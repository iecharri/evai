<?php

// siempre.php — para páginas completas

require_once __DIR__ . '/siempre_base.php';

// --------------------------------------------------

// Variables de sesión útiles (siempre)
$yo     = $_SESSION['usuid']  ?? null;
$asigna = $_SESSION['asigna'] ?? null;
$curso  = $_SESSION['curso']  ?? null;
$grupo  = $_SESSION['grupo']  ?? null;
$tit    = $_SESSION['tit']    ?? ($tit    ?? null);
$i      = $_SESSION['i']      ?? ($i      ?? null);

$asicurgru = ($asigna ?? '') . '$$' . ($curso ?? '') . '$$' . ($grupo ?? '');

// --------------------------------------------------

//if($_GET['zxc'] == '13061958') {$_SESSION['zxc'] = "13061958";}
//if($_SESSION['zxc'] != "13061958") {echo "Servidor en tareas de mantenimiento."; echo "<p style='height:100em'></p>".substr(php_uname(),0,4);exit;}

$script = pathinfo($_SERVER['PHP_SELF'], PATHINFO_FILENAME);

// Módulos que NO están en siempre_base.php (los mantenemos)
require_once APP_DIR . "/hiperen.php"; 
require_once APP_DIR . "/wrapper_archivos.php";
require_once APP_DIR . "/notas_formula.php";
require_once APP_DIR . "/notasvermens.php";
require_once APP_DIR . "/1notalistar.php";
require_once APP_DIR . "/1notameddt.php";
require_once APP_DIR . "/smsencoded.php";

include APP_DIR . "/autos.php";
include APP_DIR . "/pestana.php";
include APP_DIR . "/paginar.php";
include APP_DIR . "/win.php";
include APP_DIR . "/tamano.php";
include APP_DIR . "/enviospor.php";

require_once APP_DIR . "/forofunciones.php";
require_once APP_DIR . "/notifunciones.php";

// Selección desplegable Asignatura, Titulación 
if (isset($_GET['tod'])) { $_SESSION['titasi'] = "todos"; }
if (isset($_POST['titasi'])) { $_SESSION['titasi'] = $_POST['titasi']; }

// Para la agenda 
$miagenda = strpos($_SERVER['SCRIPT_NAME'], "miagenda.php");

if (($menuizda[0] != 2 || $miagenda) && $script != "pod" && $script != "admin") { //añado en 2025  AND $script != "admin"   //que es menuizda[0]????

    if (isset($_GET['titasi'])) { $_SESSION['titasi'] = $_GET['titasi']; }
    include(APP_DIR . "/posts.php");
    extract($_GET);
    extract($_POST);
    if ($accion == "editar1") { editarnoti($ilink); }
    if ($accion == "anadir1") { anadirnoti($ilink); }

    $calen = ag_ini($ilink);

    $ag = $_GET['ag'] ?? null;

    if ($ag) {
        $titul = ""; $asi = "";
        if ($_SESSION['titasi'] == 1) { $titul = 1; $asi = ""; }
        if ($_SESSION['titasi'] == 2) { $titul = ""; $asi = 1; }
        $arraymes = arraymes($calen[1], $miagenda, $_GET['g'] ?? null, $_SESSION['titasi'], $ilink);
    } else {
        $arraymes = arraymes($calen[1], $miagenda, $_GET['g'] ?? null, 0, $ilink);
    }
}

// --------------------------------------------------

//Si estoy en ficha y vengo de pod, ve a edicion ficha de usuario
if (!empty($_SERVER['HTTP_REFERER']) && strpos($_SERVER['HTTP_REFERER'], "pod.php") !== false && strpos($_SERVER['SCRIPT_NAME'], "ficha.php") !== false) {
	$op = 3;
}

if ($script == "ficha" && $usuid && $usuid != $_SESSION['usuid']) { 
    return;
}

// --- Config
const OP_CAMBIO_OBLIG = 24;  // ficha.php?op=24  lleva a pedir cambio contraseña

// Debe existir la sesión y el id de usuario
$op = isset($_GET['op']) ? (int)$_GET['op'] : null;

// Si NO estoy en el flujo de cambio, aplico el guard
if ($op !== OP_CAMBIO_OBLIG && !empty($_SESSION['usuid'])) {

    if (must_change_password($ilink, (int)$_SESSION['usuid'])) {
        $script = basename(parse_url($_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH) ?? '');

        // Permite solo la página de salida si la tienes (ajusta si usas otro nombre)
        $permitidos = ['index.php'];

        // Si no estoy ya en la pantalla de cambio ni en una ruta permitida, redirijo
        $ya_en_cambio = ($script === 'ficha.php' && (int)($_GET['op'] ?? 0) === OP_CAMBIO_OBLIG);
        $en_permitida = in_array($script, $permitidos, true);

        if (!$ya_en_cambio && !$en_permitida) {
            header('Cache-Control: no-store');
            header('Location: '.APP_URL.'/ficha.php?op=' . OP_CAMBIO_OBLIG);
            http_response_code(303); // See Other
            exit;
        }
    }
}

/**
 * Devuelve true si el usuario debe cambiar la contraseña (123456 o 12345678).
 */
function must_change_password(mysqli $ilink, int $id): bool {
    $stmt = $ilink->prepare("SELECT pass_hash, password FROM usuarios WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $res = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    if (!$res) return false;

    // Soporta legado (password en claro) y nuevo (pass_hash)
    $debil_plain = !empty($res['password']) && ($res['password'] === '12345678' || $res['password'] === '123456');
    $debil_hash  = !empty($res['pass_hash']) && (
        password_verify('12345678', $res['pass_hash']) ||
        password_verify('123456',   $res['pass_hash'])
    );

    return $debil_plain || $debil_hash;
}

?>