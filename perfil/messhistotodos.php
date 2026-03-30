<?php

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

$uid = $_SESSION['usuid'];

$salida = "";

$ilink->query("INSERT INTO message_histo SELECT * FROM message where isread = 1 AND (parausuid = '$uid' OR usuid = '$uid')");
$ilink->query("DELETE FROM message WHERE isread = 1 AND (parausuid = '$uid' OR usuid = '$uid')");

$sql = "SELECT usuid, message, date, isread, usuarios.alumnon, tamatach, nomatach, message_histo.id, parausuid FROM message_histo 
			LEFT JOIN usuarios ON usuarios.id = message_histo.usuid 
			WHERE message NOT LIKE 'Nuevo mensaje en el foro%' AND (parausuid='$uid' OR usuid='$uid') ORDER BY message_histo.date";
$result = $ilink->query($sql);

$sql0 = "SELECT usuid, message, date, isread, usuarios.alumnon, tamatach, nomatach, message.id, parausuid FROM message  
			LEFT JOIN usuarios ON usuarios.id = message.usuid 
			WHERE message NOT LIKE 'Nuevo mensaje en el foro%' AND (parausuid='$uid' OR usuid='$uid') ORDER BY message.date";
$result0 = $ilink->query($sql0);

if (!$result->num_rows AND !$result0->num_rows) {
		echo "<center><p></p><br>No hay hist&oacute;rico</center>";
		exit;
}

echo "<p class='b'>".i("histo",$ilink).":</p>";

echo unmensa($sql,1,$ilink,'');

if ($result0->num_rows) {echo "<p>&nbsp;</p><hr class='sty'>";}

echo unmensa($sql0,1,$ilink,'');

?>

