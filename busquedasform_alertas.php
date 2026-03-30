<?php

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

if ($_SESSION['auto'] < 2) {return;}

if ($_POST['buscar1']){
	$uid = $_SESSION['usuid'];
	$guardar = $_POST['claves0'];
	$ilink->query("UPDATE usuarios SET buscar = '$guardar' WHERE id = '$uid' LIMIT 1");
}

?>

<form name='form1' method='post' target='_self' class='center'>

	<p></p>

	<?php 
	if ($_SESSION['auto'] > 3) {
		echo i("avisarmail",$ilink)." ";
		$uid = $_SESSION['usuid'];
		$iresult = $ilink->query("SELECT id, buscar FROM usuarios WHERE id = '$uid' LIMIT 1");
		$fila = $iresult->fetch_array(MYSQLI_BOTH);
		if ($fila[0]) {
			echo "<p></p><input class='col-1' type='text' id='claves0' name='claves0' size='10' maxlength='255' value='".$fila[1]."'> 
			<input type='submit' class='col-1' name='buscar1' value='>>'>";
		}
	}

	?>

</form>
