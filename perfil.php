<?php
require_once __DIR__ . '/includes/bootstrap.php';

page_meta(
    'Mi Perfil | ERRE Supermercado',
    'Consultá tus datos personales y el historial de pedidos de tu cuenta ERRE.'
);

require_login();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (post_string('action') === 'save') {
        $nombre = post_string('p-nombre');
        $apellido = post_string('p-apellido');
        $email = post_string('p-email');
        if ($nombre === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            flash('Revisá los datos', 'El nombre y un email válido son obligatorios.', 'info');
        } elseif (user_update_profile(
            trim($nombre . ' ' . $apellido),
            $email,
            post_string('p-tel'),
            post_string('p-dir')
        )) {
            flash('Datos actualizados');
        } else {
            flash('No se pudo guardar', 'Revisá la conexión a la base de datos.', 'info');
        }
        redirect('perfil.php?tab=datos');
    }
}

$user = current_user();
$name_parts = explode(' ', $user['name']);
$initials = strtoupper(substr($name_parts[0], 0, 1) . (isset($name_parts[1]) ? substr($name_parts[1], 0, 1) : ''));
$tab = one_of(get_string('tab'), array('pedidos', 'datos'), 'pedidos');
$orders = order_all();

require __DIR__ . '/includes/header.php';
render_page_header('Mi Perfil', 'Hola, ' . $name_parts[0] . ' 👋', 'Gestioná tu cuenta y revisá tus compras.');
?>

<div class="container profile-layout">
    <aside class="profile-sidebar">
        <div class="profile-identity">
            <span class="profile-avatar"><?php echo e($initials); ?></span>
            <div>
                <strong><?php echo e($user['name']); ?></strong>
                <small class="muted"><?php echo e($user['email']); ?></small>
            </div>
        </div>
        <nav class="profile-menu">
            <a class="<?php echo $tab === 'datos' ? 'active' : ''; ?>" href="perfil.php?tab=datos"><?php echo icon('user'); ?> Mis Datos</a>
            <a class="<?php echo $tab === 'pedidos' ? 'active' : ''; ?>" href="perfil.php?tab=pedidos"><?php echo icon('package'); ?> Mis Pedidos</a>
            <a class="logout-btn" href="logout.php"><?php echo icon('logout'); ?> Cerrar Sesión</a>
        </nav>
    </aside>

    <?php if ($tab === 'pedidos'): ?>
        <section class="card orders-card">
            <div class="card-head">
                <h2>Historial de compras</h2>
                <p class="muted"><?php echo count($orders); ?> pedidos en los últimos 3 meses</p>
            </div>
            <?php if (count($orders) === 0): ?>
                <p class="muted">Todavía no registraste pedidos. <a class="link" href="comestibles.php">¡Empezá a comprar!</a></p>
            <?php else: ?>
            <div class="table-wrap">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>N° de Pedido</th>
                            <th>Fecha</th>
                            <th class="hide-sm">Productos</th>
                            <th>Estado</th>
                            <th class="align-right">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($orders as $order): ?>
                            <tr>
                                <td><strong><?php echo e($order['id']); ?></strong></td>
                                <td class="muted"><?php echo e($order['date']); ?></td>
                                <td class="muted hide-sm"><?php echo e($order['items']); ?></td>
                                <td><?php echo status_badge($order['status']); ?></td>
                                <td class="align-right"><strong><?php echo format_price($order['total']); ?></strong></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <?php endif; ?>
        </section>
    <?php else: ?>
        <section class="card profile-data">
            <h2>Mis datos</h2>
            <form method="post" action="perfil.php" class="form-grid profile-form">
                <input type="hidden" name="action" value="save">
                <div class="field"><label for="p-nombre">Nombre</label><input id="p-nombre" name="p-nombre" value="<?php echo e($name_parts[0]); ?>"></div>
                <div class="field"><label for="p-apellido">Apellido</label><input id="p-apellido" name="p-apellido" value="<?php echo e(isset($name_parts[1]) ? $name_parts[1] : ''); ?>"></div>
                <div class="field"><label for="p-email">Email</label><input id="p-email" name="p-email" type="email" value="<?php echo e($user['email']); ?>"></div>
                <div class="field"><label for="p-tel">Teléfono</label><input id="p-tel" name="p-tel" type="tel" value="<?php echo e(isset($user['telefono']) ? $user['telefono'] : ''); ?>"></div>
                <div class="field field-wide"><label for="p-dir">Dirección de entrega</label><input id="p-dir" name="p-dir" value="<?php echo e(isset($user['direccion']) ? $user['direccion'] : ''); ?>"></div>
                <div class="field-wide"><button type="submit" class="btn btn-primary">Guardar cambios</button></div>
            </form>
        </section>
    <?php endif; ?>
</div>

<?php require __DIR__ . '/includes/footer.php'; ?>
