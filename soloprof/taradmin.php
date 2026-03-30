<?php

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

if ($_SESSION['auto'] < 10) {echo "<p></p><br>Usuario no autorizado";exit;}

?>

<script language="Javascript">
function hidet() {
	document.getElementById('divadmi').style.display = "none";
	document.getElementById('divenviv').style.display = "none";
	document.getElementById('divfororec').style.display = "none";
	document.getElementById('divbanner').style.display = "none";
	document.getElementById('dividioma').style.display = "none";
}
</script>

<?php

// --------------------------------------------------

echo "<table class='conhover'>";

echo "<tr>";
echo "<td>";
	echo "<span class='fr'>";
		$usu = ponerusu($retadmienvi,1,$ilink);
		echo $usu[0].$usu[1];
	echo "</span>";
	echo "Administrador que enviar&aacute; los mails autom&aacute;ticos y recibir&aacute; los mensajes de sistema<br>";
	echo "<span class='nob'>recordatorio de contrase&ntilde;a, etc.</span>";
	echo "</td>";
	echo "<td onclick=\"hidet();show('divadmi')\">";
	echo "<span class='icon-arrow-right txth grande'></span>";
	echo "</td>";
echo "</tr>";
		
echo "<tr>";
	echo "<td>";
	echo "<span id='divaltausu' class='fr grande'>";
	$iresult = $ilink->query("SELECT altalibre FROM atencion");
	$alta = $iresult->fetch_array(MYSQLI_BOTH);
	if ($alta[0]) {echo i("si",$ilink);} else {echo i("no",$ilink);}
	echo "</span>";
	echo "Cualquier usuario puede darse de <span class='rojo b'>alta</span> en el sistema &eacute;l mismo:<br>";
	echo "<span class='nob'>Si se selecciona NO, no se mostrar&aacute; en la p&aacute;gina inicial un mensaje similar a 
	'Nuevo usuario'</span>";
	echo "</td>";
	//$iresult = $ilink->query("SELECT altalibre FROM atencion");
	//$alta = $iresult->fetch_array(MYSQLI_BOTH);
	echo "<td  onclick=\"javascript:llamarasincrono('altausu.php', 'divaltausu')\">";
	echo "<span class='icon-arrow-right txth grande'></span>";
	echo "</td>";
echo "</tr>";

echo "<tr>";
	echo "<td>";
	echo "<span id='divnotas' class='fr grande'>";
	$iresult = $ilink->query("SELECT vernotas FROM atencion");
	$notas = $iresult->fetch_array(MYSQLI_BOTH);
	if ($notas[0]) {echo i("si",$ilink);} else {echo i("no",$ilink);}
	echo "</span>";
	echo "Permitir o no a los profesores mostrar las <span class='rojo b'>notas</span> a los alumnos<br>";
	echo "<span class='nob'>Si se selecciona NO, si un profesor quiere mostrar sus calificaciones a sus alumnos 
	ha de solicitar a un Administrador que active esta opci&oacute;n para todo el entorno</span>";
	echo "</td>";
	//$iresult = $ilink->query("SELECT vernotas FROM atencion");
	//$notas = $iresult->fetch_array(MYSQLI_BOTH);
	echo "<td  onclick = \"javascript:llamarasincrono('perminotas.php', 'divnotas')\">";
	echo "<span class='icon-arrow-right txth grande'></span>";
	echo "</td>";
echo "</tr>";

echo "<tr>";
	echo "<td>Gesti&oacute;n de <a href='../cuest/cueval.php?op=8' target='_blank' class='rojo b'>Cuestionarios</a><br>";
	echo "<span class='nob'></span>";
	$iresult = $ilink->query("SELECT cuestionario FROM atencion");
	$cuestp = $iresult->fetch_array(MYSQLI_BOTH);
	if ($cuestp[0]) {
		echo "Cuestionario principal: <a target='_blank' class='b' href='../cuest/cuestionario.php'>$cuestp[0]</a>";
	} else {
		echo "En este momento no hay un cuestionario en la p&aacute;gina de inicio.";
	}
	echo "</td>";
	echo "<td onclick=\"window.open('../cuest/cueval.php?op=8')\">";
	echo "<span class='icon-arrow-right txth grande'></span>";
	echo "</td>";
echo "</tr>";

echo "<tr>";
	echo "<td>";
	$iresult = $ilink->query("SELECT fechaforgen FROM atencion");
	$flimit = $iresult->fetch_array(MYSQLI_BOTH);
	echo "Foros y Recursos compartidos generales<br>";
	echo "<span class='nob'>Para mostrar o no los de a&ntilde;os anteriores, se refiere s&oacute;lo a los generales, no a los 
	de Asignatura y Titulaci&oacute;n.<br>La fecha l&iacute;mite est&aacute; definida en (yyyy-mm-dd) <span class='txth'>$flimit[0]</span>.</span>";
	echo "</td>";
	echo "<td onclick=\"hidet();show('divfororec')\">";
	echo "<span class='icon-arrow-right txth grande'></span>";
	echo "</td>";
echo "</tr>";

echo "<tr>";
	echo "<td>";
	$iresult = $ilink->query("SELECT usuid FROM chat");
	$usuchat = $iresult->num_rows;
	$iresult = $ilink->query("SELECT n FROM chatlista");
	$menschat = $iresult->num_rows;
	echo "N&uacute;mero de mensajes acumulados en el <span class='rojo b'>Chat</span> <span class='b' id='divchat'>$menschat</span><br>";
	echo "<span class='nob'>Es conveniente vaciar el log del Chat cuando se acumulan muchos mensajes y cuando no 
	se est&aacute; utilizando. En este momento hay <span class='b'>$usuchat</span> usuarios en chat.<br>Click en la flecha para
	vaciar.</span>";
	echo "</td>";
	echo "<td onclick = \"javascript:llamarasincrono('vacichat.php', 'divchat')\">";
	echo "<span class='icon-arrow-right txth grande'></span>";
	echo "</td>";
echo "</tr>";

echo "<tr>";
	echo "<td>";
	echo "Borrar ficheros <span class='rojo b'>temporales</span><br>";
	echo "<span class='nob'>Ficheros de texto de la orla, ficheros de audio del GIC, etc. Click en la flecha.</span>";
	echo "<div id='divtempo1'></div></td>";
	echo "<td id='divtempo' onclick = \"javascript:llamarasincrono('vacitempo.php', 'divtempo1')\">";
	echo "<span class='icon-arrow-right txth grande'></span>";
	echo "</td>";
echo "</tr>";

echo "<tr>";
	echo "<td>";
	echo "<span id='divgc' class='fr grande'>";
	$iresult = $ilink->query("SELECT gc FROM podcursoasigna WHERE asigna = '".$_SESSION['asigna']."'");
	$gc = $iresult->fetch_array(MYSQLI_BOTH);
	if ($gc[0] > 0) {echo i("si",$ilink);} else {echo i("no",$ilink);}
	echo "</span>";
	//$iresult = $ilink->query("SELECT gc FROM podcursoasigna WHERE asigna = '".$_SESSION['asigna']."'");
	//$gc = $iresult->fetch_array(MYSQLI_BOTH);
	echo "Categorizaci&oacute;n de v&iacute;nculos en la asignatura ".$_SESSION['asigna'].":<br>";
	echo "<span class='nob'>Con esta opci&oacute;n se activa en el apartado de v&iacute;nculos la posibilidad de categorizarlos por: nivel de 
	agregaci&oacute;n, tipo de soporte, tipo de recurso, &aacute;mbito de aplicaci&oacute;n y nivel de complejidad</span>";
	echo "</td>";
	echo "<td onclick = \"javascript:llamarasincrono('activgc.php', 'divgc')\">";
	echo "<span class='icon-arrow-right txth grande'></span>";
	echo "</td>";
echo "</tr>";

echo "<tr>";
	echo "<td>";
	echo "Optimizar Tablas<br>";
	echo "<span class='nob'>Realizar de vez en cuando, puede ralentizar el sistema mientras se hace. Click en la flecha.</span>";
	echo "</td>";
	echo "<td id='divtbl' onclick = \"javascript:llamarasincrono('optimtabl.php', 'divtbl')\">";
	echo "<span class='icon-arrow-right txth grande'></span>";
	echo "</td>";
echo "</tr>";

echo "<tr>";
	echo "<td>";
	$iresult = $ilink->query("SELECT vincmail FROM atencion");
	$fecha=$iresult->fetch_array(MYSQLI_BOTH);
	$fecha_menos3meses = gmdate('Y-m-d',time()-(3*30*24*60*60));
	echo "Env&iacute;o por mail de los v&iacute;nculos insertados a partir del ".ifecha31($fecha_menos3meses,$ilink).". 
	La &uacute;ltima vez que se hizo un env&iacute;o fue el ".ifecha31($fecha[0],$ilink)."<br>";
	echo "<span class='nob'>Se enviar&aacute; a cada usuario un mail con los v&iacute;nculos relativos al tema solicitado por cada uno</span>";
	echo "</td>";
	echo "<td onclick=\"hidet();show('divenviv')\">";
	echo "<span class='icon-arrow-right txth grande'></span>";
	echo "</td>";
echo "</tr>";

echo "<tr>";
	echo "<td>";
	echo "<span class='rojo b'>Texto</span> en movimiento que se mostrar&aacute; en la parte superior a todos los usuarios de todas las Asignaturas que est&eacute;n en l&iacute;nea<br>";
	echo "<span class='nob'>Los Profesores pueden insertar otro texto a los Alumnos de cada Asignatura
	</span>";
	echo "</td>";
	echo "<td onclick=\"hidet();show('divbanner')\">";
	echo "<span class='icon-arrow-right txth grande'></span>";
	echo "</td>";
echo "</tr>";

echo "<tr onclick = \"hidet();show('dividioma')\">";
	echo "<td>";
	echo "<span class='rojo b'>Idiomas</span>, cambiar algunos textos (Castellano, Ingl&eacute;s, Valenciano)<br>";
	echo "<span class='nob'>Por ejemplo: cambiar Profesor por Docente (en las partes del entorno en que est&eacute; configurado)</span>";
	echo "</td>";
	echo "<td onclick=\"hidet();show('dividioma')\">";
	echo "<span class='icon-arrow-right txth grande'></span>";
	echo "</td>";
echo "</tr>";

/*echo "<tr>";
	echo "<td>";
	echo "Sonidos del sistema<br>";
	echo "<span class='nob'>Sonido para los mensajes del Messenger y para la temporizaci&oacute;n de V&iacute;nculos</span>";
	echo "</td>";
	echo "<td onclick=\"hidet();show('divsonido')\">";
	echo "<span class='icon-arrow-right txth grande'></span>";
	echo "</td>";
echo "</tr>";*/

echo "</table>";

?>