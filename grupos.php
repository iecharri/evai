<?php

require_once __DIR__ . '/siempre.php';

$accion = $_GET['accion'];

if ($accion == 'salir' OR $accion == 'entrar' OR $accion == 'crear') {$onload = "document.grupo.grupotrab.focus();";}
if ($_GET['modif']) {$onload = "document.grupo.eslogan.focus();";}

$ord = $_GET['ord'];

if (!$accion) {$solap=1;}
if ($accion == $_SESSION['usuid']) {$solap=2;}
if ($accion == 'crear') {$solap=3;}
if ($accion == 'entrar') {$solap=4;}
if ($accion == 'salir') {$solap=5;}
if ($accion == 'tod') {$solap=6;}

// --------------------------------------------------

$titpag = "<span class='icon-make-group'></span> ".i("grupos",$ilink);
$a_grupo = " class = 'active'";
require_once APP_DIR . "/molde_top.php";

unset($array);
$array = array();

$array[] = "<a href='grupos.php'>$titpag <span class='icon-arrow-right'></span></a>";
$array[] = "<a href='?ord=$ord'>".ucfirst(i("grupos1",$ilink))."</a>"; //grtittod
$array[] = "<a href='?accion=".$_SESSION['usuid']."&ord=$ord'>".i("grtitmis",$ilink)."</a>";
$array[] = "<a href='?accion=crear'>".i("grtitcre",$ilink)."</a>";
$array[] = "<a href='?accion=entrar'>".i("grtitent",$ilink)."</a>";
$array[] = "<a href='?accion=salir'>".i("grtitsal",$ilink)."</a>";
if ($_SESSION['auto'] == 10) {$array[] = "<a href='?accion=tod'>Admin.: ".i("grtittod",$ilink)."</a>";}

// --------------------------------------------------

solapah($array,$solap+1,"navhsimple");

// --------------------------------------------------

if ($_SESSION['auto'] < 4) {
	echo i("grnoauto",$ilink);
} else {

	if ($solap==1) {require_once APP_DIR . "/gruposver.php";}
	if ($solap==2) {require_once APP_DIR . "/gruposver.php";}
	if ($solap==3) {require_once APP_DIR . "/gruposcrear.php";}
	if ($solap==4) {require_once APP_DIR . "/gruposentrar.php";}
	if ($solap==5) {require_once APP_DIR . "/grupossalir.php";}
	if ($solap==6) {require_once APP_DIR . "/gruposvertodos.php";}

}

require_once APP_DIR .  "/molde_bott.php";

?>
