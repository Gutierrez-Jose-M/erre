<?php
require_once __DIR__ . '/includes/bootstrap.php';

page_meta(
    'Iniciar sesión | ERRE Supermercado',
    'Ingresá a tu cuenta de ERRE para ver tus pedidos y comprar más rápido.'
);

if (current_user()) {
    redirect('perfil.php');
}

if (get_string('forgot') === '1') {
    flash('Te enviaremos un enlace para restablecerla', 'Revisá tu bandeja de entrada.', 'info');
}
if (get_string('logout') === '1') {
    flash('Cerraste sesión', '¡Te esperamos pronto!', 'info');
}

$error = '';
if (get_string('error') === 'acceso_denegado') {
    $error = 'Ingresá con tu cuenta para acceder a esa sección.';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = post_string('email');
    $pass = post_string('password');
    if (!filter_var($email, FILTER_VALIDATE_EMAIL) || $pass === '') {
        $error = 'Ingresá un email válido y tu contraseña.';
    } else {
        $resultado = login_user($email, $pass);
        if ($resultado['ok']) {
            flash('¡Hola de nuevo!');
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
        <h1>Iniciá sesión</h1>
        <p class="muted auth-subtitle">Ingresá con tu email y contraseña</p>

        <?php if ($error !== ''): ?>
            <p class="form-error"><?php echo e($error); ?></p>
        <?php endif; ?>

        <form method="post" action="login.php" class="form-stack">
            <div class="field">
                <label for="l-email">Email</label>
                <input id="l-email" name="email" type="email" required autocomplete="email" placeholder="tu@email.com">
            </div>
            <div class="field">
                <div class="field-head">
                    <label for="l-pass">Contraseña</label>
                    <a class="link small" href="login.php?forgot=1">Olvidé mi contraseña</a>
                </div>
                <input id="l-pass" name="password" type="password" required autocomplete="current-password">
            </div>
            <button type="submit" class="btn btn-primary btn-lg btn-block">Ingresar</button>
        </form>
        <p class="auth-footer">¿No tenés cuenta? <a class="link" href="registro.php">Registrate</a></p>
    </div>
</div>

<?php require __DIR__ . '/includes/footer.php'; ?>
