<?php

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

if (($accion == 'anaasgn' OR $accion == 'edasgn') AND (!$filtrocurso OR !$filtroarea)) {
	$mensaje = "<span class='rojo b'>&iexcl;ATENCI&Oacute;N! Para a&ntilde;adir o editar Asignaciones, seleccionar un ÀREA y un CURSO</span>";
	return;
}

if ($filtrocurso) {$soyadmitit = soyadmitit("",$filtrocurso,$ilink);}

if (!$soyadmitit) {return;}

?>

<script language="javascript">
function prueba(form1) {
	if (document.form1.edborrar.checked) {return confirm("<?php echo i("confirmborr",$ilink);?>");}
}

function funcanaed(form1)
{
	pos = form1.edcodigo1.value.split('*');
	form1.edct.value = pos[0];
	form1.edcp.value = pos[1];
	form1.edcte.value = pos[2];
	form1.edcpr.value = pos[3];
	form1.edcl.value = pos[4];
	form1.edcs.value = pos[5];
	form1.edctu.value = pos[6];
	form1.edce.value = pos[7];
	form1.edtipasig.value = pos[8];
	form1.edcodigo.value = pos[9];
	form1.quedct.value = (pos[0] - pos[10]).toFixed(2);
	form1.quedcp.value = (pos[1] - pos[11]).toFixed(2);
	form1.quedcte.value = (pos[2] - pos[12]).toFixed(2);
	form1.quedcpr.value = (pos[3] - pos[13]).toFixed(2);
	form1.quedcl.value = (pos[4] - pos[14]).toFixed(2);
	form1.quedcs.value = (pos[5] - pos[15]).toFixed(2);
	form1.quedctu.value = (pos[6] - pos[16]).toFixed(2);
	form1.quedce.value = (pos[7] - pos[17]).toFixed(2);
	//form1.edcodigo1.disabled = true
}
</script>

<?php

//-------------------- A S I G N A C I O N E S --------------------------- -->

if ($accion == 'edasgn1') {
	if ($edborrar == "on") {
		$mensaje = borrarasignacion($edid,$ilink);
	} else {
		$mensaje = editarasignacion($_POST,$ilink);
		if ($ventana) {$asigna = $edcodigo; $accion = "edasgn";}
	}
}

//------------------------------------------------------------------------ -->
if ($accion == 'anaasgn1') {
	$mensaje = anadirasignacion($_POST,$ilink);
	if ($ventana) {$asigna = $edcodigo; $grupo = $edgrupo; $accion = "anaasgn";}
}

//------------------------------------------------------------------------ -->//------------------------------------------------------------------------ -->

if ($accion == 'edasgn') {
	winop("EDITAR ASIGNACI&Oacute;N",'div1','');
	
	echo "<form action='?ord=$ord&$filtro' name='form1' method='post' onsubmit='return prueba(form1)'>";
	echo "<label>Asignatura</label><br>";
	$sql = "SELECT asignatprof.asigna, asignatura, asignatprof.curso, grupo, tipasig, usuid, ct, cp, cte, cpr, cl, cs, ctu, ce, area FROM asignatprof";
	$sql .= " LEFT JOIN podasignaturas ON asignatprof.asigna = podasignaturas.cod";
	$sql .= " LEFT JOIN podcursoasigna ON asignatprof.curso = podcursoasigna.curso AND asignatprof.asigna = podcursoasigna.asigna";
	$sql .= " WHERE id = '$edid'";
	$iresult = $ilink->query($sql);
	$f = $iresult->fetch_array(MYSQLI_BOTH);
	$temp = $f['asignatura']; if (strlen($temp) > 70) {$temp = substr($temp,0,70)."...";}
	echo "<input  class='col-10' type='text' value = '".$f['asigna']." - ".$temp."' size='70' maxlength='255' readonly='readonly'>";
	echo "<br>Curso <input class='col-1' type='text' value='".$f['curso']."' size='4' maxlength='4' readonly = 'readonly'>";
	echo " Grupo <input class='col-1' type='text' value='".$f['grupo']."' size='4' maxlength='4' readonly = 'readonly'>";
	echo " Semestre <input class='col-1' type='text' value='".$f['tipasig']."' size='1' readonly='readonly'>";
	$sql = "SELECT asigna, podareas.area, ct, cp, cte, cpr, cl, cs, ctu, ce, podareas.codarea FROM podcursoasignaarea";
	$sql .= " LEFT JOIN podareas ON podcursoasignaarea.area = podareas.codarea";
	$sql .= " WHERE curso = '".$f['curso']."' AND asigna = '".$f['asigna']."'";
	if ($filtroarea) {$sql .= " AND podareas.codarea = '$filtroarea'";}
	$result = $ilink->query($sql);
	while ($fila = $result->fetch_array(MYSQLI_BOTH)) {
		$temp = $fila['area']; if (strlen($temp) > 80) {$temp = substr($temp,0,80)."...";}
		$sql1 = "SELECT sum(asignatprof.ct), sum(asignatprof.cp), sum(asignatprof.cte), sum(asignatprof.cpr), sum(asignatprof.cl), sum(asignatprof.cs), sum(asignatprof.ctu), sum(asignatprof.ce) FROM asignatprof";
		$sql1 .= " LEFT JOIN podcursoasignaarea ON asignatprof.area = podcursoasignaarea.area AND asignatprof.asigna = podcursoasignaarea.asigna AND asignatprof.curso = podcursoasignaarea.curso";
		$sql1 .= " WHERE podcursoasignaarea.area = '".$fila['codarea']."' AND asignatprof.asigna='".$f['asigna']."' AND asignatprof.curso = '".$f['curso']."'";
		$iresult = $ilink->query($sql1);
		$sum = $iresult->fetch_array(MYSQLI_BOTH);
		echo "<br><span class='b'>".$temp."</span>";
		
	echo "<table>";

	cab('',0,0);
	echo "<tr>";
	echo "<td><input type='text' name='edct' size='5' maxlength='5' value= '".$fila['ct']."' readonly='readonly'></td>";
	echo "<td><input type='text' name='edcp' size='5' maxlength='5' value= '".$fila['cp']."' readonly='readonly'></td>";
	echo "<td><input type='text' name='edcte' size='5' maxlength='5' value= '".$fila['cte']."' readonly='readonly'></td>";
	echo "<td><input type='text' name='edcpr' size='5' maxlength='5' value= '".$fila['cpr']."' readonly='readonly'></td>";
	echo "<td><input type='text' name='edcl' size='5' maxlength='5' value= '".$fila['cl']."' readonly='readonly'></td>";
	echo "<td><input type='text' name='edcs' size='5' maxlength='5' value= '".$fila['cs']."' readonly='readonly'></td>";
	echo "<td><input type='text' name='edctu' size='5' maxlength='5' value= '".$fila['ctu']."' readonly='readonly'></td>";
	echo "<td><input type='text' name='edce' size='5' maxlength='5' value= '".$fila['ce']."' readonly='readonly'></td>";
	echo "</tr>";
	echo "<tr><td colspan='8'>Se pueden asignar:</td></tr>";
	echo "<tr>";
	echo "<td><input type='text' name='quedct' size='5' maxlength='5' value='".number_format($fila['ct'] - $sum[0],2,'.','')."' readonly='readonly'></td>";
	echo "<td><input type='text' name='quedcp' size='5' maxlength='5' value='".number_format($fila['cp'] - $sum[1],2,'.','')."' readonly='readonly'></td>";
	echo "<td><input type='text' name='quedcte' size='5' maxlength='5' value='".number_format($fila['cte'] - $sum[2],2,'.','')."' readonly='readonly'></td>";
	echo "<td><input type='text' name='quedcpr' size='5' maxlength='5' value='".number_format($fila['cpr'] - $sum[3],2,'.','')."' readonly='readonly'></td>";
	echo "<td><input type='text' name='quedcl' size='5' maxlength='5' value='".number_format($fila['cl'] - $sum[4],2,'.','')."' readonly='readonly'></td>";
	echo "<td><input type='text' name='quedcs' size='5' maxlength='5' value='".number_format($fila['cs'] - $sum[5],2,'.','')."' readonly='readonly'></td>";
	echo "<td><input type='text' name='quedctu' size='5' maxlength='5' value='".number_format($fila['ctu'] - $sum[6],2,'.','')."' readonly='readonly'></td>";
	echo "<td><input type='text' name='quedce' size='5' maxlength='5' value='".number_format($fila['ce'] - $sum[7],2,'.','')."' readonly='readonly'></td>";
	echo "</tr>";
	echo "</table>";
	if ($fila['codarea'] == $f['area']) {$area = $fila['area'];}
	}
	echo "<br>";
	echo "<label>Profesor</label> (".$area.")<br>";
	$sql = "SELECT DISTINCT usuarios.id, CONCAT(alumnoa,', ',alumnon), credmax, credmin,
		credasignados FROM usuarios
		LEFT JOIN profcurareafigura ON usuarios.id = profcurareafigura.profeid
		WHERE profcurareafigura.area = '$filtroarea' AND profcurareafigura.curso = '".$f['curso']."' AND fechabaja = '0000-00-00 00:00'
		ORDER BY alumnoa,alumnon";
	$result = $ilink->query($sql);
	echo "<select class='col-10' name='edprof'>";
	while ($fila = $result->fetch_array(MYSQLI_BOTH)) {
		echo "<option value='".$fila[0]."'";
		if ($fila[0] == $f['usuid']) {echo " selected='selected'";}
		echo ">";
		if ($fila[2] != 0 OR $fila[3] != 0 OR $fila[4] != 0) {echo "[$fila[2]] [$fila[3]] [$fila[4]] ";}
		echo $fila[1];
		echo "</option>";
	}
	echo "</select>";
	echo "<br><span class='txth'>[M&aacute;x.] [M&iacute;n.] [Asignados]</span> Profesor";

	echo "<table>";

	cab('1',0,1);
	echo "<tr>";
	echo "<td><input type='text' name='asigct' size='5' maxlength='5' value='".$f['ct']."' $read></td>";
	echo "<td><input type='text' name='asigcp' size='5' maxlength='5' value='".$f['cp']."' $read></td>";
	echo "<td><input type='text' name='asigcte' size='5' maxlength='5' value='".$f['cte']."' $read></td>";
	echo "<td><input type='text' name='asigcpr' size='5' maxlength='5' value='".$f['cpr']."' $read></td>";
	echo "<td><input type='text' name='asigcl' size='5' maxlength='5' value='".$f['cl']."' $read></td>";
	echo "<td><input type='text' name='asigcs' size='5' maxlength='5' value='".$f['cs']."' $read></td>";
	echo "<td><input type='text' name='asigctu' size='5' maxlength='5' value='".$f['ctu']."' $read></td>";
	echo "<td><input type='text' name='asigce' size='5' maxlength='5' value='".$f['ce']."' $read></td>";
	echo "</tr>";
	echo "</table>";

	echo "<input type='hidden' name='accion' value='edasgn1'>";
	echo "<input type='hidden' name='edid' value='$edid'>";
	echo "<span class='rojo b'>BORRAR <input type='checkbox' name='edborrar'></span>";
	echo "<input  class='col-2' type='submit' value=\"".i("agvalid",$ilink)."\">";
	$temp = ""; if ($ventana) {$temp = "checked='checked'";}
	echo "<div class='fr'>Mantener ventana <input type='checkbox' name='ventana' $temp></div>";
	echo "<input type='hidden' name='ventana1' value='1'>";
	echo "</form>";
	echo "</div></div>";
}

//------------------------------------------------------------------------ -->

if ($accion == 'anaasgn') {

	$sql = "SELECT DISTINCT podcursoasigna.asigna, asignatura, podcursoasignaarea.ct, podcursoasignaarea.cp, podcursoasignaarea.cte, podcursoasignaarea.cpr, podcursoasignaarea.cl, podcursoasignaarea.cs, podcursoasignaarea.ctu, podcursoasignaarea.ce, tipasig,
		sum(asignatprof.ct) AS sumct, sum(asignatprof.cp) AS sumcp, sum(asignatprof.cte) AS sumcte, sum(asignatprof.cpr) AS sumcpr, sum(asignatprof.cl) AS sumcl, sum(asignatprof.cs) AS sumcs, sum(asignatprof.ctu) AS sumctu, sum(asignatprof.ce) AS sumce, grupo
		FROM podcursoasignaarea
		LEFT JOIN podcursoasigna ON podcursoasignaarea.curso = podcursoasigna.curso AND podcursoasignaarea.asigna = podcursoasigna.asigna
		LEFT JOIN podasignaturas ON podcursoasignaarea.asigna = podasignaturas.cod";
	if ($_SESSION['auto'] < 10) {
		$sql .= " LEFT JOIN podcursoasignatit ON podcursoasignatit.asigna = podcursoasigna.asigna AND podcursoasignatit.curso = podcursoasigna.curso
			LEFT JOIN titcuradmi ON podcursoasignatit.tit = titcuradmi.titulaci AND podcursoasignatit.curso = titcuradmi.curso";
	}
	$sql .= " LEFT JOIN asignatprof ON podcursoasignaarea.curso = asignatprof.curso AND
		podcursoasignaarea.asigna = asignatprof.asigna AND
		podcursoasignaarea.area = asignatprof.area 
		WHERE podcursoasignaarea.curso = '".trim($filtrocurso)."'
		AND podcursoasignaarea.area = '$filtroarea'";
	if ($_SESSION['auto'] < 10) {
		$sql .= " AND titcuradmi.usuid = '".$_SESSION['usuid']."'";
	}
	$sql .= " GROUP BY podcursoasigna.asigna ORDER BY asignatura";
	$result = $ilink->query($sql);
	if (!$result->num_rows) {
		echo "<span class='rojo b'>No hay Asignaturas para esa selecci&oacute;n.</span>";
		return;
	}
	
	winop("A&Ntilde;ADIR ASIGNACI&Oacute;N",'div1','');
	echo "<form action='?ord=$ord&$filtro' name='form1' method='post'>";
	echo "<label>Asignatura</label><br>";
	echo "<input type='hidden' name='edcodigo'>";
	echo "<input type='hidden' name='edcurso' value ='".trim($filtrocurso)."'>";
	echo "<input type='hidden' name='edarea' value = '$filtroarea'>";
	echo "<select class='col-10' name='edcodigo1' onfocus='funcanaed(form1)' onchange='funcanaed(form1)'>";
	while ($fila = $result->fetch_array(MYSQLI_BOTH)) {
		echo "<option value='$fila[2]*$fila[3]*$fila[4]*$fila[5]*$fila[6]*$fila[7]*$fila[8]*$fila[9]*$fila[10]*$fila[0]*$fila[11]*$fila[12]*$fila[13]*$fila[14]*$fila[15]*$fila[16]*$fila[17]*$fila[18]'";
		$temp = $fila[1]; if (strlen($temp) > 80) {$temp = substr($temp,0,80)."...";}
		//Si a&ntilde;ado la Asignaci&oacute;n desde la opcion de Asignaturas
		if ($asigna AND $fila[0] == $asigna) {echo " selected='selected'";}
		echo ">$fila[0] - $temp</option>";
	}
	echo "</select>";
	echo "<br >Curso <input class='col-1' type='text' size='4' maxlength='4' value='".trim($filtrocurso)."' readonly='readonly'>";
	echo " Grupo <input class='col-1' type='text' name='edgrupo' size='4' maxlength='4' value='$grupo'>";
	echo " Semestre <input class='col-1' type='text' name='edtipasig' size='1' readonly='readonly'><br>";
	echo "<table>";
	cab('',0,0);
	echo "<tr>";
	echo "<td><input type='text' name='edct' size='5' maxlength='5' readonly='readonly'></td>";
	echo "<td><input type='text' name='edcp' size='5' maxlength='5' readonly='readonly'></td>";
	echo "<td><input type='text' name='edcte' size='5' maxlength='5' readonly='readonly'></td>";
	echo "<td><input type='text' name='edcpr' size='5' maxlength='5' readonly='readonly'></td>";
	echo "<td><input type='text' name='edcl' size='5' maxlength='5' readonly='readonly'></td>";
	echo "<td><input type='text' name='edcs' size='5' maxlength='5' readonly='readonly'></td>";
	echo "<td><input type='text' name='edctu' size='5' maxlength='5' readonly='readonly'></td>";
	echo "<td><input type='text' name='edce' size='5' maxlength='5' readonly='readonly'></td>";
	echo "</tr>";
	echo "<tr><td colspan='8'>Se pueden asignar:</td></tr>";
	echo "<tr>";
	echo "<td><input type='text' name='quedct' size='5' maxlength='5' readonly='readonly'></td>";
	echo "<td><input type='text' name='quedcp' size='5' maxlength='5' readonly='readonly'></td>";
	echo "<td><input type='text' name='quedcte' size='5' maxlength='5' readonly='readonly'></td>";
	echo "<td><input type='text' name='quedcpr' size='5' maxlength='5' readonly='readonly'></td>";
	echo "<td><input type='text' name='quedcl' size='5' maxlength='5' readonly='readonly'></td>";
	echo "<td><input type='text' name='quedcs' size='5' maxlength='5' readonly='readonly'></td>";
	echo "<td><input type='text' name='quedctu' size='5' maxlength='5' readonly='readonly'></td>";
	echo "<td><input type='text' name='quedce' size='5' maxlength='5' readonly='readonly'></td>";
	echo "</tr>";
	echo "</table>";

	echo "<label>Profesor</label><br>";
	$sql = "SELECT profeid, CONCAT(alumnoa,', ',alumnon), credmax, credmin, credasignados
		FROM profcurareafigura
		LEFT JOIN usuarios ON profeid = id WHERE curso = '".trim($filtrocurso)."'
		AND area = '$filtroarea'
		ORDER BY alumnoa, alumnon";
	$result = $ilink->query($sql);
	echo "<select class='col-10' name='ednombreprof'>";
	while ($fila = $result->fetch_array(MYSQLI_BOTH)) {
		echo "<option value='$fila[0]'";
		if ($fila['profeid'] == $filtroprof) {echo " selected='selected'";}
		echo ">";
		if ($fila[2] != 0 OR $fila[3] != 0 OR $fila[4] != 0) {echo "[$fila[2]] [$fila[3]] [$fila[4]] ";}
		echo $fila[1]."</option>";
	}
	echo "</select>";
	echo "<br><span class='txth'>[M&aacute;x.] [M&iacute;n.] [Asignados]</span> Profesor";
	echo "<table>";
	cab('1',0,1);
	echo "<tr>";
	echo "<td><input type='text' name='asigct' size='5' maxlength='5' $read></td>";
	echo "<td><input type='text' name='asigcp' size='5' maxlength='5' $read></td>";
	echo "<td><input type='text' name='asigcte' size='5' maxlength='5' $read></td>";
	echo "<td><input type='text' name='asigcpr' size='5' maxlength='5' $read></td>";
	echo "<td><input type='text' name='asigcl' size='5' maxlength='5' $read></td>";
	echo "<td><input type='text' name='asigcs' size='5' maxlength='5' $read></td>";
	echo "<td><input type='text' name='asigctu' size='5' maxlength='5' $read></td>";
	echo "<td><input type='text' name='asigce' size='5' maxlength='5' $read></td>";
	echo "</tr>";
	echo "</table>";

	echo "<input type='hidden' name='accion' value='anaasgn1'> <input class='col-2' class='mediana' type='submit' value=\"Asignar\">";
	$temp = ""; if ($ventana) {$temp = "checked='checked'";}
	echo "<div class='fr'>Mantener ventana <input type='checkbox' name='ventana' $temp></div>";
	echo "<input type='hidden' name='ventana1' value='1'>";
	echo "</fieldset></form>";
	echo "</div></div>";
	
}

?>