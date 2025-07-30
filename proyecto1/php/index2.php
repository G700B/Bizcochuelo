<?php
session_start();
include 'conexion.php';
?>
<!DOCTYPE html>
<html lang="es" data-bs-theme="dark">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Barbería Estilo</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  <!-- Flatpickr CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" />
  <link rel="stylesheet" href="../css/style.css" />
</head>
<body>
  <header class="p-3 border-bottom bg-dark fixed-top">
    <div class="container d-flex justify-content-between align-items-center">
      <img src="../img/T.O.png" alt="Logo" style="height: 60px;" />
      <a href="#" class="text-white text-decoration-none d-flex align-items-center">
        <i class="fa-solid fa-scissors fa-2x me-2"></i>
        <span class="fs-4">Barbería Estilo</span>
      </a>
      <ul class="nav mb-0">
        <li><a href="#inicio" class="nav-link px-3 text-success fw-bold">Inicio</a></li>
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

  <section id="inicio" class="py-5 text-center bg-dark text-white mt-5 pt-5">
    <div class="container">
      <h1 class="display-4 fw-bold">Bienvenido a Barbería Estilo</h1>
      <p class="lead">
        Donde el estilo y la tradición se encuentran... Cortes clásicos, modernos y más para verte increíble.
      </p>
    </div>
  </section>

<?php
$turno_activo = false;
if (isset($_SESSION['usuario_id'])) {
  $usuario_id = $_SESSION['usuario_id'];
  $consulta_turno = "SELECT * FROM turnos WHERE usuario_id = ? AND estado = 'activo'";
  $stmt = $con->prepare($consulta_turno);
  $stmt->bind_param("i", $usuario_id);
  $stmt->execute();
  $resultado_turno = $stmt->get_result();
  $turno_activo = $resultado_turno->fetch_assoc();
}
?>

<?php if (isset($_SESSION['usuario_nombre'])): ?>
  <section class="d-flex align-items-center justify-content-center py-5 bg-dark text-white">
    <div class="container d-flex flex-column flex-md-row align-items-center justify-content-center gap-5">

      <div class="text-white">
        <h2 class="mb-3">Reservá tu turno</h2>
        <ul class="list-unstyled fs-5">
          <li><i class="fa-solid fa-check-circle me-2 text-success"></i>Elegí día, horario y barbero.</li>
          <li><i class="fa-solid fa-check-circle me-2 text-success"></i>Contanos cómo querés tu corte.</li>
          <li><i class="fa-solid fa-check-circle me-2 text-success"></i>Confirmación por WhatsApp.</li>
          <hr class="text-secondary" />
          <li><i class="fa-solid fa-calendar-xmark me-2 text-danger"></i><strong>No trabajamos los domingos</strong></li>
          <li><i class="fa-solid fa-clock me-2 text-warning"></i><strong>Horario:</strong> de 10:00 a 18:00 hs</li>
        </ul>
      </div>

      <?php if (!$turno_activo): ?>
        <div class="card-login shadow bg-white p-4 rounded" style="min-width: 320px; max-width: 420px;">
          <h4 class="text-center mb-3 text-dark">Reservar Turno</h4>
          <form action="reservar_turno.php" method="POST">
            <div class="mb-3">
              <label for="fecha_turno" class="form-label text-dark">Fecha del turno</label>
              <input type="text" class="form-control" id="fecha_turno" name="fecha_turno" required />
            </div>
            <div class="mb-3">
              <label for="hora_turno" class="form-label text-dark">Hora</label>
              <input type="time" class="form-control" id="hora_turno" name="hora_turno" required />
            </div>
            <div class="mb-3">
              <label for="servicio" class="form-label text-dark">Servicio</label>
              <select class="form-select" id="servicio" name="servicio" required>
                <option value="">Seleccione un servicio</option>
                <?php
                $query_servicios = "SELECT id, nombre, precio FROM servicios";
                $resultado_servicios = $con->query($query_servicios);
                while ($servicio = $resultado_servicios->fetch_assoc()):
                ?>
                  <option value="<?= $servicio['id'] ?>">
                    <?= htmlspecialchars($servicio['nombre']) ?> - $<?= number_format($servicio['precio'], 2) ?>
                  </option>
                <?php endwhile; ?>
              </select>
            </div>
            <div class="mb-3">
              <label for="descripcion" class="form-label text-dark">¿Cómo querés tu corte?</label>
              <textarea
                class="form-control"
                id="descripcion"
                name="descripcion"
                rows="3"
                placeholder="Ej: Fade alto con barba definida..."
                required
              ></textarea>
            </div>
            <div class="mb-3">
              <label for="barbero" class="form-label text-dark">Barbero preferido</label>
              <select class="form-select" id="barbero" name="barbero">
                <option value="">Cualquiera</option>
                <?php
                $query_barberos = "SELECT id, nombre FROM barberos WHERE estado = 1";
                $resultado_barberos = $con->query($query_barberos);
                while ($barbero = $resultado_barberos->fetch_assoc()):
                ?>
                  <option value="<?= $barbero['id'] ?>"><?= htmlspecialchars($barbero['nombre']) ?></option>
                <?php endwhile; ?>
              </select>
            </div>
            <div class="mb-3">
              <label for="metodo_pago" class="form-label text-dark">Método de pago</label>
              <select class="form-select" id="metodo_pago" name="metodo_pago" required>
                <option value="">Seleccione un método</option>
                <?php
                $query_metodos = "SELECT id, nombre FROM metodos_pago";
                $resultado_metodos = $con->query($query_metodos);
                while ($metodo = $resultado_metodos->fetch_assoc()):
                ?>
                  <option value="<?= $metodo['id'] ?>"><?= htmlspecialchars($metodo['nombre']) ?></option>
                <?php endwhile; ?>
              </select>
            </div>

            <div class="form-check mb-4">
              <input
                class="form-check-input"
                type="checkbox"
                id="whatsapp_confirm"
                name="whatsapp_confirm"
                value="1"
              />
              <label class="form-check-label text-dark" for="whatsapp_confirm">
                Deseo recibir confirmación por WhatsApp
              </label>
            </div>
            <button type="submit" class="btn btn-primary w-100">Confirmar Turno</button>
          </form>
        </div>
      <?php else: ?>
        <div
          class="bg-dark border border-primary rounded p-4 text-center shadow"
          style="min-width: 320px; max-width: 420px"
        >
          <h5 class="text-primary mb-3">
            <i class="fa-solid fa-calendar-check me-2"></i>Turno ya registrado
          </h5>
          <p class="text-light">Ya tenés un turno activo en el sistema.</p>
          <p>
            <a href="ver_turno.php" class="btn btn-outline-primary mt-2">Ver / Editar turno</a>
          </p>
        </div>
      <?php endif; ?>
    </div>
  </section>
<?php else: ?>
  <div class="text-center mt-5">
    <a href="php/login.php" class="btn btn-primary btn-lg">Ingresar para reservar turno</a>
  </div>
<?php endif; ?>

<section id="servicios" class="py-5 bg-secondary text-white"></section>

<footer class="bg-dark text-center text-white py-4 border-top">
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
        },
      ],
      locale: {
        firstDayOfWeek: 1,
      },
    });
  });
</script>
</body>
</html>
