<?php

// Copyright (c) 2000-2026 Inmaculada Echarri San Adrián
// Copyright (c) 2000-2026 Antonio Grandío Botella
// This file is part of EVAI.
// Licensed under the MIT License.
// See LICENSE.txt for details.

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

function fichaborrar($uid,$definitiva,$ilink) {

if ($_SESSION['auto'] < 10 AND $uid != $_SESSION['usuid']) {exit;}

$ilink->query("UPDATE usuarios SET fechabaja='".gmdate("Y-m-d H:i:s")."', foto='', video='' WHERE id = '$uid' LIMIT 1");

if(!$definitiva) {return;}

$sql = "SELECT usuario, foto, video, alumnon, alumnoa, mail FROM usuarios WHERE id = '$uid' LIMIT 1";
$result = $ilink->query($sql);
$fila = $result->fetch_array(MYSQLI_BOTH);
$usuario = $fila[0];
$foto = $fila[1];
$video = $fila[2];
$mensaje = "<span class='rojo b'>[El usuario $fila[0]: ".trim($fila[3])." ".trim($fila[4])." $fila[5] ha sido borrado.]</span><br>";
$ilink->query("UPDATE vinculos SET usu_id = 0 WHERE usu_id = '$uid'");
$ilink->query("UPDATE vinculos SET idcat = 0 WHERE idcat = '$uid'");
$ilink->query("DELETE FROM votos WHERE usu_id = '$uid'");
$ilink->query("UPDATE vinchs2 SET usu_id = 0 WHERE usu_id = '$uid'");
$ilink->query("DELETE FROM usuarios where id = '$uid' LIMIT 1");
$ilink->query("UPDATE foro SET usu_id = 0 WHERE usu_id = '$uid'");
$ilink->query("DELETE FROM gruposusu WHERE usu_id = '$uid'");
$ilink->query("UPDATE forogrupos set usu_id = 0 WHERE usu_id = '$uid'");
$ilink->query("DELETE FROM usuasi WHERE id = '$uid'");
$ilink->query("DELETE FROM alumasiano WHERE id = '$uid'");
$ilink->query("DELETE FROM asignatprof WHERE usuid = '$uid'");
$ilink->query("UPDATE enviospor SET mensaje2 = CONCAT(\"".$mensaje."\", mensaje2) WHERE deid = '$uid' OR paraid = '$uid'");
$ilink->query("DELETE FROM fichavaloracion WHERE usuid = '$uid'");
$ilink->query("DELETE FROM fichaactualiz WHERE usuid = '$uid'");
$ilink->query("UPDATE fichavaloracion SET deusuid = 0 WHERE deusuid = '$uid'");
$ilink->query("UPDATE enviospor set deid = 0 WHERE deid = '$uid'");
$ilink->query("UPDATE enviospor set paraid = 0 WHERE paraid = '$uid'");
$ilink->query("DELETE FROM titcuradmi WHERE usuid = '$uid'");
$ilink->query("DELETE FROM fichaactualiz WHERE usuid = '$uid'");

if (is_file(DATA_DIR . "/fotos/$foto")) {safe_unlink(DATA_DIR . "/fotos/$foto");}
if (is_file(DATA_DIR . "/fotos/1$foto")) {safe_unlink(DATA_DIR . "/fotos/1$foto");}
if (is_file(DATA_DIR . "/fotos/2$foto")) {safe_unlink(DATA_DIR . "/fotos/2$foto");}
if (is_file(DATA_DIR . "/fotos/$video")) {safe_unlink(DATA_DIR . "/fotos/$video");}

$ilink->query("DELETE FROM message WHERE usuid='$uid' OR parausuid='$uid'");
$ilink->query("DELETE FROM message_usus WHERE usuid='$uid' OR parausuid='$uid'");
$ilink->query("DELETE FROM message_histo WHERE usuid='$uid' OR parausuid='$uid'");
if ($usuario AND substr_count($usuario,"..") < 1) {
	if (is_dir(DATA_DIR . "/usuarios/".$usuario)) {deldir(DATA_DIR . "/usuarios/".$usuario);}
}

}

function deldir($dir){
	$current_dir = opendir($dir);
	while($entryname = readdir($current_dir)){
		if(is_dir("$dir/$entryname") and ($entryname != "." and $entryname!="..")){
			 deldir("${dir}/${entryname}");
			}elseif($entryname != "." and $entryname!=".."){
			safe_unlink("${dir}/${entryname}");
		}
	}
	closedir($current_dir);
	safe_rmdir(${dir});
}

?>