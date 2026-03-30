<?php

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

if (!$pest) {return;}

$result = $ilink->query("SELECT grupo FROM grupos WHERE id = '$grupoid'");
$fila = $result->fetch_array(MYSQLI_BOTH);

$sql = "SELECT vinculos.id, usu_id, titulo, url, fechacrea, vinculos.fecha, vinculos.area, claves,
	resumen, amplia, vinculos.numvotos, vinculos.desvtip, vinculos.nota, clicks, asignatura, roto
	FROM vinculos LEFT JOIN podasignaturas ON podasignaturas.cod = vinculos.area
	WHERE vinculos.engrupotrab = '$grupoid'";

$iresult = $ilink->query($sql);
$numvinculos = $iresult->num_rows;

if ($numvinculos AND !$_GET['id']) {
	$tit = "<p></p><span class='b'>";
	$tit .= str_replace("(vinculos)", $numvinculos, str_replace("(nombre)", $fila[0], i("hainsertado",$ilink))); 
	$tit .= ":</span><br>";
}

?>