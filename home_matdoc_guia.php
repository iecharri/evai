<?php

require_once __DIR__ . '/siempre.php';

if ($_SESSION['auto'] < 3) {exit;}

require_once APP_DIR . '/head.php';

$carpeta = $_GET['carpeta'];

$asicurgru = strtoupper($_SESSION['asigna']."$$".$_SESSION['curso']."$$".$_SESSION['grupo']);
$titcur = strtoupper($_SESSION['tit']."$$".$_SESSION['curso']);

$dirini = match ($carpeta) {
    'md'  => "/cursos/$asicurgru/compartida/",
    'gdt' => "/cursos/$titcur/contenidos/",
    'gda' => "/cursos/$asicurgru/contenidos/",
    default => "1",
};

if($dirini == "1") {exit;}
?>

<body>

<?php 

$dirini = DATA_DIR . $dirini; 

$script = "?carpeta=$carpeta"; 

if ($_SESSION['auto'] < 5) {$solover = 1;}
$fichphp = APP_URL . "/file.php";
$ocul = "__";

$dir = $_GET['dir'];
if (substr($dir,strlen($dir)-1,1) != "/"){$dir=$dir."/";}
if ($dir == "/" OR stristr($dir, '..') OR $dir == "." OR $dir == "./" OR !is_dir($dirini.$dir)) {$dir = "";}
if ($_GET['fich'] AND !is_file($dirini.$dir.$_GET['fich'])) {$_GET['accion'] = "";}

$carpeta = @scandir($dirini . $dir) ?: [];

if (count($carpeta) < 3 && !$dir) {
    echo "&nbsp; &nbsp; ";
    return;
}

homeexplo($dir,$dirini,$script,$solover,$puedounzip,$tamanomax,$fichphp,$ilink,$imgloader,$ocul);

echo "</body></html>";

// --------------------------------------------------

function homeexplo($dirx,$dirini,$script,$solover,$puedounzip,$tamanomax,$fichphp,$ilink,$imgloader,$ocul) {

	$dire = $dirini.$dirx;
	$dir = opendir($dire);
	$n = 0;
	while ($elem = readdir($dir)) {
		if ($elem == "." OR $elem == ".." OR ($ocul AND $_SESSION['auto'] < 5 AND substr($elem,0,2) == $ocul)) {continue;}
		$array[$n][0] = $elem;
		$fich = $dire.$elem;
		$array[$n][1] = filesize($fich);
		$array[$n][2] = filectime($fich);
		if (is_dir($fich)) {
			$array[$n][3] = i("carpeta1",$ilink);
		} else {
			$array[$n][3] = strrchr(strtolower($fich) , ".");
		}
		
		if ($_SESSION['soy_superadmin']) {$array[$n][4] = 1; $array[$n][5] = 1; $n++; continue;}
		if (strpos($script, "ndexrecursos.php") == 1) { //Es carpeta recursos
			if ($_SESSION['auto'] > 4) {$array[$n][4] = 1;} //con check
			$array[$n][5] = 1; //pinchable
			$n++; continue;
		}		
		$array[$n][4] = 1;$array[$n][5] = 1;
		$n++;
	}
	closedir($dir);


	dirant($dirx, $dirini, $script);

	if(empty($array)) {
		return;
	}

	foreach ($array as $elem) {
		if ($elem[5]) {
			if ($elem[3] == i("carpeta1",$ilink)) {
				echo "<a href='$script&dir=".rawurlencode($dirx).rawurlencode($elem[0])."'>";
			} else {
				$extens = explode(".",$elem[0]);
					echo "<a href='$fichphp?n=".base64_encode($dirini)."&dir=$dirx&fich=$elem[0]' target='_blank'>";
			}
		}
		echo imag1($elem[3],$ilink)." ";
		if (strlen($elem[0]) > 120) {$elem[0] = substr($elem[0],0,120)."...";}
		echo $elem[0];
		if ($elem[5]) {
			echo "</a>";
			if (strtolower($elem[3]) == ".zip" AND $puedounzip) {
				echo " [<a href='$script&dir=".rawurlencode($dir)."&accion=unzip&fich=".rawurlencode($elem[0])."' onclick=\"return confirm('unzip file *".$elem[0]."*')\">UNZIP</a>]";
				 //class='txth b' 
			}
		}
		echo "<br>";
	}

}

// --------------------------------------------------

function dirant($dir, $dirini, $script) {
if ($dir == $dirini) {return;}
$dirant = substr($dir,0,(strlen($dir)-1));
$pos = strrpos($dirant, "/");
if ($pos) {$pos=$pos+1;}
	$dirant = substr($dirant,0,$pos);
	if ($dir) {
		echo "<a href='$script&dir=".rawurlencode($dirant)."'>
		<span class='icon-undo2 azul'></span></a><br>";
	} 
}

?>
