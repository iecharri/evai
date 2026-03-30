<?php

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

$iresult = $ilink->query("SELECT mandoadist FROM cursasigru WHERE 
 asigna = '".$_SESSION['asigna']."' AND curso = '".$_SESSION['curso']."' AND grupo = '".$_SESSION['grupo']."'");
$activo = $iresult->fetch_array(MYSQLI_BOTH);

if ((!$activo[0] AND $_GET['act'] != 1) OR $_GET['act'] == 2) {return;}

if (($_GET['op'] == 6 AND $_GET['apli'] == 4)  OR $_GET['mandooff'] == 2) {
	$_SESSION['mando'] = 1;
	$_SESSION['mandotw'] = '';
}
if ($_GET['mandooff'] == 1 OR $_SESSION['mandotw'] OR ($_GET['op'] == 6 AND $_GET['apli'] == 5)) {
	$_SESSION['mando'] = "";
}
if (!$_SESSION['mando']) {
	return;
}

if ($_GET['cl']) {
	if ($activo[0]) {
		if ($_GET['cl'] == "*") {$_GET['cl']= 0;}
		$ilink->query("INSERT IGNORE INTO mandoadist (asigna, curso, grupo, usuid, click) VALUES 
	('".$_SESSION['asigna']."', '".$_SESSION['curso']."', '".$_SESSION['grupo']."', '".$_SESSION['usuid']."', '".$_GET['cl']."')");
	}
}

echo "<div id='mandotw'>";

	echo "<div class='col-10 contiene nowrap wincruz'>";
	echo "<a href='indexrecursos.php?op=6&apli=2&mandooff=1' class = 'fr icon-cross rojo'></a>";
	if($_SESSION['auto'] > 4) {
		echo "<a class='colorbl b peq' href='indexrecursos.php?op=6&apli=2'>Resultado</a>";
	}
	echo "</div><p></p>";

	$div = 'mandotw';
	$vars = variables($_GET);

	echo "<a href='?$vars&cl=7' class='col-3 colu' style='padding:.7em'>7</a>";
	echo "<a href='?$vars&cl=8' class='col-3 colu' style='padding:.7em'>8</a>";
	echo "<a href='?$vars&cl=9' class='col-3 colu' style='padding:.7em'>9</a><p></p><br>";
	echo "<a href='?$vars&cl=4' class='col-3 colu' style='padding:.7em'>4</a>";
	echo "<a href='?$vars&cl=5' class='col-3 colu' style='padding:.7em'>5</a>";
	echo "<a href='?$vars&cl=6' class='col-3 colu' style='padding:.7em'>6</a><p></p><br>";
	echo "<a href='?$vars&cl=1' class='col-3 colu' style='padding:.7em'>1</a>";
	echo "<a href='?$vars&cl=2' class='col-3 colu' style='padding:.7em'>2</a>";
	echo "<a href='?$vars&cl=3' class='col-3 colu' style='padding:.7em'>3</a><p></p><br>";
	echo "<a href='?$vars&cl=*' class='col-3 colu' style='padding:.7em'>0</a>";
	
echo "</div>";

function variables($get) {
	foreach ($get AS $key => $value) {
		$var .= "&".$key."=".$value;
	}
	return $var;
}

?>