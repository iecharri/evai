<?php

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

if(demo_enabled()) {
	//return;
}

$sql = "SELECT fichasemana, fechafichasemana FROM atencion";
$iresult = $ilink->query($sql);
$fila = $iresult->fetch_array(MYSQLI_BOTH);

$fichadia = $fila[0];

if ($fila[0] < 1 OR (gmdate("w") == 1 AND gmdate("Y-m-d") != substr($fila[1],0,10))) {

	//Usuarios, inclu&iacute;do el lanzador del script que han entrado desde hace una semana
	$menos7dias = gmdate('Y-m-d H:i:s',time()-(7*24*60*60));
	$sql = "SELECT DISTINCT usuarios.id FROM usosistema LEFT JOIN usuarios ON usosistema.id = usuarios.id
	WHERE entra > '$menos7dias' AND foto != '' AND autorizado < 10 AND autorizado > 3 AND 
	fechabaja = '0000-00-00 00:00:00' AND privacidad = 0";

	$n = 1;	$array = [];
	$result = $ilink->query($sql);
	while ($fila = $result->fetch_array(MYSQLI_BOTH)) {
		$array[$n] = $fila[0];
		$n++;
	}
	$n = count($array);
	
	$random = rand(1,$n-1);
	$fichadia = $array[$random];
	
	$ilink->query("UPDATE atencion SET fichasemana = '$fichadia', fechafichasemana = '".gmdate("Y-m-d")."'");

}

// --------------------------------------------------
echo "<hr class='sty'>";
echo "<h4 class='both'>".i("fichsemana",$ilink)."</h4>";

if(demo_enabled()) {$fichadia = 690;}

$usu = ponerusu($fichadia,1,$ilink);

?><div class="fila-usuario">
 	 	<div class="foto"><?php
 	 		echo $usu[0];?>	
 		</div>
		<div class="datos"><?php 	
			echo $usu[1]."<br> &nbsp;<span class='estoy peq u'>$usu[2]</span>";?>
		</div>
</div><?php
		
// --------------------------------------------------

$sql = "SELECT * FROM fichaactualiz LEFT JOIN usuarios on usuarios.id = fichaactualiz.usuid WHERE autorizado>0 AND fechabaja = '0000-00-00 00:00:00' ORDER BY fichaactualiz.fecha DESC";
$result = $ilink->query($sql);
$n = 0;

if ($result->num_rows > 0) {  // AND $quenosalga

	echo "<hr class='sty'>";
	echo "<h4 class='both'>".i("fichasactu",$ilink)."</h4><p></p>";

// --------------------------------------------------

	while ($fila = $result->fetch_array(MYSQLI_BOTH)) {

		$cambio = trim($fila['cambio']); $array = explode(" ",$cambio);

		if (!$n) {$foto = 1;} else {$foto = 0;}
		$texto = "<br>&nbsp;";
		for ($i=0;$i<sizeof($array);$i++) {
			$texto .= i($array[$i],$ilink);
			if (trim($array[$i]) AND $i<sizeof($array)-1) {$texto .= ", ";}
		}

	$usu = ponerusu($fila[0],1,$ilink);
	//echo "<div class=' contiene'>";
	
	?><div class="fila-usuario">
 	 		<div class="foto"><?php	
				echo $usu[0];?>
			</div>
			<div class="datos"><?php
				echo $usu[1].$texto;?>
			</div>
		</div><?php





	
	//echo "<div class='both'></div>";
	echo "<p></p>";

		$n++;
		if ($n == 5) {break;}

	}

}

echo "<hr class='sty'>";

?>