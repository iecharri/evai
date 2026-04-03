# EVAi — Entorno Virtual de Aprendizaje Interactivo

Plataforma educativa web desarrollada en PHP/MySQL. Permite gestión de alumnos, profesores, asignaturas, foros, chat, cuestionarios, notas, agenda y más.

Demo pública: [evaidemo.org](https://evaidemo.org)

---

## Requisitos del servidor

| Componente | Versión mínima recomendada |
|---|---|
| PHP | 7.4 o superior (recomendado 8.1+) |
| MySQL / MariaDB | 5.7 / 10.3 o superior |
| Apache | 2.4 con `mod_rewrite` habilitado |
| Extensiones PHP | `mysqli`, `mbstring`, `curl`, `gd`, `zip`, `intl` |

> Compatible con hosting compartido estándar (cPanel, Plesk, etc.)

---

## Estructura de carpetas

```
evai/                        ← Raíz pública (DocumentRoot o subdirectorio)
│
├── config.php               ← ⚠️ Configuración principal (NO subir con credenciales reales)
├── index.php                ← Entrada: redirige a login
├── login.php                ← Pantalla de acceso
├── siempre.php              ← Bootstrap de sesión (incluido en todas las páginas)
│
├── css/                     ← Estilos y temas de color
├── js/                      ← JavaScript propio
├── jqueryetc/               ← jQuery y plugins
├── media/                   ← Imágenes, emoticonos, sonidos
├── phpmailer/               ← Envío de correo (PHPMailer)
├── lib/                     ← Librerías (QR code, etc.)
│
├── chat/                    ← Módulo de chat en tiempo real
├── chatmini/                ← Chat simplificado
├── cuest/                   ← Cuestionarios y evaluaciones
├── pod/                     ← Panel de administración (podio)
├── soloprof/                ← Herramientas exclusivas de profesores
├── bancot/                  ← Banco de actividades
├── clasedir/                ← Clase directa / videoconferencia
│
└── tmp/                     ← Archivos temporales (debe tener permisos de escritura)
```

**Carpeta privada** (fuera del DocumentRoot, no accesible desde web):
```
/ruta/privada/evai/
└── logs/
    └── php-error.log
```

---

## Instalación paso a paso

### 1. Subir los archivos

Sube el contenido de la carpeta `evai/` al servidor, dentro del DocumentRoot (o en un subdirectorio como `/evai0`).

```bash
# Ejemplo con FTP o scp
scp -r evai/ usuario@servidor:/public_html/
```

### 2. Crear las bases de datos

EVAi usa **dos bases de datos** MySQL:

- `evai` — datos principales (usuarios, asignaturas, notas, foros...)
- `cuest` — cuestionarios y evaluaciones

Crea ambas desde phpMyAdmin o por línea de comandos:

```sql
CREATE DATABASE nombre_evai CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE DATABASE nombre_cuest CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

Luego importa los ficheros `.sql` correspondientes:

```bash
mysql -u usuario -p nombre_evai  < evai.sql
mysql -u usuario -p nombre_cuest < cuest.sql
```

### 3. Configurar `config.php`

Copia el archivo de ejemplo y edítalo con tus datos:

```bash
cp config.example.php config.php
```

Edita los valores de tu entorno:

```php
define('DB_HOST', 'localhost');
define('DB_USER', 'tu_usuario_mysql');
define('DB_PASS', 'tu_contraseña');
define('DB1', 'nombre_evai');
define('DB2', 'nombre_cuest');

define('APP_URL', '');        // Vacío si está en raíz. '/evai0' si está en subdirectorio
define('APP_DIR', __DIR__);
define('BASE_DIR', $_SERVER['DOCUMENT_ROOT']);
define('DATA_DIR', '/ruta/fuera/del/public_html/evai');  // Carpeta privada para logs
define('MEDIA_DIR', APP_DIR . '/media');
define('MEDIA_URL', APP_URL . '/media');
```

Para el correo (notificaciones, recuperación de contraseña):

```php
define('SMTP', 'smtp.gmail.com');
define('USERNAME', 'tucuenta@gmail.com');
define('PASSMAIL', 'tu_contraseña_de_aplicacion');  // Contraseña de app, no la de Gmail
define('SMTPSECURE', 'tls');
define('PORT', '587');
```

### 4. Crear la carpeta privada de datos

Esta carpeta debe estar fuera del DocumentRoot.
Crea la estructura completa:

```bash
mkdir -p /ruta/privada/evai/{cursos,fotos,grupos,logos_asigna,logs,pod,temp,usuarios,vinculos}
chmod 775 /ruta/privada/evai/*
```

### 5. Permisos de escritura

```bash
chmod 775 tmp/
chmod 775 media/imag/
chmod 775 perfil/
```

### 6. Verificar la instalación

Accede desde el navegador a tu dominio. Deberías ver la pantalla de login de EVAi.

Si hay errores, revisa:
- `config.php` — rutas y credenciales correctas
- Los logs en `DATA_DIR/logs/php-error.log`

---

## Primer acceso

El usuario administrador inicial tiene `id = 1` en la tabla `usuarios`. Accede con las credenciales que vengan en el `.sql` de instalación y **cambia la contraseña inmediatamente**.

EVAi te forzará a cambiarla si detecta que es una contraseña débil (123456, 12345678).

Existe un **modo DEMO** (configurable en `config.php`) que permite explorar la plataforma sin modificar datos reales.

---

## Configuración de Apache

Si instalas en un subdirectorio, asegúrate de que `mod_rewrite` está activo:

```apache
# En .htaccess o VirtualHost
Options -Indexes
AllowOverride All
```

Para instalación en raíz del dominio no se requiere configuración adicional.

---

## Notas de seguridad

- **`config.php` nunca debe subirse a GitHub con credenciales reales.** Añádelo al `.gitignore` y sube solo `config.example.php` con valores vacíos.
- La carpeta `tmp/` contiene archivos temporales — considera limpiarla periódicamente.
- La carpeta `pod/` es el panel de administración — protégela con acceso restringido por IP si es posible.
- En producción: `display_errors = 0` en `config.php` (ya está así por defecto para el dominio de producción).


---

## Tecnologías utilizadas

- PHP 7.4+ con MySQLi
- MySQL / MariaDB
- Apache
- jQuery + jQuery UI
- PHPMailer
- GeoIP (localización geográfica)
- phpQRcode (generación de QR)
- Jitsi (videoconferencia, integración externa)

---

## Historia

EVAI se usó en la Universitat Jaume I (2000-2023). Referencia académica: http://dx.doi.org/10.6035/Educacio.2014.18

EVAi nació en el entorno universitario como plataforma de aprendizaje colaborativo. Este repositorio es su memoria: el código de una herramienta que se construyó con ilusión y que funcionó de verdad.

---

*Licencia: ver `LICENSE.txt`*
