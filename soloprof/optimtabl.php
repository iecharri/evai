<?php

require_once __DIR__ . "/../siempre_base.php";

if ($_SESSION['auto'] < 10 ) {
	exit;
}

$result = $ilink->query("SHOW TABLES FROM ".DB1);
while ($fila = $result->fetch_array(MYSQLI_BOTH)) {
	$ilink->query("OPTIMIZE TABLE $fila[0]");
}
//borrar duplicados en usuarios favoritos messenger
$tabla = "message_usus";
$ilink->query("DELETE FROM $tabla WHERE usuid = 0 OR parausuid = 0");
$ilink->query("DELETE FROM $tabla WHERE usuid = parausuid");
$sql = "SELECT usuid, parausuid FROM $tabla ORDER BY usuid";
$result = $ilink->query($sql);

$repe = array();
while ($fila = $result->fetch_array(MYSQLI_BOTH)) {
	extract($fila);
	$result1 = $ilink->query("SELECT usuid FROM $tabla WHERE usuid = '$parausuid' AND parausuid = '$usuid'");
	if ($result1->num_rows > 0) {
		if (!in_array("$parausuid*$usuid", $repe)) {$repe[] = "$usuid*$parausuid";}
	}
}

foreach ($repe as $valor) {
    $a = explode("*",$valor);
     if ($a[0] AND $a[1]) {
    	$ilink->query("DELETE FROM $tabla WHERE usuid = '$a[0]' AND parausuid = '$a[1]'");
    }
}

?>