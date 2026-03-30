<?php

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

$hideadmi = 1; 
$hideenviv = 1;
$hidefororec = 1;
$hidebanner = 1;
$hideidioma = 1;
//$hidesonido = 1;

if ($_POST['adminid']) {
	$hideadmi = "";
	$_GET['enviv'] = "";$_GET['acc'] = "";$_GET['accion'] = "";
}
if ($_GET['enviv']) {
	$hideenviv = "";
}
if ($_POST['verfororec']) {
	$hidefororec = "";
	$_GET['enviv'] = "";$_GET['acc'] = "";$_GET['accion'] = "";
}
if ($_POST['banner']) {
	$hidebanner = "";
	$_GET['enviv'] = "";$_GET['acc'] = "";$_GET['accion'] = "";
}
if ($_POST['buscar'] OR $_GET['accion']) {
	$hideidioma = "";
	$_GET['enviv'] = "";$_GET['acc'] = "";
}
/*if ($_POST['soni'] OR $_GET['acc']) {
	$hidesonido = "";
	$_GET['enviv'] = "";$_GET['accion'] = "";
}*/

$retadmienvi = wintot1("admienvi.php", '', 'divadmi','', $hideadmi,$ilink);
$retenviv = wintot1("envivinc.php", '', 'divenviv','', $hideenviv,$ilink);
$retfororec = wintot1("fororec.php", '', 'divfororec','', $hidefororec,$ilink);
$retbanner = wintot1("banner.php", '', 'divbanner','', $hidebanner,$ilink);
$retidioma = wintot1("idioma.php", '', 'dividioma','', $hideidioma,$ilink);
//$retsonido = wintot1("sonido.php", '', 'divsonido','', $hidesonido,$ilink);

?>