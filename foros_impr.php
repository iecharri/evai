<?php

// Copyright (c) 2000-2026 Inmaculada Echarri San Adrián
// Copyright (c) 2000-2026 Antonio Grandío Botella
// This file is part of EVAI.
// Licensed under the MIT License.
// See LICENSE.txt for details.

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

if ($_SESSION['auto'] < 5 OR !$asigna) {
	return;
}

// --------------------------------------------------

$sql = traesqllista();
$iresult = $ilink->query($sql);
$temp = $iresult->fetch_array(MYSQLI_BOTH);

$titulo = "<span class='b'>$temp[4] $temp[1]</span> ".i("foro",$ilink);
$titulo .=  "\n";
$titulo .= "&nbsp;&nbsp;&nbsp;&nbsp;".i("curso",$ilink).": <input type='text' size='4' maxlength='4' name='curso' ";
$titulo .= "value='$temp[2]' style='font-size=10pt'readonly>";
$titulo .= " &nbsp; &nbsp; ".i("grupo",$ilink).": <input type='text' style='font-size=10pt' size='1' maxlength='1' name='grupo' value='$temp[3]' readonly>";

$iresult = $ilink->query($sql);

while ($fila = $iresult->fetch_array(MYSQLI_BOTH)) {
	echo "<span class='soloimp'>".$titulo."</span>";
	ponerunhilo($fila['id'],$ilink,'','');
	echo "<div class='saltopagina'></div>";
}

?>

