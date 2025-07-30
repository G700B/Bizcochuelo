<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Registro - Barbería Estilo</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="../css/style.css">
  <link rel="stylesheet" href="../css/sesion.css">
  <!-- Eliminar referencias a sesion.css y sesion.js -->
  <!-- <script src="../js/validar_r.js"></script> -->
  <script src="../js/sesion.js"></script>

</head>
<body>

  <header class="p-3 border-bottom bg-dark fixed-top">
    <div class="container">
      <div class="d-flex flex-wrap align-items-center justify-content-between">
        <a href="index.html" class="d-flex align-items-center text-white text-decoration-none">
          <i class="fa-solid fa-scissors fa-2x me-2"></i>
          <span class="fs-4">Barbería Estilo</span>
        </a>

        <ul class="nav col-12 col-lg-auto mb-2 justify-content-center mb-md-0">
          <li><a href="../index.html#inicio" class="nav-link px-3 text-white">Inicio</a></li>
          <li><a href="index.html#servicios" class="nav-link px-3 text-white">Servicios</a></li>
          <li><a href="index.html#precios" class="nav-link px-3 text-white">Precios</a></li>
          <li><a href="../index.html#nosotros" class="nav-link px-3 text-white">Nosotros</a></li>
        </ul>

        <div class="text-end">
          <a href="login.php"><button type="button" class="btn btn-outline-primary me-2">Login</button></a>
          <a href="registro.php"><button type="button" class="btn btn-primary">Registrarse</button></a>
        </div>
      </div>
    </div>
  </header>

  <?php if (isset($_GET['error'])): ?>
    <div class="alert alert-danger text-center mt-4" role="alert">
      <?php
        if ($_GET['error'] === 'existe') {
          echo 'Este correo ya está registrado.';
        } elseif ($_GET['error'] === '1') {
          echo 'Error al registrar. Intenta nuevamente.';
        } else {
          echo 'Acceso no permitido.';
        }
      ?>
    </div>
  <?php endif; ?>

  <main class="d-flex align-items-center justify-content-center mt-5 pt-5" style="min-height: 100vh;">
    <div class="container d-flex flex-column flex-md-row align-items-center justify-content-center gap-5">

 
      <div class="text-white benefits">
        <div class="d-flex align-items-center mb-4 logo">
          <i class="fa-solid fa-scissors fa-2x"></i>
          <span>Barbería Estilo</span>
        </div>
        <ul class="list-unstyled fs-5">
          <li><i class="fa-solid fa-check-circle me-2"></i>Registrate en segundos.</li>
          <li><i class="fa-solid fa-check-circle me-2"></i>Reservá turnos desde tu cuenta.</li>
          <li><i class="fa-solid fa-check-circle me-2"></i>Historial y soporte personalizado.</li>
          <li><i class="fa-solid fa-check-circle me-2"></i>10 años de experiencia.</li>
        </ul>
      </div>


      <div class="card-login shadow">
        <h4 class="text-center mb-3">Crear cuenta</h4>
        <form action="registros.php" method="POST" id="registroForm">
          <div class="mb-3">
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Juan" required>
          </div>
          <div class="mb-3">
            <label for="apellido" class="form-label">Apellido</label>
            <input type="text" class="form-control" id="apellido" name="apellido" placeholder="Pérez" required>
          </div>
          <div class="mb-3">
  <label for="fecha_nac" class="form-label">Fecha de nacimiento</label>
  <input type="date" class="form-control" id="fecha_nac" name="fecha_nac" required>
</div>
          <div class="mb-3">
            <label for="telefono" class="form-label">Teléfono</label>
            <input type="tel" class="form-control" id="telefono" name="telefono" placeholder="11 2345-6789" required>
          </div>
          <div class="mb-3">
            <label for="metodo_pago" class="form-label">Método de pago</label>
            <select class="form-select" id="metodo_pago" name="metodo_pago" required>
              <option value="">Seleccioná un método</option>
              <option value="efectivo">Efectivo</option>
              <option value="credito">Tarjeta de crédito</option>
              <option value="debito">Tarjeta de débito</option>
              <option value="mercadopago">MercadoPago</option>
            </select>
          </div>
          <div class="mb-3">
            <label for="email" class="form-label">Correo electrónico</label>
            <div class="input-group">
              <input type="email" class="form-control" id="email" name="email" placeholder="correo@mail.com" required>
              <span class="input-group-text bg-white border-0" id="emailCheck" style="display:none;">
                <i class="fa-solid fa-check text-success"></i>
              </span>
            </div>
          </div>
          <div class="mb-4">
            <label for="clave" class="form-label">Contraseña</label>
            <div class="input-group">
              <input type="password" class="form-control" id="clave" name="clave" placeholder="••••••••" required>
              <button class="btn btn-unstyled" type="button" id="togglePassword" tabindex="-1" style="background: none; border: none; padding: 0 12px;">
                <i class="fa-solid fa-eye" id="eyeIcon"></i>
              </button>
              <span class="input-group-text bg-white border-0" id="claveCheck" style="display:none;">
                <i class="fa-solid fa-check text-success"></i>
              </span>
            </div>
            <div class="invalid-feedback" id="claveError" style="display:none;">
              La contraseña debe tener al menos 8 caracteres.
            </div>
          </div>
          <button type="submit" class="btn btn-success w-100">Registrarme</button>
        </form>
        <p class="mt-3 text-center">¿Ya tenés cuenta? <a href="login.php">Iniciá sesión</a></p>
      </div>

    </div>
  </main>

  <footer class="bg-dark text-center text-white py-4 border-top">
    <div class="container">
      <p>&copy; 2025 Barbería Estilo. Todos los derechos reservados.</p>
      <p>
        <i class="fa-brands fa-instagram me-2"></i>
        <i class="fa-brands fa-facebook me-2"></i>
        <i class="fa-brands fa-whatsapp"></i>
      </p>
    </div>
  </footer>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    // Mostrar/ocultar contraseña
    document.getElementById('togglePassword').addEventListener('click', function (e) {
      e.preventDefault();
      const input = document.getElementById('clave');
      const icon = document.getElementById('eyeIcon');
      if (input.type === 'password') {
        input.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
      } else {
        input.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
      }
    });

    // Validación profesional de la contraseña y el email
    const claveInput = document.getElementById('clave');
    const claveError = document.getElementById('claveError');
    const claveCheck = document.getElementById('claveCheck');
    const emailInput = document.getElementById('email');
    const emailCheck = document.getElementById('emailCheck');

    claveInput.addEventListener('input', function() {
      if (claveInput.value.length > 0 && claveInput.value.length < 8) {
        claveInput.classList.add('is-invalid');
        claveError.style.display = 'block';
        claveCheck.style.display = 'none';
      } else if (claveInput.value.length >= 8) {
        claveInput.classList.remove('is-invalid');
        claveError.style.display = 'none';
        claveCheck.style.display = 'inline-flex';
      } else {
        claveInput.classList.remove('is-invalid');
        claveError.style.display = 'none';
        claveCheck.style.display = 'none';
      }
    });

    emailInput.addEventListener('input', function() {
      const value = emailInput.value.trim();
      const gmailRegex = /^[a-zA-Z0-9._%+-]+@gmail\.com$/;
      if (gmailRegex.test(value)) {
        emailCheck.style.display = 'inline-flex';
      } else {
        emailCheck.style.display = 'none';
      }
    });

    // Overlay de carga al registrar
    const form = document.querySelector('form[action="registros.php"]');
    form.addEventListener('submit', function(e) {
      if (claveInput.value.length < 8) {
        claveInput.classList.add('is-invalid');
        claveError.style.display = 'block';
        e.preventDefault();
      } else {
        claveInput.classList.remove('is-invalid');
        claveError.style.display = 'none';
        e.preventDefault();
        mostrarOverlaySesion('Registrando', function() {
          form.submit();
        });
      }
    });
  </script>
</body>
</html>
