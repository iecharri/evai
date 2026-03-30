<?php

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

if ($_SESSION['auto'] < 5) {return; exit;}

$temp = $ilink->query("SELECT max(cu) FROM ".$cuest."2");
$fila = $temp->fetch_array(MYSQLI_BOTH);

if (!$fila[0]) {
	echo "<p><br></p><div class='mediana'>No hay ning&uacute;n cuestionario registrado.</div>";
	return;
}
$max = $fila[0];

$temp = $ilink->query("SELECT * FROM ".$cuest."1 WHERE !n");
$fila = $temp->fetch_array(MYSQLI_BOTH);
extract($fila);

if($_GET['impr']) {

	echo "<div class='noimprimir'><a href='?opc=$opc&cuest=$cuest'>Cuestionarios uno a uno</a> - Todos los cuestionarios para imprimir</div>";

	echo "<br><form class='noimprimir' method='post' action='cueval.php?cuest=$cuest&opc=$opc&impr=1'>";
	echo "<textarea class='ancha' cols='90' rows='3' name='encab' 
			 placeholder='Encabezado por Usuario para imprimir todos los cuestionarios. Rellenar con Asignatura, Titulaci&oacute;n, Curso o el texto que se quiera. Pulsar LISTAR.'>".$_POST['encab']."</textarea>
			 <br> &nbsp; <input class='col-1' type='submit' value= ' >> Listar >> '>";
	echo "</form><p></p>";
	
	$sql3 = "SELECT DISTINCT(cu) FROM ".$cuest."2";
	$result3 = $ilink->query($sql3);
	while ($fila3 = $result3->fetch_array(MYSQLI_BOTH)) {
		$cu = $fila3[0];
		if($_POST['encab']) {
			echo "<div class='soloimprimir'>".nl2br($_POST['encab'])."</div><p></p>";
		}
		echo "<div class=''>";
			require_once APP_DIR . '/cuest/ver1en1_1.php';
		echo "</div>";
		require_once APP_DIR . '/cuest/cuest_1en1.php';
		echo "<div class='saltopagina'></div>";
		echo "<div class='noimprimir'><p></p></div>";
	}

	return;
	
}

// --------------------------------------------------

if ($_GET['borr']) {
	$ilink->query("DELETE FROM $cuest"."2 WHERE cu = '".$_GET['cu']."'");
}

// --------------------------------------------------

echo "<div class='noimprimir'>";

	echo "Cuestionarios uno a uno - <a href='?opc=$opc&cuest=$cuest&impr=1'>Todos los cuestionarios para imprimir</a><p></p>";

	if(!$fila[0]) {$fila[0] = "0";}
	echo "<li>N&deg; de cuestionarios <span class='b'>".$cuest."</span> respondidos hasta el momento: <span class='b'>$max</span>. ";

	$guardcu = $cu;
	if ($_GET['csv']) {
		require_once APP_DIR . '/cuest/csv.php';
	} else {
		echo "<a href='?cuest=$cuest&opc=$opc&cu=$cu&csv=1'>Exportar respuestas a $cuest.csv</a>";
	}
	$cu = $guardcu;

	echo "<li><span class='b'>&iexcl;ATENCI&Oacute;N! Se incluyen los que puedan estar en estos momentos en ejecuci&oacute;n</span></li>"; // y los que no han sido validados.</span></li>";

// --------------------------------------------------

	$result = $ilink->query("SELECT visible, visialuresp, guardar, formula FROM $cuest"."1 WHERE !n");
	$fila1 = $result->fetch_array(MYSQLI_BOTH);
	
	echo "<li>";

	if($fila1['visible']) {echo " El cuestionario está visible";} else {echo " El cuestionario no está visible";}
	if($fila1['guardar'] == 2 AND $fila1['visible']) {echo " - No es necesario estar dado de alta en " . SITE . " para responderlo.";}


	if($fila1['visialuresp'] AND $fila1['visible'] AND $fila1['guardar'] == 1) {
		echo " - Los alumnos ven las respuestas correctas y su nota. Si no lo han respondido ya no pueden verlo ni hacerlo.";
	} elseif($fila1['visible'] AND $fila1['guardar']) {
		echo " <li> No ven la nota, ni las respuestas correctas, ni si su respuesta es correcta, ni el feedback ni las observaciones que haya podido poner el profesor. Sólo ven el cuestionario con sus respuestas.</li>";
	}

	echo "</li><p></p>";

echo "</div>";
	
// --------------------------------------------------

if (!$cu OR $cu == 0 OR $max < $cu) {$cu = 1;}
$menos = $cu - 1; if ($menos < 1) {$menos = 1;}
$mas = $cu + 1; if ($mas > $max) {$mas = $cu;}

echo "<span class='noimprimir'>";
echo "<a href='?cuest=$cuest&cu=1&opc=$opc'><span class='icon-first'></span></a>";
echo "<a href='?cuest=$cuest&cu=".$menos."&opc=$opc'><span class='icon-backward2'></span></a>";
echo " &nbsp; <a href='?cuest=$cuest&cu=$cu&opc=$opc&borr=1' onclick=\"return borrar()\"><span class='icon-bin'></span></a>  Cuest. $cu ";
echo " &nbsp; <a href='?cuest=$cuest&cu=".$mas."&opc=$opc'><span class='icon-forward3'></span></a>";
echo "<a href='?cuest=$cuest&cu=".$max."&opc=$opc'><span class='icon-last'></span></a>";
echo "</span>";

$sqlx = "SELECT * FROM ".$cuest."2 WHERE cu = '$cu'";
$iresult = $ilink->query($sqlx);

if (!$iresult->num_rows) {
	echo "<p></p><div class='rojo b'>El cuestionario no existe</div>";return;
}

require_once APP_DIR . '/cuest/ver1en1_1.php';

echo "<p></p>";

require_once APP_DIR . '/cuest/cuest_1en1.php';
	
// --------------------------------------------------

function anotaciones($n,$cuest,$cu,$opc,$ilink) {
	
	if (!$cu OR !$n) {return;}

	$iresult = $ilink->query("SELECT obs FROM ".$cuest."2 WHERE cu='$cu' AND n='$n'");
	$fila = $iresult->fetch_array(MYSQLI_BOTH);
	echo "<br><span class='b'>Observaciones:</span> ";
	echo "<form method='post' action='?opc=$opc&cuest=$cuest&cu=$cu&i=$n'>";
	echo "<input type='text' class='col-5' name='obs_cu$cu"."_i$n' size='100' maxlength='255' value=\"$fila[0]\">";
	echo " <input class='col-05 noimprimir' type='submit' name='obs1_cu$cu"."_i$n' value=' >> '>";
	echo "</form>";

}

?>
