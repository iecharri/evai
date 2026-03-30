<?php

require_once __DIR__ . "/siempre_base.php";

require_once APP_DIR . '/hiperen.php';

$ano = gmdate("Y");
$mes = gmdate("n");
if($mes > 6) {$ano++;}
//$_SESSION['curso'] = $ano; //quito esto porque si no no indica Dr o Dra en el panel, pongo lo siguiente
if (!$_SESSION['curso']) {$_SESSION['curso'] = $_GET['curso'];}

require_once APP_DIR . '/lib/phpqrcode/qrlib.php';

$n = $_GET['n'];
$sql = "SELECT * FROM podpaneles WHERE n='$n'";

$result = $ilink->query($sql);
$fila = $result->fetch_array(MYSQLI_BOTH);

// --------------------------------------------------

echo "<div class='fr' style='width:20%;'>";

$rec = explode("$$",$fila['recursos']);


foreach ($rec as $clave => $valor) {
	
	$dat = explode("**",$valor);
	
	$url = APP_URL . "/qr.php?f=" . urlencode("qr_" . $clave . ".png");
	
	if($dat[0] OR $dat[1]) {

		echo "<div class='foto1' style='float:none;max-width:100%'>";
		
		if($dat[0]) {
			if(strpos($dat[0],"yout")) {
				echo "<div class='video-responsive'><iframe src='$dat[0]'></iframe></div>";
			}
			include APP_DIR . '/lib/phpqrcode/index1.php';
			echo "<a href='$dat[0]'><img src='$url' class='imagen on0 med'></a>";
		}
		echo "<br><a href='$dat[0]'>".$dat[1]."</a>";
		
		echo "</div><p></p>";
		
	}
	
}

echo "</div>";

// --------------------------------------------------

echo "<div class='fl' style='width:80%'>";

$usus = explode("*",$fila[3]);

foreach ($usus as $clave => $valor) {
	if(!$valor) {continue;}
	$sql = "SELECT foto, alumnon, alumnoa, pacadem, usuario, mensaje, despacho, telefono FROM usuarios WHERE id='$valor'";
	$result = $ilink->query($sql);
	$fila = $result->fetch_array(MYSQLI_BOTH);
	$fo2    = APP_URL . "/avatar.php?f=" . rawurlencode("2" . $fila[0]);
	$fo2_dir = DATA_DIR . "/fotos/2" . $fila[0];
	$url2   = APP_URL . "/qr.php?f=" . rawurlencode("qr_" . $fila['usuario'] . ".png");

	echo "<div class='foto1'>";
		
	echo "<div class='fl di mr5'>";
		if (file_exists($fo2_dir)) {	
			echo "<img src='$fo2&v=".rand(1,1000)."' class='imagen on0 med'>"; // style='border:1px solid white'
		} else {
			echo "<div class='imagen on0 med' style='border:4px solid white'></div>";
		}
	echo "</div>";
	
	echo "<div class='fl di'>";
		if ($fila['pacadem']) {
			$pacadem = $fila[3];
			$usuario = $fila['usuario'];
			include APP_DIR . '/lib/phpqrcode/index.php';  // debe guardar como DATA_DIR.'/temp/qr_'.$usuario.'.png'
			echo "<a href='".$fila['pacadem']."'><img  src='$url2' class='imagen on0 med'></a>";
		} else {
			echo "<div class='imagen on0 med' style='border:4px solid white'>&nbsp;</div>";
		}
	echo "</div>";

	echo "<div class='both center'>".esdoct($valor,$ilink)."<span class='b'>".$fila['alumnon']."</span><br>".$fila['alumnoa']."<br><span class='verdecalific peq b'>".$fila['despacho']."&nbsp;";
	if($fila['despacho'] AND $fila['telefono']) {echo " / ";}
	echo $fila['telefono'];
	echo "</span></div>";

	echo "<div class='rojo likepeq' style='height:8em;width:16em'>".conhiper(consmy(quitabarra($fila['mensaje'])))."&nbsp;</div>";

	echo "</div>";
}

echo "</div>";

function quitabarra($x) {return stripslashes($x);}

?>
