<?php

// recibe $asigna, $curso y $grupo de var_usu
defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

if ($_SESSION['tipo'] == 'E' AND $_SESSION['auto'] < 10) {  //este $_SESSION['auto'] lo da autoini(), luego toma $_SESSION['auto'] segun la asignatura, con auto()
	return;
}

if ($_SESSION['entra']) {
	if (!esmio($asigna,$curso,$grupo,$ilink) OR !existe($asigna,$curso,$grupo,$ilink)) {
		$temp = elegirasicurgru($asigna,$curso,$grupo,$ilink);
		$asigna = $temp[0];
		$curso = $temp[1];
		$grupo = $temp[2];
	}
} else {
	$abriralerta = 0;
	if ($asigna AND (!esmio($asigna,$curso,$grupo,$ilink) OR !existe($asigna,$curso,$grupo,$ilink))) {
		$abriralerta = 1;
	}
}

if (!esmio($asigna,$curso,$grupo,$ilink) OR !existe($asigna,$curso,$grupo,$ilink)) {
	return;
}

$_SESSION['auto'] = auto($_SESSION['usuid'],$asigna,$curso,$grupo,1,$ilink);

$iresult = $ilink->query("SELECT visibleporalumnos FROM cursasigru WHERE asigna = '$asigna' AND curso = '$curso' AND grupo = '$grupo'");
$fila1 = $iresult->fetch_array(MYSQLI_BOTH);

if (!$fila1[0] AND !esprofesor($asigna,$curso,$grupo,$ilink) AND !soyadmiano($asigna,$curso,$ilink)) {
	return;
}
$sql = "SELECT gc, tipasig, tit FROM podcursoasigna
	LEFT JOIN podcursoasignatit ON
	podcursoasignatit.curso = podcursoasigna.curso WHERE podcursoasigna.asigna = podcursoasignatit.asigna AND podcursoasigna.asigna = '$asigna' 
	AND podcursoasigna.curso = '$curso'";
$iresult = $ilink->query($sql);
$fila1 = $iresult->fetch_array(MYSQLI_BOTH);
$iresult = $ilink->query("SELECT gic FROM cursasigru WHERE asigna = '$asigna' AND curso = '$curso' AND grupo='$grupo'");
$gic = $iresult->fetch_array(MYSQLI_BOTH);
$_SESSION['asigna'] = trim($asigna);
if ($fila1['tipasig']) {$_SESSION['curso'] = $curso;} else {$_SESSION['curso'] = ""; $curso="";}
$_SESSION['grupo'] = $grupo;
if (!$_SESSION['grupo']) {$_SESSION['grupo'] = "";}
$_SESSION['tit'] = strtoupper($fila1[2]);
$_SESSION['filtrocurso'] = $_SESSION['curso'];

$ilink->query("UPDATE usuarios SET ultasigna = '$asigna', ultcurso = '$curso', ultgrupo='$grupo' WHERE id = '".$_SESSION['usuid']."' LIMIT 1");

$_SESSION['gic'] = $gic[0];
$_SESSION['gc'] = $fila1[0];
$_SESSION['tipasig'] = $fila1[1];

?>