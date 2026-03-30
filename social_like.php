<?php

require_once __DIR__ . '/siempre_base.php';

if ($_SESSION['auto'] < 5 ) {
	exit;
}

require_once APP_DIR . '/perfil/socialmgnmg.php';

extract($_GET);

if ($clickar) {

	$sql = "DELETE FROM socialmgnmg WHERE tabla = '$tabla' AND id = '$id' AND usuid = '".$_SESSION['usuid']."'";
	$ilink->query($sql);

	$sql = "INSERT INTO socialmgnmg (tabla,id,usuid,mgnmg,fecha) VALUES ('".$_GET['tabla']."','".$_GET['id']."','".$_SESSION['usuid']."','$sino','".gmdate('Y-m-d H:i:s')."')";
	$ilink->query($sql);
	
}

like($tabla,$id,$ilink,$clickar);

?>
