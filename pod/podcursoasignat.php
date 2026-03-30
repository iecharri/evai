<?php

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

if ($accion) {
require_once APP_DIR . "/pod/podtablasmodif.php";
}

if ($accion == "anaasgn" OR $accion == "anaasgn1" OR $accion == "edasgn" OR $accion == "edasgn1") {
	require_once APP_DIR . "/pod/podanaeditasignacion.php";
}

if($accion == "boasicur") {
	boasicur($ilink);
}

// --------------------------------------------------

if ($borrar) {
	$mensaje = borrarcurasignat($_POST,$ilink);
	$accion = "";
}

if ($accion == 'anadir1') {
	$mensaje = anadircursoasignat($_POST,$min,$ilink);
	if (!$mensaje) {$accion = "editar";}
}

if ($accion == 'editar1') {
	$mensaje = modifcursoasignat($_POST,$ilink);
	if ($ventana) {$accion = "editar";}
}

// --------------------------------------------------

if ($accion == 'anadir') {
	winop("A&Ntilde;ADIR ASIGNATURA - CURSO",'div1','');
	echo "<a name='anadir'></a><form method='post' action='?ord=$ord&$filtro'>";
	echo "<label>Curso</label><br>";
	echo "<input class='col-1' type='text' name='edcurso' size='4' maxlength='4' value='".trim($filtrocurso)."'><br>";
	$sql = "SELECT * FROM podasignaturas ORDER BY asignatura";
	$result = $ilink->query($sql);
	if ($ilink->errno) {echo $ilink->errno; exit;}
	echo "<select class='col-10' name='edcod'>";
	while ($fila = $result->fetch_array(MYSQLI_BOTH)) {
		if (strlen($fila[1]) > 70) {$fila[1] = substr($fila[1],0,69)."...";}
		echo "<option value='$fila[0]'>$fila[0] - $fila[1]</option>";
	
	}
	echo "</select><br>";
	echo "<input type='hidden' name='accion' value='anadir1'>";
	echo "<input class='col-2 'type='submit' value=\"".i("anadir1",$ilink)."\">";
	echo "</form>";
	echo "</div></div>";
}

if ($accion == 'editar') {
	$sql = "SELECT * FROM podcursoasigna";
	$sql .= " LEFT JOIN podasignaturas ON podcursoasigna.asigna = podasignaturas.cod";
	$sql .= " WHERE asigna = '$edcod' AND curso = '$edcurso'";
	$iresult = $ilink->query($sql);
	$fila = $iresult->fetch_array(MYSQLI_BOTH);
	extract($fila);
	winop("EDITAR ASIGNATURA - CURSO",'div1','');
	echo "<div class='peq'><a name='anadir'></a><form method='post' action='?ord=$ord&$filtro' name='form1' onsubmit='return prueba(form1)'>";
	echo "<span class='rojo b'>&iexcl;ATENCI&Oacute;N! Ha de haber congruencia entre el campo CURSO y el campo SEMESTRE.</span><br>";
	echo "<label>Curso</label> <input class='col-1' type='text' size='4' maxlength='4' value='$edcurso' readonly='readonly'>";
	echo "  ".i("asigna",$ilink)."  <input class='col-1' type='text' size='15' maxlength='15' value='$edcod' readonly='readonly'>";
	echo "<br><input class='col-10' type='text' size='80' maxlength='100' value='$asignatura' readonly='readonly'><br>";
	echo "<input type='hidden' name='edcod' value='$edcod'>";
	echo "<input type='hidden' name='edcurso' value='$edcurso'>";
	echo "Pertenece a las Titulaciones:<br>";	
	$sql1 = "SELECT * FROM podcursoasignatit WHERE curso = '$edcurso' AND asigna = '$edcod'";
	$result1 = $ilink->query($sql1);
	while ($fila1 = $result1->fetch_array(MYSQLI_BOTH)) {
		$sql2 = "SELECT * FROM podtitulacion ORDER BY titulacion";
		$result2 = $ilink->query($sql2);
		echo "<select class='col-10' name='tit[]'><option value=''></option>";
		while ($fila2 = $result2->fetch_array(MYSQLI_BOTH)) {
			if (strlen($fila2[1]) > 80) {$fila2[1] = substr($fila2[1],0,80)."...";}
			echo "<option value='$fila2[0]'";
			if ($fila2[0] == $fila1[2]) {echo " selected='selected'";}
			echo ">$fila2[0] - $fila2[1]</option>";
		}
		echo "</select><br>";
		$haytit=1;
	}
	if (!$haytit) {
		$sql1 = "SELECT * FROM podtitulacion ORDER BY titulacion";
		$result1 = $ilink->query($sql1);
		echo "<select class='col-10' name='tit[]'><option value=''>A&Ntilde;ADIR TITULACION</option>";
		while ($fila1 = $result1->fetch_array(MYSQLI_BOTH)) {
			if (strlen($fila1[1]) > 80) {$fila1[1] = substr($fila1[1],0,80)."...";}
			echo "<option value='$fila1[0]'>$fila1[0] - $fila1[1]</option>";
		}
		echo "</select><br>";
	}
	echo "Pertenece a las &Aacute;reas:";	
	$sql1 = "SELECT * FROM podcursoasignaarea WHERE curso = '$edcurso' AND asigna = '$edcod'";
	$result1 = $ilink->query($sql1);
	$numarea = 0;
	while ($fila1 = $result1->fetch_array(MYSQLI_BOTH)) {
		$sql2 = "SELECT * FROM podareas ORDER BY area";
		$result2 = $ilink->query($sql2);
		$elegidaarea = 0;
		echo "<div class='colu'><select class='col-10' name='area[]'><option value=''></option>";
		while ($fila2 = $result2->fetch_array(MYSQLI_BOTH)) {
			if (strlen($fila2[1]) > 40) {$fila2[1] = substr($fila2[1],0,40)."...";}
			echo "<option value='$fila2[0]'";
			if ($fila2[0] == $fila1[2]) {echo " selected='selected'"; $elegidaarea=1;}
			echo ">$fila2[0] - $fila2[1]</option>";
		}
		echo "</select><br>";
		echo "<input type='hidden' name='areaold[]' value='".$fila1[2]."'>";

		echo "<br><table class='peq'>";
		cab('',$numarea,1);
		$numarea++;
		echo "<tr>";
		echo "<td><input type='text' name='ct[]' size='5' maxlength='5' value='".number_format($fila1['ct'],2,'.','')."'></td>";
		echo "<td><input type='text' name='cp[]' size='5' maxlength='5' value='".number_format($fila1['cp'],2,'.','')."'></td>";
		echo "<td><input type='text' name='cte[]' size='5' maxlength='5' value='".number_format($fila1['cte'],2,'.','')."'></td>";
		echo "<td><input type='text' name='cpr[]' size='5' maxlength='5' value='".number_format($fila1['cpr'],2,'.','')."'></td>";
		echo "<td><input type='text' name='cl[]' size='5' maxlength='5' value='".number_format($fila1['cl'],2,'.','')."'></td>";
		echo "<td><input type='text' name='cs[]' size='5' maxlength='5' value='".number_format($fila1['cs'],2,'.','')."'></td>";
		echo "<td><input type='text' name='ctu[]' size='5' maxlength='5' value='".number_format($fila1['ctu'],2,'.','')."'></td>";
		echo "<td><input type='text' name='ce[]' size='5' maxlength='5' value='".number_format($fila1['ce'],2,'.','')."'></td>";
		echo "</tr>";
		echo "</table>";
		// ------------- Seleccionar un grupo de asignaturas para el &aacute;rea-curso
		$sql3 = "SELECT podcursoareagruposa.cod, grupo FROM podcursoareagruposa, podareagruposa
		 WHERE podcursoareagruposa.cod=podareagruposa.cod AND curso = '$edcurso'";
		if (trim($fila1[2])) {$sql3 .= " AND podcursoareagruposa.area = '$fila1[2]'";}
		$result3 = $ilink->query($sql3);
		if ($result3->num_rows) {
			echo "<select class='col-10' name='grupoa[]'";
			if (!$elegidaarea) {echo " disabled='disabled'";}
			echo "><option value=''>A&ntilde;adir Grupo de Asignaturas</option>";
			while ($fila3 = $result3->fetch_array(MYSQLI_BOTH)) {
				echo "<option value='$fila3[0]'";
				if ($fila3[0] == $fila1['grupoa']) {echo " selected='selected'";}
				echo ">$fila3[0] - $fila3[1]</option>";
			}
			echo "</select>";
		}
		echo "</div>";
	}
	$sql1 = "SELECT * FROM podareas ORDER BY area";
	$result1 = $ilink->query($sql1);
	echo "<br><div class='colu'><select class='col-10' name='area[]'><option value=''>A&Ntilde;ADIR AREA</option>";
	while ($fila1 = $result1->fetch_array(MYSQLI_BOTH)) {
		if (strlen($fila1[1]) > 40) {$fila1[1] = substr($fila1[1],0,40)."...";}
		echo "<option value='$fila1[0]'>$fila1[0] - $fila1[1]</option>";
	}
	echo "</select>";

	echo "<table class='peq'>";

	cab('', $numarea,1);
	echo "<tr>";
	echo "<td><input type='text' name='ct[]' size='5' maxlength='5'></td>";
	echo "<td><input type='text' name='cp[]' size='5' maxlength='5'></td>";
	echo "<td><input type='text' name='cte[]' size='5' maxlength='5'></td>";
	echo "<td><input type='text' name='cpr[]' size='5' maxlength='5'></td>";
	echo "<td><input type='text' name='cl[]' size='5' maxlength='5'></td>";
	echo "<td><input type='text' name='cs[]' size='5' maxlength='5'></td>";
	echo "<td><input type='text' name='ctu[]' size='5' maxlength='5'></td>";
	echo "<td><input type='text' name='ce[]' size='5' maxlength='5'></td>";
	echo "</tr>";
	echo "</table>";

	// ------------- Seleccionar un grupo de asignaturas para el &aacute;rea-curso
	$sql3 = "SELECT podcursoareagruposa.cod, grupo FROM podcursoareagruposa, podareagruposa
	 WHERE podcursoareagruposa.cod=podareagruposa.cod AND curso = '$edcurso'";
	$result3 = $ilink->query($sql3);
	if ($result3->num_rows) {
		echo "<select disabled='disabled' name='grupoa[]'><option value=''>A&ntilde;adir Grupo de Asignaturas</option>";
		while ($fila3 = $result3->fetch_array(MYSQLI_BOTH)) {
			echo "<option value='$fila3[0]'>$fila3[0] - $fila3[1]</option>";
		}
		echo "</select> Valida primero un &Aacute;rea.";
	}
	echo "</div>Tipo ";
	echo "<select name='edtipo'>";
	echo "<option value='Troncal'";
	if ($fila['tipo'] == "Troncal") {echo " selected='selected'";}
	echo ">Troncal</option>";
	echo "<option value='Optativa'";
	if ($fila['tipo'] == "Optativa") {echo " selected='selected'";}
	echo ">Optativa</option>";
	echo "<option value='Obligatoria'";
	if ($fila['tipo'] == "Obligatoria") {echo " selected='selected'";}
	echo ">Obligatoria</option>";
	echo "</select>";
	echo " Semestre ";
	echo "<select name='edtipasig'>";
	echo "<option value='0'";
	if ($fila['tipasig'] == "0") {echo " selected='selected'";}
	echo ">Indefinido</option>";
	echo "<option value='1'";
	if ($fila['tipasig'] == "1") {echo " selected='selected'";}
	echo ">Primero</option>";
	echo "<option value='2'";
	if ($fila['tipasig'] == "2") {echo " selected='selected'";}
	echo ">Segundo</option>";
	echo "<option value='3'";
	if ($fila['tipasig'] == "3") {echo " selected='selected'";}
	echo ">Asignatura Anual</option>";
	echo "</select>";
	echo " Curso (1&deg;, 2&deg;...) ";
	echo "<input class='col-4em' type='text' name='edcursoasi' size='1' maxlength='1' value='".$fila['cursoasi']."'>";
	echo " Responsable ";
	$sql1 = "SELECT DISTINCT profeid, CONCAT(alumnoa,', ',alumnon) FROM profcurareafigura LEFT JOIN usuarios ON profcurareafigura.profeid = usuarios.id WHERE curso = '$edcurso' ORDER BY alumnoa, alumnon";
	$result1 = $ilink->query($sql1);
	echo "<select name='edresponsabl'><option value=''></option>";
	while ($fila1 = $result1->fetch_array(MYSQLI_BOTH)) {
		echo "<option value='$fila1[0]'";
		if ($fila['responsabl'] == $fila1[0]) {
			echo " selected='selected'";
		}
		echo ">$fila1[1]</option>";
	}
	echo "</select>"; 
	echo "<br><input type='hidden' name='accion' value='editar1'>";
	echo "<input class='col-2' class = 'mediana b' type='submit' value=\"".i("agvalid",$ilink)."\">";
	$temp = ""; if ($ventana) {$temp = "checked='checked'";}
	echo "<div class='fr'>Mantener ventana <input type='checkbox' name='ventana' $temp></div>";
	echo "<input type='hidden' name='ventana1' value='1'>";
	echo "</form>";
	echo "</div></div></div>";
}

// -------------------------------------------------- A S I G N A T U R A S // --------------------------------------------------

if (!$accion) {
	//Esto primero es para borrar las asignaturas-curso que se han dejado sin editar para asignarles &aacute;rea, titulaci&oacute;n, etc
	//Falla por relacionado con cursasigru
	$sql = "SELECT podcursoasigna.asigna, podcursoasigna.curso FROM podcursoasigna LEFT JOIN podcursoasignaarea ON 
	podcursoasignaarea.asigna = podcursoasigna.asigna AND podcursoasignaarea.curso = podcursoasigna.curso WHERE area IS NULL";
	$result = $ilink->query($sql);
	while ($fila = $result->fetch_array(MYSQLI_BOTH)) {
		$ilink->query("DELETE FROM podcursoasigna WHERE asigna = '$fila[0]' AND curso = '$fila[1]'");
	}
}

// --------------------------------------------------

$ord = $_GET['ord'];
if (!$ord) {$ord = "podasignaturas.cod";}

$sql = "SELECT DISTINCT podcursoasigna.curso, podcursoasigna.asigna, asignatura, tipo, tipasig, cursoasi, responsabl"; //grupo, podareas.area, , titulacion 
$sql  .= ", podcursoasignaarea.area, podcursoasignaarea.grupoa, asignatprof.grupo";
$sql .= " FROM podcursoasigna";
$sql .= " LEFT JOIN asignatprof ON podcursoasigna.curso = asignatprof.curso AND podcursoasigna.asigna = asignatprof.asigna";
$sql .= " LEFT JOIN podcursoasignatit ON podcursoasignatit.asigna = podcursoasigna.asigna AND podcursoasignatit.curso = podcursoasigna.curso";
$sql .= " LEFT JOIN podcursoasignaarea ON podcursoasignaarea.asigna = podcursoasigna.asigna AND podcursoasignaarea.curso = podcursoasigna.curso";
$sql .= " LEFT JOIN podtitulacion ON podcursoasignatit.tit = podtitulacion.cod";
$sql .= " LEFT JOIN podareas ON podcursoasignaarea.area = podareas.codarea";
$sql .= " LEFT JOIN podasignaturas ON podcursoasigna.asigna = podasignaturas.cod";
$sql .= " WHERE 1=1"; //asignatprof.grupo != 'NULL'"; //1=1 AND 

if ($filtrocurso) {$sql .= " AND podcursoasigna.curso = '".trim($filtrocurso)."'";}
if ($filtroarea) {$sql .= " AND podareas.codarea = '".trim($filtroarea)."'";}
if ($filtrotit) {$sql .= " AND podtitulacion.cod = '".trim($filtrotit)."'";}
if ($filtroprof) {$sql .= " AND (asignatprof.usuid = '".trim($filtroprof)."' OR podcursoasigna.responsabl = '".trim($filtroprof)."')";}
if ($filtroasig) {
	$filtroasig = explode("$$",$filtroasig);
	$fcod = $filtroasig[0]; $farea = $filtroasig[1];
	$sql .= " AND podcursoasignaarea.area = '$farea' AND podcursoasignaarea.grupoa = '$fcod'";
}
$sql .= " ORDER BY $ord";
$result = $ilink->query($sql);

// --------------------------------------------------

echo $mensaje;

echo "<br><table class='tancha' style='font-size:.9em'>";

echo "<tr>";
echo "<th rowspan='2' class='col-01'><a href='?ord=podcursoasigna.curso,podcursoasigna.asigna&$filtro'>Curso</a>";
if ($_SESSION['auto'] == 10) {
	echo "<br><a href='?accion=anadir&$filtro'>".i("anadir1",$ilink)."</a>";
}
echo "</th>";
echo "<th rowspan='2' class='col-3'><a href='?ord=podcursoasigna.asigna,podcursoasigna.curso&$filtro'>C&oacute;digo</a>";
echo " - <a href='?ord=asignatura,podcursoasigna.curso&$filtro'>".i("asigna",$ilink)."</a>";
echo "</th>";
echo "<th rowspan='2' title='Grupo'>G</th>";
echo "<th rowspan='2' class='col-3'>Titulaci&oacute;n<br>&Aacute;rea<br><a href='?ord=responsabl,podcursoasigna.asigna,podcursoasigna.curso&$filtro'>Responsable</a></th>";
echo "<th rowspan='2' class='col-01' title='Tipo'><a href='?ord=tipo,podcursoasigna.asigna,podcursoasigna.curso&$filtro'>T</a></th>";
echo "<th rowspan='2' class='col-01' title='Semestre'><a href='?ord=tipasig,podcursoasigna.asigna,podcursoasigna.curso&$filtro'>S</a></th>";
echo "<th rowspan='2' class='col-01' title='Curso'><a href='?ord=cursoasi,podcursoasigna.asigna,podcursoasigna.curso&$filtro'>C</a></th>";
echo "<th rowspan='2' class='col-3'>Profesores<br>Asignaciones Tradicionales<br>ECTS</th>";
echo "<th colspan='3' class='nowrap'>Tradicionales<br>Asignados / Asignatura</th>";
echo "<th colspan='7'>ECTS<br>Asignados / Asignatura</th>";
echo "<th rowspan='2' class='col-01'><span title='Grupos de Asignaturas'>Gr</span></th>";
echo "</tr>";
echo "<tr>";
echo "<th class='col-01' title='Cr&eacute;ditos Te&oacute;ricos'>CT</th>";
echo "<th class='col-01' title='Cr&eacute;ditos Pr&aacute;cticos'>CP</th>";
echo "<th class='col-01' title='Cr&eacute;ditos Totales'>C</th>";
echo "<th class='col-01' title='Cr&eacute;ditos Te&oacute;ricos'>CT</th>";
echo "<th class='col-01' title='Cr&eacute;ditos Pr&aacute;cticos'>CP</th>";
echo "<th class='col-01' title='Cr&eacute;ditos de Laboratorio'>CL</th>";
echo "<th class='col-01' title='Cr&eacute;ditos de Seminario'>CS</th>";
echo "<th class='col-01' title='Cr&eacute;ditos de Tutor&iacute;a'>CTu</th>";
echo "<th class='col-01' title='Cr&eacute;ditos de Evaluaci&oacute;n'>CE</th>";
echo "<th class='col-01' title='Cr&eacute;ditos Totales'>C</th>";
echo "</tr>";

$total = array(0,0,0,0,0,0,0,0);
$totala = array(0,0,0,0,0,0,0,0);
$regant = "";

while ($fila = $result->fetch_array(MYSQLI_BOTH)) {

	echo "<tr>";
	echo "<td>";
	$temp = $fila['curso']; if (!trim($temp)) {$temp="Indef.";}
	if ($_SESSION['auto'] == 10) {
		echo "<a href='?accion=editar&edcod=".$fila['asigna']."&edcurso=".$fila['curso']."&$filtro'>";
		echo $temp."</a>";
	} else {
		echo $temp;
	}
	echo "</td>";
	echo "<td>";
	if ($_SESSION['auto'] == 10) {
		echo "<a href='?accion=editar&cod=".$fila['asigna']."&$filtro&pest1=2'>";
		echo $fila['asigna']."</a>";
	} else {
		echo $fila['asigna'];
	}
	echo " - <a href='?$filtro&pest1=3&idasigna=".$fila['asigna']."&idcurso=".$fila['curso']."'>".$fila['asignatura']."</a>";
	echo "</td>";
	echo "<td>".$fila['grupo']."</td>";
	$sql1 = "SELECT podtitulacion.titulacion FROM podtitulacion";
	$sql1 .= " LEFT JOIN podcursoasignatit ON podtitulacion.cod = podcursoasignatit.tit";
	$sql1 .= " LEFT JOIN podcursoasigna ON podcursoasignatit.asigna = podcursoasigna.asigna AND podcursoasignatit.curso = podcursoasigna.curso";
	$sql1 .= " WHERE podcursoasigna.asigna = '".$fila['asigna']."'";
	$sql1 .= " AND podcursoasigna.curso = '".$fila['curso']."'";
	$result1 = $ilink->query($sql1);
	echo "<td>";
	$haytit = "";
	while ($fila1 = $result1->fetch_array(MYSQLI_BOTH)) {
		echo $fila1['titulacion']."<br>";$haytit = 1;
	}
	if (!$haytit) {
		echo "<span class='rojo b'>Falta Titulaci&oacute;n</span><br>";	
	}
	$iresult = $ilink->query("SELECT area FROM podareas WHERE codarea = '".$fila['area']."'");
	$nombrearea = $iresult->fetch_array(MYSQLI_BOTH);
	echo $nombrearea[0];
	if (!$nombrearea[0]) {
		echo "<span class='rojo b'>Falta &Aacute;rea</span>";
	}
	if ($fila['responsabl']) {
		$usu = ponerusu($fila['responsabl'],1,$ilink);
		echo "<br>".$usu[1];
	}
	echo "</td>";
	
	$temp="";
	if ($fila['tipo'] == "Optativa") {$temp = "Op";}
	if ($fila['tipo'] == "Troncal") {$temp = "T";}
	if ($fila['tipo'] == "Obligatoria") {$temp = "Ob";}
	echo "<td title='".$fila['tipo']."'>".$temp."</td>";

	$temp="";
	if ($fila['tipasig'] == "1") {$temp = "Primero";}
	if ($fila['tipasig'] == "2") {$temp = "Segundo";}
	if ($fila['tipasig'] == "3") {$temp = "Anual";}
	if ($fila['tipasig'] == "0") {$temp = "Indefinida";}
	echo "<td title='$temp'>".$fila['tipasig']."</td>";

	echo "<td>".$fila['cursoasi']."</td>";

	echo "<td class='nowrap tbor'>";

	if ($_SESSION['auto'] == 10) {
		echo "[<a href='?accion=anaasgn&asigna=".$fila['asigna']."&curso=".$fila['curso']."&grupo=".$fila['grupo']."&$filtro'>A&ntilde;adir</a>]";
	}

	$sql = "SELECT usuid, ct, cp, cte, cpr, cl, cs, ctu, ce, asignatprof.id AS asignac, podcursofigura.creditosmin FROM asignatprof";
	$sql .= " LEFT JOIN profcurareafigura ON asignatprof.curso = profcurareafigura.curso AND asignatprof.usuid = profcurareafigura.profeid";
	$sql .= " LEFT JOIN podcursofigura ON podcursofigura.curso = profcurareafigura.curso AND podcursofigura.codfigura = profcurareafigura.figura";
	$sql .= " WHERE asignatprof.asigna = '".$fila['asigna']."' AND asignatprof.curso = '".$fila['curso']."' AND asignatprof.grupo = '".$fila['grupo']."'";
	$sql .= " AND profcurareafigura.area = '".$fila['area']."'";
	
	unset($asignac);
	$asignac = array(0,0,0,0,0,0,0,0);
	$result1 = $ilink->query($sql);
	$hayasignac = 0;
	while ($fila1 = $result1->fetch_array(MYSQLI_BOTH)) {
		echo "<br>";
		if ($_SESSION['auto'] == 10) {
			echo "[<a href='?accion=edasgn&edid=".$fila1['asignac']."&$filtro'>Editar</a>] ";
		}
		$usu = ponerusu($fila1['usuid'],1,$ilink);
		echo $usu[1];
		echo "<br>".$fila1['ct']." - ". $fila1['cp'];
		$sql1 = "SELECT SUM(cargos.creditos) AS sum FROM podcursocargos, podcargos,profecargos WHERE profeid = '".$fila1['usuid']."'";

		$sql1 = "SELECT sum(creditos) FROM podcursocargos, profecargos";
		$sql1 .= " WHERE podcursocargos.codcargo=profecargos.cargo and podcursocargos.curso=profecargos.curso";
		$sql1 .= " AND profeid='".$fila1['usuid']."' and podcursocargos.curso='".$fila['curso']."'";

		$iresult = $ilink->query($sql1);
		$cred = $iresult->fetch_array(MYSQLI_BOTH);
		$cred = $fila1['creditosmin'] - $cred[0];
		echo "<span class='b'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$cred";
		$sql1 = "SELECT SUM(ct) AS cts, SUM(cp) AS cps, SUM(cte) AS ctes, SUM(cpr) AS cprs, SUM(cl) AS cls, SUM(cs) AS css, SUM(ctu) AS ctus, SUM(ce) AS ces FROM asignatprof";
		$sql1 .= " WHERE usuid = '".$fila1['usuid']."' AND curso = '".$fila['curso']."'"; // AND asigna = '".$fila['asigna']."' AND grupo = '".$fila['grupo']."'

		$iresult = $ilink->query($sql1);
		$sum1 = $iresult->fetch_array(MYSQLI_BOTH);
		$sum_a = $sum1[0] + $sum1[1];
		echo "/$sum_a</span>";
		echo "<br>";
		echo $fila1['cte']." - ". $fila1['cpr']." - ". $fila1['cl']." - ". $fila1['cs']." - ". $fila1['ctu']." - ". $fila1['ce'];
		echo "<span class='b'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$cred";
		$sum_b = $sum1[2] + $sum1[3] + $sum1[4] + $sum1[5] + $sum1[6] + $sum1[7];
		echo "/$sum_b</span>";
		echo "<br>";
		$totala[0] = $totala[0] + $fila1['ct'];
		$totala[1] = $totala[1] + $fila1['cp'];
		$totala[2] = $totala[2] + $fila1['cte'];
		$totala[3] = $totala[3] + $fila1['cpr'];
		$totala[4] = $totala[4] + $fila1['cl'];
		$totala[5] = $totala[5] + $fila1['cs'];
		$totala[6] = $totala[6] + $fila1['ctu'];
		$totala[7] = $totala[7] + $fila1['ce'];
		$asignac[0] = $asignac[0] + $fila1['ct'];
		$asignac[1] = $asignac[1] + $fila1['cp'];
		$asignac[2] = $asignac[2] + $fila1['cte'];
		$asignac[3] = $asignac[3] + $fila1['cpr'];
		$asignac[4] = $asignac[4] + $fila1['cl'];
		$asignac[5] = $asignac[5] + $fila1['cs'];
		$asignac[6] = $asignac[6] + $fila1['ctu'];
		$asignac[7] = $asignac[7] + $fila1['ce'];
		$hayasignac = 1;
	}
if(!$hayasignac) {echo " [<a href='?accion=boasicur&asigna=".$fila['asigna']."&curso=".$fila['curso']."&$filtro'>Borrar Asignatura/Curso</a>]";}
	echo "</td>";
	
// --------------------------------------------------
	
	empty($credareas);
	$credareas = credareas($fila['asigna'],$fila['curso'],$fila['area'],$ilink);

	echo "<td class='col-01 ri tbor'>";
	echo formatear($asignac[0]);
	echo "<hr>";
	echo formatear($credareas[0]);
	echo "</td>";
	echo "<td class='col-01 ri'>";
	echo formatear($asignac[1]);
	echo "<hr>";
	echo formatear($credareas[1]);
	echo "</td>";
	echo "<td class='col-01 ri' style='background:#FAF9F9'>";
	echo formatear($asignac[0] + $asignac[1]);
	echo "<hr>";
	echo formatear($credareas[0] + $credareas[1]);
	echo "</td>";
	echo "<td class='col-01 ri'>";
	echo formatear($asignac[2]);
	echo "<hr>";
	echo formatear($credareas[2]);
	echo "</td>";
	echo "<td class='col-01 ri'>";
	echo formatear($asignac[3]);
	echo "<hr>";
	echo formatear($credareas[3]);
	echo "</td>";
	echo "<td class='col-01 ri'>";
	echo formatear($asignac[4]);
	echo "<hr>";
	echo formatear($credareas[4]);
	echo "</td>";
	echo "<td class='col-01 ri'>";
	echo formatear($asignac[5]);
	echo "<hr>";
	echo formatear($credareas[5]);
	echo "</td>";
	echo "<td class='col-01 ri'>";
	echo formatear($asignac[6]);
	echo "<hr>";
	echo formatear($credareas[6]);
	echo "</td>";
	echo "<td class='col-01 ri'>";
	echo formatear($asignac[7]);
	echo "<hr>";
	echo formatear($credareas[7]);
	echo "<td class='col-01 ri' style='background:#FAF9F9'>";
	echo formatear($asignac[2] + $asignac[3] + $asignac[4] + $asignac[5] + $asignac[6] + $asignac[7]);
	echo "<hr>";
	echo formatear($credareas[2] + $credareas[3] + $credareas[4] + $credareas[5] + $credareas[6] + $credareas[7]);
	echo "</td>";

// --------------------------------------------------

	$iresult = $ilink->query("SELECT grupo FROM podareagruposa WHERE area = '".$fila['area']."' AND cod = '$credareas[8]'");
	$nombgru = $iresult->fetch_array(MYSQLI_BOTH);
	echo "<td class='col-01 ri' title=\"$nombgru[0]\">";echo $credareas[8];
	echo "</td>";
	echo "</tr>";
	
}

empty($credareas);
$credareas = credareas($filtroasign, $filtrocurso, $filtroarea,$ilink);

echo "<tr><td colspan='19'>&nbsp;</td></tr>";

echo "<tr>";
echo "<td colspan='8' style='text-align:right'>Total cr&eacute;ditos asignados &nbsp;&nbsp;</td>";
echo "<td class='col-01 ri'>".number_format($totala[0],2,'.','')."</td>";
echo "<td class='col-01 ri'>".number_format($totala[1],2,'.','')."</td>";
echo "<td class='col-01 ri' style='background:#FAF9F9'>".number_format(($totala[0]+$totala[1]),2,'.','')."</td>";
echo "<td>".number_format($totala[2],2,'.','')."</td>";
echo "<td>".number_format($totala[3],2,'.','')."</td>";
echo "<td>".number_format($totala[4],2,'.','')."</td>";
echo "<td>".number_format($totala[5],2,'.','')."</td>";
echo "<td>".number_format($totala[6],2,'.','')."</td>";
echo "<td>".number_format($totala[7],2,'.','')."</td>";
echo "<td style='background:#FAF9F9'>".number_format(($totala[2]+$totala[3]+$totala[4]+$totala[5]+$totala[6]+$totala[7]),2,'.','')."</td>";
echo "<td></td>";
echo "</tr>";

echo "</table>";

// --------------------------------------------------

function casilla($regant, $fila, $temp, $n, $campo, $total) {
	echo "<td class='col-01 ri'>";
	if ($regant != $fila['cod'] AND $fila[$campo] != 0) {
		echo $fila[$campo];
	}
	if ($temp[$n] > $fila[$campo]) {$class = "rojo b";}
	if ($temp[$n] < $fila[$campo]) {$class = "txth b";}
	if ($temp[$n] != $fila[$campo] AND $fila[$campo] != 0) {
		if (!$temp[$n]) {$temp[$n] = "0.00";}
		echo "<br><span class = '$class'>$temp[$n]</span>";
	}
	echo "</td>";
	if ($regant != $fila['cod']) {
			$total[$n] = $total[$n] + $fila[$campo];
	}
	return $total;
}

// --------------------------------------------------

function credareas($asigna,$curso,$area,$ilink) {
	$sql1 = "SELECT DISTINCT ct, cp, cte, cpr, cl, cs, ctu, ce, grupoa FROM podcursoasignaarea";
	$sql1 .= " WHERE asigna = '$asigna'";
	$sql1 .= " AND curso = '$curso'";
	$sql1 .= " AND area = '$area'";
	$result1 = $ilink->query($sql1);
	if ($result1) {$fila1 = $result1->fetch_array(MYSQLI_BOTH);}
	return $fila1;
}

// --------------------------------------------------

function formatear($num) {
	if (!$num OR $num ==0) {return "&nbsp;";}	
	return number_format($num,2,'.','');	
}
?>
