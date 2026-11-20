<?php
require_once __DIR__ . '/includes/bootstrap.php';

http_response_code(404);
page_meta('Página no encontrada | ERRE', 'La página que buscás no existe o fue movida.');

require __DIR__ . '/includes/header.php';
?>

<div class="container empty-page">
    <strong class="error-code">404</strong>
    <h1>Página no encontrada</h1>
    <p>La página que buscás no existe o fue movida.</p>
    <a class="btn btn-primary" href="index.php">Volver al inicio</a>
</div>

<?php require __DIR__ . '/includes/footer.php'; ?>
