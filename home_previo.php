<?php

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

require_once APP_DIR . '/autos.php';

function home_previo($id, $ilink) {

	$auto = autoini($id,$ilink);

	if (!is_numeric($auto) || $auto < 2) {
		return $auto;  // no entra, $auto es un texto explicativo del por qué no entra
	}

	require_once APP_DIR . '/usosistema.php';
	sesion('', (int)$id, $ilink); //registro en usosistema de que entra el usuario
	recordar((int)$id,$ilink);

	// Login correcto
	session_regenerate_id(true);  // genera un nuevo ID y borra el viejo

	$_SESSION['auto'] = $auto;
	$_SESSION['usuid'] = (int)$id;
	$_SESSION['entra'] = 1;

	if (in_array((int)$id, $_SESSION['superadmins_cache'], true)) {
   	$_SESSION['soy_superadmin'] = true;
	}

	// Preparar la sentencia
	$stmt = $ilink->prepare("SELECT pass_hash, tipo, profpanel FROM usuarios WHERE id = ?");
	$stmt->bind_param("i", $_SESSION['usuid']);
	$stmt->execute();

	// Obtener resultado
	$result = $stmt->get_result();
	$pass   = $result->fetch_assoc();
	$stmt->close();

	// Comprobar si la contraseña es "123456" o "12345678"
	if (password_verify("123456", $pass['pass_hash']) || password_verify("12345678", $pass['pass_hash'])) {
		header("Location: ".APP_URL."/ficha.php?op=24"); exit;
	}
		
	if (isset($pass[1]) && $pass[1] == "P" && empty($pass[2])) {
   		unset($_SESSION['entra']); header("Location: ".DOMINIO.APP_URL."/ficha.php?op=3");exit;
	}
		
	header("Location: home.php");exit;
		
}

?>