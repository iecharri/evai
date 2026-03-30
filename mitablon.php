<?php

require_once __DIR__ . '/siempre.php';

$tit = $_SESSION['tit'];
$asigna = $_SESSION['asigna'];
$curso = $_SESSION['curso'];
$grupo = $_SESSION['grupo'];

extract($_GET);
extract($_POST);

$a_tablo = "class='active'";

require_once APP_DIR . '/molde_top.php';
unset($array);

// --------------------------------------------------

$_SESSION['titasi'] = $titasi;
if (!$_SESSION['titasi']) { $_SESSION['titasi'] = "todos";}
$titasi = $_SESSION['titasi'];

if ($titasi=="todos") {$num = 1;}
if ($titasi==1) {$num = 3; $filtro = " AND titulaci = '$tit'";}
if ($titasi==2) {$num = 4; $filtro = " AND asigna = '$asigna'";}
if ($titasi==1 OR $titasi==2) {
	if ($curso AND $curso != "*") {$filtro .= " AND curso = '$curso'";}
	if ($grupo AND $grupo != "*" AND $titasi==2) {$filtro .= " AND grupo = '$grupo'";}
}

$temp1 = "";
if ($_SESSION['auto'] > 4) {
	$temp1 = "<a href='miagenda.php?accion=anadir&ag=".gmdate('Y-m-d')."&tablon=1";
	if ($titasi == 1) {$temp1 .= "&titasi=1";} else {$temp1 .= "&titasi=2";}
	$temp1 .= "'>".i("writenew",$ilink)."</a>";
}

if ($_SESSION['asigna']) {
	$titpag = "<span class='icon-bullhorn'></span> ".i("avisos",$ilink);
	$array[0] = "<a href='mitablon.php'>$titpag <span class='icon-arrow-right'></span></a>";
	$array[1] = "<a href='mitablon.php?titasi=todos'>".i("todotablon",$ilink)."</a>";
	$array[2] = "";
	$array[3] = "";
	$array[4] = "";
	$array[6] = "";
	$descrip = descrip($ilink);
	$array[3] = "<a href='?titasi=1'> $tit"; // ($descrip[0])
	if ($curso) {$array[3] .= " - $curso";}
	$array[3] .= "</a>";
	$array[4] = "<a href='?titasi=2'> $asigna"; // ($descrip[1])
	if ($curso) {$array[4] .= " - $curso";}
	if ($grupo AND $grupo != "*") {$array[4] .= " - $grupo";}
	$array[4] .= "</a>";
	$array[5] = "";
	if ($temp1) {$array[5] = $temp1;}
}

// --------------------------------------------------

solapah($array,$num+1,"navhsimple");

// --------------------------------------------------

if ($titasi == 2) {$xtitasi = $descrip[1];} 
if ($titasi == 1) {$xtitasi = $descrip[0];} 

if ($titasi == 1 OR $titasi == 2) {echo "<div class='center txth mediana'>$xtitasi</div>";}	//else {echo "<br>";}

$numnotis = notis(0,1,$filtro,0,0,$ilink); //contar todas, s&oacute;lo contar, todas o asi o tit, reducido

if (!$numnotis) {
	
	nohaymens($ilink);
	
} else {
	
	$conta = $_GET['conta'];
	if (!$_GET['conta']) {$conta = 1;}
	if ($_SESSION['pda']) {$numpag = 5;} else {$numpag = 20;}
	pagina($numnotis,$conta,$numpag,i("temas",$ilink),"titasi=$titasi",$ilink);
	echo "<hr class='sty'>";
	notis($numpag,0,$filtro,1,$conta,$ilink); //todas, no s&oacute;lo contar, todas o asi o tit, ampliado
	//echo "<p></p>";
	pagina($numnotis,$conta,$numpag,i("temas",$ilink),"titasi=$titasi",$ilink);
		
}

require_once APP_DIR . '/molde_bott.php';

// --------------------------------------------------

function quitabarra($x) {return stripslashes($x);}

?>
