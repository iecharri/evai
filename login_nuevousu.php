<?php

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

require_once __DIR__ . '/siempre_base.php';

// Leer bandera en BD (con fallback seguro)
$altalibre = 0;
if ($res = $ilink->query("SELECT altalibre FROM atencion LIMIT 1")) {
    if ($row = $res->fetch_array(MYSQLI_NUM)) {
        $altalibre = (int) $row[0];
    }
    $res->free();
}

// Si el alta libre está desactivada en config o en BD → cortar
if (!defined('OLVIDO_YNUEVOUSU') || !OLVIDO_YNUEVOUSU || $altalibre !== 1) {
    http_response_code(404); // mejor 404 para no dar pistas
    exit; // fin de la petición
}

extract($_SESSION);
extract($_GET);
extract($_POST);

// --------------------------------------------------

echo "<h3><span class='anch'><span class='icon-user-plus'></span>".strtoupper($clogin)." ".i("nuevousu",$ilink)."</span></h3>";

if($_POST['nuevou']) {
	require_once APP_DIR . '/validarchars.php';
	$mal = versidatosok($ilink,$script);
	if(!$mal[0]) {
		alta($ilink);
		return;
	}
}

// --------------------------------------------------

extract($_POST);
echo "<form name='form' method='post' action='login.php'>";
require_once APP_DIR . '/form_newusu.php';
echo "<input type='submit' name='nuevou' value=\"".i("enviar",$ilink)."\">";
echo "</form>";
	
// --------------------------------------------------

function alta($ilink) {

	extract($_POST);
	mt_srand((double)microtime()*1000000);
	$passwordinicial = mt_rand(100000,999999);
	$edcurasigru = explode("*",$edcurasigru);
	$asigna = $edcurasigru[1];
	$curso = $edcurasigru[0]; 
	$grupo = $edcurasigru[2]; 

	// IP
	$ip = filter_var($_SERVER['REMOTE_ADDR'], FILTER_VALIDATE_IP) ?: '0.0.0.0';

// --------------------------------------------------

	$datospers = datospers($ilink)."<br>IP de alta: $ip<br>Fecha de alta (UTC): ".gmdate('d-m-Y H:i:s');

// --------------------------------------------------

	// ID del Administrador remitente de mails
	$iresult = $ilink->query("SELECT adminid FROM atencion");
	$from = $iresult->fetch_array(MYSQLI_BOTH);
	$idadmin = $from[0];
	unset($from);
	$from = $idadmin; //esto añado en sept 2025 
	$iresult = $ilink->query("SELECT alumnon, alumnoa,mail FROM usuarios WHERE id = '$idadmin' LIMIT 1");
	$admi = $iresult->fetch_array(MYSQLI_BOTH);
	$nombreadmi = "<a href='mailto:$admi[2]'>$admi[0] $admi[1]</a>";

	// Autorizaci&oacute;n, remitente y destinatario del correo
	if ($tipo == "A") {
		$sql = "SELECT altalibre,patronmail FROM cursasigru WHERE asigna = '$asigna' AND curso = '$curso' AND grupo = '$grupo'";
		$iresult = $ilink->query($sql);
		$fila = $iresult->fetch_array(MYSQLI_BOTH);
		extract($fila);
		if ($altalibre OR ($patronmail AND stristr($mail,trim($patronmail)))) {
			$autorizado = 3;
		} else {
			$autorizado = 0;
			$to = "p";
		}
	}

	if ($tipo == "E") {
		$autorizado = 3;
		//$from = $idadmin;
		$asigna = ""; $curso = ""; $grupo = "";
	}
	
	if ($tipo == "P") {
		$autorizado = 0;
	}

// --------------------------------------------------

// Alta en usuarios
	try {
    // --- Recoge y normaliza datos ---
    $usuario         = trim((string)($usuario         ?? ''));
    $tipo            = trim((string)($tipo            ?? ''));
    $password        = (string)($password             ?? '');
    $passwordinicial = trim((string)($passwordinicial ?? '')); // si puedes, guarda NULL en vez de texto plano
    $alumnon         = trim((string)($alumnon         ?? ''));
    $alumnoa         = trim((string)($alumnoa         ?? ''));
    $mail            = trim((string)($mail            ?? ''));
    $autorizado      = (int)   ($autorizado           ?? 3);   // <- entero
    $ipalta          = (string)($_SERVER['REMOTE_ADDR'] ?? '');
    $dni             = trim((string)($dni             ?? ''));
    $ultasigna       = trim((string)   ($asigna               ?? ''));
    $ultcurso        = trim((string)   ($curso                ?? ''));
    $ultgrupo        = trim((string)   ($grupo                ?? ''));

	 // 1) Guardas el hash de la contraseña elegida
	 $pass_hash = password_hash($password, PASSWORD_DEFAULT);

	 // 2) Generas token para activar y guardas SOLO su hash en passwordinicial
	 $token      = bin2hex(random_bytes(16));          // esto lo enviarás por email
	 $token_hash = password_hash($token, PASSWORD_DEFAULT); // esto es lo que guardas

 	 $sql = "INSERT INTO usuarios (usuario, tipo, pass_hash, passwordinicial, alumnon, alumnoa, mail, autorizado, ipalta, fechaalta, dni, ultasigna, ultcurso, ultgrupo)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, UTC_DATE(), ?, ?, ?, ?)";

	 $stmt = $ilink->prepare($sql);
	 $stmt->bind_param('sssssssis' . 'ssss', $usuario, $tipo, $pass_hash, $token_hash, $alumnon, $alumnoa, $mail, $autorizado, $ipalta, $dni, $ultasigna, $ultcurso, $ultgrupo);
	 $stmt->execute();
	 $uid = $ilink->insert_id;
    $stmt->close();

	} catch (mysqli_sql_exception $e) {
    error_log("SQL error ({$e->getCode()}): ".$e->getMessage());
    die("❌ Error en la base de datos. Contacta con el administrador.");
	}

	$sql = "SELECT id FROM usuarios WHERE usuario = '$usuario' LIMIT 1";
	$iresult = $ilink->query($sql);
	$fila = $iresult->fetch_array(MYSQLI_BOTH);
	$id = $fila['id'];

	// 3) Email de activación (SIN contraseña)
	$link = APP_URL . "/activar.php?u={$uid}&t={$token}";
	// envías $link por email

// --------------------------------------------------

	// Alta en usuasi
	if ($tipo == "E") {$asigna = "GEN";$mailto = $id;}
	$sql = "INSERT INTO usuasi (id, asigna) VALUES ('$id', '$asigna')";
	$ilink->query($sql);

	// Alta en alumasiano
	if ($tipo == "A") {
		$sql = "INSERT INTO alumasiano (id, asigna, curso, grupo, veforo, auto) VALUES ('$id', '$asigna', '$curso', '$grupo', '1', 4)";
		$ilink->query($sql);
	}

// --------------------------------------------------

	$url  = DOMINIO . APP_URL . "/activ.php?u={$uid}&t={$token}";  // URL pura

	// Para email HTML:
	$linkacti = '<a href="' . $url . '">Activar cuenta</a>';

	$fecha = gmdate("d-m-Y");

	// Mandar mail al usuario (E o A) con su enlace de activaci&oacute;n
	//if ($from == $idadmin) {
		if($tipo == "E" || $tipo == "A") {
		$mailasunto = i("altamailasunto_ea",$ilink);
		$mailtexto  = i("altamailtexto_ea",$ilink);
		$mailfrom = $idadmin;
		$mailto = $id;
		$mensaje = i("altamens_ea",$ilink);
		$mensaje = str_replace("<linksite>","<a href='" . DOMINIO . APP_URL . "/index.php'>".strtoupper(SITE)."</a>",$mensaje);
	}

	// Mandar mail a profesor(es) para que le env&iacute;en su enlace de activaci&oacute;n
	if ($to == "p") {
		$mailasunto = "Solicitud de alta de alumno en ".ucfirst(SITE);
		$mailtexto  = i("altamailtexto_p_a",$ilink)." ".i("altareenvia",$ilink)."<br>".$datospers."<hr>".i("altamailtexto_ea",$ilink);
		$mailfrom = $id;
		$mensaje = i("altamens_p",$ilink);
		$mensaje = str_replace("<linksite>","<a href='" . DOMINIO . APP_URL . "/index.php'>".strtoupper(SITE)."</a>",$mensaje);
	}

	// Mandar mail al Administrador, el usuario solicita ser profesor
	if ($tipo == "P") {
		$mailasunto = "Solicitud de alta de profesor en ".strtoupper(SITE);
		$mailtexto  = i("altamailtexto_p",$ilink)." ".i("altareenvia",$ilink)."<br>".$datospers."<hr>".i("altamailtexto_ea",$ilink);
		$mailfrom = $id;
		$mailto = $idadmin;
		$mensaje = i("altamens_p",$ilink);
		$mensaje = str_replace("<linksite>","<a href='" . DOMINIO . APP_URL . "/index.php'>".strtoupper(SITE)."</a>",$mensaje);
	}

	$mailtexto = reempl("<linkacti>",$linkacti,$mailtexto);
	$mailtexto = reempl("<fecha>", $fecha,$mailtexto);
	$mailtexto = reempl("<clave>", $password,$mailtexto);
	$mailtexto = reempl("<usuario>", $usuario,$mailtexto);
	$mailtexto = reempl("<alumnon>", $alumnon,$mailtexto);
	$mailtexto = reempl("<alumnoa>", $alumnoa,$mailtexto);
	$mailtexto = reempl("<mail>", $mail,$mailtexto);
	if ($tipo == "A") {$tip = i("alumno",$ilink);}
	if ($tipo == "P") {$tip = i("profesor",$ilink);}
	if ($tipo == "E") {$tip = i("externo",$ilink);}
	$mailtexto = reempl("<tipo>", $tip,$mailtexto);
	$mailtexto = reempl("<asigna>", $asigna,$mailtexto);
	$mailtexto = reempl("<curso>", $curso,$mailtexto);
	$mailtexto = reempl("<grupo>", $grupo,$mailtexto);

	if ($to == "p") {  //Alumno sin alta libre

		//buscar prof de asigna-curso-grupo
		$temp = $ilink->query("SELECT usuid FROM asignatprof WHERE asigna = '$asigna' AND curso = '$curso' AND grupo = '$grupo'");
		if ($temp->num_rows) {
			while ($fila = $temp->fetch_array(MYSQLI_BOTH)) {
				//enviar mail a cada profesor
				$exito = pormail($mailfrom,$fila[0],$mailasunto,$mailtexto,'',$ilink);
			}
		}

	} elseif ($mailfrom AND $mailto) {  //Externo

		$exito = pormail($mailfrom,$mailto,$mailasunto,$mailtexto,'',$ilink);

	} else {

		$mensaje = i("reghecho",$ilink).". <a href='" . DOMINIO . APP_URL ."/index.php'>".i("entrar",$ilink)."</a>.";
		echo "<div class='le justify'><br>$mensaje<br></div>";
		session_unset();
		session_destroy();
		return;
	
	}

	$mensaje = reempl("<fecha>", "<span class='txth b'>".$fecha."</span>",$mensaje);
	$mensaje = reempl("<clave>", "<span class='txth b'>".$password."</span>",$mensaje);
	$mensaje = reempl("<usuario>", "<span class='txth b'>".$usuario."</span>",$mensaje);
	$mensaje = reempl("<alumnon>", "<span class='txth b'>".$alumnon."</span>",$mensaje);
	$mensaje = reempl("<mail>", "<span class='txth b'>".$mail."</span>",$mensaje);
	$mensaje = reempl("<admi>", "<span class='txth b'>".$nombreadmi."</span>",$mensaje);

	echo "<div class='le justify'><br>$mensaje<br></div>";

	session_unset();
	session_destroy();

}

// --------------------------------------------------

function datospers($ilink) {

	extract($_POST);

	$datospers = "<br>".i("usuario",$ilink).": ".$usuario;
	$datospers .= "<br>".i("nombre",$ilink).": ".$alumnon;
	$datospers .= "<br>".i("apellidos",$ilink).": ".$alumnoa;
	$datospers .= "<br>".i("mail",$ilink).": ".$mail;
	$datospers .= "<br>".i("dni",$ilink).": ".$dni;
	$datospers .= "<br>".i("tipo",$ilink).": ";
	if ($tipo == "A") {
		$edcurasigru = explode("*",$edcurasigru);
		$datospers .= i("alumno",$ilink);
		$datospers .= "<br>".i("asigna",$ilink).": ".$edcurasigru[1];
		$datospers .= "<br>".i("curso",$ilink).": ".$edcurasigru[0];
		$datospers .= "<br>".i("grupo",$ilink).": ".$edcurasigru[2];
	}
	if ($tipo == "P") {
		$datospers .= i("profesor",$ilink);
		$datospers .= "<br>".i("deseoclave",$ilink).": ".$solicitar;
	}
	if ($tipo == "E") {$datospers .= i("externo",$ilink);}

	return $datospers;

}

?>
