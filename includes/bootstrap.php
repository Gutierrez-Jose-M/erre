<?php
/**
 * Arranque de la aplicación.
 * Incluir este archivo al principio de cada página pública.
 * Sin Composer, sin frameworks: funciona en XAMPP y en hosting compartido.
 */

if (session_status() === PHP_SESSION_NONE) {
    $https = !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off';
    if (!empty($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https') {
        $https = true;
    }
    session_set_cookie_params(array(
        'lifetime' => 0,
        'path' => '/',
        'secure' => $https,
        'httponly' => true,
        'samesite' => 'Lax',
    ));
    session_start();
}

date_default_timezone_set('America/Argentina/Buenos_Aires');

require_once __DIR__ . '/../config/conexion.php';
require_once __DIR__ . '/helpers.php';
require_once __DIR__ . '/icons.php';
require_once __DIR__ . '/products.php';
require_once __DIR__ . '/cart.php';
require_once __DIR__ . '/auth_guard.php';
require_once __DIR__ . '/ui.php';
