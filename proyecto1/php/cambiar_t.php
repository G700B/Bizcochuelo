<?php
session_start();
include 'conexion.php';

// Validar que el usuario esté logueado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: php/login.php");
    exit;
}

// Obtener el ID del turno a editar (por GET o POST, según tu lógica)
if (!isset($_GET['id'])) {
    // Si no viene el id, redirigir o mostrar error
    die("ID de turno no especificado.");
}
$turno_id = (int) $_GET['id'];
$usuario_id = $_SESSION['usuario_id'];

// Consultar datos del turno para ese usuario y turno
$sql = "SELECT * FROM turnos WHERE id = ? AND usuario_id = ?";
$stmt = $con->prepare($sql);
$stmt->bind_param("ii", $turno_id, $usuario_id);
$stmt->execute();
$result = $stmt->get_result();
$turno = $result->fetch_assoc();

if (!$turno) {
    die("Turno no encontrado o no autorizado.");
}

// Consultar servicios
$servicios = $con->query("SELECT id, nombre, precio FROM servicios");
// Consultar barberos activos
$barberos = $con->query("SELECT id, nombre FROM barberos WHERE estado = 1");
// Consultar métodos de pago
$metodos_pago = $con->query("SELECT id, nombre FROM metodos_pago");
?>

<!DOCTYPE html>
<html lang="es" data-bs-theme="dark">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Editar Turno - Barbería Estilo</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" />
  <link rel="stylesheet" href="../css/style.css" />
</head>
<body>
  <!-- Header y menú -->
  <header class="p-3 border-bottom bg-dark fixed-top">
    <div class="container d-flex justify-content-between align-items-center">
      <img src="../img/T.O.png" alt="Logo" style="height: 60px;" />
      <a href="#" class="text-white text-decoration-none d-flex align-items-center">
        <i class="fa-solid fa-scissors fa-2x me-2"></i>
        <span class="fs-4">Barbería Estilo</span>
      </a>
      <ul class="nav mb-0">
        <li><a href="#inicio" class="nav-link px-3 text-white">Inicio</a></li>
        <li><a href="tienda.php" class="nav-link px-3 text-white">Tienda</a></li>
        <li><a href="ver_turno.php" class="nav-link px-3 text-white">Ver turno</a></li>
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
        <?php else: ?>
          <a href="php/login.php"><button class="btn btn-outline-primary me-2">Login</button></a>
          <a href="php/registro.php"><button class="btn btn-primary">Registrarse</button></a>
        <?php endif; ?>
      </div>
    </div>
  </header>

  <main class="container py-5 mt-5">
    <h2 class="mb-4 text-white">Editar Turno</h2>

    <form action="actualizar.php" method="POST" class="card p-4 mx-auto bg-white rounded shadow" style="max-width: 420px;">
      <input type="hidden" name="turno_id" value="<?= $turno['id'] ?>" />

      <div class="mb-3">
        <label for="fecha_turno" class="form-label">Fecha del turno</label>
        <input
          type="text"
          class="form-control"
          id="fecha_turno"
          name="fecha_turno"
          required
          value="<?= htmlspecialchars($turno['fecha']) ?>"
        />
      </div>

      <div class="mb-3">
        <label for="hora_turno" class="form-label">Hora</label>
        <input
          type="time"
          class="form-control"
          id="hora_turno"
          name="hora_turno"
          required
          value="<?= htmlspecialchars($turno['hora']) ?>"
        />
      </div>

      <div class="mb-3">
        <label for="servicio" class="form-label">Servicio</label>
        <select class="form-select" id="servicio" name="servicio" required>
          <option value="">Seleccione un servicio</option>
          <?php while ($serv = $servicios->fetch_assoc()): ?>
            <option value="<?= $serv['id'] ?>" <?= $serv['id'] == $turno['servicio'] ? 'selected' : '' ?>>
              <?= htmlspecialchars($serv['nombre']) ?> - $<?= number_format($serv['precio'], 2) ?>
            </option>
          <?php endwhile; ?>
        </select>
      </div>

      <div class="mb-3">
        <label for="descripcion" class="form-label">¿Cómo querés tu corte?</label>
        <textarea
          class="form-control"
          id="descripcion"
          name="descripcion"
          rows="3"
          required
        ><?= htmlspecialchars($turno['descripcion']) ?></textarea>
      </div>

      <div class="mb-3">
        <label for="barbero" class="form-label">Barbero preferido</label>
        <select class="form-select" id="barbero" name="barbero">
          <option value="">Cualquiera</option>
          <?php while ($barb = $barberos->fetch_assoc()): ?>
            <option value="<?= $barb['id'] ?>" <?= $barb['id'] == $turno['barbero'] ? 'selected' : '' ?>>
              <?= htmlspecialchars($barb['nombre']) ?>
            </option>
          <?php endwhile; ?>
        </select>
      </div>

      <div class="mb-3">
        <label for="metodo_pago" class="form-label">Método de pago</label>
        <select class="form-select" id="metodo_pago" name="metodo_pago" required>
          <option value="">Seleccione un método</option>
          <?php while ($metodo = $metodos_pago->fetch_assoc()): ?>
            <option value="<?= $metodo['id'] ?>" <?= $metodo['id'] == $turno['metodo_pago'] ? 'selected' : '' ?>>
              <?= htmlspecialchars($metodo['nombre']) ?>
            </option>
          <?php endwhile; ?>
        </select>
      </div>

      <div class="form-check mb-4">
        <input
          type="checkbox"
          class="form-check-input"
          id="whatsapp_confirm"
          name="whatsapp_confirm"
          value="1"
          <?= $turno['whatsapp'] ? 'checked' : '' ?>
        />
        <label class="form-check-label" for="whatsapp_confirm">
          Deseo recibir confirmación por WhatsApp
        </label>
      </div>

      <button type="submit" class="btn btn-primary w-100">Guardar Cambios</button>
    </form>
  </main>

  <footer class="bg-dark text-center text-white py-4 border-top mt-5">
    <div class="container">
      <p>&copy; 2025 Barbería Estilo. Todos los derechos reservados.</p>
    </div>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="../js/horario.js"></script>

  <script>
    document.addEventListener("DOMContentLoaded", function () {
      flatpickr("#fecha_turno", {
        dateFormat: "Y-m-d",
        minDate: "today",
        disable: [
          function (date) {
            return date.getDay() === 0; // Deshabilitar domingos
          }
        ],
        locale: {
          firstDayOfWeek: 1,
        },
      });
    });
  </script>
</body>
</html>
