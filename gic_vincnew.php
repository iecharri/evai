<?php

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

if ($_SESSION['auto'] < 2) {exit;}

?>

<script language="javascript">

$(document).ready(function(){
	$("div[class='oscu']").click(function(){
		$('.oscu').hide();
	});
});

function verifi(form1) { 

if (form1.url.value == "")
	{
		alert("<?php echo i("web1",$ilink);?>")
		form1.url.focus()
		return false
	}

}

function compruebacampos2(form1) {
	if (form1.tipo[0].checked && (form1.titulo.value == "" || form1.url.value == "" || form1.claves.value == "" || form1.resumen.value == ""))
	{
		alert("<?php echo i("completaas",$ilink);?>")
		form1.url.focus()
		return false
	}

	if (form1.tipo[1].checked && (form1.titulo.value == "" || form1.fichup.value == "" || form1.claves.value == "" || form1.resumen.value == ""))
	{
		alert("<?php echo i("completaas",$ilink);?>")
		form1.url.focus()
		return false
	}
}

function vaciar(form1) {

	form1.url.value = ""
	form1.fichup.value = ""
	form1.titulo.value = ""
	form1.claves.value = ""
	form1.resumen.value = ""
	form1.amplia.value = ""
	form1.url.focus()
	
}

</script>

<?php

$i = $_SESSION['i'];
$fecha = gmdate("Y-m-d H:i:s");

$sologrupo = 1; if ($_POST['visi'] != "off" OR !$_POST['grupos']) {$sologrupo = 0;}

if ($_GET['id']) {
	$iresult = $ilink->query("SELECT * FROM vinculos WHERE id = '".$_GET['id']."' LIMIT 1");
	$fila = $iresult->fetch_array(MYSQLI_BOTH);
	extract($fila);
	if (!$area) {$area = "GEN";}
	if ($url_local) {$tipo = "b";} else {$tipo = "a";}
} else {
	$area = $_SESSION['asigna'];
	if (!$area) {$area = "GEN";}
	$_POST = array_map('ponbarra', $_POST);
	extract($_POST);
	$url = quitaurl($url);
}

// --------------------------------------------------

if ($extrae) {
	$claves  = "";
	$resumen = "";

	// Asegurar prefijo http:// o https://
	if (!preg_match('~^https?://~i', $url)) {
    	$url = 'http://' . $url;
	}

	$temp = @get_meta_tags($url) ?: [];

	if (!empty($temp['keywords'])) {
   	$claves = addslashes($temp['keywords']);
	}

	if (!empty($temp['description'])) {
    	$resumen = addslashes($temp['description']);
	}

}

if ($verif OR $anadir) {
	if ($tipo == "a") {
		$valido = valido($url,$ilink);
		$valido1 = substr(valido($url,$ilink),0,1);
		$mensaje = substr(valido($url,$ilink),1);
	} else {
		$valido1 = 1;
	}
	if ($valido1 AND $anadir) {
		if (!$selecc) {$imagenes = "";} 
		if ($tipo == "a") {
			$sql = "INSERT INTO vinculos (area, titulo, url, claves, resumen, amplia, usu_id, fechacrea1,
			 fecha1, idioma, dirimagen, sologrupotrab, engrupotrab) VALUES
	 		(\"$area\", \"$titulo\", \"$url\", \"$claves\", \"$resumen\", \"$amplia\",
	 		 \"".$_SESSION['usuid']."\", \"$fecha\",\"$fecha\", \"$idioma\", \"$imagenes\", \"$sologrupo\", \"".$_POST['grupos']."\")";
			$ilink->query($sql); $ultid = $ilink->insert_id;
			if ($ilink->errno) {die ("Error");}
		} else {
			$iresult = $ilink->query("SELECT MAX(id) FROM vinculos");
			$id = $iresult->fetch_array(MYSQLI_BOTH);
			$id = $id[0]+1;
			$sql = "INSERT INTO vinculos (area, titulo, claves, resumen, amplia, usu_id, fechacrea1,
		 	fecha1, idioma, url, dirimagen, sologrupotrab, engrupotrab) VALUES (\"$area\", \"$titulo\", \"$claves\", \"$resumen\",
		  	\"$amplia\", \"".$_SESSION['usuid']."\", \"$fecha\",\"$fecha\", \"$idioma\", \"$id\",
		   \"$imagenes\", \"$sologrupo\", \"".$_POST['grupos']."\")";
			$subirfich = subirfich($sql,$id,$ilink);
			$partes = explode('*', $subirfich, 2);
			$ultid = $partes[0];
			$mensaje = $partes[1];
		}

		$temp = gmdate('Y-m-d H:i:s');

		if($ultid) {		
			$ilink->query("INSERT INTO social (fecha,fmodif,usuid,tabla,relid, sologrupotrab, engrupotrab) VALUES 
			('$temp', '$temp', '".$_SESSION['usuid']."','vinculos','$ultid','$sologrupo',\"".$_POST['grupos']."\")");
			$mensaje = str_replace("<titulo>", quitabarra($titulo), str_replace("<url>", "<span class='rojo b' title=\"$url\">[url]</span>", str_replace("<usuario>", minom(1,0,$ilink), i("gicgracias",$ilink,$anch))))." ";
			if ($_SESSION['asigna']) {
				require_once APP_DIR . '/gic_var_num.php';
				$mensaje .= str_replace("<numvinc1>", $_SESSION['numvinc1'], str_replace( "<numvinc>", $_SESSION['numvinc'], i("gicyahay",$ilink))).".";
			}
			$titulo="";$url="";$claves="";$resumen="";$amplia="";
		}
	}
}

if ($mensaje) {
	wintot1('',$mensaje,'divxx2',i("anadir",$ilink),'',$ilink);
}

// --------------------------------------------------

if ($area != "GEN") {
	$result = $ilink->query("SELECT asignatura from podasignaturas WHERE cod = '$area'");
	$fila = $result->fetch_array(MYSQLI_BOTH);
	$area1 = $area." ".$fila[0];
} else {
	$area1 = i("gicgen",$ilink);
}

?>

<form action="http://www.google.com/search" name='f' target='_new'>
<fieldset><legend><?php echo i("buscarenint",$ilink);?></legend>
<input class='col-2' maxLength='256' size='25' name='q' value="">
<input name='hl' type='hidden' value='es'> <input type='radio' name='lr' value="" checked='checked'>
<?php echo i("busenweb",$ilink);?> 
<input type='radio' name='lr' value='lang_es' style='border:0'>
<?php echo i("busenespa",$ilink);?> 
<input type='submit' value="<?php echo i("buscongo",$ilink);?>" name='btnG'> 
<br><?php echo i("otrosbus",$ilink);?>: &nbsp; 
<a href='http://www.yahoo.es' target='_blank'>Yahoo</a> &nbsp; 
<a href='http://www.altavista.com' target='_blank'>Altavista</a> &nbsp; 
<a href='http://www.lycos.com' target='_blank'>Lycos</a></fieldset>
</form>

<form name='form1' method='post' enctype="multipart/form-data">
<fieldset><legend><?php echo i("area",$ilink);?> <?php echo $area1;?></legend>

<?php

// --------------------------------------------------

?>

<div class='fr'>
	<?php if ($mostrarimag) {require_once APP_DIR . '/imaghtml.php';}?>
</div>

<?php
echo "<input type='radio' name='tipo' value='a'";
if (!$tipo OR $tipo == 'a') {echo " checked='checked'";}
echo " onclick=\"hide('div_b');show('div_a');show('div_verif');url.focus();form1.fichup.value = ''\">";
echo i("vincaweb",$ilink); 
echo " <input type='radio' name='tipo' value='b'";
if ($tipo == 'b') {echo " checked='checked'";}
echo " onclick=\"hide('div_a');hide('div_verif');show('div_b');form1.url.value = ''\">";
echo " ".i("vincafich",$ilink);
?>
 
<br>

<div id='div_a' style='<?php if ($tipo == "b") {echo " display:none";}?>'>
	<input class='col-4' tabindex='1' type='text' size='50' maxlength='255' name='url' id='url' value="<?php echo $url;?>" autofocus> <label>* Web</label>
	<br>
	<div id='div_verif'>
		<input type='hidden' name='mostrarimag' value=<?php echo $mostrarimag;?>>
		<input type='submit' class='col-3' name='image' value=" <?php echo i("verimg",$ilink);?> " onclick="form1.mostrarimag.value=1;return verifi(form1)">
		<input type='submit' class='col-1'  name='verif' value=" <?php echo i("gicverif",$ilink);?> " onclick="return verifi(form1)"> 
		<?php
		if ($_SESSION['fabrir']) {
			echo "<input type='submit' class='col-3' name='extrae' value=\" ".i("gicextraer",$ilink)." \" onclick=\"return verifi(form1)\">&nbsp;";
		}
		?>
	</div>	
</div>

<div id='div_b' style='<?php if ($tipo == "a" OR !$tipo) {echo " display:none";}?>' class='fl col-8'>
	<input class='col-3' name='fichup' type='file'>&nbsp;*&nbsp;
	<?php echo i("vincsizip",$ilink);?> <input type='checkbox' name='unzip' checked='checked'>
	<?php echo i("vincziphtml",$ilink);?>
</div>

<p class='both'></p> 
<input class='col-4' tabindex='2' type='text' size='50' maxlength='120' name='titulo' value="<?= htmlspecialchars($titulo, ENT_QUOTES, 'UTF-8') ?>"> * <?php echo i("titulo",$ilink);?>
<br><input class='col-4' tabindex='3' type='text' size='50' maxlength='120' name='claves' value="<?= htmlspecialchars($titulo, ENT_QUOTES, 'UTF-8') ?>"> * <?php echo i("claves",$ilink);?>

<div class='both'></div>

<?php
echo "<div class='col-10 fl'>* ".i("resumen",$ilink).i("max255",$ilink)."<br><span class='peq'>";
echo str_replace("<caracteres>", "<input class='col-1' readonly='readonly' type='text' name='remLen' size='3' maxlength='3' value='255'> ", i("poner",$ilink));
?>
</span><br><textarea tabindex='4' rows='4' cols='90' name='resumen' wrap='physical' onKeyDown="textCounter(this.form.resumen,this.form.remLen,255);" onKeyUp="textCounter(this.form.resumen,this.form.remLen,255);"><?php echo $resumen;?></textarea><br>
</div>

<div class='col-3 fl peq' style='margin-left:2em;'><p></p>
<input type='radio' name='idioma' value="c" <?php if ($i == 'c'){echo "checked='checked'";}?>> <span class='b'>Castellano</span> 
<input type='radio' name='idioma' value="v" <?php if ($i == 'v'){echo "checked='checked'";}?>> <span class='b'>Valenci&agrave;</span> 
<input type='radio' name='idioma' value="i" <?php if ($i == 'i'){echo "checked='checked'";}?>> <span class='b'>English</span>
<!-- Ver en qu&eacute; grupos de la asignatura est&aacute; -->
<?php
$result = $ilink->query("SELECT grupo, asigna, usu_id, id FROM grupos LEFT JOIN gruposusu ON gruposusu.grupo_id = grupos.id 
										WHERE usu_id = '".$_SESSION['usuid']."' AND (asigna= '".$_SESSION['asigna']."' OR !asigna)");
if ($result->num_rows) {
	echo "<p></p><input type='checkbox' name='visi' checked='checked'>V&iacute;nculo visible por todos";
	while ($fila = $result->fetch_array(MYSQLI_BOTH)) {
		echo "<br><input type='radio' name='grupos' value='".$fila['id']."'>V&iacute;nculo para el grupo: <span class='b'>".$fila['grupo']."</span>";
	}
}
?>
</div>

<div class='both'></div>

<div class='col-4 fl'>
<label><?php echo i("ampliacion",$ilink);?></label><br><textarea tabindex='5' rows='4' cols='90' name='amplia'><?php echo $amplia;?></textarea>
</div>

<?php 
wintot1('',"<p class='justify interli'>".i("vincnew",$ilink)."</p>",'divxx1','help',1,$ilink);
?>

<p class='both'></p>

<input type='submit' class='col-2' value=" <?php echo i("vaciarcamp",$ilink);?> " onclick="vaciar(form1);return false">

<input tabindex='6' type='submit' class='col-2' name='anadir' value=" <?php echo i("anadir",$ilink);?> " onclick="return compruebacampos2(form1)">

<?php echo "&nbsp;<input type='button' onclick=\"show('divxx1')\" value=\"".i("quees",$ilink)."\">";?>

<div style='clear:both'></div>

</fieldset></form>
<div id='result'></div>
<?php

function quitabarra($x) {return stripslashes($x);}
function ponbarra($x) {return addslashes($x);}

function quitaurl($x) {
	$x = str_replace("http://", "", $x);
	return str_replace("https://", "", $x);

}

function valido($url,$ilink) {

	if ($_SESSION['fabrir']) {
		$f1=@safe_fopen("http://".$url,"r");
	} else {
		$f1 = 11;
	}
	if (!$f1) {
		return "0".str_replace("<usuario>", minom(1,0,$ilink), i("gicnoexiste",$ilink));
	}

	$result = $ilink->query("SELECT url, usu_id FROM vinculos WHERE url = '$url'");

	$valido = 1;

	if ($result->num_rows > 0) {

		$fila = $result->fetch_array(MYSQLI_BOTH);
		if ($fila[1]) {
			if ($_SESSION['usuid'] == $fila[1]) {
				$por  = i("timismo",$ilink);
			} else {
				$usua = ponerusu($fila[1],1,$ilink);
				$por = $usua[0].$usua[1];
			}
		} else {
			$por = ucfirst(SITE);
		}
		$mensaje = str_replace("<nombre1>", $por, str_replace("<nombre>",minom(1,0,$ilink), i("webexiste",$ilink)));
		$valido = 0;

	} else {

		$mensaje =  i("vincnoex",$ilink);
	}

	return $valido.$mensaje;

}

function subirfich($sql,$id,$ilink) {

	$dirini = DATA_DIR . "/vinculos/";
	if (!is_dir($dirini)){mkdir($dirini,0755);}
	//mirar si el tama&ntilde;o es adecuado
	if ($_FILES['fichup']['size'] > 4 * 1024 * 1024) {return "0*Demasiado grande";}
	//mirar si es un fichero no permitido:
	if (exten($_FILES['fichup']['name'])) {return "0*Extensi&oacute;n de fichero no permitida";}
	//mirar si es un fichero zip, hay que deszipear y no tiene index.html
	$ext = substr($_FILES['fichup']['name'], strrpos($_FILES['fichup']['name'],".")+1);
	if ($_POST['unzip'] AND $ext == "zip" AND !zipindex($_FILES['fichup']['tmp_name'])) {
		return "0*".i("zipno",$ilink);
	} else {
		//si no es un zip o no hay que descomprimirlo o hay que descomprimirlo
		$ilink->query($sql) or die ("Error1"); $ultid = $ilink->insert_id;
		$carpeta = "v".$id;
		if ($_POST['unzip'] AND $ext == "zip") {
			safe_mkdir($dirini.$carpeta, 0755);
			$rutaFinal = $dirini."$carpeta/".$_FILES['fichup']['name'];
			safe_move_uploaded_file($_FILES['fichup']['tmp_name'],$rutaFinal);
			chmod($rutaFinal, 0644);
			$url = DOMINIO_DATA ."/vinculos/$carpeta/".$_FILES['fichup']['name']."_files/"."index.html";
			safe_mkdir($dirini.$carpeta."/".$_FILES['fichup']['name']."_files", 0755);
			deszip("$dirini/$carpeta/".$_FILES['fichup']['name'],$ilink);
			$url_local = "2*$carpeta";
		} else {	
			$rutaFinal = $dirini."$carpeta"."_".$_FILES['fichup']['name'];
			safe_move_uploaded_file($_FILES['fichup']['tmp_name'],$rutaFinal);
			chmod($rutaFinal, 0644);
			$url = DOMINIO_DATA ."/vinculos/$carpeta"."_".$_FILES['fichup']['name'];
			$url_local = "1*$carpeta"."_".$_FILES['fichup']['name'];
		}
		$ilink->query("UPDATE vinculos SET url = \"$url\", url_local = \"$url_local\" WHERE url = '$id'");
		$mensaje = str_replace("<titulo>", quitabarra($titulo), str_replace("<url>", "<span class='rojo b' title=\"$url\">[url]</span>", str_replace("<usuario>", minom(1,0,$ilink), i("gicgracias",$ilink,$anch))))." ";
		if ($_SESSION['asigna']) {
			require_once APP_DIR . '/gic_var_num.php';
			$mensaje .= str_replace("<numvinc1>", $_SESSION['numvinc1'], str_replace( "<numvinc>", $_SESSION['numvinc'], i("gicyahay",$ilink))).".";
		}

	}
	
	return $ultid."*".$mensaje;

}

function exten($ruta) {
	$fich = substr($ruta,strrpos($ruta,"/"));
	$ext = substr($fich, strrpos($fich,".")+1);
	if ($ext == "sh" OR $ext == "php" OR $ext == "phps" OR $ext == "php2" OR $ext == "php3" OR $ext == "php4" OR $ext == "phtml" OR $ext == "asp" OR $ext == "asa"){return 1;} else {return 0;}
}

function deszip($fich,$ilink) {

	$zip = new ZipArchive;
	$zip->open($fich);
	$deszipear = 1;
	for ($i=0; $i<$zip->numFiles;$i++) {
	   $array = $zip->statIndex($i);
    	if (exten($array['name'])) {
    		$deszipear = 0;
    		return $array['name'].": ".i("extnopermi",$ilink);
		}
	}
	if ($deszipear) {
		$zip->open($fich);
		$zip->extractTo($fich."_files");
	}
	$zip->close();

}

function zipindex($fich) {

	$zip = new ZipArchive;
	$zip->open($fich);
	$index = 1;
	for ($i=0; $i<$zip->numFiles;$i++) {
	   $array = $zip->statIndex($i);
   	if ($array['name'] == "index.html") {
    		return 1;
		}
	}

}

?>