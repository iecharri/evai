<?php

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

if (!$url) {return;}
$pagina = "http://".$url;

$paths = imagenesHTML($pagina);
if (empty($paths)) {return;}

$paths = conpref($paths, $pagina);
?>

<script language="JavaScript">
<!--
var viewPix = new Array(<?php
$n="";
foreach($paths as $key => $value) {
	if ($n) {echo ",";}
	$n++;
	echo "\"".str_replace("\"","",$value)."\"";
}
?>)
 
var thisImage = 0 
//document.form1.imagenes.value=0;
 
function doPast() {
if (thisImage > 0) {
thisImage--;
document.form1.imagenes.value=viewPix[thisImage];
document.myShow.src=viewPix[thisImage];
}
}
function doAfter() {
if (thisImage < <?php echo $n;?>) {
thisImage++;
document.form1.imagenes.value=viewPix[thisImage];
document.myShow.src=viewPix[thisImage];
}
}
// -->
</script>

<?php

if (!$_GET['id'] OR $_POST['mostrarimag']) {
	echo "<div id ='image' style='padding:.5em;max-width:100%'>"; //class='colu' 
	echo "<a href='javascript:doPast()' class='b'>< prev.</a> &nbsp; ";
	echo "<a href='javascript:doAfter()' class='b'>next ></a> &nbsp; ";
	echo "<br><img name='myShow' src=\"".str_replace("\"","",$paths[0])."\" style='max-width:100%' onclick='form1.imagenes.value=document.myShow.src'>";
	echo "<br><input type='checkbox' name='selecc' checked='checked'> Seleccionar imagen";
	echo "<br><input type='hidden' name='imagenes' value='".str_replace("\"","",$paths[0])."'>";
	echo "</div>";
} else {
	$temp = $fila['dirimagen'];
	if (!$temp) {$temp = str_replace("\"","",$paths[0]);} else {$check = "checked='checked'";}
	echo "<div id ='image' style='padding:.5em;max-width:100%'>"; // class='colu'
	echo "<a href='javascript:doPast()' class='b'>< prev.</a> &nbsp; ";
	echo "<a href='javascript:doAfter()' class='b'>next ></a> &nbsp; ";
	echo "<br><img name='myShow' src=\"$temp\" style='max-width:100%' onclick='form1.imagenes.value=document.myShow.src'>";
	echo "<br><input type='checkbox' name='selecc' $check> Seleccionar imagen";
	echo "<input type='hidden' name='imagenes' value='$temp'>";
	echo "</div>";
}


// --------------------------------------------------

function conpref($paths, $pagina) {
	foreach($paths as $key => $value) {
		if (preg_match('/\:\/\//', $value)) {$pref="";} else {$pref=$pagina;}
		$value = str_replace("'","",$value);
		$paths[$key] = $pref.$value;
	}
	return $paths;
}

// --------------------------------------------------

function imagenesHTML($archivo, $norepetidos = true) 
{
    /*$contenido = file($archivo);
    $contenido = array_map("trim", $contenido);
    $contenido = implode(" ", $contenido);*/

/*if (is_readable($archivo)) {
    $contenido = file($archivo); // array de líneas
    $contenido = array_map('trim', $contenido);
    $contenido = implode(' ', $contenido);
} else {
    $contenido = '';
    error_log("No se pudo leer el archivo: $archivo");
}*/

	 $contenido = is_readable($archivo) ? file_get_contents($archivo) : '';
 
    if ( preg_match_all('/<img([^<>]+)>/i', $contenido, $match) ) {
    			$pathimgs = array();
            foreach($match[1] as $atributos) {
                if ( preg_match('/src="([^"]+jpg)"/i', $atributos, $matchpaths) ) {
                    $pathimgs[] = $matchpaths[1];
                } elseif ( preg_match('/src=([^ ]+jpg)/i', $atributos, $matchpaths) ) {
                    $pathimgs[] = $matchpaths[1];        
                }
                unset($matchpaths);
            }
    }
    if ( !empty($pathimgs) ) {
        if ($norepetidos) {
            return array_unique($pathimgs);
        } else {
            return $pathimgs;
        }
    } else {
        return false;
    }
}  

?>

