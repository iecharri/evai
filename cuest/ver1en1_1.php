<?php

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

$iresult = $ilink->query("SELECT usuid, nota, t_ini, datetime FROM ".$cuest."2 WHERE cu = '$cu'");
$fila = $iresult->fetch_array(MYSQLI_BOTH);

iconex(DB1,$ilink);

$nombre = "SELECT alumnoa, alumnon FROM usuarios WHERE id = '$fila[0]' LIMIT 1";
$iresult = $ilink->query($nombre);
$nombre = $iresult->fetch_array(MYSQLI_BOTH);
if ($nombre) {$nombre = $nombre['alumnoa'].", ".$nombre['alumnon']." &nbsp; &nbsp; ";}

echo "<div class='azul fr'>";

echo $nombre;

iconex(DB2,$ilink);


if($fila1['guardar'] == 1) {

	echo "<span class='b'>Inicio</span>: ".utcausu1($fila['t_ini'])." <span class='b'>Fin</span>: ";
	if (!$fila['datetime'] OR $fila['datetime'] == '0000-00-00 00:00:00' OR $fila['datetime'] == $fila['t_ini']) {
		echo "<span class='rojo b'>NO TERMINADO</span>";
	} else {
		echo utcausu1($fila['datetime']);
		$dteStart = new DateTime($fila['t_ini']); 
   	$dteEnd   = new DateTime($fila['datetime']); 
		$dteDiff  = $dteStart->diff($dteEnd); 
		echo " &nbsp; [<span class='b verdecalific'>".$dteDiff->format("%H:%I:%S")."</span>]"; 
	}
	
} else {
	
	echo "<span class='b'>Fecha</span>: ".utcausu1($fila['datetime']);
	
}

if($formula AND $guardar == 1) {
	echo " &nbsp; &nbsp; &nbsp; &nbsp; Nota: ";
	echo "<span class='mediana b'>".$fila['nota']."</span>";
}
echo "</div><div class='both'></div>";

// --------------------------------------------------

?>