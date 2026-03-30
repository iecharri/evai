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

echo "<h4>".i("grunirse",$ilink)."</h4>";

// --------------------------------------------------

if ($_POST['subm'] AND $_POST['grupotrab'] AND $_POST['password']) {

	$entrar = 0;
	$grupotrab = $_POST['grupotrab'];
	$temp1 = $_POST['password'];
	$result = $ilink->query("SELECT * FROM gruposusu LEFT JOIN grupos ON gruposusu.grupo_id = grupos.id WHERE gruposusu.usu_id = '".$_SESSION['usuid']."' AND grupo = '$grupotrab'");
	if ($result->num_rows > 0) {
		echo "<p></p><h2 class='rojo'>".i("yaengr",$ilink).": <span class='b'>$grupotrab</span></h2>";
	} else {
		$result = $ilink->query("SELECT * FROM grupos WHERE grupo = '$grupotrab'");
		if ($result->num_rows > 0) {
			$fila = $result->fetch_array(MYSQLI_BOTH);
			if ($fila['password'] == $_POST['password'] AND (!$fila['asigna'] OR $fila['asigna'] == $_SESSION['asigna'])) {
				$id = $fila['id'];
				$sql = "INSERT INTO gruposusu (grupo_id, usu_id) VALUES ('$id', '".$_SESSION['usuid']."')";
				$ilink->query($sql);
				echo "<p><h4>".i("entradoengr",$ilink).": <span class='b'>$grupotrab</span></h4></p>";
				$entrar = 1;
			} else {
				echo "<p><h2 class='rojo'>".str_replace("(grupo)",$grupotrab,i("grmalcontra",$ilink))."</h2></p>";
			}
		} else {
			echo "<p><h2 class='rojo'>".str_replace("(grupo)", $grupotrab,i("grnoex",$ilink))."</h2></p>";
		}
	}

}

// --------------------------------------------------

if ($entrar == 1) {
	$sql = "SELECT gruposusu.usu_id, usuarios.usuario FROM gruposusu LEFT JOIN grupos ON grupos.id = gruposusu.grupo_id LEFT JOIN usuarios ON usuarios.id = gruposusu.usu_id WHERE grupos.id = '$id' AND gruposusu.usu_id != '".$_SESSION['usuid']."'";

	$result1 = $ilink->query($sql);

	while ($fila1 = $result1->fetch_array(MYSQLI_BOTH)) {

		porhsm(str_replace("(grupo)", $grupotrab, i("mensauto",$ilink)),$fila1['usu_id'],0,$ilink);

	}

}

?>

<form action='?accion=entrar' name='grupo' method='post'><input type='hidden' name='n' value='3'>

<div class='col-2'><input placeholder="<?php echo i("grupo",$ilink);?>" type='text' size='10' maxlength='10' name='grupotrab'></div>
<br>
<div class='col-2'><input placeholder="<?php echo i("clave",$ilink); ?>" type='password' size='10' maxlength='10' name='password'></div>
<br>
<div class='col-2'><input type='submit' class='btn' name='subm' value="<?php echo i("grunirse1",$ilink);?>"></div>

</form>

