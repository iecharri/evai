<?php

// Copyright (c) 2000-2026 Inmaculada Echarri San Adrián
// Copyright (c) 2000-2026 Antonio Grandío Botella
// This file is part of EVAI.
// Licensed under the MIT License.
// See LICENSE.txt for details.

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

if (!$idcurso) {$idcurso = " ";}
$_SESSION['filtrocurso'] = $idcurso;

$caso = 5; 

require_once APP_DIR . "/pod/podformfiltro.php";

$idcurso = $filtrocurso;


$filtro .= "&idasigna=$idasigna&idcurso=$idcurso";

$sql = "SELECT podasignaturas.asignatura, tipasig FROM podcursoasigna";
$sql .= " LEFT JOIN podasignaturas ON podcursoasigna.asigna = podasignaturas.cod";
$sql .= " WHERE podcursoasigna.asigna = '$idasigna' AND podcursoasigna.curso = '$idcurso'";

$iresult = $ilink->query($sql);
$f = $iresult->fetch_array(MYSQLI_BOTH);
$tipasig = $f['tipasig'];

echo "<br><div class='colu'>";
echo "<span class='txth'><a href='?$filtro'>$idcurso $idasigna</a> - ".$f['asignatura']."</span><br>";
$sql = "SELECT titulacion FROM podcursoasignatit";
$sql .= " LEFT JOIN podtitulacion ON podcursoasignatit.tit = podtitulacion.cod";
$sql .= " WHERE podcursoasignatit.curso = '$idcurso' AND podcursoasignatit.asigna = '$idasigna'";
$result = $ilink->query($sql);
while ($fila = $result->fetch_array(MYSQLI_BOTH)) {
	echo $fila[0]."<br>";
}
echo "</div>";

if (!$filtrocurso) {
	echo "<p class='rojo b center'>&iexcl;ATENCI&Oacute;N! Seleccionar un CURSO.</p>";
	return;
}

if ($canc) {
	$grupo = "";
} else {
	if ($_POST['control1']) {
		if ($borrfich) {
			$contenido = ''; $nomfich = '';
		}
		$nomfich = $_FILES['eprogramafile']['name'];echo $nomfich;
		if ($nomfich) {
			$tipo    = $_FILES["eprogramafile"]["type"];
			$archivo = $_FILES["eprogramafile"]["tmp_name"];
			$tamanio = $_FILES["eprogramafile"]["size"];
			$contenido = file_get_contents($archivo);
			$contenido = $ilink->real_escape_string($contenido);
		}
		$camb = "UPDATE cursasigru SET programa = '$eprograma', horario = '$ehorario'";
		if ($nomfich OR $borrfich) {$camb .= ", nomprogfile = '$nomfich', programafile = '$contenido'";}
		$camb .= " WHERE asigna = '$idasigna' AND curso = '$idcurso' AND grupo = '".$_POST['editar1']."'";
		$ilink->query($camb);
	}
}

$sql = "SELECT podcursoasigna.tipo, tipasig, cursoasi, usuarios.id, podcursoasigna.curso, asignatprof.id, asignatprof.grupo, responsabl FROM podcursoasigna"; //podgruposa.texto, 
$sql .= " LEFT JOIN usuarios ON usuarios.id = podcursoasigna.responsabl";
$sql .= " LEFT JOIN asignatprof ON asignatprof.asigna = podcursoasigna.asigna AND asignatprof.curso = podcursoasigna.curso";
$sql .= " WHERE podcursoasigna.asigna = '$idasigna'";
$sql .= " AND podcursoasigna.curso='".trim($filtrocurso)."'";
$sql .= " ORDER BY asignatprof.grupo";

$result = $ilink->query($sql);
if ($result->num_rows == 0) {return;}

$f = $result->fetch_array(MYSQLI_BOTH);

echo "<br><table class='col-10'>";

echo "<tr><td colspan='3' class='b'>Cr&eacute;ditos Tradicionales</td></tr>";
echo "<tr><td class='col-01 nowrap'>Cr&eacute;ditos Te&oacute;ricos</td><td class='";
if (!$idcurso) {echo "col-10 ";}
$iresult = $ilink->query("SELECT SUM(ct) FROM podcursoasignaarea WHERE curso = '$idcurso' AND asigna = '$idasigna'"); 
$ct = $iresult->fetch_array(MYSQLI_BOTH);
$iresult = $ilink->query("SELECT SUM(cp) FROM podcursoasignaarea WHERE curso = '$idcurso' AND asigna = '$idasigna'");
$cp = $iresult->fetch_array(MYSQLI_BOTH);
$iresult = $ilink->query("SELECT SUM(cte) FROM podcursoasignaarea WHERE curso = '$idcurso' AND asigna = '$idasigna'");
$cte = $iresult->fetch_array(MYSQLI_BOTH);
$iresult = $ilink->query("SELECT SUM(cpr) FROM podcursoasignaarea WHERE curso = '$idcurso' AND asigna = '$idasigna'");
$cpr = $iresult->fetch_array(MYSQLI_BOTH);
$iresult = $ilink->query("SELECT SUM(cl) FROM podcursoasignaarea WHERE curso = '$idcurso' AND asigna = '$idasigna'");
$cl = $iresult->fetch_array(MYSQLI_BOTH);
$iresult = $ilink->query("SELECT SUM(cs) FROM podcursoasignaarea WHERE curso = '$idcurso' AND asigna = '$idasigna'");
$cs = $iresult->fetch_array(MYSQLI_BOTH);
$iresult = $ilink->query("SELECT SUM(ctu) FROM podcursoasignaarea WHERE curso = '$idcurso' AND asigna = '$idasigna'");
$ctu = $iresult->fetch_array(MYSQLI_BOTH);
$iresult = $ilink->query("SELECT SUM(ce) FROM podcursoasignaarea WHERE curso = '$idcurso' AND asigna = '$idasigna'");
$ce = $iresult->fetch_array(MYSQLI_BOTH);
echo "nowrap' colspan='2'>".$ct[0]."</td></tr>";
echo "<tr><td class='col-01 nowrap'>Cr&eacute;ditos Pr&aacute;cticos</td><td class='col-01 nowrap' colspan='2'>".$cp[0]."</td></tr>";
echo "<tr><td colspan='3' class='b'>Cr&eacute;ditos ECTS</td></tr>";
echo "<tr><td class='nowrap'>Cr&eacute;ditos Te&oacute;ricos</td><td colspan='2'>".$cte[0]."</td></tr>";
echo "<tr><td class='nowrap'>Cr&eacute;ditos Pr&aacute;cticos</td><td colspan='2'>".$cpr[0]."</td></tr>";
echo "<tr><td class='nowrap'>Cr&eacute;ditos de Laboratorio</td><td colspan='2'>".$cl[0]."</td></tr>";
echo "<tr><td class='nowrap'>Cr&eacute;ditos de Seminario</td><td colspan='2'>".$cs[0]."</td></tr>";
echo "<tr><td class='nowrap'>Cr&eacute;ditos de Tutor&iacute;a</td><td colspan='2'>".$cte[0]."</td></tr>";
echo "<tr><td class='nowrap'>Cr&eacute;ditos de Evaluaci&oacute;n</td><td colspan='2'>".$ce[0]."</td></tr>";
echo "<tr><td colspan='3'></td></tr>";
echo "<tr><td class='col-01 nowrap'>Tipo</td><td class='col-01 nowrap' colspan='2'>".$f['tipo']."</td></tr>";
echo "<tr><td class='col-01 nowrap'>Semestre</td><td class='col-01 nowrap' colspan='2'>";
if ($f['tipasig'] == "3") {echo "Anual";}
if ($f['tipasig'] == "2") {echo "Segundo";}
if ($f['tipasig'] == "1") {echo "Primero";}
if (!$f['tipasig']) {echo "Duraci&oacute;n indefinida";}
echo "</td></tr>";
echo "<tr><td class='col-01 nowrap'>Curso</td><td class='col-01 nowrap' colspan='2'>".$f['cursoasi']."</td></tr>";
echo "<tr><td class='col-01 nowrap'>Responsable</td><td class='col-01 nowrap' colspan='2'>";
$usu = ponerusu($f['responsabl'],1,$ilink);
echo $usu[0].$usu[1];
echo "</td></tr>";

$grupoant = '*';

// --------------------------------------------------

$sql = "SELECT grupo, horario, programa, programafile, nomprogfile FROM cursasigru";
$sql .= " WHERE asigna = '$idasigna'";
$sql .= " AND curso='$idcurso'";
$sql .= " ORDER BY grupo";


$result = $ilink->query($sql);

while ($f = $result->fetch_array(MYSQLI_BOTH)) {

	if ($f['grupo'] != $grupoant) {
		echo "<tr><td colspan='3' class='txth mediana'>";
		if ($f['grupo']) {echo "Grupo ".$f['grupo'];}
		echo"</td></tr>";
		$grupoant = $f['grupo'];
	} else {
		continue;
	}


	echo "<tr><td class='col-01 nowrap'>Profesores</td>";
	echo "<td colspan='2'>";
	$profesores = "SELECT usuarios.id, grupo, ct, cp, cte, cpr, cl, cs, ctu, ce, asignatprof.id AS asignatprofid FROM asignatprof LEFT JOIN usuarios ON usuarios.id = asignatprof.usuid WHERE asigna = '$idasigna' AND curso = '$idcurso' AND grupo = '".$f['grupo']."'";
	$profesores .= " AND usuarios.tipo = 'P' AND autorizado > 4";
	if ($_SESSION['auto'] < 10) {$profesores .= " AND fechabaja = '0000-00-00 00:00'";}
	$profesores .= " ORDER BY grupo, alumnoa, alumnon";
	$result1 = $ilink->query($profesores);
	if ($result1) {
		while ($fila1 = $result1->fetch_array(MYSQLI_BOTH)) {
			$mens = "";
			if ($_SESSION['auto'] == 10) {$mens .= " &nbsp; [<a href='pod.php?pest=8&pest1=1&accion=edasgn&edid=".$fila1['asignatprofid']."'>Asignaci&oacute;n</a>] ";}
			if ($fila1['ct'] != 0) {$mens .= " CT: <span>".$fila1['ct']."</span>";}
			if ($fila1['cp'] != 0) {$mens .= " CP: <span>".$fila1['cp']."</span>";}
			if ($fila1['cte'] != 0) {$mens .= " CTe: <span>".$fila1['cte']."</span>";}
			if ($fila1['cpr'] != 0) {$mens .= " CPr: <span>".$fila1['cpr']."</span>";}
			if ($fila1['cl'] != 0) {$mens .= " CL: <span>".$fila1['cl']."</span>";}
			if ($fila1['cs'] != 0) {$mens .= " CS: <span>".$fila1['cs']."</span>";}
			if ($fila1['ctu'] != 0) {$mens .= " CTu: <span>".$fila1['ctu']."</span>";}
			if ($fila1['ce'] != 0) {$mens .= " CE: <span>".$fila1['ce']."</span>";}
			echo "<p>";
			$usu = ponerusu($fila1['id'],1,$ilink);
			echo $usu[0].$usu[1].$mens;
			echo "</p>";
		}
	}
	echo "</td>";
	echo "</tr>";
	echo "<tr><td class='col-01 nowrap'>Programa (PDF o DOC)</td><td class='col-6 nowrap'>";
	if ($control AND $f['grupo'] == $editar) {
		echo "<form enctype='multipart/form-data' name='form1' method='post'>";
		if ($f['nomprogfile']) {
			echo i("agborrar",$ilink)." <input type='checkbox' name='borrfich'> ";
			echo "<a href='podfich.php?asigna=$idasigna&curso=$idcurso&grupo=".$f['grupo']."' target='_blank'>".$f['nomprogfile']."</a> ";
		} 
		echo "<input type='hidden' name='editar1' value='$editar'><input type='hidden' name='control1' value='1'>";
		echo "<input type='file' name='eprogramafile' class='col-5'>";
	} else {
		if ($f['nomprogfile']) {
			echo "<a href='podfich.php?asigna=$idasigna&curso=$idcurso&grupo=".$f['grupo']."' target='_blank'>".$f['nomprogfile']."</a>";
		} 
	}
	echo "</td>";
	echo "<td class='nowrap col-3' rowspan='3'>";
	if ((!$control OR $f['grupo'] != $editar) AND !$editar AND $_SESSION['auto'] == 10) {
		echo "<form method='post'>";
		echo "<input type='hidden' name='editar' value='".$f['grupo']."'><input type='hidden' name='control' value='1'>";
		echo "<input type='submit' value='A&ntilde;adir o cambiar'></form>";
	}
	echo "</td>";
	echo "</tr>";

	echo "<tr><td class='col-01 nowrap'>Programa (HTML)</td><td>";
	if ($control AND $f['grupo'] == $editar) {
		echo "<input type='text' size='25' maxlength='100' name='eprograma' value='".$f['programa']."'>";
	} else {
		echo conhiper($f['programa']);
	}
	echo "</td>";
	echo "</tr>";

	echo "<tr><td class='col-01 nowrap'>Horario (HTML)</td><td class='col-01 nowrap'>";
	if ($control AND $f['grupo'] == $editar) {
		echo "<input class='col-2' type='text' size='25' maxlength='100' name='ehorario' value='".$f['horario']."'>";
		echo " <input class='col-2' type='submit' value=' >> Validar >> '> <input class='col-3' type='submit' name='canc' value=' >> CANCELAR >> '>";
	} else {
		echo conhiper($f['horario']);
	}

	echo "</td></tr>";
	
	echo "</form>";

}

// --------------------------------------------------

echo "</table>";

// --------------------------------------------------

?>
