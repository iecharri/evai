<?php

// Copyright (c) 2000-2026 Inmaculada Echarri San Adrián
// Copyright (c) 2000-2026 Antonio Grandío Botella
// This file is part of EVAI.
// Licensed under the MIT License.
// See LICENSE.txt for details.

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

$asigna = $_SESSION['asigna'];

$temp = $ilink->query("SELECT COUNT(id) FROM vinculos WHERE area = '$asigna'"); 
$temp1 = $temp->fetch_array(MYSQLI_BOTH);
$_SESSION['numvinc'] = $temp1[0];
$numvinc = $_SESSION['numvinc'];
$temp = $ilink->query("SELECT COUNT(id) FROM vinculos WHERE usu_id = '".$_SESSION['usuid']."' AND area = '$asigna'"); 
$temp1 = $temp->fetch_array(MYSQLI_BOTH);
$_SESSION['numvinc1'] = $temp1[0];
$numvinc1 = $_SESSION['numvinc1'];
?>