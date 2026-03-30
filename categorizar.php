<?php

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

$asigna = $_SESSION['asigna'];

// --------------------------------------------------

$tit = " CATEGORIZAR V&Iacute;NCULOS";

// --------------------------------------------------

if (!$_SESSION['gc']) {return;}

extract($_GET);
$vinc = $id;
$pclave = $_GET['pclave'];
$filtro = "pclave=$pclave";
if ($_GET['pclave1']) {$filtro = "pclave1=".$_GET['pclave1'];}

if ($_POST['categ']) {
	$iresult = $ilink->query("SELECT idcat FROM vinculos WHERE id = '$vinc' LIMIT 1");
	$idcat = $iresult->fetch_array(MYSQLI_BOTH);
	$todos = 1;
	foreach($_POST['cat'] as $clave=>$valor) {
		$ilink->query("UPDATE vinculos SET gc$clave = '$valor' WHERE id = '$vinc' LIMIT 1");
		if ($valor == "") {$todos = 0;}
	}
	if ($todos AND !$idcat[0]) {
		$ilink->query("UPDATE vinculos SET idcat = '".$_SESSION['usuid']."' WHERE id = '$vinc' LIMIT 1");
	}
}

$iresult = $ilink->query("SELECT titulo FROM vinculos WHERE id = '$vinc' LIMIT 1");
$fila = $iresult->fetch_array(MYSQLI_BOTH);

echo "<br><form name='form1' method='post'>";

require_once APP_DIR . '/cat.php';
$i = 0;

$iresult = $ilink->query("SELECT gc0, gc1, gc2, gc3, gc4, idcat FROM vinculos WHERE id = '$vinc' LIMIT 1");
$vinc = $iresult->fetch_array(MYSQLI_BOTH);
if ($vinc['idcat'] AND $vinc['idcat'] != $_SESSION['usuid'] AND $_SESSION['auto'] < 5) {return;}
foreach($cat as $clave=>$valor){
	echo "$valor[0]<br><select name='cat[]'><option value=''></option>";
	foreach($valor as $clave1=>$valor1){
		if ($clave1 != "0") {
			echo "<option value='$clave1'";
			if ($vinc[$i] == $clave1) {echo " selected='selected'";}
			echo ">$valor1</option>";
		}
	}$i++;
	echo "</select><p></p>";
}

echo " <input class='col-1' name='categ' type='submit' value=' >> '>";
echo "</form>";

?>