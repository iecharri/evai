<?php

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

unset($array);
$array[0] = "<a href='#'>".i("usus",$ilink)." &nbsp; <span class='icon-arrow-right'></span></a>";
$array[1] =  "<a href='#'><span class='b'>B&uacutesqueda</span></a>";
if ($_SESSION['auto'] == 10 AND $pest == 3) {
	$array[2] = "<a href='?pest=$pest&alta=1'>Alta masiva de Usuarios</a>";
	$array[3] = "<a href='?pest=$pest&alta=2'>A&ntilde;adir un Usuario</a>";
}
solapah($array,2,"navhsimple");

// --------------------------------------------------

$ord = $_GET['ord'];
$_SESSION['asigna'] = strtoupper(trim($_SESSION['asigna']));

if ($_POST['borr']){

	require_once APP_DIR . "/soloprof/fichaborrar.php"; $n = 0;
	foreach ($_POST['borr1'] as $elem) {

		$uid = $elem;
		fichaborrar($uid,0,$ilink);
		$n++;

	}
	echo "<span class='rojo b'>Se han borrado $n usuarios.</span><br>";

}

if ($_SESSION['auto'] < 10) {
	$_SESSION['soloasi'] = 1;
}

if ($_POST['subm']) {
	$_SESSION['nom1'] = $_POST['nom1'];
	$_SESSION['mail1'] = $_POST['mail1'];
	if ($_SESSION['auto'] == 10) {
		$_SESSION['autogen'] = $_POST['autogen'];
		$_SESSION['autogen1'] = $_POST['autogen1'];
		$_SESSION['ultentr'] = $_POST['ultentr'];
		$_SESSION['soloasi'] = "";
		$_SESSION['soloext'] = "";
		$_SESSION['debaja'] = "";
		if ($_POST['soloasi'] == "on") {$_SESSION['soloasi'] = 1;}
		if ($_POST['soloext'] == "on") {$_SESSION['soloext'] = 1;}
		if ($_POST['debaja'] == "on") {$_SESSION['debaja'] = 1;}
	} else {
		$_SESSION['soloasi'] = 1;
	}
}


echo "<form action='".$_SERVER['PHP_SELF']."?ord=$ord&pest=$pest' name='atencion' method='post'>\n";

echo "Nombre o apellido: <input class='col-3' type='text' size='15' maxlength='15' name='nom1' value='".$_SESSION['nom1']."'>\n";

echo "<br>e-mail: <input class='col-2' type='text' size='20' maxlength='80' name='mail1' value='".$_SESSION['mail1']."'>\n";

if ($_SESSION['auto'] == 10) {
	echo "<br>Autorizaci&oacute;n General < <input class='col-1' type='text' size='1' maxlength='1' name='autogen' value='".$_SESSION['autogen']."'> ";
	echo " > <input class='col-1' type='text' size='1' maxlength='1' name='autogen1' value='".$_SESSION['autogen1']."'> ";
}
if ($_SESSION['auto'] == 10) {
	echo "<br>&Uacute;ltima entrada <= <input class='col-1' type='text' size='10' maxlength='10' name='ultentr' value=".$_SESSION['ultentr']."> ";
}
if ($_SESSION['auto'] == 10) {
	echo "<br>S&oacute;lo asignatura <input type='checkbox' name='soloasi'";
	if ($_SESSION['soloasi']) {echo " checked='checked'";}
	echo "> ";
	echo " S&oacute;lo externos <input type='checkbox' name='soloext'";
	if ($_SESSION['soloext']) {echo " checked='checked'";}
	echo ">";
	echo " De baja <input type='checkbox' name='debaja'";
	if ($_SESSION['debaja']) {echo " checked='checked'";}
	echo ">";
} 
echo " &nbsp; <input class='col-2' type='submit' name='subm' value=\"".i("filtrar",$ilink)."\">\n";
//echo " &nbsp; &nbsp; &nbsp;<a href='ayudaadmin.html' target='_new' class='b'>".i("quees",$ilink)."</a>\n"; // archivo ayudaadmin.html perdido
if ($_SESSION['auto'] == 10) {echo "<br><span class='peq rojo'>Administradores: seleccionar \"S&oacute;lo asignatura\" para m&aacute;s funcionalidades</span><br>";}
echo "</form>\n";

$n = 0;

$dformat = $_SESSION['dformat'];

$sql = "SELECT DISTINCT usuarios.id, usuarios.usuario, usuarios.alumnoa, usuarios.alumnon, usuarios.privacidad, 
usuarios.autorizado, usuarios.fechaalta, usuarios.fecha, usuarios.ipalta, usuarios.ip, mail, 
CONCAT(ultasigna,' ',ultcurso,' ', ultgrupo) AS ultcursasigru";

if($_SESSION['soloasi']) {
	$sql .= ", alumasiano.auto ";
}	
$sql .= " FROM usuarios";
	 
if($_SESSION['soloasi']) {
	$sql .= " LEFT JOIN alumasiano ON usuarios.id = alumasiano.id LEFT JOIN asignatprof ON asignatprof.usuid = usuarios.id";
}

$filtro = " WHERE 1=1";

if($_SESSION['soloext']) {
	$filtro .= " AND tipo = 'E'";
	$n = 1;
}

if($_SESSION['debaja']) {
	$filtro .= " AND fechabaja != '0000-00-00 00:00:00'";
	$n = 1;
}

if ($_SESSION['nom1'] != '') {
	$filtro .= " AND CONCAT(trim(alumnon),' ', trim(alumnoa)) LIKE '%".$_SESSION['nom1']."%'" ;
}

if ($_SESSION['autogen']) {
	$filtro .= " AND autorizado < ".$_SESSION['autogen'];
}

if ($_SESSION['autogen1']) {
	$filtro .= " AND autorizado > ".$_SESSION['autogen1'];
}

if ($_SESSION['ultentr']) {
	$fechaSql = ifecha1($_SESSION['ultentr']); // → "2025-09-03"
	$filtro  .= " AND fecha <= '".$fechaSql." 23:59:59'";
}

if($_SESSION['soloasi']) {
	if ($curso) {$filtro .= " AND (alumasiano.curso = '$curso' OR asignatprof.curso = '$curso')" ;}
	if ($asigna) {$filtro .= " AND (alumasiano.asigna = '$asigna' OR asignatprof.asigna = '$asigna')";}
	if ($grupo) {$filtro .= " AND (alumasiano.grupo = '$grupo' OR asignatprof.grupo = '$grupo')";}
}

if ($_SESSION['auto'] < 10) {
	$filtro .= " AND fechabaja = '0000-00-00 00:00:00'";
}

if ($_SESSION['mail1']) {
	$filtro .= " AND mail LIKE '%".$_SESSION['mail1']."%'";
}

// --------------------------------------------------

if ($_GET['loginen'] AND $_SESSION['soloasi']) {
	$result = $ilink->query($sql.$filtro);
	while($fila = $result->fetch_array(MYSQLI_BOTH)) {
		$ilink->query("UPDATE usuarios SET ultasigna = '".$_SESSION['asigna']."', ultcurso = '".$_SESSION['curso']."', ultgrupo = '".$_SESSION['grupo']."' WHERE id = '".$fila['id']."' LIMIT 1");
	}
}

// --------------------------------------------------

$sql = $sql.$filtro;

if (!$ord OR $ord == 1) {
	$sql = $sql." ORDER BY alumnoa"; 
}
if ($ord == 2) {
	$sql = $sql." ORDER BY autorizado"; 
}
if ($ord == 3) {
	$sql = $sql." ORDER BY fecha DESC"; 
}
if ($ord == 4) {
	$sql = $sql." ORDER BY fechaalta DESC"; 
}
if ($ord == 5) {
	$sql = $sql." ORDER BY alumasiano.auto"; 
}

$result = $ilink->query($sql);

$numvinculos = $result->num_rows;

if ($numvinculos == 0) {

	echo "<p></p><center>".i("noseenc",$ilink)."</center>";

} else {
	
	if ($_SESSION['auto'] == 10 AND $_SESSION['asigna'] AND $_SESSION['soloasi']) {
		echo "<p></p><a href='?ord=$ord&pest=$pest&loginen=1' class='mediana txth'>Hacer que cuando entren en EVAI los usuarios listados ($numvinculos) lo hagan en ".$_SESSION['asigna']." ".$_SESSION['curso']." ".$_SESSION['grupo']."</a><br>\n";
		$iresult = $ilink->query("SELECT visibleporalumnos FROM cursasigru WHERE asigna = '".$_SESSION['asigna']."' AND curso = '".$_SESSION['curso']."' AND grupo = '".$_SESSION['grupo']."'");
		$visi = $iresult->fetch_array(MYSQLI_BOTH);
		if (!$visi[0]) {
			echo "<span class='rojo b peq'>ATENCI&Oacute;N, ".$_SESSION['asigna']." ".$_SESSION['curso']." ".$_SESSION['grupo']." NO es visible por los alumnos, si el listado contiene alumnos no es conveniente esta opci&oacute;n.</span><br>";
		}
	}
	
	$conta = $_GET['conta'];
	if (!$conta) {$conta = 1;}

	echo "<br>";
	if ($_SESSION['pda']) {$numpag = 5;} else {$numpag = 50;}
	pagina($numvinculos,$conta,$numpag,i("usuarios",$ilink),"ord=$ord&pest=$pest",$ilink);

	$result = $ilink->query($sql." LIMIT ".($conta-1).", $numpag");

	if ($_SESSION['auto'] == 10) {
		echo "<form name='borr' action='?pest=$pest&ord=$ord&conta=$conta' method='post' onsubmit=\"return borrar()\">";
	}

	echo "<table class='conhover'>";
	
	echo "<tr>";
	if ($_SESSION['auto'] == 10) {
		echo "<th><input class='peq' type='submit' name='borr' value='Borrar'></th>";
	}
	echo "<th><a href='".$_SERVER['PHP_SELF']."?ord=1&pest=$pest'>".i("apellidos",$ilink).", ".i("nombre",$ilink)."</a></th>
	<th>".i("usuario",$ilink)."</th><th><a href='".$_SERVER['PHP_SELF']."?ord=4&pest=$pest'>Alta</a>
	</th><th><a href='".$_SERVER['PHP_SELF']."?ord=3&pest=$pest'>&Uacute;ltima entrada<br>en ".ucfirst(SITE)."</a></th>
	<th>Privacidad</th><th><a href='".$_SERVER['PHP_SELF']."?ord=2&pest=$pest'>Autorizaci&oacute;n<br>general</a></th>";
	if ($_SESSION['soloasi']){
		echo "<th><a href='".$_SERVER['PHP_SELF']."?ord=5&pest=$pest'>Autorizaci&oacute;n<br>Asignatura</a></th>";
		echo "<th class='nowrap'>".$_SESSION['asigna']." ".$_SESSION['curso']." ".$_SESSION['grupo']."<br>al entrar</th>";
	}
	echo "</tr>\n";

	while ($myrow = $result->fetch_array(MYSQLI_BOTH)) {

		$ip = $myrow['ip'];
		echo "<tr>";

		if ($_SESSION['auto'] == 10) {
			echo "<td><input type=checkbox name=\"borr1[".$myrow['id']."]\" value=".$myrow['id']."></td>";
		}

		echo "<td>";
			$usu = ponerusu($myrow['id'],1,$ilink);
			echo $usu[0].$usu[1];
		echo "</td>\n";

// --------------------------------------------------

		echo "<td><span class='rojo'>";
		if ($_SESSION['soy_superadmin'] OR $_SESSION['auto'] > $myrow['autorizado']) {
			echo $myrow['usuario'];
		}
		echo "</span></td>";

		echo "<td>";
		echo utcausu1($myrow['fechaalta']);
		echo "<br>".$myrow['ipalta']."</td>\n";

		echo  "<td>";
		echo utcausu1($myrow['fecha']);
		echo "<br>".$ip." \n";
		$result1 = $ilink->query("SELECT * FROM maquinas WHERE ip = '$ip'");
		$fila = $result1->fetch_array(MYSQLI_BOTH);
		if ($fila['ip'] == $ip) {
			echo " ".$fila['nombre'];
		}
		echo "</td>";
		echo "<td class='center'>";
		if ($myrow['privacidad']) {echo $myrow['privacidad'];}
		echo "</td>";

		echo "<td class='center'>";
		$aut = (int)$myrow['autorizado'];
		try {
    		// fechaalta se asume UTC y solo fecha (YYYY-MM-DD)
    		$alta = new DateTimeImmutable($myrow['fechaalta'] . ' 00:00:00', new DateTimeZone('UTC'));
    		$limite = $alta->modify('+7 days');

    		// hoy a medianoche UTC (comparable sin horas)
    		$hoy = new DateTimeImmutable('today', new DateTimeZone('UTC'));

   		if ($aut === 3 && $limite < $hoy) {
        		echo "<span class='rojo b'>3</span>";
    		} else {
       		echo htmlspecialchars((string)$aut, ENT_QUOTES, 'UTF-8');
    		}
		} catch (Throwable $e) {
    		// En caso de fecha inválida, cae al valor tal cual
    		echo htmlspecialchars((string)$myrow['autorizado'], ENT_QUOTES, 'UTF-8');
		}
		echo "</td>";
	
		if($_SESSION['soloasi']) {
			echo "<td class='center'>";
			if (!$myrow['auto'] AND $myrow['autorizado'] > 4) {
				echo "";
			} else {
				echo $myrow['auto'];
			}
			echo "</td>";
			echo "<td class='center'>";
			if ($_SESSION['asigna']." ".$_SESSION['curso']." ".$_SESSION['grupo'] == $myrow['ultcursasigru']) {
				echo "<span class=verdecalific b'>SI</span>";
			} else {
				if (trim($myrow['ultcursasigru'])) {
					echo "<span class='rojo peq'>".$myrow['ultcursasigru']."</span>";
				} else {
					echo "<span class=rojo b'>NINGUNA</span>";
				}
			} 
			echo "</td>";
		}
	
		echo "</tr>\n";

	}

	echo "</table><br>\n";

	if ($_SESSION['auto'] == 10) {echo "</form>";}

	pagina($numvinculos,$conta,$numpag,i("usuarios",$ilink),"ord=$ord&pest=$pest",$ilink);

}

?>

<script language=Javascript>
function borrar() {
	return confirm('Confirmar borrado de los usuarios marcados.')
}
</script>
