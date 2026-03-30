<?php

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

if (!$ord) {$ord = "curso,codcargo";}

if ($accion) {require_once APP_DIR . "/pod/podtablasmodif.php";}

if ($accion == 'anadir1') {
	$mensaje = anadircurcargos($_POST,$min,$ilink);
	if ($ventana) {$accion = 'anadir';}
}
if ($accion == 'editar1') {
	$mensaje = modifcurcargos($_POST,$min,$ilink);
	if ($ventana) {$accion = 'editar';}
}
if ($borrar) {
	$mensaje = borrarcurcargos($_POST,$ilink);
	$accion = "";
}

if ($accion == 'anadir') {
	$sql1 = "SELECT * FROM podcargos ORDER BY tipo";
	$result1 = $ilink->query($sql1);
	if (!$result1->num_rows) {
		$mensaje = "<span class='rojo b'>No existen CARGOS que a&ntilde;adir.</span>";
	} else {
		winop(i("anadir1",$ilink),'div1','');
		echo "<form name='form1' method='post'>";
		echo "<label>Curso</label><br>";
		echo "<input class='col-5' type='text' name='newcurso' size='4' maxlength='4' value='".trim($filtrocurso)."'><br>";
		echo "<label>Cargo</label><br>";
		echo "<select class='col-10' name='newcodcargo'>";
		while ($fila1 = $result1->fetch_array(MYSQLI_BOTH)) {
			$temp = $fila1[1]; if (strlen($temp) > 79) {$temp = substr($temp,0,80)."...";}
			echo "<option value='$fila1[0]'>$temp</option>";	
		}	
		echo "</select>";
		echo "<label>Cr&eacute;ditos</label><br>";
		echo "<input class='col-5' type='text' name='newcreditos' size='6' maxlength='6'><br>";
		echo "<input type='hidden' name='accion' value='anadir1'>";
		echo "<input class='col-2' type='submit' value=\"".i("anadir1",$ilink)."\">";
		$temp = ""; if ($ventana) {$temp = "checked='checked'";}
		echo "<div class='fr'>Mantener ventana <input type='checkbox' name='ventana' $temp></div>";
		echo "<input type='hidden' name='ventana1' value='1'>";
		echo "</fieldset></form>";
		echo "</div></div>";
	}
}	
if ($accion == 'editar' AND $codcargo) {
	$sql = "SELECT * FROM podcursocargos WHERE curso = '".$curso."' AND codcargo = '".$codcargo."'";
	$result = $ilink->query($sql);
	if ($ilink->errno) {echo $ilink->errno; exit;}
	$fila = $result->fetch_array(MYSQLI_BOTH);
	winop(i("editar1",$ilink),'div1','');
	echo "<form name='form1' method='post' onsubmit='return prueba(form1)'>";
	echo "<label>Curso</label><br>";
	echo "<input class='col-5' ype='text' name='edcurso' size='4' maxlength='4' value='".$fila[0]."'><br>";
	echo "<label>Cargo</label><br>";
	$sql1 = "SELECT * FROM podcargos ORDER BY tipo";
	$result1 = $ilink->query($sql1);
	if ($ilink->errno) {echo $ilink->errno; exit;}
	echo "<select class='col-10' name='edcodcargo'>";
	while ($fila1 = $result1->fetch_array(MYSQLI_BOTH)) {
		echo "<option value='$fila1[0]'";
		if ($fila1[0] == $codcargo) {echo " selected='selected'";}
		$temp = $fila1[1]; if (strlen($temp) > 79) {$temp = substr($temp,0,80)."...";}
		echo ">$temp</option>";	
	}	
	echo "</select><br>";	
	echo "<label>Cr&eacute;ditos</label><br>";
	echo "<input class='col-5' type='text' name='edcreditos' size='6' maxlength='6' value='".$fila[2]."'><br>";
	echo "<span class='rojo b'>BORRAR <input type='checkbox' name='borrar'></span>";
	echo "<input type='hidden' name='codcargo' value='".$codcargo."'>";
	echo "<input type='hidden' name='curso' value='".$curso."'>";
	echo "<input type='hidden' name='accion' value='editar1'>";
	echo "<input class='col-2' type='submit' value=\"".i("agvalid",$ilink)."\">";
	$temp = ""; if ($ventana) {$temp = "checked='checked'";}
	echo "<div class='fr'>Mantener ventana <input type='checkbox' name='ventana' $temp></div>";
	echo "<input type='hidden' name='ventana1' value='1'>";
	echo "</form>";
	echo "</div></div>";
}	
	
$sql = "SELECT * FROM podcursocargos LEFT JOIN podcargos ON podcursocargos.codcargo = podcargos.cod";
if ($filtrocurso) {$sql .= " WHERE curso = '".trim($filtrocurso)."'";}
$sql .= " ORDER BY $ord";
$result = $ilink->query($sql);

echo $mensaje;

echo "<table class='conhover'>";
echo "<tr>";
if ($_SESSION['auto'] == 10) {
	echo "<th class='col-01'><a href='?$filtro&ord=$ord&accion=anadir'>A&ntilde;adir</a></th>";
}
echo "<th class='col-01'><a href='?$filtro&ord=curso,tipo'>Curso</th>";
echo "<th class='col-01'><a href='?$filtro&ord=codcargo,curso'>C&oacute;digo</th>";
echo "<th><a href='?$filtro&ord=tipo,curso'>Cargo</a>";
echo "<th class='col-01'><a href='?$filtro&ord=cod'>Creditos</th>";
echo "</th>";
echo "</tr>";
while ($fila = $result->fetch_array(MYSQLI_BOTH)) {
	echo "<tr>";
	if ($_SESSION['auto'] == 10) {
		echo "<td><a href='?$filtro&ord=$ord&accion=editar&curso=$fila[0]&codcargo=$fila[1]'>Editar</a></td>";
	}
	echo "<td>$fila[0]</td>";
	echo "<td>$fila[1]</td>";
	echo "<td>".$fila['tipo']."</td>";
	echo "<td>$fila[2]</td>";
	echo "</tr>";
}
echo "</table>";

?>