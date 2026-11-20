<?php
/**
 * Endpoint JSON para búsqueda de productos (TP9).
 *
 * Ejemplos:
 *   GET api/buscar_productos.php?q=leche
 *   GET api/buscar_productos.php?slug=leche-entera
 *
 * Responde siempre JSON con los códigos HTTP adecuados:
 * 200 OK, 400 Bad Request, 404 Not Found, 405 Method Not Allowed,
 * 500/503 error del servidor o de la base de datos.
 */

header('Content-Type: application/json; charset=utf-8');
header('X-Content-Type-Options: nosniff');

require_once __DIR__ . '/../config/conexion.php';

/** Imprime JSON, establece el código HTTP y termina. */
function json_response($status, $payload)
{
    http_response_code($status);
    echo json_encode($payload, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    exit;
}

/** Convierte una fila al formato que consume el frontend. */
function json_product($row)
{
    return array(
        'slug' => $row['slug'],
        'name' => $row['name'],
        'brand' => $row['brand'],
        'unit' => $row['unit'],
        'price' => '$ ' . number_format((float) $row['price'], 0, ',', '.'),
        'image' => $row['image'],
    );
}

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    json_response(405, array(
        'status' => 'error',
        'message' => 'Método no permitido. Usá GET.',
    ));
}

$pdo = db();
if (!$pdo) {
    json_response(503, array(
        'status' => 'error',
        'message' => 'Base de datos no disponible. Revisá config/config.php.',
    ));
}

$slug = isset($_GET['slug']) && is_string($_GET['slug']) ? trim($_GET['slug']) : '';
$q = isset($_GET['q']) && is_string($_GET['q']) ? trim($_GET['q']) : '';

$sql = 'SELECT p.slug, p.nombre AS name, m.nombre AS brand, p.unidad AS unit,
               p.precio AS price, p.imagen AS image, p.descripcion AS description
        FROM productos p
        INNER JOIN marcas m ON m.id = p.marca_id
        INNER JOIN categorias c ON c.id = p.categoria_id
        WHERE p.activo = 1';

try {
    if ($slug !== '') {
        $sql .= ' AND p.slug = :slug LIMIT 1';
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(':slug' => $slug));
        $row = $stmt->fetch();
        if (!$row) {
            json_response(404, array(
                'status' => 'error',
                'message' => 'No existe el producto solicitado.',
            ));
        }
        json_response(200, array(
            'status' => 'success',
            'data' => array(json_product($row)),
        ));
    }

    if (!isset($_GET['q'])) {
        json_response(400, array(
            'status' => 'error',
            'message' => 'Falta el parámetro q.',
        ));
    }

    if ($q !== '') {
        $sql .= ' AND (p.nombre LIKE :query OR m.nombre LIKE :query
                       OR p.tipo LIKE :query OR c.nombre LIKE :query)';
    }
    $sql .= ' ORDER BY p.nombre ASC LIMIT 8';

    $stmt = $pdo->prepare($sql);
    $params = array();
    if ($q !== '') {
        $params[':query'] = '%' . $q . '%';
    }
    $stmt->execute($params);
    $productos = array();
    foreach ($stmt->fetchAll() as $row) {
        $productos[] = json_product($row);
    }

    json_response(200, array(
        'status' => 'success',
        'data' => $productos,
    ));
} catch (PDOException $e) {
    json_response(500, array(
        'status' => 'error',
        'message' => 'Error al consultar la base de datos.',
    ));
}
