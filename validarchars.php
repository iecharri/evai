<?php

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

function versidatosok($ilink,$script) {

	$_POST['usuario'] = $ilink->real_escape_string($_POST['usuario']);
	$_POST['password'] = $ilink->real_escape_string($_POST['password']);
	$_POST['password1'] = $ilink->real_escape_string($_POST['password1']);
	$_POST['alumnon'] = $ilink->real_escape_string($_POST['alumnon']);
	$_POST['alumnoa'] = $ilink->real_escape_string($_POST['alumnoa']);
	$_POST['mail'] = $ilink->real_escape_string($_POST['mail']);
	$_POST['dni'] = $ilink->real_escape_string($_POST['dni']);
	$_POST['solicitar'] = $ilink->real_escape_string($_POST['solicitar']);

	extract($_POST);

	if ($nodis OR $nodis1 != 'abcd') {return "*";}

	if(!$_POST['id']) { //hay -id- cuando edito en podprofesores
		if (!preg_match("/[a-z0-9._-]{8,15}/",$usuario)) {return array(1,i('usunoval',$ilink));}
	}
	
	if(!$_POST['id']) { //hay -id- cuando edito en podprofesores
		$result = $ilink->query("SELECT usuario FROM usuarios WHERE usuario = '$usuario'");	   //si existe el usuario
		$val = $result->fetch_array(MYSQLI_BOTH);
		if($val[0]) {return array(1,i('usuexiste',$ilink));}
	}

	if (!preg_match("/[a-zA-Z0-9._-]{8,15}/",$password)) {return array(2,i('passnoval',$ilink));}
	
	if (!preg_match("/[a-zA-Z0-9._-]{8,15}/",$password1)) {return array(3,i('passnoval',$ilink));}

	if ($password != $password1) {return array(4,i('contranocoinc',$ilink));}
	
	if (!trim($alumnon)) {return array(5,i('nomnoval',$ilink));}

	if (!trim($alumnoa)) {return array(6,i('apelnoval',$ilink));}

	if(!$_POST['id']) { //hay -id- cuando edito en podprofesores
		if (!filter_var($mail, FILTER_VALIDATE_EMAIL)) {return array(7,i('mailno',$ilink));}
		$result = $ilink->query("SELECT mail FROM usuarios WHERE mail = '$mail'");	             //si existe el mail
		$existe = $result->fetch_array(MYSQLI_BOTH);
		if($existe[0]) {return array(7,i('losenti',$ilink));}
	}
	
	if($script == "login") {
		if (!trim($dni)) {return array(8,i('dninoval',$ilink));}
		if(!$tipo) {$tipo = "E";}
	}
	
	if($script == "admin" OR $script == "pod") {return;}
	
	// --------------------------------------------------/
			
	if($tipo == "A" AND !$edcurasigru){		
		$mal[0] = 71;
		return $mal;
	}
	if($tipo == "A"){		
		$edcurasigru = explode("*",$edcurasigru);
		$asigna = $edcurasigru[1];
		$curso = $edcurasigru[0]; 
		$grupo = $edcurasigru[2];
		$iresult = $ilink->query("SELECT tipasig FROM podcursoasigna WHERE asigna = '$asigna' AND curso='$curso'");
		$tipasig = $iresult->fetch_array(MYSQLI_BOTH);
		if (!$tipasig[0]) {$curso = "";}
		$result = $ilink->query("SELECT usuid FROM asignatprof WHERE asigna = '$asigna' AND curso = '$curso' AND grupo = '$grupo'");
		if ($result->num_rows == 0) {
			$mal[0] = 711;
			$mal[1] = i("nohayprof",$ilink);
		}
	}
	
		
	if($tipo == "P" AND !$solicitar){		
		$mal[0] = 72;
		$mal[1] = i("motivo",$ilink);
		return $mal;
	}	
}

?>