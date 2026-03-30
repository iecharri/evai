<?php

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

if ($_SESSION['auto'] < 2) {exit;}

$sql = "SELECT vinculos.id, usu_id, titulo, url, fechacrea1, vinculos.fecha1, vinculos.area, claves, resumen, amplia, numvotos, vinculos.desvtip, 
vinculos.nota, clicks, asignatura, roto, idcat FROM vinculos LEFT JOIN podasignaturas ON podasignaturas.cod = vinculos.area WHERE !sologrupotrab";

// --------------------------------------------------

if ($_SESSION['bu'][0]) {
	$n = 0;
	if (substr($_SESSION['bu'][0],0,2) == "\\\"") {
		$condi = $condi." AND (trim(vinculos.area) LIKE '%".substr($_SESSION['bu'][0],2,strlen($_SESSION['bu'][0])-4)."%') OR (trim(asignatura) LIKE '%".substr($_SESSION['bu'][0],2,strlen($_SESSION['bu'][0])-4)."%')";
	} else {

		$array = explode (" ", rtrim(ltrim($_SESSION['bu'][0])));
		//while (list(, $palabra) = each($array)) { 2024 cambiado por foreach
		foreach ($array as $key => $palabra) {
			if ($n == 0) {
				$condi = $condi." AND (vinculos.area LIKE '%".$palabra."%' OR asignatura LIKE '%".$palabra."%'";
				$n = 1;
			} else {
				$condi = $condi." OR vinculos.area LIKE '%".$palabra."%' OR asignatura LIKE '%".$palabra."%'";
			}
		}
		$condi = $condi.")";
	}
}

// --------------------------------------------------

if ($_SESSION['bu'][1]) {
	$condi = $condi." ".$_SESSION['bu'][4];
}

// --------------------------------------------------

if ($_SESSION['bu'][1]) {
	$n = 0;
	if (substr($_SESSION['bu'][1],0,2) == "\\\"") {
		$condi = $condi." (trim(vinculos.claves) LIKE '%".substr($_SESSION['bu'][1],2,strlen($_SESSION['bu'][1])-4)."%')";
	} else {

		$array = explode (" ", rtrim(ltrim($_SESSION['bu'][1])));
		foreach ($array as $palabra) {
			if ($n == 0) {
				$condi = $condi." (vinculos.claves LIKE '%".$palabra."%'";
				$n = 1;
			} else {
				$condi = $condi." OR vinculos.claves LIKE '%".$palabra."%'";
			}
		}
		$condi = $condi.")";
	}
}

// --------------------------------------------------

if ($_SESSION['bu'][2]) {
	$condi = $condi." ".$_SESSION['bu'][5];
}

// --------------------------------------------------

if ($_SESSION['bu'][2]) {
	$n = 0;
	if (substr($_SESSION['bu'][2],0,2) == "\\\"") {
		$condi = $condi." (trim(vinculos.titulo) LIKE '%".substr($_SESSION['bu'][2],2,strlen($_SESSION['bu'][2])-4)."%')";
	} else {
		$array = explode (" ", rtrim(ltrim($_SESSION['bu'][2])));
		//while (list(, $palabra) = each($array)) {
		foreach ($array as $palabra) {
		if ($n == 0) {
			$condi = $condi." (vinculos.titulo LIKE '%".$palabra."%'";
			$n = 1;
		} else {
			$condi = $condi." OR vinculos.titulo LIKE '%".$palabra."%'";
		}
		}
		$condi = $condi.")";
	}
}

// --------------------------------------------------

if ($_SESSION['bu'][3]) {
	$condi = $condi." ".$_SESSION['bu'][6];
}

// --------------------------------------------------

if ($_SESSION['bu'][3]) {
	$n = 0;
	if (substr($_SESSION['bu'][3],0,2) == "\\\"") {
		$condi = $condi." (trim(vinculos.url) LIKE '%".substr($_SESSION['bu'][3],2,strlen($_SESSION['bu'][3])-4)."%')";
	} else {

		$array = explode (" ", rtrim(ltrim($_SESSION['bu'][3])));
		//while (list(, $palabra) = each($array)) {
		foreach ($array as $palabra) {
			if ($n == 0) {
				$condi = $condi." (vinculos.url LIKE '%".$palabra."%'";
				$n = 1;
			} else {
				$condi = $condi." OR vinculos.url LIKE '%".$palabra."%'";
			}
		}
		$condi = $condi.")";
	}
}

// --------------------------------------------------

if ($_SESSION['bu'][7]) {
	$condi .=  " AND vinculos.fechacrea1 >= '".$_SESSION['bu'][7][0]."'";
}

if ($_SESSION['bu'][8]) {
	$dt = new DateTime($_SESSION['bu'][8][0], new DateTimeZone('UTC'));
	$dt->modify('+1 day');  // siguiente día a las 00:00
	$condi .= " AND vinculos.fechacrea1 < '".$dt->format('Y-m-d 00:00:00')."'";
}

// --------------------------------------------------


if ($_SESSION['cat'][0][1]) {
	$condi .= " ".$_SESSION['cat'][0][0]." gc0 = '".$_SESSION['cat'][0][1]."'";
}
if ($_SESSION['cat'][1][1]) {
	$condi .= " ".$_SESSION['cat'][1][0]." gc1 = '".$_SESSION['cat'][1][1]."'";
}
if ($_SESSION['cat'][2][1]) {
	$condi .= " ".$_SESSION['cat'][2][0]." gc2 = '".$_SESSION['cat'][2][1]."'";
}
if ($_SESSION['cat'][3][1]) {
	$condi .= " ".$_SESSION['cat'][3][0]." gc3 = '".$_SESSION['cat'][3][1]."'";
}
if ($_SESSION['cat'][4][1]) {
	$condi .= " ".$_SESSION['cat'][4][0]." gc4 = '".$_SESSION['cat'][4][1]."'";
}

// --------------------------------------------------

$sql = $sql.$condi;

// --------------------------------------------------

$bva = "SELECT apartirde FROM cursasigru WHERE asigna = '".$_SESSION['asigna']."' AND curso = '".$_SESSION['curso']."' AND grupo = '".$_SESSION['grupo']."'";
$iresult = $ilink->query($bva);
$bva = $iresult->fetch_array(MYSQLI_BOTH);
$bva = $bva[0];

if ($bva AND $bva != "0000-00-00") {
	$sql .= " AND fechacrea >= '$bva'";
}

?>