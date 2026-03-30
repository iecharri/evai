<?php

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

$caso = 3; require_once APP_DIR . "/pod/podformfiltro.php";

?>

<script language="javascript">
function prueba(formana) {
	if (document.formana.edborrar.checked) {return confirm("<?php echo i("confirmborr",$ilink);?>");}
}

function funcanaed(form1)
{
	pos = form1.edcodigo1.value.split('*');
	form1.edct.value = pos[0];
	form1.edcp.value = pos[1];
	form1.edtipasig.value = pos[2];
	form1.edcodigo.value = pos[3];
	//form1.edcodigo1.disabled = true
}
</script>

<?php

if ($botfiltro) {$accion="";}

// -------------------------------------------------- A S I G N A C I O N E S // --------------------------------------------------

$soyadmitit = soyadmitit("","",$ilink);

if ($accion) {
	require_once APP_DIR . "/pod/podtablasmodif.php";
	require_once APP_DIR . "/pod/podanaeditasignacion.php";
}

// -------------------------------------------------- A S I G N A C I O N E S // --------------------------------------------------

$ord = $_GET['ord'];
if (!$ord) {$ord = "usuarios.alumnoa,usuarios.alumnon,curso,cod,grupo";}

$sql = "SELECT asignatprof.id, asignatprof.asigna, podasignaturas.asignatura";
$sql .= ", asignatprof.curso, asignatprof.grupo, podcursoasigna.tipasig AS semestre";
$sql .= ", asignatprof.ct, asignatprof.cp, asignatprof.cte, asignatprof.cpr";
$sql .= ", asignatprof.cl, asignatprof.cs, asignatprof.ctu, asignatprof.ce";
$sql .= ", usuarios.id AS codprofe FROM asignatprof";
$sql .= " LEFT JOIN podcursoasigna ON asignatprof.curso = podcursoasigna.curso AND asignatprof.asigna = podcursoasigna.asigna";
$sql .= " LEFT JOIN podasignaturas ON podasignaturas.cod = asignatprof.asigna";
$sql .= " LEFT JOIN profcurareafigura ON profcurareafigura.profeid = asignatprof.usuid AND profcurareafigura.curso = asignatprof.curso";
$sql .= " LEFT JOIN usuarios ON asignatprof.usuid = usuarios.id";

if ($filtrocurso) {
	$filtro1 .= " AND asignatprof.curso = '".trim($filtrocurso)."'";
} else {
	$filtro1 .= " AND (asignatprof.curso > $min OR !tipasig)";
}
if ($filtroprof) {
	$filtro1 .= " AND asignatprof.usuid = '$filtroprof'";
}
if ($filtroarea) {
	$filtro1 .= " AND profcurareafigura.area = '$filtroarea'";
}

$sql .= " WHERE 1=1 $filtro1 ORDER BY $ord";
$result = $ilink->query($sql);

echo $mensaje;
if (!$filtrocurso AND $soyadmitit AND !$mensaje) {
	if ($mensaje) {echo "<br>";}
	echo "<span class='rojo b'>&iexcl;Atenci&oacute;n Administradores! Para m&aacute;s opciones selecionar un &Aacute;REA y un CURSO.</span>";
}
echo "<table class='tancha'>";

cabtabla($soyadmitit,$filtro,$ord,$ilink);

$tot[1] = array(0,0,0,0,0,0,0,0);
$tot[2] = array(0,0,0,0,0,0,0,0);
$tot[3] = array(0,0,0,0,0,0,0,0);

$profant='*';
$cursant='*';

while ($fila = $result->fetch_array(MYSQLI_BOTH)) {

	if ($ord == "usuarios.alumnoa,usuarios.alumnon,curso,cod,grupo"  AND ($profant != $fila['codprofe'] OR $cursant != $fila['curso'])) {
		$raya = 1;
		if ($profant != "*" OR $cursant != "*") {
			filaverde($totp, $soyadmitit);
			$tot = filaazul($tot,$totp,$profant,$cursant,$soyadmitit,$ilink);
			$totp[1] = array(0,0,0,0,0,0,0,0);
			$totp[2] = array(0,0,0,0,0,0,0,0);
			$totp[3] = array(0,0,0,0,0,0,0,0);
			filablanca($soyadmitit);
		}
		$profant = $fila['codprofe'];
		$cursant = $fila['curso'];
	}

	echo "<tr>";
	if ($soyadmitit) {
		echo "<td>";
		if (soyadmiasgn($fila['id'],$ilink)) {
			echo "<a href='?accion=edasgn&edid=".$fila['id']."&$filtro&ord=$ord'";
			echo ">".i("editar1",$ilink)."</a>";
		}
		echo "</td>";
	}

	echo "<td>";
	if ($_SESSION['auto'] == 10) {
		echo "<a href='pod.php?accion=editar&edcod=".$fila['asigna']."&edcurso=".$fila['curso']."'>".$fila['asigna']."</a>";
	} else {
		echo $fila['asigna'];
	}
	echo " - ";
	echo "<a href='?idasigna=".$fila['asigna']."&idcurso=".$fila['curso']."&pest=7&pest1=3'>".$fila['asignatura']."</a></td>";
	echo "<td>".$fila['curso']."</td><td>".$fila['grupo']."</td>";

	//	
	casilla($fila, 1, 'ct', '');casilla($fila, 1, 'cp', '');
	casilla($fila, 1, 'cte', '');casilla($fila, 1, 'cpr', '');	casilla($fila, 1, 'cl', '');
	casilla($fila, 1, 'cs', '');casilla($fila, 1, 'ctu', '');casilla($fila, 1, 'ce', '');
	//	
	casilla($fila, 2, 'ct', 1);casilla($fila, 2, 'cp', 1);
	casilla($fila, 2, 'cte', 1);casilla($fila, 2, 'cpr', 1);	casilla($fila, 2, 'cl', 1);
	casilla($fila, 2, 'cs', 1);casilla($fila, 2, 'ctu', 1);casilla($fila, 2, 'ce', 1);
	//	
	casilla($fila, 3, 'ct', '');casilla($fila, 3, 'cp', '');
	casilla($fila, 3, 'cte', '');casilla($fila, 3, 'cpr', '');casilla($fila, 3, 'cl', '');
	casilla($fila, 3, 'cs', '');casilla($fila, 3, 'ctu', '');casilla($fila, 3, 'ce', '');
	//
	echo "<td class='nowrap'>";
	$usu = ponerusu($fila['codprofe'],1,$ilink);
	if ($raya == 1) {
		echo $usu[1];
		$raya = 0;
	}
	if ($ord != "usuarios.alumnoa,usuarios.alumnon,curso,cod,grupo") {
		echo $usu[1];
	}
	echo "</td>";
	echo "</tr>";

	$totp[$fila['semestre']]['ct'] = $totp[$fila['semestre']]['ct'] + $fila['ct'];
	$totp[$fila['semestre']]['cp'] = $totp[$fila['semestre']]['cp'] + $fila['cp'];
	$totp[$fila['semestre']]['cte'] = $totp[$fila['semestre']]['cte'] + $fila['cte'];
	$totp[$fila['semestre']]['cpr'] = $totp[$fila['semestre']]['cpr'] + $fila['cpr'];
	$totp[$fila['semestre']]['cl'] = $totp[$fila['semestre']]['cl'] + $fila['cl'];
	$totp[$fila['semestre']]['cs'] = $totp[$fila['semestre']]['cs'] + $fila['cs'];
	$totp[$fila['semestre']]['ctu'] = $totp[$fila['semestre']]['ctu'] + $fila['ctu'];
	$totp[$fila['semestre']]['ce'] = $totp[$fila['semestre']]['ce'] + $fila['ce'];


	if ($ord != "usuarios.alumnoa,usuarios.alumnon,curso,cod,grupo") {
		$tot = suma($tot, $totp);
		$totp[1] = array(0,0,0,0,0,0,0,0);
		$totp[2] = array(0,0,0,0,0,0,0,0);
		$totp[3] = array(0,0,0,0,0,0,0,0);
	}

}

if ($ord == "usuarios.alumnoa,usuarios.alumnon,curso,cod,grupo"  AND ($profant != $fila['codprofe'] OR $cursant != $fila['curso'])) {
	$raya = 1;
	filaverde($totp, $soyadmitit);
	$tot = filaazul($tot,$totp,$profant,$cursant,$soyadmitit,$ilink);
	filablanca($soyadmitit);
}

echo "<tr>";
$x = 28;
if ($soyadmitit) {$x++;}
echo "<td colspan='$x'>&nbsp;</td></tr>";
echo "<tr>";
$x = 3;
if ($soyadmitit) {$x++;}
echo "<td colspan='$x'></td>";

casilla2($tot[1]['ct'],'');
casilla2($tot[1]['cp'],'');
casilla2($tot[1]['cte'],'');
casilla2($tot[1]['cpr'],'');
casilla2($tot[1]['cl'],'');
casilla2($tot[1]['cs'],'');
casilla2($tot[1]['ctu'],'');
casilla2($tot[1]['ce'],'');
//
casilla2($tot[2]['ct'],1);
casilla2($tot[2]['cp'],1);
casilla2($tot[2]['cte'],1);
casilla2($tot[2]['cpr'],1);
casilla2($tot[2]['cl'],1);
casilla2($tot[2]['cs'],1);
casilla2($tot[2]['ctu'],1);
casilla2($tot[2]['ce'],1);
//
casilla2($tot[3]['ct'],'');
casilla2($tot[3]['cp'],'');
casilla2($tot[3]['cte'],'');
casilla2($tot[3]['cpr'],'');
casilla2($tot[3]['cl'],'');
casilla2($tot[3]['cs'],'');
casilla2($tot[3]['ctu'],'');
casilla2($tot[3]['ce'],'');
//

echo "<td></td></tr>";

echo "<tr>";
$x = 28;
if ($soyadmitit) {$x++;}
echo "<td colspan='$x'>&nbsp;</td></tr>";
echo "<tr>";

$x = 3;
if ($soyadmitit) {$x++;}
echo "<td colspan='$x'></td>";

$tot11 = $tot[1]['ct']+$tot[1]['cp'];
$tot12 = $tot[1]['cte']+$tot[1]['cpr']+$tot[1]['cl']+$tot[1]['cs']+$tot[1]['ctu']+$tot[1]['ce'];
$tot21 = $tot[2]['ct']+$tot[2]['cp'];
$tot22 = $tot[2]['cte']+$tot[2]['cpr']+$tot[2]['cl']+$tot[2]['cs']+$tot[2]['ctu']+$tot[2]['ce'];
$tot31 = $tot[3]['ct']+$tot[3]['cp'];
$tot32 = $tot[3]['cte']+$tot[3]['cpr']+$tot[3]['cl']+$tot[3]['cs']+$tot[3]['ctu']+$tot[3]['ce'];
$cretot1 = $tot11 + $tot21 +$tot31;
$cretot2 = $tot12 + $tot22 +$tot32;
casilla1($tot11, 2);
casilla1($tot12, 6);
casilla1($tot21, 2);
casilla1($tot22, 6);
casilla1($tot31, 2);
casilla1($tot32, 6);

echo "<td>";
if ($cretot1) {
	$porcent1 = ($tot11 * 100) / $cretot1;
	$porcent2 = ($tot21 * 100) / $cretot1;
	$porcent3 = ($tot31 * 100) / $cretot1;
}
echo "<span style='border:1px solid red' title='Tradicional'>T</span> <span class='txth b'>Total:</span> <span class='b'>".number_format($cretot1,2,'.','')."</span><br><span class='b'>Balance de carga docente</span>:<br>";
echo "Primer semestre: ".number_format($porcent1,2,'.','')."%";
echo ". Segundo semestre: ".number_format($porcent2,2,'.','')."%";
if ($porcent0) {echo ". Sin asignar: ".number_format($porcent3,2,'.','')."%";}
if ($cretot2) {
	$porcent1 = ($tot12 * 100) / $cretot2;
	$porcent2 = ($tot22 * 100) / $cretot2;
	$porcent3 = ($tot32 * 100) / $cretot2;
}
echo "<br><span style='border:1px solid red' title='ECTS'>E</span> <span class='txth b'>Total:</span> <span class='b'>".number_format($cretot2,2,'.','')."</span><br><span class='b'>Balance de carga docente</span>:<br>";
echo "Primer semestre: ".number_format($porcent1,2,'.','')."%";
echo ". Segundo semestre: ".number_format($porcent2,2,'.','')."%";
if ($porcent3) {echo ". Sin asignar: ".number_format($porcent3,2,'.','')."%";}
echo "</td>";

echo "</tr>";

echo "</table>";

// --------------------------------------------------

function casilla($fila, $semestre, $campo, $color) {
	if ($color) {$temp = " style='background:#FAF9F9'";}
	echo "<td class='col-01 ri' $temp>";
	if ($fila['semestre'] == $semestre AND $fila[$campo] != 0) {echo $fila[$campo];}
	echo "</td>";
}

function casilla1($p, $col) {
	echo "<td colspan='$col' class='center b'>";
	if ($p) {echo number_format($p,2,',','.');}
	echo "</td>";
}

function casilla2($p,$color) {
	if ($color) {$temp = " style='background:#FAF9F9'";}
	echo "<td class='ri' $temp>";
	if ($p) {echo number_format($p,2,',','.');} else {echo "&nbsp";}
	echo "</td>";
}

// --------------------------------------------------

function cabtabla($soyadmitit,$filtro,$ord,$ilink) {

echo "<tr>";
if ($soyadmitit) {
	echo "<th rowspan='3' style='width:0'><a href='?accion=anaasgn&$filtro&ord=$ord'";
	echo ">".i("anadir1",$ilink)."</a></th>";
}
echo "<th rowspan='3'><a href='?ord=cod&$filtro'>C&oacute;digo</a> - <a href='?ord=asignatura,cod&$filtro'>Asignatura</a></th>";
echo "<th rowspan='3'><a href='?ord=curso,cod&$filtro'>Curso</a></th><th rowspan='3' title='Grupo'>G</th>";
echo "<th colspan='8' class='col-01' title='Semestre 1'>S1</th>";
echo "<th colspan='8' class='col-01' title='Semestre 2'>S2</th>";
echo "<th colspan='8' class='col-01' title='Anual'>A</th>";
echo "<th rowspan='3'><a href='?ord=usuarios.alumnoa,usuarios.alumnon,curso,cod,grupo&$filtro'>Nombre<br>Ordenar por Nombre para ver totales</a></th></tr>";
echo "</tr>";

echo "<tr>";
echo "<th colspan='2' class='col-01' title='Cr&eacute;ditos Tradicionales'>T</th>";
echo "<th colspan='6' class='col-01' title='Cr&eacute;ditos ECTS'>ECTS</th>";
echo "<th colspan='2' class='col-01' title='Cr&eacute;ditos Tradicionales'>T</th>";
echo "<th colspan='6' class='col-01' title='Cr&eacute;ditos ECTS'>ECTS</th>";
echo "<th colspan='2' class='col-01' title='Cr&eacute;ditos Tradicionales'>T</th>";
echo "<th colspan='6' class='col-01' title='Cr&eacute;ditos ECTS'>ECTS</th>";
echo "</tr>";

echo "<tr>";
echo "<th class='col-01' title='Cr&eacute;ditos Te&oacute;ricos'>CT</th>";
echo "<th class='col-01' title='Cr&eacute;ditos Pr&aacute;cticos'>CP</th>";
echo "<th class='col-01' title='Cr&eacute;ditos Te&oacute;ricos'>CTe</th>";
echo "<th class='col-01' title='Cr&eacute;ditos Pr&aacute;cticos'>CPr</th>";
echo "<th class='col-01' title='Cr&eacute;ditos de Laboratorio'>CL</th>";
echo "<th class='col-01' title='Cr&eacute;ditos de Seminario'>CS</th>";
echo "<th class='col-01' title='Cr&eacute;ditos de Tutor&iacute;a'>CTu</th>";
echo "<th class='col-01' title='Cr&eacute;ditos de Evaluaci&oacute;n'>CE</th>";
//
echo "<th class='col-01' title='Cr&eacute;ditos Te&oacute;ricos'>CT</th>";
echo "<th class='col-01' title='Cr&eacute;ditos Pr&aacute;cticos'>CP</th>";
echo "<th class='col-01' title='Cr&eacute;ditos Te&oacute;ricos'>CTe</th>";
echo "<th class='col-01' title='Cr&eacute;ditos Pr&aacute;cticos'>CPr</th>";
echo "<th class='col-01' title='Cr&eacute;ditos de Laboratorio'>CL</th>";
echo "<th class='col-01' title='Cr&eacute;ditos de Seminario'>CS</th>";
echo "<th class='col-01' title='Cr&eacute;ditos de Tutor&iacute;a'>CTu</th>";
echo "<th class='col-01' title='Cr&eacute;ditos de Evaluaci&oacute;n'>CE</th>";
//
echo "<th class='col-01' title='Cr&eacute;ditos Te&oacute;ricos'>CT</th>";
echo "<th class='col-01' title='Cr&eacute;ditos Pr&aacute;cticos'>CP</th>";
echo "<th class='col-01' title='Cr&eacute;ditos Te&oacute;ricos'>CTe</th>";
echo "<th class='col-01' title='Cr&eacute;ditos Pr&aacute;cticos'>CPr</th>";
echo "<th class='col-01' title='Cr&eacute;ditos de Laboratorio'>CL</th>";
echo "<th class='col-01' title='Cr&eacute;ditos de Seminario'>CS</th>";
echo "<th class='col-01' title='Cr&eacute;ditos de Tutor&iacute;a'>CTu</th>";
echo "<th class='col-01' title='Cr&eacute;ditos de Evaluaci&oacute;n'>CE</th>";
echo "</tr>";

}

// --------------------------------------------------

function filaverde($tot, $soyadmitit) {
	$x = 3;
	if ($soyadmitit) {$x++;}
	echo "<tr>";
	echo "<td colspan='$x'></td>";
	casilla2($tot[1]['ct'],'');casilla2($tot[1]['cp'],'');
	casilla2($tot[1]['cte'],'');casilla2($tot[1]['cpr'],'');casilla2($tot[1]['cl'],'');
	casilla2($tot[1]['cs'],'');casilla2($tot[1]['ctu'],'');casilla2($tot[1]['ce'],'');
	//
	casilla2($tot[2]['ct'],1);casilla2($tot[2]['cp'],1);
	casilla2($tot[2]['cte'],1);casilla2($tot[2]['cpr'],1);casilla2($tot[2]['cl'],1);
	casilla2($tot[2]['cs'],1);casilla2($tot[2]['ctu'],1);casilla2($tot[2]['ce'],1);
	//
	casilla2($tot[3]['ct'],'');casilla2($tot[3]['cp'],'');
	casilla2($tot[3]['cte'],'');casilla2($tot[3]['cpr'],'');casilla2($tot[3]['cl'],'');
	casilla2($tot[3]['cs'],'');casilla2($tot[3]['ctu'],'');casilla2($tot[3]['ce'],'');
	//
	echo "<td></td>";
	echo "</tr>";
}

// --------------------------------------------------

function filaazul($tot,$totp,$profant,$cursant,$soyadmitit,$ilink) {
	$x = 3;
	if ($soyadmitit) {$x++;}
	echo "<tr>"; // style='background:#ccccff'
	echo "<td colspan='$x'></td>";
	$tot11 = $totp[1]['ct']+$totp[1]['cp'];
	$tot12 = $totp[1]['cte']+$totp[1]['cpr']+$totp[1]['cl']+$totp[1]['cs']+$totp[1]['ctu']+$totp[1]['ce'];
	$tot21 = $totp[2]['ct']+$totp[2]['cp'];
	$tot22 = $totp[2]['cte']+$totp[2]['cpr']+$totp[2]['cl']+$totp[2]['cs']+$totp[2]['ctu']+$totp[2]['ce'];
	$tot31 = $totp[3]['ct']+$totp[3]['cp'];
	$tot32 = $totp[3]['cte']+$totp[3]['cpr']+$totp[3]['cl']+$totp[3]['cs']+$totp[3]['ctu']+$totp[3]['ce'];
	$tot = suma($tot, $totp);
	$cretot1 = $tot11 + $tot21 +$tot31;
	$cretot2 = $tot12 + $tot22 +$tot32;
	casilla1($tot11,2);
	casilla1($tot12,6);
	casilla1($tot21,2);
	casilla1($tot22,6);
	casilla1($tot31,2);
	casilla1($tot32,6);
	echo "<td>";
	$sql = "SELECT podcursofigura.creditos, podcursofigura.creditosmin FROM podcursofigura";
	$sql .= " LEFT JOIN profcurareafigura ON podcursofigura.codfigura = profcurareafigura.figura AND podcursofigura.curso = profcurareafigura.curso";
	$sql .= " WHERE profcurareafigura.profeid = '$profant' AND profcurareafigura.curso ='$cursant'";
	$iresult = $ilink->query($sql);
	$f = $iresult->fetch_array(MYSQLI_BOTH);
	// --------------------------------------------------
	echo "<span style='border:1px solid red' title='Tradicional'>T</span> <span class='txth b'>Total: </span>";
	$span = "b";
	if ($cretot1) {
		$porcent1 = ($tot11 * 100) / $cretot1;
		$porcent2 = ($tot21 * 100) / $cretot1;
		$porcent3 = ($tot31 * 100) / $cretot1;
	}
	if ($cretot1 < $f[1]) {$span = "'rojo b'";}
	if ($cretot1 > $f[0]) {$span = "'txth b'";}
	echo "<span class=$span>".number_format($cretot1,2,'.','');
	echo "</span>";
	echo " M&aacute;ximos $f[0] *** M&iacute;nimos $f[1]<br>";
	echo "<span class='b'>Balance de carga docente</span>:<br>";
	if ($porcent1) {echo "Primer semestre: ".number_format($porcent1,2,'.','')."%. ";}
	if ($porcent2) {echo "Segundo semestre: ".number_format($porcent2,2,'.','')."%. ";}
	if ($porcent3) {echo "Sin asignar: ".number_format($porcent3,2,'.','')."%";}
	// --------------------------------------------------
	echo "<br><span style='border:1px solid red' title='ECTS'>E</span> <span class='txth b'>Total: </span>";
	$span = "b";
	if ($cretot2) {
		$porcent1e = ($tot12 * 100) / $cretot2;
		$porcent2e = ($tot22 * 100) / $cretot2;
		$porcent3e = ($tot32 * 100) / $cretot2;
	}
	if ($cretot2 < $f[1]) {$span = "'rojo b'";}
	if ($cretot2 > $f[0]) {$span = "'txth b'";}
	echo "<span class=$span>".number_format($cretot2,2,'.','');
	echo "</span>";
	echo " M&aacute;ximos $f[0] *** M&iacute;nimos $f[1]<br>";
	echo "<span class='b'>Balance de carga docente</span>:<br>";
	if ($porcent1e) {echo "Primer semestre: ".number_format($porcent1e,2,'.','')."%. ";}
	if ($porcent2e) {echo "Segundo semestre: ".number_format($porcent2e,2,'.','')."%. ";}
	if ($porcent3e) {echo "Sin asignar: ".number_format($porcent3e,2,'.','')."%";}
	// --------------------------------------------------
	echo "</td>";
	echo "</tr>";
	return $tot;
}

// --------------------------------------------------

function filablanca($soyadmitit) {
	$x = 28;
	if ($soyadmitit) {$x++;}
	echo "<tr style='background:#ffffff'><td colspan='$x'>&nbsp;</td></tr>";
}

// --------------------------------------------------

function suma($tot, $totp) {
	$tot[1]['ct'] = $tot[1]['ct'] + $totp[1]['ct'];
	$tot[2]['ct'] = $tot[2]['ct'] + $totp[2]['ct'];
	$tot[3]['ct'] = $tot[3]['ct'] + $totp[3]['ct'];
	//
	$tot[1]['cp'] = $tot[1]['cp'] + $totp[1]['cp'];
	$tot[2]['cp'] = $tot[2]['cp'] + $totp[2]['cp'];
	$tot[3]['cp'] = $tot[3]['cp'] + $totp[3]['cp'];
	//
	$tot[1]['cte'] = $tot[1]['cte'] + $totp[1]['cte'];
	$tot[2]['cte'] = $tot[2]['cte'] + $totp[2]['cte'];
	$tot[3]['cte'] = $tot[3]['cte'] + $totp[3]['cte'];
	//
	$tot[1]['cpr'] = $tot[1]['cpr'] + $totp[1]['cpr'];
	$tot[2]['cpr'] = $tot[2]['cpr'] + $totp[2]['cpr'];
	$tot[3]['cpr'] = $tot[3]['cpr'] + $totp[3]['cpr'];
	//
	$tot[1]['cl'] = $tot[1]['cl'] + $totp[1]['cl'];
	$tot[2]['cl'] = $tot[2]['cl'] + $totp[2]['cl'];
	$tot[3]['cl'] = $tot[3]['cl'] + $totp[3]['cl'];
	//
	$tot[1]['cs'] = $tot[1]['cs'] + $totp[1]['cs'];
	$tot[2]['cs'] = $tot[2]['cs'] + $totp[2]['cs'];
	$tot[3]['cs'] = $tot[3]['cs'] + $totp[3]['cs'];
	//
	$tot[1]['ctu'] = $tot[1]['ctu'] + $totp[1]['ctu'];
	$tot[2]['ctu'] = $tot[2]['ctu'] + $totp[2]['ctu'];
	$tot[3]['ctu'] = $tot[3]['ctu'] + $totp[3]['ctu'];
	//
	$tot[1]['ce'] = $tot[1]['ce'] + $totp[1]['ce'];
	$tot[2]['ce'] = $tot[2]['ce'] + $totp[2]['ce'];
	$tot[3]['ce'] = $tot[3]['ce'] + $totp[3]['ce'];
	//
	return $tot;
}

?>

<script language='JavaScript' type='text/javascript'>
function func1(form1)
{
pos = form1.codigo.value.split('*');
form1.ct.value = pos[0];
form1.cp.value = pos[1];
form1.tipasig.value = pos[2];
}
</script>
