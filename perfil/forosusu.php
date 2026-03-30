<?php

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

if (!$pest) {return;}

$sql = "SELECT * FROM foro WHERE usu_id = '$usuid'";
if ($_SESSION['auto'] < 10) {$sql .= " AND !invisible";}
$sql .= " ORDER BY fecha DESC";

$result = $ilink->query($sql);

while ($fila = $result->fetch_array(MYSQLI_BOTH)) {

	if ($fila['foro_id']) {
		$fila1 = "SELECT titulaci, asigna, curso, grupo FROM foro WHERE id = '".$fila['foro_id']."' LIMIT 1";
		$iresult = $ilink->query($fila1);		
		$fila1 = $iresult->fetch_array(MYSQLI_BOTH);
		
	}	

	$fila['titulaci'] = $fila1['titulaci'];
	$fila['asigna'] = $fila1['asigna'];
	$fila['curso'] = $fila1['curso'];
	$fila['grupo'] = $fila1['grupo'];
	$filaid = $fila['id'];
	$temp = "[";
	if ($fila['titulaci']) {$temp .= $fila['titulaci'];} elseif ($fila['asigna']) {$temp .= $fila['asigna'];}  else {$temp .= "General";}
	if ($fila['curso']) {$temp .= " - ".$fila['curso'];} // AND $fila['curso'] != "*"
	if ($fila['grupo']) {$temp .= " - ".$fila['grupo'];} // AND $fila['grupo'] != "*"
	$temp .= "]";

	if (!esmio($fila['asigna'],$fila['curso'],$fila['grupo'],$ilink) AND ($fila['asigna'] OR $fila['titulaci']) AND !esmiotitul($fila['titulaci'],$fila['curso'],$ilink)) {
		echo "<div class='colu'><span class='nob u'>".ifecha31($fila['fecha'],$ilink)." $temp</span></div>";
		continue;
	}

	if ($fila['asunto']) {
		$asunto = "<span class='mediana b'>".conhiper(consmy(quitabarra($fila['asunto'])))."</span>";
		$id = $fila['id'];
	} else {
		$iresult = $ilink->query("SELECT asunto, id FROM foro WHERE id = '".$fila['foro_id']."' LIMIT 1");
		$asunto = $iresult->fetch_array(MYSQLI_BOTH);
		$id = $asunto[1];
		$asunto = $asunto[0];
	}
	echo "<div class='colu'><span class='peq'>".ifecha31($fila['fecha'],$ilink)."</span> $temp <a href=\"foros.php?id=$id\">$asunto</a>";
	echo "<div id='1div$filaid' class='interli'><pre>".conhiper(consmy(quitabarra($fila['comentario'])))."</pre></div>";

	votos($fila['id'],$fila['voto'],$fila['usu_id'],$ilink,'','');	
	
	echo "</div><p></p>"; //style='display:none' 

}
function quitabarra($x) {return stripslashes($x);}

?>