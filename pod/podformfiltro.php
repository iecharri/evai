<?php

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

$min = 1998;

if ($_POST['filtrocurso'] == '*') {
	$_SESSION['filtrocurso'] = "";
} elseif ($_POST['filtrocurso']) {
	$_SESSION['filtrocurso'] = $_POST['filtrocurso'];
}

if ($_POST['filtroprof'] == '*') {
	$_SESSION['filtroprof'] = "";
} elseif ($_POST['filtroprof']) {
	$_SESSION['filtroprof'] = $_POST['filtroprof'];
}

if ($_POST['filtrotit'] == '*') {
	$_SESSION['filtrotit'] = "";
} elseif ($_POST['filtrotit']) {
	$_SESSION['filtrotit'] = $_POST['filtrotit'];
}

if ($_POST['filtroasig'] == '*') {
	$_SESSION['filtroasig'] = "";
} else if ($_POST['filtroasig']) {
	$_SESSION['filtroasig'] = $_POST['filtroasig'];
}

if ($_SESSION['auto'] == 10) {
	if ($_POST['filtroarea'] == '*') {
		$_SESSION['filtroarea'] = "";
	} else if ($_POST['filtroarea']) {
		$_SESSION['filtroarea'] = $_POST['filtroarea'];
	}
}


if ($_SESSION['auto'] < 10 AND $_SESSION['auto'] > 4) {
	if (!$_SESSION['filtroarea'] AND !$_SESSION['filtrocurso']) {
		$_SESSION['filtrocurso'] = $_SESSION['curso'];
		$iresult = $ilink->query("SELECT area FROM profcurareafigura WHERE curso = '".trim($_SESSION['filtrocurso'])."' AND profeid = '".$_SESSION['usuid']."'");
		$fila = $iresult->fetch_array(MYSQLI_BOTH);
		$_SESSION['filtroarea'] = $fila[0];
	}
	if (!$_SESSION['filtroarea']) {
		$iresult = $ilink->query("SELECT area FROM profcurareafigura WHERE curso = '".trim($_SESSION['filtrocurso'])."' AND profeid = '".$_SESSION['usuid']."'");
		$fila = $iresult->fetch_array(MYSQLI_BOTH);
		$_SESSION['filtroarea'] = $fila[0];
	}
}

$filtroprof = $_SESSION['filtroprof'];
$filtroasig = $_SESSION['filtroasig'];
$filtrocurso = $_SESSION['filtrocurso'];
if (!$filtrocurso) {$filtrocurso = "";}
$filtroarea = $_SESSION['filtroarea'];
$filtrotit = $_SESSION['filtrotit'];

if ($novacio) {
	if ($filtrocurso == "*" OR !$filtrocurso) {$noselecc = 1;}
}

echo "<form name='filtro' method='post'>";

switch($caso) {

	case 1:
		ncurso($filtrocurso,$min,$ilink);
		area($filtroarea,$ilink);
		titul($filtrotit,$ilink);
		grasigna($filtroasig, $filtroarea,$filtrocurso,$ilink);
		prof($filtroprof, $filtrocurso, $filtroarea,$ilink); echo " ";
		?>
		<script language='Javascript'>
		function vaciar(filtro) {
			document.filtro.filtrocurso.value = "*"
			document.filtro.filtroprof.value = "*"
			document.filtro.filtroasig.value = "*"
			document.filtro.filtrotit.value = "*"
			document.filtro.filtroarea.value = "*"
		}
		</script>
		<?php
		break;


	case 3:
		ncurso($filtrocurso,$min,$ilink);
		area($filtroarea,$ilink);
		prof($filtroprof,$filtrocurso,$filtroarea,$ilink); echo " ";
		?>
		<script language='Javascript'>
		function vaciar(filtro) {
			document.filtro.filtrocurso.value = "*"
			document.filtro.filtroprof.value = "*"
			document.filtro.filtroarea.value = "*"
		}
		</script>
		<?php
		break;
	case 4:
		area($filtroarea,$ilink);
		?>
		<script language='Javascript'>
		function vaciar(filtro) {
			document.filtro.filtroarea.value = "*"
		}
		</script>
		<?php
		break;
	case 5:
		ncurso($filtrocurso,$min,$ilink);
		?>
		<script language='Javascript'>
		function vaciar(filtro) {
			document.filtro.filtrocurso.value = "*"
		}
		</script>
		<?php
		break;
	case 6:
		ncurso($filtrocurso,$min,$ilink);
		area($filtroarea,$ilink);
		?>
		<script language='Javascript'>
		function vaciar(filtro) {
			document.filtro.filtrocurso.value = "*"
			document.filtro.filtroarea.value = "*"
		}
		</script>
		<?php
		break;
	case 8:
		ncurso($filtrocurso,$min,$ilink);
		titul($filtrotit,$ilink);
		prof($filtroprof,$filtrocurso,'',$ilink);
		?>
		<script language='Javascript'>
		function vaciar(filtro) {
			document.filtro.filtrocurso.value = "*"
			document.filtro.filtrotit.value = "*"
			document.filtro.filtroprof.value = "*"
		}
		</script>
		<?php
		break;

	default:
		return;	
}

// -------------------------------------------------- CURSO

function ncurso($filtrocurso,$min,$ilink) {

	$sql = "SELECT DISTINCT(curso) FROM podcursofigura WHERE curso >= $min ORDER BY curso DESC";
	$result = $ilink->query($sql);
	echo "<select class='col-1' name='filtrocurso' onchange='javascript:this.form.submit()'>";
	echo "<option value='*'>-- Filtrar por Curso --</option>";
	echo "<option value=' '";
	if ($filtrocurso == ' ') {echo " selected='selected'";;}
	echo ">Indefinido</option>";
	while ($fila = $result->fetch_array(MYSQLI_BOTH)) {
		if (!$fila[0]) {
			echo "<option value = ' '";
		} else {
			echo "<option value=$fila[0]";
		}
		if (trim($filtrocurso) == $fila[0]) {echo " selected='selected'";}
		echo ">";
		if (!$fila[0]) {
			echo "Indefinido";
		} else {		
			echo $fila[0];
		}
		echo "</option>";
	}
	echo "</select>";
}

// -------------------------------------------------- AREA

function area($filtroarea,$ilink) {
	$sql = "SELECT * FROM podareas ORDER BY podareas.area";
	$result = $ilink->query($sql);
	echo "<select class='col-2' name='filtroarea' onchange='javascript:this.form.submit()'>";
	echo "<option value='*'>-- Filtrar por &Aacute;rea --</option>";
	while ($fila = $result->fetch_array(MYSQLI_BOTH)) {
		if (strlen($fila[1]) > 100) {$fila[1] = substr($fila[1],0,99)."...";}
		echo "<option value='$fila[0]'";
		if ($filtroarea == $fila[0]) {echo " selected='selected'";}
		echo ">$fila[0] - $fila[1]</option>";
	}
	echo "</select>";
}

// -------------------------------------------------- TITULACION

function titul($filtrotit,$ilink) {
	$sql = "SELECT * FROM podtitulacion ORDER BY titulacion";
	$result = $ilink->query($sql);
	echo "<select class='col-2' name='filtrotit' onchange='javascript:this.form.submit()'>";
	echo "<option value='*'>-- Filtrar por Titulaci&oacute;n --</option>";
	while ($fila = $result->fetch_array(MYSQLI_BOTH)) {
		if (strlen($fila[1]) > 100) {$fila[1] = substr($fila[1],0,99)."...";}
		echo "<option value='$fila[0]'";
		if ($filtrotit == $fila[0]) {echo " selected='selected'"; $id = $fila['cod'];}
		echo ">$fila[0] - $fila[1]</option>";
	}
	echo "</select>";
}

// -------------------------------------------------- GRUPOS DE ASIGNATURAS

function grasigna($filtroasig,$filtroarea,$filtrocurso,$ilink) {
	$sql = "SELECT DISTINCT podcursoareagruposa.cod, podcursoareagruposa.area, grupo FROM podcursoareagruposa
				LEFT JOIN podareagruposa ON podcursoareagruposa.cod = podareagruposa.cod AND podcursoareagruposa.area =
				podareagruposa.area WHERE 1=1";
	if ($filtroarea) {$sql .= " AND podcursoareagruposa.area = '$filtroarea'";}
	if ($filtrocurso) {$sql .= " AND curso = '$filtrocurso'";}
	$result = $ilink->query($sql." ORDER BY grupo");
	echo "<select class='col-1' name='filtroasig' onchange='javascript:this.form.submit()'><option value='*'>-- Filtrar por Grupo de Asignaturas --</option>";
	while ($fila = $result->fetch_array(MYSQLI_BOTH)) {
		echo "<option value='$fila[0]"."$$"."$fila[1]'";
		if ($filtroasig == $fila[0]."$$".$fila[1]) {echo " selected='selected'"; $id = $fila['cod'];}
		echo ">$fila[0] - $fila[2]</option>";
	}
	echo "</select>";
}

// -------------------------------------------------- PROFESOR

function prof($filtroprof,$filtrocurso,$filtroarea,$ilink) {

	$sql = "SELECT DISTINCT usuarios.id, CONCAT(alumnoa,', ', alumnon) FROM usuarios";

	$sql = "SELECT DISTINCT profeid, CONCAT(alumnoa,', ',alumnon) FROM profcurareafigura";
	$sql .= " LEFT JOIN usuarios ON profcurareafigura.profeid = usuarios.id";
	$sql .= " WHERE fechabaja = '0000-00-00'";
	if ($filtroarea) {$sql .= " AND area = '$filtroarea'";}
	if ($filtrocurso) {$sql .= " AND curso = '".trim($filtrocurso)."'";}
	$sql .= " ORDER BY alumnoa, alumnon";
	$result = $ilink->query($sql);
	echo "<select class='col-2' name='filtroprof' onchange='javascript:this.form.submit()'>";
	echo "<option value='*'>-- Filtrar por Profesor --</option>";
	while ($fila = $result->fetch_array(MYSQLI_BOTH)) {
		echo "<option value='$fila[0]'";
		if ($filtroprof == $fila[0]) {echo " selected='selected'";}
		echo ">$fila[1]</option>";
	}
	echo "</select>";
	if ($filtroprof) {echo " <a href='ficha.php?usuid=$filtroprof' target='_blank'>Ficha</a>";}
}

// --------------------------------------------------

echo "<input type='hidden' name='nofiltrar'>";
echo "<input type='hidden' name='filtrocambio' value='1'>";
if (!$novacio) {
	echo "<input class='col-1' type='submit' onClick='vaciar(filtro);this.form.submit()' value='No filtrar'>";
}

echo "</form>";

if ($_SESSION['auto'] == 10 AND $pest != 15 AND strpos($_SERVER['PHP_SELF'],"pod.php") > 0) {
	echo "Los cursos mostrados en el desplegable corresponden a los cursos de la tabla FIGURAS del POD.";
}
//echo "<br>";
	
$filtrosql = "";

?>
