<?php

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

extract($_SERVER);
extract($_GET);
extract($_POST);

if($op == 2){$titul=1;}

$pestx = 1;
if($_GET['pestx']) {$pestx = $_GET['pestx'];}
if($accion == "anadir") {$pestx = 2;}

$array[0] = "<a href='#'><span class='icon-folder-open'></span> ".i("otrosrecur",$ilink)." <span class='icon-arrow-right'></span></a>";
$array[1] = "<a href='?pest=9$param'>".i("otrosrecur",$ilink)."</a>";
$array[2] = "<a href='?pest=9$param&accion=anadir#1'>".i("aganadir1",$ilink)."</a>";
$array[3] = "<a href='?pest=9&titul=$titul&pestx=3'>Carpeta de Recursos</a>";
if ($accion == 'editar' AND !$_GET['fich']) {$array[4] = "<a href='#'>".i("edicion",$ilink)."</a>";$pestx = 4;}

solapah($array,$pestx+1,"navhsimple");

$solorecursos = 1;
	
if($pestx == 3) {
	require_once APP_DIR . "/soloprof/carpetaficheros.php";
	return;
}

//-------------------- EDITAR -------------------

if ($accion == 'editar1') {
	$temp = usuautc($edfecha,'');
	$iresult = $ilink->query("SELECT * FROM clasesgrab WHERE id = '$id' LIMIT 1");
	$fila = $iresult->fetch_array(MYSQLI_BOTH);
	extract($fila);
	if (($codtit AND !esprofesordetit($codtit,$curso,$ilink)) OR ($codasign AND !esmio($codasign,$curso,$grupo,$ilink))) {
		echo "<p><span class='rojo b'>".i("noprofasicurgru",$ilink)."</span></p>";
		return;
	}	
	if ($_POST['borr'] == "on") {
		$ilink->query("DELETE FROM clasesgrab WHERE id = '$id' LIMIT 1");
	}
	if ($edlink) {
		$ilink->query("UPDATE clasesgrab SET link = \"$edlink\", fecha = '$temp[0]', comentario = '".addslashes($edcomentario)."' WHERE id = '$id' LIMIT 1");
	} elseif ($edvideo) {
		$ilink->query("UPDATE clasesgrab SET video = '$edvideo', fecha = '$temp[0]', comentario = '".addslashes($edcomentario)."' WHERE id = '$id' LIMIT 1");
	}
}

//------------------------------------------------------------------------

$temp = ifecha1($edfecha);

if ($accion == 'anadir1' AND $edvideo AND $temp AND $vali) {
	$temp = usuautc($edfecha,'');
	$asigna = $_SESSION['asigna'];
	$tit = $_SESSION['tit'];
	$curso = $_SESSION['curso']; if (!$curso) {$curso = "*";}
	$grupo = $_SESSION['grupo']; if (!$grupo) {$grupo = "*";}
	if ($_GET['titul']) {
		$ilink->query("INSERT INTO clasesgrab (codtit, curso, video, fecha, comentario, autor) VALUES ('$tit', '$curso', '$edvideo', '$temp[0]', '".addslashes($edcomentario)."', '".$_SESSION['usuid']."')");
	} else {
		$ilink->query("INSERT INTO clasesgrab (codasign, curso, grupo, video, fecha, comentario, autor) VALUES ('$asigna', '$curso', '$grupo', '$edvideo', '$temp[0]', '".addslashes($edcomentario)."', '".$_SESSION['usuid']."')");
	}
}

if ($accion == 'anadir1' AND $link AND $vali1) {
	$temp = usuautc($edfecha1,'');
	$asigna = $_SESSION['asigna'];
	$tit = $_SESSION['tit'];
	$curso = $_SESSION['curso']; if (!$curso) {$curso = "*";}
	$grupo = $_SESSION['grupo']; if (!$grupo) {$grupo = "*";}
	if ($_GET['titul']) {
		$ilink->query("INSERT INTO clasesgrab (codtit, curso, link, fecha, comentario, autor) VALUES ('$tit', '$curso', '$link', '$temp', '".addslashes($edcomentario1)."', '".$_SESSION['usuid']."')");
	} else {
		$sql = "INSERT INTO clasesgrab (codasign, curso, grupo, link, fecha, comentario, autor) VALUES 
		('$asigna', '$curso', '$grupo', '$link', '$temp[0]', '".addslashes($edcomentario1)."', '".$_SESSION['usuid']."')";
		$ilink->query($sql);
	}
}
//------------------------------------------------------------------------
if ($accion == 'editar') {
	echo "<form action='".$_SERVER['PHP_SELF']."?$param&pest=9' name='form1' method='post'>";
	echo "<input type='hidden' name='accion' value='editar1'>";
	echo "<input type='hidden' name='id' value='$id'>\n";
	$sql = "SELECT fecha, video, comentario, link FROM clasesgrab WHERE id = '$id' LIMIT 1";
	$iresult = $ilink->query($sql);
	$fila = $iresult->fetch_array(MYSQLI_BOTH);
	echo i("agfecha",$ilink)." <input class='col-1 datepicker' type='text' name='edfecha' size='10' maxlength='10' value='".utcausu1($fila['fecha'])."'> \n";
	if ($fila['link']) {
		echo " Link <input class='col-2' type='text' name='edlink' size='20' maxlength='255' value='".$fila['link']."'>";	
	} else {
		if ($_GET['titul']) {
			$dire = DATA_DIR . "/cursos/$tit"."$$"."$curso/recursos";
		} else {
			$dire = DATA_DIR . "/cursos/$asicurgru/recursos";
		}
		$dire = opendir($dire);
		echo " ".i("fichero",$ilink);
		echo " <select name='edvideo'>";
		while ($elemento = readdir($dire)) {
			if (!is_dir($elemento)) {
				echo "<option value=\"$elemento\"";
				if ($elemento == $fila['video']) {echo " selected='selected'";}
				echo ">$elemento</option>";
			}
		}
		closedir($dire);
		echo "</select> ";
	}
	echo " ".i("comentario",$ilink)." <input class='col-2' type='text' name='edcomentario' size='20' maxlength='255' value=\"".htmlspecialchars($fila['comentario'],ENT_COMPAT,'UTF-8')."\"> \n";
	echo " <span class='rojo'>".i("agborrar",$ilink)."</span> <input type='checkbox' name='borr'> ";
	echo "<input class='col-1' type='submit' value=\"".i("agvalid",$ilink)."\">";
	echo "</form><p></p>";

}

if ($accion == 'anadir') {
	echo "<form action='".$_SERVER['PHP_SELF']."?pest=9$param' name='form1' method='post'>\n";
	echo "<input type='hidden' name='accion' value='anadir1'>\n";
	$fecha = formatof(gmdate("Y-m-d"),'');
	echo i("agfecha",$ilink)." <input class='col-1 datepicker' type='text' name='edfecha' size='10' maxlength='10' value='$fecha[0]'> \n";
	echo i("fichero",$ilink);
	if ($_GET['titul']) {
		$dire = DATA_DIR . "/cursos/$tit"."$$"."$curso/recursos";
	} else {
		$dire =DATA_DIR . "/cursos/$asicurgru/recursos";
	}
	$dire = opendir($dire);
	echo " <select name='edvideo'>";
	while ($elemento = readdir($dire)) {
		if (!is_dir($elemento)) {
			echo "<option value=\"$elemento\">$elemento</option>";
		}
	}
	closedir($dire);
	echo "</select> ";
	echo i("comentario",$ilink)." <input class='col-3' type='text' name='edcomentario' size='20' maxlength='255'> \n";
	echo "<input class='col-1' type='submit' name='vali' value=\"".i("agvalid",$ilink)."\">\n";
	
	echo "<p></p>".i("agfecha",$ilink)." <input class='col-1 datepicker' type='text' name='edfecha1' size='10' maxlength='10' value='$fecha[0]'> \n";
	echo " Link (<span class='rojo b'>http://...</span>) <input class='col-2' type='text' name='link' size='20' maxlength='255'>";	
	echo " ".i("comentario",$ilink)." <input class='col-2' type='text' name='edcomentario1' size='20' maxlength='255'> \n";
	echo "<input class='col-1' type='submit' name='vali1' value=\"".i("agvalid",$ilink)."\">\n";

	echo "</form><p></p>";
}

require_once APP_DIR . "/ponerobject.php";
require_once APP_DIR . "/recursos.php";

?>
