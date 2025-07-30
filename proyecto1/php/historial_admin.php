<?php
session_start();
include("conexion.php");

if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_rol'] !== 'admin') {
    header("Location: login.php");
    exit();
}


if (isset($_GET['limpiar']) && $_GET['limpiar'] == '1') {
    $con->query("DELETE FROM turnos");
    header("Location: historial_admin.php?borrado=1");
    exit();
}


$sql = "SELECT t.*, u.nombre AS cliente, s.nombre AS servicio, b.nombre AS barbero, 
               mp.nombre AS metodo_pago_nombre
        FROM turnos t
        JOIN usuarios u ON t.usuario_id = u.id
        JOIN servicios s ON t.servicio = s.id
        LEFT JOIN barberos b ON t.barbero = b.id
        JOIN metodos_pago mp ON t.metodo_pago = mp.id
        ORDER BY t.fecha DESC, t.hora DESC";

$stmt = $con->prepare($sql);
$stmt->execute();
$resultado = $stmt->get_result();
$turnos = $resultado->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="es" data-bs-theme="dark">
<head>
  <meta charset="UTF-8">
  <title>Historial de Turnos - Admin</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/style.css">
</head>
<body>

<header class="p-3 border-bottom bg-dark fixed-top">
  <div class="container d-flex justify-content-between align-items-center">
    <img src="../img/T.O.png" alt="Logo" style="height: 60px;">
    <a href="#" class="text-white text-decoration-none d-flex align-items-center">
      <i class="fa-solid fa-scissors fa-2x me-2"></i>
      <span class="fs-4">Barbería Estilo - Historial</span>
    </a>
    <div class="text-end">
      <a href="panel_admin.php" class="btn btn-outline-secondary btn-sm me-2"><i class="fa fa-arrow-left me-1"></i>Volver</a>
      <span class="me-3 text-white"><i class="fa fa-user-shield me-1"></i> <?= htmlspecialchars($_SESSION['usuario_nombre']) ?></span>
      <a href="cerrar_sesion.php" class="btn btn-outline-danger btn-sm">Cerrar sesión</a>
    </div>
  </div>
</header>

<main class="container mt-5 pt-5">
  <h2 class="text-center text-primary my-4"><i class="fa fa-history me-2"></i>Historial de Turnos</h2>

  <?php if (isset($_GET['borrado']) && $_GET['borrado'] == '1'): ?>
    <div class="alert alert-success text-center">Historial eliminado correctamente.</div>
  <?php endif; ?>

  <?php if (empty($turnos)): ?>
    <div class="alert alert-warning text-center mt-4">
      <i class="fa fa-info-circle me-2"></i>No hay turnos registrados.
    </div>
  <?php else: ?>
    <div class="table-responsive">
      <table class="table table-dark table-striped table-bordered shadow-sm">
        <thead class="table-primary text-center text-dark">
          <tr>
            <th>Fecha</th>
            <th>Hora</th>
            <th>Cliente</th>
            <th>Servicio</th>
            <th>Barbero</th>
            <th>Descripción</th>
            <th>WhatsApp</th>
            <th>Método de Pago</th>
            <th>Estado</th>
            <th>Motivo Cancelación</th>
          </tr>
        </thead>
        <tbody class="text-center">
          <?php foreach ($turnos as $turno): ?>
            <tr>
              <td><?= htmlspecialchars($turno['fecha']) ?></td>
              <td><?= htmlspecialchars($turno['hora']) ?></td>
              <td><?= htmlspecialchars($turno['cliente']) ?></td>
              <td><?= htmlspecialchars($turno['servicio']) ?></td>
              <td><?= htmlspecialchars($turno['barbero'] ?? 'Cualquiera') ?></td>
              <td><?= htmlspecialchars($turno['descripcion']) ?></td>
              <td><?= $turno['whatsapp'] ? '✅' : '❌' ?></td>
              <td><?= htmlspecialchars($turno['metodo_pago_nombre']) ?></td>
              <td>
                <?php 
                  $estado = $turno['estado'];
                  if ($estado === 'activo') {
                    echo '<span class="badge bg-success">Activo</span>';
                  } elseif ($estado === 'cancelado') {
                    echo '<span class="badge bg-danger">Cancelado</span>';
                  } else {
                    echo '<span class="badge bg-secondary">'.htmlspecialchars($estado).'</span>';
                  }
                ?>
              </td>
              <td><?= htmlspecialchars($turno['cancelacion_motivo'] ?? '-') ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>

    <div class="d-flex justify-content-end mt-3">
      <a href="historial_admin.php?limpiar=1" class="btn btn-outline-danger"
         onclick="return confirm('¿Seguro que deseas borrar todo el historial?');">
        <i class="fa fa-trash me-2"></i>Limpiar Historial
      </a>
    </div>
  <?php endif; ?>
</main>

<footer class="bg-dark text-center text-white py-4 mt-5 border-top">
  <div class="container">
    <p>&copy; 2025 Barbería Estilo | Historial de turnos</p>
  </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
