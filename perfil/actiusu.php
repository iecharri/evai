<?php

// Copyright (c) 2000-2026 Inmaculada Echarri San Adrián
// Copyright (c) 2000-2026 Antonio Grandío Botella
// This file is part of EVAI.
// Licensed under the MIT License.
// See LICENSE.txt for details.

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

if (!$_SESSION['auto']) {return;}
$u = $usuid;
if ($_SESSION['asigna']) {$a = $_SESSION['asigna']; require_once APP_DIR . '/estadis_alu.php';}
$a = "";

if ($script == "ficha") {
	$actualiz = "<a href='".APP_URL."/ficha.php?op=$op&pest=$pest&actu=1&usuid=$usuid&accion=exp'>".i("profesor",$ilink).": ".i("actuestad",$ilink)."</a><p></p>";
}
require_once APP_DIR . '/estadis_alu.php';

?>

