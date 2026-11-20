<?php
/** Cabecera común. Luego de incluirla, la página imprime su contenido. */

$page_title = isset($GLOBALS['page_title']) ? $GLOBALS['page_title'] : 'ERRE Supermercado Online';
$page_description = isset($GLOBALS['page_description'])
    ? $GLOBALS['page_description']
    : 'Comestibles y artículos de limpieza con envío a domicilio.';
$totals = cart_totals();
$current_user = current_user();
$flash = take_flash();

?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo e($page_title); ?></title>
    <meta name="description" content="<?php echo e($page_description); ?>">
    <meta name="author" content="ERRE Supermercado">
    <meta property="og:title" content="<?php echo e($page_title); ?>">
    <meta property="og:description" content="<?php echo e($page_description); ?>">
    <meta property="og:type" content="website">
    <meta name="twitter:card" content="summary_large_image">
    <link rel="icon" href="assets/favicon.ico" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:opsz,wght@12..96,500;12..96,700;12..96,800&family=Figtree:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
<?php if ($flash): ?>
    <div class="toast toast-<?php echo e($flash['type']); ?>" id="toast" role="status">
        <span class="toast-icon"><?php echo icon('check'); ?></span>
        <span>
            <strong><?php echo e($flash['message']); ?></strong>
            <?php if (!empty($flash['description'])): ?>
                <small><?php echo e($flash['description']); ?></small>
            <?php endif; ?>
        </span>
        <button type="button" class="toast-close" data-close-toast aria-label="Cerrar aviso"><?php echo icon('x'); ?></button>
    </div>
<?php endif; ?>

<header class="site-header">
    <div class="topbar">
        <div class="container topbar-inner">
            <?php echo icon('truck'); ?>
            <span>Envío gratis en compras desde <?php echo format_price(FREE_SHIPPING_FROM); ?></span>
        </div>
    </div>

    <div class="container header-main">
        <button type="button" class="icon-btn mobile-menu-btn" id="menuToggle" aria-label="Abrir menú" aria-expanded="false">
            <?php echo icon('menu'); ?>
        </button>

        <a class="logo" href="index.php" aria-label="ERRE, ir al inicio">
            <span class="logo-mark">R</span>
            <span class="logo-word">ERRE</span>
        </a>

        <div class="header-search header-search-desktop">
            <form class="search-form" action="buscar.php" method="get" role="search" autocomplete="off">
                <span class="search-icon"><?php echo icon('search'); ?></span>
                <input type="search" name="q" id="searchInput" placeholder="¿Qué estás buscando hoy? Leche, yerba, detergente…" aria-label="Buscar productos">
                <button type="submit" class="btn btn-primary search-submit">Buscar</button>
                <div class="search-suggestions" id="searchSuggestions" hidden></div>
            </form>
        </div>

        <div class="header-actions">
            <a class="account-link" href="<?php echo $current_user ? 'perfil.php' : 'login.php'; ?>">
                <?php echo icon('user'); ?>
                <span class="hide-sm">Mi Cuenta</span>
            </a>
            <a class="cart-link" href="carrito.php">
                <span class="cart-icon-wrap">
                    <?php echo icon('cart'); ?>
                    <?php if ($totals['count'] > 0): ?>
                        <span class="cart-count"><?php echo $totals['count']; ?></span>
                    <?php endif; ?>
                </span>
                <span class="hide-sm"><?php echo $totals['count'] > 0 ? format_price($totals['subtotal']) : 'Carrito'; ?></span>
            </a>
        </div>
    </div>

    <div class="container header-search header-search-mobile">
        <form class="search-form" action="buscar.php" method="get" role="search">
            <span class="search-icon"><?php echo icon('search'); ?></span>
            <input type="search" name="q" placeholder="Buscar productos…" aria-label="Buscar productos">
            <button type="submit" class="btn btn-primary search-submit">Buscar</button>
        </form>
    </div>

    <nav class="main-nav" aria-label="Principal">
        <ul class="container nav-list">
            <li><a class="<?php echo nav_active('index.php'); ?>" href="index.php">Inicio</a></li>
            <li><a class="<?php echo nav_active('comestibles.php'); ?>" href="comestibles.php">Comestibles</a></li>
            <li><a class="<?php echo nav_active('limpieza.php'); ?>" href="limpieza.php">Limpieza</a></li>
            <li><a class="<?php echo nav_active('servicios.php'); ?>" href="servicios.php">Servicios</a></li>
            <li><a class="<?php echo nav_active('nosotros.php'); ?>" href="nosotros.php">Nosotros</a></li>
            <li><a class="<?php echo nav_active('contacto.php'); ?>" href="contacto.php">Contacto</a></li>
            <?php if ($current_user && $current_user['rol'] === 'admin'): ?>
                <li><a class="<?php echo nav_active('admin_panel.php'); ?>" href="admin_panel.php">Administración</a></li>
            <?php endif; ?>
            <li class="nav-promo"><span>Ofertas de la semana</span></li>
        </ul>
    </nav>

    <nav class="mobile-nav" id="mobileNav" aria-label="Principal móvil" hidden>
        <ul class="container">
            <li><a href="index.php">Inicio</a></li>
            <li><a href="comestibles.php">Comestibles</a></li>
            <li><a href="limpieza.php">Limpieza</a></li>
            <li><a href="servicios.php">Servicios</a></li>
            <li><a href="nosotros.php">Nosotros</a></li>
            <li><a href="contacto.php">Contacto</a></li>
            <?php if ($current_user && $current_user['rol'] === 'admin'): ?>
                <li><a href="admin_panel.php">Administración</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</header>

<main class="site-main">
