<?php 

declare(strict_types=1);

if (!defined('EVA_BOOTSTRAP')) { //Defino 
    define('EVA_BOOTSTRAP', 1);
}

// Carga de configuración central (define APP_ENV, DATA_DIR, logs, etc.)
require_once __DIR__ . '/config.php';

// siempre_base.php — incluir el PRIMERO en TODOS los PHP ligeros (AJAX, endpoints pequeños)
// Ubícar junto a ini_zona.php, config.php y link.php

// === Arranque de sesión seguro ===
$secure = !empty($_SERVER['HTTPS']); // true si uso https

if (session_status() !== PHP_SESSION_ACTIVE) {

	ini_set('session.use_strict_mode', '1');
	ini_set('session.use_only_cookies', '1');
	ini_set('session.cookie_httponly', '1');
	ini_set('session.cookie_samesite', 'Lax');
	if ($secure) {ini_set('session.cookie_secure', '1');}

   session_set_cookie_params([
        'lifetime' => 0,      // hasta cerrar navegador
        'path'     => '/',
        'domain'   => '',
        'secure'   => $secure,
        'httponly' => true,
        'samesite' => 'Lax',
   ]);
   session_start();
}

// Token CSRF único por sesión
if (empty($_SESSION['csrf'])) {
    $_SESSION['csrf'] = bin2hex(random_bytes(32));
}

// Zona/SESION (siempre primero)
require_once APP_DIR . '/ini_zona.php';

// Conexión a BD (debe dejar $ilink listo)
require_once APP_DIR . '/link.php'; 

// Funciones de fechas (requiere $_SESSION['zone'])
require_once APP_DIR . '/ifecha.php';

// Funcion de idioma
require_once APP_DIR . '/idioma.php'; 

require_once APP_DIR . "/nombre.php"; 

// Nombre de script sin extensión (útil para flujos)
$script = pathinfo($_SERVER['PHP_SELF'], PATHINFO_FILENAME);

if (empty($_SESSION['i']) && empty($_COOKIE['i'])) {
    $_SESSION['i'] = 'c';       // castellano
    setcookie('i', 'c', time()+31536000, "/"); 
}

// Color por defecto
if (empty($_SESSION['paleta']) && empty($_COOKIE['paleta'])) {
    $_SESSION['paleta'] = 'amarillo';  // tema amarillo
    setcookie('paleta', 'amarillo', time()+31536000, "/");
}


?>