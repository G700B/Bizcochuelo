<?php
session_start();
include 'conexion.php';

if (!isset($_SESSION['carrito']) || empty($_SESSION['carrito'])) {
    header("Location: carrito.php");
    exit;
}

$carrito = $_SESSION['carrito'];
$usuario_id = $_SESSION['usuario_id'] ?? null;

if (!$usuario_id) {
    header("Location: login.php");
    exit;
}

// Calcular total
$total = 0;
foreach ($carrito as $item) {
    $total += $item['precio'] * $item['cantidad'];
}

// Insertar venta
$stmt = $con->prepare("INSERT INTO ventas (usuario_id, total) VALUES (?, ?)");
$stmt->bind_param("id", $usuario_id, $total);
$stmt->execute();
$venta_id = $stmt->insert_id;
$stmt->close();

// Insertar detalle de productos
$stmt = $con->prepare("INSERT INTO detalle_venta (venta_id, producto_id, cantidad, precio_unitario) VALUES (?, ?, ?, ?)");
foreach ($carrito as $producto) {
    $stmt->bind_param("iiid", $venta_id, $producto['id'], $producto['cantidad'], $producto['precio']);
    $stmt->execute();
}
$stmt->close();

// Limpiar carrito
unset($_SESSION['carrito']);

// Redirigir al historial
header("Location: historial_compras.php");
exit;
?>
