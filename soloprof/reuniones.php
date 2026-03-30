<?php

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

//-----------  NO SE EJECUTA  --------------------------------------------------

return;


unset($array);
$array[0] = "<a href='#'>Reuniones <span class='icon-arrow-right'></span></a>";
$array[1] = "<a href='?pest=12'>Crear nueva</a>";

if (noexisteopen($ilink) == 1) {
	$noopen=1;	
} else {
	$array[2] = "<a href='?pest=12&pestx=2'>Configurar</a>";
}

// --------------------------------------------------

if ($borruna) {
	borruna($borruna,$ilink);	
}

// --------------------------------------------------
extract($_GET);
$_POST['gruporeu'] = str_replace(" ","",$_POST['gruporeu']);
$_POST['gruporeu'] = str_replace("'","",$_POST['gruporeu']);
$_POST['gruporeu'] = str_replace("\"","",$_POST['gruporeu']);
$_POST['gruporeu'] = str_replace("&ntilde;","n",$_POST['gruporeu']);
extract($_POST);
// --------------------------------------------------

if (!$pestx) {$pestx = 1;}

// --------------------------------------------------

solapah($array,$pestx+1,"navhsimple");
	
// --------------------------------------------------

if ($noopen) {
	echo "<p>No existe la Base de Datos de Openmeetings.</p>";
} else {
	echo "<div class='colu'><span class='rojo b peq'>Atenci&oacute;n: Ha de estar activo el servidor RED5. La URL de acceso es <a href='http://openmeetings.evai.net:5080/openmeetings' target='_blank'>http://openmeetings.evai.net:5080/openmeetings</a>.
	 Para administrar, usuario: admin &nbsp password: passinicial</span><br>";
	echo "Las salas creadas son salas PRIVADAS, se ha de ir a 'Salas', 'Salas privadas' en Openmeetings.<br>";
	echo "Los usuarios entran con el nombre de usuario de <span class='b'>".SITE."</span> precedido de <span class='txth b'>".SITE."_</span> y su password de <span class='b'>".SITE."</span>.</div><p></p>";
	if ($pestx == 1) {nueva($ilink);} else {config($ilink);}
}

// --------------------------------------------------

function config($ilink) {
	$pref = SITE;
	echo "Reuniones existentes en Openmeetings: (Si se borra una sala xxxx_room_xxxx, se borrar&aacute; los usuarios y el grupo de usuarios asociado: xxxx_org_xxxx)";
	iconex("openmeetings",$ilink);
	$sql = "SELECT name FROM room WHERE name LIKE '$pref"."_room_%'";
	$result = $ilink->query($sql);
	echo "<p></p>";
	if ($result->num_rows) {
		while($fila = $result->fetch_array(MYSQLI_BOTH)) {
			echo $fila[0]." (<a href='?pest=12&pestx=2&borruna=$fila[0]'>Borrar</a>)<br>"; 
		}
	} else {
		echo "No hay";
	}
	iconex(SITE,$ilink);

// --------------------------------------------------

	if (!$_SESSION['soy_superadmin']) {return;}
	//Solo superadmin
	echo "<hr>";
	echo "<p>S&oacute;lo para superadministradores:</p>";
	echo "<p></p><a href='?pest=12&pestx=2&vaciar=1'>Vaciar la Base de Datos de Openmeetings de usuarios y salas o crearla si no existe.</a>";	
	echo "<br><span class='rojo b'>&iexcl;&iexcl;&iexcl;ATENCI&Oacute;N!!! Se borrar&aacute;n salas/usuarios de otros entornos virtuales que existan en el Servidor</span>";
	if ($_GET['vaciar'] == 1) {
		echo "<p></p><a href='?pest=12&pestx=2&vaciar1=1'>CONFIRMAR</a>";	
	}
	if ($_GET['vaciar1'] == 1) {
		if (!$ilink->select_db("openmeetings_base")) {
			echo "<p></p>No existe la Base de Datos <span class='b'>openmeetings_base</span>, no es posible vaciar.";
			iconex(SITE,$ilink);
			return;
		}
		$ilink->query("DROP DATABASE openmeetings");
		$ilink->query("CREATE DATABASE openmeetings DEFAULT CHARACTER SET 'utf8'");
		$sql = "SHOW TABLES FROM openmeetings_base";
		$result = $ilink->query($sql);
		while ($fila = $result->fetch_array(MYSQLI_BOTH)) {
			$ilink->query("CREATE TABLE openmeetings.$fila[0] LIKE openmeetings_base.$fila[0]");
			$ilink->query("INSERT INTO openmeetings.$fila[0] SELECT * FROM openmeetings_base.$fila[0]");
		}
		echo "<p></p> ... HECHO";
	}
	iconex(SITE,$ilink);
}

// --------------------------------------------------

function nueva($ilink) {
	extract($_GET);
	extract($_POST);
	if ($validar) {
		$ret = comprobardatos($ilink);
		if ($ret != "ok") {
			echo $ret;
		} else {
			$integrantes .= "*".$moderadores;
			if ($tit OR $asigna OR $anadirusu) {
				$ret = anadirintegr($integrantes,$ilink);
				$integrantes = $ret[1];
				echo $ret[0];
			} else {
				$bo = borrarlossinmarcar();
				if ($bo != 1) {$integrantes = $bo;}
			}
			$_POST['integrantes'] = $integrantes;
		}
		$ret = ajustar($integrantes,$moderadores,$ilink);
		$integrantes = $ret[0];
		$moderadores = $ret[1];
	}
	$canti = substr_count($integrantes, '*');if ($integrantes != "") {$canti = $canti+1;}
	if ($validar1) {
		crearopen($ilink,$canti);
	}
	echo "<table><form method='post' name='reunion'>";
	echo "<tr>";
	echo "<td class='col-01 nowrap'>Nombre corto<br>(letras, n&uacute;meros)</td>";
	echo "<td class='col-10'><input class='col-2' type='text' name='gruporeu' size='10' maxlength='10' value='$gruporeu'>";
	echo "</td>";
	echo "</tr>";
	echo "<tr>";
	echo "<td class='col-01'>Descripci&oacute;n</td>";
	echo "<td class='col-10'><textarea name='descripcion' rows='5' cols='100'>$descripcion</textarea></td>";
	echo "</tr>";
	echo "<tr>";
	echo "<td class='col-01'>";
	echo "#id de usuarios <span class='txth'>Moderadores</span><br><span class='peq'>separados por un asterisco (ej.: 2*25*128)</span>";
	echo "</td>";
	echo "<td>";
	echo "<input class='col-5' type='text' size='90' maxlength='255' name='moderadores' value='$moderadores'> <input class='col-1' type='submit' name='validar' value= '&nbsp; >> &nbsp;'>";
	echo "</td>";
	echo "</tr>";
	echo "<tr>";
	echo "<td class='col-01'>";
	echo "A&ntilde;adir <span class='txth'>Integrantes</span><br>";
	echo "<span class='peq'>titulaci&oacute;n-curso o asignatura-curso-grupo que exista</span>";
	echo "</td>";
	echo "<td>";
	echo i("titul",$ilink)." <input class='col-1' type='text' size='5' maxlength='5' name='tit'>";
	echo " ".i("asigna",$ilink)." <input class='col-1' type='text' size='15' maxlength='15' name='asigna'>";
	echo " ".i("curso",$ilink)." <input class='col-1' type='text' size='4' maxlength='4' name='curso'>";
	echo " ".i("grupo",$ilink)." <input class='col-1' type='text' size='1' maxlength='1' name='grupo'> <input class='col-1' type='submit' name='validar' value= '&nbsp; >> &nbsp;'>";
	echo "</td>";
	echo "</tr>";
	echo "<tr>";
	echo "<td class='col-01'>";
	echo "A&ntilde;adir <span class='txth'>Integrante</span><br><span class='peq'>por su #id de usuario</span>";
	echo "</td>";
	echo "<td>#id <input class='col-1' type='text' size='10' maxlenght='10' name='anadirusu'> <input class='col-1' type='submit' name='validar' value= '&nbsp; >> &nbsp;'>";
	echo "</td>";
	echo "</tr>";
	echo "<tr>";
	echo "<td class='col-01'>";
	echo "<span class='txth'>Integrantes</span> $canti<br>";
	echo "</td>";
	echo "<td><span class='peq'>";
	if ($canti) {echo "(Desmarcar usuarios para quitarlos de la reuni&oacute;n) <input type='submit' name='validar' value= '&nbsp; >> &nbsp;'>";}
	if ($integrantes) {
		echo "<span class='fr rojo'>Cuando no quieras a&ntilde;adir m&aacute;s integrantes click para crear la reuni&oacute;n en Openmeetings <input type='submit' name='validar1' value=' >>>> '></span>";
	}
	echo "</td>";
	echo "</tr>";
	echo "<tr>";
	echo "<td class='col-01' style='text-align:top'>";
	echo "</td>";
	echo "<td><input type='hidden' name='integrantes' value='$integrantes'>";
	listarinte($integrantes,$ilink);
	echo "</td>";
	echo "</tr>";
	echo "</form></table>";
	return;	
}

// --------------------------------------------------

function comprobardatos($ilink) {
	$pref = SITE;
	extract($_POST);
	if (!$moderadores OR !$gruporeu OR !$descripcion) {
		return "<span class='rojo b'>Completa: nombre corto, descripci&oacute;n y moderadores</span>";
	}
	$ilink->select_db("openmeetings");
	$sql = "SELECT name FROM room WHERE name = '$pref_room_$gruporeu'";
	$iresult = $ilink->query($sql);
	$fila = $iresult->fetch_array(MYSQLI_BOTH);
	if ($fila) {
		$mens = "<span class='rojo b'>La sala ya existe en Openmeetings. No se puede crear. Cambiar el nombre o borrar desde</span> <a href='?pest=12'>Reuniones</a>";
	}
	$sql = "SELECT name FROM organisation WHERE name = '$pref_org_$gruporeu'";
	$iresult =$ilink->query($sql);
	$fila = $iresult->fetch_array(MYSQLI_BOTH);
	if ($fila) {
		$mens = "<span class='rojo b'>El grupo de usuarios ya existe en Openmeetings. No se puede crear. Cambiar el nombre o borrar desde</span> <a href='?pest=12'>Reuniones</a>";
	}
	iconex(SITE,$ilink);
	if ($mens) {return $mens;}
	$mods = explode("*",$moderadores);
	foreach($mods AS $mod) {
		if (!$mod) {continue;}
		$iresult = $ilink->query("SELECT id, fechabaja, autorizado FROM usuarios WHERE id = '$mod' LIMIT 1");
		$fila = $iresult->fetch_array(MYSQLI_BOTH);
		if (!$fila) {return "<span class='rojo'>No existe ning&uacute;n usuario con #id <span class='b i'>$mod</span>.</span><p></p>";}
		if ($fila[1] != "0000-00-00 00:00:00") {return "El usuario de #id <span class='b u'>$mod</span> est&aacute; dado de baja.<p></p>";}
		if ($fila[2] < 4) {return "El usuario de #id <span class='b u'>$mod</span> tiene una autorizaci&oacute;n en el entorno virtual baja.<p></p>";}
	}
	return "ok";
}

// --------------------------------------------------

function anadirintegr($integrantes1,$ilink) {
	extract($_POST);
	if ($tit AND $asigna) {$ret[0] = "<span class='rojo'>Elige Titulaci&oacute;n o Asignatura.</span><p></p>"; return $ret;}
	if ($tit AND $grupo) {$ret[0] = "<span class='rojo'>En Titulaciones no hay grupos.</span><p></p>"; return $ret;}
	if ($anadirusu) {
		$iresult = $ilink->query("SELECT id, CONCAT(alumnon,' ',alumnoa) FROM usuarios WHERE id = '$anadirusu' AND fechabaja ='0000-00-00 00:00:00' AND autorizado > 3 LIMIT 1");
		$fila = $iresult->fetch_array(MYSQLI_BOTH);
		if (!$fila) {return "<span class='rojo'>No se ha a&ntilde;adido usuario #id $anadirusu.</span><p></p>";}	
		$inte = $integrantes1."*".$anadirusu;
		$ret[0] = "<span class='txth'>A&ntilde;adido usuario: <span class='b'>$fila[1]</span></span><p></p>";
		$ret[1] = $inte;
		return $ret;
	} else {
		if ($asigna AND existe($asigna,$curso,$grupo)) {$valido = "ok";}
		if ($tit) {
			$iresult = $ilink->query("SELECT * FROM podtitulacion WHERE cod = '$tit'");
			$fila = $iresult->fetch_array(MYSQLI_BOTH);
			if ($fila) {$valido = "ok";}
		}
	}
	if ($valido != "ok") {$ret[0] = "<span class='rojo'>No se ha a&ntilde;adido.</span><p></p>"; return $ret;}

	//cogido de fotoscurso.php
	if ($tit) {
		$sqlprof = "SELECT DISTINCT usuarios.id FROM asignatprof LEFT JOIN podcursoasignatit
		ON asignatprof.asigna = podcursoasignatit.asigna AND asignatprof.curso = podcursoasignatit.curso
		LEFT JOIN usuarios ON asignatprof.usuid = usuarios.id
		WHERE autorizado > 1 AND fechabaja = '0000-00-00 00:00:00' AND podcursoasignatit.tit = '$tit'
		AND asignatprof.curso = '$curso' AND usuarios.id > 0";
		$sqlalu = "SELECT DISTINCT usuarios.id FROM alumasiano LEFT JOIN podcursoasignatit
		ON alumasiano.asigna = podcursoasignatit.asigna AND alumasiano.curso = podcursoasignatit.curso
		LEFT JOIN usuarios ON alumasiano.id = usuarios.id
		WHERE auto > 1 AND autorizado > 1 AND fechabaja = '0000-00-00 00:00:00'
		AND podcursoasignatit.tit = '$tit' AND alumasiano.curso = '$curso'";
	} else {
		$sqlprof = "SELECT DISTINCT usuarios.id FROM asignatprof LEFT JOIN usuarios ON asignatprof.usuid = usuarios.id WHERE autorizado > 1 AND fechabaja = '0000-00-00 00:00:00' AND asigna = '$asigna' AND curso = '$curso' AND grupo = '$grupo' AND usuarios.id > 0";
		$sqlalu = "SELECT DISTINCT usuarios.id FROM alumasiano LEFT JOIN usuarios ON alumasiano.id = usuarios.id WHERE auto > 1 AND autorizado > 1 AND fechabaja = '0000-00-00 00:00:00' AND asigna = '$asigna' AND curso = '$curso' AND grupo = '$grupo'";
	}
	$result = $ilink->query($sqlprof);
	while ($fila = $result->fetch_array(MYSQLI_BOTH)) {
		$integr .= "*".$fila[0];	
	}
	$result = $ilink->query($sqlalu);
	while ($fila = $result->fetch_array(MYSQLI_BOTH)) {
		$integr .= "*".$fila[0];	
	}
	$integr .= "*";
	$i = $integrantes1.$integr;
	$ret[1] = $i; return $ret;
}

function ajustar($integrantes,$moderadores,$ilink) {
	$i = str_replace("**","*",$integrantes);
	$array = explode("*",$i);
	$array = array_unique($array);
	$i = implode("*",$array);
	$integrantes = str_replace("**","*",$i);
	$arrayintegr = explode("*",$integrantes);

	$m = str_replace("**","*",$moderadores);
	$array = explode("*",$m);
	$array = array_unique($array);
	$m = implode("*",$array);
	$moderadores = str_replace("**","*",$m);
	$arraymoder = explode("*",$moderadores);
	
	foreach ($arraymoder AS $moderador) {
		if (array_search($moderador,$arrayintegr) == NULL) {
			$integrantes .= "*".$moderador;
		}	
	}

	$ret[0] = ordenar($integrantes,$ilink);
	$ret[1] = ordenar($moderadores,$ilink);
	
	return $ret;
}

function listarinte($integrantes,$ilink) {
	$intes = explode("*",$integrantes);
	foreach ($intes AS $inte) {
		if (!$inte) {continue;}
		echo "<input type='checkbox' name='usuenv[]' value='$inte' checked='checked'> ";
		$usua = ponerusu($inte,1,$ilink);
		echo $usua[0];
		echo $usua[1];
	}
}

function ordenar($cadena,$ilink) {
	if ($cadena == "*") {$cadena = "";}
	if (!$cadena) {return;}
	$array = explode("*",$cadena);
	$array = array_unique($array);
	foreach($array AS $elem) { 
	if (!$elem) {continue;}
		$iresult = $ilink->query("SELECT CONCAT(alumnoa,' ',alumnon) FROM usuarios WHERE id = '$elem' LIMIT 1");
		$apelnom = $iresult->fetch_array(MYSQLI_BOTH);
		$array1[$n] = $apelnom[0]."$".$elem;
		$n++;
	}	
		
	asort($array1);
	$n = "";
	foreach($array1 AS $key => $value) {
		$temp = explode("$",$value);
		$array2[$n] = $temp[1];
		$n++;
	}
	$cadena = implode("*",$array2);
	return $cadena;
	
}

function borrarlossinmarcar() {
	if (!$_POST['usuenv']) {return 1;}
	$cadena = implode("*",$_POST['usuenv']);
	$cadena = str_replace("**","*",$cadena);
	return $cadena;
}

function noexisteopen($ilink) {
	if (!$ilink->select_db("openmeetings")) {
		iconex(SITE,$ilink);
		return 1;
	}
	iconex(SITE,$ilink);
}

function crearopen($ilink,$canti) {
	$pref = SITE;
	extract($_POST);
	$inte = explode("*",$integrantes);
	$mode = explode("*",$moderadores);
	$ilink->select_db("openmeetings");
	$sql = "INSERT INTO `room` (`allow_font_styles`, `allow_recording`, `allow_user_questions`, `appointment`, `auto_video_select`, `chat_moderated`, 
			`chat_opened`, `comment_field`, `confno`, `deleted`, `demo_time`, `externalRoomId`, `externalRoomType`, `files_opened`, `hide_actions_menu`, 
			`hide_activities_and_actions`, `hide_chat`, `hide_files_explorer`, `hide_screen_sharing`, `hide_top_bar`, `hide_whiteboard`, 
			`is_audio_only`, `is_closed`, `isdemoroom`, `ismoderatedroom`, `ispublic`, `name`, `numberOfPartizipants`, `owner_id`, `pin`, `redirect_url`, 
			`show_microphone_status`, `sip_enabled`, `starttime`, `updatetime`, `wait_for_recording`, `roomtypes_id`) VALUES
			(b'0', b'0', b'0', b'0', b'0', b'0', b'0', \"$descripcion\", NULL, b'0', NULL, NULL, NULL, b'0', b'0', b'0', b'0', b'0', b'0', b'0', b'0', b'0', b'0', 
			b'0', b'0', b'0', '".$pref."_room_"."$gruporeu', $canti, 0, NULL, '', b'0', b'0', '".gmdate("Y-m-d H:i:s")."', NULL, b'0', 1)";
	$iresult = $ilink->query($sql);
	$lastidroom = $result->insert_id;
	$sql = "INSERT INTO organisation (deleted, name, starttime) VALUES (0,'".$pref."_org_"."$gruporeu', '".gmdate("Y-m-d H:i:s")."')";
	$iresult = $ilink->query($sql);
	$lastidorga = $result->insert_id;
	$sql = "INSERT INTO `rooms_organisation` (`deleted`, `starttime`, `updatetime`, `rooms_id`, `organisation_id`) VALUES
				(b'0', '".gmdate("Y-m-d H:i:s")."', NULL, '$lastidroom', '$lastidorga')";
	$ilink->query($sql);			
	foreach ($inte AS $key => $value) {
		$level_id = 1; if (in_array($value, $mode)) {$level_id = 2;}
		iconex(SITE,$ilink);
		$iresult = $ilink->query("SELECT alumnon, alumnoa, foto, usuario, password, mail FROM usuarios WHERE id ='$value'");
		$usu = $iresult->fetch_array(MYSQLI_BOTH);
		extract($usu);
		iconex("openmeetings",$ilink);
		$sql = "INSERT INTO address (email) VALUES ('$mail')";
		$iresult = $ilink->query($sql);
		$lastid = $iresult->insert_id;
		$sql = "INSERT INTO om_user (id,availible,deleted,firstname,language_id,lastname,level_id,login,password,pictureuri,adresses_id,omtimezoneId) VALUES
				('$lastid',1,0,'$alumnon',8,'$alumnoa','$level_id','".$pref."_"."$usuario','".md5($password)."','','$lastid','22')";
		$ilink->query($sql);
		if (in_array($value, $mode)) {
			$sql = "INSERT INTO `rooms_moderator` (`deleted`, `is_supermoderator`, `roomId`, `starttime`, `updatetime`, `user_id`) VALUES
					(b'0', b'1', '$lastidroom', '".gmdate("Y-m-d H:i:s")."', NULL, '$lastid')";
			$ilink->query($sql);
		}
		$sql = "INSERT INTO organisation_users (deleted,user_id,organisation_id) VALUES (0,'$lastid','$lastidorga')";
		$ilink->query($sql);
	}
	//A&ntilde;adir usuario admin a la organizaci&oacute;n
	$sql = "INSERT INTO organisation_users (deleted,user_id,organisation_id) VALUES (0,'1','$lastidorga')";
	$ilink->query($sql);
	echo " <h3>CREADA</h3><p></p>";	
	iconex(SITE,$ilink);
}

function vaciaropenmeetings($ilink) {
	$ilink->select_db("openmeetings");
	$sql = "DELETE FROM organisation_users";
	$ilink->query($sql);
	$sql = "DELETE FROM om_users WHERE id != '1'";
	$ilink->query($sql);
	$sql = "DELETE FROM address WHERE id != '1'";
	$ilink->query($sql);
	$sql = "DELETE FROM room";
	$ilink->query($sql);
	iconex(SITE,$ilink);
}

function borruna($sala,$ilink) {
	$ilink->select_db("openmeetings");
	$iresult = $ilink->query("SELECT id FROM room WHERE name = '$sala'");
	$room = $iresult->fetch_array(MYSQLI_BOTH);
	$org = str_replace("_room_","_org_",$sala);
	$iresult = $ilink->query("SELECT id FROM organisation WHERE name = '$org'");
	$orga = $iresult->fetch_array(MYSQLI_BOTH);
	//Borrar moderadores de la sala
	$sql = "DELETE FROM rooms_moderator WHERE roomid = '$room[0]'";
	$ilink->query($sql);
	//Sacamos de la org a los usuarios
	$sql = "DELETE FROM organisation_users WHERE organisation_id = '$orga[0]";
	$ilink->query($sql);
	//Borrar usuarios sin org
	$sql = "SELECT DISTINCT(om_user.id) FROM om_user LEFT JOIN organisation_users ON om_user.id = organisation_users.user_id WHERE om_user.id != '1' AND organisation_id = NULL";
	$result = $ilink->query($sql);
	while ($fila = $result->fetch_array(MYSQLI_BOTH)) {
		$sql1 = "DELETE FROM om_user WHERE id = '$fila[0]'";
		$ilink->query($sql1);
	}
	//Borrar la org
	$sql = "DELETE FROM organisation WHERE id = '$orga[0]'";
	$ilink->query($sql);
	//Borrar la room
	$sql = "DELETE FROM room WHERE name = '$sala'";
	$ilink->query($sql);
		
	iconex(SITE,$ilink);
}

?>
