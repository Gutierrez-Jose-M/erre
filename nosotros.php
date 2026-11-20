<?php
require_once __DIR__ . '/includes/bootstrap.php';

page_meta(
    'Nosotros | La historia de ERRE Supermercado',
    'Desde 1998 ERRE acompaña a las familias del barrio. Conocé nuestra historia, nuestros valores y cómo llegamos a tu casa.'
);

$milestones = array(
    array('year' => '1998', 'text' => 'Abrimos nuestro primer almacén de barrio en Almagro, con 4 góndolas y mucha ilusión.'),
    array('year' => '2008', 'text' => 'Nos convertimos en supermercado y sumamos frutas, verduras y panadería propia.'),
    array('year' => '2016', 'text' => 'Inauguramos dos sucursales más y el primer servicio de envío telefónico.'),
    array('year' => '2024', 'text' => 'Lanzamos la tienda online de ERRE para llegar a toda la ciudad.'),
);

$values = array(
    array('icon' => 'leaf', 'title' => 'Frescura', 'text' => 'Trabajamos con productores locales y reponemos todos los días.'),
    array('icon' => 'heart', 'title' => 'Confianza', 'text' => 'Precios claros, sin letra chica y atención cercana.'),
    array('icon' => 'users', 'title' => 'Comunidad', 'text' => 'Más de 80 vecinos forman parte de nuestro equipo.'),
    array('icon' => 'store', 'title' => 'Cercanía', 'text' => 'El trato del almacén de siempre, con la comodidad de lo online.'),
);

require __DIR__ . '/includes/header.php';
render_page_header('Nosotros', 'Somos ERRE', 'Un supermercado de barrio que creció junto a sus vecinos.');
?>

<section class="container about-intro">
    <img src="assets/img/nosotros-tienda.jpg" alt="Interior del supermercado ERRE con frutas y verduras frescas" loading="lazy" width="1600" height="1008">
    <div>
        <h2 class="section-title">Nuestra historia</h2>
        <p>ERRE nació en 1998 como un pequeño almacén familiar en el corazón de Almagro. El nombre viene de la inicial de sus fundadores, Roberto y Rosa, que soñaban con un lugar donde los vecinos encontraran todo lo necesario para su casa, con precios justos y una sonrisa.</p>
        <p>Hoy somos un supermercado moderno con tres sucursales y una tienda online, pero seguimos eligiendo cada producto como si fuera para nuestra propia mesa.</p>
    </div>
</section>

<section class="about-band">
    <div class="container">
        <h2 class="section-title">Nuestro recorrido</h2>
        <ol class="timeline">
            <?php foreach ($milestones as $m): ?>
                <li><strong><?php echo e($m['year']); ?></strong><p><?php echo e($m['text']); ?></p></li>
            <?php endforeach; ?>
        </ol>
    </div>
</section>

<section class="container section-block">
    <h2 class="section-title">Lo que nos mueve</h2>
    <ul class="values-grid">
        <?php foreach ($values as $v): ?>
            <li class="value-card">
                <span class="value-icon"><?php echo icon($v['icon']); ?></span>
                <h3><?php echo e($v['title']); ?></h3>
                <p><?php echo e($v['text']); ?></p>
            </li>
        <?php endforeach; ?>
    </ul>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>
