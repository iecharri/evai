<?php

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

if ($_SESSION['auto'] < 2 OR $_SESSION['tipo'] == 'E') {return;}
$usuid = $_SESSION['usuid'];

?>

<script language='JavaScript' type='text/javascript'>
function campos(form1) {

	if (form1.desde.value == "" || form1.hasta.value == "")
	{
		alert("<?php echo i("completa",$ilink);?>")
		form1.desde.focus()
		return false
	}

}
</script>

<?php

// --------------------------------------------------

if ($_POST['desde'] AND $_POST['hasta'] AND $_POST['desde'] != $_POST['hasta'] AND $_POST['trasp']) {

	extract($_GET);
	extract($_POST);
	$desde = strtoupper($desde);
	$hasta = strtoupper($hasta);

	if ($_SESSION['tipo'] == "A") {
		$iresult = $ilink->query("SELECT asigna FROM alumasiano WHERE id = '$usuid' AND asigna = '$desde'");
		$temp = $iresult->fetch_array(MYSQLI_BOTH);
		$iresult = $ilink->query("SELECT asigna FROM alumasiano WHERE id = '$usuid' AND asigna = '$hasta'");
		$temp1 = $iresult->fetch_array(MYSQLI_BOTH);
	}
	if ($_SESSION['tipo'] == "P") {
		$iresult = $ilink->query("SELECT asigna FROM asignatprof WHERE usuid = '$usuid' AND asigna = '$desde'");
		$temp = $iresult->fetch_array(MYSQLI_BOTH);
		$iresult = $ilink->query("SELECT asigna FROM asignatprof WHERE usuid = '$usuid' AND asigna = '$hasta'");
		$temp1 = $iresult->fetch_array(MYSQLI_BOTH);
	}
	if (($temp[0] OR $desde == "GEN") AND ($temp1[0] OR $hasta == "GEN")) {

		$sql = "UPDATE vinculos SET area = '$hasta' WHERE area = '$desde' AND usu_id = '$usuid'";
		$ilink->query($sql);
		if ($ilink->errno) {die ("Error");}
		if ($hasta == 'GEN' OR $desde='GEN') {$ilink->query("DELETE FROM usuasi WHERE id = '$usuid' AND asigna = 'GEN'");}

	}

}

// --------------------------------------------------

$u = $usuid; require_once APP_DIR . '/gic_actu.php';

$iresult = $ilink->query("SELECT numvinc FROM usuarios WHERE id = '$usuid' LIMIT 1");
$fila = $iresult->fetch_array(MYSQLI_BOTH);

if ($fila[0]) {

	$sql = "SELECT cod, asignatura, numvinc FROM usuasi LEFT JOIN podasignaturas
		ON podasignaturas.cod = usuasi.asigna WHERE id = '$usuid' AND numvinc > 0 ORDER BY asigna";
	$result = $ilink->query($sql);

	echo "<p><span class='b u'>".i("tengovinc",$ilink).":</span></p>";

	while($fila = $result->fetch_array(MYSQLI_BOTH)) {

	if($fila[0] == 'GEN' OR !$fila[0]) {
		echo "<span class='verdecalific b'>GEN</span> - Asignatura genérica";
	} else {
		echo "<span class='verdecalific b'>".$fila[0]."</span> - ".$fila[1];
	}
	echo ". ".i("vinculos",$ilink).": <span class='txth b'>".$fila[2]."</span><br>";

	}

	echo "<p><br><p/><form method=post name='form1' action='?usuid=$usuid&ord=ord&op=9&pest=4' onsubmit=\"return campos(form1)\">";
	echo "<span class='verdecalific b'>Cod.</span> <input class='col-1' type='text' name='desde' size='15' maxlength='15'> ";
	echo i("traspvinc",$ilink)." <input class='col-1' type='text' name='hasta' size='15' maxlength='15'>";
	echo " <input class='col-1' type='submit' name='trasp' value=' >> '>";
	echo "</form>";

}

?>
