<?php

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

if (!$ord) {$ord = "curso,codfigura";}

if ($accion) {require_once APP_DIR . "/pod/podtablasmodif.php";}

if ($accion == 'anadir1') {
	$mensaje = anadircurfiguras($_POST,$min,$ilink);
	if ($ventana) {$accion = 'anadir';}
}
if ($accion == 'editar1') {
	$mensaje = modifcurfiguras($_POST,$min,$ilink);
	if ($ventana) {$accion = 'editar';}
}
if ($borrar) {
	$mensaje = borrarcurfiguras($_POST,$ilink);
	$accion = "";
}

if ($accion == 'anadir') {
	winop(i("anadir1",$ilink),'div1','');	echo "<form name='form1' method='post'>";
	echo "<form name='form1' method='post' >";
	echo "<label>Curso</label><br>";
	echo "<input type='text' name='newcurso' size='4' maxlength='4' value='".trim($filtrocurso)."'><br>";
	echo "<label>Figura</label><br>";
	$sql1 = "SELECT * FROM podfiguras ORDER BY figura";
	$result1 = $ilink->query($sql1);
	echo "<select name='newcodfigura'>";
	while ($fila1 = $result1->fetch_array(MYSQLI_BOTH)) {
		$temp = $fila1[1]; if (strlen($temp) > 79) {$temp = substr($temp,0,80)."...";}
		echo "<option value='$fila1[0]'>$temp</option>";	
	}	
	echo "</select><br>";
	echo "<label>Cr&eacute;ditos m&aacute;ximos</label><br>";
	echo "<input type='text' name='newcreditos' size='6' maxlength='6'><br>";
	echo "<label>Cr&eacute;ditos m&iacute;nimos</label><br>";
	echo "<input type='text' name='newcreditosmin' size='6' maxlength='6'><br>";
	echo "<label>Tiempo</label><br>";
	echo "<select name='newtiempo'>";
	echo "<option value='1'>Parcial</option>";	
	echo "<option value='2'>Completo</option>";	
	echo "</select>";	
	echo "<input type='hidden' name='accion' value='anadir1'>";
	echo " <input class='col-2' type='submit' value=\"".i("anadir1",$ilink)."\">";
	$temp = ""; if ($ventana) {$temp = "checked='checked'";}
	echo "<div class='fr'>Mantener ventana <input type='checkbox' name='ventana' $temp></div>";
	echo "<input type='hidden' name='ventana1' value='1'>";
	echo "</form>";
	echo "</div></div>";
}	
if ($accion == 'editar' AND $codfigura) {
	$sql = "SELECT * FROM podcursofigura WHERE codfigura = '".$codfigura."' AND curso = '".$curso."'";
	$result = $ilink->query($sql);
	if ($ilink->errno) {echo $ilink->errno; exit;}
	$fila = $result->fetch_array(MYSQLI_BOTH);
	winop(i("editar1",$ilink),'div1','');
	echo "<form name='form1' method='post'>";
	echo "<form name='form1' method='post' onsubmit='return prueba(form1)'>";
	echo "<label>Curso</label><br>";
	echo "<input type='text' name='edcurso' size='4' maxlength='4' value='".$fila[0]."'><br>";
	echo "<label>Figura</label><br>";
	$sql1 = "SELECT * FROM podfiguras ORDER BY figura";
	$result1 = $ilink->query($sql1);
	if ($ilink->errno) {echo $ilink->errno; exit;}
	echo "<select name='edcodfigura'>";
	while ($fila1 = $result1->fetch_array(MYSQLI_BOTH)) {
		echo "<option value='$fila1[0]'";
		if ($fila1[0] == $codfigura) {echo " selected='selected'";}
		$temp = $fila1[1]; if (strlen($temp) > 79) {$temp = substr($temp,0,80)."...";}
		echo ">$temp</option>";	
	}	
	echo "</select><p></p>";	
	echo "<label>Cr&eacute;ditos m&aacute;ximos</label><br>";
	echo "<input type='text' name='edcreditos' size='6' maxlength='6' value='".$fila[2]."'><br>";
	echo "<label>Cr&eacute;ditos m&iacute;nimos</label><br>";
	echo "<input type='text' name='edcreditosmin' size='6' maxlength='6' value='".$fila[3]."'><br>";
	echo "<label>Tiempo</label><br>";
	echo "<select name='edtiempo'>";
	echo "<option value='1'";
	if ($fila[4] == '1') {echo "selected='selected'";}
	echo ">Parcial</option>";	
	echo "<option value='2'";
	if ($fila[4] == '2') {echo "selected='selected'";}
	echo ">Completo</option>";	
	echo "</select>";	
	echo "<br><span class='rojo b'>BORRAR <input type='checkbox' name='borrar'></span> ";
	echo "<input type='hidden' name='codfigura' value='".$codfigura."'>";
	echo "<input type='hidden' name='curso' value='".$curso."'>";
	echo "<input type='hidden' name='accion' value='editar1'>";
	echo "<input class='col-2' type='submit' value=\"".i("agvalid",$ilink)."\">";
	$temp = ""; if ($ventana) {$temp = "checked='checked'";}
	echo "<div class='fr'>Mantener ventana <input type='checkbox' name='ventana' $temp></div>";
	echo "<input type='hidden' name='ventana1' value='1'>";
	echo "</form>";
	echo "</div></div>";
}	
	
$sql = "SELECT * FROM podcursofigura LEFT JOIN podfiguras ON podcursofigura.codfigura = podfiguras.cod";
if ($filtrocurso) {$sql .= " WHERE curso = '".trim($filtrocurso)."'";}
$sql .= " ORDER BY $ord";
$result = $ilink->query($sql);

echo $mensaje;

echo "<table class='conhover'>";
echo "<tr>";
if ($_SESSION['auto'] == 10) {
	echo "<th class='col-01'><a href='?$filtro&ord=$ord&accion=anadir'>A&ntilde;adir</a></th>";
}
echo "<th class='col-01'><a href='?$filtro&ord=curso,figura'>Curso</th>";
echo "<th class='col-01'><a href='?$filtro&ord=codfigura,curso'>C&oacute;digo</th>";
echo "<th class='col-10 nowrap'><a href='?$filtro&ord=figura,curso'>Figura</a></th>";
echo "<th class='col-01'><a href='?$filtro&ord=creditos,curso'>Cr&eacute;ditos M&aacute;ximos</a></th>";
echo "<th class='col-01'><a href='?$filtro&ord=creditosmin,curso'>Cr&eacute;ditos M&iacute;nimos</a></th>";
echo "<th class='col-01 nowrap'><a href='?$filtro&ord=tiempo,curso'>Tiempo</a></th>";
echo "</tr>";
while ($fila = $result->fetch_array(MYSQLI_BOTH)) {
	echo "<tr>";
	if ($_SESSION['auto'] == 10) {
		echo "<td><a href='?$filtro&ord=$ord&accion=editar&curso=$fila[0]&codfigura=$fila[1]'>Editar</a></td>";
	}
	echo "<td>$fila[0]</td>";
	echo "<td>$fila[1]</td>";
	echo "<td>".$fila['figura']."</td>";
	echo "<td>$fila[2]</td>";
	echo "<td>$fila[3]</td>";
	echo "<td>";
	if ($fila[4] == "1") {echo "Parcial";} else {echo "Completo";}
	echo "</td>";
	echo "</tr>";
}
echo "</table>";

?>