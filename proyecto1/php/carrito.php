<?php
session_start();
include 'conexion.php';

// Usar el carrito real de la sesión
$carrito = isset($_SESSION['carrito']) ? $_SESSION['carrito'] : [];

$total = 0;
foreach ($carrito as $item) {
  $total += $item['precio'] * $item['cantidad'];
}
?>
<!DOCTYPE html>
<html lang="es" data-bs-theme="dark">
<head>
  <meta charset="UTF-8">
  <title>Carrito - Barbería Estilo</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
        <li><a href="ver_turno.php" class="nav-link px-3 text-white">Ver turno</a></li>
        <li><a href="historial.php" class="nav-link px-3 text-white">Historial</a></li>
        <li><a href="carrito.php" class="nav-link px-3 text-success fw-bold"><i class="fa-solid fa-cart-shopping"></i> Carrito</a></li>
      </ul>
      <div class="text-end d-flex align-items-center gap-3">
        <?php if (isset($_SESSION['usuario_nombre'])): ?>
          <div class="dropdown">
            <button class="btn btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown">
              <i class="fa-solid fa-user"></i> <?= htmlspecialchars($_SESSION['usuario_nombre']) ?>
            </button>
            <ul class="dropdown-menu dropdown-menu-end">
              <li><a class="dropdown-item" href="cerrar_sesion.php">Cerrar sesión</a></li>
            </ul>
          </div>
        <?php else: ?>
          <a href="login.php"><button class="btn btn-outline-primary me-2">Login</button></a>
          <a href="registro.php"><button class="btn btn-primary">Registrarse</button></a>
        <?php endif; ?>
      </div>
    </div>
  </header>

  <main class="container pt-5 mt-5">
    <h2 class="text-center text-white mb-4">Mi Carrito</h2>
    <?php if (count($carrito) > 0): ?>
    <div class="table-responsive bg-light text-dark p-4 rounded shadow mb-4">
      <table class="table table-striped table-bordered align-middle">
        <thead class="table-dark">
          <tr>
            <th>Producto</th>
            <th>Cantidad</th>
            <th>Precio</th>
            <th>Subtotal</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($carrito as $item): ?>
          <tr>
            <td><?= htmlspecialchars($item['nombre']) ?></td>
            <td><?= $item['cantidad'] ?></td>
            <td>$<?= number_format($item['precio'], 0, ',', '.') ?></td>
            <td>$<?= number_format($item['precio'] * $item['cantidad'], 0, ',', '.') ?></td>
            <td>
              <a href="eliminar_del_carrito.php?id=<?= $item['id'] ?>" class="btn btn-sm btn-danger">
                <i class="fa-solid fa-trash"></i>
              </a>
            </td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
      <div class="d-flex justify-content-end align-items-center mt-3">
        <h4 class="me-4 mb-0">Total: <span class="text-success">$<?= number_format($total, 0, ',', '.') ?></span></h4>
        <a href="vaciar_carrito.php" class="btn btn-outline-danger me-2">Vaciar carrito</a>
        <a href="finalizar_compra.php" class="btn btn-success">Finalizar compra</a>
      </div>
    </div>
    <?php else: ?>
      <div class="alert alert-info text-center">Tu carrito está vacío.</div>
    <?php endif; ?>
  </main>

  <footer class="bg-dark text-center text-white py-4 border-top mt-5">
    <div class="container">
      <p>&copy; 2025 Barbería Estilo. Todos los derechos reservados.</p>
    </div>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
