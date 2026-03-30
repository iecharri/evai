<?php

// Copyright (c) 2000-2026 Inmaculada Echarri San Adrián
// Copyright (c) 2000-2026 Antonio Grandío Botella
// This file is part of EVAI.
// Licensed under the MIT License.
// See LICENSE.txt for details.

require_once __DIR__ . '/../siempre_base.php';

$id = $_GET['id'];
$id = (int)$id; // seguridad: cast a int

$qry = "SELECT tipoatach, attachment, nomatach, message, usuid, parausuid, isread FROM message_histo WHERE id = $id";
$iresult = $ilink->query($qry);

if ($iresult->num_rows === 0) {
    // No hay en la tabla histórica, probar en la tabla principal
    $qry = "SELECT tipoatach, attachment, nomatach, message, usuid, parausuid, isread FROM message WHERE id = $id";
    $iresult = $ilink->query($qry);
}

$res = $iresult->fetch_array(MYSQLI_BOTH);
if ($res[5] != $_SESSION['usuid'] AND $res[4] != $_SESSION['usuid']) {exit;}
$res[2] = str_replace(" ", "_", $res[2]);

$tipo = $res[0];
$contenido = $res[1];
$uid = $res['usuid']; $parausuid = $res['parausuid'];
$temp = gmdate("Y-m-d H:i:s");

if ($res[4] != $_SESSION['usuid']) {
	$ilink->query("INSERT INTO message (usuid, parausuid, message, date) VALUES 
	('$parausuid', '$uid', 'Recibido $res[2]', '$temp')");
}

header("Pragma: public");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Cache-Control: private",false);
header("Content-Description: File Transfer"); 
header("Content-Type: $tipo"); 
header("Content-Length: " . strlen($contenido)); 
header("Content-Disposition: attachment; filename=$res[2]"); 

print $contenido;

?>