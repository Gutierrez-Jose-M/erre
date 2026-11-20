<?php
require_once __DIR__ . '/includes/bootstrap.php';

page_meta(
    'Finalizar compra | ERRE Supermercado',
    'Completá tus datos de envío y pago para recibir tu pedido de ERRE.'
);

$step = 0;
$method = 'tarjeta';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = post_string('step');
    if ($action === 'next') {
        $step = 1;
        $method = one_of(post_string('method', 'tarjeta'), array('tarjeta', 'transferencia', 'efectivo'), 'tarjeta');
        $_SESSION['checkout_shipping'] = array(
            'nombre' => post_string('nombre'),
            'apellido' => post_string('apellido'),
            'email' => post_string('email'),
            'telefono' => post_string('telefono'),
            'direccion' => post_string('direccion'),
            'piso' => post_string('piso'),
            'cp' => post_string('cp'),
            'localidad' => post_string('localidad'),
            'franja' => post_string('franja'),
        );
    } elseif ($action === 'back') {
        $step = 0;
        $method = one_of(post_string('method', 'tarjeta'), array('tarjeta', 'transferencia', 'efectivo'), 'tarjeta');
    } elseif ($action === 'pay') {
        $totals = cart_totals();
        if ($totals['count'] === 0) {
            redirect('checkout.php');
        }
        $method = one_of(post_string('method', 'tarjeta'), array('tarjeta', 'transferencia', 'efectivo'), 'tarjeta');
        $envio = isset($_SESSION['checkout_shipping']) ? $_SESSION['checkout_shipping'] : array();
        $order = order_place($totals['count'], $totals['total'], $method, $envio);
        $order['shipping'] = isset($_SESSION['checkout_shipping']) ? $_SESSION['checkout_shipping'] : array();
        $_SESSION['last_order'] = $order;
        unset($_SESSION['checkout_shipping']);
        cart_clear();
        redirect('checkout.php?done=1');
    }
}

$completed = (get_string('done') === '1' && isset($_SESSION['last_order'])) ? $_SESSION['last_order'] : null;
$t = cart_totals();

require __DIR__ . '/includes/header.php';

if ($completed):
    ?>
    <div class="container page-content">
        <div class="confirmation">
            <span class="confirmation-icon"><?php echo icon('party'); ?></span>
            <h1>¡Gracias por tu compra!</h1>
            <p>
                Tu pedido <strong><?php echo e($completed['id']); ?></strong> por <?php echo format_price($completed['total']); ?>
                fue confirmado. Te avisaremos cuando salga para tu domicilio.
            </p>
            <div class="confirmation-actions">
                <a class="btn btn-primary" href="perfil.php">Ver mis pedidos</a>
                <a class="btn btn-soft" href="index.php">Volver al inicio</a>
            </div>
        </div>
    </div>
    <?php
elseif ($t['count'] === 0):
    ?>
    <div class="container empty-page">
        <h1>No hay productos para pagar</h1>
        <p>Agregá productos al carrito antes de finalizar la compra.</p>
        <a class="btn btn-primary" href="comestibles.php">Ir a comprar</a>
    </div>
    <?php
else:
    $steps = array('Datos de Envío', 'Datos de Pago');
    ?>
    <?php
    $extra = '<ol class="checkout-steps">';
    foreach ($steps as $i => $label) {
        $state = $i === $step ? 'current' : ($i < $step ? 'done' : 'todo');
        $extra .= '<li class="' . $state . '"><span class="step-number">'
            . ($i < $step ? icon('check') : ($i + 1)) . '</span> ' . e($label) . '</li>';
        if ($i < count($steps) - 1) {
            $extra .= '<li class="step-line"></li>';
        }
    }
    $extra .= '</ol>';
    render_page_header('Checkout', 'Finalizar compra', '', $extra);
    ?>

    <div class="container checkout-layout">
        <div class="checkout-form-card">
            <?php if ($step === 0): ?>
                <form method="post" action="checkout.php" class="form-stack">
                    <input type="hidden" name="step" value="next">
                    <h2>1. ¿Dónde te lo llevamos?</h2>
                    <div class="form-grid">
                        <?php
                        $shipping = isset($_SESSION['checkout_shipping']) ? $_SESSION['checkout_shipping'] : array();
                        $fields = array(
                            array('nombre', 'Nombre', 'text', 'given-name', false, ''),
                            array('apellido', 'Apellido', 'text', 'family-name', false, ''),
                            array('email', 'Email', 'email', 'email', false, ''),
                            array('telefono', 'Teléfono', 'tel', 'tel', false, ''),
                            array('direccion', 'Calle y número', 'text', 'street-address', false, 'wide'),
                            array('piso', 'Piso / Depto (opcional)', 'text', '', true, ''),
                            array('cp', 'Código postal', 'text', 'postal-code', false, ''),
                            array('localidad', 'Localidad', 'text', 'address-level2', false, 'wide'),
                        );
                        foreach ($fields as $f):
                            $value = isset($shipping[$f[0]]) ? $shipping[$f[0]] : '';
                            ?>
                            <div class="field <?php echo $f[5] === 'wide' ? 'field-wide' : ''; ?>">
                                <label for="<?php echo e($f[0]); ?>"><?php echo e($f[1]); ?></label>
                                <input id="<?php echo e($f[0]); ?>" name="<?php echo e($f[0]); ?>" type="<?php echo e($f[2]); ?>"
                                    <?php echo $f[3] !== '' ? 'autocomplete="' . e($f[3]) . '"' : ''; ?>
                                    <?php echo $f[4] ? '' : 'required'; ?> value="<?php echo e($value); ?>">
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="field">
                        <label for="franja">Franja horaria de entrega</label>
                        <select id="franja" name="franja">
                            <option>Hoy · 16 a 18 h</option>
                            <option>Hoy · 18 a 20 h</option>
                            <option>Mañana · 9 a 11 h</option>
                            <option>Mañana · 11 a 13 h</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary btn-xl">Continuar al pago</button>
                </form>
            <?php else: ?>
                <form method="post" action="checkout.php" class="form-stack">
                    <input type="hidden" name="step" value="pay">
                    <h2>2. ¿Cómo querés pagar?</h2>
                    <div class="payment-methods">
                        <?php
                        $methods = array(
                            array('tarjeta', 'Tarjeta', 'card'),
                            array('transferencia', 'Transferencia', 'bank'),
                            array('efectivo', 'Efectivo al recibir', 'cash'),
                        );
                        foreach ($methods as $m):
                            ?>
                            <label class="payment-option <?php echo $method === $m[0] ? 'selected' : ''; ?>">
                                <input type="radio" name="method" value="<?php echo e($m[0]); ?>" <?php echo $method === $m[0] ? 'checked' : ''; ?>>
                                <?php echo icon($m[2]); ?>
                                <span><?php echo e($m[1]); ?></span>
                            </label>
                        <?php endforeach; ?>
                    </div>

                    <div class="payment-extra" data-method="tarjeta" <?php echo $method === 'tarjeta' ? '' : 'hidden'; ?>>
                        <div class="form-grid">
                            <div class="field field-wide"><label for="titular">Nombre del titular</label><input id="titular" name="titular" autocomplete="cc-name"></div>
                            <div class="field field-wide"><label for="numero">Número de tarjeta</label><input id="numero" name="numero" inputmode="numeric" placeholder="0000 0000 0000 0000" autocomplete="cc-number"></div>
                            <div class="field"><label for="vencimiento">Vencimiento</label><input id="vencimiento" name="vencimiento" placeholder="MM/AA" autocomplete="cc-exp"></div>
                            <div class="field"><label for="cvv">Código de seguridad</label><input id="cvv" name="cvv" inputmode="numeric" placeholder="123" autocomplete="cc-csc"></div>
                        </div>
                    </div>
                    <div class="payment-note" data-method="transferencia" <?php echo $method === 'transferencia' ? '' : 'hidden'; ?>>
                        Al confirmar te mostraremos el CBU/alias de ERRE. Tenés 24 h para enviar el comprobante.
                    </div>
                    <div class="payment-note" data-method="efectivo" <?php echo $method === 'efectivo' ? '' : 'hidden'; ?>>
                        Pagás al repartidor cuando recibís el pedido. Te recomendamos tener el importe justo.
                    </div>

                    <div class="form-actions">
                        <button type="submit" name="step" value="back" class="btn btn-outline btn-lg" formnovalidate>Volver</button>
                        <button type="submit" class="btn btn-primary btn-xl">
                            <?php echo icon('lock'); ?> Confirmar y pagar <?php echo format_price($t['total']); ?>
                        </button>
                    </div>
                </form>
            <?php endif; ?>
        </div>

        <?php render_order_summary(true); ?>
    </div>
    <?php
endif;

require __DIR__ . '/includes/footer.php';
