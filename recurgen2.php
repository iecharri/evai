<?php

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

if ($_SESSION['auto'] < 3) {
	exit;
}

//-------------------- EDITAR ------------------- -->

if ($_POST['accion1'] =='editar1' AND $_SESSION['auto'] > 2) {

	$iresult = $ilink->query("SELECT usuid FROM recurgen WHERE id = '$id' LIMIT 1");
	$propiet = $iresult->fetch_array(MYSQLI_BOTH);
	if (!soyadmiano($asigna,$curso,$ilink) AND $propiet[0] != $_SESSION['usuid'] AND !esprofesor($_SESSION['asigna'],$_SESSION['curso'],$_SESSION['grupo'],$ilink)) {return;}

	if ($borrar) {
		$ilink->query("DELETE FROM recurgen WHERE id = '$id' LIMIT 1");
		actu(1,'',$ilink);
		return;
	}

	if ($descrip) {$ilink->query("UPDATE recurgen SET descrip = \"$descrip\" WHERE id = \"$id\" LIMIT 1");$camb = 1;}

	$nomatach = $_FILES['fichup']['name'];
	if ($nomatach) {
		$tipo    = $_FILES["fichup"]["type"];
		$archivo = $_FILES["fichup"]["tmp_name"];
		$tamanio = $_FILES["fichup"]["size"];
		if ($tamanio < $tamanomax* 1024 * 1024) {
			$contenido = file_get_contents($archivo);
			$contenido = $ilink->real_escape_string($contenido);
			$ilink->query("UPDATE recurgen SET descrip = \"$descrip\", tamatach = \"$tamanio\", nomatach = \"$nomatach\", tipoatach = \"$tipo\", attachment = \"$contenido\" WHERE id = \"$id\"");
			if ($ilink->errno) {die ("Error");}
			$camb = 1;
		} else {
			actu(2,$tamanomax,$ilink);
		}
	}
if ($camb) {actu(1,'',$ilink);}
}

//------------------------------------------------------------------------ -->

if ($_POST['accion1'] == 'anadir1' AND $_FILES['fichup']['name']) {
	$nomatach = $_FILES['fichup']['name'];
	$tipo    = $_FILES["fichup"]["type"];
	$archivo = $_FILES["fichup"]["tmp_name"];
	$tamanio = $_FILES["fichup"]["size"];
	if ($tamanio < $tamanomax * 1024 * 1024) {
		$contenido = file_get_contents($archivo);
		$contenido = $ilink->real_escape_string($contenido);
		$asigna="";
		if ($titasi==2) {$asigna = $_SESSION['asigna'];}
		if ($titasi==1) {$titulaci = $_SESSION['tit']; $grupo="";}
		$date = gmdate("Y-m-d H:i:s");
		$ilink->query("INSERT INTO recurgen (descrip, usuid, tamatach, tipoatach, 
		nomatach, attachment, asigna, curso, grupo, titulaci, date)
		 VALUES (\"$descrip\", \"".$_SESSION['usuid']."\", \"$tamanio\",
		  \"$tipo\", \"$nomatach\", \"$contenido\", \"$asigna\", '$curso',
		   '$grupo', '$titulaci', '$date')");
		actu(1,'',$ilink);
	} else {
		actu(2,$tamanomax,$ilink);
	}
}

//----------------------------------------------------------------------------- -->

if (stristr($accion, 'editar')) {
	$sql = "SELECT * FROM recurgen WHERE id = '$id' LIMIT 1";
	$iresult = $ilink->query($sql);
	$fila = $iresult->fetch_array(MYSQLI_BOTH);
	echo "<h3>".i("edicion",$ilink)."</h3>";
	echo "<form action='recurgen.php?$param&accion=editar' name='form1' method='post' enctype='multipart/form-data'><p></p>";
	echo "<input type='hidden' name='accion1' value='editar1'>\n";
	echo "<input type='hidden' name='id' value='$id'>\n";
	echo i("cambiarfich",$ilink)." <span class='txth'>".$fila['nomatach']."</span>  (max. $tamanomax MB)<br><input class='col-3' name=\"fichup\" type=\"file\" >";
	echo "<p></p>".i("descrip",$ilink)."<br><textarea name='descrip' rows='10' cols='50' class='col-5' required>".$fila['descrip']."</textarea><p></p>";
	echo "<span class='rojo b'>".i("borrarfich",$ilink)."</span> <input type='checkbox' name='borrar'><p></p>";
	echo "<input type='submit' class='col-2' value=\"".i("agvalid",$ilink)."\">\n";
	echo "</form></div><br>\n";
}


if (stristr($accion, "anadir")) { 
	echo "<h3>".i("aganadir1",$ilink)."</h3>";
	echo "<form action='recurgen.php?$param&accion=anadir' name='form1' method='post' enctype='multipart/form-data' onsubmit=\"hide('ocultar');show('esperar')\"><p></p>";
	echo i("fichero",$ilink)." (max. $tamanomax MB)<br><input class='col-3' name='fichup' type='file' required>";
	echo "<input type='hidden' name='accion1' value='anadir1'>\n";
	echo "<p></p>".i("descrip",$ilink)."<br><textarea name='descrip' rows='10' cols='50' class='col-5' required></textarea><p></p>";
	echo "<span id='ocultar'><input type='submit' value=\"".i("agvalid",$ilink)."\" class='col-2'></span>";
	echo "<span id='esperar' style='display:none'>".$imgloader.i("esperar",$ilink)."</span>";
	echo "</form>";
}

function actu($siono,$tamanomax,$ilink) {
	
if ($siono == 1) {echo "<p></p>".i("acturealiz",$ilink);}
if ($siono == 2) {echo "<p></p><span class='rojo b'>".i("tamanofichgr",$ilink)."</span> $tamanomax MB";}
	
}
?>