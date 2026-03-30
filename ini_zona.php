<?php

/**
 * ini_zona.php — Punto único para fijar la zona horaria de usuario en sesión.
 * - No imprime nada, no inyecta JS, no hace redirects.
 * - Prioridad: BD (preferencia usuario) > cookie 'zone' válida > UTC.
 * - Sincroniza cookie 'zone' si falta o difiere de la sesión.
 */

declare(strict_types=1);

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

// Siempre trabajamos en UTC en servidor/BD
if (ini_get('date.timezone') !== 'UTC') {
    date_default_timezone_set('UTC');
}

// Evita reprocesar si se incluye varias veces
if (defined('EVAI_ZONE_BOOTSTRAPPED')) {
    return;
}
define('EVAI_ZONE_BOOTSTRAPPED', true);

// Lista IANA válida para validar valores entrantes
$VALID_TZ = \DateTimeZone::listIdentifiers();

// Helper: ¿zona válida?
$esZonaValida = static function (?string $z) use ($VALID_TZ): bool {
    return is_string($z) && $z !== '' && in_array($z, $VALID_TZ, true);
};

// 1) Si ya hay zona en sesión y es válida, usamos esa y salimos rápido
if (!empty($_SESSION['zone']) && $esZonaValida($_SESSION['zone'])) {
    // Asegura cookie alineada si falta
    if (empty($_COOKIE['zone']) || $_COOKIE['zone'] !== $_SESSION['zone']) {
        $secure = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off');
        setcookie('zone', $_SESSION['zone'], [
            'expires'  => time() + 31536000, // 1 año
            'path'     => '/',
            'secure'   => $secure,
            'httponly' => true,
            'samesite' => 'Lax',
        ]);
    }
    return;
}

// Determinar zona según prioridad
$zone = null;

// 2) Preferencia del usuario (si está logueado y guardas tz en BD) --> no guardo

// 3) Cookie 'zone' si es válida
if ($zone === null && !empty($_COOKIE['zone']) && $esZonaValida($_COOKIE['zone'])) {
    $zone = $_COOKIE['zone'];
}

// 4) Fallback: UTC
if ($zone === null) {
    $zone = 'UTC';
}

// Fija en sesión
$_SESSION['zone'] = $zone;

// Sincroniza cookie si falta o difiere
if (empty($_COOKIE['zone']) || $_COOKIE['zone'] !== $zone) {
    $secure = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off');
    setcookie('zone', $zone, [
        'expires'  => time() + 31536000, // 1 año
        'path'     => '/',
        'secure'   => $secure,
        'httponly' => true,
        'samesite' => 'Lax',
    ]);
}

// Listo: a partir de aquí tu código puede usar siempre $_SESSION['zone']
// para convertir/mostrar fechas (los inserts/updates a BD siguen en UTC).
?>