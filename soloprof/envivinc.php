<?php

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

if (!$_GET['enviv']) {
	echo "<p></p><a class='mediana center' href='?enviv=1'>ENVIAR</a>";
	return;
}
error_reporting(0);
$fecha_menos3meses = gmdate('Y-m-d',time()-(3*30*24*60*60));
$sql = "SELECT id, alumnon, alumnoa, mail, buscar FROM usuarios WHERE 
fechabaja = '0000-00-00 00:00:00' AND buscar != '' AND mail != '' AND fechalogin > '$fecha_menos3meses'";
$result = $ilink->query($sql);

$_SESSION['asigna0'] = $_POST['asigna0'];
$_SESSION['claves0'] = $_POST['claves0'];
$_SESSION['titulo0'] = $_POST['titulo0'];
$_SESSION['pagina0'] = $_POST['pagina0'];
$_SESSION['orand10'] = $_POST['orand10'];
$_SESSION['orand20'] = $_POST['orand20'];
$_SESSION['orand40'] = $_POST['orand40'];
unset($_SESSION['orden']);

$iresult = $ilink->query("SELECT DATE_FORMAT(vincmail,'%Y%m%d') FROM atencion");
$fecha = $iresult->fetch_array(MYSQLI_BOTH);

$fecha1 = $fecha[0];
$iresult = $ilink->query("SELECT adminid FROM atencion");
$from = $iresult->fetch_array(MYSQLI_BOTH);

echo "<div class='colu' style='height:10em;overflow:auto'>";

while ($fila = $result->fetch_array(MYSQLI_BOTH))

{

	$id = $fila['id'];

	$_SESSION['bu'][1] = $fila['buscar'];

	require_once APP_DIR . "/busquedas_sql_simp.php";

	$result1 = $ilink->query($sql." AND DATE_FORMAT(vinculos.fecha,'%Y%m%d') >= ".$fecha_menos3meses." ORDER BY vinculos.fecha DESC");

	$cuerpo = '';
	$n = 30;

	while ($fila1 = $result1->fetch_array(MYSQLI_BOTH) AND $n > 0)

	{

		$n = $n - 1;
		$cuerpo = $cuerpo."<a href=http://".$fila1['url'].">".$fila1['titulo']."</a><br>";

	}

	if ($cuerpo) {
		$n = 1;
		echo "Enviando correo a ".$fila['alumnon']." ".$fila['alumnoa']."<br>";
		$cuerpo1 = "Hola ".$fila['alumnon']." ".$fila['alumnoa'];
		$cuerpo1 .= ".<br>Estos son los &uacute;ltimos v&iacute;nculos introducidos en ".ucfirst(SITE)." sobre el tema <span class=b>".$_SESSION['bu'][1]."</span>:<p></p>".$cuerpo;
		$exito = pormail($from[0], $fila['id'], ucfirst(SITE).": nuevos v&iacute;nculos", $cuerpo1, $cuerpo1,$ilink);
		if ($exito) {echo "<br><span class='txth b'>Env&iacute;o realizado por mail</span>";} else {echo " <span class='rojo b'>Error</span><br>";}
	}

}

echo "</div>";

$fecha = gmdate("Ymd");
$ilink->query("UPDATE atencion SET vincmail = '$fecha'");

if ($n == 1) {
	echo "<p></p>Completado";
} else {
	echo "<p></p>No hay correos para enviar";
}

?>