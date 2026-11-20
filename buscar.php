<?php
require_once __DIR__ . '/includes/bootstrap.php';

$q = get_string('q');
$results = search_products($q);

page_meta(
    $q !== '' ? 'Resultados para "' . $q . '" | ERRE' : 'Buscar productos | ERRE',
    'Encontrá comestibles y artículos de limpieza en ERRE Supermercado.'
);

require __DIR__ . '/includes/header.php';
render_page_header('Búsqueda', $q !== '' ? 'Resultados para "' . $q . '"' : 'Buscar productos');
?>

<div class="container page-content">
    <?php if (strlen(normalize_text($q)) < 2): ?>
        <div class="empty-state">
            <p>Escribí al menos 2 caracteres para buscar productos.</p>
            <a class="btn btn-primary" href="comestibles.php">Ver comestibles</a>
        </div>
    <?php elseif (count($results) === 0): ?>
        <div class="empty-state">
            <p>No encontramos productos para “<?php echo e($q); ?>”.</p>
            <a class="btn btn-soft" href="limpieza.php">Ver limpieza</a>
        </div>
    <?php else: ?>
        <p class="results-count"><strong><?php echo count($results); ?></strong> productos encontrados</p>
        <div class="product-grid">
            <?php foreach ($results as $product): ?>
                <?php render_product_card($product); ?>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<?php require __DIR__ . '/includes/footer.php'; ?>
