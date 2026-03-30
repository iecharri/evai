<?php

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

if ($_SESSION['auto'] < 5) {exit;}

require_once APP_DIR . "/ponerobject.php";

extract($_GET);
extract($_SERVER);
extract($_POST);

$asigna = $_SESSION['asigna'];
if ($_GET['asigna']) {$asigna = $_GET['asigna'];}
if ($_POST['asigna']) {$asigna = $_POST['asigna'];}
$curso = $_SESSION['curso'];
if ($_GET['curso']) {$curso = $_GET['curso'];}
if ($_POST['curso']) {$curso = $_POST['curso'];}
$grupo = $_SESSION['grupo'];
if ($_GET['grupo']) {$grupo = $_GET['grupo'];}
if ($_POST['grupo']) {$grupo = $_POST['grupo'];}
if ($conv == "*") {$conv = "";}

// --------------------------------------------------

if (!esprofesor($asigna,$curso,$grupo,$ilink) AND !soyadmiano($asigna,$curso,$ilink)) {
	exit;
}

$formula = formula($asigna,$curso,$grupo,$ilink);
$test1 = $formula[0];
$preg1 = $formula[1];
$prac1 = $formula[2];
$eval1 = $formula[3];
$alu1 = $formula[4];
$pro1 = $formula[5];
$mintest1 = $formula[6];
$minpreg1 = $formula[7];
$minprac1 = $formula[8];
$mineval1 = $formula[9];
$divisor1 = $formula[10];

$iresult = $ilink->query("SELECT coefi FROM cursasigru WHERE asigna = '$asigna' AND curso = '$curso' AND grupo = '$grupo'");
$concoefi = $iresult->fetch_array(MYSQLI_BOTH);

// --------------------------------------------------

if ($_POST['sub']) {

	// Actualizar nota de pr&aacute;cticas de compa&ntilde;eros
	if ($_POST['cambiar'] AND $concoefi[0]) {
		$fecha = gmdate("Y-m-d H:i:s");
		$sql = "UPDATE alumasiano SET ".$conv."nota1 = '$nota', ".$conv."fecha_nota = '$fecha' WHERE id = '$usuid' AND asigna = '$asigna' AND curso = '$curso' AND grupo = '$grupo'";
		$ilink->query($sql);
	}

	$result = $ilink->query("SELECT * FROM alumasiano WHERE id = $usuid AND asigna = '$asigna' AND curso = '$curso' AND grupo = '$grupo'");
	$fila = $result->fetch_array(MYSQLI_BOTH);

	if ($concoefi[0]) {
		$prac = ($alu1*$fila[$conv.'nota1']+($notprofp*$pro1))/$divisor1;    //2;
		$sql = "UPDATE alumasiano SET ".$conv."nota1 = '$nota', ".$conv."test = '$test', ".$conv."preg = '$preg', ".$conv."eval = '$eval', ".$conv."notprofp = '$notprofp', ".$conv."prac = '$prac', eval = '$eval', ".$conv."total = $test1*'$test' + $preg1*'$preg' + $prac1*'$prac' + $eval1*'$eval' WHERE id = '$usuid' AND asigna = '$asigna' AND curso = '$curso' AND grupo = '$grupo'";
	} else {
		$sql = "UPDATE alumasiano SET  ".$conv."total = '$total' WHERE id = '$usuid' AND asigna = '$asigna' AND curso = '$curso' AND grupo = '$grupo'";
	}
	$ilink->query($sql);

	$result = $ilink->query("SELECT * FROM alumasiano WHERE id = $usuid AND asigna = '$asigna' AND curso = '$curso' AND grupo = '$grupo'");
	$fila = $result->fetch_array(MYSQLI_BOTH);

	if ($concoefi[0]) {
		
		$tot_test = $fila[$conv.'test'] * $test1;		
		$tot_preg = $fila[$conv.'preg'] * $preg1;				
		$tot_prac = ($alu1*$fila[$conv.'nota1']+($notprofp*$pro1))/$divisor1;    //2;
		$tot_prac = $tot_prac * $prac1;
		$tot_eval = $fila[$conv.'eval'] * $eval1;		
		
		$aprobar = 0;
		if ($_POST['aprobar']) {
			$aprobar = 1;
		} else {
			if (($tot_test < $mintest1 OR $tot_preg < $minpreg1 OR $tot_prac < $minprac1 OR $tot_eval < $mineval1) AND $fila[$conv.'total'] >= 5) {
				$aprobar = 2;
			}
		}
		$sql = "UPDATE alumasiano SET ".$conv."aprobado = '$aprobar' WHERE id = '$usuid' AND asigna = '$asigna' AND curso = '$curso' AND grupo = '$grupo'";
		$ilink->query($sql);
	}
	
}

// --------------------------------------------------

echo "".i("pertgr",$ilink).":";

$result = $ilink->query("SELECT grupo, id FROM grupos LEFT JOIN gruposusu ON gruposusu.grupo_id = grupos.id WHERE usu_id = '$usuid'");
while ($fila = $result->fetch_array(MYSQLI_BOTH)) {
	echo " <a href='grupo.php?grupoid=".$fila['id']."' target='_blank'>".$fila['grupo']."</a>";
}

echo "<p></p>";

$sql = "SELECT video, video1, iconos, alumnon, alumnoa FROM usuarios WHERE id = '$usuid' LIMIT 1";
$iresult = $ilink->query($sql);
$fila = $iresult->fetch_array(MYSQLI_BOTH);
extract($fila);

// --------------------------------------------------
	
echo "<div class='col-3 fl colu'>";
	if ($video OR $video1) {
		if ($video) {
			echo "<p></p>";
			
    		$dir64 = base64_encode("fotos");
    		$url = "ver_media.php?dir64=$dir64&f=" . urlencode($video);
    		$videoa = ponerVideoHtml5($url);

    		if ($videoa) {
        		echo "<div class='ce'>$videoa<span class='peq ce'>". ifecha31(gmdate("Y-m-d H:i:s", filemtime(DATA_DIR . "/fotos/$video")), $ilink). "</span>$mens</div>";
    		}
		}
		if ($video1) {
			$posicionbarra7 = strrpos($video1, "/");
			if ($posicionbarra7) {$video1 = substr(strrchr ( $video1 , "/" ),1);}
			echo poneryoutub($video1);
		}
	}
	$a = $asigna;
	$u = $usuid;
	if ($_SESSION['auto'] > 4){
		$actualiz = "<a href='".$_SESSION['PHP_SELF']."?
		actu=1&usuid=$u&conv=$conv&curso=$curso&asigna=$a&grupo=$grupo&pest=$pest&op=$op'>".
		i("profesor",$ilink).": ".i("actuestad",$ilink)."</a>";
	}
	require_once APP_DIR . '/estadis_alu.php';
echo "</div>";

// --------------------------------------------------

?>

<script language="Javascript">
function actu(form2) {form2.nota.value = form2.nota1.value;form2.cambiar.value = 1;}
function actu1(form2) {
	form2.test.value = 0;
	form2.preg.value = 0;
	form2.notprofp.value = 0;
	form2.nota.value = 0;
	form2.prac.value = 0;
	form2.eval.value = 0;
	form2.total.value = 0;
	form2.cambiar.value = 1;
}
</script>

<?php

$temp = $conv.'fecha_nota';
$sql = "SELECT *, usuasi.nota,$temp AS fnotax FROM alumasiano LEFT JOIN usuasi ON usuasi.id = alumasiano.id WHERE alumasiano.id = '$usuid' AND alumasiano.asigna = '$asigna' AND usuasi.asigna = '$asigna' AND curso = '$curso' AND grupo = '$grupo'";
$result = $ilink->query($sql);
$fila = $result->fetch_array(MYSQLI_BOTH);

echo "<div class='col-4 fl colu'>

	<span class='grande b'>".i("nota",$ilink)." $asigna $curso $grupo ".substr($conv,0,strlen($conv)-1)."</span><p></p>
	<form name='form2' action='?asigna=$asigna&curso=$curso&grupo=$grupo&conv=$conv&pest=$pest&op=$op' method='post'>
	<input type='hidden' name='usuid' value=' $usuid'>
	<input type='hidden' name='temp' value='1'>
	<input type='hidden' name='nota1' value='".$fila['nota']."'>
	<input type='hidden' name='conv' value='$conv'>
	<input type='hidden' name='asigna' value='$asigna'>
	<input type='hidden' name='curso' value='$curso'>

	";

	if ($concoefi[0]) {
		echo "
		<span class='rojo'>Pr&aacute;cticas - Votos alumnos al ".utcausu1(gmdate('Y:m:d H:i:s')).": <span class='b'>".$fila['nota']."</span></span> 
		<input type='button' class='col-4' value='Actualizar nota' onclick=\"actu(form2)\"><br>
		<input class='col-1' type='text' name='test' size='5' maxlength='5' value='".$fila[$conv.'test']."'> Test -- Nota m&iacute;nima: $mintest1<br>
		<input class='col-1' type='text' name='preg' size='5' maxlength='5' value='".$fila[$conv.'preg']."'> Preguntas -- Nota m&iacute;nima: $minpreg1<br>
		<input class='col-1' type='text' name='nota' size='5' maxlength='5' value='";
		if ($fila[$conv.'nota1'] != 0) {
		echo $fila[$conv.'nota1'];
		} elseif ($fila['nota'] != 0) {
			echo $fila['nota'];
			$atenc = 1;
		}
		echo "' readonly='readonly' onfocus='document.form2.notprofp.select()'> Pr&aacute;cticas - Votos alumnos el <span class='rojo'>".utcausu1($fila['fnotax'])."</span>";
		if ($atenc) {
			echo ": ";
			echo "<input class='col-1' type='button' onclick=\"document.form2.nota.value='0.00'\" value='0.00'>";
			echo "<br>(<span class='rojo b'>Validar para aceptar la nueva nota";
			echo " <input class='col-2' type='button' onclick=\"actu(form2)\" value='".$fila['nota']."'>";
			echo "</span>)";
		}
		echo "<input type='hidden' name='cambiar' value='";
		if ($atenc) {echo '1';}
		echo "'>";
		echo "<br>
		<input class='col-1' type='text' name='notprofp' size='5' maxlength='5' value='".$fila[$conv.'notprofp']."'> Pr&aacute;cticas - Nota profesor<br>
		<input class='col-1' type='text' name='prac' size='5' maxlength='5' value='".$fila[$conv.'prac']."' readonly onfocus='document.form2.sub.focus()'> Pr&aacute;cticas - Media -- Nota m&iacute;nima: $minprac1<br>
		";
		
		echo "<input class='col-1' type='text' name='eval' size='5' maxlength='5' value='".$fila[$conv.'eval']."'> Evaluación -- Nota m&iacute;nima: $mineval1<br>";
	
	}

	$clase = "class = 'b'";
	if (($fila[$conv.'total'] < 5 OR $fila[$conv.'aprobado'] > 0) AND $concoefi[0]) {
		$clase = "class='rojo b'";
		$nollega = 1;
	}

	echo "<input class='col-1' type='text' name='total' size='5' maxlength='5' value='".$fila[$conv.'total']."'";
	if ($concoefi[0]) {echo " readonly = 'readonly' ";}
	echo " $clase> Total";

	if ($nollega) {
		echo " - Aprobar <input type='checkbox' name='aprobar' ";
		if ($fila[$conv.'aprobado'] == 1) {echo "checked='checked'";}
		echo "><input type='hidden' name='check' value='1'>";
	}
	?>

	<p></p><input class='col-2' type='submit' value="<?php echo i("agvalid",$ilink);?>" name='sub'>

	<?php

	if ($concoefi[0]) {
	echo " <input class='col-2' type='button' name='Button1' value='Cerrar' onclick='window.close()'>";
  	echo " <input class='col-2' type='button' value='Vaciar' onclick=actu1(form2)>";
}

	echo " <a href='?usuid=$usuid&conv=$conv&curso=$curso&grupo=$grupo&asigna=$asigna&pest=3&op=$op'>Enviar mensaje</a>";

	if ($concoefi[0]) {

		echo "<p><br></p>total = ($test1 x test) + ($preg1 x preg) + ($prac1 x prac) + ($eval1 x eval)";
		echo "<br>prac = (($alu1 x votosalumnos) + ($pro1 x notaprofesor))";   //2";
		if ($divisor1) {echo " / $divisor1";}	
	
	}

	?>

	</form>

</div>

<!-- --------------------------------------- -->

<div class='col-2 fl colu'>

	<?php

	$iresult = $ilink->query("SELECT textos FROM cursasigru WHERE asigna = '$asigna' AND curso = '$curso' AND grupo = '$grupo'");
	$textos = $iresult->fetch_array(MYSQLI_BOTH);
	$textos = explode("*",$textos[0]);

	?>
	<span class='b'><span class="icon-pushpin rojo fr grande"></span> A recordar</span> que en los listados, las palabras: 
	<span class='b'>Test</span>
	, <span class='b'>Preguntas</span>
	, <span class='b'>Pr&aacute;cticas</span>
	, <span class='b'>Evaluaci&oacute;n</span>
	 y <span class='b'>Total</span><br>ser&aacute;n sustitu&iacute;das por: 

	<?php
	echo "$textos[0], $textos[1], $textos[2], $textos[3] y $textos[4].";
	?>

	<br>Y las abreviaturas relativas a las convocatorias: <span class='b'>OJ</span>, <span class='b'>OF</span>, <span class='b'>EJ</span>, <span class='b'>ES</span><br>
	ser&aacute;n sustitu&iacute;das por: 
	<?php
	echo "$textos[5], $textos[6], $textos[7] y $textos[8]";

echo "</div>";

// --------------------------------------------------

?>
