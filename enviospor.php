<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;


require_once __DIR__ . '/siempre_base.php';

function porsms($textosms) {
	if ($textosms AND $_SESSION['auto'] > 4) {
	//return "javascript:window.open('http://www.virtualeidos.com/hurqt3h1.php?sms=$textosms', 
	//'win0', 'toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=400,height=400,left = 170,top = 50');return false;";
	}
}

function porhsm($message,$para,$guardar,$ilink) {
	$message = addslashes($message);
	$temp = gmdate("Y-m-d H:i:s");
	$sql = "INSERT INTO message (message, usuid, parausuid, date) VALUES (\"$message\", '".$_SESSION['usuid']."', '$para','$temp')";
	$ilink->query($sql);
	if ($ilink->errno) {die ("Error");}
	$ilink->query("INSERT IGNORE INTO message_usus (usuid, parausuid) VALUES ('".$_SESSION['usuid']."', '$para')");
	return 1;
}

function pormail($deid,$paraid,$asunto,$mensaje,$mensaje_alt,$ilink) {

if (demo_enabled()) {return 1;}
	$iresult = $ilink->query("SELECT mail FROM usuarios WHERE id = '$paraid' LIMIT 1");
	$para = $iresult->fetch_array(MYSQLI_BOTH);
	$exito = porphpmailer($deid,$para,$asunto, $mensaje,"","",$mensaje_alt,$ilink);
	return $exito;
}

function pormail_enti($deid,$paraid,$asunto,$mensaje,$mensaje_alt,$ilink) {
	$exito = porphpmailer($deid,$paraid,$asunto, $mensaje,"","",$mensaje_alt,$ilink);
	return $exito;
}

function pormailadj($deid,$paraid,$asunto,$mensaje,$conadjunto,$name,$ilink) {
	if (demo_enabled()) {return 1;}

	$para = explode(",", $paraid);
	$exito = porphpmailer($deid,$para,$asunto,$mensaje,$_FILES['adjunto']['tmp_name'],$_FILES['adjunto']['name'],'',$ilink);
	return $exito;
}

function pormail_n($deid,$para,$asunto,$mensaje,$mensaje_alt,$ilink) {
	if (demo_enabled()) {return 1;}

	$exito = porphpmailer($deid,$para,$asunto,$mensaje,"","",$mensaje_alt,$ilink);
	return $exito;
}

// Usando phpMailer

function porphpmailer($deid,$para,$asunto,$mensaje,$conadjunto,$name,$mensaje_alt,$ilink) {
	if (demo_enabled()) {return 1;}

	$iresult = $ilink->query("SELECT alumnon, alumnoa, mail FROM usuarios WHERE id = '$deid' LIMIT 1");	
	$de = $iresult->fetch_array(MYSQLI_BOTH);

	require_once(APP_DIR . '/phpmailer/PHPMailer.php');
	require_once(APP_DIR . '/phpmailer/SMTP.php');
	require_once(APP_DIR . '/phpmailer/Exception.php');

	$mail = new PHPMailer();
	
	$mail->SMTPDebug = 0;                         // nada por pantalla
   $mail->Debugoutput = 'error_log';             // si subes el nivel, que vaya al log
    
	$mail->IsSMTP(); //IsSendmail()
	$mail->PluginDir = APP_DIR."/";

	$mail->SMTPSecure = SMTPSECURE;
	$mail->Port = PORT;
	$mail->CharSet = 'UTF-8';

	$mail->Host = SMTP;
	$mail->SMTPAuth = SMTPAUTH;
	if (SMTPAUTH == 'true') {
		$mail->Username = USERNAME; 
		$mail->Password = PASSMAIL;
	}

	$cab = "<img src='". DOMINIO . MEDIA_URL . "/cabpeq.png'><a href='" . DOMINIO . APP_URL . "'>".strtoupper(SITE)."</a><p></p>";
	$cab_alt = DOMINIO .APP_URL. "\n\r";

	$body             = "<div>".$cab.$mensaje."</div>";
	$body 				= str_replace("\\", "", $body);

	$mail->From       = USERNAME;
	
	if ($conadjunto) {
		$mail->FromName   = "";
	} else {
		$mail->FromName   = strtoupper(SITE)." [No-Reply Email]";
	}

	$mail->Subject    = $asunto;

	if (!$mensaje_alt) {$mensaje_alt = "";} //"To view the message, please use an HTML compatible email viewer!";}
	$mail->AltBody    = $cab_alt."\n\r".$mensaje_alt.str_replace("<p>", "\n\r", str_replace("<p />", "\n\r", str_replace("<br>", "\n", str_replace("<br>", "\n", $mensaje)))); //.$mensaje;

	$mail->MsgHTML($body);

	foreach ($para as $clave => $valor) {
		$mail->AddBCC($valor);
	}

	if ($conadjunto) {
		$mail->AddAttachment($_FILES["adjunto"]["tmp_name"], $name);
	}

	if($mail->Send()) {
  		$exito = 1;
	}
	//echo $mail->ErrorInfo;
// --------------------------------------------------

	$paraid = implode(",",$para);
	$mensaje = str_replace('>',')',str_replace('<','(',$paraid))."*+*+*+*".$cab.$mensaje;

	if($conadjunto) {
		$mensaje .= "<p></p><span class='b'>".$_FILES['adjunto']['name']."</span>";
	}

	$paraid = -1;

	$temp = gmdate('Y-m-d H:i:s');
	$asunto = addslashes($asunto);
	$mensaje = addslashes($mensaje);

	$ilink->query("INSERT INTO enviospor (fecha, deid, paraid, tipo, mensaje1, mensaje2, exito) VALUES (\"$temp\", \"$deid\", \"-1\", \"mail\", \"$asunto\", \"$mensaje\", \"$exito\")");
	if ($ilink->errno) {die ("Error");}

	return $exito;
	
}

function enviarxmail($tipo,$tit,$asigna,$curso,$grupo,$ilink) {

	if (demo_enabled()) {return;}

	if ($tipo == "foro") {
		$campo = "forospormail";
	} elseif ($tipo == "noti") {
		$campo = "notispormail";
	} else {
		return;
	}

	if ($asigna) {
		$sql = "SELECT $campo FROM cursasigru WHERE asigna = '$asigna'";
		if ($curso) {$sql .= " AND curso = '$curso'";}
		if ($grupo) {$sql .= " AND grupo = '$grupo'";}
	} elseif ($tit) {
		$sql = "SELECT $campo FROM titcuradmi WHERE titulaci = '$tit'";
		if ($curso) {$sql .= " AND curso = '$curso'";}
	}

	$result = $ilink->query($sql);
	$fila = $result->fetch_array(MYSQLI_BOTH);
	if ($fila[0]) {return $fila[0];}

}

?>
