<?php
require_once __DIR__ . '/includes/bootstrap.php';

page_meta(
    'ERRE Supermercado | Comestibles y limpieza a domicilio',
    'Ofertas semanales en almacén, lácteos, frutas y artículos de limpieza. Comprá online en ERRE y recibí en tu casa.'
);

$featured = get_featured();
$food = array();
$cleaning = array();
foreach ($featured as $p) {
    if ($p['category'] === 'comestibles') {
        $food[] = $p;
    } else {
        $cleaning[] = $p;
    }
}

$categories = array(
    array('label' => 'Almacén', 'icon' => 'wheat', 'url' => 'comestibles.php'),
    array('label' => 'Desayuno', 'icon' => 'coffee', 'url' => 'comestibles.php'),
    array('label' => 'Limpieza', 'icon' => 'spray', 'url' => 'limpieza.php'),
    array('label' => 'Lavado', 'icon' => 'shirt', 'url' => 'limpieza.php'),
    array('label' => 'Higiene', 'icon' => 'sparkles', 'url' => 'limpieza.php'),
);

$perks = array(
    array('icon' => 'truck', 'title' => 'Envío en el día', 'text' => 'Pedí antes de las 13 h'),
    array('icon' => 'percent', 'title' => 'Ofertas semanales', 'text' => 'Hasta 20% off'),
    array('icon' => 'shield', 'title' => 'Compra segura', 'text' => 'Pagos protegidos'),
    array('icon' => 'clock', 'title' => 'Elegí tu horario', 'text' => 'Franjas de 2 horas'),
);

require __DIR__ . '/includes/header.php';
?>

<section class="container hero-section">
    <div class="hero">
        <img class="hero-image" src="assets/img/hero-erre.jpg" alt="Canasta con frutas, verduras, pan, leche y productos de limpieza" width="1920" height="800">
        <div class="hero-fade"></div>
        <div class="hero-content">
            <span class="hero-badge"><?php echo icon('percent'); ?> Semana del ahorro</span>
            <h1>Lo fresco de siempre, <span class="text-primary">hasta 20% off</span></h1>
            <p>Llenamos tu heladera y tu alacena sin que salgas de casa. Envío gratis desde $30.000.</p>
            <div class="hero-actions">
                <a class="btn btn-primary btn-lg" href="comestibles.php">Ver comestibles <?php echo icon('arrow'); ?></a>
                <a class="btn btn-outline btn-lg" href="limpieza.php">Ofertas en limpieza</a>
            </div>
        </div>
    </div>
</section>

<section class="container perks">
    <ul class="perks-grid">
        <?php foreach ($perks as $perk): ?>
            <li>
                <span class="perk-icon"><?php echo icon($perk['icon']); ?></span>
                <span>
                    <strong><?php echo e($perk['title']); ?></strong>
                    <small><?php echo e($perk['text']); ?></small>
                </span>
            </li>
        <?php endforeach; ?>
    </ul>
</section>

<section class="container section-block">
    <h2 class="section-title">Categorías destacadas</h2>
    <ul class="category-grid">
        <?php foreach ($categories as $category): ?>
            <li>
                <a class="category-item" href="<?php echo e($category['url']); ?>">
                    <span class="category-icon"><?php echo icon($category['icon']); ?></span>
                    <span><?php echo e($category['label']); ?></span>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
</section>

<section class="container section-block">
    <div class="section-heading">
        <div>
            <p class="eyebrow">Almacén y frescos</p>
            <h2 class="section-title">Comestibles destacados</h2>
        </div>
        <a class="see-all" href="comestibles.php">Ver todos <?php echo icon('arrow'); ?></a>
    </div>
    <div class="product-grid">
        <?php foreach ($food as $product): ?>
            <?php render_product_card($product); ?>
        <?php endforeach; ?>
    </div>
</section>

<section class="container section-block">
    <div class="promo-grid">
        <div class="promo">
            <p class="eyebrow">Solo online</p>
            <h3>2x1 en lácteos seleccionados</h3>
            <p>Todos los miércoles, en leches, yogures y quesos.</p>
            <a class="btn btn-highlight" href="comestibles.php">Aprovechar</a>
        </div>
        <div class="deal">
            <p class="eyebrow">Hogar impecable</p>
            <h3>3x2 en limpieza de la casa</h3>
            <p>Detergentes, lavandinas y limpiadores de pisos.</p>
            <a class="btn btn-deep" href="limpieza.php">Ver productos</a>
        </div>
    </div>
</section>

<section class="container section-block">
    <div class="section-heading">
        <div>
            <p class="eyebrow">Hogar y cuidado</p>
            <h2 class="section-title">Limpieza destacada</h2>
        </div>
        <a class="see-all" href="limpieza.php">Ver todos <?php echo icon('arrow'); ?></a>
    </div>
    <div class="product-grid">
        <?php foreach ($cleaning as $product): ?>
            <?php render_product_card($product); ?>
        <?php endforeach; ?>
    </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>
