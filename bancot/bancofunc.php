<?php

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

function cambios($ilink) {
	extract($_GET);
	extract($_POST);
// --------------------------------------------------
	if ($desact) {
		$ilink->query("UPDATE bancot1 SET activo = '' WHERE bancoid = '$bancot'");
	}
// --------------------------------------------------
	if ($act) {
		$ilink->query("UPDATE bancot1 SET activo = '1' WHERE bancoid = '$bancot'");
	}
// --------------------------------------------------
	if ($rec) {
		$ilink->query("UPDATE bancot2 SET aceptado = '".gmdate('Y-m-d')."' WHERE bancoid = '$bancot' AND usurecibe = '$rec'");
		$message = "Este es un mensaje autom&aacute;tico. Ha sido aceptada una solicitud de tiempo en el <a target='ficha' href='ficha.php?op=20'>".i("bancot",$ilink)."</a>";
		porhsm($message, $rec,"",$ilink);
	}
// --------------------------------------------------
	if ($puntuar > 0 AND $puntuar < 11) {
		$ilink->query("UPDATE bancot2 SET satisfac = '$puntuar' WHERE bancoid = '$xbancoid' AND usurecibe = '$xusurecibe' AND satisfac='' LIMIT 1");
	}
// --------------------------------------------------
	if ($_POST['pidot'] AND $_POST['pidot'] != "00:00:00") {
		$iresult = $ilink->query("SELECT tiempo, usuid FROM bancot1 WHERE bancoid = '$pidoid'");
		$ttot = $iresult->fetch_array(MYSQLI_BOTH);
		$datos = completado($fila['bancoid'],$ttot[0],$ilink);
		$usado[0] = $datos[0];
		$diff[0] = $datos[1];		
		$media[0] = $datos[2];
		if ($diff[0] >= '00:00:00') {
			$ilink->query("INSERT INTO bancot2 (bancoid, usurecibe, fecha, tiempo) VALUES
			 ('$pidoid', '".$_SESSION['usuid']."', '".gmdate('Y-m-d')."', '".$_POST['pidot']."')");
			 $message = "Este es un mensaje autom&aacute;tico. Nueva solicitud de tiempo en el <a target='ficha' href='ficha.php?op=20'>".i("bancot",$ilink)."</a>";
			 porhsm($message, $ttot[1],"",$ilink);
		}
	}
// --------------------------------------------------
	if ($addbanco2) {
		$ilink->query("INSERT INTO bancot1 (usuid, competencia, tiempo, fecha)
		VALUES ('".$_SESSION['usuid']."', \"$addbanco2\", '".$addbanco1.":00', '".gmdate('Y-m-d')."')");
	}
// --------------------------------------------------
	if ($changet2) {
		$ilink->query("UPDATE bancot1 SET tiempo = '$changet1' WHERE bancoid='$bancoid'");
	}
}

// --------------------------------------------------

function cabecera($busca) {
	echo "<table class='conhover'>";
	echo "<tr><th class='wid35'>Oferta</th>";
	echo "<th>";
	if ($busca) {
		echo "Tiempo";
	} else {
		echo "Utilizado por...";
	}
	echo "</th>";
	echo "<th class='col-01 nowrap'>n&deg; votos / valoraci&oacute;n</th>";
	echo "</tr>";
}

// --------------------------------------------------

function pie() {
	echo "</table>";
}

// --------------------------------------------------

function competencia($fila,$busca,$param,$ilink) {
	$datos = completado($fila['bancoid'],$fila['tiempo'],$ilink);
	$usado[0] = $datos[0];
	$diff[0] = $datos[1];	
	$media[0] = $datos[2];
	$num = $datos[3];
	echo "<tr>";
	echo "<td><span class='mediana b'>".$fila['competencia']."</span>";
	if ($busca) {
		echo "<br>";
		$usu = ponerusu($fila['usuid'],1,$ilink);
		echo $usu[0].$usu[1];
	}
	echo "<br>";	
	if (!$busca) {
		echo "La oferta est&aacute; <span class='b'>";
		if ($fila['activo']) {echo "<span class='txth b'>Activa</span>";} else {echo "<span class='rojo b'>Inactiva</span>";}
		echo "</span>. ";
	}
	if ($ver OR esprofdeid($fila['usuid'],$ilink) OR $fila['usuid'] == $_SESSION['usuid']) {
		if ($fila['activo']) {
			echo "[<a class='rojo b' href='?$param&bancot=".$fila['bancoid']."&desact=1'>Desactivar oferta</a>]";
		} else {
			echo "[<a class='txth b' href='?$param&bancot=".$fila['bancoid']."&act=1'>Activar oferta</a>]";
		}
	}
	echo "</td>";
	echo "<td>";
	
	echo "	".i("btofertado",$ilink)." ";
	if ($_SESSION['usuid'] != $fila['usuid'] OR $busca) {
		echo "<input class='col-2' type='text' size='7' value='".tiempo($fila['tiempo'])."'readonly='readonly'>";
	} else {
		echo "<form method='post' action='?op=3'>";
		echo "<select name='changet1'>";
		//la oferta m&iacute;­nima ser&aacute; la suma de lo aceptado, o sea, $usado[0]
		ponoption($usado[0],'08:00:00',$fila['tiempo'],$ilink);
		echo "</select>";
		echo " <input class='col-1' type='submit' name='changet2' value=' >> '>";
		echo " <input type='hidden' name='bancoid' value='".$fila['bancoid']."'>";
		echo "</form>";
	}
	if ($diff[0] != "00:00:00") {
		echo "<br>".i("btutilizado",$ilink)." ";
		echo "<input class='col-2' type='text' size='7' readonly='readonly' value='".tiempo($usado[0])."'>";
		echo " ".i("btrestante",$ilink)." ";
		echo "<input class='col-2' type='text' size='7' readonly='readonly' value='".tiempo($diff[0])."'>";
	}

	if ($_SESSION['usuid'] != $fila['usuid'] AND $fila['activo'] AND $diff[0] != "00:00:00") {
		$puedopedir = pedir($fila,$busca,$ilink);
		if ($puedopedir) {pedir1($fila,$diff[0],$param,$ilink);}
	}

	if ($diff[0] == "00:00:00") {
		echo "<br><span class='rojo'>Oferta completada</span>";
		$completada = 1;
	}	

	if (!$busca AND $fila['activo']) {usadopor($fila,$param,$completada,$diff[0],$ilink);}
	
	echo "</td>";
	echo "<td class='nowrap'>";
	if ($num) {echo $num." / ".number_format($media[0],2,',',' ');}
	echo "</td>";
	echo "</tr>";
}

// --------------------------------------------------

function pedir($fila,$busca,$ilink) {
	$puedopedir=1;
	$sql = "SELECT * FROM bancot2 WHERE bancoid = '".$fila['bancoid']."'
	AND usurecibe = '".$_SESSION['usuid']."' AND aceptado = '0000-00-00'";
	$result = $ilink->query($sql);
	if ($result->num_rows > 0) {
		if ($busca) {
			$fila = $result->fetch_array(MYSQLI_BOTH);
			echo "<br><span class='txth b'>Solicitado ".tiempo($fila['tiempo'])." el ".ifecha31($fila['fecha'],$ilink).". Pendiente de ser aceptado.</span>";
		}
		$puedopedir=0;
	}
	return $puedopedir;
}

// --------------------------------------------------

function pedir1($fila,$tqueda,$param,$ilink) {
	echo "<br><form action='?$param' method='post'>".i("btpedir",$ilink)." ";
	echo "<select name='pidot'>";
	ponoption('00:00:00',$tqueda,'',$ilink);
	echo "</select>";
	//echo "<input type='text' name='pidot' size='5' maxlength='5' value='00:00'>";
	echo " <input class='col-2' type='submit' name='pedirt' value=' >> '>";
	echo "<input type='hidden' name='pidoid' value='".$fila['bancoid']."'>";
	echo "</form>";
}

// --------------------------------------------------

function ponoption($min,$x,$selected,$ilink) {
	$max = "SELECT ADDTIME('$min', '$x')";
	$iresult = $ilink->query($max);
	$max = $iresult->fetch_array(MYSQLI_BOTH);
	$max = $max[0];	

	$valor = $min;
	while (1==1) {
		echo "<option value='$valor'";
		if ($valor == $selected) {echo " selected='selected'";}
		echo ">".tiempo($valor)."</option>";			
		if ($valor >= $max OR $n >20) {return;}
		$n++;
		$valor = "SELECT ADDTIME('$valor', '00:30:00')";
		$iresult = $ilink->query($valor);
		$valor = $iresult->fetch_array(MYSQLI_BOTH);
		$valor = $valor[0];	
	}
	return;
}

// --------------------------------------------------

function usadopor($fila,$param,$completada,$queda,$ilink) {
	$usado1 = "SELECT * FROM bancot2 WHERE bancoid = '".$fila['bancoid']."'";
	$usado1 = $ilink->query($usado1);
	echo "<table>";
	while ($fila1 = $usado1->fetch_array(MYSQLI_BOTH)) {
		if (!$tit1) {
			echo "<tr><th>Petici&oacute;n</th><th>Aceptado</th><th></th>";
			if ($_SESSION['auto'] > 4) {
				echo "<th>Valoraci&oacute;n</th></tr>";
			}
			$tit1=1;
		}
		echo "<tr>";
		echo "<td>".ifecha31($fila1['fecha'],$ilink)."</td>";
		echo "<td>";
		if ($fila1['aceptado'] == "0000-00-00") {
			if ($queda < $fila1['tiempo']) {
				echo "<span class='rojo b'>Demasiado tiempo solicitado</span><br>";
			}
			if (($_SESSION['usuid'] == $_GET['usuid'] OR !$_GET['usuid']) AND !$completada) {
				if ($queda >= $fila1['tiempo']) {
					echo "<a href='?$param&bancot=".$fila1['bancoid']."&rec=".$fila1['usurecibe']."' class='b'>ACEPTAR</a>";
				}
			} elseif ($completada) {
				echo "<span class='rojo b'>Oferta completada</span>";
			}
		} else {
			echo ifecha31($fila1['aceptado'],$ilink);
		}
		echo "</td>";
		echo "<td>";
		$usu = ponerusu($fila1['usurecibe'],1,$ilink);
		echo $usu[0].$usu[1];
		echo "<br><span class='rojo b'>solicita ".tiempo($fila1['tiempo'])."</span>";
		echo "</td>";
		if ($_SESSION['auto'] > 4) {
			echo "<td>";
			if ($fila1['satisfac']) {echo $fila1['satisfac'];}
			echo "</td>";
		}
		echo "</tr>";
	}
	echo "</table>";
}

// --------------------------------------------------

function completado($bancoid,$tiempo,$ilink) {
	$usado = "SELECT SEC_TO_TIME(SUM(TIME_TO_SEC(tiempo))) FROM bancot2 WHERE
	 bancoid = '".$bancoid."' AND aceptado != '0000-00-00'";
	$iresult = $ilink->query($usado); 
	$usado = $iresult->fetch_array(MYSQLI_BOTH);
	if (!$usado[0]) {$usado[0] = "00:00:00";}
	$diff = "SELECT SUBTIME('".$tiempo."','$usado[0]')";
	$iresult = $ilink->query($diff);
	$diff = $iresult->fetch_array(MYSQLI_BOTH);
	$iresult = $ilink->query(" SELECT AVG(satisfac), COUNT(satisfac)
	 FROM bancot2 WHERE bancoid='".$bancoid."' AND aceptado != '0000-00-00' 
	 AND satisfac");
	$media = $iresult->fetch_array(MYSQLI_BOTH);
	$ret[0] = $usado[0];
	$ret[1] = $diff[0];if (!$ret[1]) {$ret[1] = "00:00:00";}
	$ret[2] = $media[0];
	$ret[3] = $media[1];
	return $ret;
}

?>