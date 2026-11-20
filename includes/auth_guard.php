<?php
/**
 * Guardián de rutas y control de acceso por roles (TP8).
 * Se incluye desde bootstrap.php.
 */

/** Exige sesión iniciada; si no, redirige a login.php?error=acceso_denegado. */
function require_login()
{
    if (!current_user()) {
        flash('Acceso denegado', 'Iniciá sesión para continuar.', 'info');
        redirect('login.php?error=acceso_denegado');
    }
}

/** Exige un rol concreto (por ejemplo, 'admin'). */
function require_role($rol)
{
    require_login();
    $user = current_user();
    if (!isset($user['rol']) || $user['rol'] !== $rol) {
        flash('Sin permisos', 'Tu cuenta no tiene acceso a esa sección.', 'info');
        redirect('perfil.php?error=sin_permisos');
    }
}
