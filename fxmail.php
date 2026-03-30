<?php

require_once __DIR__ . '/siempre_base.php';

function fxmail($id,$foro,$ilink) {

	$iresult = $ilink->query("SELECT comentario FROM foro WHERE id = '$id' LIMIT 1");
	$comentario = $iresult->fetch_array(MYSQLI_BOTH);
	$comentario = $comentario[0];
	
	$iresult = $ilink->query("SELECT titulaci, asigna, curso, grupo, asunto FROM foro WHERE id = '$foro' LIMIT 1");
	$fila = $iresult->fetch_array(MYSQLI_BOTH);
	$asunto = $fila[4];

	if ($fila[2] == "*") {$fila[2] = "";}
	if ($fila[3] == "*") {$fila[3] = "";}
	
	$enviar = enviarxmail("foro",$fila[0],$fila[1],$fila[2],$fila[3],$ilink);
	
// --------------------------------------------------
	
	if (!$enviar) {return;}
	
	if($enviar == 2 AND ($_SESSION['auto'] < 5 OR $id != $foro)) {return;}

// --------------------------------------------------
	
	$asuntomail = "EVAI - ".i("foro",$ilink)." $fila[0] $fila[1] $fila[2] $fila[3]";

	$zonaUsuario = $_SESSION['zone'] ?? 'UTC';
	$dt = new DateTime('now', new DateTimeZone($zonaUsuario));

	$fp=safe_fopen("foroxmail.php","r");
	$textomail = fread($fp,filesize("foroxmail.php"));
	fclose($fp);
	$textomail = str_replace("#dominio_data#",DOMINIO . MEDIA_URL ,$textomail);
	$textomail = str_replace("#Nombre del foro#", $asuntomail, $textomail);
	$textomail = str_replace("#Tema del foro#", $asunto, $textomail);
	$textomail = str_replace("#Usuario#",minom(1,1,$ilink),$textomail);
	$textomail = str_replace("#fecha#", $dt->format($_SESSION['dformat']), $textomail);
	$textomail = str_replace("#Mensaje#", nl2br($comentario), $textomail);

	$fp=safe_fopen("foroxmail1.php","r");
	$textomail1 = fread($fp,filesize("foroxmail1.php"));
	fclose($fp);

	$textomail1 = str_replace("#dominio_data#",DOMINIO . MEDIA_URL ,$textomail1);
	$textomail1 = str_replace("#Nombre del foro#", $asuntomail, $textomail1);
	$textomail1 = str_replace("#Tema del foro#", $asunto, $textomail1);
	$textomail1 = str_replace("#Usuario#",minom(1,1,$ilink),$textomail1);
	$textomail1 = str_replace("#fecha#", $dt->format($_SESSION['dformat']), $textomail1);
	$textomail1 = str_replace("#Mensaje#", $comentario, $textomail1);

	$from = $_SESSION['usuid'];

	if ($fila[0]) {
		$sqlprof = usu_enviar(1,1,$fila);
		$result = $ilink->query($sqlprof);
		if ($result AND $result->num_rows) {
			$fila2=array();
			while ($fila1 = $result->fetch_array(MYSQLI_BOTH)) {$fila2[]=$fila1[0];}
			pormail_n($from,$fila2,$asuntomail,$textomail,$textomail1,$ilink);
		}
		$sqlalu = usu_enviar(1,0,$fila);
		$result = $ilink->query($sqlalu);
		if ($result AND $result->num_rows) {
			$fila2=array();
			while ($fila1 = $result->fetch_array(MYSQLI_BOTH)) {$fila2[]=$fila1[0];}
			pormail_n($from,$fila2,$asuntomail,$textomail,$textomail1,$ilink);
		}
	} else {
		$sqlprof = usu_enviar(0,1,$fila);
		$result = $ilink->query($sqlprof);
		if ($result AND $result->num_rows) {
			$fila2=array();
			while ($fila1 = $result->fetch_array(MYSQLI_BOTH)) {$fila2[]=$fila1[0];}
			pormail_n($from,$fila2,$asuntomail,$textomail,$textomail1,$ilink);
		}
		$sqlalu = usu_enviar(0,0,$fila);
		$result = $ilink->query($sqlalu);
		if ($result AND $result->num_rows) {
			$fila2=array();
			while ($fila1 = $result->fetch_array(MYSQLI_BOTH)) {$fila2[]=$fila1[0];}
			pormail_n($from,$fila2,$asuntomail,$textomail,$textomail1,$ilink);
		}
	}

}


function nxmail($id,$ilink) {

	$iresult = $ilink->query("SELECT titulaci, asigna, curso, grupo, descripcion, detalle FROM noticias WHERE id = '$id' LIMIT 1");
	$fila = $iresult->fetch_array(MYSQLI_BOTH);

	if ($fila[2] == "*") {$fila[2] = "";}
	if ($fila[3] == "*") {$fila[3] = "";}

	$enviar = enviarxmail("noti",$fila[0],$fila[1],$fila[2],$fila[3],$ilink);
	if (!$enviar) {return;}
	
	$asuntomail = "EVAI - News $fila[0] $fila[1] $fila[2] $fila[3]";

	$zonaUsuario = $_SESSION['zone'] ?? 'UTC';
	$dt = new DateTime('now', new DateTimeZone($zonaUsuario));

	$fp=safe_fopen("notixmail.php","r");
	$textomail = fread($fp,filesize("notixmail.php"));
	fclose($fp);

	$textomail = str_replace("#Tema#", $fila[4], $textomail);
	$textomail = str_replace("#Usuario#",minom(1,1,$ilink), $textomail);
	$textomail = str_replace("#fecha#", $dt->format($_SESSION['dformat']), $textomail);
	$textomail = str_replace("#Mensaje#", nl2br($fila[5]), $textomail);
	$textomail = str_replace("#dominio_data#",DOMINIO_DATA,$textomail);

	$fp=safe_fopen("notixmail1.php","r");
	$textomail1 = fread($fp,filesize("notixmail1.php"));
	fclose($fp);

	$textomail1 = str_replace("#Tema#", $fila[4], $textomail1);
	$textomail1 = str_replace("#Usuario#", minom(1,1,$ilink), $textomail1);
	$textomail1 = str_replace("#fecha#", $dt->format($_SESSION['dformat']), $textomail1);
	$textomail1 = str_replace("#Mensaje#", $fila[5], $textomail1);
	$textomail1 = str_replace("#dominio_data#",DOMINIO_DATA,$textomail1);

	$from = $_SESSION['usuid'];

	if ($fila[0]) {
		$sqlprof = usu_enviar(1,1,$fila);
		$result = $ilink->query($sqlprof);
		if ($result->num_rows) {
			$fila2=array();
			while ($fila1 = $result->fetch_array(MYSQLI_BOTH)) {$fila2[]=$fila1[0];}
			pormail_n($from,$fila2,$asuntomail,$textomail,"",$textomail1,$ilink);
		}
		$sqlalu = usu_enviar(1,0,$fila);
		$result = $ilink->query($sqlalu);
		if ($result->num_rows) {
			$fila2=array();
			while ($fila1 = $result->fetch_array(MYSQLI_BOTH)) {$fila2[]=$fila1[0];}
			pormail_n($from,$fila2,$asuntomail,$textomail,"",$textomail1,$ilink);
		}
	} else {
		$sqlprof = usu_enviar(0,1,$fila);
		$result = $ilink->query($sqlprof);
		if ($result->num_rows) {
			$fila2=array();
			while ($fila1 = $result->fetch_array(MYSQLI_BOTH)) {$fila2[]=$fila1[0];}
			pormail_n($from,$fila2,$asuntomail,$textomail,"",$textomail1,$ilink);
		}
		$sqlalu = usu_enviar(0,0,$fila);
		$result = $ilink->query($sqlalu);
		if ($result->num_rows) {
			$fila2=array();
			while ($fila1 = $result->fetch_array(MYSQLI_BOTH)) {$fila2[]=$fila1[0];}
			pormail_n($from,$fila2,$asuntomail,$textomail,"",$textomail1,$ilink);
		}
	}

}

function usu_enviar($tit, $prof, $fila) {

	if ($fila[2] == "*") {$fila[2] = "";}
	if ($fila[3] == "*") {$fila[3] = "";}

	if ($tit) {
		if ($prof) {
			return "SELECT DISTINCT mail FROM asignatprof 
				LEFT JOIN podcursoasignatit ON asignatprof.asigna = podcursoasignatit.asigna
				AND asignatprof.curso = podcursoasignatit.curso 
				LEFT JOIN usuarios ON asignatprof.usuid = usuarios.id 
				WHERE podcursoasignatit.tit = '$fila[0]' AND podcursoasignatit.curso = '$fila[2]' AND fechabaja='0000-00-00 00:00:00' AND usuarios.autorizado > 4 
				ORDER BY usuarios.alumnoa ";
		} else {
			return "SELECT DISTINCT mail FROM alumasiano 
				  LEFT JOIN usuarios ON alumasiano.id = usuarios.id 
				  LEFT JOIN podcursoasignatit ON alumasiano.asigna = podcursoasignatit.asigna
				  AND alumasiano.curso = podcursoasignatit.curso
				  WHERE usuarios.autorizado > 3 AND fechabaja='0000-00-00 00:00:00' AND podcursoasignatit.tit = '$fila[0]' AND podcursoasignatit.curso = '$fila[2]' 
				  ORDER BY usuarios.alumnoa ";
		}
	} else {
		if ($prof) {
 			return "SELECT DISTINCT mail FROM asignatprof 
				LEFT JOIN usuarios ON asignatprof.usuid = usuarios.id 
				WHERE asigna = '$fila[1]' AND curso = '$fila[2]' AND grupo = '$fila[3]' AND fechabaja='0000-00-00 00:00:00' AND autorizado > 4 
				ORDER BY usuarios.alumnoa ";
		} else {
			return "SELECT DISTINCT mail FROM alumasiano 
				  LEFT JOIN usuarios ON alumasiano.id = usuarios.id 
				  WHERE autorizado > 3 AND fechabaja='0000-00-00 00:00:00' AND asigna = '$fila[1]' AND curso = '$fila[2]' AND grupo = '$fila[3]' 
				  ORDER BY usuarios.alumnon ";
		}
	}
	
}

?>