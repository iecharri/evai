<?php

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

function sesion($usuid, $id, $ilink) {
	
	date_default_timezone_set('UTC');

	$fecha = gmdate("Y-m-d H:i:s");
	$varsesion = session_id();

	if (!$usuid) {

		if (!$id OR $id < 1) {return;}
		
		//insertar registro en usosistema, el usuario entra en el sistema
		$ip = filter_var($_SERVER['REMOTE_ADDR'], FILTER_VALIDATE_IP) ?: '0.0.0.0';

		$sql = "INSERT INTO usosistema (entra, id, sesion, ip) VALUES ('$fecha', '$id', '$varsesion', '$ip')";
		$ilink->query($sql);
		return;
		
	} else {
	
		return 1;	
	
	}	
	
}

?>