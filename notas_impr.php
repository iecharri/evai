<?php

require_once __DIR__ . '/siempre.php';

$asigna = $_SESSION['asigna'];
$curso = $_SESSION['curso'];
$grupo = $_SESSION['grupo'];

$esprofesor = esprofesor($asigna,$curso,$grupo,$ilink);

?>

<body style="font-size:10pt;background:white"><a name='inicio'></a>

<?php

if ($_SESSION['auto'] < 5 OR !$asigna) {
	return;
}

// --------------------------------------------------

$sql = "SELECT podasignaturas.cod, podtitulacion.titulacion FROM podcursoasignatit
	LEFT JOIN podasignaturas ON podcursoasignatit.asigna = podasignaturas.cod
	LEFT JOIN podtitulacion on podcursoasignatit.tit = podtitulacion.cod
	WHERE podcursoasignatit.asigna = '$asigna' AND podcursoasignatit.curso = '$curso'";
$iresult = $ilink->query($sql);
$temp = $iresult->fetch_array(MYSQLI_BOTH);

echo "<blockquote><form name='impr' method='post'><div style='font-size:12pt'><span class='b'>$temp[1] - $temp[0]</span><br>".i("notas",$ilink)."</div><p></p>";
echo "\n";
echo "&nbsp;&nbsp;&nbsp;&nbsp;".i("curso",$ilink).": <input class='col-1' type='text' size='4' maxlength='4' name='curso' ";
echo "value='$curso' style='font-size=10pt'readonly>";
echo " &nbsp; &nbsp; ".i("grupo",$ilink).": <input class='col-1' type='text' style='font-size=10pt' size='1' maxlength='1' name='grupo' value='$grupo' readonly>";

$iresult = $ilink->query("SELECT tipasig FROM podcursoasigna WHERE asigna = '$asigna' AND curso = '$curso'");
$tipo = $iresult->fetch_array(MYSQLI_BOTH);
if ($tipo[0] == 1) {$OF_color=" class=1";$EJ_color=" class=1";$ES_color=" class=1";}
if ($tipo[0] == 2) {$OF_color=" class=1";$ES_color=" class=1";}
if ($tipo[0] == 3) {$OJ_color=" class=1";$ES_color=" class=1";}

$convoca = $_POST['convoca'];
$iresult = $ilink->query("SELECT textos FROM cursasigru WHERE asigna = '$asigna' AND curso = '$curso' AND grupo = '$grupo'");
$textos = $iresult->fetch_array(MYSQLI_BOTH);
$textos = explode("*",$textos[0]);

if ($tipo[0] != 0) {
	echo " &nbsp; &nbsp; Convocatoria: <select name='convoca' style='font-size=10pt'>";
	if ($tipo[0] == 1) {
		if (!$convoca) {$convoca = "OF";}
		echo "<option value=\"OF\"";
		if($convoca == "OF") {echo " selected = 'selected'";}
		echo ">$textos[6]</option><option value=\"EJ\"";
		if($convoca == "EJ") {echo " selected = 'selected'";}
		echo ">$textos[6]</option><option value=\"ES\"";
		if($convoca == "ES") {echo " selected = 'selected'";}
		echo ">$textos[6]</option>";
	}
	if ($tipo[0] == 2) {
		if (!$convoca) {$convoca = "OF";}
		echo "<option value=\"OF\"";
		if($convoca == "OF") {echo " selected = 'selected'";}
		echo ">$textos[6]</option><option value=\"ES\"";
		if($convoca == "ES") {echo " selected = 'selected'";}
		echo ">$textos[8]</option>";
	}
	if ($tipo[0] == 3) {
		if (!$convoca) {$convoca = "OJ";}
		echo "<option value=\"OJ\"";
		if($convoca == "OJ") {echo " selected = 'selected'";}
		echo ">$textos[5]</option><option value=\"ES\"";
		if($convoca == "ES") {echo " selected = 'selected'";}
		echo ">$textos[8]</option>";}
	if (!$tipo[0]) {echo "<option value=\"\"></option>";}
	echo "</select>";
}
echo "&nbsp; &nbsp;<select name='mostrar'>";
echo "<option value='1'>".i("nombre",$ilink)."</option>";
echo "<option value='2'";
if ($_POST['mostrar'] == 2) {echo " selected = 'selected'";}
echo ">DNI</option>";
echo "</select>";
echo "&nbsp; &nbsp;<input class='col-1' type='submit' name='impr' value = \" >> \" style='font-size=10pt'></form>";
echo " &nbsp; &nbsp;<input type='text' size='120' style='font-size=10pt'>";
echo "<p></p><br>";

// --------------------------------------------------

$sql1 = " WHERE alumasiano.asigna = '$asigna'";

if ($convoca) {
	$sql1 = $sql1." AND alumasiano.".$convoca."_total != 0 ";
} else {
	$sql1 = $sql1." AND alumasiano.total != 0 ";
}

if ($curso) {$sql1 = $sql1." AND alumasiano.curso = '".$curso."'";}
if ($grupo) {$sql1 = $sql1." AND alumasiano.grupo = '".$grupo."'";}

$iresult = $ilink->query("SELECT coefi, textos FROM cursasigru WHERE asigna = '$asigna' AND curso = '$curso' AND grupo = '$grupo'");
$concoefi = $iresult->fetch_array(MYSQLI_BOTH);

$sql = "SELECT *, usuarios.alumnon, usuarios.alumnoa, usuarios.privacidad, usuarios.usuario, usuarios.id, usuarios.dni FROM alumasiano LEFT JOIN usuarios ON usuarios.id = alumasiano.id".$sql1;
if (!$_POST['mostrar'] OR $_POST['mostrar'] == 1) {$sql .= " ORDER BY alumnoa, curso";} else {$sql .= "ORDER BY dni";}

// --------------------------------------------------

$iresult = $ilink->query($sql);
if ($iresult->num_rows == 0) {

	echo "<p></p><span class='rojo center b'>No se encontraron datos</span>";
	return;
}

// --------------------------------------------------

$result = $ilink->query($sql);

$numvinculos = $result->num_rows;

$result = $ilink->query($sql);

echo "<br><table class='center col-10'>";

?>
<colgroup>
<col span="1" style='background-color:#E3DCD9'>
<col span="6">
<col span="6" style='background-color:#E3DCD9'>
<col span="6">
<col span="6" style='background-color:#E3DCD9'>
<col span="6">
</colgroup>
<?php

$textos = explode("*",$concoefi[1]);

//tit0(1, $textos[4], $textos[5], $textos[6], $textos[7], "");

echo "<th></th>";

if ($OJ_color AND $convoca == "OJ") {echo "<th colspan='6'>$textos[5]</th>";}
if ($OF_color AND $convoca == "OF") {echo "<th colspan='6'>$textos[6]</th>";}
if ($EJ_color AND $convoca == "EJ") {echo "<th colspan='6'>$textos[7]</th>";}
if ($ES_color AND $convoca == "ES") {echo "<th colspan='6'>$textos[8]</th>";}
if (!$tipo['tipasig']) {echo "<th colspan='6'></th>";}

echo "<tr><th class='col-2'>";
if (!$_POST['mostrar'] OR $_POST['mostrar'] == 1) {echo i("nombre",$ilink);} else {echo "DNI";}
echo "</th>";

if ($OJ_color AND $convoca == "OJ") {echo tit(1, "OJ_", 0, $concoefi[0], $textos);} //else {tit(1, "","","", $textos);}
if ($OF_color AND $convoca == "OF") {echo tit(1, "OF_", 0, $concoefi[0], $textos);} //else {tit(1, "","","", $textos);}
if ($EJ_color AND $convoca == "EJ") {echo tit(1, "EJ_", 0, $concoefi[0], $textos);} //else {tit(1, "","","", $textos);}
if ($ES_color AND $convoca == "ES") {echo tit(1, "ES_", 0, $concoefi[0], $textos);} //else {tit(1, "","","", $textos);}
if (!$tipo['tipasig']) {echo tit(1, "*", 0, $concoefi[0], $textos);} //else {tit(1, "","","", $textos);}

echo "</tr>";

echo "<tr><td colspan='31'><hr></td></tr>";

while ($fila = $result->fetch_array(MYSQLI_BOTH)) {

	echo "<tr>";

	$nombre = "<a href='ficha.php?usuid=".$fila['id']."' target='ficha'>";
	if ($_POST['mostrar'] == '2') {$nombre = $fila['dni'];} else {$nombre = $fila['alumnoa'].", ".$fila['alumnon'];}
	echo "</a>";

	$nombre .= "<br>";
	if (!$_SESSION['curso']) {$nombre .= i("curso",$ilink).": ".$fila['curso'];}
	if (!$_SESSION['grupo']) {$nombre .= " ".i("grupo",$ilink).": ".strtoupper($fila['grupo']);}
	echo "<td>".$nombre."</td>";

// --------------------------------------------------

	$formula = formula($asigna,$fila['curso'],$fila['grupo'],$ilink);
	$esprofesor = esprofesor($asigna,$fila['curso'],$fila['grupo'],$ilink);
	$test1 = $formula[0]; $preg1 = $formula[1]; $prac1 = $formula[2]; $eval1 = $formula[3];

// --------------------------------------------------

	if ($OJ_color AND $convoca == "OJ") {echo notas('OJ_', $fila, $formula, 0, "_new", $concoefi[0],$ilink);} //else {notas("","","","","","",'');}
	if ($OF_color AND $convoca == "OF") {echo notas('OF_', $fila, $formula, 0, "_new", $concoefi[0],$ilink);} //else {notas("","","","","","",'');}
	if ($EJ_color AND $convoca == "EJ") {echo notas('EJ_', $fila, $formula, 0, "_new", $concoefi[0],$ilink);} //else {notas("","","","","","",'');}
	if ($ES_color AND $convoca == "ES") {echo notas('ES_', $fila, $formula, 0, "_new", $concoefi[0],$ilink);} //else {notas("","","","","","",'');}
	if (!$tipo['tipasig']) {echo notas('*', $fila, $formula, 0, "_new", $concoefi[0],$ilink);} //else {notas("","","","","","",'');}

// --------------------------------------------------

	echo "</tr>\n";
	echo "<tr><td colspan='31'><hr></td></tr>";

}

$sql = "SELECT AVG(alumasiano.test)*$test1 AS test, STDDEV(alumasiano.test)*$test1 AS test_dt, 
									AVG(alumasiano.preg)*$preg1 AS preg, STDDEV(alumasiano.preg)*$preg1 AS preg_dt, 
									AVG(alumasiano.prac)*$prac1 AS prac, STDDEV(alumasiano.prac)*$prac1 AS prac_dt, 
									AVG(alumasiano.eval)*$eval1 AS eval, STDDEV(alumasiano.eval)*$eval1 AS eval_dt, 
									AVG(alumasiano.total) AS total, STDDEV(alumasiano.total) AS total_dt ";

if ($OJ_color) {

	$sql .= ", AVG(alumasiano.OJ_test)*$test1 AS OJ_test, STDDEV(alumasiano.OJ_test)*$test1 AS OJ_test_dt, 
						AVG(alumasiano.OJ_preg)*$preg1 AS OJ_preg, STDDEV(alumasiano.OJ_preg)*$preg1 AS OJ_preg_dt, 
						AVG(alumasiano.OJ_prac)*$prac1 AS OJ_prac, STDDEV(alumasiano.OJ_prac)*$prac1 AS OJ_prac_dt, 
						AVG(alumasiano.OJ_eval)*$eval1 AS OJ_eval, STDDEV(alumasiano.OJ_eval)*$eval1 AS OJ_eval_dt, 
						AVG(alumasiano.OJ_total) AS OJ_total, STDDEV(alumasiano.OJ_total) AS OJ_total_dt";

}

if ($OF_color) {

	$sql .= ", AVG(alumasiano.OF_test)*$test1 AS OF_test, STDDEV(alumasiano.OF_test)*$test1 AS OF_test_dt, 
						AVG(alumasiano.OF_preg)*$preg1 AS OF_preg, STDDEV(alumasiano.OF_preg)*$preg1 AS OF_preg_dt, 
						AVG(alumasiano.OF_prac)*$prac1 AS OF_prac, STDDEV(alumasiano.OF_prac)*$prac1 AS OF_prac_dt, 
						AVG(alumasiano.OF_eval)*$eval1 AS OF_eval, STDDEV(alumasiano.OF_eval)*$eval1 AS OF_eval_dt, 
						AVG(alumasiano.OF_total) AS OF_total, STDDEV(alumasiano.OF_total) AS OF_total_dt";

}

if ($EJ_color) {

	$sql .= ", AVG(alumasiano.EJ_test)*$test1 AS EJ_test, STDDEV(alumasiano.EJ_test)*$test1 AS EJ_test_dt, 
						AVG(alumasiano.EJ_preg)*$preg1 AS EJ_preg, STDDEV(alumasiano.EJ_preg)*$preg1 AS EJ_preg_dt, 
						AVG(alumasiano.EJ_prac)*$prac1 AS EJ_prac, STDDEV(alumasiano.EJ_prac)*$prac1 AS EJ_prac_dt, 
						AVG(alumasiano.EJ_eval)*$eval1 AS EJ_eval, STDDEV(alumasiano.EJ_eval)*$prac1 AS EJ_eval_dt, 
						AVG(alumasiano.EJ_total) AS EJ_total, STDDEV(alumasiano.EJ_total) AS EJ_total_dt";

}

if ($ES_color) {

	$sql .= ", AVG(alumasiano.ES_test)*$test1 AS ES_test, STDDEV(alumasiano.ES_test)*$test1 AS ES_test_dt, 
						AVG(alumasiano.ES_preg)*$preg1 AS ES_preg, STDDEV(alumasiano.ES_preg)*$preg1 AS ES_preg_dt, 
						AVG(alumasiano.ES_prac)*$prac1 AS ES_prac, STDDEV(alumasiano.ES_prac)*$prac1 AS ES_prac_dt, 
						AVG(alumasiano.ES_eval)*$eval1 AS ES_eval, STDDEV(alumasiano.ES_eval)*$eval1 AS ES_eval_dt, 
						AVG(alumasiano.ES_total) AS ES_total, STDDEV(alumasiano.ES_total) AS ES_total_dt";

}

$sql = $sql." FROM alumasiano LEFT JOIN usuarios ON alumasiano.id = usuarios.id ".$sql1;
$result = $ilink->query($sql);
$fila1 = $result->fetch_array(MYSQLI_BOTH);

echo "<tr><td colspan='31'>&nbsp;</td></tr>\n";
echo "<tr>";
echo "<td align='right'>MEDIA </td>";

if ($OJ_color AND $convoca == "OJ") {media('OJ_', $fila1, 0, $concoefi[0]);} //else {media("","","","");}
if ($OF_color AND $convoca == "OF") {media('OF_', $fila1, 0, $concoefi[0]);} //else {media("","","","");}
if ($EJ_color AND $convoca == "EJ") {media('EJ_', $fila1, 0, $concoefi[0]);} //else {media("","","","");}
if ($ES_color AND $convoca == "ES") {media('ES_', $fila1, 0, $concoefi[0]);} //else {media("","","","");}
if (!$tipo['tipasig']) {media('*', $fila1, 0, $concoefi[0]);} //else {media("","","","");}

echo "</tr>\n";
echo "<tr>";
echo "<td align='right'>DESVIACI&Oacute;N T&Iacute;PICA </td>";

if ($OJ_color AND $convoca == "OJ") {dtip('OJ_', $fila1, 0, $concoefi[0]);} //else {dtip("","","","");}
if ($OF_color AND $convoca == "OF") {dtip('OF_', $fila1, 0, $concoefi[0]);} //else {dtip("","","","");}
if ($EJ_color AND $convoca == "EJ") {dtip('EJ_', $fila1, 0, $concoefi[0]);} //else {dtip("","","","");}
if ($ES_color AND $convoca == "ES") {dtip('ES_', $fila1, 0, $concoefi[0]);} //else {dtip("","","","");}
if (!$tipo['tipasig']) {dtip('', $fila1, 0, $concoefi[0]);} //else {dtip("","","","");}

echo "</tr></table><br>\n";

?>
</body></html>
