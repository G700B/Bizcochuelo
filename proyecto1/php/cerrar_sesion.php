<?php
session_start();
session_destroy();
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Cerrando sesión...</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../css/sesion.css" />
</head>
<body style="background: #222;">
  <script src="../js/sesion.js"></script>
  <script>
    mostrarOverlaySesion('Cerrando sesión', function() {
      window.location.href = '../index.html';
    });
  </script>
</body>
</html>
