<?php

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

function borrar($usuid, $asigna, $curso, $grupo, $ilink) {

	$u = $usuid; require_once APP_DIR . '/gic_actu.php';

	$borrar = 0; $cambiaragen = 0;

	$sql = "SELECT asigna FROM alumasiano WHERE id = '$usuid' AND asigna = '$asigna'";
	$iresult = $ilink->query($sql);
	$numanos = $iresult->num_rows;

	if ($numanos > 1) {
		
		$borrar = 1;
		
	} else {

		if ($numanos == 1) {
			$sql = "SELECT numvinc FROM usuasi WHERE id = '$usuid' AND asigna = '$asigna'";
			$iresult = $ilink->query($sql);
			$numvinc = $iresult->fetch_array(MYSQLI_BOTH);
			if ($numvinc[0] > 0) {$cambiaragen = 1;} else {$borrar = 1;}
		}

	}

	if ($borrar == 1 AND $numanos > 0) {

		$ilink->query("DELETE FROM alumasiano WHERE id = '$usuid' AND asigna = '$asigna' AND curso = '$curso' AND grupo = '$grupo'");
	}

	if ($borrar == 1 AND $numanos == 1) {

		$ilink->query("DELETE FROM usuasi WHERE id = '$usuid' AND asigna = '$asigna'");

	}

	if ($cambiaragen == 1) {

		$iresult = $ilink->query("SELECT asigna FROM usuasi WHERE id = '$usuid' AND asigna = 'GEN'");
		$temp = $iresult->num_rows;

		if ($temp > 0) {

			$ilink->query("DELETE FROM usuasi WHERE id = '$usuid' AND asigna = '$asigna'");
			if ($ilink->errno) {die ("Error");}

		} else {

			$ilink->query("UPDATE usuasi SET asigna = 'GEN'  WHERE id = '$usuid' AND asigna = '$asigna'"); 
			if ($ilink->errno) {die ("Error2");}

		}

		$ilink->query("DELETE FROM alumasiano WHERE id = '$usuid' AND asigna = '$asigna' AND curso = '$curso'");
		if ($ilink->errno) {die ("Error3");}

		$ilink->query("UPDATE vinculos SET area = 'GEN' WHERE area = '$asigna' AND usu_id = '$usuid'");
		if ($ilink->errno) {die ("Error4");}

	}

	$iresult = $ilink->query("SELECT * from alumasiano WHERE id = '$usuid'");
	$temp = $iresult->fetch_array(MYSQLI_BOTH);

	if (!$temp) {
		$ilink->query("UPDATE usuarios SET tipo = 'E' WHERE id ='$usuid' LIMIT 1");
	}

	if (!$temp AND $usuid == $_SESSION['usuid']) {
		$_SESSION['tipo'] = 'E';
		$_SESSION['asigna'] = "";
		$_SESSION['tit'] = "";
		$_SESSION['curso'] = "";
		$_SESSION['grupo'] = "";
	}

	$u = $usuid; require_once APP_DIR . '/gic_actu.php';

	$ilink->query("UPDATE usuarios SET ultasigna = '', ultcurso = '', ultgrupo = '' WHERE id ='$usuid' LIMIT 1");

}

// --------------------------------------------------

function anadir($usuid, $edcurasigru,$ilink) {

	$edcurasigru = explode("*",$edcurasigru);
	$curso = $edcurasigru[0];
	$asigna = $edcurasigru[1];
	$grupo = $edcurasigru[2];	

	$sql = "SELECT asigna,grupo FROM alumasiano WHERE id = '$usuid' AND asigna = '$asigna'
		AND curso = '$curso'";
	$result = $ilink->query($sql);
	if ($result->num_rows > 0) {
		$iresult = $ilink->query($sql);
		$grupo = $iresult->fetch_array(MYSQLI_BOTH);
		$grupo = $grupo[1];
		$mensaje = "<div class='colu'>".i("yaestasalu",$ilink)."<span class='b'>".$asigna;
		if ($curso) {$mensaje .= " / $curso";}
		if ($grupo) {$mensaje .= " / $grupo";}
		$mensaje .= "</span></div>";
		return $mensaje;
	}

	$sql = "SELECT usuid FROM asignatprof LEFT JOIN usuarios ON asignatprof.usuid = usuarios.id WHERE asigna = '$asigna' AND curso = '$curso' AND grupo = '$grupo' AND fechabaja = '0000-00-00 00:00:00'";
	$profesores = $ilink->query($sql);
	if ($profesores->num_rows == 0) {
		$mensaje = "<span class='rojo'>".i("nexistprof",$ilink).": $asigna";
		if ($curso) {$mensaje .= " - $curso";}
		if ($grupo) {$mensaje .= " - $grupo";}
		$mensaje .= ". ".i("noregis",$ilink)."</span>";
		return $mensaje;
	}

	$sql = "SELECT altalibre, patronmail, visibleporalumnos FROM cursasigru WHERE asigna = '$asigna' AND curso = '$curso' AND grupo = '$grupo'";
	$iresult = $ilink->query($sql);
	$fila = $iresult->fetch_array(MYSQLI_BOTH);
	if (!$fila[0] AND (!$fila[1] OR ($fila[1] AND !stristr($mail[0],trim($fila[1]))))) {
		//Enviar hsm a profesores de solicitud de alta en asigna-curso-grupo
		$temp = $ilink->query("SELECT usuid FROM asignatprof LEFT JOIN usuarios ON asignatprof.usuid = usuarios.id WHERE asigna = '$asigna' AND curso = '$curso' AND grupo = '$grupo' AND fechabaja = '0000-00-00 00:00:00'");
		if ($temp->num_rows) {
			$hsm = i("solicitalu",$ilink)." [$asigna $curso $grupo]. ";
			while ($fila = $temp->fetch_array(MYSQLI_BOTH)) {
				//enviar hsm a cada profesor				porhsm($hsm,$fila[0],'',$ilink);
			}
			$enviohsm = 1;
		}
		if ($enviohsm) {return "<div class='colu'>Se ha enviado tu solicitud a los profesores de la Asignatura.</div>";}
		return;
	}


	$sql = "INSERT INTO alumasiano (id, asigna, curso, grupo, veforo, auto) values
		('$usuid', '$asigna', '$curso', '$grupo', 1, '4')";
	$ilink->query($sql);
	$ilink->query("INSERT INTO usuasi (id, asigna) values ('$usuid', '$asigna')");

	//if ($fila[2]) {
		$_SESSION['asigna'] = trim($asigna);
		$_SESSION['curso'] = $curso;
		$_SESSION['grupo'] = $grupo;
		$tit = "SELECT tit FROM podcursoasignatit WHERE curso = '$curso' AND asigna = '$asigna' AND grupo = '$grupo'";
		$_SESSION['tit'] = $tit[0];
	//}
	
	$mensaje = "<div class='colu'>".i("asigregis",$ilink)."</div>";
	return $mensaje;

}

?>