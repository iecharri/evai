<?php

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

if ($_POST['idedit']) {
	foroedit1($ilink);
	$mens = i("hecho",$ilink);
}

$idedit = $_GET['idedit'];
if (!$idedit) {$idedit = $_POST['idedit'];}
if (!$idedit) {return;}
$edit = foroedit($_GET['id'],$idedit,$ilink,$mens);
echo $edit;

//Editar un mensaje

function foroedit($id,$idedit,$ilink,$mens) {
	if (!$idedit) {return;}
	
	//if($_GET['invi'] == 1) {$hide = "";}
	//if($_GET['invi'] == 2) {$hide = 2;}

	//$ilink->query("UPDATE foro SET invisible = '$hide' WHERE id = '".$_GET['idedit']."' LIMIT 1");
	
	$iresult = $ilink->query("SELECT titulaci,curso FROM foro WHERE id = '$id' LIMIT 1");
	$titulaci = $iresult->fetch_array(MYSQLI_BOTH);
	$iresult = $ilink->query("SELECT asigna, curso, grupo FROM foro WHERE id = '$id' LIMIT 1");
	$asi = $iresult->fetch_array(MYSQLI_BOTH);
	$iresult = $ilink->query("SELECT asunto, comentario, categoria,invisible FROM foro WHERE id = '$idedit' LIMIT 1");
	$fila = $iresult->fetch_array(MYSQLI_BOTH);
	$iresult = $ilink->query("SELECT palabra FROM forocategorias WHERE id = '".$fila['categoria']."' LIMIT 1");
	$edcat = $iresult->fetch_array(MYSQLI_BOTH);
	extract($fila);
	if ($titulaci[0]) {
		if (esadmidetit($titulaci[0],$titulaci[1],$ilink)) {$x=1;}
	} elseif ($asi[0]) {
		$iresult = $ilink->query("SELECT tit FROM podcursoasignatit WHERE curso = '$asi[1]' AND asigna = '$asi[0]'");
		$tit = $iresult->fetch_array(MYSQLI_BOTH);
		if (esprofesor($asi[0],$asi[1],$asi[2],$ilink) OR esadmidetit($tit[0],$asi[1],$ilink)) {$x=1;}
	} else {
		if ($_SESSION['auto'] == 10) {$x=1;}
	}
	if (!$x) {return;}

	//$invi = $fila['invisible'];
	//if (!$invi) {$hide = 2; $pon = "HIDE";} else {$hide = 1;$pon = "SHOW";}
	
	//$formu = "xxxx<span class='rojo b peq u'>".i("noborrf",$ilink)."</span> ";
	//$formu .= "<a href='?id=$id&idedit=$idedit&invi=$hide'>$pon</a><p></p>";
	$formu = "<form name='form1' method='post' onsubmit='return compruebacamposforo2(form1)'>\n";
	$formu .= "\n";

	if ($fila[0]) {
		$formu .= "<label class='b'>".i("categoria",$ilink)."</label><br><input class='col-10' type='text' maxlength='100' name='categoria' value=\"".quitabarra($edcat[0])."\"><br>";
		$formu .= "<label class='b'>".i("asunto",$ilink)."</label><br><input class='col-10' type='text' maxlength='100' name='asunto' value=\"".quitabarra($fila[0])."\" required><br>";
	}	
	$formu .= "<input type='hidden' name='idedit' value='$idedit'>";
	$formu .= "<label class='b'>".i("comentario",$ilink)."</label><br><textarea class='col-10' rows='15' cols='50' name='comentario' required>".quitabarra($fila[1])."</textarea>\n";
	$formu .= "<br><input class='col-10' type='submit' value = \"".i("cambiar",$ilink)."\"></form>\n";
	if ($mens) {$formu .= "<div class='mediana center txth'>$mens</div>";}
	return $formu;
}

//Editar un mensaje

function foroedit1($ilink) {
	
	if ($_POST['idedit']) {
		$temp = "";
		if ($_POST['asunto']) {
			$temp = "asunto = \"".addslashes($_POST['asunto'])."\", ";
			$iresult = $ilink->query("SELECT titulaci, asigna, categoria FROM foro WHERE id = '".$_POST['idedit']."' LIMIT 1");
			$fila = $iresult->fetch_array(MYSQLI_BOTH);
			$idpalabra = nuevacat($_POST['categoria'],$fila[0],$fila[1],$fila[2],$ilink);
		}
		$ilink->query("UPDATE foro SET $temp comentario = \"".addslashes($_POST['comentario'])."\", categoria = '$idpalabra' WHERE id = '".$_POST['idedit']."' LIMIT 1");
	}
}

?>

