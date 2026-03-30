<?php

require_once __DIR__ . '/../siempre_base.php';
require_once APP_DIR . '/pestana.php';
require_once APP_DIR . '/win.php';
require_once APP_DIR . "/wrapper_archivos.php";
require_once APP_DIR . '/hiperen.php';
require_once APP_DIR . '/tamano.php';

if ($_SESSION['auto'] < 5) {echo "<p><br>Usuario no autorizado</p>";exit;}

extract($_GET);

if ($pest == 1) {
	$a_areas = "class='active'";
	$titpag = "&Aacute;reas";
} elseif($pest == 2) {
	$a_titul = "class='active'";
	$titpag = "Titulaciones";
} elseif($pest == 3) {
	$a_grasi = "class='active'";
	$titpag = "Grupos de Asignaturas";
} elseif($pest == 4) {
	$a_figur = "class='active'";
} elseif($pest == 5) {
	$a_cargo = "class='active'";
} elseif($pest == 6) {
	$a_profe = "class='active'";
} elseif($pest == 7) {
	$a_asitu = "class='active'";
} elseif($pest == 8) {
	$a_asign = "class='active'";
} elseif($pest == 9) {
	$a_repos = "class='active'";
} elseif($pest == 10) {
	$a_envim = "class='active'";
} elseif($pest == 11) {
	$a_creda = "class='active'";
} elseif($pest == 12) {
	$a_envima = "class='active'";
} elseif($pest == 13) {
	$a_recim = "class='active'";
} elseif($pest == 14) {
	$a_admip = "class='active'";
} elseif($pest == 15) {
	$a_recalcu = "class='active'";
} elseif($pest == 16) {
	$a_paneles = "class='active'";
}

?>
<script language="javascript">
function prueba(form1) {
	if (document.form1.borrar.checked) {
		return confirm("<?php echo i("confirmborr",$ilink);?>");
	}
}
function obtenerN(form1, numarea) {
	form1.elements['cte[]'][numarea].value = Number(form1.elements['ct[]'][numarea].value) / 2.5;
	form1.elements['cpr[]'][numarea].value = Number(form1.elements['cp[]'][numarea].value) / 2.5;
}
function obtenerV(form1, numarea) {
	form1.elements['ct[]'][numarea].value = Number(form1.elements['cte[]'][numarea].value) * 2.5;
	form1.elements['cp[]'][numarea].value = Number(form1.elements['cpr[]'][numarea].value) + Number(form1.elements['cl[]'][numarea].value) + Number(form1.elements['cs[]'][numarea].value) + Number(form1.elements['ctu[]'][numarea].value) + Number(form1.elements['ce[]'][numarea].value);
	form1.elements['cp[]'][numarea].value = form1.elements['cp[]'][numarea].value * 2.5
}

function obtenerN1(form1, numarea) {
	form1.elements['asigcte'].value = Number(form1.elements['asigct'].value) / 2.5;
	form1.elements['asigcpr'].value = Number(form1.elements['asigcp'].value) / 2.5
}
function obtenerV1(form1, numarea) {
	form1.elements['asigct'].value = Number(form1.elements['asigcte'].value) * 2.5;
	form1.elements['asigcp'].value = Number(form1.elements['asigcpr'].value) + Number(form1.elements['asigcl'].value) + Number(form1.elements['asigcs'].value) + Number(form1.elements['asigctu'].value) + Number(form1.elements['asigce'].value);
	form1.elements['asigcp'].value = form1.elements['asigcp'].value * 2.5
}
</script>
<?php

if ($_SESSION['entra']) {

	$iresult = $ilink->query("SELECT * FROM usuarios WHERE id = '".$_SESSION['usuid']."' LIMIT 1");
	$fila = $iresult->fetch_array(MYSQLI_BOTH);
	require_once APP_DIR . "/var_usu.php";
	require_once APP_DIR . "/var_asig.php";

}

extract($_GET);
extract($_POST);

if (!$_SESSION['pod']) {
	$_POST['filtrocurso'] = $curso; $_SESSION['pod'] = 8;
}
if ($_POST['pest']) {$_SESSION['pod'] = $_POST['pest'];}
if ($_GET['pest']) {$_SESSION['pod'] = $_GET['pest'];}
$pest = $_SESSION['pod'];

$pest1 = $_GET['pest1']; if(!$pest1) {$pest1=1;}

$filtro = "pest=$pest&pest1=$pest1";

$body = " onload=\"";

if (($pest==7 OR $pest==8) AND ($accion=='edasgn' OR $accion=='anaasgn' OR $accion == 'anaasgn1')) {
	$body .= "document.form1.edcodigo1.focus();";
}

if ($pest==1 AND $accion == "anadir") {
	$body .= "document.form1.newcodarea.focus()";
}

$body .= "\"";

require_once APP_DIR . "/molde_top.php";

// --------------------------------------------------

$sql = "SELECT atencion, atenciontodos FROM podareas";
if ($filtroarea) {$sql .= " WHERE codarea = '$filtroarea'";}

$iresult = $ilink->query($sql);
$bpod1 = $iresult->fetch_array(MYSQLI_BOTH);
if ($bpod1[0] OR $bpod1[1]) {
	$bpod = $bpod1[0]." <span class='colu1'> ".$bpod1[1]." </span>";
}

$guardausuid = $usuid;
$usuid = $_SESSION['usuid'];


if ($bpod) {
	echo "<div class='col-10' style='margin-bottom:5px'>";
	echo "<marquee width=100% behavior='scroll' direction='left' scrollamount='5'><span class='b whit'> ";
	echo conhiper(consmy(trim($bpod)));
	echo " </span></marquee></div>";
}

$usuid = $guardausuid;

$mens = "";
$mensaje = "";

// --------------------------------------------------
$min = 1998;
// --------------------------------------------------
require_once APP_DIR . "/pod/barrapod.php";
// --------------------------------------------------

if ($ventana1) {$_SESSION['ventana'] = $ventana;}
$ventana = $_SESSION['ventana'];

if ($filtrocambio) {$accion = ""; $ord = "";}

if ($pest == 1) {
	require_once APP_DIR . "/pod/podareas.php";
}

if ($pest == 2) {
	if ($pest1 == 2) {
		require_once APP_DIR . "/pod/podadmitit.php";
	} else {
		require_once APP_DIR . "/pod/podtitulaciones.php";
	}
}

if ($pest == 3) {
	if ($pest1 == 2) {
		$caso = 4; require_once APP_DIR . "/pod/podformfiltro.php";
		require_once APP_DIR . "/pod/podareagruposasi.php";
	} else {
		$caso = 6; require_once APP_DIR . "/pod/podformfiltro.php";
		require_once APP_DIR . "/pod/podcursoareagruposasi.php";
	}
}

if ($pest == 4) {
	if ($pest1 == 2) {
		require_once APP_DIR . "/pod/podfiguras.php";
	} else {
		$caso = 5; require_once APP_DIR . "/pod/podformfiltro.php";
		require_once APP_DIR . "/pod/podcursofiguras.php";
	}
}

if ($pest == 5) {
	if ($pest1 == 2) {
		require_once APP_DIR . "/pod/podcargos.php";
	} else {
		$caso = 5; require_once APP_DIR . "/pod/podformfiltro.php";
		require_once APP_DIR . "/pod/podcursocargos.php";
	}
}

if ($pest == 6) {
	if ($pest1 == 2) {
		require_once APP_DIR . "/pod/podprofesores.php";
	} else {
		$caso = 3; require_once APP_DIR . "/pod/podformfiltro.php";
		require_once APP_DIR . "/pod/podcursoprofesores.php";
	}
}

if ($pest == 7) {
	if ($pest1 == 1) {
		$caso = 1; require_once APP_DIR . "/pod/podformfiltro.php";
		require_once APP_DIR . "/pod/podcursoasignat.php";
	} elseif ($pest1 == 2) {
		require_once APP_DIR . "/pod/podasignaturas.php";
	} else {
		require_once APP_DIR . "/pod/podfichaasigna.php";
	}
}

if ($pest == 8) {
	require_once APP_DIR . "/pod/podasignaciones.php";
}

if ($pest == 9) {
	require_once APP_DIR . "/pod/podreposit.php";
}


if ($pest == 10) {
	require_once APP_DIR . "/pod/podmails1.php";
}


if ($pest == 11) {
	require_once APP_DIR . "/pod/podresumenas.php";
}

if ($pest == 12) {
	require_once APP_DIR . "/pod/podmails.php";
}

if ($pest == 13) {
	require_once APP_DIR . "/pod/podrecmails.php";
}

if ($pest == 14) {
	if ($pest1 == 1) {
		require_once APP_DIR . "/pod/podadminmens.php";
	} else {
		require_once APP_DIR . "/pod/podadminpods.php";
	}
}

if ($pest == 15) {
	$filtrocurso = $_SESSION['filtrocurso'];
	require_once APP_DIR . "/pod/podactucredasig.php";
}

if ($pest == 16) {
	require_once APP_DIR . "/pod/paneles.php";
}

require_once APP_DIR . "/molde_bott.php";

function soyadmitit($tit,$filtrocurso,$ilink) {
	if ($_SESSION['auto'] == 10) {return 1;}
	$sql = "SELECT usuid FROM titcuradmi WHERE usuid = '".$_SESSION['usuid']."'";
	if ($filtrocurso) {$sql .= " AND curso = '".trim($filtrocurso)."'";}
	if ($tit) {$sql .= " AND titulaci = '$tit'";}
	$result = $ilink->query($sql);
	if ($result->num_rows > 0) {return 1;}
}

function soyadmiasgn($asgn,$ilink) {
	if ($_SESSION['auto'] == 10) {return 1;}
	$sql = "SELECT asignatprof.curso, tit FROM asignatprof
		LEFT JOIN podcursoasignatit ON asignatprof.curso = podcursoasignatit.curso AND
		asignatprof.asigna = podcursoasignatit.asigna WHERE asignatprof.id = '$asgn'";
	$iresult = $ilink->query($sql);
	$fila = $iresult->fetch_array(MYSQLI_BOTH);
	if (soyadmitit($fila[1],$fila[0],$ilink)) {return 1;}
}

function cab($tipo, $numarea, $marca) {
echo "<tr>";
echo "<td colspan='2'>Cr&eacute;ditos Tradicionales ";
if ($marca) {
	echo "<a href='#' onclick='obtenerV$tipo(form1, $numarea);return false;'><span class='icon-checkmark' title = 'CONVERTIR: CT(t) = CT(ects) * 2.5 ------ CP(t) = [CP(ects) + CL + CS + CTu + CE] * 2.5'></span></a>&nbsp; &nbsp; </td>";
}
echo "<td colspan='6'>Cr&eacute;ditos ECTS ";
if ($marca) {
	echo "<a href='#' onclick='obtenerN$tipo(form1, $numarea);return false;'><span class='icon-checkmark' title = 'CONVERTIR: CT(ects) = CT(t) / 2.5 ------ CP(ects) = CP(t) / 2.5'></span></a></td>";
}
echo "</tr>";
echo "<tr>";
echo "<td class='col-01' title='Cr&eacute;ditos Te&oacute;ricos'>CT</td>";
echo "<td class='col-01' title='Cr&eacute;ditos Pr&aacute;cticos'>CP</td>";
//
echo "<td class='col-01' title='Cr&eacute;ditos Te&oacute;ricos'>CT</td>";
echo "<td class='col-01' title='Cr&eacute;ditos Pr&aacute;cticos'>CP</td>";
echo "<td class='col-01' title='Cr&eacute;ditos de Laboratorio'>CL</td>";
echo "<td class='col-01' title='Cr&eacute;ditos de Seminario'>CS</td>";
echo "<td class='col-01' title='Cr&eacute;ditos de Tutor&iacute;a'>CTu</td>";
echo "<td class='col-01' title='Cr&eacute;ditos de Evaluaci&oacute;n'>CE</td>";
echo "</tr>";
}

?>