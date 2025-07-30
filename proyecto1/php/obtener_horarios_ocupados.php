<?php
session_start();
include 'conexion.php';

if (!isset($_SESSION['usuario_id'])) {
    http_response_code(401);
    echo json_encode([]);
    exit();
}

$fecha = $_GET['fecha'] ?? null;

if (!$fecha) {
    echo json_encode([]);
    exit();
}

$stmt = $con->prepare("SELECT DATE_FORMAT(hora, '%H:%i') as hora_corta FROM turnos WHERE fecha = ? AND estado = 'activo'");
$stmt->bind_param("s", $fecha);
$stmt->execute();
$result = $stmt->get_result();

$horasOcupadas = [];
while ($row = $result->fetch_assoc()) {
    $horasOcupadas[] = $row['hora_corta'];
}

echo json_encode($horasOcupadas);

$stmt->close();
$con->close();
?>
