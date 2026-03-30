<?php

require_once __DIR__ . "/../siempre_base.php";

if ($_SESSION['auto'] < 5 ) {
	exit;
}

$filtro = "asigna = '".$_SESSION['asigna']."' AND curso = '".$_SESSION['curso']."' AND grupo='".$_SESSION['grupo']."'";

$iresult = $ilink->query("SELECT forospormail FROM cursasigru WHERE $filtro");
$fxm = $iresult->fetch_array(MYSQLI_BOTH);

$camb = "";
if ($fxm[0] < 1) {
	$camb = 1;
} elseif ($fxm[0] == 1) {
	$camb = 2;
}

$ilink->query("UPDATE cursasigru SET forospormail = '$camb' WHERE $filtro");

if ($fxm[0] == 2) {
	echo i("no",$ilink);
} elseif($fxm[0] == 1) {
	echo "PHP";
} else {
	echo i("si",$ilink);
}

?>