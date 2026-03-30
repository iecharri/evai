<?php

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

if (!soyadmiano($asigna,$curso,$ilink)) {return;}
$filtro = "titulaci = '$tit' AND curso = '$curso'";

?>

<script language="Javascript">
function hidet() {
	document.getElementById('divcopyfich').style.display = "none";
	document.getElementById('divborrforo').style.display = "none";
	//document.getElementById('divmenualut').style.display = "none";
}
</script>

<?php

// --------------------------------------------------

echo "<table class='conhover'>";

echo "<tr>";
echo "<td>";
		echo "Copiar los ficheros de [<span class='verdecalific b'>$tit $curso</span>] en otra.<br>";
		echo "<span class='nob'>Has de estar autorizado</span>";
		echo "</td>";
	echo "<td  onclick=\"hidet();show('divcopyfich')\">";
	echo "<span class='icon-arrow-right txth grande'></span>";
	echo "</td>";
echo "</tr>";

echo "<tr>";
	echo "<td>";
	$result = $ilink->query("SELECT forospormail FROM titcuradmi WHERE $filtro");
	$hayadmi = $result->num_rows;
	$fxm = $result->fetch_array(MYSQLI_BOTH);
	echo "<span id='divforomailtit' class='fr grande'>";
	if ($hayadmi) {
		if ($fxm[0] == 1) {
			echo i("si",$ilink);
		} elseif($fxm[0] == 2) {
			echo "PHP";
		} else {
			echo i("no",$ilink);
		}
	}
	echo "</span>";
	echo "<span class='rojo b'>Env&iacute;o</span> de los mensajes del foro por mail: <span class='mediana'>NO / SI / Primero de hilo de Profesor (PHP)</span><br>";
	echo "<span class='mediana'>NO</span>: no se envía ningún mail de aviso<br>";
	echo "<span class='mediana'>SI</span>: se envían mails de aviso de nueva aportación a los usuarios que están participando en el foro<br>";
	echo "<span class='mediana'>PHP</span>: se envía un mail de aviso a todos los Alumnos y Profesores de <span class='rojo'>$tit $curso</span> sólo cuando el Profesor crea un nuevo hilo<br>";
	if (!$hayadmi) {
		echo "<div class='col-9 colu'>Es necesario asignar un Administrador de Titulaci&oacute;n (solicitar al Administración de <a class='b' href='../contacto.php'>EVAI</a>) para cambiar &eacute;sto</div>";
	}
	echo "</td>";
	echo "<td onclick = \"javascript:llamarasincrono('pforoxmailtit.php', 'divforomailtit')\">";
	echo "<span class='icon-arrow-right txth grande'></span>";
	echo "</td>";
echo "</tr>";

echo "<tr>";
	echo "<td>";
	$result = $ilink->query("SELECT notispormail FROM titcuradmi WHERE $filtro");
	$hayadmi = $result->num_rows;
	$nxm = $result->fetch_array(MYSQLI_BOTH);
	echo "<span id='divnotimail' class='fr grande'>";
	if ($hayadmi) {
		if ($nxm[0] > 0) {
			echo i("si",$ilink);
		} else {
			echo i("no",$ilink);
		}
	}
	echo "</span>";
	echo "<span class='rojo b'>Env&iacute;o</span> de los avisos y mensajes de la agenda por mail<br>";
	if (!$hayadmi) {
		echo "<div class='col-9 colu'>Es necesario asignar un Administrador de Titulaci&oacute;n (solicitar al Administración de <a class='b' href='../contacto.php'>EVAI</a>) para cambiar &eacute;sto</div>";
	}
	echo "</td>";
	echo "<td  onclick = \"javascript:llamarasincrono('pnotixmailtit.php', 'divnotimail')\">";
	echo "<span class='icon-arrow-right txth grande'></span>";
	echo "</td>";
echo "</tr>";

echo "<tr>";
echo "<td>";
	echo "<span class='fr'>";
	echo "</span>";
	echo "Borrar los mensajes del foro de [<span class='verdecalific b'>$tit $curso</span>]<br>";
	echo "<span class='nob'></span>";
	echo "</td>";
	echo "<td onclick=\"hidet();show('divborrforo')\">";
	echo "<span class='icon-arrow-right txth grande'></span>";
	echo "</td>";
echo "</tr>";
/*echo "<tr>";
echo "<td>";
	echo "<span class='fr'>";
	echo "</span>";
	echo "Cambiar el <span class='rojo b'>Men&uacute;</span> con el que acceden los Alumnos<br>";
	echo "</td>";
	echo "<td onclick=\"hidet();show('divmenualut')\">";
	echo "<span class='icon-arrow-right txth grande'></span>";
	echo "</td>";
echo "</tr>";*/
echo "</table>";
return;

?>