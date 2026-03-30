<?php

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

$sql = "SELECT * FROM alumasiano WHERE id = '$usuid' ORDER BY curso DESC, asigna ASC, grupo ASC";
$result = $ilink->query($sql);

if (!$result->num_rows) {return;}

if ($script == "calificaciones") {$sinlink = 1;}


echo "<table>";

while ($fila = $result->fetch_array(MYSQLI_BOTH)) {
	extract($fila);
	if ($ano != $curso) {
		echo "<tr><th class='center' colspan='20'>$curso</th></tr>"; //22
		$ano = $curso;
		$asigru = "";
	}
	if ($asigru != $asigna."$$".$grupo) {
		//ver si el alumno ve las notas, e indicarlo al lado de la asignatura
		
		$notasvermens = notasvermens($asigna,$curso,$grupo,$ilink); // [0] =0 -> no ve; [0] > 0 -> ve ... [1]: motivo
		
		echo "<tr class='whit'><td class='center' colspan='20'>$asigna $grupo $notasvermens[1]</td></tr>"; //22
		$asigru = $asigna."$$".$grupo;
	}
	$iresult = $ilink->query("SELECT textos, coefi FROM cursasigru WHERE asigna = '$asigna'
	 				AND curso = '$curso' AND grupo = '$grupo'");
	$fila1 = $iresult->fetch_array(MYSQLI_BOTH);
	$textos = explode("*",$fila1[0]);
	$concoefi = $fila1[1];
	$colspan = 5; if($concoefi) {$colspan = 5;}
	
$iresult = $ilink->query("SELECT tipasig FROM podcursoasigna WHERE asigna = '$asigna' AND curso='$curso'");
$tipo = $iresult->fetch_array(MYSQLI_BOTH);

$OJ_color = $OF_color = $EJ_color = $ES_color = ""; $colus = "*";$n = "";
if ($tipo['tipasig'] == 1) {$OF_color=" class=1";$EJ_color=" class=1";$ES_color=" class=1";}
if ($tipo['tipasig'] == 2) {$OF_color=" class=1";$ES_color=" class=1";}
if ($tipo['tipasig'] == 3) {$OJ_color=" class=1";$ES_color=" class=1";}
	
	
	echo "<td class='col-2 center' colspan='$colspan'>"; if($OJ_color) {echo $textos[5];$colus[1]=1;} echo "</td>";
	echo "<td class='col-2 center' colspan='$colspan'>"; if($OF_color) {echo $textos[6];$colus[2]=2;} echo "</td>";
	echo "<td class='col-2 center' colspan='$colspan'>"; if($EJ_color) {echo $textos[7];$colus[3]=3;} echo "</td>";
	echo "<td class='col-2 center' colspan='$colspan'>"; if($ES_color) {echo $textos[8];$colus[4]=4;} echo "</td>";
	//echo "<td class='col-2 center' colspan='4'>&uacute;nica</td>";
	echo "</tr>";
	echo "<tr>";
	
	for($i = 1; $i <= 4; $i++) {
		if ($concoefi) {
			echo "<td class='center'>"; if($colus[$i] == $i) {echo $textos[0];$n="*";} echo "</td>";
			echo "<td class='center'>"; if($colus[$i] == $i) {echo $textos[1];$n="*";} echo "</td>";
			echo "<td class='center'>"; if($colus[$i] == $i) {echo $textos[2];$n="*";} echo "</td>";
			echo "<td class='center'>"; if($colus[$i] == $i) {echo $textos[3];$n="*";} echo "</td>";
			echo "<td class='center'>"; if($colus[$i] == $i) {echo $textos[4];} echo "</td>";
		} else {
			echo "<td class='center' colspan='5'>"; if($colus[$i] == $i) {echo $textos[4];} echo "</td>";
		}
	}
	echo "</tr>";
	echo "<tr>";
	bloque($usuid,$concoefi,$asigna,$curso,$grupo,'OJ',$notasvermens[0],$sinlink,$ilink);
	bloque($usuid,$concoefi,$asigna,$curso,$grupo,'OF',$notasvermens[0],$sinlink,$ilink);
	bloque($usuid,$concoefi,$asigna,$curso,$grupo,'EJ',$notasvermens[0],$sinlink,$ilink);
	bloque($usuid,$concoefi,$asigna,$curso,$grupo,'ES',$notasvermens[0],$sinlink,$ilink);
	//bloque($usuid,$concoefi,$asigna,$curso,$grupo,'',$notasvermens[0],$sinlink,$ilink);
	echo "</tr>";
}

echo "</table>";

// --------------------------------------------------

function bloque($usuid,$concoefi,$asigna,$curso,$grupo,$conv,$notasvermens,$sinlink,$ilink) {
	$nota = nota($usuid,$concoefi,$asigna,$curso,$grupo,$conv,$ilink);
	if ($nota) {$class=' caja2';}
	if (!$notasvermens) {unset($nota);}
	if ($nota[0] == "0,00") {$nota[0] = "";}
	if ($nota[1] == "0,00") {$nota[1] = "";}
	if ($nota[2] == "0,00") {$nota[2] = "";} 
	if ($nota[3] == "0,00") {$nota[3] = "";} 
	if ($nota[4] == "0,00") {$nota[4] = "";} 
	if (esprofesor($asigna,$curso,$grupo,$ilink)) {
		extract($_GET);
		if ($conv) {$conv .= "_";}
		if (!$sinlink) {
			$pre1 = "<a href='?pest=2&op=$op&usuid=$usuid&asigna=$asigna&curso=$curso&grupo=$grupo&conv=$conv'>";
			$pre2 = "</a>";
		}
		if ($pre1 AND !$nota[4] AND $class) {$nota[4] = "<span class='icon-pencil'></span>";}
	}
	if (!$concoefi) {
		echo "<td class='col-2 center$class' colspan='5' style='height:2em'>";
		echo $pre1.$nota[4].$pre2;
		echo "</td>";
	} else {
		echo "<td class='col-1 center$class'>";echo $nota[0]; echo "</td>";
		echo "<td class='col-1 center$class'>";echo $nota[1]; echo "</td>";
		echo "<td class='col-1 center$class'>";echo $nota[2]; echo "</td>";
		echo "<td class='col-1 center$class'>";echo $nota[3]; echo "</td>";
		echo "<td class='col-1 center$class'>";echo $pre1.$nota[4].$pre2; echo "</td>";
	}
}

// --------------------------------------------------

function nota($usuid,$concoefi,$asigna,$curso,$grupo,$conv,$ilink) {
	$iresult = $ilink->query("SELECT tipasig FROM podcursoasigna WHERE asigna = '$asigna' 
	AND curso='$curso'");
	$tipo = $iresult->fetch_array(MYSQLI_BOTH);
	$tipo = $tipo[0];
	if ($conv == "OF" AND $tipo AND $tipo < 3) {return nota1($usuid,$concoefi,$asigna,$curso,$grupo,'OF',$ilink);}
	if ($conv == "EJ" AND $tipo == 1) {return nota1($usuid,$concoefi,$asigna,$curso,$grupo,'EJ',$ilink);}
	if ($conv == "ES" AND $tipo) {return nota1($usuid,$concoefi,$asigna,$curso,$grupo,'ES',$ilink);}
	if ($conv == "OJ" AND $tipo == 3) {return nota1($usuid,$concoefi,$asigna,$curso,$grupo,'OJ',$ilink);}
	if ($conv == "" AND !$tipo) {return nota1($usuid,$concoefi,$asigna,$curso,$grupo,'',$ilink);}
}

// --------------------------------------------------

function nota1($usuid,$concoefi,$asigna,$curso,$grupo,$conv,$ilink) {
	$f = formula($asigna,$curso,$grupo,$ilink);
	$esprofesor = esprofesor($asigna,$curso,$grupo,$ilink);
	if (!$esprofesor) {$esprofesor = soyadmiano($asigna,$curso,$ilink);} 
	$test1 = $f[0];
	$preg1 = $f[1];
	$prac1 = $f[2];
	$eval1 = $f[3];
	//$alu1 = $f[3];
	//$pro1 = $f[4];
	//$mintest1 = $f[5];
	//$minpreg1 = $f[6];
	//$minprac1 = $f[7];
	//$divisor1 = $f[8];	
	if ($conv) {$conv = $conv."_";}
	$sql = "SELECT $conv"."nota1, $conv"."notprofp, $conv"."test, $conv"."preg, $conv"."prac, $conv"."eval, $conv"."total, $conv"."aprobado 
	FROM alumasiano WHERE id = '$usuid' AND asigna = '$asigna' AND curso = '$curso' AND grupo = '$grupo'";
	$result = $ilink->query($sql);
	$fila = $result->fetch_array(MYSQLI_BOTH);
	extract($fila);
	$ret[0] = number_format($fila[$conv.'test']*$test1,2,',','.');
	$ret[1] = number_format($fila[$conv.'preg']*$preg1,2,',','.');
	$ret[2] = number_format($fila[$conv.'prac']*$prac1,2,',','.');
	$ret[3] = number_format($fila[$conv.'eval']*$eval1,2,',','.');
	$temp = number_format($fila[$conv.'total'],2,',','.');
	if ($temp != "0,00") {
		$tiponota = "<br>".tiponota($temp,$fila[$conv.'aprobado'],$ilink);
	}
	if ($esprofesor OR $fila[$conv.'aprobado'] != 2) {
		$ret[4] = $temp;
	}
	$ret[4] = $ret[4].$tiponota;

	return $ret;
}

// --------------------------------------------------

function tiponota($nota,$aprobado,$ilink) {
	if ($nota < 5) {$mensaje = "<span class='rojo'>".i("suspenso",$ilink)."</span>";}
	if ($nota >= 5 AND $nota < 7) {$mensaje = "<span class='verdecalific'>".i("aprobado",$ilink)."</span>";}
	if ($nota >= 7 AND $nota < 9) {$mensaje = "<span class='verdecalific b'>".i("notable",$ilink)."</span>";}
	if ($nota >= 9) {$mensaje = "<span class='verdecalific u'>".i("sobresaliente",$ilink)."</span>";}
	if ($aprobado == 2) {$mensaje = "<span class='rojo'>".i("suspensodesc",$ilink)."</span>";}
	return $mensaje;
}

?>