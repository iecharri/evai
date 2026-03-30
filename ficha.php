<?php

require_once __DIR__ . '/siempre.php';
require_once APP_DIR . '/perfil/accionesfp.php';

extract($_POST);
extract($_GET);

if (!$_SESSION['usuid']) {return;}

if (!$usuid) {$usuid = $_SESSION['usuid'];}

// --------------------------------------------------

require_once APP_DIR . "/perfil/personaliz1.php";

// --------------------------------------------------

$tamanomax = 750; //400;
if ($_SESSION['auto'] == 5) {$tamanomax = 750;} //400
if ($_SESSION['auto'] < 5) {
	$tamanomax = 3;
	if ($_SESSION['tipo'] == "A") {$tamanomax = 80;}
}

if ($_POST['norecordardatos'] OR $_POST['regis'] OR (($_POST['desborrar'] OR $_POST['borrar'] OR $_POST['profes']) AND $_SESSION['auto'] > 4)) {
	require_once APP_DIR . '/ficha1.php'; $op="";
}

$iresult = $ilink->query("SELECT * FROM usuarios WHERE id = '$usuid' LIMIT 1");
if (!$iresult) { echo "Error SQL: " . $ilink->error; return; }
$f = $iresult->fetch_array(MYSQLI_BOTH);
extract($f);

// --------------------------------------------------

if (!$f) {return;}

if ($_SESSION['auto'] < 10 AND $f['fechabaja'] != "0000-00-00 00:00:00") {return;}

if ($_SESSION['mipriv'] && $usuid != $_SESSION['usuid']) {
	echo "<h3>Cambia tu privacidad para poder ver otros perfiles</h3>";
	return;
}

if($f['privacidad'] && $usuid != $_SESSION['usuid'] && $_SESSION['auto'] < 5) {
 	echo "<h3>El usuario no permite ver su ficha</h3>";
 	return;
}

$fechabaja = $f['fechabaja'];

if ($usuid == $_SESSION['usuid'] AND $f['fechabaja'] != '0000-00-00 00:00:00') {
	echo "<p><br></p><h3 class='rojo'>$nombreborr<p></p>".i("usuborr",$ilink).".</h3><p><br></p></body></html>";
	session_unset();
	session_destroy();
	exit;
}

// --------------------------------------------------

if (!$op) {$op = 1;}
if ($op == 1 AND $pest == 2) {$body = " onload = \"document.form1.alumnon.focus();\"";}
if ($op == 7 AND $_SESSION['auto'] == 10) {$body = " onload = \"document.form1.autorizado.focus()\"";}

// --------------------------------------------------

if($usuid == $_SESSION['usuid']) {
	if($no_geo) {$ilink->query("UPDATE usuarios SET geo = '' WHERE id='".$_SESSION['usuid']."'");}
	$result = $ilink->query("SELECT geo FROM usuarios WHERE id = '$usuid'");
if (!$result) { echo "Error SQL: " . $ilink->error; return; }
	$fila = $result->fetch_array(MYSQLI_BOTH);
	if ($op == 1 AND ($fila[0] OR $_POST['myInputLatitud'])) {
		//$body = "onload='cargarmap()'";
	}
} elseif($op == 1) {
	//$body = "onload='cargarmap()'";
}

// --------------------------------------------------

require_once APP_DIR . '/molde_top.php';

// --------------------------------------------------

/*if ($_POST['porsms']) {
	require_once APP_DIR . '/smsencoded.php';
	$smsmens[0][0] = encoded($_POST['tfmovil']);$smsmens[0][1] = "Mensaje de ".minom(1,1,$ilink).": ".trim($_POST['textosms']).". Servicio de Human Site";
	$smsmens = urlencode(serialize($smsmens));
	$onload = "onload = \"".porsms($smsmens)."\"";
	if ($onload) {$enviosms = 1;}
}*/

// --------------------------------------------------

$param = "usuid=$usuid&op=$op&pest=$pest";

// --------------------------------------------------

unset($array);

if ($op == 1) {
	require_once APP_DIR . '/perfil/fichaverper.php';
}

if ($op == 3 AND $veopasswd) {
	require_once APP_DIR . '/perfil/fichaeditar.php';
}

if ($op == 4) {
	require_once APP_DIR . '/perfil/unmens.php';
	require_once APP_DIR . '/perfil/mensajes.php';
}


if ($op == 5 AND $usuid == $_SESSION['usuid']) { 
	require_once APP_DIR . '/perfil/personaliz.php';return;
}

if ($op == 7 AND $veo > 2) {require_once APP_DIR . '/perfil/permisos.php';}

if ($op == 8 AND $veo > 2) {
	$param = "usuid=".trim($usuid)."&op=$op";
	require_once APP_DIR . '/soloprof/mailssist.php';
}

if ($op == 9) {
	require_once APP_DIR . '/perfil/activiusu.php';
}

if ($op == 10 AND $usuid != $_SESSION['usuid']) {
	require_once APP_DIR . '/perfil/susasigna.php';
}

if ($op == 11 AND $veo > 1) {
	if (!$pest) {$pest = 1;}
	//$array[] = "<a href='?usuid=$usuid&op=$op'>".i("calific",$ilink)."</a>";
	if (!isset($array) || !is_array($array)) $array = [];
	$array[] = "<a href='?usuid=$usuid&op=$op'>".i("calific",$ilink)."</a>";
	if ($veo > 2 AND $asigna) {
		if($pest > 1) {
		$array[] = "<a href='?usuid=$usuid&op=$op&pest=2&asigna=$asigna&curso=$curso&grupo=$grupo&conv=$conv'>"."Nota $asigna $curso $grupo ".substr($conv,0,-1)."</a>";    //substr($conv,0,strlen($conv-1))."</a>";
		}		
		if ($pest == 3) {
			$array[] = "<a href='?usuid=$usuid&op=$op&pest=2&asigna=$asigna&curso=$curso&grupo=$grupo&conv=$conv&pest=3'>"."Mensaje"."</a>";
		}
	}

	if($_SESSION['auto'] > 4) {	
		solapah($array,$pest,"navhsimple");
	}
		
	if ($pest == 1) {
		require_once APP_DIR . '/perfil/calificaciones.php';
	} elseif($veo > 2 AND $asigna) {
		if ($pest == 2) {
			require_once APP_DIR . '/notas1.php';
		} elseif ($pest == 3) {
			require_once APP_DIR . '/1notamail.php';
		}	
	}
}

if ($op == 14 AND $veo > 2) {
	require_once APP_DIR . '/perfil/fichaveraca.php';
}

if ($op == 15) {
	require_once APP_DIR . '/perfil/gmail.php';
}

if ($op == 16) {
	require_once APP_DIR . '/perfil/socialmgnmg.php';
	require_once APP_DIR . '/perfil/social.php';
}


if ($op == 17) {
	if ($bofoto) {
		bofoto($bofoto,$ilink);
	}
	if ($verfoto) {
		if ($usuid == $_SESSION['usuid']) {
			grandefoto($verfoto,$_SESSION['usuid'],$ilink);
		} else {
			grandefoto($verfoto,$usuid,$ilink);
		}
	} else {
		if ($usuid == $_SESSION['usuid']) {
			thumbfotos($_SESSION['usuid'],$ilink);
		} else {
			thumbfotos($usuid,$ilink);
		}
	}
}

if ($op == 18) {
	if ($usuid != $_SESSION['usuid']) {
		echo "<div class='fl col-5'>";
		thumbamigos($amigosusuid1,i("siguea",$ilink),$ilink);
		echo "</div><div class='fl col-5'>";
		thumbamigos($amigosusuid2,i("lesiguen",$ilink),$ilink);
		echo "</div>";
	} else {
		echo "<div class='fl col-5'>";
		thumbamigos($amigosyo1,i("sigoa",$ilink),$ilink);
		echo "</div><div class='fl col-5'>";
		thumbamigos($amigosyo2,i("mesiguen",$ilink),$ilink);
		echo "</div>";
	}
}

if ($op == 19 AND $veocarpeta) {
	require_once APP_DIR . '/perfil/micarpeta.php';
}

if ($op == 20) {
	require_once APP_DIR . '/bancot/usu.php';
}

/*if ($op == 21 AND $veo > 2 AND $usuid == $_SESSION['usuid']) {
	require_once APP_DIR . '/perfil/autograb1.php';
}*/

if ($op == 22 AND esprofdeid($usuid,$ilink)) {
	require_once APP_DIR . '/perfil/anotaciones.php';
}

if ($op == 23 AND $_SESSION['auto'] > 4) {
	require_once APP_DIR . '/perfil/anotaciones1.php';
}

if ($op == 24 AND $veopasswd) {

	
	require_once APP_DIR . '/perfil/cambpass.php';
}

require_once APP_DIR .  '/molde_bott.php';	

// --------------------------------------------------

function crearcarpasignat($usuid,$dirini,$ilink) {
	$sql = "SELECT asigna,curso,grupo FROM alumasiano WHERE id = '$usuid'";
	$result = $ilink->query($sql);
if (!$result) { echo "Error SQL: " . $ilink->error; return; }
	while ($fila = $result->fetch_array(MYSQLI_BOTH)) {
		extract($fila);
		if (!$asigna) {return;} 
 		//crear carpeta
		$carpeta = $dirini."profesor/".$asigna;
		if ($curso) {$carpeta .= "$$".$curso;}
		if ($grupo) {$carpeta .= "$$".$grupo;}
		if (!is_dir($carpeta)) { 
			safe_mkdir($carpeta,0750);
		}
	}
	return;
}

?>

