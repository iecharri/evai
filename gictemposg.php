<?php

require_once __DIR__ . "/siempre_base.php";

if ($_SESSION['auto'] < 5 OR $_SESSION['rec5mn']) {
	exit;
}

if (!$_SESSION['demo']) {
	$temp = $_SESSION['asignas']; if(!$_SESSION['asignas']) {$temp="1=1";}
	$sql = "SELECT COUNT(vinculos.id) AS maxi, usu_id, alumnon, alumnoa FROM vinculos LEFT JOIN usuarios ON usuarios.id = vinculos.usu_id WHERE 
	(".$temp.") AND usu_id > 0 AND fechacrea1 > '".$_SESSION['desde']."' GROUP BY usu_id ORDER BY maxi DESC";
	$result = $ilink->query($sql);
	if ($result) {
		$fila1 = $result->fetch_array(MYSQLI_BOTH);		$max = $fila1['maxi'];
		$temp = "";
		$result = $ilink->query($sql);
		while ($fila = $result->fetch_array(MYSQLI_BOTH)) {
			if ($fila['maxi'] != $max) {break;}
			$temp = $temp.$fila['maxi']." ".$fila['alumnon']." ".$fila['alumnoa'].". ";
		}
		if ($max AND sizeof($fila1)) {
			
			$temp = "Los que más vínculos han insertado: $temp";
			echo "<audio src='".MEDIA_URL."/sonidos/DINGDONG.wav' autoplay preload='auto'></audio>";

			if ($_SESSION['idioma'] != 'i') {$lang = "es-ES";} else {$lang = "en-GB";}

			?>

 			<script>
 
				vozlink("<?php echo $temp;?>","<?php echo $lang;?>"); 
 
  			</script>
		
		<?php

	 	}
	}
}

if ($_SESSION['demo']) {
	$sql = "SELECT CONCAT(alumnon,' ',alumnoa) AS nombre FROM vinculos LEFT JOIN usuarios ON usuarios.id = vinculos.usu_id WHERE area != 'GEN' AND usu_id > 0 ORDER BY fechacrea1 DESC LIMIT ".$_SESSION['demo'].",".$_SESSION['listar'];
	$result = $ilink->query($sql);

	if ($result AND $result->num_rows>0) {
		$array = array();
		while ($fila = $result->fetch_array(MYSQLI_BOTH)) {
			$array[] = $fila[0];
		} 
		$array = array_count_values($array);
		arsort($array);
		$max = max($array);
		$temp = "";
		foreach ($array as $clave=>$valor) {
			if ($valor != $max) {break;}
			$temp = $temp.$max." ".$clave.". ";		
		}
		if ($max) {
			$temp = "Los que más vínculos han insertado: $temp";
			echo "<audio src='".MEDIA_URL."/sonidos/DINGDONG.wav' autoplay preload='auto'></audio>";
		
		?>	 
		<script>
		var myLongText = "<?php echo $temp; ?>";
		var utterance = new SpeechSynthesisUtterance(myLongText);
		utterance.lang = 'es-ES';

		speechUtteranceChunker(utterance, {
    		chunkLength: 120
		}, function () {
    		// Acción al terminar (opcional)
		});
		</script>

		<?php
			//echo "<script language='javascript'>OnLoad_temp(\"$temp\");</script>";
		}
	}
}

?>

