<?php

require_once __DIR__ . "/../siempre_base.php";

require_once APP_DIR . "/wrapper_archivos.php";

if ($_SESSION['auto'] < 10 ) {
	exit;
}

$directorio = DATA_DIR . "/temp/";

$archivos = scandir($directorio); //hace una lista de archivos del directorio
$num = count($archivos); //los cuenta

//Los borramos
for ($i=0; $i<=$num; $i++) {
	// si empiezan por "p" o "a", tienen extensi&oacute;n .txt e incluyen un gui&oacute;n se borran (control para no borrar por error nada importante)
	$fich = explode(".",$archivos[$i]);
	if ($fich[1] != "txt") {continue;}
	if (substr($fich[0],0,1) != "a" AND substr($fich[0],0,1) != "p") {continue;}
	if (strpos($fich[0],'-') == 0) {continue;}
 	safe_unlink ($directorio.$archivos[$i]); 
}

// --------------------------------------------------

$directorio = "../tmp/";

$archivos = scandir($directorio); //hace una lista de archivos del directorio
$num = count($archivos); //los cuenta

//Los borramos
for ($i=0; $i<=$num; $i++) {
	// si empiezan por "u" y tienen extensi&oacute;n .txt o .wav se borran (control para no borrar por error nada importante)
	$fich = explode(".",$archivos[$i]);
	if ($fich[1] != "txt" AND $fich[1] != "wav") {continue;}
	if (substr($fich[0],0,1) != "u") {continue;}
 	safe_unlink ($directorio.$archivos[$i]); 
}

echo "<span class='txth b'> HECHO</span>";

?>