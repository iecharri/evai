<?php

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

if ($_SESSION['auto'] < 5) {exit;}

extract($_GET);
extract($_POST);

// --------------------------------------------------

unset($array);

$array[0] = "<a href='#'>".i("practext",$ilink)." <span class='icon-arrow-right'></span> ";
$array[1] = "<a href='?pest=$pest&apli=1'>".i("calenactivi",$ilink)."</a>";
$apli = 1;

solapah($array,$apli+1,"navhsimple");

if ($apli) {
	echo "<a class='grande b' href='?pest=$pest&apli=$apli'>$texto[$apli]</a>";
	if ($apli == 1) {
		echo "(<span class='txth b'>".i("activialu",$ilink)." <a href='" . APP_URL . "indexrecursos.php?op=10&apli=1'>Recursos, Pr&aacute;cticas, Calendario de actividades</a></span>)";
	}
}

if ($apli == 1) {
	require_once APP_DIR . "/soloprof/titaplic1.php";
}

?>
