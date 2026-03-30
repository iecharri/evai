<?php

require_once __DIR__ . '/siempre.php';

$a_misa = "active";

require_once APP_DIR . '/molde_top.php';

if ($_SESSION['auto'] < 2 OR $_SESSION['tipo'] != 'A') {return;}
$usuid = $_SESSION['usuid'];

require_once APP_DIR . '/asigalu1.php';

// --------------------------------------------------

if ($_POST['anadir']) {
	$mensaje = anadir($usuid, $_POST['edcurasigru'],$ilink);
}

if ($_POST['borrar']) {

	borrar($usuid, $_POST['edasigna'], $_POST['edcurso'], strtoupper($_POST['edgrupo']),$ilink);
	// var_asig.php debe recibir las variables de $asigna, $curso y $grupo
	require_once APP_DIR . '/var_asig.php';

}

// --------------------------------------------------

echo "
<script language='JavaScript' type='text/javascript'>
function compruebaasign(form1) {

	if (form1.edasigna.value == \"\")
	{
		alert(\"".i("eligeasigna",$ilink)."\")
		return false
	}
	
}
</script>";

// --------------------------------------------------

unset($array);
$array = array();

if($_SESSION['tipo'] == "A") {
	$array[] = "<a href=?pest=1>".i("registrarme",$ilink)."</a>";
	$array[] = "<a href=?pest=2>".i("borrarme",$ilink)."</a>";
} else {
	$array[] = "";
	$array[] = "";
}

$array[] = "<a href='misasignaturas.php'>".i("misasigna",$ilink)."</a>";
$pest = $_GET['pest'];
if (!$pest) {$pest = 3;}

// --------------------------------------------------

solapah($array,$pest,"navhsimple");

// --------------------------------------------------

$iresult = $ilink->query("SELECT altalibre FROM atencion");
$alta = $iresult->fetch_array(MYSQLI_BOTH);
if (!$alta[0] AND $_SESSION['auto'] < 10) {require_once APP_DIR .  "/molde_bott.php"; return;}

$mes = gmdate("m"); $ano = gmdate("Y");
if ($mes > 9) {$ano = $ano+1;}

// --------------------------------------------------

if ($pest == 1) {

	if ($_SESSION['auto'] < 4) {
		echo "<p></p><span class='rojo mediana'>".i("usunoaut",$ilink)."</span>";
		echo "</div>"; return;
	}

	echo "<p></p><div class='mediana'>$mensaje</div>";

	echo "<p class='mediana'>".i("selecasi",$ilink).":</>";
	echo "<form action=?pest=1 name='form1' method='post' onsubmit='return compruebaasign(form1)'>";
	echo "<span class='txth b mediana'>".i("asignadispo",$ilink).":</span>";
	$sql = "SELECT DISTINCT podasignaturas.asignatura, podasignaturas.cod,podtitulacion.titulacion,
		podcursoasignatit.curso, asignatprof.grupo FROM asignatprof
		LEFT JOIN podcursoasignatit ON asignatprof.curso = podcursoasignatit.curso AND
		asignatprof.asigna = podcursoasignatit.asigna
		LEFT JOIN cursasigru ON asignatprof.asigna = cursasigru.asigna AND
		asignatprof.curso = cursasigru.curso AND asignatprof.grupo = cursasigru.grupo
		LEFT JOIN podasignaturas ON asignatprof.asigna =  podasignaturas.cod
		LEFT JOIN podtitulacion ON podcursoasignatit.tit = podtitulacion.cod
		LEFT JOIN usuarios ON asignatprof.usuid = usuarios.id
		WHERE visibleporalumnos = 1 AND (podcursoasignatit.curso = '' OR
		podcursoasignatit.curso >= '".gmdate("Y")."')
		AND fechabaja = '0000-00-00 00:00:00'
		ORDER BY podcursoasignatit.curso,podcursoasignatit.asigna";
	$result = $ilink->query($sql);
	echo "<br><select class='col-10' name='edcurasigru' size='15'>";
	$ed = explode("*",$_POST['edcurasigru']);
	while ($fila = $result->fetch_array(MYSQLI_BOTH)) {
		echo "<option value = '$fila[3]*$fila[1]*$fila[4]' ";
		if ($fila[3] == $ed[0] AND $fila[1] == $ed[1] AND $fila[4] == $ed[2]) {echo " selected = 'selected'";}
		$temp = $fila[3]; if (!$temp) {$temp = "Indef.";}
		if ($fila[4]) {$temp1 = " - Grupo $fila[4]";}
		echo ">".$temp.$temp1." - ".$fila[1]." ".$fila[0]." - ".$fila[2];
		echo "</option>\n";
	}
	echo "</select><p></p>";
	echo "<input type='hidden' name='anadir' value='1'>";
	echo "<input class='col-10' type='submit' value=\" >> ".i("anadir1",$ilink)." >> \">";
	echo "</form>";

}

if ($pest == 2) {

	echo "<p>".i("borrarasi",$ilink).":</p>";

	$sql = "SELECT asigna, asignatura, curso, grupo FROM alumasiano
		LEFT JOIN podasignaturas ON podasignaturas.cod = alumasiano.asigna
		WHERE id = '$usuid' AND asigna != 'GEN' 
		ORDER BY asigna, curso, grupo";
	$result = $ilink->query($sql);

	$num = 0;
	while ($fila = $result->fetch_array(MYSQLI_BOTH)) {
		echo "[ <a href='?pest=2&borr=1&edasigna=$fila[0]&edcurso=$fila[2]&edgrupo=$fila[3]'>".i("borrarfich",$ilink)."</a> ] $fila[0] $fila[1]";
		if ($fila[2]) {echo " - Curso: $fila[2]";}
		if ($fila[3]) {echo " - Grupo: ".strtoupper($fila[3]);}
		echo "<br>\n";
		$num ++;
	}

	if ($_GET['borr'] == 1) {

		echo "<p></p>".i("borrasi",$ilink).": ".$_GET['edasigna'];
		if ($_GET['edcurso']) {echo ", curso: ".$_GET['edcurso'];}
		echo ", grupo: ".$_GET['edgrupo'];

		if ($num > 1) {
			$result = $ilink->query("SELECT asigna FROM alumasiano WHERE id = '$usuid' AND asigna = '".$_GET['edasigna']."'");
			if ($result->num_rows == 1) {
				echo "<br>".i("borrasig1",$ilink);
			}
		} else {
			echo "<br>".i("borrasig2",$ilink)."<br>";
		}

		echo "<div id='esperar' style='display:none'><p><br></p>";
		echo $imgloader.i("esperar",$ilink);
		echo "<p><br></p></div>";
		echo "<div id='confirma'><form name='form1' method='post' action='?pest=2'>";
		echo "<input type='hidden' name='edasigna' value=".$_GET['edasigna'].">";
		echo "<input type='hidden' name='edcurso' value=".$_GET['edcurso'].">";
		echo "<input type='hidden' name='edgrupo' value=".$_GET['edgrupo'].">";
		echo "<input type='submit' name='borrar' value='Confirmar' onclick=\"show('esperar');hide('confirma')\">";
		echo "</form></div>";

	}

}

require_once APP_DIR .  "/molde_bott.php";

// --------------------------------------------------

?>
