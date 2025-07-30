<?php
session_start();
include("conexion.php");

if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_rol'] !== 'admin') {
    header("Location: login.php");
    exit();
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre']);
    $email = trim($_POST['email']);
    $clave = $_POST['clave'];
    $clave_confirm = $_POST['clave_confirm'];

    if (!$nombre || !$email || !$clave || !$clave_confirm) {
        $error = "Todos los campos son obligatorios.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "El correo no es válido.";
    } elseif ($clave !== $clave_confirm) {
        $error = "Las contraseñas no coinciden.";
    } else {
        // Verificar si el email ya existe
        $stmt_check = $con->prepare("SELECT id FROM usuarios WHERE email = ?");
        $stmt_check->bind_param("s", $email);
        $stmt_check->execute();
        $stmt_check->store_result();

        if ($stmt_check->num_rows > 0) {
            $error = "El correo ya está registrado.";
        } else {
            $hash = password_hash($clave, PASSWORD_DEFAULT);
            $rol = 'admin';

            $stmt_insert = $con->prepare("INSERT INTO usuarios (nombre, email, pass, rol) VALUES (?, ?, ?, ?)");
            $stmt_insert->bind_param("ssss", $nombre, $email, $hash, $rol);
            if ($stmt_insert->execute()) {
                $success = "Administrador creado con éxito.";
            } else {
                $error = "Error al crear el administrador.";
            }
            $stmt_insert->close();
        }
        $stmt_check->close();
    }
}
?>
<!DOCTYPE html>
<html lang="es" data-bs-theme="dark">
<head>
  <meta charset="UTF-8" />
  <title>Agregar Admin - Panel Admin</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="css/style.css" />
</head>
<body>
<header class="p-3 border-bottom bg-dark fixed-top">
  <div class="container d-flex justify-content-between align-items-center">
    <a href="panel_admin.php" class="text-white text-decoration-none d-flex align-items-center">
      <i class="fa-solid fa-scissors fa-2x me-2"></i>
      <span class="fs-4">Barbería Estilo - Panel Admin</span>
    </a>
    <div class="text-end">
      <span class="me-3 text-white"><i class="fa fa-user-shield me-1"></i> <?= $_SESSION['usuario_nombre'] ?></span>
      <a href="panel_admin.php" class="btn btn-outline-primary btn-sm me-2"><i class="fa fa-arrow-left me-1"></i>Volver</a>
      <a href="cerrar_sesion.php" class="btn btn-outline-danger btn-sm">Cerrar sesión</a>
    </div>
  </div>
</header>

<main class="container mt-5 pt-5">
  <h2 class="text-center text-info mb-4"><i class="fa fa-user-plus me-2"></i>Agregar Nuevo Administrador</h2>

  <?php if ($error): ?>
    <div class="alert alert-danger text-center"><?= htmlspecialchars($error) ?></div>
  <?php elseif ($success): ?>
    <div class="alert alert-success text-center"><?= htmlspecialchars($success) ?></div>
  <?php endif; ?>

  <form action="agregar_admin.php" method="POST" class="mx-auto" style="max-width: 400px;">
    <div class="mb-3">
      <label for="nombre" class="form-label">Nombre</label>
      <input type="text" name="nombre" id="nombre" class="form-control" required value="<?= isset($_POST['nombre']) ? htmlspecialchars($_POST['nombre']) : '' ?>" />
    </div>
    <div class="mb-3">
      <label for="email" class="form-label">Correo electrónico</label>
      <input type="email" name="email" id="email" class="form-control" required value="<?= isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '' ?>" />
    </div>
    <div class="mb-3">
      <label for="clave" class="form-label">Contraseña</label>
      <input type="password" name="clave" id="clave" class="form-control" required />
    </div>
    <div class="mb-3">
      <label for="clave_confirm" class="form-label">Confirmar Contraseña</label>
      <input type="password" name="clave_confirm" id="clave_confirm" class="form-control" required />
    </div>
    <button type="submit" class="btn btn-info w-100"><i class="fa fa-save me-2"></i>Crear Administrador</button>
  </form>
</main>

<footer class="bg-dark text-center text-white py-4 mt-5 border-top">
  <div class="container">
    <p>&copy; 2025 Barbería Estilo | Panel administrativo</p>
  </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
