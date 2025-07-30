<?php
session_start();
include("conexion.php");

if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_rol'] !== 'admin') {
    header("Location: login.php");
    exit();
}

if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$hoy = date("Y-m-d");
$hasta = date("Y-m-d", strtotime("+6 days"));

$stmt = $con->prepare("SELECT t.*, u.nombre AS cliente, s.nombre AS servicio, b.nombre AS barbero, mp.nombre AS metodo_pago_nombre
                       FROM turnos t
                       JOIN usuarios u ON t.usuario_id = u.id
                       JOIN servicios s ON t.servicio = s.id
                       LEFT JOIN barberos b ON t.barbero = b.id
                       JOIN metodos_pago mp ON t.metodo_pago = mp.id
                       WHERE t.fecha BETWEEN ? AND ? AND t.estado = 'activo'
                       ORDER BY t.fecha, t.hora ASC");
$stmt->bind_param("ss", $hoy, $hasta);
$stmt->execute();
$resultado = $stmt->get_result();

$turnos_por_dia = [];
while ($turno = $resultado->fetch_assoc()) {
    $turnos_por_dia[$turno['fecha']][] = $turno;
}
?>
<!DOCTYPE html>
<html lang="es" data-bs-theme="dark">
<head>
  <meta charset="UTF-8">
  <title>Panel de Administración</title>
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
      <span class="fs-4">Barbería Estilo - Panel Admin</span>
    </a>
    <div class="text-end">
      <a href="agregar_admin.php" class="btn btn-outline-info btn-sm me-2"><i class="fa fa-user-plus me-1"></i>Agregar Admins</a>
      
  <a href="historial_admin.php" class="btn btn-outline-secondary btn-sm me-2"><i class="fa fa-history me-1"></i>Historial</a>
      <span class="me-3 text-white"><i class="fa fa-user-shield me-1"></i> <?= htmlspecialchars($_SESSION['usuario_nombre']) ?></span>
      <a href="cerrar_sesion.php" class="btn btn-outline-danger btn-sm">Cerrar sesión</a>
    </div>
  </div>
</header>

<main class="container mt-5 pt-5">
  <h2 class="text-center text-primary my-4"><i class="fa fa-calendar-week me-2"></i>Turnos próximos (<?= date("d/m/Y") ?> → <?= date("d/m/Y", strtotime($hasta)) ?>)</h2>

  <?php if (empty($turnos_por_dia)): ?>
    <div class="alert alert-warning text-center mt-4">
      <i class="fa fa-info-circle me-2"></i>No hay turnos activos para esta semana.
    </div>
  <?php else: ?>
    <?php foreach ($turnos_por_dia as $fecha => $turnos): ?>
      <div class="mt-5">
        <h4 class="text-info border-bottom pb-2">
          <i class="fa fa-calendar-day me-2"></i><?= strftime('%A %d/%m/%Y', strtotime($fecha)) ?>
        </h4>
        <div class="table-responsive">
          <table class="table table-dark table-striped table-bordered shadow-sm">
            <thead class="table-primary text-center text-dark">
              <tr>
                <th>Hora</th>
                <th>Cliente</th>
                <th>Servicio</th>
                <th>Barbero</th>
                <th>Descripción</th>
                <th>WhatsApp</th>
                <th>Método de Pago</th>
                <th>Estado</th>
                <th>Acción</th>
              </tr>
            </thead>
            <tbody class="text-center">
              <?php foreach ($turnos as $turno): ?>
                <tr>
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
                  <td>
                    <?php if ($turno['estado'] === 'activo'): ?>
                    <form action="cancelar_admin.php" method="POST" onsubmit="return pedirMotivo(this)">
                      <input type="hidden" name="turno_id" value="<?= $turno['id'] ?>">
                      <input type="hidden" name="cancelacion_motivo">
                      <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                      <button type="submit" class="btn btn-sm btn-danger"><i class="fa fa-xmark me-1"></i>Cancelar</button>
                    </form>
                    <?php else: ?>
                      <button class="btn btn-sm btn-secondary" disabled>Cancelado</button>
                    <?php endif; ?>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    <?php endforeach; ?>
  <?php endif; ?>
</main>

<footer class="bg-dark text-center text-white py-4 mt-5 border-top">
  <div class="container">
    <p>&copy; 2025 Barbería Estilo | Panel administrativo</p>
  </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
function pedirMotivo(form) {
  const motivo = prompt("Por favor ingrese el motivo de la cancelación:");
  if (!motivo || motivo.trim() === "") {
    alert("Debe ingresar un motivo para cancelar el turno.");
    return false;
  }
  form.cancelacion_motivo.value = motivo.trim();
  return true;
}
</script>
</body>
</html>
