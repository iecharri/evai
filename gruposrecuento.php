<?php

// Copyright (c) 2000-2026 Inmaculada Echarri San Adrián
// Copyright (c) 2000-2026 Antonio Grandío Botella
// This file is part of EVAI.
// Licensed under the MIT License.
// See LICENSE.txt for details.

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

if ($grupoid) {$where = "WHERE id = '$grupoid' LIMIT 1";}

$result = $ilink->query("SELECT asigna, numvinc, id FROM grupos $where");

while ($fila = $result->fetch_array(MYSQLI_BOTH)) {

	$result1 = $ilink->query("SELECT * FROM gruposusu WHERE grupo_id = '".$fila['id']."'");

	$temp = 0;

	while ($fila1 = $result1->fetch_array(MYSQLI_BOTH)) {

		if ($fila['asigna']) {

			$iresult = $ilink->query("SELECT numvinc FROM usuasi WHERE asigna = '".$fila['asigna']."' AND id = '".$fila1['usu_id']."'");
			$numvinc1 = $iresult->fetch_array(MYSQLI_BOTH);

		} else {

			$iresult = $ilink->query("SELECT numvinc FROM usuarios WHERE id = '".$fila1['usu_id']."' LIMIT 1");
			$numvinc1 = $iresult->fetch_array(MYSQLI_BOTH);

		}

		$temp = $temp + $numvinc1[0];

	}

	$id = $fila['id'];
	$ilink->query("UPDATE grupos SET numvinc = '$temp' WHERE id = '$id' LIMIT 1");

}
