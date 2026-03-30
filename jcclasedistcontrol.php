<?php

require_once __DIR__ . "/siempre_base.php";

if ($_SESSION['auto'] < 2) {exit;} 

$asicurgru = $_SESSION['asigna']."$$".$_SESSION['curso']."$$".$_SESSION['grupo'];
$basedir = DATA_DIR ."/cursos/$asicurgru/claseactual/";

if(is_file($basedir."clase.txt")) {
	$contenido = file_get_contents($basedir."clase.txt");
	$contenido = $ilink->real_escape_string($contenido);
}

if ($contenido != $_SESSION['cont']) {
	
	?>
	<script language="javascript">jcclasedistimag();</script>
	<?php
	$_SESSION['cont'] = $contenido;

}

?>


