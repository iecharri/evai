<?php

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

iconex(DB2,$ilink);

$result = $ilink->query("SELECT mn, visible, visialuresp, formula, ordenadas, alfabet, sinnum, guardar FROM ".$cuest."1 WHERE !n");
$fila = $result->fetch_array(MYSQLI_BOTH);
extract($fila);

if(!$sinnum) {$numera = 1;}

//para recuperar los POST desde cuest
versilohehecho($cuest,'',$cu,$ilink);

$result = $ilink->query("SELECT * FROM ".$cuest."1 WHERE n AND !n1 ORDER BY orden");echo "SELECT * FROM ".$cuest."1 WHERE n AND !n1 ORDER BY orden";

while ($fila = $result->fetch_array(MYSQLI_BOTH)) {
		
	include APP_DIR . "/cuest/cu_1preg.php";
		
	if(!$fila['input']) {continue;}

	$color = $letra = $escorr_feed = "";

	$n = $fila['n'];
	$post = $_POST['v'.$n];

	echo "<div class='colu2 contiene'>";

	//ver si es correcta y tiene feedback
		
	if ($fila['input'] != 'check' AND $fila['input'] != 'persiana') {
		
		$texto = $post;

	} else {		

		if($visialuresp) {
			respucorr($cuest,$n,$alfabet,$ilink);
		}		
		
		//devuelve p,r,respcorr 
		if($post) {
			$ord = "SELECT orden FROM $cuest"."1 WHERE n='$n' AND n1 = '$post'";
			$ord = $ilink->query($ord);
			$ord = $ord->fetch_array(MYSQLI_BOTH);
			$escorr_feed = escorr_feed($n,$post,$cuest,$ilink);
			//devuelve p,r,respcorr
			if($alfabet) {$letra = chr(64+$ord[0]).")";}
			$texto = $escorr_feed[0];
			$color = "rojo";
			if($escorr_feed[2]) {$color = "verdecalific";}
		}
		
	}

	if ($escorr_feed[1]) {echo "<span class='b'>".$escorr_feed[1]."</span><br>";}	
				
	echo "<span class='b'>Tu respuesta:</span>";
		
	if($post) {echo "<br><span class='$color'>$letra $texto</span>";}
		
	if ($color AND $guardar != 2) {
		echo "<div class='b fr $color' style='float:right'>";
		if ($color == "verdecalific") {
			echo "<span class='$color icon-checkmark'> OK</span>";
		} else {
			echo "<span class='$color icon-checkmark'> ERR</span>";
		}
		echo "</div>";
	}
	
// --------------------------------------------------

	if($guardar == 1) {
	
		if ($_POST["obs1_cu$cu"."_i$n"] AND $_SESSION['auto'] > 4) {
			$ilink->query("UPDATE $cuest"."2 SET obs=\"".$_POST["obs_cu$cu"."_i$n"]."\" WHERE cu='$cu' AND n='$n'");
			$_POST['obs'.$i] = $_POST["obs_cu$cu"."_i$n"];
		}
	
		if ($_POST['obs'.$i]) {
			echo "<br><span class='b'>Observaciones</span>: ".$_POST['obs'.$n];
		}

		if(!$impr) {	
			anotaciones($n,$cuest,$cu,$opc,$ilink);	
		}

	}
		
	echo "</div>";
		
}

?>	