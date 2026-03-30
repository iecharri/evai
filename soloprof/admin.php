<?php

require_once __DIR__ . '/../siempre.php';

if($_SESSION['auto'] < 5) {header("Location: ../index.php"); exit;}

extract($_GET);
extract($_POST);

$tit = $_SESSION['tit'];
$asigna = $_SESSION['asigna'];
$curso = $_SESSION['curso'];
$grupo = $_SESSION['grupo'];

if (!$asigna) {$_SESSION['op'] = 3;}

if (!$_SESSION['op']) {$_SESSION['op'] = 1;}
if($_GET['op']) {
	$_SESSION['op'] = $_GET['op'];
}
$op = $_SESSION['op'];

// --------------------------------------------------

if (!$pest) {$pest = 1;}

if ($porsms) {
	$smsmens = $_POST['smsmens'];
	$onload = " onload=\"".porsms($smsmens)."\"";
}

// --------------------------------------------------

require_once APP_DIR . "/molde_top.php";

// --------------------------------------------------

switch($op) {
	
	case 1:
	
		if (!esprofesor($asigna,$curso,$grupo,$ilink) AND !soyadmiano($asigna,$curso,$ilink)) {header("Location: ../index.php"); exit;}
		if ($pest < 2) {require_once APP_DIR . "/soloprof/tarprof0.php";}
		if ($pest == 1) {require_once APP_DIR . "/soloprof/tarprof.php";}
		if ($pest == 2) {require_once APP_DIR . "/soloprof/gestusu.php";}
		if ($pest == 3) {require_once APP_DIR . "/soloprof/soloprofgic.php";}
		if ($pest == 4) {require_once APP_DIR . "/soloprof/soloprofcomunic.php";}
		if ($pest == 5) {require_once APP_DIR . "/soloprof/soloprofcoefnotas.php";}
		if ($pest == 7) {require_once APP_DIR . "/soloprof/soloprofmens.php";}
		if ($pest == 8) {require_once APP_DIR . "/soloprof/soloprofmodulos.php";}
		if ($pest == 9) {require_once APP_DIR . "/soloprof/soloprofrecur.php";}
		if ($pest == 11) {require_once APP_DIR . "/soloprof/soloprofaplic.php";}
		if ($pest == 12) {require_once APP_DIR . "/soloprof/soloproftrabalu.php";}
		if ($pest == 13) {require_once APP_DIR . "/soloprof/soloprofcarpgrup.php";}
		if ($pest == 14) {require_once APP_DIR . "/soloprof/soloproffich.php";}
		if ($pest == 15) {require_once APP_DIR . "/soloprof/asistencia1.php";}
		break;
		
	case 2:
		if (!esprofesor($asigna,$curso,$grupo,$ilink) AND !soyadmiano($asigna,$curso,$ilink)) {header("Location: ../index.php"); exit;}
		if ($pest < 2) {require_once APP_DIR . "/soloprof/tarprof0.php";}
		if ($pest == 1) {require_once APP_DIR . "/soloprof/tarproftit.php";}
		if ($pest == 7) {require_once APP_DIR . "/soloprof/simplemail.php";}
		if ($pest == 9) {if ($_GET['titul'] == 1) {$titasi=1;} require_once APP_DIR . "/soloprof/soloprofrecur.php";}
		if ($pest == 11) {require_once APP_DIR . "/soloprof/titaplic.php";}
		if ($pest == 12) {require_once APP_DIR . "/soloprof/soloproffich.php";}
		break;

	case 3:
		if ($pest == 1) {
			require_once APP_DIR . "/soloprof/taradmin0.php";
			require_once APP_DIR . "/soloprof/taradmin.php";
		}
		if ($pest == 2) {require_once APP_DIR . "/soloprof/gestipadm.php";}
		if ($pest == 3) {if ($_GET['alta']) {require_once APP_DIR . "/soloprof/gestusu1.php";} else {require_once APP_DIR . "/soloprof/gestusu.php";}}
		if ($pest == 5) {$deasicurgr = 1;require_once APP_DIR . "/soloprof/soloprofmens.php";}
		if ($pest == 6) {
			$param = "pest=6";
			require_once APP_DIR . "/soloprof/mailssist.php";
		}
		if ($pest == 9) {require_once APP_DIR . "/soloprof/admiusosistema.php";}
		if ($pest == 10) {require_once APP_DIR . "/soloprof/carpprofregactivi.php";}
		if ($pest == 11) {require_once APP_DIR . "/soloprof/tareas.php";}
		//if ($pest == 12) {require_once APP_DIR . "/soloprof/reuniones.php";}
		if ($pest == 13) {require_once APP_DIR . "/soloprof/soloproffich.php";}
		if ($pest == 14) {require_once APP_DIR . "/soloprof/mensajes.php";}
	
}

// --------------------------------------------------

require_once APP_DIR . "/molde_bott.php";

?>
