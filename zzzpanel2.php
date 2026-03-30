<?php

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

$rec = explode("$$",$fila['recursos']);

foreach ($rec as $clave => $valor) {
	
	$dat = explode("**",$valor);
	$url = DATA_URL . "/temp/qr_".$clave.".png";
	if($dat[0] OR $dat[1]) {

		echo "<div class='foto1' style='float:none;max-width:100%'>";
		
		if($dat[0]) {
			require_once APP_DIR . "/lib/phpqrcode/index1.php";
			echo "<img src='$url' class='imagen on0 med'>"."<br>";
		}
		echo " ".$dat[1];
		
		echo "</div>";
		
	}
	
}


?>