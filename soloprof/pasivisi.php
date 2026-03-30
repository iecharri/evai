<?php

require_once __DIR__ . "/../siempre_base.php";

if ($_SESSION['auto'] < 5 ) {
	exit;
}

$filtro = "asigna = '".$_SESSION['asigna']."' AND curso = '".$_SESSION['curso']."' AND grupo='".$_SESSION['grupo']."'";

$iresult = $ilink->query("SELECT visibleporalumnos FROM cursasigru WHERE $filtro");
$visi = $iresult->fetch_array(MYSQLI_BOTH);

$camb = ""; if (!$visi[0]) {$camb = 1;}

$ilink->query("UPDATE cursasigru SET visibleporalumnos = '$camb' WHERE $filtro");

if ($visi[0]) {echo i("no",$ilink);} else {echo i("si",$ilink);}

?>