<?php

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

function winop($tit,$div,$oculta) {
	echo "<div id='$div' class='oscu' style='";if ($oculta) {echo "display:none;";} echo "'>";
		echo "<div class='o-content'>";	
			xclose($tit,$div);
}

function winop1($tit,$div,$oculta) {
    // (igual que winop; mantenlo si lo usas en otros sitios)
    $style = $oculta ? "display:none;" : "";
    echo "<div id='$div' class='oscu' style='$style' ".
         "onclick=\"if(event.target===this){ if(window.hide){ hide('$div'); } else { this.remove(); } }\">";
        echo "<div class='o-content' role='dialog' aria-modal='true' aria-labelledby='{$div}-ttl'>";
            xclose($tit,$div);
}
 
function wintot1($pg,$mensaje,$div,$tit,$oculta,$ilink) {
	winop($tit,$div,$oculta);
	if ($mensaje) {echo $mensaje."<br>";}
	echo "<div id='contenido'>";
		if ($pg) {include($pg);}
	echo "</div>";
	echo "</div>";
	echo "</div>";
	return $ret;
}

// --------------------------------------------------
 
function xclose($tit,$div) {
		echo "<span onclick=\"javascript:hide('$div');return false\" class = 'fr icon-cross rojo'></span>";
		echo "<span class='verdecalific b'>$tit</span>";
		echo "<p></p>";
}


?>
