<?php
session_start();
include 'conexion.php';
$productos = [];
$result = $con->query("SELECT * FROM productos");
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $productos[] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="es" data-bs-theme="dark">
<head>
  <meta charset="UTF-8">
  <title>Tienda - Barbería Estilo</title>
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
        <li><a href="tienda.php" class="nav-link px-3 text-success fw-bold">Tienda</a></li>
        <li><a href="ver_turno.php" class="nav-link px-3 text-white">Ver turno</a></li>
        <li><a href="historial.php" class="nav-link px-3 text-white">Historial</a></li>
      </ul>
      <div class="text-end d-flex align-items-center gap-3">
        <a href="carrito.php" class="btn btn-outline-light position-relative me-2">
          <i class="fa-solid fa-cart-shopping"></i>
        </a>
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
    <h2 class="text-center text-white mb-4">Productos de Barbería</h2>
    <div class="row g-4 justify-content-center">
      <?php foreach ($productos as $producto): ?>
        <div class="col-md-4">
          <div class="card h-100 shadow">
            <img src="../img/<?= htmlspecialchars($producto['imagen']) ?>" class="card-img-top" alt="<?= htmlspecialchars($producto['nombre']) ?>">
            <div class="card-body">
              <h5 class="card-title"><?= htmlspecialchars($producto['nombre']) ?></h5>
              <p class="card-text"><?= htmlspecialchars($producto['descripcion']) ?></p>
              <p class="card-text fw-bold text-success mb-2">$<?= number_format($producto['precio'], 0, ',', '.') ?></p>
              <div class="d-flex gap-2 mt-3">
                <a href="agregar_al_carrito.php?id=<?= $producto['id'] ?>" class="btn btn-success w-50">Agregar al carrito</a>
                <a href="detalle.php?id=<?= $producto['id'] ?>" class="btn btn-outline-primary w-50">Ver detalles</a>
              </div>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </main>

  <footer class="bg-dark text-center text-white py-4 border-top mt-5">
    <div class="container">
      <p>&copy; 2025 Barbería Estilo. Todos los derechos reservados.</p>
    </div>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
