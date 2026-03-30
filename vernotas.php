<?php

// Copyright (c) 2000-2026 Inmaculada Echarri San Adrián
// Copyright (c) 2000-2026 Antonio Grandío Botella
// This file is part of EVAI.
// Licensed under the MIT License.
// See LICENSE.txt for details.

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

function vernota($asigna,$curso,$grupo,$ilink) {

$iresult = $ilink->query("SELECT vernotas FROM atencion");
$vernota = $iresult->fetch_array(MYSQLI_BOTH);

$iresult = $ilink->query("SELECT vernota FROM cursasigru WHERE asigna = '$asigna' AND curso = '$curso' AND grupo = '$grupo'");
$vernota1 = $iresult->fetch_array(MYSQLI_BOTH);

if (!$vernota[0]) {
	if (esprofesor($asigna,$curso,$grupo,$ilink) OR soyadmiano($asigna,$curso,$ilink)) {return 1;} else {return 0;}
}

if (!$vernota1[0]) {
	if (esprofesor($asigna,$curso,$grupo,$ilink) OR soyadmiano($asigna,$curso,$ilink)) {return 2;} else {return 0;}
}

if (esprofesor($asigna,$curso,$grupo,$ilink) OR soyadmiano($asigna,$curso,$ilink)) {return 3;}

return 4;

}

?>