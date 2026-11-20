<?php
/** Vista del catálogo (TP10, parte A: MVC nativo). */

$brands = array();
$types = array();
foreach ($items as $product) {
    $brands[$product['brand']] = true;
    $types[$product['type']] = true;
}
$brands = array_keys($brands);
$types = array_keys($types);
sort($brands, SORT_STRING);
sort($types, SORT_STRING);

$highest = 500;
foreach ($items as $product) {
    if ($product['price'] > $highest) {
        $highest = $product['price'];
    }
}
$max_price = (int) (ceil($highest / 500) * 500);

$sel_brands = isset($_GET['brand']) && is_array($_GET['brand']) ? array_values(array_filter($_GET['brand'], 'is_string')) : array();
$sel_types = isset($_GET['type']) && is_array($_GET['type']) ? array_values(array_filter($_GET['type'], 'is_string')) : array();
$price = isset($_GET['price']) ? (int) $_GET['price'] : $max_price;
if ($price < 500 || $price > $max_price) {
    $price = $max_price;
}
$only_deals = isset($_GET['deals']) && $_GET['deals'] === '1';
$sort = one_of(isset($_GET['sort']) ? $_GET['sort'] : '', array('relevancia', 'menor', 'mayor', 'ofertas'), 'relevancia');

$filtered = array();
foreach ($items as $product) {
    if (count($sel_brands) > 0 && !in_array($product['brand'], $sel_brands, true)) {
        continue;
    }
    if (count($sel_types) > 0 && !in_array($product['type'], $sel_types, true)) {
        continue;
    }
    if ($product['price'] > $price) {
        continue;
    }
    if ($only_deals && !$product['oldPrice']) {
        continue;
    }
    $filtered[] = $product;
}

if ($sort === 'menor') {
    usort($filtered, function ($a, $b) { return $a['price'] - $b['price']; });
} elseif ($sort === 'mayor') {
    usort($filtered, function ($a, $b) { return $b['price'] - $a['price']; });
} elseif ($sort === 'ofertas') {
    usort($filtered, function ($a, $b) { return (int) (bool) $b['oldPrice'] - (int) (bool) $a['oldPrice']; });
}

$active_count = count($sel_brands) + count($sel_types) + ($price < $max_price ? 1 : 0) + ($only_deals ? 1 : 0);
$base_url = $catalog_category === 'comestibles' ? 'comestibles.php' : 'limpieza.php';

require __DIR__ . '/../../includes/header.php';
render_page_header($catalog_crumb, $catalog_title, $catalog_subtitle);
?>

<div class="container catalog-layout">
    <button type="button" class="btn btn-outline filter-toggle" id="filterToggle">
        <?php echo icon('sliders'); ?> Filtros <?php echo $active_count > 0 ? '(' . $active_count . ')' : ''; ?>
    </button>

    <aside class="filters" id="filtersPanel" hidden>
        <form method="get" action="<?php echo e($base_url); ?>" class="filters-card">
            <div class="filters-head">
                <h2>Filtros</h2>
                <?php if ($active_count > 0): ?>
                    <a class="link" href="<?php echo e($base_url); ?>">Limpiar (<?php echo $active_count; ?>)</a>
                <?php endif; ?>
            </div>

            <fieldset class="filter-group">
                <legend><?php echo e($catalog_type_label); ?></legend>
                <?php foreach ($types as $type): ?>
                    <label class="check-row">
                        <input type="checkbox" name="type[]" value="<?php echo e($type); ?>" <?php echo in_array($type, $sel_types, true) ? 'checked' : ''; ?>>
                        <span><?php echo e($type); ?></span>
                    </label>
                <?php endforeach; ?>
            </fieldset>

            <div class="filter-group">
                <h3>Precio máximo</h3>
                <input type="range" name="price" min="500" max="<?php echo $max_price; ?>" step="100" value="<?php echo $price; ?>" id="priceRange">
                <div class="range-labels">
                    <span><?php echo format_price(500); ?></span>
                    <strong id="priceLabel"><?php echo format_price($price); ?></strong>
                </div>
            </div>

            <fieldset class="filter-group">
                <legend>Marca</legend>
                <?php foreach ($brands as $brand): ?>
                    <label class="check-row">
                        <input type="checkbox" name="brand[]" value="<?php echo e($brand); ?>" <?php echo in_array($brand, $sel_brands, true) ? 'checked' : ''; ?>>
                        <span><?php echo e($brand); ?></span>
                    </label>
                <?php endforeach; ?>
            </fieldset>

            <label class="check-row deals-row">
                <input type="checkbox" name="deals" value="1" <?php echo $only_deals ? 'checked' : ''; ?>>
                <span><strong>Solo ofertas</strong></span>
            </label>

            <?php if ($sort !== 'relevancia'): ?>
                <input type="hidden" name="sort" value="<?php echo e($sort); ?>">
            <?php endif; ?>
            <button type="submit" class="btn btn-primary btn-block">Aplicar filtros</button>
        </form>
    </aside>

    <div class="catalog-results">
        <div class="catalog-toolbar">
            <p><strong><?php echo count($filtered); ?></strong> productos</p>
            <form method="get" action="<?php echo e($base_url); ?>" class="sort-form">
                <?php foreach ($sel_types as $type): ?>
                    <input type="hidden" name="type[]" value="<?php echo e($type); ?>">
                <?php endforeach; ?>
                <?php foreach ($sel_brands as $brand): ?>
                    <input type="hidden" name="brand[]" value="<?php echo e($brand); ?>">
                <?php endforeach; ?>
                <input type="hidden" name="price" value="<?php echo $price; ?>">
                <?php if ($only_deals): ?>
                    <input type="hidden" name="deals" value="1">
                <?php endif; ?>
                <label>
                    <span class="hide-sm">Ordenar por</span>
                    <select name="sort" onchange="this.form.submit()">
                        <option value="relevancia" <?php echo $sort === 'relevancia' ? 'selected' : ''; ?>>Relevancia</option>
                        <option value="menor" <?php echo $sort === 'menor' ? 'selected' : ''; ?>>Menor precio</option>
                        <option value="mayor" <?php echo $sort === 'mayor' ? 'selected' : ''; ?>>Mayor precio</option>
                        <option value="ofertas" <?php echo $sort === 'ofertas' ? 'selected' : ''; ?>>Ofertas primero</option>
                    </select>
                </label>
            </form>
        </div>

        <?php if (count($filtered) === 0): ?>
            <div class="empty-state">
                <p>No hay productos con esos filtros.</p>
                <a class="btn btn-soft" href="<?php echo e($base_url); ?>">Limpiar filtros</a>
            </div>
        <?php else: ?>
            <div class="product-grid">
                <?php foreach ($filtered as $product): ?>
                    <?php render_product_card($product); ?>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php require __DIR__ . '/../../includes/footer.php'; ?>

