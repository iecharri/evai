<?php

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

$usuid = $_GET['usuid'];

$sql = "SELECT *,CHAR_LENGTH(comentario) AS chars FROM foro WHERE usu_id = '$usuid'";
if ($_SESSION['auto'] < 10) {$sql .= " AND !invisible";}
$sql .= " ORDER BY fecha DESC";

$result = $ilink->query($sql);

if(!$imprimir) {$sinoimpr = " style='height:25em;overflow:auto'";}

$ret[0] = 0;
$ret[1] = 0;

$puestonombre = "";

while ($fila = $result->fetch_array(MYSQLI_BOTH)) {

	if ($fila['foro_id']) {
		$sql1 = "SELECT titulaci, asigna, curso, grupo FROM foro WHERE id = '".$fila['foro_id']."' LIMIT 1";
		$result1 = $ilink->query($sql1);
		$fila1 = $result1->fetch_array(MYSQLI_BOTH);
		$fila['titulaci'] = $fila1['titulaci'];
		$fila['asigna'] = $fila1['asigna'];
		$fila['curso'] = $fila1['curso'];
		$fila['grupo'] = $fila1['grupo'];
	}	
	
	if ($fila['titulaci']) {
		continue;
	}	
	
	if ($fila['asigna'] AND $fila['asigna'] != $_SESSION['asigna']) {
		continue;
	}	

	if ($fila['curso'] AND $fila['curso'] != $_SESSION['curso']) {
		continue;
	}	
	
	if ($fila['grupo'] AND $fila['grupo'] != $_SESSION['grupo']) {
		continue;
	}	

	if (!$fila['titulaci'] AND !$fila['asigna']) {
		continue;
	}

	if(!$puestonombre) {
		//if(!$imprimir) {echo "T&iacute;tulo del Hilo en letra m&aacute;s grande cuando &eacute;l lo inicia<p></p>";}
		$usu = ponerusu($usuid,1,$ilink);
		echo $usu[0].$usu[1];
		$puestonombre = "*";
		echo "<div $sinoimpr>";
	}
	
	$filaid = $fila['id'];
	$temp = "[";
	if ($fila['titulaci']) {
		$temp .= $fila['titulaci'];
	} elseif ($fila['asigna']) {
		$temp .= $fila['asigna'];
	}
	
	if ($fila['curso']) {$temp .= " - ".$fila['curso'];} // AND $fila['curso'] != "*"
	if ($fila['grupo']) {$temp .= " - ".$fila['grupo'];} // AND $fila['grupo'] != "*"
	$temp .= "]";

	if ($fila['asunto']) {
		$asunto = "<span class='mediana b'>".conhiper(consmy(quitabarra($fila['asunto'])))."</span>";
		$id = $fila['id'];
	} else {
		$result2 = $ilink->query("SELECT asunto, id FROM foro WHERE id = '".$fila['foro_id']."' LIMIT 1");
		$asunto = $result2->fetch_array(MYSQLI_BOTH);
		$id = $asunto[1];
		$asunto = $asunto[0];
	}
	
	$ret[0]++;
	$ret[1] = $ret[1] + $fila['chars'];
	echo "<p></p><div class='colu'><span class='peq'>".ifecha31($fila['fecha'],$ilink)."</span> $temp ";
	
	echo "<br><span style='border:1px solid;padding:0 3px' class='b'>".$fila['foros_id']."</span> ";
				if ($fila['contest_a']) {echo " REF. <span style='border:1px solid;padding:0 3px' class='b'>".$fila['contest_a']."</span> ";}		
	
	echo "<a href=\"../foros.php?id=$id\">$asunto</a>";
	if (strlen($fila['comentario']) > 100 AND !$imprimir) {echo " <a onclick=\"amplred('1div$filaid');amplred('div$filaid')\" class='txth b'>[Ampliar/reducir]</a>";}
	echo "<div id='div$filaid' class='justify'>";
	$letras = 100;
	if($imprimir) {$letras = 9999999999;}
	echo conhiper(consmy(quitabarra(mb_substr($fila['comentario'],0,$letras,'UTF-8'))));
	if(!$imprimir) {
		if (strlen($fila['comentario']) > 100) {echo "...";}
	}
	echo "</div>";
	echo "<div id='1div$filaid' style='display:none' class='interli'>".conhiper(consmy(quitabarra($fila['comentario'])))."</div>";

	votos($fila['id'],$fila['voto'],$fila['usu_id'],$ilink,'','*');	

	echo "</div><p></p>";

}

if($puestonombre) {
	echo "</div>";
	echo "<div class='saltopagina'></div>";
}
	

?>