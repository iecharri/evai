<?php

// Copyright (c) 2000-2026 Inmaculada Echarri San Adrián
// Copyright (c) 2000-2026 Antonio Grandío Botella
// This file is part of EVAI.
// Licensed under the MIT License.
// See LICENSE.txt for details.

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

if (!$_SESSION['usuid']) {return;}

if ($_SESSION['auto'] < 4) {
	echo i("sinautogr",$ilink);
	return;
}

echo "<h4>".i("grsalir",$ilink)."</h4>";
$uid = $_SESSION['usuid'];

// --------------------------------------------------

if ($_POST['subm']) {

	$grupotrab = $_POST['grupotrab'];
	$result = $ilink->query("SELECT grupo_id, grupos.grupo FROM gruposusu LEFT JOIN grupos ON grupos.id = gruposusu.grupo_id WHERE usu_id = '$uid' AND grupos.grupo = '$grupotrab'");

	if ($result->num_rows == 0) {

		echo "<p></p><h4>".str_replace("(grupo)", $grupotrab, i("noestasengr",$ilink))."</h4>";

	} else {

		$fila = $result->fetch_array(MYSQLI_BOTH);
		$grupo_id = $fila['grupo_id'];
		$result = $ilink->query("SELECT * FROM gruposusu WHERE grupo_id = '$grupo_id'");
		if ($result->num_rows == 1) {
			$fila = $result->fetch_array(MYSQLI_BOTH);
			echo "<p></p><h4><span class='rojo b'>".str_replace("(grupo)", $_POST['grupotrab'], i("atencionborrgr",$ilink))."</span></h4><p></p>";
			echo "<form name='grupo1' method='post'>
			<input type='hidden' name='grupo_id' value='$grupo_id'>
			<input type='submit' class='btn' name='subm1' value='".i("confirmborr",$ilink)."'>
			</form>";
		} else {
			$sql = "DELETE FROM gruposusu WHERE grupo_id = '$grupo_id' AND usu_id = '$uid'";
			$ilink->query($sql);
			$sql = "UPDATE forogrupos SET usu_id = 0 WHERE grupo_id = '$grupo_id' AND usu_id = '$uid'";
			$ilink->query($sql);
			echo "<p></p><h4>".str_replace("(grupo)", $grupotrab, i("hasabgr",$ilink))."</h4>";

			$sql = "SELECT gruposusu.usu_id, usuarios.usuario FROM gruposusu LEFT JOIN grupos ON grupos.id = gruposusu.grupo_id LEFT JOIN usuarios ON usuarios.id = gruposusu.usu_id WHERE grupos.id = '$grupo_id' AND gruposusu.usu_id != '$uid'";

			$result1 = $ilink->query($sql);
			require_once APP_DIR . '/enviospor.php';

			while ($fila1 = $result1->fetch_array(MYSQLI_BOTH)) {

				porhsm(str_replace("(grupo)", $grupotrab, i("mensauto1",$ilink)),$fila1['usu_id'],0,$ilink);

			}

		}

	}

}

if ($_POST['subm1']) {

	$grupo_id = $_POST['grupo_id'];
	$iresult = $ilink->query("SELECT grupo FROM grupos WHERE id = '$grupo_id' LIMIT 1");
	$fila = $iresult->fetch_array(MYSQLI_BOTH);
	$grupo = $fila['grupo'];
	$sql = "DELETE FROM gruposusu WHERE grupo_id = '$grupo_id' AND usu_id = '$uid'";
	$ilink->query($sql);
	$sql = "DELETE FROM grupos WHERE id = '$grupo_id' LIMIT 1";
	$ilink->query($sql);
	$sql = "DELETE FROM forogrupos WHERE grupo = '$grupo_id'";
	$ilink->query($sql);
	$sql = "UPDATE vinculos SET engrupotrab = '', sologrupotrab ='' WHERE engrupotrab = '$grupo_id'";
	$ilink->query($sql);
	if (is_dir(DATA_DIR . "/grupos/$grupo")) {safe_rmdir(DATA_DIR . "/grupos/$grupo");}
	echo "<h4>".str_replace("(grupo)", $grupo, i("grborr",$ilink))."</h4>";

} else {

	if (!$_POST['subm']) {

		echo "<form action='?accion=salir' name='grupo' method='post'><input type='hidden' name='n' value='3'>
		<div class='col-2'><input placeholder=\"".i("grupo",$ilink)."\" type='text' size='10' maxlength='10' name='grupotrab'> &nbsp; 
		<input type='submit' class='btn' name='subm' value=\"".i("salirgr",$ilink)."\"></div>";
		echo "</form>\n";

	}

}
?>
