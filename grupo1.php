<?php

// Copyright (c) 2000-2026 Inmaculada Echarri San Adrián
// Copyright (c) 2000-2026 Antonio Grandío Botella
// This file is part of EVAI.
// Licensed under the MIT License.
// See LICENSE.txt for details.

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

$_POST = array_map('ponbarra', $_POST);
extract($_POST);

$result = $ilink->query("SELECT grupo, mas, interesante, wow, competencias, video1 FROM grupos WHERE id = '$grupoid'");
$fila = $result->fetch_array(MYSQLI_BOTH);
$grupo = $fila['grupo'];

if ($mas AND $mas != $fila['mas']) {$cambio = "mas ";}
if ($interes AND $interes != $fila['interesante']) {$cambio .= "interesante ";}
if ($competencias AND $competencias != $fila['competencias']) {$cambio .= "competencias ";}
if ($wow AND $wow != $fila['wow']) {$cambio .= "wow ";}
if ($video1 AND $video1 != $fila['video1']) {$cambio .= "YouTube ";}

$sql = "UPDATE grupos SET mas = \"".quitabarra(nocomid($mas))."\", interesante = \"".quitabarra(nocomid($interes))."\", wow = \"".quitabarra(nocomid($wow))."\", 
 video1 = \"$video1\", competencias = \"".quitabarra(nocomid($competencias))."\", otros = \"$otros\"";
$sql .= " WHERE id = '$grupoid'";

$ilink->query($sql);
if ($ilink->errno) {die ("Error");}

function quitabarra($x) {return stripslashes($x);}
function ponbarra($x) {return addslashes($x);}
function nocomid($x) {return str_replace("\"","''",$x);}

?>