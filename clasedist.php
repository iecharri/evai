<?php

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

$asicurgrupo = $_SESSION['asigna']."$$".$_SESSION['curso']."$$".$_SESSION['grupo'];

$basedir = DATA_DIR ."/cursos/$asicurgrupo/claseactual/";

if ($_SESSION['auto'] > 4) {
	if ($_GET['fin']) {safe_unlink($basedir."clase.txt");}
	if ($_GET['file']) {
		$file = fopen($basedir."clase.txt","w");
		fwrite($file,$_GET['file']);
		fclose($file);
	}
}

$elwidget = formuwidget($ilink);
$elwidget = stripslashes($elwidget);
if ($_GET['widget']) {return;}


require_once APP_DIR . '/jcclasedistfunci.php';

// --------------------------------------------------

?>

<div style='overflow:hidden;display:inline;float:left;width:330px;'>

<?php

// Cosas que le aparecen al profesor
if ($_SESSION['auto'] > 4) {
	echo "<div class='colu peq col-10'><span class='b'>Profesor: </span> <a onclick=\"amplred('sopro')\" class='txth b'>Ampliar/reducir</a>. ";
	echo "<a href='clasedir/index.php' class='rojo peq' target='_blank'>AYUDA</a>. ";
	echo "<div id='sopro' style='display:none'>";
	echo "<a href='?op=8&widget=1'>A&ntilde;ade o cambia el widget de v&iacute;deo (p.ej. ustream, youtube)</a><br>";
	echo "<a title='Sube im&aacute;genes a la carpeta *claseactual* y cuando quieras, pinchando en el link de las im&aacute;genes
	que has subido, las personas que est&eacute;n en esta p&aacute;gina las ver&aacute;n, a la vez que est&eacute;s emitiendo v&iacute;deo 
	(insertando un widget de v&iacute;deo como ustream) o hablando en el chat de debajo' 
	href='soloprof/admin.php?pest=14&dir=&titul=&dir=claseactual' target='_blank'>Sube im&aacute;genes a la carpeta *claseactual*</a>";
		echo "<div style='background:#c0c0c0;OVERFLOW: auto; HEIGHT: 70px'>";
		$dir = getcwd();
		$hayfich = displaydir($basedir);
		chdir($dir);
		echo "</div>";
	echo "</div>";
	if ($hayfich) {
		echo "<a href=\"javascript:llamarasincrono('jcclasedistfich.php?fin=1');\">Acabar presentaci&oacute;n si la hay</a>.";
	}
	echo "</div>";
}


	echo "<div id='tochat' class='contiene' style='border:1px solid #c0c0c0;width:99%;height:300px'>";
	$_GET['enchatusuid'] = $_SESSION['asigna']."-".$_SESSION['curso']."-".$_SESSION['grupo'];
	$enchatusuid = $_GET['enchatusuid'];
	$titchat = str_replace("-"," ",$enchatusuid);
	require_once APP_DIR . '/chatmini/chat.php';
	echo "</div>";
	echo "<div class='fl both'></div><p></p>";

?>

</div>

<script>

$( ".dialog3" ).dialog({
	autoOpen: true,
	width: 500,
	height: 550,
}).prev(".ui-dialog-titlebar").css("background","#B7B75E");

</script>

<?php

if ($elwidget) {

	echo "<div class='dialog3' title='video'>";

	echo $elwidget; //"Move me!... Resize me!".

	echo "</div>";

}

?>

<!-- Div de la derecha, donde se ven las fotos -->
<div style='margin-left:330px;height:800px'> <!-- height:600px -->
	<div id="jcclasedistcontrol">
	<script language="javascript">
	jcclasedistcontrol();
	</script></div>

	<div id="jcclasedistimag" class='fl' style='width:98%;height:600px'> <!-- 330px -->
	<script language="javascript">
	jcclasedistimag();
	</script>
</div>

</div>



<div id="contenido"></div>

<?php

// --------------------------------------------------

function formuwidget($ilink) {

	if ($_POST['submiwidget']) {	
		$ilink->query("UPDATE cursasigru SET clasedistancia = \"".addslashes($_POST['formuwidget'])."\" WHERE
		asigna = '".$_SESSION['asigna']."' AND curso = '".$_SESSION['curso']."' 
		AND grupo = '".$_SESSION['grupo']."'");
	}

	if ($_GET['pordef']) {
		$actu = widgetpordef();
	} else {
		$sql = "SELECT clasedistancia FROM cursasigru WHERE asigna = '".$_SESSION['asigna']."' AND 
		curso = '".$_SESSION['curso']."' AND grupo = '".$_SESSION['grupo']."'";
		$iresult = $ilink->query($sql);
		$actu = $iresult->fetch_array(MYSQLI_BOTH);
		$actu = $actu[0];
	}
	
	if ($_SESSION['auto'] < 5) {return $actu;}

	if ($_GET['widget']) {
		echo "<p></p>";
		echo "<span class='mediana'>Pincha 
		<a class='b' href='?op=8&widget=1&pordef=1'>aqu&iacute;</a> para usar la cuenta de Ustream por
		 defecto de EVAI, o rellena el campo con el widget de v&iacute;deo en directo que desees.</span>";
		echo "<br>"; 
		echo "<form method='post' action='?op=8'>";
		echo "<input class='submicss' type='submit' name='submiwidget' value=' >> Validar >>'>";
		echo "<br><textarea name='formuwidget' rows='25' cols='80'>$actu</textarea>";
		echo "</form>";
	}	
	return $actu;
}

// --------------------------------------------------

function widgetpordef() {
	
	$widgetpordef = 
	"<iframe src=\"http://www.ustream.tv/embed/10650451\" width=\"325\" height=\"296\" scrolling=\"no\" 
frameborder=\"0\" style=\"border: 0px none transparent;\"></iframe><br>
<a href=\"http://www.ustream.tv/producer\" style=\"padding: 2px 0px 4px; width: 400px; 
background: #ffffff; display: block; color: #000000; font-weight: normal; font-size: 10px; 
text-decoration: underline; text-align: center;\" target=\"_blank\">
Free desktop streaming application by Ustream</a>";

return $widgetpordef; 	
	
	$widgetpordef = 	
"<object classid=\"clsid:d27cdb6e-ae6d-11cf-96b8-444553540000\" width=\"325\" height=\"296\" id=\"utv125169\">
<param name=\"flashvars\" value=\"autoplay=false&brand=embed&cid=9353362&v3=1\"/>
<param name=\"allowfullscreen\" value=\"true\"/><param name=\"allowscriptaccess\" value=\"always\"/>
<param name=\"movie\" value=\"http://www.ustream.tv/flash/viewer.swf\"/>
<embed flashvars=\"autoplay=false&brand=embed&cid=9353362&v3=1\" width=\"325\" height=\"296\" 
allowfullscreen=\"true\" allowscriptaccess=\"always\" id=\"utv125169\" name=\"utv_n_209502\" 
src=\"http://www.ustream.tv/flash/viewer.swf\" type=\"application/x-shockwave-flash\"></object><br>
<a href=\"http://www.ustream.tv/\" style=\"padding: 2px 0px 4px; width: 400px; background: #ffffff;
 display: block; color: #000000; font-weight: normal; font-size: 10px; text-decoration: underline; 
 text-align: center;\" target=\"_blank\">Video streaming by Ustream</a>

";
	return $widgetpordef; 	
	
}

// --------------------------------------------------

function displaydir($basedir) {

$dirlist = array();

chdir($basedir);
$handle=opendir(".");
while ($file = readdir($handle))
	{
		if(!is_dir($file) AND $file != 'clase.txt') $dirlist[] = $file;
	}
	closedir($handle);
	if (sizeof($dirlist)) {
	asort($dirlist);
			
	foreach ($dirlist as $key => $file) {
		//echo '<a href="javascript:llamarasincrono(\'jcclasedistfich.php?file=' . $file . '\');">' . $file . '</a><br>';
		//echo "<a href=\"javascript:llamarasincrono('jcclasedistfich.php?file=$file')\">$file</a><br>";
		
echo '<a href="javascript:llamarasincrono(\'jcclasedistfich.php?file='. rawurlencode($file).'\')", \'jcclasedistimag\'>' . $file . '</a><br>';		 //jcclasedistimag"
		
		$hayfich = 1;
	}		
			
	}
	return $hayfich;
}


?>

