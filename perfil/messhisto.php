<?php

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

$sender = $_GET['usuid'];
$uid = $_SESSION['usuid'];

if (!$sender) {exit;}

$salida = "";

$ilink->query("INSERT INTO message_histo SELECT * FROM message where isread = 1 AND (parausuid = '$uid' OR usuid = '$uid')");
$ilink->query("DELETE FROM message WHERE isread = 1 AND (parausuid = '$uid' OR usuid = '$uid')");

$sql0 = "SELECT usuid, message, date, isread, usuarios.alumnon, tamatach, nomatach, message.id FROM message LEFT JOIN usuarios ON usuarios.id = message.usuid WHERE (isread = 1 AND usuid='$sender' AND parausuid='$uid') OR (usuid='$uid' AND parausuid='$sender') ORDER BY message.date";
$result0 = $ilink->query($sql0);

$sql = "SELECT usuid, message, date, isread, usuarios.alumnon, tamatach, nomatach, message_histo.id FROM message_histo LEFT JOIN usuarios ON usuarios.id = message_histo.usuid WHERE (usuid='$sender' AND parausuid='$uid') OR (usuid='$uid' AND parausuid='$sender') ORDER BY message_histo.date";
$result = $ilink->query($sql);

if (!$result->num_rows AND !$result0->num_rows) {
		echo "<p><br>No hay hist&oacute;rico</p>";
		exit;
}

echo "<p class='b'>".i("histo",$ilink).":</p>";

echo unmensa($sql,'',$ilink,'');

if ($result0->num_rows) {echo "<p></p><hr class='sty'>";}

echo unmensa($sql0,'',$ilink,'');

?>

