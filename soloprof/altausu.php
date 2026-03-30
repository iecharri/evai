<?php

require_once __DIR__ . "/../siempre_base.php";

if ($_SESSION['auto'] < 10 ) {
	exit;
}

$iresult = $ilink->query("SELECT altalibre FROM atencion");
$alta = $iresult->fetch_array(MYSQLI_BOTH);

$camb = "";
if (!$alta[0]) {$camb = 1;}

$ilink->query("UPDATE atencion SET altalibre = '$camb'");

if ($alta[0]) {echo i("no",$ilink);} else {echo i("si",$ilink);}

?>