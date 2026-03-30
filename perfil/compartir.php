<?php

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

?>

<script language="javascript">

function url(comp,mens) {
	comp.foto.value = "";comp.comentario.value = "";
	comp.url.value='http://';comp.resumen.value=mens;
}
function foto(comp) {
	comp.url.value = "";	comp.resumen.value = "";comp.comentario.value = "";
}
function coment(comp,mens) {
	comp.url.value = "";	comp.resumen.value = "";comp.foto.value = "";comp.comentario.value=mens;
}
</script>

<?php

function compartir($post,$usuid,$ilink) {
	if ($post) {
		extract($post);
		$_POST['url'] = striptags($url);
		$url = $_POST['url'];
		if ($_FILES['foto']['name']) {
			$mensaje = guardarfoto($_FILES,$ilink);
		} elseif ($url) {
			$mensaje = existevinculo($url,$ilink);
			if (!$mensaje) {
				$mensaje = envinculos($url,$ilink);
				if (!$mensaje) {
					copiarlinkentablas($post,$url,$ilink);
				}
			}
		} elseif ($comentario) {
			copiartextoentablas($post,$ilink);
		}
	}
	return $mensaje;
}

// --------------------------------------------------

function existevinculo($url,$ilink){
	if ($_SESSION['fabrir']) {$f1=@fopen("http://".$url,"r");} else {$f1 = 11;}
	if (!$f1) {return i("vincnoexis",$ilink);}
}

// --------------------------------------------------

function envinculos($url,$ilink){
	$sql = "SELECT usu_id FROM vinculos WHERE url = '$url'";
	$existe = $ilink->query($sql);
	if ($existe->num_rows > 0) {
		$existe = $existe->fetch_array(MYSQLI_BOTH);
		$usu = ponerusu($existe[0],1,$ilink);
		return "El v&iacute;nculo ".consmy(conhiper("http://".$url))." ha sido a&ntilde;adido por ".$usu[0].$usu[1];
	}
	
}

// --------------------------------------------------

function guardarfoto($files,$ilink){

	//Si no es un .gif o .jpg o .bmp --> return
	$tmp = explode(".", $files['foto']['name']); 
	$tmp = end($tmp); 
	if ($tmp != "gif" AND $tmp != "jpg" AND $tmp != "jpeg" AND $tmp != "png") {return "$tmp - Tipo de imagen desconocida";} 

	$dirini = DATA_DIR . '/temp';
	if (!is_dir($dirini)){safe_mkdir($dirini);}

	//Dimensiones thumb
	$max_width = 200;
	$max_height = 150;

	$tamanomax = 750; //400;
	if ($_SESSION['auto'] == 5) {$tamanomax = 750;} //400
	if ($_SESSION['auto'] < 5) {
		$tamanomax = 3;
		if ($_SESSION['tipo'] == "A") {$tamanomax = 80;}
	}

// --------------------------------------------------
	
	$tmpName = "$dirini/".$files['foto']['name'];
	$tmpName1 = "$dirini/thumb".$files['foto']['name'];
	$mime = $files['foto']['type'];
	
	move_uploaded_file($files['foto']['tmp_name'], $tmpName);

	//Si fichero grande o dimensiones grandes --> redimensionar
	list($width, $height, $tipo, $atributos) = getimagesize($tmpName);
	//Dimensiones foto normal
	$maxw = 600;
	$maxh = 400;
	if ($_FILES['foto']['size'] > $tamanomax * 1024 * 1024 OR $width > $maxw OR $height > $maxh) {
		hacermini($tmpName, $tmpName1, $maxw, $maxh);
		safe_unlink($tmpName);
		safe_rename($tmpName1, $tmpName);
	}
	
	hacermini($tmpName, $tmpName1, $max_width, $max_height);

	copiarfotoentablas($dest,$tmpName,$mime,$dirini,$ilink);

	safe_unlink($tmpName1);
	
}

// --------------------------------------------------

function copiartextoentablas($post,$ilink) {
	extract($post);
	if (!$comentario) {return;}
	$sql = "INSERT INTO social_textos (usuid,texto) VALUES 
	('".$_SESSION['usuid']."', \"$comentario\")";
	$ilink->query($sql);		
	$lastid = $ilink->insert_id;
	$temp = gmdate('Y-m-d H:i:s');
	$sql = "INSERT INTO social (fecha,fmodif,usuid,tabla, relid) VALUES
 	('$temp', '$temp','".$_SESSION['usuid']."','textos',\"$lastid\")";
	$ilink->query($sql);
}

// --------------------------------------------------

function copiarlinkentablas($post,$urlsin,$ilink) {
	extract($post);
	$fecha = gmdate("Y-m-d H:i:s");
	$area = $_SESSION['asigna'];
	if (!$area) {$area = "GEN";}
	$sql = "INSERT INTO vinculos (area, titulo, url, claves, resumen, amplia, usu_id, fechacrea1,
	fecha1, dirimagen) VALUES
	(\"$area\", \"$resumen\", \"$urlsin\", \"$claves\", \"\", \"$amplia\",
	 \"".$_SESSION['usuid']."\", \"$fecha\",\"$fecha\", \"$imagenes\")";
	$ilink->query($sql) or die ("Error");
	$lastid = $ilink->insert_id;
	$temp = gmdate('Y-m-d H:i:s');
	$sql = "INSERT INTO social (fecha, fmodif, usuid, tabla, relid) VALUES
 	('$temp', '$temp','".$_SESSION['usuid']."','vinculos',\"$lastid\")";
	$ilink->query($sql);		
}

// --------------------------------------------------

function copiarfotoentablas($dest,$tmpName,$mime,$dirini,$ilink) {
	$dest = "$dirini/thumb".$_FILES['foto']['name'];
	$imagen1 = addslashes(fread(fopen($tmpName, "r"), filesize($tmpName))); 
	$imagen2 = addslashes(fread(fopen($dest, "r"), filesize($dest))); 
	$temp = gmdate('Y-m-d H:i:s');
	$ilink->query("INSERT INTO social_fotos (tipo,fichfoto,thumb) VALUES 
	('$mime',\"$imagen1\",\"$imagen2\")");
	$lastid = $ilink->insert_id;
	$ilink->query("INSERT INTO social (fecha, fmodif,usuid,tabla,relid) VALUES 
	('$temp','$temp','".$_SESSION['usuid']."','fotos','$lastid')");
	safe_unlink($tmpName);
}

// --------------------------------------------------

function hacermini($tmpName, $tmpName1, $max_width, $max_height) {
	
	list($width, $height, $tipo, $atributos) = getimagesize($tmpName);

	$ratioh = $max_height/$height;
	$ratiow = $max_width/$width;
	$ratio = min($ratioh, $ratiow);

	// New dimensions
	$width1 = intval($ratio*$width);
	$height1 = intval($ratio*$height);

	switch($tipo) {
		case 1:  $newimg=imagecreatefromgif($tmpName);break;
   	case 2:  $newimg=imagecreatefromjpeg($tmpName);break;
   	case 3:  $newimg=imagecreatefrompng($tmpName);break;
   	//default: return "$tmp - Tipo de imagen desconocida";
	}

	$thumb=imagecreatetruecolor($width1,$height1);                  
	imagecopyresampled($thumb,$newimg,0,0,0,0,$width1,$height1,$width,$height);

	switch($tipo) {
		case 1:  imagegif($thumb,$tmpName1);break;
  	 	case 2:  imagejpeg($thumb,$tmpName1);break;
 	  	case 3:  imagepng($thumb,$tmpName1);break;
  	 	//default: return "Tipo de imagen desconocida"; 
	}

}

// --------------------------------------------------

function striptags($url) {
	$url = str_ireplace("http://","",$url);
	$url = str_ireplace("https://","",$url);
	$url = str_ireplace("ftp://","",$url);
	return $url;
}

// --------------------------------------------------

?>