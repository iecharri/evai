<?php

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

if ($_POST['notasenvio']){
	$_POST = array_map('ponbarra', $_POST);
	extract($_POST);
	$temp = nl2br($notasmail2);
	$ilink->query("UPDATE cursasigru SET notasmail1 = \"$notasmail1\", notasmail2 = \"$temp\" WHERE asigna = '$asigna' AND curso = '$curso' AND grupo = '$grupo'");
	$temp = nl2br($_POST['notashsm']);
	$ilink->query("UPDATE cursasigru SET notashsm = '$temp' WHERE asigna = '$asigna' AND curso = '$curso' AND grupo = '$grupo'");
	$ilink->query("UPDATE cursasigru SET notassms = \"$notassms\" WHERE asigna = '$asigna' AND curso = '$curso' AND grupo = '$grupo'");
}

$sql = "SELECT * FROM cursasigru WHERE asigna = '$asigna' AND curso = '$curso' AND grupo = '$grupo'";
$result = $ilink->query($sql);
$fila = $result->fetch_array(MYSQLI_BOTH);
if ($fila) {
	$fila = array_map("comidoble",$fila);
	extract($fila);
}

if (!$fila['textos']) {
	$textos = "Test*Preguntas*Pr&aacute;cticas*Evaluación*Total*OJ*OF*EJ*ES";
	$ilink->query("UPDATE cursasigru SET textos = '$textos' WHERE asigna = '$asigna' AND curso = '$curso' AND grupo = '$grupo'");
}

function quitabarra($x) {return stripslashes($x);}
function ponbarra($x) {return addslashes($x);}
if (!function_exists('comidoble')) {function comidoble($x) {return str_replace("\"", "&#34;", $x);}}

// --------------------------------------------------

unset($array);

$array[0] = "<a href='#'>".i("textaenvi",$ilink)." <span class='icon-arrow-right'></span></a>";
solapah($array,1,"navhsimple");

echo "<span class='rojo b'>".i("comunictextos",$ilink)." $asigna ";
if ($curso) {echo "/ $curso ";}
echo "/ $grupo</span><p></p>";

// --------------------------------------------------

?>

<div class='col-4 fl contiene'>
<?php echo i("comunictextos1",$ilink);?>:<p></p>

<?php

$result = $ilink->query("SELECT textos FROM cursasigru WHERE  asigna = '$asigna' AND curso = '$curso' AND grupo = '$grupo'");
$textos = $result->fetch_array(MYSQLI_BOTH);
$textos = explode("*",$textos[0]);

?>

#asignatura# &nbsp; <span class='icon-arrow-right'></span> &nbsp; <?php echo i("asigna",$ilink);?><p></p>
#curso# &nbsp; <span class='icon-arrow-right'></span> &nbsp; <?php echo i("curso",$ilink);?><p></p>
#grupo# &nbsp; <span class='icon-arrow-right'></span> &nbsp; <?php echo i("grupo",$ilink);?><p></p>
#convocatoria# &nbsp; <span class='icon-arrow-right'></span> &nbsp; <?php echo i("convocatoria",$ilink);?><p></p>
#nombre# &nbsp; <span class='icon-arrow-right'></span> &nbsp; <?php echo i("nomusu",$ilink);?><p></p>
#apellidos# &nbsp; <span class='icon-arrow-right'></span> &nbsp; <?php echo i("apeusu",$ilink);?><p></p>
#test# &nbsp; <span class='icon-arrow-right'></span> &nbsp; <?php echo $textos[0]; //i("notatest",$ilink);?><p></p>
#preguntas# &nbsp; <span class='icon-arrow-right'></span> &nbsp; <?php echo $textos[1]; //i("notapreg",$ilink);?><p></p>
#practicas# &nbsp; <span class='icon-arrow-right'></span> &nbsp; <?php echo $textos[2]; //i("notaprac",$ilink);?><p></p>
#evaluacion# &nbsp; <span class='icon-arrow-right'></span> &nbsp; <?php echo $textos[3]; //i("notaeval",$ilink);?><p></p>
#total# &nbsp; <span class='icon-arrow-right'></span> &nbsp; <?php echo $textos[4]; //i("notatot",$ilink);?>

<div class='colu'>
	<span class="icon-pushpin fr grande rojo"></span><span class='b'> A recordar</span> que en los listados, las palabras:
	<span class='b'>Test</span>, <span class='b'>Preguntas</span>, <span class='b'>Pr&aacute;cticas</span>, 
	<span class='b'>Evaluaci&oacute;n</span> y <span class='b'>Total</span><br>ser&aacute;n sustitu&iacute;das por: 
	<?php
	//$textos = explode("*", $textos);
	echo "$textos[0], $textos[1], $textos[2], $textos[3] y $textos[4].";
	?>
	<br>Y las abreviaturas relativas a las convocatorias: <span class='b'>OJ</span>, <span class='b'>OF</span>, <span class='b'>EJ</span>, <span class='b'>ES</span><br>
	ser&aacute;n sustitu&iacute;das por: 
	<?php
	echo "$textos[5], $textos[6], $textos[7] y $textos[8]";
	?>
</div>

</div>

<div class='col-5 fl contiene'>
<?php 

echo "<form name='form1' action='?op=$op&pest=$pest' method='post'>";

echo i("textstand",$ilink);?>:<p></p>

<span class='b'><?php echo i("mail",$ilink);?>:</span><br>
<?php echo i("asunto",$ilink);?>:<br>
<input class='col-9' type='text' name='notasmail1' size='50' maxlength='255' value="<?php echo $fila['notasmail1'];?>">
<br><?php echo i("mensaje",$ilink);?>:<br>
<?php $temp = str_replace("<br />", "", $fila['notasmail2']);?>
<textarea class='col-9' name='notasmail2' rows='10' cols='60'><?php echo stripslashes($temp);?></textarea>


<p></p><span class='b'>HSM:</span><br>
<?php $temp = str_replace("<br />", "", $fila['notashsm']);?>
<textarea class='col-9' name='notashsm' rows='10' cols='60'><?php echo stripslashes($temp);?></textarea>

<p></p><span class='b'>SMS:</span><br>
<input class='col-9' type='text' name='notassms' size='50' maxlength='255' value="<?php echo $fila['notassms']?>">
<p></p><input class='col-2' type='submit' name='notasenvio' value=" >> ">
</form>

</div>
