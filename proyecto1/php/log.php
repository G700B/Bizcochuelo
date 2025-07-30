<?php
session_start();
include("conexion.php");

if (isset($_POST['email']) && isset($_POST['clave'])) {
    $email = $_POST['email'];
    $clave = $_POST['clave'];

    $stmt = $con->prepare("SELECT id, nombre, pass, rol FROM usuarios WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows === 1) {
        $usuario = $resultado->fetch_assoc();

        if (password_verify($clave, $usuario['pass'])) {
      
            $_SESSION['usuario_id'] = $usuario['id'];
            $_SESSION['usuario_nombre'] = $usuario['nombre'];
            $_SESSION['usuario_rol'] = $usuario['rol'];  

         
            if ($usuario['rol'] === 'admin') {
                header("Location: panel_admin.php");  
            } else {
                header("Location: index2.php");       
            }
            exit;
        } else {
            echo "<script>alert('Contraseña incorrecta'); window.history.back();</script>";
        }
    } else {
        echo "<script>alert('Correo no encontrado'); window.history.back();</script>";
    }

    $stmt->close();

} else {
    echo "<script>alert('Acceso no permitido'); window.location.href = 'login.php';</script>";
}
?>
