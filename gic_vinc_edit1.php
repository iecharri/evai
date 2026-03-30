<?php

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

$uid = $_SESSION['usuid'];
extract($_POST);

/*************** MODIFICACI&Oacute;N DEL V&Iacute;NCULO ***********************************************/

if (strlen(ltrim($tituloedit)) == 0 OR strlen(ltrim($clavesedit)) == 0 OR strlen(ltrim($resumenedit)) == 0) {
	$mensaje = "<p></p><span class='rojo'>".str_replace("(nombre)", $quienn, i("vinceditno",$ilink))."</span>";
	return;
}

$result = $ilink->query("SELECT vinculos.id, vinculos.url, usu_id, vinculos.idioma, vinculos.url_local FROM vinculos LEFT JOIN usuarios ON usuarios.id = vinculos.usu_id WHERE vinculos.id = '$id' LIMIT 1");

$fila = $result->fetch_array(MYSQLI_BOTH);

if ($fila['usu_id'] != $_SESSION['usuid'] AND $_SESSION['auto'] < 10) {return;}

if ($borrarvinc == "on") {

	$url_local = substr($fila['url_local'],0,1);
	if ($url_local) {
		$dirini = DATA_DIR ."/vinculos/";
		if ($url_local == 1) {
			//borrar el fichero
			$url_local = substr($fila['url_local'],2);
			safe_unlink("$dirini$url_local");
		} else {//
			//borrar el directorio
			$url_local = substr($fila['url_local'],2);
			borrardir("$dirini$url_local/");
		}
	}
	$result = $ilink->query("DELETE FROM vinculos WHERE id = '$id' LIMIT 1");
	$result = $ilink->query("DELETE FROM votos WHERE vinculo_id = '$id'");
	$result = $ilink->query("DELETE FROM vinchs2 WHERE id = '$id'");
	$result = $ilink->query("DELETE FROM social WHERE tabla = 'vinculos' AND relid = '$id'");
	if ($fila['usu_id'] == $uid) {
		$_SESSION['numvinc'] = $_SESSION['numvinc'] - 1;
		$_SESSION['numvinc1'] = $_SESSION['numvinc1'] - 1;
	}
	$noexiste = 1;

} else {

	$fecha = gmdate("Y-m-d H:i:s");
	$x = str_replace("http://", "", $urledit);
	$urledit1 = str_replace("https://", "", $x);
	if ($_SESSION['fabrir']) {
		$f1=@fopen("http://".$urledit1,"r");
	} else {
		$f1 = 11;
	}
	if ($f1) {$roto = 0;} else {$roto = 1;}
	$sologrupo = 1; if ($_POST['visi'] == "on" OR !$_POST['grupos']) {$sologrupo = 0;}
	$_POST = array_map('ponbarra', $_POST);
	extract($_POST);
	if (!$selecc) {$fotovinc = ", dirimagen=''";} else {$fotovinc = ", dirimagen='$imagenes'";}
	$sqlupd = "UPDATE vinculos SET area = \"$area\", titulo = \"$tituloedit\", url = \"$urledit1\", claves = \"$clavesedit\", 
	resumen = \"$resumenedit\", amplia = \"$ampliaedit\", fecha1 = \"$fecha\", idioma = \"$idioma\", roto = \"$roto\", sologrupotrab = \"$sologrupo\"
	, engrupotrab = \"$grupos\" $fotovinc WHERE id = \"$id\" LIMIT 1"; 
	$result = $ilink->query($sqlupd);
	$ilink->query("UPDATE social SET engrupotrab = '$grupos', sologrupotrab  = '$sologrupo' WHERE tabla = 'vinculos' AND relid = '$id'");
	$_POST = array_map('quitabarra', $_POST);
	extract($_POST);

	if (!$result) {
		$result = $ilink->query("SELECT vinculos.id, usuarios.alumnon, usuarios.alumnoa, usu_id FROM vinculos LEFT JOIN usuarios ON usuarios.id = vinculos.usu_id WHERE vinculos.url = '$urledit'");
		$fila1 = $result->fetch_array(MYSQLI_BOTH);
		$mensaje = "<span class='rojo'>";
		$usua = ponerusu($fila1['usu_id'],1,$ilink);
		$nombapel = $usua[0].$usua[1];
		$vinculo = "<a href='links.php?id=".$fila1['id']."'>v&iacute;nculo</a>";
		$mensaje .= str_replace("(porusuario)", "<br>".$nombapel, 
		str_replace ("(vinculo)", $vinculo, 
		str_replace( "(apellidos)", "", 
		str_replace("(nombre)", minom(1,0,$ilink), i("vincrep",$ilink)))))."</span><p></p>";
	}

	if ($roto != 0) {
		$mensaje = "<p><br><span class='rojo'>$urledit <span class='b'><br>".i("vincnoexis",$ilink)."</span></span></p>";
		$noexiste = 2;
	}

}

function ponbarra($x) {
	return addslashes($x);
}

function borrardir($dir){
    if ($handle = opendir($dir)) {
    while (false !== ($file = readdir($handle))) {
        if ($file != "." && $file != "..") {
            if(is_dir($dir.$file)){
               borrardir($dir.$file."/");
             } else {
             	safe_unlink($dir.$file);
            }
        }
	}
    closedir($handle);
	}
	safe_rmdir($dir);
}

?>