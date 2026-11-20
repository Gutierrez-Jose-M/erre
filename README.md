# ERRE Supermercado — versión PHP + MySQL

Tienda online de comestibles y limpieza migrada de React/TanStack a **PHP puro con MySQL (PDO)**. Sin Composer ni frameworks en el sitio principal: funciona en **XAMPP** y en hosting compartido como **InfinityFree**, subiendo por **WinSCP**.

Los trabajos prácticos 6, 7, 8, 9 y 10 están integrados en el proyecto. Guía rápida: [`BASE_DE_DATOS.md`](BASE_DE_DATOS.md).

## Estructura principal

```
index.php / comestibles.php / limpieza.php / producto.php
buscar.php / carrito.php / checkout.php / contacto.php
login.php / registro.php / logout.php / perfil.php
admin_panel.php / admin.php / admin_crear.php / admin_editar.php / admin_eliminar.php
api/buscar_productos.php          Endpoint JSON (Fetch API)
config/conexion.php               Conexión PDO con try-catch
config/config.example.php         Copiar a config/config.php
schema.sql                        DDL: 9 tablas, PK/FK/índices (TP6)
consultas.sql                     Datos iniciales + CRUD de prueba (TP6)
NORMALIZACION.md                  1FN/2FN/3FN aplicadas (TP6)
BASE_DE_DATOS.md                  Paso a paso para crear la BD
app/Models/                       Consultas SQL (TP10-A)
app/Controllers/                  Lógica de request (TP10-A)
app/Views/                        HTML del catálogo (TP10-A)
framework-module/                 Módulo CodeIgniter 4 (TP10-B)
includes/                         Bootstrap, plantillas y funciones compartidas
assets/css/styles.css             Diseño del proyecto original
assets/js/app.js                  Búsqueda asíncrona, menú, tabs y controles
```

## Instalación local (XAMPP)

1. Iniciá Apache y MySQL.
2. Copiá la carpeta a `C:\xampp\htdocs\erre`.
3. En phpMyAdmin ejecutá `schema.sql` y después `consultas.sql` (ver [`BASE_DE_DATOS.md`](BASE_DE_DATOS.md)).
4. Copiá `config/config.example.php` a `config/config.php`. En XAMPP los valores por defecto funcionan.
5. Entrá a `http://localhost/erre`.

## Subir a InfinityFree con WinSCP

1. Creá la base MySQL y el usuario en el panel; anotá host, BD, usuario y contraseña.
2. Importá `schema.sql` y `consultas.sql` desde phpMyAdmin.
3. Editá `config/config.php` con esos datos.
4. En WinSCP: sesión **SFTP** con los datos del hosting → subí **todo el contenido** de esta carpeta a `htdocs/`.
5. Probá `http://tu-dominio.infinityfreeapp.com`. Permisos: archivos `644`, carpetas `755`.

## Usuarios de prueba

| Email | Contraseña | Rol |
| --- | --- | --- |
| `admin@erre.com.ar` | `admin123` | admin |
| `cliente@erre.com.ar` | `cliente123` | usuario |

## Cómo se comportan los datos

- **Catálogo:** se lee de MySQL (`productos` + `marcas` + `categorias`). Si no hay BD, se usa el array estático de `includes/products.php` para que el sitio no se rompa.
- **Carrito:** se guarda en `$_SESSION['cart']` (no requiere tabla). El cálculo de envío sigue en `shipping_for()`.
- **Pedidos:** se guardan en `pedidos` y `detalle_pedidos` con transacción y consultas preparadas. Si no hay BD, quedan solo en sesión.
- **Login/registro:** reales, contra `usuarios`. Contraseñas con `password_hash()` / `password_verify()`, `session_regenerate_id(true)`, guardián de rutas y control por rol.
- **Contacto:** guarda cada mensaje en `consultas` (además del avisos en pantalla).
- **Búsqueda:** el header usa `fetch()` a `api/buscar_productos.php?q=...`; `buscar.php` sigue funcionando sin JavaScript.

## Cumplimiento de los TPs

| TP | Implementación |
| --- | --- |
| 6 — Esquema relacional | `schema.sql`, `consultas.sql`, `NORMALIZACION.md` |
| 7 — PDO + CRUD seguro | `config/conexion.php`, `admin*.php`, `app/Models/ProductModel.php`, `htmlspecialchars()` en vistas |
| 8 — Sesiones y autenticación | `login.php`, `registro.php`, `logout.php`, `includes/auth_guard.php`, `admin_panel.php` |
| 9 — AJAX & JSON | `api/buscar_productos.php` + `assets/js/app.js` (Fetch, async/await, try/catch, DOM dinámico) |
| 10 — MVC y framework | Parte A: `app/Models|Controllers|Views`. Parte B: `framework-module/` (CodeIgniter 4) |

## Comandos útiles

```bash
# Validar JS (si tenés Node)
node --check assets/js/app.js

# Servir CodeIgniter del TP10-B (requiere Composer)
cd framework-module   # copiar archivos en un proyecto codeigniter4/appstarter
php spark serve
```
