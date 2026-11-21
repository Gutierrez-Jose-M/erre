# Proyecto web — Trabajos Prácticos 6 a 10

Proyecto desarrollado en **PHP** y **MySQL** que integra, de forma progresiva, los contenidos de los trabajos prácticos de Programación Web: diseño de base de datos, persistencia con PDO, manejo de sesiones y autenticación, comunicación asíncrona con JSON y organización bajo el patrón MVC.

## Requisitos

- PHP 7.4 o superior (recomendado PHP 8.x).
- MySQL o MariaDB.
- Servidor web con soporte PHP (por ejemplo, Apache en XAMPP).
- Navegador web moderno (para las funciones con Fetch API).

## Estructura del proyecto

- **Raíz (`*.php`)**: páginas principales del sitio y pantallas de administración/gestión.
- **`api/`**: endpoints que devuelven respuestas en formato JSON.
- **`app/`**: componentes bajo patrón MVC.
  - `app/Models/`: acceso a datos y consultas.
  - `app/Controllers/`: lógica de control y coordinación entre modelo y vista.
  - `app/Views/`: vistas utilizadas por los controladores.
- **`assets/`**: recursos estáticos (CSS, JavaScript e imágenes).
- **`config/`**: configuración y conexión a la base de datos (`conexion.php`, `config.example.php`).
- **`includes/`**: archivos comunes y utilidades compartidas (arranque, plantillas, autenticación, helpers, etc.).
- **`framework-module/`**: módulo independiente implementado con un framework PHP (TP10, parte B).
- **`img/`**: capturas/evidencias del proyecto.
- **Archivos de base de datos y documentación**: `schema.sql`, `consultas.sql`, `NORMALIZACION.md`, `BASE_DE_DATOS.md`.

## Contenido por trabajo práctico

### TP 6 — Diseño y esquema relacional (MySQL)
- Definición del esquema de la base de datos con tablas, claves primarias y foráneas, índices y campos de auditoría.
- Scripts SQL para creación y carga/prueba de datos.
- Documentación del proceso de normalización.

**Archivos principales:** `schema.sql`, `consultas.sql`, `NORMALIZACION.md`.

### TP 7 — Conexión PHP-MySQL y CRUD seguro
- Conexión a MySQL mediante **PDO** con manejo de errores.
- Uso de **consultas preparadas** para operaciones de lectura y escritura.
- Implementación de operaciones CRUD integradas al proyecto.

**Archivos principales:** `config/conexion.php`, `admin.php`, `admin_crear.php`, `admin_editar.php`, `admin_eliminar.php`, `app/Models/ProductModel.php`.

### TP 8 — Manejo de estado, sesiones y autenticación
- Registro, inicio y cierre de sesión utilizando `$_SESSION`.
- Almacenamiento seguro de contraseñas con `password_hash()` y verificación con `password_verify()`.
- Protección de rutas y control de acceso por rol.

**Archivos principales:** `login.php`, `registro.php`, `logout.php`, `perfil.php`, `admin_panel.php`, `includes/auth_guard.php`.

### TP 9 — Comunicación asincrónica (AJAX & JSON)
- Endpoint en PHP que responde en formato **JSON** con los encabezados y códigos de estado adecuados.
- Consumo desde el frontend con **Fetch API** (JavaScript asíncrono) para obtener datos y actualizar el DOM sin recargar la página.

**Archivos principales:** `api/buscar_productos.php`, `assets/js/app.js`.

### TP 10 — Arquitectura MVC y framework
- **Parte A:** refactorización de componentes a una estructura **Modelo–Vista–Controlador** en PHP.
- **Parte B:** módulo independiente desarrollado con un framework PHP, organizado con sus rutas, controladores, modelos y vistas.

**Archivos principales:** `app/Models/`, `app/Controllers/`, `app/Views/`, `framework-module/` (ver `framework-module/README.md`).

## Puesta en marcha

1. **Base de datos**
   - Crear/importar la base de datos ejecutando `schema.sql` y luego `consultas.sql` en MySQL/MariaDB (por ejemplo, desde phpMyAdmin).
2. **Configuración**
   - Copiar `config/config.example.php` como `config/config.php`.
   - Completar los datos de conexión según el entorno (host, nombre de base, usuario y contraseña).
3. **Ejecución**
   - Colocar el proyecto en el directorio del servidor web y acceder desde el navegador (por ejemplo, `http://localhost/<carpeta-del-proyecto>/` con XAMPP).

## Documentación adicional

- `BASE_DE_DATOS.md`: guía detallada del esquema y de la carga de la base de datos.
- `NORMALIZACION.md`: desarrollo del proceso de normalización aplicado.
- `framework-module/README.md`: información del módulo implementado con framework.
- `img/`: evidencias y capturas del proyecto.

## Notas

- El archivo `config/config.php` contiene credenciales locales y no debe versionarse; se incluye `config/config.example.php` como plantilla.
- Las consultas a la base de datos se realizan con PDO y sentencias preparadas para mejorar la seguridad y la integridad de las operaciones.
- Las contraseñas se gestionan mediante funciones de hash de PHP (`password_hash` / `password_verify`).
- La estructura del proyecto separa configuración, lógica, vistas, recursos estáticos y endpoints para facilitar el mantenimiento y la comprensión de cada TP.

## Evidencias

Capturas incluidas en la carpeta `img/` con una breve descripción de cada una.

### Base de datos

Estructura de la base de datos y sus tablas en MySQL/phpMyAdmin.

<img src="img/base%20de%20datos.png" alt="Base de datos" width="900">

### Configuración de variables de entorno

Configuración de los datos de conexión a la base de datos para el entorno local.

<img src="img/Configuraci%C3%B3n%20de%20variables%20de%20entorno.png" alt="Configuración de variables de entorno" width="900">

### Errores de validación (campos vacíos)

Mensajes de validación mostrados al enviar un formulario con campos obligatorios sin completar.

<img src="img/Errores%20de%20validaci%C3%B3n%20%28campos%20vac%C3%ADos%29.png" alt="Errores de validación (campos vacíos)" width="900">

### Estructura modular (SSI)

Organización del proyecto en componentes y archivos reutilizables.

<img src="img/Estructura%20modular%20%28SSI%29.png" alt="Estructura modular (SSI)" width="900">

### Estructura modular (SSI) 2

Otra vista de la estructura modular y la separación de archivos del proyecto.

<img src="img/Estructura%20modular%20%28SSI%292.png" alt="Estructura modular (SSI) 2" width="900">

### Navegación dinámica (título + clase active)

Navegación que actualiza el título y resalta la sección activa según la página.

<img src="img/Navegaci%C3%B3n%20din%C3%A1mica%20%28t%C3%ADtulo%20%2B%20clase%20active%29.png" alt="Navegación dinámica (título + clase active)" width="900">

### Pedido recibido

Confirmación de un pedido registrado y procesado correctamente.

<img src="img/pedido%20recibido.png" alt="Pedido recibido" width="900">

### Persistencia de datos (email inválido y mensaje corto)

El formulario conserva los datos ingresados cuando se producen errores de validación.

<img src="img/Persistencia%20de%20datos%20%28email%20inv%C3%A1lido%20y%20mensaje%20corto%29.png" alt="Persistencia de datos (email inválido y mensaje corto)" width="900">

### Protección contra XSS (el código se muestra como texto y no se ejecuta)

La entrada con código se muestra como texto (escapada/sanitizada) y no se ejecuta en el navegador.

<img src="img/Protecci%C3%B3n%20contra%20XSS%20el%20c%C3%B3digo%20scriptalert%281%29script%20se%20muestra%20como%20texto%20y%20no%20se%20ejecuta..png" alt="Protección contra XSS (el código se muestra como texto y no se ejecuta)" width="900">

### Servidor local ejecutándose

Proyecto en ejecución en el servidor local (Apache/XAMPP).

<img src="img/Servidor%20local%20ejecut%C3%A1ndose.png" alt="Servidor local ejecutándose" width="900">
