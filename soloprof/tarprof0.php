<?php

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

$hidecopyfich = 1; 
$hidemenualu = 1; 
$hidealtamail = 1; 
$hideborrforo = 1; 
$hidebanner = 1; 
$hidelogo = 1; 
$hidemenualut = 1; 

if ($_POST['pmail']) {
	$hidealtamail = "";
}
if ($_POST['copyfich']) {
	$hidecopyfich = "";
}
if ($_POST['menua']) {
	$hidemenualu = "";
}
if ($_GET['borrforo']) {
	$hideborrforo = "";
}
if ($_GET['banner']) {
	$hidebanner = "";
}
if ($_POST['submlogdesc']) {
	$hidelogo = "";
}
if ($_POST['menuat']) {
	$hidemenualut = "";
}

if ($_GET['op'] == 2) {
	$retcopyfich = wintot1("soloprof/pcopyfichtit.php",'','divcopyfich','',$hidecopyfich,$ilink);
	$retborrforo = wintot1("soloprof/pborrforotit.php",'','divborrforo','',$hideborrforo,$ilink);	
	//$retmenualut = wintot1("soloprof/pmenualut.php",'','divmenualut','',$hidemenualut,$ilink);
	return;
}

$retaltamail = wintot1("soloprof/paltamail.php",'','divaltamail','',$hidealtamail,$ilink);
$retcopyfich = wintot1("soloprof/pcopyfich.php",'','divcopyfich','',$hidecopyfich,$ilink);
//$retmenualu = wintot1("soloprof/pmenualu.php",'','divmenualu','',$hidemenualu,$ilink);
$retborrforo = wintot1("soloprof/pborrforo.php",'','divborrforo','',$hideborrforo,$ilink);
$retbanner = wintot1("soloprof/pbanner.php",'','divbanner','',$hidebanner,$ilink);
$retlogo = wintot1("soloprof/plogo.php",'','divlogo','',$hidelogo,$ilink);

?>

