<?php

require_once __DIR__ . "/../siempre_base.php";

if ($_SESSION['auto'] < 5 ) {
	exit;
}

$filtro = "asigna = '".$_SESSION['asigna']."' AND curso = '".$_SESSION['curso']."' AND grupo='".$_SESSION['grupo']."'";

$iresult = $ilink->query("SELECT gic FROM cursasigru WHERE $filtro");
$gic = $iresult->fetch_array(MYSQLI_BOTH);

$camb = "";
if ($gic[0] < 1) {$camb = 1;}

$ilink->query("UPDATE cursasigru SET gic = '$camb' WHERE $filtro");
$_SESSION['gic'] = $camb;

if ($gic[0] > 0) {echo i("no",$ilink);} else {echo i("si",$ilink);}

?>