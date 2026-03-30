<?php

require_once __DIR__ .  "/siempre_base.php";

if ($_SESSION['auto'] < 3) {return;}

$id = $_GET['id'];

$qry = "SELECT tipoatach, attachment, nomatach, descrip FROM recurgen WHERE id=$id LIMIT 1";
$iresult = $ilink->query($qry);
$res = $iresult->fetch_array(MYSQLI_BOTH);

$tipo = $res[0];
$contenido = $res[1];
$res[2] = str_replace(" ", "_", $res[2]);

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