# 🛒 ERRE — Tienda Online de Comestibles y Limpieza

Plataforma web multipágina de comercio electrónico dedicada a la venta de artículos de limpieza y comestibles. Nacida como un proyecto de uso personal y familiar, está desarrollada íntegramente en **PHP** y **MySQL** con una arquitectura modular y escalable, pensada para su futuro lanzamiento comercial.

---

## ✨ Características Principales

* **Tienda Online Multipágina:** Catálogo dividido por rubros con navegación fluida entre Inicio, Comestibles, Limpieza, Búsqueda, Detalle de producto, Nosotros, Servicios y Contacto.
* **Catálogo Dinámico:** Listado completo con nombre, marca, categoría, tipo, precio, precio anterior/oferta, unidad de medida, imagen y descripción, incluyendo una sección de productos destacados.
* **Búsqueda en Tiempo Real y Filtrado:** Buscador predictivo con sugerencias instantáneas mediante AJAX (sin recargar la página) y filtros combinables por tipo, marca, rango de precio, ofertas y ordenamiento.
* **Carrito de Compras Persistente:** Gestión completa de ítems (agregar, modificar cantidades, eliminar y vaciar carrito) respaldada en la sesión del usuario.
* **Flujo de Checkout y Pedidos:** Resumen de compra, carga de datos de envío con cálculo dinámico de costo según subtotal, y confirmación con registro transaccional en base de datos.
* **Gestión de Usuarios y Roles:** Registro, inicio/cierre de sesión, perfil de usuario con historial de compras y control de acceso diferenciado (`admin` / `usuario`).
* **Panel de Administración (CRUD):** Gestión integral de productos (alta, edición, baja y listado) desde la web, con creación o selección rápida de marcas.
* **Formulario de Contacto:** Validación doble (cliente y servidor), almacenamiento de consultas en base de datos y protección contra reenvío de formularios (patrón PRG).
* **Seguridad Web:** Contraseñas encriptadas (`password_hash`), consultas preparadas con PDO para prevenir inyección SQL y escapado de salida contra ataques XSS.

---

## 🛠️ Tecnologías Aplicadas

| Capa / Área | Tecnologías y Herramientas |
| :--- | :--- |
| **Backend** | PHP 8+, manejo de sesiones, patrón Post/Redirect/Get (PRG). |
| **Base de Datos** | MySQL (esquema relacional normalizado, claves primarias/foráneas, índices y auditoría). |
| **Acceso a Datos** | PDO con consultas preparadas y manejo de excepciones. |
| **Frontend** | HTML5, CSS3 (`assets/css/styles.css`), JavaScript Vanilla (`assets/js/app.js`). |
| **Asincronía** | Fetch API consumiendo endpoints JSON (`api/buscar_productos.php`). |
| **Arquitectura** | Patrón MVC nativo (`app/`) + Componentes reutilizables (`includes/`). |
| **Framework (Módulo)** | Módulo complementario independiente desarrollado en **CodeIgniter 4** (`framework-module/`). |
| **Entorno y Control** | Apache / XAMPP en local, compatible con hosting PHP/MySQL. Control de versiones con Git y GitHub. |

---

## 📂 Estructura del Proyecto

```text
erre/
├── api/
│   └── buscar_productos.php        # Endpoint JSON para búsqueda asíncrona (TP9)
├── app/                            # Organización MVC nativa (TP10-A)
│   ├── Controllers/
│   │   └── CatalogController.php   # Controlador del catálogo
│   ├── Models/
│   │   └── ProductModel.php        # Acceso a datos de productos/marcas/categorías (PDO)
│   └── Views/
│       └── catalog.php             # Vista del catálogo
├── assets/
│   ├── css/
│   │   └── styles.css              # Estilos principales del sitio
│   ├── img/
│   │   ├── hero-erre.jpg
│   │   ├── nosotros-tienda.jpg
│   │   └── products/               # Imágenes del catálogo de productos
│   ├── js/
│   │   └── app.js                  # Lógica frontend y Fetch API para búsqueda dinámica
│   └── favicon.ico
├── config/
│   ├── conexion.php                # Conexión PDO a MySQL
│   └── config.example.php          # Plantilla de configuración (config.php ignorado en Git)
├── framework-module/               # Módulo independiente en CodeIgniter 4 (TP10-B)
│   ├── app/
│   │   ├── Config/
│   │   ├── Controllers/
│   │   ├── Models/
│   │   └── Views/
│   │       └── productos/
│   └── README.md                   # Documentación específica del módulo CodeIgniter
├── img/                            # Capturas de pantalla y evidencias del README
├── includes/                       # Componentes y lógica compartida
│   ├── auth_guard.php              # Protección de rutas y control de roles (TP8)
│   ├── bootstrap.php               # Inicialización global del sistema
│   ├── cart.php                    # Lógica del carrito y cálculo de envío
│   ├── catalog_view.php            # Renderizado compartido de grillas de productos
│   ├── footer.php                  # Pie de página global
│   ├── header.php                  # Cabecera y barra de navegación
│   ├── helpers.php                 # Funciones auxiliares y sanitización
│   ├── icons.php                   # Librería de iconos SVG
│   ├── products.php                # Catálogo de respaldo (fallback)
│   └── ui.php                      # Componentes de interfaz reutilizables
├── .htaccess                       # Reglas de servidor Apache y seguridad
├── .gitignore
├── 404.php
├── admin.php                       # Listado y gestión administrativa de productos
├── admin_crear.php                 # Formulario de alta de producto
├── admin_editar.php                # Formulario de edición de producto
├── admin_eliminar.php              # Baja de producto
├── admin_panel.php                 # Dashboard de administración
├── buscar.php                      # Resultados de búsqueda (con fallback sin JS)
├── carrito.php                     # Vista y gestión del carrito de compras
├── checkout.php                    # Proceso de finalización de compra
├── comestibles.php                 # Sección de comestibles
├── contacto.php                    # Formulario de contacto
├── index.php                       # Página principal
├── limpieza.php                    # Sección de artículos de limpieza
├── login.php                       # Inicio de sesión
├── logout.php                      # Cierre de sesión
├── nosotros.php                    # Información institucional
├── perfil.php                      # Perfil de usuario e historial de pedidos
├── producto.php                    # Vista de detalle de producto
├── registro.php                    # Registro de nuevos usuarios
├── servicios.php                   # Servicios ofrecidos
├── schema.sql                      # Estructura de la base de datos MySQL (TP6)
├── consultas.sql                   # Datos iniciales y consultas de prueba (TP6)
├── BASE_DE_DATOS.md                # Guía de instalación e importación de BD
├── NORMALIZACION.md                # Documentación del modelo relacional
├── README.md                       # Documentación principal
└── robots.txt
```

## ⚙️ Arquitectura e Implementación Técnica

### Servidor Local en Ejecución
Entorno montado sobre Apache y MySQL mediante XAMPP para desarrollo y pruebas locales.

![Servidor Local](<img/Servidor local ejecutándose.png>)

### Estructura Modular
Separación de responsabilidades mediante archivos incluidos (`header.php`, `footer.php`, `bootstrap.php`) para evitar duplicación de código y facilitar el mantenimiento.

![Estructura Modular1](<img/Estructura modular (SSI).png>)
![Estructura Modular2](<img/Estructura modular (SSI)2.png>)

### Navegación Dinámica
Asignación automática del título de página y marcado visual (`class="active"`) en el menú según la ruta actual del usuario.

![Navegación Dinámica](<img/Navegación dinámica (título + clase active).png>)

### Configuración de Variables de Entorno
Aislamiento de credenciales sensibles de la base de datos mediante `config.php` (excluido del repositorio vía `.gitignore`) utilizando `config.example.php` como plantilla base.

![Configuración de Variables de Entorno](<img/Configuración de variables de entorno.png>)

---

## 🛡️ Procesamiento de Formularios y Seguridad Web

### Formulario de Contacto de ERRE
Formulario de Contacto de ERRE
Canal directo de comunicación para que visitantes y clientes envíen consultas, dudas sobre pedidos o sugerencias.

Campos solicitados:

Nombre: Identifica al remitente.

Email: Dirección de correo para responder la consulta.

Asunto: Motivo principal del contacto.

Mensaje: Desarrollo detallado de la consulta o comentario.

Flujo de procesamiento:

Envío: Al presionar "Enviar mensaje", los datos viajan mediante método POST.

Doble Validación: Se verifica tanto en el navegador (HTML5/JS) como en el servidor (PHP) que no existan campos vacíos y que el correo tenga un formato válido.

Manejo de Errores: Si algún dato falla, se detiene el proceso, se conservan los datos válidos ingresados y se muestran alertas específicas.

Almacenamiento y Confirmación: Si la validación es exitosa, el mensaje se guarda en MySQL y se notifica al usuario que recibirá respuesta dentro de las 24 horas.

Prevención de Reenvíos: Se aplica redirección controlada tras el envío para evitar duplicar registros si el usuario recarga la página (F5).

#### Evidencias de Validación y Seguridad

* **Errores de validación (campos vacíos):**
  ![Errores de validación](<img/Errores de validación (campos vacíos).png>)

* **Persistencia de datos (email inválido y mensaje corto):**
  ![Persistencia de datos](<img/Persistencia de datos (email inválido y mensaje corto).png>)

* **Protección contra XSS (`<script>alert(1)</script>` escapado como texto plano sin ejecutarse):**
  ![Protección contra XSS](<img/Protección contra XSS el código scriptalert(1)script se muestra como texto y no se ejecuta..png>)

* **Envío exitoso y confirmación al usuario:**
  ![Envío exitoso](<img/Envío exitoso.png>)

---

## 🗄️ Base de Datos Relacional

El sistema utiliza MySQL con un diseño normalizado (ver `NORMALIZACION.md` y `BASE_DE_DATOS.md`) que garantiza la integridad referencial entre usuarios, productos, marcas, categorías y pedidos.

### Tablas, Claves Primarias y Foráneas
![base de datos](<img/base de datos.png>)
![Tablas, Claves Primarias](<img/Tablas, claves primarias y foráneas.png>)

### Funcionamiento de la Base de Datos
![Funcionamiento1](<img/Funcionamiento base de datos  (1).png>)

![Funcionamiento2](<img/Funcionamiento base de datos  (2).png>)

![Funcionamiento3](<img/Funcionamiento base de datos  (3).png>)

---

## 🛍️ Flujo de Compra del Usuario

### 1. Lista de Productos
Exploración del catálogo con filtros, precios, ofertas destacadas y acceso rápido al detalle o al carrito.

![Lista de Productos](<img/Lista de productos.png>)

### 2. Carrito de Compras
Control de unidades, eliminación de artículos y cálculo parcial de la compra.

![Carrito de Compras](<img/Carrito.png>)

### 3. Datos de Envío
Formulario de checkout con validación de dirección y cálculo automático del costo de envío según el subtotal.

![Datos de Envío](<img/Datos de envio.png>)

### 4. Confirmación de Pedido
Registro definitivo de la orden en la base de datos con resumen detallado para el cliente.

![Confirmación de Pedido](<img/confirmacion de pedido.png>)

### 5. Cancelar Compra / Vaciar Carrito
Opción para anular el proceso en curso y limpiar el estado de la sesión de forma segura.

![Cancelar Compra / Vaciar Carrito](<img/cancelar compra.png>)
## 🔒 Seguridad y Mejoras Futuras

### Medidas de Seguridad Implementadas
* **Contraseñas Encriptadas:** Uso de `password_hash()` y `password_verify()` (bcrypt) en el registro e inicio de sesión (`login.php`, `registro.php`).
* **Gestión Segura de Sesiones:** Cookies configuradas con `httponly`, `samesite=Lax`, `secure` (bajo HTTPS) y regeneración de ID con `session_regenerate_id(true)` (`includes/bootstrap.php`).
* **Control de Acceso por Roles:** Protección de vistas privadas y administrativas mediante `require_login()` y `require_role('admin')` (`includes/auth_guard.php`).
* **Prevención de Inyección SQL y XSS:** Consultas preparadas con PDO (`PDO::ATTR_EMULATE_PREPARES = false`) y escapado de salida HTML con `htmlspecialchars()` (`includes/helpers.php`).
* **Validación y Protección de Archivos:** Validación de datos en servidor, bloqueo de acceso directo a carpetas internas y dotfiles vía `.htaccess`, y exclusión de credenciales (`config/config.php`) mediante `.gitignore`.

### Alcance Actual y Próximos Pasos (Roadmap)
* **Protección CSRF y Rate Limiting:** Incorporar tokens CSRF en formularios `POST` y limitar intentos fallidos de inicio de sesión o peticiones a la API.
* **Manejo de Errores en Producción:** Reemplazar los detalles técnicos de conexión (`db_requerida()`) por mensajes genéricos al usuario, derivando el detalle a logs internos.
* **Pasarela de Pago Real:** Integrar un procesador de pagos externo (como Mercado Pago) para reemplazar el flujo de checkout demostrativo actual.
* **Carga Segura de Imágenes:** Implementar subida directa de archivos en el panel admin con validación estricta de formato MIME, peso y renombrado seguro.
* **Endurecimiento del Servidor:** Configurar cabeceras HTTP de seguridad (`CSP`, `X-Frame-Options`, `HSTS`) y certificado SSL activo en el entorno de producción.