<?php

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

$ord = $_GET['ord'];
if (!$ord) {$ord = "cod";}

if ($accion) {
	require_once APP_DIR . "/pod/podtablasmodif.php";
}

if ($accion == 'anadir1') {
	$mensaje = anadirasignat($_POST,$ilink);
	if ($ventana) {$accion = 'anadir'; $newcod=''; $newasignatura='';}
}
if ($accion == 'editar1') {
	$mensaje = modifasignat($_POST,$ilink);
	if ($ventana) {$accion = 'editar';}
}
if ($borrar) {
	$mensaje = borrarasignat($_POST,$ilink);
	$accion = "";
}

if ($accion == 'anadir') {
	winop("A&Ntilde;ADIR ASIGNATURA",'div1','');
	echo "<form method='post'>";
	echo "<span class='rojo b'>Es preferible que el c&oacute;digo tenga solo letras y n&uacute;meros.</span><br>";
	echo "<label>C&oacute;digo</label><br><input class='col-1' class='col-2' type='text' name='newcod' size='15' maxlength='15' value='$newcod'>";
	echo "<br><label>".i("descrip",$ilink)."</label><br><input class='col-10' type='text' name='newasignatura' size='80' maxlength='254' value='$newasignatura'>";
	echo "<br><input type='hidden' name='accion' value='anadir1'><input class='col-1' type='submit' value=\"".i("anadir1",$ilink)."\">";
	$temp = ""; if ($ventana) {$temp = "checked='checked'";}
	echo "<div class='fr'>Mantener ventana <input type='checkbox' name='ventana' $temp></div>";
	echo "<input type='hidden' name='ventana1' value='1'>";
	echo "</form>";
	echo "</div></div>";
}

if ($accion == 'editar') {
	$iresult = $ilink->query("SELECT * FROM podasignaturas WHERE cod = '$cod'");
	$fila = $iresult->fetch_array(MYSQLI_BOTH);
	winop("EDITAR ASIGNATURA",'div1','');
	echo "<form name='form1' method='post' onsubmit='return prueba(form1)'>";
	echo "<span class='rojo b'>Es preferible que el c&oacute;digo tenga solo letras y n&uacute;meros.</span><br>";
	echo "<label>C&oacute;digo</label><br>";
	echo "<input class='col-1' type='text' name='edcod' size='15' maxlength='15' value='$cod'><br>";
	echo "<label>".i("descrip",$ilink)."</label><br>";
	echo "<input class='col-10' type='text' name='edasignatura' size='80' maxlength='254' value='".$fila['asignatura']."'><br>";
	echo "<input type='hidden' name='cod' value='$cod'>";
	echo "<span class='rojo b'>BORRAR <input type='checkbox' name='borrar'></span>";
	echo " <input type='hidden' name='accion' value='editar1'><input class='col-1' type='submit' value=\"".i("agvalid",$ilink)."\">";
	$temp = ""; if ($ventana) {$temp = "checked='checked'";}
	echo "<div class='fr'>Mantener ventana <input type='checkbox' name='ventana' $temp></div>";
	echo "<input type='hidden' name='ventana1' value='1'>";
	echo "</form>";
	echo "</div></div>";
}

// -------------------------------------------------- A S I G N A T U R A S // --------------------------------------------------

$sql = "SELECT * FROM podasignaturas";
$sql .= " ORDER BY $ord";
$result = $ilink->query($sql);

// --------------------------------------------------

echo $mensaje;

echo "<table class='conhover'>";

echo "<tr>";
if ($_SESSION['auto'] == 10) {
	echo "<th class='col-01'>";
	echo "<a href='?ord=$ord&accion=anadir&$filtro'>".i("anadir1",$ilink)."</a>";
	echo "</th>";
}
echo "<th class='col-01'><a href='?ord=cod&$filtro'>C&oacute;digo</a></th>";
echo "<th class='col-10'><a href='?ord=asignatura&$filtro'>".i("asigna",$ilink)."</a></th>";
echo "</tr>";

if (!$result) {echo "</table>"; return;}

while ($fila = $result->fetch_array(MYSQLI_BOTH)) {

	echo "<tr>";
	if ($_SESSION['auto'] == 10) {
		echo "<td>";
		echo "<a href='?accion=editar&cod=".$fila['cod']."&$filtro'>";
		echo i("editar1",$ilink)."</td>";
	}
	echo "<td>".$fila['cod']."</td>";
	echo "<td>".$fila['asignatura']."</td>";
	echo "</tr>";
	
}

echo "</table>";

?>
