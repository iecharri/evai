<?php

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

// -------------------------------------------------- EDICI&Oacute;N NOTICIA // --------------------------------------------------

function editarnoti($ilink) {

extract($_POST);
if ($accion == 'editar1') {
	
	$fusuario = usuautc($eddia, $edhora);
	
	if ($edvisible == 'on') {$temp1 = 1;}
	if ($edmostrar == 'on') {$temp2 = 1;}
	if ($edtablon == 'on') {$temp3 = 1;}
	
	$sql = "SELECT autor, asigna, curso, grupo, titulaci FROM noticias WHERE id = '$id' LIMIT 1";
	$iresult = $ilink->query($sql);
	$fila = $iresult->fetch_array(MYSQLI_BOTH);
	extract($fila);
	
	if (!$temp2 AND !$temp3) {
		$titulaci = "";
		$asigna = "";
		$curso = "";
		$grupo = "";
	}
		
	if ($autor == $_SESSION['usuid'] OR $_SESSION['auto'] == 10) {
		if ($edborrar == 'on') {
			$ilink->query("DELETE FROM noticias where id = '$id' LIMIT 1");
		} else {
			$ilink->query("UPDATE noticias SET descripcion = '".addslashes($eddescripcion)."', detalle = '".addslashes($eddetalle)."', dia = '$fusuario[0]', hora = '$fusuario[1]', visible = '$temp1', mostrar = '$temp2', tablon = '$temp3', asigna = '$asigna', curso = '$curso', grupo = '$grupo', titulaci = '$titulaci' WHERE id = '$id'");
		}
	}
}

}

// --------------------------------------------------// A&Ntilde;ADIR NOTICIA // --------------------------------------------------

function anadirnoti($ilink) {

	extract($_POST);
	
	$utc = usuautc($eddia,$edhora);
	
	if ($edvisible == 'on') {$temp1 = 1;}
	if ($edmostrar == 'on') {$temp2 = 1;}
	if ($edtablon == 'on') {$temp3 = 1;}
	if ($temp2 OR $temp3) {
		if ($_SESSION['titasi'] == 2) {
			$edasigna = $_SESSION['asigna'];
			$edgrupo = $_SESSION['grupo']; //if (!$edgrupo) {$edgrupo = "*";}
		}
		if ($_SESSION['titasi'] == 1) {$edtitul = $_SESSION['tit'];}
		$edcurso = $_SESSION['curso']; //if (!$edcurso) {$edcurso = "*";}
	}
	$edautor = $_SESSION['usuid'];

	$ilink->query("INSERT INTO noticias (mostrar, visible, tablon, dia, hora, 
	asigna, autor, descripcion, detalle, curso, grupo, titulaci) VALUES 
	('$temp2', '$temp1', '$temp3', '$utc[0]', '$utc[1]', '$edasigna', '$edautor',
	 '".addslashes($eddescripcion)."', '".addslashes($eddetalle)."', '$edcurso',
	  '$edgrupo', '$edtitul')");

	$id = $ilink->insert_id;	  	  
	require_once APP_DIR . '/fxmail.php';
	if ($edmostrar OR $edtablon) {nxmail($id,$ilink);}
	
}

?>
