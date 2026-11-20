# Normalización aplicada al proyecto ERRE (TP6)

## 1. Registro hipotético sin normalizar

Antes del diseño relacional, un pedido se podría guardar como una sola fila con
listas y datos repetidos:

| id | cliente | email | rol | items | categorias | marca | provincia | ciudad |
| --- | --- | --- | --- | --- | --- | --- | --- | --- |
| 1 | Ana Pérez | ana@email.com | usuario | Leche x2, Arroz x1, Jabón x3 | Lácteos, Almacén, Higiene | La Pradera, Don Grano, Brillo | Buenos Aires | CABA |

Problemas:

- `items`, `categorias` y `marca` son **campos multivaluados** (rompen 1FN).
- El nombre y el email del cliente se repiten en cada pedido (redundancia).
- El rol depende del cliente, no del pedido (dependencia transitiva).
- La provincia depende de la ciudad, no del pedido (dependencia transitiva).
- Para agregar un producto al pedido hay que editar un texto, no una fila.

## 2. Proceso de normalización

### 1FN — campos atómicos

Se elimina la lista de ítems: cada producto del pedido pasa a una fila propia.

| pedido_id | producto | cantidad |
| --- | --- | --- |
| 1 | Leche Entera | 2 |
| 1 | Arroz Largo Fino | 1 |
| 1 | Jabón Líquido | 3 |

Además, `nombre` y `email` del cliente dejan de guardarse dentro del pedido:
el pedido solo referencia al cliente por su `id`.

### 2FN — sin dependencias parciales

La tabla de detalle usa una clave primaria compuesta `(pedido_id, producto_id)`.
Los datos que dependen solo del producto (nombre, marca, categoría, precio) se
mueven a su propia tabla `productos`. En `detalle_pedidos` quedan únicamente
`cantidad`, `precio_unitario` y `subtotal`, que sí dependen de la combinación
pedido + producto.

### 3FN — sin dependencias transitivas

Se extraen a tablas propias los atributos que dependen de otros atributos no clave:

- `roles` → el rol depende del usuario, no del pedido.
- `categorias` → la categoría depende del producto.
- `marcas` → la marca depende del producto.
- `estados_pedido` → el estado depende del pedido, pero es un dominio separado.

Resultado: cambiar el nombre de una marca o de un rol se hace en **un solo lugar**.

## 3. Tablas resultantes

| Tabla | PK | FK |
| --- | --- | --- |
| `roles` | `id` | — |
| `categorias` | `id` | — |
| `marcas` | `id` | — |
| `estados_pedido` | `id` | — |
| `usuarios` | `id` | `rol_id → roles.id` |
| `productos` | `id` | `marca_id → marcas.id`, `categoria_id → categorias.id` |
| `pedidos` | `id` | `usuario_id → usuarios.id`, `estado_id → estados_pedido.id` |
| `detalle_pedidos` | `id` | `pedido_id → pedidos.id`, `producto_id → productos.id` |
| `consultas` | `id` | — |

## 4. Decisiones técnicas

- Todas las PK son `INT AUTO_INCREMENT`.
- Las FK usan `ON UPDATE CASCADE`; `detalle_pedidos` usa `ON DELETE CASCADE`
  para que al borrar un pedido se borren sus líneas.
- Tablas principales con `created_at` y `updated_at`.
- Índices explícitos (`CREATE INDEX`) sobre `email`, `categoria_id`, `marca_id`,
  `usuario_id` y `pedido_id`, campos usados con frecuencia en filtros y JOIN.
- `password` es `VARCHAR(255)` porque guarda el hash bcrypt de `password_hash()`.
- `precio`, `old_price`, `precio_unitario` y `subtotal` son `DECIMAL(10,2)`
  para evitar errores de coma flotante con dinero.
