<?php

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

$_SESSION['fabrir'] = 1;

//Previamente en home.php se hace un SELECT * FROM usuarios para el id en cuestion.
extract($fila);

// --------------------------------------------------

if ($_SESSION['entra']) {
		
	if(!demo_enabled()) { 

		$ilink->query("INSERT INTO message_histo SELECT * FROM message WHERE isread = 1 AND parausuid = '$id'");
		$ilink->query("INSERT INTO message_histo SELECT * FROM message WHERE isread = 1 AND usuid = '$id'");

		$ilink->query("DELETE FROM message WHERE isread = 1 AND parausuid = '$id'");
		$ilink->query("DELETE FROM message WHERE isread = 1 AND usuid = '$id'");

		$iresult = $ilink->query("SELECT id FROM message WHERE isread = 0 AND parausuid = '$id'");
		$_SESSION['porleer'] = $iresult->num_rows;

		$timestamp = time();
		$ip = filter_var($_SERVER['REMOTE_ADDR'], FILTER_VALIDATE_IP) ?: '0.0.0.0';

		$timestamp = time();
		$corte = gmdate('Y-m-d H:i:s', $timestamp - 30);
		$ilink->query("UPDATE usuarios SET recarga = 1 WHERE fecha >= '$corte'");

		$iresult = $ilink->query("SELECT tultimo+tacumulado, privacidad FROM usuarios WHERE id = '$id' LIMIT 1");
		$t = $iresult->fetch_array(MYSQLI_BOTH);
		$_SESSION['mipriv'] = $t[1];
		$ilink->query("UPDATE usuarios SET ip='$ip', fechalogin = '".gmdate('Y-m-d H:i:s')."', tacumulado = '$t[0]', tultimo = 0  WHERE id = '$id' LIMIT 1");

// --------------------------------------------------

		$iresult = $ilink->query("SELECT COUNT(id) FROM vinculos");
		$numvinc = $iresult->fetch_array(MYSQLI_BOTH);
		$ilink->query("UPDATE atencion SET numvinc = '$numvinc[0]'");
		$_SESSION['numvinc'] = $numvinc[0];
	
// --------------------------------------------------
	
	}

	$_SESSION['tipo'] = $tipo;
	$_SESSION['dformat'] = $dateformat;
	$_SESSION['confoto'] = $confoto;
	$_SESSION['numvinc1'] = $numvinc1;
	$_SESSION['modofoto'] = $modofoto;
	
	$asigna = $ultasigna;
	$curso = $ultcurso;
	$grupo = $ultgrupo;
	
	// le pasa estas tres variables a var_asig
	
}

?>