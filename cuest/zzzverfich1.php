<?php


require_once __DIR__ . '/../siempre_base.php';

// --------------------------------------------------

iconex(DB2,$ilink);

$id = $_GET['idfoto'];
$tabla = $_GET['tabla'];
// --------------------------------------------------

$query="select imagen from $tabla where n='$id'";
$rs = $ilink->query($query);

header("Content-type:video/x-ms-wmv");

$song = $rs->fetch_array(MYSQLI_BOTH);
echo $song[0];
?>