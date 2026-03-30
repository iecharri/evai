<?php

// Copyright (c) 2000-2026 Inmaculada Echarri San Adrián
// Copyright (c) 2000-2026 Antonio Grandío Botella
// This file is part of EVAI.
// Licensed under the MIT License.
// See LICENSE.txt for details.

extract($_GET);
extract($_POST);

$texto[1] = i("calenactivi",$ilink);
if ($titasi == 2) {$texto[2] = i("plazas",$ilink);}

if ($apli) {
	echo "<span class='txth fl b'>$texto[$apli] </span>";
} else {
	echo "<br><div class='col-7' style='margin:0 2em'><ul class=''>";
	echo "<li><a href='?op=$op&apli=1&titasi=$titasi'>$texto[1]</a></li>";
	if ($titasi == 2) {
		echo "<li><a href='?op=$op&apli=2'>$texto[2]</a></li>";
	}
	echo "</ul></div>";
}

if ($apli == 1) {
	expo($pest,$titasi,$ilink);
}

if ($apli == 2 AND $titasi == 2) {
	require_once APP_DIR . '/plazas.php';
}

// --------------------------------------------------

function expo($pest,$titasi,$ilink) {

$tit = $_SESSION['tit'];
$asigna = $_SESSION['asigna'];
$grupo = $_SESSION['grupo'];
$curso = $_SESSION['curso'];

if ($titasi == 1) {
	$sufijo = "tit";
	$condi = "tit = '$tit' AND curso = '$curso'";
} else {
	$sufijo = "";
	$condi = "asigna = '$asigna' AND curso = '$curso' AND grupo = '$grupo'";
}

extract($_GET);
extract($_POST);

$minombre = minom(1,1,$ilink)." [".$_SESSION['usuid']."]";

$sql = "SELECT row_id FROM gruposexpo".$sufijo." WHERE apuntados LIKE \"%$minombre%\" AND $condi";

$result = $ilink->query($sql);
if ($result->num_rows > 0) {
	$estoyapuntado = $result->fetch_array(MYSQLI_BOTH);
	$estoyapuntado = $estoyapuntado[0];
}

if ($grupoex AND !$estoyapuntado) {
	$iresult = $ilink->query("SELECT apuntados FROM gruposexpo".$sufijo." WHERE row_id = '$grupoex'");
	$apuntados = $iresult->fetch_array(MYSQLI_BOTH);
	$apuntados = $apuntados[0];
	$apuntados .= minom(1,1,$ilink)." [".$_SESSION['usuid']."]"."$$";
	$sql = "UPDATE gruposexpo".$sufijo." SET apuntados = \"$apuntados\" WHERE row_id = '$grupoex'";
	$ilink->query($sql);

	$sql = "SELECT row_id FROM gruposexpo".$sufijo." WHERE apuntados LIKE \"%$minombre%\" AND $condi";
	$result = $ilink->query($sql);
	$estoyapuntado = "";
	if ($result->num_rows > 0) {
		$estoyapuntado = $result->fetch_array(MYSQLI_BOTH);
		$estoyapuntado = $estoyapuntado[0];
	}

}

if ($salir AND $estoyapuntado) {
	$iresult = $ilink->query("SELECT apuntados FROM gruposexpo".$sufijo." WHERE row_id = '$salir'");
	$apuntados = $iresult->fetch_array(MYSQLI_BOTH);
	$apuntados = $apuntados[0];
	$yo = minom(1,1,$ilink)." [".$_SESSION['usuid']."]"."$$";
	$apuntados = str_replace($yo,"",$apuntados);	
	$sql = "UPDATE gruposexpo".$sufijo." SET apuntados = \"$apuntados\" WHERE row_id = '$salir'";
	$ilink->query($sql);

	$sql = "SELECT row_id FROM gruposexpo".$sufijo." WHERE apuntados LIKE \"%$minombre%\" AND $condi";
	$result = $ilink->query($sql);
	$estoyapuntado = "";
	if ($result->num_rows > 0) {
		$estoyapuntado = $result->fetch_array(MYSQLI_BOTH);
		$estoyapuntado = $estoyapuntado[0];
	}
}

$sql = "SELECT * FROM gruposexpo".$sufijo." WHERE $condi";
$result = $ilink->query($sql);

if ($result->num_rows > 0) {
	$fila1 = $result->fetch_array(MYSQLI_BOTH);
	extract($fila1);
	if ($tini == "0000-00-00 00:00:00") {
		echo "<p><br> &nbsp; &nbsp; <div class='rojo b'>".i("nogruact",$ilink)."</div></p>";
		return;
	}
} else {
	echo "<p><br> &nbsp; &nbsp; <div class='rojo b'>".i("nogruact",$ilink)."</div></p>";
	return;
}

// --------------------------------------------------

$hoy = gmdate('Y-m-d H:i:s');
if ($tini < $hoy AND $tfin > $hoy) {$activo = 1;}
echo " &nbsp; <span class='b'>".$descripcion."</span>";
echo "<p></p><span class='txth'>".i("actifrom",$ilink)."</span>";
echo ifecha31($tini,$ilink);
echo "<span class='txth'>".i("actito",$ilink)."</span>";
echo ifecha31($tfin,$ilink);
echo ". Ahora est&aacute; ";
if ($activo) {
	echo "<span class='txth b'>".i("activo1",$ilink)."</span>.";
} else {
	echo "<span class='rojo b'>".i("inactivo1",$ilink)."</span>.";
}
echo "<div class='rojo center'>".i("maxpers",$ilink)."$maxusu</div>";

$result = $ilink->query($sql);
while ($fila = $result->fetch_array(MYSQLI_BOTH)) {
	extract($fila);
	if (!$titu) {
		echo "<table class='conhover'>";
		echo "<tr>";
		echo "<th>".i("grupo",$ilink)."</th>";
		echo "<th>".i("descrip",$ilink)."</th>";
		echo "<th></th>";
		echo "</tr>";
		$titu = 1;
	}
			
	echo "<tr>";
	echo "<td>$grupoexpo</td><td>$descripgrupo</td>";
	echo "<td>";
	if ($activo) {
		//ver si hay menos apuntados del m&aacute;ximo permitido por grupo
		$num = 0;
		if ($apuntados) {
			$apuntados = explode("$$",trim($apuntados));
			//$apuntados=array_unique($apuntados);
			//$apuntados = explode(":",(implode(":",$apuntados)));
			$num = count($apuntados)-1;
		}
		echo "$num apuntados";
		if (!$estoyapuntado AND $num < $maxusu) {
			echo ". <a href='?op=$op&apli=$apli&grupoex=".$fila['row_id']."'>".i("apugrupo",$ilink)."</a>.";
		} else {
			if ($estoyapuntado == $fila['row_id']) {
				echo ". <span class='txth b'>".i("estoyestegr",$ilink)."</span>.";
				echo " <a href='?op=$op&apli=$apli&salir=".$fila['row_id']."' class='rojo b'>".i("salir",$ilink)."</a>.";
			}
		}
	}
	echo "</td>";
	echo "</tr>";
}

if ($titu) {echo "</table>";}

}

?>
