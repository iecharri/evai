<?php

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

?>

<script language="Javascript">

function vaciar_T(usu) {

	usu.asigna2.value= ""
	usu.curso2.value= ""
	usu.grupo2.value= ""
	usu.tipo2.value = ""
	usu.nom2.value = ""
	usu.enlinea2.checked = ""
	usu.confoto2.checked = ""
	usu.sinfoto2.checked = ""
	usu.nota2.value = " "
	usu.convid2.checked = ""
	usu.sinvid2.checked = ""
	usu.congrup2.checked = ""
	usu.delgrup2.value = ""

}

function vaciar_noACG(usu) {

	usu.tipo2.value = ""
	usu.nom2.value = ""
	usu.enlinea2.checked = ""
	usu.confoto2.checked = ""
	usu.sinfoto2.checked = ""
	usu.nota2.value = " "
	usu.convid2.checked = ""
	usu.sinvid2.checked = ""
	usu.congrup2.checked = ""
	usu.delgrup2.value = ""

}

function vaciar_4(usu) {

	usu.asigna2.value= ""
	usu.curso2.value= ""
	usu.grupo2.value= ""
	usu.tipo2.value = ""
	usu.nom2.value = ""
	usu.enlinea2.checked = ""
	usu.confoto2.checked = ""
	usu.sinfoto2.checked = ""
	usu.convid2.checked = ""
	usu.sinvid2.checked = ""
	usu.congrup2.checked = ""
	usu.delgrup2.value = ""

}

</script>

<?php

if ($_GET['m'] == 1) {
	$_SESSION['b'][0] = $_SESSION['asigna'];
	$_SESSION['b'][1] = $_SESSION['curso'];
	$_SESSION['b'][2] = $_SESSION['grupo'];
}

if($_POST['listar']) {
	$_SESSION['b'][0] = $_POST['asigna2'];
	$_SESSION['b'][1] = $_POST['curso2'];
	$_SESSION['b'][2] = strtoupper($_POST['grupo2']);
	$_SESSION['b'][3] = $_POST['tipo2'];

	if (!$_POST['asigna2']) {$_SESSION['b'][0] = ' ';}

	$_SESSION['b'][4] = $_POST['nota2'];
	$_SESSION['b'][5] = $_POST['nom2'];
	$_SESSION['b'][6] = $_POST['enlinea2'];
	$_SESSION['b'][7] = $_POST['confoto2'];
	$_SESSION['b'][8] = $_POST['sinfoto2'];
	$_SESSION['b'][9] = $_POST['convid2'];
	$_SESSION['b'][10] = $_POST['sinvid2'];
	$_SESSION['b'][11] = $_POST['congrup2'];
	$_SESSION['b'][12] = $_POST['delgrup2'];

	if ($_SESSION['b'][3] == 'P') {
		$_SESSION['b'][4] =' ';
	}

	if ($_SESSION['b'][3] == 'E') {
		$_SESSION['b'][1] = '';
		$_SESSION['b'][0] ='';
		$_SESSION['b'][2] ='';
		$_SESSION['b'][4] =' ';
	}
}

$asigna = $_SESSION['b'][0]; 
$curso = $_SESSION['b'][1]; 
$grupo = $_SESSION['b'][2];

// --------------------------------------------------

if(!$noformu) {
	formu($ilink, $asigna, $curso, $grupo, $pest, $script);
}

// --------------------------------------------------

// ojo, el $sql antiguo llevaba fechax y este no. Ver en quien llama a sqlusuarios.php para adaptar alli
$sql = "
SELECT DISTINCT(usuarios.id), fecha, fechalogin, mail, tfmovil, autorizado, 
       alumnon, alumnoa, alumasiano.*
FROM usuarios 
LEFT JOIN alumasiano ON alumasiano.id = usuarios.id 
LEFT JOIN asignatprof ON usuarios.id = asignatprof.usuid 
LEFT JOIN gruposusu ON gruposusu.usu_id = usuarios.id 
LEFT JOIN grupos ON grupos.id = gruposusu.grupo_id 
WHERE usuarios.autorizado > 1 
  AND usuarios.fechabaja = '0000-00-00 00:00:00'";

if ($_SESSION['b'][3] == 'A') {$sql .= "AND tipo = 'A' ";}
if ($_SESSION['b'][3] == 'P') {$sql .= "AND (tipo = 'P' AND autorizado > 4) ";}
if ($_SESSION['b'][3] == 'E') {$sql .= "AND tipo = 'E' ";}

// -------------------------------------------------- ! SOLOHSM // --------------------------------------------------
	
if ($asigna AND $asigna != ' ') {
	$sql .= " AND ";
	if ($_SESSION['b'][3] == '') {$sql .= "((alumasiano.asigna = '$asigna' AND alumasiano.auto > 1) OR asignatprof.asigna = '$asigna')";}
	if ($_SESSION['b'][3] == 'A') {$sql .= " alumasiano.asigna = '$asigna' AND alumasiano.auto > 1";}
	if ($_SESSION['b'][3] == 'P') {$sql .= " asignatprof.asigna = '$asigna'";}
}

if ($curso != '') {
	$sql .= " AND ";
	if ($_SESSION['b'][3] == '') {$sql .= "(alumasiano.curso = '$curso' OR asignatprof.curso = '$curso')";}
	if ($_SESSION['b'][3] == 'A') {$sql .= "alumasiano.curso = '$curso'";}
	if ($_SESSION['b'][3] == 'P') {$sql .= " asignatprof.curso = '$curso'";}
}

if ($grupo != '') {
	$sql .= " AND ";
	if ($_SESSION['b'][3] == '') {$sql .= "(alumasiano.grupo = '$grupo' OR asignatprof.grupo = '$grupo')";}
	if ($_SESSION['b'][3] == 'A') {$sql .= "alumasiano.grupo = '$grupo'";}
	if ($_SESSION['b'][3] == 'P') {$sql .= " asignatprof.grupo = '$grupo'";}
}

// -------------------------------------------------- ! SOLOHSM // --------------------------------------------------

if ($_SESSION['b'][5] != '') {
	$sql .= " AND CONCAT(trim(alumnon),' ', trim(alumnoa)) LIKE '%".$_SESSION['b'][5]."%'" ;
}

// -------------------------------------------------- ! SOLOHSM // --------------------------------------------------

if ($_SESSION['b'][7] == 'on') {$sql .= " AND foto != ''" ;}
if ($_SESSION['b'][8] == 'on') {$sql .= " AND foto = ''" ;}
if ($_SESSION['b'][9] == 'on') {$sql .= " AND (usuarios.video != '' OR usuarios.video1 != '')" ;}
if ($_SESSION['b'][10] == 'on') {$sql .= " AND usuarios.video = '' AND usuarios.video1 = ''" ;}

if ($_SESSION['b'][11] == 'on') {$sql .= " AND grupo_id != ''" ;}
if ($_SESSION['b'][12]) {$sql .= " AND grupos.grupo = '".$_SESSION['b'][12]."'" ;}

if ($_SESSION['b'][4] AND $_SESSION['b'][4] != " " AND $_SESSION['auto'] > 4) {
	$sql .= " AND ";
	if ($_SESSION['b'][4] == "_") {
		$sql .= "total != 0";
	} else {
		$sql .= $_SESSION['b'][4]."_total != 0";
	}

if ($_SESSION['b'][6]) {
	$timestamp = time(); // en UTC
	$corte = gmdate('Y-m-d H:i:s', $timestamp - 30);
	$sql .= " AND fecha >= '$corte' AND estado < 2";

	if ($_SESSION['auto'] < 10) {
		$sql .= " AND (estado=0 OR autorizado < ".$_SESSION['auto']." OR usuarios.id = '".$_SESSION['usuid']."')";
	}
}

}
// -------------------------------------------------- ! SOLOHSM // --------------------------------------------------

$sql .=  " GROUP BY usuarios.id ";

// --------------------------------------------------

if (!function_exists('comidoble')) {function comidoble($x) {return str_replace("\"", "&#34;", $x);}}

// --------------------------------------------------

function formu($ilink, $asigna, $curso, $grupo, $pest, $script) {

	echo "<form name='usu' method='post'>";

	if($script == "admin" AND $_SESSION['op'] == 1) {
		$asigna = $_SESSION['asigna'];
		$curso = $_SESSION['curso'];
		$grupo = $_SESSION['grupo'];
		$fijar = "readonly"; $fijar1 = "disabled";
	}

	echo i("quesean",$ilink)."<br>";
	echo "<select name='tipo2'><option value=''>";
	echo "<option value = 'A' ";
		if ($_SESSION['b'][3] == "A") {echo "selected = 'selected'";}
	echo ">".i("alumno",$ilink)."\n";
	echo "<option value = 'P' ";
		if ($_SESSION['b'][3] == "P") {echo "selected = 'selected'";}
	echo ">".i("profesor",$ilink)."\n";
	echo "<option value = 'E' ";
		if ($_SESSION['b'][3] == "E") {echo "selected = 'selected'";}
	echo ">".i("externo",$ilink)."\n";
	echo "</select><p></p>";

	echo i("cuyonom",$ilink)."<br><input class='col-2' type='text' size='15' maxlength='15' name='nom2' value=\"".$_SESSION['b'][5]."\"> ";

	echo "<p></p>".i("delcurso",$ilink)."<br><input class='col-2' type='text' name='curso2' maxlength='4' size='4' value='$curso' $fijar> / 
	<input class='col-2' type='text' name='grupo2' size='6' maxlength='6' value='$grupo' $fijar><p></p>";

	echo i("delaasigna",$ilink)."<br>";

	echo "<select class='col-10' name='asigna2' $fijar1><option value=''>\n";
	$result1 = $ilink->query("SELECT * from podasignaturas ORDER BY asignatura");
	while ($fila = $result1->fetch_array(MYSQLI_BOTH)) {
		echo "<option value = '$fila[0]'";
		if ($fila[0] == $asigna) {
			echo " selected = 'selected'";
		}
		$temp = $fila[1]; if (strlen($temp) > 70) {$temp = substr($temp,0,70)."...";}
		echo ">$fila[0] $temp\n";
	}
	echo "</select>";

	if($fijar) {
		echo "<input type='hidden' name='asigna2' value='$asigna'>";
	}
	
	echo "<p></p>";

	if ($_SESSION['auto'] > 4) {
		echo "<p></p><label>".i("connota",$ilink)."</label> <select name='nota2'>";
		echo "<option value= ' '";if ($_SESSION['b'][4] == ' ') {echo " selected = 'selected'";} echo ">";
		echo "<option value='OF'";if ($_SESSION['b'][4] == 'OF') {echo " selected = 'selected'";} echo ">OF";
		echo "<option value='EJ'";if ($_SESSION['b'][4] == 'EJ') {echo " selected = 'selected'";} echo ">EJ";
		echo "<option value='ES'";if ($_SESSION['b'][4] == 'ES') {echo " selected = 'selected'";} echo ">ES";
		echo "<option value='OJ'";if ($_SESSION['b'][4] == 'OJ') {echo " selected = 'selected'";} echo ">OJ";
		echo "<option value='_'";if ($_SESSION['b'][4] == '_') {echo " selected = 'selected'";} echo ">&uacute;nica";
		echo "</select>";
	}

	echo "<p></p>".i("enlinea1",$ilink)." <input type='CHECKBOX' name='enlinea2'";
	if ($_SESSION['b'][6] == 'on') {echo "checked='checked'";}
	echo ">\n";

	echo i("fotosi",$ilink)." <input type='CHECKBOX' name='confoto2' ";
	if ($_SESSION['b'][7] == 'on') {echo "checked='checked'";}
	echo "> ";

	echo i("fotono",$ilink)." <input type='CHECKBOX' name='sinfoto2' ";
	if ($_SESSION['b'][8] == 'on') {echo "checked='checked'";}
	echo "> ";

	echo i("videosi",$ilink)." <input type='CHECKBOX' name='convid2' ";
	if ($_SESSION['b'][9] == 'on') {echo "checked='checked'";}
	echo "> ";

	echo "".i("videono",$ilink)." <input type='CHECKBOX' name='sinvid2' ";
	if ($_SESSION['b'][10] == 'on') {echo "checked='checked'";}
	echo ">";

	echo "<p></p>".i("engrupo",$ilink)." <input type='CHECKBOX' name='congrup2' ";
	if ($_SESSION['b'][11] == 'on') {echo "checked='checked'";}
	echo "><p></p>";

	echo i("nombgrupo",$ilink)." <input class='col-3' type='text' size='15' maxlength='15' name='delgrup2' value=\"".$_SESSION['b'][12]."\"><p></p>\n";

	if ($script == "admin" AND $pest != 5) {
		$temp = "P";
	} elseif($_SESSION['auto'] == 10) {
		$temp = "A";
	} else {
		$temp = "2";
	}

	if($_SESSION['auto'] < 5) {
		$temp = "4";
	} elseif($script == "usuarios" OR $_SESSION['op'] == 3) {
		$temp = "T";
	} else {
		$temp = "noACG";
	}

	echo "<input class='col-3' type='button' value='".i("vaciarcamp",$ilink)."' onclick='vaciar_".$temp."(usu)'>";
	echo " <input class='col-3' type='submit' name='listar' value='".i("verusu",$ilink)."'>\n";

	echo"</form>";
	
}

?>