<?php

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

// --------------------------------------------------
//Si se sale del sistema.
// --------------------------------------------------

if (!isset($_SESSION['usuid'])) {return;}

require_once APP_DIR . '/usosistema.php';
while ($salir == 0) {
	$salir = sesion($_SESSION['usuid'],'',$ilink);
}
//Se guarda el tiempo de salida del usuario y se avisa a los dem&aacute;s que est&aacute;n en l&iacute;nea de que se va.
//Se guardan variables de sesi&oacute;n necesarias antes de cerrar la sesi&oacute;n de usuario.

$timestamp = time(); // UTC

// Obtener la fecha original
$iresult = $ilink->query("SELECT fecha, privacidad FROM usuarios WHERE id = '".$_SESSION['usuid']."' LIMIT 1");
$fecha = $iresult->fetch_array(MYSQLI_BOTH);

// Restar 31 segundos a esa fecha en PHP (UTC)
$nueva_fecha = gmdate('Y-m-d H:i:s', strtotime($fecha[0]) - 31);

// Actualizar al propio usuario con la nueva fecha
$ilink->query("UPDATE usuarios SET recordar = '', fecha = '$nueva_fecha' WHERE id = '".$_SESSION['usuid']."' LIMIT 1");

// Actualizar a los demás usuarios cuya fecha esté dentro de los últimos 30 segundos
// Primero: calcula el corte en PHP
$corte = gmdate('Y-m-d H:i:s', $timestamp - 30);

// Ahora actualiza solo a usuarios con fecha >= ese momento
$ilink->query("UPDATE usuarios SET recarga = 1 WHERE fecha >= '$corte' AND id != '".$_SESSION['usuid']."'");

// Forzamos caducidad de la cookie de recordar en el navegador
setcookie(
    SITE,           // nombre de la cookie (ej. "evai")
    '',                    // valor vacío
    time() - 3600,         // expiración en el pasado
    '/',                   // ruta
    '',                    // dominio actual
    !empty($_SERVER['HTTPS']), // secure: solo por https si lo usas
    true                   // httponly
);

?>