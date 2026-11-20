<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Productos | Módulo CodeIgniter 4</title>
</head>
<body>
<div class="container" style="max-width:960px;margin:2rem auto;font-family:system-ui">
    <h1>Productos</h1>
    <p>Vista renderizada con el motor de plantillas de CodeIgniter 4 (<code>view()</code>).</p>

    <table border="1" cellpadding="8" cellspacing="0" style="width:100%;border-collapse:collapse">
        <thead>
            <tr>
                <th>ID</th>
                <th>Producto</th>
                <th>Tipo</th>
                <th>Precio</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($productos as $producto): ?>
            <tr>
                <td><?= esc($producto['id']) ?></td>
                <td><?= esc($producto['nombre']) ?></td>
                <td><?= esc($producto['tipo']) ?></td>
                <td>$ <?= number_format((float) $producto['precio'], 0, ',', '.') ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
</body>
</html>
