<?php
/** CRUD de productos — CREATE (TP7). */
require_once __DIR__ . '/includes/bootstrap.php';
require_once __DIR__ . '/app/Models/ProductModel.php';
require_role('admin');
db_requerida();

page_meta(
    'Nuevo producto | ERRE Supermercado',
    'Formulario de alta de productos del catálogo ERRE.'
);

$error = '';
try {
    $marcas = ProductModel::marcas();
    $categorias = ProductModel::categorias();
} catch (PDOException $e) {
    $marcas = array();
    $categorias = array();
    $error = 'Error al cargar marcas o categorías: ' . $e->getMessage();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $marca_nombre = post_string('marca_nombre');
    $data = array(
        'slug' => post_string('slug'),
        'name' => post_string('nombre'),
        'description' => post_string('descripcion'),
        'marca_id' => 0,
        'categoria_id' => (int) post_string('categoria_id'),
        'type' => post_string('tipo'),
        'price' => post_string('precio'),
        'oldPrice' => post_string('old_price'),
        'unit' => post_string('unidad'),
        'image' => post_string('imagen'),
        'featured' => post_string('destacado') === '1',
    );

    if ($data['slug'] === '' || $data['name'] === '' || $marca_nombre === ''
        || $data['categoria_id'] < 1 || $data['type'] === '' || $data['unit'] === ''
        || $data['price'] === '' || $data['image'] === '') {
        $error = 'Completá slug, nombre, marca, categoría, tipo, unidad, precio e imagen.';
    } else {
        try {
            $marca_id = ProductModel::ensureMarca($marca_nombre);
            if (!$marca_id) {
                $error = 'No se pudo guardar la marca.';
            } else {
                $data['marca_id'] = $marca_id;
                if (ProductModel::create($data)) {
                    flash('Producto creado', $data['name']);
                    redirect('admin.php');
                }
                $error = 'No se pudo guardar el producto.';
            }
        } catch (PDOException $e) {
            $error = 'Error de base de datos: ' . $e->getMessage();
        }
    }
}

require __DIR__ . '/includes/header.php';
render_page_header('Administración', 'Nuevo producto', 'Alta con consulta preparada (PDO).');
?>

<div class="container page-content">
    <p><a class="btn btn-outline" href="admin.php">← Volver al listado</a></p>

    <form method="post" action="admin_crear.php" class="card form-stack" style="padding:1.5rem">
        <?php if ($error !== ''): ?>
            <p class="form-error"><?php echo e($error); ?></p>
        <?php endif; ?>

        <div class="form-grid">
            <div class="field">
                <label for="a-slug">Slug (URL)</label>
                <input id="a-slug" name="slug" required value="<?php echo e(post_string('slug')); ?>">
            </div>
            <div class="field">
                <label for="a-nombre">Nombre</label>
                <input id="a-nombre" name="nombre" required value="<?php echo e(post_string('nombre')); ?>">
            </div>
            <div class="field">
                <label for="a-marca">Marca</label>
                <input id="a-marca" name="marca_nombre" list="marcas-list" required placeholder="Escribí o elegí una marca" value="<?php echo e(post_string('marca_nombre')); ?>">
                <datalist id="marcas-list">
                    <?php foreach ($marcas as $marca): ?>
                        <option value="<?php echo e($marca['nombre']); ?>"></option>
                    <?php endforeach; ?>
                </datalist>
            </div>
            <div class="field">
                <label for="a-categoria">Categoría</label>
                <select id="a-categoria" name="categoria_id" required>
                    <option value="">Seleccioná…</option>
                    <?php foreach ($categorias as $categoria): ?>
                        <option value="<?php echo e($categoria['id']); ?>" <?php echo (string) $categoria['id'] === post_string('categoria_id') ? 'selected' : ''; ?>><?php echo e($categoria['nombre']); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="field">
                <label for="a-tipo">Tipo</label>
                <input id="a-tipo" name="tipo" value="<?php echo e(post_string('tipo')); ?>">
            </div>
            <div class="field">
                <label for="a-unidad">Unidad</label>
                <input id="a-unidad" name="unidad" value="<?php echo e(post_string('unidad')); ?>">
            </div>
            <div class="field">
                <label for="a-precio">Precio</label>
                <input id="a-precio" name="precio" type="number" step="0.01" min="0" required value="<?php echo e(post_string('precio')); ?>">
            </div>
            <div class="field">
                <label for="a-old">Precio anterior (opcional)</label>
                <input id="a-old" name="old_price" type="number" step="0.01" min="0" value="<?php echo e(post_string('old_price')); ?>">
            </div>
            <div class="field field-wide">
                <label for="a-imagen">Imagen (ruta)</label>
                <input id="a-imagen" name="imagen" required placeholder="assets/img/products/ejemplo.jpg" value="<?php echo e(post_string('imagen')); ?>">
            </div>
            <div class="field field-wide">
                <label for="a-descripcion">Descripción</label>
                <textarea id="a-descripcion" name="descripcion" rows="4"><?php echo e(post_string('descripcion')); ?></textarea>
            </div>
        </div>

        <label class="check-row">
            <input type="checkbox" name="destacado" value="1" <?php echo post_string('destacado') === '1' ? 'checked' : ''; ?>>
            <span>Producto destacado</span>
        </label>

        <button type="submit" class="btn btn-primary btn-lg">Guardar producto</button>
    </form>
</div>

<?php require __DIR__ . '/includes/footer.php'; ?>
