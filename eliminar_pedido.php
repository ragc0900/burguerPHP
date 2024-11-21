<?php
include 'conexion.php';

if ($_GET['id']) {
    $id = $_GET['id'];

    $productos = $conexion->query("SELECT producto_id, cantidad FROM pedido_productos WHERE pedido_id = $id");
    while ($producto = $productos->fetch_assoc()) {
        $conexion->query("UPDATE productos SET stock = stock + {$producto['cantidad']} WHERE id = {$producto['producto_id']}");
    }

    $conexion->query("DELETE FROM pedido_productos WHERE pedido_id = $id");
    $conexion->query("DELETE FROM pedidos WHERE id = $id");

    header('Location: pedidos.php');
}
?>
