<?php

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

if ($_SESSION['auto'] < 5) {return;}

$sql = "SELECT fichavaloracion.fecha, fichavaloracion.video, ficha, usuarios.id FROM fichavaloracion LEFT JOIN usuarios ON usuarios.id = fichavaloracion.deusuid WHERE usuid = '".$_GET['usuid']."'";
$result = $ilink->query($sql);

echo "<table>";

echo "<tr><th>Fecha</th><th>Ficha</th><th>V&iacute;deo</th><th></th></tr>";
while ($fila = $result->fetch_array(MYSQLI_BOTH)) {

	echo "<tr><td>".fechaen($fila['fecha'],$ilink)."</td><td style='text-align:center'>";
	if ($fila['ficha']) {echo $fila['ficha'];}
	echo "</td><td style='text-align:center'>";
	if ($fila['video']) {echo $fila['video'];}
	echo "</td><td>";
	$usua = ponerusu($fila['id'],1,$ilink);
	echo $usua[0];
	echo $usua[1];
	echo "</td></tr>";

}
echo "</table>";

?>