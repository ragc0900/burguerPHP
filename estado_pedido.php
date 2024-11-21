<?php
include 'conexion.php';
if (isset($_GET['id']) && isset($_GET['accion'])) {
    $id = intval($_GET['id']);
    $accion = $_GET['accion'];
    $conexion->query("UPDATE pedidos SET estado = '$accion' WHERE id = $id");
    header('Location: pedidos.php');
}
?>
