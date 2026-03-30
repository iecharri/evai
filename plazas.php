<?php

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

if ($subm) {
	$filtro = "WHERE convenio = '$conv' AND alumno = '".$_SESSION['usuid']."'";
	if (!$plaza[$conv]) {
		$ilink->query("DELETE FROM convsolicitudes $filtro");
	} else {
		$sql = "SELECT * FROM convsolicitudes $filtro";
		$result = $ilink->query($sql);
		if ($result->num_rows) {
			$ilink->query("UPDATE convsolicitudes SET preferencia = '".$plaza[$conv]."' $filtro"); 
		} else {
			$ilink->query("INSERT INTO convsolicitudes (convenio, alumno, preferencia)
			 VALUES ('$conv', '".$_SESSION['usuid']."', '".$plaza[$conv]."')");
		}
	}
}

// --------------------------------------------------

if ($ampli) {
	echo " &nbsp; [<a href='?op=$op&apli=$apli'>Volver al listado de plazas</a>]<p></p>";
	verampli($ampli,$ilink);
	return;
}

// --------------------------------------------------

$sql = "SELECT DISTINCT(pais) FROM convenios LEFT JOIN conventid ON
 convenios.entidad = conventid.n 
 WHERE asigna = '$asigna' AND curso = '$curso' AND grupo = '$grupo'
 ORDER BY pais, plazadescrip";
 
$result = $ilink->query($sql);

echo " &nbsp; <form method='post' action='?op=$op&apli=$apli'><select name='entipais'><option value=''> -- ".i("pais",$ilink)." -- </option>";

while ($fila = $result->fetch_array(MYSQLI_BOTH)) {
	echo "<option value='$fila[0]'";
	if ($_POST['entipais'] == $fila[0]) {echo " selected = 'selected'";}
	echo ">$fila[0]</option>";	
	
	
}
echo "</select> <input class='col-1' type='submit' value=' >> ' name='entipaisselect'></form>";

// --------------------------------------------------

$sql = "SELECT *, convenios.n AS nx FROM convenios LEFT JOIN conventid ON
 convenios.entidad = conventid.n 
 WHERE asigna = '$asigna' AND curso = '$curso' AND grupo = '$grupo'";

if ($_POST['entipais']) {$sql .= "AND pais = '".$_POST['entipais']."'";}
 
 $sql .= " ORDER BY pais, plazadescrip";
 
$result = $ilink->query($sql);

if (!$result) {return;}

echo "<table class='padded-table fl mr5 conhover'>";

echo "<tr>";
echo "<th class='col-4'>".i("plentidad",$ilink)."</th>";
echo "<th class='col-01'>".i("plazas",$ilink)."</th>";
echo "<th>".i("pldescrip",$ilink)."</th>";
echo "<th class='col-01 nowrap'>".i("plde1a3",$ilink)."</th>";
echo "</tr>";

while ($fila = $result->fetch_array(MYSQLI_BOTH)) {
	extract($fila);
	if ((!$visible OR !$ofertado) AND $_SESSION['auto'] < 5) {continue;}
	$result1 = $ilink->query("SELECT preferencia, aceptada, tutorid FROM convsolicitudes WHERE convenio = '$nx' AND alumno = '".$_SESSION['usuid']."'");
	$preferencia = "";
	if ($result1->num_rows) {
		$preferencia = $result1->fetch_array(MYSQLI_BOTH);
	}
	echo "<tr>";
	echo "<td><span class='b'>$nombre</span><br>Localizaci&oacute;n de la Entidad: <span class='txth'>$localidad</span>"; //$pais
	echo "<br>Pa&iacute;ses de actuaci&oacute;n: <span class='b'>$paisactu</span>";
	if (!$visible AND $_SESSION['auto'] > 4) {echo "<br><span class='fr rojo b'>Plaza no visible por los alumnos</span>";}
	if (!$ofertado AND $_SESSION['auto'] > 4) {
		echo "<br><span class='fr rojo b'>Plaza no ofertada por la Entidad</span>";
	}
	echo "<br><a href='?op=$op&apli=$apli&ampli=$nx' class='fr txth b'>Ver detalle</a>";
	echo "</td>";
	echo "<td>$numplazas<br>$tipplaza</td>";
	echo "<td>".nl2br($plazadescrip);
	echo "</td>";
	echo "<td class='center'>";
	echo "<form action='?op=$op&apli=$apli' method='post'>";
	$disabled = "";
	if ($preferencia[1]) {$disabled = "disabled = 'disabled'";}
	echo "<input type='radio' name='plaza[$nx]' value='0' $disabled";
	if (!$preferencia[0]) {echo " checked='checked'";}
	echo "> 0 &nbsp; ";
	echo "<input type='radio' name='plaza[$nx]' value='1' $disabled";
	if ($preferencia[0] == 1) {echo " checked='checked'";}
	echo "> 1 &nbsp; ";
	echo "<input type='radio' name='plaza[$nx]' value='2' $disabled";
	if ($preferencia[0] == 2) {echo " checked='checked'";}
	echo "> 2 &nbsp; ";
	echo "<input type='radio' name='plaza[$nx]' value='3' $disabled";
	if ($preferencia[0] == 3) {echo " checked='checked'";}
	echo "> 3 &nbsp; ";
	echo "<input type='hidden' name='conv' value='$nx'>";
	if (!$preferencia[1]) {
		echo "<br><input type='submit' name='subm' value=' >> '>";
	}
	echo "<input type='hidden' name='entipais' value='".$_POST['entipais']."'>";
	echo "</form>";
	if ($preferencia[2] AND $preferencia[1]){
		echo "<p class='both'></p>Tutor&iacute;a<br>";
		$usu = ponerusu($preferencia[2],1,$ilink);
		echo $usu[0].$usu[1];
	}
	echo "</td>";
	echo "</tr>";
}

echo "</table>";

// --------------------------------------------------

function verampli($plaza,$ilink) {
	require_once APP_DIR . "/soloprof/soloprofaplic21.php";
	$mensaje = campos($plaza, '', '', '', 0,0,$ilink);
	echo $mensaje;

}

?>