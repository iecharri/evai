<?php

require_once __DIR__ . '/siempre.php';

// --------------------------------------------------

if ($_GET['m']) {$_SESSION['bu'][0] = $_SESSION['asigna']; $_GET['bus'] = 2;}
if ($_POST['filtroasign']) {$_SESSION['bu'][0] = $_SESSION['asigna'];}

// --------------------------------------------------

$a_links = " class = 'active'";
require_once APP_DIR . '/molde_top.php';

// --------------------------------------------------

unset($array);

$array = array();

$titpag = "<span class='icon-link'></span> ".i("vinculos",$ilink);
$array[] = "<a href='links.php?m=1'>$titpag <span class='icon-arrow-right'></span></a>";
$array[] = "<a href='links.php?bus=2'>".i("cambiaraba",$ilink)."</a>";
$array[] = "<a href='links.php?bus=1'>".i("cambiarabs",$ilink)."</a>";
$array[] = "<a href='links.php?bus=3'>".i("alertas",$ilink)."</a>";
if ($_SESSION['gic'] OR !$_SESSION['asigna']) {
	$array[] = "<a href='links.php?new=1'>".strtolower(i("anadir",$ilink))."</a>";
} else {
	$array[] = "";
}
$array[] = "<a href='links.php?bus=4'>".i("coment",$ilink)."</a>";

if ($_GET['id']) {$array[] = "<a href='links.php?id=".$_GET['id']."&accion=1'>".i("vinculo",$ilink)."</a>";}
$solap = 1;
if ($_GET['bus'] == 4) {$solap = 6;}
if ($_GET['bus'] == 3) {$solap = 4;}
if ($_GET['bus'] == 2) {$solap = 2;}
if ($_GET['bus'] == 1) {$solap = 3;}
if ($_GET['new'] == 1) {$solap = 5;}
if ($_GET['id']) {$solap = 7;}

solapah($array,$solap,"navhsimple");

// --------------------------------------------------

if ($_POST['subm']) {
	$_SESSION['bu'][0] = $_POST['asigna0'];
	$_SESSION['bu'][1] = $_POST['claves0'];
	$_SESSION['bu'][2] = $_POST['titulo0'];
	$_SESSION['bu'][3] = $_POST['pagina0'];
	$_SESSION['bu'][4] = $_POST['orand10'];
	$_SESSION['bu'][5] = $_POST['orand20'];
	$_SESSION['bu'][6] = $_POST['orand40'];
	//$_SESSION['bu'][7] = substr($_POST['d1'],6,4).substr($_POST['d1'],3,2).substr($_POST['d1'],0,2);
	//$_SESSION['bu'][8] = substr($_POST['d2'],6,4).substr($_POST['d2'],3,2).substr($_POST['d2'],0,2);
$_SESSION['bu'][7] = usuautc1($_POST['d1'],'');
$_SESSION['bu'][8] = usuautc1($_POST['d2'],'');
	$_SESSION['cat'][0][0] = $_POST['oy'][0];
	$_SESSION['cat'][0][1] = $_POST['cat'][0];
	$_SESSION['cat'][1][0] = $_POST['oy'][1];
	$_SESSION['cat'][1][1] = $_POST['cat'][1];
	$_SESSION['cat'][2][0] = $_POST['oy'][2];
	$_SESSION['cat'][2][1] = $_POST['cat'][2];
	$_SESSION['cat'][3][0] = $_POST['oy'][3];
	$_SESSION['cat'][3][1] = $_POST['cat'][3];
	$_SESSION['cat'][4][0] = $_POST['oy'][4];
	$_SESSION['cat'][4][1] = $_POST['cat'][4];

}

// --------------------------------------------------

$sql = '';

if (!$_GET['id']) {
	
	if ($_GET['bus'] AND $_GET['bus'] != 4) {require_once APP_DIR . '/busquedasform.php';}
	if ($_GET['bus'] == 1) {require_once APP_DIR . '/busquedas_sql_simp.php';}
	if ($_GET['bus'] == 2) {require_once APP_DIR . '/busquedas_sql_avan.php';}
	if ($_GET['new'] == 1) {require_once APP_DIR . '/gic_vincnew.php'; require_once APP_DIR . '/molde_bott.php'; return;}
	if ($_GET['bus'] == 4) {require_once APP_DIR . '/coment.php'; require_once APP_DIR . '/molde_bott.php'; return;}

} else {
	$solap = 5;
}

if ($solap == 5) {$sql = "SELECT * FROM vinculos WHERE id = '".$_GET['id']."' LIMIT 1";}
if ($solap == 1) {$sql = "SELECT * FROM vinculos";}

if ($_GET['bus'] != 3) {require_once APP_DIR . '/links_resul.php';}

require_once APP_DIR . '/jsspeech.js';
require_once APP_DIR . '/molde_bott.php';

?>

<script>

function vozlink(texto, idioma) {
    var utterance = new SpeechSynthesisUtterance(texto);
    utterance.lang = idioma;
    speechUtteranceChunker(utterance, {
        chunkLength: 120,
        langu: idioma
    }, function () {
        // Acción opcional al terminar
    });
}

</script>

