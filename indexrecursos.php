<?php

require_once __DIR__ . '/siempre.php';

if ($_SESSION['auto'] < 3) {exit;}

$tit = $_SESSION['tit'];
$titcur = $tit."$$".$_SESSION['curso'];
$asigna = $_SESSION['asigna'];
$curso = $_SESSION['curso'];
$grupo = $_SESSION['grupo'];
$op = $_GET['op'];

// --------------------------------------------------

if ($_SESSION['titasi'] != 1 AND $_SESSION['titasi'] != 2) { $_SESSION['titasi'] = 2;}
if ($_GET['titasi']) {$_SESSION['titasi'] = $_GET['titasi'];}
if ($_POST['titasi']) {$_SESSION['titasi'] = $_POST['titasi'];}
$titasi = $_SESSION['titasi'];

// --------------------------------------------------

$a_recur = " class = 'active'";
require_once APP_DIR . "/molde_top.php";

// --------------------------------------------------

if ($titasi==1) {
	$param="&titasi=1";
} else {
	$param="&titasi=2";
}

$icon = "";

unset($array);

$titpag = "<span class='icon-folder-open'></span> ".i("recur",$ilink);

$array[0] = "<a href='indexrecursos.php'>$titpag <span class='icon-arrow-right'></span></a>";

if ($titasi==1) {
	$tempcont = DATA_DIR . "/cursos/$tit"."$$"."$curso/contenidos/index.htm";
	if (file_exists($tempcont."l")) {
		$haytempcont = 1; $l = "l";
	} elseif (file_exists($tempcont)) {
		$haytempcont = 1; $l="";
	}
} else {
	$tempcont = DATA_DIR . "/cursos/$asicurgru/contenidos/index.htm";
	if (file_exists($tempcont."l")) {
		$haytempcont = 1; $l = "l";
	} elseif (file_exists($tempcont)) {
		$haytempcont = 1; $l="";
	}
}

//antes eran array 2 y 3
$array[1] = "<a href=\"?op=5$param\">$icon ".i("guiadocen",$ilink)."</a>";
$array[2] = "<a href='?op=4$param'>".i("matdocente",$ilink)."</a>";


$array[3] = "<a href='?op=1$param'>".i("otrosrecur",$ilink)."</a>";


$array[4] = "<a href='?op=6&titasi=$titasi'>".i("aplicaciones",$ilink)."</a>";

if ($titasi==2) {
	$array[8] = "<a href='?op=8'>".i("clasedir",$ilink)."</a>";
	$array[9] = "<a href='cuest/cuest.php?ini=1' target='_blank'>".i("eval",$ilink)."</a>";
} else {
	$array[8] = "";
	$array[9] = "";
}

$array[10] = "<a href='?op=10&titasi=$titasi'>".i("practext",$ilink)."</a>";

if(!$op){$op = 5;}
$pest = 1;
if ($op == 1) {$pest = 3;} 
if ($op == 4) {$pest = 2;} //3;}
if ($op == 5) {$pest = 1;} //2;}
if ($op == 6) {$pest = 4;}
if ($op == 8) {$pest = 5;}
if ($op == 10) {$pest = 7;}

// --------------------------------------------------

$titpag = "<span class='icon-folder-open'></span> ".i("recur",$ilink);

if ($asigna) {
	solapah($array,$pest+1,"navhsimple");
}

// --------------------------------------------------

$vacio=0;
if ($op <= 6 AND $asigna) {require_once APP_DIR . "/selectitasi.php";}
if ($op == 10 AND $asigna) {require_once APP_DIR . "/selectitasi.php";}

if (!$op) {$op = 1;}

if ($op == 1 AND $asigna) {
	if ($titasi==1) {
		if ($_SESSION['auto'] > 4) { 
			echo "<a class='fr colu' href='soloprof/admin.php?op=2&pest=9' target='_blank'>Administraci&oacute;n de Recursos</a><div class='both'></div>";
		}
		$temp = DATA_DIR . "/cursos/$titcur/recursos/index.html";
		if (file_exists($temp)) {
			require_once $temp;
		} else {
			require_once APP_DIR . "/ponerobject.php";
			require_once APP_DIR . "/recursos.php";
		}
	} else {
		if ($_SESSION['auto'] > 4) {
			echo "<div class='fr colu'><a href='soloprof/admin.php?op=1&pest=9' target='_blank'>Administraci&oacute;n de Recursos</a></div><p><br></p><br>";
		}	
		$temp = DATA_DIR . "cursos/".$asicurgru."/recursos/index.html";
		if (file_exists($temp)) {
			require_once $temp;
		} else {
			require_once APP_DIR . "/ponerobject.php";
			require_once APP_DIR . "/recursos.php";
		}
	}
}

$puedounzip=1; if ($_SESSION['auto'] < 5) {$puedounzip=0;}

if ($op == 4 AND $titasi==1) {
	$dirini = DATA_DIR . "/cursos/$tit"."$$".$curso."/compartida/";
	$param = "titasi=1&op=4";
	$script = "indexrecursos.php?$param";
	if ($_SESSION['auto'] < 5) {$solover = 1;}
	$fichphp = APP_URL . "/file.php?n=".base64_encode($dirini);
	$ocul = "__";
	require_once APP_DIR . "/explorernue.php";
}

if ($op == 4 AND $titasi==2) {
	$dirini = DATA_DIR . "/cursos/$asicurgru/compartida/";
	$param = "titasi=2&op=4";
	$script = "indexrecursos.php?$param";
	if ($_SESSION['auto'] < 5) {$solover = 1;}
	$fichphp = APP_URL . "/file.php?n=".base64_encode($dirini); 
	$ocul = "__";
	require_once APP_DIR . "/explorernue.php";
}

if ($op == 5 AND $asigna) {
	$dirini = DATA_DIR . "/cursos/$asicurgru/contenidos/";
	$param = "titasi=2&op=5";
	$script = "indexrecursos.php?$param";
	if ($_SESSION['auto'] < 5) {$solover = 1;}
	$fichphp = APP_URL . "/file.php?n=".base64_encode($dirini); 
	$ocul = "__";
	require_once APP_DIR . "/explorernue.php";
	
	/*echo "<p><br></p>";
	if ($titasi == 1) {
		if ($haytempcont) {
 			echo " &nbsp; <a class='mediana b' href='".DATA_URL."/cursos/$tit"."$$"."$curso/contenidos/index.htm$l' 
 			target='_new'>$icon ".i("guiadocen",$ilink)."</a>";
		}
 	}
	if ($titasi == 2) {
		if ($haytempcont) {
 			echo " &nbsp; <a class='mediana b' href='".DATA_URL."/cursos/$asigna"."$$".$curso."$$".$grupo."/contenidos/index.htm$l' 
 			target='_new'>$icon ".i("guiadocen",$ilink)."</a>";
 		}
 	}*/
}

if ($op == 6 AND $asigna) {
	require_once APP_DIR . "/aplicaciones.php";
}

if ($op == 8 AND $asigna) {
	require_once APP_DIR . "/clasedist.php";
}

if ($op == 10 AND $asigna) {
	require_once APP_DIR . "/practiext.php";
}

require_once APP_DIR . "/molde_bott.php";

?>
