<?php
require_once __DIR__ . '/includes/bootstrap.php';

page_meta(
    'Contacto | ERRE Supermercado',
    'Escribinos tu consulta, llamanos o visitanos en Av. Corrientes 1234, CABA. Atención de lunes a sábado.'
);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = post_string('nombre');
    $email = post_string('email');
    $asunto = post_string('asunto');
    $mensaje = post_string('mensaje');

    if ($nombre === '' || !filter_var($email, FILTER_VALIDATE_EMAIL) || $asunto === '' || $mensaje === '') {
        flash('Faltan datos', 'Completá nombre, email, asunto y mensaje.', 'info');
    } else {
        $pdo = db();
        if ($pdo) {
            try {
                $stmt = $pdo->prepare('INSERT INTO consultas (nombre, email, asunto, mensaje)
                                       VALUES (:nombre, :email, :asunto, :mensaje)');
                $stmt->execute(array(
                    ':nombre' => $nombre,
                    ':email' => $email,
                    ':asunto' => $asunto,
                    ':mensaje' => $mensaje,
                ));
            } catch (PDOException $e) {
                $GLOBALS['erre_db_error'] = $e->getMessage();
            }
        }
        flash('¡Mensaje enviado!', 'Te responderemos dentro de las 24 horas.');
    }
    redirect('contacto.php');
}

$info = array(
    array('icon' => 'pin', 'label' => 'Dirección', 'value' => 'Av. Corrientes 1234, CABA'),
    array('icon' => 'phone', 'label' => 'Teléfono', 'value' => '0800-555-3773'),
    array('icon' => 'mail', 'label' => 'Email', 'value' => 'hola@erre.com.ar'),
    array('icon' => 'clock', 'label' => 'Horario', 'value' => 'Lun a Sáb de 8 a 21 h'),
);

require __DIR__ . '/includes/header.php';
render_page_header('Contacto', 'Contacto', '¿Dudas sobre un pedido o sugerencias? Escribinos, nos encanta leerte.');
?>

<div class="container contact-layout">
    <form method="post" action="contacto.php" class="card contact-form">
        <h2>Envianos tu consulta</h2>
        <div class="form-grid">
            <div class="field"><label for="c-nombre">Nombre</label><input id="c-nombre" name="nombre" required autocomplete="name"></div>
            <div class="field"><label for="c-email">Email</label><input id="c-email" name="email" type="email" required autocomplete="email"></div>
        </div>
        <div class="field"><label for="c-asunto">Asunto</label><input id="c-asunto" name="asunto" required></div>
        <div class="field"><label for="c-mensaje">Mensaje</label><textarea id="c-mensaje" name="mensaje" rows="6" required></textarea></div>
        <button type="submit" class="btn btn-primary btn-lg"><?php echo icon('send'); ?> Enviar mensaje</button>
    </form>

    <div class="contact-side">
        <ul class="contact-info">
            <?php foreach ($info as $item): ?>
                <li>
                    <?php echo icon($item['icon']); ?>
                    <span class="eyebrow"><?php echo e($item['label']); ?></span>
                    <strong><?php echo e($item['value']); ?></strong>
                </li>
            <?php endforeach; ?>
        </ul>
        <div class="map-wrap">
            <iframe title="Mapa de ERRE Supermercado"
                src="https://www.google.com/maps?q=Av.+Corrientes+1234,+Buenos+Aires&output=embed"
                loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
    </div>
</div>

<?php require __DIR__ . '/includes/footer.php'; ?>
