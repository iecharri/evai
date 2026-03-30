<?php

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

if ($titasi==1) {
	$sql = "SELECT DISTINCT id, fecha AS fechax, video, comentario, autor, curso, grupo, link FROM clasesgrab WHERE codtit = '".$_SESSION['tit']."' AND fecha > '0000-00-00' ORDER BY fecha DESC";
} else {
	$sql = "SELECT DISTINCT id, fecha AS fechax, video, comentario, autor, curso, grupo, link FROM clasesgrab WHERE codasign = '$asigna' AND fecha > '0000-00-00' ORDER BY fecha DESC";
}
$result = $ilink->query($sql);

if($solover) {
	$nohay="";
	if(!$result->num_rows) {$nohay=1;return;} //paso aqui el return
	//return;
}

$n = "";
while ($fila = $result->fetch_array(MYSQLI_BOTH)) {
	if ($titasi==1) {
		if ($fila['curso'] != $curso AND $fila['curso'] != "*") {continue;} 
	} else {
		if (($fila['curso'] != "*" AND $fila['curso'] != $curso) OR ($fila['grupo'] != "*" AND $fila['grupo'] != $grupo)) {continue;} 
	}
	$n = 1;
	if ($fila['link']) {
		$ext = strrchr ( $fila['link'] , "." );
	} else {
		$mms="";
		$ext = strrchr ( $fila['video'] , "." );
	}
	$imag = imag1($ext,$ilink);
	$mens = "<br><span class='nob peq'>".ifecha31($fila['fechax'],$ilink)."</span> "; //$mens .=
	if ($_SESSION['auto'] > 4 AND $pest == 9) {
		$mens .= "[<a href='".$_SERVER['PHP_SELF']."?$param&pest=9&accion=editar&id=".$fila['id']."#1'>".i("editar1",$ilink)."</a>] ";
	}
	$mens .= "<br>";
	if ($fila['link']) {
		$mens .= "<a href='".$fila['link']."' target='_new'>";
		$ext = strrchr($fila['link'],'.');
		if(stristr($fila['link'], 'youtube.com') OR stristr($fila['link'], 'youtu.be')){
			$ext = "youtube";
		} elseif ("*".stristr($fila['link'], 'http://')) {
			$ext = ".html";
		}
		$mens .= imag1($ext,$ilink);
		$mens .= $fila['comentario']."</a>";
	} else {
		$temp = $titcur;
		if ($asicurgru) {$temp = $asicurgru;}
		$dirini = DATA_DIR . "/cursos/$temp/recursos/";
		$mens .= "<a href='". APP_URL ."/file.php?n=".base64_encode($dirini)."&fich=".$fila['video']."' target='_new'>";
		$mens .= $imag." ".$fila['comentario']."</a>";
		$ext = explode(".",$fila['video']);
		if (esvid($ext[1])) {
			$x = 3;if($script == "home") {$x = 10;}
			$dir =  $asicurgru ; // relativo a DATA_DIR
			$fich = $fila['video'];                      // nombre del vídeo
			$ruta = APP_URL . "/file.php?ag=1&dir=" . rawurlencode($dir) ."&fich=" . rawurlencode($fich);
			$video = ponerVideoHtml5($ruta);			
			if($video) {
				$mens .= "<br>(<a class='txth b' onclick=\"amplred('div".$fila['id']."')\">mostrar/ocultar el v&iacute;deo</a>)";
				$mens .= "<div id='div".$fila['id']."' class='col-$x' style='display:none'>";
				$mens .= $video;
				$mens .= "</div>";
			}
		}
	}
	
	$usu = ponerusu($fila['autor'],1,$ilink);
	
	?><div class="fila-usuario">
 		<div class="foto"><?php
 			echo $usu[0];?>	
 		</div>
		<div class="datos"><?php 	
			echo $usu[1].$mens;?>
		</div>
	</div><?php
	
	echo "<p><br></p>";
	
	$num++;
	if($solo AND $num >= $solo) {break;}
}

if (!$n) {

	if($noponer) {return;}

	echo "<br> &nbsp; &nbsp; ";

	echo i("nohayfich",$ilink);

}

?>