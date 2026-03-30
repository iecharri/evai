<?php

require_once __DIR__ . '/siempre_base.php';

if ($_SESSION['auto'] < 5 ) {
	exit;
}

$sg = $_SESSION['sg'];

if ($_SESSION['demo']) {
	$sql1 = "SELECT vinculos.id FROM vinculos WHERE area != 'GEN' AND usu_id > 0 ";
} else {
	$temp = $_SESSION['asignas']; if(!$_SESSION['asignas']) {$temp="1=1";}
	$sql1 = "SELECT vinculos.id FROM vinculos WHERE (".$temp.") AND usu_id > 0 AND fechacrea1 > '".$_SESSION['desde']."' ";
}

if ($_SESSION['leer'] > 0) {

	if($_SESSION['demo']) {

		$n = $_SESSION['demo'];
		$sql = $sql1."ORDER BY vinculos.fechacrea DESC LIMIT $n,".$_SESSION['leer'];

	} else {
		$sql = $sql1."ORDER BY vinculos.fechacrea DESC LIMIT 0,".$_SESSION['leer'];

	}

	$result = $ilink->query($sql);
	
	$poner = "";

	while ($fila = $result->fetch_array(MYSQLI_BOTH)) {
	
		$id = $fila['id'];
		
		$iresult = $ilink->query("SELECT vinculos.titulo, CONCAT(usuarios.alumnon,' ',usuarios.alumnoa) AS nombre, grupos.grupo, grupos.eslogan, vinculos.idioma FROM vinculos LEFT JOIN usuarios ON usuarios.id = vinculos.usu_id LEFT JOIN gruposusu ON gruposusu.usu_id = vinculos.usu_id LEFT JOIN grupos ON grupos.id = gruposusu.grupo_id WHERE vinculos.id = '$id' LIMIT 1");
		$fila1 = $iresult->fetch_array(MYSQLI_BOTH);

		$poner .= $fila1['nombre'];

		if ($fila1['grupo']) {
			$poner .= ", ".str_replace("<grupo>", $fila1['grupo'], i1("delgrupo",$fila1['idioma'],$ilink));
			if ($fila1['eslogan']) {
				$poner .= ", ".nl2br(str_replace("\""," ", $fila1['eslogan']));
			}
		}
		$poner .= ": ".$fila1['titulo'].". ";

	}

	if ($poner) {
		$poner = i1("nuevosvinc",$fila1['idioma'],$ilink)." ".str_replace("\""," ",$poner);
	} else {
		return;
	}

	//$wav = crearwav($poner, $n);
	//echo "<audio src='tmp/$wav' autoplay preload='auto' autobuffer></audio>";
	//utterance.voice = voiceArr[2]; en script siguiente

	if ($fila1['idioma'] != 'i') {$lang = "es-ES";} else {$lang = "en-GB";}

	?>

 	<script>
 
		vozlink("<?php echo $poner;?>","<?php echo $lang;?>"); 
 
  	</script>

 <?php

}

if (!$_SESSION['listar']) {$_SESSION['listar'] = 0;}

if($_SESSION['demo']) {

	$n = $_SESSION['demo'];
	$sql = $sql1."ORDER BY vinculos.fechacrea DESC LIMIT $n,".$_SESSION['listar'];

} else {

	$sql = $sql1."ORDER BY vinculos.fechacrea DESC LIMIT 0,".$_SESSION['listar'];

}

$result = $ilink->query($sql);

if ($_SESSION['leer'] > 0) {
	echo "<audio src='".MEDIA_URL."/sonidos/vinc.wav' autoplay preload='auto' autobuffer></audio>";
}
echo "<table class='conhover'>";

$a1 = i("area",$ilink);
$c1 = i("claves",$ilink);
$t1 = i("titulo",$ilink);
$r1 = i("resumen",$ilink);
$i1 = i("insmodif",$ilink);

echo "<tr><th>$a1</th><th></th><th>$c1</th><th>$t1 / $r1</th><th>$i1</th></tr>\n";

if ($result->num_rows) {

	while ($fila = $result->fetch_array(MYSQLI_BOTH)) {

		$id = $fila['id'];

		$iresult = $ilink->query("SELECT area, titulo, usu_id, claves, url, resumen, amplia, fechacrea, fecha FROM vinculos WHERE vinculos.id = '$id' LIMIT 1");
		$fila1 = $iresult->fetch_array(MYSQLI_BOTH);

		echo "<tr>";

		echo "<td class='center'>".$fila1['area']."</td>";
		$usua = ponerusu($fila1['usu_id'],1,$ilink);
		echo "<td class='nowrap'>";
		echo $usua[0]."<br>";
		echo $usua[1];
		echo "</td><td>".$fila1['claves']."</td>";

		echo "<td>";
		echo "<a href=http://".$fila1['url']." class='b' target='_blank'>".$fila1['titulo']."</a>: ".$fila1['resumen'];
		echo "</td>";
	
		echo "<td>".fechaen($fila1['fechacrea'],$ilink),"<br>".fechaen($fila1['fecha'],$ilink)."</td></tr>\n";

	}

}

echo "</table><p></p>";

// --------------------------------------------------

function crearwav($txt, $n) {
	//Creo fichero txt usu-txt-n
	$fich = "u".$_SESSION['usuid']."_".$n;
	$ar=safe_fopen("tmp/$fich.txt","w+");
	fputs($ar,$txt);
	fclose($ar);
	//Creo wav
	$ejecutar = trim($_SESSION['espeak'])." -f tmp/$fich.txt -w tmp/$fich.wav";
	system($ejecutar);
	return $fich.".wav";	
}

?>
