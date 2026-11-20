# TP10 — Parte B: módulo con framework (CodeIgniter 4)

Este módulo **no forma parte del sitio principal**. El e-commerce ERRE sigue siendo
PHP puro (sin Composer) para poder subirse por WinSCP a InfinityFree.

Acá está la implementación de un módulo independiente en **CodeIgniter 4** que
reutiliza la misma base de datos MySQL (`schema.sql` + `consultas.sql`).

## Cómo probarlo

En XAMPP (con Composer instalado):

```bash
composer create-project codeigniter4/appstarter erre-ci4
cd erre-ci4
```

Copiá los archivos de esta carpeta dentro del proyecto CI4:

- `app/Config/Routes.php` → `app/Config/Routes.php` (agregá las rutas; no reemplaces
  las existentes si ya tenés otras).
- `app/Controllers/Productos.php` → `app/Controllers/Productos.php`
- `app/Controllers/ProductoApi.php` → `app/Controllers/ProductoApi.php`
- `app/Models/ProductoModel.php` → `app/Models/ProductoModel.php`
- `app/Views/productos/index.php` → `app/Views/productos/index.php`

Configurá la BD en `app/Config/Database.php` con los mismos datos de
`config/config.php` del proyecto principal. Después iniciá el servidor:

```bash
php spark serve
```

Rutas del módulo:

- `http://localhost:8080/productos` → vista con el motor de plantillas de CI4.
- `http://localhost:8080/api/productos?q=leche` → API REST que devuelve JSON.
- `http://localhost:8080/api/productos/1` → un producto por id (404 si no existe).

## Qué cumple del TP10

| Requisito | Archivo |
| --- | --- |
| Enrutamiento (Routing) | `app/Config/Routes.php` |
| Controlador propio del framework | `app/Controllers/Productos.php`, `ProductoApi.php` |
| Modelo con ORM/Query Builder | `app/Models/ProductoModel.php` |
| Vista con motor de plantillas | `app/Views/productos/index.php` |
