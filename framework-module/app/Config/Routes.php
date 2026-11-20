<?php
// Agregá estas rutas al final del archivo app/Config/Routes.php de CodeIgniter 4.

$routes->get('productos', 'Productos::index');
$routes->get('api/productos', 'ProductoApi::index');
$routes->get('api/productos/(:num)', 'ProductoApi::show/$1');
