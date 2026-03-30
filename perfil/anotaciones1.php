<?php

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

if($_SESSION['auto'] < 5) {return;}

$sql = "SELECT * FROM fichaanotaci WHERE deid = '".$_SESSION['usuid']."' ORDER BY date DESC";
$result = $ilink->query($sql);

if(!$result->num_rows) {echo "<p>No has hecho ninguna anotación de los Alumnos. Puedes hacerlo en el apartado Anotaciones de sus fichas.</p>";return;}

echo "<ul>";

while ($fila = $result->fetch_array(MYSQLI_BOTH)) {
	$usu = ponerusu($fila['sobreid'],1,$ilink);	
	echo "<li class='colu2'>$usu[0]$usu[1] <a href='?usuid=".$fila['sobreid']."&op=22&edit=$fila[0]' target='_blank'><span class='icon-pencil2'></span></a> ";
	echo "<span class='peq verdecalific'>".ifecha31($fila['date'],$ilink)."</span> "; //$fila['date'] ya es UTC
	if($fila['fich']) {
		$ext = exten($fila['nombre']);
		echo "<a href='perfil/fichanotaci.php?id=$fila[0]' target='_blank'>";
		echo imag1(".".$ext,$ilink);
		echo "</a> ";
	}
	echo $fila['texto'];
	echo "</li>";
}

echo "</ul>";

// --------------------------------------------------

function exten($fich) {
	$ext = explode(".",$fich);
	$len = sizeof($ext);
	$ext = $ext[$len-1];
	if ($ext == "sh" OR $ext == "php" OR $ext == "phps" OR $ext == "php2" OR $ext == "php3" OR $ext == "php4" OR $ext == "phtml" OR $ext == "asp" OR $ext == "asa"){return 0;} 
	return $ext;
}

?>