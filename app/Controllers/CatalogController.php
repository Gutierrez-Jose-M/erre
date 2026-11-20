<?php
/**
 * Controlador del catálogo (TP10, parte A: MVC nativo).
 * Recibe la solicitud, pide datos al Modelo y elige la Vista.
 */

require_once __DIR__ . '/../Models/ProductModel.php';

class CatalogController
{
    /**
     * Muestra el listado de una categoría.
     *
     * @param string $categoria comestibles | limpieza
     * @param array  $meta      título, migas y etiquetas de la página
     */
    public static function index($categoria, $meta)
    {
        $items = ProductModel::byCategory($categoria);

        // Modo sin base de datos: se mantiene el catálogo estático del proyecto.
        if (count($items) === 0) {
            $items = get_products_by_category($categoria);
        }

        $catalog_category = $categoria;
        $catalog_crumb = $meta['crumb'];
        $catalog_title = $meta['title'];
        $catalog_subtitle = $meta['subtitle'];
        $catalog_type_label = $meta['type_label'];

        require __DIR__ . '/../Views/catalog.php';
    }
}
