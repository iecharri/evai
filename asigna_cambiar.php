<?php

// ------------- selecciona asignatura 

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

if ($_SESSION['auto'] < 2) {return;}

if ($_GET['y'] AND $_GET['filtroasign']) {

	$asigna = trim($_GET['filtroasign']);
	$curso =  $_GET['curso'];
	$grupo = strtoupper($_GET['grupo']);

} elseif ($_POST['filtroasign']) {

	$asigna = trim($_POST['filtroasign']);
	$curso =  $_POST['curso'];
	$grupo = strtoupper($_POST['grupo']);
}

?>
