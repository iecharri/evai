<?php

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

$filtro = "asigna = '".$_SESSION['asigna']."' AND curso = '".$_SESSION['curso']."' AND grupo='".$_SESSION['grupo']."'";

if ($_POST['banner']) {
	$temp = $_POST['banner1'];
	$ilink->query("UPDATE cursasigru SET banner = '$temp' WHERE $filtro");
}

$iresult = $ilink->query("SELECT banner FROM cursasigru WHERE $filtro");
$atencion = $iresult->fetch_array(MYSQLI_BOTH);

echo "Mensaje:<br>";
echo "Para quitar el mensaje dejar vac&iacute;o (m&aacute;ximo 255 caracteres.)";

echo "<p></p><form action='?' method='post'><input type='text' name='banner1' size='50' maxlength='255' value='$atencion[0]'>";
echo "<br> <input class='col-1' type='submit' name='banner' value=\">>\"></form>";

$ret = $atencion[0];

?>