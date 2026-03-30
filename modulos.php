<?php

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

if($_SESSION['auto'] < 5) {return;}

echo "Administrador de ".$tit."<p></p>";

echo "Media de las notas de las asignaturas de código que comience por $asigna"." y el código no sea $asigna.<p></p>";

echo "<a href='?op=2&cop=1' onclick='return confirm(\"".i("aceptar",$ilink)."\")'>Click para copiar estas notas en $asigna $curso $grupo</a>.<p></p>";

$sql1 = " WHERE alumasiano.asigna = '$asigna' AND auto > 1 AND autorizado > 1";
$sql1 .= " AND fechabaja = '0000-00-00 00:00:00'";
if ($curso) {$sql1 .= " AND alumasiano.curso = '".$curso."'";} else {$sql1 .= " AND alumasiano.curso = ''";}
if ($grupo) {$sql1 .= " AND alumasiano.grupo = '".$grupo."'";} else {$sql1 .= " AND alumasiano.grupo = ''";}

$sqlhay = "SELECT *, usuarios.id FROM alumasiano LEFT JOIN usuarios ON usuarios.id = alumasiano.id".$sql1." ORDER BY alumnoa, alumnon";

$iresult = $ilink->query($sqlhay);
if ($iresult->num_rows == 0 OR !existe($asigna,$curso,$grupo,$ilink)) {
	$nohaydatos = 1;
	echo "<center><p></p><span class='rojo b'>No se encontraron datos</span></center>";
	require_once APP_DIR .  "/molde_bott.php";
	exit;
}


$result = $ilink->query($sqlhay);

$numvinculos = $result->num_rows;

$conta = $_GET['conta'];
if (!$_GET['conta']) {$conta = 1;}

if ($_SESSION['pda']) {$numpag = 5;} else {$numpag = 50;}
pagina($numvinculos,$conta,$numpag,i("usuarios",$ilink),"op=$op",$ilink);

$result = $ilink->query($sqlhay." LIMIT ".($conta-1).", $numpag");


$iresult = $ilink->query("SELECT tipasig FROM podcursoasigna WHERE asigna = '$asigna' AND curso='$curso'");
$tipo = $iresult->fetch_array(MYSQLI_BOTH);
$iresult = $ilink->query("SELECT coefi,textos FROM cursasigru WHERE asigna = '$asigna' AND curso = '$curso' AND grupo = '$grupo'");
$concoefi = $iresult->fetch_array(MYSQLI_BOTH);
if (!$concoefi[1]) {
	$textos = "Test*Preguntas*Pr&aacute;cticas*Evaluación*Total*OJ*OF*EJ*ES";
	$ilink->query("UPDATE cursasigru SET textos = '$textos' WHERE asigna = '$asigna' AND curso = '$curso' AND grupo = '$grupo'");
	$concoefi[1] = $textos;
}

$iresult = $ilink->query("SELECT tipasig FROM podcursoasigna WHERE asigna = '$asigna' AND curso='$curso'");
$tipo = $iresult->fetch_array(MYSQLI_BOTH);


if ($tipo['tipasig'] == 1) {$OF_color=" class=1";$EJ_color=" class=1";$ES_color=" class=1";}
if ($tipo['tipasig'] == 2) {$OF_color=" class=1";$ES_color=" class=1";}
if ($tipo['tipasig'] == 3) {$OJ_color=" class=1";$ES_color=" class=1";}

echo "<br><table class='conhover'>";

$textos = explode("*",$concoefi[1]);

echo "<tr><th>".i("nombre",$ilink)."</th>";

if ($OJ_color) {echo "<th>$textos[5]</th>";}
if ($OF_color) {echo "<th>$textos[6]</th>";}
if ($EJ_color) {echo "<th>$textos[7]</th>";}
if ($ES_color) {echo "<th>$textos[8]</th>";}
if (!$tipo['tipasig']) {echo "<th colspan='6'></th>";}

echo "</tr>";

while ($fila = $result->fetch_array(MYSQLI_BOTH)) {

	echo "<tr>";
	if ($n == 0) {$n = 1;}else {$n = 0;}

	echo "<td>";

	if($_SESSION['auto'] > 4 OR $fila['id'] == $_SESSION['usuid']) {
		$usu = ponerusu($fila['id'],1,$ilink);	
		echo $usu[0].$usu[1];
	} else {
		echo $fila['dni'];
	}
	
	echo "</td>";
	



	if ($OJ_color) {
		echo "<td align='right'>";
		$temp = $ilink->query("SELECT ROUND(AVG(OJ_total),2) FROM alumasiano WHERE id='".$fila['id']."' AND curso='$curso' and asigna LIKE '$asigna"."%' and asigna != '$asigna'");
		$temp1 = $temp->fetch_array(MYSQLI_BOTH); 
		if($temp1[0] != 0) {echo $temp1[0];}
		if($cop==1) {
			$copiar = "UPDATE alumasiano SET OJ_nota1=0, OJ_fecha_nota='".gmdate('Y-m-d H:i:s')."', OJ_notprofp=0, OJ_test=0, OJ_preg=0, OJ_prac=0, OJ_eval=0,OJ_total='$temp1[0]', OJ_aprobado='' WHERE id='".$fila['id']."' AND curso='$curso' and asigna = '$asigna'";
			$ilink->query($copiar);
		}
		echo "</td>";
	}
	if ($OF_color) {
		echo "<td align='right'>";
		$temp = $ilink->query("SELECT ROUND(AVG(OF_total),2) FROM alumasiano WHERE id='".$fila['id']."' AND curso='$curso' and asigna LIKE '$asigna"."%' and asigna != '$asigna'");
		$temp1 = $temp->fetch_array(MYSQLI_BOTH); 
		if($temp1[0] != 0) {echo $temp1[0];}
		if($cop==1) {
			$copiar = "UPDATE alumasiano SET OF_nota1=0, OF_fecha_nota='".gmdate('Y-m-d H:i:s')."', OF_notprofp=0, OF_test=0, OF_preg=0, OF_prac=0, OF_eval=0,OF_total='$temp1[0]', OF_aprobado='' WHERE id='".$fila['id']."' AND curso='$curso' and asigna = '$asigna'";
			$ilink->query($copiar);
		}
		echo "</td>";
	}
	if ($EJ_color) {
		echo "<td align='right'>";
		$temp = $ilink->query("SELECT ROUND(AVG(EJ_total),2) FROM alumasiano WHERE id='".$fila['id']."' AND curso='$curso' and asigna LIKE '$asigna"."%' and asigna != '$asigna'");
		$temp1 = $temp->fetch_array(MYSQLI_BOTH); 
		if($temp1[0] != 0) {echo $temp1[0];}
		echo "</td>";
		if($cop==1) {
			$copiar = "UPDATE alumasiano SET EJ_nota1=0, EJ_fecha_nota='".gmdate('Y-m-d H:i:s')."', EJ_notprofp=0, EJ_test=0, EJ_preg=0, EJ_prac=0, EJ_eval=0,EJ_total='$temp1[0]', EJ_aprobado='' WHERE id='".$fila['id']."' AND curso='$curso' and asigna = '$asigna'";
			$ilink->query($copiar);
		}
	}
	if ($ES_color) {
		echo "<td align='right'>";
		$temp = $ilink->query("SELECT ROUND(AVG(ES_total),2) FROM alumasiano WHERE id='".$fila['id']."' AND curso='$curso' and asigna LIKE '$asigna"."%' and asigna != '$asigna'");
		$temp1 = $temp->fetch_array(MYSQLI_BOTH); 
		if($temp1[0] != 0) {echo $temp1[0];}
		echo "</td>";
		if($cop==1) {
			$copiar = "UPDATE alumasiano SET ES_nota1=0, ES_fecha_nota='".gmdate('Y-m-d H:i:s')."', ES_notprofp=0, ES_test=0, ES_preg=0, ES_prac=0, ES_eval=0,ES_total='$temp1[0]', ES_aprobado='' WHERE id='".$fila['id']."' AND curso='$curso' and asigna = '$asigna'";
			$ilink->query($copiar);
		}
	}
	if (!$tipo['tipasig']) {
		echo "<td align='right'>";
		$temp = $ilink->query("SELECT ROUND(AVG(total),2) FROM alumasiano WHERE id='".$fila['id']."' AND curso='$curso' and asigna LIKE '$asigna"."%' and asigna != '$asigna'");
		$temp1 = $temp->fetch_array(MYSQLI_BOTH); 
		if($temp1[0] != 0) {echo $temp1[0];}
		if($cop==1) {
			$copiar = "UPDATE alumasiano SET nota1=0, fecha_nota='".gmdate('Y-m-d H:i:s')."', notprofp=0, test=0, preg=0, prac=0, eval=0,total='$temp1[0]', aprobado='' WHERE id='".$fila['id']."' AND curso='$curso' and asigna = '$asigna'";
			$ilink->query($copiar);
		}
		echo "</td>";
	}


echo "</tr>";

}

echo "</table><br>\n";

pagina($numvinculos,$conta,$numpag,i("usuarios",$ilink),"op=$op",$ilink);







?>