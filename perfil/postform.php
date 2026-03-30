<?php

require_once __DIR__ . '/../siempre_base.php';

extract($_GET);
extract($_POST);
if (!$usuid) {return;}

require_once APP_DIR . '/hiperen.php';
require_once APP_DIR . '/tamano.php';
require_once APP_DIR . '/perfil/unmens.php';

if ($vid) {
	$iresult = $ilink->query("SELECT usuario FROM usuarios WHERE id = '$usuid' LIMIT 1");
	$vid = $iresult->fetch_array(MYSQLI_BOTH);
	$message = "[<a class='b' href='http://www.mebeam.com/$usuid$vid[0]' target='_blank'>Videochat</a>]";
}

$message = addslashes($message);

$nomatach = $_FILES['file']['name'];
if ($nomatach) {$message .= " - env&iacute;a ".$nomatach;}

if (!$message) {return;}

$temp = gmdate("Y-m-d H:i:s");
$temp1 = gmdate("Y-m-d H:i:s");

if ($nomatach) {
	$tipo    = $_FILES["file"]["type"];
	$archivo = $_FILES["file"]["tmp_name"];
	$tamanio = $_FILES["file"]["size"];
	$contenido = file_get_contents($archivo);
	$contenido = $ilink->real_escape_string($contenido);
}

$result = $ilink->query("INSERT INTO message (isread, message, usuid, parausuid,
 date, tamatach, tipoatach, nomatach, attachment) VALUES ('0', \"$message\", '".$_SESSION['usuid']."', '$usuid',
 '$temp', '$tamanio', '$tipo', \"$nomatach\", \"$contenido\")");
$lastid = $ilink->insert_id;

if ($result) {
	$ilink->query("INSERT IGNORE INTO message_usus (usuid, parausuid) VALUES ('".$_SESSION['usuid']."', '$usuid')");
	$sql = "SELECT usuid, message, date, isread, usuarios.alumnon, tamatach, nomatach, message.id 
			FROM message LEFT JOIN usuarios ON usuarios.id = message.usuid WHERE message.id = '$lastid'";
	$result = $ilink->query($sql);
	$mens = unmensa($sql,2,$ilink,'');
	$mens = str_replace("\r","", $mens);
	$mens = addslashes($mens);

	?>
	<script language="JavaScript">
 	 	parent.document.getElementById('mensajes').innerHTML += "<?php echo $mens;?>";
		parent.document.getElementById('mensajes').scrollTop = 1000000;
		parent.document.getElementById('esperar').style.display = 'none';
		parent.document.getElementById('message').value = '';
		parent.document.getElementById('file').value = '';
		parent.document.getElementById('message').focus();
	</script>
	<?php	
}

?>