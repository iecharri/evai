<?php

// Copyright (c) 2000-2026 Inmaculada Echarri San Adrián
// Copyright (c) 2000-2026 Antonio Grandío Botella
// This file is part of EVAI.
// Licensed under the MIT License.
// See LICENSE.txt for details.

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

if (!$pest) {return;}

if (!$_POST['env']){$n = '0';} else {$n = $_POST['n'];}

$sql = "SELECT DISTINCT (vinculos.id), votos, usuarios.id FROM votos LEFT JOIN vinculos ON vinculos.id = votos.vinculo_id LEFT JOIN usuarios ON usuarios.id =  vinculos.usu_id WHERE votos.usu_id = '$usuid' AND votos > 0";
$alu = $usuid;

$result1 = $ilink->query($sql);

while($fila1 = $result1->fetch_array(MYSQLI_BOTH)) {

	$aalu = $fila1['id'];

	$tabla[$alu][$aalu][0] = $tabla[$alu][$aalu][0] + 1;
	$tabla[$alu][$aalu][1] = $tabla[$alu][$aalu][1] + $fila1['votos'];

}


$sql = "SELECT vinculos.id, votos, usuarios.id FROM vinculos LEFT JOIN votos ON vinculos.id = votos.vinculo_id LEFT JOIN usuarios ON usuarios.id =  votos.usu_id WHERE vinculos.usu_id = '$usuid' AND votos.votos > 0";

$result1 = $ilink->query($sql);
	
while($fila1 = $result1->fetch_array(MYSQLI_BOTH)) {

	$dealu = $fila1['id'];

	$tabla[$dealu][$alu][0] = $tabla[$dealu][$alu][0] + 1;
	$tabla[$dealu][$alu][1] = $tabla[$dealu][$alu][1] + $fila1['votos'];

}

echo "<form name='form' method='post'>Se contrastan m&aacute;s de 
<input class='col-1' type='text' name='n' size='3' maxlength='3' value='$n'> votos emitidos y recibidos 
<input class='col-1' type='submit' name='env' value='>>'></form>";

if (sizeof($tabla)) {

echo "<p></p><table class='conhover'>";

echo "<tr><th>usuario</th><th>Emitidos a<br>(votos / nota)</th><th>Recibidos de<br>(votos / nota)</th></tr>
";

foreach($tabla as $clave=>$valor){
	foreach($valor as $clave1=>$valor1){
		if ($clave = $alu AND $clave1 != $alu){
			echo "<tr><td>";
			$usu = ponerusu($clave1,1,$ilink);
			echo $usu[0].$usu[1];
			echo "</td><td>".$valor1[0]." / ".number_format(($valor1[1]/$valor1[0]),2,',','.')."</td><td>";
			if ($valor1[0] > $n AND $tabla[$clave1][$alu][0] > $n){echo $tabla[$clave1][$alu][0]." /  ".number_format(($tabla[$clave1][$alu][1]/$tabla[$clave1][$alu][0]),2,',','.');
			$tabla[$clave1][$alu][1] = ''; $tabla[$clave1][$alu][0] = '';
			}
			echo "</td></tr>";
		}
	}
}

echo "<tr><td colspan=3>&nbsp;</td></tr>";$m=($n+1);
foreach($tabla as $clave=>$valor){
	if ($clave != $alu) {
		foreach($valor as $clave1=>$valor1){
			if ($valor1[0]){
				echo "<tr><td>";
				$usu = ponerusu($clave,1,$ilink);
				echo $usu[0].$usu[1];
				echo "</td><td>&nbsp;</td><td>$valor1[0] / ".number_format(($valor1[1]/$valor1[0]),2,',','.')."</td></tr>";
			}
		}
	}
}

echo "</table>";

} else {

	echo "<p></p>".i("noseenc",$ilink);

}

?>
