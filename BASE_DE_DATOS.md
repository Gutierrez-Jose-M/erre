# Qué tenés que crear en la base de datos (TP6 → TP10)

Resumen para el docente / para ti: **una base MySQL llamada `erre_supermercado` con 9 tablas**, cargada con los scripts `schema.sql` y `consultas.sql`.

## 1. Datos de la base

| Concepto | Valor sugerido |
| --- | --- |
| Motor | MySQL / MariaDB (XAMPP, Laragon o InfinityFree) |
| Nombre de la BD | `erre_supermercado` |
| Usuario local (XAMPP) | `root` |
| Contraseña local | (vacía) |
| Charset | `utf8mb4` |
| Collation | `utf8mb4_unicode_ci` |

En InfinityFree el proveedor te da **host, nombre de BD, usuario y contraseña** propios. Esos valores van en `config/config.php`.

## 2. Tablas que crea `schema.sql`

| # | Tabla | Para qué sirve |
| --- | --- | --- |
| 1 | `roles` | `admin` / `usuario` (control de acceso del TP8) |
| 2 | `categorias` | Comestibles / Limpieza (3FN) |
| 3 | `marcas` | Marcas de los productos (3FN) |
| 4 | `estados_pedido` | Preparando, En camino, Entregado, Cancelado |
| 5 | `usuarios` | Login real con hash bcrypt + rol (TP8) |
| 6 | `productos` | Catálogo del e-commerce (TP7) |
| 7 | `pedidos` | Compras con usuario, estado y total |
| 8 | `detalle_pedidos` | Ítems de cada pedido (relación 1:N) |
| 9 | `consultas` | Mensajes del formulario de contacto |

Cada tabla principal incluye `created_at` y `updated_at`. Hay claves primarias autoincrementales, claves foráneas e índices explícitos (`CREATE INDEX`).

## 3. Opción A: XAMPP (local)

1. Abrí el panel de XAMPP → **Start** en Apache y MySQL.
2. Entrá a `http://localhost/phpmyadmin`.
3. Pestaña **SQL** → pegá todo el contenido de `schema.sql` → **Continuar/Go**.
4. Volvé a la pestaña **SQL** → pegá todo `consultas.sql` → **Continuar/Go**.
5. Copiá `config/config.example.php` a `config/config.php`. Para XAMPP podés dejar los valores por defecto.
6. Abrí `http://localhost/erre/index.php`.

Si phpMyAdmin no permite `CREATE DATABASE`, creala desde la pestaña **Bases de datos** con el nombre `erre_supermercado` y luego ejecutá solo desde la línea `USE erre_supermercado;`.

## 4. Opción B: InfinityFree ( hosting )

1. En el panel de InfinityFree: **MySQL Databases** → **Create Database**. Anotá el nombre (ej. `epiz_12345678_erre`).
2. **Create User** → anotá usuario y contraseña.
3. **Add User To Database** → marcá **ALL PRIVILEGES**.
4. Abrí **phpMyAdmin** desde el panel → seleccioná tu base → pestaña **SQL**.
5. Pegá `schema.sql`. Si el usuario no tiene permiso para `CREATE DATABASE`, borrá las primeras líneas y dejá solo `USE tu_nombre_de_bd;`.
6. Pegá `consultas.sql` (también adaptando el `USE`).
7. En WinSCP, copiá `config/config.example.php` como `config/config.php` y editá:

```php
define('DB_HOST', 'sqlXXX.infinityfree.com'); // el que te da el panel
define('DB_NAME', 'epiz_12345678_erre');
define('DB_USER', 'epiz_12345678');
define('DB_PASS', 'tu-contraseña-del-panel');
define('DB_CHARSET', 'utf8mb4');
```

8. Subí todo por WinSCP a `htdocs/`. `config/config.php` **no se sube al repositorio Git**, pero sí al servidor (está en `.gitignore`).

## 5. Usuarios de prueba que cargan los scripts

| Email | Contraseña | Rol |
| --- | --- | --- |
| `admin@erre.com.ar` | `admin123` | admin |
| `cliente@erre.com.ar` | `cliente123` | usuario |

También podés registrarte desde `registro.php`: el alta usa `password_hash()` y crea el usuario con rol `usuario`.

## 6. Cómo verificar que quedó bien

| Prueba | Resultado esperado |
| --- | --- |
| `index.php` | Catálogo con 24 productos (si hay BD, vienen de MySQL) |
| Buscar "leche" en el header | Sugerencias sin recargar (Fetch API → `api/buscar_productos.php`) |
| `api/buscar_productos.php?q=leche` | JSON con `"status":"success"` |
| `api/buscar_productos.php?slug=no-existe` | HTTP 404 con JSON de error |
| Login con `admin@erre.com.ar` | Redirige a `perfil.php` |
| `admin_panel.php` sin login | Redirige a `login.php?error=acceso_denegado` |
| `admin.php` con usuario `cliente` | Redirige a `perfil.php?error=sin_permisos` |
| Alta/edición/baja en `admin.php` | Cambios visibles de inmediato en el catálogo |
| Comprar en `checkout.php` | Nuevo pedido en `pedidos` + filas en `detalle_pedidos` |

## 7. Solución de problemas

- **"No se pudo conectar a MySQL"**: revisá `config/config.php` y que el usuario tenga permisos sobre la BD.
- **Catálogo vacío después de conectar**: ejecutá `consultas.sql`; el catálogo se lee desde MySQL y el fallback estático solo se usa si no hay base.
- **Error de FK al insertar**: falta ejecutar primero la parte de `roles`, `categorias` y `marcas` de `consultas.sql`.
- **El buscador no responde**: abrí `api/buscar_productos.php?q=leche` directo; si da 503 es un problema de conexión.
- **En InfinityFree el host no es `localhost`**: copiá el host MySQL exacto que muestra el panel.

## 8. Relación con los trabajos prácticos

| TP | Dónde está |
| --- | --- |
| TP6 | `schema.sql`, `consultas.sql`, `NORMALIZACION.md` |
| TP7 | `config/conexion.php`, `admin*.php`, `app/Models/ProductModel.php` |
| TP8 | `login.php`, `registro.php`, `logout.php`, `includes/auth_guard.php`, `admin_panel.php` |
| TP9 | `api/buscar_productos.php`, `assets/js/app.js` |
| TP10 A | `app/Models/`, `app/Controllers/`, `app/Views/` |
| TP10 B | `framework-module/` (CodeIgniter 4) |
