<?php

require_once __DIR__ .  "/../siempre_base.php";

if ($_SESSION['auto'] < 3 OR !$_GET['usuid']) {
	exit;
}

require_once APP_DIR . "/hiperen.php";
require_once APP_DIR . "/tamano.php";
require_once APP_DIR . "/nombre.php";
require_once APP_DIR . "/idioma.php";
require_once APP_DIR . "/perfil/unmens.php";

$uid = $_SESSION['usuid'];
$sender = $_GET['usuid'];

if ($sender == $uid) {
	//pantalla de ultimos mensajes
	$sql = "SELECT id FROM message WHERE parausuid = '$uid' AND aviso=''";
	$class = "class='txth b'";
	$sql1 = "SELECT usuid, message, date, isread, usuarios.alumnon, tamatach, nomatach, message.id FROM message 
			LEFT JOIN usuarios ON 	message.usuid = usuarios.id WHERE aviso='' AND parausuid='$uid' 
			ORDER BY message.date";
	$class = "class='txth b'";
	
} else {
	//pantalla de chat con un usuario
	$temp = "AND usuid= '$sender'";	
	$sql = "SELECT id FROM message WHERE parausuid = '$uid' $temp AND isread=0";
	$sql1 = "SELECT usuid, message, date, isread, usuarios.alumnon, tamatach, nomatach, message.id FROM message 
			LEFT JOIN usuarios ON message.usuid = usuarios.id WHERE isread=0 $temp AND parausuid='$uid' 
			ORDER BY message.date";
	$class = "class='rojo'";
	$class1 = "class='b'";
}

$iresult = $ilink->query($sql);
$m = $iresult->num_rows;

if ($m < 1) {return;}

$salida = "";

$result = $ilink->query($sql1);

$salida = unmensa($sql1,2,$ilink,'');

$salida = str_replace("\r","", $salida);
$salida = addslashes($salida);

?>

<script language="JavaScript">
	document.getElementById('mensajes').innerHTML += '<?php echo $salida;?>';
	document.getElementById('mensajes').scrollTop = 1000000;
	document.getElementById('nohaymens').style.display = 'none';
</script>
	
<?php

if ($myrow[7] != 'v.spx' AND $temp) {
	$ilink->query("UPDATE message set isread = 1, aviso = 1 WHERE parausuid = '$uid' $temp");
} elseif (!$temp) {
	$ilink->query("UPDATE message set aviso = 1 WHERE parausuid = '$uid'");
}
	
?>