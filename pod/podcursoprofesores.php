<?php

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

// -------------------------------------------------- PROFESORES // --------------------------------------------------

$ord = $_GET['ord'];

if ($accion) { // OR $recalc
	require_once APP_DIR . "/pod/podtablasmodif.php";
}

// --------------------------------------------------

if ($borrar) {
	$mensaje = borrarcursoprof($_POST,$ilink);
	$accion = "";
}

if ($accion == 'anadir1') {
	$mensaje = anadircursoprof($_POST,$ilink);
	if (!$mensaje) {
		$profeid = $id;
		$cursoid = $curso;
		$accion = "editar";
	}
}

if ($accion == 'editar1') {
	$mensaje = modifcursoprof($_POST,$ilink);
	if ($ventana) {$accion = 'editar';}
}


// --------------------------------------------------

if ($filtrocurso) {
	$filtro1 .= " AND profcurareafigura.curso = '".trim($filtrocurso)."'";
}

if ($filtroarea) {
	$filtro1 .= " AND profcurareafigura.area = '$filtroarea'";
}

if ($filtroprof) {
	$filtro1 .= " AND profcurareafigura.profeid = '$filtroprof'";
}

$listaprofes = "SELECT DISTINCT profeid AS id";
$listaprofes .= ", podfiguras.cod, podfiguras.figura, podcursofigura.creditos, profcurareafigura.area,";
$listaprofes .= " profcurareafigura.curso, examenes, exacum, n_prof,";
$listaprofes .= " profcurareafigura.telefono, telefono1, profcurareafigura.despacho, tfmovil1,";
$listaprofes .= " podcursofigura.creditosmin, podcursofigura.tiempo, obs, obs2, mail2,";
$listaprofes .= " profcurareafigura.doctor, credasignados "; //reduccio, 
$listaprofes .= " FROM profcurareafigura";
$listaprofes .= " LEFT JOIN usuarios ON profcurareafigura.profeid = usuarios.id";
$listaprofes .= " LEFT JOIN podcursofigura ON profcurareafigura.figura = podcursofigura.codfigura AND profcurareafigura.curso = podcursofigura.curso";
$listaprofes .= " LEFT JOIN podfiguras ON podcursofigura.codfigura = podfiguras.cod";
$listaprofes .= " WHERE 1=1 ".$filtro1;

// -------------------------------------------------- MODIFICAR / A&Ntilde;ADIR PROFESOR - CURSO // --------------------------------------------------

if ($accion == 'anadir' AND $filtrocurso) {
	winop("A&Ntilde;ADIR PROFESOR - CURSO",'div1','');
	echo $mens1;
	echo "<form name='form1' method='post'>";
	echo "<label>Curso</label><br><input class='col-3' type='text' name='curso' size='4' maxlength='4' value='$filtrocurso' readonly='readonly'><br>";
	$sql = "SELECT id, CONCAT(alumnoa, ', ',alumnon) FROM usuarios WHERE tipo='P' AND autorizado > 4 AND fechabaja = '0000-00-00 00:00' ORDER BY alumnoa, alumnon";
	$result = $ilink->query($sql);
	echo "Profesores<br><select class='col-10' name='id'>";
	while ($fila = $result->fetch_array(MYSQLI_BOTH)) {
		echo "<option value='$fila[0]'>$fila[1]</option>";
	}
	echo "</select><br>";
	echo "<label>Figura</label><br>";
	$sql = "SELECT * FROM podcursofigura LEFT JOIN podfiguras ON podcursofigura.codfigura=podfiguras.cod WHERE curso = '$filtrocurso'";
	$result = $ilink->query($sql);
	echo "<select class='col-10' name='figura'>";
	while ($fila = $result->fetch_array(MYSQLI_BOTH)) {
		echo "<option value = '".$fila['codfigura']."'";
		$temp = $fila['figura']; if (strlen($temp) > 79) {$temp = substr($temp,0,80)."...";}
		echo ">$temp</option>";
	}
	echo "</select><br>";
	echo "<label>&Aacute;rea</label><br><select class='col-10' name='area'>";
	$r = $ilink->query("SELECT * FROM podareas ORDER BY area");
	while ($f = $r->fetch_array(MYSQLI_BOTH)) {
		echo "<option value = ".$f['codarea'];
		if ($f['codarea'] == $filtroarea) {echo " selected='selected'";}
		$temp = $f['area']; if (strlen($temp) > 79) {$temp = substr($temp,0,80)."...";}
		echo ">$temp</option>";
	}
	echo "</select><br>";
	echo "<input type='hidden' name='accion' value='anadir1'>";
	echo "<input class='col-2' type='submit' value=\"".i("anadir1",$ilink)."\">";
	echo "</form>";
	echo "</div></div>";
}

// --------------------------------------------------

if ($accion == 'editar') {
	winop(i("edicion",$ilink),'div1','');
	echo "<div class='peq'><form enctype='multipart/form-data' name='form1' method='post' onsubmit='return prueba(form1)'>";
	$profesor1 = $listaprofes." AND usuarios.id = '$profeid' AND profcurareafigura.curso = '$cursoid'";
	$iresult = $ilink->query($profesor1);
	$profesor = $iresult->fetch_array(MYSQLI_BOTH);
	echo "Curso ";
	$iresult = $ilink->query("SELECT sexo FROM usuarios WHERE id = '$profeid' LIMIT 1");
	$sexo = $iresult->fetch_array(MYSQLI_BOTH);
	echo "<input type='hidden' name='cursoid' value='$cursoid'>";
	echo "<input type='hidden' value='$profeid'>";
	echo " <input class='col-4em' type='text' value='$cursoid' size='4' readonly='readonly'>";
	if ($sexo[0]=='h' OR !$sexo[0]) {$temp = "Doctor";}
	if ($sexo[0]=='m') {$temp = "Doctora";}
	echo " &nbsp; <input type = 'checkbox' name = 'doctor'";
	if ($profesor['doctor']) {echo " checked = 'checked'";}
	echo "> Es $temp en este curso.";
	if (!$sexo[0]) {echo " <span class='rojo b'>&iexcl;Atenci&oacute;n! Indicar si es hombre o mujer en su ficha personal.</span>";}
	echo "<br>Profesor ";
	echo "<input type='text' value='".nomb1($profeid,$ilink)."' size='80' readonly='readonly'><br>";
	echo "Figura ";
	echo "<select class='col-4' name='figura'>";
	$result = $ilink->query("SELECT codfigura, figura FROM podcursofigura LEFT JOIN podfiguras ON podcursofigura.codfigura=podfiguras.cod WHERE curso = '$cursoid'");
	while ($fila = $result->fetch_array(MYSQLI_BOTH)) {
		echo "<option value = '".$fila[0]."'";
		if ($fila[0] == $profesor['cod']) {echo " selected = 'selected'";}
		$temp = $fila[1]; if (strlen($temp) > 79) {$temp = substr($temp,0,80)."...";}
		echo ">$temp</option>";
	}
	echo "</select> ";
	echo "&Aacute;rea <select class='col-4' name='area'>";
	$r = $ilink->query("SELECT * FROM podareas ORDER BY area");
	while ($f = $r->fetch_array(MYSQLI_BOTH)) {
		echo "<option value = ".$f['codarea'];
		if ($f['codarea'] == $profesor['area']) {echo " selected='selected'";}
		$temp = $f['area']; if (strlen($temp) > 79) {$temp = substr($temp,0,80)."...";}
		echo ">$temp</option>";
	}
	echo "</select>";

	// -------------------------------------------------- CARGOS // --------------------------------------------------
	
	echo "<br>Cargos<br>";
	$cargos = "SELECT cargo, tipo FROM profecargos";
	$cargos .= " LEFT JOIN podcargos ON profecargos.cargo = podcargos.cod";
	$cargos .= " WHERE profeid = '$profeid' AND curso = '$cursoid'";
	$cargos .= " ORDER BY tipo";
	
	$result1 = $ilink->query($cargos);
	$numcargos = $result1->num_rows;
	$cargos = "";
	$i = 0;
	while ($fila1 = $result1->fetch_array(MYSQLI_BOTH)) {
		$cargos[$i][0] = $fila1[0];		
		$cargos[$i][1] = $fila1[1];
		$i++;		
	}
  	$i = 0;
  	while($i < $numcargos) {
  		$sql = "SELECT codcargo, tipo FROM podcursocargos";
  		$sql .= " LEFT JOIN podcargos ON podcursocargos.codcargo = podcargos.cod";
  		$sql .= " WHERE curso = '$cursoid' ORDER BY tipo";
		$result2 = $ilink->query($sql);
		echo "<select class='col-4' name='cargo$i'>";
		while ($fila2 = $result2->fetch_array(MYSQLI_BOTH)) {
			echo "<option value='$fila2[0]'";
			if ($fila2[0] == $cargos[$i][0]) {echo " selected = 'selected'";}
			$temp = $fila2[1]; if (strlen($temp) > 79) {$temp = substr($temp,0,80)."...";}
			echo ">$temp</option>";
		}
		echo "</select> <input type='checkbox' name='borrcargo$i'> <span class='rojo b'>".i("borrarfich",$ilink)."</span><br>";
		$i++;
	}
	$sql = "SELECT codcargo, tipo FROM podcursocargos";
	$sql .= " LEFT JOIN podcargos ON podcursocargos.codcargo = podcargos.cod";
	$sql .= " WHERE curso = '$cursoid' ORDER BY tipo";
	$result2 = $ilink->query($sql);
	echo "<select class='col-4' name='cargoanadir'><option value=''>A&Ntilde;ADIR CARGO</option>";
	while ($fila2 = $result2->fetch_array(MYSQLI_BOTH)) {
		echo "<option value='$fila2[0]'>";
		$temp = $fila2[1]; if (strlen($temp) > 79) {$temp = substr($temp,0,80)."...";}
		echo $temp;
		echo "</option>";
	}
	echo "</select>";

// --------------------------------------------------
	
	echo "<br><span class='mediana txth b'>Otros datos del PROFESOR - CURSO</span><br>";
	echo "<label>Examenes</label><br><input class='col-10' value='".$profesor['examenes']."' type='text' name='examenes' size='30' maxlength='30'><br>";
	echo "<label>Exacum</label><br><input class='col-10' value='".$profesor['exacum']."' type='text' name='exacum' size='30' maxlength='30'><br>";
	echo "<label>N_prof</label><br><input class='col-10' value='".$profesor['n_prof']."' type='text' name='n_prof' size='30' maxlength='30'><br>";
	echo "<label>Observaciones</label><br><input class='col-10' value='".$profesor['obs']."' type='text' name='obs' size='50' maxlength='255'><br>";
	echo "<label>Observaciones1</label><br><input class='col-10' value='".$profesor['obs2']."' type='text' name='obs2' size='50' maxlength='255'><br>";
	echo "<label>Mail2</label><br><input class='col-10' value='".$profesor['mail2']."' type='text' name='mail2' size='50' maxlength='50'><br>";
	echo "<label>Tel&eacute;fono1</label><br><input class='col-10' value='".$profesor['telefono']."' type='text' name='telefono' size='15' maxlength='15'><br>";
	echo "<label>Tel&eacute;fono2</label><br><input class='col-10' value='".$profesor['telefono1']."' type='text' name='telefono1' size='15' maxlength='15'><br>";
	echo "<label>Despacho</label><br><input class='col-10' value='".$profesor['despacho']."' type='text' name='despacho' size='50' maxlength='50'><br>";
	echo "<input type='hidden' name='accion' value='editar1'>";
	echo "<input type='hidden' name='profeid' value='$profeid'>";
	echo "<span class='rojo b'>BORRAR <input type='checkbox' name='borrar'></span>";
	echo " <input class='col-2' type='submit' value=\"".i("agvalid",$ilink)."\">";
	$temp = ""; if ($ventana) {$temp = "checked='checked'";}
	echo "<div class='fr'>Mantener ventana <input type='checkbox' name='ventana' $temp></div>";
	echo "<input type='hidden' name='ventana1' value='1'>";
	echo "</fieldset>";
	echo "</form>";
	echo "</div></div></div>";
}

// --------------------------------------------------

if (!$ord) {$ord = "usuarios.alumnoa,usuarios.alumnon,curso";}

if ($filtrocurso) {
	$iresult = $ilink->query($listaprofes." AND tiempo = 1");
	$tp = $iresult->num_rows;
	$iresult = $ilink->query($listaprofes." AND tiempo = 2");
	$tc = $iresult->num_rows;
	if($tp OR $tc) {echo "<br>";}
	if ($tp) {echo "A Tiempo Parcial: ".$tp.". ";}
	if ($tc) {echo " A Tiempo Completo: ".$tc.". ";}
}

$listaprofes .= " ORDER BY $ord";
$result = $ilink->query($listaprofes);

if ($_SESSION['auto'] == 10 AND !$filtrocurso AND $accion ==  'anadir') {
	echo "<span class='rojo b'>&iexcl;ATENCI&Oacute;N! para a&ntilde;adir un PROFESOR a un CURSO, seleccionar un CURSO.</span>";
	if ($mensaje) {echo "<br>";}
}

echo $mensaje;

echo "<table class='tancha conhover'>";

echo "<tr>";
echo "<th class='col-01'><a href='?ord=&pest=$pest&pest1=$pest1'>Curso</a>";
if ($_SESSION['auto'] == 10) {
	echo "<br><a href='?ord=$ord&accion=anadir&pest=$pest&pest1=$pest1'>A&ntilde;adir</a>";
}
echo "</th>";
echo "<th><a href='?$filtro'>Profesor</a>";
echo "</th>";
echo "<th><a href='?ord=figura&$filtro' class='b'>Figura</a><br>Cargos</th>";
echo "<th class='col-01 nowrap'><a href='?ord=creditos&$filtro'>Cred.Max.</a><br><a href='?ord=creditosmin&$filtro'>Cred.Min.</a></th>";
echo "<th>Reducciones</th>";
echo "<th>Cred. Asignad.</th><th>Cred. por asignar</th>";
echo "</tr>";
while ($fila = $result->fetch_array(MYSQLI_BOTH)) {
	echo "<tr>";
	echo "<td>";
	$temp = $fila['curso']; if (!trim($temp)) {$temp="Indef.";}
	if ($_SESSION['auto'] == 10) {
		echo "<a href='?ord=$ord&accion=editar&$filtro";
		echo "&cursoid=".$fila['curso']."&profeid=".$fila['id']."' title='Editar'>";	
		echo $temp."</a>";
	} else {
		echo $temp;
	}
	echo "</td>";
	echo "<td class='nowrap'>";
		$usu = ponerusu($fila['id'],1,$ilink);
		echo $usu[0].$usu[1];
	echo "<br>";
	if ($fila['mail2']) {echo "Mail: <a href='mailto:".$fila['mail2']."'>".$fila['mail2']."</a><br>";}
	if ($fila['telefono']) {echo "Tel&eacute;fono1: ".$fila['telefono']."<br>";}
	if ($fila['telefono1'] AND (!$fila['notf'] OR $ver)) {echo "Tel&eacute;fono2: ".$fila['telefono1']."<br>";}
	if ($fila['despacho']) {echo "Despacho: ".$fila['despacho']."<br>";}
	echo "</td>";
	$tiempo = "";
	if ($fila['tiempo'] == 1) {$tiempo = "Parcial"; $span='rojo b';}
	if ($fila['tiempo'] == 2) {$tiempo = "Completo"; $span='txth b';}
	echo "<td class='nowrap'><span class='b'>".$fila['figura']."</span><br>"; //<span class='$span'>".$tiempo."</span>
	$sql1 = "SELECT tipo FROM profecargos
		LEFT JOIN podcursocargos ON profecargos.curso = podcursocargos.curso 
		AND profecargos.cargo = podcursocargos.codcargo
		LEFT JOIN podcargos ON podcursocargos.codcargo = podcargos.cod
		WHERE profecargos.curso = '".$fila['curso']."' AND profecargos.profeid = '".$fila['id']."'";
	$result1 = $ilink->query($sql1);
	if ($result1->num_rows > 0) {
		while ($fila1 = $result1->fetch_array(MYSQLI_BOTH)) {
			echo $fila1[0]."<br>";
		}
	} 
	echo "</td>";
	echo "<td class='col-01 center nowrap'>".$fila['creditos']."<br>".$fila['creditosmin']."</td>";
	echo "<td class='col-01 nowrap ri'>";
	$creditos = "SELECT SUM(creditos) AS sum FROM podcursocargos";
	$creditos .= " LEFT JOIN profecargos ON podcursocargos.codcargo = profecargos.cargo AND podcursocargos.curso = profecargos.curso";
	$creditos .= " WHERE profecargos.profeid = '".$fila['id']."' AND profecargos.curso = '".$fila['curso']."'";
	$result1 = $ilink->query($creditos);
	$creditos = $result1->fetch_array(MYSQLI_BOTH);
	$reducc = $creditos[0];
	echo $reducc;		
	echo "</td>";
	echo "<td class='col-01 ri rojo'>";
	$asignados = $fila['credasignados'];
	if ($asignados) {echo $asignados;}
	echo "</td>";
	echo "<td class='col-01 ri'>";
	$tot = $fila['creditosmin'] - $reducc - $asignados;
	if ($tot > 0) {
		$span = "rojo b";
	} else {
		if ($fila['creditos'] - $reducc >= $asignados) {
			$span = "";
		} else {
			$span = "txth b";
			$exceso = ($fila['creditos'] - $reducc - $asignados);
			$exceso = "<br>(".number_format($exceso,2,'.','').")";
		}
	}
	if ($tot) {echo "<span class='$span'>".number_format($tot,2,'.','')."</span>".$exceso;} else {echo "<span class='txth b'>OK!</span>";}
	$exceso = "";
	echo "</td>";
	echo "</tr>";
	
	
	$cmax = $cmax + $fila['creditos'];
	$cmin = $cmin + $fila['creditosmin'];
	$reduccio = $reduccio + $reducc;
	$credasig = $credasig + $asignados;
	$credporas = $credporas + $tot;
	
}

echo "<tr>";
echo "<td class='ri col-01' colspan='3'>";
echo " Totales </td>";
echo "<td class='col-01 nowrap center'>".number_format($cmax,2,'.','')."<br>".number_format($cmin,2,'.','')."</td>";
echo "<td class='ri'>".number_format($reduccio,2,'.','')."</td>";
echo "<td class='ri'>".number_format($credasig,2,'.','')."</td><td class='ri'>".number_format($credporas,2,'.','')."</td>";
echo "</tr>";

echo "</table>";

?>
