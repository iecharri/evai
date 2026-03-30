<?php

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

if ($_POST['verfororec']) {
	$temp = $_POST['verfororec'];
	$ilink->query("UPDATE atencion SET fechaforgen = '$temp'");
	$temp .= " 00:00:00";
	$ilink->query("UPDATE foro SET invisible = 1 WHERE asigna='' AND titulaci='' AND foro_id=0");
	$ilink->query("UPDATE foro SET invisible = 0 WHERE asigna='' AND titulaci='' AND foro_id = 0 AND fecha > '$temp'");
	$sql = "SELECT id, invisible FROM foro WHERE asigna='' AND titulaci='' AND foro_id = 0";
	$result = $ilink->query($sql);
	while ($fila = $result->fetch_array(MYSQLI_BOTH)) {
		extract($fila);
		$ilink->query("UPDATE foro SET invisible = '$invisible' WHERE foro_id = '$fila[0]'"); 		
	}
	$ilink->query("UPDATE recurgen SET invisible = 1 WHERE date <= '$temp' AND titulaci ='' AND asigna = ''");
}

$iresult = $ilink->query("SELECT fechaforgen FROM atencion");
$fecha = $iresult->fetch_array(MYSQLI_BOTH);

echo "<p></p>No mostrar los mensajes en el Foro General y los Recursos Compartidos de fecha anterior a
<form name='frver' action='?' method='post'>";
echo "(yyyy-mm-dd) <input type='text' size='10' maxlength='10' name='verfororec' value='$fecha[0]'>";
echo " <input type='submit' value=' >> '></form><p></p>";

$retfororec = $fecha[0];

?>