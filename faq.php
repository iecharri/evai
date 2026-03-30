<?php

require_once __DIR__ . '/siempre.php';

extract($_GET);

if ($_POST['faqnew']) {
	extract($_POST);
	if($gen == 1) {$para = 0; $asigna = "";}
	if($titul) {$para = 0; $titulaci = $_SESSION['tit'];}
	if($asi) {$para = 0; $asigna = $_SESSION['asigna'];}
	if($faqpr) {$para = 5; $asigna = "";}
	if($faqad) {$para = 10; $asigna = "";}
	$activo = "";
	if ($_POST['activo']) {$activo = 1;}
	$ilink->query("INSERT INTO faq (para, asigna, pr_c, res_c, pr_v, res_v, pr_i, res_i, activo, titulaci) VALUES ('$para', '$asigna', '$faqpc', '$faqrc', '$faqpv', '$faqrv', '$faqpi', '$faqri', '$activo', '$titulaci')");
}
if ($_POST['faqedit']) {
	extract($_POST);
	$activo = "";
	if ($_POST['activo']) {$activo = 1;}
	$ilink->query("UPDATE faq SET pr_c = '$faqpc', pr_v = '$faqpv', pr_i = '$faqpi', res_c = '$faqrc', res_v = '$faqrv', res_i = '$faqri', activo = '$activo' WHERE id = '$ed' LIMIT 1");
	$_GET['ed'] = "";
}

// --------------------------------------------------

if ($_SESSION['auto'] < 2) {echo "</body></htm>";return;}

$pest = 1;

if ($gen) {$param="gen=1";$pest=1;}
if ($titul) {$param="titul=1";$pest=2;}
if ($asi) {$param="asi=1";$pest=3;}
if ($faqpr) {$param="faqpr=1";$pest=4;}
if ($faqad) {$param="faqad=1";$pest=5;}

require_once APP_DIR . 'molde_top.php';

// --------------------------------------------------

$array = array();

$array[] = "<a href=?gen=1>FAQ General</a>";

if ($_SESSION['asigna']) {
	$array[] = "<a href=?titul=1>FAQ ".$_SESSION['tit']."</a>";
	$array[] = "<a href=?asi=1>FAQ ".$_SESSION['asigna']."</a>";
} else {
	$array[] = "";
	$array[] = "";
	$pest = 1;
}

if ($_SESSION['auto'] > 4) {
	$array[] = "<a href=?faqpr=1>FAQ ".i("profesor",$ilink)."</a>";
} else {
	$array[] = "";
}

if ($_SESSION['auto'] == 10) {
	$array[] = "<a href=?faqad=1>FAQ ".i("soload",$ilink)."</a>";
} else {
	$array[] = "";
}

echo "FAQ <span class='icon-arrow-right'></span> ";
solapah($array,$pest,"navhsimple");

if (esprofesor($_SESSION['asigna'],"","",$ilink)) {$esprofesor=1;}
if (soyadmiano($_SESSION['asigna'],'',$ilink)) {$soyadmi=1;}

if ($_GET['ed'] AND ($esprofesor OR $soyadmi)) {
	wintot("faqedit.php",'',"dive",'',0,$ilink);
}

if ($_GET['an'] AND ($esprofesor OR $soyadmi)) {
	wintot("faqnew.php",'',"diva",'',0,$ilink);
}

if ((($esprofesor OR $soyadmi) AND $asi == 1 ) OR ($soyadmi AND $titul == 1) OR $_SESSION['auto'] == 10) {
	echo "<br><a href='faq.php?an=1&$param' class='txth b mediana'>A&ntilde;adir FAQ</a><p></p>";
}

$sql = "SELECT * FROM faq WHERE 1=1";

if ($pest == 1) {
	$sql .= " AND para = 0 AND asigna = ''";
}

if ($pest == 2) {
	$sql .= " AND para = 0 AND titulaci = '".$_SESSION['tit']."'";
}

if ($pest == 3) {
	$sql .= " AND para = 0 AND asigna = '".$_SESSION['asigna']."'";
}

if ($pest == 4 AND $_SESSION['auto'] > 4) {
	$sql .= " AND para = 5";
}

if ($pest == 5 AND $_SESSION['auto'] == 10) {
	$sql .= " AND para = 10";
}

if ($_SESSION['auto'] < 10) {
	if ($gen == 1 OR $faqpr == 1) {$sql .= " AND activo = 1";}
}

$result = $ilink->query($sql);
if ($result) {$numfilas = $result->num_rows;}

if ($numfilas == 0) {

	require_once APP_DIR .  "/molde_bott.php";
	exit;

}

$i = $_SESSION['i'];
$m=1;

while ($fila = $result->fetch_array(MYSQLI_BOTH)) {

	if ((!$fila['pr_'.$i] OR !$fila['res_'.$i]) AND $_SESSION['auto'] < 5) {continue;}
	echo "<p class='interli'>$m. ".$fila['pr_'.$i];
	echo " <a name=".$fila['id']."></a> [ <a onclick=\"amplred('div".$fila['id']."')\" class='txth b'>Respuesta</a> ]";
	if ((($esprofesor OR $soyadmi) AND ($asi == 1 OR $titul == 1)) OR $_SESSION['auto'] == 10) {
		echo " (<a href='?ed=".$fila['id']."&$param'>".i("editar1",$ilink)."</a>)";
	}
	if (!$fila['activo']) {echo "<span class='rojo b'> No activo</span>";}
	echo "<br>";
	echo "<div id='div".$fila['id']."' style='display:none'>".consmy(conhiper($fila['res_'.$i]))."</div><p></p>";
	$m++;

}

require_once APP_DIR .  "/molde_bott.php";
?>
