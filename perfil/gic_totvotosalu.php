<?php

// Copyright (c) 2000-2026 Inmaculada Echarri San Adrián
// Copyright (c) 2000-2026 Antonio Grandío Botella
// This file is part of EVAI.
// Licensed under the MIT License.
// See LICENSE.txt for details.

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

if (!$pest) {return;}

if (!$_GET['n']){
	echo "[<a href='?n=1&usuid=$usuid&op=9&pest=6'>Por orden en B.D.</a>]&nbsp;&nbsp;[Por apellido]";
}else{
	echo "[Por orden en B.D.]&nbsp;&nbsp;[<a href='?usuid=$usuid&op=9&pest=6'>Por apellido</a>]";
}

echo "<p></p><div class='fl colu col-4'>";

$sql = "SELECT votos, vinculos.url, usuarios.id FROM votos LEFT JOIN vinculos ON vinculos.id = votos.vinculo_id LEFT JOIN usuarios ON usuarios.id = votos.usu_id WHERE vinculos.usu_id = '$usuid'";

if (!$_GET['n']){$sql.= " ORDER BY usuarios.alumnoa";}

$result = $ilink->query($sql);

echo "<span class='b'>Recibidos de</span>:<br>";
while ($fila = $result->fetch_array(MYSQLI_BOTH)) {
	
	$temp = $fila['votos']; if ($temp == 0){$temp = '--';}
	$mens = " un $temp por <a href=http://".$fila['url']." target='_blank'>".substr($fila['url'],0,30)."...</a>\n";
	
	$usu = ponerusu($fila['id'],1,$ilink);
	?><div class="fila-usuario">
  		<div class="foto"><?php
  			echo $usu[0];?>	
 		</div>
		<div class="datos"><?php 	
			echo $usu[1]."<br>".$mens;?>
		</div>
	</div><?php

	echo "<p class='both'></p>";
	
}

echo "</div><div class='fl colu col-4'>";

echo "<span class='b'>Emitidos a</span>:<br>\n";
$sql = "SELECT votos, vinculos.url, usuarios.id FROM votos LEFT JOIN vinculos ON vinculos.id = votos.vinculo_id  LEFT JOIN usuarios ON usuarios.id = vinculos.usu_id WHERE votos.usu_id = '$usuid'";

if (!$_GET['n']){$sql.= " ORDER BY usuarios.alumnoa";}

$result = $ilink->query($sql);

while ($fila = $result->fetch_array(MYSQLI_BOTH)) {
	$temp = $fila['votos']; if ($temp == 0){$temp = '--';} 
	$mens = " un $temp por <a href=http://".$fila['url']." target='_blank'>".substr($fila['url'],0,30)."...</a>\n";
	
	$usu = ponerusu($fila['id'],1,$ilink);
	
	?><div class="fila-usuario">
  		<div class="foto"><?php
  			echo $usu[0];?>	
 		</div>
		<div class="datos"><?php 	
			echo $usu[1]."<br>".$mens;?>
		</div>
	</div><?php

}

echo "</div>";

?>