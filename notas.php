<?php

require_once __DIR__ . '/siempre.php';

if (!$asigna) {return;}
	
$esprofesor = esprofesor($asigna,$curso,$grupo,$ilink);
if (!$esprofesor) {$esprofesor = soyadmiano($asigna,$curso,$ilink);} 
$esadmidetit = esadmidetit($tit,$curso,$ilink);

// --------------------------------------------------

$titpag = "<span class='icon-dice'></span> ".i("notas",$ilink);
$a_notas = " class = 'active'";
require_once APP_DIR . "/molde_top.php";

unset($array);
$array[0] = "<a href='#'>$titpag <span class='icon-arrow-right'></span></a>";
$array[1] = "<a href='?op=1$param'>".i("notas",$ilink)." $asigna $curso $grupo</a>";
if ($esadmidetit) {
	$array[2] = "<a href='?op=2'>".i("modulos",$ilink)."</a>";
	
}

$pest = 1;
if ($op == 1) {$pest = 1;}
if ($op == 2) {$pest = 2;}

solapah($array,$pest+1,"navhsimple");

// --------------------------------------------------

if($op == 2) {
	
	require_once APP_DIR . "/modulos.php";
	require_once APP_DIR . "/molde_bott.php";

	exit;

}

// --------------------------------------------------


$sql1 = " WHERE alumasiano.asigna = '$asigna' AND auto > 1 AND autorizado > 1";
$sql1 .= " AND fechabaja = '0000-00-00 00:00:00'";
if ($curso) {$sql1 .= " AND alumasiano.curso = '".$curso."'";} else {$sql1 .= " AND alumasiano.curso = ''";}
if ($grupo) {$sql1 .= " AND alumasiano.grupo = '".$grupo."'";} else {$sql1 .= " AND alumasiano.grupo = ''";}

if (!$esprofesor) {
	$sql1 .= " AND (alumasiano.total != 0 OR alumasiano.OF_total != 0 OR alumasiano.EJ_total != 0 OR alumasiano.ES_total != 0 OR alumasiano.OJ_total != 0) ";
}

$sqlhay = "SELECT *, usuarios.id FROM alumasiano LEFT JOIN usuarios ON usuarios.id = alumasiano.id".$sql1." ORDER BY alumnoa, alumnon";

// --------------------------------------------------
require_once APP_DIR . "/vernotas.php";
$ver = vernota($asigna,$curso,$grupo,$ilink);

$iresult = $ilink->query("SELECT verlistanota FROM cursasigru WHERE asigna = '$asigna' AND curso = '$curso' AND grupo = '$grupo'");
$vernota = $iresult->fetch_array(MYSQLI_BOTH);

if (!$vernota[0] AND $_SESSION['auto'] < 5) {$ver = "";}

if (!$ver) {
	echo "<span class='rojo'>Opci&oacute;n no disponible en estos momentos para Alumnos.</span>";
	require_once APP_DIR . "/molde_bott.php";
	exit;
}

// por si acaso
if($_SESSION['auto'] > 4) {
	
	if ($ver == 1) {$mensaje = "[ El Administrador ha cancelado la vista de notas por parte de los Alumnos. ]<br>";}
	if ($curso AND $grupo) {
		if ($ver == 2) {$mensaje .= "[ El Profesor ha cancelado la vista de notas por parte de los Alumnos. ]<br>";}
		if ($ver == 3) {
			$mensaje .= "[ Los alumnos tienen acceso a sus notas en su ficha personal. ";
			if($vernota[0]) {$mensaje .= "También ven este listado.";} else {$mensaje .= "No ven este listado de notas.";}
			$mensaje .= " ] Cambiar la visibilidad en: <a href='soloprof/admin.php?pest=5&op=1' target='_blank'> Admin / Asignatura / Notas</a>";
			$mensaje .= "<br><br>";
		}
	}
	
}

// --------------------------------------------------

if ($esprofesor) {
	echo "<div class='colu'><span class='b'>S&oacute;lo Profesor:</span>";
	echo "<span class='fr icon-printer grande' onclick=\"window.open('notas_impr.php')\"></span>";
	//echo "<span class='b'>Profesor:</span> &raquo; : env&iacute;o de la nota al alumno v&iacute;a SMS, email o HSM<br>";
	require_once APP_DIR . "/soloprof/importtestcuest.php";
	echo "</div>";
}

// --------------------------------------------------

echo "<span class='rojo'><br>$mensaje</span>";

$iresult = $ilink->query($sqlhay);
if ($iresult->num_rows == 0 OR !existe($asigna,$curso,$grupo,$ilink)) {
	$nohaydatos = 1;
	echo "<center><p></p><span class='rojo b'>No se encontraron datos</span></center>";
	require_once APP_DIR . "/molde_bott.php";
	exit;
}

if ($_SESSION['auto'] < 11) {
	$result = $ilink->query("SELECT cuestionario FROM atencion");
	$cuestppal = $result->fetch_array(MYSQLI_BOTH);
	if (!$cuestppal[0]) {
		$nohay = 1;
	} else {
		iconex(DB2,$ilink);
		$result = $ilink->query("SHOW TABLES LIKE '$cuestppal[0]"."1'") ;
		if(!$result->num_rows) {
			$nohay = 1;
		}
		iconex(DB1,$ilink);
	}	
	if(!$nohay) {
		echo "<center><a href=cuest/cuestionario.php target='cuest'>&iexcl;&iexcl;Por Favor, Contestad el Cuestionario!!</a></center>";
	}
}

$result = $ilink->query($sqlhay);

$numvinculos = $result->num_rows;

$conta = $_GET['conta'];
if (!$_GET['conta']) {$conta = 1;}

if ($_SESSION['pda']) {$numpag = 5;} else {$numpag = 50;}
pagina($numvinculos,$conta,$numpag,i("usuarios",$ilink),0,$ilink);

$result = $ilink->query($sqlhay." LIMIT ".($conta-1).", $numpag");

$iresult = $ilink->query("SELECT tipasig FROM podcursoasigna WHERE asigna = '$asigna' AND curso='$curso'");
$tipo = $iresult->fetch_array(MYSQLI_BOTH);
$iresult = $ilink->query("SELECT coefi,textos FROM cursasigru WHERE asigna = '$asigna' AND curso = '$curso' AND grupo = '$grupo'");
$concoefi = $iresult->fetch_array(MYSQLI_BOTH);
if (!$concoefi[1]) {
	$textos = "Test*Preguntas*Pr&aacute;cticas*Evaluación*Total*OJ*OF*EJ*ES";
	$ilink->query("UPDATE cursasigru SET textos = '$textos' WHERE asigna = '$asigna' AND curso = '$curso' AND grupo = '$grupo'");
	$concoefi[1] = $textos;
}

if ($tipo['tipasig'] == 1) {$OF_color=" class=1";$EJ_color=" class=1";$ES_color=" class=1";}
if ($tipo['tipasig'] == 2) {$OF_color=" class=1";$ES_color=" class=1";}
if ($tipo['tipasig'] == 3) {$OJ_color=" class=1";$ES_color=" class=1";}

echo "<br><table class='conhover'>";

?>
<colgroup>
<col span="1" class='colusu' style='background:#E3DCD9'>
<col span="6" style='background:#F1EDEC'>
<col span="6" style='background:#FAF9F9'>
<col span="6" style='background:#F1EDEC'>
<col span="6" style='background:#FAF9F9'>
<col span="6" style='background:#F1EDEC'>
</colgroup>
<?php

$textos = explode("*",$concoefi[1]);

//tit0(1, $textos[5], $textos[6], $textos[7], $textos[8], " ");

echo "<tr>";

echo "<th></th>";

if ($OJ_color) {echo "<th colspan='6'>$textos[5]</th>";}
if ($OF_color) {echo "<th colspan='6'>$textos[6]</th>";}
if ($EJ_color) {echo "<th colspan='6'>$textos[7]</th>";}
if ($ES_color) {echo "<th colspan='6'>$textos[8]</th>";}
if (!$tipo['tipasig']) {echo "<th colspan='6'></th>";}

echo "</tr>";
		
echo "<tr><th>".i("nombre",$ilink)."</th>";

if ($OJ_color) {echo tit(1,"OJ_", $esprofesor, $concoefi[0], $textos);} //else {tit(1,"","","", $textos);}
if ($OF_color) {echo tit(1,"OF_", $esprofesor, $concoefi[0], $textos);} //else {tit(1,"","","", $textos);}
if ($EJ_color) {echo tit(1,"EJ_", $esprofesor, $concoefi[0], $textos);} //else {tit(1,"","","", $textos);}
if ($ES_color) {echo tit(1,"ES_", $esprofesor, $concoefi[0], $textos);} //else {tit(1,"","","", $textos);}
if (!$tipo['tipasig']) {echo tit(1,"", $esprofesor, $concoefi[0], $textos);} //else {tit(1,"","","", $textos);}

echo "</tr>";

$formula = formula($asigna,$curso,$grupo,$ilink);
$test1 = $formula[0]; $preg1 = $formula[1]; $prac1 = $formula[2];$eval1= $formula[3];

while ($fila = $result->fetch_array(MYSQLI_BOTH)) {

	echo "<tr>";
	if ($n == 0) {$n = 1;}else {$n = 0;}

	echo "<td>";

	if($_SESSION['auto'] > 4 OR $fila['id'] == $_SESSION['usuid']) {
		$usu = ponerusu($fila['id'],1,$ilink);	
		echo $usu[0].$usu[1];
	} else {
		echo $fila['dni'];
	}
	
	echo "</td>";

// --------------------------------------------------

	if ($OJ_color) {echo notas('OJ_',$fila,$formula,$esprofesor,"_new",$concoefi[0],$ilink);} //else {notas("","","","","","","");}
	if ($OF_color) {echo notas('OF_',$fila,$formula,$esprofesor,"_new",$concoefi[0],$ilink);} //else {notas("","","","","","","");}
	if ($EJ_color) {echo notas('EJ_',$fila,$formula,$esprofesor,"_new",$concoefi[0],$ilink);} //else {notas("","","","","","","");}
	if ($ES_color) {echo notas('ES_',$fila,$formula,$esprofesor,"_new",$concoefi[0],$ilink);} //else {notas("","","","","","","");}
	if (!$tipo['tipasig']) {echo notas('*',$fila,$formula,$esprofesor,"_new",$concoefi[0],$ilink);} //else {notas("","","","","","","");}

// --------------------------------------------------

	echo "</tr>\n";

}

$sql = "SELECT AVG(alumasiano.test)*$test1 AS test, STDDEV(alumasiano.test)*$test1 AS test_dt, 
									AVG(alumasiano.preg)*$preg1 AS preg, STDDEV(alumasiano.preg)*$preg1 AS preg_dt, 
									AVG(alumasiano.prac)*$prac1 AS prac, STDDEV(alumasiano.prac)*$prac1 AS prac_dt, 
									AVG(alumasiano.eval)*$eval1 AS eval, STDDEV(alumasiano.eval)*$eval1 AS eval_dt, 
									AVG(alumasiano.total) AS total, STDDEV(alumasiano.total) AS total_dt ";

if ($OJ_color) {

	$sql .= ", AVG(alumasiano.OJ_test)*$test1 AS OJ_test, STDDEV(alumasiano.OJ_test)*$test1 AS OJ_test_dt, 
						AVG(alumasiano.OJ_preg)*$preg1 AS OJ_preg, STDDEV(alumasiano.OJ_preg)*$preg1 AS OJ_preg_dt, 
						AVG(alumasiano.OJ_prac)*$prac1 AS OJ_prac, STDDEV(alumasiano.OJ_prac)*$prac1 AS OJ_prac_dt, 
						AVG(alumasiano.OJ_eval)*$eval1 AS OJ_eval, STDDEV(alumasiano.OJ_eval)*$eval1 AS OJ_eval_dt, 
						AVG(alumasiano.OJ_total) AS OJ_total, STDDEV(alumasiano.OJ_total) AS OJ_total_dt";

}

if ($OF_color) {

	$sql .= ", AVG(alumasiano.OF_test)*$test1 AS OF_test, STDDEV(alumasiano.OF_test)*$test1 AS OF_test_dt, 
						AVG(alumasiano.OF_preg)*$preg1 AS OF_preg, STDDEV(alumasiano.OF_preg)*$preg1 AS OF_preg_dt, 
						AVG(alumasiano.OF_prac)*$prac1 AS OF_prac, STDDEV(alumasiano.OF_prac)*$prac1 AS OF_prac_dt, 
						AVG(alumasiano.OF_eval)*$eval1 AS OF_eval, STDDEV(alumasiano.OF_eval)*$eval1 AS OF_eval_dt, 
						AVG(alumasiano.OF_total) AS OF_total, STDDEV(alumasiano.OF_total) AS OF_total_dt";

}

if ($EJ_color) {

	$sql .= ", AVG(alumasiano.EJ_test)*$test1 AS EJ_test, STDDEV(alumasiano.EJ_test)*$test1 AS EJ_test_dt, 
						AVG(alumasiano.EJ_preg)*$preg1 AS EJ_preg, STDDEV(alumasiano.EJ_preg)*$preg1 AS EJ_preg_dt, 
						AVG(alumasiano.EJ_prac)*$prac1 AS EJ_prac, STDDEV(alumasiano.EJ_prac)*$prac1 AS EJ_prac_dt, 
						AVG(alumasiano.EJ_eval)*$eval1 AS EJ_eval, STDDEV(alumasiano.EJ_eval)*$eval1 AS EJ_eval_dt, 
						AVG(alumasiano.EJ_total) AS EJ_total, STDDEV(alumasiano.EJ_total) AS EJ_total_dt";

}

if ($ES_color) {

	$sql .= ", AVG(alumasiano.ES_test)*$test1 AS ES_test, STDDEV(alumasiano.ES_test)*$test1 AS ES_test_dt, 
						AVG(alumasiano.ES_preg)*$preg1 AS ES_preg, STDDEV(alumasiano.ES_preg)*$preg1 AS ES_preg_dt, 
						AVG(alumasiano.ES_prac)*$prac1 AS ES_prac, STDDEV(alumasiano.ES_prac)*$prac1 AS ES_prac_dt, 
						AVG(alumasiano.ES_eval)*$eval1 AS ES_eval, STDDEV(alumasiano.ES_eval)*$eval1 AS ES_eval_dt, 
						AVG(alumasiano.ES_total) AS ES_total, STDDEV(alumasiano.ES_total) AS ES_total_dt";

}

$sql = $sql." FROM alumasiano LEFT JOIN usuarios ON alumasiano.id = usuarios.id ".$sql1;
$result = $ilink->query($sql);
$fila1 = $result->fetch_array(MYSQLI_BOTH);

echo "<tr><td colspan='31' class='colu1'></td></tr>";

echo "<tr>";
echo "<td class='b' align='right'>MEDIA </td>";

if ($OJ_color) {media('OJ_', $fila1, $esprofesor, $concoefi[0]);} //else {media("","","","");}
if ($OF_color) {media('OF_', $fila1, $esprofesor, $concoefi[0]);} //else {media("","","","");}
if ($EJ_color) {media('EJ_', $fila1, $esprofesor, $concoefi[0]);} //else {media("","","","");}
if ($ES_color) {media('ES_', $fila1, $esprofesor, $concoefi[0]);} //else {media("","","","");}
if (!$tipo['tipasig']) {media('*', $fila1, $esprofesor, $concoefi[0]);} //else {media("","","","");}

echo "</tr>\n";
echo "<tr>";
echo "<td class='b' align='right'>DESVIACI&Oacute;N T&Iacute;PICA </td>";

if ($OJ_color) {dtip('OJ_', $fila1, $esprofesor, $concoefi[0]);} //else {dtip("","","","");}
if ($OF_color) {dtip('OF_', $fila1, $esprofesor, $concoefi[0]);} //else {dtip("","","","");}
if ($EJ_color) {dtip('EJ_', $fila1, $esprofesor, $concoefi[0]);} //else {dtip("","","","");}
if ($ES_color) {dtip('ES_', $fila1, $esprofesor, $concoefi[0]);} //else {dtip("","","","");}
if (!$tipo['tipasig']) {dtip('*', $fila1, $esprofesor, $concoefi[0]);} //else {dtip("","","","");}

echo "</tr></table><br>\n";

pagina($numvinculos,$conta,$numpag,i("usuarios",$ilink),0,$ilink);

require_once APP_DIR . "/molde_bott.php";

;?>
