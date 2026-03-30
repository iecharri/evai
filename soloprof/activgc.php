<?php

require_once __DIR__ . "/../siempre_base.php";

if ($_SESSION['auto'] < 10 ) {
	exit;
}

$iresult = $ilink->query("SELECT gc FROM podcursoasigna WHERE asigna = '".$_SESSION['asigna']."'");
$gc = $iresult->fetch_array(MYSQLI_BOTH);

$camb = "";
if ($gc[0] < 1) {$camb = 1;}

$ilink->query("UPDATE podcursoasigna SET gc = '$camb' WHERE  asigna = '".$_SESSION['asigna']."'");
$_SESSION['gc'] = $camb;

if ($gc[0] > 0) {echo i("no",$ilink);} else {echo i("si",$ilink);}

?>