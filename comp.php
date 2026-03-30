<?php

require_once __DIR__ . "/siempre.php";

require_once APP_DIR . "/perfil/socialmgnmg.php";
	
// --------------------------------------------------

if($comp) {
	$num = $comp ;
} 

$a_comp = " class = 'active'";
require_once APP_DIR . "/molde_top.php";

$titpag = "<span class='icon-share2'></span> ".i("compartir",$ilink);

unset($array);

$array[0] = "<a href='comp.php'>$titpag <span class='icon-arrow-right' ></span></a>";
$array[1] = "<a href='?comp=1'>".i("vinculo",$ilink)."</a>";
$array[2] = "<a href='?comp=2'>".i("foto",$ilink)."</a>";
$array[3] = "<a href='?comp=3'>".i("comentario",$ilink)."</a>";
solapah($array,$num+1,"navhsimple")."</a>";

echo "<a href='ficha.php?op=18' class='rojo b peq'>".i("sigueaot",$ilink)."</a><p></p>";

if ($usuid == $yo) {
	if($_POST) {
		require_once APP_DIR . "/perfil/compartir.php";
		$mensaje = compartir($_POST,$usuid,$ilink);
		if($mensaje) {
			echo $mensaje;
			require_once APP_DIR . "/molde_bott.php";
			return;
		}
	} else {
		if($comp == 1) {
			pidevinc($ilink);
		} elseif($comp == 2) {
			pidefoto($imgloader,$ilink);
		} elseif($comp == 3) {
			pidecoment();
		}
		if($comp) {
			require_once APP_DIR . "/molde_bott.php";
			return;
		}
	}
}	

// --------------------------------------------------

$sql = "SELECT DISTINCT tit, cursasigru.asigna, cursasigru.curso, grupo FROM cursasigru LEFT JOIN podcursoasignatit ON 
			cursasigru.asigna = podcursoasignatit.asigna AND cursasigru.curso = podcursoasignatit.curso WHERE tit IS NOT NULL AND 
			(cursasigru.curso = '' OR cursasigru.curso > 1999)
			ORDER BY curso DESC,asigna,grupo";
$result = $ilink->query($sql);

$cadmisasig = cadmisasig($ilink);

require_once APP_DIR . "/perfil/accionesfp.php";
require_once APP_DIR . "/perfil/social.php";
require_once APP_DIR . "/molde_bott.php";

// --------------------------------------------------

function pidevinc($ilink) {
	echo "<form method='post' action='?comp=1' name='comp'>";
	echo "<input class='col-5' type='text' size='70' maxlength='255' name='url' placeholder='http://' value='http://'>";
	echo "<br><input class='col-5' type='text' size='70' maxlength='255' name='resumen' placeholder=\"".i("escribecom",$ilink)."\">"; // onblur='this.value=\"$mens_resumen\"'
	echo "<br><input class='col-1' type='submit' value=' >> '>";
	echo "</form>";
}

function pidefoto($imgloader,$ilink) {
	echo "<form method='post' action='?comp=2' name='comp' enctype='multipart/form-data'>";
	echo "<br><input type='file' name='foto' class='col-2'>";
	echo " <span id='ocultar'><input class='col-1' type='submit' name='submifoto' value=' >> ' onclick=\"hide('ocultar');show('esperar')\"></span>";
	echo " <span id='esperar' style='display:none'>$imgloader".i("esperar",$ilink)."</span>";
	echo "</form>";
}

function pidecoment() {
	echo "<form method='post' action='?comp=3' name='comp'>";
	echo "<br><input class='col-8' type='text' size='70' maxlength='255' name='comentario' onfocus=\"this.value=''\">"; // onblur='this.value=\"$mens_coment\"'
	echo " &nbsp; <input class='col-1' type='submit' value=' >> '>";
	echo "</form>";
}

?>
