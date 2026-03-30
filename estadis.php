<?php

require_once __DIR__ . '/siempre.php';
require_once APP_DIR . '/dms.php';

if(!$_SESSION['asigna']) {$usua = 1;}

// --------------------------------------------------

$titpag = "<span class='icon-stats-dots'></span> ".i("estad",$ilink);
$a_estad = " class = 'active'";

require_once APP_DIR . '/molde_top.php';

require_once APP_DIR . '/estadis_funcis.php';

// --------------------------------------------------

$asigna = $_SESSION['asigna'];
$curso = $_SESSION['curso'];
$grupo = $_SESSION['grupo'];

// --------------------------------------------------

$onclick = "return confirm('La actualización tardará dependiendo del número de registros...')";

unset($array);

$array[0] = "<a href='estadis.php'>$titpag <span class='icon-arrow-right'></span></a>";

if($usua AND $_SESSION['soy_superadmin']) {
	//$temp = " <a title= \"".i('actuestad',$ilink)."\" href='estadis.php?actu=1&usua=$usua' onclick = \"return confirm('La actualización tardará dependiendo del número de registros...')\">
	//			 <span class='icon-redo2'></span></a>";
} elseif(!$usua AND $_SESSION['auto'] > 4) {
	$array[1] = " <a class='nowrap' title= \"".i('actuestad',$ilink)."\" href='estadis.php?actu=1&usua=$usua'><span class='icon-redo2'></span></a>";
}

if($_SESSION['asigna']) {
	if($usua) {
		$array[2] = "<a href='estadis.php'>".i("grtittod",$ilink)."</a>";
	} else {
		$array[2] = "<a href='estadis.php?usua=1'>$asigna $curso $grupo</a>";
	}
}

solapah($array,1,"navhsimple");

$nohayfechas = fromto($asigna,$curso,$grupo,$ilink);

if ($nohayfechas == 1) {
	echo "Selecciona un rango de fechas";return;exit;	
}



//ver si los alumnos pueden ver las notas
$iresult = $ilink->query("SELECT verlistanota FROM cursasigru WHERE asigna = '$asigna' AND curso = '$curso' AND grupo = '$grupo'");
$vernota = $iresult->fetch_array(MYSQLI_BOTH);
if ((!$vernota[0] AND $_SESSION['auto'] < 5) OR $usua) {$vernota = "";}

// --------------------------------------------------

if($actu) {

	if ($usua) {

		$ilink->query("DELETE FROM tempoestadis WHERE asigna=''");

		$temp = "INSERT IGNORE INTO tempoestadis (id) SELECT usuarios.id FROM usuarios WHERE autorizado > 1 AND fechabaja = '0000-00-00 00:00:00'";
		$ilink->query($temp);

		actualizar('','','','',$ilink);
		
	} else {

		$ilink->query("DELETE FROM tempoestadis WHERE asigna='$asigna' AND curso='$curso' AND grupo='$grupo'");	
		
		$temp = "INSERT IGNORE INTO tempoestadis (id,asigna,curso,grupo) SELECT  usuarios.id,asigna,curso,grupo FROM usuarios LEFT JOIN alumasiano ON usuarios.id = alumasiano.id 
				WHERE autorizado > 1 AND fechabaja = '0000-00-00 00:00:00' AND alumasiano.asigna = '$asigna' AND alumasiano.curso = '$curso' AND alumasiano.grupo = '$grupo'";
		$ilink->query($temp);
		
		$temp = "INSERT IGNORE INTO tempoestadis (id,asigna,curso,grupo) SELECT usuarios.id,asigna,curso,grupo FROM usuarios LEFT JOIN asignatprof ON usuarios.id = asignatprof.usuid 
				WHERE	autorizado > 1 AND fechabaja = '0000-00-00 00:00:00' AND asignatprof.asigna= '$asigna' AND asignatprof.curso= '$curso' AND asignatprof.grupo= '$grupo'";
		$ilink->query($temp);
		
		actualizar('',$asigna,$curso,$grupo,$ilink);

	}

}

// --------------------------------------------------

$campos = "tempoestadis.id,tempoestadis.tacumulado,tempoestadis.ultiacceso,tempoestadis.numvalorfich,tempoestadis.mediafich,tempoestadis.desvtipfic,tempoestadis.numvalorvid,
				tempoestadis.mediavid,tempoestadis.desvtipvid,tempoestadis.numvisitas,
				tempoestadis.numvinc,tempoestadis.coment,tempoestadis.numvincvot,tempoestadis.notaemi,tempoestadis.desvtipemi,tempoestadis.numvotrec,tempoestadis.nota,tempoestadis.desvtip,
				forowri,forochar,forovrec,fororecmed,fororecds,forovemi,foroemimed,foroemids,ultimetarea,notatot,aprobado";

if(!$usua) {
	$sql = "SELECT $campos FROM tempoestadis LEFT JOIN usuarios ON usuarios.id = tempoestadis.id WHERE asigna='$asigna' AND curso='$curso' AND grupo='$grupo' GROUP BY tempoestadis.id";
} else {
	$sql = "SELECT $campos FROM tempoestadis LEFT JOIN usuarios ON usuarios.id = tempoestadis.id WHERE asigna='' AND curso='' AND grupo=''"; //GROUP BY tempoestadis.id"; 
}

$result = $ilink->query($sql);

if ($result->num_rows < 1) {
		echo "<p></p><br><span class='mediana rojo b'>".i("nodatos",$ilink)."</span>";
		return;
}

$conta = $_GET['conta'];

if (!$_GET['conta']) {$conta = 1;}

$numpag = 50;

$numvinculos = $result->num_rows;

pagina($numvinculos,$conta,$numpag,i("usuarios",$ilink),"ord=$ord&usua=$usua",$ilink);

echo " <span class='peq nob'>los valores de las columnas en <span class='rojo'>rojo</span> dependen del rango de fechas elegido por el Profesor</span>";

// --------------------------------------------------

echo "<table class='conhover peq'>";

echo "<tr>";
echo "<th rowspan='2'><a href='?pest=$pest&usua=$usua'>".ucfirst(i("nombre",$ilink))."</a></th>";
echo "<th rowspan='2'><a href='?pest=$pest&ord=1&usua=$usua' class='rojo'>".i("enlinea1",$ilink)."</a>
		<br><a href='?pest=$pest&ord=2&usua=$usua' class='rojo'>".i("ultiacces",$ilink)."</a>
		<br><a href='?pest=$pest&ord=10&usua=$usua'>".i("visirecu",$ilink)."</a>
		</th>";
if(!$usua) {echo "<th rowspan='2'><a href='?pest=$pest&ord=20'>Tarea</a></th>";}
if($vernota) {echo "<th rowspan='2'><a href='?pest=$pest&ord=21' class='rojo'>".i("nota",$ilink)."</a></th>";}
echo "<th colspan='2' class='rojo'>Votos ficha</th>";
echo "<th colspan='2' class='rojo'>Votos vídeo</th>";
echo "<th colspan='4' class='rojo'>".i("vinculos",$ilink)."</th>";
echo "<th colspan='6'>".i("foro",$ilink);
if(!$usua) {echo " $asigna $curso $grupo";}
echo "</th>";

echo "</tr>";

echo "<tr><th><a href='?pest=$pest&ord=3&usua=$usua' class='rojo'>n</a></th>";
echo "<th class='nowrap'><a href='?pest=$pest&ord=4&usua=$usua' class='rojo'>M</a> / <a href='?pest=$pest&ord=5&usua=$usua' class='rojo'>DS</a></th>";
echo "<th><a href='?pest=$pest&ord=6&usua=$usua' class='rojo'>n</a></th>";
echo "<th><a href='?pest=$pest&ord=7&usua=$usua' class='rojo'>M</a> / <a href='?pest=$pest&ord=8&usua=$usua' class='rojo'>DS</a></th>";

echo "<th><a href='?pest=$pest&ord=10&usua=$usua' class='rojo'>n</a></th>";
echo "<th><a href='?pest=$pest&ord=11&usua=$usua' class='rojo'>M</a> / <a href='?pest=$pest&ord=12&usua=$usua' class='rojo'>DS</a></th>";
echo "<th><a href='?pest=$pest&ord=13&usua=$usua' class='rojo'>votados</a></th>";
echo "<th><a href='?pest=$pest&ord=9&usua=$usua' class='rojo'>".i("comentarios",$ilink)."</a></th>";

echo "<th><a href='?pest=$pest&ord=14&usua=$usua'>n</a></th>";
echo "<th><a href='?pest=$pest&ord=15&usua=$usua'>chars</a></th>";
echo "<th><a href='?pest=$pest&ord=16&usua=$usua'>".lcfirst(i("votos",$ilink))."</a></th>";
echo "<th><a href='?pest=$pest&ord=17&usua=$usua'>M / DS</a></th>";

if($_SESSION['auto'] > 4) {
	echo "<th><a href='?pest=$pest&ord=18&usua=$usua'>".i("ajenos",$ilink)."</a></th>";
	echo "<th><a href='?pest=$pest&ord=19&usua=$usua'>M / DS</a></th>";
}

echo "</tr>";

if(!$ord) {$sql .= " ORDER BY alumnoa, alumnon";}
if ($ord == 1) {$sql .= " ORDER BY tacumulado DESC";}
if ($ord == 2) {$sql .= " ORDER BY ultiacceso DESC";}
if ($ord == 3) {$sql .= " ORDER BY numvalorfich DESC";}
if ($ord == 4) {$sql .= " ORDER BY mediafich DESC, numvalorfich DESC";}
if ($ord == 5) {$sql .= " ORDER BY desvtipfic DESC";}
if ($ord == 6) {$sql .= " ORDER BY numvalorvid DESC";}
if ($ord == 7) {$sql .= " ORDER BY mediavid DESC, numvalorvid DESC";}
if ($ord == 8) {$sql .= " ORDER BY desvtipvid DESC";}
if ($ord == 9) {$sql .= " ORDER BY coment DESC";}
if ($ord == 10) {$sql .= " ORDER BY numvinc DESC";}
if ($ord == 11) {$sql .= " ORDER BY nota DESC, numvinc DESC";}
if ($ord == 12) {$sql .= " ORDER BY desvtip DESC";}
if ($ord == 13) {$sql .= " ORDER BY numvincvot DESC";}
if ($ord == 14) {$sql .= " ORDER BY forowri DESC";}
if ($ord == 15) {$sql .= " ORDER BY forochar DESC";}
if ($ord == 16) {$sql .= " ORDER BY forovrec DESC";}
if ($ord == 17) {$sql .= " ORDER BY fororecmed DESC,forovrec DESC";}
if ($ord == 18) {$sql .= " ORDER BY forovemi DESC";}
if ($ord == 19) {$sql .= " ORDER BY foroemimed DESC";}
if ($ord == 20) {$sql .= " ORDER BY ultimetarea ASC";}
if ($ord == 21 AND $vernota) {$sql .= " ORDER BY notatot DESC";}

$sql .= " LIMIT ".($conta-1).", $numpag";
$result = $ilink->query($sql);

if (!$ord OR $ord == 1 OR $ord == 2 OR $ord == 5 OR $ord == 8 OR $ord == 12 OR $conta > 50 OR $ord == 20) {$medallas = 5;} else {$medallas = 1;}

while ($filax = $result->fetch_array(MYSQLI_BOTH)) {
	
	extract($filax);
	
	if(!$numvalorfich) {$numvalorfich = "";}
	if(!$numvalorvid) {$numvalorvid = "";}
	if(!$mediafich) {$mediafich = "";}
	if($desvtipfic == 0) {$desvtipfic = "";}
	if($nota == 0) {$nota = "";}
	if($desvtip == 0) {$desvtip = "";}
	
	if(!$coment) {$coment = "";}
	if(!$numvincvot) {$numvincvot = "";}
	if(!$numvinc) {$numvinc = "";}
	
	if(!$forowri) {$forowri = "";}
	if(!$forochar) {$forochar = "";}
	if(!$forovrec) {$forovrec = "";}
	if(!$forovemi) {$forovemi = "";}
	if($ultimetarea == "0000-00-00 00:00:00") {$ultimetarea = "";}
	if($notatot == 0) {$notatot = "";}
	
	echo "<tr>";
	
	echo "<td>";
	if ($medallas == 1) {
		echo "<img class='fl' src='".MEDIA_URL."/imag/oro.png' title=\"".i("medoro",$ilink)."\">\n";
	}
	if ($medallas == 2) {
		echo "<img class='fl' src='".MEDIA_URL."/imag/plata.png' title=\"".i("medplata",$ilink)."\">\n";
	}
	if ($medallas == 3) {
		echo "<img class='fl' src='".MEDIA_URL."/imag/bronce.png' title=\"".i("medbronce",$ilink)."\">\n";
	}
	$medallas = $medallas+1;
	$usu = ponerusu($id,1,$ilink);
	echo $usu[0].$usu[1];
	echo "</td>";
	
	echo "<td class='nowrap'>";
	echo dms($tacumulado);
	echo "<br>";
	if($ultiacceso != "0000-00-00 00:00:00") {echo ifecha31($ultiacceso,$ilink);}
	echo "<br>".$numvisitas;
	echo "</td>";

	if(!$usua) {echo "<td class='nowrap'>".ifecha31($ultimetarea,$ilink)."</td>";}
	if($vernota) {
		$temp = "";
		if($aprobado == "2") {$temp = "rojo";}
		echo "<td class='nowrap $temp'>".$notatot."</td>";
	}
	
	echo "<td class='nowrap'>$numvalorfich</td>";
	echo "<td class='nowrap'>";
	if($mediafich > 0) {echo number_format($mediafich,2,',','.');} 
	if($mediafich > 0 OR $desvtipfic > 0) {echo " / ";}
	if($desvtipfic > 0) {echo number_format($desvtipfic,2,',','.');} 
	echo "</td>";
	echo "<td class='nowrap'>$numvalorvid</td>";
	echo "<td class='nowrap'>"; 
	if($mediavid > 0) {echo number_format($mediavid,2,',','.');} 
	if($mediavid > 0 OR $desvtipvid > 0) {echo " / ";}
	if($desvtipvid > 0) {echo number_format($desvtipvid,2,',','.');}
	echo "</td>";

	echo "<td class='nowrap'>$numvinc</td>";
	echo "<td class='nowrap'>";
	if($nota) {echo "$nota / $desvtip";}
	echo "</td>";
	echo "<td class='nowrap'>".$numvincvot;
	if($numvincvot) {echo " / ".$notaemi;}
	echo "</td>";
	echo "<td class='nowrap'>$coment</td>";

	echo "<td class='nowrap'>$forowri</td>";
	echo "<td class='nowrap ri'>".$forochar."</td>";
	echo "<td class='nowrap'>$forovrec</td>";
	echo "<td class='nowrap'>";
	if($fororecmed > 0) {echo $fororecmed;}
	if($fororecmed > 0 OR $fororecds > 0) { echo "/";}
	if($fororecds > 0) {echo $fororecds;}
	echo "</td>";
	
	if($_SESSION['auto'] > 4) {
		
		echo "<td class='nowrap'>$forovemi</td>";
		echo "<td class='nowrap'>";
		if($foroemimed > 0) {echo $foroemimed;}
		if($foroemimed > 0 OR $foroemids > 0) { echo "/";}
		if($foroemids > 0) {echo $foroemids;}
		echo "</td>";

	}
	
	echo "</tr>";
	
}

echo "</table>";

pagina($numvinculos,$conta,$numpag,i("usuarios",$ilink),"ord=$ord&usua=$usua",$ilink);

require_once APP_DIR .  "/molde_bott.php";	

?>
