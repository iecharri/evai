<?php

require_once __DIR__ . '/siempre.php';

// --------------------------------------------------

$tit = $_SESSION['tit'];
$asigna = $_SESSION['asigna'];
$curso = $_SESSION['curso'];
$grupo = $_SESSION['grupo'];
$ordenn = " ORDER BY usuarios.alumnon, usuarios.alumnoa ";
$ordena = " ORDER BY usuarios.alumnoa, usuarios.alumnon ";
$ordenr = " ORDER BY RAND() ";

if ($_GET['titul']) {
	$sqlprof = "SELECT DISTINCT usuarios.id, autorizado, privacidad FROM asignatprof LEFT JOIN podcursoasignatit
		ON asignatprof.asigna = podcursoasignatit.asigna AND asignatprof.curso = podcursoasignatit.curso
		LEFT JOIN usuarios ON asignatprof.usuid = usuarios.id
		WHERE autorizado > 1 AND fechabaja = '0000-00-00 00:00:00' AND podcursoasignatit.tit = '$tit'
		AND asignatprof.curso = '$curso' AND usuarios.id > 0";
	$sqlalu = "SELECT DISTINCT usuarios.id, autorizado, privacidad FROM alumasiano LEFT JOIN podcursoasignatit
		ON alumasiano.asigna = podcursoasignatit.asigna AND alumasiano.curso = podcursoasignatit.curso
		LEFT JOIN usuarios ON alumasiano.id = usuarios.id
		WHERE auto > 1 AND autorizado > 1 AND fechabaja = '0000-00-00 00:00:00'
		AND podcursoasignatit.tit = '$tit' AND alumasiano.curso = '$curso'";
	$pest = 1;} else {
	$sqlprof = "SELECT DISTINCT usuarios.id, autorizado, privacidad FROM asignatprof LEFT JOIN usuarios ON asignatprof.usuid = usuarios.id WHERE autorizado > 1 AND fechabaja = '0000-00-00 00:00:00' AND asigna = '$asigna' AND curso = '$curso' AND grupo = '$grupo' AND usuarios.id > 0";
	$sqlalu = "SELECT DISTINCT usuarios.id, auto, autorizado, privacidad FROM alumasiano LEFT JOIN usuarios ON alumasiano.id = usuarios.id WHERE auto > 1 AND autorizado > 1 AND fechabaja = '0000-00-00 00:00:00' AND asigna = '$asigna' AND curso = '$curso' AND grupo = '$grupo'";
	$pest = 2;
}

// --------------------------------------------------

$titpag = "<span class='icon-man-woman'></span> ".i("orla",$ilink);
$a_orla = " class = 'active'";

require_once APP_DIR . '/molde_top.php';

$array[0] = "<a href='fotoscurso.php'>$titpag <span class='icon-arrow-right'></span>";
$array[1] = "<a href='?titul=1'> $tit $curso</a>";
$array[2] = "<a href='?'> $asigna $curso $grupo</a>";

// --------------------------------------------------

solapah($array,$pest+1,"navhsimple");

if ($_GET['list']) {$templ = "class='b'";}
if($_GET['r']) {$tempr = "class='b'";}
		
echo "<span class='noimprimir'>[<a $templ href='?titul=".$_GET['titul']."&list=1'>".i("lista",$ilink)."</a>] ";
echo "[<a $tempr href='?titul=".$_GET['titul']."&r=1'>".i("random",$ilink)."</a>]</span> ";

// --------------------------------------------------

if ($_GET['list']) {
	$result = $ilink->query($sqlprof.$ordena);	if ($result->num_rows) {
		if ($_SESSION['auto'] > 4) {
			$fichtxt = "p".gmdate("ymd-his")."UTC.txt";
			$fich = " txt file <a href='filetemp.php?fich=$fichtxt'><span class='icon-file-text'></span></a>";
		}
		echo "<p><h2>".i("profesores",$ilink)." ".$fich."</h2>";
		listorla($result,$ilink,$fichtxt);
	}
	//echo "<div class='both'></div>";
	$result = $ilink->query($sqlalu.$ordena);
	if ($result->num_rows) {
		if ($_SESSION['auto'] > 4) {
			$fichtxt = "a".gmdate("ymd-his")."UTC.txt";
			$fich = " txt file <a href='filetemp.php?fich=$fichtxt'><span class='icon-file-text'></span></a>";
		}
		echo "<h2>".i("alumnos",$ilink)." ".$fich."</h2>";
		listorla($result,$ilink,$fichtxt);
		echo "</p>";
	}

} elseif($_GET['r']) {

	$result = $ilink->query($sqlprof.$ordenr);
	echo "<p><h2>".i("profesores",$ilink)."</h2>"; //." [<a href='?titul=".$_GET['titul']."&list=1'>List</a>]</h2>";
	if ($result->num_rows) {thumbr($result,$ilink);}
	$result = $ilink->query($sqlalu.$ordenr);
	echo "<div class='fl col-10'>";
	echo "<h2>".i("alumnos",$ilink)."</h2>"; //." [<a href='?titul=".$_GET['titul']."&list=1'>List</a>]</h2>";
	if ($result->num_rows) {thumbr($result,$ilink);}
	echo "</p></div>";

} else {
	
	$result = $ilink->query($sqlprof.$ordenn);
	echo "<p><h2>".i("profesores",$ilink)."</h2>"; //." [<a href='?titul=".$_GET['titul']."&list=1'>List</a>]</h2>";
	if ($result->num_rows) {thumb($result,$ilink);}
	$result = $ilink->query($sqlalu.$ordenn);
	echo "<div class='fl col-10'>";
	echo "<h2>".i("alumnos",$ilink)."</h2>"; //." [<a href='?titul=".$_GET['titul']."&list=1'>List</a>]</h2>";
	if ($result->num_rows) {thumb($result,$ilink);}
	echo "</p></div>";
	
}

require_once APP_DIR .  "/molde_bott.php";

// --------------------------------------------------

function listorla($result,$ilink,$fichtxt) {
	
	$timestamp = time(); 
	if ($_SESSION['auto'] > 4) {$arch = safe_fopen(DATA_DIR ."/temp/".$fichtxt,"w+");}

	while ($fila = $result->fetch_array(MYSQLI_BOTH)) {
		extract($fila);
		if (!$id) {continue;}
		
		$usu = ponerusu($fila['id'],2,$ilink);
   	echo $usu[0].$usu[1]."<div class='both'></div><span class='estoy peq u'>$usu[2]</span>";	

		if ($privacidad AND $autorizado >= $_SESSION['auto'] AND $_SESSION['auto'] < 10) {continue;}

		//$iresult = $ilink->query("SELECT mail, callto, callto1, direccion, codpos, localidad, provincia, pais, alumnon, fecha, $timestamp-UNIX_TIMESTAMP(fecha) AS fechax, estado, alumnoa FROM usuarios WHERE id = '$id' LIMIT 1");
		//$f = $iresult->fetch_array(MYSQLI_BOTH);
		//extract($f);

		$iresult = $ilink->query("SELECT mail, callto, callto1, direccion, codpos, localidad, provincia, pais, alumnon, fecha, estado, alumnoa FROM usuarios WHERE id = '$id' LIMIT 1");

		$f = $iresult->fetch_array(MYSQLI_BOTH);

		// Calcular fechax en PHP (UTC)
		$f['fechax'] = time() - strtotime($f['fecha']);

		extract($f);

		if ($_SESSION['auto'] > 4) {
			fputs($arch,$alumnoa.", ".$alumnon."\t".$mail."\t".$direccion."\t".$codpos."\t".$localidad."\t".$provincia."\t".$pais);
			fputs($arch,"\n");
		}
		echo "<br>Mail: ".$mail;
		echo "<br>".i("direccion",$ilink).": $codpos $localidad $pais";
		if (!$callto1 OR !$callto) {
			echo "<p><br></p>";
			continue;
		}

		if ($fechax < 30 AND $fecha){$enlinea=1;}
		if ($enlinea==1 AND $estado > 0) {
			if ($_SESSION['auto'] < $autorizado AND $id != $_SESSION['usuid'] AND $_SESSION['auto'] < 10) {
				$enlinea=0;
			}
		}
		if (demo_enabled() && in_array((int)$id, DEMO_ONLINE_IDS, true)) {$enlinea = 1;}
		echo "<br>Conf. ";
		if ($enlinea) {
			echo "<a href=callto:$callto onmouseover=\"window.status='".i("lanzar",$ilink)." $alumnon'; return true\">
			<span class='icon-video-camera grande' title=\"".i("lanzar",$ilink)." $alumnon\"></span></a> ".$callto;
		} else {
			echo "<span class='icon-video-camera grande'></span> ".$callto;
		}
		echo "<p><br></p>";
	}
	
  if ($_SESSION['auto'] > 4) {fclose($arch);}
  
}

// --------------------------------------------------

function thumbr($result,$ilink) {
	
	?><div class="usuarios--fotos"><?php
	
	while ($fila = $result->fetch_array(MYSQLI_BOTH)) {
		$usu = ponerusu($fila['id'],2,$ilink);
		echo $usu[0];
	}
	
	?></div><?php
	
}

// --------------------------------------------------

function thumb($result,$ilink) {
	
?><div class="usuarios--fila"><?php
	 
	while ($fila = $result->fetch_array(MYSQLI_BOTH)) {
		$usu = ponerusu($fila['id'],2,$ilink);
		?><div class="fila-usuario">
 	 		<div class="foto"><?php
 	 			echo $usu[0];?>	
 			</div>
			<div class="datos"><?php 	
				echo $usu[1]."<br> &nbsp;<span class='estoy peq u'>$usu[2]</span>";?>
			</div>
		</div>
<?php
		
	}
	
?></div><?php

}

?>
