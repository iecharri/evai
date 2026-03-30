<?php

require_once __DIR__ . "/../siempre_base.php";


extract($fila);

$uid = $_SESSION['usuid'];

// --------------------------------------------------

$iresult = $ilink->query("SELECT tultimo+tacumulado FROM usuarios WHERE id = '$uid' LIMIT 1");
$t = $iresult->fetch_array(MYSQLI_BOTH);
$ilink->query("UPDATE usuarios SET fechalogin = '".gmdate('Y-n-d H:i:s')."', tacumulado = '$t[0]', tultimo = 0  WHERE id = '$uid'");

// --------------------------------------------------

$ip = filter_var($_SERVER['REMOTE_ADDR'], FILTER_VALIDATE_IP) ?: '0.0.0.0';
$ilink->query("UPDATE usuarios SET ip='$ip' WHERE id='$uid'");

// --------------------------------------------------

$_SESSION['tipo'] = $tipo;
$_SESSION['numvinc1'] = $numvinc;

?>