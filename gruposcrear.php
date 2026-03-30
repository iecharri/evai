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

echo "<h4>".i("grcrear",$ilink)."</h4>";

// --------------------------------------------------

if ($_POST['subm'] AND $_POST['grupotrab']) {

	if (!$_POST['password']) {
		echo "<p><h2 class='rojo'>".i("grdarcontras",$ilink)."</h2></p>\n";
	} else {
		$grupotrab = $_POST['grupotrab'];
		$temp1 = $_POST['password'];
		$result = $ilink->query("SELECT * FROM grupos WHERE grupo = '$grupotrab'");
		if ($result->num_rows > 0) {
			echo "<p><h2 class='rojo'>".str_replace("(grupo)", $grupotrab, i("grexiste",$ilink))."</h2></p></span>";
		} else {
			$dir = DATA_DIR . '/grupos/';
			if(!file_exists($dir.$grupotrab)){safe_mkdir($dir.$grupotrab,0750);}
			$temp2 = '';
			if ($_POST['cerrado']) {$temp2 = $_SESSION['asigna'];}
			$temp3 = gmdate('Y-m-d');
			$eslogan = $_POST['eslogan'];
			$sql = "INSERT INTO grupos (grupo, password, asigna, fechacrea, eslogan) VALUES ('$grupotrab', '$temp1', '$temp2', '$temp3', '$eslogan')";
			$ilink->query($sql);
			$iresult = $ilink->query("SELECT * FROM grupos WHERE grupo = '$grupotrab'");
			$fila = $iresult->fetch_array(MYSQLI_BOTH);
			$id = $fila['id'];
			$sql = "INSERT INTO gruposusu (grupo_id, usu_id) VALUES ('$id', '".$_SESSION['usuid']."')";
			$ilink->query($sql);
			echo "<h4>Se ha creado el grupo $grupotrab</h4>";
			return;
		}
	}
}

// --------------------------------------------------

?>

<form action='?accion=crear' name='grupo' method='post'><input type='hidden' name='n' value='3'>

<div class='col-2'><input placeholder="<?php echo i("grupo",$ilink)." (".i("minus",$ilink).")";?>" type='text' size='10' maxlength='10' name='grupotrab' value="<?php echo $_POST['grupotrab'];?>" 
onKeypress='if (event.keyCode < 48 || event.keyCode > 122 || (event.keyCode > 57 && event.keyCode < 97)) event.returnValue = false;'> 
</div>

<br>

<div class='col-2'><input placeholder="<?php echo i("clave",$ilink)." (".i("minus",$ilink).")";?>" type='password' size='10' maxlength='10' name='password' value = "<?php echo$_POST['password'];?>" 
onKeypress='if (event.keyCode < 48 || event.keyCode > 122 || (event.keyCode > 57 && event.keyCode < 97)) event.returnValue = false;'>
</div>

<br>

<?php

if ($_SESSION['asigna']) {
	echo "<label>".i("grtipo",$ilink)."</label> <input type='Checkbox' name='cerrado' ";
	if ($_POST['cerrado']) {echo " checked='checked'";}
	echo "> ".i("grmrcar",$ilink)." <b>".$_SESSION['asigna']."</b></p>";
} else {
	echo i("secreagrab",$ilink);
	if ($_SESSION['tipo'] != 'E' OR $_SESSION['auto'] == 10) {echo ", ".i("paracerr",$ilink);}
	echo ".<p></p>";
}

echo i("frasegr",$ilink);

?>

<br>

<div class='col-2'><input type='text' name='eslogan' size='60' maxlength='255' value="<?php echo $_POST['eslogan'];?>">
</div>

<br>

<div class='col-2'><input type='submit' class='btn' name='subm' value="<?php echo i("creargr",$ilink);?>">
</div>

</form>

