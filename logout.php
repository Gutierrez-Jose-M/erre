<?php
/**
 * Cierre de sesión (TP8):
 * 1) limpia $_SESSION, 2) expira la cookie de sesión,
 * 3) destruye la sesión y 4) redirige al login.
 */
require_once __DIR__ . '/includes/bootstrap.php';

logout_user();
redirect('login.php?logout=1');
