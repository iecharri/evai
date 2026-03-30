<?php

require_once __DIR__ "/siempre_base.php";

if ($_SESSION['auto'] < 3 ) {
	exit;
}

require_once APP_DIR "/hiperen.php";

$uid = $_SESSION['usuid'];
$sender = $_GET['usuid'];

$iresult = $ilink->query("SELECT id FROM message WHERE parausuid = '$uid' AND usuid= '$sender' AND isread=0");
$m = $iresult->num_rows;

if ($m > 0) {

	$salida = "";

	$sql = "SELECT message.id, usuid, message, date, isread, usuarios.alumnon, tamatach, nomatach, parausuid FROM message LEFT JOIN usuarios ON message.usuid = usuarios.id 
	WHERE isread=0 AND usuid='$sender' AND parausuid='$uid' ORDER BY message.date";

	$result = $ilink->query($sql);

	while ($myrow = $result->fetch_array(MYSQLI_BOTH))
	{
		$salida .= "<span class='txth b'>".$myrow[5]."</span> (".fechaen($myrow[3]).",$ilink) ";
		$salida .= consmy(conhiper($myrow[2]));
		if ($myrow[7] == 'v.spx') {
			$salida .= "<div id='audio".$myrow['id']."'>";	
			$salida .= "<a href=\"javascript:Enviar('autograb3.php?id=".$myrow['id']."','audio".$myrow['id']."')\" >";
			$salida .= "<span class='icon-headphones'></span></a> ".tamano($myrow['tamatach'])."</div>";
		} elseif ($myrow[7]) {
			$salida .= " - <a href='fich.php?id=$myrow[id]' target='_blank' class='rojo'>Descargar <B>$myrow[7]</B></a>  - ".tamano($myrow[6]);
		}

		$salida .= "</span><p></p>";

	}

	$salida = str_replace("\r","", $salida);
	$salida = addslashes($salida);
	?>

	<script language="JavaScript">
 	document.getElementById('mensajes').innerHTML += '<?php echo $salida;?>';
	document.getElementById('mensajes').scrollTop = 1000000;
	</script>
	
	<?php
echo $salida;
	if ($myrow[7] != 'v.spx') {
		$ilink->query("UPDATE message set isread = 1 WHERE parausuid = '$uid' AND usuid= '$sender'");
	}
	
}

?>

