</main>

<footer class="site-footer">
    <div class="container footer-grid">
        <div class="footer-about">
            <a class="logo logo-inverted" href="index.php" aria-label="ERRE, ir al inicio">
                <span class="logo-mark">R</span>
                <span class="logo-word">ERRE</span>
            </a>
            <p>Tu supermercado de barrio, ahora online. Comestibles frescos y artículos de limpieza con entrega a domicilio.</p>
            <div class="social-links">
                <a href="#" aria-label="Facebook"><?php echo icon('facebook'); ?></a>
                <a href="#" aria-label="Instagram"><?php echo icon('instagram'); ?></a>
                <a href="#" aria-label="X (Twitter)"><?php echo icon('twitter'); ?></a>
                <a href="#" aria-label="YouTube"><?php echo icon('youtube'); ?></a>
            </div>
        </div>
        <div>
            <h3>Comprá</h3>
            <ul class="footer-links">
                <li><a href="comestibles.php">Comestibles</a></li>
                <li><a href="limpieza.php">Limpieza</a></li>
                <li><a href="carrito.php">Mi carrito</a></li>
                <li><a href="perfil.php">Mis pedidos</a></li>
            </ul>
        </div>
        <div>
            <h3>Ayuda</h3>
            <ul class="footer-links">
                <li><a href="servicios.php">Envíos y devoluciones</a></li>
                <li><a href="servicios.php">Medios de pago</a></li>
                <li><a href="nosotros.php">Quiénes somos</a></li>
                <li><a href="contacto.php">Contacto</a></li>
            </ul>
        </div>
        <div>
            <h3>Contacto</h3>
            <ul class="footer-contact">
                <li><?php echo icon('pin'); ?> Av. Corrientes 1234, CABA</li>
                <li><?php echo icon('phone'); ?> 0800-555-3773</li>
                <li><?php echo icon('mail'); ?> hola@erre.com.ar</li>
                <li><?php echo icon('card'); ?> Débito, crédito y transferencia</li>
            </ul>
        </div>
    </div>
    <div class="footer-bottom">
        <div class="container footer-bottom-inner">
            <p>© <?php echo date('Y'); ?> ERRE Supermercado. Todos los derechos reservados.</p>
            <p>Precios válidos para compras online. Imágenes ilustrativas.</p>
        </div>
    </div>
</footer>

<script src="assets/js/app.js"></script>
</body>
</html>
