<?php

$host = $_SERVER['HTTP_HOST'] ?? 'localhost';

if ($host === 'localhost' || $host === '127.0.0.1') {

    define('BASE_DIR', '/ruta/al/servidor/html');
    define('APP_DIR',  __DIR__);
    define('DATA_DIR', '/ruta/privada/fuera/del/html/evai');

    define('APP_URL',  '/evai0');  // o '' si está en raíz

    define('MEDIA_DIR', APP_DIR . '/media');
    define('MEDIA_URL', APP_URL . '/media');

    define('DB_HOST', 'localhost');
    define('DB_USER', 'tu_usuario');
    define('DB_PASS', 'tu_contraseña');
    define('DB1', 'nombre_bd_evai');
    define('DB2', 'nombre_bd_cuest');

    error_reporting(E_ERROR | E_PARSE);
    ini_set('display_errors', '1');
    ini_set('log_errors', '1');
    ini_set('error_log', DATA_DIR . '/logs/php-error.log');

} elseif ($host === 'tudominio.com' || $host === 'www.tudominio.com') {

    define('BASE_DIR', $_SERVER['DOCUMENT_ROOT']);
    define('APP_DIR',  $_SERVER['DOCUMENT_ROOT']);
    define('DATA_DIR', '/ruta/privada/fuera/del/html/evai');

    define('APP_URL',  '');

    define('MEDIA_DIR', APP_DIR . '/media');
    define('MEDIA_URL', APP_URL . '/media');

    define('DB_HOST', 'localhost');
    define('DB_USER', 'tu_usuario');
    define('DB_PASS', 'tu_contraseña');
    define('DB1', 'nombre_bd_evai');
    define('DB2', 'nombre_bd_cuest');

    error_reporting(E_ERROR | E_PARSE);
    ini_set('display_errors', '0');
    ini_set('log_errors', '1');
    ini_set('error_log', DATA_DIR . '/logs/php-error.log');

} else {
    return; exit;
}

define('DATA_URL', null);

$logDir = DATA_DIR . '/logs';
if (!is_dir($logDir)) {
    mkdir($logDir, 0775, true);
}

$scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
$host   = $_SERVER['HTTP_HOST'] ?? 'localhost';
define('DOMINIO', $scheme . '://' . $host);

define('SITE', 'evai');

$clogin = "Evai";
$anch   = "Evai";
$estr   = "Evai";
$imgloader = "<div class='spinner icon-spinner'></div> ";

define('SMTP',       'smtp.gmail.com');
define('SMTPAUTH',   'true');
define('USERNAME',   'tucuenta@gmail.com');
define('PASSMAIL',   'tu_contraseña_de_aplicacion');
define('SMTPSECURE', 'tls');
define('PORT',       '587');

define('DEMO_BTN', true);
const DEMO_ONLINE_IDS = [1];

define('OLVIDO_YNUEVOUSU', false);
const PALETAS    = ['azul','amarillo','verde','marron','lila','rojo','turquesa','naranja','menta','rosa','grafito'];
const FORMFOTO   = ['cuadrada','redonda'];

function demo_enabled(): bool {
    if (session_status() !== PHP_SESSION_ACTIVE) {
        return false;
    }
    return !empty($_SESSION['demo_mode']);
}
?>
