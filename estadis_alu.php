<?php

// Copyright (c) 2000-2026 Inmaculada Echarri San Adrián
// Copyright (c) 2000-2026 Antonio Grandío Botella
// This file is part of EVAI.
// Licensed under the MIT License.
// See LICENSE.txt for details.

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

if ($_SESSION['auto'] < 2) {return;}
if ($_SESSION['auto'] > 4 AND $_GET['actu']) {
	require_once APP_DIR . '/gic_actu.php';
	$_GET['actu'] = "";
}

?>

<div class='center'>
	
	<?php
	
	if ($a) {
		$temp = "SELECT rotos, numvotrec, nota, desvtip, numvinc FROM usuasi WHERE id = '$u' AND asigna = '$a'";	
		echo "<h3>$a: </h3>";
	} else {
		$temp = "SELECT rotos, numvotrec, nota, desvtip, numvinc FROM usuarios WHERE id = '$u' LIMIT 1";
		echo "<h3>".i("totales",$ilink).": </h3>";
	}
	$result = $ilink->query($temp);
	$fila = $result->fetch_array(MYSQLI_BOTH);
	$temp = $fila['numvinc'];

	?>


 
		<?php
		echo i("numvinc",$ilink).": <span>".$temp."</span>";
		echo "<br><span class='rojo'>(".i("rotos",$ilink).": ".$fila['rotos'].")</span><br>";
		echo i("votosrec",$ilink).": <span class='b'>".$fila['numvotrec']."</span>";
		echo "<br> - ".i("puntu",$ilink).": <span>".$fila['nota']."</span>";
		echo "<br> - D.T.: <span class='b'>".$fila['desvtip']."</span>";
		echo "<p></p><h3>".i("totales",$ilink).":</h3>";

// --------------------------------------------------
	
		$temp = "SELECT numvincvot, coment FROM usuarios WHERE id = '$u' LIMIT 1";
		$result = $ilink->query($temp);
		$fila = $result->fetch_array(MYSQLI_BOTH);
		$numvincvot = $fila['numvincvot'];
		$coment = $fila['coment'];

		echo i("ajenos",$ilink).": <span>$numvincvot</span>";
		echo "<br>".i("coment",$ilink).": <span>$coment</span>";

// --------------------------------------------------

		$sql = "SELECT count(id) FROM vinculos WHERE idcat = '$u'";
		if ($a) {$sql .= " AND area = '$a'";}
		$iresult = $ilink->query($sql);
		$vinc = $iresult->fetch_array(MYSQLI_BOTH);
		//if ($vinc[0]) {
			echo "<br>V&iacute;nculos categorizados: $vinc[0]";
		//}

// --------------------------------------------------

		if ($_SESSION['auto'] > 4) {echo "<p></p>".$actualiz;}

// --------------------------------------------------
		?>

	</div>

