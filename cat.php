<?php

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

$result = $ilink->query("SELECT gc2.n, gc2.subn, gc1.cat, gc2.cat FROM gc2 LEFT JOIN gc1 ON gc1.n = gc2.n ORDER BY gc2.n, gc2.subn");
$contr = "*";
$i = -1;
while ($fila = $result->fetch_array(MYSQLI_BOTH)) {
	if ($contr != $fila[0]) {
		$cat[$i+1][0] = $fila[2];
		$contr = $fila[0];
		$i++;
	}
	if (!isset($cat[$i]) || !is_array($cat[$i])) {
		$cat[$i] = [];
	}
	$cat[$i][$fila[1]] = $fila[3];
}


?>
