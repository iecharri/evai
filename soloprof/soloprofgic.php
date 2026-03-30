<?php

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

if ($_POST['recuen']) {
	$sql = "SELECT distinct(usuasi.id) FROM usuasi LEFT JOIN alumasiano ON alumasiano.id = usuasi.id  WHERE usuasi.asigna = '".$_SESSION['asigna']."' $filtrocur";
	$result = $ilink->query($sql);
	if ($ilink->errno) {die ("Error");}
	while ($fila = $result->fetch_array(MYSQLI_BOTH)) {
		$u = $fila['id'];
		require_once APP_DIR . "/gic_actu.php";
	}
}

if ($_GET['vaciar']) {
	$result = $ilink->query("DELETE FROM merlinhabla WHERE decir=1 AND usuid='$usuid'");
}

extract($_POST);
$usuid = $_SESSION['usuid'];

if ($camb == 2) {
	
	if ($borrfrase OR $asigzodi) {
		if ($borrfrase) {
			$ilink->query("DELETE FROM merlinhabla WHERE usuid = '$usuid' AND frase = \"$tablafrases\"");
			$hablamerlin="";
		}
		if ($asigzodi) {
			$yaexiste = yaexistem($hablamerlin,$ilink);
			if (!$yaexiste AND $hablamerlin) {
				$ilink->query("INSERT INTO merlinhabla (frase,usuid) VALUES (\"$hablamerlin\",'$usuid')");
			}
			$ilink->query("UPDATE merlinhabla SET zodiaco = '$zodiaco' WHERE usuid = '$usuid' AND frase = \"$hablamerlin\"");
			$hablamerlin="";
		} 
	} else {
		
		
		if ($dicezodiaco == 'on') {
			$dicezodiaco = dicezodiaco($ilink);
		}
		if ($cumple == 'on' AND $hablamerlin) {
			$hablamerlin = cumple($hablamerlin,$ilink); 
		}	

		if ($dicezodiaco) {$hablamerlin = $dicezodiaco.". ".$hablamerlin;}
		
		
		$yaexiste = yaexistem($hablamerlin,$ilink);
		if (!$yaexiste) {
			$ilink->query("INSERT INTO merlinhabla (frase,usuid,decir) VALUES (\"$hablamerlin\",'$usuid','1')");
		} else {
			$ilink->query("UPDATE merlinhabla SET decir = '1' WHERE frase = \"$hablamerlin\" AND usuid = '$usuid'");
		}
		if ($zodiaco) {
			$ilink->query("UPDATE merlinhabla SET zodiaco = \"$zodiaco\" WHERE frase = \"$hablamerlin\" AND usuid = '$usuid'");
		}
	
/*		if ($dicezodiaco == 'on') {
			$dicezodiaco = dicezodiaco($ilink);
		}	
		if ($cumple == 'on' AND $hablamerlin) {
			$hablamerlin = cumple($hablamerlin,$ilink); 
		}	

		if ($dicezodiaco) {$hablamerlin = $dicezodiaco.". ".$hablamerlin;}
	
		if ($merlinmov) {
			$muevemerlin = $merlinmov; 
		}
*/
	}

}

if (!$_SESSION['gic']) {
	echo "<p><br><p class='mediana rojo'>".i("gicpediracti",$ilink)."</p/><br></p>";
	return;
}

// --------------------------------------------------

unset($array);

$array[0] = "<a href='?pest=$pest&pest1=2'>".i("gicdescri",$ilink)." <span class='icon-arrow-right'></span></a>";

$array[1] = "<a href='?pest=$pest&pest1=2'>".i("temporiz",$ilink)."</a>";
$array[2] = "<a href='?pest=3&pest1=3&gic=1'>".i("recuvinc",$ilink)." $asigna";
if ($curso) {$array[2] .= " / $curso";}
$array[2] .= "</a>";
$array[3] = "<a href='?pest=3&pest1=4&gic=1'>B&uacute;squedas</a>";

if(!$pest1) {$pest1 = 2;}
solapah($array,$pest1,"navhsimple");

// --------------------------------------------------

if ($pest1 == 3) {

	echo "<form name='recuen' method='post'>";
	echo " &nbsp;<input class='col-3' type='submit' name='recuen' value=' >>> realizar recuento >>> ' onclick=\"show('esperar')\"></form>";
	echo "<p><span class='txth b'>".i("recuvinc1",$ilink)."</span></p>";
	echo "<div id='esperar' style='display:none'><p><br></p>";
	echo $imgloader.i("esperar",$ilink);
	echo "<p><br></p></div>";
	if ($_POST['recuen']) {echo "<span class='mediana txth'>".i("recuvinc2",$ilink)."</span><p></p>";}
	return;
		
}		

// --------------------------------------------------

if ($pest1 == 4) {
	if (!$_SESSION['curso']) {
		echo "<p></p>El curso actual es indefinido, no se restringir&aacute;n las b&uacute;squedas";
		return;
	}
	if ($_POST['busque']) {
		$ilink->query("UPDATE cursasigru SET apartirde = '".$_POST['fechamas']."' WHERE asigna = '$asigna' AND curso = '$curso' AND grupo = '$grupo'");
	}
	$sql = "SELECT apartirde FROM cursasigru WHERE asigna = '$asigna' AND curso = '$curso' AND grupo = '$grupo'";
	$iresult = $ilink->query($sql);
	$apartirde = $iresult->fetch_array(MYSQLI_BOTH);
	echo "<p>&nbsp;</p><form name='busquedas' method='post'>";
	echo "Mostrar v&iacute;nculos insertados a partir del (aaaa-mm-dd) ";
	echo "<input type='text' class='col-1' name='fechamas' size='10' maxlength='10' value='$apartirde[0]'>";
	echo " &nbsp;<input class='col-1' type='submit' name='busque' value=' >>>>>> '></form>";
	return;
}

// --------------------------------------------------

if (!strpos($_SERVER['HTTP_USER_AGENT'],"Chrome")) {
	echo "<p></p>Opci&oacute;n de <span class='txth b'>Temporizaci&oacute;n de v&iacute;nculos</span> s&oacute;lo disponible en Navegador <span class='txth b'>Chrome</span>";
	return;
};

// --------------------------------------------------

echo "<h3>".i("asignas",$ilink)."</h3>";
echo " <form name='temporiz' action='".APP_DIR."/gictempo.php' method='post' target='_blank' onsubmit='return validarSelect()'>";
		
echo "<select name='asignastempo[]' size='6' multiple='multiple' id='asignastempo'>";
$sql = "SELECT cod, asignatura FROM podasignaturas ORDER BY cod"; //WHERE inactiva = 0 
$result = $ilink->query($sql);
while ($fila = $result->fetch_array(MYSQLI_BOTH)) {
	echo "<option value='$fila[0]'";
	if($fila[0] == $_SESSION['asigna']) { echo " selected='selected'";}
	echo ">$fila[0] - ";
	if (strlen($fila[1]) > 80) {echo substr($fila[1],0,80)."...";} else {echo $fila[1];}
	echo "</option>";		
}
echo "</select><br>";
if (!$_SESSION['rec5mn']) {$temp = "checked='checked'";} else {$temp = "";}
echo " ".i("rec5sg",$ilink)." <input type='checkbox' name='rec5mn' $temp>";
echo " - Refresh: <input class='col-1' type='text' name='sg' size='4' maxlength='4' value='".$_SESSION['sg']."'> <input class='col-1' type='submit' value=\"".i("segundos",$ilink)."\"></form> &nbsp;";

echo "<form action='".APP_URL."/gictempo.php' method='post' target='_blank'>";
echo " &nbsp; &nbsp; <input class='col-1' type='submit' name='demo' value=' >> DEMO >>'></form>";

// --------------------------------------------------
	
echo "<form action='?pest=3' method='post' name='hablamer'>";
echo "<h3> &nbsp; ".i("mensmerlin",$ilink)."</h3>";

echo i("mensmerlin1",$ilink)."<br>".i("max255",$ilink);

$result = $ilink->query("SELECT * FROM merlinhabla WHERE !decir AND cumpleanos=0 AND usuid = '".$_SESSION['usuid']."' ORDER BY zodiaco, frase");
if ($result->num_rows) {
	echo "<br><span class='txth b'>Selecciona una frase guardada o escribe una nueva</span><br>";
	echo "<select class='peq' name='tablafrases' onchange='document.hablamer.hablamerlin.value=document.hablamer.tablafrases.value'>";
	echo "<option value=''>---</option>";
	while ($fila = $result->fetch_array(MYSQLI_BOTH)) {
		$len = strlen($fila[0]);
		if ($len > 135) {$puntos = " ...";} else {$puntos = "";}
		echo "<option value='$fila[0]'>".substr($fila[0],0,135).$puntos;
		if ($fila[1]) {echo " [frase asignada a $fila[1]]";}
		echo "</option>";
	}
	echo "</select>";
}
echo "<br><input class='col-3' name='hablamerlin' type='text' size='100' maxlength='255'>";
echo " Borrar esta frase";
echo " <input class='col-05' type='submit' name='borrfrase' value=' >> '>";
echo "<p></p><span class='txth b'>Elige si esa frase va se asignar&aacute; a los</span> <select name='zodiaco'>";
echo "<option value=''>- Zodicaco -</option>";
echo "<option value='Aries'>Aries</option>";
echo "<option value='Tauro'>Tauro</option>";
echo "<option value='G&eacute;minis'>G&eacute;minis</option>";
echo "<option value='C&aacute;ncer'>C&aacute;ncer</option>";
echo "<option value='Leo'>Leo</option>";
echo "<option value='Virgo'>Virgo</option>";
echo "<option value='Libra'>Libra</option>";
echo "<option value='Escorpio'>Escorpio</option>";
echo "<option value='Sagitario'>Sagitario</option>";
echo "<option value='Acuario'>Acuario</option>";
echo "<option value='Piscis'>Piscis</option>";
echo "<option value='Capricornio'>Capricornio</option>";
echo "</select> <input class='col-05' name='asigzodi' type='submit' value=' >> '>";	

echo "<input type='hidden' name='camb' value='2'>";
echo "<p></p>Dir&aacute; los conectados seg&uacute;n su signo del zodiaco y una frase relativa al signo m&aacute;s abundante en este momento <input type='checkbox' name='dicezodiaco'><br>";
echo "Felicitar&aacute; a los conectados que cumplan hoy a&ntilde;os con la frase anterior (si en la frase se incluye #nombres#, nombrar&aacute; a todos los que cumplen a&ntilde;os hoy) ";
echo " <input type='checkbox' name='cumple'><p></p>";
echo "<input class='col-2' type='submit' value=\"".i("agvalid",$ilink)."\">";
echo "</form><p></p>";

$result = $ilink->query("SELECT * FROM merlinhabla WHERE usuid='$usuid' AND decir AND frase != \"\"");
echo "<div class='mediana center'><span class='rojo'>".fechaen('',$ilink)."</span>: pr&oacute;ximo mensaje: ";
if ($result->num_rows) {
	echo "<a href='?pest=3&vaciar=1' class='rojo'>[vaciar]</a><br>";
	while ($fila = $result->fetch_array(MYSQLI_BOTH)) {
		echo " <span class='txth'>".$fila['frase']."</span><br>";
	}
}
echo "</div>";

/*if ($hablamerlin) {
	echo "<div class='mediana center'><span class='rojo'>".fechaen('',$ilink)."</span>: pr&oacute;ximo mensaje:<br>";
	echo " <span class='txth'>$hablamerlin</span></div>";
}*/

// --------------------------------------------------

function cumple($hablamerlin,$ilink) {
	
$timestamp = time(); // UTC actual

// Parte final de la fecha: -MM-DD
$date = gmdate("m-d"); // cumpleaños hoy

// Fecha de corte (hace 30 segundos)
$corte = gmdate('Y-m-d H:i:s', $timestamp - 30);

// Usuarios en línea y con cumpleaños hoy
$result = $ilink->query("
    SELECT alumnon, alumnoa, fnaci FROM usuarios WHERE fecha >= '$corte' AND fnaci LIKE '%-$date'");	
	
	$n = 0;
	while ($fila = $result->fetch_array(MYSQLI_BOTH)) {
		if ($n) {$nom .= ", ";} else {$n = 1;}
		$nom .= $fila[0]." ".$fila[1];
	}
	if ($nom) {$hablamerlin = str_replace('#nombres#', $nom, $hablamerlin).". ";}
	return $hablamerlin;
}

function dicezodiaco($ilink) {
	$timestamp = time(); 
	require_once APP_DIR . "/zodiaco.php";
	$result = $ilink->query("SELECT fnaci FROM usuarios WHERE $timestamp-UNIX_TIMESTAMP(fecha) < 30");
	$array = array();
	while ($fila = $result->fetch_array(MYSQLI_BOTH)) {
		$array[] = zodiaco($fila[0]);
	}
	sort($array);
	$contador=array_count_values($array);
	$frase = "Ahora hay en línea ";
	$losmas = 0;
	$n = 0;
	foreach($contador as $valor=>$veces){
		if ($n) {$frase .= ", ";} else {$n = 1;}
		$frase .= $veces." ".$valor;
		if ($veces == $losmas) {
			mt_srand((double)microtime()*1000000);
			$aleat = mt_rand(1,2);
			if ($aleat == 2) {$losmas = $veces; $signo=$valor;}
		} else {
			if ($veces > $losmas) {$losmas = $veces; $signo=$valor;}
		}
	}
	if ($frase) {$frase .= ". ";}

	$result = $ilink->query("SELECT frase FROM merlinhabla WHERE zodiaco = '$signo' AND usuid = '".$_SESSION['usuid']."'");
	if ($result->num_rows) {
		$numfras = $result->num_rows;
		mt_srand((double)microtime()*1000000);
		$numfras = mt_rand(0,$numfras-1);
		$result->data_seek($numfras);
		$fras = $result->fetch_array(MYSQLI_BOTH);
		if (trim($fras[0])) { $frase .= $fras[0];}
	}
	return $frase;
}

function yaexistem($frase,$ilink) {
	$sql = "SELECT usuid FROM merlinhabla WHERE frase = '$frase' AND usuid = '".$_SESSION['usuid']."' AND !decir";
	$result = $ilink->query($sql);
	if ($result->num_rows) {return 1;}
}

?>

<script>
function validarSelect() {
  const select = document.getElementById('asignastempo');
  const seleccionados = Array.from(select.options).filter(opt => opt.selected);
  if (seleccionados.length === 0) {
    alert("Debes seleccionar al menos una asignatura.");
    return false;
  }
  return true;
}
</script>
