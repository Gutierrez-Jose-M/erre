<?php
/**
 * Compatibilidad: las páginas comestibles.php y limpieza.php siguen
 * incluyendo este archivo, que delega en el controlador MVC (TP10).
 */

require_once __DIR__ . '/../app/Controllers/CatalogController.php';

CatalogController::index($catalog_category, array(
    'crumb' => $catalog_crumb,
    'title' => $catalog_title,
    'subtitle' => $catalog_subtitle,
    'type_label' => $catalog_type_label,
));
