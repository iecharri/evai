<?php

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

if ($_SESSION['auto'] < 5) {$usuid = $_SESSION['usuid'];}

if ($_POST['desborrar'] AND $_SESSION['auto'] == 10) {
	$ilink->query("UPDATE usuarios SET fechabaja = '0000-00-00 00:00:00' WHERE id = '$usuid' LIMIT 1");
	return;
}

if ($_POST['borrar'] AND ($_SESSION['auto'] == 10 OR $usuid = $_SESSION['usuid'])) {
	$ilink->query("UPDATE usuarios SET fechabaja='".gmdate("Y-m-d H:i:s")."' WHERE id = '$usuid' LIMIT 1");
	return;
}

if($_POST['norecordardatos']) {
	$ilink->query("UPDATE usuarios SET recordar='' WHERE id = '$usuid' LIMIT 1");
	return;	
}

if($_POST['profes']) {
	$profpanel = $_POST['profpanel'];
	if(!$profpanel) {$profpanel=1;} else {$profpanel=0;}
	$ilink->query("UPDATE usuarios SET mensaje=\"$mensajep\", profpanel=\"$profpanel\" WHERE id = '$usuid' LIMIT 1");
	$res1 = $ilink->query("SELECT usuario FROM usuarios WHERE id = '$usuid' LIMIT 1");
	$fi1 = $res1->fetch_array(MYSQLI_BOTH);

	$cambfoto = subefoto($fi1[0]);
	if($cambfoto) {
		$foto = $fi1[0].".jpg";
		$sql = "UPDATE usuarios SET  foto = \"$foto\" WHERE id = '$usuid' LIMIT 1";
		$ilink->query($sql);
		if ($ilink->errno) {die ("Error");}
		$cambio .= "foto ";
	}
	return;
}

// -------------------------------------------------- Comprobar mail y dni

//if(!preg_match('/^[^0-9][a-zA-Z0-9_-]+([.][a-zA-Z0-9_-]+)*[@][a-zA-Z0-9_-]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/', $_POST['mail'])){
if(!preg_match("/^(([A-Za-z0-9]+_+)|([A-Za-z0-9]+\-+)|([A-Za-z0-9]+\.+)|([A-Za-z0-9]+\++))*[A-Za-z0-9]+@((\w+\-+)|(\w+\.))*\w{1,63}\.[a-zA-Z]{2,6}$/", $_POST['mail'])){
	$mensaje1 = "<br><span class='rojo b'>".i("mailno",$ilink)."</span><br>\n";
	return;
}

$result = $ilink->query("SELECT mail FROM usuarios WHERE mail = '".$_POST['mail']."' AND id != '$usuid' LIMIT 1");
if ($result->num_rows > 0) {
	$mensaje1 = "<br><span class='rojo b'>".i("losenti",$ilink)."</span><br>\n";
	return;
}

if (!$_POST['dni']) {
	// Si se quiere obligar a poner DNI, descomentar lo siguiente y quitar en el siguiente IF :  AND $_POST['dni']
	//$mensaje2 = "<br><span class='rojo b'>El DNI es obligatorio, no se han efectuado cambios en la ficha</span><br>\n";
	//return;
}

$result = $ilink->query("SELECT dni FROM usuarios WHERE dni = '".$_POST['dni']."' AND id != '$usuid' LIMIT 1");
if ($result->num_rows > 0 AND $_POST['dni']) {
	$mensaje2 = "<br><span class='rojo b'>El DNI ya existe en la base de datos de usuarios, no se han efectuado cambios en la ficha</span><br>\n";
	return;
}

// --------------------------------------------------

$_POST = array_map('ponbarra', $_POST);
extract($_POST);

$result = $ilink->query("SELECT foto, video, usuario, mas, interesante, wow, autorizado, ppersonal, competencias, video1 FROM usuarios WHERE id = '$usuid' LIMIT 1");
$fila = $result->fetch_array(MYSQLI_BOTH);
$foto = $fila['foto'];$video = $fila['video']; $usuario = $fila['usuario'];

if ($mas AND $mas != $fila['mas']) {$cambio = "mas ";}
if ($interes AND $interes != $fila['interesante']) {$cambio .= "interesante ";}
if ($competencias AND $competencias != $fila['competencias']) {$cambio .= "competencias ";}
if ($wow AND $wow != $fila['wow']) {$cambio .= "wow ";}
if ($ppersonal AND $ppersonal != $fila['ppersonal']) {$cambio .= "ppers ";}
if ($video1 AND $video1 != $fila['video1']) {$cambio .= "YouTube ";}

	$cambfoto = subefoto($usuario);
	if($cambfoto) {
		$foto = $usuario.".jpg";
		$sql = "UPDATE usuarios SET  foto = \"$foto\" WHERE id = '$usuid' LIMIT 1";
		$ilink->query($sql);
		if ($ilink->errno) {die ("Error");}	
		$cambio .= "foto ";
	}

if (strpos("*".$_FILES['curri']['type'], 'doc') > 0 OR strpos("*".$_FILES['curri']['type'], 'word') > 0 OR strpos("*".$_FILES['curri']['type'], 'pdf') > 0) {
	if ($_FILES['curri']['size'] < $tamanomax* 1024 * 1024) {
		$extension = explode(".",$_FILES['curri']['name']);
		$num = count($extension)-1;
		$curri = "curr".gmdate('YmdHis')."UTC.".$extension[$num];
		$exito = safe_move_uploaded_file($_FILES['curri']['tmp_name'], DATA_DIR . '/usuarios/$usuario/.$curri');
		$curriculum = DATA_DIR . "/usuarios/$usuario/$curri";
		$subi = tamano($_FILES['curri']['size']);
		require_once APP_DIR . '/registrar.php';
		registrar($exito,"subirc", '', $_FILES['curri']['name'], DATA_DIR . "/usuarios/$usuario/",$curri." (".$subi.")",$ilink);
	} else {
		$mensajecurr = i("tamanofichgr",$ilink). " $tamanomax MB.";
	}
}

if ($curriculum AND $curriculum != $fila['curriculum']) {$cambio .= "curriculum ";}

if (!empty($_FILES['regisvideo']['tmp_name']) && str_starts_with($_FILES['regisvideo']['type'], 'video/')) 

//if (strpos("*".$_FILES['regisvideo']['type'], 'video') > 0)
{
	
// 1. Comprobamos MIME real (no fiarse del navegador)
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mime  = finfo_file($finfo, $_FILES['regisvideo']['tmp_name']);
    finfo_close($finfo);

    // 2. Extensiones y MIME permitidos
    $okExt  = ['mp4','webm','ogg','ogv'];
    $okMime = ['video/mp4','video/webm','video/ogg','video/ogv'];

    // 3. Validar
    $extension = explode('.', $_FILES['regisvideo']['name']);
    $num = count($extension) - 1;
    $ext = strtolower($extension[$num]);

    if (!in_array($ext, $okExt, true) || !in_array($mime, $okMime, true)) {
        echo "<p style='color:red'>❌ Tipo de vídeo no permitido ($mime).</p>";
    } else {
        // 4. Nombre final y guardado
        $video = $usuario . '.' . $ext;
        $destino = DATA_DIR . '/fotos/' . $video;

        if (safe_move_uploaded_file($_FILES['regisvideo']['tmp_name'], $destino)) {
            echo "<p>✅ Vídeo subido correctamente.</p>";
        } else {
            echo "<p style='color:red'>❌ Error al mover el archivo.</p>";
        }
    }	
	
	$cambio .= "video";	

}

$fnaci = ifecha1($fnaci);

if ($nofoto) {

	$dir = DATA_DIR . '/fotos/';
	$file = $dir.$foto;
	safe_unlink($file);
	$file = $dir."1".$foto;
	safe_unlink($file);
	$file = $dir."2".$foto;
	safe_unlink($file);
	$foto = "";

}

if ($novideo) {

	$dir = DATA_DIR . '/fotos/';
	$file = $dir.$video;
	safe_unlink($file);
	$video = "";

}

if($tfmovil1){$tfmovil1=1;}else{$tfmovil1=0;}
if($callto1){$callto1=1;}else{$callto1=0;}

$sql = "UPDATE usuarios SET $sipuedocambpass alumnon = \"$alumnon\", alumnoa = \"$alumnoa\", ocupacion = \"$ocupaci\", ppersonal = \"$ppersonal\", mail = \"$mail\", titul = \"$titul\", universi = \"$universi\", pacadem=\"$pacadem\", mensaje=\"$mensajep\", mas = \"".quitabarra(nocomid($mas))."\", sexo = \"$sexo\", fnaci = \"$fnaci\", pareja = \"$pareja\", amistad = \"$amistad\", interesante = \"".quitabarra(nocomid($interes))."\", wow = \"".quitabarra(nocomid($wow))."\", foto = \"$foto\", video = \"$video\", video1 = \"$video1\", privacidad = \"$privacidad\", dni = \"$dni\", pais = \"$pais\", provincia = \"$provincia\", direccion = \"".quitabarra(nocomid($direccion))."\", codpos = \"$codpos\", localidad = \"$localidad\", tfmovil = \"$tfmovil\", tfmovil1 = \"$tfmovil1\", callto = \"$callto\", callto1 = \"$callto1\", estado = \"$estado\", competencias = \"".quitabarra(nocomid($competencias))."\"";
$sql .= ", codigo1 = \"$codigo1\", codigo2 = \"$codigo2\", codigo3 = \"$codigo3\", codigo4 = \"$codigo4\"";
$sql .= ", curriculum = \"$curriculum\", otrospics = \"$otrospics\", otrosvideos= \"$otrosvideos\"";

$sql .= " WHERE id = '$usuid' LIMIT 1";

$ilink->query($sql);
if ($ilink->errno) {die ("Error");}

if (trim($cambio) AND $fila['autorizado'] > 3) {
	$iresult = $ilink->query("SELECT usuid FROM fichaactualiz WHERE usuid = '$usuid'");
	if ($iresult->num_rows) {
		$ilink->query("UPDATE fichaactualiz SET cambio = '$cambio', fecha = '".gmdate("Y-m-d H:i:s")."' WHERE usuid = '$usuid'");
	} else {
		$ilink->query("INSERT INTO fichaactualiz (usuid, cambio, fecha) VALUES ('$usuid', '$cambio', '".gmdate("Y-m-d H:i:s")."')");
	}
}

$_POST = array_map('quitabarra', $_POST);
extract($_POST);

if ($usuid == $_SESSION['usuid']) {
	$iresult = $ilink->query("SELECT * FROM usuarios WHERE id = '$usuid' LIMIT 1");
	$fila = $iresult->fetch_array(MYSQLI_BOTH);
}

// --------------------------------------------------

function quitabarra($x) {return stripslashes($x);}
function ponbarra($x) {return addslashes($x);}
function nocomid($x) {return str_replace("\"","''",$x);}

// --------------------------------------------------

function subefoto($usuario) {	

	
if (strpos("*".$_FILES['foto']['type'], 'jpg') > 0 OR strpos("*".$_FILES['foto']['type'], 'jpeg') > 0) {
	$foto = $usuario.".jpg";
	if (is_file(DATA_DIR . '/fotos/1$foto')) {safe_unlink(DATA_DIR . '/fotos/1$foto');}
	if (is_file(DATA_DIR . '/fotos/2$foto')) {safe_unlink(DATA_DIR . '/fotos/2$foto');}
	
	$image_r=imagecreatefromjpeg($_FILES['foto']['tmp_name']);
	$exif = exif_read_data($_FILES['foto']['tmp_name']);

	if(!empty($exif['Orientation'])) {
   	switch($exif['Orientation']) {
        case 8:
            $rotada_r = imagerotate($image_r,90,0);
            break;
        case 3:
            $rotada_r = imagerotate($image_r,180,0);
            break;
        case 6:
            $rotada_r = imagerotate($image_r,-90,0);
            break;
    	}
    	if($rotada_r) {
    		imagejpeg($rotada_r,$_FILES['foto']['tmp_name']);
   	}
	}		

	safe_move_uploaded_file($_FILES['foto']['tmp_name'], DATA_DIR . '/fotos/'.$foto);
	$cambio = "foto ";
}	

return $cambio;

}

?>