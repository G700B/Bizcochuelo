<?php
include 'conexion.php';
$producto = null;
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = intval($_GET['id']);
    $stmt = $con->prepare("SELECT * FROM productos WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result && $row = $result->fetch_assoc()) {
        $producto = $row;
    }
    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="es" data-bs-theme="dark">
<head>
  <meta charset="UTF-8">
  <title>Detalle del Producto - Barbería Estilo</title>
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
      </ul>
      <div class="text-end d-flex align-items-center gap-3">
        <a href="carrito.php" class="btn btn-outline-light position-relative me-2">
          <i class="fa-solid fa-cart-shopping"></i>
        </a>
      </div>
    </div>
  </header>

  <main class="container pt-5 mt-5">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <?php if ($producto): ?>
        <div class="card shadow">
          <img src="../img/<?= htmlspecialchars($producto['imagen']) ?>" class="card-img-top" alt="<?= htmlspecialchars($producto['nombre']) ?>">
          <div class="card-body">
            <h3 class="card-title mb-3"><?= htmlspecialchars($producto['nombre']) ?></h3>
            <p class="card-text mb-2"><strong>Descripción:</strong> <?= htmlspecialchars($producto['descripcion']) ?></p>
            <p class="card-text mb-4"><strong>Detalles:</strong> <?= htmlspecialchars($producto['detalles']) ?></p>
            <p class="card-text fw-bold text-success mb-4">Precio: $<?= number_format($producto['precio'], 0, ',', '.') ?></p>
            <a href="agregar_al_carrito.php?id=<?= $producto['id'] ?>" class="btn btn-success w-100">Agregar al carrito</a>
          </div>
        </div>
        <?php else: ?>
        <div class="alert alert-danger text-center">Producto no encontrado.</div>
        <?php endif; ?>
      </div>
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
