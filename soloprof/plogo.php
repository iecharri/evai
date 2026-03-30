<?php

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

$asigna = $_SESSION['asigna'];
$curso = $_SESSION['curso'];
$grupo = $_SESSION['grupo'];

$filtro = "asigna = '$asigna' AND curso = '$curso' AND grupo='$grupo'";
$asicurgru = $asigna."$$".$curso."$$".$grupo;
$dir = DATA_DIR . "/logos_asigna/";

$logo_ant = logo($dir,$asicurgru);

if ($_POST['submlogdesc']) {
	$logo_ant = logodescr($_POST,$logo_ant,$borrgif,$filtro,$asicurgru,$ilink); 
}

echo "<span class='b'>Logo y descripci&oacute;n de la [Asignatura Curso Grupo]</span>";

if (is_file(DATA_DIR . "/logos_asigna/$logo_ant")) {
	$haygif = 1;
	
	$dirPriv = "logos_asigna";             // carpeta privada dentro de DATA_DIR
	$dir64   = base64_encode($dirPriv);
	$file64  = urlencode($logo_ant);

	$url = APP_URL . "/ver_media.php?dir64=$dir64&f=$file64";

	echo "<p></p><center><a href='$url' target='_blank'>
        <img title='click para ver en tama&ntilde;o original'
             src='$url'
             style='max-width:300px; height:auto; display:block; margin:0 auto;'>
      </a>";
	echo "</center>";
}


echo "<form enctype='multipart/form-data' name='formdesclogo' method='post'>";
//echo "<input type='file' name='logo' class='col-5'>";

?><div class="bloque-subida">
   	<label class="boton-subida">
   		📷 <?php echo i("foto",$ilink);?> (jpg)
   		<input type="file" name="logo" accept="image/*">
  		</label>
<?php
if ($haygif) {
	echo " <span class='rojo b'>".i("agborrar",$ilink)."</span> </span><input type='checkbox' name='borrgif'>";
}
?>  		
</div>
<?php

$sql = "SELECT texto FROM cursasigru WHERE $filtro";
$result = $ilink->query($sql);
$fila = $result->fetch_array(MYSQLI_BOTH);
if ($fila) {extract($fila);}


echo "<br>".i("descrip",$ilink).", ".str_replace("<caracteres>", "<input readonly='readonly' class='col-1' type='text' name='remLen' size=3 maxlength='3' value='3000'>", i("poner",$ilink));
echo "<br>";
echo "<textarea class='col-10' rows='3' cols='40' name='texto' wrap='physical' 
		onKeyDown=\"textCounter(this.form.texto,this.form.remLen,3000);\" onKeyUp=\"textCounter(this.form.texto,this.form.remLen,3000);\">";
echo $texto;
echo "</textarea>";

echo "<input class='col-1' type='submit' name='submlogdesc' value=' >> '>";

echo "<input type='hidden' name='op' value='1'>";

echo "</form>";

// --------------------------------------------------

function logodescr($post,$logo_ant,$borrgif,$filtro,$asicurgru,$ilink) { 
	
	extract($post);
	$nomlogo = $_FILES['logo']['name'];
	if ($borrgif == "on" AND $logo_ant) {safe_unlink(DATA_DIR . "/logos_asigna/$logo_ant");}
	if ($nomlogo) {
		if ($logo_ant) {safe_unlink(DATA_DIR . "/logos_asigna/$logo_ant");}
		$archivo = $_FILES["logo"]["tmp_name"];
		$tamanio = $_FILES["logo"]["size"];
		$type = str_replace("image/","",$_FILES["logo"]["type"]);
		$contenido = file_get_contents($archivo);
		$contenido = $ilink->real_escape_string($contenido);
	}

	$ilink->query("UPDATE cursasigru SET texto = \"$texto\" WHERE $filtro");

	$sql = "SELECT texto FROM cursasigru WHERE $filtro";
	$result = $ilink->query($sql);
	$fila = $result->fetch_array(MYSQLI_BOTH);
	if ($fila) {extract($fila);}

	if ($nomlogo) {
		move_uploaded_file($_FILES['logo']['tmp_name'], DATA_DIR . "/logos_asigna/$asicurgru".".$type");
		$logo_ant = $asicurgru.".$type";
	}
	return $logo_ant;	
	
}

// --------------------------------------------------

function logo($dir,$asicurgru) {
	$dir1 = opendir($dir);
	$n = 0;
	while ($obj = readdir($dir1)) {
		if ($obj != "." AND $obj != ".." AND substr_count($obj,$asicurgru)) {
			closedir($dir1);
			return $obj;
		}
	}
	closedir($dir1);
}

?>