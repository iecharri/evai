<?php

// Copyright (c) 2000-2026 Inmaculada Echarri San Adrián
// Copyright (c) 2000-2026 Antonio Grandío Botella
// This file is part of EVAI.
// Licensed under the MIT License.
// See LICENSE.txt for details.

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

if ($_SESSION['auto'] < 5) {exit;}

extract($_POST);
require_once APP_DIR . '/asigalu1.php';

if ($_SESSION['auto'] == 10 AND $_POST['autoval']) {

	$iresult = $ilink->query("SELECT autorizado FROM usuarios WHERE id = '$usuid' LIMIT 1");
	$temp = $iresult->fetch_array(MYSQLI_BOTH);
	if ($_POST['autorizado'] == 5 AND $temp[0] == 4) {$mens = "No se puede dar autorizaci&oacute;n de Profesor al usuario."; $_POST['autorizado'] = $temp[0];}
	if ($_POST['autorizado'] == 4 AND $temp[0] == 5) {$mens = "No se puede quitar la autorizaci&oacute;n a un Profesor, para desautorizar al usuario, ponerle autorizaci&oacute;n menor de 3."; $_POST['autorizado'] = $temp[0];}
	if (!$mens) {
		if ($_SESSION['auto'] >= $_POST['autorizado']) {$ilink->query("UPDATE usuarios SET texto = '".$_POST['texto']."', autorizado = '".$_POST['autorizado']."' WHERE id = '$usuid'");}
	}

}

// --------------------------------------------------

if ($_POST['autorizadoxprof'] == 4) {
	$ilink->query("UPDATE usuarios SET autorizado = '4' WHERE id = '$usuid'");
}

// --------------------------------------------------

if ($autoval) {

	$temp = $ilink->query("SELECT asigna, curso, grupo FROM alumasiano WHERE id='$usuid'");
	while ($fila = $temp->fetch_array(MYSQLI_BOTH)) {
		if (esprofesor($fila[0],$fila[1],$fila[2],$ilink) OR soyadmiano($fila[0],$fila[1],$ilink)) {
			$borrar = "b*".$fila[0];
			//if ($fila[1]) {
			$borrar .= "*".$fila[1];
			//}
			//if ($fila[2]) {
			$borrar .= "*".$fila[2];
			//}
			$borrar = str_replace(".","%",str_replace(" ","=",$borrar));
			if ($_POST[$borrar]) {
				$borrar = str_replace("%",".",str_replace("="," ",$borrar));
				$borrar = explode("*",substr($borrar,2));
				borrar($usuid,$borrar[0],$borrar[1],$borrar[2],$ilink);
				$mens1 = i("hecho",$ilink);
			}
			if ($_POST[str_replace(".","%",str_replace(" ","=",$fila[0]))] < 5) {
				$ilink->query("UPDATE alumasiano SET auto = '".$_POST[str_replace(".","%",str_replace(" ","=",$fila[0]))]."' WHERE id = '$usuid' AND asigna = '".str_replace("="," ",$fila[0])."' AND curso = '$fila[1]' AND grupo = '$fila[2]'");
				if ($asigna < 2) {$ilink->query("UPDATE usuarios SET ultasigna = '', ultcurso = '', ultgrupo = '' WHERE id = '$usuid'");}
			}
		}
	}

}

// --------------------------------------------------

if ($asignaext1) {
	$mens_anadir = anadiren($asignaext1,$curso1,$grupo1,$usuid,$ilink);
}
if ($asignaext2) {
	$mens_anadir .= "<br>".anadiren($asignaext2, $curso2, $grupo2, $usuid,$ilink);
}
if ($asignaext3) {
	$mens_anadir .= "<br>".anadiren($asignaext3, $curso3, $grupo3, $usuid,$ilink);
}
if ($asignaext4) {
	$mens_anadir .= "<br>".anadiren($asignaext4, $curso4, $grupo4, $usuid,$ilink);
}
if ($asignaext5) {
	$mens_anadir .= "<br>".anadiren($asignaext5, $curso5, $grupo5, $usuid,$ilink);
}
if ($asignaext6) {
	$mens_anadir .= "<br>".anadiren($asignaext6, $curso6, $grupo6, $usuid,$ilink);
}
if ($asignaext7) {
	$mens_anadir .= "<br>".anadiren($asignaext7, $curso7, $grupo7, $usuid,$ilink);
}
if ($asignaext8) {
	$mens_anadir .= "<br>".anadiren($asignaext8, $curso8, $grupo8, $usuid,$ilink);
}
if ($asignaext9) {
	$mens_anadir .= "<br>".anadiren($asignaext9, $curso9, $grupo9, $usuid,$ilink);
}
if ($asignaext10) {
	$mens_anadir .= "<br>".anadiren($asignaext10, $curso10, $grupo10, $usuid,$ilink);
}

// --------------------------------------------------

?>

<form method='post' name='form1'>

<?php

$sql = "SELECT autorizado, texto, tipo FROM usuarios WHERE id = '$usuid' LIMIT 1";
$result = $ilink->query($sql);
$fila = $result->fetch_array(MYSQLI_BOTH);
extract($fila);

$n = 0;

if ($_SESSION['auto'] == 10) {

	echo "<p class='both'></p>Opci&oacute;n s&oacute;lo para <span class='b'>Administradores</span>: 
	Utilizar para cambiar de <B>3 a 4</B> para <B> validar</B> un usuario o de <B>4 a inferior</B> para <B>bloquearlo</B>.
	<br>Tambi&eacute;n para dar a un <b>Profesor</b> la autorizaci&oacute;n de <b>5</b> y a cualquier usuario 
	autorizaci&oacute;n <B>10</B> de <B>Administrador</B>.<p></p>Autorizaci&oacute;n general:<br> 
	<input class='col-1' type='text' name='autorizado' size='2' maxlength='2' value='$autorizado'>";
	echo "<br>Texto personal a mostrar: <input type='text' name='texto' size='50' maxlength='255' value='$texto'><p></p>";
	$n = 1;

} else {

	if (esprofdeid($usuid,$ilink)) {
		if ($autorizado < 4) {
			echo "<p></p>Autorizaci&oacute;n <span class='rojo b'>general</span> del alumno en ".strtoupper(SITE)." (Dar valor 4 para autorizarlo) 
			<input class='col-1' type='text' name='autorizadoxprof' size='1' maxlength='1' value='$autorizado'>";
		} else {
			echo "<p></p>Autorizaci&oacute;n <span class='rojo b'>general</span> del alumno en ".strtoupper(SITE).": $autorizado";
		}	
	}

}

// --------------------------------------------------

if ($tipo == "A") {

	$temp = $ilink->query("SELECT auto, asigna, curso, grupo FROM alumasiano WHERE id='$usuid'");

	echo "<p></p>Estas son las <span class='b'>autorizaciones</span> para este <B>Alumno</B> en las siguientes <B>Asignaturas</B>.<br>S&oacute;lo las podr&aacute; cambiar un <B>Profesor</B> de las mismas. El m&aacute;ximo valor es <b>4</b><p></p>";

	while ($fila = $temp->fetch_array(MYSQLI_BOTH)) {

		echo "<br>Autorizaci&oacute;n en <span class='b'>".$fila['asigna']."</span> ";
		echo "<span class='b'>".$fila['curso']."</span> ";
		echo "<span class='b'>".$fila['grupo']."</span>: ";
		echo "<input class='col-1' type='text' name='".str_replace(".","%",str_replace(" ","=",$fila['asigna']))."' size='1' maxlength='1' value='$fila[0]'";
		if (!esprofesor($fila['asigna'],$fila['curso'],$fila['grupo'],$ilink) AND !soyadmiano($fila['asigna'],$fila['curso'],$ilink)) {
			echo " readonly>";
		} else {
			echo "> Borrar de <span class='b'>".$fila['asigna']." ".$fila['curso']." ".$fila['grupo']."</span>: 
			<input type='checkbox' name='b*".str_replace(".","%",str_replace(" ","=",$fila['asigna']));
			echo "*".$fila['curso'];
			echo "*".$fila['grupo'];
			echo "'>";
			$n = 1;
		}

	}

	echo "<p></p>";

}

if ($tipo == "E" OR $tipo == "A") {

	$n = 1;

	echo "Autorizar como Alumno de la Asignatura / Curso / Grupo ";
	echo "<input class='col-1' type='text' name='asignaext1' size='15' maxlength='15'> / ";
	echo "<input class='col-1' type='text' name='curso1' size='4' maxlength='4'> / ";
	echo "<input class='col-1' type='text' name='grupo1' size='4' maxlength='4'><br>";

	echo "Autorizar como Alumno de la Asignatura / Curso / Grupo ";
	echo "<input class='col-1' type='text' name='asignaext2' size='15' maxlength='15'> / ";
	echo "<input class='col-1' type='text' name='curso2' size='4' maxlength='4'> / ";
	echo "<input class='col-1' type='text' name='grupo2' size='4' maxlength='4'><br>";

	echo "Autorizar como Alumno de la Asignatura / Curso / Grupo ";
	echo "<input class='col-1' type='text' name='asignaext3' size='15' maxlength='15'> / ";
	echo "<input class='col-1' type='text' name='curso3' size='4' maxlength='4'> / ";
	echo "<input class='col-1' type='text' name='grupo3' size='4' maxlength='4'><br>";

	echo "Autorizar como Alumno de la Asignatura / Curso / Grupo ";
	echo "<input class='col-1' type='text' name='asignaext4' size='15' maxlength='15'> / ";
	echo "<input class='col-1' type='text' name='curso4' size='4' maxlength='4'> / ";
	echo "<input class='col-1' type='text' name='grupo4' size='4' maxlength='4'><br>";

	echo "Autorizar como Alumno de la Asignatura / Curso / Grupo ";
	echo "<input class='col-1' type='text' name='asignaext5' size='15' maxlength='15'> / ";
	echo "<input class='col-1' type='text' name='curso5' size='4' maxlength='4'> / ";
	echo "<input class='col-1' type='text' name='grupo5' size='4' maxlength='4'><br>";

	echo "Autorizar como Alumno de la Asignatura / Curso / Grupo ";
	echo "<input class='col-1' type='text' name='asignaext6' size='15' maxlength='15'> / ";
	echo "<input class='col-1' type='text' name='curso6' size='4' maxlength='4'> / ";
	echo "<input class='col-1' type='text' name='grupo6' size='4' maxlength='4'><br>";

	echo "Autorizar como Alumno de la Asignatura / Curso / Grupo ";
	echo "<input class='col-1' type='text' name='asignaext7' size='15' maxlength='15'> / ";
	echo "<input class='col-1' type='text' name='curso7' size='4' maxlength='4'> / ";
	echo "<input class='col-1' type='text' name='grupo7' size='4' maxlength='4'><br>";

	echo "Autorizar como Alumno de la Asignatura / Curso / Grupo ";
	echo "<input class='col-1' type='text' name='asignaext8' size='15' maxlength='15'> / ";
	echo "<input class='col-1' type='text' name='curso8' size='4' maxlength='4'> / ";
	echo "<input class='col-1' type='text' name='grupo8' size='4' maxlength='4'><br>";

	echo "Autorizar como Alumno de la Asignatura / Curso / Grupo ";
	echo "<input class='col-1' type='text' name='asignaext9' size='15' maxlength='15'> / ";
	echo "<input class='col-1' type='text' name='curso9' size='4' maxlength='4'> / ";
	echo "<input class='col-1' type='text' name='grupo9' size='4' maxlength='4'><br>";

	echo "Autorizar como Alumno de la Asignatura / Curso / Grupo ";
	echo "<input class='col-1' type='text' name='asignaext10' size='15' maxlength='15'> / ";
	echo "<input class='col-1' type='text' name='curso10' size='4' maxlength='4'> / ";
	echo "<input class='col-1' type='text' name='grupo10' size='4' maxlength='4'><p></p>";

}

if ($n == 1) {

	echo "<input class='col-2' type='submit' name = 'autoval' value = \" >> Actualizar >>  \">";

} else {

	if ($tipo == "A") {echo "<p class='both'><br></p>No eres profesor de sus asignaturas";}

}

echo "<p></p><span class='rojo b'>$mens<p></p>$mens1</span>";
echo "<p></p><span class='rojo b'>$mens_anadir<p></p>$mens_anadir</span>";

?>

</form>

<?php

function anadiren($asignaext,$curso,$grupo,$usuid,$ilink) {

	$asignaext = strtoupper($asignaext); $grupo = strtoupper($grupo);
	//comprobar que existe asigna
	$result = $ilink->query("SELECT asigna FROM cursasigru WHERE asigna = '$asignaext' AND curso = '$curso' AND grupo = '$grupo'");
	$existe = $result->num_rows;
	if (!$existe) {
		$mens = "$asignaext / $curso / $grupo no existe.";
	} else {
		if (esprofesor($asignaext,$curso,$grupo,$ilink) OR soyadmiano($asignaext,$curso,$ilink)) {
			//update de usuarios E -> A
			$ilink->query("UPDATE usuarios SET tipo='A', ultasigna='$asignaext', ultcurso='$curso', ultgrupo='$grupo' WHERE id = '$usuid'");
			// a&ntilde;adir registro en alumasiano y usuasi
			$ilink->query("INSERT INTO alumasiano (id, asigna, curso, grupo, veforo, auto) VALUES ('$usuid', '$asignaext', '$curso', '$grupo', 1,'4')");
			$ilink->query("INSERT INTO usuasi (id, asigna) VALUES ('$usuid', '$asignaext')");
			$mens = "Pinchar de nuevo en Actualizar para ver la ficha actualizada.";
		} else {
			$mens = "No eres profesor de $asignaext / $curso / $grupo";
		}
	}

	return $mens;

}

?>
