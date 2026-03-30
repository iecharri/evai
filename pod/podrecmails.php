<?php

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

if($_SESSION['auto'] < 10) {return;}

?>

<script language="javascript">
	function borrar(form1) {
	if (document.form1.borrar.checked) {
		return confirm("<?php echo i("confirmborr",$ilink);?>");
	}
}
</script>

<?php


$caso = 6; require_once APP_DIR . "/pod/podformfiltro.php";

if (!$ord) {$ord = "date";}
if ($ord == "date") {$ord = "date DESC";}
if ($ord == "nombre") {$ord = "alumnoa,alumnon";}

// --------------------------------------------------

if ($date AND $de AND !$fid) {
	$topic = addslashes($topic);
	$text = addslashes($text);
	$date = explode(" ",$date);
	$date = usuautc($date[0],$date[1]);
	$date = $date[0]." ".$date[1];
	$nomfich = $_FILES['attachfich']['name'];
	if ($nomfich) {
		$tipo    = $_FILES["attachfich"]["type"];
		$archivo = $_FILES["attachfich"]["tmp_name"];
		$tamanio = $_FILES["attachfich"]["size"];
		$contenido = file_get_contents($archivo);
		$contenido = $ilink->real_escape_string($contenido);
	}
	$ilink->query("INSERT INTO mailrec (typeattach, de, date, topic, text, attach, para, curso, attachfich, area) VALUES ('$tipo', '$de', '$date', '$topic', '$text', '$nomfich', '".$_SESSION['usuid']."', '".trim($filtrocurso)."', '$contenido', '$filtroarea')");
}

// --------------------------------------------------

if ($date AND $de AND $fid AND $edit) {
	if ($borrar == "on") {
		$ilink->query("DELETE FROM mailrec WHERE id = '$fid'");
	} else {
		$topic = addslashes($topic);
		$text = addslashes($text);
		$date = explode(" ",$date);
		$date = usuautc($date[0],$date[1]);
		$date = $date[0]." ".$date[1];
		if ($borraradj) {
			$nomfich=""; $contenido = "";
		}
		$nomfich = $_FILES['attachfich']['name'];
		if ($nomfich) {
			$tipo    = $_FILES["attachfich"]["type"];
			$archivo = $_FILES["attachfich"]["tmp_name"];
			$tamanio = $_FILES["attachfich"]["size"];
			$contenido = file_get_contents($archivo);
			$contenido = $ilink->real_escape_string($contenido);
		}
		$sql = "UPDATE mailrec SET typeattach='$tipo', de = '$de', date = '$date', topic = '$topic', text = '$text', attach = '$nomfich', attachfich = '$contenido' WHERE id = '$fid'";
		$ilink->query($sql);
	}
}

// --------------------------------------------------

if ($fid AND !$edit) {
	winop(i("editar1",$ilink),'div99','');
	$iresult = $ilink->query("SELECT * FROM mailrec WHERE id = '$fid'");
	$fila = $iresult->fetch_array(MYSQLI_BOTH);
	echo "<form method='post' enctype='multipart/form-data'>";
	$date = utcausu1($fila['date']);
	echo "Fecha<br><input class='col-3' type='text' name='date' size='19' maxlength='19' value='$date'>";
	echo "<br>De<br>";
	if ($filtroarea) {$filtro1 = " AND area = '$filtroarea'";}
	if ($filtrocurso) {$filtro1 .= " AND curso = '".trim($filtrocurso)."'";}
	$sql = "SELECT DISTINCT usuarios.id, alumnon, alumnoa FROM profcurareafigura";
	$sql .= " LEFT JOIN usuarios ON profcurareafigura.profeid=usuarios.id";
	$sql .= " WHERE 1=1 $filtro1 ORDER BY alumnoa, alumnon";
	$result = $ilink->query($sql);
	echo "<select class='col-10' name='de'>";
	while ($f = $result->fetch_array(MYSQLI_BOTH)) {
		echo "<option value='$f[0]'";
		if ($f[0] == $fila['de']) {echo " selected = 'selected'";}
		echo ">$f[2], $f[1]</option>";
	}
	echo "</select>";
	echo "<br>Asunto<br><input class='col-10' type='text' name='topic' value = \"".$fila['topic']."\">";
	echo "<br>Texto<br><textarea class='col-10' rows='10' cols='40' name='text'>".$fila['text']."</textarea>";
	echo "<br>Fichero adjunto <input type='file' name='attachfich' class='col-3'>";
	if ($fila['attach']) {
		echo " <a href='podfich1.php?id=".$fila['id']."' target='_blank'>".$fila['attach']."</a> <input type='checkbox' name='borraradj'> <span class='rojo b'>Borrar</span>";
	}
	echo " <span class='rojo b'>BORRAR <input type='checkbox' name='borrar'>";
	echo "</span><input type='hidden' name='edit' value='1'><input type='hidden' name='fid' value='$fid'>
	 <input class='col-1' type='submit' value=' >> '>";
	echo "</form>";
	echo "</div></div>";
}

// --------------------------------------------------

if ($anadir) {
	winop(i("anadir1",$ilink),'div991','');
	echo "<form method='post' enctype='multipart/form-data'>";
	$usuario_fmt = fecha_actual_usuario_his();
	echo "Fecha<br><input class='col-3' type='text' name='date' size='19' maxlength='19' value='".$usuario_fmt."'>";
	echo "<br>De<br>";
	if ($filtroarea) {$filtro1 = " AND area = '$filtroarea'";}
	if ($filtrocurso) {$filtro1 .= " AND curso = '".trim($filtrocurso)."'";}

	$sql = "SELECT DISTINCT usuarios.id, alumnon, alumnoa FROM profcurareafigura";
	$sql .= " LEFT JOIN usuarios ON profcurareafigura.profeid=usuarios.id";
	$sql .= " WHERE 1=1 $filtro1 ORDER BY alumnoa, alumnon";

	$result = $ilink->query($sql);
	echo "<select class='col-10' name='de'>";
	while ($f = $result->fetch_array(MYSQLI_BOTH)) {
		echo "<option value='$f[0]'>$f[2], $f[1]</option>";
	}
	echo "</select>";
	echo "<br>Asunto<br><input class='col-10' type='text' name='topic'>";
	echo "<br>Texto<br><textarea class='col-10' rows='10' cols='40' name='text'></textarea>";
	echo "<br>Fichero adjunto <input class='col-6' type='file' name='attachfich' class='col-3'>";
	echo " <input class='col-1' type='submit' value=' >> '>";
	echo "</form>";
	echo "</div></div>";
}

// --------------------------------------------------

$sql = "SELECT mailrec.id, date, de, topic, text, attach, date,";
$sql .= " mailrec.curso FROM mailrec";
$sql .= " LEFT JOIN profcurareafigura ON profcurareafigura.profeid = mailrec.id AND profcurareafigura.curso = mailrec.curso AND profcurareafigura.area = mailrec.area";
$sql .= " LEFT JOIN usuarios ON mailrec.de = usuarios.id";
$sql .= " WHERE para = '".$_SESSION['usuid']."'";

if ($filtroarea) {$sql .= " AND mailrec.area = '$filtroarea'";}
if ($filtroprof) {$sql .= " AND de = '$filtroprof'";}
if ($filtrocurso) {$sql .= " AND mailrec.curso = '".trim($filtrocurso)."'";}

$result = $ilink->query($sql);
$numfilas = $result->num_rows;

if ($numfilas == 0) {

	echo "<center><br>".i("messno",$ilink)."</center>";
	return;

}

$sql .= " ORDER BY $ord";
$result = $ilink->query($sql);

echo "<br><table class='conhover'>";
echo "<tr><th class='col-01'><a href='?conta=$conta&anadir=1&$filtro'>".i("anadir1",$ilink)."</a></th><th class='col-01'>".i("curso",$ilink)."</th>
		<th class='col-01 nowrap'><a href='?$filtro'>Fecha</a></th>
		<th class='col-01 nowrap'><a href='?$filtro&ord=nombre'>De</a></th>
		<th class='col-10'><a href='?$filtro&ord=topic'>Asunto</a></th><th>Adjunto</th><th class='col-01 nowrap'></th></tr>";
while ($temp = $result->fetch_array(MYSQLI_BOTH)) {

	echo "<tr>";
	echo "<td><a href='?conta=$conta&fid=".$temp['id']."&$filtro'>editar</a></td>";
	echo "<td>";
	if ($temp['curso']) {echo $temp['curso'];}
	echo "</td>";
	echo "<td class='nowrap'>".utcausu1($temp['date'])."</td>";
	echo "<td class='col-01 nowrap'>";
	$usua = ponerusu($temp['de'],1,$ilink);
	echo $usua[0];
	echo $usua[1];
	echo "</td>";
	echo "<td>".$temp['topic'];
	echo "<div id='div".$temp['id']."' class='colu col-10' style='display:none'><span class='b'>Texto</span>:<br>".nl2br($temp['text'])."</div>";
	echo "</td>";
	echo "<td>";
	if ($temp['attach']) {
		echo "<a href='podfich1.php?id=".$temp['id']."' target='_blank'>".$temp['attach']."</a>";
	}
	echo "</td>";
	echo "<td class='col-01 nowrap'>";
	echo "<a name='".$temp['id']."'></a> [ <a href='javascript:void(0)' onclick=\"amplred('div".$temp['id']."')\" class='txth b'>Ampliar/reducir</a> ]<br>";
	echo "</td>";

}
echo "</tr></table>";

?>


