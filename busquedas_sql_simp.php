<?php

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

if ($_SESSION['auto'] < 2) {exit;}

$claves = stripslashes($_SESSION['bu'][1]);

if (!$claves AND !$_POST['usuarios']) {
	$sql = "SELECT vinculos.id, usu_id, titulo, url, fechacrea, vinculos.fecha, vinculos.area, claves, resumen, amplia, numvotos, vinculos.desvtip, 
	vinculos.nota, clicks, asignatura, roto, idcat FROM vinculos LEFT JOIN podasignaturas ON podasignaturas.cod = vinculos.area WHERE !sologrupotrab";
	return;
}

if ($_POST['usuarios']) {

	$sql = "SELECT DISTINCT usuarios.id FROM vinculos LEFT JOIN podasignaturas ON vinculos.area=podasignaturas.cod LEFT JOIN usuarios ON 
	usuarios.id = vinculos.usu_id WHERE !sologrupotrab AND MATCH(titulo, url, area, claves, resumen, amplia) AGAINST('$claves') ";

} else {

	$sql = "SELECT id, usu_id, titulo, url, fechacrea, fecha, area, claves, resumen, amplia, numvotos, desvtip, nota, clicks, roto, 
	MATCH(titulo, url, area, claves, resumen, amplia) AGAINST ('$claves') AS relevancia, asignatura FROM vinculos 
	LEFT JOIN podasignaturas ON vinculos.area=podasignaturas.cod WHERE !sologrupotrab AND 
	MATCH(titulo, url, area, claves, resumen, amplia) AGAINST ('$claves')";

}

?>
