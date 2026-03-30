<?php

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

require_once APP_DIR . '/dms.php';
require_once APP_DIR . "/ponerobject.php";


?>

<div class="layout-3col">

	<div class="col-multi"><article class="caja" style='padding:10px'>
		<?php columna1($f,$usuid,$dominio,$ilink,$codigo1,$codigo2,$codigo3,$codigo4);?>
	</article></div>

	<div class="col-multi"><article class="caja caja--texto" style='padding:10px'>
		<?php columna2($f,$usuid,$ilink);?>
	</article></div>
	
	<div class="col-multi"><article class="caja" style='padding:10px'>
		<?php columna3($usuid,$ilink);?>
	</article></div>

</div>


<?php
// --------------------------------------------------

function columna1($f,$usuid,$dominio,$ilink,$codigo11,$codigo12,$codigo13,$codigo14,) {
	
$t="";

extract($f);

$timestamp = time(); // UTC actual

// Consulta sin calcular fechax en SQL
$iresult = $ilink->query("SELECT fecha, ip, iconos, estado, ultasigna, ultcurso, ultgrupo, foto, video, video1 FROM usuarios WHERE id = '$usuid' LIMIT 1");
$f = $iresult->fetch_array(MYSQLI_BOTH);

// Calcular fechax en PHP (en UTC)
$f['fechax'] = $timestamp - strtotime($f['fecha']);

extract($f);

// Determinar si está en línea
$enlinea = 0;
if ($fechax < 30 && $fecha && (!$estado || $_SESSION['auto'] == 10)) {
    $enlinea = 1;
}

if (demo_enabled() && in_array((int)$usuid, DEMO_ONLINE_IDS, true)) {$enlinea = 1;}
	
// --------------------------------------------------

$iresult = $ilink->query("SELECT privacidad,foto FROM usuarios WHERE id = '".$_SESSION['usuid']."' LIMIT 1"); //mi privacidad y foto
$temp = $iresult->fetch_array(MYSQLI_BOTH);

if ($enlinea AND $usuid != $_SESSION['usuid'] AND $callto AND $callto1 AND $privacidad==0 AND $temp[0]==0) {
	if ($callto == "[ip]") {$callto = $f['ip'];}
	echo "<a href=callto:$callto onmouseover=\"window.status='".i("lanzar",$ilink)." $alumnon'; return true\"><span class='icon-skype grande'></span>
	<span class='icon-video-camera grande' title=\"".i("lanzar",$ilink)." $alumnon\"></span></a> &nbsp; ";
}

//echo "<div class='galeria' style='border:1px solid red'>";

if ($foto OR $video OR $video1) {
	
	$mipriv = $_SESSION['mipriv']; //no tengo que tener privacidad si quiero ver foto ajena
	
	if ($foto AND $temp['foto'] AND ($_SESSION['auto'] == 10 OR $id == $_SESSION['usuid'] OR $_SESSION['auto'] > $f['autorizado'] OR (!$f['privacidad'] AND !$mipriv))) {
		echo "<p></p>";
		$claseFoto = 'perfil-foto foto-'.$_SESSION['modofoto'];
		$src = APP_URL . "/avatar.php?f=" . urlencode((string)$foto). "&g=2". "&s=" . urlencode((string)$sexo);
		echo "<img src='{$src}&v=" . rand(1,1000) . "' class='{$claseFoto} center' alt='Foto de usuario'>";
	
	}
	
	echo "<h3 class='center'>".nomb1($id,$ilink)."</h3>";

	if ($video) {

    	// Carpeta relativa dentro de DATA_DIR
    	$dirRel = "fotos"; // antes apuntabas a DATA_DIR . "/fotos"
    	$dir64  = base64_encode($dirRel);

    	echo "<p></p>";

    	// URL al servidor de media privado (con soporte de Range)
    	$url = APP_URL . "/ver_media.php?dir64=" . urlencode($dir64) . "&f=" . urlencode($video);

    	// Tu helper recibe ahora la URL segura
    	$videoa = ponerVideoHtml5($url);

    	if ($videoa) {
        	$mens  = "<div id='div".$fila['id']."'>$videoa</div>";
        	$mens .= "<span class='peq'>"
               . ifecha31(gmdate("Y-m-d H:i:s", filemtime(DATA_DIR . "/$dirRel/$video")), $ilink)
               . "</span>";
         echo $mens;
    	}
	}	
	
	if ($video1) {
		
		$posicionbarra7 = strrpos($video1, "/");
		if ($posicionbarra7) {$video1 = substr(strrchr ( $video1 , "/" ),1);}
		echo poneryoutub($video1);

	}
	
}

// --------------------------------------------------

echo "<h3 class='center'>Galeria multimedia</h3>";

$dirini = DATA_DIR . "/usuarios/$usuario/";
if (!is_dir($dirini)){
	mkdir($dirini);
}

if (!is_dir($dirini."public/")){mkdir($dirini."public/");}
if (!is_dir($dirini."public/pics")){mkdir($dirini."public/pics/");}
if (!is_dir($dirini."public/video/")){mkdir($dirini."public/video/");}

$directory = DATA_DIR . "/usuarios/$usuario/public/pics"; 
$dirint = dir($directory);

while (($archivo = $dirint->read()) !== false) {
	if ($archivo != "." && $archivo != ".." && @exif_imagetype($directory."/".$archivo)) {

		// 👇 único cambio: la ruta pasa por ver_media.php
      $dirCod = base64_encode("usuarios/$usuario/public/pics");
		$url = APP_URL ."/ver_media.php?dir64=$dirCod&f=" . urlencode($archivo);
		//$url = "ver_media.php?dir=" . urlencode("usuarios/$usuario/public/pics") . "&f=" . urlencode($archivo);

		echo "<a href='$url' target='_blank'>
				<img src='$url' class='galeria-item'>
			  </a>";
		echo "<p><br></p>";
	}
}
$dirint->close();

$directory = DATA_DIR . "/usuarios/$usuario/public/video";
$dirint = dir($directory);

while (($archivo = $dirint->read()) !== false) {
    if ($archivo != "." && $archivo != "..") {
        // ⬇️ NUEVO: URL al script que sirve desde DATA_DIR
        $dirCod = base64_encode("usuarios/$usuario/public/video");
		  $url = APP_URL ."/ver_media.php?dir64=$dirCod&f=" . urlencode($archivo);
        //$url = "ver_media.php?dir=" . urlencode("usuarios/$usuario/public/video") . "&f=" . urlencode($archivo);

        // Usamos tu helper con la URL privada
        echo ponerVideoHtml5($url);

        // Tu fecha, igual que antes
        echo "<span class='peq'>".ifecha31(gmdate("Y-m-d H:i:s.", filemtime($directory . "/$archivo")),$ilink)."</span><p></p>";
    }
}
$dirint->close();

if ($otrosvideos) {
	
	$otrosvideos = explode("*", $otrosvideos);
	
	foreach($otrosvideos as $vid) {
		echo "<div class='video-responsive galeria-item'>".$vid."</div><p></p>";
	}  
}

if ($otrospics) {
	$otrospics = explode("*", $otrospics);
	foreach($otrospics as $img) {
		echo "<div class='video-responsive galeria-item'>".$img."</div>";
	}
}

if ($codigo11) {echo "<div align='center' class='galeria-item'>".stripslashes($codigo11)."</div>";}
if ($codigo12) {echo "<p></p><div align='center' class='galeria-item'>".stripslashes($codigo12)."</div>";}
if ($codigo13) {echo "<p></p><div align='center' class='galeria-item'>".stripslashes($codigo13)."</div>";}
if ($codigo14) {echo "<p></p><div align='center' class='galeria-item'>".stripslashes($codigo14)."</div>";}

if ($_GET['vot']) {$ocu = "";}

// --------------------------------------------------

if ($usuid == $_SESSION['usuid']) {echo "<hr class='sty'></hr><div class='peq u nob col-10'>".i("fichasube",$ilink)."</div><br>";}

}

// --------------------------------------------------

function columna2($f,$usuid,$ilink) {
extract($f);

echo "<h3>".i("datosper",$ilink)."</h3>";

echo "<span class='b'>".i("mail",$ilink)."</span>";
echo " <a href='mailto:$mail'>$mail</a><p></p>";

if ($curriculum) {
	echo "<span class='b'>Curriculum</span>";
	echo "<a href='$curriculum' target='_new'>Curriculum</a><p></p>";
}

if ($tfmovil1) {
	echo "<span class='b'>".i("tfmov",$ilink)."</span> ";
	echo $tfmovil."<p></p>";
}

if ($ppersonal) {
	echo "<span class='b'>".i("ppers",$ilink)."</span>";
	if(substr($ppersonal,0,4) != "http") {$ppersonal = "http://".$ppersonal;}
	echo "<a href=$ppersonal target='_new'>$ppersonal</a><p></p>";
}

if ($ocupacion) {
	echo "<span class='b'>".i("ocupaci",$ilink)."</span> ";
	echo $ocupacion."<p></p>";
}

if ($titul) {
	echo "<span class='b'>".i("titul",$ilink)."</span> ";
	echo $titul."<p></p>";
}

if ($universi) {
	echo "<span class='b'>".i("universi",$ilink)."</span> ";
	echo $universi."<p></p>";
}

echo "<hr class='sty'>";

if ($fnaci != "0000-00-00") {
	require_once APP_DIR . '/zodiaco.php';
	echo ifecha31($fnaci,$ilink)." <span class='b'>[ ".zodiaco($fnaci)." ]</span>"; 
}

if ($sexo) {
	if ($sexo) {
		echo "<br>".i($sexo,$ilink).". ";
	}
}

if ($pareja OR $amistad) {
	if ($pareja) {
		if ($pareja=='s') {echo i("conpar",$ilink);}
		if ($pareja=='n') {echo i("sinpar",$ilink);}
		echo ". ";
	}
	if ($amistad) {
		if ($amistad=='s') {echo i("amis",$ilink);}
		if ($amistad=='n') {echo i("nobusco",$ilink);}
		echo ". ";
	}
}

$result = $ilink->query("SELECT grupo, asigna, usu_id, id FROM grupos LEFT JOIN gruposusu ON gruposusu.grupo_id = grupos.id WHERE usu_id = '$usuid'");
if ($result->num_rows) {
	echo "<h3>".i("pertgr",$ilink)."</h3>";
	while ($fila = $result->fetch_array(MYSQLI_BOTH)) {
		$asigna = $fila['asigna'];

		echo "[<a href='grupo.php?grupoid=".$fila['id']."' target='_blank'>".$fila['grupo']."</a>] ";

	}
}


if ($interesante OR $wow OR $mas OR $competencias) {
	echo "<hr class='sty'>";
	if ($interesante) {echo "<div class='justify interli contiene'><h3>".i("interesante",$ilink)."</h3>".nl2br($interesante)."</div>";}
	if ($wow) {echo "<div class='justify interli interli contiene'><h3>WOW!</h3>".nl2br($wow)."</div>";}
	if ($competencias) {echo "<div class='justify interli contiene'><h3>".i("competencias",$ilink)."</h3>".nl2br($competencias)."</div>";}
	if ($mas) {echo "<div class='justify interli contiene'><h3>".i("mas",$ilink)."</h3>".nl2br($mas)."</div>";}
}

}

// --------------------------------------------------

function columna3($usuid,$ilink) {

echo "<div id='estad'>";

	$sql = "SELECT tempoestadis.tacumulado, tempoestadis.ultiacceso, tempoestadis.numvisitas, ultasigna, ultcurso, ultgrupo FROM usuarios LEFT JOIN tempoestadis ON tempoestadis.id=usuarios.id 
			WHERE usuarios.id='$usuid' AND asigna=''";
	$iresult = $ilink->query($sql);
	$f = $iresult->fetch_array(MYSQLI_BOTH);
	if($f) {extract($f);}

	echo "<h3>".i("actividad",$ilink)."</h3>";

	echo i("tenlinea",$ilink).": ".dms($tacumulado)."<br>";

	echo "<span class='peq u'>".i("ultiacces",$ilink)." <span class='mediana'>".fechaen($ultiacceso,$ilink)."</span>";

	if ($_SESSION['auto'] > 4) {
		echo " ($ip) ";
		if ($ultasigna OR $ultcurso OR $ultgrupo) {
			echo " en $ultasigna $ultcurso $ultgrupo";
		}
	}
	
	echo "</span>";

	echo "<br>".i("visirecu",$ilink).": $numvisitas <p></p>";

	require_once APP_DIR . '/perfil/fichavotar.php';

echo "</div>";

/*echo "<div class='col-10 cajabl'>";
	require_once APP_DIR . "/maps1.php";
echo "</div><p></p>";*/

echo "<h3>".i("chatvisitas",$ilink)."</h3>";
echo "<div class='contiene' style='border:1px solid #c0c0c0;width:99%;height:300px'>";
$iresult = $ilink->query("SELECT alumnon FROM usuarios WHERE id = '$usuid' LIMIT 1");
$titchat = $iresult->fetch_array(MYSQLI_BOTH);
$titchat = $titchat[0];
$_GET['enchatusuid'] = $usuid;
$enchatusuid = $usuid;
require_once APP_DIR . '/chatmini/chat.php';
echo "</div>";
echo "<div class='fl both'></div><p></p>";
	
}

// --------------------------------------------------

?>