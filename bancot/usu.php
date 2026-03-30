<?php

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

?>

<br><div class='center'>OFERTO
<?php
if ($_SESSION['usuid'] == $usuid) {echo " [<a href='?op=$op&pest=$pest&ofertar=1'>Ofertar</a>]";}
?>
</div>

<?php

require_once APP_DIR . "/bancot/bancofunc.php";

cambios($ilink);

// --------------------------------------------------

$sql = "SELECT * FROM bancot1 WHERE usuid = '$usuid'";

$result = $ilink->query($sql);

cabecera("");
$param = "usuid=$usuid&op=$op&pest=$pest";
if ($ofertar) {
	echo "<tr>";
	echo "<td colspan='3'>";
	echo "<form method='post' action='?op=$op&pest=$pest&ofertar=1'>";
	echo "Tiempo que se ofrece ";
	echo "<select name='addbanco1'>";
	ponoption('00:30:00','10:00:00','',$ilink);
	echo "</select>";
	echo "<br>Competencia <input class='col-6' type='text' name='addbanco2' size='50' maxlength='255'>";
	echo " <input class='col-1' type='submit' value=' >> '>";
	echo "</form>";
	echo "</td>";
	echo "</tr>";
}
while ($fila = $result->fetch_array(MYSQLI_BOTH)) {
	competencia($fila,"",$param,$ilink);
}
pie();

// --------------------------------------------------

$tit="";
$sql = "SELECT bancot2.fecha,bancot2.aceptado,bancot2.tiempo,usuid,competencia,bancot1.fecha,satisfac,bancot2.bancoid,bancot1.tiempo AS bancot1tiempo
 FROM bancot2 LEFT JOIN bancot1 ON bancot2.bancoid=bancot1.bancoid 
 WHERE usurecibe = '$usuid' ORDER BY bancot2.fecha";

$result = $ilink->query($sql);

echo "<br><p>&nbsp;<br></p><div class='both center'>SOLICITO</div>";

while ($fila = $result->fetch_array(MYSQLI_BOTH)) {

	if (!$tit) {
		echo "<table class='conhover'>";
		echo "<tr>";
		echo "<th class='col-9'>Competencia<br>Tiempo</th>";
		echo "<th class='col-01'>Petici&oacute;n</th>";
		echo "<th class='col-01'>Aceptado</th>";
		echo "<th class='col-01'>Mi valoraci&oacute;n</th>";
		echo "</tr>";
		$tit = 1;
	}

	$datos = completado($fila['bancoid'],$fila['bancot1tiempo'],$ilink);
	$usado[0] = $datos[0];
	$diff[0] = $datos[1];		
	$media[0] = $datos[2];
	if ($diff[0] == "00:00:00") {
		$completada = "<br><span class='rojo b'>Oferta completada</span>";
	}	

	echo "<tr>";
	echo "<td>";
	echo "<span class='mediana b'>".$fila['competencia']."</span>";
	echo "<br>".$fila[2];
	echo "<br>";
	$usu = ponerusu($fila['usuid'],1,$ilink);
	echo $usu[0].$usu[1];
	echo "</td>";
	echo "<td class='nowrap'>";
	echo ifecha31($fila[0],$ilink);
	echo "<br><span class='txth b center'>".tiempo($fila['tiempo']);
	echo "</span></td>";
	echo "<td class='nowrap'>";
	
	if ($fila['aceptado'] != '0000-00-00') {
		echo ifecha31($fila['aceptado'],$ilink);
	} elseif ($completada) {
		echo $completada;
	} elseif ($diff[0] < $fila['tiempo']) {
		echo $diff[0] ."<". $fila['tiempo']."<span class='rojo b'>Demasiado tiempo solicitado</span>";
	} else {
		echo "<span class='rojo b'>A&uacute;n no aceptado</span>";
	}
	echo "</td>";
	echo "<td class='col-01 nowrap'>";
	if (!$fila['satisfac'] AND $fila['aceptado'] != '0000-00-00') {
		if ($_SESSION['usuid'] == $usuid) {
			echo "Valorar<br>de 1 a 10<br>";
			echo "<form method='post'>";
			echo "<input type='hidden' name='xbancoid' value='$fila[7]'>";
			echo "<input type='hidden' name='xusurecibe' value='$usuid'>";
			echo "<input type='text' name='puntuar' size='2' maxlength='2'>";
			echo " <input type='submit' value=' >> '>";
			echo "</form>";
		}
	} else {
		if ($fila['satisfac'] AND $ver) {echo $fila['satisfac'];}
	}
	echo "</td>";
	echo "</tr>";

}

if ($tit) {
	echo "</table>";
}


?>