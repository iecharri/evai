<?php

// Copyright (c) 2000-2026 Inmaculada Echarri San Adrián
// Copyright (c) 2000-2026 Antonio Grandío Botella
// This file is part of EVAI.
// Licensed under the MIT License.
// See LICENSE.txt for details.

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

if ($_SESSION['auto'] < 5) {exit;}

$caso = 6; 

require_once APP_DIR . "/pod/podformfiltro.php";

$sql = "SELECT DISTINCT profcurareafigura.profeid FROM profcurareafigura";
$sql .= " WHERE 1=1";

if ($filtroarea) {
	$sql .= " AND profcurareafigura.area = '$filtroarea'";
}

if ($filtrocurso) {
	$sql .= " AND profcurareafigura.curso = '".trim($filtrocurso)."'";
}

?>

<script language="Javascript">
function selecc(comunic){
var check;
if (comunic.all.checked) {check = 'checked'} else {check = ''}
<?php
$result = $ilink->query($sql);
while ($fila = $result->fetch_array(MYSQLI_BOTH)) {
	echo "comunic.usuenv$fila[0].checked = ";?>check<?php echo ";";
}
?>
}
</script>

<?php

$result = $ilink->query($sql);
$num = $result->num_rows;

echo "<form name='comunic' method='post'>";
echo "Marcar los profesores a los que se desea mandar el mail y luego pulsar <input class='col-1' type='submit' name='listar' value=' >> '>";

if ($_POST['listar']) {
	echo "<br><a href='mailto:";
	while ($fila = $result->fetch_array(MYSQLI_BOTH)) {
		$iresult = $ilink->query("SELECT mail, mail2, alumnon FROM profcurareafigura LEFT JOIN usuarios ON profcurareafigura.profeid = usuarios.id WHERE profcurareafigura.profeid = '$fila[0]'");
		$datos = $iresult->fetch_array(MYSQLI_BOTH);
		
		if($_POST['usuenv'.$fila[0]]) {
			echo $datos[0].",";
			if ($datos[1]) {echo $datos[1].",";}
		}
	}
	echo "'>Este enlace abre el programa de correo eletr&oacute;nico por defecto</a>";
}

echo "<table class='col-5 conhover'>";

echo "<tr>";
echo "<td colspan='2'><input type='checkbox' name='all' onclick='selecc(comunic)'></td></tr>";

$result = $ilink->query($sql);

while ($fila = $result->fetch_array(MYSQLI_BOTH)) {

	echo "<tr>";
	echo "<td class='col-01'><input type='checkbox' name=\"usuenv$fila[0]\"";
	if($_POST['usuenv'.$fila[0]]) {echo " checked='checked'";}
	echo "></td><td>";
		$usu = ponerusu($fila['profeid'],1,$ilink);
		echo $usu[0].$usu[1];
	echo "</td></tr>";

}

echo "</table></form>";

?>
