<?php

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

if ($_SESSION['auto'] < 5 OR !esprofesor($asigna,$curso,$grupo,$ilink)) {return;}

//listar grupos y sus ficheros de asignatura-curso-grupo

$sql = "SELECT DISTINCT grupos.id, grupos.grupo FROM grupos LEFT JOIN gruposusu ON grupos.id = gruposusu.grupo_id 
LEFT JOIN alumasiano ON alumasiano.id = gruposusu.usu_id ";

$sql .= " WHERE ((alumasiano.asigna = '".$_SESSION['asigna']."'";
if ($_SESSION['curso']) {$sql .= " AND alumasiano.curso = '".$_SESSION['curso']."'";}
$sql .= ") OR grupos.asigna = '".$_SESSION['asigna']."') ";

if ($_SESSION['curso']) {
	$sql .= "AND";
	$f1 = ($_SESSION['curso']-1)."-09-01"; $f2 = $_SESSION['curso']."-09-31";
	$sql .= " fechacrea >= '$f1' AND fechacrea <= '$f2'";
}

$result = $ilink->query($sql);

$carpeta = "profesor/$temp/";

// --------------------------------------------------

unset($array);

$array[0] = "<a href='#'>Trabajos Grupos <span class='icon-arrow-right'></span></a>";
solapah($array,1,"navhsimple");

$ret = wintot1("",'','copyleaks',"Copyleaks",1,$ilink);

// --------------------------------------------------

echo "<table class='conhover'>";
echo "<tr><th class='col-3'>".i("grupo",$ilink)."</th><th class='col-3 nowrap'>Ficheros (en carpeta [profesor] de cada grupo)</th></tr>";


while ($fila = $result->fetch_array(MYSQLI_BOTH)) {

	extract($fila);
	echo "<tr><td style='nowrap'>";
	echo "<a href='".APP_URL."/grupo.php?grupoid=$id' class='txth b mediana' target='_blank'>".$grupo."</a><p></p>";
	integrantes($id,$ilink);
	echo "</td>";
	echo "<td>";
	$dirini = DATA_DIR . "/grupos/$grupo/";
	if (!is_dir($dirini)){safe_mkdir($dirini);}
	if (!is_dir($dirini."profesor/")){safe_mkdir($dirini."profesor/");}
	$dirini = "/grupos/$grupo/profesor/";
	muestrafich($dirini,$ilink);
	echo "</td>";

	echo "</tr>";

}

echo "</table>";

// --------------------------------------------------

function muestrafich($dirini,$ilink) {
	$array = leer($dirini,$ilink);
	return mostrar($array,$dirini,$ilink);
}

// --------------------------------------------------

function leer($dire,$ilink) {

$dir = opendir(DATA_DIR . $dire);
$n = 0;
while ($elemento = readdir($dir))
{
	if ($elemento != "." AND $elemento != "..") {
		$array[$n][0] = $elemento;
		$fich = $dire.$elemento;
		$array[$n][1] = filesize(DATA_DIR.$fich);
		$array[$n][2] = filemtime(DATA_DIR.$fich);
		if (is_dir(DATA_DIR.$fich)) {$array[$n][3] = i("carpeta1",$ilink);} else {$array[$n][3] = strrchr ( strtolower($fich) , "." );}
		$n++;
	}
}
closedir($dir);
return $array;

}

// --------------------------------------------------

function mostrar($array,$dirini,$ilink){

if(empty($array)) {return;}

echo "<table class='conhover'>";

echo "<tr><th>".i("nombre",$ilink)."</th><th>".i("tamano",$ilink)."</th><th>".i("agfecha",$ilink)."</th><th>".i("tipo2",$ilink)."</th>";

if($_SESSION['auto'] > 9) {
	echo "<th class='col-01' title='Copyleaks'>CL</th>";
}
echo "</tr>";

$copyleaks = array("txt","pdf","docx","doc","rtf","xml","ppt","xppt","odt","chm","epub","odp","ppsx","pages","xlsx","xls","csv","latex");

foreach ($array as $elem) {

	echo "<tr><td class='nob nowrap'>";
	if ($elem[3] == i("carpeta1",$ilink)) {
		echo "<a href='?pest=12&dir=".rawurlencode($elem[0])."'>";
	} else {
		$dir64 = base64_encode($dirini); // ruta relativa a DATA_DIR
		$url = APP_URL . "/ver_media.php?dir64=$dir64" . "&f=" . urlencode($elem[0]);
		echo '<a title="' . htmlspecialchars($elem[0], ENT_QUOTES). '" href="' . $url . '" target="_blank">';		
	}
	echo imag1($elem[3],$ilink)." ";
	if (strlen($elem[0]) > 50) {$elem[0] = substr($elem[0],0,50)."...";}
	echo $elem[0]."</a>";
	if (strtolower($elem[3]) == ".zip" AND $puedounzip) {
		echo " [<a class='txth b' href='../file.php&dir=".rawurlencode($dir)."&accion=unzip&fich=".rawurlencode($elem[0])."' 
		onclick=\"return confirm('unzip file *".$elem[0]."*')\">UNZIP</a>]";
	}
	echo "</td><td class='nob nowrap'>";
	echo tamano($elem[1])."</td><td class='nob nowrap'>";
	echo fechaen(gmdate("Y-m-d H:i:s",$elem[2]),$ilink)."</td><td class='nob nowrap'>";
	echo strtolower($elem[3]);
	echo "</td>";
	
	if($_SESSION['auto'] > 4) {
		//$ext = end(explode(".",$elem[0]));
		$ext = substr($elem[3],1);
		echo "<td>";$dir = "";
		if (in_array(strtolower($ext), $copyleaks)) {
			echo "<a href=\"javascript:document.getElementById('contenido').innerHTML='Comparando <span class=b>$elem[0]</span> con Copyleaks Plagiarism, espere por favor...';lla('".APP_URL."/copyleaks.php?n=".base64_encode($navini)."&tabla=$dir$elem[0]','contenido')\"  onclick=\"show('copyleaks')\" title='Ckeck with Copyleaks'><span class='icon-info'></span></a>";
		}
		echo "</td>";
	}
	
	echo "</tr>";
	$n=$n+1;
}
echo "</table><br>";
return $n;

}

function quitabarra($x) {return stripslashes($x);}

// --------------------------------------------------

function integrantes($grupoid,$ilink) {
	
$sql = "SELECT usu_id FROM gruposusu WHERE gruposusu.grupo_id = '$grupoid'";

$result = $ilink->query($sql);

echo "<div class='both'></div>";

while ($fila = $result->fetch_array(MYSQLI_BOTH)) {

	$usu = ponerusu($fila['usu_id'],1,$ilink);
	echo $usu[0].$usu[1];
	echo "</div>";
	echo "<div class='both'></div>";
	
}
	
	
}

?>


