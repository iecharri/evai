<?php

// Copyright (c) 2000-2026 Inmaculada Echarri San Adrián
// Copyright (c) 2000-2026 Antonio Grandío Botella
// This file is part of EVAI.
// Licensed under the MIT License.
// See LICENSE.txt for details.

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

if ($_SESSION['auto'] < 10) {exit;}

$caso = 5;

require_once APP_DIR . "/pod/podformfiltro.php";

if (!$filtrocurso) {
	echo "<p class='rojo b'>Seleccionar un Curso</p>";
	return;
}

$pod = trim(str_replace(" ","",$pod));
if (!$crear AND ($pod < 2010 OR $pod == $filtropod)) {
	if ($pod) {echo "<p class='rojo b mediana'>Teclea un Curso v&aacute;lido</p>";}
	echo "<form method='post'>";
	echo "<p>Crear POD del curso ";
	echo "<input class='col-1' type='text' name='pod' size='4' maxlength='4' value='$pod'>";
	echo " a partir del seleccionado <input class='col-1' type='submit' value= ' >> '>";
	echo "</p></form>";
	return;
}

if (!$crear) {
	echo "<p><span class='b'>Se va a crear el POD del curso <span class='txth mediana'>$pod</span>";
	echo " a partir del POD <span class='txth mediana'>$filtrocurso</span></span></p>";
	echo "<p class='rojo b'>Si existen datos del POD - $pod no ser&aacute;n modificados.</p>";
	echo "<form method='post'><p class='mediana'>Pulsar para continuar</p>";
	echo " <input type='hidden' name='pod' value='$pod'>";
	echo " <input class='col-2' type='submit' name='crear' value=' >> '></form>";
	return;
}

$newpod = $pod;
$oldpod = $filtrocurso;

if (!$newpod OR !$oldpod OR $newpod < $oldpod) {
	return;
}

// tablas

$tabla = array();

$tabla[] = "podcursofigura";
$tabla[] = "podcursocargos";
$tabla[] = "podcursoareagruposa";
$tabla[] = "titcuradmi";
$tabla[] = "profcurareafigura";
$tabla[] = "podcursoasigna";
$tabla[] = "podcursoasignatit";
$tabla[] = "podcursoasignaarea";
$tabla[] = "podcursoasigna"; 
$tabla[] = "cursasigru";
//$tabla[] = "asignatprof";

//&oacute;rdenes

$orden = array();

$orden[] = "create temporary table ppp like tabla";
$orden[] = "insert into ppp select * from tabla where curso='oldpod'";
$orden[] = "update ppp set curso='newpod'";
$orden[] = "insert ignore into tabla select * from ppp";
$orden[] = "drop table ppp";

foreach($tabla as $indicet => $cadatabla) {
	foreach($orden as $indiceo => $cadaorden) {
		$sql = str_replace("tabla",$cadatabla,$cadaorden);
		$sql = str_replace("oldpod",$oldpod,$sql);	
		$sql = str_replace("newpod",$newpod,$sql);
		$ilink->query($sql);	
	}
}

$orden[] = "create temporary table ppp like tabla";
$orden[] = "insert into ppp select * from tabla where curso='oldpod'";
$orden[] = "update ppp set curso='newpod'";
$orden[] = "insert ignore into tabla (area,usuid,asigna,curso,grupo,semestre,ct,cp,cte,cpr,cl,cs,ctu,ce,disponible) select area,usuid,asigna,curso,grupo,semestre,ct,cp,cte,cpr,cl,cs,ctu,ce,disponible from ppp";
$orden[] = "drop table ppp";

$cadatabla = "asignatprof";
foreach($orden as $indiceo => $cadaorden) {
	$sql = str_replace("tabla",$cadatabla,$cadaorden);
	$sql = str_replace("oldpod",$oldpod,$sql);	
	$sql = str_replace("newpod",$newpod,$sql);
	$ilink->query($sql);	
}

echo "<p class='txth b grande'>HECHO</p>";

?>
