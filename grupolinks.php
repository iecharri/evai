<?php

// Copyright (c) 2000-2026 Inmaculada Echarri San Adrián
// Copyright (c) 2000-2026 Antonio Grandío Botella
// This file is part of EVAI.
// Licensed under the MIT License.
// See LICENSE.txt for details.

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

echo "<div class='center'>";
echo "<span class='colu'>";
echo "<a href='links.php?new=1'><span class='icon-pencil2 grande' title=\"".i("anadir",$ilink)."\"></span> ".i("anadir",$ilink)."</a>";
echo "</span></div>";

$sql = '';
$tit = "";
require_once APP_DIR . "/busquedas_sql_grupo.php";
require_once APP_DIR . "/links_resul.php";

?>


