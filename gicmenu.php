<?php

// Copyright (c) 2000-2026 Inmaculada Echarri San Adrián
// Copyright (c) 2000-2026 Antonio Grandío Botella
// This file is part of EVAI.
// Licensed under the MIT License.
// See LICENSE.txt for details.

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

unset($array);

$param = "usuid=$usuid&ord=$ord";

$array = array();

$array[] = "<a href='?$param&pest=1'>".i("actividad",$ilink)."</a>";
$array[] = "<a href='?$param&pest=2'>".i("vermiscomen",$ilink)."</a>";
$array[] = "<a href='?$param&pest=3'>".i("misvinc",$ilink)."</a>";
if ($usuid == $_SESSION['usuid'] AND $_SESSION['tipo'] != "E") {
	$array[] = "<a href='?$param&pest=4'>".i("traspvinc",$ilink)."</a>";
} else {
	$array[] = "";
}
if (($usuid == $_SESSION['usuid'] OR $_SESSION['auto'] > 4) AND $_SESSION['gc']) {
	$array[] = "<a href='?$param&pest=5'>Categorizaci&oacute;n</a>";
} else {
	$array[] = "";
}
if ($_SESSION['auto'] > 4) {
	$array[] = "<a href='?$param&pest=6'>Votos emitidos y recibidos</a>";
	$array[] = "<a href='?$param&pest=7'>Fiabilidad</a>";
} else {
	if ($pest > 5 AND $pest!=8 AND $usuid != $_SESSION['usuid']) {$pest = 1;} else {$array[] = "";}
	$array[] = "";
}
$array[] = "<a href='?$param&pest=8'>Foros</a>";
$array[] = "<a href='ficha.php?$param'>".i("ver",$ilink)."</a>";

?>