<?php

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

echo "<p><br></p><a href='#' onclick=\"amplred('estoy')\">".i("estoy",$ilink)."...</a>";

$ms = $ilink->query("SELECT estoy FROM usuarios WHERE id = '".$_SESSION['usuid']."'");
$ms = $ms->fetch_array(MYSQLI_BOTH);
$ms = $ms[0];

echo "<div id='estoy' style='display:none'>";

	echo "<form method='post' action='ficha.php?op=5'>";
	echo "<input type='text' maxlength='40' name='estoy' value=\"$ms\" placeholder=\"".i("estoy1",$ilink)."\">";
	echo "<input type='hidden' name='estoy1' value='1'> <input class='col-4em peq' type='submit' value='>>'></form>";

echo "</div><p></p>";

// --------------------------------------------------

echo "<a href='#' onclick=\"amplred('ms')\">".i("mesiento",$ilink)."...</a>";

echo " <div id='ms' style='display:none'>";

	$ms = $ilink->query("SELECT mesiento FROM usuarios WHERE id = '".$_SESSION['usuid']."'");
	$ms = $ms->fetch_array(MYSQLI_BOTH);
	$ms = $ms[0];

	if($ms) {$$ms = "30";}

	$iconos = array('cat','silenced','smile','huh','wink','shock','angry','blush','cheesy','pacman','forreal','expressionless','tongue','ninja','sad','rolleyes','cry','grin',
						'dizzy','tired','sorry','wow','cool','dontknow','confused','ohdear','thumbup','thumbdown','eng99','eng101','pseudo','devil','laugh','whistle','worried',
						'smoking','beer','love');

	foreach ($iconos as $valor) {
		$sty='';
		if($valor == $ms) {$sty = "background:#ff0000";}
   	echo "<a class='mr5' href='".APP_URL."/ficha.php?op=5&ms=$valor'><img style='$sty' src='".MEDIA_URL."/emo/Em_$valor.svg' height='30'></a>";
	}

echo "</div><p><br></p>";



//echo "<div id='saco'></div>"; creo que no sirve

?>
