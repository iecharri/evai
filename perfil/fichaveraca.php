<?php

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

extract($_GET);
extract($_POST);

$filtrocurso = $_SESSION['filtrocurso'];

$caso = 5; $min = 1998; require_once APP_DIR . '/pod/podformfiltro.php';
if ($_SESSION['auto'] == 10 AND $filtrocurso) {
	echo " [ <a href='".APP_URL."/pod/pod.php?accion=editar&pest=6&cursoid=".trim($filtrocurso)."&profeid=$usuid'>".i("editar1",$ilink)."</a> ]<p></p>";
}

if (!$filtrocurso) {return;}

if ($accion == 'ed1' AND $_SESSION['auto'] == 10 AND $editar == "si") {
	if ($doctor == "on") {$doctor=1;} else {$doctor=0;}
	$ilink->query("UPDATE usuarios SET sexo = '$sexo', doctor = '$doctor', figura = '$figura', examenes = '$examenes', exacum = '$exacum', n_prof = '$n_prof', area = '$area', obs = '$obs', obs2 = '$obs2', mail2 = '$mail2', telefono1 = '$telefono1', despacho = '$despacho' WHERE id = '$usuid'");
	$mensaje = "<span class='rojo b'>Ficha actualizada</span>";
}

$sql = "SELECT * FROM profcurareafigura";
$sql .= " LEFT JOIN podcursofigura ON profcurareafigura.figura = podcursofigura.codfigura AND profcurareafigura.curso = podcursofigura.curso";
$sql .= " WHERE profcurareafigura.profeid = '$usuid' AND profcurareafigura.curso = '".trim($filtrocurso)."'";

$iresult = $ilink->query($sql);
$ficha = $iresult->fetch_array(MYSQLI_BOTH);

$obs = $ficha['obs'];
$obs2 = $ficha['obs2'];

$ver = 0;
if ($_SESSION['auto'] == 10) {$ver = 1;}

$sql1 = "SELECT SUM(podcursocargos.creditos) AS sum FROM profecargos";
$sql1 .= " LEFT JOIN podcursocargos ON profecargos.cargo = podcursocargos.codcargo AND profecargos.curso = podcursocargos.curso";
$sql1 .= " WHERE profeid = '$usuid' AND profecargos.curso = '".trim($filtrocurso)."'";
$iresult = $ilink->query($sql1);
$sum = $iresult->fetch_array(MYSQLI_BOTH);
if (!$sum[0]) {$sum[0] = "0";}

$iresult = $ilink->query("SELECT SUM(ct), sum(cp), sum(cte), sum(cpr), sum(cl), sum(cs), sum(ctu), sum(ce) FROM asignatprof WHERE usuid = '$id' AND curso = '".trim($filtrocurso)."'");
$cred = $iresult->fetch_array(MYSQLI_BOTH);
$cretot = $cred[0]+$cred[1];
$cretotects = $cred[2]+$cred[3]+$cred[4]+$cred[5]+$cred[6]+$cred[7];
$sql1 = "SELECT sum(ct + cp), sum(cte + cpr + cl + cs + ctu + ce) FROM asignatprof";
$sql1 .= " LEFT JOIN podcursoasigna ON asignatprof.curso = podcursoasigna.curso AND asignatprof.asigna = podcursoasigna.asigna";
$sql1 .= " WHERE usuid='$id' and tipasig='1' AND asignatprof.curso = '".trim($filtrocurso)."'";
$iresult = $ilink->query($sql1);
$fila1 = $iresult->fetch_array(MYSQLI_BOTH);
$sql2 = "SELECT sum(ct + cp), sum(cte + cpr + cl + cs + ctu + ce) FROM asignatprof";
$sql2 .= " LEFT JOIN podcursoasigna ON asignatprof.curso = podcursoasigna.curso AND asignatprof.asigna = podcursoasigna.asigna";
$sql2 .= " WHERE usuid='$id' and tipasig='2' AND asignatprof.curso = '".trim($filtrocurso)."'";
$iresult = $ilink->query($sql2);
$fila2 = $iresult->fetch_array(MYSQLI_BOTH);
$sql0 = "SELECT sum(ct + cp), sum(cte + cpr + cl + cs + ctu + ce) FROM asignatprof";
$sql0 .= " LEFT JOIN podcursoasigna ON asignatprof.curso = podcursoasigna.curso AND asignatprof.asigna = podcursoasigna.asigna";
$sql0 .= " WHERE usuid='$id' and tipasig='3' AND asignatprof.curso = '".trim($filtrocurso)."'";
$iresult = $ilink->query($sql0);
$fila0 = $iresult->fetch_array(MYSQLI_BOTH);
if ($cretot) {
	$porcent1 = ($fila1[0] * 100) / $cretot;
	$porcent2 = ($fila2[0] * 100) / $cretot;
	$porcent0 = ($fila0[0] * 100) / $cretot;
}
if ($cretotects) {
	$porcent1e = ($fila1[1] * 100) / $cretotects;
	$porcent2e = ($fila2[1] * 100) / $cretotects;
	$porcent0e = ($fila0[1] * 100) / $cretotects;
}

// --------------------------------------------------

if ($mensaje) {
	echo "<div class='colu center'>$mensaje</div><p></p>";
}

echo "<div class='fl col-3'>";

	echo "<div class='colu'>";
	echo "Tel&eacute;fono: ".$ficha['telefono'];
	echo "<br>Tel&eacute;fono2: ".$ficha['telefono1'];
	echo "<br>Despacho: ".$ficha['despacho'];
	echo "</div>";

	if ($sum[0]) {
		$sql = "SELECT podcargos.tipo, podcursocargos.creditos FROM profecargos";
		$sql .= " LEFT JOIN podcursocargos ON profecargos.cargo = podcursocargos.codcargo AND profecargos.curso = podcursocargos.curso";
		$sql .= " LEFT JOIN podcargos ON profecargos.cargo = podcargos.cod";
		$sql .= " WHERE profeid = '$usuid' AND profecargos.curso = '".trim($filtrocurso)."'";
		$result = $ilink->query($sql);
		echo "<div class='both'></div><p></p><span class='b'> &nbsp; Cargos</span><hr class='sty'><ul>";
		if ($result) {
			while ($fila = $result->fetch_array(MYSQLI_BOTH)) {
				echo "<li>".$fila['tipo'].": ".$fila['creditos']."</li>";
			}
		}
		echo "</ul>";
	}
	
	$sql = "SELECT DISTINCT asigna, asignatura, tipo, tipasig, cursoasi, creditos";
	$sql .= " FROM podcursoasigna";
	$sql .= " LEFT JOIN podasignaturas ON podcursoasigna.asigna = podasignaturas.cod";
	$sql .= " WHERE responsabl = '$usuid' AND curso = '".trim($filtrocurso)."'";
	$result = $ilink->query($sql);
	if ($result->num_rows) {
		echo "<p></p><span class='b'> &nbsp; Responsable de</span><hr class='sty'>";
		echo "<ul>";
		while ($fila = $result->fetch_array(MYSQLI_BOTH)) {
			echo "<li>".$fila['asigna']." - ".$fila['asignatura']."</li>";
		}
		echo "</ul>";
	}

echo "</div>";

// --------------------------------------------------

echo "<div class='fr col-6'><p></p>";

echo "<table class='col-10 mr5 fl'>";
echo "<tr><th class='nowrap col-01' colspan='2'>Cr&eacute;ditos</th><th>Reducciones</th><th></th></tr>";
echo "<tr><td class='nowrap col-01 rojo b'> M&aacute;ximos</td><td class='col-01'>".$ficha['creditos']."</td><td rowspan='2' class='col-01 center'>$sum[0]</td><td class='col-01 rojo b'>".number_format(($ficha['creditos']-$sum[0]),2,',','.')."</td></tr>";
echo "<tr><td class='nowrap col-01 verdecalific b'>M&iacute;nimos</td><td class='col-01'>".$ficha['creditosmin']."</td><td class='col-01 verdecalific b'>".number_format(($ficha['creditosmin']-$sum[0]),2,',','.')."</td></tr>";
echo "</table>";

// --------------------------------------------------

echo "<table class='col-01 mr5'>";
echo "<tr>";
	echo "<tr><th colspan='10'>Cr&eacute;ditos asignados</th></tr>";
echo "<th colspan='3'>Tradicionales</th>";
echo "<th colspan='7'>ECTS</th>";
echo "</tr>\n";
echo "<tr>";
echo "<th class='col-01' title='Cr&eacute;ditos Te&oacute;ricos'>CT</th>";
echo "<th class='col-01' title='Cr&eacute;ditos Pr&aacute;cticos'>CP</th>";
echo "<th class='col-01' title='Total'>T</th>";
echo "<th class='col-01' title='Cr&eacute;ditos Te&oacute;ricos'>CT</th>";
echo "<th class='col-01' title='Cr&eacute;ditos Pr&aacute;cticos'>CP</th>";
echo "<th class='col-01' title='Cr&eacute;ditos de Laboratorio'>CL</th>";
echo "<th class='col-01' title='Cr&eacute;ditos de Seminario'>CS</th>";
echo "<th class='col-01' title='Cr&eacute;ditos de Tutor&iacute;a'>CTu</th>";
echo "<th class='col-01' title='Cr&eacute;ditos de Evaluaci&oacute;n'>CE</th>";
echo "<th class='col-01' title='Total'>T</th>";
echo "</tr>\n";
echo "<tr><td>$cred[0]</td><td>$cred[1]</td><td class='b verdecalific'>".number_format($cretot,2,'.','')."</td>";
echo "<td>$cred[2]</td><td>$cred[3]</td>";
echo "<td>$cred[4]</td><td>$cred[5]</td>";
echo "<td>$cred[6]</td><td>$cred[7]</td>";
echo "<td class='b verdecalific'>".number_format($cretotects,2,'.','')."</td>";
echo "</tr>";
echo "</table>";

// --------------------------------------------------

echo "<div class='both'>&nbsp;</div>";

echo "<table class='col-01 mr5'>";
echo "<tr><th colspan='6'>Balance de carga docente</th></tr>";
echo "<tr><th colspan='3'>Cr&eacute;ditos Tradicionales</th>";
echo "<th colspan='3'>ECTS</th></tr>";
echo "<tr><th>1er semestre</th><th>2&deg; semestre</th><th>Anuales</th>";
echo "<th>1er semestre</th><th>2&deg; semestre</th><th>Anuales</th></tr>";
echo "<tr><td>";
if ($fila1[0]) {echo $fila1[0];}
echo "</td><td>";
if ($fila2[0]) {echo $fila2[0];}
echo "</td><td>";
if ($fila0[0]) {echo $fila0[0];}
echo "</td><td>";
if ($fila1[1]) {echo $fila1[1];}
echo "</td><td>";
if ($fila2[1]) {echo $fila2[1];}
echo "</td><td>";
if ($fila0[1]) {echo $fila0[1];}
echo "</td></tr>";
echo "<tr><td>";
if ($porcent1) {echo number_format($porcent1,2,'.','')."%";}
echo "</td><td>";
if ($porcent2) {echo number_format($porcent2,2,'.','')."%";}
echo "</td><td>";
if ($porcent0) {echo number_format($porcent0,2,'.','')."%";}
echo "</td><td>";
if ($porcent1e) {echo number_format($porcent1e,2,'.','')."%";}
echo "</td><td>";
if ($porcent2e) {echo number_format($porcent2e,2,'.','')."%";}
echo "</td><td>";
if ($porcent0e) {echo number_format($porcent0e,2,'.','')."%";}
echo "</td></tr>";
echo "</table>";

echo "<div class='both'>&nbsp;</div>";

$sql = "SELECT DISTINCT podasignaturas.cod, asignatura, podcursoasigna.tipo, tipasig, cursoasi, grupo, creditos, asignatprof.ct, asignatprof.cp, asignatprof.cte, asignatprof.cpr, asignatprof.cl, asignatprof.cs, asignatprof.ctu, asignatprof.ce";
$sql .= " FROM asignatprof";
$sql .= " LEFT JOIN podcursoasigna ON asignatprof.asigna = podcursoasigna.asigna AND asignatprof.curso = podcursoasigna.curso";
$sql .= " LEFT JOIN podasignaturas ON asignatprof.asigna = podasignaturas.cod";
$sql .= " LEFT JOIN podcursoasignaarea ON asignatprof.asigna = podcursoasignaarea.asigna AND asignatprof.curso = podcursoasignaarea.curso";
$sql .= " WHERE asignatprof.usuid = '$usuid' AND asignatprof.curso = '".trim($filtrocurso)."'";
$sql .= " ORDER BY asignatura,grupo";
$result = $ilink->query($sql);

// --------------------------------------------------

echo "<table>";

cab();
while ($fila = $result->fetch_array(MYSQLI_BOTH)) {
	echo "<tr><td>";
	if ($_SESSION['auto'] == 10) {
		echo "<a href='pod.php?accion=editar&edcod=".$fila['cod']."&edcurso=".trim($filtrocurso)."&pest=7&pest1=1'>".$fila['cod']."</a>";
	} else {
		echo $fila['cod'];
	}
	echo " - ";
	echo "<a href='pod.php?idasigna=".$fila['cod']."&idcurso=".trim($filtrocurso)."&pest=7&pest1=3'>".$fila['asignatura']."</a></td>";
	echo "<td class='center'>".$fila['grupo']."</td>";
	echo "<td class='center'>";
	if ($fila['ct'] != 0) {echo $fila['ct'];}
	echo "</td>";
	echo "<td class='center'>";
	if ($fila['cp'] != 0) {echo $fila['cp'];}
	echo "</td>";
	echo "<td class='center'>";
	if ($fila['cte'] != 0) {echo $fila['cte'];}
	echo "</td>";
	echo "<td class='center'>";
	if ($fila['cpr'] != 0) {echo $fila['cpr'];}
	echo "</td>";
	echo "<td class='center'>";
	if ($fila['cl'] != 0) {echo $fila['cl'];}
	echo "</td>";
	echo "<td class='center'>";
	if ($fila['cs'] != 0) {echo $fila['cs'];}
	echo "</td>";
	echo "<td class='center'>";
	if ($fila['ctu'] != 0) {echo $fila['ctu'];}
	echo "</td>";
	echo "<td class='center'>";
	if ($fila['ce'] != 0) {echo $fila['ce'];}
	echo "</td>";
	echo "</tr>";
}
echo "<tr>";
echo "<td colspan='2' class='b' style='text-align:right'>Cr&eacute;ditos asignados &nbsp; ";
echo "</td>";
echo "<td class='center b'>".$cred[0];
echo "</td>";
echo "<td class='center b'>".$cred[1];
echo "</td>";
echo "<td class='center b'>".$cred[2];
echo "</td>";
echo "<td class='center b'>".$cred[3];
echo "</td>";
echo "<td class='center b'>".$cred[4];
echo "</td>";
echo "<td class='center b'>".$cred[5];
echo "</td>";
echo "<td class='center b'>".$cred[6];
echo "</td>";
echo "<td class='center b'>".$cred[7];
echo "</td>";
echo "</tr>";
echo "</table>";

if ($_SESSION['auto'] == 10) {
	echo "<p></p><span class='b'> &nbsp; Observaciones</span><hr class='verdecalific b'><p></p>";
	echo "<span class='b'>".$obs."</span><p></p>";	
	echo $obs2."<p></p>";
}

echo "</div>";

// --------------------------------------------------

function cab() {
echo "<tr><th rowspan='2'>Profesor de...</th><th rowspan='2'>Grupo</th>";
echo "<th colspan='2'>Cr&eacute;ditos Tradicionales</th>";
echo "<th colspan='6'>Cr&eacute;ditos ECTS</th>";
echo "</tr>\n";
echo "<tr>";
echo "<th class='col-01' title='Cr&eacute;ditos Te&oacute;ricos'>CT</th>";
echo "<th class='col-01' title='Cr&eacute;ditos Pr&aacute;cticos'>CP</th>";
echo "<th class='col-01' title='Cr&eacute;ditos Te&oacute;ricos'>CT</th>";
echo "<th class='col-01' title='Cr&eacute;ditos Pr&aacute;cticos'>CP</th>";
echo "<th class='col-01' title='Cr&eacute;ditos de Laboratorio'>CL</th>";
echo "<th class='col-01' title='Cr&eacute;ditos de Seminario'>CS</th>";
echo "<th class='col-01' title='Cr&eacute;ditos de Tutor&iacute;a'>CTu</th>";
echo "<th class='col-01' title='Cr&eacute;ditos de Evaluaci&oacute;n'>CE</th>";
echo "</tr>\n";

}

?>