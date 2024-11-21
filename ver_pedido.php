<?php
include 'conexion.php';

if (isset($_GET['id'])) {
    $id_pedido = $_GET['id'];

    $pedido_resultado = $conexion->query("SELECT * FROM pedidos WHERE id = $id_pedido");
    $pedido = $pedido_resultado->fetch_assoc();

    if (!$pedido) {
        die("Pedido no encontrado.");
    }

    $id_cliente = $pedido['cliente_id'];
    $cliente_resultado = $conexion->query("SELECT * FROM clientes WHERE id = $id_cliente");
    $cliente = $cliente_resultado->fetch_assoc();

    $productos_resultado = $conexion->query("
        SELECT p.nombre, pp.cantidad, p.precio 
        FROM productos p
        INNER JOIN pedido_productos pp ON p.id = pp.producto_id
        WHERE pp.pedido_id = $id_pedido
    ");
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalle del Pedido</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php include 'nav.php';?> 
<div class="container mt-5">
        <div class="card">
            <div class="card-header">
                <h1>Detalle del Pedido #<?= $pedido['id'] ?></h1>
            </div>
            <div class="card-body">
                <h4>Cliente: <?= $cliente['nombre'] ?></h4>
                <p><strong>Contacto:</strong> <?= $cliente['contacto'] ?></p>
                <p><strong>Dirección:</strong> <?= $cliente['direccion'] ?></p>

                <hr>
                <h4>Productos del Pedido</h4>
                <table class="table table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th>Producto</th>
                            <th>Cantidad</th>
                            <th>Precio</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php 
                    $total_pedido = 0;
                    while ($producto = $productos_resultado->fetch_assoc()): 
                        $total_producto = $producto['cantidad'] * $producto['precio'];
                        $total_pedido += $total_producto;
                    ?>
                        <tr>
                            <td><?= $producto['nombre'] ?></td>
                            <td><?= $producto['cantidad'] ?></td>
                            <td><?= number_format($producto['precio'], 2) ?></td>
                            <td><?= number_format($total_producto, 2) ?></td>
                        </tr>
                    <?php endwhile; ?>
                    </tbody>
                </table>

                <hr>
                <h4><strong>Total del Pedido: <?= number_format($total_pedido, 2) ?></strong></h4>
            </div>
            <div class="card-footer">
                <a href="clientes.php" class="btn btn-secondary">Volver a la lista de clientes</a>
            </div>
        </div>
    </div>
</body>
</html>
