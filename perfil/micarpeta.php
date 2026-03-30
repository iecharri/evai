<?php

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

$tamanomax = 750; //400;
if ($_SESSION['auto'] == 5) {$tamanomax = 750;} //400
if ($_SESSION['auto'] < 5) {
	$tamanomax = 3;
	if ($_SESSION['tipo'] == "A") {$tamanomax = 80;}
}

$iresult = $ilink->query("SELECT usuario, alumnon, alumnoa FROM usuarios WHERE id = '$usuid' LIMIT 1");
$temp = $iresult->fetch_array(MYSQLI_BOTH);
$dirini = DATA_DIR . '/usuarios/'.$temp[0].'/';
if (!is_dir($dirini)){safe_mkdir($dirini);}
if (!is_dir($dirini."public/")){safe_mkdir($dirini."public/");}
if (!is_dir($dirini."public/pics")){safe_mkdir($dirini."public/pics/");}
if (!is_dir($dirini."public/video/")){safe_mkdir($dirini."public/video/");}

if (!is_dir($dirini."profesor/") AND $tipo[0] == "A"){
	safe_mkdir($dirini."profesor/");
}

if ($tipo[0] == "A") {crearcarpasignat($usuid,$dirini,$ilink);}
if ($ver == 0.5 AND $tipo[0] == "A") {
	$dirini = DATA_DIR ."/usuarios/".$temp[0]."/profesor/";
}

if (!is_dir($dirini)) {safe_mkdir($dirini,0750);}
$script = "ficha.php?$param";
$puedounzip = 0; if ($_SESSION['auto'] > 4) {$puedounzip = 1;}
$fichphp = APP_URL . "/file.php?n=".base64_encode($dirini);  //antes $navini

require_once APP_DIR . '/explorernue.php';

?>