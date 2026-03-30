<?php

require_once __DIR__ . "/siempre_base.php";

if ($_SESSION['auto'] < 3 ) {
	exit;
}

// Tiempo actual UTC
$timestamp = time();
$ahora = gmdate('Y-m-d H:i:s');

// Obtener fecha de login directamente
$res = $ilink->query("SELECT fechalogin, recarga FROM usuarios WHERE id='".$_SESSION['usuid']."' LIMIT 1");
$t = $res->fetch_array(MYSQLI_BOTH);

// Calcular diferencia en PHP
$fechalogin = strtotime($t['fechalogin']);
$diferencia = $timestamp - $fechalogin;

// Guardar nueva fecha UTC
$ilink->query("UPDATE usuarios SET fecha='$ahora', tultimo='$diferencia' WHERE id='".$_SESSION['usuid']."' LIMIT 1");

// Actualizar hora de salida en usosistema
$sesion = session_id();
$temp = $ilink->query("SELECT entra FROM usosistema WHERE id='".$_SESSION['usuid']."' AND sesion = '$sesion' ORDER BY entra DESC");
$temp = $temp->fetch_array(MYSQLI_BOTH);
$ilink->query("UPDATE usosistema SET sale='$ahora' WHERE id='".$_SESSION['usuid']."' AND sesion = '$sesion' AND entra = '$temp[0]'");

// Carga JS si recarga activa
if ($t['recarga']) {
	echo "<script>jusuonline();</script>";
}

// Comprobación de mensajes nuevos
$n = 0;
$temp = $ilink->query("SELECT id FROM message WHERE isread = 0 AND parausuid = '".$_SESSION['usuid']."'");
$porleer = $temp->num_rows;

if ($porleer != $_SESSION['porleer']) {
	if ($porleer && !$_SESSION['porleer']) $n = 1;
	$_SESSION['porleer'] = $porleer;
	$_SESSION['recarga'] = 1;
	echo "<script>jcabhsm();</script>";
}

if ($n == 1) {
	$iresult = $ilink->query("SELECT id FROM message WHERE aviso = 0 AND isread = 0 AND parausuid = '".$_SESSION['usuid']."'");
	if ($iresult->num_rows) {
		echo "<audio autoplay><source src='" . MEDIA_URL . "/sonidos/mens.wav' type='audio/wav'></audio>";
	}
}

// --------------------------------------------------

return;

?>

