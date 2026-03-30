<?php

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

if (!$_SESSION['auto']) {return;}

if ($op == 9) {
	$filtro = " WHERE vinchs2.usu_id = '$usuid'";
	if ($soloasigna) {$filtro = $filtro." AND vinculos.area = '$asigna'";}
	$param = "pest=2&usuid=$usuid&op=$op";
} else {
	if ($_POST['buscar']) {$_SESSION['b2'] = $_POST['b2']; $_GET['conta'] = "";}
	$filtro = buscar($ilink);
	$param = "bus=$bus";
	if ($_SESSION['asigna'] AND !$filtro) {
		$filtro = "WHERE vinculos.area = '".$_SESSION['asigna']."'";
	}
}

$b2 = $_SESSION['b2'];

$sql = "SELECT vinchs2.id, vinchs2.usu_id, vinchs2.comentario, vinchs2.fecha, usuarios.privacidad, usuarios.usuario, usuarios.alumnon, usuarios.alumnoa, vinculos.desvtip, vinculos.nota, MATCH(comentario) AGAINST ('$b2') AS relevancia, vinculos.area FROM vinchs2 LEFT JOIN vinculos ON vinchs2.id = vinculos.id LEFT JOIN usuarios ON vinchs2.usu_id = usuarios.id $filtro";

if (!$b2) {$sql = $sql." ORDER BY vinchs2.fecha DESC ";}

$iresult = $ilink->query($sql);
$resul = $iresult->num_rows;
if (!$resul) {
	echo "<p></p><h4 class='rojo'>".i("nodatos",$ilink)."</h4>\n";
	return;
}

if (!$conta) {$conta = 1;}
$iresult = $ilink->query($sql);
$resul = $iresult->num_rows;

if ($_SESSION['pda']) {$numpag = 5;} else {$numpag = 20;}

pagina($resul,$conta,$numpag,i("comentarios",$ilink),$param,$ilink);

$sql1 = $sql.$orden."LIMIT ".($conta-1).", $numpag";

$result = $ilink->query($sql1);

while ($fila = $result->fetch_array(MYSQLI_BOTH)) {

	$link=1;if ($usuid) {$link=-1;}
	echo "<div class='colu contiene'>";
	$mens = " <span class='peq nob'>".ifecha31($fila['fecha'],$ilink)."</span> &nbsp; &nbsp; <a href='links.php?id=".$fila['id']."' class='b'>".$fila['area']." ".i("vinculo",$ilink)."</a> (".i("nota",$ilink).": <span class='b'>".$fila['nota']."</span>&nbsp;&nbsp;".i("dt",$ilink).": <span class='b'>".$fila['desvtip']."</span>)<br>";
	if ($_SESSION['b2']) {
		$mens .= str_replace($_SESSION['b2'], "<span class='rojo b u'>".$_SESSION['b2']."</span>", nl2br($fila['comentario']));
	} else {
		$mens .= nl2br($fila['comentario']);
	}
	if (!$usuid) {
		$usu = ponerusu($fila['usu_id'],1,$ilink);
		?><div class="fila-usuario">
 	 		<div class="foto"><?php
 	 			echo $usu[0];?>	
 			</div>
			<div class="datos"><?php 	
				echo $usu[1].$mens;?>
			</div>
		</div><?php
	} else {
		echo $mens;
	}
	echo "</div>\n";
}

pagina($resul,$conta,$numpag,i("comentarios",$ilink),$param,$ilink);

return;

function buscar($ilink) {

	$b2 = $_SESSION['b2'];

	echo "<form name='buscar' method='post' action='links.php?bus=4'>";
	echo "<input class='col-3' type='text' name='b2' size='20' maxlength='20' value=\"$b2\"> ";
	echo " <input type='submit' name='buscar' value='".i("buscar",$ilink)."'><p></p>";
	echo "</form>";

	if ($b2) {return " WHERE MATCH(comentario) AGAINST ('$b2')";}

}

?>