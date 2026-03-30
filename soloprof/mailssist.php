<?php

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

if($_SESSION['auto'] < 5) {return;}

if (!$usuid) {$usuid = $_SESSION['usuid'];}

if ($_SESSION['auto'] == 5 AND $usuid != $_SESSION['usuid']) {
	$iresult = $ilink->query("SELECT autorizado FROM usuarios WHERE id = '$usuid' LIMIT 1");
	$auto = $iresult->fetch_array(MYSQLI_BOTH);
	if ($auto[0] != 3 AND $auto[0] != 4) {return;}
}

$iresult = $ilink->query("SELECT mail FROM usuarios WHERE id = '$usuid' LIMIT 1");
$mail = $iresult->fetch_array(MYSQLI_BOTH);

$filtro = "";

if($_SESSION['auto'] < 10 OR $usuid != $_SESSION['usuid']) {
	$filtro = " WHERE (mensaje2 LIKE '%$mail[0]%'";
	$filtro .= " OR paraid = '$usuid' OR deid = '$usuid')";
}

$sql = "SELECT * FROM enviospor $filtro";
if ($filtropod) {
	if ($filtro) {$sql .= " AND";} else {$sql .= "WHERE";}
	$sql .= $filtropod;
}

$result = $ilink->query($sql);
$numfilas = $result->num_rows;

// --------------------------------------------------

unset($array);

$array[0] = "<a href='#'>Mails sistema <span class='icon-arrow-right'></span></a>";

solapah($array,1,"navhsimple");
	
// --------------------------------------------------

if ($numfilas == 0) {
	echo "<center><br>".i("messno",$ilink)."</center>";
	return;
}

$conta = $_GET['conta'];
if (!$conta) {$conta = 1;}

if ($_SESSION['pda']) {$numpag = 5;} else {$numpag = 20;}
pagina($numfilas,$conta,$numpag,i("mensajes",$ilink),$param,$ilink);

$result = $ilink->query($sql." ORDER BY fecha DESC LIMIT ".($conta-1).", $numpag");

while ($temp = $result->fetch_array(MYSQLI_BOTH)) {

	echo "<p class='both'>".utcausu1($temp['fecha'])." (".$temp['tipo']." ";
	if ($temp['exito']) {echo "&eacute;xito";} else {echo "<span class=rojo>fallido</span>";}
	echo ")<br>";
	
	//foto, nombre y mensaje
	$usu = ponerusu($temp['deid'],1,$ilink);
	
	?><div class="fila-usuario">
 		<div class="foto"><?php
 			echo $usu[0];?>	
		</div>
		<div class="datos"><?php 	
			echo $usu[1];
			echo " para ";
			if ($temp['paraid'] == -1) {
				$mailagrupo = strpos($temp['mensaje2'],"*+*+*+*");
				$nom = substr($temp['mensaje2'],0,$mailagrupo);
				$temp['mensaje2'] = substr($temp['mensaje2'],$mailagrupo+7);
				echo str_replace(",",", ",$nom);
			} else {
				$usu = ponerusu($temp['paraid'],1,$ilink);
				?><div class="fila-usuario">
			 		<div class="foto"><?php
 						echo $usu[0];?>	
					</div>
					<div class="datos"><?php 	
						echo $usu[1];
			}

			echo "<br> &nbsp; <span class='b'>Asunto</span>: ".$temp['mensaje1'];
			echo ". <span class='b'>Texto</span> ";
			if (demo_enabled()) {
				echo ": <span class='rojo b'>DEMO VERSION</span>";
			} else {
				echo "<a name=".$temp['n']."></a> [ <a onclick=\"amplred('div".$temp['n']."')\" class='txth b'>Ampliar/reducir</a> ]<br>";
			}

			echo "<div id='div".$temp['n']."' class='colu col-6' style='display:none'>".$temp['mensaje2']."</div><p><br></p>";?>

	  </div>
	 </div><?php
	
	//echo "<div id='div".$temp['n']."' class='colu col-6' style='display:none'>".$temp['mensaje2']."</div><p><br></p>";

}

echo "<p></p>";
pagina($numfilas,$conta,$numpag,i("mensajes",$ilink),$param,$ilink);

?>


