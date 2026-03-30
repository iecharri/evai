<?php

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

?>

<h3 class='center'><?php echo i("asignas",$ilink);?></h3>

<?php

$iresult = $ilink->query("SELECT titulacion FROM podtitulacion WHERE cod = '".$_SESSION['tit']."'");
$tit = $iresult->fetch_array(MYSQLI_BOTH);

if ($_SESSION['curso']) {
	echo i("curso",$ilink)." ".$_SESSION['curso'].". ";
}
echo $tit[0]."<p></p>";

$flecha = "<span class='icon-arrow-right2'></span>";

$sql = "SELECT DISTINCT asignatprof.asigna, asignatura, grupo FROM podcursoasignatit 
	LEFT JOIN podasignaturas ON podcursoasignatit.asigna = podasignaturas.cod 
	LEFT JOIN asignatprof ON podcursoasignatit.curso = asignatprof.curso AND podcursoasignatit.asigna = asignatprof.asigna
	WHERE asignatprof.curso = '$curso' AND tit = '".$_SESSION['tit']."' ORDER BY asigna, grupo";
$result = $ilink->query($sql);

while ($fila = $result->fetch_array(MYSQLI_BOTH)) {
	//Si $fila0/$curso/$fila2 es m&iacute;a y no est&aacute; inactiva, que sea pinchable
	$iresult = $ilink->query("SELECT visibleporalumnos FROM cursasigru WHERE asigna='$fila[0]' AND curso='$curso' AND grupo='$fila[2]'");
	$visi = $iresult->fetch_array(MYSQLI_BOTH);
	echo "$flecha ";
	if (esmio($fila[0],$curso,$fila[2],$ilink) AND ($visi[0] OR esprofesor($fila[0],$curso,$fila[2],$ilink))) {
		echo "<a class='peq b' href='home.php?filtroasign=$fila[0]&curso=$curso&grupo=$fila[2]&y=1'>".$fila[0]." ".$fila[1]." ".$fila[2]."</a>";
	} else {
		echo "<span class='peq'>".$fila[0]." ".$fila[1]." ".$fila[2]."</span>";
	}
	echo "<p></p>";
}