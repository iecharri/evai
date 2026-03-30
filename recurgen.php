<?php

require_once __DIR__ . '/siempre.php';

$tamanomax = 4;

$tit = $_SESSION['tit'];
$asigna = $_SESSION['asigna'];
$curso = $_SESSION['curso'];
$grupo = $_SESSION['grupo'];
extract($_GET);
extract($_POST);

if ($_GET['m']) {unset($_SESSION['b']);}

// --------------------------------------------------

if (!$_SESSION['titasi'] OR $_SESSION['titasi'] == 'todos') { $_SESSION['titasi'] = 2;}
if ($_GET['titasi']) {$_SESSION['titasi'] = $_GET['titasi'];}
if ($_POST['titasi']) {$_SESSION['titasi'] = $_POST['titasi'];}
if (!$asigna) {$_SESSION['titasi'] = "general";}
$titasi = $_SESSION['titasi'];

if ($titasi=="todos") {
	$param='titasi=todos'; 
} else {
	$param="titasi=".$titasi;
}

if ($titasi==1) {
	$filtro = "WHERE titulaci='$tit'";
	if ($curso) {$filtro .= " AND curso = '$curso'";}
} elseif ($titasi==2) {
	$filtro = "WHERE asigna='$asigna'";
	if ($curso) {$filtro .= " AND (curso = '$curso' OR curso = '')";} // OR curso = '*'
	if ($grupo AND !$_GET['titul']) {$filtro .= " AND (grupo = '$grupo' OR grupo = '')";} // OR grupo = '*')
} elseif ($titasi=="general") {
	$filtro = "WHERE asigna='' AND titulaci=''";
	if ($_SESSION['auto'] < 10) {
		$filtro .= " AND invisible = 0";	
	}
}	

// --------------------------------------------------

$a_recuc = " class = 'active'";
require_once APP_DIR . '/molde_top.php';

$pest = 1;
$titpag = "<span class='icon-folder-upload'></span> ".i("recurgen",$ilink)."";

$array[0] = "<a href='recurgen.php?$param'>$titpag <span class='icon-arrow-right'></span></a>";
$array[1] = ""; //<a href='recurgen.php?$param'>".i("recurgen",$ilink)."</a>";
$array[2] = "<a href='recurgen.php?$param&accion=anadir'>".i("anadir1",$ilink)."</a>";

if ($accion == "editar") {
	$array[3] = "<a href='#'>".i("editar1",$ilink)."</a>";
	$pest=3;
} else {
	$array[3] = "";
}

$array[4] = "";

if ($accion == "anadir") {
	$pest=2;
}
if ($op == 3) {
	$pest = 3;
}
if ($op == 4) {
	$pest = 4;
}

if ($accion) {
	$accion = "&accion=".$_GET['accion'];
}

// --------------------------------------------------

$titpag = "<span class='icon-folder-upload'></span> <a href='recurgen.php?$param'>".i("recurgen",$ilink)."</a>";

solapah($array,$pest+1,"navhsimple");

// --------------------------------------------------

$general="general";
require_once APP_DIR . '/selectitasi.php';

if (stristr($accion,"anadir") OR stristr($accion,"editar")) {
	require_once APP_DIR . '/recurgen2.php';
	require_once APP_DIR .  "/molde_bott.php";
	exit;
}

if ($_POST['buscar']) {
	$_SESSION['b'][0] = $_POST['b0'];
	$_SESSION['b'][1] = $_POST['b1'];
	$_SESSION['b'][2] = $_POST['b2'];
	$_SESSION['b'][3] = $_POST['b3'];
}

$filtro .= buscar($titasi,$ilink);

$sql = "SELECT recurgen.id, usuid, descrip, tamatach, nomatach, tipoatach, date, alumnon, alumnoa, invisible
	FROM recurgen LEFT JOIN usuarios ON usuarios.id = recurgen.usuid $filtro ORDER BY date DESC";

$resul = $ilink->query($sql);
if (!$resul->num_rows) {
	echo "<h4 class='rojo b'>".i("nodatos",$ilink)."</h4>\n";
	require_once APP_DIR .  "/molde_bott.php";
	exit;
}

$conta = $_GET['conta'];
if (!isset($conta) OR $_POST['buscar']) {$conta = 1;}
$iresult = $ilink->query($sql);
$resul = $iresult->num_rows;

if ($_SESSION['pda']) {$numpag = 5;} else {$numpag = 15;}
pagina($resul,$conta,$numpag,"recursos",$gen.$accion.$param,$ilink);

$sql1 = $sql. " LIMIT ".($conta-1).", $numpag";
$result = $ilink->query($sql1);

echo "<hr class='sty'>";

while ($fila = $result->fetch_array(MYSQLI_BOTH)) {

	if ($fila['invisible'] AND $_SESSION['auto'] == 10) {echo "<span class='fr rojo b'>Recurso invisible a no Administradores</span><br>";}
	$mens = "<p></p>";
	if (soyadmiano($asigna,$curso,$ilink) OR esprofesor($asigna,$curso,$grupo,$ilink) OR $fila['usuid'] == $_SESSION['usuid']) {
		$mens .= "[<a href='recurgen.php?$param&accion=editar&id=".$fila['id']."'>".i("editar1",$ilink)."</a>] &nbsp; ";
	}

	$mens .= "<a href='recurgenver.php?id=".$fila['id']."' target='_new' class='b'>";
	$mens .= imag1($fila['tipoatach'],$ilink)." ".$fila['nomatach'];
	$mens .= "</a> <span class='rojo'>".tamano($fila['tamatach'])."</span> <span class='nob peq'>".ifecha31($fila['date'],$ilink)."</span>";
	$mens .= "<p></p>".$fila['descrip'];
	$mms="";

	//foto, nombre y mensaje
	
	$usu = ponerusu($fila['usuid'],1,$ilink);
	
	?><div class="fila-usuario">
 			<div class="foto"><?php
 	 			echo $usu[0];?>	
 			</div>
			<div class="datos"><?php 	
				echo $usu[1].$mens."<p></p>";?>
			</div>
	  </div>
	  <?php	
	
	echo "<p><br><p>";

}

pagina($resul,$conta,$numpag,"recursos",$gen.$accion.$param,$ilink);

require_once APP_DIR .  "/molde_bott.php";

// --------------------------------------------------

function buscar($titasi,$ilink) {

$b0 = $_SESSION['b'][0];
$b1 = $_SESSION['b'][1];
$b2 = $_SESSION['b'][2];
$b3 = $_SESSION['b'][3];

echo "<p></p><div><form name='buscar' method='post'> &nbsp; <span class='b'>".ucfirst(i("buscar",$ilink))."... &nbsp; </span> &nbsp; ";
echo i("enviadopor",$ilink)." <input class='col-1' type='text' name='b0' size='10' maxlength='20' value=\"$b0\"> ";
echo i("fichero",$ilink)." <input class='col-1' type='text' name='b1' size='10' maxlength='20' value=\"$b1\"> ";
echo i("descrip",$ilink)." <input class='col-1' type='text' name='b2' size='10' maxlength='20' value=\"$b2\"> ";
if ($b3 == "image") {$image="selected = 'selected'";}
if ($b3 == "audio") {$audio="selected = 'selected'";}
if ($b3 == "video") {$video="selected = 'selected'";}
if ($b3 == "html") {$html="selected = 'selected'";}
echo i("tipo2",$ilink)." <select name='b3'><option value=''><option value='image' $image>".i("imagen",$ilink)."<option value='audio' $audio>".i("audio",$ilink)."<option value='video' $video>".i("video",$ilink)."<option value='html' $html>".i("pagweb",$ilink)."</select>";
echo "<input type='hidden' name='titasi' value='$titasi'>";
echo " <input type='submit' class='col-1' name='buscar' value=' >> '><p></p>";
echo "</form></div>";

if (!$b0 AND !$b1 AND !$b2 AND !$b3) {return;}

$filtro = " AND ";

if ($b0) {
	$filtro .= "(alumnon LIKE '%$b0%' OR alumnoa LIKE '%$b0%')";$n=1;
}
if ($b1) {
	if ($n == 1) {$filtro .= " AND ";}
	$filtro .= "nomatach LIKE '%$b1%' ";$n=1;
}
if ($b2) {
	if ($n == 1) {$filtro .= " AND ";}
	$filtro .= "descrip LIKE '%$b2%' ";$n=1;
}
if ($b3) {
	if ($n == 1) {$filtro .= " AND ";}
	$filtro .= "tipoatach LIKE '%$b3%' ";$n=1;
}

return $filtro;

}

?>
