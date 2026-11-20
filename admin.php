<?php
/** CRUD de productos — READ (TP7). */
require_once __DIR__ . '/includes/bootstrap.php';
require_once __DIR__ . '/app/Models/ProductModel.php';
require_role('admin');
db_requerida();

page_meta(
    'Administrar productos | ERRE Supermercado',
    'Alta, baja, modificación y listado de productos del catálogo ERRE.'
);

$productos = ProductModel::adminList();

require __DIR__ . '/includes/header.php';
render_page_header('Administración', 'Productos', 'Altas, bajas y modificaciones del catálogo.');
?>

<div class="container page-content">
    <p style="margin-bottom:1rem">
        <a class="btn btn-primary" href="admin_crear.php">+ Nuevo producto</a>
        <a class="btn btn-outline" href="admin_panel.php">Volver al panel</a>
    </p>

    <?php if (count($productos) === 0): ?>
        <div class="empty-state">
            <p>No hay productos en la base de datos.</p>
            <p class="muted">Importá <code>consultas.sql</code> para cargar el catálogo inicial.</p>
        </div>
    <?php else: ?>
        <div class="card table-wrap">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Producto</th>
                        <th>Marca</th>
                        <th>Categoría</th>
                        <th>Precio</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($productos as $p): ?>
                        <tr>
                            <td><?php echo e($p['id']); ?></td>
                            <td>
                                <strong><?php echo e($p['nombre']); ?></strong><br>
                                <small class="muted"><?php echo e($p['slug']); ?></small>
                            </td>
                            <td><?php echo e($p['marca']); ?></td>
                            <td><?php echo e($p['categoria']); ?></td>
                            <td><?php echo format_price($p['precio']); ?></td>
                            <td>
                                <a class="btn btn-sm btn-outline" href="admin_editar.php?id=<?php echo e($p['id']); ?>">Editar</a>
                                <form method="post" action="admin_eliminar.php" style="display:inline"
                                      onsubmit="return confirm('¿Eliminar este producto?');">
                                    <input type="hidden" name="id" value="<?php echo e($p['id']); ?>">
                                    <button type="submit" class="btn btn-sm btn-outline">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

<?php require __DIR__ . '/includes/footer.php'; ?>
