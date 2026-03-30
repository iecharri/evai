<?php

require_once __DIR__ . '/siempre_base.php';

$id = $_GET['id'];

$qry = "SELECT tipoatach, attachment, nomatach, usuid FROM grabaciones WHERE id=$id LIMIT 1";
$iresult = $ilink->query($qry);
$res = $iresult->fetch_array(MYSQLI_BOTH);
if ($res[3] != $_SESSION['usuid']) {exit;}

$tipo = $res[0];
$contenido = $res[1];
$uid = $res['usuid'];
$temp = gmdate("Y-m-d H:i:s");

header("Pragma: public");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Cache-Control: private",false);
header("Content-Description: File Transfer"); 
header("Content-Type: application/force-download"); 
header("Content-Length: " . strlen($contenido)); 
header("Content-Disposition: attachment; filename=$res[2]"); 

print $contenido;

?>