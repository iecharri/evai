<?php

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

if (!function_exists('comidoble')) {function comidoble($x) {return str_replace("\"", "&#34;", $x);}}

if($_GET['id']) {$id = $_GET['id'];}
if($_POST['id']) {$id = $_POST['id'];}

if (!$id) {return;}

$sql = "SELECT vinculos.area, titulo, url, claves, resumen, amplia, usuarios.usuario,usu_id, vinculos.idioma, url_local, dirimagen, sologrupotrab, engrupotrab FROM vinculos
	LEFT JOIN usuarios ON usuarios.id = usu_id WHERE vinculos.id = '$id' LIMIT 1";

$result = $ilink->query($sql);

$fila = $result->num_rows;

if ($fila == 0) {
	echo "<p></p><center><span class='b'><p></p><br>".i("yanovinc",$ilink)."</span></center>";
	return;
}

$fila = $result->fetch_array(MYSQLI_BOTH);

if ($fila['usu_id'] != $_SESSION['usuid'] AND $_SESSION['auto'] < 10) {return;}

if ($_SESSION['fabrir']) {

	if ($_SESSION['fabrir']) {
    	$roto = esRoto($urledit);
	} else {
   	 $roto = 0; // 
	}

// Asegurar URL con http:// o https://
$url = $fila['url'];
if (!preg_match('~^https?://~i', $url)) {
    $url = 'http://' . $url;
}

// Obtener meta tags
$temp = @get_meta_tags($url) ?: [];

// Recoger con seguridad
$cla  = isset($temp['keywords'])    ? addslashes($temp['keywords'])    : '';
$resu = isset($temp['description']) ? addslashes($temp['description']) : '';
	
}

echo "<form name='form1' method='post'>\n";

echo "<div class='fr col-4'><p></p>"; //style='width:180px;height:100%'  style='max-width:25%'
$url = $fila['url']; require_once APP_DIR . '/imaghtml.php';
echo "</div>";

$asigna = $fila['area'];
$uid = $fila['usu_id'];
$i = $fila['idioma'];

if ($_SESSION['auto'] < 10 OR $uid != $_SESSION['usuid']) {
	$sql = "SELECT asigna, asignatura FROM usuasi LEFT JOIN podasignaturas
		ON usuasi.asigna = podasignaturas.cod WHERE id='$uid' ORDER BY asignatura";
	$result = $ilink->query($sql);
} else {
	$result = $ilink->query("SELECT cod, asignatura FROM podasignaturas ORDER BY asignatura");
}

echo "<select class='col-6' name='area'>";

while ($asig = $result->fetch_array(MYSQLI_BOTH)) {

	if ($_SESSION['auto'] < 10  OR $uid != $_SESSION['usuid']) {
		echo "<option value = '".$asig['asigna']."'";
		if ($asig['asigna'] == $asigna) {echo " selected = 'selected'";}
		echo ">".$asig['asigna']." - ".substr($asig['asignatura'],0,40)."...";
	} else {
		echo "<option value = '".$asig['cod']."'";
		if ($asig['cod'] == $asigna) {echo " selected = 'selected'";}
		echo ">".$asig['cod']." - ".substr($asig['asignatura'],0,40)."...";
	}

}

echo "</select>";
echo " <label>* ".i("area",$ilink)."</label>\n";

echo "<br><input class='col-6' type='text' size='35' maxsize='120' name='tituloedit' value=\"".comidoble($fila['titulo'])."\"> <label>* ".i("titulo",$ilink)."</label>\n";

echo "<br><input class='col-6' type='text' size='35' maxsize='255' name='urledit' value=\"".$fila['url']."\"";
if ($fila['url_local']) {echo " readonly='readonly'";}
echo "> <label>* Web</label>\n";
echo "<br><input type='hidden' name='mostrarimag' value=\"$mostrarimag\">";
echo "<input type='submit' class='col-4' name='image' value=\"".i("verimg",$ilink)."\" onclick='form1.mostrarimag.value=1;return confirmasiborrar(form1)'>";

echo "<br><label>* ".i("claves",$ilink)."</label><br>
		<input class='col-6' type='text' size='33' maxsize='255' name='clavesedit' value=\"".comidoble($fila['claves'])."\">\n";

echo "<br><label>* ".i("resumen",$ilink)."</label>\n";

echo "<br><textarea class='col-6' rows='4' cols='50' name='resumenedit'>\n";
echo ltrim(rtrim($fila['resumen']))."</textarea>\n";

echo "<br><label>".i("ampliacion",$ilink)."</label>\n";

echo "<br><textarea class='col-6' rows='4' cols='50' name='ampliaedit'>";
echo ltrim(rtrim($fila['amplia']))."</textarea>\n";

?>

<p></p>
<input type='radio' name='idioma' value="c" <?php if ($i == 'c'){echo "checked='checked'";}?>> <label>Castellano</label> &nbsp; &nbsp; &nbsp; &nbsp; 
<input type='radio' name='idioma' value="v" <?php if ($i == 'v'){echo "checked='checked'";}?>> <label>Valenci&agrave;</label> &nbsp; &nbsp; &nbsp; &nbsp; 
<input type='radio' name='idioma' value="i" <?php if ($i == 'i'){echo "checked='checked'";}?>> <label>English</label>

<?php
$result1 = $ilink->query("SELECT grupo, asigna, usu_id, id FROM grupos LEFT JOIN gruposusu ON gruposusu.grupo_id = grupos.id WHERE 
			(asigna = '".$_SESSION['asigna']."' OR !asigna) AND usu_id = '".$_SESSION['usuid']."'");
if ($result->num_rows) {
	if ($fila['engrupotrab']) {
		echo "<p></p><input type='checkbox' name='visi'";
		if (!$fila['sologrupotrab']) {echo " checked='checked'";}
		echo "> V&iacute;nculo visible por todos<br>";
	}
	//por si lo est&aacute; editando un administrador y no es suyo
	if ($fila['usu_id'] != $_SESSION['usuid']) {
		$result2 = $ilink->query("SELECT grupo FROM grupos WHERE id = \"".$fila['engrupotrab']."\" LIMIT 1");
		$fila2 = $result2->fetch_array(MYSQLI_BOTH);
		echo "<br><input type='radio' name='grupos' value='".$fila['engrupotrab']."' checked = 'checked'>";
		echo " V&iacute;nculo para el grupo: ".$fila2['grupo'];
	} else {
		while ($fila1 = $result1->fetch_array(MYSQLI_BOTH)) {
			echo "<br><input type='radio' name='grupos' value='".$fila1['id']."'";
			if ($fila['engrupotrab'] == $fila1['id']) {echo " checked = 'checked'";}
			echo "> V&iacute;nculo para el grupo: ".$fila1['grupo'];
		}
		echo "<br>";
	}
}

if ($fila['usu_id'] == $uid OR $_SESSION['auto'] == 10) {


	if ($_SESSION['fabrir']) {
		echo "<div class='col-4 rojo'>".i("claresupg1",$ilink)."</div>";
		echo "<input class='col-4' type='button' name='extrae' onclick=\"claresu('$cla', '$resu')\" value=\"".i('gicextraer',$ilink)."\"> &nbsp; &nbsp; ";
	}
	echo "<span class='rojo'>".i("borrvinc",$ilink)."</span> <input type='checkbox' name='borrarvinc'>\n";
	echo " &nbsp; &nbsp; <input type='submit' class='col-2' name='editar' value=".i("aceptar",$ilink)." onclick='return confirmasiborrar(form1)'>\n";
}

echo "</form><p></p>";

// --------------------------------------------------



// --------------------------------------------------

function esRoto($url) {
    // Aseguramos que tiene esquema
    if (!preg_match('~^[a-z]+://~i', $url)) {
        $url = "http://" . $url;
    }

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_NOBODY, true);      // Solo cabeceras
    curl_setopt($ch, CURLOPT_TIMEOUT, 5);        // Timeout
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_MAXREDIRS, 3);
    curl_exec($ch);
    $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    return ($code >= 200 && $code < 400) ? 0 : 1;
}

?>

<script language="Javascript">

function confirmasiborrar(form1) {

var temp = ''

   if (form1.borrarvinc.checked == true) {

			return confirm("<?php echo i("vincborrar",$ilink);?>")

   }

   if (form1.tituloedit.value == "" || form1.urledit.value == "" || form1.clavesedit.value == "" || form1.resumenedit.value == "") {

		alert("<?php echo i("completaas",$ilink);?>")
		form1.tituloedit.focus()
		return false

   }	

	splitstring = form1.urledit.value.split("http://");
	for(i = 0; i < splitstring.length; i++)
	temp += splitstring[i];
	form1.urledit.value = temp;

}

function claresu(cla, resu) {

    const f = document.forms['form1']; 
    if (!f) return false;

    f.elements['clavesedit'].value  = cla ?? '';
    f.elements['resumenedit'].value = resu ?? '';

}

</script>
