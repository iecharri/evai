<?php

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

if ($_SESSION['auto'] < 5) {echo "<p></p><br>".i("usunoauto",$ilink);exit;}

extract($_GET);
extract($_POST);

$tit = $_SESSION['tit'];
$asigna = $_SESSION['asigna'];
$curso = $_SESSION['curso'];
$grupo = $_SESSION['grupo'];

$sqlprof = "SELECT DISTINCT usuarios.id, autorizado, privacidad FROM asignatprof LEFT JOIN usuarios ON asignatprof.usuid = usuarios.id 
	WHERE autorizado > 1 AND fechabaja = '0000-00-00 00:00:00' AND asigna = '$asigna' AND curso = '$curso' AND grupo = '$grupo' AND usuarios.id > 0 
	ORDER BY usuarios.alumnoa, usuarios.alumnon";

$resultprof = $ilink->query($sqlprof);

echo "<div class='mediana center'>Aportaciones de cada Profesor al Foro de $asigna $curso $grupo</div><p></p>";

while ($filaprof = $resultprof->fetch_array(MYSQLI_BOTH)) {

	$_GET['usuid'] = $filaprof[0];
	$imprimir = 1;
	
	require_once APP_DIR . "/soloprof/forosusu.php";
		
}

?>

	