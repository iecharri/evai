<?php

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

if ($_SESSION['auto'] < 5){exit;}

if (!function_exists('comidoble')) {function comidoble($x) {return str_replace("\"", "&#34;", $x);}}

// --------------------------------------------------

$usuid = $_GET['usuid'];
extract($_POST);

echo "<div class='txth b'>".i("comunicestand",$ilink)."</div><div class='both'></div>";

$asigna = $_SESSION['asigna'];
if($_GET['asigna']){$asigna=$_GET['asigna'];}

if ($porhsm) {
	if (porhsm($textohsm,$usuid,1,$ilink)) {echo "<p></p>".i("mesenvihsm",$ilink);}
}

if ($pormail) {
	$exito = pormail($_SESSION['usuid'],trim($usuid),trim(nl2br($asuntomail)),trim(nl2br($textomail)),$textomail,$ilink);
	if ($exito) {
		echo "<p></p>".i("mesenvimail",$ilink);
	} else {
		echo "<p></p>".i("mesenvimail",$ilink)." <span class='rojo b'>Error</span>";
	}
}

if ($enviarnota) {
	if ($enviosms) {echo "<p></p>".i("mesenvisms",$ilink);}
	return;
}

// --------------------------------------------------

$formula = formula($asigna,$curso,$grupo,$ilink);
$test1 = $formula[0]; $preg1 = $formula[1]; $prac1 = $formula[2];$eval1 = $formula[3];

// --------------------------------------------------

$sql = "SELECT usuarios.alumnon, usuarios.alumnoa, usuarios.mail, ".$conv."test, ".$conv."preg, ".$conv."prac, ".$conv."eval,".$conv."total, ".$conv."aprobado, tfmovil FROM alumasiano LEFT JOIN usuarios ON usuarios.id = alumasiano.id WHERE alumasiano.asigna = '$asigna' AND alumasiano.id = '$usuid'";

if ($curso){$sql .= " AND alumasiano.curso = '$curso'";}
if ($grupo){$sql .= " AND alumasiano.grupo = '$grupo'";}

$result = $ilink->query($sql);
if ($ilink->errno) {die ("Error");}

$fila = $result->fetch_array(MYSQLI_BOTH);

extract($fila);

$result = $ilink->query("SELECT mail FROM usuarios WHERE id = '".$_SESSION['usuid']."' LIMIT 1");
$temp = $result->fetch_array(MYSQLI_BOTH);

// --------------------------------------------------

$from1 = minom(1,1,$ilink); $from2 =trim($temp[0]);

$to = trim($alumnon)." ".trim($alumnoa)." <".$fila['mail'].">";

$iresult = $ilink->query("SELECT * FROM cursasigru WHERE asigna = '$asigna' AND curso = '$curso' AND grupo = '$grupo'");
$texto = $iresult->fetch_array(MYSQLI_BOTH); 
$conv = str_replace("_", "", $_GET['conv']);

if ($fila[8] == 2) {
	$mensaje = ": ".i("suspensodesc",$ilink);
	$fila[7] = "";
} else {
	if ($fila[7] < 5) {$mensaje = " ".i("suspenso",$ilink);}
	if ($fila[7] >= 5 AND $fila[7] < 7) {$mensaje = " ".i("aprobado",$ilink);}
	if ($fila[7] >= 7 AND $fila[7] < 9) {$mensaje = " ".i("notable",$ilink);}
	if ($fila[7] >= 9) {$mensaje = " ".i("sobresaliente",$ilink);}
	$fila[7] = number_format($fila[7],2,',','.');
}
$fila[7] .= $mensaje;

$asuntomail = $texto['notasmail1'];
$asuntomail = str_replace("#asignatura#",$asigna,$asuntomail);
$asuntomail = str_replace("#curso#",$curso,$asuntomail);
$asuntomail = str_replace("#grupo#",$grupo,$asuntomail);
$asuntomail = str_replace("#nombre#",$alumnon,$asuntomail);
$asuntomail = str_replace("#apellidos#",$alumnoa,$asuntomail);
$asuntomail = str_replace("#test#",number_format(($fila[3]*$test1),2,',','.'),$asuntomail);
$asuntomail = str_replace("#preguntas#",number_format(($fila[4]*$preg1),2,',','.'),$asuntomail);
$asuntomail = str_replace("#practicas#",number_format(($fila[5]*$prac1),2,',','.'),$asuntomail);
$asuntomail = str_replace("#evaluacion#",number_format(($fila[6]*$eval1),2,',','.'),$asuntomail);
$asuntomail = str_replace("#total#",$fila[7],$asuntomail);
$asuntomail = str_replace("#convocatoria#",$conv,$asuntomail);

$textomail = $texto['notasmail2'];
$textomail = str_replace("#asignatura#",$asigna,$textomail);
$textomail = str_replace("#curso#",$curso,$textomail);
$textomail = str_replace("#grupo#",$grupo,$textomail);
$textomail = str_replace("#nombre#",$alumnon,$textomail);
$textomail = str_replace("#apellidos#",$alumnoa,$textomail);
$textomail = str_replace("#test#",number_format(($fila[3]*$test1),2,',','.'),$textomail);
$textomail = str_replace("#preguntas#",number_format(($fila[4]*$preg1),2,',','.'),$textomail);
$textomail = str_replace("#practicas#",number_format(($fila[5]*$prac1),2,',','.'),$textomail);
$textomail = str_replace("#evaluacion#",number_format(($fila[6]*$eval1),2,',','.'),$textomail);
$textomail = str_replace("#total#",$fila[7],$textomail);
$textomail = str_replace("#convocatoria#",$conv,$textomail);

$textohsm = $texto['notashsm'];
$textohsm = str_replace("#asignatura#",$asigna,$textohsm);
$textohsm = str_replace("#curso#",$curso,$textohsm);
$textohsm = str_replace("#grupo#",$grupo,$textohsm);
$textohsm = str_replace("#nombre#",$alumnon,$textohsm);
$textohsm = str_replace("#apellidos#",$alumnoa,$textohsm);
$textohsm = str_replace("#test#",number_format(($fila[3]*$test1),2,',','.'),$textohsm);
$textohsm = str_replace("#preguntas#",number_format(($fila[4]*$preg1),2,',','.'),$textohsm);
$textohsm = str_replace("#practicas#",number_format(($fila[5]*$prac1),2,',','.'),$textohsm);
$textohsm = str_replace("#evaluacion#",number_format(($fila[6]*$eval1),2,',','.'),$textohsm);
$textohsm = str_replace("#total#",$fila[7],$textohsm);
$textohsm = str_replace("#convocatoria#",$conv,$textohsm);

$textosms = $texto['notassms'];
$textosms = str_replace("#asignatura#",$asigna,$textosms);
$textosms = str_replace("#curso#",$curso,$textosms);
$textosms = str_replace("#grupo#",$grupo,$textosms);
$textosms = str_replace("#nombre#",$alumnon,$textosms);
$textosms = str_replace("#apellidos#",$alumnoa,$textosms);
$textosms = str_replace("#test#",number_format(($fila[3]*$test1),2,',','.'),$textosms);
$textosms = str_replace("#preguntas#",number_format(($fila[4]*$preg1),2,',','.'),$textosms);
$textosms = str_replace("#practicas#",number_format(($fila[5]*$prac1),2,',','.'),$textosms);
$textosms = str_replace("#evaluacion#",number_format(($fila[6]*$eval1),2,',','.'),$textosms);
$textosms = str_replace("#total#",$fila[7],$textosms);
$textosms = str_replace("#convocatoria#",$conv,$textosms);

// --------------------------------------------------

?>

<p></p><form name='form' method='post' onsubmit="show('esperar')">

<div class='fl colu'>

<?php
echo "<span class='b'>MAIL</span><br>";
echo "De<br><input type='text' name='from1' value=\"$from1\" size='50' maxlength='255' disabled>";
echo "<br><input type='text' name='from2' value=\"$from2\" size='50' maxlength='255' disabled>";
echo "<br>Para<br><input type='text' name='to' value=\"$to\" size='50' maxlength='255' disabled>";
echo "<br>Asunto<br><input type='text' name='asuntomail' value=\"$asuntomail\" size='50' maxlength='255'>";
$textomail = str_replace("<br />", "", $textomail);
echo "<br>Texto<br><textarea name='textomail' rows='10' cols='40'>$textomail</textarea>";

echo "</div><div class='fl colu'>";

echo "<span class='b'>HSM</span>";
$textohsm = str_replace("<br />", "", $textohsm);
echo "<br><textarea name='textohsm' rows='10' cols='40'>$textohsm</textarea>";

echo "<br><span class='b'>SMS</span>";
echo "<br><input type='hidden' name='tfmovil' value=\"".trim($fila['tfmovil'])."\"><input type='text' name='textosms' value=\"".comidoble($textosms)."\" size='50' maxlength='255'>";

echo "<p></p>Por mail: <input type='checkbox' name='pormail' checked='checked'>&nbsp;&nbsp;&nbsp;Por HSM: <input type='checkbox' name='porhsm'>&nbsp;&nbsp;&nbsp;Por SMS: <input type='checkbox'  disabled='disabled' name='porsms' ";
if ($_SESSION['auto'] < 10 OR !$fila['tfmovil'] OR $fila['tfmovil'] == 0) {echo " disabled";}
echo ">";

echo "<p></p><input type='submit' value='>> ".i("enviar",$ilink)." >>' name='enviarnota'>";

echo "</div></form><div class='both'></div>";

echo "<div id='esperar' style='display:none'><p><br></p>";
echo $imgloader.i("esperar",$ilink);
echo "<p><br></p></div>";

?>


