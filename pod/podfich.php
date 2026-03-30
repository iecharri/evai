<?php

// Copyright (c) 2000-2026 Inmaculada Echarri San Adrián
// Copyright (c) 2000-2026 Antonio Grandío Botella
// This file is part of EVAI.
// Licensed under the MIT License.
// See LICENSE.txt for details.

require_once __DIR__ . "/../siempre_base.php";

if ($_SESSION['auto'] < 3) {return;}

$qry = "SELECT programafile, nomprogfile FROM cursasigru WHERE asigna='".$_GET['asigna']."' AND curso = '".$_GET['curso']."' AND grupo = '".$_GET['grupo']."'";
$iresult = $ilink->query($qry);
$res = $iresult->fetch_array(MYSQLI_BOTH);

$contenido = $res[0];

header("Pragma: public");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Cache-Control: private",false);
header("Content-Description: File Transfer"); 
header("Content-Type: application/force-download"); 
header("Content-Length: " . strlen($contenido)); 
header("Content-Disposition: attachment; filename=\"$res[1]\""); 

print $contenido;

?>