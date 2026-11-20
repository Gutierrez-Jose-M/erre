<?php
/** Piezas reutilizables de la interfaz. */

/** Encabezado con migas de pan de las páginas interiores. */
function render_page_header($crumb, $title, $subtitle = '', $extra = '')
{
    ?>
    <section class="page-header">
        <div class="container page-header-inner">
            <nav class="breadcrumb" aria-label="Ruta">
                <a href="index.php">Inicio</a>
                <?php echo icon('chevron'); ?>
                <span><?php echo e($crumb); ?></span>
            </nav>
            <h1><?php echo e($title); ?></h1>
            <?php if ($subtitle !== ''): ?>
                <p class="page-subtitle"><?php echo e($subtitle); ?></p>
            <?php endif; ?>
            <?php echo $extra; ?>
        </div>
    </section>
    <?php
}

/** Tarjeta de producto del catálogo. */
function render_product_card($product)
{
    $off = discount_percent($product);
    ?>
    <article class="product-card">
        <?php if ($off > 0): ?>
            <span class="badge badge-sale product-discount">-<?php echo $off; ?>%</span>
        <?php endif; ?>
        <a class="product-media" href="producto.php?slug=<?php echo e($product['slug']); ?>">
            <img src="<?php echo e($product['image']); ?>" alt="<?php echo e($product['name']); ?>" loading="lazy" width="512" height="512">
        </a>
        <div class="product-info">
            <span class="product-brand"><?php echo e($product['brand']); ?></span>
            <a class="product-name" href="producto.php?slug=<?php echo e($product['slug']); ?>"><?php echo e($product['name']); ?></a>
            <span class="muted product-unit"><?php echo e($product['unit']); ?></span>
            <div class="product-price">
                <?php if ($product['oldPrice']): ?>
                    <span class="old-price"><?php echo format_price($product['oldPrice']); ?></span>
                <?php endif; ?>
                <span class="price"><?php echo format_price($product['price']); ?></span>
            </div>
            <form method="post" action="carrito.php">
                <input type="hidden" name="action" value="add">
                <input type="hidden" name="slug" value="<?php echo e($product['slug']); ?>">
                <input type="hidden" name="qty" value="1">
                <button type="submit" class="btn btn-primary btn-block btn-add">
                    <?php echo icon('plus'); ?> Agregar al carrito
                </button>
            </form>
        </div>
    </article>
    <?php
}

/** Control de cantidad para el carrito (va dentro de un formulario). */
function render_qty_stepper($slug, $qty, $min = 0)
{
    ?>
    <div class="qty-stepper">
        <button type="button" class="qty-btn" data-step="-1" aria-label="Disminuir cantidad"><?php echo icon('minus'); ?></button>
        <input type="number" name="qty" value="<?php echo (int) $qty; ?>" min="<?php echo (int) $min; ?>" max="99" aria-label="Cantidad" onchange="this.form.submit()">
        <button type="button" class="qty-btn" data-step="1" aria-label="Aumentar cantidad"><?php echo icon('plus'); ?></button>
    </div>
    <?php
}

/** Resumen de la orden; $inner permite agregar un botón u otro contenido. */
function render_order_summary($show_items = false, $inner = '')
{
    $t = cart_totals();
    $missing = FREE_SHIPPING_FROM - $t['subtotal'];
    ?>
    <aside class="order-summary">
        <h2>Resumen de la orden</h2>
        <?php if ($show_items): ?>
            <ul class="summary-items">
                <?php foreach ($t['items'] as $item): ?>
                    <li>
                        <span class="summary-thumb">
                            <img src="<?php echo e($item['product']['image']); ?>" alt="">
                            <span class="summary-qty"><?php echo $item['qty']; ?></span>
                        </span>
                        <span class="summary-name"><?php echo e($item['product']['name']); ?></span>
                        <strong><?php echo format_price($item['subtotal']); ?></strong>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
        <dl class="summary-totals">
            <div>
                <dt>Subtotal (<?php echo $t['count']; ?> <?php echo $t['count'] === 1 ? 'producto' : 'productos'; ?>)</dt>
                <dd><?php echo format_price($t['subtotal']); ?></dd>
            </div>
            <div>
                <dt>Envío</dt>
                <dd><?php echo $t['shipping'] === 0 ? '<span class="text-primary">Gratis</span>' : format_price($t['shipping']); ?></dd>
            </div>
            <?php if ($t['subtotal'] > 0 && $missing > 0): ?>
                <p class="shipping-hint">Te faltan <?php echo format_price($missing); ?> para tener envío gratis.</p>
            <?php endif; ?>
            <div class="summary-total">
                <dt>Total</dt>
                <dd><?php echo format_price($t['total']); ?></dd>
            </div>
        </dl>
        <?php if ($inner !== ''): ?>
            <div class="summary-actions"><?php echo $inner; ?></div>
        <?php endif; ?>
    </aside>
    <?php
}

/** Etiqueta de estado de un pedido. */
function status_badge($status)
{
    $class = 'badge';
    if ($status === 'Entregado') {
        $class .= ' badge-soft';
    } elseif ($status === 'En camino') {
        $class .= ' badge-highlight';
    } elseif ($status === 'Cancelado') {
        $class .= ' badge-sale';
    } else {
        $class .= ' badge-outline';
    }
    return '<span class="' . $class . '">' . e($status) . '</span>';
}
