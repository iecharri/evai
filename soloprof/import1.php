<?php

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

//Procedimiento aut&oacute;nomo que puedo insertar en varias ventanas, ventana que se abre 
//(en notas, administraci&oacute;n de la asignatura, cuestionarios)
$asigna = $_SESSION['asigna'];
$curso = $_SESSION['curso'];
$grupo = $_SESSION['grupo'];

//Ver si la asigna-curso-grupo usa coeficiente de notas
$usacoef = usacoef($asigna,$curso,$grupo,$ilink);
$class="verdecalific"; $usacoef1 = "S&Iacute;";
if (!$usacoef) {
	echo "<p></p><span class='b'>-</span> &iquest;Activado el uso de coeficientes en las notas?: <span class='b rojo'>NO</span>";
	echo "<p></p> &nbsp; &nbsp; &nbsp;Activar en <a class='btn' href='soloprof/admin.php?op=1&pest=5' target='_blank'>Link</a> y volver";
	echo "<p></p>";
	return;
}

//Ver si hay cuestionarios en asigna-curso-grupo

$haycuest = cuestionarios($asigna,$curso,$grupo,$ilink);
$class="verdecalific"; $haycuest1 = "S&Iacute;";
if (!$haycuest) {$class = "rojo"; $haycuest1 = "NO";}
if (!$haycuest) {
	echo "<p></p><span class='b'>-</span> &iquest;Hay cuestionarios en $asigna para poder importar notas?: <span class='b rojo'>NO</span>";
	echo "<br> &nbsp; &nbsp; &nbsp;Crearlos en <a href='cuest/cueval.php?op=1' target='_blank'>[Link]</a> y volver";
	echo "<p></p>";
	return;
}

//Pedir la convocatoria
$iresult = $ilink->query("SELECT tipasig FROM podcursoasigna WHERE asigna = '$asigna' AND curso='$curso'");
$tipo = $iresult->fetch_array(MYSQLI_BOTH);
$tipo = $tipo[0];
	
if (!$tipo) {
	$_GET['conv'] = "*";
}
if (!$_GET['conv']) {
	echo "Elige una convocatoria: ";
	convocatorias($tipo);	
	echo "<p></p>";
	return;
}

$conv1 = $_GET['conv'];
if ($conv1 == "*") {$conv1 = "&uacute;nica";}

echo "<span class='mediana'>Convocatoria: </span><span class='txth b'>$conv1</span>";

//Mostrar persiana con los cuestionarios para elegir de cual transferir las notas
$mens = "<p></p><span class='mediana'>Cuestionario: </span>";
echo $mens;
if (!$_GET['table']) {
	elegircuest($asigna,$curso,$grupo,$_GET['conv'],$ilink);
	echo "<p></p>";
	return;
}
echo "<span class='txth b'>".$_GET['table']."</span>";
echo "<p></p>";

//Importar
echo "<div id='importando' style='display:none'>Importando...</div>";
if ($_GET['imp']) {
	importar($_GET['conv'],$_GET['table'],$link,$asigna,$curso,$grupo,$ilink);
	echo "<p></p>Terminado.";
	return;	
}

//Una vez seleccionado uno advertir que se sutituir&aacute;n las notas test sin posibilidad de restaurar
$textos = "SELECT textos FROM cursasigru WHERE asigna = '$asigna' AND curso = '$curso' AND grupo = '$grupo'";
$iresult = $ilink->query($textos);
$textos = $iresult->fetch_array(MYSQLI_BOTH);
$textos = $textos[0];
$textos = explode("*",$textos);
$ttest = $textos[0];
$mens = "<p></p><span class='rojo b'>&iexcl;ATENCI&Oacute;N!</span> Al pulsar en 
<a href='?conv=".$_GET['conv']."&table=".$_GET['table']."&imp=1' onclick=\"javascript:hide('mensfinal');javascript:show('importando')\" class='btn'>IMPORTAR</a> se realizar&aacute;
 la importaci&oacute;n<br>de la nota del cuestionario <span class='txth b'>".$_GET['table']."</span>
 en la nota <span class='txth b'>$ttest</span>
  de la convocatoria <span class='txth b'>$conv1</span><br><span class='rojo'>sin posibilidad de retornar al estado anterior</span>.";
echo "<div id='mensfinal'>".$mens."</div>";
echo "<p></p>";

// --------------------------------------------------

function usacoef($asigna,$curso,$grupo,$ilink) {
	$iresult = $ilink->query("SELECT coefi FROM cursasigru 
	WHERE asigna = '$asigna' AND curso = '$curso' AND grupo = '$grupo'");
	$usacoef = $iresult->fetch_array(MYSQLI_BOTH);	
	return $usacoef[0];
}

// --------------------------------------------------

function cuestionarios($asigna,$curso,$grupo,$ilink) {
	$sql = "SHOW TABLES FROM ".DB2." LIKE '".strtolower($asigna)."_%'";
	$result = $ilink->query($sql);
	if ($result->num_rows > 0) {return 1;}
}

// --------------------------------------------------

function elegircuest($asigna,$curso,$grupo,$conv,$ilink) {
	$sql = "SHOW TABLES FROM ".DB2." LIKE '".strtolower($asigna)."_%'";
	$result = $ilink->query($sql);
	echo "<div class='colu contiene' style='overflow:auto;height:20em;width:80%;'>\n";
	$i = 0;
	while ($fila = $result->fetch_array(MYSQLI_BOTH)) {
		$tb_names[$i] = $fila[0];
		if (substr($tb_names[$i],strlen($tb_names[$i])-1,1) == '2') 	{
			$tabla = substr($tb_names[$i],0,strlen($tb_names[$i])-1);
			echo "<a href='?conv=$conv&table=$tabla'>".$tabla."</a><br>";
		}
		$i++;
	}
	echo "</div>\n";
}

// --------------------------------------------------

function convocatorias($tipo) {
	if (!$tipo) {return;}
	echo "<p></p>";
	if ($tipo == 1) {
		echo "<a class='btn' href='?conv=OF'>OF</a> &nbsp; ";
		echo "<a class='btn' href='?conv=EJ'>EJ</a> &nbsp; ";
		echo "<a class='btn' href='?conv=ES'>ES</a>";
	} elseif ($tipo == 2) {
		echo "<a class='btn' href='?conv=OF'>OF</a> &nbsp; ";
		echo "<a class='btn' href='?conv=ES'>ES</a>";
	} elseif ($tipo == 3) {
		echo "<a class='btn' href='?conv=OJ'>OJ</a> &nbsp; ";
		echo "<a class='btn' href='?conv=ES'>ES</a>";
	}
}

// --------------------------------------------------

function importar($conv,$table,$link,$asigna,$curso,$grupo,$ilink) {
	//obtener una tabla usuid-nota desde el cuestionario
	
	iconex(DB2,$ilink);
	
	$sql = "SELECT DISTINCT usuid, nota FROM ".$table."2";
	$result = $ilink->query($sql);
	if ($result->num_rows > 0) {
		while ($fila = $result->fetch_array(MYSQLI_BOTH)) {
			$notas[$fila[0]] = $fila[1];
		}
	}

	iconex(DB1,$ilink);

	if (empty($notas)) {echo " No hay notas que importar."; return;}
	if ($conv == "*") {$conv = "";}
	if ($conv) {$conv = $conv."_";}
	$formula = formula($asigna,$curso,$grupo,$ilink);
	foreach ($notas as $usuid => $nota) {
		$sql = "UPDATE alumasiano SET ".$conv."test = '$nota' WHERE asigna = '$asigna' AND curso = '$curso' 
		AND grupo = '$grupo' AND id = '$usuid'";
		$ilink->query($sql);
		//Recalcular la nota total
		recalcu($asigna,$curso,$grupo,$usuid,$conv,$formula,$ilink);
	}
}

// --------------------------------------------------

function recalcu($asigna,$curso,$grupo,$usuid,$conv,$formula,$ilink) {
	$result = $ilink->query("SELECT * FROM alumasiano WHERE id = $usuid AND asigna = '$asigna' AND curso = '$curso' AND grupo = '$grupo'");
	$fila = $result->fetch_array(MYSQLI_BOTH);
	$test1 = $formula[0];
	$preg1 = $formula[1];
	$prac1 = $formula[2];
	$eval1 = $formula[3];
	$alu1 = $formula[4];
	$pro1 = $formula[5];
	$mintest1 = $formula[6];
	$minpreg1 = $formula[7];
	$minprac1 = $formula[8];
	$prac = ($alu1*$fila[$conv.'nota1']+($fila[$conv.'notprofp']*$pro1))/2;
	$tottest = $test1 * $fila[$conv.'test'];
	$totpreg = $preg1 * $fila[$conv.'preg'];
	$totprac = $prac1 * $prac;
	$toteval = $eval1 * $fila[$conv.'eval'];
	$tot = $tottest + $totpreg + $totprac + $toteval;
	$sql = "UPDATE alumasiano SET ".$conv."total = '$tot' WHERE id = '$usuid' AND asigna = '$asigna' AND curso = '$curso' AND grupo = '$grupo'";
	$ilink->query($sql);
}

?>