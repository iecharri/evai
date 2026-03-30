<?php

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

$filtro = "asigna = '".$_SESSION['asigna']."' AND curso = '".$_SESSION['curso']."' AND grupo='".$_SESSION['grupo']."'";

if ($_POST['pmail']) {
	$temp = $_POST['pmail1'];
	$ilink->query("UPDATE cursasigru SET patronmail = '$temp'");
}

$iresult = $ilink->query("SELECT patronmail FROM cursasigru WHERE $filtro");
$mail = $iresult->fetch_array(MYSQLI_BOTH);

if ($mail[0]) {
	echo "Actualmente es: $mail[0]";
}

echo "<p></p>
		<form name='diva1' action='?' method='post'>Cadena 
		<input class='col-5' type='text' name='pmail1' size='25' maxlength='' value='$mail[0]'> 
		<input class='col-1' name='pmail' type='submit' value=\">>\"></form>";
		
$ret = $mail[0];

?>