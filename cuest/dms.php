<?php

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

function dms($segundos){
	//dias es la division de n segs entre 86400 segundos que representa un dia;
	$dias=floor($segundos/86400);
	//mod_hora es el sobrante, en horas, de la division de dÃ­as;	
	$mod_hora=$segundos%86400;
	//hora es la division entre el sobrante de horas y 3600 segundos que representa una hora;
	$horas=floor($mod_hora/3600);
	//mod_minuto es el sobrante, en minutos, de la division de horas;	
	$mod_minuto=$mod_hora%3600;
	//minuto es la division entre el sobrante y 60 segundos que representa un minuto;
	$minutos=floor($mod_minuto/60);
	//mod_segundo es el sobrante, en segundos, de la division de minutos;	
	$mod_segundo=$mod_minuto%3600;
	//segundo es la division entre el sobrante y 60 segundos que representa un minuto;
	$segundo=floor($mod_segundo/60);
	//segundos restantes
	$resto = $mod_segundo%60;	

	if ($dias) {$ret = $dias."d";}
	if ($horas) {$ret .= " ".$horas."h";}
	if ($minutos) {$ret .= " ".$minutos."m";}
	if ($resto) {$ret .= " ".$resto."s";}
	return $ret;
	
	if($horas<=0){
		return $minutos." minutos "; //.$resto."s";
	}elseif($dias<=0){
		return $horas.' horas '.$minutos." minutos "; //.$resto."s";
	}else{
		return $dias.' dÃ­as '.$horas.' horas '.$minutos." minutos "; //.$resto."s";
	}
}

?>