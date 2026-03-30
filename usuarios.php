<?php

require_once __DIR__ . "/siempre.php";

require_once APP_DIR . "/perfil/unmens.php";

extract($_GET);
extract($_POST);

if($usuid == $_SESSION['usuid'] AND $_GET['usuid'] == $_SESSION['usuid']) {
	$us = "m";
}

if($us) {$_SESSION['us'] = $us;}
$us = $_SESSION['us'];
if($_GET['us'] == "l") {$_SESSION['sql'] = "";}

// --------------------------------------------------

if($us != 'm') {
	$titpag = "<span class='icon-users'></span> <a href='usuarios.php?us=l'>".i("usus",$ilink)."</a>";
	$a_usus = "active";
} else {
	$titpag = "<span class='icon-bubble3'></span> <a href='usuarios.php?us=m'>".i("mensajes",$ilink)."</a>";
	$a_mess = "active";
}

if($us == "l") {
// --------------------------------------------------
if($usuid == $_SESSION['usuid']) {
	if($no_geo) {$ilink->query("UPDATE usuarios SET geo = '' WHERE id='".$_SESSION['usuid']."'");}
	$result = $ilink->query("SELECT geo FROM usuarios WHERE id = '$usuid'");
	$fila = $result->fetch_array(MYSQLI_BOTH);
	if($fila[0] OR $_POST['myInputLatitud']) {
		//$body = "onload='cargarmap()'";$cargamapa = 1;
	}
}
// --------------------------------------------------
}
require_once APP_DIR . "/molde_top.php";

// --------------------------------------------------

if($us == "m" OR ($us == "b" AND !$_POST['listar']) OR ($_GET['usuid'] AND $_GET['usuid'] != $_SESSION['usuid'])){
	if($us == "b" AND !$_GET['usuid'] AND !$_GET['histo']) {
		echo "<div class='col-5 fl'>";
			require_once APP_DIR . "/sqlusuarios.php";
		echo "</div>";
		$_SESSION['sql'] = $sql." LIMIT 500";
		require_once APP_DIR . "/molde_bott.php";	return;
	} else {
		require_once APP_DIR . "/perfil/mensajes.php";
	}
}

// --------------------------------------------------

if($_POST['listar'] OR ($us != "m" AND $us != "b" AND !$_GET['usuid'])) {
	//echo "<div class='col-4 fl contiene'>";
	if($us != "m") {
		$class = "selected='selected'";
		if ($us == 'l') {$class_l = $class;}
		if ($us == 'a') {$class_a = $class;}
		if ($us == 'b') {$class_b = $class;}
		if ($us == 'c') {$class_c = $class;}
		echo "<form style='margin:15px' action='usuarios.php?m=1' method='post'>";
		echo "<select style='border:1px solid #c0c0c0' name='us' onchange='javascript:this.form.submit()'>";
		echo "<option $class_l value='l'>".i("usuonline",$ilink)."</option>";
		echo "<option $class_a value='a'>".i("siguiendo",$ilink)."</option>";
		echo "<option $class_c value='c'>".i("usuconmens",$ilink)."</option>";
		echo "<option $class_b value='b'>".i("buscarusu",$ilink)."</option>";
		echo "</select>";
		echo "</form>";
		if($_POST['listar']) {
			$noformu = 1;
			require_once APP_DIR . "/sqlusuarios.php";
			$_SESSION['sql'] = $sql." LIMIT 500";
		}

	}
	?>
	<div id="jusuonline">	
		<script language="javascript">jusuonline();</script>
	</div><br>
	<!-- </div> -->
	<?php
	
}

// --------------------------------------------------

require_once APP_DIR . "/molde_bott.php";

?>