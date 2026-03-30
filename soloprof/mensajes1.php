<?php

require_once __DIR__ . "/../siempre_base.php";

if ($_SESSION['auto'] < 5 ) {
	exit;
}

require_once APP_DIR . "/enviospor.php";

$num = $_GET['num'];
$desde = $_GET['desde'];

//a quién voy a enviar
$para = $_GET['usuid'];
$sql = "SELECT alumnon FROM usuarios WHERE id='$para'";
$result = $ilink->query($sql);
$nombre = $result->fetch_array(MYSQLI_BOTH);

//asunto
$asuntomailx = "mensajes en ".ucfirst(SITE);

//texto
$textomailx = "Hola $nombre[0], tienes $num mensaje(s) por leer. Click <a target='_blank' href= '" . DOMINIO .APP_URL. "/usuarios.php?us=m'>aquí</a> para acceder a leerlos.";

//remitente: admin de evai
$sql = "SELECT adminid FROM atencion";
$result = $ilink->query($sql);
$fila = $result->fetch_array(MYSQLI_BOTH);
$de = $fila[0];

$cuando = gmdate('Y-m-d H:i:s');

$sql = "UPDATE usuarios SET hsmremind = '".$cuando."' WHERE id = '$para'";
$ilink->query($sql);
		
$exito = pormail($de,$para,$asuntomailx,$textomailx,trim($textomailx),$ilink);

if($exito) {
	echo " <span class='icon-checkmark'></span>";
	echo "<br><span class='peq'>Avisado por mail el ".ifecha31($cuando,$ilink)."</span>";
} else {
	echo "ERROR";
}

?>