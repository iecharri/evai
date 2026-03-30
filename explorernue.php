<?php

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

if (!is_dir($dirini) OR !$dirini) {safe_mkdir($dirini);}

if(strpos($dir,"ompartida") == 1) {$ocul = "__";}

?>

<script>

function borrar(form1) {
	if (document.form1.accion.value == "delete") {
		return confirm("<?php echo i("borrarfichmarc",$ilink);?>");
	}
}

function visib(capa,si,dir,form1){
document.getElementById("capa").style.display = "none";
valor=["none","inline","inline","inline"];
document.getElementById("capa").style.display=valor[si];
if (document.form1.accion.value == "copy" || document.form1.accion.value == "move"){
   document.form1.aque.value = dir;
}
if (document.form1.accion.value == "rename"){
   document.form1.aque.value = '';
}
} 

</script>

<?php

$ret = wintot1("",'','copyleaks',"Copyleaks",1,$ilink);

require_once APP_DIR . "/registrar.php";

$dir = $_GET['dir'];
if (substr($dir,strlen($dir)-1,1) != "/"){$dir=$dir."/";}
if ($dir == "/" OR stristr($dir, '..') OR $dir == "." OR $dir == "./" OR !is_dir($dirini.$dir)) {$dir = "";}
if ($_GET['fich'] AND !is_file($dirini.$dir.$_GET['fich'])) {$_GET['accion'] = "";}

$tamanomax = 750; //400;
if ($_SESSION['auto'] == 5) {$tamanomax = 750;} //400
if ($_SESSION['auto'] < 5) {
	$tamanomax = 3;
	if ($_SESSION['tipo'] == "A") {$tamanomax = 80;}
}

$tam = ($tamanomax* 1024 * 1024);

$mensaje = array(); 

// -------------------------------------------------- Upload // --------------------------------------------------
if ($_POST['upload']) {
	foreach ($_FILES['fichup']['name'] as $f => $name) {
		if ($_FILES['fichup']['error'][$f] != 0) {
			$mensaje[] = $_FILES['fichup']['name'][$f].": ".i("errorupload",$ilink);
			continue; // Skip file if any error found
	   }		
		if (exten($_FILES['fichup']['name'][$f])){
			$mensaje[] = $_FILES['fichup']['name'][$f].": ".i("extnopermi",$ilink);
			continue;
		} elseif ($_FILES['fichup']['size'][$f] > $tam) {
			$mensaje[] = $_FILES['fichup']['name'][$f].": ".i("tamanofichgr",$ilink). " $tamanomax MB";
			continue;
		} elseif (!$nomodif) {
			$fichupname = sanear_string($_FILES['fichup']['name'][$f]);
			$exito = safe_move_uploaded_file($_FILES['fichup']['tmp_name'][$f],$dirini.$dir.$fichupname);
			$subi = tamano($_FILES['fichup']['size'][$f]);
			registrar($exito,"subir", '',$_FILES['fichup']['name'][$f],$dirini.$dir,$fichupname." (".$subi.")",$ilink);
		
			if ($exito) {
				$mensaje[] = $_FILES['fichup']['name'][$f].": ".i("subido",$ilink)." (".$subi.")";
			} else {
				$mensaje[] = $_FILES['fichup']['name'][$f].": Error ".i("errorupload",$ilink);
			}
		}
	
	}	
} 

// -------------------------------------------------- Crear fichero o carpeta // --------------------------------------------------
if (($_POST['mkdir'] OR $_POST['mkfile']) AND !$nomodif) {crear1($_POST,$dirini.$dir,$ilink);}
// -------------------------------------------------- Borrar // --------------------------------------------------
if ($_POST['accion'] == "delete" AND $_POST['check'] AND !$nomodif) {$mensaje[] = borrar($_POST['check'],$dirini.$dir,$ilink);}
// -------------------------------------------------- Copiar // --------------------------------------------------
if ($_POST['accion'] == "copy" AND $_POST['check'] AND $_POST['aque'] AND !$nomodif) {$mensaje[] = copiara($_POST['check'],$dirini,$dir, $_POST['aque'],$ilink);}
// -------------------------------------------------- Renombrar // --------------------------------------------------
if ($_POST['accion'] == "rename" AND $_POST['check'] AND $_POST['aque'] AND !$nomodif) {$mensaje[] = renamea($_POST['check'],$dirini,$dir,$_POST['aque'],$ilink);}
// -------------------------------------------------- Mover // --------------------------------------------------
if ($_POST['accion'] == "move" AND $_POST['check'] AND $_POST['aque'] AND !$nomodif) {$mensaje[] = movera($_POST['check'],$dirini,$dir,$_POST['aque'],$ilink);}
// --------------------------------------------------

if ($_GET['accion'] == 'unzip' AND $puedounzip) {

   $zip = new ZipArchive;
    $zipPath = $dirini.$dir.$_GET['fich'];
    $res = $zip->open($zipPath);
    if ($res === TRUE) {
        $deszipear = 1;
        for ($i=0; $i<$zip->numFiles;$i++) {
            $array = $zip->statIndex($i);
            if (exten($array['name'])) {
                $deszipear = 0;
                $mensaje[] = $array['name'].": ".i("extnopermi",$ilink);
            }
        }
        if ($deszipear) {
            if ($zip->extractTo($dirini.$dir.$_GET['fich']."_files")) {
                //$mensaje[] = "Archivo descomprimido correctamente.";
            } else {
                //$mensaje[] = "Error al extraer el archivo ZIP.";
            }
        }
        $zip->close();
    } else {
        //$mensaje[] = "No se pudo abrir el archivo ZIP ($zipPath). Código de error: $res";
    }

}

// --------------------------------------------------

if ($mensaje) {
	foreach ($mensaje as $m => $mens) {
		echo "<h3 class='rojo'>$mens</h3>";
	}
}
if ($_GET['accion'] == 'editar' AND !$solover) {
	if ($_GET['fich']) {$editar = $dirini.$dir.$_GET['fich'];}
	editar($script,$dirini,$editar,$dir,$_POST['texto'],$solover,$ilink);
} else {
	require_once APP_DIR . '/comentariosprof.php';
	explorar($dir,$dirini,$script,$solover,$puedounzip,$tamanomax,$fichphp,$navini,$ilink,$imgloader,$ocul,$todosfich);
}

// --------------------------------------------------


// -------------------------------------------------- Explorar // --------------------------------------------------

function explorar($dir,$dirini,$script,$solover,$puedounzip,$tamanomax,$fichphp,$navini,$ilink,$imgloader,$ocul,$todosfich) {

	$dir1 = strpos($script, "dir=");
	if(!$dir1) {$temp = "dir=";}
	if ($_SESSION['auto'] > 4) {
		$hideonoff = "<span class='icon-eye-blocked mediana'></span> ".i("mostrar1",$ilink)." / ".i("ocultar1",$ilink);;
		echo "<div class='colu'>Atenci&oacute;n profesores <a href='#' onclick=\"amplred('ocul')\">$hideonoff</a>";
		echo "<div id='ocul' style='display:none'>";
		echo "<li>Si se desea evitar accesos a ficheros .html desde fuera de ".strtoupper(SITE).", se deben renombrar a .php y 
		a&ntilde;adir lo siguiente antes de ".htmlspecialchars("<html>").": ";
		$cad = htmlspecialchars("<?php")." ".htmlspecialchars("session_start();")." ".htmlspecialchars("if (!$").htmlspecialchars("_SESSION['auto']) {exit;}")." ".htmlspecialchars("?>");
		echo "<span class='peq'>".$cad."</span></li>";
		echo "<li>Se puede subir un fichero .zip (<span class='peq rojo'>¡evitar tildes en nombres de archivos!</span>) y luego descomprimirlo en el ".strtoupper(SITE)." haciendo click en [UNZIP].</li>";
		if($ocul) {
			echo "<li><span class='rojo'>".i("nuevo",$ilink)."</span> Renombra ficheros y carpetas, precediéndolos por dos guiones bajos '__', para ocultarlos a los Alumnos.</li>";
		}
		?>
		</div>
		</div>
		<?php
		if($todosfich) {
			echo "<br><div class='colu rojo'>";
			echo "<span class='b'>&iexcl;Atenci&oacute;n Administradores!</span> Se muestran todos los ficheros de EVAI. Algunos son necesarios para su buen funcionamiento, como iconos y sonidos. Se tiene acceso a las carpetas de fotos, usuarios, cursos, v&iacute;nculos, grupos y ficheros del pod en las correspondientes carpetas.";
			echo "</div>";
		}
	}
	echo "<p></p><a href=$script&$temp>".i("inicio",$ilink)."</a> - ".i("carpactu",$ilink).": <span class='txth b'>/$dir</span>";

	echo "<form name='form1' action='$script&$temp".rawurlencode($dir)."' method='post' onsubmit=\"return borrar(form1)\">";
	$haychecks = explorer($dir,$dirini,$script,$solover,$puedounzip,$fichphp,$navini,$ilink,$ocul);
	if ($dir == "profesor/" AND !strpos($dirini,"grupos")) {return;}

	
	if (!$solover AND $haychecks) {
		echo i("conmarca",$ilink);
		echo " <select name='accion' onChange=\"visib('capa',this.selectedIndex,'/$dir',form1);return false\">";
		echo "<option value='delete'>".i("borrarfich",$ilink);
		echo "<option value='copy'>".i("copytofol",$ilink);
		echo "<option value='rename'>".i("rename",$ilink);
		echo "<option value='move'>".i("movetofol",$ilink);
		echo "</select> ";
		echo " <div style='display:none' id='capa'><input class='col-3' type='text' name='aque' size='50' maxlength='150'></div> ";
		echo "<input type='submit' class='col-1' name='accion1' value=' >> '>";
	}
	echo "</form>";

	if ($solover) {return;}

	echo "<form action='$script&$temp".rawurlencode($dir)."' enctype='multipart/form-data' method='post' onsubmit=\"hide('ocultar');show('esperar')\">";
	if (!strpos($dir,"$$") AND !strpos(".".$dir,"profesor/") AND !strpos(".".$dir,"public/")) {
		echo "<input type='text' name='dirmake' size='20' maxlength='100' class='col-1 fl'>";
		echo " &nbsp;<input class='col-2' type='submit' name='mkdir' value=\"".i("createfolder",$ilink)."\"><br>";
	}

// --------------------------------------------------
	$boton = "submit";
	$name = "upload";	
	if($_SESSION['auto'] > 4) {
		$legal = DATA_DIR . "/legal.txt";
		if(file_exists($legal)) {
			$texto = nl2br(conhiper(file_get_contents($legal)));
			$texto .= "<p></p><input class='col-2' type='submit' name='upload' value=\"".i("aceptar",$ilink)."\">";
			wintot1('',"<p class='justify interli'>$texto</p>",'divxx1','',1,$ilink);
			$oncl = " onclick=\"show('divxx1')\"";
			$boton = "button";
			$name = "uploadxx";
			$oncl = "onclick=\"show('divxx1')\"";
		}
	}
// --------------------------------------------------

	if (!strpos(".".$dir,"public/")) {
		echo "<input type='text' name='file' size='20' class='both col-1 fl'>";
		echo " &nbsp;<input class='col-2' type='submit' name = 'mkfile' value=\"".i("createfile",$ilink)."\">";
		echo "<p class=both'></p>";
	}

	?><div class="bloque-subida"><?php echo i("filemax",$ilink).": <span class='rojo b'>$tamanomax MB</span>: ";?>
  		<label class="boton-subida">
   	 📁 Select
   	 <input type="file" name="fichup[]" multiple>
 		 </label><?php

	echo " <span id='ocultar'><input class='col-2' type='$boton' name='$name' value=\"".i("sendfile",$ilink)."\" $oncl></span>";
	echo " <span id='esperar' style='display:none'>$imgloader".i("esperar",$ilink)."</span>";
	echo "</div></form>";

}

// -------------------------------------------------- Tabla funcion explorer // --------------------------------------------------

function explorer($dir,$dirini,$script,$solover,$puedounzip,$fichphp,$navini,$ilink,$ocul) {

	$array = leer($dirini,$dir,$script,$ilink,$ocul);
	$haychecks = mostrar($array,$dir,$dirini,$script,$solover,$puedounzip,$fichphp,$navini,$ilink);
	return $haychecks;
}

function leer($dirini,$dirx,$script,$ilink,$ocul) {
	$usuid = $_GET['usuid'];
	$dire = $dirini . $dirx;
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
		if (strpos($script, "ndexrecursos.php") == 1) { //Es carpeta recursos
			if ($_SESSION['auto'] > 4) {$array[$n][4] = 1;} //con check
			$array[$n][5] = 1; //pinchable
			$n++; continue;
		}		
		if ($array[$n][0] == "profesor" AND $dirx == "") { //La carpeta profesor, sin check, pinchable
			$array[$n][4] = 0; $array[$n][5] = 1;
			$n++; continue;
		}
		if (strpos($script, "rupo.php") == 1) { //Es carpeta grupo
			$array[$n][4] = 1; //con check
			$array[$n][5] = 1; //pinchable
			$n++; continue;
		}		
		if ($_SESSION['auto'] > 4 AND (!$_GET['usuid'] OR $_GET['usuid'] == $_SESSION['usuid'])) { //soy prof y es m&iacute;a
			$array[$n][4] = 1; $array[$n][5] = 1;
			$n++; continue;
		}
		if ($dirx == "profesor/" OR ($dirx == "" AND $_SESSION['auto'] > 4)) {
			//Lo que hay dentro de carpeta profesor
			if (strpos($elem,"$$") > 0) {
				$array[$n][4] = 0; //sin check
				$acg = explode("$$",$elem);
				//if ($_SESSION['auto'] < 5 OR esprofesor($acg[0],$acg[1],$acg[2],$ilink)) {$array[$n][5] = 1;} //pinchable
				if (esalumno1($acg[0],$acg[1],$acg[2],$ilink,$usuid)) {$array[$n][5] = 1; $n++;}
				continue;
			}
			$array[$n][4] = 1;$array[$n][5] = 1;
			$n++; continue;
		}

		if ($_SESSION['soy_superadmin']) {$array[$n][4] = 1; $array[$n][5] = 1; $n++; continue;} 

		$array[$n][4] = 1;$array[$n][5] = 1;
		$n++;
	}
	closedir($dir);
	return $array;
}

function mostrar($array,$dir,$dirini,$script,$solover,$puedounzip,$fichphp,$navini,$ilink){
	echo "<table class='conhover'>";
	echo "<tr><th><a href='$script&dir=$dir&ord=nom'>".i("nombre",$ilink)."</a></th>
	<th class='col-01'><a href='$script&dir=$dir&ord=tam'>".i("tamano",$ilink)."</a></th>
	<th class='col-01'><a href='$script&dir=$dir&ord=fec'>".i("agfecha",$ilink)."</a></th>
	<th class='col-01'><a href='$script&dir=$dir&ord=tip'>".i("tipo2",$ilink)."</a></th>";
	echo "<th class='col-01'>".i("editar1",$ilink)."</th>";
	if($_SESSION['auto'] > 9) {
		echo "<th class='col-01' title='Copyleaks'>CL</th>";
	}
	echo "</tr>";
	dirant($dir, $dirini, $script);

	if(empty($array)) {
		echo "</table>";
		return;
	}

	if ($_GET['ord'] == "nom") {$cla = 0;}
	if ($_GET['ord'] == "tam") {$cla = 1;}
	if ($_GET['ord'] == "fec") {$cla = 2;}
	if ($_GET['ord'] == "tip") {$cla = 3;}

	foreach ($array as $llave => $fila) {
   	$ord[$llave]  = $fila[$cla];
	}

	array_multisort($ord, SORT_ASC, $array);

	$copyleaks = array("txt","pdf","docx","doc","rtf","xml","ppt","xppt","odt","chm","epub","odp","ppsx","pages","xlsx","xls","csv","latex");

	foreach ($array as $elem) {
		echo "<tr><td class='nob nowrap'>";
		if ($elem[4]) {
			echo "<input type='checkbox' name=\"check[]\" value=\"$elem[0]\"> "; $haychecks = 1;
		} else {
			echo "<span style='margin-left:19px'>&nbsp;</span>";
		}
		if ($elem[5]) {
			if ($elem[3] == i("carpeta1",$ilink)) {
				echo "<a href='$script&dir=".rawurlencode($dir).rawurlencode($elem[0])."'>";
			} else {
				$extens = explode(".",$elem[0]);
				if ($extens[1] == "htm" OR $extens[1] == "html" OR $extens[1] == "php") { 
					echo "<a href=\"$navini$dir$elem[0]\" target='_blank'>";    // esto habrá que pensarlo, copiar a una carpeta sites en MEDIA_DIR
				} else {
					echo "<a href=\"$fichphp"."&dir=$dir&fich=$elem[0]\" target='_blank'>";
				}
			}
		}
		echo imag1($elem[3],$ilink)." ";
		if (strlen($elem[0]) > 120) {$elem[0] = substr($elem[0],0,120)."...";}
		echo $elem[0];
		if ($elem[5]) {
			echo "</a>";
			if (strtolower($elem[3]) == ".zip" AND $puedounzip) {
				echo " [<a class='txth b' href='$script&dir=".rawurlencode($dir)."&accion=unzip&fich=".rawurlencode($elem[0])."' onclick=\"return confirm('unzip file *".$elem[0]."*')\">UNZIP</a>]";
			}
		}
		echo "</td><td class='nob nowrap'>";
		echo tamano($elem[1])."</td><td class='nob nowrap'>";
		echo fechaen(gmdate("Y-m-d H:i:s",$elem[2]),$ilink)."</td><td class='nob nowrap'>";
		echo strtolower($elem[3]);
		echo "</td>";
		echo "<td class='nob'>";
		if (!$solover) { //(strpos($script, "odulos.php") < 1 AND strpos($script, "ndexrecursos.php") < 1 ) {
			if (strtolower($elem[3]) == ".txt" OR strtolower($elem[3]) == ".htm" OR strtolower($elem[3]) == ".html" OR (strtolower($elem[3]) == ".php" AND $_SESSION['auto'] > 4)) {
				echo "<a href=$script&dir=".rawurlencode($dir)."&accion=editar&fich=".rawurlencode($elem[0]).">
				<span class='icon-pencil'></span></a>";
			}
		}
		echo "</td>";
		if($_SESSION['auto'] > 4) {
			$partes = explode(".", $elem[0]);
			$ext = end($partes);
			//$ext = end(explode(".",$elem[0]));
			echo "<td>";
			if (in_array(strtolower($ext), $copyleaks)) {
				echo "<a href=\"javascript:document.getElementById('contenido').innerHTML='Comparando <span class=b>$elem[0]</span> con Copyleaks Plagiarism, espere por favor...';lla('".APP_URL."/copyleaks.php?n=".base64_encode($dirini)."&tabla=$dir$elem[0]','contenido')\"  onclick=\"show('copyleaks')\" title='Ckeck with Copyleaks'><span class='icon-info'></span></a>";
			}
			echo "</td>";
		}
		echo "</tr>";
	}
	echo "</table><br>";
	return $haychecks;
}

// -------------------------------------------------- Editar // --------------------------------------------------

function editar($script,$dirini,$fichedit,$dir,$texto,$solover,$ilink) {
	if (!$fichedit OR $solover) {return;}
	if ($_POST['validar']) {
		$fp = safe_fopen($fichedit,"w+");
		fwrite($fp,$texto);
		$subi = tamano(filesize($fichedit));
		fclose($fp);
		registrar($fp,"fopenw1",'','',$dirini.$dir, $fichedit."(".$subi.")",$ilink);
	}
	$temp = str_replace($dirini,"",$fichedit);
	$temp1 = str_replace($dir,"",$temp);
	echo "<p></p>".i("agedit",$ilink)." /$temp &nbsp;";
	echo "<form name='edit' method='post' action='$script&dir=$dir&accion=editar&fich=$temp1'>";
	echo "<input type='submit' class='col-2' name='validar' value=\"".i("agvalid",$ilink)."\"> &nbsp; <a href='$script&dir=$dir'>".i("volver",$ilink)."</a><p></p>";
	if (!$texto AND filesize($fichedit)) {
		$fp=safe_fopen($fichedit,"r");
		$texto=fread($fp,filesize($fichedit));
		fclose($fp);
	}
	echo "<textarea rows='30' cols='100' name='texto'>$texto</textarea>";
	echo "</form>";
}

// --------------------------------------------------

function dirant($dir, $dirini, $script) {
if ($dir == $dirini) {return;}
$dirant = substr($dir,0,(strlen($dir)-1));
$pos = strrpos($dirant, "/");
if ($pos) {$pos=$pos+1;}
	$dirant = substr($dirant,0,$pos);
	if ($dir) {
		echo "<tr><td class='nob'><a href='$script&dir=".rawurlencode($dirant)."'>
		<span class='icon-undo2 azul'></span></a></td><td></td><td></td><td></td>";
		echo "<td></td>";
		echo "</tr>";
	}
}

// --------------------------------------------------

function crear1($post,$dir,$ilink) {
	if ($post['mkdir']) {
		$dirmake = sanear_string($post['dirmake']);
		if(!file_exists($dir.$dirmake)){
			$exito = safe_mkdir($dir.$dirmake,0750);
			registrar($exito,"mkdir",'',$post['dirmake'],$dir,$dirmake,$ilink);
		}
	}

	if ($post['mkfile']) {
		$fich = sanear_string($post['file']);
		if(!file_exists($dir.$fich)){
			$file = safe_fopen($dir.$fich,"w");
			fwrite($file," ");
			fclose($file);
			registrar($file,"fopenw",'',$_POST['file'],$dir,$fich,$ilink);
		}
	}
}

// --------------------------------------------------

function borrar($array,$dir,$ilink) {
	$n = 0;
	foreach ($array as $elem) {
		if (is_dir("$dir$elem")) {
			borrardir("$dir$elem/",$ilink);
		} else {
			$exito = safe_unlink("$dir$elem");
			registrar($exito, "unlink", $dir, $elem,'', '',$ilink);
		}
		$n = $n + 1;
	}
}

// --------------------------------------------------

function copiara($array,$dirini,$dir,$dirdest,$ilink) {
	$n = 0;
	if (substr($dirdest,0,1) == "/") {$dirdest=substr($dirdest,1);}
	if (substr($dirdest,strlen($dirdest)-1,1) != "/"){$dirdest=$dirdest."/";}
	if (!is_dir($dirini.$dirdest)){return i("noexiste",$ilink).": /".$dirdest;}
	foreach ($array as $elem) {
		$exito = safe_copy($dirini.$dir.$elem,$dirini.$dirdest.$elem);
		registrar($exito,"copy",$dirini.$dir,$elem,$dirini.$dirdest,$elem,$ilink);
		$n = $n + 1;
	}
}

// --------------------------------------------------

function movera($array,$dirini,$dir,$dirdest,$ilink) {
	$n = 0;
	if (substr($dirdest,strlen($dirdest)-1,1) != "/"){$dirdest=$dirdest."/";}
	if (!is_dir($dirini.$dirdest)){return i("noexiste",$ilink).": /".$dirdest;}
	foreach ($array as $elem) {
		$exito = safe_rename($dirini.$dir.$elem,$dirini.$dirdest.$elem);
		registrar($exito,"mover",$dirini.$dir,$elem,$dirini.$dirdest,$elem,$ilink);
		$n = $n + 1;
	}
}

// --------------------------------------------------

function renamea($array,$dirini,$dir,$dirdest,$ilink) {
	$n = 0;
	if (substr($dirdest,0,1) == "/") {$dirdest=substr($dirdest,1);}
	if (is_file($dirini.$dir.$dirdest)) {return "Ya existe el fichero";}
	if (sizeof($array) == 1){
		if (exten($dirdest)){
			return i("extnopermi",$ilink);
		} else {
			$exito = safe_rename($dirini.$dir.$array[0],$dirini.$dir.$dirdest);
			registrar($exito,"rename",$dirini.$dir,$array[0],$dirini.$dir,$dirdest,$ilink);
		}
	}
}

// --------------------------------------------------

function exten($ruta) {
	$fich = substr($ruta,strrpos($ruta,"/"));
	$ext = substr($fich, strrpos($fich,".")+1);
	if ($ext == "php" AND $_SESSION['auto'] > 4) {return 0;}
	if ($ext == "sh" OR $ext == "php" OR $ext == "phps" OR $ext == "php2" OR $ext == "php3" OR $ext == "php4" OR $ext == "phtml" OR $ext == "asp" OR $ext == "asa"){return 1;} else {return 0;}
}

// --------------------------------------------------

function borrardir($dir,$ilink){
    if ($handle = opendir($dir)) {
    while (false !== ($file = readdir($handle))) {
        if ($file != "." && $file != "..") {
            if(is_dir($dir.$file)){
               borrardir($dir.$file."/",$ilink);
             } else {
             	$exito = unlink($dir.$file);
             	registrar($exito,"unlink",$dir,$file,'','',$ilink);
            }
        }
	}
    closedir($handle);
	}
	$exito = safe_rmdir($dir);
	registrar($exito,"rmdir",$dir,'','','',$ilink);
}

?>