<?php

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

if ($_SESSION['auto'] < 5) {exit;}

extract($_GET);
extract($_POST);
if(!$apli) {$apli = 1;}

// --------------------------------------------------
$texto[1] = i("calenactivi",$ilink);
$texto[2] = i("plazas",$ilink);

unset($array);

$array[0] = "<a href='#'>".i("practext",$ilink)." <span class='icon-arrow-right'></span></a>";
$array[1] = "<a href='?pest=$pest&apli=1'>$texto[1]</a>";
$array[2] = "<a href='?pest=$pest&apli=2'>$texto[2]</a>";

solapah($array,$apli+1,"navhsimple");

// --------------------------------------------------

if ($apli) {
	if ($apli == 2) {
		echo " &nbsp; <span class='txth b'>".i("plazasalu",$ilink)." <a href='".APP_URL."/indexrecursos.php?op=10&apli=$apli'> ".i("plazasen",$ilink)."</a></span>";
	}
	if ($apli == 1) {
		echo " &nbsp; <span class='txth b'>".i("activialu",$ilink)." <a href='".APP_URL."/indexrecursos.php?op=10&apli=$apli'> ".i("activien",$ilink)."</a></span>";
	}
}

if ($apli == 1) {
	require_once APP_DIR . "/soloprof/soloprofaplic1.php";
}

if ($apli == 2) {
	require_once APP_DIR . "/soloprof/soloprofaplic2.php";
}

?>
