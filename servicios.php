<?php
require_once __DIR__ . '/includes/bootstrap.php';

page_meta(
    'Servicios: envíos, pagos y devoluciones | ERRE',
    'Conocé las políticas de envío a domicilio, los medios de pago aceptados y cómo hacer cambios y devoluciones en ERRE.'
);

$shipping = array(
    array('icon' => 'truck', 'title' => 'Envío a domicilio', 'text' => 'Costo fijo de ' . format_price(SHIPPING_COST) . ' y gratis en compras desde ' . format_price(FREE_SHIPPING_FROM) . '.'),
    array('icon' => 'pin', 'title' => 'Zonas de cobertura', 'text' => 'CABA y principales localidades de GBA Norte, Oeste y Sur.'),
    array('icon' => 'calendar', 'title' => 'Franjas horarias', 'text' => 'Elegí una franja de 2 horas, de lunes a sábado de 9 a 21 h.'),
    array('icon' => 'box-check', 'title' => 'Entrega en el día', 'text' => 'Los pedidos confirmados antes de las 13 h llegan ese mismo día.'),
);

$payments = array(
    array('icon' => 'card', 'title' => 'Tarjetas de crédito', 'text' => 'Visa, Mastercard y American Express. Hasta 3 cuotas sin interés.'),
    array('icon' => 'cash', 'title' => 'Tarjetas de débito', 'text' => 'Todas las tarjetas de débito de bancos argentinos.'),
    array('icon' => 'bank', 'title' => 'Transferencia', 'text' => 'Transferí a nuestro CBU y enviá el comprobante dentro de las 24 h.'),
    array('icon' => 'sparkles', 'title' => 'Billeteras virtuales', 'text' => 'Pagá con QR desde tu billetera favorita.'),
    array('icon' => 'cash', 'title' => 'Efectivo', 'text' => 'Abonás al recibir el pedido en tu domicilio.'),
);

$returns = array(
    array('icon' => 'rotate', 'title' => '48 horas para devolver', 'text' => 'Si un producto llegó dañado o vencido, te lo cambiamos sin costo.'),
    array('icon' => 'arrow', 'title' => 'Reintegro rápido', 'text' => 'Devolvemos el dinero al mismo medio de pago en hasta 5 días hábiles.'),
    array('icon' => 'shield', 'title' => 'Garantía de frescura', 'text' => 'Si una fruta o verdura no te convence, la reponemos en tu próxima compra.'),
);

function render_service_section($kicker, $title, $items)
{
    ?>
    <section class="service-section">
        <p class="eyebrow"><?php echo e($kicker); ?></p>
        <h2 class="section-title"><?php echo e($title); ?></h2>
        <ul class="services-grid">
            <?php foreach ($items as $item): ?>
                <li>
                    <span class="service-icon"><?php echo icon($item['icon']); ?></span>
                    <h3><?php echo e($item['title']); ?></h3>
                    <p><?php echo e($item['text']); ?></p>
                </li>
            <?php endforeach; ?>
        </ul>
    </section>
    <?php
}

require __DIR__ . '/includes/header.php';
render_page_header('Servicios', 'Servicios', 'Todo lo que necesitás saber sobre envíos, medios de pago y devoluciones.');
?>

<div class="container">
    <?php render_service_section('Llegamos a tu casa', 'Envíos a domicilio', $shipping); ?>
    <?php render_service_section('Pagá como quieras', 'Métodos de pago', $payments); ?>
    <?php render_service_section('Comprá tranquilo', 'Cambios y devoluciones', $returns); ?>

    <div class="contact-cta">
        <div>
            <h2>¿Tenés otra consulta?</h2>
            <p>Nuestro equipo te responde en menos de 24 horas.</p>
        </div>
        <a class="btn btn-highlight btn-lg" href="contacto.php">Escribinos</a>
    </div>
</div>

<?php require __DIR__ . '/includes/footer.php'; ?>
