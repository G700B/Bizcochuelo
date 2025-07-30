<?php
include("conexion.php");

if (isset($_POST['email'])) {
    $nombre     = $_POST['nombre'];
    $apellido   = $_POST['apellido'];
    $fecha_nac  = $_POST['fecha_nac'];
    $telefono   = $_POST['telefono'];
    $email      = $_POST['email'];
    $clave      = $_POST['clave'];

    $stmt = $con->prepare("SELECT id FROM usuarios WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->close();
        header("Location: registro.php?error=existe");
        exit;
    }
    $stmt->close();

    $clave_encriptada = password_hash($clave, PASSWORD_DEFAULT);

    $stmt = $con->prepare("INSERT INTO usuarios (nombre, apellido, fecha, telefono, email, pass) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $nombre, $apellido, $fecha_nac, $telefono, $email, $clave_encriptada);

    if ($stmt->execute()) {
        $stmt->close();
        header("Location: login.php?registro=ok");
        exit;
    } else {
        $stmt->close();
        header("Location: registro.php?error=1");
        exit;
    }

} else {
    header("Location: registro.php?error=acceso");
    exit;
}
?>
