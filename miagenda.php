<?php

require_once __DIR__ . '/siempre.php';

if (!$ag) {$ag = gmdate('Y-m');}
$titasi = $_SESSION['titasi'];

// --------------------------------------------------

$a_agend = " class = 'active'";

require_once APP_DIR . '/molde_top.php';

// --------------------------------------------------

if ($_GET['id']) {
	if ($_SESSION['auto'] > 4) {
		$iresult = $ilink->query("SELECT titulaci, asigna, curso, grupo FROM noticias WHERE id = '$id' LIMIT 1");
		$fila = $iresult->fetch_array(MYSQLI_BOTH);
		extract($fila);
		$titulo = i("agedit",$ilink)." ";
		if ($fila['titulaci']) {
			$titulo .= i("titul",$ilink).": ".$fila['titulaci'];
		} elseif ($fila['asigna']) {
			$titulo .= i("asigna",$ilink).": ".$fila['asigna'];
		} else {
			$titulo .= i("notapers",$ilink);
		}		
		if ($fila['curso'] AND $fila['curso'] != "*") {$titulo .= " - ".$fila['curso'];}		if ($fila['asigna'] AND $fila['grupo'] AND $fila['grupo'] != "*") {$titulo .= " - ".$fila['grupo'];}
	}
	if (!$titulo) {$titulo = i("agedit",$ilink)." ".i("notapers",$ilink);}
	wintot1("miagenda1.php",'',"div1",$titulo,'',$ilink);
}

// --------------------------------------------------

$vacio = 1;
require_once APP_DIR . '/selectitasi.php';

$asig = $_SESSION['asigna'];

//construyo la cabecera de la tabla
echo "<a href=?ag=$calen[0]&$param";
if ($g) {echo "&g=1";}
echo "><span class='icon-arrow-left grande' title=\"".i("agmes1",$ilink)."\"></span></a>";
echo " <a href=?ag=".gmdate("Y-m")."&$param";
if ($g) {echo "&g=1";}
echo "> &nbsp; <span class='icon-calendar grande' title=\"".i("agmesactu",$ilink)."\"></span> <span class=' b'>".ifecha31($calen[1],$ilink)."</span></a>";
echo " <a href=?ag=$calen[2]&$param";
if ($g) {echo "&g=1";}
echo "> &nbsp; ";
echo "<span class='icon-arrow-right grande' title=\"".i("agmes2",$ilink)."\"></span></a>";
echo " <a href='?accion=anadir&ag=$ag&$param'> &nbsp; ";
echo "<span class='icon-pencil2 grande' title=\"".i("aganadir1",$ilink)."\"></span></a> &nbsp; ";
if (!$_GET['g']) {
	echo " <a href='?ag=".rtrim($ag);
	echo "&$param&g=1";
	echo "'><span class='icon-zoom-in grande estoy' title=\"".i("agampliar",$ilink)."\"></span></a>";
} else {
	echo " <a href='?ag=".rtrim($ag);
	echo "&$param'><span class='icon-zoom-out grande estoy' title=\"".i("agreducir",$ilink)."\"></span></a>";
}

echo "<br>";

if ($g) {$a = "10";} else {$a = '4';}

echo "<div class='fl col-$a'>";
	calendario($ag,$g,$arraymes,$titasi,$asist,$ilink);
echo "</div>";

if (!$_GET['g']) {
	echo "<div class='col-6 fl'>";
	agenda($ag,$arraymes,$g,$param,$ilink);
	echo "</div>";
}

// --------------------------------------------------

if ($accion == "anadir") {
	if ($_SESSION['auto'] > 4) {
		$x = 0;
		$titulo = i("aganadiendo",$ilink)." ";
		if ($_SESSION['titasi'] == "1"){
			$titulo .= i("titul",$ilink).": ".$_SESSION['tit']; $x = 1;
		} elseif ($_SESSION['titasi'] == "2"){
			$titulo .= i("asigna",$ilink).": ".$_SESSION['asigna']; $x = 1;
		} else {
			$titulo .= i("notapers",$ilink);
		}
		if ($x > 0 AND $_SESSION['curso'] AND $_SESSION['curso'] != "*") {$titulo .= " - ".$_SESSION['curso'];}		if ($x > 0 AND $_SESSION['asigna'] AND $_SESSION['grupo'] AND $_SESSION['grupo'] != "*") {$titulo .= " - ".$_SESSION['grupo'];}
	}
	if (!$titulo) {$titulo = i("aganadiendo",$ilink)." ".i("notapers",$ilink);}
	wintot1("miagenda1.php",'',"div1",$titulo,'',$ilink);
}

// --------------------------------------------------

require_once APP_DIR .  "/molde_bott.php";

function quitabarra($x) {return stripslashes($x);}

?>