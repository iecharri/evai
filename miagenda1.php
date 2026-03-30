<?php

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

if (!$_SESSION['usuid']) {exit;}

if (!function_exists('comidoble')) {function comidoble($x) {return str_replace("\"", "&#34;", $x);}}

// -------------------------------------------------- EDICI&Oacute;N NOTICIA  --------------------------------------------------

extract($_POST);

$imgloader = "<div class='spinner icon-spinner'></div> ";

if ($_GET['id']) {

	$id = $_GET['id'];
	$sql = "SELECT * FROM noticias WHERE id = '$id' LIMIT 1";
	$iresult = $ilink->query($sql);
	$fila = $iresult->fetch_array(MYSQLI_BOTH);
	$ag = $fila['dia'];

	if ($fila['autor'] != $_SESSION['usuid'] AND $_SESSION['auto'] < 10){return;}

	echo "<form action='?ag=".$_GET['ag']."' name='form1' method='post' onsubmit='return validar(form1)'>";
	echo "<input type='hidden' name='accion' value='editar1'>\n";
	echo "<input type='hidden' name='id' value='".$_GET['id']."'>\n";
	
	$temp = $fila['dia']." ".$fila['hora'];
	$temp1 = utcausu1($temp);
	$temp2 = explode(" ",$temp1);
	$dia = $temp2[0];
	$hora = $temp2[1];

	echo "<label>".i("agfecha",$ilink)."</label><br>
	<input class='col-1 peq datepicker' type='text' name='eddia' size='10' maxlength='10' value='$dia'> ";
	require_once APP_DIR . "/minutospersiana.php";
	echo " &nbsp; &nbsp; ";
	echo "<span class='rojo'>".i("agborrar",$ilink)."</span><input type='checkbox' name='edborrar'><br>\n";
	echo "<label>".i("descrip",$ilink)."</label><br>
	<input class='col-10' type='text' name='eddescripcion' size='30' maxlength='255' value=\"".comidoble($fila['descripcion'])."\" autofocus required><br>\n";
	echo "<label>".i("agdetall",$ilink)."</label><br>
	<textarea class='col-10' rows='5' cols='40' name='eddetalle' required>" .$fila['detalle']."</textarea><br>\n";
	echo "<input type='checkbox' name='edvisible'";
	if ($fila['visible'] == 1) {echo " checked='checked'";}
	echo "> ".i("agmenspref",$ilink)."<br>\n";
	if ((esprofesor($fila['asigna'],$fila['curso'],$fila['grupo'],$ilink) AND $fila['asigna']) OR ($fila['titulaci'] AND esprofesordetit($fila['titulaci'],$fila['curso'],$ilink))) {
		echo "<input type='Checkbox' name='edmostrar'";
		if ($fila['mostrar'] == 1) {echo " checked='checked'";}
		echo "> ".i("agaagenda",$ilink)."<br>\n";
		echo "<input type='Checkbox' name='edtablon'";
		if ($fila['tablon'] == 1) {echo " checked='checked'";}
		echo "> ".i("agatablon",$ilink)."<br>\n";
	}
	echo "<input type='submit' class='col-2' value=\"".i("agvalid",$ilink)."\">\n";
	echo "</form>\n";

}

// -------------------------------------------------- A&Ntilde;ADIR NOTICIA  --------------------------------------------------

if ($_GET['accion'] == 'anadir') {
	$ag = $_GET['ag']; 
	$dia = explode("-",$ag); if (!$dia[2]) {$ag = $ag."-".gmdate("d");}
	echo "<form action='?ag=".$ag."' name='form1' method='post' onsubmit='return validar(form1)'>";
	$temp = formatof($ag,'');
	echo "<input type='hidden' name='accion' value='anadir1'>\n";
	echo "<label>".i("agfecha",$ilink)."</label><br><input class='col-1 peq datepicker' type='text' name='eddia' ";
	echo "size='10' maxlength='10' value='$temp[0]'> ";
	$hora = zone(gmdate('Y-m-d H:i:s'));
	$hora = $hora[0];
	$hora = explode(" ",$hora);
	$hora = substr($hora[1],0,5);
	require_once APP_DIR . "/minutospersiana.php";
	echo "<br>\n";
	echo "<label>".i("descrip",$ilink)."</label><br><input class='col-10' type='text' name='eddescripcion' size='30' maxlength='255' autofocus required>\n";
	echo "<br><label>".i("agdetall",$ilink)."</label><br><textarea class='col-10' rows='5' cols='40' name='eddetalle' required></textarea>\n";
	echo "<br><input type='Checkbox' name='edvisible'> ".i("agmenspref",$ilink);
	if ((esprofesor($_SESSION['asigna'],$_SESSION['curso'],$_SESSION['grupo'],$ilink) AND $_SESSION['titasi'] == 2) OR (esprofesordetit($_SESSION['asigna'],$_SESSION['curso'],$ilink) AND $_SESSION['titasi'] == 1) OR (soyadmiano($_SESSION['asigna'],$_SESSION['curso'],$ilink) AND ($_SESSION['titasi'] == 1 OR $_SESSION['titasi'] == 2))) {
		echo "<br><input type='checkbox' name='edmostrar'> ".i("agaagenda",$ilink);
		echo "<br><input type='checkbox' name='edtablon'";
		if ($_GET['tablon'] == 1) {echo " checked='checked'";}
		echo "> \n";
		echo i("agatablon",$ilink);
	}
	echo "<br><input type='submit' class='col-2' value=\"".i("aganadir1",$ilink)."\" onclick=\"show('esperar')\"></form>\n";
	echo "<p></p><div id='esperar' style='display:none'>";
	echo $imgloader.i("esperar",$ilink);
	echo "</div>";

}

?>