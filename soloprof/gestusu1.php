<?php

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

unset($array);
$array[0] = "<a href='#'>".i("usus",$ilink)." &nbsp; <span class='icon-arrow-right'></span></a>";
$array[1] =  "<a href='?pest=$pest'><span class='b'>B&uacute;squeda</span></a>";
if ($_SESSION['auto'] == 10 AND $pest == 3) {
	$array[2] = "<a href='?pest=$pest&alta=1'>Alta masiva de Usuarios</a>";
	$array[3] = "<a href='?pest=$pest&alta=2'>A&ntilde;adir un Usuario</a>";
}
solapah($array,(2+$alta),"navhsimple");

// --------------------------------------------------

if ($_GET['confirm']) {
	anadirusus();
	return;
}

if ($_POST['anadir1usu']) {

	require_once APP_DIR . "/validarchars.php";
	$mal = versidatosok($ilink,$script);
	if(!$mal[0]) {
		$auto = 4; if ($_POST['tipo'] == "P") {$auto = 5;}

		// Preparar la sentencia
		$stmt = $ilink->prepare("INSERT INTO usuarios (usuario, pass_hash, alumnon, alumnoa, mail, tipo, autorizado, fechaalta) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");

		// Variables
		$usuario   = trim($usuario);
		// Encriptar contraseña
		$hash = password_hash(trim($password1), PASSWORD_DEFAULT);
		$alumnon   = trim($alumnon);
		$alumnoa   = trim($alumnoa);
		$mail      = trim($mail);
		$tipo      = $tipo;
		$auto      = $auto;
		$fechaalta = gmdate("Y-m-d");

		// Vincular parámetros
		$stmt->bind_param("ssssssis", $usuario, $hash, $alumnon, $alumnoa, $mail, $tipo, $auto, $fechaalta);

		// Ejecutar
		$stmt->execute();
		$stmt->close();
		
		$ultid = $ilink->insert_id;
		$mensaje = "<span class='txth'>".i("usuanadido",$ilink).": &nbsp;";
		$usua = ponerusu($ultid,1,$ilink);
		$mensaje .= $usua[0].$usua[1];
		$mensaje .= "</span>";
	}

}

// --------------------------------------------------

if ($_POST['enviar']) {

	$ext = explode(".", $_FILES['fichcsv']['name']);
	$ext = $ext[1];
	if ($ext == "csv") {
		$ilink->query("DELETE FROM usuarios1 WHERE 1");
		$fichcsv = $_FILES['fichcsv']['tmp_name'];
		$fichcsv = addslashes ($fichcsv);
		$sql = "LOAD DATA LOCAL INFILE '".$fichcsv."' INTO TABLE usuarios1 FIELDS TERMINATED BY ',' ENCLOSED BY '\"' LINES TERMINATED BY '\n'"; // \r\n en windows \n en linux
		$ilink->query($sql);
		if ($ilink->errno) {die ("Error");}
		$ilink->query("UPDATE usuarios1 SET alumnon = TRIM(alumnon)");
		$ilink->query("UPDATE usuarios1 SET alumnoa = TRIM(alumnoa)");
		$ilink->query("UPDATE usuarios1 SET usuario = TRIM(usuario)");
		$hash = $ilink->real_escape_string(password_hash($password, PASSWORD_DEFAULT));
		$ilink->query("UPDATE usuarios1 SET pass_hash = '$hash'");
		$ilink->query("UPDATE usuarios1 SET mail = TRIM(mail)");
		$ilink->query("UPDATE usuarios1 SET asignaturas = TRIM(asignaturas)");
		$iresult = $ilink->query("SELECT usuario FROM usuarios1");
		$registros = $iresult->num_rows;
		if ($registros) {
			echo "<p class='grande'>Se va a analizar $registros registros de ".$_FILES['fichcsv']['name']." (continuar al final del listado):<p></p>";
			$sql = "SELECT usuario, count(usuario) FROM usuarios1 GROUP BY usuario HAVING count(usuario)>1";
			$iresult = $ilink->query($sql);
			if ($iresult->num_rows>0) {
				echo "<span class='rojo b mediana'>&iexcl;ATENCI&Oacute;N! No se a&ntilde;adir&aacute;n los usuarios, hay al menos un usuario repetido.</span><p></p>";
				$repetidos = 1;
			}
			$sql = "SELECT mail, count(mail) FROM usuarios1 GROUP BY mail HAVING count(mail)>1";
			$iresult = $ilink->query($sql);
			if ($iresult->num_rows>0) {
				echo "<span class='rojo b mediana'>&iexcl;ATENCI&Oacute;N! No se a&ntilde;adir&aacute;n los usuarios, hay al menos un mail repetido.</span><p></p>";
				$repetidos = 1;
			}
			echo "Se se&ntilde;ala en rojo el nombre de usuario o el mail que ya existe en la tabla de usuarios. Si las \"asignatura curso grupo\" no tienen profesor, tambi&eacute;n se indica y no se realiza la copia.";
			$result = $ilink->query("SELECT * FROM usuarios1 ORDER BY tipo DESC, usuario");
			echo "<table class = 'conhover'>";
			echo "<tr><th>Tipo</th><th>Usuario</th><th>Password</th><th>Mail</th><th>Nombre</th><th>Apellidos</th><th>Asignaturas</th><th>Registro v&aacute;lido</th></tr>";
			$copiar = 1;
			while ($fila = $result->fetch_array(MYSQLI_BOTH)) {
				$ok=1;
				extract($fila);
				echo "<tr><td>";
				if ($tipo != "A" AND $tipo != "E") {echo "<span class='rojo b'>$tipo</span>";$ok=0; $copiar=0;} else {echo $tipo;}
				echo "</td><td>";
				$sql1 = "SELECT usuario FROM usuarios WHERE usuario = '$usuario'";
				$result1 = $ilink->query($sql1);
				if ($result1->num_rows) {echo "<span class='rojo b'>$usuario</span>";$ok=0; $copiar=0;} else {echo $usuario;}
				echo "</td><td>********</td><td>";
				$sql1 = "SELECT mail FROM usuarios WHERE mail = '$mail'";
				$result1 = $ilink->query($sql1);
				if ($result1->num_rows) {echo "<span class='rojo b'>$mail</span>";$ok=0; $copiar=0;} else {echo $mail;}
				echo "</td><td>$alumnon</td><td>$alumnoa</td>";
				echo "<td>";
				$noasi1 = 0;
				if (!$asignaturas AND $tipo == "A") {echo "<span class = 'rojo b'>NO</span>"; $ok=0; $copiar=0;}
				if ($asignaturas) {
					$asignas = explode("*",$asignaturas);
					$numasi = sizeof($asignas);
					for ($i=0;$i<$numasi;$i++) {
						$asignas1 = $asignas[$i];
						$asignas1 = explode("$", $asignas1);
						$numasi1 = sizeof($asignas1);
						for ($j=0;$j<$numasi1;$j++) {
							echo $asignas1[$j]." ";
						}
						if (existe($asignas1[0],$asignas1[1],$asignas1[2],$ilink)) {
							echo " <span class='verdecalific b'>OK</span>";
						} else {
							if ($fila['tipo'] == "A") {echo " <span class='rojo b'>NO hay profesor</span>";$noasi = 1;$noasi1 = 1;}
							if ($fila['tipo'] == "P") {
								$result2 = $ilink->query("SELECT cod FROM asignaturas WHERE cod = '$asignas1[0]' AND anyo = '$asignas1[1]'");
								if ($result2->num_rows) {
									echo " <span class='verdecalific b'>OK</span>";
								} else {
									echo " <span class='rojo b'>NO</span>";$noasi = 1;$noasi1 = 1;
								}						
							}
						}
						echo "<br>";	
					}
				}
				echo "</td>";
				echo "<td>";
				if ($noasi1) {$ok = 0;}
				if ($ok) {echo "<span class='verdecalific b'>OK</span>";} else {echo "<span class='rojo b'>NO</span>";}
				echo "</td>";
				echo "</tr>";
			}
			echo "</table>";
			if (!$copiar OR $noasi OR $repetidos) {
				echo "<p></p><span class='rojo b mediana'>Fichero con errores. Corregir y volver a intentar.</span>";
			} else {
				echo "<p></p><a href='?pest=$pest&alta=1&confirm=1' class='txth b grande'>CLICK AQU&Iacute; PARA A&Ntilde;ADIR LOS USUARIOS LISTADOS</a>";
			}
		}
	} else {
		echo "<span class='rojo b mediana'>Se ha de enviar un fichero de extensi&oacute;n <span class='txth'>csv</span></span>";
	}

} else {

	if ($_GET['alta'] == 1) {
		echo "Enviar un fichero.csv con el siguiente formato por cada usuario (Externos o Alumnos):";

		echo "<p></p>\"A\",\"Antonio\",\"Torrefacto Morales\",\"atorrefacto\",\"clavedeacceso\",\"mail@mail.com\",\"R25"."$"."2008"."$"."A*C49"."$"."2008"."$"."F*A76"."$"."2008\"";

		echo "<p></p>[A partir de un fichero excel (con cada campo en una celda, considerado el conjunto de asignaturas como un campo), guardar el archivo como: fichero csv, codificaci&oacute;n de caraceteres Occidental (ISO-8859-15)]";

		echo "<p>Los campos, entrecomillados y separados por comas son:</li></p>
		<ul><li>Tipo de usuario: E (Externo) A (Alumno)</li>
		<li>Nombre</li>
		<li>Apellidos</li>
		<li>Nombre de usuario</li>
		<li>Contrase&ntilde;a de acceso</li>
		<li>Mail</li>
		<li>Asignatura"."$"."Curso"."$"."Grupo de las que es Alumno o Profesor separadas por un asterisco</li></ul>";

		echo "<form name='altausus' method='post' action='?&pest=$pest&alta=1' enctype='multipart/form-data'>";
		echo "<input class='col-3' type='file' name='fichcsv'>";
		echo " <input class='col-1' type='submit' name='enviar' value='Enviar'>";
		echo "</form>";
	} else {
		//anadir1usu($_POST,$mensaje,$ilink);return;
		if($post) {extract($post);}
		echo "<p>$mensaje</p>";
		echo "<p></p><h2>Pon como contraseña 123456 y harás que el usuario al entrar sea redireccionado a cambiar contraseña</h2>";
		echo "<form name='ana1usu' method='post' class='col-5'>";
		require_once APP_DIR . "/form_newusu.php";
		echo "&nbsp; &nbsp; &nbsp; <input class='col-1' type='submit' name='anadir1usu' value=' >> '>";
		echo "&nbsp; &nbsp; &nbsp; <input class='col-2' type='submit' value=\"".i("vaciarcamp",$ilink)."\" onclick=\"vaciar(ana1usu);return false\">";
		echo "<p></p>";
		echo "</form>";	
	}

}

// --------------------------------------------------

function anadir1usu($post,$mensaje,$ilink) {

	extract($post);	
	echo "<p>$mensaje</p>";
	echo "<form name='ana1usu' method='post'>";
	echo i("nombre",$ilink)."<br><input class='col-4' type='text' name='alumnon' value=\"$alumnon\" size='30' maxlength='80'><br>";
	echo i("apellidos",$ilink)."<br><input class='col-4' type='text' name='alumnoa' value=\"$alumnoa\" size='30' maxlength='100'><br>";
	echo i("mail",$ilink)."<br><input class='col-4' type='text' name='mail' value=\"$mail\" size='30' maxlength=80'><br>";
	echo i("usuario",$ilink)."<br><input class='col-4' type='text' name='usuario' value=\"$usuario\" size='15' maxlength='15'><br>";
	echo i("selecc",$ilink)."<br><input class='col-4' type='password' name='pass1' value=\"$pass1\" size='15' maxlength='15' required pattern='[A-Za-z0-9._-]{8,15}' title='A-Z a-z 0-9 . - _    8->15'><br>";
	echo i("repc",$ilink)."<br><input class='col-4' type='password' name='pass2' value=\"$pass2\" size='15' maxlength='15' required pattern='[A-Za-z0-9._-]{8,15}' title='A-Z a-z 0-9 . - _    8->15'><br>";
	echo "Tipo<br>";
	echo "<select name='tipo'>";
	echo "<option value='A'";
	if ($tipo == "A") {echo " selected = 'selected'";}
	echo ">".i("alumno",$ilink)."</option>";
	echo "<option value='P'";
	if ($tipo == "P") {echo " selected = 'selected'";}
	echo ">".i("profesor",$ilink)."</option>";
	echo "<option value='E'";
	if ($tipo == "E") {echo " selected = 'selected'";}
	echo ">".i("externo",$ilink)."</option>";
	echo "</select>";
	echo "&nbsp; &nbsp; &nbsp; <input class='col-1' type='submit' name='anadir1usu' value=' >> '>";
	echo "&nbsp; &nbsp; &nbsp; <input class='col-2' type='submit' value=\"".i("vaciarcamp",$ilink)."\" onclick=\"vaciar(ana1usu);return false\">";
	echo "<p></p>";
	echo "</form>";
	
}
	
// --------------------------------------------------

function anadirusus() {


	$sql = "SELECT * FROM usuarios1 ORDER BY tipo DESC, usuario";
	$result = $ilink->query($sql);
	
	while ($fila = $result->fetch_array(MYSQLI_BOTH)) {

		if ($fila['tipo'] == "E") {$auto = "4"; $id = ausuarios($fila, $auto); continue;}

		$asignaturas = $fila['asignaturas'];
		$asignas = explode("*",$asignaturas);
		$numasi = sizeof($asignas);
		for ($i=0;$i<$numasi;$i++) {
			$asignas1 = $asignas[$i];
			$asignas1 = explode("$", $asignas1);
			$asigna = trim($asignas1[0]); $curso = trim($asignas1[1]); $grupo = trim($asignas1[2]);
	
			if ($fila['tipo'] == "P") {
				$auto = "5";
				$id = ausuarios($fila, $auto);
				//echo "$id, $asigna, $curso, $grupo, $auto<br>";
				ausuasi($id, $asigna, $auto);
				acursasigru($id, $asigna, $curso, $grupo);
				aasignatprof($id, $asigna, $curso, $grupo);
				continue;
			}	
	
			if ($fila['tipo'] == "A") {
				$auto = "4";
				$id = ausuarios($fila, $auto);
				ausuasi($id, $asigna, $auto);
				aalumasiano($id, $asigna, $curso, $grupo, $auto);
			}
		} 
			
	}
	
	$ilink->query("DELETE FROM usuarios1 WHERE 1"); 
	echo "<h3>SE HAN A&Ntilde;ADIDO LOS USUARIOS.</h3>";

}

// --------------------------------------------------

function ausuarios($fila, $auto) {
	extract($fila);
	$sql = "INSERT INTO usuarios (tipo, usuario, password, mail, alumnon, alumnoa, autorizado, menu, fechaalta) VALUES (\"$tipo\", \"$usuario\", \"$password\", \"$mail\", \"$alumnon\", \"$alumnoa\", \"$auto\", '1', '".gmdate("Y-m-d")."')";
	$ilink->query($sql);
	$iresult = $ilink->query("SELECT id FROM usuarios WHERE usuario = '$usuario'");
	$id = $iresult->fetch_array(MYSQLI_BOTH);
	return $id[0];
}

// --------------------------------------------------

function ausuasi($id, $asigna, $auto) {
	$sql = "INSERT INTO usuasi (id, asigna, auto) VALUES (\"$id\", \"$asigna\", \"$auto\")";
	$ilink->query($sql);
}

// --------------------------------------------------

function aalumasiano($id, $asigna, $curso, $grupo, $auto) {
	$sql = "INSERT INTO alumasiano (id, asigna, curso, grupo, auto) VALUES (\"$id\", \"$asigna\", \"$curso\", \"$grupo\", \"$auto\")";
	$ilink->query($sql);
}

// --------------------------------------------------

function aasignatprof($id, $asigna, $curso, $grupo) {
	$sql = "INSERT INTO asignatprof (usuid, asigna, curso, grupo) VALUES (\"$id\", \"$asigna\", \"$curso\", \"$grupo\")";
	$ilink->query($sql);
}

// --------------------------------------------------

function acursasigru($id, $asigna, $curso, $grupo) {
	$sql = "INSERT INTO cursasigru (asigna, curso, grupo, visibleporalumnos, altalibre) VALUES (\"$asigna\", \"$curso\", \"$grupo\",\"1\",\"1\")";
	$ilink->query($sql);
}

// --------------------------------------------------

?>

<script language="javascript">

function vaciar(form1) {

	form1.usuario.value = ""
	form1.pass1.value = ""
	form1.pass2.value = ""
	form1.alumnon.value = ""
	form1.alumnoa.value = ""
	form1.mail.value = ""
	form1.alumnon.focus()
	
}

</script>