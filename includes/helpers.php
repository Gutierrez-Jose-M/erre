<?php
/** Funciones generales de la tienda. */

/** Escapa texto para imprimir en HTML. */
function e($value)
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

/** Formato de pre ARG, por ejemplo: $ 1.290. */
function format_price($value)
{
    return '$ ' . number_format((float) $value, 0, ',', '.');
}

/** Quita acentos y pasa a minúsculas (para búsquedas). */
function normalize_text($value)
{
    $value = (string) $value;
    $from = array('á', 'é', 'í', 'ó', 'ú', 'ñ', 'Á', 'É', 'Í', 'Ó', 'Ú', 'Ñ', 'ü', 'Ü');
    $to   = array('a', 'e', 'i', 'o', 'u', 'n', 'a', 'e', 'i', 'o', 'u', 'n', 'u', 'u');
    return strtolower(str_replace($from, $to, $value));
}

/** Redirige y corta la ejecución. */
function redirect($url)
{
    header('Location: ' . $url);
    exit;
}

/** Guarda un aviso para mostrarlo en la próxima página (toast). */
function flash($message, $description = '', $type = 'success')
{
    $_SESSION['flash'] = array(
        'message' => $message,
        'description' => $description,
        'type' => $type,
    );
}

/** Devuelve y borra el aviso pendiente. */
function take_flash()
{
    $flash = isset($_SESSION['flash']) ? $_SESSION['flash'] : null;
    unset($_SESSION['flash']);
    return $flash;
}

/** Define el título y la descripción de la página para el <head>. */
function page_meta($title, $description)
{
    $GLOBALS['page_title'] = $title;
    $GLOBALS['page_description'] = $description;
}

/** Nombre del archivo actual, útil para marcar el link activo. */
function current_page()
{
    return basename(isset($_SERVER['PHP_SELF']) ? $_SERVER['PHP_SELF'] : '');
}

/** Devuelve "active" si la página actual coincide con el archivo dado. */
function nav_active($file)
{
    return current_page() === $file ? ' active' : '';
}

/** Cantidad de caracteres recibidos por POST de forma segura. */
function post_string($key, $default = '')
{
    if (!isset($_POST[$key]) || !is_string($_POST[$key])) {
        return $default;
    }
    return trim($_POST[$key]);
}

/** Escoge un valor de GET saneado. */
function get_string($key, $default = '')
{
    if (!isset($_GET[$key]) || !is_string($_GET[$key])) {
        return $default;
    }
    return trim($_GET[$key]);
}

/** Devuelve el valor de una lista si está permitido, si no el valor por defecto. */
function one_of($value, array $allowed, $default)
{
    return in_array($value, $allowed, true) ? $value : $default;
}

/** Recorta un texto por palabras, sin depender de extensiones extra. */
function excerpt($text, $max = 110)
{
    $text = (string) $text;
    if (strlen($text) <= $max) {
        return $text;
    }
    $cut = substr($text, 0, $max);
    $space = strrpos($cut, ' ');
    if ($space !== false) {
        $cut = substr($cut, 0, $space);
    }
    return $cut . '…';
}
