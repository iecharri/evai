<?php

// Copyright (c) 2000-2026 Inmaculada Echarri San Adrián
// Copyright (c) 2000-2026 Antonio Grandío Botella
// This file is part of EVAI.
// Licensed under the MIT License.
// See LICENSE.txt for details.

require_once __DIR__ . "/siempre_base.php";

if ($_SESSION['auto'] < 2 OR !$_SESSION['asigna']) {exit;} 

$asicurgrupo = $_SESSION['asigna']."$$".$_SESSION['curso']."$$".$_SESSION['grupo'];
$basedir = DATA_DIR ."/cursos/$asicurgrupo/claseactual/";

if ($_GET['fin']) {safe_unlink($basedir."clase.txt");}


if($_GET['file'] AND $_SESSION['auto'] > 4) 
	{
		$file = fopen($basedir."clase.txt","w");
		fwrite($file,$_GET['file']);
		fclose($file);
	}

?>



