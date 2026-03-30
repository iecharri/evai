<?php

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');
if ($_SESSION['auto'] < 5 OR !esprofesor($asigna,$curso,$grupo,$ilink)) {return;}

$ret = wintot1("",'','copyleaks',"Copyleaks",1,$ilink);

//listar alumnos y sus ficheros de asignatura-curso-grupo

$temp = $asigna;
if ($curso) {$temp .= "$$".$curso;}	
if ($grupo) {$temp .= "$$".$grupo;}	
$carpeta = "profesor/$temp/";

// --------------------------------------------------

$temp1 = i("trabpers",$ilink);
$temp1 = "Se muestra el n&uacute;mero de mensajes / n&uacute;mero de caracteres escritos en el FORO de la 
Asignatura o Titulaci&oacute;n. CLICK ah&iacute; para ver los mensajes.";
$temp1 .= "<br>Se muestra el n&uacute;mero de mensajes / n&uacute;mero de caracteres escritos en los FOROS de los GRUPOS de la 
Asignatura. CLICK ah&iacute; para ver los mensajes.";

unset($array);

$array[0] = "<a href='admin.php?pest=$pest'>".i("trabpers",$ilink)." <span class='icon-arrow-right'></span></a>";
$array[1] = "<a href=?pest=$pest>Resumen</a>";
$array[2] = "<a href='?pest=$pest&pest1=2'>Foro / Alumno</a>";
$array[3] = "<a href='?pest=$pest&pest1=3'>Foro / Profesor</a>";

if(!$pest1) {$pest1 = 1;}
solapah($array,$pest1+1,"navhsimple");

// --------------------------------------------------

if($pest1 == 2) {
	require_once APP_DIR . "/soloprof/soloproftrabalu1.php";
	return;
} elseif($pest1 == 3) {
	require_once APP_DIR . "/soloprof/soloproftrabprof1.php";
	return;
}

// --------------------------------------------------

echo "<p>";
echo str_replace("<asicurgru>", "$asigna $curso $grupo", str_replace("<asicurgru1>", $temp, $temp1));
echo "<p></p>";

echo "<h3>".i("profesores",$ilink)."</h3>";

$sqlprof = "SELECT DISTINCT usuarios.id, autorizado, privacidad FROM asignatprof LEFT JOIN usuarios ON asignatprof.usuid = usuarios.id 
	WHERE autorizado > 1 AND fechabaja = '0000-00-00 00:00:00' AND asigna = '$asigna' AND curso = '$curso' AND grupo = '$grupo' AND usuarios.id > 0 
	ORDER BY usuarios.alumnoa, usuarios.alumnon";
//$oculta1 = 
trabajos($sqlprof,$ilink,"",$temp);

echo "<h3>".i("alumnos",$ilink)."</h3>";

$sqlalu = "SELECT DISTINCT usuarios.id, auto, autorizado, privacidad, usuario FROM alumasiano LEFT JOIN usuarios ON alumasiano.id = usuarios.id WHERE auto > 1 AND autorizado > 1 AND fechabaja = '0000-00-00 00:00:00' AND asigna = '$asigna' AND curso = '$curso' AND grupo = '$grupo' ORDER BY usuarios.alumnoa, usuarios.alumnon ";
 
trabajos($sqlalu,$ilink,"a",$temp);

function trabajos($sql,$ilink,$x,$temp) {

	$result = $ilink->query($sql);

	while ($fila = $result->fetch_array(MYSQLI_BOTH)) {
		extract($fila);
		$usu = ponerusu($id,1,$ilink);
		echo "<div style='position:relative'>$usu[0] $usu[1]";
		$_GET['usuid'] = $id;
		$ret = wintot1("forosusu.php",'','divxx'.$id,i("foro",$ilink),1,$ilink);
	
		if ($ret[0]) {
			echo " -&nbsp;<a onclick = \"hidedivxx();show('divxx$id')\">Mensajes FORO:  
			<span class='b'>$ret[0]</span> / <span class='b'>$ret[1]</span></a>";
		}
		$ret1 = wintot1("forosgrupousu.php",'','divxxx'.$id,i("foro",$ilink)." - ".i("grupos1",$ilink),1,$ilink);
		if ($ret1[0]) {
			echo " - &nbsp;<a onclick = \"hidedivxx();show('divxxx$id')\">Mensajes FORO grupos:  
			<span class='b'>$ret1[0]</span> / <span class='b'>$ret1[1]</span></a>";
		}
		if($x) {
			$dirini = DATA_DIR . "/usuarios/$usuario/";
			if (!is_dir($dirini)){safe_mkdir($dirini);}
			if (!is_dir($dirini."profesor/")){safe_mkdir($dirini."profesor/");}
			if (!is_dir($dirini."profesor/$temp")){safe_mkdir($dirini."profesor/$temp");}
			$dirini = "/usuarios/$usuario/profesor/$temp/";
			muestrafich($usuario,$dirini,$ilink);
		}
		echo "</div>";
		echo "<hr class='sty'>";
		
	}

}

// --------------------------------------------------

function muestrafich($usuario,$dirini,$ilink) {

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

echo "<br><table class='col-5 conhover'>";

echo "<tr><th>".i("nombre",$ilink)."</th><th>".i("tamano",$ilink)."</th><th>".i("agfecha",$ilink)."</th><th>".i("tipo2",$ilink)."</th>";

if($_SESSION['auto'] > 9) {
	echo "<th class='col-01' title='Copyleaks'>CL</th>";
}
echo "</tr>";

$copyleaks = array("txt","pdf","docx","doc","rtf","xml","ppt","xppt","odt","chm","epub","odp","ppsx","pages","xlsx","xls","csv","latex");

foreach ($array as $elem) {

	echo "<tr><td class='nob nowrap'>";
	if ($elem[3] == i("carpeta1",$ilink)) {
		echo "<a href='?pest=12&dir=".$elem[0]."'>"; //rawurlencode($dir).
	} else {
		$dir64 = base64_encode($dirini); 
		$url = APP_URL . "/ver_media.php?dir64=" . $dir64 . "&f=" . urlencode($elem[0]);
		echo '<a title="' . htmlspecialchars($elem[0], ENT_QUOTES). '" href="' . $url . '" target="_blank">';		
	}
	echo imag1($elem[3],$ilink)." ";
	if (strlen($elem[0]) > 50) {$elem[0] = substr($elem[0],0,50)."...";}
	echo $elem[0]."</a>";
	if (strtolower($elem[3]) == ".zip" AND $puedounzip) {
		echo " [<a class='txth b' href='$script&dir=".rawurlencode($dir)."&accion=unzip&fich=".rawurlencode($elem[0])."' onclick=\"return confirm('unzip file *".$elem[0]."*')\">UNZIP</a>]";
	}
	echo "</td><td class='nob nowrap'>";
	echo tamano($elem[1])."</td><td class='nob nowrap'>";
	echo fechaen(gmdate("Y-m-d H:i:s",$elem[2]),$ilink)."</td><td class='nob nowrap'>";
	echo strtolower($elem[3]);
	echo "</td>";

	if($_SESSION['auto'] > 4) {
		$ext = substr($elem[3],1);
		echo "<td>";
		if (in_array(strtolower($ext), $copyleaks)) {
			echo "<a href=\"javascript:document.getElementById('contenido').innerHTML='Comparando <span class=b>$elem[0]</span> con Copyleaks Plagiarism, espere por favor...';lla('../copyleaks.php?n=".base64_encode($navini)."&tabla=$elem[0]','contenido')\"  onclick=\"show('copyleaks')\" title='Ckeck with Copyleaks'><span class='icon-info'></span></a>";
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

?>


