<?php

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

if (!$_SESSION['usuid'] OR ($_SESSION['tipo'] == 'E' AND $_SESSION['auto'] < 10)) {return;}

$iresult = $ilink->query("SELECT numvisitas FROM usuarios WHERE id = '$usuid' LIMIT 1");
$numvisitas = $iresult->fetch_array(MYSQLI_BOTH);
$numvisitas = $numvisitas[0];
if ($usuid != $_SESSION['usuid'] AND !$_POST['votar']) {
	$numvisitas = $numvisitas + 1;
	$ilink->query("UPDATE usuarios SET numvisitas = '$numvisitas' WHERE id = '$usuid' LIMIT 1");
}

if ($_POST['votar']) {
	$iresult = $ilink->query("SELECT sesion FROM fichavaloracion WHERE deusuid = '".$_SESSION['usuid']."' AND usuid = '$usuid' AND sesion = '".session_id()."'");
	$sesion = $iresult->fetch_array(MYSQLI_BOTH);
	if (!$sesion) {
		$ilink->query("INSERT INTO fichavaloracion (usuid, deusuid, fecha, video, ficha, sesion) VALUES ('$usuid', '".$_SESSION['usuid']."', '".gmdate("Y-m-d H:i:s")."', '".$_POST['video']."', '".$_POST['ficha']."', '".session_id()."')");
	}
}

$iresult = $ilink->query("SELECT COUNT(usuid) AS vusuid, AVG(video) AS vvideo, STDDEV(video) AS svideo FROM fichavaloracion WHERE usuid = '$usuid' AND video > 0");
$valorav = $iresult->fetch_array(MYSQLI_BOTH);
extract($valorav);
$iresult = $ilink->query("SELECT COUNT(usuid) AS fusuid, AVG(ficha) AS fficha, STDDEV(ficha) AS sficha FROM fichavaloracion WHERE usuid = '$usuid' AND ficha > 0");
$valoraf = $iresult->fetch_array(MYSQLI_BOTH);
extract($valoraf);

if ($vusuid OR $fusuid) {
	echo "";
	if ($video OR $video1) {
		echo "<span class=''>".i("valorvid",$ilink)."</span> $vusuid<br><label>Media</label>: <span class='txth '>".number_format($vvideo,2,',','.')."</span> <label>D.T.</label>: ".number_format($svideo,2,',','.')."<br>";
	}
	echo "<span class=''>".i("valorfich",$ilink)."</span> $fusuid<br><label>Media</label>: <span class='txth '> ".number_format($fficha,2,',','.')."</span> <label>D.T.</label>: ".number_format($sficha,2,',','.');
}

echo "<p></p>";

if ($usuid != $_SESSION['usuid']) {

	$iresult = $ilink->query("SELECT sesion FROM fichavaloracion WHERE deusuid = '".$_SESSION['usuid']."' AND usuid = '$usuid' AND sesion = '".session_id()."'");
	$sesion = $iresult->fetch_array(MYSQLI_BOTH);
	echo "<p class='rojo'>";
	if ($sesion) {
		echo i("yavotusu",$ilink);
	} else {
		echo "<form method='post' action='ficha.php?usuid=$usuid'>";
		if ($video OR $video1) {
			echo i("votarvid",$ilink)."
			 <select name='video'>
			<option value='1'>1
			<option value='2'>2
			<option value='3'>3
			<option value='4'>4
			<option value='5' selected = 'selected'>5
			<option value='6'>6
			<option value='7'>7
			<option value='8'>8
			<option value='8'>9
			<option value='10'>10
			</select> ";
		}
		echo " ".i("votarfich",$ilink)."
		 <select name=ficha>
		<option value='1'>1
		<option value='2'>2
		<option value='3'>3
		<option value='4'>4
		<option value='5' selected = 'selected'>5
		<option value='6'>6
		<option value='7'>7
		<option value='8'>8
		<option value='8'>9
		<option value='10'>10
		</select>
		 <input class='col-2' type='submit' name='votar' value=' >> '>
		</form>
		";
	}

	echo "<p></p>";

}

if ($_SESSION['auto'] > 4 AND ($vusuid OR $fusuid)) {

	if ($_GET['vot'] == 1) {
		wintot1("perfil/fichavotar1.php",'','div1',i("valorfich",$ilink),'',$ilink);
	}
	echo "<a href='ficha.php?usuid=$usuid&vot=1'>".i("profesores",$ilink).". ".i("agdetall",$ilink)."</a>";

}

if ($_SESSION['auto'] == 10) {
	echo "<p></p>";
	echo "<a href='soloprof/admin.php?op=3&pest=9&usu=$usuid'>".i("profesores",$ilink).". Uso del sistema</a><p></p>";
}

// ------------- solo Alumnos, votar al profesor

if($_SESSION['tipo'] != "A" OR $tipo != "P") {return;}

// ver si ese profesor lo es de la asicurgru en que estoy

if (!idesprofesor($usuid,$_SESSION['asigna'],$_SESSION['curso'],$_SESSION['grupo'],$ilink)) {return;}

$asigna= $_SESSION['asigna'];
$curso= $_SESSION['curso'];
$grupo= $_SESSION['grupo'];

// --------------------------------------------------

if($_POST['votprof']) {
	$sql = "INSERT INTO profvotar (id,deid,asicurgru,activi,materia,asist,fecha) VALUES 
						('$usuid','".$_SESSION['usuid']."','$asigna*$curso*$grupo','".$_POST['votactivi']."','".$_POST['votmateria']."','".$_POST['votasist']."','".gmdate('Y:m:d H:i:s')."')";
	$ilink->query($sql);
}

// --------------------------------------------------

$sql = "SELECT * FROM profvotar WHERE deid='".$_SESSION['usuid']."' AND id='$usuid' AND asicurgru = '$asigna*$curso*$grupo' LIMIT 1";
$result = $ilink->query($sql);
$fila = $result->fetch_array(MYSQLI_BOTH);
if($fila) {extract($fila);}

$v15 = $v25 = $v35 = "selected='selected'";

if($activi){
	$v15 = '';${'v1'.$activi}="selected='selected'";
	$v25 = '';${'v2'.$materia}="selected='selected'";
	$v35 = '';${'v3'.$asist}="selected='selected'";
	$disabled="disabled";
}

echo "<form method='post' action='ficha.php?usuid=$usuid'>";
echo "<input type='hidden' name='votprof' value='1'>";

echo i("votactivi",$ilink)."
		<select name='votactivi' $disabled>
		<option value='1' $v11>1
		<option value='2' $v12>2
		<option value='3' $v13>3
		<option value='4' $v14>4
		<option value='5' $v15>5
		<option value='6' $v16>6
		<option value='7' $v17>7
		<option value='8' $v18>8
		<option value='8' $v19>9
		<option value='10' $v110>10
		</select>";

echo "<br>".i("votmateri",$ilink)."
		<select name='votmateria' $disabled>
		<option value='1' $v21>1
		<option value='2' $v22>2
		<option value='3' $v23>3
		<option value='4' $v24>4
		<option value='5' $v25>5
		<option value='6' $v26>6
		<option value='7' $v27>7
		<option value='8' $v28>8
		<option value='8' $v29>9
		<option value='10' $v210>10
		</select>";
		
echo "<br>".i("votasisite",$ilink)."
		<select name='votasist' $disabled>
		<option value='1' $v31>1
		<option value='2' $v32>2
		<option value='3' $v33>3
		<option value='4' $v34>4
		<option value='5' $v35>5
		<option value='6' $v36>6
		<option value='7' $v37>7
		<option value='8' $v38>8
		<option value='8' $v39>9
		<option value='10' $v310>10
		</select>";
if(!$disabled) {echo " <input class='col-2' type='submit' name='votprof' value='>>'>";}
				
echo "</form>";

?>