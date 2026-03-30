<?php

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

function solapah($menus, $num, $id) {
echo "<ul id='$id' style='margin-bottom:.5em'>";
$n = 1;
foreach ($menus as $elem) {
	if ($elem) {
		$tipo = '';
		if ($num == $n) {$tipo = "id='active'";}
		echo "<li $tipo>$elem</li>";
	}
	$n++;
}
echo "</ul>";
}

?>