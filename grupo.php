<?php

require_once __DIR__ . '/siempre.php';

extract($_POST);
extract($_GET);

if (!$_SESSION['usuid']) {return;}

extract($_GET);
$sql = "SELECT * FROM grupos WHERE id = '$grupoid' LIMIT 1";
$result = $ilink->query($sql);
$fila = $result->fetch_array(MYSQLI_BOTH);
if (!$grupoid OR $_SESSION['auto'] < 2 OR !$fila) {exit;}

$dirini = DATA_DIR."/grupos/".$fila['grupo']."/";
if (!is_dir($dirini)) {safe_mkdir($dirini,0750);}
$dirini = DATA_DIR ."/grupos/".$fila['grupo']."/";
$carpeta = $dirini."public/";
if (!is_dir($carpeta)) {safe_mkdir($carpeta,0750);}
$carpeta = $dirini."public/pics/";
if (!is_dir($carpeta)) {safe_mkdir($carpeta,0750);}
$carpeta = $dirini."public/video/";
if (!is_dir($carpeta)) {safe_mkdir($carpeta,0750);}

// --------------------------------------------------

extract($fila);

require_once APP_DIR . '/molde_top.php';

if (!$pest) {$pest = 1;}

// --------------------------------------------------

require_once APP_DIR . '/gruposrecuento.php';

if ($_GET['mvisi']) {
	mensvisig($_GET['mvisi'],$ilink);
}

if ($_GET['minvisi']) {
	mensinvisig($_GET['minvisi'],$ilink);
}

// --------------------------------------------------

$array = array();

$array[] = "<a href='grupo.php?grupoid=$grupoid'>".i("grupo",$ilink)." <span class='b'>$grupo</span>&nbsp; <span class='icon-arrow-right'></span></a>";
$array[] = "<a href=?pest=1&grupoid=$grupoid>Integrantes</a>";
if (esmigrupo($grupoid,$_SESSION['usuid'],$ilink)) {
	$array[] = "<a href=?pest=2&grupoid=$grupoid>".i("foro",$ilink)."</a>";
	$array[] = "<a href=?pest=3&grupoid=$grupoid>Carpeta del grupo</a>";
	$array[] = "<a href=?pest=4&grupoid=$grupoid>Links</a>";
	$esmigrupo = 1;
}
if ($grupoid AND $_GET['id']) {
	if ($pest == 2) {
		$array[] = "<a href='#'>".i("mensaje",$ilink)."</a>";
		$pest = 5;
	} else {
		$array[] = "";
	}
	if ($pest == 4) {
	$array[] = "Link";
	$pest = 6;
	}
} else {
	$array[] = "";
	$array[] = "";
}

if ($esmigrupo == 1) {
	$array[] = "<a href=?pest=5&grupoid=$grupoid&editarf=1>".i("grupomodiff",$ilink)."</a>";
	if ($editarf) {$pest = 7;}
}

// --------------------------------------------------

solapah($array,$pest+1,"navhsimple");echo "<br>";

// --------------------------------------------------

if ($pest == 1) {require_once APP_DIR . '/grupolista.php';}

if (($pest == 2 OR $pest == 5) AND $esmigrupo) {require_once APP_DIR . '/grupoforo.php';}

if ($pest == 3 AND $esmigrupo) {
	$iresult = $ilink->query("SELECT grupo from grupos WHERE grupos.id = '$grupoid'");
	$temp = $iresult->fetch_array(MYSQLI_BOTH);
	$dirini = DATA_DIR . "/grupos/$temp[0]/";
	if (!is_dir($dirini."profesor/")){
		safe_mkdir($dirini."profesor/");
	}
	$param = "grupoid=$grupoid&pest=3";
	$script = "grupo.php?$param";
	$fichphp = APP_URL . "/file.php?n=".base64_encode($dirini);
	$puedounzip = 0; if ($_SESSION['auto'] > 4) {$puedounzip = 1;}
	require_once APP_DIR . '/explorernue.php';
}

if (($pest == 4 OR $pest == 6) AND $esmigrupo) {require_once APP_DIR . '/grupolinks.php';}

if ($pest == 7 AND $esmigrupo) {require_once APP_DIR . '/grupofeditar.php';}

require_once APP_DIR . '/molde_bott.php';	

// --------------------------------------------------

function grupo1($id,$ilink) {

	$sql = "SELECT * FROM grupos WHERE id = '$id' LIMIT 1";
	$result = $ilink->query($sql);
	if ($result->num_rows < 1) {return;}
	$fila = $result->fetch_array(MYSQLI_BOTH);
	if (!$fila) {return;}
	extract($fila);
	$g[0] = "$grupo";
	if ($asigna) { $g[1] = i("grupocerr",$ilink)."<span class='b'>$asigna</span>";} else {$g[1] = i("grupoabierto",$ilink);}
	return $g;

}

function esmigrupo($grupoid,$uid,$ilink) {
	$iresult = $ilink->query("SELECT grupo FROM grupos LEFT JOIN gruposusu ON gruposusu.grupo_id = grupos.id WHERE usu_id = '$uid' AND id = '$grupoid'");
	$fila = $iresult->num_rows;
	if ($fila) {return 1;}
	$iresult = $ilink->query("SELECT asigna FROM grupos WHERE id = '$grupoid' LIMIT 1");
	$fila = $iresult->fetch_array(MYSQLI_BOTH);
	if (soyprofde($fila[0],$ilink)) {return 1;} else {return 0;}
}

function soyprofde($asigna,$ilink) {
	if ($_SESSION['auto'] < 5) {return 0;}
	if ($_SESSION['auto'] == 10 OR !$asigna) {return 1;}
	$sql = "SELECT usuid FROM asignatprof WHERE asigna = '$asigna' AND usuid = '".$_SESSION['usuid']."'";
	$result = $ilink->query($sql);
	if ($result->num_rows > 0) {return 1;}
}

//Invisibilizar un mensaje
function mensinvisig($id,$ilink) {
	$ilink->query("UPDATE forogrupos SET invisible=2 WHERE id='$id' LIMIT 1");
}

//Visibilizar un mensaje
function mensvisig($id,$ilink) {
	$ilink->query("UPDATE forogrupos SET invisible=0 WHERE id='$id' LIMIT 1");
}

?>
