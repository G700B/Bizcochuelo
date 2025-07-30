<?php
session_start();
include 'conexion.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

$usuario_id = $_SESSION['usuario_id'];

// Obtener historial de compras con productos
$sql = "SELECT v.id AS venta_id, v.total, v.fecha,
               dv.cantidad, dv.precio_unitario,
               p.nombre AS producto_nombre
        FROM ventas v
        JOIN detalle_venta dv ON dv.venta_id = v.id
        JOIN productos p ON p.id = dv.producto_id
        WHERE v.usuario_id = ?
        ORDER BY v.fecha DESC";

$stmt = $con->prepare($sql);
$stmt->bind_param("i", $usuario_id);
$stmt->execute();
$resultado = $stmt->get_result();

// Agrupar por venta
$ventas = [];
while ($row = $resultado->fetch_assoc()) {
    $venta_id = $row['venta_id'];
    if (!isset($ventas[$venta_id])) {
        $ventas[$venta_id] = [
            'fecha' => $row['fecha'],
            'total' => $row['total'],
            'productos' => []
        ];
    }
    $ventas[$venta_id]['productos'][] = [
        'nombre' => $row['producto_nombre'],
        'cantidad' => $row['cantidad'],
        'precio_unitario' => $row['precio_unitario']
    ];
}
?>
<!DOCTYPE html>
<html lang="es" data-bs-theme="dark">
<head>
  <meta charset="UTF-8">
  <title>Historial de Compras</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="../css/style.css">
</head>
<body>

<header class="p-3 border-bottom bg-dark fixed-top">
  <div class="container d-flex justify-content-between align-items-center">
    <img src="../img/T.O.png" alt="Logo" style="height: 60px;">
    <a href="index2.php" class="text-white text-decoration-none d-flex align-items-center">
      <i class="fa-solid fa-scissors fa-2x me-2"></i>
      <span class="fs-4">Barbería Estilo</span>
    </a>
    <ul class="nav mb-0">
      <li><a href="index2.php" class="nav-link px-3 text-white">Inicio</a></li>
      <li><a href="tienda.php" class="nav-link px-3 text-white">Tienda</a></li>
      <li><a href="ver_turno.php" class="nav-link px-3 text-white">Ver mi Turno</a></li>
      <li><a href="historial.php" class="nav-link px-3 text-white">Historial de Turnos</a></li>
      <li><a href="historial_compras.php" class="nav-link px-3 text-success fw-bold">Compras</a></li>
    </ul>
    <div class="text-end">
      <?php if (isset($_SESSION['usuario_nombre'])): ?>
        <div class="dropdown">
          <button class="btn btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown">
            <i class="fa-solid fa-user"></i> <?= htmlspecialchars($_SESSION['usuario_nombre']) ?>
          </button>
          <ul class="dropdown-menu dropdown-menu-end">
            <li><a class="dropdown-item" href="cerrar_sesion.php">Cerrar sesión</a></li>
          </ul>
        </div>
      <?php endif; ?>
    </div>
  </div>
</header>

<main class="container pt-5 mt-5">
  <h2 class="text-white text-center mb-4">Historial de Compras</h2>

  <?php if (count($ventas) > 0): ?>
    <?php foreach ($ventas as $id => $venta): ?>
      <div class="bg-light text-dark p-4 rounded shadow mb-4">
        <h5 class="mb-3">Compra #<?= $id ?> | Fecha: <?= date("d/m/Y H:i", strtotime($venta['fecha'])) ?></h5>
        <table class="table table-bordered table-sm">
          <thead class="table-secondary">
            <tr>
              <th>Producto</th>
              <th>Cantidad</th>
              <th>Precio Unitario</th>
              <th>Subtotal</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($venta['productos'] as $prod): ?>
              <tr>
                <td><?= htmlspecialchars($prod['nombre']) ?></td>
                <td><?= $prod['cantidad'] ?></td>
                <td>$<?= number_format($prod['precio_unitario'], 0, ',', '.') ?></td>
                <td>$<?= number_format($prod['precio_unitario'] * $prod['cantidad'], 0, ',', '.') ?></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
        <div class="text-end fw-bold fs-5">
          Total: <span class="text-success">$<?= number_format($venta['total'], 0, ',', '.') ?></span>
        </div>
      </div>
    <?php endforeach; ?>
  <?php else: ?>
    <div class="alert alert-info text-center">Aún no realizaste ninguna compra.</div>
  <?php endif; ?>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
