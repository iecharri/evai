<?php

require_once __DIR__ . '/../siempre_base.php';

// --------------------------------------------------

$id = $_GET['idfoto'];
$tabla = $_GET['tabla'];

iconex(DB2,$ilink);

// --------------------------------------------------
 
$sql = "SELECT imagen, tipofich FROM $tabla WHERE n='$id'";
$result  = $ilink->query($sql);
$fila = $result->fetch_array(MYSQLI_BOTH);

$mime = $fila[1];
$imagen = $fila[0];

// --------------------------------------------------

if (preg_match('/^image/',$mime)) {
	header("Content-Type: $mime");
	echo $imagen;   
}

// --------------------------------------------------

if (preg_match('/^video/',$mime)) {
	header("Content-Type: $mime"); //video/x-ms-wmv
	echo $imagen;   
}

?>