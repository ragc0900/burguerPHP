<?php
include 'conexion.php';

if ($_GET['id']) {
    $id = $_GET['id'];
    $conexion->query("DELETE FROM clientes WHERE id = $id");
    header('Location: clientes.php');
}
?>
