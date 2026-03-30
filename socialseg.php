<?php

require_once __DIR__ . "/siempre_base.php";

if ($_SESSION['auto'] < 3 ) {
	exit;
}

require_once APP_DIR . "/idioma.php";

extract($_GET);
$tablau = "message_usus";
$div = "seg".$id;

if ($seg == 1) {
	//seguir
	$ilink->query("INSERT IGNORE INTO $tablau (usuid, parausuid) VALUES ('$id','".$_SESSION['usuid']."')");
	$ilink->query("UPDATE $tablau SET usuid1 = -1 WHERE usuid = '$id' AND parausuid = '".$_SESSION['usuid']."'");	
	$ilink->query("UPDATE $tablau SET parausuid1 = -1 WHERE parausuid = '$id' AND usuid = '".$_SESSION['usuid']."'");	
	echo "<a href=\"javascript:llamarasincrono('socialseg.php?id=$id&seg=2','$div');\">
	<span class='icon-star-full' alt=\"".i("seguirno",$ilink)."\"></span></a>";	
} elseif ($seg == 2) {
	$ilink->query("UPDATE $tablau SET usuid1 = 0 WHERE usuid = '$id' AND parausuid = '".$_SESSION['usuid']."'");	
	$ilink->query("UPDATE $tablau SET parausuid1 = 0 WHERE parausuid = '$id' AND usuid = '".$_SESSION['usuid']."'");	
	echo "<a href=\"javascript:llamarasincrono('socialseg.php?id=$id&seg=1','$div');\">
	<span class='icon-star-empty' alt=\"".i("seguir",$ilink)."\"></span></a>";
}

?>