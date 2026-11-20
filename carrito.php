<?php
require_once __DIR__ . '/includes/bootstrap.php';
cart_handle_post();

page_meta(
    'Mi Carrito | ERRE Supermercado',
    'Revisá los productos de tu carrito, ajustá cantidades y finalizá tu compra en ERRE.'
);

$t = cart_totals();

require __DIR__ . '/includes/header.php';
render_page_header('Carrito', 'Carrito de compras');
?>

<div class="container page-content">
    <?php if (count($t['items']) === 0): ?>
        <div class="empty-state empty-cart">
            <span class="empty-icon"><?php echo icon('basket'); ?></span>
            <h2>Tu carrito está vacío</h2>
            <p>Sumá productos de nuestros catálogos para empezar.</p>
            <div class="empty-actions">
                <a class="btn btn-primary" href="comestibles.php">Comestibles</a>
                <a class="btn btn-soft" href="limpieza.php">Limpieza</a>
            </div>
        </div>
    <?php else: ?>
        <div class="cart-layout">
            <div class="cart-card">
                <div class="cart-head">
                    <span>Producto</span>
                    <span class="align-right">Precio unit.</span>
                    <span class="align-center">Cantidad</span>
                    <span class="align-right">Subtotal</span>
                    <span></span>
                </div>
                <ul class="cart-lines">
                    <?php foreach ($t['items'] as $item): ?>
                        <li class="cart-line">
                            <div class="cart-product">
                                <img src="<?php echo e($item['product']['image']); ?>" alt="">
                                <div>
                                    <a href="producto.php?slug=<?php echo e($item['slug']); ?>"><?php echo e($item['product']['name']); ?></a>
                                    <p class="muted small"><?php echo e($item['product']['brand']); ?> · <?php echo e($item['product']['unit']); ?></p>
                                    <p class="muted small cart-mobile-price"><?php echo format_price($item['product']['price']); ?> c/u</p>
                                </div>
                            </div>
                            <span class="cart-unit-price"><?php echo format_price($item['product']['price']); ?></span>
                            <div class="cart-qty">
                                <form method="post" action="carrito.php">
                                    <input type="hidden" name="action" value="update">
                                    <input type="hidden" name="slug" value="<?php echo e($item['slug']); ?>">
                                    <?php render_qty_stepper($item['slug'], $item['qty']); ?>
                                </form>
                                <strong class="cart-mobile-subtotal"><?php echo format_price($item['subtotal']); ?></strong>
                                <form method="post" action="carrito.php" class="cart-remove-mobile">
                                    <input type="hidden" name="action" value="remove">
                                    <input type="hidden" name="slug" value="<?php echo e($item['slug']); ?>">
                                    <button type="submit" class="icon-btn danger" aria-label="Quitar <?php echo e($item['product']['name']); ?>"><?php echo icon('trash'); ?></button>
                                </form>
                            </div>
                            <strong class="cart-subtotal"><?php echo format_price($item['subtotal']); ?></strong>
                            <form method="post" action="carrito.php" class="cart-remove">
                                <input type="hidden" name="action" value="remove">
                                <input type="hidden" name="slug" value="<?php echo e($item['slug']); ?>">
                                <button type="submit" class="icon-btn remove-btn" aria-label="Quitar <?php echo e($item['product']['name']); ?>"><?php echo icon('trash'); ?></button>
                            </form>
                        </li>
                    <?php endforeach; ?>
                </ul>
                <div class="cart-foot">
                    <a class="link" href="comestibles.php">← Seguir comprando</a>
                    <form method="post" action="carrito.php">
                        <input type="hidden" name="action" value="clear">
                        <button type="submit" class="link-btn">Vaciar carrito</button>
                    </form>
                </div>
            </div>

            <?php
            $checkout_button = '<a class="btn btn-primary btn-xl btn-block" href="checkout.php">Ir a Pagar ' . icon('arrow') . '</a>';
            render_order_summary(false, $checkout_button);
            ?>
        </div>
    <?php endif; ?>
</div>

<?php require __DIR__ . '/includes/footer.php'; ?>
