<?php

require_once __DIR__ . "/../siempre_base.php";

if ($_SESSION['auto'] < 5 ) {
	exit;
}

$filtro = "asigna = '".$_SESSION['asigna']."' AND curso = '".$_SESSION['curso']."' AND grupo='".$_SESSION['grupo']."'";

$iresult = $ilink->query("SELECT altalibre FROM cursasigru WHERE $filtro");
$altalib = $iresult->fetch_array(MYSQLI_BOTH);

$camb = ""; if (!$altalib[0]) {$camb = 1;}

$ilink->query("UPDATE cursasigru SET altalibre = '$camb' WHERE $filtro");

if ($altalib[0]) {echo i("no",$ilink);} else {echo i("si",$ilink);}

?>