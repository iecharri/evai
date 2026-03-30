<?php

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

function ponerusuf($id,$grande,$ilink){
	$usu = ponerusu($id,$grande,$ilink);
	$usu[0] = str_replace("<a href='".APP_URL."/ficha.php?usuid=$id' target='_blank'>","<a href='#' onclick='openFic()'>",$usu[0]);
	$usu[1] = str_replace("<a href='".APP_URL."/ficha.php?usuid=$id' target='_blank'>","<a href='#' onclick='openFic()'>",$usu[1]);
	return $usu;
}

function ponerusu($id,$grande,$ilink){
	if(!$id) {return sologenerico($grande);}
	$timestamp = time(); 
	$f1 = $ilink->query("SELECT foto, estado, autorizado, fechabaja, privacidad, sexo, tipo, usuario, alumnon, alumnoa, fecha, mesiento, estoy FROM usuarios WHERE id = '$id' LIMIT 1");
	$f = $f1->fetch_array(MYSQLI_BOTH);
	if (!$f) {return sologenerico($grande);}
	if ($f['fechabaja'] != "0000-00-00 00:00:00" AND $_SESSION['auto'] < 10) {return sologenerico($grande);}
	if ($f['fechabaja'] != "0000-00-00 00:00:00") {$esbaja = 1;}
		
	$mipriv = $_SESSION['mipriv'];
	extract($f);
	//Si tiene foto creo las miniaturas si no est&aacute;n
	if ($foto) {
		$fo1 = DATA_DIR . "fotos/1$f[0]"; 
		$fo2 = DATA_DIR . "/fotos/2$f[0]";
		if (!file_exists($fo1) OR !file_exists($fo2)) {
			foto($f[0], '', '');
		}
	}
	//lo veo en linea?
	$enlinea = estaenlinea($id,$f);
	//veo su foto o veo foto gen&eacute;rica?
	if ($_SESSION['auto'] == 10 OR $id == $_SESSION['usuid'] OR $_SESSION['auto'] > $f['autorizado'] OR (!$f['privacidad'] AND !$mipriv)) {
		$ver = 1;
	}
	//a donde el link?
	if ($ver) {
		$script = pathinfo($_SERVER['PHP_SELF']);
		$php = APP_URL . "/ficha"; $target = "_blank"; 
		if ($script['filename'] == "jusuonline") {$php = APP_URL . "/usuarios"; $target="";}
		if(!$mipriv[0] OR $_SESSION['auto'] > 4 OR $id == $_SESSION['usuid']) {
			$php1 = "<a href='$php".".php?usuid=$id' target='$target'>";
			$php2 = "</a>";
		}
	}
 	$nomape = nomape($id,$enlinea,$esbaja,$ver,$estado,$privacidad,$tipo,$usuario,$alumnon,$alumnoa,$mesiento,$estoy,$ilink);
	$foto = fotomedi($id,$foto,$ver,$enlinea,$sexo,$grande);
	$foto = str_replace("#title#",$nomape[0],$foto);
	$ret[0] = $php1.$foto.$php2;
	$ret[1] = str_replace("#php2#",$php2,str_replace("#php1#",$php1,$nomape[1]));
	$ret[2] = $estoy;
	return $ret;

}
// --------------------------------------------------
function nomape($id,$enlinea,$esbaja,$ver,$estado,$privacidad,$tipo,$usuario,$alumnon,$alumnoa,$mesiento,$estoy,$ilink){
	$script = pathinfo($_SERVER['PHP_SELF']); 
	$script = $script['basename'];
	if($script != "pod.php") {
		//bola de online
		$temp = disp($id,$ilink);
		if ($enlinea) {
			$bola = "<img class='noimprimir' src='" . MEDIA_URL . "/imag/on$temp.png' title=\"".i("enlinea",$ilink)."\">";
		} else {
			$bola = "<img class='noimprimir' src='" . MEDIA_URL . "/imag/off$temp.png' title=\"".i("nolin",$ilink)."\">";
		}
		if($mesiento) {
			$bola .= "<img class='ml5' src='". MEDIA_URL . "/emo/Em_$mesiento.svg' height='20'>";
		}
		//estrella para seguir o no
		$sigue = seguirono($id,$ilink); //2:no estoy siguiendo 1:si
		$div = "seg".$id;
		if($sigue == 2) {
			$star = "<a class='noimprimir' id='$div' href=\"javascript:llamarasincrono('socialseg.php?id=$id&seg=1','$div');\">
			<span class='icon-star-empty' alt=\"".i("seguir",$ilink)."\"></span></a>";
		} elseif($sigue == 1) {
			$star = "<a class='noimprimir' id='$div' href=\"javascript:llamarasincrono('socialseg.php?id=$id&seg=2','$div');\">
			<span class='icon-star-full txth' alt=\"".i("seguirno",$ilink)."\"></span></a>";
		}
	}
	//veo su nombre, con link o usuario?
	$pae = espae($tipo,$ilink);
	$esdr = esdoct($id,$ilink);
	$alumnon1 = "<span class='b'>".trim($alumnon)."</span>";
	$alumnoa1 = trim($alumnoa);
	if ($ver) {
		if($_SESSION['auto'] > 4 AND $privacidad) {$priv = "<span title=\"privacidad\" class='cabgris'>&nbsp;P </span> &nbsp;";}
		//Nombre y apellido con link
		$nom[0] = trim("$esdr $alumnon $alumnoa $pae");
		$nom[1] = trim("$priv $esdr #php1# $alumnon1 $alumnoa1 #php2# $pae");
	} elseif ($privacidad == 1) {
		//Nombre y apellido
		$nom[0] = trim("$esdr $alumnon $alumnoa $pae");
		$nom[1] = trim("$esdr $alumnon1 $alumnoa1 $pae");
	} else {
		//Usuario
		$nom[0] = trim("$esdr $usuario $pae");
		$nom[1] = trim("$esdr $usuario $pae");
	}	
	//Si es baja
	if ($esbaja) {
		$esba = i("usuborr",$ilink);
		$xesbaja[0] = "[$esba]";
		$xesbaja[1] = "<span title=\"$esba\" class='cabred'>&nbsp;B </span> &nbsp;";
	}
	//Si est&aacute; oculto
	if ($_SESSION['auto'] == 10 AND $estado) {
		$oculto = i("noconectado",$ilink);
		$xoculto[0] = "[$oculto]";
		$xoculto[1] = "<span title=\"$oculto\" class='cabgris'>&nbsp;O </span> &nbsp;";
	}
	$nombape[0] = $xesbaja[0]." ".$xoculto[0]." ".$nom[0];
	$nombape[1] = $star." ".$bola." ".$xesbaja[1]." ".$xoculto[1]." ".$nom[1];
	return $nombape;
}
// --------------------------------------------------

function sologenerico($grande) {
	$tam = "peq"; if ($grande == 2) {$tam = "med";}
	$temp = "<img src='" . MEDIA_URL . "/imag/nofoto.png' class='imagen on0 $tam foto-".$_SESSION['modofoto']."' title=\"".SITE."\">";
	$foto[0] = $temp;
	$foto[1] = SITE;
	return $foto;
}

// --------------------------------------------------
function foto($foto)
{

$filename=DATA_DIR . "/fotos/$foto"; 

if (!is_file($filename)) {return;}
list($w, $h, $type, $attr) = getimagesize($filename);	
$src_im = imagecreatefromjpeg($filename);

if(!$src_im) {return;}

//coger una porcion cuadrada x=y

if($w > $h) {
	$dst_im = imagecreatetruecolor($h,$h);
	$ox = (($w-$h)/2);
	$dw = $dh = $h;
	imagecopyresampled($dst_im, $src_im, 0, 0, $ox, 0, $h, $h, $h, $h);
	$src_im = $dst_im;
	$dst_im = imagecreatetruecolor(240,240);
} else {
	$dst_im = imagecreatetruecolor($w,$w);
	$oy = (($h-$w)/2);
	$dw = $dh = $w;
	imagecopyresampled($dst_im, $src_im, 0, 0, 0, $oy, $w, $w, $w, $w); 
	$src_im = $dst_im;
	$dst_im = imagecreatetruecolor(240,240);
}

// Cambiar el tamaño

imagecopyresized($dst_im, $src_im, 0, 0, 0, 0, 240, 240, $dw, $dw);
imagejpeg($dst_im,DATA_DIR . '/fotos/2'.$foto,100); 

$dst_im = imagecreatetruecolor(64,64);
imagecopyresized($dst_im, $src_im, 0, 0, 0, 0, 64, 64, $dw, $dw);
imagejpeg($dst_im,DATA_DIR."/fotos/1".$foto,100); 

}

// --------------------------------------------------

function fotomedi($id, $foto, $ver, $enlinea, $sexo, $grande) {
    $tam = "peq"; if ($grande == 2) { $tam = "med"; }

    // ¿Existe físicamente la foto privada?
    $rel = $grande . $foto; // p.ej. "1foto23.png"
    $path = DATA_DIR . "/fotos/" . $rel;
    $has = ($foto && $ver && is_file($path));

    // Siempre pasamos el sexo; solo pasamos "f" si existe archivo
    $qs = "s=" . urlencode(strtolower((string)$sexo));
    if ($has) { $qs .= "&f=" . urlencode($rel); }

    $src  = APP_URL . "/avatar.php?" . $qs;
    $modo = $_SESSION['modofoto'] ?? 'normal';

    return "<img src='" . $src . "&v=" . rand(1,1000) . "' class='imagen on$enlinea $tam foto-$modo' title=\"#title#\">";
}


// --------------------------------------------------

function esdoct($id,$ilink) {
	$sql = "SELECT sexo, doctor, privacidad FROM profcurareafigura";
	$sql .= " LEFT JOIN usuarios ON profcurareafigura.profeid = usuarios.id ";
	$sql .= " WHERE id = '$id' AND tipo = 'P' AND profcurareafigura.curso = '".$_SESSION['curso']."'";
	$result = $ilink->query($sql);
	if (!$result) {return;}	
	$f = $result->fetch_array(MYSQLI_BOTH);
	if ($f[1] AND $f[2] < 2) {
		if ($f[0]=="h") {return 'Dr. ';}
		if ($f[0]=="m") {return 'Dra. ';}
	}
}

// --------------------------------------------------

function espae($tipo,$ilink) {
	if ($tipo == "P") {return "[".i("profesor",$ilink)."]";}
	if ($tipo == "A") {return "[".i("alumno",$ilink)."]";}
	if ($tipo == "E") {return "[".i("externo",$ilink)."]";}
}

// --------------------------------------------------

function estaenlinea($id,$f) {
	
	if (!$id || !$f['fecha']) return 0;

	if (demo_enabled() && in_array((int)$id, DEMO_ONLINE_IDS, true)) {return 1;}
	
	$dif = time() - strtotime($f['fecha']); // Ambos en UTC
	if ($dif < 0 || $dif >= 30) return 0;  //era$dif < 1 pero asi no se veia uno mismo en linea
	if (!$f['estado'] || $_SESSION['soy_superadmin']) return 1;
	if ($_SESSION['auto'] > $f['autorizado']) return 1;

	return 0;

	
	
	extract($f);
	if (!$id OR $f['fechax'] < 1 OR $f['fechax'] >= 30){return 0;}
	if (!$f['estado'] OR $_SESSION['soy_superadmin']) {return 1;}
	if ($_SESSION['auto'] > $f['autorizado']) {return 1;}
	return 0;
}

// --------------------------------------------------

function seguirono($id,$ilink) {
	if ($id == $_SESSION['usuid'] OR !$id) {return;}
	$yo = $_SESSION['usuid'];
	$sql = "SELECT * FROM message_usus WHERE (usuid = '$id' AND parausuid = '$yo' AND usuid1 = '-1') OR (usuid = '$yo' AND parausuid = '$id' AND parausuid1 = '-1')";	
	$result = $ilink->query($sql);
	if (!$result->num_rows) {return 2;} else{return 1;}
}

// --------------------------------------------------

// Asignaturas que ve en apartado Compartir
function cadmisasig($ilink) {
	if ($_SESSION['auto'] < 5) {
		$sql = "SELECT tit, alumasiano.asigna, alumasiano.curso, grupo FROM alumasiano LEFT JOIN podcursoasignatit ON alumasiano.asigna = podcursoasignatit.asigna AND
		alumasiano.curso = podcursoasignatit.curso WHERE id = '".$_SESSION['usuid']."' AND auto > 3";
	} else {
		$sql = "SELECT tit, asignatprof.asigna, asignatprof.curso, grupo FROM asignatprof LEFT JOIN podcursoasignatit ON asignatprof.asigna = podcursoasignatit.asigna AND
		asignatprof.curso = podcursoasignatit.curso WHERE usuid = '".$_SESSION['usuid']."'";
	}
	$result = $ilink->query($sql);
	$cadmisasig[0] = "#";
	$cadmisasig[1] = "#";
	while ($fila = $result->fetch_array(MYSQLI_BOTH)) {
		extract($fila);
		$cadmisasig[0] .= $asigna."$$".$curso."$$".$grupo."#";
		if (!strstr($cadmisasig[1],"#".$tit."$$".$curso."#")) {$cadmisasig[1] .= $tit."$$".$curso."#";}
	}
	if ($cadmisasig[0] == "#") {$cadmisasig[0] = "#$#";}
	if ($cadmisasig[1] == "#") {$cadmisasig[1] = "#$#";}
	return $cadmisasig;
}

// --------------------------------------------------

function elegirasicurgru($asigna,$curso,$grupo,$ilink) {

	$temp = "";
	if (esmio($asigna,"","",$ilink)) {
		$temp = " AND asigna = '$asigna'";
	}

	if ($_SESSION['tipo'] == "A") {
		$sql = "SELECT asigna, curso, grupo FROM alumasiano WHERE id = '".$_SESSION['usuid']."' $temp  AND auto > 1";
	} elseif ($_SESSION['tipo'] == "P") {
		$sql = "SELECT asigna, curso, grupo FROM asignatprof WHERE usuid = '".$_SESSION['usuid']."' $temp";
	} elseif ($_SESSION['auto'] == 10) {
		$sql = "SELECT asigna, curso, grupo FROM asignatprof WHERE 1=1 $temp";
	}

	if (!$sql) {return;}
	
	$result = $ilink->query($sql);
	if (!$result) {return;}
	$filas = $result->num_rows;
	if (!$filas) {return;}
	$result->data_seek($filas-1);
	$fila = $result->fetch_array(MYSQLI_BOTH);
	if (!existe($fila[0],$fila[1],$fila[2],$ilink)) {
		$asicurgru[0] = "";
		$asicurgru[1] = "";
		$asicurgru[2] = "";
	} else {
		$asicurgru[0] = $fila[0];
		$asicurgru[1] = $fila[1];
		$asicurgru[2] = $fila[2];
	}
	return $asicurgru;

}

// --------------------------------------------------

function nomb1($id,$ilink) {
	$iresult = $ilink->query("SELECT privacidad, usuario, alumnon, alumnoa, tipo FROM usuarios WHERE id = '$id' LIMIT 1");
	$f = $iresult->fetch_array(MYSQLI_BOTH);
	if (!$f) {return;}
	$esdr = esdoct($id,$ilink);
	if ($f[0] == 2) {return "$f[1] ".espae($f[4],$ilink);}
	return $esdr."$f[2] $f[3] ".espae($f[4],$ilink);
}

// --------------------------------------------------

function esprofdeid($id,$ilink) {
	$result = $ilink->query("SELECT asigna, curso, grupo FROM alumasiano WHERE id = '$id'");
	while ($fila = $result->fetch_array(MYSQLI_BOTH)) {
		extract($fila);
		if (esprofesor($asigna,$curso,$grupo,$ilink) OR soyadmiano($asigna,$curso,$ilink)) {
			return 1;
		}
	}
}

// --------------------------------------------------

function existe($asigna,$curso,$grupo,$ilink) {
	$sql = "SELECT asigna FROM asignatprof WHERE asigna = '$asigna' AND curso = '$curso' AND grupo = '$grupo'";
	$iresult = $ilink->query($sql);
	if (!$iresult->num_rows) {return 0;}
	return 1;
}

// --------------------------------------------------

function esalumnodetit($tit,$curso,$ilink) {
	if ($curso == "*") {$curso = "";}
	$sql = "SELECT alumasiano.asigna FROM alumasiano LEFT JOIN podcursoasigna 
	ON podcursoasigna.asigna=alumasiano.asigna AND podcursoasigna.curso=alumasiano.curso 
	LEFT JOIN podcursoasignatit ON podcursoasignatit.curso=podcursoasigna.curso
	AND podcursoasignatit.asigna=podcursoasigna.asigna
	WHERE alumasiano.id='".$_SESSION['usuid']."' AND podcursoasignatit.tit='$tit' 
	AND alumasiano.curso='$curso'";
	$iresult = $ilink->query($sql);
	if ($iresult->num_rows) {return 1;}
}

// --------------------------------------------------

function esadmidetit($tit,$curso,$ilink) {
	if (!$tit) {return 0;}
	if ($_SESSION['auto'] == 10) {return 1;}
	if ($curso == "*") {$curso = "";}
	$sql = "SELECT usuid FROM titcuradmi WHERE titulaci = '$tit' AND curso = '$curso' AND usuid ='".$_SESSION['usuid']."'";
	$iresult = $ilink->query($sql);
	if ($iresult->num_rows) {return 1;}
}

// --------------------------------------------------

function esadmidetit1($tit,$curso,$usuid,$ilink) {
	if (!$tit) {return 0;}
	if ($curso == "*") {$curso = "";}
	$sql = "SELECT usuid FROM titcuradmi WHERE titulaci = '$tit' AND curso = '$curso' AND usuid ='$usuid'";
	$iresult = $ilink->query($sql);
	if ($iresult->num_rows) {return 1;}
	$sql = "SELECT autorizado FROM usuarios WHERE id = '$usuid' AND autorizado = '10' LIMIT 1";
	$iresult = $ilink->query($sql);
	if ($iresult->num_rows) {return 1;}
}

// --------------------------------------------------

function esalumno($asigna,$curso,$grupo,$ilink) {
	if ($_SESSION['auto'] == 10) {return 1;} 
	if ($curso == "*") {$curso="";}
	if ($grupo == "*") {$grupo="";}
	$sql = "SELECT id FROM alumasiano WHERE auto > 1 AND id = '".$_SESSION['usuid']."' AND asigna = '$asigna' AND curso = '$curso' AND grupo = '$grupo'";
	$result = $ilink->query($sql);
	if ($result->num_rows > 0) {return 1;}
}

// --------------------------------------------------

function esalumno1($asigna,$curso,$grupo,$ilink,$usuid) {
	//if ($_SESSION['auto'] == 10) {return 1;} 
	if ($curso == "*") {$curso="";}
	if ($grupo == "*") {$grupo="";}
	$sql = "SELECT id FROM alumasiano WHERE auto > 1 AND id = '$usuid' AND asigna = '$asigna' AND curso = '$curso' AND grupo = '$grupo'";
	$result = $ilink->query($sql);
	if ($result->num_rows > 0) {return 1;}
}

// --------------------------------------------------

function esprofesordetit($tit,$curso,$ilink) {
	if (!$tit) {return 0;}
	if ($_SESSION['auto'] == 10) {return 1;} 
	if ($curso == "*") {$curso = "";}
	$sql = "SELECT usuid FROM titcuradmi WHERE titulaci = '$tit' AND curso = '$curso' AND usuid ='".$_SESSION['usuid']."'";
	$iresult = $ilink->query($sql);
	if ($iresult->num_rows) {return 1;}
	$sql = "SELECT usuid FROM asignatprof LEFT JOIN podcursoasignatit
		ON asignatprof.asigna = podcursoasignatit.asigna AND asignatprof.curso = podcursoasignatit.curso 
		WHERE tit='$tit' AND asignatprof.curso='$curso' AND usuid = '".$_SESSION['usuid']."'";
	$iresult = $ilink->query($sql);
	if ($iresult->num_rows) {return 1;}
}

// --------------------------------------------------

function soyadmiano($asigna,$curso,$ilink) {
	//si soy adm del master en un a&ntilde;o X, soy su administrador 
	if ($_SESSION['auto'] < 5) {return 0;}
	if ($_SESSION['auto'] == 10) {return 1;}
	if (!$asigna) {return 0;}
	if ($curso == "*") {$curso="";}
	$sql = "SELECT usuid FROM podcursoasignatit LEFT JOIN titcuradmi
	ON titcuradmi.titulaci=podcursoasignatit.tit AND titcuradmi.curso=podcursoasignatit.curso
	WHERE usuid = '".$_SESSION['usuid']."'
	AND podcursoasignatit.asigna = '$asigna'";
	if ($curso) {$sql .= " AND titcuradmi.curso = '$curso'";}
	$iresult = $ilink->query($sql);
	if ($iresult->num_rows) {return 1;}
}

// --------------------------------------------------

function esmio($asigna,$curso,$grupo,$ilink) {
	if ($_SESSION['auto'] == 10) {return 1;}
	if (esprofesor($asigna,$curso,$grupo,$ilink)) {return 1;}
	if (esalumno($asigna,$curso,$grupo,$ilink)) {return 1;}
	if (soyadmiano($asigna,$curso,$ilink)) {return 1;}
}

// --------------------------------------------------

function esmiotitul($tit,$curso,$ilink) {
	if ($_SESSION['auto'] == 10) {return 1;}
	if (esprofesordetit($tit,$curso,$ilink)) {return 1;}
	if (esalumnodetit($tit,$curso,$ilink)) {return 1;}
}

// --------------------------------------------------

function esprofesor($asigna,$curso,$grupo,$ilink) {
	if ($_SESSION['auto'] == 10) {return 1;}
	if ($curso == "*") {$curso="";}
	if ($grupo == "*") {$grupo="";}
	$sql = "SELECT usuid FROM asignatprof WHERE asigna = '$asigna' AND curso = '$curso' AND grupo = '$grupo' AND usuid = '".$_SESSION['usuid']."'";
	$result = $ilink->query($sql);
	if ($result->num_rows > 0) {return 1;}
}

// --------------------------------------------------

function idesprofesor($id,$asigna,$curso,$grupo,$ilink) {
	//if ($_SESSION['auto'] == 10) {return 1;}
	if ($curso == "*") {$curso="";}
	if ($grupo == "*") {$grupo="";}
	$sql = "SELECT usuid FROM asignatprof WHERE asigna = '$asigna' AND curso = '$curso' AND grupo = '$grupo' AND usuid = '$id'";
	$result = $ilink->query($sql);
	if ($result->num_rows > 0) {return 1;}
}

// --------------------------------------------------

function disp($id,$ilink) {
	$iresult = $ilink->query("SELECT tipo FROM usuarios WHERE id = '$id' LIMIT 1");
	$tipo = $iresult->fetch_array(MYSQLI_BOTH);
	if ($tipo[0] == "A") {	
		$iresult = $ilink->query("SELECT disponible FROM alumasiano WHERE id = '$id' AND asigna = '".$_SESSION['asigna']."' AND curso = '".$_SESSION['curso']."' AND grupo = '".$_SESSION['grupo']."'");
		$disp = $iresult->fetch_array(MYSQLI_BOTH);
	}
	if ($tipo[0] == "P") {	
		$iresult = $ilink->query("SELECT disponible FROM asignatprof WHERE usuid = '$id' AND asigna = '".$_SESSION['asigna']."' AND curso = '".$_SESSION['curso']."' AND grupo = '".$_SESSION['grupo']."'");
		$disp = $iresult->fetch_array(MYSQLI_BOTH);
	}
	if($disp[0]) {return "no";}
}

// --------------------------------------------------

function minom($nom,$ape,$ilink) {

	$id = $_SESSION['usuid'];
	$iresult = $ilink->query("SELECT alumnon, alumnoa FROM usuarios WHERE id = '$id' LIMIT 1");
	$f = $iresult->fetch_array(MYSQLI_BOTH);
	$esdr = esdoct($id,$ilink);
	if ($nom) {$ret = trim($f[0]);}
	if ($ape) {$ret .= " ".trim($f[1]);}
	return $esdr.$ret; 

}

// --------------------------------------------------

?>