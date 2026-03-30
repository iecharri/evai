<?php

require_once __DIR__ . '/siempre_base.php';

if($_SESSION['auto'] < 5) {return;}

$iresult = $ilink->query("SELECT COUNT(click) FROM mandoadist WHERE 
asigna = '".$_SESSION['asigna']."' AND curso = '".$_SESSION['curso']."'
 AND grupo = '".$_SESSION['grupo']."'");
$tot = $iresult->fetch_array(MYSQLI_BOTH);

$clicks = $ilink->query("SELECT click, COUNT(click) FROM mandoadist WHERE 
asigna = '".$_SESSION['asigna']."' AND curso = '".$_SESSION['curso']."'
 AND grupo = '".$_SESSION['grupo']."' GROUP BY click ORDER BY click");
echo "<p></p>";

while ($fila = $clicks->fetch_array(MYSQLI_BOTH)) {
	$porc = (100*$fila[1])/$tot[0];
	echo "<div id='result' class='col-10 both grande'><br>";
		echo "<div class='fl col-1'><span class='colu'>".$fila[0]."</span> Clicks ".$fila[1]."</div> ";
		echo "<div class='fl col-9'>";
			echo "<div style='background:#643B2C;color:#fff;width:$porc%'> ".number_format($porc,2,',','.')."% </div>";
		echo "</div>";
	echo "</div>";
	echo "<p><br></p>";
}
?>
