<?php
session_start();
include 'conexion.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

$usuario_id = $_SESSION['usuario_id'];
$id_turno = isset($_POST['turno_id']) ? intval($_POST['turno_id']) : 0;

if ($id_turno <= 0) {
    die("Turno no válido.");
}

$fecha = $_POST['fecha'];
$hora = $_POST['hora'];
$servicio = intval($_POST['servicio']);
$descripcion = $_POST['descripcion'];
$barbero = ($_POST['barbero'] !== '') ? intval($_POST['barbero']) : null;
$whatsapp = isset($_POST['whatsapp']) ? 1 : 0;
$metodo_pago = isset($_POST['metodo_pago']) ? intval($_POST['metodo_pago']) : 0;

if ($metodo_pago <= 0) {
    die("Método de pago inválido.");
}

// Validar que el método de pago exista en la base de datos
$sql_check = "SELECT COUNT(*) FROM metodos_pago WHERE id = ?";
$stmt_check = $con->prepare($sql_check);
$stmt_check->bind_param("i", $metodo_pago);
$stmt_check->execute();
$stmt_check->bind_result($count);
$stmt_check->fetch();
$stmt_check->close();

if ($count == 0) {
    die("El método de pago seleccionado no existe.");
}

// Actualizar el turno
$sql = "UPDATE turnos 
        SET fecha = ?, hora = ?, servicio = ?, descripcion = ?, barbero = ?, whatsapp = ?, metodo_pago = ? 
        WHERE id = ? AND usuario_id = ?";

$stmt = $con->prepare($sql);

// Verifica si barbero es NULL o un número
if ($barbero === null) {
    // Usa NULL explícito para barbero
    $stmt->bind_param("sssssiiii", $fecha, $hora, $servicio, $descripcion, $barbero, $whatsapp, $metodo_pago, $id_turno, $usuario_id);
} else {
    $stmt->bind_param("sssssiiii", $fecha, $hora, $servicio, $descripcion, $barbero, $whatsapp, $metodo_pago, $id_turno, $usuario_id);
}

if (!$stmt->execute()) {
    die("Error al ejecutar la actualización: " . $stmt->error);
}

if ($stmt->affected_rows > 0) {
    header("Location: ver_turno.php?msg=editado");
    exit();
} else {
    echo "No se pudo actualizar el turno o no hubo cambios.";
}

$stmt->close();
$con->close();
?>
