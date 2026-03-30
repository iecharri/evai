<?php

require_once __DIR__ . '/../siempre_base.php';

$nomatach = $_FILES['file']['name'];
$tipo    = $_FILES["file"]["type"];
$archivo = $_FILES["file"]["tmp_name"];
$tamanio = $_FILES["file"]["size"];
$contenido = file_get_contents($archivo);
$contenido = $ilink->real_escape_string($contenido);
$uid = $_SESSION['usuid'];
$temp = gmdate("Y-m-d H:i:s");

$ilink->query("INSERT INTO grabaciones (usuid, date, tamatach, tipoatach, nomatach, attachment)
 VALUES (\"$uid\", \"$temp\", \"$tamanio\", \"$tipo\", \"$nomatach\", \"$contenido\")");

print "***";

?>
