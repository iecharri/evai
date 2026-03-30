<?php

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

function bolsaacuest($bolsa,$cuest,$ilink) {
	
	$result = $ilink->query("SELECT MAX(n) FROM $cuest"."1");
	$maxn = $result->fetch_array(MYSQLI_BOTH);
	$maxn = $maxn[0];

	$result = $ilink->query("SELECT * FROM $bolsa"."_ WHERE !n1 ORDER BY orden");

	while ($fila = $result->fetch_array(MYSQLI_BOTH)) {

		$temp = 'a'.$fila['n'];
		
		if ($_POST[$temp]) {
			
			$maxn++;

			$sql = "SELECT * FROM $bolsa"."_ WHERE n='".$fila['n']."' and !n1";
			$result1 = $ilink->query($sql);
			$fila1 = $result1->fetch_array(MYSQLI_BOTH);

			//primero añado la pregunta				
			$imagen = $ilink->real_escape_string($fila1['imagen']);
			$sql = "INSERT INTO $cuest"."1 (n, n1, p, tipo, amin, amax, input, defec, r, respcorr, imagen, tipofich, ancho, youtube, anchoyoutube,orden) VALUES 
					('$maxn', '".$fila1['n1']."', '".$fila1['p']."', '".$fila1['tipo']."', '".$fila1['amin']."', '".$fila1['amax']."', '".$fila1['input']."', 
					'".$fila1['pordefec']."', '".$fila1['r']."', '".$fila1['respcorr']."', \"$imagen\", 
					\"".$fila1['tipofich']."\", '".$fila1['ancho']."', \"".$fila1['youtube']."\", \"".$fila1['anchoyoutube']."\",\"".$fila1['orden']."\")";
			$ilink->query($sql);
	
			//luego los valores de n1		
			$sql = "SELECT * FROM $bolsa"."_ WHERE n='".$fila['n']."' AND n1 ORDER BY orden"; //n1 order by!!
			$result1 = $ilink->query($sql);

			while ($fila1 = $result1->fetch_array(MYSQLI_BOTH)) {
				
				$imagen = $ilink->real_escape_string($fila1['imagen']);
				$sql = "INSERT INTO $cuest"."1 (n, n1, p, tipo, amin, amax, input, defec, r, respcorr, imagen, tipofich, ancho, youtube, anchoyoutube,orden) VALUES 
					('$maxn', '".$fila1['n1']."', '".$fila1['p']."', '".$fila1['tipo']."', '".$fila1['amin']."', '".$fila1['amax']."', '".$fila1['input']."', 
					'".$fila1['pordefec']."', '".$fila1['r']."', '".$fila1['respcorr']."', \"$imagen\", 
					\"".$fila1['tipofich']."\", '".$fila1['ancho']."', \"".$fila1['youtube']."\", \"".$fila1['anchoyoutube']."\",\"".$fila1['orden']."\")";
				$ilink->query($sql);
				
			}	
			
		}
		
	}
	
}

function ordenar($tabla,$ilink) {
	$sql ="SELECT @rownum:=@rownum+1 'row number',n,orden FROM $tabla C , (SELECT @rownum:=0) R WHERE n AND !n1 ORDER BY orden";
	$result = $ilink->query($sql);
	if(!$result->num_rows) {return;}
	while ($fila = $result->fetch_array(MYSQLI_BOTH)) {
		$sql = "UPDATE $tabla SET orden = '$fila[0]' WHERE n='$fila[1]' AND !n1";
		$ilink->query($sql);
	}
}

function respucorr($cuest,$n,$alfabet,$ilink) {
	//echo "<span class='b'>Respuestas correctas:";
		$validas = $ilink->query("SELECT p, n1, respcorr FROM $cuest"."1 WHERE n='$n' AND n1 > 0 ORDER BY orden");
		$temp = "";	$j = 0;
		while ($validas1 = $validas->fetch_array(MYSQLI_BOTH)) {
			if (!$x) {echo "<span class='b'>Respuestas correctas:</span><br>"; $x=1;}
			if ($validas1[2] == 1) {
				if ($alfabet) {echo chr(65+$j).")";}
				echo " ".$validas1[0]."<br>";
				if ($var == $validas1[0]) {
					$temp = 'verdecalific'; if ($alfabet) {$letra = chr(65+$j).") ";}
					$temp1 = 'verdecalific';  // he anadido esto para preguntas con multiples respuestas validas -> ????????
				} elseif ($var) {
					$temp = "rojo";
				}
			} else {
				if ($var == $validas1[0] AND $alfabet) {$letra = chr(65+$j).") ";}
			}
			$j++;
		}
	
	//echo "<br>";
}

function escorr_feed($n,$n1,$cuest,$ilink) {
	$sql = "SELECT p,r,respcorr FROM $cuest"."1 WHERE n='$n' AND n1 = '$n1'";
	$result = $ilink->query($sql);
	$fila = $result->fetch_array(MYSQLI_BOTH);
	return $fila;
}

// --------------------------------------------------

function versilohehecho($cuest,$usuid,$cu,$ilink) {

	if($usuid) {
		$sql = "SELECT cu,nota FROM ".$cuest."2 WHERE usuid = '$usuid'";
	} elseif($cu) {$sql = "SELECT cu,nota FROM ".$cuest."2 WHERE cu = '$cu'";
	} else {return;}
	
	$result = $ilink->query($sql);
	if ($result->num_rows > 0) {
		//ya lo he hecho o existe el $cu
		$fila = $result->fetch_array(MYSQLI_BOTH);
		extract($fila);
		//creo variables POST
		$sql = "SELECT n,n1,tipo,input FROM ".$cuest."1 WHERE n AND !n1";
		$result = $ilink->query($sql);
		while ($fila = $result->fetch_array(MYSQLI_BOTH)) {
			$i = $fila['n'];
			if ($fila['tipo'] == 'N') {$campo = " v1";} 
			if ($fila['tipo'] == 'C') {$campo = " v2";} 
			if ($fila['tipo'] == 'L') {$campo = " v3";} 
			if (!$fila['tipo']) {continue;}
			$sql1 = "SELECT $campo, obs FROM $cuest"."2 WHERE cu='$cu' AND n = '$i'";
			$result1 = $ilink->query($sql1);
			$fila1 = $result1->fetch_array(MYSQLI_BOTH);
			if ($fila['input'] == 'check' OR $fila['input'] == 'persiana') {
				$sql2 = "SELECT n1 FROM $cuest"."1 WHERE n='$i' AND p = '$fila1[0]'";
				$result2 = $ilink->query($sql2);
				$n1 = $result2->fetch_array(MYSQLI_BOTH);
				$fila1[0] = $n1[0];
			}	
			$_POST['v'.$i] = $fila1[0];
			$_POST['obs'.$i] = $fila1[1];
		}
		return "*".$nota;
	}

}

?>