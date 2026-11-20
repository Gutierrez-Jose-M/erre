<?php
require_once __DIR__ . '/includes/bootstrap.php';

page_meta(
    'Crear cuenta | ERRE Supermercado',
    'Registrate en ERRE y accedé a ofertas exclusivas, historial de pedidos y compras más rápidas.'
);

if (current_user()) {
    redirect('perfil.php');
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = post_string('nombre');
    $lastname = post_string('apellido');
    $email = post_string('email');
    $pass = post_string('password');

    $telefono = post_string('telefono');
    if ($name === '' || $lastname === '' || !filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($pass) < 8) {
        $error = 'Revisá los datos: el email debe ser válido y la contraseña tener al menos 8 caracteres.';
    } else {
        $resultado = register_user($name . ' ' . $lastname, $email, $pass, $telefono);
        if ($resultado['ok']) {
            flash('¡Cuenta creada!', 'Bienvenido/a a ERRE.');
            redirect('perfil.php');
        }
        $error = $resultado['error'];
    }
}

require __DIR__ . '/includes/header.php';
?>

<div class="auth-shell">
    <div class="auth-card">
        <div class="auth-logo">
            <a class="logo" href="index.php" aria-label="ERRE, ir al inicio">
                <span class="logo-mark">R</span><span class="logo-word">ERRE</span>
            </a>
        </div>
        <h1>Creá tu cuenta</h1>
        <p class="muted auth-subtitle">Tardás menos de un minuto</p>

        <?php if ($error !== ''): ?>
            <p class="form-error"><?php echo e($error); ?></p>
        <?php endif; ?>

        <form method="post" action="registro.php" class="form-stack">
            <div class="form-grid">
                <div class="field"><label for="r-nombre">Nombre</label><input id="r-nombre" name="nombre" required autocomplete="given-name"></div>
                <div class="field"><label for="r-apellido">Apellido</label><input id="r-apellido" name="apellido" required autocomplete="family-name"></div>
            </div>
            <div class="field"><label for="r-email">Email</label><input id="r-email" name="email" type="email" required autocomplete="email"></div>
            <div class="field"><label for="r-tel">Teléfono</label><input id="r-tel" name="telefono" type="tel" required autocomplete="tel" placeholder="11 1234-5678"></div>
            <div class="field">
                <label for="r-pass">Contraseña</label>
                <input id="r-pass" name="password" type="password" required minlength="8" autocomplete="new-password">
                <small class="muted">Mínimo 8 caracteres.</small>
            </div>
            <button type="submit" class="btn btn-primary btn-lg btn-block">Crear cuenta</button>
        </form>
        <p class="auth-footer">¿Ya tenés cuenta? <a class="link" href="login.php">Iniciá sesión</a></p>
    </div>
</div>

<?php require __DIR__ . '/includes/footer.php'; ?>
