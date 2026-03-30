<?php

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

if($usuid != $_SESSION['usuid']) {return;}

// --------------------------------------------------------------
// Forma fotos

if ($_POST['modofoto']) {
	$ilink->query("UPDATE usuarios SET modofoto = '".$_POST['modofoto']."' WHERE id = '".$_SESSION['usuid']."'");
	$_SESSION['modofoto'] = $_POST['modofoto'];
}

// --------------------------------------------------------------
// Formato fecha

if ($_POST['fecha']) {
	$ilink->query("UPDATE usuarios SET dateformat = '".$_POST['fecha']."' WHERE id = '".$_SESSION['usuid']."'");
	$_SESSION['dformat'] = $_POST['fecha'];
}

// --------------------------------------------------------------
// Idiomas
$IDIOMAS = ['c','v','i'];

// 1) Sesión manda si existe
$idioma = $_SESSION['i'] ?? '';

// 2) Si no hay en sesión, intenta cookie
if ($idioma === '') {
    $i = $_COOKIE['i'] ?? '';
    if (in_array($i, $IDIOMAS, true)) $idioma = $i;
}

// 3) Como último recurso, BD (si tienes $usuid del usuario autenticado)
if ($i === '' && !empty($usuid)) {
    
    if ($res = $ilink->query("SELECT idioma FROM usuarios WHERE id=$usuid LIMIT 1")) {
        if ($row = $res->fetch_row()) {
            if (in_array($row[0], $IDIOMAS, true)) {
                $i = $row[0];
                $_SESSION['i'] = $i;           // cachea en sesión
                setcookie('i', $i, [           // sincroniza cookie
                  'expires'=>time()+60*60*24*180,
                  'path'=>'/',
                  'secure'=>!empty($_SERVER['HTTPS']),
                  'httponly'=>false,
                  'samesite'=>'Lax',
                ]);
            }
        }
    }
}

if ($_POST['idioma']) {
	
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
 	   $sel = trim($_POST['idioma'] ?? '');
    	if (!in_array($sel, $IDIOMAS, true)) { $sel = 'c'; }

    	// 1) Guardar en BD
    	$stmt = $ilink->prepare("UPDATE usuarios SET idioma=? WHERE id=?");
    	$stmt->bind_param('si', $sel, $usuid);
    	$stmt->execute();
    	$stmt->close();

    	// 2) Guardar en cookie (180 días)
    	$cookieOpts = [
        'expires'  => time() + 60*60*24*180,
        'path'     => '/',
        'secure'   => !empty($_SERVER['HTTPS']),
        'httponly' => false,
        'samesite' => 'Lax',
    	];
    	setcookie('i', $sel, $cookieOpts);
    	$_SESSION['i'] = $sel;

	}
	
}

// --------------------------------------------------------------
// Paletas válidas
$PALETAS = PALETAS; //['azul','amarillo','verde','marron','lila'];

// 1) Sesión manda si existe
$paleta = $_SESSION['paleta'] ?? '';

// 2) Si no hay en sesión, intenta cookie
if ($paleta === '') {
    $c = $_COOKIE['paleta'] ?? '';
    if (in_array($c, $PALETAS, true)) $paleta = $c;
}

// 3) Como último recurso, BD (si tienes $usuid del usuario autenticado)
if ($paleta === '' && !empty($usuid)) {
    if ($res = $ilink->query("SELECT colores FROM usuarios WHERE id=$usuid LIMIT 1")) {
        if ($row = $res->fetch_row()) {
            if (in_array($row[0], $PALETAS, true)) {
                $paleta = $row[0];
                $_SESSION['paleta'] = $paleta;           // cachea en sesión
                setcookie('paleta', $paleta, [           // sincroniza cookie
                  'expires'=>time()+60*60*24*180,
                  'path'=>'/',
                  'secure'=>!empty($_SERVER['HTTPS']),
                  'httponly'=>false,
                  'samesite'=>'Lax',
                ]);
            }
        }
    }
}

if($_POST['paleta']) {

	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
 	   $sel = trim($_POST['paleta'] ?? '');
    	if (!in_array($sel, $PALETAS, true)) { $sel = 'azul'; }

    	// 1) Guardar en BD
    	$stmt = $ilink->prepare("UPDATE usuarios SET colores=? WHERE id=?");
    	$stmt->bind_param('si', $sel, $usuid);
    	$stmt->execute();
    	$stmt->close();

    	// 2) Guardar en cookie (180 días)
    	$cookieOpts = [
        'expires'  => time() + 60*60*24*180,
        'path'     => '/',
        'secure'   => !empty($_SERVER['HTTPS']),
        'httponly' => false,
        'samesite' => 'Lax',
    	];
    	setcookie('paleta', $sel, $cookieOpts);
    	$_SESSION['paleta'] = $sel;

	}

}

// --------------------------------------------------------------
// Estoy y me siento

$icono = $_GET['ms'];

$ms = $ilink->query("SELECT mesiento, estoy FROM usuarios WHERE id = '".$_SESSION['usuid']."'");
$ms = $ms->fetch_array(MYSQLI_BOTH);
$ms = $ms[0];

if($estoy1) {
	$ilink->query("UPDATE usuarios SET estoy = \"$estoy\" WHERE id = '".$_SESSION['usuid']."'");
}

if((!$ms OR $ms != $icono) AND $icono) {
	$mesiento = $icono;
} elseif ($ms AND $ms == $icono) {
	$mesiento = "";
} else {
	return;
}

$ilink->query("UPDATE usuarios SET mesiento = '$mesiento' WHERE id = '".$_SESSION['usuid']."'");

?>