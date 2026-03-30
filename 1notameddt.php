<?php

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

function media($conv, $fila, $esprof5, $concoefi) {

	if (!$conv) {echo "<td></td><td></td><td></td><td></td><td></td><td></td><td></td>"; return;}

	if (!$concoefi) {
		echo "<td></td><td></td><td></td><td></td>";
	} else {
		echo "<td align=right>&nbsp;";
		if ($fila[$conv.'test'] != 0) { echo number_format($fila[$conv.'test'],2,',','.');}
		echo "</td><td align=right>&nbsp;";
		if ($fila[$conv.'preg'] != 0) { echo number_format($fila[$conv.'preg'],2,',','.');}
		echo "</td><td align=right>&nbsp;";
		if ($fila[$conv.'prac'] != 0) { echo number_format($fila[$conv.'prac'],2,',','.');}
		echo "</td><td align=right>&nbsp;";
		if ($fila[$conv.'eval'] != 0) { echo number_format($fila[$conv.'eval'],2,',','.');}
		echo "</td>";
	}
	echo "<td align=right>&nbsp;<span class='b'>";
	if ($fila[$conv.'total'] != 0) { echo number_format($fila[$conv.'total'],2,',','.');}
	echo "</span></td>";
	echo "<td>&nbsp;</td>";

}

function dtip($conv, $fila, $esprof5, $concoefi) {

	if (!$conv) {echo "<td></td><td></td><td></td><td></td><td></td><td></td><td></td>"; return;}

	if (!$concoefi) {
		echo "<td></td><td></td><td></td><td></td>";
	} else {
		echo "<td align=right>&nbsp;";
		if ($fila[$conv.'_test_dt'] != 0) { echo number_format($fila[$conv.'test_dt'],2,',','.');}
		echo "</td><td align=right>&nbsp;";
		if ($fila[$conv.'preg_dt'] != 0) { echo number_format($fila[$conv.'preg_dt'],2,',','.');}
		echo "</td><td align=right>&nbsp;";
		if ($fila[$conv.'prac_dt'] != 0) { echo number_format($fila[$conv.'prac_dt'],2,',','.');}
		echo "</td><td align=right>&nbsp;";
		if ($fila[$conv.'eval_dt'] != 0) { echo number_format($fila[$conv.'eval_dt'],2,',','.');}
		echo "</td>";
	}
	echo "<td align=right>&nbsp;<span class='b'>";
	if ($fila[$conv.'total_dt'] != 0) { echo number_format($fila[$conv.'total_dt'],2,',','.');}
	echo "</span></td>";
	echo "<td>&nbsp;</td>";

}

?>