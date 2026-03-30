<?php

ob_start();

require_once __DIR__ . '/siempre_base.php';
require_once APP_DIR . '/login_func.php';
require_once APP_DIR . '/index_zone.php';
include_once APP_DIR . "/home_previo.php";

// === SALIR si viene ?x ===
if (isset($_GET['x'])) {

	require_once APP_DIR . '/index_sale.php';
	
   session_destroy();
 	
 	header("Location: login.php?x=1"); exit;

}

// --------------------------------------------------

$_SESSION['index'] = 1;

require_once APP_DIR . '/_superadmins.php';
cargar_superadmins($ilink);

// --------------------------------------------------

if(!$_GET['x'] AND !$_SESSION['usuid']) {
	
	// Si no está logueado pero hay cookie de recordar, comprobamos
	$cookieName = defined('SITE') ? SITE : 'evai';
	$cookieVal  = $_COOKIE[$cookieName] ?? '';

	if ($cookieVal !== '' && preg_match('/^[a-f0-9]{64}\z/i', $cookieVal)) {
    	$stmt = $ilink->prepare("SELECT id, usuario, menusimple, recordar FROM usuarios WHERE recordar LIKE CONCAT('%', ?, '%') LIMIT 1");
    	$stmt->bind_param('s', $cookieVal);
   	$stmt->execute();
   	$res = $stmt->get_result();
   	if ($row = $res->fetch_assoc()) {
       	 // Verificamos que el token exacto está en la lista (no solo LIKE)
        	$tokens = array_filter(explode('*', (string)$row['recordar']));
       	if (in_array($cookieVal, $tokens, true)) {
      	    // Login automático
       	    // quito modo demo
          	 $_SESSION['demo_mode'] = false;
         	 $_SESSION['usuid']      = (int)$row['id'];
        	    $_SESSION['usuario']    = $row['usuario'];
   			 $_SESSION['soy_superadmin'] = in_array((int)$_SESSION['usuid'], $_SESSION['superadmins_cache'], true);
				 $porquenoentro = home_previo($_SESSION['usuid'], $ilink);  //dentro de home_previo, si procede, se hace Location: a home
      	}
   	}
   	$stmt->close();
	}	

	//En $porquenoentro esta el motivo por el que se vuelve a login
	//Si hay algun motivo por el que existe $porquenoentro tendre que borrar sesion y cookie y volver a login
	
}

// --------------------------------------------------

 header("Location: login.php");

?>
