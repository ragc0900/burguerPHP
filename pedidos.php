<?php
include 'conexion.php';

$pedidos = $conexion->query("
    SELECT p.id, p.fecha, p.estado, c.nombre AS cliente
    FROM pedidos p
    JOIN clientes c ON p.cliente_id = c.id
");

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pedidos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php include 'nav.php';?>
    <div class="container mt-5">
        <h1>Gestión de Pedidos</h1>
        <a href="crear_pedido.php" class="btn btn-success mb-3">Nuevo Pedido</a>
        <table class="table table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Cliente</th>
                    <th>Fecha</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($pedido = $pedidos->fetch_assoc()): ?>
                    <tr>
                        <td><?= $pedido['id'] ?></td>
                        <td><?= $pedido['cliente'] ?></td>
                        <td><?= $pedido['fecha'] ?></td>
                        <td><?= $pedido['estado'] ?></td>
                        <td>
                        <select class="form-select form-select-sm" onchange="confirmarCambio(this, <?= $pedido['id'] ?>)">
                            <option value="">Sel. nuevo estado</option>
                            <option value="aprobar">Pendiente</option>
                            <option value="rechazar">En proceso</option>
                            <option value="pendiente">Enviado</option>
                            <option value="cancelar">Completado</option>
                        </select>
                            <a href="ver_pedido.php?id=<?= $pedido['id'] ?>" class="btn btn-primary btn-sm">Ver</a>
                            <a href="eliminar_pedido.php?id=<?= $pedido['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Está seguro de eliminar este pedido?');">Eliminar</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <script>
          function confirmarCambio(select, id) {
        if (select.value === "") return; 

        const confirmacion = confirm(`¿Está seguro de cambiar el estado a "${select.options[select.selectedIndex].text}"?`);
        if (confirmacion) {
            window.location.href = `estado_pedido.php?id=${id}&accion=${select.options[select.selectedIndex].text}`;
        } else {
            select.value = "";
        }
    }
    </script>
</body>
</html>
