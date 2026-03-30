<?php

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

function i($x,$ilink,$anch='') {
	if (!$x) {return;}
	$i = $_SESSION['i'];
	if (!$i) {$i = 'c';}
	$w = $ilink->query("SELECT $i FROM idioma WHERE m='$x'");
	if ($w->num_rows < 1) {return;}
	$iresult = $ilink->query("SELECT $i FROM idioma WHERE m='$x'");
	$w = $iresult->fetch_array(MYSQLI_BOTH);
	if (!$anch) {$anch = ucfirst(SITE);}
	return stripslashes(nl2br(str_replace("<site>", $anch, $w[0])));
}


function i1($x,$i,$ilink) {  //se usa

	if (!$i) {$i = 'c';}
	$iresult = $ilink->query("SELECT $i FROM idioma WHERE m='$x'");
	$w = $iresult->fetch_array(MYSQLI_BOTH);
	return stripslashes(nl2br(str_replace("<site>", ucfirst(SITE), $w[0])));

}

?>