<?php
session_start();
include("conexion.php");

if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_rol'] !== 'admin') {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['turno_id']) && isset($_POST['cancelacion_motivo'])) {
    $turno_id = (int)$_POST['turno_id'];
    $motivo = trim($_POST['cancelacion_motivo']);

    if ($motivo === "") {
        $_SESSION['error'] = "El motivo de cancelación no puede estar vacío.";
        header("Location: panel_admin.php");
        exit();
    }

    $nombre_admin = $_SESSION['usuario_nombre'] ?? 'Admin';
    $rol_admin = $_SESSION['usuario_rol'] ?? 'admin';
    
    $motivo_final = $motivo . " (cancelado por $rol_admin $nombre_admin)";

    $stmt = $con->prepare("UPDATE turnos SET estado = 'cancelado', cancelacion_motivo = ? WHERE id = ? AND estado = 'activo'");
    $stmt->bind_param("si", $motivo_final, $turno_id);

    if ($stmt->execute() && $stmt->affected_rows > 0) {
        $_SESSION['mensaje'] = "Turno cancelado correctamente.";
    } else {
        $_SESSION['error'] = "Error al cancelar el turno o ya estaba cancelado.";
    }

    $stmt->close();
} else {
    $_SESSION['error'] = "Datos inválidos.";
}

header("Location: panel_admin.php");
exit();
