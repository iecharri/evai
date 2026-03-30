<?php

require_once __DIR__ . "/../siempre_base.php";

if ($_SESSION['auto'] < 5 ) {
	exit;
}

$asigna = $_SESSION['asigna'];
$curso = $_SESSION['curso'];
$grupo = $_SESSION['grupo'];
$id = $_GET['id'];
$fecha = $_GET['fecha'];

$ilink->query("INSERT INTO asistencia (usuid, asigna, curso, grupo, fecha) VALUES ('$id', '$asigna', '$curso', '$grupo', '$fecha')");

$sql = "UPDATE asistencia SET asistencia = '' WHERE fecha = '$fecha' AND usuid = '$id' AND
asigna = '".$_SESSION['asigna']."' AND curso = '".$_SESSION['curso']."' AND grupo = '".$_SESSION['grupo']."'";

$ilink->query($sql);
echo "<a href=\"javascript:llamarasincrono('asistencia2.php?fecha=$fecha&id=$id','v$id$fecha')\" class='nob'>*</a>";

?>