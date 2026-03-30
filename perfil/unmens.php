<?php

require_once(__DIR__ . "/../siempre_base.php");

function unmensa($sql,$histot,$ilink,$x) {
	
	//salvo que el admi envíe por mail los hsm, $x es $_SESSION['usuid']
	
	if(!$x) {$x = $_SESSION['usuid'];}

	$result = $ilink->query($sql);
	
	while ($myrow = $result->fetch_array(MYSQLI_BOTH)) {
		
		//$myrow[0] es el que manda
		//$myrow[4] es el nombre del que manda
		//$histot, 1 = necesario poner nombre completo del otro; 0 = solo nombre con link 2 = nombre
		//$myrow[3] leido o no

		$cierradiv = "";
		$ventanadechat = '';

		//quien manda
		if(!$histot) { //historial de un usuario
			if($myrow[0] AND $x == $myrow[0]) {$myrow[4] = i("yo",$ilink);}
			$ret .= "<a href='usuarios.php?usuid=$myrow[0]'>$myrow[4]</a>";
		} elseif($histot == 1) { //historial total
			$para = "<span class='icon-arrow-left rojo' title=\"".i("de",$ilink)."\"></span>";
			if($x == $myrow[0]) {
				$para = "<span class='icon-arrow-right nob' title=\"".i("para",$ilink)."\"></span>";
				$usu = ponerusu($myrow[8],1,$ilink);
			} else {
				$usu = ponerusu($myrow[0],1,$ilink);
			}

			$ret .= "<div class=\"fila-usuario\"><div class=\"foto\">$para $usu[0]</div><div class=\"datos\">".$usu[1]; $cerrar=1;
			
			$cierradiv = 1;
		} else { //ventana de chat
			$ventanadechat = 1;
		}
		if($ventanadechat) {
			if($myrow[0] AND $x == $myrow[0]) {$myrow[4] = i("yo",$ilink);}
			$ret .= $myrow[4];
			$ret .= " <span class='nob peq'>".fechaen($myrow[2],$ilink)."</span> "; //la fecha
		} else {
			$ret .= " <span class='nob peq'>".fechaen($myrow[2],$ilink)."</span> "; //la fecha, historial
		}

		if($cierradiv) {$ret .= "<p></p>";}

		// con negrita o no
		if ($myrow[0] != $x AND $histot != 2) {
			$ret .= "<span class='b'>".consmy(conhiper($myrow[1]))."</span>";
		} else {
			$ret .= consmy(conhiper($myrow[1]));
		}
		
		//adjuntos
		if ($myrow[6]) {
			if ($myrow[3] == 1) {$histo = "&hist=1";}
			$ret .= " <a href='perfil/fichmess.php?id=$myrow[7]' target='_blank' class='rojo'>";
			$ret .= " - Descargar <span class='b'>$myrow[6]</span></a>  - ".tamano($myrow[5]);
		}

		//leido o no
		if ($myrow[3] == 0 AND $histot != 2) {
			if ($myrow[0] == $x) {
				$ret .= " <span class='peq nob'>".i("sinleer",$ilink)."</span>";
			} else {
				$ret .= " <a class='peq nob' href='?usuid=$myrow[0]'>".i("sinleer",$ilink)."</a>";
			}

		}

		if($cierradiv) {$ret .= "</div><p class='both'></p><hr class='sty'><p class='both'></p>";}
		
		if($cerrar){$ret .= "</div>"; }
		$ret .= "<br>";
		
	}
	
	return $ret;
	
}

?>