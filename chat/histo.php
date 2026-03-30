<?php

require_once __DIR__ '/../siempre_base.php';
require_once  APP_DIR . '/hiperen.php';

if ($_SESSION['auto'] < 2) {exit;}

$uid = $_SESSION['usuid'];
$a = $_GET['a'];

?>

<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
</head>

<body>

<center><input type=button value='Guardar chat con Internet Explorer' onclick="javascript:window.document.execCommand('SaveAs',false,'<?php echo $histo;?>');">
<p></p>Navegadores Mozilla: pulsar con el bot&oacute;n derecho sobre esta ventana y guardar la p&aacute;gina con "Guardar como..."<p></p>
</center>

<?php

//$a = $_SESSION['a'];
$iresult = $ilink->query("SELECT fechaentra FROM chat WHERE usuid = '$uid' AND asigna = '$a'");
$entra = $iresult->fetch_array(MYSQLI_BOTH);
$entra = $entra[0];
$salida = "";
$histo = "chat".gmdate("Ynd_His").".html";

$sql = "SELECT DISTINCT chatlista.texto, usuarios.alumnon, usuarios.alumnoa, chatlista.usuid, chatlista.fecha FROM chatlista LEFT JOIN usuarios ON usuarios.id = chatlista.usuid LEFT JOIN chat on chat.usuid = chatlista.usuid WHERE chatlista.fecha >='$entra' AND (parausuid = '$uid' OR parausuid = 0 OR chatlista.usuid = '$uid') AND chatlista.asigna = '$a' ORDER BY chatlista.fecha";

$result = $ilink->query($sql);

while ($myrow = $result->fetch_array(MYSQLI_BOTH))
{

	echo fechaen($myrow[4],$ilink)." ";
	if ($myrow[3] == $_SESSION['usuid']){echo "<span class='b'>";}
	echo $myrow[1]." ".$myrow[2].": ".consmy(conhiper($myrow[0]))."</span><br>";
}

?>

</body></html>
