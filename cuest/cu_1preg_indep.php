<?php

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

//traigo variables ordenadas, alfabet, sinnum

//si añadir, no dejar modificar valores de formulario

if(!$ponerform) {$disabled="disabled";}

$i = $fila['n'];

$separador = $espacio = "";
if (!$fila['n1'] AND !$fila['input']) {
	$separador = 'b';
	if(!$solop) {$espacio = "<p></p>";}
}

echo $espacio;
	
echo "<span class='contiene $separador'>";

	if (!$separador AND $numera) {
		echo "<br><span class='rojo'>".$numera."</span> ";
		if($numera) {$numera++;}
	}

	echo nl2br(conhiper($fila['p']));

echo "</span>";

if($solop) {return;}

if ($fila['imagen']) {
	$param = "tabla=$cuest"."1&idfoto=".$fila['n'];
	if (preg_match('/^image/',$fila['tipofich'])) {
		echo "<br><span class='col-9'><img src='verfich.php?$param' style='height:".$fila['ancho']."px'></span>"; 
	}
}
	
if ($fila['youtube']) {
	echo poneryoutub($fila['youtube'],$fila['anchoyoutube']);
}

if($solom) {return;}

echo "<br>";

//si es persiana

if ($fila['input'] == 'persiana') {
	$j = 0;
	echo "<select name='v$i' $disabled>";
	$result1 = $ilink->query("SELECT * from ".$cuest."1 WHERE n1>0 AND n = ".$fila['n']." ORDER BY orden"); // n, n1  order by!!
	while ($fila1 = $result1->fetch_array(MYSQLI_BOTH)) {
		echo "<option value = '".$fila1['n1']."'";
		if ($fila1['n1'] == $post) {echo " selected = 'selected'";}
		echo ">";
		if ($alfabet) {echo chr($j+65).")";}
		echo " ".$fila1['p'];
		$j++;
	}
	echo "</select>";
}

//si es texto
	
if ($fila['input'] == 'texto') {
	if($fila['amin'] > 80) {$col = "col-5";} else {$col = "col-2";}
	echo "<input class='$col max100' value=\"$post\" name='v$i' size='";
	if ($fila['amin'] > 80) {
		echo "80";
	} else {
		echo $fila['amin'];
	}
	echo "' maxlength='".$fila['amax']."'";
	if ($fila['defec']) {
		echo " value='".$fila['input']."'";
	}
	echo " $disabled>";
}

//si es longtext
		
if ($fila['input'] == 'longtext') {
	echo "<textarea class='col-10' rows='5' cols='80' name='v$i' $disabled>$post</textarea>";
}

//si est check
	
if ($fila['input'] == 'check') {
	$j = 0;
	$enter=" "; if ($ordenadas) {$enter = "<br>";}
	$result1 = $ilink->query("SELECT * from ".$cuest."1 where n1>0 AND n = ".$fila[0]." ORDER BY orden"); //n, n1 order by!!!
	while ($fila1 = $result1->fetch_array(MYSQLI_BOTH)) {
		echo "<input type='radio' name='v$i' value='".$fila1['n1']."' onclick=\"uncheckRadio(this)\"";
		if ($fila1['n1'] == $post) {
			echo " checked='checked'";
		}
		echo " $disabled>";
		if ($alfabet) {echo chr($j+65).")";}
		echo " ".$fila1['p'].$enter;
		$j++;
	}
}

echo "<div class='both'>&nbsp;</div>";

echo $espacio;

?>