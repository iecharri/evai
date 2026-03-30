<?php

// Copyright (c) 2000-2026 Inmaculada Echarri San Adrián
// Copyright (c) 2000-2026 Antonio Grandío Botella
// This file is part of EVAI.
// Licensed under the MIT License.
// See LICENSE.txt for details.

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

//-------------------- PROFESORES ----------------------------- -->

$ord = $_GET['ord'];
if (!$ord) {$ord = "usuarios.alumnoa,usuarios.alumnon";}

if ($accion) {require_once APP_DIR . "/pod/podtablasmodif.php";}

if ($accion == 'anadir1') {

	require_once APP_DIR . "/validarchars.php";

	$mal = versidatosok($ilink,$script);
	if(!$mal[0]) {
		$mensaje = anadirprof($_POST,$ilink);
		if ($ventana) {$accion = 'anadir';}
		$usuario = $password = $password1 = $mail = $alumnon = $alumnoa = "";
		unset($_POST);
	} else {
		$accion = "anadir";
	}

}

if ($accion == 'editar1') {

	require_once APP_DIR . "/validarchars.php";

	$mal = versidatosok($ilink,$script);
	if(!$mal[0]) {
		$mensaje = modifprof($_POST,$ilink);
		if ($ventana) {$accion = 'editar';}
		//$usuario = $password = $password1 = $password1 = $mail = $alumnon = $alumnoa = "";
		//unset($_POST);
	} else {
		$ventana = 1;
		$accion = "editar";
	}

}

if ($borrar) {
	$mensaje = borrarprof($_POST,$ilink);
	$accion = "";
}

if ($accion == 'anadir') {
	winop(i("anadir1",$ilink)." - ".i("profesor",$ilink),'div1','');echo "<span class='b'>".$mensaje."<span><p></p>";
	echo "<form name='form1' method='post'>";
	require_once APP_DIR . "/form_newusu.php";
	echo "<input type='hidden' name='accion' value='anadir1'>";
	echo "<input class='col-2' type='submit' value=\"".i("anadir1",$ilink)."\">";
	$temp = ""; if ($ventana) {$temp = "checked='checked'";}
	echo "<div class='fr'>Mantener ventana <input type='checkbox' name='ventana' $temp></div>";
	echo "<input type='hidden' name='ventana1' value='1'>";
	echo "</form>";
	echo "</div></div>";
}

if ($accion == 'editar' AND $id) {
	$sql = "SELECT alumnon, alumnoa, mail, usuario, password FROM usuarios WHERE id = '$id' LIMIT 1"; //SELECT *
	$result = $ilink->query($sql);
	$fila = $result->fetch_array(MYSQLI_BOTH);
	winop(i("editar1",$ilink)." - ".i("profesor",$ilink),'div1','');
	echo "<form name='form1' method='post' onsubmit='return prueba(form1)'>";

	extract($fila); $password1 = $password;
	require_once APP_DIR . "/form_newusu.php";
	echo "<input type='hidden' name='accion' value='editar1'>";
	echo "<input type='hidden' name='id' value='".$id."'>";
	echo "<div class='fr'>Mantener ventana <input type='checkbox' name='ventana' $temp></div>";
	echo "<p class='rojo b'>BORRAR <input type='checkbox' name='borrar'><br>";
	echo "<input class='col-10' type='submit' value=\"".i("agvalid",$ilink)."\">";
	$temp = ""; if ($ventana) {$temp = "checked='checked'";}
	echo "<input type='hidden' name='ventana1' value='1'>";
	echo "</form>";
	echo "</div></div>";
}	

$listaprofes = "SELECT id FROM usuarios ";
$listaprofes .= " WHERE tipo = 'P' AND autorizado > 4";
if ($_SESSION['auto'] < 10) {$listaprofes .= " AND fechabaja = '0000-00-00 00:00'";}

$listaprofes .= " ORDER BY $ord";
$result = $ilink->query($listaprofes);

echo $mensaje;

echo "<table class='conhover'>";

echo "<tr>";
if ($_SESSION['auto'] == 10) {
	echo "<th class='col-01'>";
	echo "<a href='?ord=$ord&accion=anadir&pest=$pest&pest1=$pest1'>A&ntilde;adir</a>";
	echo "</th>";
}
echo "<th>Profesor</th>";
echo "</tr>";
while ($fila = $result->fetch_array(MYSQLI_BOTH)) {
	echo "<tr>";
	if ($_SESSION['auto'] == 10) {
		echo "<td><a href='?ord=$ord&accion=editar&pest=$pest&pest1=$pest1&id=".$fila['id']."'>Editar</a></td>";
	}
	echo "</td>";
	echo "<td class='nowrap'>";
		$usu = ponerusu($fila['id'],1,$ilink);
		echo $usu[0].$usu[1];
	echo "</td>";
	echo "</tr>";
}
echo "</table>";

?>
