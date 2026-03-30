<?php

// Copyright (c) 2000-2026 Inmaculada Echarri San Adrián
// Copyright (c) 2000-2026 Antonio Grandío Botella
// This file is part of EVAI.
// Licensed under the MIT License.
// See LICENSE.txt for details.

require_once __DIR__ .  "/../siempre_base.php";

$id = $_GET['id'];

$campo = "thumb"; if ($_GET['tam']) {$campo = "fichfoto";}

$qry = "SELECT $campo,tipo FROM social_fotos WHERE id='$id'";
$iresult = $ilink->query($qry);

if (!$iresult || $iresult->num_rows === 0) {
    return; exit;  // no hay registros o error en la consulta
}

$res = $iresult->fetch_array(MYSQLI_BOTH);

header("Content-Type: $res[1]");

echo $res[0];   
?>