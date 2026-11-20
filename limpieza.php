<?php
require_once __DIR__ . '/includes/bootstrap.php';

page_meta(
    'Limpieza e Higiene | ERRE Supermercado',
    'Detergentes, lavandinas, jabones, papel higiénico y más artículos de limpieza e higiene personal.'
);

$catalog_category = 'limpieza';
$catalog_crumb = 'Limpieza';
$catalog_title = 'Catálogo de Limpieza';
$catalog_subtitle = 'Productos de higiene y limpieza para dejar tu casa impecable.';
$catalog_type_label = 'Tipo de producto';

require __DIR__ . '/includes/catalog_view.php';
