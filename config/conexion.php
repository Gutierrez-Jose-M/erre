<?php
/**
 * Conexión PDO a MySQL (TP7).
 *
 * Si existe config/config.php se usan esos datos. Si no existe, se usan
 * los valores por defecto de XAMPP. La aplicación funciona en modo
 * catálogo estático cuando no hay base de datos disponible; las páginas
 * que requieren persistencia (admin, login, API) muestran un error claro.
 */

if (file_exists(__DIR__ . '/config.php')) {
    require_once __DIR__ . '/config.php';
}

if (!defined('DB_HOST')) {
    define('DB_HOST', 'localhost');
}
if (!defined('DB_NAME')) {
    define('DB_NAME', 'erre_supermercado');
}
if (!defined('DB_USER')) {
    define('DB_USER', 'root');
}
if (!defined('DB_PASS')) {
    define('DB_PASS', '');
}
if (!defined('DB_CHARSET')) {
    define('DB_CHARSET', 'utf8mb4');
}

/**
 * Devuelve la instancia PDO o null si no se pudo conectar.
 * El error queda disponible en $GLOBALS['erre_db_error'].
 */
function db()
{
    static $pdo = null;
    static $intentado = false;

    if ($intentado) {
        return $pdo;
    }
    $intentado = true;

    $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=' . DB_CHARSET;
    $options = array(
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    );

    try {
        $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
    } catch (PDOException $e) {
        $GLOBALS['erre_db_error'] = $e->getMessage();
        $pdo = null;
    }

    return $pdo;
}

/** True cuando hay conexión a MySQL. */
function db_available()
{
    return db() instanceof PDO;
}

/**
 * Conexión obligatoria: para módulos que no pueden funcionar sin BD.
 * Devuelve PDO o termina con un mensaje controlado.
 */
function db_requerida()
{
    $pdo = db();
    if (!$pdo) {
        http_response_code(500);
        $detalle = isset($GLOBALS['erre_db_error']) ? $GLOBALS['erre_db_error'] : 'Error desconocido';
        echo '<!doctype html><html lang="es"><head><meta charset="utf-8"><title>Error de base de datos</title></head>';
        echo '<body style="font-family:system-ui;padding:2rem;max-width:720px;margin:auto">';
        echo '<h1>No se pudo conectar a MySQL</h1>';
        echo '<p>Revisá <code>config/config.php</code> y confirmá que importaste <code>schema.sql</code> y <code>consultas.sql</code>.</p>';
        echo '<pre style="white-space:pre-wrap;background:#f5f5f5;padding:1rem">' . htmlspecialchars($detalle, ENT_QUOTES, 'UTF-8') . '</pre>';
        echo '</body></html>';
        exit;
    }
    return $pdo;
}

/** Texto del último error de conexión (para diagnóstico). */
function db_error()
{
    return isset($GLOBALS['erre_db_error']) ? $GLOBALS['erre_db_error'] : '';
}
