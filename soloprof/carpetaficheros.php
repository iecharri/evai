<?php

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

$asicurgru = $_SESSION['asigna']."$$".$_SESSION['curso']."$$".$_SESSION['grupo'];
$titcur = $_SESSION['tit']."$$".$_SESSION['curso'];

// --------------------------------------------------

$puedounzip=1;

if ($_SESSION['op'] == 2) {
	$titcur = $_SESSION['tit']."$$".$_SESSION['curso'];
	$dirini = DATA_DIR . "/cursos/$titcur/";
	$param="pest=9&titul=1";
} else {
	$asicurgru = $_SESSION['asigna']."$$".$_SESSION['curso']."$$".$_SESSION['grupo'];
	$dirini = DATA_DIR . "/cursos/$asicurgru/";
	$param = "pest=9&titul=";
}

if($solorecursos) {
	$dirini .= "recursos/";
	$navini .= "recursos/";
	$param .= "&pestx=$pestx";
}

$script = "admin.php?$param";
$fichphp = APP_URL . "/file.php?n=".base64_encode($dirini);

// --------------------------------------------------

require_once APP_DIR . "/explorernue.php";

?>
