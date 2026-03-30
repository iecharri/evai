<?php

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

unset($array);

$array[] = "";

$array = array();

$array[] = "<a href='?$param&pest=2'>".i("vermiscomen",$ilink)."</a>";
$array[] = "<a href='?$param&pest=3'>".i("misvinc",$ilink)."</a>";
if ($usuid == $_SESSION['usuid'] AND $_SESSION['tipo'] != "E") {
	$array[] = "<a href='?$param&pest=4'>".i("traspvinc",$ilink)."</a>";
} else {
	$array[] = "";
}
if (($usuid == $_SESSION['usuid'] OR $_SESSION['auto'] > 4) AND $_SESSION['gc']) {
	$array[] = "<a href='?$param&pest=5'>Categorizaci&oacute;n</a>";
} else {
	$array[] = "";
}
if ($_SESSION['auto'] > 4) {
	$array[] = "<a href='?$param&pest=6'>Votos emitidos y recibidos</a>";
	$array[] = "<a href='?$param&pest=7'>Fiabilidad</a>";
} else {
	if ($pest > 5 AND $pest!=8 AND $usuid != $_SESSION['usuid']) {$pest = 1;} else {$array[] = "";}
	$array[] = "";
}
if ($_SESSION['auto'] > 4) {$array[] = "<a href='?$param&pest=8'>Foros</a>";}

if (!$pest) {$pest = 1;}

solapah($array,$pest-1,"navhsimple");

if ($pest == 1) {
	echo "<div class='col-5'>";
	require_once APP_DIR . '/perfil/actiusu.php';
	echo "<div class='both'></div><div class='mediana'>".i("foro",$ilink).": ";
	$sql = "SELECT id FROM foro WHERE usu_id = '$usuid'";
	if ($_SESSION['auto'] < 10) {$sql .= " AND !invisible";}
	$iresult = $ilink->query($sql);
	$mensajes = $iresult->num_rows;
	echo $mensajes." ".i("mensajes",$ilink);
	echo "</div></div>";
}

if ($pest == 2) {
	if($soloasigna) {
		echo "$asigna $curso $grupo | <a href='?usuid=$usuid&op=$op&pest=$pest'>".i("grtittod",$ilink)."</a>";
	} else {
		echo "<a href='?usuid=$usuid&op=$op&pest=$pest&soloasigna=1'>$asigna $curso $grupo</a> | ".i("grtittod",$ilink);
	}
	echo "<p></p>";		
	require_once APP_DIR . '/coment.php';
}

if ($pest == 3) {
	$iresult = $ilink->query("SELECT anonota FROM usuasi WHERE id = '$usuid' AND asigna = '$asigna'");
	$temp=$iresult->fetch_array(MYSQLI_BOTH);
	if ($temp[0]==0 AND $_SESSION['auto'] < 5 AND $usuid != $_SESSION['usuid']) {
		echo "<p></p><h3 class='rojo'>".i("nopermivincusu",$ilink)."</h3>";
	} else {
		$sql = '';
		if($soloasigna) {
			echo "$asigna $curso $grupo | <a href='?usuid=$usuid&op=$op&pest=$pest'>".i("grtittod",$ilink)."</a>";
		} else {
			echo "<a href='?usuid=$usuid&op=$op&pest=$pest&soloasigna=1'>$asigna $curso $grupo</a> | ".i("grtittod",$ilink);
		}
		echo "<p></p>";		
		require_once APP_DIR . '/busquedas_sql_usu.php';
		require_once APP_DIR . '/links_resul.php';
	}
}

if ($pest == 4 AND ($_SESSION['auto'] > 4 OR $usuid == $_SESSION['usuid'])) {
	require_once APP_DIR . '/gicvinccambiar.php';
}

if ($pest == 5) {
	$sql = "SELECT * FROM vinculos WHERE idcat = '$usuid'";
	if($_GET['area']) {$sql .= " AND area = '".$_GET['area']."'";}
	require_once APP_DIR . '/links_resul.php';
}

if ($pest == 6 AND $_SESSION['auto'] > 4) {
	require_once APP_DIR . '/perfil/gic_totvotosalu.php';
}

if ($pest == 7 AND $_SESSION['auto'] > 4) {
	require_once APP_DIR . '/perfil/fiabilidad.php';
}

if ($pest == 8 AND $_SESSION['auto'] > 4) {
	require_once APP_DIR . '/perfil/forosusu.php';
}

?>


