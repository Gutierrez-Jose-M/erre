<?php
/** Catálogo estático de productos (equivalente a src/data/products.ts). */

$GLOBALS['erre_products'] = array(
    // Comestibles
    array(
        'slug' => 'leche-entera', 'name' => 'Leche Entera Larga Vida', 'brand' => 'La Pradera',
        'category' => 'comestibles', 'type' => 'Lácteos', 'price' => 1290, 'oldPrice' => 1490,
        'unit' => '1 L', 'image' => 'assets/img/products/leche-entera.jpg', 'featured' => true,
        'description' => 'Leche entera ultrapasteurizada, fuente natural de calcio y proteínas. Ideal para el desayuno, licuados y recetas de todos los días. Una vez abierta, conservar en heladera y consumir dentro de los 3 días.',
    ),
    array(
        'slug' => 'arroz-largo-fino', 'name' => 'Arroz Largo Fino', 'brand' => 'Don Grano',
        'category' => 'comestibles', 'type' => 'Almacén', 'price' => 1850, 'oldPrice' => null,
        'unit' => '1 kg', 'image' => 'assets/img/products/arroz-largo-fino.jpg', 'featured' => true,
        'description' => 'Arroz largo fino tipo 00000, de granos sueltos y cocción pareja en 18 minutos. Perfecto para guarniciones, ensaladas y risottos caseros.',
    ),
    array(
        'slug' => 'fideos-spaghetti', 'name' => 'Fideos Spaghetti', 'brand' => 'Nonna Bella',
        'category' => 'comestibles', 'type' => 'Almacén', 'price' => 990, 'oldPrice' => null,
        'unit' => '500 g', 'image' => 'assets/img/products/fideos-spaghetti.jpg', 'featured' => false,
        'description' => 'Spaghetti de sémola de trigo candeal, secado lento para una textura al dente. Cocción: 9 a 11 minutos en abundante agua con sal.',
    ),
    array(
        'slug' => 'aceite-girasol', 'name' => 'Aceite de Girasol', 'brand' => 'Campo Dorado',
        'category' => 'comestibles', 'type' => 'Almacén', 'price' => 2690, 'oldPrice' => 3150,
        'unit' => '1,5 L', 'image' => 'assets/img/products/aceite-girasol.jpg', 'featured' => true,
        'description' => 'Aceite puro de girasol, liviano y de sabor neutro. Rico en vitamina E, ideal para frituras, horneados y aderezos.',
    ),
    array(
        'slug' => 'yerba-mate', 'name' => 'Yerba Mate Tradicional', 'brand' => 'Monte Verde',
        'category' => 'comestibles', 'type' => 'Infusiones', 'price' => 3990, 'oldPrice' => null,
        'unit' => '1 kg', 'image' => 'assets/img/products/yerba-mate.jpg', 'featured' => false,
        'description' => 'Yerba mate con palo, elaborada con estacionamiento natural de 12 meses. Sabor intenso y duradero, de rendimiento excepcional.',
    ),
    array(
        'slug' => 'cafe-molido', 'name' => 'Café Molido Intenso', 'brand' => 'Tostadero Sur',
        'category' => 'comestibles', 'type' => 'Infusiones', 'price' => 4590, 'oldPrice' => 5100,
        'unit' => '250 g', 'image' => 'assets/img/products/cafe-molido.jpg', 'featured' => false,
        'description' => 'Blend de granos arábica y robusta tostados en el día. Molienda media apta para cafetera de filtro, italiana y prensa francesa.',
    ),
    array(
        'slug' => 'galletitas-dulces', 'name' => 'Galletitas Dulces de Vainilla', 'brand' => 'Doña Clara',
        'category' => 'comestibles', 'type' => 'Desayuno', 'price' => 1150, 'oldPrice' => null,
        'unit' => '200 g', 'image' => 'assets/img/products/galletitas-dulces.jpg', 'featured' => false,
        'description' => 'Galletitas crocantes con suave sabor a vainilla. El acompañamiento perfecto para el mate o el café con leche.',
    ),
    array(
        'slug' => 'pan-lactal', 'name' => 'Pan Lactal Blanco', 'brand' => 'Horno Feliz',
        'category' => 'comestibles', 'type' => 'Panadería', 'price' => 2350, 'oldPrice' => null,
        'unit' => '550 g', 'image' => 'assets/img/products/pan-lactal.jpg', 'featured' => false,
        'description' => 'Pan de molde tierno y esponjoso, rebanado. Sin grasas trans. Ideal para tostadas y sándwiches.',
    ),
    array(
        'slug' => 'tomate-triturado', 'name' => 'Tomate Triturado', 'brand' => 'Huerta Real',
        'category' => 'comestibles', 'type' => 'Almacén', 'price' => 890, 'oldPrice' => null,
        'unit' => '520 g', 'image' => 'assets/img/products/tomate-triturado.jpg', 'featured' => false,
        'description' => 'Tomates seleccionados y triturados, listos para salsas, guisos y pizzas. Sin conservantes agregados.',
    ),
    array(
        'slug' => 'dulce-de-leche', 'name' => 'Dulce de Leche Clásico', 'brand' => 'La Pradera',
        'category' => 'comestibles', 'type' => 'Desayuno', 'price' => 2190, 'oldPrice' => null,
        'unit' => '400 g', 'image' => 'assets/img/products/dulce-de-leche.jpg', 'featured' => false,
        'description' => 'Dulce de leche tradicional, cremoso y de color dorado intenso. Para untar, rellenar y disfrutar a cucharadas.',
    ),
    array(
        'slug' => 'manzanas-rojas', 'name' => 'Manzanas Rojas', 'brand' => 'Valle Frutal',
        'category' => 'comestibles', 'type' => 'Frutas y Verduras', 'price' => 1690, 'oldPrice' => null,
        'unit' => '1 kg', 'image' => 'assets/img/products/manzanas-rojas.jpg', 'featured' => true,
        'description' => 'Manzanas rojas frescas del Alto Valle de Río Negro. Crocantes, dulces y jugosas. Se venden por kilo.',
    ),
    array(
        'slug' => 'queso-cremoso', 'name' => 'Queso Cremoso', 'brand' => 'Tambo Viejo',
        'category' => 'comestibles', 'type' => 'Lácteos', 'price' => 6890, 'oldPrice' => 7650,
        'unit' => '500 g', 'image' => 'assets/img/products/queso-cremoso.jpg', 'featured' => false,
        'description' => 'Queso cremoso de pasta blanda y sabor suave. Excelente para fundir en pizzas, tartas y sándwiches calientes.',
    ),
    // Limpieza
    array(
        'slug' => 'detergente-lavavajillas', 'name' => 'Detergente Lavavajillas Limón', 'brand' => 'Brillo',
        'category' => 'limpieza', 'type' => 'Cocina', 'price' => 1490, 'oldPrice' => 1790,
        'unit' => '750 ml', 'image' => 'assets/img/products/detergente-lavavajillas.jpg', 'featured' => true,
        'description' => 'Detergente concentrado con aroma a limón. Remueve la grasa más difícil y cuida tus manos. Rinde hasta 3 veces más.',
    ),
    array(
        'slug' => 'lavandina', 'name' => 'Lavandina Concentrada', 'brand' => 'Blancura',
        'category' => 'limpieza', 'type' => 'Desinfección', 'price' => 1290, 'oldPrice' => null,
        'unit' => '2 L', 'image' => 'assets/img/products/lavandina.jpg', 'featured' => true,
        'description' => 'Lavandina de uso general que elimina el 99,9% de gérmenes y bacterias. Diluir según indicaciones. Mantener fuera del alcance de los niños.',
    ),
    array(
        'slug' => 'jabon-liquido-ropa', 'name' => 'Jabón Líquido para Ropa', 'brand' => 'Nube',
        'category' => 'limpieza', 'type' => 'Lavado', 'price' => 7990, 'oldPrice' => 9200,
        'unit' => '3 L', 'image' => 'assets/img/products/jabon-liquido-ropa.jpg', 'featured' => true,
        'description' => 'Jabón líquido para lavarropas automático y a mano. Fórmula con enzimas que remueve manchas desde el primer lavado.',
    ),
    array(
        'slug' => 'limpiador-multiuso', 'name' => 'Limpiador Multiuso Gatillo', 'brand' => 'Brillo',
        'category' => 'limpieza', 'type' => 'Superficies', 'price' => 1890, 'oldPrice' => null,
        'unit' => '500 ml', 'image' => 'assets/img/products/limpiador-multiuso.jpg', 'featured' => false,
        'description' => 'Limpiador multisuperficie en spray para vidrios, mesadas y azulejos. No deja marcas ni residuos.',
    ),
    array(
        'slug' => 'papel-higienico', 'name' => 'Papel Higiénico Doble Hoja', 'brand' => 'Suavecito',
        'category' => 'limpieza', 'type' => 'Higiene', 'price' => 2490, 'oldPrice' => null,
        'unit' => '4 rollos x 30 m', 'image' => 'assets/img/products/papel-higienico.jpg', 'featured' => true,
        'description' => 'Papel higiénico de doble hoja, suave y resistente. Pack de 4 rollos de 30 metros cada uno.',
    ),
    array(
        'slug' => 'esponjas', 'name' => 'Esponjas Doble Uso', 'brand' => 'Brillo',
        'category' => 'limpieza', 'type' => 'Cocina', 'price' => 990, 'oldPrice' => null,
        'unit' => 'Pack x 3', 'image' => 'assets/img/products/esponjas.jpg', 'featured' => false,
        'description' => 'Esponjas con cara abrasiva verde para ollas y cara suave para vajilla delicada. Pack x 3 unidades.',
    ),
    array(
        'slug' => 'desodorante-ambientes', 'name' => 'Desodorante de Ambientes Lavanda', 'brand' => 'Aroma Hogar',
        'category' => 'limpieza', 'type' => 'Ambientes', 'price' => 1690, 'oldPrice' => null,
        'unit' => '360 ml', 'image' => 'assets/img/products/desodorante-ambientes.jpg', 'featured' => false,
        'description' => 'Aerosol con fragancia de lavanda que neutraliza olores y deja una sensación de frescura duradera.',
    ),
    array(
        'slug' => 'suavizante', 'name' => 'Suavizante para Ropa', 'brand' => 'Nube',
        'category' => 'limpieza', 'type' => 'Lavado', 'price' => 2290, 'oldPrice' => null,
        'unit' => '1 L', 'image' => 'assets/img/products/suavizante.jpg', 'featured' => false,
        'description' => 'Suavizante concentrado con aroma floral. Deja la ropa suave, perfumada y fácil de planchar.',
    ),
    array(
        'slug' => 'shampoo', 'name' => 'Shampoo Nutrición', 'brand' => 'Natura Fresh',
        'category' => 'limpieza', 'type' => 'Higiene', 'price' => 3290, 'oldPrice' => 3790,
        'unit' => '400 ml', 'image' => 'assets/img/products/shampoo.jpg', 'featured' => false,
        'description' => 'Shampoo con extractos naturales para todo tipo de cabello. Limpia suavemente y aporta brillo.',
    ),
    array(
        'slug' => 'jabon-tocador', 'name' => 'Jabón de Tocador Neutro', 'brand' => 'Natura Fresh',
        'category' => 'limpieza', 'type' => 'Higiene', 'price' => 1590, 'oldPrice' => null,
        'unit' => '3 x 90 g', 'image' => 'assets/img/products/jabon-tocador.jpg', 'featured' => false,
        'description' => 'Jabón de tocador neutro, hipoalergénico y con glicerina. Pack de 3 unidades de 90 g.',
    ),
    array(
        'slug' => 'limpiador-pisos', 'name' => 'Limpiador de Pisos Lavanda', 'brand' => 'Aroma Hogar',
        'category' => 'limpieza', 'type' => 'Superficies', 'price' => 1990, 'oldPrice' => null,
        'unit' => '1,8 L', 'image' => 'assets/img/products/limpiador-pisos.jpg', 'featured' => false,
        'description' => 'Limpiador líquido para todo tipo de pisos. Perfuma por horas y no requiere enjuague.',
    ),
    array(
        'slug' => 'bolsas-residuos', 'name' => 'Bolsas de Residuos Reforzadas', 'brand' => 'Fuerte',
        'category' => 'limpieza', 'type' => 'Hogar', 'price' => 1390, 'oldPrice' => null,
        'unit' => 'Rollo x 30', 'image' => 'assets/img/products/bolsas-residuos.jpg', 'featured' => false,
        'description' => 'Bolsas de residuos de 50 x 70 cm, reforzadas y resistentes a desgarros. Rollo de 30 unidades.',
    ),
);

/** Todos los productos. */
function get_products()
{
    return $GLOBALS['erre_products'];
}

/** Busca un producto por slug; devuelve null si no existe. */
function get_product($slug)
{
    foreach ($GLOBALS['erre_products'] as $product) {
        if ($product['slug'] === $slug) {
            return $product;
        }
    }
    return null;
}

/** Productos de una categoría. */
function get_products_by_category($category)
{
    $out = array();
    foreach ($GLOBALS['erre_products'] as $product) {
        if ($product['category'] === $category) {
            $out[] = $product;
        }
    }
    return $out;
}

/** Productos destacados: 4 de comestibles y 4 de limpieza. */
function get_featured()
{
    $featured = array();
    foreach ($GLOBALS['erre_products'] as $product) {
        if (!empty($product['featured'])) {
            $featured[] = $product;
        }
    }
    $food = array();
    $cleaning = array();
    foreach ($featured as $product) {
        if ($product['category'] === 'comestibles' && count($food) < 4) {
            $food[] = $product;
        }
        if ($product['category'] === 'limpieza' && count($cleaning) < 4) {
            $cleaning[] = $product;
        }
    }
    return array_merge($food, $cleaning);
}

/** Porcentaje de descuento de un producto. */
function discount_percent($product)
{
    if (empty($product['oldPrice'])) {
        return 0;
    }
    return (int) round((1 - $product['price'] / $product['oldPrice']) * 100);
}

/** Busca productos por nombre, marca o tipo. */
function search_products($query)
{
    $q = normalize_text($query);
    if (strlen($q) < 2) {
        return array();
    }
    $out = array();
    foreach ($GLOBALS['erre_products'] as $product) {
        $haystack = normalize_text($product['name'] . ' ' . $product['brand'] . ' ' . $product['type']);
        if (strpos($haystack, $q) !== false) {
            $out[] = $product;
        }
    }
    return $out;
}

/** Convierte una fila de MySQL al formato que usa la tienda. */
function product_from_row($row)
{
    return array(
        'id' => (int) $row['id'],
        'slug' => $row['slug'],
        'name' => $row['nombre'],
        'description' => $row['descripcion'],
        'brand' => $row['marca'],
        'category' => $row['categoria'],
        'type' => $row['tipo'],
        'price' => (float) $row['precio'],
        'oldPrice' => $row['old_price'] === null ? null : (float) $row['old_price'],
        'unit' => $row['unidad'],
        'image' => $row['imagen'],
        'featured' => (bool) $row['destacado'],
    );
}

/**
 * Carga el catálogo desde MySQL (TP7). Si no hay BD o falla la consulta,
 * se mantiene el catálogo estático para que el sitio siga funcionando.
 */
function products_load_from_db()
{
    $pdo = db();
    if (!$pdo) {
        return false;
    }

    try {
        $sql = 'SELECT p.id, p.slug, p.nombre, p.descripcion, p.tipo, p.precio,
                       p.old_price, p.unidad, p.imagen, p.destacado,
                       m.nombre AS marca, c.slug AS categoria
                FROM productos p
                INNER JOIN marcas m ON m.id = p.marca_id
                INNER JOIN categorias c ON c.id = p.categoria_id
                WHERE p.activo = 1
                ORDER BY p.id ASC';
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $rows = $stmt->fetchAll();
        if (count($rows) === 0) {
            return false;
        }
        $productos = array();
        foreach ($rows as $row) {
            $productos[] = product_from_row($row);
        }
        $GLOBALS['erre_products'] = $productos;
        return true;
    } catch (PDOException $e) {
        $GLOBALS['erre_db_error'] = $e->getMessage();
        return false;
    }
}

products_load_from_db();
