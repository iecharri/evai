<?php

require_once(__DIR__ . "/../siempre_base.php");

if ($yo == $usuid) {
	$where = "parausuid='$yo' AND isread=0";
} else {
	$where = " (usuid='$usuid' AND parausuid='$yo') OR (usuid='$yo' AND parausuid='$usuid')";
}

$tot0 = "SELECT usuid FROM message WHERE $where";

$iresult = $ilink->query($tot0);
$tot0 = $iresult->num_rows;

$cuantos = $tot0;

$sql0 = "SELECT usuid, message, date, isread, usuarios.alumnon, tamatach, nomatach, message.id 
			FROM message LEFT JOIN usuarios ON usuarios.id = message.usuid 
			WHERE $where ORDER BY message.date LIMIT 0, $cuantos"; 

$result0 = $ilink->query($sql0);
$num0 = $result0->num_rows;

if ($num0 > 0) {
	if($_GET['us'] == "m") {
		echo unmensa($sql0,1,$ilink,'');
	} else {
		echo unmensa($sql0,2,$ilink,'');
	}
} elseif ($yo == $usuid) {
	echo "<div id='nohaymens'>".i("nomens",$ilink,$anch)."</div>";	
}

?>
