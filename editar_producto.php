<?php
include 'conexion.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $resultado = $conexion->query("SELECT * FROM productos WHERE id = $id");
    $producto = $resultado->fetch_assoc();

    if (!$producto) {
        header("Location: productos.php");
        exit;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id']; 
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];
    $stock = $_POST['stock'];

    $query = "UPDATE productos SET 
                nombre = '$nombre', 
                descripcion = '$descripcion', 
                precio = $precio, 
                stock = $stock 
              WHERE id = $id";
    
    if ($conexion->query($query)) {
        header("Location: productos.php"); 
        exit;
    } else {
        echo "Error al actualizar el producto: " . $conexion->error;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Producto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php include 'nav.php';?>
    <div class="container mt-5">
        <h1 class="mb-4">Editar Producto</h1>
        <form method="POST" action="editar_producto.php">
            <!-- ID oculto -->
            <input type="hidden" name="id" value="<?= $producto['id'] ?>">

            <div class="mb-3">
                <label class="form-label">Nombre del Producto</label>
                <input type="text" name="nombre" class="form-control" value="<?= $producto['nombre'] ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Descripción</label>
                <textarea name="descripcion" class="form-control" rows="3" required><?= $producto['descripcion'] ?></textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">Precio</label>
                <input type="number" name="precio" class="form-control" value="<?= $producto['precio'] ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Stock</label>
                <input type="number" name="stock" class="form-control" value="<?= $producto['stock'] ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Actualizar Producto</button>
            <a href="productos.php" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
