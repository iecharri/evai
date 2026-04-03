# EVAi — Interactive Virtual Learning Environment

Web-based educational platform developed in PHP/MySQL. Supports management of students, teachers, subjects, forums, chat, quizzes, grades, calendar and more.

Public demo: [evaidemo.org](https://evaidemo.org)

---

## Server Requirements

| Component | Minimum recommended version |
|---|---|
| PHP | 7.4 or higher (8.1+ recommended) |
| MySQL / MariaDB | 5.7 / 10.3 or higher |
| Apache | 2.4 with `mod_rewrite` enabled |
| PHP Extensions | `mysqli`, `mbstring`, `curl`, `gd`, `zip`, `intl` |

> Compatible with standard shared hosting (cPanel, Plesk, etc.)

---

## Folder Structure

```
evai/                        ← Public root (DocumentRoot or subdirectory)
│
├── config.php               ← ⚠️ Main configuration (DO NOT upload with real credentials)
├── index.php                ← Entry point: redirects to login
├── login.php                ← Login screen
├── siempre.php              ← Session bootstrap (included in all pages)
│
├── css/                     ← Styles and color themes
├── js/                      ← Custom JavaScript
├── jqueryetc/               ← jQuery and plugins
├── media/                   ← Images, emoticons, sounds
├── phpmailer/               ← Mail sending (PHPMailer)
├── lib/                     ← Libraries (QR code, etc.)
│
├── chat/                    ← Real-time chat module
├── chatmini/                ← Simplified chat
├── cuest/                   ← Quizzes and assessments
├── pod/                     ← Administration panel (podium)
├── soloprof/                ← Teacher-only tools
├── bancot/                  ← Activity bank
├── clasedir/                ← Direct class / videoconference
│
└── tmp/                     ← Temporary files (must have write permissions)
```

**Private folder** (outside DocumentRoot, not accessible from the web):
```
/private/path/evai/
└── logs/
    └── php-error.log
```

---

## Step-by-step Installation

### 1. Upload the files

Upload the contents of the `evai/` folder to the server, inside the DocumentRoot (or in a subdirectory such as `/evai0`).

```bash
# Example with FTP or scp
scp -r evai/ user@server:/public_html/
```

### 2. Create the databases

EVAi uses **two MySQL databases**:

- `evai` — main data (users, subjects, grades, forums...)
- `cuest` — quizzes and assessments

Create both from phpMyAdmin or via the command line:

```sql
CREATE DATABASE evai_name CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE DATABASE cuest_name CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

Then import the corresponding `.sql` files:

```bash
mysql -u user -p evai_name  < evai.sql
mysql -u user -p cuest_name < cuest.sql
```

### 3. Configure `config.php`

Copy the example file and edit it with your details:

```bash
cp config.example.php config.php
```

Edit the values for your environment:

```php
define('DB_HOST', 'localhost');
define('DB_USER', 'your_mysql_user');
define('DB_PASS', 'your_password');
define('DB1', 'evai_name');
define('DB2', 'cuest_name');

define('APP_URL', '');        // Empty if at root. '/evai0' if in a subdirectory
define('APP_DIR', __DIR__);
define('BASE_DIR', $_SERVER['DOCUMENT_ROOT']);
define('DATA_DIR', '/path/outside/public_html/evai');  // Private folder for logs
define('MEDIA_DIR', APP_DIR . '/media');
define('MEDIA_URL', APP_URL . '/media');
```

For mail (notifications, password recovery):

```php
define('SMTP', 'smtp.gmail.com');
define('USERNAME', 'youraccount@gmail.com');
define('PASSMAIL', 'your_app_password');  // App password, not your Gmail password
define('SMTPSECURE', 'tls');
define('PORT', '587');
```

### 4. Create the private data folder

This folder must be outside the DocumentRoot.
Create the full structure:

```bash
mkdir -p /private/path/evai/{cursos,fotos,grupos,logos_asigna,logs,pod,temp,usuarios,vinculos}
chmod 775 /private/path/evai/*
```

### 5. Write permissions

```bash
chmod 775 tmp/
chmod 775 media/imag/
chmod 775 perfil/
```

### 6. Verify the installation

Open your browser and navigate to your domain. You should see the EVAi login screen.

If there are errors, check:
- `config.php` — correct paths and credentials
- The logs at `DATA_DIR/logs/php-error.log`

---

## First Access

The initial administrator user has `id = 1` in the `usuarios` table. Log in with the credentials provided in the installation `.sql` file and **change the password immediately**.

EVAi will force you to change it if it detects a weak password (123456, 12345678).

There is a **DEMO mode** (configurable in `config.php`) that lets you explore the platform without modifying real data.

---

## Apache Configuration

If you install in a subdirectory, make sure `mod_rewrite` is active:

```apache
# In .htaccess or VirtualHost
Options -Indexes
AllowOverride All
```

No additional configuration is required for installation at the domain root.

---

## Security Notes

- **`config.php` must never be pushed to GitHub with real credentials.** Add it to `.gitignore` and only upload `config.example.php` with empty values.
- The `tmp/` folder contains temporary files — consider cleaning it periodically.
- The `pod/` folder is the administration panel — protect it with IP-restricted access if possible.
- In production: `display_errors = 0` in `config.php` (already set this way by default for the production domain).


---

## Technologies Used

- PHP 7.4+ with MySQLi
- MySQL / MariaDB
- Apache
- jQuery + jQuery UI
- PHPMailer
- GeoIP (geographic location)
- phpQRcode (QR code generation)
- Jitsi (videoconference, external integration)

---

## History

EVAI was used at Universitat Jaume I (2000-2023). Academic reference: http://dx.doi.org/10.6035/Educacio.2014.18

EVAi was born in a university setting as a collaborative learning platform. This repository is its memory: the code of a tool built with passion that truly worked.

---

*License: see `LICENSE.txt`*
