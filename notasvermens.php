<?php

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

function notasvermens($asigna,$curso,$grupo,$ilink) {

$mens1 = "<span class='rojo'>".i("notasnovisi",$ilink)."</span> ";
$mens2 = "<span class='rojo'>".i("adminonotas",$ilink)."</span> ";
$mens3 = "<span class='rojo'>".i("profenonotas",$ilink)."</span> ";
$mens4 = "<span class='verdecalific'>".i("alusinotas",$ilink)."</span>";

$iresult = $ilink->query("SELECT vernotas FROM atencion");
$vernota = $iresult->fetch_array(MYSQLI_BOTH);

$iresult = $ilink->query("SELECT vernota FROM cursasigru WHERE asigna = '$asigna' AND curso = '$curso' AND grupo = '$grupo'");
$vernota1 = $iresult->fetch_array(MYSQLI_BOTH);

if (esprofesor($asigna,$curso,$grupo,$ilink) OR soyadmiano($asigna,$curso,$ilink)) {
	$puedover = 1;
}

if (!$vernota[0] OR !$vernota1[0]) {
	if (!$puedover) {
		$ret[0] = 0;
		$ret[1] = $mens1;
	} else {
		$ret[0] = 1;
		if (!$vernota[0]) {
			$ret[1] = $mens2;
		}
		if (!$vernota1[0]) {
			$ret[1] .= $mens3;
		}
	}
} else {
	$ret[0] = 1;
	if ($puedover) {
		$ret[1] = $mens4;
	}
}

return $ret;

}

?>