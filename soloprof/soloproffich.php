<?php

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

extract($_SERVER);
extract($_GET);
extract($_POST);

if($op == 2){$titul=1;}

unset($array);

$array[0] = "<a href='#'>".i("fichs",$ilink)." <span class='icon-arrow-right'></span></a>";
solapah($array,1,"navhsimple");

$asicurgru = $_SESSION['asigna']."$$".$_SESSION['curso']."$$".$_SESSION['grupo'];
$titcur = $_SESSION['tit']."$$".$_SESSION['curso'];

// --------------------------------------------------

$puedounzip=1;

if ($_SESSION['op'] == 2) {
	$titcur = $_SESSION['tit']."$$".$_SESSION['curso'];
	$dirini = DATA_DIR ."/cursos/$titcur/";
	$param="pest=$pest&titul=1";
} elseif($_SESSION['op'] == 3 AND $_SESSION['auto'] == 10) {
	$asicurgru = ""; 
	$dirini = DATA_DIR . "/";
	$param = "pest=$pest";
	$todosfich = 1;
} else {
	$asicurgru = $_SESSION['asigna']."$$".$_SESSION['curso']."$$".$_SESSION['grupo'];
	$dirini = DATA_DIR . "/cursos/$asicurgru/";
	$param = "pest=$pest&titul=";
}

$script = "admin.php?$param";
$fichphp = APP_URL . "/file.php?n=".base64_encode($dirini);

// --------------------------------------------------

require_once APP_DIR . "/explorernue.php";

?>
