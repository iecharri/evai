<?php

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

function tit0($unacolmas, $c1, $c2, $c3, $c4, $c5) {

	echo "<tr>";
	if ($unacolmas) {echo "<th></th>";}
	echo "<th colspan='6'>$c1</th>";
	echo "<th colspan='6'>$c2</th>";
	echo "<th colspan='6'>$c3</th>";
	echo "<th colspan='6'>$c4</th>";
	echo "<th colspan='6'>$c5</th>";
	echo "</tr>";

}

function tit($connombre, $conv, $esprofesor, $concoefi, $textos) {

	$ancho = "style='width:4%'";
	if ($connombre) {$ancho = "style='width:3%'";}
	if (!$conv OR !$concoefi) {
		echo "<th $ancho>&nbsp;</th><th $ancho>&nbsp;</th><th $ancho>&nbsp;</th><th $ancho>&nbsp;</th><th $ancho>$textos[4]</th>
		<th $ancho>&nbsp;</th>";
		return;
	}
	echo "<th $ancho>$textos[0]</th>";
	echo "<th $ancho>$textos[1]</th>";
	echo "<th $ancho>$textos[2]</th>";
	echo "<th $ancho>$textos[3]</th>";
	echo "<th $ancho>$textos[4]</th>";
	echo "<th $ancho></th>";

}

function notas($conv,$fila,$f,$esprofesor,$target,$concoefi,$ilink) {

	if (!$conv) {echo "<td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>"; return;}
	if ($conv == "*") {$conv = "";}
	$target = " target='$target'";
	if (!$concoefi) {
		echo "<td></td><td></td><td></td><td></td>";
	} else {
		echo "<td align='right'>&nbsp;";
		if ($fila[$conv.'test'] != 0) { echo number_format($fila[$conv.'test']*$f[0],2,',','.');}
		echo "</td><td align='right'>&nbsp;";
		if ($fila[$conv.'preg'] != 0) { echo number_format($fila[$conv.'preg']*$f[1],2,',','.');}
		echo "</td><td align='right'>&nbsp;";
		if ($fila[$conv.'prac'] != 0) { echo number_format($fila[$conv.'prac']*$f[2],2,',','.');}
		echo "</td><td align='right'>&nbsp;";
		if ($fila[$conv.'eval'] != 0) { echo number_format($fila[$conv.'eval']*$f[3],2,',','.');}
		echo "</td>\n";
	}
	echo "<td align='right'>";
	if ($esprofesor AND !$noponernotas) {
		echo "<a title='cambiar nota' href='ficha.php?asigna=".$fila['asigna']."&usuid=".$fila['id']."&curso=
		".$fila['curso']."&grupo=".$fila['grupo']."&conv=$conv&pest=2&op=11' $target>";
	}
	if ($fila[$conv.'total'] != 0) {
		if ($fila[$conv.'total'] < 5) {$mensaje = "<span class='rojo'>".i("suspenso",$ilink)."</span>";}
		if ($fila[$conv.'total'] >= 5 AND $fila[$conv.'total'] < 7) {$mensaje = "<span class='verdecalific'>".i("aprobado",$ilink)."</span>";}
		if ($fila[$conv.'total'] >= 7 AND $fila[$conv.'total'] < 9) {$mensaje = "<span class='verdecalific b'>".i("notable",$ilink)."</span>";}
		if ($fila[$conv.'total'] >= 9) {$mensaje = "<span class='verdecalific u'>".i("sobresaliente",$ilink)."</span>";}
		if ($fila[$conv.'aprobado'] == 2) {$mensaje = "<span class='rojo'>".i("suspensodesc",$ilink)."</span>";}

		if ($esprofesor OR $fila[$conv.'aprobado'] != 2) {echo number_format($fila[$conv.'total'],2,',','.')."<br>";}
		echo $mensaje;
	}
	if ($esprofesor AND !$noponernotas) {
		echo "<br><span class='icon-pencil'></span>";
		echo "</a>";
	}
	echo "</td>";
	echo "<td>";
	if ($esprofesor AND !$noponernotas){
		echo "&nbsp;<a title='enviar nota' href='ficha.php?usuid=".$fila['id']."&conv=$conv"."&curso=".$fila['curso']."&grupo=".$fila['grupo']."&asigna=
		".$fila['asigna']."&pest=3&op=11' $target><span class='icon-upload'></span></a>";
	}
	echo "</td>";

}

?>