<?php
/** CRUD de productos — UPDATE (TP7). */
require_once __DIR__ . '/includes/bootstrap.php';
require_once __DIR__ . '/app/Models/ProductModel.php';
require_role('admin');
db_requerida();

page_meta(
    'Editar producto | ERRE Supermercado',
    'Modificación de productos del catálogo ERRE.'
);

$id = (int) get_string('id');
$product = ProductModel::find($id);
if (!$product) {
    flash('Producto no encontrado', '', 'info');
    redirect('admin.php');
}

$marcas = ProductModel::marcas();
$categorias = ProductModel::categorias();
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = array(
        'slug' => post_string('slug'),
        'name' => post_string('nombre'),
        'description' => post_string('descripcion'),
        'marca_id' => (int) post_string('marca_id'),
        'categoria_id' => (int) post_string('categoria_id'),
        'type' => post_string('tipo'),
        'price' => post_string('precio'),
        'oldPrice' => post_string('old_price'),
        'unit' => post_string('unidad'),
        'image' => post_string('imagen'),
        'featured' => post_string('destacado') === '1',
    );

    if ($data['slug'] === '' || $data['name'] === '' || $data['marca_id'] < 1
        || $data['categoria_id'] < 1 || $data['price'] === '' || $data['image'] === '') {
        $error = 'Completá slug, nombre, marca, categoría, precio e imagen.';
    } else {
        try {
            if (ProductModel::update($id, $data)) {
                $product = ProductModel::find($id);
                flash('Producto actualizado', $data['name']);
                redirect('admin.php');
            }
            $error = 'No se pudo actualizar el producto.';
        } catch (PDOException $e) {
            $error = 'Error de base de datos: ' . $e->getMessage();
        }
    }
}

// Valores que se muestran en el formulario (los enviados tienen prioridad).
$values = array(
    'slug' => $_SERVER['REQUEST_METHOD'] === 'POST' ? post_string('slug') : $product['slug'],
    'nombre' => $_SERVER['REQUEST_METHOD'] === 'POST' ? post_string('nombre') : $product['name'],
    'descripcion' => $_SERVER['REQUEST_METHOD'] === 'POST' ? post_string('descripcion') : $product['description'],
    'marca_id' => $_SERVER['REQUEST_METHOD'] === 'POST' ? (int) post_string('marca_id') : $product['marca_id'],
    'categoria_id' => $_SERVER['REQUEST_METHOD'] === 'POST' ? (int) post_string('categoria_id') : $product['categoria_id'],
    'tipo' => $_SERVER['REQUEST_METHOD'] === 'POST' ? post_string('tipo') : $product['type'],
    'precio' => $_SERVER['REQUEST_METHOD'] === 'POST' ? post_string('precio') : $product['price'],
    'old_price' => $_SERVER['REQUEST_METHOD'] === 'POST' ? post_string('old_price') : $product['oldPrice'],
    'unidad' => $_SERVER['REQUEST_METHOD'] === 'POST' ? post_string('unidad') : $product['unit'],
    'imagen' => $_SERVER['REQUEST_METHOD'] === 'POST' ? post_string('imagen') : $product['image'],
    'destacado' => $_SERVER['REQUEST_METHOD'] === 'POST' ? post_string('destacado') === '1' : $product['featured'],
);

require __DIR__ . '/includes/header.php';
render_page_header('Administración', 'Editar producto', $product['name']);
?>

<div class="container page-content">
    <p><a class="btn btn-outline" href="admin.php">← Volver al listado</a></p>

    <form method="post" action="admin_editar.php?id=<?php echo e($id); ?>" class="card form-stack" style="padding:1.5rem">
        <?php if ($error !== ''): ?>
            <p class="form-error"><?php echo e($error); ?></p>
        <?php endif; ?>

        <input type="hidden" name="id" value="<?php echo e($id); ?>">

        <div class="form-grid">
            <div class="field">
                <label for="a-slug">Slug (URL)</label>
                <input id="a-slug" name="slug" required value="<?php echo e($values['slug']); ?>">
            </div>
            <div class="field">
                <label for="a-nombre">Nombre</label>
                <input id="a-nombre" name="nombre" required value="<?php echo e($values['nombre']); ?>">
            </div>
            <div class="field">
                <label for="a-marca">Marca</label>
                <select id="a-marca" name="marca_id" required>
                    <?php foreach ($marcas as $marca): ?>
                        <option value="<?php echo e($marca['id']); ?>" <?php echo (int) $marca['id'] === $values['marca_id'] ? 'selected' : ''; ?>>
                            <?php echo e($marca['nombre']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="field">
                <label for="a-categoria">Categoría</label>
                <select id="a-categoria" name="categoria_id" required>
                    <?php foreach ($categorias as $categoria): ?>
                        <option value="<?php echo e($categoria['id']); ?>" <?php echo (int) $categoria['id'] === $values['categoria_id'] ? 'selected' : ''; ?>>
                            <?php echo e($categoria['nombre']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="field">
                <label for="a-tipo">Tipo</label>
                <input id="a-tipo" name="tipo" value="<?php echo e($values['tipo']); ?>">
            </div>
            <div class="field">
                <label for="a-unidad">Unidad</label>
                <input id="a-unidad" name="unidad" value="<?php echo e($values['unidad']); ?>">
            </div>
            <div class="field">
                <label for="a-precio">Precio</label>
                <input id="a-precio" name="precio" type="number" step="0.01" min="0" required value="<?php echo e($values['precio']); ?>">
            </div>
            <div class="field">
                <label for="a-old">Precio anterior (opcional)</label>
                <input id="a-old" name="old_price" type="number" step="0.01" min="0" value="<?php echo e($values['old_price']); ?>">
            </div>
            <div class="field field-wide">
                <label for="a-imagen">Imagen (ruta)</label>
                <input id="a-imagen" name="imagen" required value="<?php echo e($values['imagen']); ?>">
            </div>
            <div class="field field-wide">
                <label for="a-descripcion">Descripción</label>
                <textarea id="a-descripcion" name="descripcion" rows="4"><?php echo e($values['descripcion']); ?></textarea>
            </div>
        </div>

        <label class="check-row">
            <input type="checkbox" name="destacado" value="1" <?php echo $values['destacado'] ? 'checked' : ''; ?>>
            <span>Producto destacado</span>
        </label>

        <button type="submit" class="btn btn-primary btn-lg">Guardar cambios</button>
    </form>
</div>

<?php require __DIR__ . '/includes/footer.php'; ?>
