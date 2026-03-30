<?php

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

if ($_POST['adminid']) {
	$temp = $_POST['adminid'];
	$ilink->query("UPDATE atencion SET adminid = '$temp'");
}

$iresult = $ilink->query("SELECT adminid, alumnon, alumnoa FROM atencion LEFT JOIN usuarios ON adminid = id");
$admi = $iresult->fetch_array(MYSQLI_BOTH);
if (!$admi[0]) {
	echo "<span class='rojo b'>&iexcl;Atenci&oacute;n! Un usuario Administrador ha de autorizarse como emisor / receptor de mails de sistema.</span>";
} else {
	echo "Actualmente es: ".$admi[1]." ".$admi[2];
}
$result = $ilink->query("SELECT id, alumnon, alumnoa FROM usuarios WHERE autorizado = '10'");
echo "<p></p><form name='diva1' action='?' method='post'><select class='col-10' name='adminid' size='8'>";
while ($fila = $result->fetch_array(MYSQLI_BOTH)) {
	echo "<option value='$fila[0]'";
	if ($fila[0] == $admi[0]) {echo " selected = 'selected'";}
	echo ">".$fila[1]." ".$fila[2];
}
echo "</select> <input class='col-10' type='submit' value=\">>\"></form>";
$ret = $admi[0];

?>