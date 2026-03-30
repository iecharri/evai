<?php

require_once __DIR__ . '/../siempre_base.php';

$iresult = $ilink->query("SELECT MAX(n) FROM $cuest"."1");
$max = $iresult->fetch_array(MYSQLI_BOTH);

$sql1 = "SELECT $cuest"."2.u, $cuest"."2.cu, $cuest"."2.n, $cuest"."2.v1, $cuest"."2.v2,
 $cuest"."2.v3, $cuest"."2.datetime, $cuest"."2.t_ini, $cuest"."1.tipo, usuid, nota FROM $cuest"."2 LEFT JOIN $cuest"."1
  ON $cuest"."2.n = $cuest"."1.n AND $cuest"."1.n1 =0
  WHERE $cuest"."1.input != ''
   ORDER BY $cuest"."2.cu, $cuest"."1.orden";

$result1 = $ilink->query($sql1);

$cuanterior = "";
$linea = "\"T ini.\";\"T fin\";\"IP\";\"Usuario\";\"Nota\"";

while ($fila1 = $result1->fetch_array(MYSQLI_BOTH)) {

	extract($fila1);
	$nombre = "";
	if ($usuid) {
		iconex(DB1,$ilink);
		$iresult = $ilink->query("SELECT CONCAT(alumnoa,', ',alumnon) FROM usuarios WHERE id = '$usuid' LIMIT 1");
		$nombre = $iresult->fetch_array(MYSQLI_BOTH);
		$nombre = $nombre[0];
		iconex(DB2,$ilink);	
	}

	if ($cu != $cuanterior) {
		$linea .= "\r\"" . utcausu1($t_ini) . "\";\"" . utcausu1($datetime) . "\";\"" . $u . "\";\"" . $nombre . "\";\"" . $nota . "\"";
		$cuanterior = $cu;
	}

	$linea .= ";\"";
	if ($tipo == "N") {$linea .= $v1;}
	if ($tipo == "C") {$linea .= $v2;}
	if ($tipo == "L") {$linea .= str_replace("\"","'",$v3);}
	$linea .= "\"";

}

$file = fopen(DATA_DIR ."/".$cuest.".csv","w+");
fwrite($file,$linea);
fclose($file);

$dir64 = base64_encode('');  // raíz de DATA_DIR
$url = APP_URL . "/ver_media.php?dir64=$dir64&f=" . urlencode("$cuest.csv");

echo "<a href='$url'>Descargar $cuest.csv</a>";
?>
