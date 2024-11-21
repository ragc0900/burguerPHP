<?php
include 'conexion.php';

$resultado = $conexion->query("SELECT * FROM clientes");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $contacto = $_POST['contacto'];
    $direccion = $_POST['direccion'];

    $query = "INSERT INTO clientes (nombre, contacto, direccion) VALUES ('$nombre', '$contacto', '$direccion')";
    $conexion->query($query);
    header("Location: clientes.php"); 
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clientes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php include 'nav.php';?>
    <div class="container mt-5">
        <h1>Gestión de Clientes</h1>
        <table class="table table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Contacto</th>
                    <th>Direccion</th>
                    <th>Opciones
                    </th>
                </tr>
            </thead>
            <tbody>
            <?php while ($fila = $resultado->fetch_assoc()): ?>
                    <tr>
                        <td><?= $fila['id'] ?></td>
                        <td><?= $fila['nombre'] ?></td>
                        <td><?= $fila['contacto'] ?></td>
                        <td><?= $fila['direccion'] ?></td>
                        <td>
                            <a class="btn btn-primary btn-sm" href="editar_cliente.php?id=<?= $fila['id'] ?>">Editar</a>
                            <a class="btn btn-danger btn-sm" href="eliminar_cliente.php?id=<?= $fila['id'] ?>">Eliminar</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>


    <div class="card mt-5">
    <div class="card-body">
                <h5 class="card-title">Crear Nuevo cliente</h5>
                <form method="POST" action="clientes.php">
                    <div class="mb-3">
                        <label class="form-label">Nombre del cliente</label>
                        <input type="text" name="nombre" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Contacto</label>
                        <input type="text" name="contacto" class="form-control" require>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Direccion</label>
                        <input type="text" name="direccion" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-success">Crear cliente</button>
                </form>
            </div>
        </div>
</body>
</html>
