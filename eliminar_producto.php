<?php
include 'conexion.php';

if ($_GET['id']) {
    $id = $_GET['id'];
    $conexion->query("DELETE FROM productos WHERE id = $id");
    header('Location: productos.php');
}
?>
