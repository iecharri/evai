<?php 

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

$asigna = $_SESSION['asigna'];
$curso = $_SESSION['curso'];
$grupo = $_SESSION['grupo'];

extract($_GET);
extract($_POST);
require_once APP_DIR . "/soloprof/soloprofaplic21.php";

$sqlmail = "SELECT n, email FROM conventid ORDER BY n";
$result = $ilink->query($sqlmail);

?>
<script language="javascript">
function prueba() {
	return confirm("<?php echo i("confirmborr",$ilink);?>");
}

<?php if ($pest == 11) {?>
function selecc(envio){
var check;
if (envio.all.checked) {check = 'checked'} else {check = ''}

<?php
while ($fila = $result->fetch_array(MYSQLI_BOTH)) {
	echo "envio.usuenv$fila[0].checked = ";?>check<?php echo ";\n";
}
?>

<?php } ?>

}

</script>
<?php

// -------------------------------------------------- Permisos de modificaci&oacute;n de Plazas, Entidades y Titulaciones

$superprofes = $ilink->query("SELECT superprofes FROM cursasigru
 WHERE asigna = '$asigna' AND curso = '$curso' AND grupo = '$grupo'");
if ($superprofes) {
	$superprofes = $superprofes->fetch_array(MYSQLI_BOTH);
}
$superprofes = explode('**',$superprofes[0]);
$automodif = automodif($superprofes);
if (!$automodif) {
	echo "Usuario no autorizado a modificaciones.";
	echo "<br>Solicitarlo a los <a href='pod/pod.php?pest=2&pest1=2'>Administradores de ".$_SESSION['tit']."</a>.";
}

// -------------------------------------------------- Modificaciones, si permitido

if ($automodif) {

	echo "<p></p>";
	if(!$pest1) {$pest1 = 1;}
	$array[0] = "<a href='?pest=$pest&pest1=1&apli=$apli'>Plazas</a>";
	$array[1] = "<a href='?pest=$pest&pest1=2&apli=$apli&enti=1'>Entidades de pr&aacute;cticas</a>";
	$array[2] = "<a href='?pest=$pest&pest1=3&apli=$apli&titulreq=1'>Titulaciones</a>";
	$array[3] = "<a href='?pest=$pest&pest1=4&apli=$apli&prof=1'>Profesores autorizados</a>";
	$array[4] = "<a title='Copiar Plazas desde otra Asignatura-Curso-Grupo' href='?pest=$pest&pest1=5&apli=$apli&copiar=1'>Copiar Plazas desde otra A-C-G</a>";
	$array[5] = "<a href='?pest=$pest&pest1=6&apli=$apli&mail=1'>Envío por mail</a>";
	solapah($array,$pest1,"navhsimple");
	
// --------------------------------------------------

	if ($mail) {
		mandarmail($ilink);
	}
	
// --------------------------------------------------

	if ($copiar) {
		copiarpl($ilink);
	}


// --------------------------------------------------

	if ($solicitud) {
		if ($soliccheck) {$acep=1;} 
		if($elecc == "*") {
			$ilink->query("DELETE FROM convsolicitudes WHERE convenio = '$solicconv' AND alumno = '$solicalum'");
		} else {
			$tutor = $result = $ilink->query("SELECT tutornom FROM convenios WHERE n = '$solicconv'");
			$tutor = $tutor->fetch_array(MYSQLI_BOTH);
			$ilink->query("UPDATE convsolicitudes SET tutorid = '$tutor[0]', preferencia = '$elecc', aceptada = '$acep' WHERE convenio = '$solicconv' AND alumno = '$solicalum'");
		}
	}

	if ($submvisi) {
		if ($visible) {$visi = 1;}
		$ilink->query("UPDATE convenios SET visible = '$visi' WHERE n = '$conveniovisi'");
	}

	if ($submofert) {
		if ($ofertado) {$ofert = 1;}
		$ilink->query("UPDATE convenios SET ofertado = '$ofert' WHERE n = '$convenioofertado'");
	}

// --------------------------------------------------

	if ($submsuperprof) {
		foreach ($superprofes as $key => $value) {
   		if ($value == $usuid) {$esta = 1; break;}
		}
		if ($superprofe) {
			if (!$esta) {array_push($superprofes,$usuid);}
		} elseif ($esta) {
			foreach ($superprofes as $key => $value) {
    			if ($value == $usuid) {unset($superprofes[$key]);}
			}
		}
		$temp = implode("**",$superprofes);
		$ilink->query("UPDATE cursasigru SET superprofes = '$temp' WHERE
		 asigna = '$asigna' AND curso = '$curso' AND grupo = '$grupo'");
	}

}

echo "<p></p>";

if (!$enti AND !$titulreq AND !$prof AND !$copiar AND !$mail) {
	if ($bo AND $automodif) {
		$ilink->query("DELETE FROM convenios WHERE n = '$bo'");
	}
	if ($ana == 1 AND $automodif) {
		echo "<span class='txth b mediana center'>A&ntilde;adir Plaza</span>";
		anadir($asigna,$curso, $grupo,'',$ilink);
	} elseif ($ed AND $automodif) {
		if ($entiacepta1){
			if ($entiacepta) {$entiacepta = 1;} else {$entiacepta = 0;}
			$ilink->query("UPDATE convenios SET ofertado = '$entiacepta' WHERE n = '$ed'");
		}
		$sqlofer = "SELECT ofertado FROM convenios WHERE n = '$ed'";
		$result = $ilink->query($sqlofer);
		$fila = $result->fetch_array(MYSQLI_BOTH);
		echo "<form method='post'><span class='txth b mediana center'>Modificar Plaza</span>";
		echo " &nbsp; &nbsp; &nbsp; &nbsp;[ <a href='?pest=11&apli=2&bo=$ed' class='rojo b' onclick='return prueba()'>Click para borrar Plaza</a> ]";
		echo " &nbsp; &nbsp; &nbsp; &nbsp; La Entidad acepta ofertar plazas el año activo";
		echo "<input type='checkbox' name='entiacepta'";
		if ($fila[0]) {echo " checked='checked'";}
		echo "><input class='col-05' type='submit' name='entiacepta1' value=' >> '></form>";
		echo $mensaje;
		editar($ed,$asigna,$curso,$grupo,'',$ilink);
	} else {
		/*echo "<p></p>Ordenar por ";
	 	echo "[ <a href='?pest=$pest&apli=$apli&ord=pais' ";
	 	if ($ord != "apel") {echo "class='txth b'";}
	 	echo ">Pa&iacute;s</a> ] &nbsp; [ <a href='?pest=$pest&apli=$apli&ord=apel' ";
	 	if ($ord == "apel") {echo "class='txth b'";}
	 	echo ">Apellido</a> ] &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;";*/
		echo "<span class='txth b'>En cuanto se acepta una solicitud, el usuario no puede cambiarla</span>. En ese momento se mostrará al alumno cual es su tutor.";
		if ($ord != "apel") {
			listar($asigna,$curso,$grupo,$automodif,0,$ilink);
		} else {
			listarapel($asigna,$curso,$grupo,$automodif,0,$ilink);
		}
	}
} elseif ($enti AND $automodif) {
	if ($boenti) {
		$iresult = $ilink->query("SELECT n FROM convenios WHERE entidad = '$boenti'");
		$convenios = $iresult->num_rows;
		if (!$convenios) {
			$ilink->query("DELETE FROM conventid WHERE n = '$boenti'");
		} else {
			$mensaje = "<span class='rojo b'> &nbsp; No se puede borrar, tiene Plazas asociadas.</span>";
			$edenti = $boenti;
		}
	}
	
	if ($anaenti == 1 OR $anadirenti1) {
		echo "<span class='txth b mediana center'>A&ntilde;adir Entidad</span>";
		anadirenti($ilink);
	} elseif ($edenti OR $editarenti1) {
		echo "<span class='txth b mediana center'>Modificar Entidad</span>";
		echo " &nbsp; &nbsp; &nbsp; &nbsp;[ <a href='?pest=11&apli=2&enti=1&boenti=$edenti' class='rojo b' onclick='return prueba()'>Click para borrar Entidad</a> ]$mensaje";
		editarenti($edenti,0,$ilink);
	} else {
		listarenti($ilink);
	}
} elseif ($titulreq AND $automodif) {
	if ($botitu) {
		$iresult = $ilink->query("SELECT n FROM convenios WHERE entidad = '$boenti'");
		$convenios = $iresult->num_rows;
		if (!$convenios) {
			$ilink->query("DELETE FROM convtitul WHERE n = '$botitu'");
		} else {
			$mensaje = "<span class='rojo b'> &nbsp; No se puede borrar, tiene Plazas asociadas.</span>";
			$edenti = $boenti;
		}
	}
	if ($anatitu == 1 OR $anatitu1) {
		echo "<span class='txth b mediana center'>A&ntilde;adir Titulaci&oacute;n</span>";
		anadirtitu($ilink);
	} elseif ($edtitu OR $edtitu1) {
		echo "<span class='txth b mediana center'>Modificar Titulaci&oacute;n</span>";
		echo " &nbsp; &nbsp; &nbsp; &nbsp;[ <a href='?pest=11&apli=2&titulreq=1&botitu=$edtitu' class='rojo b' onclick='return prueba()'>Click para borrar Titulaci&oacute;n</a> ]$mensaje";
		editartitu($edtitu,$ilink);
	} else {
		listartitu($ilink);
	}
} elseif ($prof AND $automodif) {
	profauto($asigna,$curso,$grupo,$superprofes,$ilink);
}

// --------------------------------------------------

// -------------------------------------------------- ENTIDADES

function listarenti($ilink) {
	
	$sql = "SELECT * FROM conventid ORDER BY pais, nombre";

	echo "<table class='conhover'>";
	echo "<tr>";
	echo "<th class='col-01'><a href='?pest=11&apli=2&enti=1&anaenti=1&pest1=2'>A&ntilde;adir</a></th>";
	echo "<th>Entidad</th>";
	echo "<th>&Aacute;mbito geogr&aacute;fico</th>";
	echo "<th>Sector</th>";
	echo "<th>n&deg; empleados</th>";
	echo "<th class='nowrap col-01'>Pa&iacute;ses de actuaci&oacute;n</th>";
	echo "</tr>";

	$result = $ilink->query($sql);
	while ($fila = $result->fetch_array(MYSQLI_BOTH)) {
		extract($fila);
		echo "<tr>";
		echo "<td><a href='?pest=11&apli=2&enti=1&edenti=$n&pest1=2'>Editar</a></td>";
		echo "<td><span class='b'>$nombre</span>";
		if ($calle) {echo "<br>".$calle;}
		if ($codpos OR $localidad) {echo "<br>".$codpos." ".$localidad;}
		if ($tf) {echo "<br>".$tf;}
		if ($email) {echo "<br>".$email;}
		if ($web) {echo "<br><a href='$web' target='_blank'>$web</a>";}
		echo "<br>Localizaci&oacute;n de la Entidad: <span class='txth mediana'>$localidad</span><br>";  //$pais
		echo "<span class='peq nob'>Gesti&oacute;n externa de plazas: <a target='_blank' href='" . DOMINIO .APP_URL."/plazasext.php?enti=$n'>". DOMINIO.APP_URL."/plazasext.php?enti=$n</a></span>";
		
		echo "</td>";
		echo "<td>$ambgeo</td>";
		echo "<td>$sector</td>";
		echo "<td>$numemp</td>";
		echo "<td>$paisactu</td>";
		echo "</tr>";
	}

	echo "</table>";

}

// -------------------------------------------------- TITULACIONES

function listartitu($ilink) {

	$sql = "SELECT * FROM convtitul ORDER BY titulacion";

	echo "<table class='conhover'>";
	echo "<tr>";
	echo "<th class='col-01'><a href='?pest1=3&pest=11&apli=2&titulreq=1&anatitu=1'>A&ntilde;adir</a></th>";
	echo "<th>Titulaci&oacute;n</th>";
	echo "</tr>";

	$result = $ilink->query($sql);
	while ($fila = $result->fetch_array(MYSQLI_BOTH)) {
		extract($fila);
		echo "<tr>";
		echo "<td><a href='?pest1=3&pest=11&apli=2&titulreq=1&edtitu=$n'>Editar</a></td>";
		echo "<td>$titulacion";
		echo "</tr>";
	}

	echo "</table>";

}

// --------------------------------------------------

function anadirtitu($ilink) {
	if ($_POST['anatitu1']) {
		extract($_POST);
		$ilink->query("INSERT INTO convtitul (titulacion) VALUES (\"$titulacion\")");
		$mensaje = "<span class='txth b mediana'> - Titulaci&oacute;n a&ntilde;adida</span><p></p>";
	}
	$div = "anadir";
	$mensaje .= "<form method='post' action='?pest1=3&pest=11&apli=2&titulreq=1&anatitu=1'>";
	$mensaje .= campostitu('',$ilink);
	$mensaje .= "<input class='col-2' name='anatitu1' type='submit' value=\"".i("anadir1",$ilink)."\">";
	$mensaje .= "</form>";
	echo $mensaje;
}

// --------------------------------------------------

function editartitu($n,$ilink) {
	if ($_POST['edtitu1']) {
		extract($_POST);
		$ilink->query("UPDATE convtitul SET titulacion = \"$titulacion\" WHERE n = '$n'");
		$mensaje = "<span class='txth b mediana'> - Titulaci&oacute;n modificada</span><p></p>";
	}
	$div = "editar";
	$mensaje .= "<form method='post' action='?pest1=3&pest=11&apli=2&titulreq=1'>";
	$mensaje .= campostitu($n,$ilink);
	$mensaje .= "<input type='hidden' name='edtitu' value='$n'>";
	$mensaje .= "<input class='col-2' name='edtitu1' type='submit' value=\"".i("agvalid",$ilink)."\">";
	$mensaje .= "</form>";
	echo $mensaje;
}

// --------------------------------------------------

function campostitu($n,$ilink) {
	if ($n) {
		$iresult = $ilink->query("SELECT * FROM convtitul WHERE n = '$n'");
		$fila = $iresult->fetch_array(MYSQLI_BOTH);
		extract($fila);
	}
	$mensaje = "<fieldset><legend>Titulaci&oacute;n</legend>";
	$mensaje .= "<input class='col-5' type='text' name='titulacion' size='90' maxlength='252' value=\"$titulacion\">";
	return $mensaje;
}

// --------------------------------------------------

function automodif($superprofes) {
	if ($_SESSION['auto'] == 10) {return 1;}
	if (esadmidetit($_SESSION['tit'],$_SESSION['curso'],$ilink)) {return 1;}
	foreach ($superprofes as $key => $value) {
		if ($value == $_SESSION['usuid']) {return 1;}
	}
}

// --------------------------------------------------

function profauto($asigna,$curso,$grupo,$superprofes,$ilink) {
	$sql = "SELECT usuid FROM asignatprof LEFT JOIN usuarios ON usuarios.id = asignatprof.usuid 
	WHERE fechabaja = '0000-00-00 00:00' AND asigna = '$asigna' AND curso = '$curso' AND grupo = '$grupo'
	ORDER BY alumnoa, alumnon";
	$result = $ilink->query($sql);
	$soyadmidetit = esadmidetit($_SESSION['tit'],$_SESSION['curso'],$ilink);
	echo "<table class='conhover'>";
	echo "<tr><th class='col-01'>Autorizado a modificar Plazas, Entidades y Titulaciones</th>";
	echo "<th>".i("profesor",$ilink)."</th></tr>";
	while ($fila = $result->fetch_array(MYSQLI_BOTH)) {
		$temp = "";
		if (esadmidetit1($_SESSION['tit'],$_SESSION['curso'],$fila[0],$ilink)) {$temp = "1";}
		echo "<tr>";
		echo "<td>";
		echo "<form method='post'>";
		foreach ($superprofes as $key => $value) {
			if ($value == $fila[0]) {$pos = 1; break;}
		}
		echo "<input type='checkbox' name='superprofe'";
		if ($pos OR $temp) {echo " checked = 'checked'";}
		echo ">";
		if (!$temp AND $soyadmidetit) {echo " <input type='submit' name='submsuperprof' value=' >> '>";}
		echo "<input type='hidden' name='usuid' value='".$fila['usuid']."'>";
		echo "</form>";
		echo "</td>";
		echo "<td>";
		
		$usua = ponerusu($fila['usuid'],1,$ilink);
		echo $usua[0];
		echo $usua[1];

		echo "</tr>";
	}
	echo "</table>";
}

// --------------------------------------------------

function copiarpl($ilink) {
	
	extract($_POST);
	
	echo "<p></p>Indica la Asignatura - Curso - Grupo de donde quieres copiar las plazas<p/>";
	echo "<form method='post'>".i("asigna",$ilink)." <input class='col-1' type='text' size='15' name='asigna1' value='$asigna1'> ".i("curso",$ilink)." <input class='col-1' type='text' size='4' name='curso1' value='$curso1'> ";
	echo i("grupo",$ilink)." <input class='col-1' type='text' size='4' name='grupo1' value='$grupo1'> <input class='col-1' type='submit' name='copiar1' value=' >> '></form>";
	
	if (!$asigna1) {return;}

	if (!esprofesor($asigna1, $curso1, $grupo1, $ilink) OR !existe($asigna1, $curso1, $grupo1, $ilink)) {
		echo "<p></p><span class='rojo mediana'>No existe o no tienes permisos</span>";
		return;
	}
	$ilink->query("DROP TABLE kkk");
	$ilink->query("CREATE TABLE kkk SELECT * FROM convenios WHERE asigna = '$asigna1' AND curso = '$curso1' AND grupo = '$grupo1'");
	$asigna = $_SESSION['asigna'];
	$curso = $_SESSION['curso'];
	$grupo = $_SESSION['grupo'];
	$ilink->query("UPDATE kkk SET asigna = '$asigna', curso = '$curso', grupo = '$grupo'");
	$result = $ilink->query("SELECT MAX(n) as id FROM convenios");
	$max = $result->fetch_array(MYSQLI_BOTH);
	$result = $ilink->query("SELECT * FROM kkk");
	while ($fila = $result->fetch_array(MYSQLI_BOTH)) {
		$max++;
		$kkk = $fila['n'];
		$ilink->query("UPDATE kkk SET n = '$max' WHERE n = '$kkk'");
	}
	$ilink->query("INSERT INTO convenios SELECT * FROM kkk");
	$ilink->query("DROP TABLE kkk");
	
	echo "<p></p><span class='txth mediana b'>&nbsp; &nbsp; &nbsp;".strtoupper(("hecho"))."</span>";
	
}

// --------------------------------------------------

function mandarmail($ilink) {

	extract($_POST);
	$sql = "SELECT n, email, nombre, contrasena FROM conventid ORDER BY n";
	$result = $ilink->query($sql);
	echo "<p></p>Env&iacute;o por mail del Link, Contrase&ntilde;a y/u otros textos a las Entidades.";
	echo "<p></p>Insertar en cualquier lugar del Asunto o Texto del mensaje las siguientes acotaciones con el signo # para que sea sustitu&iacute;do por lo que le corresponde a cada Entidad";
	echo "<p></p>#nombre#: Nombre de la Entidad";
	echo "<p></p>#link#: Link a la Gesti&oacute;n externa de la Entidad";
	echo "<p></p>#contrasena#: Contrase&ntilde;a de acceso";
	
	echo "<form method='post' name='envio'>";
	echo "<span class='b'>Asunto</span><br>";
	echo "<input class='col-3' type='text' name='asunto' size='90' maxlength='90' value='$asunto'>";
	echo "<p></p><span class='b'>Mensaje</span><br>";
	echo "<textarea class='col-3' name='mensaje' rows='10' cols='60'>$mensaje</textarea>";
	echo "<p></p>";
	echo "<span class='b'>Destinatarios</span><br>";
	
	echo "<input type='checkbox' name='all' onclick='selecc(envio)'> <span class='b'>Seleccionar todos / ninguno</span> &nbsp; &nbsp; &nbsp;";
	if ($_POST['contimail1'] AND !$_POST['enviarnota']) {
		echo "<span class='rojo b'>Continuar debajo en la barra amarilla pulsando en ".i("enviar",$ilink)." >>>></span>";
	}
	echo "<br>";
	while ($fila = $result->fetch_array(MYSQLI_BOTH)) {
		extract($fila);
		echo "<input type='checkbox' name=\"usuenv$fila[0]\" value=\"".$fila[0]."\"";
		if($_POST['usuenv'.$fila[0]] OR $_POST['subm1']) {echo " checked='checked'";}
		echo ">";
		echo $nombre." - <span class='txth'>".$email."</span><br>";
	}
	if (!$_POST['contimail1'] AND !$_POST['enviarnota']) {
		 echo "<br><input class='col-10' type='submit' name='contimail1' value='".i("conti",$ilink)."'></form>";return;
	}
	
	?>

	<table class='conhover'>
	<tr>
	<th>

	<?php echo i("envimens",$ilink);?></th>
	<th class='col-01 nowrap'>Mail</th>
	<th>
	<?php
	if (!$_POST['enviarnota']) {
		echo "<span class='b'>";
		echo i("enviar",$ilink);
		echo "<input type='hidden' name='asunto' value='".$_POST['asunto']."'>";
		echo "<input type='hidden' name='mensaje' value='".$_POST['mensaje']."'>";
		echo " <input type='submit' value='>>>>' name='enviarnota'></span>";
	}
	?>
	</th></tr>

	 <?php
	 	 
	$result = $ilink->query($sql);
	while ($fila = $result->fetch_array(MYSQLI_BOTH)) {
		if (!$_POST['usuenv'.$fila[0]]) {continue;}
		echo "<tr>";
		$para = str_replace(" ","",$fila['email']);
		$para = str_replace(",",";",$para);
		$para = str_replace("/",";",$para);
		$para = str_replace(",",";",$para);

		$para = explode(";",$para);
		echo "<td class='col-01 nowrap'>";
		if (!$fila['email']) {
			echo "<span class='rojo b'>Atencion. Entidad sin mail. Corregir antes de enviar</span>";
		} else {
			echo $fila['email'];
		}
		echo "</td>";
		echo "<td class='col-9'>";
		$link = "<a href='" . DOMINIO.APP_URL . "/plazasext.php?enti=".$fila['n']."'>" . DOMINIO.APP_URL ."/plazasext.php?enti=".$fila['n']."</a>";
		$asunto1 = str_replace("#nombre#",$fila['nombre'],$asunto);
		$asunto1 = str_replace("#link#",$link,$asunto1);
		$asunto1 = str_replace("#contrasena#",$fila['contrasena'],$asunto1);
		$mensaje1 = str_replace("#nombre#",$fila['nombre'],$mensaje);
		$mensaje1 = str_replace("#link#",$link,$mensaje1);
		$mensaje1 = nl2br(str_replace("#contrasena#",$fila['contrasena'],$mensaje1));
		echo "<span class='b'>Asunto:</span><br>".$asunto1;
		echo "<br><span class='b'>Mensaje:</span><br>".$mensaje1;
		echo "</td>";
		echo "<td>";
		if ($_POST['enviarnota']) {
			$exito = pormail_enti($_SESSION['usuid'],$para,trim(nl2br($asunto1)),trim(nl2br($mensaje1)),trim($mensaje1),$ilink);
			if ($exito) {
				echo "<br><span class='txth b'>Env&iacute;o realizado por mail</span>";
			} else {
				echo "<p></p><span class='rojo b'>Error</span>";
			}
		}
		echo "</td>";
		echo "</tr>";	
		
	}
	
	echo "</table><p></p>";
	
}

?>