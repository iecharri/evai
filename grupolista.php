<?php

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

echo "<h3>$eslogan</h3>";

if ($numvinc) { echo i("numvinc",$ilink).": <span class='b'>$numvinc</span><p></p>";}

$sqla = "SELECT DISTINCT(usu_id), usuarios.alumnon, usuarios.alumnoa, usuarios.privacidad, usuarios.foto, usuarios.mas";
if ($asigna) {$sqla .= ", usuasi.numvinc";} else {$sqla .= ", usuarios.numvinc";}
$sqla .= " FROM gruposusu LEFT JOIN usuarios ON gruposusu.usu_id = usuarios.id ";
if ($asigna) {$sqla .= "LEFT JOIN usuasi ON usuasi.id = gruposusu.usu_id";}
$sqla .= " WHERE gruposusu.grupo_id = '$grupoid'";
if ($asigna) {$sqla .= " AND asigna = '$asigna'";}

$resultalu = $ilink->query($sqla);

thumb_alu($resultalu,$ilink);

// --------------------------------------------------

$sql = "SELECT * FROM grupos WHERE id = '$grupoid' LIMIT 1";
$result = $ilink->query($sql);
$fila = $result->fetch_array(MYSQLI_BOTH);

echo "<p></p><div class='col-3 fl pr2em ce'>";
	columna1($fila,$grupoid,$ilink,$esmigrupo);
echo "</div>";

echo "<div class='col-3 fl pr2em'>";
	columna2($fila, $ilink);
echo "</div>";
echo "<div class='col-3 fl'>";
	columna3($codigo1,$codigo2,$codigo3,$codigo4,$grupoid,$ilink,$esmigrupo);
echo "</div>";

// --------------------------------------------------

function columna1($f,$grupoid,$ilink,$esmigrupo) {

if ($esmigrupo) {
	echo "<div class='colu'>".i("gruposube",$ilink)."</div><br>";	
}

extract($f);
require_once APP_DIR . "/ponerobject.php";
	
//Mostrar ficheros en carpeta grupo/public/pics y video

$directory = "/grupos/$grupo/public/pics";
$dirint = dir(DATA_DIR . $directory);

while (($archivo = $dirint->read()) !== false) {
    $ruta0 = DATA_DIR . $directory . "/" . $archivo;

    if (is_file($ruta0) && @exif_imagetype($ruta0)) {
    	   // n = base64 de la ruta completa dentro de DATA_DIR
        $n = base64_encode(DATA_DIR . "/grupos/$grupo/public/pics");
        $url = APP_URL . "/file.php?n=" . $n .  "&fich=" . $archivo;
        // Nueva URL pública segura:
        echo "<a href='$url' target='_blank'>
                <img src='$url' class='borderfot max100'>
              </a>";
        echo "&nbsp;<p></p>";
    }
}

echo "<div class='galeria'>";

$directory = "/grupos/$grupo/public/video";
$dirint = dir(DATA_DIR . $directory);

while (($archivo = $dirint->read()) !== false) {
    if ($archivo === '.' || $archivo === '..') continue;

    $rutaFisica = DATA_DIR . $directory . '/' . $archivo;
    if (!is_file($rutaFisica)) continue;

    // URL pública segura a través de file.php (usa n = base64 de la ruta en DATA_DIR)
    $n   = urlencode(base64_encode(DATA_DIR . $directory));
    $url = APP_URL . "/file.php?n=" . $n . "&fich=" . urlencode($archivo);

    echo ponerVideoHtml5($url, 260);
}

echo "</div>";

$dirint->close();

if ($video1) {
	
	$video1 = explode("*", $video1);
	
	foreach($video1 as $vid) {
		$vid = preg_replace('/width="\d*"/', 'width="300"', $vid);
		$vid = preg_replace('/height="\d*"/', '', $vid);
		echo "<div style='width:300px'>$vid</div>";
	}
}

if ($otros) {
	$otros = explode("*", $otros);
	foreach($otros as $img) {
		//reemplazar widht heigh
		//$replace = preg_replace('/width="\d+" height="\d+"/', 'width="712" height="475"', $replace);
		$img = preg_replace('/width="\d*"/', 'width="300"', $img);
		echo "<div style='width:300px'>$img</div>";
	}
}

}

// --------------------------------------------------

function columna2($fila, $ilink) {
extract($fila);

if ($interesante OR $wow OR $mas OR $competencias) {

	echo "<div class='colu'>";
	if ($interesante) {echo "<div class='justify interli'><h3>".i("interesante",$ilink)."</h3>".nl2br($interesante)."<hr class='sty'></div>";}
	if ($wow) {echo "<div class='justify interli'><h3>WOW!</h3>".nl2br($wow)."<hr class='sty'></div>";}
	if ($competencias) {echo "<div class='justify interli'><h3>".i("competencias",$ilink)."</h3>".nl2br($competencias)."<hr class='sty'></div>";}
	if ($mas) {echo "<div class='justify interli'><h3>".i("mas",$ilink)."</h3>".nl2br($mas)."</div>";}
	echo "</div>";

}

}

// --------------------------------------------------

function columna3($codigo11,$codigo12,$codigo13,$codigo14,$grupoid,$ilink,$esmigrupo) {

if ($esmigrupo) {
	
echo "<div class='contiene' style='border:1px solid #c0c0c0;width:99%;height:300px'>";
$iresult = $ilink->query("SELECT grupo FROM grupos WHERE id = '$grupoid' LIMIT 1");
$titchat = $iresult->fetch_array(MYSQLI_BOTH);
$titchat = $titchat[0];
$_GET['enchatusuid'] = "g_".$grupoid;
$enchatusuid = "g_".$grupoid;
require_once APP_DIR . '/chatmini/chat.php';
echo "</div>";
echo "<div class='fl both'></div><p></p>";

}
	
if ($codigo11) {echo "<div align='center'>".stripslashes($codigo11)."</div>";}
if ($codigo12) {echo "<p></p><div align='center'>".stripslashes($codigo12)."</div>";}
if ($codigo13) {echo "<p></p><div align='center'>".stripslashes($codigo13)."</div>";}
if ($codigo14) {echo "<p></p><div align='center'>".stripslashes($codigo14)."</div>";}

}

// --------------------------------------------------

function thumb_alu($result,$ilink) {
	?>
	<div>
	<?php
	while ($fila = $result->fetch_array(MYSQLI_BOTH)) {
		$usu = ponerusu($fila['usu_id'],2,$ilink);
		echo "<div class='foto2'>";
		echo "<span class='fl'>$usu[0]</span>";
		echo "$usu[1]";
		echo "</div>";
	}
	echo "<div class='both'>&nbsp;</div>";
}


//******************************************************************************************
?>