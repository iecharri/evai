<?php

require_once __DIR__ . '/siempre.php';

$a_misa = "active";

require_once APP_DIR . '/molde_top.php';

// --------------------------------------------------

unset($array);
$array = array();

if($_SESSION['tipo'] == "A") {
	$array[] = "<a href=asigalu.php?pest=1>".i("registrarme",$ilink)."</a>";
	$array[] = "<a href=asigalu.php?pest=2>".i("borrarme",$ilink)."</a>";
} else {
	$array[] = "";
	$array[] = "";
}
	
$array[] = "<a href='misasignaturas.php'>".i("misasigna",$ilink)."</a>";
$pest = $_GET['pest'];
$pest = 3;
$titpag = i("misa",$ilink);

// --------------------------------------------------

solapah($array,$pest,"navhsimple");

// --------------------------------------------------

require_once APP_DIR . '/exped.php';

require_once APP_DIR .  "/molde_bott.php";

?>
