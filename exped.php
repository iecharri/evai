<?php

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

if(!$usuid) {$usuid = $_SESSION['usuid'];}

$iresult = $ilink->query("SELECT altalibre FROM atencion");
$alta = $iresult->fetch_array(MYSQLI_BOTH);

$calif = 1; $formlibocu = 1;
$iconflecha = "<span class='icon-arrow-right2'></span> ";
	
$novacio = 1;
$caso = 5; require_once APP_DIR . '/pod/podformfiltro.php';
if ($noselecc) {return;}

// ------------- ALUMNO DE

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

	if ($_POST['libocu']) {
		$ilink->query("UPDATE alumasiano SET disponible = '".$_POST['lib_ocu']."' WHERE id = '$usuid' AND asigna = '".$_POST['asigna1']."' AND curso = '".$_POST['curso1']."' AND grupo = '".$_POST['grupo1']."'");
	}

	$curso = '';
	require_once APP_DIR . '/vernotas.php'; 

	while ($fila = $result->fetch_array(MYSQLI_BOTH)) {
	
		$iresult = $ilink->query("SELECT visibleporalumnos FROM cursasigru WHERE asigna = '".$fila['asigna']."' AND curso = '".$fila['curso']."' AND grupo = '".$fila['grupo']."'");
		$visi = $iresult->fetch_array(MYSQLI_BOTH);
		$iresult = $ilink->query("SELECT disponible FROM alumasiano WHERE id = '$usuid' AND asigna = '".$fila['asigna']."' AND curso = '".$fila['curso']."' AND grupo = '".$fila['grupo']."'");
		$libocu = $iresult->fetch_array(MYSQLI_BOTH);

		if ($titx != $fila['cod']) {
			echo "<h2>".$fila['cod']." ".$fila['titulacion']."</h2>";
			$titx = $fila['cod']; 
		}

		if ($formlibocu) {formulibocu($fila,$libocu[0],$usuid,$ilink);}

		echo $iconflecha;

		$bold1 = $bold2 = "";
		if ($_SESSION['asigna'] == $fila['asigna'] AND $_SESSION['curso'] == $fila['curso'] AND $_SESSION['grupo'] == $fila['grupo']) {
			$bold1 = "<span class='b'>";
			$bold2 = "</span>";		
		}

		if ($visi[0]) {
			echo "<a href='home.php?filtroasign=".$fila['asigna']."&curso=".$fila['curso']."&grupo=".$fila['grupo']."&y=1'>";
		}
		echo $bold1.$fila['asigna']." ".$fila['asignatura'];
		if ($fila['grupo']) {echo " ".i("grupo",$ilink)." ".$fila['grupo'];}
		echo $bold2;
		if ($visi[0]) {
			echo "</a>";
		}

		if (!$visi[0]) {echo "<br class='both'>&nbsp; &nbsp; <span class='rojo'>".i("asinovisi",$ilink)."</span>";}
		
		if ($calif AND ($_SESSION['auto']> 4 OR $usuid == $_SESSION['usuid'])) {
			$a = $fila['asigna'];
			$curso = $fila['curso'];
			$grupo = $fila['grupo'];
		}

	}
	
}

if ($_SESSION['auto'] < 5 OR $_GET['calif']) {echo "<p></p>";return;}

// --------------------------------------------------// PROFESOR DE

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

	if ($_POST['libocu']) {
		$ilink->query("UPDATE asignatprof SET disponible = '".$_POST['lib_ocu']."' WHERE usuid = '$usuid' AND asigna = '".$_POST['asigna1']."' AND curso = '".$_POST['curso1']."' AND grupo = '".$_POST['grupo1']."'");
	}

	while ($fila = $result->fetch_array(MYSQLI_BOTH)) {

		$iresult = $ilink->query("SELECT visibleporalumnos FROM cursasigru WHERE asigna = '".$fila['asigna']."' AND curso = '".$fila['curso']."' AND grupo = '".$fila['grupo']."'");
		$visi = $iresult->fetch_array(MYSQLI_BOTH);
		$iresult = $ilink->query("SELECT disponible FROM asignatprof WHERE usuid = '$usuid' AND asigna = '".$fila['asigna']."' AND curso = '".$fila['curso']."' AND grupo = '".$fila['grupo']."'");
		$libocu = $iresult->fetch_array(MYSQLI_BOTH);
		
		if ($titx != $fila['cod']) {
			echo "<h2>".$fila['cod']." ".$fila['titulacion']."</h2>";
			$titx = $fila['cod']; 
		}

		echo "<p></p>";

		if ($formlibocu) {formulibocu($fila,$libocu[0],$usuid,$ilink);}

		echo $iconflecha;

		$bold1 = $bold2 = "";
		if ($_SESSION['asigna'] == $fila['asigna'] AND $_SESSION['curso'] == $fila['curso'] AND $_SESSION['grupo'] == $fila['grupo']) {
			$bold1 = "<span class='b'>";
			$bold2 = "</span>";		
		}

		echo "<a href='home.php?filtroasign=".$fila['asigna']."&curso=".$fila['curso']."&grupo=".$fila['grupo']."&y=1'>";
		echo $fila['asigna']." ".$fila['asignatura'];
		if ($fila['grupo']) {echo " (".i("grupo",$ilink)." ".$fila['grupo'].")";}
		echo "</a>";

		if (!$visi[0]) {echo "<br>&nbsp; &nbsp; <span class='rojo'>".i("asinovisi",$ilink)."</span>";}

	}

}

// --------------------------------------------------/ ADMI DE

if ($_SESSION['auto'] == 10 AND $usuid == $_SESSION['usuid']) {
	$sql = "SELECT DISTINCT podtitulacion.cod, cursasigru.curso, cursasigru.grupo, podtitulacion.titulacion, cursasigru.asigna,asignatura
	FROM cursasigru LEFT JOIN podasignaturas ON cursasigru.asigna = podasignaturas.cod
	LEFT JOIN podcursoasignatit ON cursasigru.curso = podcursoasignatit.curso AND cursasigru.asigna = podcursoasignatit.asigna
	LEFT JOIN podtitulacion ON podcursoasignatit.tit = podtitulacion.cod
	WHERE podtitulacion.cod != 'NULL'";
	$sql .= " AND cursasigru.curso = '".trim($filtrocurso)."'";
	$sql .= " ORDER BY podtitulacion.cod, cursasigru.asigna";
} else {
	$sql = "SELECT DISTINCT podtitulacion.cod, podtitulacion.titulacion, titcuradmi.curso, podcursoasignatit.asigna, asignatura 
	FROM titcuradmi
	LEFT JOIN podcursoasignatit ON podcursoasignatit.curso = titcuradmi.curso AND podcursoasignatit.tit = titcuradmi.titulaci
	LEFT JOIN podtitulacion ON titcuradmi.titulaci = podtitulacion.cod 
	LEFT JOIN podasignaturas ON podcursoasignatit.asigna = podasignaturas.cod
	WHERE usuid = '$usuid'";
	$sql .= " AND titcuradmi.curso = '".trim($filtrocurso)."'";
	$sql .= " ORDER BY podtitulacion.cod, podcursoasignatit.asigna";
}

$result = $ilink->query($sql);
$fila = $result->num_rows;

if ($fila > 0) {

	echo "<h3>".i("admide",$ilink)."</h3><hr class='sty'>";
	$titx = "";

	while ($fila = $result->fetch_array(MYSQLI_BOTH)) {

		$iresult = $ilink->query("SELECT visibleporalumnos FROM cursasigru WHERE asigna = '".$fila['asigna']."' AND curso = '".$fila['curso']."' AND grupo = '".$fila['grupo']."'");
		$visi = $iresult->fetch_array(MYSQLI_BOTH);
		$iresult = $ilink->query("SELECT disponible FROM alumasiano WHERE id = '$usuid' AND asigna = '".$fila['asigna']."' AND curso = '".$fila['curso']."' AND grupo = '".$fila['grupo']."'");
		$libocu = $iresult->fetch_array(MYSQLI_BOTH);

		if ($titx != $fila['cod']) {
			echo "<h2>".$fila['cod']." ".$fila['titulacion']."</h2>";
			$titx = $fila['cod']; 
		}

		if ($fila['asigna']) {echo "<p></p>".$iconflecha;}

		$bold1 = $bold2 = "";
		if ($_SESSION['asigna'] == $fila['asigna'] AND $_SESSION['curso'] == $fila['curso'] AND $_SESSION['grupo'] == $fila['grupo']) {
			$bold1 = "<span class='b'>";
			$bold2 = "</span>";		
		}

		echo "<a href='home.php?filtroasign=".$fila['asigna']."&curso=".$fila['curso']."&grupo=".$fila['grupo']."&y=1'>";
		echo $fila['asigna']." ".$fila['asignatura'];
		if ($fila['grupo']) {echo " (".i("grupo",$ilink)." ".$fila['grupo'].")";}
		echo "</a>";

		if (!$visi[0] AND $fila['asigna']) {echo "<br class='both'>&nbsp; &nbsp; <span class='rojo'>".i("asinovisi",$ilink)."</span>";}

	}
		
}

// --------------------------------------------------

function formulibocu($fila,$libocu,$usuid,$ilink) {

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
