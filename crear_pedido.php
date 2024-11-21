<?php
include 'conexion.php';

$clientes = $conexion->query("SELECT id, nombre FROM clientes");
$productos = $conexion->query("SELECT id, nombre, stock FROM productos WHERE estado = 'Disponible'");

if ($_POST) {
    $cliente_id = $_POST['cliente_id'];
    $productos_seleccionados = $_POST['producto_id'];
    $cantidades = $_POST['cantidad'];

    if (empty($productos_seleccionados)) {
        echo "Por favor, seleccione al menos un producto.";
        exit; 
    }

    $conexion->query("INSERT INTO pedidos (cliente_id) VALUES ($cliente_id)");
    $pedido_id = $conexion->insert_id; 

    foreach ($productos_seleccionados as $index => $producto_id) {
        $cantidad = $cantidades[$index];
        
        $producto_query = $conexion->query("SELECT stock FROM productos WHERE id = $producto_id");
        $producto = $producto_query->fetch_assoc();
        if ($producto['stock'] < $cantidad) {
            echo "No hay suficiente stock para el producto: " . $producto['nombre'];
            exit;
        }

        $conexion->query("INSERT INTO pedido_productos (pedido_id, producto_id, cantidad) VALUES ($pedido_id, $producto_id, $cantidad)");

        $conexion->query("UPDATE productos SET stock = stock - $cantidad WHERE id = $producto_id");
    }

    header('Location: pedidos.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Pedido</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php include 'nav.php';?>
    <div class="container mt-5">
        <h1>Crear Pedido</h1>
        <form method="POST">
            <div class="mb-3">
                <label>Cliente</label>
                <select name="cliente_id" class="form-select" required>
                    <option value="">Seleccione un cliente</option>
                    <?php while ($cliente = $clientes->fetch_assoc()): ?>
                        <option value="<?= $cliente['id'] ?>"><?= $cliente['nombre'] ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="mb-3">
                <label>Productos</label>
                <?php while ($producto = $productos->fetch_assoc()): ?>
                    <div class="d-flex align-items-center mb-2">
                        <input type="checkbox" name="producto_id[]" value="<?= $producto['id'] ?>" class="form-check-input me-2">
                        <label class="form-check-label me-3"><?= $producto['nombre'] ?> (Stock: <?= $producto['stock'] ?>)</label>
                        <input type="number" name="cantidad[]" min="1" placeholder="Cantidad" class="form-control w-25">
                    </div>
                <?php endwhile; ?>
            </div>
            <button type="submit" class="btn btn-success">Guardar Pedido</button>
            <a href="pedidos.php" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</body>
</html>
