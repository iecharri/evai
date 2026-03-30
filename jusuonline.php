<?php

require_once __DIR__ . "/siempre_base.php";

if ($_SESSION['auto'] < 3 ) {
	exit;
}

require_once APP_DIR . "/perfil/accionesfp.php";

$ilink->query("UPDATE usuarios SET recarga=0 WHERE id='".$_SESSION['usuid']."'");

$us = $_SESSION['us'];

// --------------------------------------------------

if ($us == 'l') {
	
$timestamp = time(); // UTC actual
$corte = gmdate('Y-m-d H:i:s', $timestamp - 30); // Fecha hace 30 segundos

// Construcción del SQL en UTC puro
$temp = "SELECT id FROM usuarios WHERE fecha >= '$corte' AND estado < 2";

if ($_SESSION['auto'] < 10) {
	$temp .= " AND (autorizado < '" . $_SESSION['auto'] . "' OR estado = 0 OR id = '" . $_SESSION['usuid'] . "')";
}

$temp .= " ORDER BY fechalogin DESC";

// Ejecutar consulta
$result = $ilink->query($temp);

// Armar lista de IDs activos
$usuarios = "";
$n = 0;

while ($fila = $result->fetch_array(MYSQLI_BOTH)) {
	if ($usuarios) {
		$usuarios .= ",";
	} else {
		$n = 1;
	}
	$usuarios .= $fila[0];
}
	
if (demo_enabled()) {$usuarios = implode(', ', DEMO_ONLINE_IDS);}

} elseif ($us == 'a') {
	$usuarios = arrayamigos1($_SESSION['usuid'],$ilink); //sigo a	
} elseif ($us == 'c') {
	echo "<p></p>";
	$sql = "SELECT DISTINCT(usuid) FROM message WHERE parausuid = '".$_SESSION['usuid']."' AND isread = 0";
	$result = $ilink->query($sql);
	while ($fila = $result->fetch_array(MYSQLI_BOTH)) {
		if ($usuarios) {$usuarios .= ",";}
		$usuarios .= $fila[0];
	}
} elseif ($us == 'b' AND $_SESSION['sql']) {
	$result = $ilink->query($_SESSION['sql']);
	while ($fila = $result->fetch_array(MYSQLI_BOTH)) {
		if ($usuarios) {$usuarios .= ",";}
		$usuarios .= $fila[0];
	}
}

// --------------------------------------------------

listausuarios($usuarios,$ilink);

// --------------------------------------------------

?>
