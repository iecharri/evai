<?php

// Copyright (c) 2000-2026 Inmaculada Echarri San Adrián
// Copyright (c) 2000-2026 Antonio Grandío Botella
// This file is part of EVAI.
// Licensed under the MIT License.
// See LICENSE.txt for details.

require_once __DIR__ . "/siempre_base.php";

if (($_SESSION['auto'] ?? 0) < 2) { exit; }

$asicurgrupo = $_SESSION['asigna']."$$".$_SESSION['curso']."$$".$_SESSION['grupo'];

// RUTA RELATIVA (la que entenderá ver_media.php)
$relDir = "cursos/$asicurgrupo/claseactual";

// RUTA ABSOLUTA EN DISCO (para is_file, file_get_contents)
$absDir = rtrim(DATA_DIR, '/') . '/' . $relDir . '/';

// lee el nombre guardado
$fname = null;
if (is_file($absDir . "clase.txt")) {
    $fname = trim((string)file_get_contents($absDir . "clase.txt"));
    $fname = basename(rawurldecode($fname)); // evita rutas
}

if ($fname && is_file($absDir . $fname)) {
    // URL al visor (usa dir relativa codificada)
    $dir64 = base64_encode($relDir);
    $src   = APP_URL . "/ver_media.php?dir64=" . rawurlencode($dir64)
          . "&f=" . rawurlencode($fname);

    echo '<img src="' . $src . '" alt="' . htmlspecialchars($fname, ENT_QUOTES) . '" class="col-10">';
} else {
    echo "<p></p><div class='center mediana'>" . i("nopresen", $ilink) . "</div>";
}

?>


