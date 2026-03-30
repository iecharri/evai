<?php

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

if (!$ord) {$ord = "cod";}

if ($accion) {require_once APP_DIR . "/pod/podtablasmodif.php";}

if ($accion == 'anadir1') {
	$mensaje = anadirgras($_POST,$ilink);
	if ($ventana) {$accion = 'anadir';}
}
if ($accion == 'editar1') {
	$mensaje = modifgras($_POST,$ilink);
	if ($ventana) {$accion = 'editar';}
}
if ($borrar) {
	$mensaje = borrargras($_POST,$ilink);
	$accion = "";
}
if ($accion == 'anadir') {
	winop(i("anadir1",$ilink),'div1','');
	echo "<form name='form1' method='post'>";
	echo "<label>&Aacute;rea</label><br>";
	$sql = "SELECT * FROM podareas ORDER BY area";
	$result = $ilink->query($sql);
	if ($ilink->errno) {echo $ilink->errno; exit;}
	echo "<select name='newarea'>";
	while ($fila = $result->fetch_array(MYSQLI_BOTH)) {
		echo "<option value='$fila[0]'";
		if (strlen($fila[1]) > 40) {$fila[1] = substr($fila[1],0,79)."...";}
		if ($fila[0] == $filtroarea) {echo " selected='selected'";}
		echo ">$fila[1]</option>";
	}
	echo "</select><br>";
	echo "<label>C&oacute;digo</label><br>";
	echo "<input type='text' name='newcod' size='6' maxlength='6'><br>";
	echo "<label>Grupo de Asignaturas</label><br>";
	echo "<input type='text' name='newgrupo' size='50' maxlength='255'><br>";
	echo "<input type='hidden' name='accion' value='anadir1'>";
	echo "<input class='col-2' type='submit' value=\"".i("anadir1",$ilink)."\">";
	$temp = ""; if ($ventana) {$temp = "checked='checked'";}
	echo "<div class='fr'>Mantener ventana <input type='checkbox' name='ventana' $temp></div>";
	echo "<input type='hidden' name='ventana1' value='1'>";
	echo "</form>";
	echo "</div></div>";
}	
if ($accion == 'editar' AND $cod) {
	$sql = "SELECT * FROM podareagruposa WHERE area = '".$area."' AND cod = '".$cod."'";
	$result = $ilink->query($sql);
	$fila = $result->fetch_array(MYSQLI_BOTH);
	winop(i("editar1",$ilink),'div1','');
	echo "<form name='form1' method='post' onsubmit='return prueba(form1)'>";
	echo "<label>&Aacute;rea</label><br>";
	$sql1 = "SELECT * FROM podareas ORDER BY area";
	$result1 = $ilink->query($sql1);
	echo "<select name='edarea'>";
	while ($fila1 = $result1->fetch_array(MYSQLI_BOTH)) {
		echo "<option value='$fila1[0]'";
		if (strlen($fila1[1]) > 40) {$fila1[1] = substr($fila1[1],0,79)."...";}
		if ($fila1[0] == $area) {echo " selected='selected'";}
		echo ">$fila1[1]</option>";
	}
	echo "</select><br>";
	echo "<label>C&oacute;digo</label><br>";
	echo "<input type='text' name='edcod' size='6' maxlength='6' value='".$fila[1]."'><br>";
	echo "<label>Grupo de Asignaturas</label><br>";
	echo "<input type='text' name='edgrupo' size='50' maxlength='255' value='".$fila[2]."'><br>";
	echo "<span class='rojo b'>BORRAR <input type='checkbox' name='borrar'></span>";
	echo "<input type='hidden' name='cod' value='".$cod."'>";
	echo "<input type='hidden' name='area' value='".$area."'>";
	echo "<input type='hidden' name='accion' value='editar1'>";
	echo "<input class='col-2' type='submit' value=\"".i("agvalid",$ilink)."\">";
	$temp = ""; if ($ventana) {$temp = "checked='checked'";}
	echo "<div class='fr'>Mantener ventana <input type='checkbox' name='ventana' $temp></div>";
	echo "<input type='hidden' name='ventana1' value='1'>";
	echo "</form>";
	echo "</div></div>";
}	
	
$sql = "SELECT * FROM podareagruposa LEFT JOIN podareas ON podareagruposa.area = podareas.codarea";
if ($filtroarea) {$sql .= " WHERE podareagruposa.area = '$filtroarea'";}
$sql .= " ORDER BY $ord";
$result = $ilink->query($sql);
if ($ilink->errno) {echo $ilink->errno; exit;}
echo "<br><table class='conhover'>";
echo "<tr>";
if ($_SESSION['auto'] == 10) {
	echo "<th class='col-01'><a href='?$filtro&ord=$ord&accion=anadir'>A&ntilde;adir</a></th>";
}
echo "<th><a href='?$filtro&ord=podareas.area,cod'>&Aacute;rea</th>";
echo "<th><a href='?$filtro&ord=cod,podareas.area'>C&oacute;digo</a>";
echo " - <a href='?$filtro&ord=podareagruposa.grupo,podareas.area'>Grupo de Asignaturas</a></th>";
echo "</tr>";
while ($fila = $result->fetch_array(MYSQLI_BOTH)) {
	echo "<tr>";
	if ($_SESSION['auto'] == 10) {
		echo "<td><a href='?$filtro&$ord&accion=editar&area=$fila[0]&cod=$fila[1]'>Editar</a></td>";
	}
	echo "<td>".$fila['area']."</td><td>$fila[1] - $fila[2]</td></tr>";
}
echo "</table>";

?>