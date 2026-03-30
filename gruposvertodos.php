<?php

// Copyright (c) 2000-2026 Inmaculada Echarri San Adrián
// Copyright (c) 2000-2026 Antonio Grandío Botella
// This file is part of EVAI.
// Licensed under the MIT License.
// See LICENSE.txt for details.

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

if ($_SESSION['auto'] < 10) {return;}

if ($_POST['subm']) {$ilink->query("UPDATE grupos SET eslogan = '".$_POST['eslogan']."' WHERE id = '".$_GET['id']."' LIMIT 1");}

require_once APP_DIR . "/gruposrecuento.php";

if ($accion) {
	$temp = i("grveryo",$ilink);
} else {
	$temp = i("grver",$ilink);
}

// --------------------------------------------------

$sql = "SELECT DISTINCT grupos.id, grupos.grupo, grupos.asigna, grupos.password, fechacrea, grupos.numvinc, eslogan FROM grupos LEFT JOIN gruposusu ON 
grupos.id = gruposusu.grupo_id";

$result = $ilink->query($sql);

$numvinculos = $result->num_rows;

if ($_SESSION['auto'] == 5 AND !$_SESSION['asigna']) {
		echo "<span class='rojo b'>".i("gracceso",$ilink)."</span><p></p>";
}

if (!$numvinculos) {

	echo "<p></p>".i("nogrupos",$ilink);
	if ($_SESSION['asigna']) {echo " ".i("nogrupos1",$ilink);}
	return;
}

$conta = $_GET['conta'];

if (!$conta OR $conta < 0) {
	$conta = 1;
}

$ord = $_GET['ord'];
if ($ord == 1) {$sql .= " ORDER BY grupo ";}
if ($ord == 2 OR !$ord) {$sql .= " ORDER BY fechacrea DESC ";}
if ($ord == 3) {$sql .= " ORDER BY asigna ";}
if ($ord == 4) {$sql .= " ORDER BY numvinc DESC ";}

if ($_SESSION['pda']) {$numpag = 5;} else {$numpag = 50;}
pagina($numvinculos,$conta,$numpag,i("grupos1",$ilink),"ord=$ord&accion=$accion",$ilink);

echo "<br>";

// --------------------------------------------------

$result = $ilink->query($sql." LIMIT ".($conta-1).", $numpag");

if ($result->num_rows > 0) {
	echo "<table class='conhover'>";
	echo "<tr><th class='col-7'><a href=?ord=1&accion=$accion>".i("grupo",$ilink)."</a></th><th><a href=?ord=4&accion=$accion>".i("vinculos",$ilink)."</a></th><th><a href=?ord=2&accion=$accion>".i("fechacreagr",$ilink)."</a></th>";
	echo "<th><a href=?ord=3&accion=$accion>".i("asigna",$ilink)."</a></th></tr>\n";
	while ($fila = $result->fetch_array(MYSQLI_BOTH)) {
		$temp= $fila['id'];
		$result1 = $ilink->query("SELECT usu_id FROM gruposusu WHERE gruposusu.grupo_id = '$temp' AND usu_id = '$uid'");
		echo "<tr>";
		echo "<td>";
		echo "<a href='grupo.php?grupoid=".$fila['id']."' target='_blank'>".$fila['grupo']."</a>";
		if (esprofesor($fila['asigna'],"","",$ilink)) {echo " <a href='#' title=\"".$fila['password']."\">[password]</a>";}
		echo "<p></p>";
		$result1 = $ilink->query("SELECT usu_id, usuarios.alumnon, usuarios.alumnoa, usuarios.privacidad, usuarios.foto, usuarios.mas FROM gruposusu LEFT JOIN usuarios ON gruposusu.usu_id = usuarios.id WHERE gruposusu.grupo_id = '$temp'");

		if($_GET['modif'] AND $temp == $_GET['id']){
			echo "<form action='?modif=2&id=$temp&accion=$accion' name='grupo' method='post'><input type='text' name='eslogan' size='50' maxlength='255' value=\"".$fila['eslogan']."\"><br><input class='col-1' type='submit' name='subm' value='".i("modificar",$ilink)."'></form>\n";
		} else {
			echo nl2br($fila['eslogan'])."<p></p>";
			if ($accion) {echo "<p></p><a href='?accion=$accion&modif=1&id=".$fila['id']."'>".i("modificar",$ilink)."</a>";}
		}
		echo "</td><td>&nbsp;";
		if ($fila['numvinc']) {echo $fila['numvinc'];}
		echo "</td><td>&nbsp;";
		if ($fila['fechacrea'] != "0000-00-00") {echo utcausu1($fila['fechacrea']);}
		echo "</td>";

		echo "<td>";
		if ($fila['asigna']){echo $fila['asigna'];} else {echo i("abierto",$ilink);}
		echo "</td>";
		echo "</tr>\n";
	}
	echo "</table>\n";
}

// --------------------------------------------------

echo "<br>";

pagina($numvinculos,$conta,$numpag,i("grupos1",$ilink),"ord=$ord&accion=$accion",$ilink);

?>
