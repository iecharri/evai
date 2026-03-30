<?php

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

iconex(DB2,$ilink);

$result = $ilink->query("SELECT ordenadas, alfabet, sinnum FROM ".$cuest."1 WHERE !n");
$fila = $result->fetch_array(MYSQLI_BOTH);
extract($fila);

if(!$sinnum) {$numera = 1;}
	
// --------------------------------------------------

if(!$envi) {
	echo "<form name='form1' id='form1' method='post'>";
	$ponerform = 1;
}

// --------------------------------------------------

$result = $ilink->query("SELECT * FROM ".$cuest."1 WHERE n AND !n1 ORDER BY orden");

while ($fila = $result->fetch_array(MYSQLI_BOTH)) {
	
	include APP_DIR . "/cuest/cu_1preg.php"; //es ok el include
		
	if(!$fila['input'] OR !$envi) {continue;}
		
	$color=$letra=$escorr_feed="";

	$n = $fila['n'];
	$post = $_POST['v'.$n];

	echo "<div class='colu2 contiene'>";

	if ($fila['input'] != 'check' AND $fila['input'] != 'persiana') {
		
		$texto = $post;

	} else {		
		
		//devuelve p,r,respcorr 
		if($post) {
			$escorr_feed = escorr_feed($n,$post,$cuest,$ilink);
			//devuelve p,r,respcorr
			if($alfabet) {$letra = chr(64+$post).")";}
			$texto = $escorr_feed[0];
			$color = "rojo";
			if($escorr_feed[2]) {$color = "verdecalific";}

		}
		
	}

	echo "<span class='b'>Tu respuesta:</span>";
		
	if($post) {echo "<br><span class='$color'>$letra $texto</span>";}
	echo "</div>";
		
}

// --------------------------------------------------

if(!$envi) {
	echo "<input type='hidden' name='cuest' value='$cuest'>";
	echo "<input class='col-10' type='submit' name = 'envi' value='>> Enviar >>'>";
	echo "</form>";	
}
	
?>	