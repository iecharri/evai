<?php

require_once __DIR__ . '/../siempre_base.php';

$id = $_GET['id'];

$qry = "SELECT fich,nombre,type FROM fichaanotaci WHERE n=$id";
$iresult = $ilink->query($qry);
$res = $iresult->fetch_array(MYSQLI_BOTH);

$contenido = $res[0];

header("Pragma: public");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Cache-Control: private",false);
header("Content-Description: File Transfer"); 
header("Content-Type: $res[2]"); 
header("Content-Length: " . strlen($contenido)); 
header("Content-Disposition: attachment; filename=$res[1]"); 

print $contenido;

?>