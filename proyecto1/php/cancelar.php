<?php
session_start();
include 'conexion.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

$usuario_id = $_SESSION['usuario_id'];
$usuario_nombre = $_SESSION['usuario_nombre'] ?? 'usuario';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ver_turno.php");
    exit();
}

$id_turno = isset($_POST['id']) ? intval($_POST['id']) : 0;
$motivo_original = trim($_POST['motivo'] ?? '');

if ($id_turno <= 0 || $motivo_original === '') {
    die("Datos inválidos para cancelar el turno.");
}

// Agrega al final del motivo quién canceló
$motivo_final = $motivo_original . " (cancelado por $usuario_nombre)";

// Solo cancela si el turno pertenece a ese usuario
$sql = "UPDATE turnos SET estado = 'cancelado', cancelacion_motivo = ? WHERE id = ? AND usuario_id = ? AND estado = 'activo'";
$stmt = $con->prepare($sql);
$stmt->bind_param("sii", $motivo_final, $id_turno, $usuario_id);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    header("Location: ver_turno.php?msg=cancelado");
    exit();
} else {
    echo "No se pudo cancelar el turno o ya fue cancelado o no te pertenece.";
}
$stmt->close();
$con->close();
