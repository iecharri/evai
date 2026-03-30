<?php

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

if ($_GET['borrforo']) {
	delforo($_SESSION['asigna'],$_SESSION['curso'],$_SESSION['grupo'],$ilink);
	return;
}

echo "Se van a borrar los mensajes del foro de esta [Asignatura Curso Grupo].<p></p>";
echo "Conf&iacute;rmalo pulsando en <a href='?borrforo=1'>ACEPTAR</a><p></p>";

// --------------------------------------------------

function delforo($asigna,$curso,$grupo,$ilink) {

	echo "<p></p>Borrando mensajes...</span><p></p>";

	$sql = "SELECT id FROM foro WHERE asigna = '$asigna' AND curso = '$curso' AND grupo = '$grupo'";
	$result = $ilink->query($sql);
	while ($fila = $result->fetch_array(MYSQLI_BOTH)) {
		$sql1 = "DELETE FROM foro WHERE foro_id = '$fila[0]'";
		$ilink->query($sql1);	
		$sql1 = "DELETE FROM foro WHERE id = '$fila[0]' LIMIT 1";
		$ilink->query($sql1);	
	}	
	
	echo "<p></p>HECHO<p></p>";

}

?>