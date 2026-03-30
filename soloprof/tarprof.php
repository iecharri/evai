<?php

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

if (!esprofesor($asigna,$curso,$grupo,$ilink) AND !soyadmiano($asigna,$curso,$ilink)) {return;}
$filtro = "asigna = '$asigna' AND curso = '$curso' AND grupo='$grupo'";
?>

<script language="Javascript">
function hidet() {
	document.getElementById('divaltamail').style.display = "none";
	document.getElementById('divcopyfich').style.display = "none";
	//document.getElementById('divmenualu').style.display = "none";
	document.getElementById('divborrforo').style.display = "none";
	document.getElementById('divbanner').style.display = "none";
	document.getElementById('divlogo').style.display = "none";
}
</script>

<?php

// --------------------------------------------------

//echo "<div class='center'>Configuraci&oacute;n de $asigna $curso $grupo
//	(click en la flecha para ver o cambiar) [<a href='http://www.evai.net/evaih/tutoriales/prueba/flash/prof2.html'
//	target='_blank'>Ayuda</a>]</div>";

echo "<table class='conhover'>";

echo "<tr>";
	echo "<td colspan ='2'>
	Gesti&oacute;n de <a href='../cuest/cueval.php?op=4' class='rojo b'>Cuestionarios</a> ";
	echo "<span class='nob'> [<span class='verdecalific b'>$asigna</span>]</span>";
	echo "</td>";
echo "</tr>";

echo "<tr>";
	echo "<td>";
	$iresult = $ilink->query("SELECT visibleporalumnos FROM cursasigru WHERE $filtro");
	$visi = $iresult->fetch_array(MYSQLI_BOTH);
	echo "<span id='divvisi' class='fr grande'>";
	if ($visi[0]) {echo i("si",$ilink);} else {echo i("no",$ilink);}
	echo "</span>";
	echo "<span class='rojo b'>Visibilidad</span> por parte de los alumnos<br>";
	echo "<span class='nob'>Si se selecciona NO, los Alumnos no podr&aacute;n acceder a esta [Asignatura Curso Grupo]. Puede
	servir cuando el Profesor est&aacute; a&uacute;n confeccionando el material, el curso no ha comenzado, ha terminado, etc</span>";
	echo "</td>";
	echo "<td class='col-01' onclick = \"javascript:llamarasincrono('pasivisi.php', 'divvisi')\">";
	echo "<span class='icon-arrow-right txth grande'></span>";
	echo "</td>";
echo "</tr>";

echo "<tr>";
	echo "<td>";
	$iresult = $ilink->query("SELECT altalibre FROM cursasigru WHERE $filtro");
	$altalib = $iresult->fetch_array(MYSQLI_BOTH);
	echo "<span id='divaltalib' class='fr grande'>";
	if ($altalib[0]) {echo i("si",$ilink);} else {echo i("no",$ilink);}
	echo "</span>";
	echo "Permitir el <span class='rojo b'>alta libre</span> de usuarios<br>";
	echo "<span class='nob'>Si se permite, los alumnos que previamente se hayan dado de alta en el entorno, podr&aacute;n entrar y salir en [<span class='verdecalific b'>$asigna $curso $grupo</span>] sin solicitarlo</span>";
	echo "</td>";
	echo "<td onclick = \"javascript:llamarasincrono('paltalib.php', 'divaltalib')\">";
	echo "<span class='icon-arrow-right txth grande'></span>";
	echo "</td>";
echo "</tr>";

echo "<tr>";
echo "<td>";
	$iresult = $ilink->query("SELECT patronmail FROM cursasigru WHERE $filtro");
	$mail = $iresult->fetch_array(MYSQLI_BOTH);
	echo "Permitir el alta de usuarios siempre que su mail contenga la cadena... $mail[0]<br>";
	echo "<span class='nob'>S&oacute;lo tiene sentido si la opci&oacute;n anterior es ".i("NO",$ilink).".</span>";
	echo "</td>";
	echo "<td onclick=\"hidet();show('divaltamail')\">";
	echo "<span class='icon-arrow-right txth grande'></span>";
	echo "</td>";
echo "</tr>";

echo "<tr>";
echo "<td>";
	echo "Copiar los ficheros de esta [Asignatura Curso Grupo] en otra.<br>";
	echo "<span class='nob'>Has de ser Profesor o estar autorizado</span>";
	echo "</td>";
	echo "<td onclick=\"hidet();show('divcopyfich')\">";
	echo "<span class='icon-arrow-right txth grande'></span>";
	echo "</td>";
echo "</tr>";

/*echo "<tr>";
echo "<td>";
	echo "<span class='fr'>";
	echo "</span>";
	echo "<span class='rojo b'>Men&uacute;</span> con el que acceden los Alumnos<br>";
	echo "<span class='nob'>Selecci&oacute;n actual: $retmenualu</span>";
	echo "</td>";
	echo "<td onclick=\"hidet();show('divmenualu')\">";
	echo "<span class='icon-arrow-right txth grande'></span>";
	echo "</td>";
echo "</tr>";*/

echo "<tr>";
	echo "<td>";
	$iresult = $ilink->query("SELECT gic FROM cursasigru WHERE $filtro");
	$gic = $iresult->fetch_array(MYSQLI_BOTH);
	echo "<span id='divgic' class='fr grande'>";
	if ($gic[0] > 0) {echo i("si",$ilink);} else {echo i("no",$ilink);}
	echo "</span>";
	echo "Gestor Interactivo de Conocimiento <span class='rojo b'>GIC</span><br>";
	echo "<span class='nob'>Posibilidad de que se puedan insertar v&iacute;nculos</span>";
	echo "</td>";
	echo "<td onclick = \"javascript:llamarasincrono('pgic.php', 'divgic')\">";
	echo "<span class='icon-arrow-right txth grande'></span>";
	echo "</td>";
echo "</tr>";

echo "<tr>";
	echo "<td>";
	$iresult = $ilink->query("SELECT forospormail FROM cursasigru WHERE $filtro");
	$fxm = $iresult->fetch_array(MYSQLI_BOTH);
	echo "<span id='divforomail' class='fr grande'>";
	if ($fxm[0] == 1) {
		echo i("si",$ilink);
	} elseif($fxm[0] == 2) {
		echo "PHP";
	} else {
		echo i("no",$ilink);
	}
	echo "</span>";
	echo "<span class='rojo b'>Enviar</span> los mensajes del foro por mail: <span class='mediana'>NO / SI / Primero de hilo de Profesor (PHP)</span><br>";
	echo "<span class='nob'>&Eacute;sto puede ralentizar el sistema si hay muchos usuarios y el foro est&aacute; muy activo</span><br>";
	echo "<span class='mediana'>NO</span>: no se envía ningún mail de aviso<br>";
	echo "<span class='mediana'>SI</span>: se envían mails de aviso de nueva aportación a los usuarios que están participando en el foro<br>";
	echo "<span class='mediana'>PHP</span>: se envía un mail de aviso a todos los Alumnos y Profesores de <span class='rojo'>$asigna $curso $grupo</span> sólo cuando el Profesor crea un nuevo hilo<br>";
	echo "</td>";
	echo "<td  onclick = \"javascript:llamarasincrono('pforoxmail.php', 'divforomail')\">";
	echo "<span class='icon-arrow-right txth grande'></span>";
	echo "</td>";
echo "</tr>";

echo "<tr>";
	echo "<td>";
	$iresult = $ilink->query("SELECT notispormail FROM cursasigru WHERE $filtro");
	$nxm = $iresult->fetch_array(MYSQLI_BOTH);
	echo "<span id='divnotimail' class='fr grande'>";
	if ($nxm[0] > 0) {echo i("si",$ilink);} else {echo i("no",$ilink);}
	echo "</span>";
	echo "<span class='rojo b'>Enviar</span> los avisos y mensajes de la agenda por mail<br>";
	echo "<span class='nob'>&Eacute;sto puede ralentizar el sistema</span>";
	echo "</td>";
	echo "<td onclick = \"javascript:llamarasincrono('pnotixmail.php', 'divnotimail')\">";
	echo "<span class='icon-arrow-right txth grande'></span>";
	echo "</td>";
echo "</tr>";

echo "<tr>";
echo "<td>";
	echo "<span class='fr'>";
	echo "</span>";
	echo "Borrar los mensajes del foro de [<span class='verdecalific b'>$asigna $curso $grupo</span>]<br>";
	echo "<span class='nob'></span>";
	echo "</td>";
	echo "<td onclick=\"hidet();show('divborrforo')\">";
	echo "<span class='icon-arrow-right txth grande'></span>";
	echo "</td>";
echo "</tr>";

echo "<tr>";
	echo "<td>";
	echo "<span class='rojo b'>Texto</span> en movimiento que se mostrar&aacute; en la parte superior a los usuarios de [<span class='verdecalific b'>$asigna $curso $grupo</span>] que est&eacute;n en l&iacute;nea<br>";
	if (trim($retbanner)) {$retbanner = "En este momento: ".$retbanner;}
	echo "<span class='nob'>$retbanner</span>";
	echo "</td>";
	echo "<td onclick=\"hidet();show('divbanner')\">";
	echo "<span class='icon-arrow-right txth grande'></span>";
	echo "</td>";
echo "</tr>";

echo "<tr>";
	echo "<td>";
	echo "Logo y descripci&oacute;n de [<span class='verdecalific b'>$asigna $curso $grupo</span>]<br>";
	echo "<span class='nob'>Se mostrar&aacute; en la p&aacute;gina de inicio.</span>";
	echo "</td>";
	echo "<td onclick=\"hidet();show('divlogo')\">";
	echo "<span class='icon-arrow-right txth grande'></span>";
	echo "</td>";
echo "</tr>";

echo "</table>";

?>