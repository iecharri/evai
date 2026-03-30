<?php

// Copyright (c) 2000-2026 Inmaculada Echarri San Adrián
// Copyright (c) 2000-2026 Antonio Grandío Botella
// This file is part of EVAI.
// Licensed under the MIT License.
// See LICENSE.txt for details.

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

$iconflecha = "<span class='icon-arrow-right'></span> ";
	
$caso=5; require_once APP_DIR . '/pod/podformfiltro.php';

// -------------------------------------------------- ALUMNO DE

$sql = "SELECT DISTINCT alumasiano.asigna, alumasiano.curso, grupo, asignatura, podtitulacion.cod, podtitulacion.titulacion
	FROM alumasiano LEFT JOIN podcursoasigna ON podcursoasigna.asigna = alumasiano.asigna AND podcursoasigna.curso = alumasiano.curso
	LEFT JOIN podcursoasignatit ON podcursoasignatit.asigna = podcursoasigna.asigna AND podcursoasignatit.curso = podcursoasigna.curso
	LEFT JOIN podtitulacion ON podcursoasignatit.tit = podtitulacion.cod
	LEFT JOIN podasignaturas ON podcursoasigna.asigna = podasignaturas.cod
	WHERE alumasiano.id = '$usuid'";
	$sql .= " AND alumasiano.curso = '".trim($filtrocurso)."'";
	$sql .= " ORDER BY podasignaturas.cod";

$result = $ilink->query($sql);
$fila = $result->num_rows;

if ($fila > 0) {

	$curso = '';

	while ($fila = $result->fetch_array(MYSQLI_BOTH)) {

		$iresult = $ilink->query("SELECT visibleporalumnos FROM cursasigru WHERE asigna = '".$fila['asigna']."' AND curso = '".$fila['curso']."' AND grupo = '".$fila['grupo']."'");
		$visi = $iresult->fetch_array(MYSQLI_BOTH);

		if ($titx != $fila['cod']) {
			echo "<h3>".$fila['cod']." ".$fila['titulacion']."</h3>";
			$titx = $fila['cod']; 
		}

		echo "<p></p>".$iconflecha;
		echo $fila['asigna']." ".$fila['asignatura'];
		if ($fila['grupo']) {echo " ".i("grupo",$ilink)." ".$fila['grupo'];}
		if (!$visi[0]) {echo "<br class='both'><span class='rojo'>".i("asinovisi",$ilink)."</span>";}
		
	}
	
}

// -------------------------------------------------- PROFESOR DE

$sql = "SELECT DISTINCT asignatprof.asigna, asignatprof.curso, asignatprof.grupo, asignatura, podtitulacion.cod, podtitulacion.titulacion,
	 visibleporalumnos
	FROM asignatprof
	LEFT JOIN podcursoasigna ON asignatprof.asigna = podcursoasigna.asigna AND asignatprof.curso = podcursoasigna.curso
	LEFT JOIN podasignaturas ON podcursoasigna.asigna = podasignaturas.cod
	LEFT JOIN podcursoasignatit ON podcursoasigna.curso = podcursoasignatit.curso AND podcursoasigna.asigna = podcursoasignatit.asigna
	LEFT JOIN podtitulacion ON podcursoasignatit.tit = podtitulacion.cod
	LEFT JOIN cursasigru ON cursasigru.asigna = asignatprof.asigna AND
	cursasigru.curso = asignatprof.curso AND cursasigru.grupo = asignatprof.grupo
	WHERE asignatprof.usuid = '$usuid'";
	$sql .= " AND cursasigru.curso = '".trim($filtrocurso)."'";
	$sql .= " ORDER BY asignatprof.asigna";

$result = $ilink->query($sql);
$fila = $result->num_rows;

if ($fila > 0) {

	while ($fila = $result->fetch_array(MYSQLI_BOTH)) {

		$iresult = $ilink->query("SELECT visibleporalumnos FROM cursasigru WHERE asigna = '".$fila['asigna']."' AND curso = '".$fila['curso']."' AND grupo = '".$fila['grupo']."'");
		$visi = $iresult->fetch_array(MYSQLI_BOTH);

		if ($titx != $fila['cod']) {
			echo "<h3>".$fila['cod']." ".$fila['titulacion']."</h3>";
			$titx = $fila['cod']; 
		}

		echo "<p></p>".$iconflecha;
		echo $fila['asigna']." ".$fila['asignatura'];
		if ($fila['grupo']) {echo " (".i("grupo",$ilink)." ".$fila['grupo'].")";}
		if (!$visi[0]) {echo "<br class='both'><span class='rojo'>".i("asinovisi",$ilink)."</span>";}

	}

}

// -------------------------------------------------- ADMI DE

$sql = "SELECT DISTINCT podtitulacion.cod, podtitulacion.titulacion, titcuradmi.curso, podcursoasignatit.asigna, asignatura 
	FROM titcuradmi
	LEFT JOIN podcursoasignatit ON podcursoasignatit.curso = titcuradmi.curso AND podcursoasignatit.tit = titcuradmi.titulaci
	LEFT JOIN podtitulacion ON titcuradmi.titulaci = podtitulacion.cod 
	LEFT JOIN podasignaturas ON podcursoasignatit.asigna = podasignaturas.cod
	WHERE usuid = '$usuid'";
$sql .= " AND titcuradmi.curso = '".trim($filtrocurso)."'";
$sql .= " ORDER BY podtitulacion.cod, podcursoasignatit.asigna";

$result = $ilink->query($sql);
$fila = $result->num_rows;

if ($fila > 0) {

	echo "<p></p><br><span class='b'>".i("admide",$ilink)."</span><hr>";
	$titx = "";

	while ($fila = $result->fetch_array(MYSQLI_BOTH)) {

		if ($titx != $fila['cod']) {
			echo "<h3>".$fila['cod']." ".$fila['titulacion']."</h3>";
			$titx = $fila['cod']; 
		}

		if ($fila['asigna']) {echo $iconflecha;}
		echo $fila['asigna']." ".$fila['asignatura'];

	}
		
}

// --------------------------------------------------

function formulibocu($fila,$libocu,$usuid) {

	if ($usuid != $_SESSION['usuid'] AND 
	(!esprofesor($fila['asigna'],$fila['curso'],$fila['grupo'],$ilink) OR !esprofesordetit($fila['tit'],$fila['curso'],$ilink)))
	{return;}
		
	echo "<form method='post' name='form".$fila['asigna']."\$".$fila['curso']."\$".$fila['grupo']."'>";
	echo "<input type='hidden' name='filtroano1' value='".$_POST['filtroano1']."'>";
	echo "<input type='hidden' name='filtroano' value='1'>";
	echo "<input type='hidden' name='libocu' value='1'>";
	echo "<input type='hidden' name='asigna1' value='".$fila['asigna']."'>";
	echo "<input type='hidden' name='curso1' value='".$fila['curso']."'>";
	echo "<input type='hidden' name='grupo1' value='".$fila['grupo']."'>";
	echo " <select class='selectcss' name='lib_ocu' onchange='javascript:this.form.submit()'>";
	echo "<option value='0'>".i("libre",$ilink)."</option>";
	echo "<option value='1'";
	if ($libocu) {echo " selected='selected'";}
	echo ">".i("ocupado",$ilink)."</option>";
	echo "</select>";
	echo "</form> &nbsp;";

}

?>
