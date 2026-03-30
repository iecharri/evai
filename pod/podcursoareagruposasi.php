<?php

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

if (!$ord) {$ord = "podcursoareagruposa.cod";}

if ($accion == 'anadir1') {
	if ($ventana) {$accion = 'anadir';}
	$newcod = strtoupper(str_replace(" ","",$newcod));
	$sql = "INSERT INTO podcursoareagruposa (curso, area, cod) VALUES (\"$newcurso\", \"$newarea\", \"$newcod\")";
	$ilink->query($sql);
	if ($ilink->errno) {echo $ilink->errno; exit;}
}
if ($accion == 'editar1') {
	if ($ventana) {$accion = 'editar';}
	$temp = explode("##",$edcod);
	$edcod = $temp[1];
	$edarea = $temp[0];
	$edcod = strtoupper(str_replace(" ","",$edcod));
	$sql = "UPDATE podcursoareagruposa SET curso = \"$edcurso\", area = \"$edarea\", cod = \"$edcod\" WHERE  curso = \"$curso\" AND area = \"$area\" AND cod=\"$cod\"";
	$ilink->query($sql);
}
if ($borrar) {
	$accion = "";
	$sql = "DELETE FROM podcursoareagruposa WHERE area = \"$area\" AND curso = \"$curso\" AND cod = \"$cod\"";
	$ilink->query($sql);
}
if ($accion == 'anadir' AND $filtroarea) {
	winop(i("anadir1",$ilink),'div1','');
	echo "<form name='form1' method='post'>";
	echo "<label>Curso</label> ";
	echo "<input class='col-2' type='text' name='newcurso' size='4' maxlength='4' value='".trim($filtrocurso)."'><br>";
	echo "<label>Grupo de Asignaturas</label><br>";
	$sql = "SELECT cod, grupo FROM podareagruposa";
	if ($filtroarea) {$sql .= " WHERE area = '$filtroarea'";}
	$sql .= " ORDER BY grupo";
	$result = $ilink->query($sql);
	if ($ilink->errno) {echo $ilink->errno; exit;}
	echo "<select class='col-10' name = 'newcod'>";
	while ($fila = $result->fetch_array(MYSQLI_BOTH)) {
		echo "<option value = '$fila[0]'>$fila[1]</option>";
	}
	echo "</select><br>";
	echo "<input type = 'hidden' name = 'newarea' value = '$filtroarea'>";
	echo "<input type='hidden' name='accion' value='anadir1'>";
	echo "<input class='col-2' type='submit' value=\"".i("anadir1",$ilink)."\">";
	$temp = ""; if ($ventana) {$temp = "checked='checked'";}
	echo "<div class='fr'>Mantener ventana <input type='checkbox' name='ventana' $temp></div>";
	echo "<input type='hidden' name='ventana1' value='1'>";
	echo "</form>";
	echo "</div></div>";
}	
if ($accion == 'editar' AND $_GET['cod'] AND $filtroarea) {
	$sql = "SELECT * FROM podcursoareagruposa WHERE curso = '$curso' AND area = '$area' AND cod = '".$cod."'";
	$result = $ilink->query($sql);
	if ($ilink->errno) {echo $ilink->errno; exit;}
	$fila = $result->fetch_array(MYSQLI_BOTH);
	winop(i("editar1",$ilink),'div1','');
	echo "<form name='form1' method='post' onsubmit='return prueba(form1)'>";
	echo "<label>Curso</label> ";
	echo "<input class='col-2' type='text' name='edcurso' size='4' maxlength='4' value='".$fila['curso']."'><br>";
	echo "<label>Grupo de Asignaturas</label><br>";
	$sql1 = "SELECT area, cod, grupo FROM podareagruposa";
	if ($filtroarea) {$sql1 .= " WHERE area = '$area'";}
	$sql1 .= " ORDER BY grupo";
	$result1 = $ilink->query($sql1);
	if ($ilink->errno) {echo $ilink->errno; exit;}
	echo "<select class='col-10' name = 'edcod'>";
	while ($fila1 = $result1->fetch_array(MYSQLI_BOTH)) {
		echo "<option value = '$fila1[0]##$fila1[1]'";
		if ($fila1[0] == $area AND $fila1[1] == $cod) {echo " selected='seleccted'";}
		echo ">$fila1[2]</option>";
	}
	echo "</select>";
	echo "<br><span class='rojo b'>BORRAR <input type='checkbox' name='borrar'></span>";
	echo "<input type='hidden' name='cod' value='".$cod."'>";
	echo "<input type='hidden' name='curso' value='".$curso."'>";
	echo "<input type='hidden' name='area' value='".$area."'>";
	echo "<input type='hidden' name='accion' value='editar1'>";
	echo "<input class='col-2' type='submit' value=\"".i("agvalid",$ilink)."\">";
	$temp = ""; if ($ventana) {$temp = "checked='checked'";}
	echo "<div class='fr'>Mantener ventana <input type='checkbox' name='ventana' $temp></div>";
	echo "<input type='hidden' name='ventana1' value='1'>";
	echo "</form>";
	echo "</div></div>";
}	
	
$sql = "SELECT curso, podareas.area, podcursoareagruposa.cod, podareagruposa.grupo, podareas.codarea FROM podcursoareagruposa";
$sql .= " LEFT JOIN podareas ON podcursoareagruposa.area = podareas.codarea";
$sql .= " LEFT JOIN podareagruposa ON";
$sql .= " podcursoareagruposa.area = podareagruposa.area AND podcursoareagruposa.cod = podareagruposa.cod";
$sql .= " WHERE 1=1";
if ($filtrocurso) {$sql .= " AND curso = '".trim($filtrocurso)."'";}
if ($filtroarea) {$sql .= " AND podcursoareagruposa.area = '".trim($filtroarea)."'";}
$sql .= " ORDER BY $ord";
$result = $ilink->query($sql);
if ($ilink->errno) {echo $ilink->errno; exit;}
if (!$filtroarea) {echo "<span class='rojo b'>&iexcl;ATENCI&Oacute;N! para a&ntilde;adir o modificar un Grupo, seleccionar un &Aacute;rea y un Curso.</span>";}
echo "<table>";
echo "<tr>";
if ($_SESSION['auto'] == 10) {
	echo "<th class='col-01'><a href='?$filtro&ord=$ord&accion=anadir'>A&ntilde;adir</a></th>";
}
echo "<th class='col-01'><a href='?$filtro&ord=cod'>Curso</a></th>";
echo "<th><a href='?$filtro&ord=cod'>&Aacute;rea</a></th>";
echo "<th><a href='?$filtro&ord=cod'>C&oacute;digo</a>";
echo " - <a href='?$filtro&ord=grupo'>Grupo de Asignaturas</a></th>";
echo "</tr>";
while ($fila = $result->fetch_array(MYSQLI_BOTH)) {
	echo "<tr>";
	if ($_SESSION['auto'] == 10) {
		echo "<td><a href='?$filtro&ord=$ord&accion=editar&curso=$fila[0]&area=$fila[4]&cod=$fila[2]'>Editar</a></td>";
	}
	echo "<td>$fila[0]</td><td>$fila[1]</td>";
	echo "<td>$fila[2] - $fila[3]</td>";
	echo "</tr>";
}
echo "</table>";

?>