<?php

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

?>

<script language="JavaScript">
<!--
var era;
var previo=null;
function uncheckRadio(rbutton){
if(previo &&previo!=rbutton){previo.era=false;}
if(rbutton.checked==true && rbutton.era==true){rbutton.checked=false;}
rbutton.era=rbutton.checked;
previo=rbutton;
}
//-->
</script>

<?php

function listar($asigna,$curso,$grupo,$automodif,$enti,$ilink) {
	
	$filtroenti = $_POST['filtroenti'];
	$filtroenti1 = $_POST['filtroenti1'];
	if ($filtroenti1) {$filtroenti = $filtroenti1;}
	
	if ($filtroenti == 2) {$filtro = " AND ofertado = '1'";}	
	
	if (!$enti) {
		$sql = "SELECT *, convenios.n AS nx FROM convenios LEFT JOIN conventid ON
	 	convenios.entidad = conventid.n
	 	WHERE asigna = '$asigna' AND curso = '$curso' AND grupo = '$grupo' $filtro ORDER BY pais, plazadescrip";
	} else {
		$sql = "SELECT *, convenios.n AS nx FROM convenios LEFT JOIN conventid ON
	 	convenios.entidad = conventid.n
	 	WHERE entidad = '$enti' $filtro ORDER BY curso DESC, asigna, grupo";
	}
	
	echo "<table class='conhover'>";

	echo "<tr>";

	if ($automodif) {
		echo "<th class='col-01'>";
		if (!$enti) {echo "<a href='?pest=11&apli=2&ana=1'>A&ntilde;adir</a>";}
		echo "</th>";
	}

	if (!$enti) {echo "<th class='col-1'>Visible por los Alumnos</th>";}

	echo "<th class='col-1'>Ofertada por la Entidad</th>";

	echo "<th class='col-3'>Plaza";
	echo "<form method='post'> &nbsp; &nbsp; <select name='filtroenti'>";
	echo "<option value=1";
	if ($filtroenti == 1 OR !$filtroenti) {echo " selected = 'selected'";}
	echo ">Todas</option>";
	echo "<option value=2";
	if ($filtroenti == 2) {echo " selected = 'selected'";}
	echo ">Ofertadas por la Entidad</option>";
	echo "</select> <input class='col-1' type='submit' value=' >> '>";
	echo "</form>";
	echo "</th>";

	if (!$enti) {echo "<th class='col-5 nowrap'>Solicitudes<br><span class='b'>&nbsp; preferencia: de 1 (m&aacute;xima preferencia) a 3&nbsp;</span></th>";}

	echo "</tr>";

// --------------------------------------------------

	$result = $ilink->query($sql);
	
	if (!$result) {echo "</table>"; return;}
	
	while ($fila = $result->fetch_array(MYSQLI_BOTH)) {
		extract($fila);
		
		echo "<tr>";
		
		if ($automodif) {
			echo "<td class='col-1'><a href='?pest=11&apli=2&ed=$nx'>Editar</a></td>";
		}
		
		if (!$enti) {
			if ($visible) {$temp = "S&iacute;";} else {$temp = "No";}
			echo "<td class='col-1'>";
			echo "<form method='post'>";
			echo "<input type='hidden' name='conveniovisi' value='$nx'>";
			echo "<input type='checkbox' name='visible'";
			if ($fila['visible']) {echo " checked='checked'";}
			echo ">";
			if ($automodif) {
				echo " <input class='col-3 peq' type='submit' value=' >> ' name='submvisi'>";
			}
			echo "<input type='hidden' name = 'filtroenti1' value = '$filtroenti'>";
			echo "</form>";
			echo "</td>";
		}
		
		echo "<td class='col-1'>";
		echo "<form method='post'>";
		echo "<input type='hidden' name='convenioofertado' value='$nx'>";
		echo "<input type='checkbox' name='ofertado'";
		if ($fila['ofertado']) {echo " checked='checked'";}
		echo ">";
		if ($automodif) {
			echo " <input class='col-3 peq' type='submit' value=' >> ' name='submofert'>";
		}
		echo "<input type='hidden' name = 'filtroenti1' value = '$filtroenti'>";
		echo "</form>";
		echo "</td>";

		echo "<td class='col-6'>";
		echo "$nombre<br><span class=''>$pais</span><br>";
		if ($enti) {echo "<span class='rojo'>$curso</span> ";}
		echo "Plazas: $numplazas $tipplaza";
		echo " &nbsp;<a class='nob peq' onclick=\"amplred('pl$nx')\">Ampliar / Reducir</a><br>";
		echo "<div style='display:none' id='pl$nx'>".nl2br($plazadescrip)."</div></td>";

		if (!$enti) {
		echo "<td>";
		$sql1 = "SELECT alumno, preferencia, aceptada, convenio FROM convsolicitudes WHERE convenio = '$nx'";
		$result1 = $ilink->query($sql1);
		if ($result1->num_rows) {
			echo "<hr>";
			while ($fila1 = $result1->fetch_array(MYSQLI_BOTH)) {
				echo "<form class='peq b' method='post'>";
				echo "<input type='hidden' name = 'filtroenti1' value = '$filtroenti'>";
				echo "<input type='hidden' name='solicconv' value='$fila1[3]'>";
				echo "<input type='hidden' name='solicalum' value='$fila1[0]'>";
				echo "<select name='elecc'>";
				echo "<option value='*' ";
				if ($fila1[1] == 0) {echo "selected='selected'";}
				echo ">0</option>";
				echo "<option value='1' ";
				if ($fila1[1] == 1) {echo "selected='selected'";}
				echo ">1</option>";
				echo "<option value='2' ";
				if ($fila1[1] == 2) {echo "selected='selected'";}
				echo ">2</option>";
				echo "<option value='3' ";
				if ($fila1[1] == 3) {echo "selected='selected'";}
				echo ">3</option>";
				echo "</select>";
				echo "<input type='checkbox' name='soliccheck'";
				if ($fila1[2]) {echo " checked='checked'";}
				echo "> ACEPTADA";
				if ($automodif) {
					echo " <input class='col-3' type='submit' name='solicitud' value=' >> '>";
				}
				echo "</form>";
				$usu = ponerusu($fila1[0],1,$ilink);
				echo $usu[0].$usu[1];
				echo "<p class='both'></p>";
			}
			echo "<hr class='both'>";
		}
		echo "</td>";
		}

		echo "</tr>";

	}

	echo "</table>";

}

// --------------------------------------------------

function listarapel($asigna,$curso,$grupo,$automodif,$enti,$ilink) {
	
	if ($enti) {return;}

	$sql = "SELECT *, convenios.n AS nx FROM convenios LEFT JOIN conventid ON convenios.entidad = conventid.n
	WHERE asigna = '$asigna' AND curso = '$curso' AND grupo = '$grupo' ORDER BY pais, plazadescrip";
	$result = $ilink->query($sql);
	
	while ($fila = $result->fetch_array(MYSQLI_BOTH)) {
		if (!strpos($convenio.",",",".$fila['nx'].",")) {
			$convenio .= ",".$fila['nx'];
		}
	}

	if(!$convenio) {return;}
	
	$convenio = substr($convenio,1);

	$sql = "SELECT *, convenios.n AS nx FROM convsolicitudes LEFT JOIN usuarios ON usuarios.id  = alumno
	LEFT JOIN convenios ON convsolicitudes.convenio = convenios.n LEFT JOIN conventid ON convenios.entidad = conventid.n
	WHERE convenio IN ($convenio) ORDER BY alumnoa, alumnon, preferencia";
		
	echo "<table class='conhover'>";
	echo "<tr>";
	if ($automodif) {
		echo "<th class='col-01'>";
		if (!$enti) {echo "<a href='?pest=11&apli=2&ana=1'>A&ntilde;adir</a>";}
		echo "</th>";
	}
	if (!$enti) {echo "<th class='col-01'>Visible por los Alumnos</th>";}
	if (!$enti) {echo "<th class='col-01'>Ofertada por la Entidad</th>";}
	echo "<th class='col-3'>Plaza</th>";
	if (!$enti) {echo "<th class='col-5 nowrap'>Solicitudes<br><span class='b'>&nbsp; preferencia: de 1 (m&aacute;xima preferencia) a 3&nbsp;</span></th>";}
	echo "</tr>";
	$result = $ilink->query($sql);
	
	if (!$result) {echo "</table>"; return;}
	
	while ($fila = $result->fetch_array(MYSQLI_BOTH)) {
	
		extract($fila);
		echo "<tr>";
		
		
		if ($automodif) {
			echo "<td><a href='?pest=11&apli=2&ed=$nx'>Editar</a></td>";
		}
		if (!$enti) {
			//if ($visible) {$temp = "S&iacute;";} else {$temp = "No";}
			echo "<td>";
			echo "<form method='post'>";
			echo "<input type='hidden' name='conveniovisi' value='$nx'>";
			echo "<input type='checkbox' name='visible' disabled='disabled'";
			if ($fila['visible']) {echo " checked='checked'";}
			echo ">";
			echo "</form>";
			echo "</td>";
			//if ($visible) {$temp = "S&iacute;";} else {$temp = "No";}
			echo "<td>";
			echo "<form method='post'>";
			echo "<input type='hidden' name='convenioofer' value='$nx'>";
			echo "<input type='checkbox' name='ofertado' disabled='disabled'";
			if ($fila['ofertado']) {echo " checked='checked'";}
			echo ">";
			echo "</form>";
			echo "</td>";
		}
		echo "<td>";
		if ($mientras != $fila['alumno']) {echo "<hr style='valign=top'>";}
		echo "$nombre<br><span class=''>$pais</span><br>";
		if ($enti) {echo "<span class='rojo'>$curso</span> ";}
		echo "Plazas: $numplazas $tipplaza";
		$sql2 = "SELECT COUNT(convenio) FROM convsolicitudes WHERE convenio = '$nx' AND aceptada > 0";
		$iresult2 = $ilink->query($sql2);
		$num = $iresult2->fetch_array(MYSQLI_BOTH);
		echo " [<span class='rojo b'>".$num[0]."</span> aceptadas]";
		echo " &nbsp;<a class='nob peq' onclick=\"amplred('pl$nx')\">Ampliar / Reducir</a><br>";
		echo "<div style='display:none' id='pl$nx'>".nl2br($plazadescrip)."</div></td>";

		echo "<td>";

		echo "<form class='peq b fr' method='post'>";
		echo "<input type='hidden' name='solicconv' value='$convenio'>";
		echo "<input type='hidden' name='solicalum' value='$alumno'>";
		echo "<select name='elecc'>";
		echo "<option value='*' ";
		if(!$preferencia) {echo "selected='selected'";}
		echo ">0</option>";
		echo "<option value='1' ";
		if ($preferencia == 1) {echo "selected='selected'";}
		echo ">1</option>";
		echo "<option value='2' ";
		if ($preferencia == 2) {echo "selected='selected'";}
		echo ">2</option>";
		echo "<option value='3' ";
		if ($preferencia == 3) {echo "selected='selected'";}
		echo ">3</option>";
		echo "</select>";
		echo "<input type='checkbox' name='soliccheck'";
		if ($aceptada) {echo " checked='checked'";}
		echo "> ACEPTADA";
		if ($automodif) {
			echo " <input class='col-1' type='submit' name='solicitud' value=' >> '>";
		}
		echo "</form>";
		
		if ($mientras != $fila['alumno']) {	
			$mientras = $fila['alumno'];
			echo funciusu($fila['alumno'],0,1,1,'','','',$ilink);
			echo "<p class='both'>";
			elegirprof($fila['nx'],$fila['alumno'],$fila['tutorid'],$ilink);
		}

		echo "</td>";

	}

	echo "</tr></table>";

}

// --------------------------------------------------

function editar($n,$asigna,$curso,$grupo,$enti,$ilink) {
	if ($_POST['editar1']) {
		extract($_POST);
		$plazatitreque1temp = array();
		for ($i=0;$i<count($plazatitreque);$i++)    
		{     
		$plazatitreque1temp[] = $plazatitreque[$i];   
		}
		if (count($plazatitreque)) {$plazatitreque1 = implode("**", $plazatitreque1temp);}
		if ($enti) {
			$ilink->query("UPDATE convenios SET supervinomb = \"$supervinomb\", supervitel = \"$supervitel\",
			 supervidep = \"$supervidep\", superviema = \"$superviema\", plazadescrip = \"".addslashes($plazadescrip)."\", plazatitreque = \"$plazatitreque1\",
			 plazaidiomas = \"$plazaidiomas\", plazaotros = \"$plazaotros\", localizplaza = \"$localizplaza\",
			 numplazas = \"$numplazas\",tipplaza = \"$tipplaza\", mesini = \"$mesini\", desarrpract = \"$desarrpract\",
			 horario = \"$horario\", ayudaec = \"$ayudaec\", ayudacanti = \"$ayudacanti\", ayudatipo = \"$ayudatipo\",
			 alojamiento = \"$alojamiento\", recuestudiante = \"$recuestudiante\", insercionpost = \"$insercionpost\",
			 obs = \"".addslashes($obs)."\" WHERE n = '$n'");
		} else {
			$ilink->query("UPDATE convenios SET asigna = \"$asigna\", curso = \"$curso\", grupo = \"$grupo\",
			 entidad = \"$entidad\", responom = \"$responom\", respocargo = \"$respocargo\",
			 respodep = \"$respodep\", supervinomb = \"$supervinomb\", supervitel = \"$supervitel\",
			 supervidep = \"$supervidep\", superviema = \"$superviema\", tutornom = \"$tutornom\", tutorcargo = \"$tutorcargo\",
			 tutordep = \"$tutordep\", plazadescrip = \"".addslashes($plazadescrip)."\", plazatitreque = \"$plazatitreque1\",
			 plazaidiomas = \"$plazaidiomas\", plazaotros = \"$plazaotros\", localizplaza = \"$localizplaza\",
			 numplazas = \"$numplazas\",tipplaza = \"$tipplaza\", mesini = \"$mesini\", desarrpract = \"$desarrpract\",
			 horario = \"$horario\", ayudaec = \"$ayudaec\", ayudacanti = \"$ayudacanti\", ayudatipo = \"$ayudatipo\",
			 alojamiento = \"$alojamiento\", recuestudiante = \"$recuestudiante\", insercionpost = \"$insercionpost\",
			 obs = \"".addslashes($obs)."\" WHERE n = '$n'");
		}
		$mensaje = "<span class='b'> - Plaza modificada</span><p></p>";
	}
	$div = "editar";
	$mensaje .= "<form method='post'>";
	$mensaje .= campos($n,$asigna,$curso,$grupo,1,$enti,$ilink);
	$mensaje .= "<input type='hidden' name='ed' value='$n'>";
	$mensaje .= "<input class='col-2' name='editar1' type='submit' value=\"".i("agvalid",$ilink)."\">";
	$mensaje .= "</form>";
	echo $mensaje;
}

// --------------------------------------------------

function anadir($asigna,$curso,$grupo,$enti,$ilink) {
	if ($_POST['anadir1']) {
		extract($_POST);
		$asigna = $_SESSION['asigna'];
		$curso = $_SESSION['curso'];
		$grupo = $_SESSION['grupo'];
		$ilink->query("INSERT INTO convenios (asigna, curso, grupo, entidad, responom, respocargo,
		 respodep, supervinomb, supervitel, supervidep, superviema, plazadescrip, plazatitreque,
		 plazaidiomas,	plazaotros,	localizplaza, numplazas, tipplaza, mesini,	desarrpract, horario, ayudaec,
		 ayudacanti, ayudatipo,	alojamiento, recuestudiante, insercionpost, obs) VALUES (
		 \"$asigna\", \"$curso\", \"$grupo\", \"$entidad\",
		 \"$responom\", \"$respocargo\", \"$respodep\", \"$supervinomb\", \"$supervitel\",
		 \"$supervidep\", \"$superviema\", \"".addslashes($plazadescrip)."\", \"$plazatitreque\", \"$plazaidiomas\", \"$plazaotros\",
		 \"$localizplaza\", \"$numplazas\", \"$tipplaza\", \"$mesini\", \"$desarrpract\", \"$horario\",
		 \"$ayudaec\", \"$ayudacanti\", \"$ayudatipo\", \"$alojamiento\", \"$recuestudiante\",
		 \"$insercionpost\", \"".addslashes($obs)."\")");
		$mensaje = "<span class='b'> - Plaza a&ntilde;adida</span><p></p>";
	}
	$div = "anadir";
	$mensaje .= "<form method='post'>";
	$mensaje .= campos('',$asigna,$curso,$grupo,1,$enti,$ilink);
	$mensaje .= "<input class='col-2' name='anadir1' type='submit' value=\"".i("anadir1",$ilink)."\">";
	$mensaje .= "</form>";
	echo $mensaje;
}

// --------------------------------------------------

function campos($n,$asigna,$curso,$grupo,$cambiar,$entiget,$ilink) {

	$cl = "b i";
	if ($n) {
		$iresult = $ilink->query("SELECT * FROM convenios WHERE n = '$n'");
		$fila = $iresult->fetch_array(MYSQLI_BOTH);
		extract($fila);
		$plazatitreque = explode("**", $plazatitreque);
		$enti = $fila['entidad'];
	}
	$mensaje = "<fieldset><legend>Entidad de pr&aacute;cticas</legend>";
	$mensaje .= "<select name='entidad'";
	if (!$cambiar OR $entiget) {$mensaje .= " disabled='disabled'";}
	$mensaje .= ">";
	$result = $ilink->query("SELECT n, nombre, pais FROM conventid ORDER BY pais, nombre");
	while ($fila = $result->fetch_array(MYSQLI_BOTH)) {
		$mensaje .= "<option value='$fila[0]'";
		if ($fila[0] == $enti) {$mensaje .= " selected='selected'";}
		$mensaje .= ">$fila[1] - $fila[2]</option>";
	}
	$mensaje .= "</select>";
	if ($entiget) {$mensaje .= " &nbsp; Curso <span class='rojo'>".$curso."</span>";}
	$mensaje .= "</fieldset>";	

	
	if ($_SESSION['auto'] > 4 OR $entiget) {	

	$sql = "SELECT usuid FROM asignatprof LEFT JOIN usuarios ON usuarios.id = asignatprof.usuid
	 WHERE asigna = '$asigna' AND curso = '$curso' AND grupo = '$grupo' ORDER BY alumnoa, alumnon";
	$result = $ilink->query($sql);
	$mensaje .= "<fieldset><legend>Supervisor/a del Practicum</legend>";
	$mensaje .= "<label>Nombre</label><br>\n\r";
	$mensaje .= "<input class='col-7' type='text' name='supervinomb'";
	if (!$cambiar) {$mensaje .= " disabled='disabled'";}
	$mensaje .= " size='100' maxlength='100' value=\"$supervinomb\"><p></p>";
	$mensaje .= "<label>Departamento</label><br>\n\r";
	$mensaje .= "<input class='col-7' type='text' name='supervidep'";
	if (!$cambiar) {$mensaje .= " disabled='disabled'";}
	$mensaje .= " size='100' maxlength='100' value=\"$supervidep\"><p></p>";
	$mensaje .= "<label>Tel&eacute;fono</label><br>\n\r";
	$mensaje .= "<input class='col-7' type='text' name='supervitel'";
	if (!$cambiar) {$mensaje .= " disabled='disabled'";}
	$mensaje .= " size='20' maxlength='20' value=\"$supervitel\"><p></p>";
	$mensaje .= "<label>Email</label><br>\n\r";
	$mensaje .= "<input class='col-7' type='text' name='superviema'";
	if (!$cambiar) {$mensaje .= " disabled='disabled'";}
	$mensaje .= " size='100' maxlength='100' value=\"$superviema\"><p></p>";
	$mensaje .= "</fieldset>";
	// --------------------------------------------------
	}
	
	if ($_SESSION['auto'] > 4) {	
	$mensaje .= "<fieldset><legend>Tutor/a del Practicum</legend>";
	$result = $ilink->query($sql);
	$mensaje .= "<select name='tutornom'";
	if (!$cambiar) {$mensaje .= " disabled='disabled'";}
	$mensaje .= "><option value=''></option>";
	while ($fila = $result->fetch_array(MYSQLI_BOTH)) {
		$mensaje .= "<option value='".$fila['usuid']."'";
		if ($fila['usuid'] == $tutornom) {$mensaje .= " selected = 'selected'";}
		$mensaje .= ">".nomb1($fila['usuid'],$ilink)."</option>";
	}
	$mensaje .= "</select>";
	$mensaje .= "<p></p><label>Cargo</label><br>\n\r";
	$mensaje .= "<input class='col-7' type='text' name='tutorcargo'";
	if (!$cambiar) {$mensaje .= " disabled='disabled'";}
	$mensaje .= " size='100' maxlength='100' value=\"$tutorcargo\"><p></p>";
	$mensaje .= "<label>Departamento</label><br>\n\r";
	$mensaje .= "<input class='col-7' type='text' name='tutordep'";
	if (!$cambiar) {$mensaje .= " disabled='disabled'";}
	$mensaje .= " size='100' maxlength='100' value=\"$tutordep\"><p></p>";
	$mensaje .= "</fieldset>";
	}	
	
// --------------------------------------------------
	$mensaje .= "<fieldset><legend>Descripci&oacute;n de la Plaza</legend>";
	$mensaje .= "<textarea class='col-7' name='plazadescrip'";
	if (!$cambiar) {$mensaje .= " disabled='disabled'";}
	$mensaje .= " rows='12' cols='80'>$plazadescrip</textarea></fieldset>";
// --------------------------------------------------
	$mensaje .= "<fieldset><legend>Requerimientos</legend>";
	$mensaje .= "<label>Titulaci&oacute;n acad&eacute;mica";
	if ($cambiar) {$mensaje .= " (seleccionar varias pulsando may&uacute;scula - control)";}
	$mensaje .= "</label><br>\n\r";
	$mensaje .= "<select class='col-7' multiple name='plazatitreque[]' size='10'";
	if (!$cambiar) {$mensaje .= " disabled='disabled'";}
	$mensaje .= "><option value=''></option>";
	$sql = "SELECT * FROM convtitul ORDER BY titulacion";
	$result = $ilink->query($sql);
	while ($fila = $result->fetch_array(MYSQLI_BOTH)) {
		$pos = ""; $temp = "";
		if ($plazatitreque) {
			foreach ($plazatitreque as $key => $value) {
				if ($value == $fila[0]) {$temp .= " selected='selected'"; $pos = 1;break;}		
			}
		}
		if (!$cambiar AND !$pos) {continue;}
		$mensaje .= "<option value='$fila[0]'";
		if ($pos) {$mensaje .= " selected='selected'";}
		$mensaje .= ">$fila[1]</option>";	
	}
	$mensaje .= "</select>";
	$mensaje .= "<p></p><label>Nivel de idiomas</label><br>\n\r";
	$mensaje .= "<input class='col-7' type='text' name='plazaidiomas'";
	if (!$cambiar) {$mensaje .= " disabled='disabled'";}
	$mensaje .= " size='100' maxlength='100' value=\"$plazaidiomas\"><p></p>";
	$mensaje .= "<label>Otros conocimientos</label><br>\n\r";
	$mensaje .= "<textarea class='col-7' name='plazaotros'";
	if (!$cambiar) {$mensaje .= " disabled='disabled'";}
	$mensaje .= " rows='12' cols='80'>$plazaotros</textarea>";
	$mensaje .= "</fieldset>";
// --------------------------------------------------
	$mensaje .= "<fieldset><legend>Localizaci&oacute;n exacta de la Plaza</legend>";
	$mensaje .= "<input class='col-7' type='text' name='localizplaza'";
	if (!$cambiar) {$mensaje .= " disabled='disabled'";}
	$mensaje .= " size='100' maxlength='100' value=\"$localizplaza\">";
	$mensaje .= "</fieldset>";
	$mensaje .= "<fieldset><legend>N&uacute;mero 	de Plazas</legend>";
	$mensaje .= "<input class='col-7' type='text' name='numplazas'";
	if (!$cambiar) {$mensaje .= " disabled='disabled'";}
	$mensaje .= " size='3' maxlength='3' value=\"$numplazas\">";
	$mensaje .= "</fieldset>";
	$mensaje .= "<fieldset><legend>Tipo de Plaza</legend>";
	$mensaje .= "<select class='col-7' name='tipplaza' value=\"$tipplaza\"";
	if (!$cambiar) {$mensaje .= " disabled='disabled'";}
	$mensaje .= ">";
	$mensaje .= "<option value=\"Practicum\"";
	if ($tipplaza == "Practicum") {$mensaje .= " selected='selected'";}
	$mensaje .= ">Practicum</option>";
	$mensaje .= "<option value=\"Laboral\"";
	if ($tipplaza == "Laboral") {$mensaje .= " selected='selected'";}
	$mensaje .= ">Laboral</option>";
	$mensaje .= "</select>";
	$mensaje .= "</fieldset>";
	$mensaje .= "<fieldset><legend>Mes de inicio</legend>";
	$mensaje .= "<input class='col-7' type='text' name='mesini'";
	if (!$cambiar) {$mensaje .= " disabled='disabled'";}
	$mensaje .= " size='50' maxlength='50' value=\"$mesini\">";
	$mensaje .= "</fieldset>";
// --------------------------------------------------
	$mensaje .= "<fieldset><legend>Desarrollo de las pr&aacute;cticas</legend>";
	$mensaje .= "<input type='radio' name='desarrpract' onclick=\"uncheckRadio(this)\"";
	if (!$cambiar) {$mensaje .= " disabled='disabled'";}
	$mensaje .= " value='Estancia completa en el terreno'";
	if ($desarrpract == "Estancia completa en el terreno") {$cld1 = $cl; $mensaje .= " checked='checked'";}
	$mensaje .= "><span class='$cld1'>Estancia completa en el terreno</span><br>";
	$mensaje .= "<input type='radio' name='desarrpract' onclick=\"uncheckRadio(this)\"";
	if (!$cambiar) {$mensaje .= " disabled='disabled'";}
	$mensaje .= " value='Formaci&oacute;n previa en sede de Espa&ntilde;a y salida al terreno'";
	if ($desarrpract == "Formaci&oacute;n previa en sede de Espa&ntilde;a y salida al terreno") {$cld2 = $cl; $mensaje .= " checked='checked'";}
	$mensaje .= "><span class='$cld2'>Formaci&oacute;n previa en sede de Espa&ntilde;a y salida al terreno</span><br>";
	$mensaje .= "<input type='radio' name='desarrpract' onclick=\"uncheckRadio(this)\"";
	if (!$cambiar) {$mensaje .= " disabled='disabled'";}
	$mensaje .= " value='Estancia exclusiva en sede de Espa&ntilde;a'";
	if ($desarrpract == "Estancia exclusiva en sede de Espa&ntilde;a") {$cld3 = $cl; $mensaje .= " checked='checked'";}
	$mensaje .= "><span class='$cld3'>Estancia exclusiva en sede de Espa&ntilde;a</span>";
	$mensaje .= "</fieldset>";
// --------------------------------------------------
	$mensaje .= "<fieldset><legend>Horario</legend>";
	$mensaje .= "<input type='radio' name='horario' onclick=\"uncheckRadio(this)\"";
	if (!$cambiar) {$mensaje .= " disabled='disabled'";}
	$mensaje .= " value='Ma&ntilde;ana'";
	if ($horario == "Ma&ntilde;ana") {$cle1 = $cl; $mensaje .= " checked='checked'";}
	$mensaje .= "><span class='$cle1'>Ma&ntilde;ana</span><br>";
	$mensaje .= "<input type='radio' name='horario' onclick=\"uncheckRadio(this)\"";
	if (!$cambiar) {$mensaje .= " disabled='disabled'";}
	$mensaje .= " value='Tarde'";
	if ($horario == "Tarde") {$cle2 = $cl; $mensaje .= " checked='checked'";}
	$mensaje .= "><span class='$cle2'>Tarde</span><br>";
	$mensaje .= "<input type='radio' name='horario' onclick=\"uncheckRadio(this)\"";
	if (!$cambiar) {$mensaje .= " disabled='disabled'";}
	$mensaje .= " value='Partido'";
	if ($horario == "Partido") {$cle3 = $cl; $mensaje .= " checked='checked'";}
	$mensaje .= "><span class='$cle3'>Partido</span><br>";
	$mensaje .= "<input type='radio' name='horario' onclick=\"uncheckRadio(this)\"";
	if (!$cambiar) {$mensaje .= " disabled='disabled'";}
	$mensaje .= " value='A negociar'";
	if ($horario == "A negociar") {$cle4 = $cl; $mensaje .= " checked='checked'";}
	$mensaje .= "><span class='$cle4'>A negociar</span>";
	$mensaje .= "</fieldset>";
// --------------------------------------------------
	$mensaje .= "<fieldset><legend>Ayuda econ&oacute;mica</legend>";
	$mensaje .= "<input type='radio' name='ayudaec' onclick=\"uncheckRadio(this)\"";
	if (!$cambiar) {$mensaje .= " disabled='disabled'";}
	$mensaje .= " value='S&iacute;'";
	if ($ayudaec == "S&iacute;") {$clf1 = $cl; $mensaje .= " checked='checked'";}
	$mensaje .= "><span class='$clf1'>S&iacute;</span> &nbsp; &nbsp; ";
	$mensaje .= "<input type='radio' name='ayudaec' onclick=\"uncheckRadio(this)\"";
	$mensaje .= " value='No'";
	if (!$cambiar) {$mensaje .= " disabled='disabled'";}
	if ($ayudaec == "No") {$clf2 = $cl; $mensaje .= " checked='checked'";}
	$mensaje .= "><span class='$clf2'>No</span> &nbsp; &nbsp; ";
	$mensaje .= "<label>Cantidad</label> ";
	$mensaje .= "<input class='col-1' type='text' name='ayudacanti'";
	if (!$cambiar) {$mensaje .= " disabled='disabled'";}
	$mensaje .= " size='10' maxlength='10' value=\"$ayudacanti\"><p></p>";
	$mensaje .= "<label>Tipo de ayuda</label><br>\n\r";
	$mensaje .= "<input class='col-7' type='text' name='ayudatipo'";
	if (!$cambiar) {$mensaje .= " disabled='disabled'";}
	$mensaje .= " size='100' maxlength='100' value=\"$ayudatipo\"><p></p>";
	$mensaje .= "</fieldset>";
// --------------------------------------------------
	$mensaje .= "<fieldset><legend>Alojamiento</legend>";
	$mensaje .= "<input type='radio' name='alojamiento' onclick=\"uncheckRadio(this)\"";
	if (!$cambiar) {$mensaje .= " disabled='disabled'";}
	$mensaje .= " value='A Cargo de la entidad'";
	if ($alojamiento == "A Cargo de la entidad") {$cla1 = $cl; $mensaje .= " checked='checked'";}
	$mensaje .= "><span class='$cla1'>A Cargo de la entidad</span><br>";
	$mensaje .= "<input type='radio' name='alojamiento' onclick=\"uncheckRadio(this)\"";
	if (!$cambiar) {$mensaje .= " disabled='disabled'";}
	$mensaje .= " value='La entidad busca alojamiento y el estudiante lo costea'";
	if ($alojamiento == "La entidad busca alojamiento y el estudiante lo costea") {$cla2 = $cl; $mensaje .= " checked='checked'";}
	$mensaje .= "><span class='$cla2'>La entidad busca alojamiento y el estudiante lo costea</span><br>";
	$mensaje .= "<input type='radio' name='alojamiento' onclick=\"uncheckRadio(this)\"";
	if (!$cambiar) {$mensaje .= " disabled='disabled'";}
	$mensaje .= " value='A cargo del estudiante'";
	if ($alojamiento == "A cargo del estudiante") {$cla3 = $cl; $mensaje .= " checked='checked'";}
	$mensaje .= "><span class='$cla3'>A cargo del estudiante</span><br>";
	$mensaje .= "</fieldset>";
// --------------------------------------------------
	$mensaje .= "<fieldset><legend>Recepci&oacute;n del estudiante</legend>";
	$mensaje .= "<input type='radio' name='recuestudiante' onclick=\"uncheckRadio(this)\"";
	if (!$cambiar) {$mensaje .= " disabled='disabled'";}
	$mensaje .=" value='La entidad recoge al estudiante en el aeropuerto'";
	if ($recuestudiante == "La entidad recoge al estudiante en el aeropuerto") {$clb1 = $cl; $mensaje .= " checked='checked'";}
	$mensaje .= "><span class='$clb1'>La entidad recoge al estudiante en el aeropuerto</span><br>";
	$mensaje .= "<input type='radio' name='recuestudiante' onclick=\"uncheckRadio(this)\"";
	if (!$cambiar) {$mensaje .= " disabled='disabled'";}
	$mensaje .= " value='La entidad ofrece informaci&oacute;n al estudiante sobre c&oacute;mo llegar a sus instalaciones'";
	if ($recuestudiante == "La entidad ofrece informaci&oacute;n al estudiante sobre c&oacute;mo llegar a sus instalaciones") {$clb2 = $cl; $mensaje .= " checked='checked'";}
	$mensaje .= "><span class='$clb2'>La entidad ofrece informaci&oacute;n al estudiante sobre c&oacute;mo llegar a sus instalaciones</span><br>";
	$mensaje .= "</fieldset>";
// --------------------------------------------------
	$mensaje .= "<fieldset><legend>Inserci&oacute;n posterior</legend>";
	$mensaje .= "<input type='radio' name='insercionpost' onclick=\"uncheckRadio(this)\"";
	if (!$cambiar) {$mensaje .= " disabled='disabled'";}
	$mensaje .= " value='S&iacute;'";
	if ($insercionpost == "S&iacute;") {$clc1 = $cl; $mensaje .= " checked='checked'";}
	$mensaje .= "><span class='$clc1'>S&iacute;</span> &nbsp; &nbsp; ";
	$mensaje .= "<input type='radio' name='insercionpost' onclick=\"uncheckRadio(this)\"";
	if (!$cambiar) {$mensaje .= " disabled='disabled'";}
	$mensaje .= " value='No'";
	if ($insercionpost == "No") {$clc2 = $cl; $mensaje .= " checked='checked'";}
	$mensaje .= "><span class='$clc2'>No</span> &nbsp; &nbsp; ";
	$mensaje .= "</fieldset>";
// --------------------------------------------------
	$mensaje .= "<fieldset><legend>Observaciones</legend>";
	$mensaje .= "<textarea class='col-7' name='obs'";
	if (!$cambiar) {$mensaje .= " disabled='disabled'";}
	$mensaje .= " rows='12' cols='80'>$obs</textarea>";
	$mensaje .= "</fieldset>";
// --------------------------------------------------
	return $mensaje;
}

// Entidades

// --------------------------------------------------

function anadirenti($ilink) {
	if ($_POST['anadirenti1']) {
		extract($_POST);
		$ilink->query("INSERT INTO conventid (pais, nombre, persconta, descrienti, ambgeo, sector, numemp, paisactu
		, calle, localidad, codpos, tf, email, web, responom1, respocargo1, respodep1, contrasena, cif) VALUES (\"$pais\", \"$nombre\", \"$persconta\", \"".
		addslashes($descrienti)."\", \"$ambgeo\", \"$sector\",
		 \"$numemp\", \"$paisactu\", \"$calle\", \"$localidad\", \"$codpos\", \"$tf\", \"$email\", \"$web\", \"$responom1\", \"$respocargo1\", \"$respodep1\", \"$contrasena\", \"$cif\")");
		$mensaje = "<span class='b'> - Entidad a&ntilde;adida</span><p></p>";
	}
	$div = "anadir";
	$mensaje .= "<form method='post' action='?pest=11&apli=2&enti=1&pest1=2'>";
	$mensaje .= camposenti('','',$ilink);
	$mensaje .= "<div class='center'><input class='col-10' name='anadirenti1' type='submit' value=\"".i("anadir1",$ilink)."\"></div>";
	$mensaje .= "</form>";
	echo $mensaje;
}

// --------------------------------------------------

function editarenti($n,$externo,$ilink) {
	if ($_POST['editarenti1']) {
		extract($_POST);
		if ($externo) {
			$ilink->query("UPDATE conventid SET pais = \"$pais\", nombre = \"$nombre\", persconta = \"$persconta\",
			descrienti = \"".addslashes($descrienti)."\", ambgeo = \"$ambgeo\",
		 	sector = \"$sector\", numemp = \"$numemp\", paisactu = \"$paisactu\", calle = \"$calle\",
		  localidad = \"$localidad\", codpos = \"$codpos\", tf = \"$tf\", email = \"$email\",
		   web = \"$web\", cif = \"$cif\" WHERE n = '$n'");
		} else {
			$ilink->query("UPDATE conventid SET pais = \"$pais\", nombre = \"$nombre\", persconta = \"$persconta\",
			descrienti = \"".addslashes($descrienti)."\", ambgeo = \"$ambgeo\",
		 	sector = \"$sector\", numemp = \"$numemp\", paisactu = \"$paisactu\", calle = \"$calle\",
		  localidad = \"$localidad\", codpos = \"$codpos\", tf = \"$tf\", email = \"$email\",
		   web = \"$web\", responom1 = \"$responom1\", respocargo1 = \"$respocargo1\", respodep1 = \"$respodep1\", contrasena = \"$contrasena\", cif = \"$cif\"
		    WHERE n = '$n'");
		}
		$mensaje = "<span class='b'> - Entidad modificada</span><p></p>";
	}
	$div = "editar";
	$mensaje .= "<form method='post' action='?pest=11&apli=2&enti=$n&pest1=2'>"; // action='?pest=11&apli=2&enti=1'
	$mensaje .= camposenti($n,$externo,$ilink);
	$mensaje .= "<input type='hidden' name='edenti' value='$n'>";
	$mensaje .= "<input class='col-10' name='editarenti1' type='submit' value=\"".i("agvalid",$ilink)."\">";
	$mensaje .= "</form>";
	echo "<br>";
	echo "<span class='peq nob'>Gesti&oacute;n externa de plazas: <a target='_blank' href='". DOMINIO .APP_URL. "/plazasext.php?enti=$n'>". DOMINIO.APP_URL. "/plazasext.php?enti=$n</a></span>";
	echo $mensaje;
}

// --------------------------------------------------

function camposenti($n,$externo,$ilink) {

	if ($n) {
		$iresult = $ilink->query("SELECT * FROM conventid WHERE n = '$n'");
		$fila = $iresult->fetch_array(MYSQLI_BOTH);
		extract($fila);
	}

	if (!$externo) {
		$mensaje = "<span class='b fr'>Contrase&ntilde;a de la entidad <input type='text' name='contrasena' size='15' maxlength='15' value=\"$contrasena\"></span>";
	}
	
	$mensaje .= "<div class='both'><fieldset><legend>Pa&iacute;s</legend>";
	$mensaje .= "<input class='col-7' type='text' name='pais' size='50' maxlength='50' value=\"$pais\">";
	$mensaje .= "<br><input class='col-7' type='text' name='paisactu' size='50' maxlength='50' value=\"$paisactu\">";
	$mensaje .= " Pa&iacute;s de actuaci&oacute;n</fieldset>";
	//******************
	$mensaje .= "<fieldset><legend>Entidad</legend>";
	$mensaje .= "<label>Nombre</label><br>\n\r";
	$mensaje .= "<input class='col-7' type='text' name='nombre' size='100' maxlength='100' value=\"$nombre\"><br>";
	$mensaje .= "<label>CIF/Company Number</label><br>\n\r";
	$mensaje .= "<input class='col-7' type='text' name='cif' size='50' maxlength='100' value=\"$cif\"><br>";
	$mensaje .= "<label>Descripci&oacute;n de la Entidad</label><br>\n\r";
	$mensaje .= "<textarea class='col-7' rows='5' cols='90' name='descrienti'>$descrienti</textarea>";
	$mensaje .= "<p></p>";
	$mensaje .= "<label>&Aacute;mbito geogr&aacute;fico</label> &nbsp &nbsp; ";
	$mensaje .= "<input type='radio' name='ambgeo' value='Local'";
	if ($ambgeo == "Local") {$mensaje .= " checked='checked'";}
	$mensaje .= ">Local &nbsp &nbsp; ";
	$mensaje .= "<input type='radio' name='ambgeo' value='Regional'";
	if ($ambgeo == "Regional") {$mensaje .= " checked='checked'";}
	$mensaje .= ">Regional &nbsp &nbsp; ";
	$mensaje .= "<input type='radio' name='ambgeo' value='Nacional'";
	if ($ambgeo == "Nacional") {$mensaje .= " checked='checked'";}
	$mensaje .= ">Nacional &nbsp &nbsp; ";
	$mensaje .= "<input type='radio' name='ambgeo' value='Internacional'";
	if ($ambgeo == "Internacional") {$mensaje .= " checked='checked'";}
	$mensaje .= ">Internacional <p></p>";
	$mensaje .= "<label>Sector</label> &nbsp &nbsp; ";
	$mensaje .= "<input type='radio' name='sector' value='P&uacute;blico'";
	if ($sector == "P&uacute;blico") {$mensaje .= " checked='checked'";}
	$mensaje .= ">P&uacute;blico &nbsp &nbsp; ";
	$mensaje .= "<input type='radio' name='sector' value='Privado'";
	if ($sector == "Privado") {$mensaje .= " checked='checked'";}
	$mensaje .= ">Privado &nbsp &nbsp; ";
	$mensaje .= "<input type='radio' name='sector' value='Tercer sector'";
	if ($sector == "Tercer sector") {$mensaje .= " checked='checked'";}
	$mensaje .= ">Tercer sector<p></p> ";
	$mensaje .= "<label>N&uacute;mero de empleados</label> &nbsp &nbsp; ";
	$mensaje .= "<input type='radio' name='numemp' value='1 - 10'";
	if ($numemp == "1 - 10") {$mensaje .= " checked='checked'";}
	$mensaje .= ">1 - 10 &nbsp &nbsp; ";
	$mensaje .= "<input type='radio' name='numemp' value='11 - 50'";
	if ($numemp == "11 - 50") {$mensaje .= " checked='checked'";}
	$mensaje .= ">11 - 50 &nbsp &nbsp; ";
	$mensaje .= "<input type='radio' name='numemp' value='51 - 250'";
	if ($numemp == "51 - 250") {$mensaje .= " checked='checked'";}
	$mensaje .= ">51 - 250 &nbsp &nbsp; ";
	$mensaje .= "<input type='radio' name='numemp' value='m&aacute;s de 250'";
	if ($numemp == "m&aacute;s de 250") {$mensaje .= " checked='checked'";}
	$mensaje .= ">m&aacute;s de 250<p></p> ";
	$mensaje .= "<label>Calle/Avenida</label><br>\n\r";
	$mensaje .= "<input class='col-7' type='text' name='calle' size='100' maxlength='100' value=\"$calle\"><br>";
	$mensaje .= "<label>Localizaci&oacute;n de la Entidad</label><br>\n\r";
	$mensaje .= "<input class='col-7' type='text' name='localidad' size='50' maxlength='100' value=\"$localidad\"><br>";
	$mensaje .= "<label>C&oacute;digo postal</label><br>\n\r";
	$mensaje .= "<input class='col-7' type='text' name='codpos' size='50' maxlength='100' value=\"$codpos\"><br>";
	$mensaje .= "<label>Persona de contacto</label><br>\n\r";
	$mensaje .= "<input class='col-7' type='text' name='persconta' size='100' maxlength='100' value=\"$persconta\"><br>";
	$mensaje .= "<label>Tel&eacute;fono</label><br>\n\r";
	$mensaje .= "<input class='col-7' type='text' name='tf' size='50' maxlength='100' value=\"$tf\"><br>";
	$mensaje .= "<label>Direcci&oacute;n electronica</label><br>\n\r";
	$mensaje .= "<input class='col-7' type='text' name='email' size='50' maxlength='100' value=\"$email\"><br>";
	$mensaje .= "<label>Direcci&oacute;n web</label><br>\n\r";
	$mensaje .= "<input class='col-7' type='text' name='web' size='50' maxlength='100' value=\"$web\"><br>";
	
// --------------------------------------------------
	$asigna = $_SESSION['asigna'];
	$curso = $_SESSION['curso'];
	$grupo = $_SESSION['grupo'];
	$sql1 = "SELECT usuid FROM asignatprof LEFT JOIN usuarios ON usuarios.id = asignatprof.usuid
	 WHERE asigna = '$asigna' AND curso = '$curso' AND grupo = '$grupo' ORDER BY alumnoa, alumnon";
	$result1 = $ilink->query($sql1);

	if (!$externo) {
	$mensaje .= "<fieldset><legend>Persona responsable del Convenio</legend>";
	$mensaje .= "<select name='responom1'";
	$mensaje .= "><option value=''></option>";
	while ($fila1 = $result1->fetch_array(MYSQLI_BOTH)) {
		$mensaje .= "<option value='".$fila1['usuid']."'";
		if ($fila1['usuid'] == $responom1) {$mensaje .= " selected = 'selected'";}
		$mensaje .= ">".nomb1($fila1['usuid'],$ilink)."</option>";
	}
	$mensaje .= "</select>";
	$mensaje .= "<p></p><label>Cargo</label><br>\n\r";
	$mensaje .= "<input class='col-7' type='text' name='respocargo1'";
	$mensaje .= " size='100' maxlength='100' value=\"$respocargo1\"><p></p>";
	$mensaje .= "<label>Departamento</label><br>\n\r";
	$mensaje .= "<input class='col-7' type='text' name='respodep1'";
	$mensaje .= " size='100' maxlength='100' value=\"$respodep1\"></fieldset><p></p>";
// --------------------------------------------------
	}
	$mensaje .= "</fieldset>";
	return $mensaje;

}

// --------------------------------------------------

function elegirprof($convenio,$alumno,$tutorini,$ilink) {
	
	$asigna = $_SESSION['asigna'];
	$curso = $_SESSION['curso'];
	$grupo = $_SESSION['grupo'];
	$tutor = $_POST['tutorde'];
	$tutor = $tutor[$alumno];
	if ($tutor) {
		if ($tutor == "*") {$tutor = "";}
		$sql = "UPDATE convsolicitudes SET tutorid = '$tutor' WHERE convenio = '$convenio' AND alumno = '$alumno'";
		$ilink->query($sql);
	} else {
		$tutor = $tutorini;
	}
		
	$sql = "SELECT DISTINCT usuarios.id, alumnon, alumnoa, autorizado, privacidad FROM asignatprof LEFT JOIN usuarios ON asignatprof.usuid = usuarios.id WHERE autorizado > 1 AND 
	fechabaja = '0000-00-00 00:00:00' AND asigna = '$asigna' AND curso = '$curso' AND grupo = '$grupo' AND usuarios.id > 0 ORDER BY alumnoa, alumnon";
	
	$result = $ilink->query($sql);

	echo "<form method='post'>Tutor&iacute;a <select name='tutorde[$alumno]'><option value='*'>-- Elegir --</option>";	
	while ($fila = $result->fetch_array(MYSQLI_BOTH)) {
		extract($fila);
		echo "<option value='$id'";
		if ($tutor == $id) {echo " selected = 'selected'";}
		echo ">$alumnon $alumnoa</option>\n";	
		
	}
	echo "</select> <input type='submit' value=' >> '>";
	echo "</form>";

}

?>