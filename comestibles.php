<?php
require_once __DIR__ . '/includes/bootstrap.php';

page_meta(
    'Comestibles | ERRE Supermercado',
    'Almacén, lácteos, frutas, panadería e infusiones al mejor precio. Filtrá por marca, precio y tipo de alimento.'
);

$catalog_category = 'comestibles';
$catalog_crumb = 'Comestibles';
$catalog_title = 'Catálogo de Comestibles';
$catalog_subtitle = 'Almacén, lácteos, frutas y todo lo que necesitás para tu cocina.';
$catalog_type_label = 'Tipo de alimento';

require __DIR__ . '/includes/catalog_view.php';
