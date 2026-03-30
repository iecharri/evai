<?php

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

if ($_GET['borrforo']) {
	delforo($_SESSION['tit'],$_SESSION['curso'],$ilink);
	return;
}

echo "Se van a borrar los mensajes del foro de esta [Titulaci&oacute;n Curso].<br>";
echo "Conf&iacute;rmalo pulsando en <a href='?titul=1&borrforo=1'>ACEPTAR</a>";

// --------------------------------------------------

function delforo($tit,$curso,$ilink) {

	echo "<span class='mediana'>Borrando mensajes...</span><p></p>";

	$sql = "SELECT id FROM foro WHERE titulaci = '$tit' AND curso = '$curso'";
	$result = $ilink->query($sql);
	while ($fila = $result->fetch_array(MYSQLI_BOTH)) {
		$sql1 = "DELETE FROM foro WHERE foro_id = '$fila[0]'";
		$ilink->query($sql1);	
		$sql1 = "DELETE FROM foro WHERE id = '$fila[0]' LIMIT 1";
		$ilink->query($sql1);	
	}	
	
	echo "<span class='grande'>HECHO</span>";

}

?>