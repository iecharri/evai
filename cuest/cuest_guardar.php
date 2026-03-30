<?php

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

iconex(DB2,$ilink);

if ($controla AND !$previsu) { //$envi
	guardarc($cuest,$ilink);
}

$result = $ilink->query("SELECT mn, visible, visialuresp, formula, ordenadas, alfabet, sinnum FROM ".$cuest."1 WHERE !n");
$fila = $result->fetch_array(MYSQLI_BOTH);
extract($fila);

if(!$sinnum) {$numera = 1;}

echo  "<span class='mediana'>Cuestionario $cuest evaluable. S&oacute;lo se permite contestar una vez.</span>";

// Se intenta realizar el cuestionario, pero no est&aacute; activo y no se ha respondido anteriormente

if ($visialuresp AND !$previsu) {
	$sql = "SELECT * FROM ".$cuest."2 WHERE usuid = '".$_SESSION['usuid']."'";
	$result = $ilink->query($sql);
	$num = $result->num_rows;
	if (!$num) {
		echo "<p></p><div class='mediana b'>Cuestionario no respondido. Cuestionario no activo.</div>";
		return;
	}
}

?>

        <script src="http://code.jquery.com/jquery-1.11.2.min.js"></script>

<?php

if($previsu AND $controla) { //$envi
	$yalohehecho = 1;	
} elseif(!$previsu) {
	$yalohehecho = versilohehecho($cuest,$_SESSION['usuid'],'',$ilink);
}

if(!$controla AND !$yalohehecho) { //$envi
	$ponerform = 1;
}

// --------------------------------------------------

if(!$yalohehecho AND !$iniciar) {

	//no lo he hecho y no he pulsado iniciar
	echo "<p></p><div class='mediana'>";
	if($mn) {
		echo "&iexcl;ATENCI&Oacute;N! Se dispone de $mn minutos para realizar el cuestionario. ";
		$fra = "y empezar&aacute; a contar el tiempo";
	}
	echo "Ser&aacute; mostrado $fra cuando se pulse<p></p>";
	echo "<a href='?opc=$opc&cuest=$cuest&iniciar=1' class='txth b'>ACEPTAR</a>";
	echo "<p></p>Una vez pulsado, no recargues la página ni desconectes de Internet, no se podrá repetir el Cuestionario.";
	echo "</div>";
	//aviso de que comenzara al pulsar iniciar
	return;
	
}

if ($iniciar AND !$previsu) {
	
	$yaini = preguardar($cuest,$ilink);
	if($yaini) {$yalohehecho = 1;}
	
}

if ($yalohehecho) {

	if($yaini) {	
		echo "<p></p><span class='rojo b mediana'>Has pulsado ACEPTAR para iniciar el Cuestionario con anterioridad y ha quedado registrado.</span>";
	} else {
		echo "<p></p><span class='rojo b mediana'>Has contestado a este Cuestionario.</span>";
	}
	$nota = substr($yalohehecho,1);
	if ($nota AND $visialuresp) {		
		echo " &nbsp; &nbsp; &nbsp; &nbsp; Nota: ";
		echo "<span class='mediana b'>".$nota."</span>";
	} else {
		echo "<p></p>";
	}
		
}

// --------------------------------------------------

if($ponerform) {
	
	if ($mn) {
		//cronometro($mn);
		require_once APP_DIR . '/cuest/cronometro.php';
	}
	
	echo "<form name='form1' id='form1' method='post' action='?opc=$opc&cuest=$cuest'>";
	echo "<input type='hidden' name='tini' value='".gmdate("Y-m-d H:i:s")."'>";
	echo "<input type='hidden' name='iniciar' value=''>";
	echo "<p class='rojo'>No recargues la página ni desconectes de Internet, no se podrá repetir el Cuestionario.</p>";

}

// --------------------------------------------------

$result = $ilink->query("SELECT * FROM ".$cuest."1 WHERE n AND !n1 ORDER BY orden");

while ($fila = $result->fetch_array(MYSQLI_BOTH)) {
		
	include APP_DIR . '/cuest/cu_1preg.php'; //es ok el include
		
	if(!$fila['input'] OR $ponerform) {continue;}
		
	$color = $letra = $escorr_feed = "";

	$n = $fila['n'];
	$post = $_POST['v'.$n];
	
	echo "<div class='colu2 contiene'>";

	//ver si es correcta y tiene feedbak
		
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
			if($visialuresp) {
				$color = "rojo";
				if($escorr_feed[2]) {$color = "verdecalific";}
			}

		}
		
	}

	if ($escorr_feed[1] AND $visialuresp) {echo "<span class='b'>".$escorr_feed[1]."</span><br>";}	
				
	echo "<span class='b'>Tu respuesta:</span>";
		
	if($post) {echo "<br><span class='$color'>$letra $texto</span>";}
		
	if ($color) {
		echo "<div class='b fr $color' style='float:right'>";
		if ($color == "verdecalific") {
			echo "<span class='$color icon-checkmark'> OK</span>";
		} else {
			echo "<span class='$color icon-checkmark'> ERR</span>";
		}
		echo "</div>";
	}
	
	if ($_POST['obs'.$n] AND $visialuresp) {
		echo "<br><span class='b'>Observaciones</span>: ".$_POST['obs'.$n];
	}
	
	echo "</div>";
		
}

// --------------------------------------------------

if($ponerform) {
	echo "<input type='hidden' name='cuest' value='$cuest'>";
	echo "<input type='hidden' name='controla' value='1'>"; //al auto-enviarse no se registraba la variable -envi-
	echo "<input class='col-10' type='submit' name = 'envi' value='>> Enviar >>'>";
	echo "</form>";	
}

// --------------------------------------------------

function preguardar($cuest,$ilink) {

	$sql = "SELECT usuid FROM ".$cuest."2 WHERE usuid = '".$_SESSION['usuid']."'";
	$temp = $ilink->query($sql);
	if($temp->num_rows) {
		return 1;
	}	
	
	$sql = "SELECT max(cu) FROM ".$cuest."2";
	$temp = $ilink->query($sql);
	if($temp->num_rows) {
		$fila = $temp->fetch_array(MYSQLI_BOTH);
	}
	$cu = $fila[0] + 1;

	$ip = filter_var($_SERVER['REMOTE_ADDR'], FILTER_VALIDATE_IP) ?: '0.0.0.0';
	$tini = gmdate("Y-m-d H:i:s");
	$sql = "INSERT INTO ".$cuest."2 (t_ini, cu, u, usuid) VALUES ('$tini','$cu','$ip','".$_SESSION['usuid']."')";
	$ilink->query($sql);
	
}

// --------------------------------------------------

function guardarc($cuest,$ilink) {

	if (!$_SESSION['usuid']) {return;} //por si se hubiera perdido sesi&oacute;n. Se va a borrar 1 registro.

	$result = $ilink->query("SELECT t_ini, cu, u FROM $cuest"."2 WHERE usuid = '".$_SESSION['usuid']."'");
	
	if(!$result->num_rows) {return;}
	
	$temp = $result->fetch_array(MYSQLI_BOTH);
	extract($temp);
	$ilink->query("DELETE FROM $cuest"."2 WHERE usuid = '".$_SESSION['usuid']."'");
	
	$tfin = gmdate("Y-m-d H:i:s");

	$result = $ilink->query("SELECT * FROM ".$cuest."1 WHERE n AND !n1 ORDER BY n");

	while ($fila = $result->fetch_array(MYSQLI_BOTH)) {

		$i = $fila['n'];
		$var = $_POST['v'.$i];

		if ($var AND ($fila['input'] == 'check' OR $fila['input'] == 'persiana')) {
			$result1 = $ilink->query("SELECT p FROM ".$cuest."1 WHERE n='$i' AND n1='$var'");
			$fila1 = $result1->fetch_array(MYSQLI_BOTH);			$var = $fila1[0];
		}

		$sql = "INSERT INTO ".$cuest."2 (t_ini, cu, u, n, ";
		if (!$fila['input']) {
			$sql = $sql." v2,"; $var="separador";
		} else {
			if ($fila['tipo'] == 'N') {$sql = $sql." v1,";} 
			if ($fila['tipo'] == 'C') {$sql = $sql." v2,";}
			if ($fila['tipo'] == 'L') {$sql = $sql." v3,";}
		}

		$sql = $sql." usuid, datetime) VALUES ('$t_ini', '$cu', '$u', '$i', '$var', '".$_SESSION['usuid']."', '$tfin')";
		$ilink->query($sql);
			
	}
		
}
	
?>	