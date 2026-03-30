<?php

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

function autoini($usuid,$ilink) {

	if (!$usuid) {
		return i('usunoex',$ilink);
	}

	$iresult = $ilink->query("SELECT tipo, autorizado, passwordinicial, fechabaja,
	(UTC_DATE() >= DATE_ADD(fechaalta, INTERVAL 7 DAY)) AS plazo_cumplido, DATE_ADD(fechaalta, INTERVAL 7 DAY) AS fecha_limite FROM usuarios WHERE id = '$usuid' LIMIT 1");
	$fila = $iresult->fetch_array(MYSQLI_BOTH);
	extract($fila);

	// Usuario dado de baja con fecha fechabaja

	if ($fechabaja != "0000-00-00 00:00:00") {return i("usunoex",$ilink);exit;}

	//es Profesor, est&aacute; autorizado desde cualquier IP

	if ($autorizado > 4) {return $autorizado;}

	//Puede ser un P o A pendiente de validaci&oacute;n o un usario no autorizado

	if ($autorizado < 2) {
		if ($autorizado == 0 AND $tipo == 'P') {
			if ($passwordinicial == 0) { //esto no esta bien, creo
				return i('usunoaut',$ilink); exit; // Usuario no autorizado, no validado en el tiempo requerido
			}
			return i('profval',$ilink); exit; //Profesor sin validar a&uacute;n
		}
		if ($autorizado == 0 AND $tipo == 'A') {
			if ($passwordinicial == 0) { //esto no esta bien, creo
				return i('usunoaut',$ilink); exit; // Usuario no autorizado, no validado en el tiempo requerido  
			}
			return i('aluval',$ilink); exit; //Alumno sin validar // ver si plazo cumplido
		}
		return i('usunoaut',$ilink); exit; //Usuario no autorizado  // ver si plazo cumplido
	}

	$ip = filter_var($_SERVER['REMOTE_ADDR'], FILTER_VALIDATE_IP) ?: '0.0.0.0';
	$iresult = $ilink->query("SELECT autorizado FROM maquinas WHERE ip = '$ip'");
	$maq = $iresult ->fetch_array(MYSQLI_BOTH);
	$maq = $maq[0];

	//autorizado es 2,3 o 4
	//la autorizaci&oacute;n a la IP es relevante

	if ($maq > 0) {
		if ($maq < 2) {return i('mqnoaut',$ilink);} // M&aacute;quina no autorizada
		if ($autorizado > $maq) {$autorizado = $maq;}
	}

	//autorizado es 2, 3 o 4
	//ver si autorizado es 3 y si se ha validado en el tiempo requerido

	if ($autorizado == 3) {
		//list($anno, $mes, $dia) = explode( "-", $fechaalta);
		//list($anno1, $mes1, $dia1) = explode (" ", gmdate("Y m d"));
		//$dia = $dia + 7;
		//if ( mktime(0,0,0,$mes,$dia,$anno) < mktime(0,0,0,$mes1,$dia1,$anno1) ) {
		if ((int)$plazo_cumplido === 1) {
			//$ilink->query("UPDATE usuarios SET passwordinicial = '' WHERE id = '$id' LIMIT 1");
			return i('usunoaut',$ilink); exit; // Usuario no autorizado, no validado en el tiempo requerido
		}
		$_SESSION['sinvalidar'] = $fecha_limite;  //gmdate("d-m-Y", mktime(0, 0, 0, $mes, $dia, $anno));
	}

	return $autorizado; exit;

}

function auto($usuid, $asigna, $curso, $grupo, $ip, $ilink){

	$iresult = $ilink->query("SELECT autorizado FROM usuarios WHERE id = '$usuid' LIMIT 1");
	$fila = $iresult->fetch_array(MYSQLI_BOTH);
	extract($fila);

	if ($autorizado == 10) {return $autorizado;exit;}
	if (soyadmiano($asigna,$curso,$ilink)) {return 6;exit;}
	if ($autorizado == 5) {return $autorizado;exit;}
	if ($autorizado < 2) {return;exit;}

	if ($ip AND $autorizado < 5) {
		$ip = filter_var($_SERVER['REMOTE_ADDR'], FILTER_VALIDATE_IP) ?: '0.0.0.0';
		$iresult = $ilink->query("SELECT autorizado FROM maquinas WHERE ip = '$ip'");
		$maq = $iresult->fetch_array(MYSQLI_BOTH);
		$maq = $maq[0];

		if ($maq > 0) {
			if ($autorizado > $maq) {$autorizado = $maq;}
		}
	}

	if (trim($asigna)) {
		$iresult = $ilink->query("SELECT auto FROM alumasiano WHERE asigna = '$asigna' AND curso = '$curso' AND grupo = '$grupo' AND id = '$usuid'");
		$temp = $iresult->fetch_array(MYSQLI_BOTH);
		if ($temp[0] < $autorizado) {$autorizado = $temp[0];}
	}

	return $autorizado;

}