<?php
/** Carrito, pedidos y sesión de usuario (equivalente a src/lib/cart.tsx). */

define('FREE_SHIPPING_FROM', 30000);
define('SHIPPING_COST', 2500);

/** Costo de envío según el subtotal. */
function shipping_for($subtotal)
{
    $subtotal = (float) $subtotal;
    if ($subtotal == 0 || $subtotal >= FREE_SHIPPING_FROM) {
        return 0;
    }
    return SHIPPING_COST;
}

/** Devuelve las líneas del carrito con producto y subtotal calculados. */
function cart_items()
{
    $lines = isset($_SESSION['cart']) && is_array($_SESSION['cart']) ? $_SESSION['cart'] : array();
    $items = array();
    foreach ($lines as $slug => $qty) {
        $product = get_product($slug);
        $qty = (int) $qty;
        if ($product && $qty > 0) {
            $items[] = array(
                'slug' => $slug,
                'qty' => $qty,
                'product' => $product,
                'subtotal' => $product['price'] * $qty,
            );
        }
    }
    return $items;
}

/** Cantidad total de unidades. */
function cart_count()
{
    $count = 0;
    foreach (cart_items() as $item) {
        $count += $item['qty'];
    }
    return $count;
}

/** Subtotal del carrito. */
function cart_subtotal()
{
    $subtotal = 0;
    foreach (cart_items() as $item) {
        $subtotal += $item['subtotal'];
    }
    return $subtotal;
}

/** Subtotal, envío, total y cantidad en un solo llamado. */
function cart_totals()
{
    $items = cart_items();
    $subtotal = 0;
    $count = 0;
    foreach ($items as $item) {
        $subtotal += $item['subtotal'];
        $count += $item['qty'];
    }
    $shipping = shipping_for($subtotal);
    return array(
        'items' => $items,
        'count' => $count,
        'subtotal' => $subtotal,
        'shipping' => $shipping,
        'total' => $subtotal + $shipping,
    );
}

/** Inicializa el carrito en sesión si hace falta. */
function cart_init()
{
    if (!isset($_SESSION['cart']) || !is_array($_SESSION['cart'])) {
        $_SESSION['cart'] = array();
    }
}

/** Agrega unidades de un producto al carrito. */
function cart_add($slug, $qty = 1)
{
    $product = get_product($slug);
    $qty = (int) $qty;
    if (!$product || $qty < 1) {
        return false;
    }
    cart_init();
    $qty = min($qty, 99);
    if (isset($_SESSION['cart'][$slug])) {
        $_SESSION['cart'][$slug] = min(99, (int) $_SESSION['cart'][$slug] + $qty);
    } else {
        $_SESSION['cart'][$slug] = $qty;
    }
    return true;
}

/** Cambia la cantidad de un producto (0 o menos lo quita). */
function cart_set_qty($slug, $qty)
{
    cart_init();
    $qty = (int) $qty;
    if ($qty <= 0) {
        unset($_SESSION['cart'][$slug]);
    } elseif (get_product($slug)) {
        $_SESSION['cart'][$slug] = min(99, $qty);
    }
}

/** Quita un producto del carrito. */
function cart_remove($slug)
{
    cart_init();
    unset($_SESSION['cart'][$slug]);
}

/** Vacía el carrito. */
function cart_clear()
{
    $_SESSION['cart'] = array();
}

/** Procesa las acciones del carrito enviadas por POST. */
function cart_handle_post()
{
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        return;
    }
    $action = post_string('action');
    $slug = post_string('slug');
    $qty = (int) post_string('qty', '1');

    if ($action === 'add' && cart_add($slug, $qty > 0 ? $qty : 1)) {
        $product = get_product($slug);
        flash('Agregado al carrito', $product['name']);
    } elseif ($action === 'update') {
        cart_set_qty($slug, $qty);
    } elseif ($action === 'remove') {
        cart_remove($slug);
        flash('Producto quitado del carrito');
    } elseif ($action === 'clear') {
        cart_clear();
        flash('Carrito vaciado');
    } else {
        return;
    }
    redirect(back_or('carrito.php'));
}

/** URL de retorno segura para volver a la página que envió el formulario. */
function back_or($default)
{
    $referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';
    if ($referer !== '') {
        $host = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '';
        $parts = parse_url($referer);
        if (isset($parts['host']) && $host !== '' && $parts['host'] === $host) {
            return $referer;
        }
    }
    return $default;
}

/** Pedidos de ejemplo (solo se usan si no hay base de datos). */
function demo_orders()
{
    return array(
        array('id' => 'ER-48213', 'date' => '10/11/2026', 'status' => 'En camino', 'items' => 14, 'total' => 38450),
        array('id' => 'ER-47790', 'date' => '02/11/2026', 'status' => 'Entregado', 'items' => 9, 'total' => 21980),
        array('id' => 'ER-46521', 'date' => '24/10/2026', 'status' => 'Entregado', 'items' => 22, 'total' => 54320),
    );
}

/** Pedidos del usuario autenticado, leídos desde MySQL. */
function order_all()
{
    $user = current_user();
    $pdo = db();
    if ($user && $pdo) {
        try {
            $sql = 'SELECT p.numero, p.total, p.created_at, e.nombre AS estado,
                           COUNT(d.id) AS items
                    FROM pedidos p
                    INNER JOIN estados_pedido e ON e.id = p.estado_id
                    LEFT JOIN detalle_pedidos d ON d.pedido_id = p.id
                    WHERE p.usuario_id = :usuario_id
                    GROUP BY p.id, e.nombre, p.total, p.created_at
                    ORDER BY p.created_at DESC';
            $stmt = $pdo->prepare($sql);
            $stmt->execute(array(':usuario_id' => $user['id']));
            $rows = $stmt->fetchAll();
            $orders = array();
            foreach ($rows as $row) {
                $orders[] = array(
                    'id' => $row['numero'],
                    'date' => date('d/m/Y', strtotime($row['created_at'])),
                    'status' => $row['estado'],
                    'items' => (int) $row['items'],
                    'total' => (float) $row['total'],
                );
            }
            return $orders;
        } catch (PDOException $e) {
            $GLOBALS['erre_db_error'] = $e->getMessage();
        }
    }

    $own = isset($_SESSION['orders']) && is_array($_SESSION['orders']) ? $_SESSION['orders'] : array();
    return array_merge($own, demo_orders());
}

/** Numero de pedido único para el registro en MySQL. */
function order_number()
{
    $random = function_exists('random_bytes')
        ? strtoupper(bin2hex(random_bytes(3)))
        : strtoupper(dechex(mt_rand(100000, 999999)));
    return 'ER-' . date('ymd') . '-' . $random;
}

/** Registra un pedido en MySQL (con detalle) y también en sesión como respaldo. */
function order_place($items, $total, $method, $shipping = array())
{
    $user = current_user();
    $pdo = db();
    $order = array(
        'id' => order_number(),
        'date' => date('d/m/Y'),
        'status' => 'Preparando',
        'items' => $items,
        'total' => $total,
        'method' => $method,
    );

    if ($pdo) {
        try {
            $pdo->beginTransaction();

            $sqlPedido = 'INSERT INTO pedidos (numero, usuario_id, estado_id, total, metodo_pago, direccion)
                          VALUES (:numero, :usuario_id,
                              (SELECT id FROM estados_pedido WHERE nombre = "Preparando" LIMIT 1),
                              :total, :metodo, :direccion)';
            $stmt = $pdo->prepare($sqlPedido);
            $stmt->execute(array(
                ':numero' => $order['id'],
                ':usuario_id' => $user ? $user['id'] : null,
                ':total' => $total,
                ':metodo' => $method,
                ':direccion' => isset($shipping['direccion'])
                    ? $shipping['direccion'] . ' ' . (isset($shipping['piso']) ? $shipping['piso'] : '')
                    : null,
            ));
            $pedidoId = (int) $pdo->lastInsertId();

            $sqlDetalle = 'INSERT INTO detalle_pedidos
                           (pedido_id, producto_id, cantidad, precio_unitario, subtotal)
                           VALUES (:pedido_id,
                               (SELECT id FROM productos WHERE slug = :slug LIMIT 1),
                               :cantidad, :precio, :subtotal)';
            $stmtDetalle = $pdo->prepare($sqlDetalle);
            foreach (cart_items() as $item) {
                $stmtDetalle->execute(array(
                    ':pedido_id' => $pedidoId,
                    ':slug' => $item['slug'],
                    ':cantidad' => $item['qty'],
                    ':precio' => $item['product']['price'],
                    ':subtotal' => $item['subtotal'],
                ));
            }

            $pdo->commit();
            return $order;
        } catch (PDOException $e) {
            if ($pdo->inTransaction()) {
                $pdo->rollBack();
            }
            $GLOBALS['erre_db_error'] = $e->getMessage();
        }
    }

    if (!isset($_SESSION['orders']) || !is_array($_SESSION['orders'])) {
        $_SESSION['orders'] = array();
    }
    array_unshift($_SESSION['orders'], $order);
    return $order;
}

/** Usuario logueado (o null). */
function current_user()
{
    if (isset($_SESSION['usuario_id'], $_SESSION['usuario_nombre'], $_SESSION['usuario_email'])) {
        return array(
            'id' => (int) $_SESSION['usuario_id'],
            'name' => $_SESSION['usuario_nombre'],
            'email' => $_SESSION['usuario_email'],
            'rol' => isset($_SESSION['rol']) ? $_SESSION['rol'] : 'usuario',
            'telefono' => isset($_SESSION['usuario_telefono']) ? $_SESSION['usuario_telefono'] : '',
            'direccion' => isset($_SESSION['usuario_direccion']) ? $_SESSION['usuario_direccion'] : '',
        );
    }
    return null;
}

/** Guarda los datos clave del usuario en la sesión (TP8). */
function session_set_user($row)
{
    session_regenerate_id(true);
    $_SESSION['usuario_id'] = (int) $row['id'];
    $_SESSION['usuario_nombre'] = $row['nombre'];
    $_SESSION['usuario_email'] = $row['email'];
    $_SESSION['rol'] = $row['rol'];
    $_SESSION['usuario_telefono'] = isset($row['telefono']) ? $row['telefono'] : '';
    $_SESSION['usuario_direccion'] = isset($row['direccion']) ? $row['direccion'] : '';
}

/** Inicia sesión contra MySQL usando password_verify() (TP8). */
function login_user($email, $password)
{
    $pdo = db();
    if (!$pdo) {
        return array('ok' => false, 'error' => 'La base de datos no está disponible. Revisá la configuración.');
    }

    try {
        $sql = 'SELECT u.id, u.nombre, u.email, u.password, u.telefono, u.direccion, r.nombre AS rol
                FROM usuarios u
                INNER JOIN roles r ON r.id = u.rol_id
                WHERE u.email = :email
                LIMIT 1';
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(':email' => $email));
        $row = $stmt->fetch();

        if (!$row || !password_verify($password, $row['password'])) {
            return array('ok' => false, 'error' => 'Email o contraseña incorrectos.');
        }

        session_set_user($row);
        return array('ok' => true, 'error' => '');
    } catch (PDOException $e) {
        $GLOBALS['erre_db_error'] = $e->getMessage();
        return array('ok' => false, 'error' => 'No se pudo validar tu cuenta. Intentá más tarde.');
    }
}

/** Crea un usuario con contraseña hasheada (TP8). */
function register_user($name, $email, $password, $telefono = '')
{
    $pdo = db();
    if (!$pdo) {
        return array('ok' => false, 'error' => 'La base de datos no está disponible. Revisá la configuración.');
    }

    try {
        $stmt = $pdo->prepare('SELECT id FROM usuarios WHERE email = :email LIMIT 1');
        $stmt->execute(array(':email' => $email));
        if ($stmt->fetch()) {
            return array('ok' => false, 'error' => 'Ese email ya está registrado. Iniciá sesión.');
        }

        $hash = password_hash($password, PASSWORD_BCRYPT);
        $sql = 'INSERT INTO usuarios (nombre, email, password, rol_id, telefono)
                VALUES (:nombre, :email, :password,
                    (SELECT id FROM roles WHERE nombre = "usuario" LIMIT 1),
                    :telefono)';
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(
            ':nombre' => $name,
            ':email' => $email,
            ':password' => $hash,
            ':telefono' => $telefono,
        ));

        session_set_user(array(
            'id' => $pdo->lastInsertId(),
            'nombre' => $name,
            'email' => $email,
            'rol' => 'usuario',
        ));
        return array('ok' => true, 'error' => '');
    } catch (PDOException $e) {
        $GLOBALS['erre_db_error'] = $e->getMessage();
        return array('ok' => false, 'error' => 'No se pudo crear tu cuenta. Intentá más tarde.');
    }
}

/** Actualiza los datos personales del usuario (TP7: UPDATE con WHERE). */
function user_update_profile($name, $email, $telefono, $direccion)
{
    $user = current_user();
    $pdo = db();
    if (!$user || !$pdo) {
        return false;
    }
    try {
        $sql = 'UPDATE usuarios
                SET nombre = :nombre, email = :email, telefono = :telefono, direccion = :direccion
                WHERE id = :id';
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(
            ':nombre' => $name,
            ':email' => $email,
            ':telefono' => $telefono,
            ':direccion' => $direccion,
            ':id' => $user['id'],
        ));
        $_SESSION['usuario_nombre'] = $name;
        $_SESSION['usuario_email'] = $email;
        $_SESSION['usuario_telefono'] = $telefono;
        $_SESSION['usuario_direccion'] = $direccion;
        return true;
    } catch (PDOException $e) {
        $GLOBALS['erre_db_error'] = $e->getMessage();
        return false;
    }
}

/** Cierra la sesión del usuario: unset + cookie + session_destroy (TP8). */
function logout_user()
{
    $_SESSION = array();

    if (ini_get('session.use_cookies')) {
        $params = session_get_cookie_params();
        setcookie(
            session_name(),
            '',
            time() - 42000,
            $params['path'],
            $params['domain'],
            $params['secure'],
            $params['httponly']
        );
    }

    session_destroy();
}
