<?php

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

if($_SESSION['auto'] < 5) {return;}

echo i("anotacitxt",$ilink);
extract($_POST);

?>

<a href='?op=23' target='_blank'><span class='icon-link'></span></a>

<p></p>

<?php

$anaed = "anadir1";

if($edit1) { //$envi AND $texto AND 
	editar($edit,$ilink);
} elseif($envi AND $texto) {
	anadir($usuid,$ilink);
	$texto="";
}

if($edit AND !$edit1) {
	$sql = "SELECT * FROM fichaanotaci WHERE n='$edit'";
	$result = $ilink->query($sql);
	$fila = $result->fetch_array(MYSQLI_BOTH);
	extract($fila);
	$anaed = "cambiar";
	if($nombre) {$txt = "Cambiar o borrar adjunto <span class='azul'>".$nombre."</span><br>";}
}
	
?>

<form method='post' enctype="multipart/form-data">

<?php echo $txt;?>



Opcional <input name="fich" type="file" class='col-4' value="<?php echo $nombre;?>">

<?php if($fich) {echo " Borrar <input type='checkbox' name='fichdel'>";}?>

<div class='both'></div>

<textarea class='col-5' name='texto' rows='10'><?php echo $texto;?></textarea>

<input type='submit' class='col-5' name='envi' value="<?php echo i($anaed,$ilink)?>">
<?php if($edit) {echo "<input type='hidden' name='edit1' value='$edit'>";}?>

</form>

<?php

// --------------------------------------------------

echo "<ul>";
$sql = "SELECT * FROM fichaanotaci WHERE deid = '".$_SESSION['usuid']."' AND sobreid = '$usuid' ORDER BY date DESC";
$result = $ilink->query($sql);
while ($fila = $result->fetch_array(MYSQLI_BOTH)) {
	echo "<li class='colu2'><a href='?usuid=$usuid&op=$op&edit=$fila[0]'><span class='icon-pencil2'></span></a> ";
	echo "<span class='peq verdecalific'>".ifecha31($fila['date'],$ilink)."</span> ";
	if($fila['fich']) {
		$ext = exten($fila['nombre']);
		echo "<a href='perfil/fichanotaci.php?id=$fila[0]' target='_blank'>";
		echo imag1(".".$ext,$ilink);
		echo "</a> ";
	}
	echo $fila['texto'];
	echo "</li>";
}
echo "</ul>";

// --------------------------------------------------

function editar($sobreid,$ilink) {

	extract($_POST);
	$limite_kb = 10000;
	if ($_FILES["fich"]["name"] AND (!exten($_FILES["fich"]["name"]) OR $_FILES['fich']['size'] > $limite_kb * 1024)){
		echo "<span class='rojo b'>El tipo de fichero ".$_FILES["fich"]["name"]." no está permitido o el tamaño es mayor de 10MB</span><p></p>";
		return;
	}
	if($fichdel) {
		$temp = " ,fich = \"\" ,nombre = \"\", type = ''";
	}
	if($_FILES['fich']['type']) {
		$tipo    = $_FILES["fich"]["type"];
		$nombre = $_FILES["fich"]["name"];
		$archivo = $_FILES["fich"]["tmp_name"];
		$tamanio = $_FILES["fich"]["size"];
		$contenido = file_get_contents($archivo);
		$contenido = $ilink->real_escape_string($contenido);
		$temp = " ,fich = \"$contenido\" ,nombre = \"$nombre\", type = '$tipo'";
	}
	if($texto) {	
		$sql = "UPDATE fichaanotaci SET texto = \"$texto\" " . $temp . " WHERE n = '$edit1'";
	} else {
		$sql = "DELETE FROM fichaanotaci WHERE n = '$edit1'";
	}
	$result = $ilink->query($sql);

}

// --------------------------------------------------

function anadir($sobreid,$ilink) {

	$limite_kb = 10000;
	if ($_FILES["fich"]["name"] AND (!exten($_FILES["fich"]["name"]) OR $_FILES['fich']['size'] > $limite_kb * 1024)){
		echo "<span class='rojo b'>El tipo de fichero ".$_FILES["fich"]["name"]." no está permitido o el tamaño es mayor de 10MB</span><p></p>";
		return;
	}
	if($_FILES['fich']['type']) {
		$tipo    = $_FILES["fich"]["type"];
		$nombre = $_FILES["fich"]["name"];
		$archivo = $_FILES["fich"]["tmp_name"];
		$tamanio = $_FILES["fich"]["size"];
		$contenido = file_get_contents($archivo);
		$contenido = $ilink->real_escape_string($contenido);
	}
	
	$sql = "INSERT INTO fichaanotaci (deid,sobreid,texto,fich,nombre,type) VALUES ('".$_SESSION['usuid']."','$sobreid',\"".$_POST['texto']."\",\"$contenido\",\"$nombre\",'$tipo')";
	$result = $ilink->query($sql);


}

function exten($fich) {
	$ext = explode(".",$fich);
	$len = sizeof($ext);
	$ext = $ext[$len-1];
	if ($ext == "sh" OR $ext == "php" OR $ext == "phps" OR $ext == "php2" OR $ext == "php3" OR $ext == "php4" OR $ext == "phtml" OR $ext == "asp" OR $ext == "asa"){return 0;} 
	return $ext;
}

?>