-- ============================================================
-- consultas.sql — TP6 (DML) + datos iniciales del proyecto ERRE
-- Ejecutar DESPUÉS de schema.sql.
-- Las inserciones usan INSERT IGNORE para poder volver a ejecutarlas.
-- Las sentencias de CRUD de prueba están al final dentro de una
-- transacción que se deshace con ROLLBACK: no modifican tus datos.
-- ============================================================

USE erre_supermercado;

-- ------------------------------------------------------------
-- CREATE: tablas maestras / secundarias
-- ------------------------------------------------------------
INSERT IGNORE INTO roles (nombre) VALUES
('admin'), ('usuario');

INSERT IGNORE INTO estados_pedido (nombre) VALUES
('Preparando'), ('En camino'), ('Entregado'), ('Cancelado');

INSERT IGNORE INTO categorias (slug, nombre) VALUES
('comestibles', 'Comestibles'),
('limpieza', 'Limpieza');

INSERT IGNORE INTO marcas (nombre) VALUES
('Aroma Hogar'),
('Blancura'),
('Brillo'),
('Campo Dorado'),
('Don Grano'),
('Doña Clara'),
('Fuerte'),
('Horno Feliz'),
('Huerta Real'),
('La Pradera'),
('Monte Verde'),
('Natura Fresh'),
('Nonna Bella'),
('Nube'),
('Suavecito'),
('Tambo Viejo'),
('Tostadero Sur'),
('Valle Frutal');

-- ------------------------------------------------------------
-- CREATE: usuarios de prueba
-- Contraseñas: admin123 / cliente123
-- Los hashes son bcrypt ($2y$) generados con password_hash().
-- ------------------------------------------------------------
INSERT IGNORE INTO usuarios (nombre, email, password, rol_id, telefono, direccion)
SELECT 'Administrador ERRE', 'admin@erre.com.ar',
       '$2y$12$cWaDzip/xKaCnMJC5leY4.9fxM/PyABZZlmNwoxJYpXG4f9bFmxSy', r.id,
       '11 4444-0000', 'Av. Corrientes 1234, CABA'
FROM roles r WHERE r.nombre = 'admin';

INSERT IGNORE INTO usuarios (nombre, email, password, rol_id, telefono, direccion)
SELECT 'Cliente ERRE', 'cliente@erre.com.ar',
       '$2y$12$vL4vn3i/cMCq87B2AsPTQOT7uVerIe.Hmgzwyrtno5OD784AICc8y', r.id,
       '11 5555-1111', 'Av. Rivadavia 4520, 3 B, CABA'
FROM roles r WHERE r.nombre = 'usuario';

-- ------------------------------------------------------------
-- CREATE: catálogo completo (24 productos del proyecto)
-- ------------------------------------------------------------
INSERT IGNORE INTO productos (slug, nombre, descripcion, marca_id, categoria_id, tipo, precio, old_price, unidad, imagen, destacado, activo)
SELECT 'leche-entera', 'Leche Entera Larga Vida', 'Leche entera ultrapasteurizada, fuente natural de calcio y proteínas. Ideal para el desayuno, licuados y recetas de todos los días. Una vez abierta, conservar en heladera y consumir dentro de los 3 días.', m.id, c.id, 'Lácteos', 1290.00, 1490.00, '1 L', 'assets/img/products/leche-entera.jpg', 1, 1
FROM marcas m, categorias c
WHERE m.nombre = 'La Pradera' AND c.slug = 'comestibles';

INSERT IGNORE INTO productos (slug, nombre, descripcion, marca_id, categoria_id, tipo, precio, old_price, unidad, imagen, destacado, activo)
SELECT 'arroz-largo-fino', 'Arroz Largo Fino', 'Arroz largo fino tipo 00000, de granos sueltos y cocción pareja en 18 minutos. Perfecto para guarniciones, ensaladas y risottos caseros.', m.id, c.id, 'Almacén', 1850.00, NULL, '1 kg', 'assets/img/products/arroz-largo-fino.jpg', 1, 1
FROM marcas m, categorias c
WHERE m.nombre = 'Don Grano' AND c.slug = 'comestibles';

INSERT IGNORE INTO productos (slug, nombre, descripcion, marca_id, categoria_id, tipo, precio, old_price, unidad, imagen, destacado, activo)
SELECT 'fideos-spaghetti', 'Fideos Spaghetti', 'Spaghetti de sémola de trigo candeal, secado lento para una textura al dente. Cocción: 9 a 11 minutos en abundante agua con sal.', m.id, c.id, 'Almacén', 990.00, NULL, '500 g', 'assets/img/products/fideos-spaghetti.jpg', 0, 1
FROM marcas m, categorias c
WHERE m.nombre = 'Nonna Bella' AND c.slug = 'comestibles';

INSERT IGNORE INTO productos (slug, nombre, descripcion, marca_id, categoria_id, tipo, precio, old_price, unidad, imagen, destacado, activo)
SELECT 'aceite-girasol', 'Aceite de Girasol', 'Aceite puro de girasol, liviano y de sabor neutro. Rico en vitamina E, ideal para frituras, horneados y aderezos.', m.id, c.id, 'Almacén', 2690.00, 3150.00, '1,5 L', 'assets/img/products/aceite-girasol.jpg', 1, 1
FROM marcas m, categorias c
WHERE m.nombre = 'Campo Dorado' AND c.slug = 'comestibles';

INSERT IGNORE INTO productos (slug, nombre, descripcion, marca_id, categoria_id, tipo, precio, old_price, unidad, imagen, destacado, activo)
SELECT 'yerba-mate', 'Yerba Mate Tradicional', 'Yerba mate con palo, elaborada con estacionamiento natural de 12 meses. Sabor intenso y duradero, de rendimiento excepcional.', m.id, c.id, 'Infusiones', 3990.00, NULL, '1 kg', 'assets/img/products/yerba-mate.jpg', 0, 1
FROM marcas m, categorias c
WHERE m.nombre = 'Monte Verde' AND c.slug = 'comestibles';

INSERT IGNORE INTO productos (slug, nombre, descripcion, marca_id, categoria_id, tipo, precio, old_price, unidad, imagen, destacado, activo)
SELECT 'cafe-molido', 'Café Molido Intenso', 'Blend de granos arábica y robusta tostados en el día. Molienda media apta para cafetera de filtro, italiana y prensa francesa.', m.id, c.id, 'Infusiones', 4590.00, 5100.00, '250 g', 'assets/img/products/cafe-molido.jpg', 0, 1
FROM marcas m, categorias c
WHERE m.nombre = 'Tostadero Sur' AND c.slug = 'comestibles';

INSERT IGNORE INTO productos (slug, nombre, descripcion, marca_id, categoria_id, tipo, precio, old_price, unidad, imagen, destacado, activo)
SELECT 'galletitas-dulces', 'Galletitas Dulces de Vainilla', 'Galletitas crocantes con suave sabor a vainilla. El acompañamiento perfecto para el mate o el café con leche.', m.id, c.id, 'Desayuno', 1150.00, NULL, '200 g', 'assets/img/products/galletitas-dulces.jpg', 0, 1
FROM marcas m, categorias c
WHERE m.nombre = 'Doña Clara' AND c.slug = 'comestibles';

INSERT IGNORE INTO productos (slug, nombre, descripcion, marca_id, categoria_id, tipo, precio, old_price, unidad, imagen, destacado, activo)
SELECT 'pan-lactal', 'Pan Lactal Blanco', 'Pan de molde tierno y esponjoso, rebanado. Sin grasas trans. Ideal para tostadas y sándwiches.', m.id, c.id, 'Panadería', 2350.00, NULL, '550 g', 'assets/img/products/pan-lactal.jpg', 0, 1
FROM marcas m, categorias c
WHERE m.nombre = 'Horno Feliz' AND c.slug = 'comestibles';

INSERT IGNORE INTO productos (slug, nombre, descripcion, marca_id, categoria_id, tipo, precio, old_price, unidad, imagen, destacado, activo)
SELECT 'tomate-triturado', 'Tomate Triturado', 'Tomates seleccionados y triturados, listos para salsas, guisos y pizzas. Sin conservantes agregados.', m.id, c.id, 'Almacén', 890.00, NULL, '520 g', 'assets/img/products/tomate-triturado.jpg', 0, 1
FROM marcas m, categorias c
WHERE m.nombre = 'Huerta Real' AND c.slug = 'comestibles';

INSERT IGNORE INTO productos (slug, nombre, descripcion, marca_id, categoria_id, tipo, precio, old_price, unidad, imagen, destacado, activo)
SELECT 'dulce-de-leche', 'Dulce de Leche Clásico', 'Dulce de leche tradicional, cremoso y de color dorado intenso. Para untar, rellenar y disfrutar a cucharadas.', m.id, c.id, 'Desayuno', 2190.00, NULL, '400 g', 'assets/img/products/dulce-de-leche.jpg', 0, 1
FROM marcas m, categorias c
WHERE m.nombre = 'La Pradera' AND c.slug = 'comestibles';

INSERT IGNORE INTO productos (slug, nombre, descripcion, marca_id, categoria_id, tipo, precio, old_price, unidad, imagen, destacado, activo)
SELECT 'manzanas-rojas', 'Manzanas Rojas', 'Manzanas rojas frescas del Alto Valle de Río Negro. Crocantes, dulces y jugosas. Se venden por kilo.', m.id, c.id, 'Frutas y Verduras', 1690.00, NULL, '1 kg', 'assets/img/products/manzanas-rojas.jpg', 1, 1
FROM marcas m, categorias c
WHERE m.nombre = 'Valle Frutal' AND c.slug = 'comestibles';

INSERT IGNORE INTO productos (slug, nombre, descripcion, marca_id, categoria_id, tipo, precio, old_price, unidad, imagen, destacado, activo)
SELECT 'queso-cremoso', 'Queso Cremoso', 'Queso cremoso de pasta blanda y sabor suave. Excelente para fundir en pizzas, tartas y sándwiches calientes.', m.id, c.id, 'Lácteos', 6890.00, 7650.00, '500 g', 'assets/img/products/queso-cremoso.jpg', 0, 1
FROM marcas m, categorias c
WHERE m.nombre = 'Tambo Viejo' AND c.slug = 'comestibles';

INSERT IGNORE INTO productos (slug, nombre, descripcion, marca_id, categoria_id, tipo, precio, old_price, unidad, imagen, destacado, activo)
SELECT 'detergente-lavavajillas', 'Detergente Lavavajillas Limón', 'Detergente concentrado con aroma a limón. Remueve la grasa más difícil y cuida tus manos. Rinde hasta 3 veces más.', m.id, c.id, 'Cocina', 1490.00, 1790.00, '750 ml', 'assets/img/products/detergente-lavavajillas.jpg', 1, 1
FROM marcas m, categorias c
WHERE m.nombre = 'Brillo' AND c.slug = 'limpieza';

INSERT IGNORE INTO productos (slug, nombre, descripcion, marca_id, categoria_id, tipo, precio, old_price, unidad, imagen, destacado, activo)
SELECT 'lavandina', 'Lavandina Concentrada', 'Lavandina de uso general que elimina el 99,9% de gérmenes y bacterias. Diluir según indicaciones. Mantener fuera del alcance de los niños.', m.id, c.id, 'Desinfección', 1290.00, NULL, '2 L', 'assets/img/products/lavandina.jpg', 1, 1
FROM marcas m, categorias c
WHERE m.nombre = 'Blancura' AND c.slug = 'limpieza';

INSERT IGNORE INTO productos (slug, nombre, descripcion, marca_id, categoria_id, tipo, precio, old_price, unidad, imagen, destacado, activo)
SELECT 'jabon-liquido-ropa', 'Jabón Líquido para Ropa', 'Jabón líquido para lavarropas automático y a mano. Fórmula con enzimas que remueve manchas desde el primer lavado.', m.id, c.id, 'Lavado', 7990.00, 9200.00, '3 L', 'assets/img/products/jabon-liquido-ropa.jpg', 1, 1
FROM marcas m, categorias c
WHERE m.nombre = 'Nube' AND c.slug = 'limpieza';

INSERT IGNORE INTO productos (slug, nombre, descripcion, marca_id, categoria_id, tipo, precio, old_price, unidad, imagen, destacado, activo)
SELECT 'limpiador-multiuso', 'Limpiador Multiuso Gatillo', 'Limpiador multisuperficie en spray para vidrios, mesadas y azulejos. No deja marcas ni residuos.', m.id, c.id, 'Superficies', 1890.00, NULL, '500 ml', 'assets/img/products/limpiador-multiuso.jpg', 0, 1
FROM marcas m, categorias c
WHERE m.nombre = 'Brillo' AND c.slug = 'limpieza';

INSERT IGNORE INTO productos (slug, nombre, descripcion, marca_id, categoria_id, tipo, precio, old_price, unidad, imagen, destacado, activo)
SELECT 'papel-higienico', 'Papel Higiénico Doble Hoja', 'Papel higiénico de doble hoja, suave y resistente. Pack de 4 rollos de 30 metros cada uno.', m.id, c.id, 'Higiene', 2490.00, NULL, '4 rollos x 30 m', 'assets/img/products/papel-higienico.jpg', 1, 1
FROM marcas m, categorias c
WHERE m.nombre = 'Suavecito' AND c.slug = 'limpieza';

INSERT IGNORE INTO productos (slug, nombre, descripcion, marca_id, categoria_id, tipo, precio, old_price, unidad, imagen, destacado, activo)
SELECT 'esponjas', 'Esponjas Doble Uso', 'Esponjas con cara abrasiva verde para ollas y cara suave para vajilla delicada. Pack x 3 unidades.', m.id, c.id, 'Cocina', 990.00, NULL, 'Pack x 3', 'assets/img/products/esponjas.jpg', 0, 1
FROM marcas m, categorias c
WHERE m.nombre = 'Brillo' AND c.slug = 'limpieza';

INSERT IGNORE INTO productos (slug, nombre, descripcion, marca_id, categoria_id, tipo, precio, old_price, unidad, imagen, destacado, activo)
SELECT 'desodorante-ambientes', 'Desodorante de Ambientes Lavanda', 'Aerosol con fragancia de lavanda que neutraliza olores y deja una sensación de frescura duradera.', m.id, c.id, 'Ambientes', 1690.00, NULL, '360 ml', 'assets/img/products/desodorante-ambientes.jpg', 0, 1
FROM marcas m, categorias c
WHERE m.nombre = 'Aroma Hogar' AND c.slug = 'limpieza';

INSERT IGNORE INTO productos (slug, nombre, descripcion, marca_id, categoria_id, tipo, precio, old_price, unidad, imagen, destacado, activo)
SELECT 'suavizante', 'Suavizante para Ropa', 'Suavizante concentrado con aroma floral. Deja la ropa suave, perfumada y fácil de planchar.', m.id, c.id, 'Lavado', 2290.00, NULL, '1 L', 'assets/img/products/suavizante.jpg', 0, 1
FROM marcas m, categorias c
WHERE m.nombre = 'Nube' AND c.slug = 'limpieza';

INSERT IGNORE INTO productos (slug, nombre, descripcion, marca_id, categoria_id, tipo, precio, old_price, unidad, imagen, destacado, activo)
SELECT 'shampoo', 'Shampoo Nutrición', 'Shampoo con extractos naturales para todo tipo de cabello. Limpia suavemente y aporta brillo.', m.id, c.id, 'Higiene', 3290.00, 3790.00, '400 ml', 'assets/img/products/shampoo.jpg', 0, 1
FROM marcas m, categorias c
WHERE m.nombre = 'Natura Fresh' AND c.slug = 'limpieza';

INSERT IGNORE INTO productos (slug, nombre, descripcion, marca_id, categoria_id, tipo, precio, old_price, unidad, imagen, destacado, activo)
SELECT 'jabon-tocador', 'Jabón de Tocador Neutro', 'Jabón de tocador neutro, hipoalergénico y con glicerina. Pack de 3 unidades de 90 g.', m.id, c.id, 'Higiene', 1590.00, NULL, '3 x 90 g', 'assets/img/products/jabon-tocador.jpg', 0, 1
FROM marcas m, categorias c
WHERE m.nombre = 'Natura Fresh' AND c.slug = 'limpieza';

INSERT IGNORE INTO productos (slug, nombre, descripcion, marca_id, categoria_id, tipo, precio, old_price, unidad, imagen, destacado, activo)
SELECT 'limpiador-pisos', 'Limpiador de Pisos Lavanda', 'Limpiador líquido para todo tipo de pisos. Perfuma por horas y no requiere enjuague.', m.id, c.id, 'Superficies', 1990.00, NULL, '1,8 L', 'assets/img/products/limpiador-pisos.jpg', 0, 1
FROM marcas m, categorias c
WHERE m.nombre = 'Aroma Hogar' AND c.slug = 'limpieza';

INSERT IGNORE INTO productos (slug, nombre, descripcion, marca_id, categoria_id, tipo, precio, old_price, unidad, imagen, destacado, activo)
SELECT 'bolsas-residuos', 'Bolsas de Residuos Reforzadas', 'Bolsas de residuos de 50 x 70 cm, reforzadas y resistentes a desgarros. Rollo de 30 unidades.', m.id, c.id, 'Hogar', 1390.00, NULL, 'Rollo x 30', 'assets/img/products/bolsas-residuos.jpg', 0, 1
FROM marcas m, categorias c
WHERE m.nombre = 'Fuerte' AND c.slug = 'limpieza';


-- ------------------------------------------------------------
-- CREATE: pedido de prueba con detalle (relación 1:N)
-- ------------------------------------------------------------
INSERT IGNORE INTO pedidos (numero, usuario_id, estado_id, total, metodo_pago, direccion)
SELECT 'ER-DEMO-001', u.id, e.id, 2580.00, 'efectivo', 'Av. Rivadavia 4520, 3 B, CABA'
FROM usuarios u, estados_pedido e
WHERE u.email = 'cliente@erre.com.ar' AND e.nombre = 'Entregado';

INSERT INTO detalle_pedidos (pedido_id, producto_id, cantidad, precio_unitario, subtotal)
SELECT ped.id, pro.id, 2, 1290.00, 2580.00
FROM pedidos ped, productos pro
WHERE ped.numero = 'ER-DEMO-001' AND pro.slug = 'leche-entera'
  AND NOT EXISTS (
      SELECT 1 FROM detalle_pedidos det
      WHERE det.pedido_id = ped.id AND det.producto_id = pro.id
  );

-- ------------------------------------------------------------
-- Consultas de prueba CRUD (TP6, parte 3)
-- Se ejecutan y luego se deshacen para no alterar los datos reales.
-- ------------------------------------------------------------
START TRANSACTION;

-- CREATE
INSERT INTO marcas (nombre) VALUES ('Marca Prueba TP6');

-- READ: WHERE + ORDER BY
SELECT id, nombre FROM marcas
WHERE nombre LIKE 'Marca%'
ORDER BY nombre ASC;

-- READ: INNER JOIN entre tres tablas
SELECT pro.nombre AS producto, mar.nombre AS marca, cat.nombre AS categoria, pro.precio
FROM productos pro
INNER JOIN marcas mar ON mar.id = pro.marca_id
INNER JOIN categorias cat ON cat.id = pro.categoria_id
WHERE cat.slug = 'comestibles'
ORDER BY pro.precio DESC
LIMIT 10;

-- UPDATE: siempre con WHERE
UPDATE productos SET precio = 9999.00 WHERE slug = 'leche-entera';

-- DELETE: siempre con WHERE
DELETE FROM marcas WHERE nombre = 'Marca Prueba TP6';

ROLLBACK;
