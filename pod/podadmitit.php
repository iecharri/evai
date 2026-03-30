<?php

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

?>

<script language=Javascript>
function borrar() {
	return confirm('Confirmar borrado.')
}
</script>

<?php

$param = "pest=$pest&pest1=$pest1";

$caso = 8; 

require_once APP_DIR . "/pod/podformfiltro.php";

//-------------------- TITULACIONES - ADMINISTRADORES - CURSOS -------------------

if ($accion == 'borrar1' AND $_SESSION['auto'] == 10) {
	$ilink->query("DELETE FROM titcuradmi WHERE titulaci = '$titulaci' AND curso = '$curso' AND usuid = '$usuid'");	
}

//------------------------------------------------------------------------

if ($accion == 'anadir1' AND $_SESSION['auto'] == 10) {
	$edasigna = strtoupper($edasigna);
	$ilink->query("INSERT INTO titcuradmi (titulaci, curso, usuid) VALUES ('$edasigna', '$edcurso', '$edusuid')");
	if ($ventana) {$accion = 'anadir';}
}

//---------------------- TITULACIONES - ADMINISTRADORES --------------------------------------------

echo "<br><table class='conhover'>";

echo "<tr>";

if ($_SESSION['auto'] == 10) {
	echo "<th class='col-01'><a href='?$param&accion=anadir'>".i("anadir1",$ilink)."</a></th>";
}
echo "<th>".i("titul",$ilink)."</th><th>".i("curso",$ilink)."</th><th>".i("profesor",$ilink)."</th></tr>";

$n = 0;

$sql = "SELECT titcuradmi.usuid, titcuradmi.titulaci, podtitulacion.titulacion, titcuradmi.curso
	FROM titcuradmi LEFT JOIN podtitulacion ON podtitulacion.cod = titcuradmi.titulaci
	LEFT JOIN usuarios ON usuarios.id = titcuradmi.usuid";
$sql .= " WHERE 1=1";

if ($filtroprof) {
	$sql = $sql." AND titcuradmi.usuid = '$filtroprof'";
}
if ($filtrocurso) {
	$sql = $sql." AND titcuradmi.curso = '$filtrocurso'";
}
if ($filtrotit) {
	$sql = $sql." AND titcuradmi.titulaci = '$filtrotit'";
}

$sql = $sql." ORDER BY titulacion, titcuradmi.curso";

$result = $ilink->query($sql);

while ($fila = $result->fetch_array(MYSQLI_BOTH)) {

	echo "<tr>";
	if ($_SESSION['auto'] == 10) {
		echo "<td><a href='?$param&accion=borrar1&titulaci=".$fila['titulaci']."&curso=".$fila['curso']."&usuid=".$fila['usuid']."' onclick='return borrar();'>Borrar</a></td>";
	}
	echo "<td class='col-5'>".$fila['titulaci']." -  ".$fila['titulacion']."</td>";
	echo "<td class='col-01'>".$fila['curso']."</td>";
	echo "<td class='col-5'>";
	$usua = ponerusu($fila['usuid'],1,$ilink);
	echo $usua[0];
	echo $usua[1];
	echo "</td></tr>";

}

echo "</table>";

// ------------------------------------------------------------------------

if ($accion == 'anadir') {
	winop("Administrador de una Titulaci&oacute;n / Curso - ".i("anadir1",$ilink),'div1','');
	echo "<form action='".$_SERVER['PHP_SELF']."?$param' name='form1' method='post'>";
	echo "<label>C&oacute;digo</label><br>";
	$result1 = $ilink->query("SELECT * FROM podtitulacion");
	echo "<select class='col-10' name='edasigna'>";
	while ($fila1 = $result1->fetch_array(MYSQLI_BOTH)) {
		echo "<option value = '".$fila1['cod']."'";
		$temp = $fila1[1]; if (strlen($temp) > 79) {$temp = substr($temp,0,80)."...";}
		echo ">".$fila1['cod']." - ".$temp;
	}
	echo "</select><br>";
	echo "<label>".i("curso",$ilink)."</label> <input class='col-1' type='text' name='edcurso' size='4' maxlength='4' value='".trim($filtrocurso)."'><p></p>";
	echo "<label>".i("profesor",$ilink)."</label><br>";
	echo "<select class='col-10' name='edusuid'>";
	$result1 = $ilink->query("SELECT id, alumnon, alumnoa FROM usuarios WHERE tipo = 'P' AND autorizado > 4 ORDER BY alumnoa, alumnon");
	while ($fila1 = $result1->fetch_array(MYSQLI_BOTH)) {
		echo "<option value = '".$fila1[0]."'";
		if ($filtroprof == $fila1[0]) {
			echo " selected = 'selected'";
		}
		echo ">".$fila1[2].", ".$fila1[1]."";
	}
	echo "</select><br>";
	if ($filtroprof) {
		echo "<input type='hidden' name='filtroprof' value='".$filtroprof."'>";
	}
	echo "<input type='hidden' name='accion' value='anadir1'><input class='col-2' type='submit' value=\"".i("anadir1",$ilink)."\">";
	$temp = ""; if ($ventana) {$temp = "checked='checked'";}
	echo "<div class='fr'>Mantener ventana <input type='checkbox' name='ventana' $temp></div>";
	echo "<input type='hidden' name='ventana1' value='1'>";
	echo "</form>";
	echo "</div></div>";

}

?>
