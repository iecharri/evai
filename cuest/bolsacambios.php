<?php

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

//se va a anadir una pregunta

if ($reganadir1) {
	if($p1 OR (!$input1 AND $_FILES['upimagen']['name'])) {
		require_once APP_DIR . '/cuest/bolsapregadd.php';
		$opc1 = 1;
	} else {
		if (!$p1) {
			$mensaje = "<span class='rojo b'>Escribe la pregunta</span>";
		}
	}
}

//se va a modificar una pregunta

if ($regmodif1 == 1) {
	require_once APP_DIR . '/cuest/bolsapregchg.php';	
	$regmodif1 = 0; //por que???
}

?>