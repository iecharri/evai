<?php

require_once __DIR__ . "/../siempre_base.php";

if ($_SESSION['auto'] < 5 ) {
	exit;
}

$filtro = "titulaci = '".$_SESSION['tit']."' AND curso = '".$_SESSION['curso']."'";

$result = $ilink->query("SELECT notispormail FROM titcuradmi WHERE $filtro");
$hayadmi = $result->num_rows;

if (!$hayadmi) {return;}

$nxm = $result->fetch_array(MYSQLI_BOTH);

$camb = "";
if ($nxm[0] < 1) {$camb = 1;}

$ilink->query("UPDATE titcuradmi SET notispormail = '$camb' WHERE $filtro");

if ($nxm[0] > 0) {echo i("no",$ilink);} else {echo i("si",$ilink);}

?>