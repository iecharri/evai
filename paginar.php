<?php

// Copyright (c) 2000-2026 Inmaculada Echarri San Adrián
// Copyright (c) 2000-2026 Antonio Grandío Botella
// This file is part of EVAI.
// Licensed under the MIT License.
// See LICENSE.txt for details.

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

function pagina($resul,$conta,$num,$que,$param,$ilink) {

	echo "<span class = 'txth b'>".i("pg",$ilink)."</span>";
	$pag = ceil($resul/$num);
	$pagactu = ceil($conta/$num);
	if ($param) {$param="&".$param;} else {$param = "";}

	$i = $pagactu - 5;

	if ($i > 1) {echo " <a href=?conta=1$param><<</a> <a href=?conta=".($conta-$num)."$param><</a>";}

	while ($i < $pagactu) {

		if ($i > 0) {echo " <a href=?conta=".((($i-1)*$num)+1)."$param>$i</a>";}
		$i++;

	}

	$i++;

	echo " [<span class = 'txth b'>$pagactu</span>]";

	$n = $pagactu + 7;

	while ($i < $n) {

		if ($i <= $pag) {echo " <a href=?conta=".((($i-1)*$num)+1)."$param>$i</a> ";}
		$i++;

	}

	if ($i <= $pag) {
		echo "<a href=?conta=".($conta+$num)."$param>></a> <a href=?conta=".((((int)($resul/$num))*$num)+1)."$param>>></a>";
	}

	echo " (".$resul." $que)";

}
