<?php
require_once __DIR__ . '/includes/bootstrap.php';
require_once __DIR__ . '/app/Models/ProductModel.php';
cart_handle_post();

$slug = get_string('slug');
$product = db_available() ? ProductModel::findBySlug($slug) : get_product($slug);

if (!$product) {
    http_response_code(404);
    page_meta('Producto no disponible | ERRE', 'El producto que buscás no está disponible.');
    require __DIR__ . '/includes/header.php';
    ?>
    <div class="container empty-page">
        <h1>Producto no encontrado</h1>
        <p>Puede que ya no esté disponible.</p>
        <a class="btn btn-primary" href="index.php">Volver al inicio</a>
    </div>
    <?php
    require __DIR__ . '/includes/footer.php';
    exit;
}

$off = discount_percent($product);
$catalog_url = $product['category'] === 'comestibles' ? 'comestibles.php' : 'limpieza.php';
$catalog_label = $product['category'] === 'comestibles' ? 'Comestibles' : 'Limpieza';

$related = array();
$catalog_products = db_available() ? ProductModel::byCategory($product['category']) : get_products();
foreach ($catalog_products as $other) {
    if ($other['category'] === $product['category'] && $other['slug'] !== $product['slug'] && count($related) < 4) {
        $related[] = $other;
    }
}

$title = $product['name'] . ' ' . $product['unit'] . ' – ' . $product['brand'] . ' | ERRE';
$description = $product['name'] . ' ' . $product['brand'] . ' a ' . format_price($product['price']) . '. '
    . excerpt($product['description'], 110);
page_meta($title, $description);

require __DIR__ . '/includes/header.php';
?>

<div class="container page-content">
    <nav class="breadcrumb page-breadcrumb" aria-label="Ruta">
        <a href="index.php">Inicio</a>
        <?php echo icon('chevron'); ?>
        <a href="<?php echo e($catalog_url); ?>"><?php echo e($catalog_label); ?></a>
        <?php echo icon('chevron'); ?>
        <span><?php echo e($product['name']); ?></span>
    </nav>

    <div class="product-detail">
        <div class="product-detail-media">
            <?php if ($off > 0): ?>
                <span class="badge badge-sale detail-discount">-<?php echo $off; ?>% OFF</span>
            <?php endif; ?>
            <img src="<?php echo e($product['image']); ?>" alt="<?php echo e($product['name']); ?>" width="512" height="512">
        </div>

        <div class="product-detail-info">
            <span class="badge badge-soft"><?php echo e($product['type']); ?></span>
            <h1><?php echo e($product['name']); ?></h1>
            <p class="muted">Marca: <strong><?php echo e($product['brand']); ?></strong> · <?php echo e($product['unit']); ?></p>

            <div class="detail-price">
                <strong><?php echo format_price($product['price']); ?></strong>
                <?php if ($product['oldPrice']): ?>
                    <span><?php echo format_price($product['oldPrice']); ?></span>
                <?php endif; ?>
            </div>
            <p class="muted small">Precio final con IVA incluido.</p>

            <form method="post" action="producto.php" class="detail-buy">
                <input type="hidden" name="action" value="add">
                <input type="hidden" name="slug" value="<?php echo e($product['slug']); ?>">
                <?php render_qty_stepper($product['slug'], 1, 1); ?>
                <button type="submit" class="btn btn-primary btn-xl detail-add">
                    <?php echo icon('cart'); ?> Agregar al carrito · <?php echo format_price($product['price']); ?>
                </button>
            </form>

            <ul class="detail-perks">
                <li><?php echo icon('truck'); ?> Envío gratis desde <?php echo format_price(FREE_SHIPPING_FROM); ?></li>
                <li><?php echo icon('rotate'); ?> Devolución sin cargo dentro de las 48 h</li>
                <li><?php echo icon('shield'); ?> Compra 100% protegida</li>
            </ul>

            <div class="tabs" data-tabs>
                <div class="tab-list" role="tablist">
                    <button type="button" class="tab-btn active" data-tab="descripcion" role="tab">Descripción</button>
                    <button type="button" class="tab-btn" data-tab="detalles" role="tab">Detalles</button>
                    <button type="button" class="tab-btn" data-tab="envio" role="tab">Envío</button>
                </div>
                <div class="tab-panel" data-panel="descripcion">
                    <p><?php echo e($product['description']); ?></p>
                </div>
                <div class="tab-panel" data-panel="detalles" hidden>
                    <dl class="detail-specs">
                        <dt>Marca</dt><dd><?php echo e($product['brand']); ?></dd>
                        <dt>Contenido</dt><dd><?php echo e($product['unit']); ?></dd>
                        <dt>Categoría</dt><dd><?php echo e($catalog_label); ?> › <?php echo e($product['type']); ?></dd>
                        <dt>Código</dt><dd>ERRE-<?php echo e(strtoupper(substr($product['slug'], 0, 6))); ?></dd>
                    </dl>
                </div>
                <div class="tab-panel" data-panel="envio" hidden>
                    <p>Entregamos en CABA y GBA en franjas horarias de 2 horas. Pedidos confirmados antes de las 13 h llegan en el día.
                        <a class="link" href="servicios.php">Ver políticas de envío</a>.</p>
                </div>
            </div>
        </div>
    </div>

    <section class="section-block">
        <h2 class="section-title">También te puede interesar</h2>
        <div class="product-grid">
            <?php foreach ($related as $other): ?>
                <?php render_product_card($other); ?>
            <?php endforeach; ?>
        </div>
    </section>
</div>

<?php require __DIR__ . '/includes/footer.php'; ?>
