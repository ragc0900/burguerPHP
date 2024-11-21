<?php
include 'conexion.php';

$resultado = $conexion->query("SELECT * FROM productos");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Productos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php include 'nav.php';?>
    <div class="container mt-5">
        <h1 class="mb-4">Gestión de Productos</h1>

        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Precio</th>
                    <th>Stock</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($fila = $resultado->fetch_assoc()): ?>
                    <tr>
                        <td><?= $fila['nombre'] ?></td>
                        <td><?= $fila['descripcion'] ?></td>
                        <td><?= $fila['precio'] ?></td>
                        <td><?= $fila['stock'] ?></td>
                        <td><?= $fila['estado'] ?></td>
                        <td>
                            <a class="btn btn-primary btn-sm" href="editar_producto.php?id=<?= $fila['id'] ?>">Editar</a>
                            <a class="btn btn-danger btn-sm" href="eliminar_producto.php?id=<?= $fila['id'] ?>">Eliminar</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <div class="card mt-4">
            <div class="card-body">
                <h5 class="card-title">Crear Nuevo Producto</h5>
                <form method="POST" action="crear_producto.php">
                    <div class="mb-3">
                        <label class="form-label">Nombre del Producto</label>
                        <input type="text" name="nombre" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Descripción</label>
                        <textarea name="descripcion" class="form-control" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Precio</label>
                        <input type="number" name="precio" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Stock</label>
                        <input type="number" name="stock" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-success">Crear Producto</button>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
