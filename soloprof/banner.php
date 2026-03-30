<?php

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

if ($_POST['banner']) {
	$temp = $_POST['banner1'];
	$ilink->query("UPDATE atencion SET atencion = '$temp'");
}

$iresult = $ilink->query("SELECT atencion FROM atencion");
$atencion = $iresult->fetch_array(MYSQLI_BOTH);

echo "Mensaje a mostrar por Administradores en la barra superior<br>";
echo "Para quitar el mensaje dejar vac&iacute;o (m&aacute;ximo 255 caracteres.)";

echo "<p></p><form action='admin.php' method='post'><input type='text' name='banner1' size='50' maxlength='255' value='$atencion[0]'>";
echo "<br><input type='submit' name='banner' value=\">>\"></form>";

$ret = $atencion[0];

?>