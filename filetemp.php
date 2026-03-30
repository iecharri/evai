<?php  
// Permite la descarga de un archivo ocultando su ruta  

require_once __DIR__ . '/siempre_base.php';

if ($_SESSION['auto'] < 4) {return;}

$fich = $_GET['fich'];

$directorio = "/".DATA_DIR."/temp/"; 
$filename = $_SESSION["path"].$directorio.$fich;

$size = filesize($filename); 
header("Content-Transfer-Encoding: binary");  
header("Content-type: application/force-download");  
header("Content-Disposition: attachment; filename=$fich");  
header("Content-Length: $size");  
readfile("$filename");  
?>   