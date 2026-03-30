<?php

//Decido no dejar gestionar sonidos, los pongo en MEDIA_DIR
return;

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

if (strpos("*".$_FILES['sonido']['type'], 'wav') > 0) {
	$_GET['sonido'] = "";
	$sonido = $_FILES['sonido']['name'];
	move_uploaded_file($_FILES['sonido']['tmp_name'], DATA_DIR . "/$sonido");
}

if ($_GET['sonido']) {
	if ($_GET['acc'] == "borrar") {safe_unlink(DATA_DIR . "/".$_GET['sonido']);}
	if ($_GET['acc'] == "mess") {
		safe_unlink(DATA_DIR . "/mens.wav");
		safe_copy(DATA_DIR . "/".$_GET['sonido'],DATA_DIR . "/mens.wav");
	}
	if ($_GET['acc'] == "vinc") {
		safe_unlink(DATA_DIR . "/vinc.wav");
		safe_copy(DATA_DIR . "/".$_GET['sonido'],DATA_DIR . "/vinc.wav");
	}
}

echo "<p></p><a href='#' onclick=\"playSound('".DATA_URL . "/mens.wav')\">Sonido para los mensajes del <span class='b'>Messenger</span></a><br>";

echo "<a href='#' onclick=\"playSound('".DATA_URL . "/vinc.wav')\">Sonido para la temporizaci&oacute;n de <span class='b'>V&iacute;nculos</span></a>";

echo "<br>Sonidos disponibles en el servidor:";
leer(DATA_DIR);
echo "<form enctype='multipart/form-data' method='post'>Subir un sonido al servidor
 <input type='file' name='sonido' class='col-3'> <input type='submit' name='soni' value=' >> '></form>";

$ret = $fecha[0];

function leer($dire) {
$dir = opendir($dire);
$n = 0;

echo "<div style='overflow:auto; height:5em' class='colu'>";
while ($elemento = readdir($dir))
{
	if (substr($elemento,-4) == ".wav" AND $elemento != "mens.wav" AND $elemento != "vinc.wav") {
		$array[$n][0] = $elemento;
		$fich = $dire.$elemento;
		$n++;
		echo "<a onclick=\"playSound('".DATA_URL."/$elemento');\">$elemento</a>

		[<a href='?sonido=$elemento&acc=borrar'>borrar</a>] 
		[<a href='?sonido=$elemento&acc=mess'>Messenger</a>] 
		[<a href='?sonido=$elemento&acc=vinc'>Vinculos</a>]<br>";
	}
}
echo "</div>";
closedir($dir);
return $array;
}

?>

<span id="son"></span>

<script language="javascript" type="text/javascript">
 function playSound(soundfile) {
 	document.getElementById("son").innerHTML= "<audio autoplay><source src='"+soundfile+"' type='audio/wav'></audio>";	
 }
</script>