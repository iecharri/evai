<?php
require __DIR__ . '/siempre_base.php';

$errs = [];
$ok = [];

// 1) Sesión
if (session_status() === PHP_SESSION_ACTIVE) { $ok[] = 'Sesión activa'; } else { $errs[] = 'Sesión NO activa'; }

// 2) CSRF
if (!empty($_SESSION['csrf'])) { $ok[] = 'CSRF ok'; } else { $errs[] = 'CSRF no generado'; }

// 3) Logs (¿ruta y permisos?)
$logDir = rtrim(DATA_DIR, '/').'/logs';
$logFile = $logDir.'/php-error.log';
if (is_dir($logDir) && is_writable($logDir)) { $ok[] = "Logs dir ok ($logDir)"; } else { $errs[] = "Logs dir sin permisos: $logDir"; }
error_log('EVAi healthcheck '.date('c'));
$ok[] = "Intento de escribir log → revisa $logFile";

// 4) DEMO
$ok[] = 'demo_enabled(): '.(demo_enabled() ? 'ON' : 'OFF');

// 5) DB (opcional, si $db existe en link.php)
if (isset($ilink) && @$ilink->ping()) { $ok[] = 'MySQL conectado'; } else { $errs[] = 'MySQL sin conexión (revisa host/credenciales)'; }

// 6) Entorno
$ok[] = 'APP_ENV = '.(defined('APP_ENV') ? APP_ENV : '(no definido)');
$ok[] = 'DATA_DIR = '.(defined('DATA_DIR') ? DATA_DIR : '(no definido)');

header('Content-Type: text/plain; charset=utf-8');
echo "OK:\n- ".implode("\n- ", $ok)."\n\n";
echo $errs ? "ERRORES:\n- ".implode("\n- ", $errs)."\n" : "ERRORES: ninguno\n";
?>