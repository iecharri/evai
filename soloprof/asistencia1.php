<?php

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

extract($_GET);
extract($_POST);

if (!$yasist) {$yasist = gmdate('Y'); $masist = gmdate('m');}

if ($m == -1 AND $masist == 1) {
	$masist = 12; $yasist = $yasist - 1;
} elseif ($m == 1 AND $masist == 12) {
	$masist = 1; $yasist = $yasist + 1;
} elseif ($m == -1) {
	$masist = $masist - 1;
} elseif ($m == 1) {
	$masist = $masist + 1;
}

$masist = str_pad($masist, 2, "0", STR_PAD_LEFT);
$fasist = ifecha31($yasist."-".$masist,$ilink);

$sqlalu = "SELECT DISTINCT usuarios.id, auto, autorizado, privacidad FROM alumasiano LEFT JOIN usuarios ON
 alumasiano.id = usuarios.id WHERE 
 auto > 1 AND autorizado > 1 AND fechabaja = '0000-00-00 00:00:00' AND asigna = '$asigna' AND curso = '$curso'
 AND grupo = '$grupo' ORDER BY usuarios.alumnoa, usuarios.alumnon ";

$result = $ilink->query($sqlalu);

echo "<table class='conhover'>";
//echo "<tr><th><a href='?op=7&yasist=$yasist&masist=$masist&m=-1'><<</a> &nbsp; $fasist &nbsp; <a href='?op=7&yasist=$yasist&masist=$masist&m=1'>>></a></th>";
echo "<tr><th><a href='?op=1&pest=15&yasist=$yasist&masist=$masist&m=-1'><<</a> &nbsp; $fasist &nbsp; <a href='?op=1&pest=15&yasist=$yasist&masist=$masist&m=1'>>></a></th>";

$numdias = cal_days_in_month(CAL_GREGORIAN,$masist,$yasist);

for ($i = 1; $i <= $numdias; $i++) {
	$di = ""; if ($i == gmdate('d')) {$di = " caja2";} 
	echo "<th class='col-01 $di'>$i</th>";
}
echo "<th>mes</th>";
echo "<th>curso</th>";

echo "</tr>";
$cf = $yasist."-".$masist."-";
$sql1 = "SELECT asistencia FROM asistencia WHERE usuid = '*****' AND asigna = '$asigna' AND curso = '$curso' AND grupo = '$grupo'";

while ($fila = $result->fetch_array(MYSQLI_BOTH)) {
	echo "<tr>";
	extract($fila);
	echo "<td>";
		$usu = ponerusu($id,1,$ilink);
		echo $usu[0].$usu[1];
	echo "</td>";
	$tot = "";
	for ($i = 1; $i <= $numdias; $i++) {
		$dia = str_pad($i, 2, "0", STR_PAD_LEFT);
		echo asis($id,$sql1,$cf,$dia,$ilink);
	}
	$sql = "SELECT asistencia FROM asistencia WHERE asistencia = 1 AND fecha LIKE '$cf"."%' AND usuid = '$id' AND asigna = '$asigna' AND curso = '$curso' AND grupo = '$grupo'";
	$iresult = $ilink->query($sql);
	$dias = $iresult->num_rows;
	echo "<td class='center'>";
	if ($dias) {echo $dias;}
	echo "</td>";
	$sql = "SELECT asistencia FROM asistencia WHERE asistencia = 1 AND usuid = '$id' AND asigna = '$asigna' AND curso = '$curso' AND grupo = '$grupo'";
	$iresult = $ilink->query($sql);
	$dias = $iresult->num_rows;
	echo "<td class='center'>";
	if ($dias) {echo $dias;}
	echo "</td>";
	echo "</tr>";
}
echo "</table>";

// --------------------------------------------------

function asis($id,$sql1,$cf,$dia,$ilink) {
	$fecha = $cf.$dia;
	if (gmdate("w",strtotime($fecha)) == 0 OR gmdate("w",strtotime($fecha)) == 6) {$c = " class='whit'";}
	if ($dia == gmdate('d')) {$c = " class='caja2'";} 
	$sql1 = $sql1." AND fecha = '$fecha 00:00:00'";
	$sql1 = str_replace("*****",$id,$sql1);
	$result = $ilink->query($sql1);
	echo "<td $c id='v$id$fecha'>";
	if ($result) {
		$fila = $result->fetch_array(MYSQLI_BOTH);
		if ($fila[0]) {
			echo "<a href=\"javascript:llamarasincrono('asistencia2no.php?fecha=$fecha&id=$id','v$id$fecha');\" class=' b grande'>*</a>";
		} else {
			echo "<a href=\"javascript:llamarasincrono('asistencia2.php?fecha=$fecha&id=$id','v$id$fecha');\" class='nob'>*</a>";
		}
	}
	echo "</td>";
}

?>
