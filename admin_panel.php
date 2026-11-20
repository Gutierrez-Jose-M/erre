<?php
/** Panel protegido por rol admin (TP8). */
require_once __DIR__ . '/includes/bootstrap.php';
require_role('admin');
$pdo = db_requerida();

page_meta(
    'Panel de administración | ERRE Supermercado',
    'Gestión de productos y consultas del sitio ERRE.'
);

$stats = array(
    'productos' => 0,
    'usuarios' => 0,
    'pedidos' => 0,
    'consultas' => 0,
);
foreach ($stats as $tabla => $valor) {
    $stmt = $pdo->prepare('SELECT COUNT(*) FROM ' . $tabla);
    $stmt->execute();
    $stats[$tabla] = (int) $stmt->fetchColumn();
}

$user = current_user();
require __DIR__ . '/includes/header.php';
render_page_header('Administración', 'Hola, ' . explode(' ', $user['name'])[0] . ' 👋', 'Panel de gestión del catálogo ERRE.');
?>

<div class="container page-content">
    <div class="card" style="margin-bottom:1.5rem">
        <h2>Accesos rápidos</h2>
        <p class="muted">Solo el rol <strong>admin</strong> puede ver esta página.</p>
        <div style="display:flex;gap:.75rem;flex-wrap:wrap;margin-top:1rem">
            <a class="btn btn-primary" href="admin.php">Gestionar productos</a>
            <a class="btn btn-outline" href="admin_crear.php">Nuevo producto</a>
            <a class="btn btn-soft" href="perfil.php">Mi perfil</a>
        </div>
    </div>

    <div class="product-grid">
        <?php foreach ($stats as $tabla => $total): ?>
            <div class="card" style="padding:1.25rem">
                <span class="muted"><?php echo e(ucfirst($tabla)); ?></span>
                <p style="font-size:2rem;font-weight:800;margin:.35rem 0 0"><?php echo e($total); ?></p>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<?php require __DIR__ . '/includes/footer.php'; ?>
