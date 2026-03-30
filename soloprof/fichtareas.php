<?php

// Copyright (c) 2000-2026 Inmaculada Echarri San Adrián
// Copyright (c) 2000-2026 Antonio Grandío Botella
// This file is part of EVAI.
// Licensed under the MIT License.
// See LICENSE.txt for details.

require_once __DIR__ . "/../siempre_base.php";

if ($_SESSION['auto'] < 3) {return;}

$id = $_GET['id'];

$sql = "SELECT tipoadj, adjunto, nomadj FROM tareas WHERE id='$id'";

$iresult = $ilink->query($sql);
$fila = $iresult->fetch_array(MYSQLI_BOTH);

$tipo = $fila[0];
$contenido = $fila[1];

header("Pragma: public");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Cache-Control: private",false);
header("Content-Description: File Transfer"); 
header("Content-Type: application/force-download"); 
header("Content-Length: " . strlen($contenido)); 
header("Content-Disposition: attachment; filename=$fila[2]"); 

print $contenido;

?>