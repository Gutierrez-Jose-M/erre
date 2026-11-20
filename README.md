# Proyecto web — Trabajos Prácticos 6 a 10

Proyecto en PHP y MySQL que integra los contenidos de los trabajos prácticos de Programación Web.

## Contenido por TP

- **TP6 — Diseño y esquema relacional (MySQL)**  
  `schema.sql` (creación de la base de datos y tablas con PK, FK, índices y campos de auditoría), `consultas.sql` (datos iniciales y consultas CRUD de prueba) y `NORMALIZACION.md` (proceso de normalización).

- **TP7 — Conexión PHP-MySQL y CRUD seguro**  
  Conexión con PDO y consultas preparadas en `config/conexion.php`, y módulo CRUD integrado al proyecto (`admin.php`, `admin_crear.php`, `admin_editar.php`, `admin_eliminar.php`, `app/Models/ProductModel.php`).

- **TP8 — Sesiones y autenticación**  
  Registro, inicio y cierre de sesión con `$_SESSION`, hash de contraseñas (`password_hash`/`password_verify`), protección de rutas y control de acceso por rol (`login.php`, `registro.php`, `logout.php`, `includes/auth_guard.php`).

- **TP9 — Comunicación asincrónica (AJAX & JSON)**  
  Endpoint PHP que responde en JSON (`api/buscar_productos.php`) y consumo desde el frontend con Fetch API para actualizar el DOM sin recargar la página (`assets/js/app.js`).

- **TP10 — MVC y framework**  
  Refactorización a Modelo-Vista-Controlador en `app/Models`, `app/Controllers` y `app/Views`, y módulo independiente implementado con un framework PHP en `framework-module/`.

## Puesta en marcha básica

1. Crear la base de datos e importar `schema.sql` y luego `consultas.sql` en MySQL.
2. Copiar `config/config.example.php` como `config/config.php` y completar los datos de conexión.
3. Ejecutar el proyecto en un servidor con PHP y MySQL (por ejemplo, Apache/XAMPP).

Para más detalle sobre el esquema y la carga de datos, ver `BASE_DE_DATOS.md`.
