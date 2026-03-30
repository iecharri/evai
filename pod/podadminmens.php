<?php

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

if ($_SESSION['auto'] < 10) {exit;}

$caso = 4; 

require_once APP_DIR . "/pod/podformfiltro.php";

if ($_POST['camb'] == 1 AND $_SESSION['auto'] == 10) {
	$temp = $_POST['atencion'];
	$ilink->query("UPDATE podareas SET atenciontodos = '$temp'");
}

if ($_POST['camb1'] == 1 AND $_SESSION['auto'] == 10 AND $filtroarea) {
	$temp = $_POST['atencion1'];
	$ilink->query("UPDATE podareas SET atencion = '$temp' WHERE codarea = '$filtroarea'");
}

echo "<br>";

if ($_SESSION['auto'] == 10) {

	echo str_replace("<usuauto>", "<span class='txth b'>".i("administradores",$ilink)."</span>", i("mensbanner",$ilink));
	echo "<br>";
	echo i("bannervac",$ilink)." ".i("max255",$ilink)."<br>";
	echo "<form action='?pest=$pest' method='post'>";
	$result = $ilink->query("SELECT * FROM podareas");
	$fila = $result->fetch_array(MYSQLI_BOTH);
	echo "<input class='col-8' name='atencion' type='text' size='60' maxlength='255' value=\"".$fila['atenciontodos']."\"> 
	<input type='hidden' name='camb' value='1'>
	<p><input class='col-2' type='submit' value=\">> ".i("aceptar",$ilink)." >>\"></form></p>";
	echo "<div class='both'></div>";
	
}

if ($_SESSION['auto'] == 10 AND $filtroarea) {

	echo str_replace("<usuauto>", "<span class='txth b'>los Jefes de &Aacute;rea</span>", i("mensbanner",$ilink));
	echo "<br>";
	echo i("bannervac",$ilink)." ".i("max255",$ilink)."<br>";
	echo "<form action='?pest=$pest' method='post'>";
	$result = $ilink->query("SELECT atencion FROM podareas WHERE codarea = '$filtroarea'");	$fila = $result->fetch_array(MYSQLI_BOTH);
	echo "<input class='col-8' name='atencion1' type='text' size='60' maxlength='255' value=\"".$fila['atencion']."\"> 
	<input type='hidden' name='camb1' value='1'>
	<p><input class='col-2' type='submit' value=\">> ".i("aceptar",$ilink)." >>\"></form></p>";
	echo "<div class='both'></div>";
	
}

?>
