<?php

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

//declare(strict_types=1);

// ==================== CONFIGURACIÓN BASE ====================
date_default_timezone_set('UTC');
// mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT); // Actívalo en local si quieres excepciones de mysqli

// ==================== CLASE DE CONEXIÓN ====================
class ConexionEvai extends mysqli
{
    public function __construct(string $host, string $user, string $pass, ?string $db = null, int $port = 3306)
    {
        // Evitamos warnings visibles en hostings gratis con @ (puedes quitarlo si prefieres verlos)
        @parent::__construct($host, $user, $pass, $db ?? '', $port);
        if ($this->connect_errno) {
            // Mensaje amable al usuario final
            die('En estos momentos no hay conexión con el servidor, inténtalo más tarde.');
        }
        $this->set_charset('utf8mb4');
    }

public function query(string $query, int $result_mode = MYSQLI_STORE_RESULT): mysqli_result|bool
{
    // Normaliza encabezado: quita espacios y comentarios iniciales /* ... */ y -- ...
    $head = ltrim($query);
    // Elimina un bloque de comentarios iniciales (opcional, simple)
    $head = preg_replace('/^(?:\/\*.*?\*\/\s*|--[^\n]*\n\s*)+/s', '', $head);

    // ¿Demo activo para esta sesión?
    if (demo_enabled()) {
        // Permitir SOLO lecturas: SHOW, SELECT, WITH (CTE), DESCRIBE, EXPLAIN, SET NAMES
        $isReadOnly = preg_match(
            '/^\s*(?:SHOW|SELECT|WITH|DESCRIBE|EXPLAIN|SET(?:\s+NAMES)?)(?!\s*.*;\s*\S)/i',
            $head
        );

        if (!$isReadOnly) {
            // Bloquea INSERT/UPDATE/DELETE/REPLACE/ALTER/DROP/CREATE/TRUNCATE, etc.
            return false; // o lanza Exception si prefieres
        }

        // Opcional: bloquear multi-statements incluso en lectura
        if (str_contains($head, ';')) {
            return false;
        }
    }

    return parent::query($query, $result_mode);
}

}

// ==================== CREAR CONEXIÓN ====================

$ilink = new ConexionEvai(DB_HOST, DB_USER, DB_PASS, DB1);
$ilink->query("SET time_zone = '+00:00'");

// Seleccionar BD si está definida
if (!empty(DB1)) {
    $ilink->select_db(DB1);
    if ($ilink->errno) {
        echo 'En estos momentos no hay conexión con la base de datos de ' . SITE . ', inténtalo más tarde.';
        exit;
    }
}

// Charset por si la BD se selecciona más tarde
$ilink->set_charset('utf8mb4');

iconex(DB1, $ilink);

/**
 * iconex: valida acceso básico (usuid) + selecciona BD y charset.
 */
function iconex(string $base, mysqli $ilink): void {
    $usuid = $_SESSION['usuid'] ?? null;
    if (empty($usuid)) {
        // Scripts públicos permitidos sin sesión
        $permitidos = ['cuestionario.php','activ.php','cuest.php','verfich.php','login.php','hsmlogin.php','hsm.php','index.php','plazasext.php','olvido.php'];
        $script = basename($_SERVER['PHP_SELF'] ?? '');
        if (!in_array($script, $permitidos, true)) {
				header('Location: ' . APP_URL . '/index.php');
		      exit;
        }
    }

    if ($base === '') {
        return;
    }

    $ilink->select_db($base);
    if ($ilink->errno) {
        echo "En estos momentos no hay conexi&oacute;n con la base de datos de ".htmlspecialchars(ucfirst(SITE)).",, int&eacute;ntalo m&aacute;s tarde.";
        exit;
    }

    $ilink->set_charset('utf8mb4');
    // Compat legado opcional:
    // $ilink->query("SET NAMES 'utf8mb4'");
}
