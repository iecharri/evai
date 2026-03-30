<?php

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

if ($_SESSION['auto'] < 5) {echo "<p></p><br>".i("usunoauto",$ilink);exit;}

extract($_GET);
extract($_POST);

$tit = $_SESSION['tit'];
$asigna = $_SESSION['asigna'];
$curso = $_SESSION['curso'];
$grupo = $_SESSION['grupo'];

$sqlalu = "SELECT DISTINCT usuarios.id, auto, autorizado, privacidad, usuario FROM alumasiano LEFT JOIN usuarios ON alumasiano.id = usuarios.id WHERE auto > 1 AND autorizado > 1 AND fechabaja = '0000-00-00 00:00:00' AND asigna = '$asigna' AND curso = '$curso' AND grupo = '$grupo' ORDER BY usuarios.alumnoa, usuarios.alumnon ";
$resultalu = $ilink->query($sqlalu);

echo "<div class='mediana center'>Aportaciones de cada Alumno al Foro de $asigna $curso $grupo</div><p></p>";

while ($filaalu = $resultalu->fetch_array(MYSQLI_BOTH)) {

	$_GET['usuid'] = $filaalu[0];
	$imprimir = 1;
	
	require_once APP_DIR . "/soloprof/forosusu.php";
		
}

?>