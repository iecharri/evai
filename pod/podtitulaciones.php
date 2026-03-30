<?php

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

if (!$ord) {$ord = "cod";}

if ($accion) {require_once APP_DIR . "/pod/podtablasmodif.php";}

if ($accion == 'anadir1') {
	$mensaje = anadirtitulaci($_POST,$ilink);
	if ($ventana) {$accion = 'anadir';}
}
if ($accion == 'editar1') {
	$mensaje = modiftitulaci($_POST,$ilink);
	if ($ventana) {$accion = 'editar';}
}
if ($borrar) {
	$mensaje = borrtitulaci($_POST,$ilink);
	$accion = "";
}

if ($accion == 'anadir') {
	winop("C&oacute;digo - ".i("anadir1",$ilink),'div1','');
	echo "<form name='form1' method='post'>";
	echo "<input type='text' name='newcod' size='5' maxlength='5'><br>";
	echo "<label>Titulaci&oacute;n</label><br>";
	echo "<input type='text' name='newtitulacion' size='50' maxlength='254'><br>";
	echo "<input type='hidden' name='accion' value='anadir1'>";
	echo "<input class='col-2' type='submit' value=\"".i("anadir1",$ilink)."\">";
	$temp = ""; if ($ventana) {$temp = "checked='checked'";}
	echo "<div class='fr'>Mantener ventana <input type='checkbox' name='ventana' $temp></div>";
	echo "<input type='hidden' name='ventana1' value='1'>";
	echo "</form>";
	echo "</div></div>";
}	
if ($accion == 'editar' AND $cod) {
	$sql = "SELECT * FROM podtitulacion WHERE cod = '".$cod."'";
	$result = $ilink->query($sql);
	if ($ilink->errno) {echo $ilink->errno; exit;}
	$fila = $result->fetch_array(MYSQLI_BOTH);
	winop("C&oacute;digo - ".i("editar1",$ilink),'div1','');
	echo "<form name='form1' method='post' onsubmit='return prueba(form1)'>";
	echo "<label>C&oacute;digo</label><br>";
	echo "<input type='text' name='edcod' size='5' maxlength='5' value='".$fila[0]."'><br>";
	echo "<label>Titulaci&oacute;n</label><br>";
	echo "<input type='text' name='edtitulacion' size='50' maxlength='254' value='".$fila[1]."'><br>";
	echo "<span class='rojo b'>BORRAR <input type='checkbox' name='borrar'></span>";
	echo "<input type='hidden' name='cod' value='".$cod."'>";
	echo "<input type='hidden' name='accion' value='editar1'>";
	echo "<input class='col-2' type='submit' value=\"".i("agvalid",$ilink)."\">";
	$temp = ""; if ($ventana) {$temp = "checked='checked'";}
	echo "<div class='fr'>Mantener ventana <input type='checkbox' name='ventana' $temp></div>";
	echo "<input type='hidden' name='ventana1' value='1'>";
	echo "</form>";
	echo "</div></div>";
}	
	
$sql = "SELECT * FROM podtitulacion ORDER BY $ord";
$result = $ilink->query($sql);

echo $mensaje;

echo "<table class='conhover'>";
echo "<tr>";
if ($_SESSION['auto'] == 10) {
	echo "<th class='col-01'><a href='?$filtro&ord=$ord&accion=anadir'>A&ntilde;adir</a></th>";
}
echo "<th class='col-01'><a href='?$filtro&ord=cod'>C&oacute;digo</th><th><a href='?$filtro&ord=titulacion'>Titulaci&oacute;n</a></th>";
echo "</tr>";
while ($fila = $result->fetch_array(MYSQLI_BOTH)) {
	echo "<tr>";
	if ($_SESSION['auto'] == 10) {
		echo "<td><a href='?$filtro&$ord&accion=editar&cod=$fila[0]'>Editar</a></td>";
	}
	echo "<td>$fila[0]</td><td>$fila[1]</td></tr>";
}
echo "</table>";

?>