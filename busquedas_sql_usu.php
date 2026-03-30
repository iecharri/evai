<?php

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

if (!$pest) {return;}

$result = $ilink->query("SELECT alumnoa, alumnon, privacidad, usuario FROM usuarios WHERE id = '$usuid' LIMIT 1");
$fila = $result->fetch_array(MYSQLI_BOTH);

if ($fila['privacidad'] < 2 OR $_SESSION['auto'] > 4) {
	$alumnon = rtrim($fila['alumnon'])." ".rtrim($fila['alumnoa']);
} else {
	$alumnon = $fila['usuario'];
}

$sql = "SELECT vinculos.id, usu_id, titulo, url, fechacrea, vinculos.fecha, vinculos.area, claves,
	resumen, amplia, vinculos.numvotos, vinculos.desvtip, vinculos.nota, clicks, asignatura, roto
	FROM vinculos LEFT JOIN podasignaturas ON podasignaturas.cod = vinculos.area
	WHERE vinculos.usu_id = '$usuid'";

if ($soloasigna) {$sql = $sql." AND vinculos.area = '$asigna'";}

$iresult = $ilink->query($sql);
$numvinculos = $iresult->num_rows;

if ($numvinculos AND !$_GET['id']) {

if ($usuid != $_SESSION['usuid']) {
	$tit = "<p></p><span class='b'>";
	$tit .= str_replace("(vinculos)", $numvinculos, str_replace("(nombre)", $alumnon, i("hainsertado",$ilink))); 
	if (trim($asigna)) {$tit .= " ".i("de",$ilink)." ".$asigna;}
	$tit .= ":</span><br>";
} else {
	$tit = "<p></p>".str_replace("<numvinculos>", $numvinculos, i("estosson",$ilink))."<br>";
	if (trim($asigna)) {
		$temp = i("de",$ilink)." ".$asigna;
		$tit = "<p></p>".str_replace("<deasigna>", $temp, $tit);
	}
}

}

?>