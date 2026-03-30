<?php

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

$guop = $op;
if($script != "ficha") {$op = "";}
${'a'.$op} = "class='active'";

// --------------------------------------------------

$veo = 3;

if ($_SESSION['auto'] < 5) {
	$veo = 2;
	if ($usuid != $_SESSION['usuid']) {$veo = 1;}
}

if ($usuid == $_SESSION['usuid'] OR ($_SESSION['auto'] == 10) OR ($_SESSION['auto'] > 4 AND $autorizado < 5 AND esprofdeid($usuid,$ilink))) {
	$veocarpeta = 1;
}

$veopasswd = verpassword($usuid,$autorizado,$ilink);

// --------------------------------------------------

echo "<li><a $a1 href= '" . APP_URL . "/ficha.php?usuid=$usuid'><span class='icon-profile'></span> ".i("perfil",$ilink)."</a></li>";

if ($veopasswd) {
	echo "<li><a $a3 href='" . APP_URL . "/ficha.php?usuid=$usuid&op=3'><span class='icon-profile'></span> ".i("editar",$ilink)."</a></li>";
	echo "<li><a $a24 href='" . APP_URL . "/ficha.php?usuid=$usuid&op=24'><span class='icon-cog'></span> ".i("cambiarpass",$ilink)."</a></li>";

}

if ($usuid AND $usuid != $_SESSION['usuid']) {
	echo "<a $a4 href='" . APP_URL . "/ficha.php?usuid=$usuid&mens=1&op=4'><span class='icon-bubbles3'></span> ".i("envimens1",$ilink)."</a>";
}

if (!$usuid OR $_SESSION['usuid'] == $usuid) {
	echo "<li><a $a5 href='".APP_URL."/ficha.php?op=5'><span class='icon-cog'></span> ".i("personalizar",$ilink)."</a></li>";
}

//modificado2023 anulado siguiente if sobre  bd wp

if ($usuid == $_SESSION['usuid']) {
	$array = array();
	$array[] = "";
}

//if ($_SESSION['usuid'] != $usuid) {
	echo "<li><a $a10 href='" . APP_URL . "/ficha.php?usuid=$usuid&op=10'><span class='icon-books'></span> ".i("misasigna",$ilink)."</a></li>";
//}

if (($veo > 1 OR $usuid == $_SESSION['usuid']) ) { //AND $tipo == "A"
	if(($usuid == $_SESSION['usuid'] AND $_SESSION['tipo'] == "A") OR ($veo > 1 AND $tipo == "A")) {
		echo "<li><a $a11 href='" . APP_URL . "/ficha.php?usuid=$usuid&op=11'><span class='icon-dice'></span> ".i("miscalif",$ilink)."</a></li>";
	}
}

//if ($tipo == 'P' AND $veo > 2) {
if($veo > 2) {
	if($_SESSION['usuid'] == $usuid OR $tipo == "P") {
		echo "<li><a $a14 href='" . APP_URL . "/ficha.php?usuid=$usuid&op=14'><span class='icon-study'></span> ".i("fiacade",$ilink)."</a></li>";
	}
}

if ($usuid == $_SESSION['usuid']) {
	echo "<li><a $a15 href='" . APP_URL . "/ficha.php?op=15'><span class='icon-google'></span> Gmail</a></li>";
} else {
	echo "<li><a $a16 href='" . APP_URL . "/ficha.php?usuid=$usuid&op=16'><span class='icon-share2'></span> ".i("comparte",$ilink)."</a></li>";
}

echo "<li><a $a17 href='" . APP_URL . "/ficha.php?usuid=$usuid&op=17'><span class='icon-images'></span> ".ucfirst(i("fotos",$ilink))."</a></li>";

echo "<li><a $a18 href='" . APP_URL . "/ficha.php?op=18&usuid=$usuid'><span class='icon-users'></span> ".ucfirst(i("social",$ilink))."</a></li>";

if ($veocarpeta) { 
	echo "<li><a $a19 href='" . APP_URL . "/ficha.php?usuid=$usuid&op=19'><span class='icon-folder'></span> ".i("carpeta",$ilink)."</a></li>";
}

echo "<li><a $a20 href='" . APP_URL . "/ficha.php?usuid=$usuid&op=20'><span class='icon-hour-glass'></span> ".i("bancodet",$ilink)."</a></li>";

/*if ($veo > 2 AND $usuid == $_SESSION['usuid']) {
	echo "<li><a $a21 href='?usuid=$usuid&op=21'><span class='icon-headphones'></span> ".i("autograb",$ilink)."</a></li>";
}*/

if ($veo > 2) {
	echo "<li><a $a7 href='" . APP_URL . "/ficha.php?usuid=$usuid&op=7'><span class='icon-user-check'></span> ".ucfirst(strtolower(i("perm",$ilink)))."</a></li>";
}

if ($veo > 2) {
	echo "<li><a $a8 href='" . APP_URL . "/ficha.php?usuid=$usuid&op=8'><span class='icon-history'></span> ".i("histoenvi",$ilink)."</a></li>";
}

echo "<li><a $a9 href='" . APP_URL . "/ficha.php?usuid=$usuid&op=9'><span class='icon-flag'></span> ".i("actividad",$ilink)."</a></li>";

if($_SESSION['auto'] > 4) {
	if($usuid == $_SESSION['usuid']) {
		echo "<li><a $a23 href='" . APP_URL . "/ficha.php?usuid=$usuid&op=23'><span class='icon-pencil2'></span> ".i("anotaciones",$ilink)."</a></li>";
	} else {
		if (esprofdeid($usuid,$ilink)) { 
			echo "<li><a $a22 href='" . APP_URL . "/ficha.php?usuid=$usuid&op=22'><span class='icon-pencil2'></span> ".i("anotaciones",$ilink)."</a></li>";
		}
	}
}

$op = $guop;

// --------------------------------------------------

function verpassword($id,$autorizado,$ilink) {

//si soy yo
if($_SESSION['usuid'] == $id || !$id) {return 1;}
	
if ($_SESSION['auto'] < 5) {return;}

//Ver si puedo ver y cambiar la password del usuario $id

//Si es superadmin no puedo ver ni cambiar
if (!$_SESSION['soy_superadmin']) {return;}

//Si mi autorizaci&oacute;n es <= que la suya --> no puedo ver ni cambiar
if ($_SESSION['auto'] <= $autorizado AND !$_SESSION['soy_superadmin']) {return;}

//soy superadmi --> puedo ver y cambiar
if ($_SESSION['soy_superadmin'] AND $_SESSION['auto'] == 10) {return 1;} 

}
?>