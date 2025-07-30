<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Sobre Nosotros - Barbería Estilo</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="../css/style.css">
</head>
<body>
  <header class="p-3 border-bottom bg-dark fixed-top">
    <div class="container">
      <div class="d-flex flex-wrap align-items-center justify-content-between">
        <img src="../img/T.O.png" alt="Logo" style="height: 60px;">
        <a href="../index.html#inicio" class="d-flex align-items-center text-white text-decoration-none">
          <i class="fa-solid fa-scissors fa-2x me-2"></i>
          <span class="fs-4">Barbería Estilo</span>
        </a>
        <ul class="nav col-12 col-lg-auto mb-2 justify-content-center mb-md-0">
          <li><a href="../index.html#inicio" class="nav-link px-3 text-white">Inicio</a></li>
          <li><a href="../index.html#servicios" class="nav-link px-3 text-white">Servicios</a></li>
          <li><a href="../index.html#precios" class="nav-link px-3 text-white">Precios</a></li>
          <li><a href="nosotros.php" class="nav-link px-3 text-secondary">Nosotros</a></li>
        </ul>
        <div class="text-end">
          <a href="login.php"><button type="button" class="btn btn-outline-primary me-2">Login</button></a>
          <a href="registro.php"><button type="button" class="btn btn-primary">Registrarse</button></a>
        </div>
      </div>
    </div>
  </header>

  <main class="container" style="margin-top: 110px;">
    <section class="text-center mb-5">
      <h1 class="display-5 fw-bold">Sobre Nosotros</h1>
      <p class="lead">Más de 10 años brindando estilo, confianza y atención personalizada.<br>En Barbería Estilo, tu imagen es nuestra pasión.</p>
    </section>
    <section class="row align-items-center mb-5">
      <div class="col-md-6 mb-4 mb-md-0">
        <img src="../img/barberia2.jpg" alt="Barbería" class="img-fluid rounded shadow">
      </div>
      <div class="col-md-6">
        <h3 class="fw-bold mb-3">Nuestra Historia</h3>
        <p>Barbería Estilo nació del sueño de crear un espacio donde el arte del buen corte y el trato personalizado se encuentren. Desde nuestros inicios, nos esforzamos por ofrecer un ambiente cálido, profesional y moderno, donde cada cliente se sienta único.</p>
        <h4 class="fw-semibold mt-4">Misión</h4>
        <p>Brindar servicios de barbería de excelencia, fusionando tradición y tendencias actuales, para que cada persona salga con su mejor versión.</p>
        <h4 class="fw-semibold mt-4">Valores</h4>
        <ul>
          <li>Atención personalizada</li>
          <li>Profesionalismo y pasión</li>
          <li>Innovación y aprendizaje constante</li>
          <li>Respeto y confianza</li>
        </ul>
      </div>
    </section>
    <section class="mb-5">
      <h3 class="fw-bold text-center mb-4">Nuestro Equipo</h3>
      <div class="row justify-content-center">
        <div class="col-md-4 mb-4">
          <div class="card bg-dark text-white h-100 shadow">
            <img src="../img/barber1.jpg" class="card-img-top" alt="Barbero 1">
            <div class="card-body">
              <h5 class="card-title">Kevin</h5>
              <p class="card-text">Negrillo, Experto y Fundador. Más de 15 años de experiencia en cortes clásicos y modernos.</p>
            </div>
          </div>
        </div>
        <div class="col-md-4 mb-4">
          <div class="card bg-dark text-white h-100 shadow">
            <img src="../img/federico_acosta.jpg" class="card-img-top" alt="Federico Acosta" style="object-fit: cover; width: 100%; height: 260px; border-radius: 12px 12px 0 0;">
            <div class="card-body">
              <p class="card-text">Junto a su esposa Celeste, evolucionaron los cortes.</p>
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>

  <footer class="bg-dark text-center text-white py-4 border-top mt-auto">
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
</body>
</html>
