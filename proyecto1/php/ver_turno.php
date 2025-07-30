<?php
session_start();
include 'conexion.php';
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

$usuario_id = $_SESSION['usuario_id'];

$sql = "SELECT t.*, s.nombre AS servicio_nombre, s.precio AS servicio_precio, b.nombre AS barbero_nombre 
        FROM turnos t 
        INNER JOIN servicios s ON s.id = t.servicio 
        LEFT JOIN barberos b ON b.id = t.barbero
        WHERE t.usuario_id = ? AND t.estado = 'activo' 
        ORDER BY t.creado_en DESC 
        LIMIT 1";

$stmt = $con->prepare($sql);
$stmt->bind_param("i", $usuario_id);
$stmt->execute();
$resultado = $stmt->get_result();
$turno = $resultado->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="es" data-bs-theme="dark">
<head>
  <meta charset="UTF-8">
  <title>Ver mi turno - Barbería Estilo</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<header class="p-3 border-bottom bg-dark fixed-top">
  <div class="container d-flex justify-content-between align-items-center">
     <img src="../img/T.O.png" alt="Logo" style="height: 60px;">
    <a href="index.php" class="text-white text-decoration-none d-flex align-items-center">
      <i class="fa-solid fa-scissors fa-2x me-2"></i>
      <span class="fs-4">Barbería Estilo</span>
    </a>
    <ul class="nav mb-0">
      <li><a href="index2.php" class="nav-link px-3 text-white">Inicio</a></li>
      <li><a href="tienda.php" class="nav-link px-3 text-white">Tienda</a></li>
      <li><a href="ver_turno.php" class="nav-link px-3 text-success fw-bold">Ver mi Turno</a></li>
      <li><a href="historial.php" class="nav-link px-3 text-white">Historial</a></li>
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
  <h2 class="text-white text-center mb-4">Mi Turno Reservado</h2>

  <?php if ($turno): ?>
    <div class="card bg-light text-dark mb-5 shadow mx-auto" style="max-width: 500px;">
      <div class="card-body">
        <p><strong>Fecha:</strong> <?= htmlspecialchars($turno['fecha']) ?></p>
        <p><strong>Hora:</strong> <?= htmlspecialchars($turno['hora']) ?></p>
        <p><strong>Servicio:</strong> <?= htmlspecialchars($turno['servicio_nombre']) ?></p>
        <p><strong>Precio:</strong> $<?= number_format($turno['servicio_precio'], 2) ?></p>
        <p><strong>Descripción:</strong> <?= htmlspecialchars($turno['descripcion']) ?></p>
        <p><strong>Barbero:</strong> <?= htmlspecialchars($turno['barbero_nombre'] ?? 'Cualquiera') ?></p>
        <p><strong>Confirmación WhatsApp:</strong> <?= $turno['whatsapp'] ? 'Sí' : 'No' ?></p>

        <div class="d-flex justify-content-between mt-4">
          <a href="cambiar_t.php?id=<?= $turno['id'] ?>" class="btn btn-warning">
            <i class="fa-solid fa-pen"></i> Cambiar
          </a>

          <form id="formCancelar" action="cancelar.php" method="POST" style="display:inline;">
            <input type="hidden" name="motivo" id="motivoInput" />
            <input type="hidden" name="id" value="<?= $turno['id'] ?>" />
            <button type="button" class="btn btn-danger" onclick="cancelarTurno()">
              <i class="fa-solid fa-xmark"></i> Cancelar
            </button>
          </form>
        </div>
      </div>
    </div>
  <?php else: ?>
    <div class="alert alert-info text-center">No tenés ningún turno reservado.</div>
    <div class="text-center">
      <a href="index2.php" class="btn btn-success">Reservar ahora</a>
    </div>
  <?php endif; ?>

  <?php if (isset($_GET['msg']) && $_GET['msg'] === 'cancelado'): ?>
    <script>
      alert('Turno cancelado correctamente.');
    </script>
  <?php endif; ?>

</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
  function cancelarTurno() {
    const motivo = prompt("Por favor, ingrese el motivo de la cancelación:");
    if (motivo && motivo.trim() !== "") {
      document.getElementById('motivoInput').value = motivo.trim();
      if(confirm("¿Estás seguro que deseas cancelar el turno?")) {
        document.getElementById('formCancelar').submit();
      }
    } else if (motivo !== null) {
      alert("Debes ingresar un motivo para cancelar.");
    }
  }
</script>

</body>
</html>
