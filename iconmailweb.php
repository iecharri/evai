<?php

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

if (!$_SESSION['usuid']) {return;}

// --------------------------------------------------

if ($_SESSION['tipo'] != 'E' OR $_SESSION['auto'] > 4) {

	if (!$_SESSION['asigna']) {
		echo i("nohasselec",$ilink)."<p></p>";
	}

}

if (!$_SESSION['asigna']) {return;}

$result1 = $ilink->query("SELECT DISTINCT mail, ppersonal FROM usuarios LEFT JOIN asignatprof ON asignatprof.usuid = usuarios.id WHERE fechabaja='0000-00-00 00:00:00' AND asigna = '$asigna' AND curso = '$curso' AND grupo = '$grupo'");

$fila = $result1->num_rows;
$ppersonal = "";
if ($fila) {
	$n = 0; $ppersonal = "";
	while ($fila = $result1->fetch_array(MYSQLI_BOTH)) {
		if ($n == 1) {$echo .= ";";}
		$echo .= $fila['mail'];
		$n = 1;
		if (!$ppersonal) {
			$ppersonal = $fila[1];
		}
	}
}

//echo "<a href='contacto.php'><span class='icon-mail2 grande center' title=\"".i("contacto1",$ilink)."\"></span> ".i("contacto1",$ilink)."</a> ";

if ($ppersonal) {
	echo " &nbsp; <a href='http://".$ppersonal."' target='_new'><span class='icon-earth grande' title=\"".i("web",$ilink)."\"></span> ".i("web",$ilink)."</a>\n";
}

$tit = $_SESSION['tit'];
$curso = $_SESSION['curso'];

echo i("estascon",$ilink)." ".$_SESSION['asigna'];
if($curso) {echo " ".i("curso",$ilink)." ".$curso;}
if($grupo) {echo " ".i("grupo",$ilink)." ".$grupo;}

echo "<a href='contacto.php'><span class='icon-mail2 grande center' title=\"".i("contacto1",$ilink)."\"></span> ".i("contacto1",$ilink)."</a> ";

$asicurgru = strtoupper($_SESSION['asigna']."$$".$curso."$$".$grupo);

logo($asicurgru);



$asigna = $_SESSION['asigna'];
$curso = $_SESSION['curso'];
if ($_SESSION['tipasig']) {$filtrocur = " AND curso = '$curso'";}
if (!$curso) {$curso = "";}
$grupo = $_SESSION['grupo'];

$sql = "SELECT texto FROM cursasigru WHERE asigna = '$asigna' $filtrocur AND grupo = '$grupo'";
$result = $ilink->query($sql);
$fila = $result->fetch_array(MYSQLI_BOTH);
if ($fila['texto']) {echo "<br><div class='justify interli'>".nl2br($fila['texto'])."</div>";}



// --------------------------------------------------

function logo($asicurgru) {
	$dir = DATA_DIR . "/logos_asigna";
	$logo = '';

	if (is_dir($dir)) {
    	foreach (scandir($dir) as $obj) {
        if ($obj != "." && $obj != ".." && strpos($obj, $asicurgru) !== false) {
            $logo = $obj;
            break;
        }
    	}
	}

	if ($logo) {
    	$dir64 = base64_encode("logos_asigna");
    	$url = "ver_media.php?dir64=$dir64&f=" . urlencode($logo);
   	 echo "<p></p><img src='$url' class='media-img' alt='Logo'>";
	}
}

?>
