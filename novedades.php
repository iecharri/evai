<?php

require_once __DIR__ . "/siempre_base.php";

$lee = $_POST['lee'];
$para = $_POST['para'];
$i = $_SESSION['i'];
if (!$i) {$i = 'c';}

if($lee) {

	$texto = i("news".$para,$ilink);
	echo $texto;
	return;
}

require_once APP_DIR . "/hiperen.php";

$texto = $_POST['texto'];

$sql = "UPDATE idioma SET $i = \"".addslashes($texto)."\" WHERE m = 'news$para'";
$ilink->query($sql);

$texto = str_replace("(dominio)", DOMINIO, $texto);
$texto = str_replace("&nbsp;", " ", $texto);
$texto = str_replace("<div></div>", "", $texto);	
$texto = str_replace("</div>", " </div>", $texto);	
echo conhiper($texto);

?>

