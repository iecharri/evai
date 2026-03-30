<?php

require_once __DIR__ . "/../siempre_base.php";

if ($_SESSION['auto'] < 5 ) {
	exit;
}

$filtro = "titulaci = '".$_SESSION['tit']."' AND curso = '".$_SESSION['curso']."'";

$result = $ilink->query("SELECT forospormail FROM titcuradmi WHERE $filtro");
$hayadmi = $result->num_rows;

if (!$hayadmi) {return;}

$fxm = $result->fetch_array(MYSQLI_BOTH);

$camb = "";
if ($fxm[0] < 1) {
	$camb = 1;
} elseif ($fxm[0] == 1) {
	$camb = 2;
}

$ilink->query("UPDATE titcuradmi SET forospormail = '$camb' WHERE $filtro");

if ($fxm[0] == 2) {
	echo i("no",$ilink);
} elseif($fxm[0] == 1) {
	echo "PHP";
} else {
	echo i("si",$ilink);
}

?>