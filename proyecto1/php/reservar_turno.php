<?php
session_start();
include 'conexion.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

$usuario_id    = $_SESSION['usuario_id'];
$fecha         = $_POST['fecha_turno'] ?? null;
$hora          = $_POST['hora_turno'] ?? null;
$servicio      = $_POST['servicio'] ?? null;
$descripcion   = trim($_POST['descripcion'] ?? '');
$barbero       = $_POST['barbero'] ?? null;
$whatsapp      = isset($_POST['whatsapp_confirm']) ? 1 : 0;
$metodo_pago   = $_POST['metodo_pago'] ?? null;
$creado_en     = date("Y-m-d H:i:s");

$barbero = $barbero === '' ? null : $barbero;

if (!$fecha || !$hora || !$servicio || empty($descripcion) || !$metodo_pago) {
    echo "Faltan datos obligatorios.";
    exit();
}


$consulta_precio = $con->prepare("SELECT precio FROM servicios WHERE id = ?");
$consulta_precio->bind_param("i", $servicio);
$consulta_precio->execute();
$resultado_precio = $consulta_precio->get_result();

if ($resultado_precio->num_rows === 0) {
    echo "Servicio inválido.";
    exit();
}

$precio_servicio = $resultado_precio->fetch_assoc()['precio'];
$consulta_precio->close();

$stmt = $con->prepare("INSERT INTO turnos (usuario_id, fecha, hora, servicio, descripcion, barbero, whatsapp, creado_en, metodo_pago, precio)
                       VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

if ($stmt === false) {
    die("Error en la preparación de la consulta: " . $con->error);
}

$stmt->bind_param("isssisdisd", $usuario_id, $fecha, $hora, $servicio, $descripcion, $barbero, $whatsapp, $creado_en, $metodo_pago, $precio_servicio);

if ($stmt->execute()) {
    echo "<script>
            alert('Turno registrado con éxito');
            window.location.href = 'index2.php';
          </script>";
    exit();
} else {
    echo "Error al guardar el turno: " . $stmt->error;
}

$stmt->close();
$con->close();
?>
