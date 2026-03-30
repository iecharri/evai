<?php

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

function mostrarocultar($get,$ilink) {
	$get['fecha'] = str_replace("$"," ",$get['fecha']);
	if ($get['mostrar'] == 'si' AND $_SESSION['auto'] == 10) {
		$ilink->query("UPDATE vinchs2 SET oculto = 0 WHERE fecha = '".$get['fecha']."' AND id = '".$get['id']."'
		 AND usu_id = '".$get['usu_id']."'");	
	}

	if ($get['mostrar'] == 'no' AND $_SESSION['auto'] == 10) {
		$ilink->query("UPDATE vinchs2 SET oculto = 1 WHERE fecha = '".$get['fecha']."' AND id = '".$get['id']."'
		 AND usu_id = '".$get['usu_id']."'");	
	}
}

// --------------------------------------------------

function votos_coment($id,$post,$ilink) {

	extract($post);
	
	//Comentario
	if ($comentario) {
		$fecha = gmdate("Y-m-d H:i:s");
		$ilink->query("INSERT INTO vinchs2 (id, usu_id, comentario, fecha) VALUES ('$id', '".$_SESSION['usuid']."', \"".addslashes($comentario)."\", '$fecha')");
		$ilink->query("UPDATE social SET fmodif = '$fecha' WHERE relid = '$id'");
	}

	//Voto
	$temp = "SELECT usu_id FROM vinculos WHERE id = '$id' LIMIT 1";
	$iresult = $ilink->query($temp);
	$temp = $iresult->fetch_array(MYSQLI_BOTH);
	if ($temp[0] == $_SESSION['usuid']) {return 1;}
	$temp = "SELECT vinculo_id FROM votos WHERE vinculo_id = '$id' AND usu_id = '".$_SESSION['usuid']."' AND votos > 0";
	$iresult = $ilink->query($temp);
	$temp = $iresult->fetch_array(MYSQLI_BOTH);
	if ($temp) {return 1;}
	if (!$voto) {return 0;}
	$ilink->query("INSERT INTO votos (votos, usu_id, vinculo_id) VALUES ('$voto', '".$_SESSION['usuid']."', '$id')");
	$iresult = $ilink->query("SELECT COUNT(votos) AS numvotos, AVG(votos) AS votos, STDDEV(votos) AS votos_d FROM votos WHERE vinculo_id = '$id' and votos > 0");
	$fila = $iresult->fetch_array(MYSQLI_BOTH);
	extract($fila);
	$ilink->query("UPDATE vinculos SET numvotos = '$numvotos', nota = '$votos', desvtip = '$votos_d' WHERE id = '$id' LIMIT 1");
	return 1;

}

// --------------------------------------------------

function comentariosdelink($id,$php,$ilink,$div,$votado) {
	
	$script = pathinfo($_SERVER['PHP_SELF'], PATHINFO_FILENAME);
	if($script == "ficha") {$temp='3&op=9';} else {$temp='5';}
	
	if ($_GET['mostrar'] AND $_SESSION['auto'] == 10) {mostrarocultar($_GET,$ilink);}	
	
	$sql = "SELECT * FROM vinchs2 WHERE id ='$id' ORDER BY fecha";
	$result = $ilink->query($sql);

	if ($result->num_rows AND $php AND $php == "comp") {
		$hideonoff = "<span class='icon-eye-blocked'></span> ".i("mostrar1",$ilink)." / ".i("ocultar1",$ilink);
		echo " <a onclick=\"amplred('link".$div."_".$id."')\"><button class='peq'>$hideonoff</button></a><p></p>";
		echo "<div class='both' id='link".$div."_".$id."' style='display:none'>";
	}
	
	while ($fila = $result->fetch_array(MYSQLI_BOTH)) {
		
		extract($fila);
		echo "<p class='both'></p>";
		echo "<div class='colu0'>";
		if ($oculto AND $_SESSION['auto'] < 10) {
			echo "<span class='nob'>".i("comentborr",$ilink)."</span></div>";
			continue;
		}
		
		$fecha = str_replace(" ", "$",$fecha);

		if ($_SESSION['auto'] == 10 AND !$php) {
			$most_ocul = "[<a href='?pest=$temp&id=$id&accion=1&fecha=$fecha&usu_id=$usu_id&";
			if ($oculto) {
				$most_ocul .= "mostrar=si' class='txth b'>".strtoupper(i("mostrar1",$ilink));
			} else {
				$most_ocul .= "mostrar=no' class='rojo b'>".strtoupper(i("ocultar1",$ilink));
			}
			$most_ocul .= "</a>]";
		}
		
		$usu = ponerusu($fila['usu_id'],1,$ilink);
		
		
		?><div class="fila-usuario">
 	 		<div class="foto"><?php
 	 			echo $usu[0];?>	
 			</div>
			<div class="datos"><?php 	
				echo $usu[1];
				echo "<br><div class='peq nob'>".ifecha31($fila['fecha'],$ilink)."</div>";
				echo $most_ocul." ".$fila['comentario'];
				$most_ocul = "";
			echo "</div>";
			if ($php AND $php == "comp") {
				$clickar = 0;
				if ($fila['usu_id'] != $_SESSION['usuid']) {$clickar = 1;}
				mgnmg("vinchs2",$rowid,$ilink,$clickar);
			}
		echo "</div>";
		
	}

	if ($result->num_rows) {
		echo "</div>";
	}
	
	if ($php AND $php == "comp") {return;}

	echo "<p></p><br>";
	
	comentayvota($id,$ilink,$votado);
	
}

function comentayvota($id,$ilink,$votado) {
	echo "<p class='both'><br></p><form method='post' name='form$id'>";	
	echo "<label class='mediana rojo'>".i("comentar",$ilink).":</label><br>";
	echo "<textarea rows='4' cols='90' name='comentario'></textarea><p></p>";
	echo "<input type='hidden' name='comentaid' value='$id'>";
	if (!$votado) {
		echo "<p></p><label class='mediana rojo'>".i("votar",$ilink).":</label><br>";
		echo "1<input type='radio' name='voto' value='1'>";
		echo " 2<input type='radio' name='voto' value='2'>";
		echo " 3<input type='radio' name='voto' value='3'>";
		echo " 4<input type='radio' name='voto' value='4'>";
		echo " 5<input type='radio' name='voto' value='5'>";
		echo " 6<input type='radio' name='voto' value='6'>";
		echo " 7<input type='radio' name='voto' value='7'>";
		echo " 8<input type='radio' name='voto' value='8'>";
		echo " 9<input type='radio' name='voto' value='9'>";
		echo " 10<input type='radio' name='voto' value='10'>";
	}
	echo "<p></p><input type='submit' class='col-2' name='comentar' value='>> ".i("enviar",$ilink)." >>'>";
	echo "</form>";	
}

?>