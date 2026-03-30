<?php

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

if ($_SESSION['auto'] < 10) {return;}

function borrtitulaci($post,$ilink) {
	extract($post);
	$mensaje = "Borrando [$cod] en la tabla de Titulaciones...";
	$sql = "DELETE FROM podtitulacion WHERE cod = '$cod'";
	$ilink->query($sql);
	if ($ilink->errno) {$mensaje .= "<br>Error al borrar [$cod] en la tabla Titulaciones.";}
	$mensaje .= "<br>Borrando [$cod] en la tabla Foros...";
	$sql = "DELETE FROM foro WHERE titulaci = '$cod'";
	$ilink->query($sql);
	if ($ilink->errno) {$mensaje .= "<br>Error al borrar [$cod] en la tabla Foro.";}
	$mensaje .= "<br>Borrando [$cod] en la tabla Administradores de Titulaci&oacute;n...";
	$sql = "DELETE FROM titcuradmi WHERE titulaci = '$cod'";
	$ilink->query($sql);
	if ($ilink->errno) {$mensaje .= "<br>Error al borrar [$cod] en la tabla Administradores de Titulaci&oacute;n.";}
	//Borrar carpetas de la titulaci&oacute;n		
	$mensaje .= "<br>Borrando carpetas de la Titulaci&oacute;n [$cod]...";
	$dire = DATA_DIR . "/cursos/";
	borrardir($dire, $cod);
	$mensaje .= "<p class='mediana'>HECHO</p>";
	return $mensaje;
}
function modiftitulaci($post,$ilink) {
	extract($post);
	$edcod = strtoupper(str_replace(" ","",$edcod));
	$mensaje = "<span class='rojo b'>Error al modificar la Titulaci&oacute;n [$cod].</span>";
	if (!$edcod OR !$edtitulacion) {return $mensaje;}
	$sql = "UPDATE podtitulacion SET titulacion = \"$edtitulacion\", cod=\"$edcod\" WHERE cod = '$cod'";
	$ilink->query($sql);
	if ($ilink->errno) {return $mensaje;}
}
function anadirtitulaci($post,$ilink) {
	extract($post);
	$newcod = strtoupper(str_replace(" ","",$newcod));
	$mensaje = "<span class='rojo b'>Error al a&ntilde;adir la Titulaci&oacute;n [$newcod]. Posiblemente ya existe.</span>";
	if (!$newcod OR !$newtitulacion) {return $mensaje;}
	$ilink->query("INSERT INTO podtitulacion (cod, titulacion) VALUES ('$newcod', \"$newtitulacion\")");
	if ($ilink->errno) {return $mensaje;}
}

// --------------------------------------------------
// --------------------------------------------------

function modifareas($post,$ilink) {
	extract($post);
	$edcodarea = strtoupper(str_replace(" ","",$edcodarea));
	$mensaje = "<span class='rojo b'>Error al modificar Area [$codarea].</span>";
	if (!$edarea OR !$edcodarea) {return $mensaje;}
	$ilink->query("UPDATE podareas SET area = '$edarea', codarea='$edcodarea' WHERE codarea = '$codarea'");
	if ($ilink->errno) {return $mensaje;}
}
function anadirareas($post,$ilink) {
	extract($post);
	$newcodarea = strtoupper(str_replace(" ","",$newcodarea));
	$mensaje = "<span class='rojo b'>Error al a&ntilde;adir Area [$newcodarea].</span>";
	if (!$newarea OR !$newcodarea) {return $mensaje;}
	$ilink->query("INSERT INTO podareas (codarea, area) VALUES ('$newcodarea', '$newarea')");
	if ($ilink->errno) {return $mensaje;}
}
function borrarareas($post,$ilink) {
	extract($post);
	if (!$codarea) {return $mensaje;}
	$mensaje = "<span class='rojo b'>Error al borrar Area [$codarea].</span>";
	$ilink->query("DELETE FROM podareas WHERE codarea = '$codarea'");
	if ($ilink->errno) {return $mensaje;}
}

// --------------------------------------------------
// --------------------------------------------------

function anadirgras($post,$ilink) {
	extract($post);
	$newcod = strtoupper(str_replace(" ","",$newcod));
	$mensaje = "<span class='rojo b'>Error al a&ntilde;adir Grupo de Asignaturas [$newcod].</span>";
	if (!$newcod) {return $mensaje;}
	$sql = "INSERT INTO podareagruposa (area, cod, grupo) VALUES (\"$newarea\", \"$newcod\", \"$newgrupo\")";
	$ilink->query($sql);
	if ($ilink->errno) {return $mensaje;}
}

function modifgras($post,$ilink) {
	extract($post);
	$edcod = strtoupper(str_replace(" ","",$edcod));
	$mensaje = "<span class='rojo b'>Error al modificar Grupo de Asignaturas [$edcod].</span>";
	if (!$edcod) {return $mensaje;}
	$sql = "UPDATE podareagruposa SET area = \"$edarea\", cod = \"$edcod\", grupo= \"$edgrupo\" WHERE cod=\"$cod\" AND area=\"$area\"";
	$ilink->query($sql);
	if ($ilink->errno) {return $mensaje;}
}

function borrargras($post,$ilink) {
	extract($post);
	$mensaje = "<span class='rojo b'>Error al borrar Grupo de Asignaturas [$cod].</span>";
	$sql = "DELETE FROM podareagruposa WHERE cod = \"$cod\"";
	$ilink->query($sql);
	if ($ilink->errno) {return $mensaje;}
}

// --------------------------------------------------
// --------------------------------------------------

function anadirfiguras($post,$ilink) {
	extract($post);
	$newcod = strtoupper(str_replace(" ","",$newcod));
	$mensaje = "<span class='rojo b'>Error al a&ntilde;adir Figura [$newfigura].</span>";
	if (!$newcod OR !$newfigura) {return $mensaje;}
	$sql = "INSERT INTO podfiguras (cod, figura) VALUES (\"$newcod\", \"$newfigura\")";
	$ilink->query($sql);
	if ($ilink->errno) {return $mensaje;}
}
function modiffiguras($post,$ilink) {
	extract($post);
	$edcod = strtoupper(str_replace(" ","",$edcod));
	$mensaje = "<span class='rojo b'>Error al modificar Figura [$cod].</span>";
	if (!$edcod OR !$edfigura) {return $mensaje;}
	$sql = "UPDATE podfiguras SET cod = \"$edcod\", figura= \"$edfigura\" WHERE cod=\"$cod\"";
	$ilink->query($sql);
	if ($ilink->errno) {return $mensaje;}
}
function borrarfiguras($post,$ilink) {
	extract($post);
	$mensaje = "<span class='rojo b'>Error al borrar Figura [$cod].</span>";
	$sql = "DELETE FROM podfiguras WHERE cod = \"$cod\"";
	$ilink->query($sql);
	if ($ilink->errno) {return $mensaje;}
}

// --------------------------------------------------
// --------------------------------------------------

function anadircurfiguras($post,$min,$ilink) {
	extract($post);
	$mensaje = "<span class='rojo b'>Error al a&ntilde;adir Figura - Curso [$newcodfigura $newcurso].</span>";
	$newcodfigura = strtoupper(str_replace(" ","",$newcodfigura));
	$newcurso = strtoupper(str_replace(" ","",$newcurso));
	if (!$newcurso) {$newcurso = "";}
	if (!$newcodfigura OR ($newcurso AND $newcurso < $min)) {return $mensaje;}
	$sql = "INSERT INTO podcursofigura (curso, codfigura, creditos, creditosmin, tiempo) VALUES (\"$newcurso\", \"$newcodfigura\", \"$newcreditos\", \"$newcreditosmin\", \"$newtiempo\")";
	$ilink->query($sql);
	if ($ilink->errno) {return $mensaje;}
}
function modifcurfiguras($post,$min,$ilink) {
	extract($post);
	$mensaje = "<span class='rojo b'>Error al modificar Figura - Curso [$codfigura $curso].</span>";
	$edcodfigura = strtoupper(str_replace(" ","",$edcodfigura));
	if (!$edcurso) {$edcurso = "";}
	$edcurso = strtoupper(str_replace(" ","",$edcurso));
	if (!$edcurso) {$edcurso = "";}
	if (!$edcodfigura OR ($edcurso AND $edcurso < $min)) {return $mensaje;}
	$sql = "UPDATE podcursofigura SET curso = \"$edcurso\", codfigura = \"$edcodfigura\", creditos= \"$edcreditos\", creditosmin= \"$edcreditosmin\", tiempo= \"$edtiempo\" WHERE curso = \"$curso\" AND codfigura=\"$codfigura\"";
	$ilink->query($sql);
	if ($ilink->errno) {return $mensaje;}
}
function borrarcurfiguras($post,$ilink) {
	extract($post);
	$mensaje = "<span class='rojo b'>Error al borrar Figura - Curso [$codfigura $curso].</span>";
	$sql = "DELETE FROM podcursofigura WHERE  curso = \"$curso\" AND codfigura = \"$codfigura\"";
	$ilink->query($sql);
	if ($ilink->errno) {return $mensaje;}
}

// --------------------------------------------------
// --------------------------------------------------

function anadircargos($post,$ilink) {
	extract($post);
	$newcod = strtoupper(str_replace(" ","",$newcod));
	$mensaje = "<span class='rojo b'>Error al a&ntilde;adir Cargo [$newtipo].</span>";
	if (!$newcod OR !$newtipo) {return $mensaje;}
	$sql = "INSERT INTO podcargos (cod, tipo) VALUES (\"$newcod\", \"$newtipo\")";
	$ilink->query($sql);
	if ($ilink->errno) {return $mensaje;}
}
function modifcargos($post,$ilink) {
	extract($post);
	$edcod = strtoupper(str_replace(" ","",$edcod));
	$mensaje = "<span class='rojo b'>Error al modificar Cargo [$cod].</span>";
	if (!$edcod OR !$edtipo) {return $mensaje;}
	$sql = "UPDATE podcargos SET cod = \"$edcod\", tipo= \"$edtipo\" WHERE cod=\"$cod\"";
	$ilink->query($sql);
	if ($ilink->errno) {return $mensaje;}
}
function borrarcargos($post,$ilink) {
	extract($post);
	$mensaje = "<span class='rojo b'>Error al borrar Cargo [$cod].</span>";
	$sql = "DELETE FROM podcargos WHERE cod = \"$cod\"";
	$ilink->query($sql);
	if ($ilink->errno) {return $mensaje;}
}

// --------------------------------------------------
// --------------------------------------------------

function anadircurcargos($post,$min,$ilink) {
	extract($post);
	$mensaje = "<span class='rojo b'>Error al a&ntilde;adir Cargo - Curso [$newcodcargo $newcurso].</span>";
	$newcodcargo = strtoupper(str_replace(" ","",$newcodcargo));
	$newcurso = strtoupper(str_replace(" ","",$newcurso));
	if (!$newcurso) {$newcurso = "";}
	if (!$newcodcargo OR ($newcurso AND $newcurso < $min)) {return $mensaje;}
	$sql = "INSERT INTO podcursocargos (curso, codcargo, creditos) VALUES (\"$newcurso\", \"$newcodcargo\", \"$newcreditos\")";
	$ilink->query($sql);
	if ($ilink->errno) {return $mensaje;}
}
function modifcurcargos($post,$min,$ilink) {
	extract($post);
	$mensaje = "<span class='rojo b'>Error al modificar Cargo - Curso [$codcargo $curso].</span>";
	$edcodcargo = strtoupper(str_replace(" ","",$edcodcargo));
	if (!$edcurso) {$edcurso = "";}
	$edcurso = strtoupper(str_replace(" ","",$edcurso));
	if (!$edcurso) {$edcurso = "";}
	if (!$edcodcargo OR ($edcurso AND $edcurso < $min)) {return $mensaje;}
	$sql = "UPDATE podcursocargos SET curso = \"$edcurso\", codcargo = \"$edcodcargo\", creditos= \"$edcreditos\" WHERE curso = \"$curso\" AND codcargo=\"$codcargo\"";
	$ilink->query($sql);
	//recalccred($curso);
	//if ($curso != $edcurso) {recalccred($edcurso);}
	if ($ilink->errno) {return $mensaje;}
}
function borrarcurcargos($post,$ilink) {
	extract($post);
	$mensaje = "<span class='rojo b'>Error al borrar Cargo - Curso [$codcargo $curso].</span>";
	$sql = "DELETE FROM podcursocargos WHERE curso = \"$curso\" AND codcargo = \"$codcargo\"";
	$ilink->query($sql);
	if ($ilink->errno) {return $mensaje;}
}

// --------------------------------------------------
// --------------------------------------------------

function anadirprof($post,$ilink) {
	extract($post);
	$mensaje = "<span class='rojo b'>Error al a&ntilde;adir Profesor.</span>";
	//$newusuario = str_replace(" ","",$newusuario);
	//if (!$newalumnon OR !$newalumnoa OR !$newmail OR !$newusuario OR !$newpassword) {return $mensaje;}
	$sql = "INSERT INTO usuarios (alumnon, alumnoa, mail, usuario, password, menu, autorizado, tipo, fechaalta, menusimple) VALUES 
	(\"$alumnon\", \"$alumnoa\", \"$mail\", \"$usuario\", \"$password\", '1', '5', 'P', '".gmdate('Y-m-d h:s')."', 'a')";
	$ilink->query($sql);
	if ($ilink->errno) {return $mensaje;}
	return i("usuanadido",$ilink);
}
function modifprof($post,$ilink) {
	extract($post);
	$mensaje = "<span class='rojo b'>Error al modificar Profesor.</span>";
	//$edusuario = str_replace(" ","",$edusuario);
	//if (!$edalumnon OR !$edalumnoa OR !$edmail OR !$edusuario OR !$edpassword) {return $mensaje;}
	$sql = "UPDATE usuarios SET alumnon= \"$alumnon\", alumnoa= \"$alumnoa\", mail= \"$mail\", usuario= \"$usuario\", password= \"$password\" WHERE id=\"$id\"";
	$ilink->query($sql);
	if ($ilink->errno) {return $mensaje;}
}
function borrarprof($post,$ilink) {
	extract($post);
	$mensaje = "<span class='rojo b'>Error al borrar Profesor.</span>";
	$sql = "DELETE FROM usuarios WHERE id = \"$id\" LIMIT 1";
	$ilink->query($sql);
	if ($ilink->errno) {return $mensaje;}
}

// --------------------------------------------------
// --------------------------------------------------

function borrarcursoprof($post,$ilink) {
	extract($post);
	$mensaje = "<span class='rojo b'>Error al borrar Profesor - Curso.</span>";
	$sql = "DELETE FROM profcurareafigura WHERE profeid = \"$profeid\" AND curso = \"$cursoid\"";
	$ilink->query($sql);
	if ($ilink->errno) {return $mensaje;}
}
function anadircursoprof($post,$ilink) {
	extract($post);
	$mensaje = "<span class='rojo b'>Error al a&ntilde;adir Profesor - Curso.</span>";
	$curso = strtoupper(str_replace(" ","",$curso));
	if (!$curso) {$curso = "";}
	$sql = "INSERT INTO profcurareafigura (profeid, curso, area, figura) VALUES";
	$sql .= " ('$id', '$curso', '$area', '$figura')";
	$ilink->query($sql);
	if ($ilink->errno) {return $mensaje;}
}
function modifcursoprof($post,$ilink) {
	extract($post);
	$mensaje = "<span class='rojo b'>Error al modificar Profesor - Curso.</span>";
	if($doctor == "on") {$doctor=1;} else {$doctor=0;}
	$sql = "UPDATE profcurareafigura SET";
	$sql .= " area = '$area', figura = '$figura', doctor = '$doctor', examenes = '$examenes',";
	$sql .= " exacum = '$exacum', n_prof = '$n_prof', obs = '$obs', mail2 = '$mail2',";
	$sql .= " telefono = '$telefono', telefono1 = '$telefono1', despacho = '$despacho',";
	$sql .= " doctor = '$doctor', obs2 = '$obs2' WHERE ";
	$sql .= "curso = '$cursoid' AND profeid = '$profeid'";
	$ilink->query($sql);
	if ($ilink->errno) {return $mensaje;}
	// Borrar cargos marcados
	$mensaje = "<span class='rojo b'>Error al borrar Profesor - Curso - Cargo.</span>";
	$cargos = "SELECT cargo, tipo FROM profecargos";
	$cargos .= " LEFT JOIN podcargos ON profecargos.cargo = podcargos.cod";
	$cargos .= " WHERE profeid = '$profeid' AND curso = '$cursoid'";
	$cargos .= " ORDER BY tipo";
	$result1 = $ilink->query($cargos);
	$numcargos = $result1->num_rows;
	$cargos = "";
	$i = 0;
	while ($fila1 = $result1->fetch_array(MYSQLI_BOTH)) {
		if ($_POST['borrcargo'.$i] == "on") {
			$sql = "DELETE FROM profecargos WHERE";
			$sql .= " curso = '$cursoid' AND profeid = '$profeid' AND cargo = '$fila1[0]'"; 
			$ilink->query($sql);
			if ($ilink->errno) {return $mensaje;}
		} else {
			$mensaje = "<span class='rojo b'>Error al modificar Profesor - Curso - Cargo.</span>";
			$sql = "UPDATE profecargos SET cargo = '".$_POST['cargo'.$i]."' WHERE curso = '$cursoid' AND profeid = '$profeid' AND cargo = '$fila1[0]'";
			$ilink->query($sql);
			if ($ilink->errno) {return $mensaje;}
		}
		$i++;		
	}
	// A&ntilde;adir cargo seleccionado	
	if ($cargoanadir) {
		$mensaje = "<span class='rojo b'>Error al a&ntilde;adir Profesor - Curso - Cargo.</span>";
		$sql = "INSERT INTO profecargos (curso, profeid, cargo) VALUES";
		$sql .= " ('$cursoid', '$profeid', '$cargoanadir')";
		$ilink->query($sql);
		if ($ilink->errno) {return $mensaje;}
	}
}

// --------------------------------------------------
// --------------------------------------------------

function boasicur($ilink) {
	extract($_GET);
	$sql = "DELETE FROM asignatprof WHERE asigna = '$asigna' AND curso = '$curso'";
	$ilink->query($sql);
	$sql = "DELETE FROM cursasigru WHERE asigna = '$asigna' AND curso = '$curso'";
	$ilink->query($sql);
	$sql = "DELETE FROM podcursoasigna WHERE asigna = '$asigna' AND curso = '$curso'";
	$ilink->query($sql);
}

// --------------------------------------------------
// --------------------------------------------------

function anadirasignat($post,$ilink) {
	extract($post);
	$newcod = strtoupper(str_replace(" ","",$newcod));
	$mensaje = "<span class='rojo b'>Error al a&ntilde;adir Asignatura [$newcod].</span>";
	if (!$newcod OR !$newasignatura) {return $mensaje;}
	$sql = "INSERT INTO podasignaturas (cod, asignatura) VALUES (\"$newcod\", \"$newasignatura\")";
	$ilink->query($sql);
	if ($ilink->errno) {return $mensaje;}
}
function modifasignat($post,$ilink) {
	extract($post);
	$edcod = strtoupper(str_replace(" ","",$edcod));
	$mensaje = "<span class='rojo b'>Error al modificar Asignatura [$cod].</span>";
	if (!$edcod OR !$edasignatura) {return $mensaje;}
	$sql = "UPDATE podasignaturas SET cod = \"$edcod\", asignatura= \"$edasignatura\" WHERE cod=\"$cod\"";
	$ilink->query($sql);
	if ($ilink->errno) {return $mensaje;}
}
function borrarasignat($post,$ilink) {
	extract($post);
	$mensaje = "<span class='rojo b'>Error al borrar Asignatura [$cod].</span>";
	$sql = "DELETE FROM podasignaturas WHERE cod = \"$cod\"";
	$ilink->query($sql);
	if ($ilink->errno) {return $mensaje;}
}

// --------------------------------------------------
// --------------------------------------------------

function anadircursoasignat($post,$min,$ilink) {
	extract($post);
	$edcurso = trim(str_replace(" ","",$edcurso));
	if (!$edcurso) {$edcurso = "";}
	$mensaje = " <span class='rojo b'>Error al a&ntilde;adir Asignatura - Curso.</span>";
	if ($edcurso AND $edcurso < $min) {return $mensaje;}
	if ($edcurso) {$tipasig = 1;}
	$sql = "INSERT INTO podcursoasigna (curso, asigna, tipasig) VALUES ('$edcurso', '$edcod', '$tipasig')";
	$ilink->query($sql);
	//if ($ilink->errno) {return $mensaje;}
}
function modifcursoasignat($post,$ilink) {
	extract($post);
	$ilink->query("DELETE FROM podcursoasignatit WHERE curso = '$edcurso' AND asigna = '$edcod'");
	foreach($tit AS $clave=>$valor) {
		if ($valor) {
			$sql = "INSERT INTO podcursoasignatit (curso, asigna, tit) VALUES ('$edcurso', '$edcod', '$valor')";
			$result = $ilink->query($sql);
		}
	}
	foreach($area AS $clave=>$valor) {
		if ($valor) {
			if ($valor == $areaold[$clave]) {
				$sql = "UPDATE podcursoasignaarea SET ct = '".$ct[$clave]."', cp = '".$cp[$clave]."', cte = '".$cte[$clave]."', cpr = '".$cpr[$clave]."', cl = '".$cl[$clave]."', cs = '".$cs[$clave]."', ctu = '".$ctu[$clave]."', ce = '".$ce[$clave]."', grupoa = '".$grupoa[$clave]."' WHERE curso = '$edcurso' AND asigna = '$edcod' AND area = '$valor'";
				$ilink->query($sql);
			} else {
				if (!$areaold[$clave]) {
					//Si es nueva la a&ntilde;ado
					$sql = "INSERT INTO podcursoasignaarea (curso, asigna, area, ct, cp, cte, cpr, cl, cs, ctu, ce, grupoa) VALUES ('$edcurso', '$edcod', '$valor', '".$ct[$clave]."', '".$cp[$clave]."', '".$cte[$clave]."', '".$cpr[$clave]."', '".$cl[$clave]."', '".$cs[$clave]."', '".$ctu[$clave]."', '".$ce[$clave]."', '".$grupoa[$clave]."')";
					$ilink->query($sql);
				} else {
					//Si es un cambio de &aacute;rea hago update de areaold a valor
					$sql = "UPDATE podcursoasignaarea SET ct = '".$ct[$clave]."', cp = '".$cp[$clave]."', cte = '".$cte[$clave]."', cpr = '".$cpr[$clave]."', cl = '".$cl[$clave]."', cs = '".$cs[$clave]."', ctu = '".$ctu[$clave]."', ce = '".$ce[$clave]."', grupoa = '".$grupoa[$clave]."', area = '$valor' WHERE curso = '$edcurso' AND asigna = '$edcod' AND area = '".$areaold[$clave]."'";
					$ilink->query($sql);
				}
			}
		} elseif($areaold[$clave]) {
			$ilink->query("DELETE FROM podcursoasignaarea WHERE curso = '$edcurso' AND asigna = '$edcod' AND area = '".$areaold[$clave]."'");
		}	
	}
	$sql = "UPDATE podcursoasigna SET tipo = '$edtipo', tipasig = '$edtipasig', cursoasi = '$edcursoasi', responsabl = '$edresponsabl' WHERE curso = '$edcurso' AND asigna = '$edcod'";
	$ilink->query($sql);
}
function borrarcursoasignat($post,$ilink) {


}

// --------------------------------------------------
// --------------------------------------------------

function anadirasignacion($post,$ilink) {
	extract($post);
	$edgrupo = strtoupper(trim(str_replace(" ","",$edgrupo)));
	$iresult = $ilink->query("SELECT * FROM asignatprof WHERE usuid = '$ednombreprof' AND asigna = '$edcodigo' AND curso = '$edcurso' AND grupo = '$edgrupo'");
	$yahayasig = $iresult->fetch_array(MYSQLI_BOTH);
	if ($yahayasig['usuid']) {
		$usua = ponerusu($ednombreprof,1,$ilink);
		$usua = $usua[1];
		return "<span class='rojo b'>Ya hay una asignaci&oacute;n para ".$usua." en [$edcodigo $edcurso $edgrupo]</span>";
	}
	$ilink->query("INSERT INTO cursasigru (asigna, curso, grupo, visibleporalumnos, altalibre, gic) VALUES ('$edcodigo', '$edcurso', '$edgrupo','1','1','1')");
	$ilink->query("INSERT INTO asignatprof (asigna, usuid, ct, cp, cte, cpr, cl, cs, ctu, ce, curso, grupo, area) VALUES ('$edcodigo', '$ednombreprof', '$asigct', '$asigcp', '$asigcte', '$asigcpr', '$asigcl', '$asigcs', '$asigctu', '$asigce', '$edcurso', '$edgrupo', '$edarea')");
	//calculacred($ednombreprof,$edcurso);
	if ($ilink->errno) {return "Error al a&ntilde;adir la Asignaci&oacute;n en [ $edcodigo $edcurso].";}
	$ilink->query("INSERT INTO usuasi (id, asigna, auto) VALUES ('$ednombreprof', '$edcodigo', 5)");
	$ilink->query("INSERT INTO cursasigru (asigna, curso, grupo, visibleporalumnos, altalibre) VALUES ('$edcodigo', '$edcurso', '$edgrupo','1','1')");
	//Crear carpetas en evai de asigna-curso-grupo
	//crearcarpetas($edcodigo, $edcurso, $edgrupo);	
	return "<span class='txth b'>Asignaci&oacute;n realizada.</span>";
}
function editarasignacion($post,$ilink) {
	extract($post);
	$iresult = $ilink->query("SELECT usuid,curso FROM asignatprof WHERE id='$edid'");
	$old = $iresult->fetch_array(MYSQLI_BOTH);
	//calculacred($old[0],$old[1]);
	$ilink->query("UPDATE asignatprof SET usuid = '$edprof', ct ='$asigct', cp = '$asigcp', cte = '$asigcte', cpr = '$asigcpr', cl = '$asigcl', cs = '$asigcs', ctu = '$asigctu', ce = '$asigce' WHERE id = '$edid'");
}
function borrarasignacion($edid,$ilink) {
	$poderborrarasignac = poderborrarasignac($edid,$ilink);
	if ($poderborrarasignac) {
		$iresult = $ilink->query("SELECT asigna, curso, grupo, usuid FROM asignatprof WHERE id = '$edid'");
		$temp = $iresult->fetch_array(MYSQLI_BOTH);
		$mensaje .= " <span class='txth b'>Asignaci&oacute;n borrada: ";
		$usua = ponerusu($temp[3],1,$ilink);
		$mensaje .= $usua[1];
		$mensaje .= " [$temp[0] $temp[1] $temp[2]]</span>";		
		borrarasignacion1($edid,$poderborrarasignac,$ilink);
		return $mensaje;
	} else {
		//Alertar de que hay alumnos de asigna-curso-grupo, s&oacute;lo queda &eacute;l como profesor y no se puede borrar la asignaci&oacute;n.
		return "<span class='rojo b'>No se puede borrar la asignaci&oacute;n. Hay alumnos.</span>";		
	}
}
function borrarasignacion1($edid,$poderborrarasignac,$ilink) {
	$iresult = $ilink->query("SELECT asigna, curso, grupo, usuid FROM asignatprof WHERE id = '$edid'");
	$temp = $iresult->fetch_array(MYSQLI_BOTH);
	if ($poderborrarasignac == 1) {
		$ilink->query("DELETE FROM cursasigru WHERE asigna = '$temp[0]' AND curso = '$temp[1]' AND grupo = '$temp[2]'");
		$ilink->query("DELETE FROM clasesgrab WHERE codasign = '$temp[0]' AND curso = '$temp[1]' AND grupo = '$temp[2]'");
	}
	$ilink->query("DELETE FROM asignatprof WHERE id = '$edid'");
	$ilink->query("DELETE FROM usuasi WHERE id = '$temp[3]' AND asigna = '$temp[0]'");
	$ilink->query("UPDATE vinculos SET area = 'GEN' WHERE area = '$temp[0]' AND usu_id = '$temp[3]'");
	$ilink->query("UPDATE usuarios SET ultasigna = '', ultcurso = '', ultgrupo = '' WHERE id = '$temp[3]'");
	if ($poderborrarasignac == 1) {
		$ilink->query("DELETE FROM recurgen WHERE asigna = '$temp[0]' AND curso = '$temp[1]' AND grupo = '$temp[2]'");
		//Borrar carpetas en evai de asigna-curso-grupo
	}
}
function poderborrarasignac($edid,$ilink) {
	//Ver si hay m&aacute;s profesores para esa asigna-curso-grupo
	$iresult = $ilink->query("SELECT asigna, curso, grupo, usuid FROM asignatprof WHERE id = '$edid'");
	$temp = $iresult->fetch_array(MYSQLI_BOTH);
	$iresult = $ilink->query("SELECT usuid FROM asignatprof WHERE asigna = '$temp[0]' AND curso = '$temp[1]' AND grupo = '$temp[2]' AND usuid != '$temp[3]'");
	$otrosprof = $iresult->fetch_array(MYSQLI_BOTH);
	//Si no hay
	if (!$otrosprof[0]) {
		//Mirar si hay alumnos de esa asigna-curso-grupo
		$result = $ilink->query("SELECT id FROM alumasiano WHERE asigna = '$temp[0]' AND curso = '$temp[1]' AND grupo = '$temp[2]'");
		$otrosalu = $result->num_rows;
		if ($otrosalu == 0) {return 1;} else {return 0;}
	} else {
		return 2;
	}
}

// --------------------------------------------------
// --------------------------------------------------

function borrardir($dire,$cod,$ilink) {
	$dir = opendir($dire); 
	while($dir1 = readdir($dir)) {
		if (strtolower(substr($dir1,0,strlen($cod))) == strtolower($cod)) {
			borrardir1($dire.$dir1."/");
		}
	}
}

function borrardir1($dir,$ilink){
    if ($handle = opendir($dir)) {
    while (false !== ($file = readdir($handle))) {
        if ($file != "." && $file != "..") {
            if(is_dir($dir.$file)){
               borrardir1($dir.$file."/");
             } else {
             	safe_unlink($dir.$file);
            }
        }
	}
   closedir($handle);
	}
	safe_rmdir($dir);
}

?>