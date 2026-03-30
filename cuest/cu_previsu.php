<?php

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

$cuest = $_GET['cuest'];

iconex(DB1,$ilink);
$result = $ilink->query("SELECT cuestionario FROM atencion");
$cuestppal = $result->fetch_array(MYSQLI_BOTH);

iconex(DB2,$ilink);
$result = $ilink->query("SELECT ordenadas, alfabet, sinnum, guardar, formula FROM ".$cuest."1 WHERE !n");
$fila = $result->fetch_array(MYSQLI_BOTH);
if (is_array($fila)) {
	extract($fila);	
}

if(!$sinnum) {$numera = 1;}

$previsu = 1;

if($guardar == 1) {
	require_once APP_DIR . '/cuest/cuest_guardar.php';
} elseif($guardar == 2) {
	require_once APP_DIR . '/cuest/cuest_indep.php';
} elseif($cuestppal[0] == $cuest) {
	require_once APP_DIR . '/cuest/cuest_ppal.php';
} else {
	require_once APP_DIR . '/cuest/cuest_noguardar.php';
}

?>
