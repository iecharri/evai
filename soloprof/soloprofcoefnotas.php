<?php

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

if ($_POST['coef']){
	extract($_POST);
	$ilink->query("UPDATE cursasigru SET divisor = '$divisor', test = '$test', preg = '$preg', prac = '$prac', eval='$eval', votosalumnos = '$votosalumnos', notaprofesor = '$notaprofesor', mintest = '$mintest', minpreg = '$minpreg', minprac = '$minprac',mineval = '$mineval' WHERE asigna = '$asigna' AND curso = '$curso' AND grupo = '$grupo'");
	$textos = $ttest."*".$tpreg."*".$tprac."*".$teval."*".$ttotal."*".$toj."*".$tof."*".$tej."*".$tes;
	$ilink->query("UPDATE cursasigru SET textos = \"$textos\" WHERE  asigna = '$asigna' AND curso = '$curso' AND grupo = '$grupo'");
}

// --------------------------------------------------

if ($_POST['usarcoef']) {
	if ($_POST['usarc'] == 'on') {$usarc = 1;} else {$usarc = 0;}
	$ilink->query("UPDATE cursasigru SET coefi = '$usarc' WHERE asigna = '$asigna' AND curso = '$curso' AND grupo = '$grupo'");
}

// --------------------------------------------------

unset($array);

$array[0] = "<a href='#'>".i("notas",$ilink)." <span class='icon-arrow-right'></span></a>";
solapah($array,1,"navhsimple");

// --------------------------------------------------

$iresult = $ilink->query("SELECT vernotas FROM atencion");
$vernota = $iresult->fetch_array(MYSQLI_BOTH);

echo "<span class='rojo b'>";
if (!$vernota[0]) {echo i("vernotasno",$ilink);} else {echo i("vernotassi",$ilink);}
echo "</span><p></p>";

if ($_POST['visi'] OR $_POST['verlis']) {
	if ($_POST['verlista'] == 'on') {$verlistanota = 1;} else {$verlistanota = 0;}
	if ($_POST['vernota'] == 'on') {$verprof = 1;} else {$verprof = 0; $verlistanota = 0;}
	$ilink->query("UPDATE cursasigru SET vernota = '$verprof', verlistanota = '$verlistanota' 
	WHERE asigna = '$asigna' AND curso = '$curso' AND grupo = '$grupo'");
}

$iresult = $ilink->query("SELECT vernota, coefi, textos, verlistanota FROM cursasigru 
WHERE asigna = '$asigna' AND curso = '$curso' AND grupo = '$grupo'");
$verprof = $iresult->fetch_array(MYSQLI_BOTH);

// --------------------------------------------------

echo "<form method='post' name='visi'>";
echo ucfirst(i("vernotas1",$ilink))." <input type='checkbox' name='vernota' ";
if ($verprof[0]) {echo "checked='checked'";}
echo "> <input class='col-1' type='submit' name='visi' value=' >> '> <span class='peq nob'>
(Marcar para que cada alumno vea su nota)</span><br>";
echo "Listado de Notas de toda la clase visible por los alumnos<input type='checkbox' name='verlista' ";
if ($verprof[3]) {echo "checked='checked'";}
echo "> <input class='col-1' type='submit' name='verlis' value=' >> '> <span class='peq nob'>
(Marcar para que sea visible, es necesario marcar la opci&oacute;n anterior)</span>";
echo "</form><br>";

// --------------------------------------------------

// --------------------------------------------------
echo "<form method='post' name='usarcoef1'>";
echo " Usar coeficientes de notas <input type='checkbox' name='usarc' ";if ($verprof[1]) {echo "checked='checked'";}
echo "> <input class='col-1' type='submit' name='usarcoef' value=' >> '> (si se desmarca, se usar&aacute; una &uacute;nica nota global)";
echo "</form><br>";

echo "<p></p>";

// --------------------------------------------------

?>

<form name='form' method='post'>

<span class='rojo b'>Sustituir las siguientes palabras o abreviaturas en los listados</span>
 (255 caracteres en total)<p></p>

<?php
$textos = $verprof['textos'];
if (!$textos) {
	$textos = "Test*Preguntas*Pr&aacute;cticas*Evaluación*Total*OJ*OF*EJ*ES";
	$ilink->query("UPDATE cursasigru SET textos = '$textos' WHERE asigna = '$asigna' AND curso = '$curso' AND grupo = '$grupo'");
}
$textos = explode("*",$textos);
$ttest = $textos[0];
$tpreg = $textos[1];
$tprac = $textos[2];
$teval = $textos[3];
$ttotal = $textos[4];
$toj = $textos[5];
$tof = $textos[6];
$tej = $textos[7];
$tes = $textos[8];

$tipo = "display:none";

if($verprof[1]) {$tipo = "";}
	
?>

<span style='<?php echo $tipo;?>'>

Test 
<input class='col-1' type='<?php echo $tipo;?>' name='ttest' size='15' maxlength='25' value="<?php echo $ttest;?>">
 &nbsp; Preguntas 
<input class='col-1' type='<?php echo $tipo;?>' name='tpreg' size='15' maxlength='25' value="<?php echo $tpreg;?>">
 &nbsp; Pr&aacute;cticas 
<input class='col-1' type='<?php echo $tipo;?>' name='tprac' size='15' maxlength='25' value="<?php echo $tprac;?>">
 &nbsp; Evaluaci&oacute;n 
<input class='col-1' type='<?php echo $tipo;?>' name='teval' size='15' maxlength='25' value="<?php echo $teval;?>">
 &nbsp;  </span>Total
<input class='col-1' type='text' name='ttotal' size='15' maxlength='25' value="<?php echo $ttotal;?>">
<p></p>Convocatorias
 &nbsp; OJ
<input class='col-1' type='text' name='toj' size='15' maxlength='25' value="<?php echo $toj;?>">
 &nbsp; OF
<input class='col-1' type='text' name='tof' size='15' maxlength='25' value="<?php echo $tof;?>">
 &nbsp; EJ
<input class='col-1' type='text' name='tej' size='15' maxlength='25' value="<?php echo $tej;?>">
 &nbsp; ES
<input class='col-1' type='text' name='tes' size='15' maxlength='25' value="<?php echo $tes;?>">

<?php

if (!$verprof[1]) {
	?>
	<p></p><input class='col-2' type='submit' name='coef' value=" >> <?php echo i("agvalid",$ilink);?> >> ">
	</form>
	<?php
	return;
}

// --------------------------------------------------

$sql = "SELECT * FROM cursasigru WHERE asigna = '$asigna' AND curso = '$curso' AND grupo = '$grupo'";
$result = $ilink->query($sql);
$fila = $result->fetch_array(MYSQLI_BOTH);
if ($fila) {extract($fila);}

echo "<p></p><span class='rojo b'>".i("coefnotas",$ilink)."</span><p></p>";

?>

<span class='peq'>

total = (COEF_TEST x notatest) + (COEF_PREGUNTAS x notapreguntas) + (COEF_EVALUCACION x notaevaluacion) + (COEF_PR&Aacute;CTICAS x NOTA_PR&Aacute;CTICAS)
<p></p>
NOTA_PR&Aacute;CTICAS = ((COEF_VOTOS x votosrecibidos) + (COEF_PROFESOR x notaprofesor)) / 

</span>

<?php 
$divisor = $fila['divisor'];
if (!$divisor) {$divisor = 2;}
?>

<input class='col-05' type='text' name='divisor' size='1' maxlength='1' value='<?php echo $divisor;?>'>

<p></p><span class='b'>COEF_TEST</span>: 
<input class='col-4em' type='text' name='test' size='5' maxlength='5' value="<?php echo $fila['test'];?>">
 &nbsp; <span class='b'>COEF_PREGUNTAS</span>: 
<input class='col-4em' type='text' name='preg' size='5' maxlength='5' value="<?php echo $fila['preg'];?>">
 &nbsp; <span class='b'>COEF_PR&Aacute;CTICAS</span>: 
<input class='col-4em' type='text' name='prac' size='5' maxlength='5' value="<?php echo $fila['prac'];?>">
&nbsp; <span class='b'>COEF_EVALUACION</span>: 
<input class='col-4em' type='text' name='eval' size='5' maxlength='5' value="<?php echo $fila['eval'];?>">
<p></p><span class='b'>COEF_VOTOS</span>: 
<input class='col-4em' type='text' name='votosalumnos' size='5' maxlength='5' value="<?php echo $fila['votosalumnos']?>">
 &nbsp; <span class='b'>COEF_PROFESOR</span>: 
<input class='col-4em' type='text' name='notaprofesor' size='5' maxlength='5' value="<?php echo $fila['notaprofesor']?>">

<p></p>
<br><span class='rojo b'><?php echo i("notamin",$ilink);?></span><p></p>

<p></p><span class='b u'><?php echo i("notatest",$ilink);?></span>: 
<input class='col-1' type='text' name='mintest' size='5' maxlength='5' value="<?php echo $fila['mintest'];?>">
 &nbsp; <span class='b u'><?php echo i("notapreg",$ilink);?></span>: 
<input class='col-1' type='text' name='minpreg' size='5' maxlength='5' value="<?php echo $fila['minpreg'];?>">
 &nbsp; <span class='b u'><?php echo i("notaprac",$ilink);?></span>: 
<input class='col-1' type='text' name='minprac' size='5' maxlength='5' value="<?php echo $fila['minprac'];?>">
&nbsp; <span class='b u'><?php echo i("notaeval",$ilink);?></span>: 
<input class='col-1' type='text' name='mineval' size='5' maxlength='5' value="<?php echo $fila['mineval'];?>">


<p></p>

<p></p>

<input class='col-2' type='submit' name='coef' value=" >> <?php echo i("agvalid",$ilink);?> >> "></div>
