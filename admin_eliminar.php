<?php
/** CRUD de productos — DELETE (TP7). */
require_once __DIR__ . '/includes/bootstrap.php';
require_once __DIR__ . '/app/Models/ProductModel.php';
require_role('admin');
db_requerida();

page_meta(
    'Eliminar producto | ERRE Supermercado',
    'Baja de productos del catálogo ERRE.'
);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = (int) post_string('id');
    try {
        if (ProductModel::delete($id)) {
            flash('Producto eliminado');
        } else {
            flash('No se pudo eliminar el producto', '', 'info');
        }
    } catch (PDOException $e) {
        flash('Error de base de datos', $e->getMessage(), 'info');
    }
    redirect('admin.php');
}

$id = (int) get_string('id');
$product = ProductModel::find($id);
if (!$product) {
    flash('Producto no encontrado', '', 'info');
    redirect('admin.php');
}

require __DIR__ . '/includes/header.php';
render_page_header('Administración', 'Eliminar producto', 'Confirmá la baja del registro.');
?>

<div class="container page-content">
    <div class="card" style="padding:1.5rem;max-width:640px">
        <p>¿Seguro que querés eliminar <strong><?php echo e($product['name']); ?></strong>?</p>
        <p class="muted">Esta acción no se puede deshacer.</p>
        <form method="post" action="admin_eliminar.php" style="margin-top:1rem">
            <input type="hidden" name="id" value="<?php echo e($id); ?>">
            <button type="submit" class="btn btn-primary">Confirmar eliminación</button>
            <a class="btn btn-outline" href="admin.php">Cancelar</a>
        </form>
    </div>
</div>

<?php require __DIR__ . '/includes/footer.php'; ?>
