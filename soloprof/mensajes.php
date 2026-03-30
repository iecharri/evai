<?php

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

if($_GET['bomensf']) {
	$sql = "UPDATE message SET isread = 1 WHERE message LIKE 'Nuevo mensaje en el foro%'";
	$ilink->query($sql);
	$_GET['bomensf'] = "";
}

// --------------------------------------------------

unset($array);
$array[0] = "<a href='#'>".ucfirst(i("mensajes",$ilink))." <span class='icon-arrow-right'></span></a>";
solapah($array,1,"navhsimple");
	
// --------------------------------------------------

echo "<a href='admin.php?pest=14&bomensf=1' class='b' onclick=\"return confirm('Sólo se darán por leídos (no se borrarán) los mensajes que comienzan por -Nuevo mensaje en el foro-. Confirmar')\">CLICK</a> para marcar como leídos TODOS los mensajes automáticos de avisos de los Foros de TODOS los usuarios del ".ucfirst(SITE)." (no sólo Profesores).";

echo "<table class='conhover'>";

echo "<tr>";
echo "<th>".i("profesor",$ilink)."</th>";
echo "<th class='col-0 nowrap'>último acceso / último mensaje</th>";
echo "<th class='col-0 nowrap'>total por leer</th>";

echo "</tr>\n";


$sql = "SELECT id,hsmremind FROM usuarios WHERE tipo = 'P' AND fechabaja = '0000-00-00 00:00:00' ORDER BY fechalogin DESC";
$result = $ilink->query($sql);

while ($fila = $result->fetch_array(MYSQLI_BOTH)) {

	$sql1 = "SELECT entra,sale FROM usosistema WHERE id = '".$fila['id']."' ORDER BY sale DESC LIMIT 1";
	$result1 = $ilink->query($sql1);
	$fila1 = $result1->fetch_array(MYSQLI_BOTH);

	$sql2 = "SELECT count(id), max(date) FROM message WHERE parausuid = '".$fila['id']."' AND isread='0'";
	$result2 = $ilink->query($sql2);
	$fila2 = $result2->fetch_array(MYSQLI_BOTH);

	$sql3 = "SELECT count(id) FROM message WHERE parausuid = '".$fila['id']."' AND isread='0' AND message LIKE 'Nuevo mensaje en el foro%'";
	$result3 = $ilink->query($sql3);
	$fila3 = $result3->fetch_array(MYSQLI_BOTH);

	echo "<tr>";
	
	echo "<td>";
		$usu = ponerusu($fila['id'],1,$ilink);
		echo $usu[0].$usu[1];
	echo "</td>";

	echo "<td class='nowrap peq'>";
		if($result1->num_rows) {
			if($fila1[1] == "0000-00-00 00:00:00" OR !$fila[1]) {
				echo "Entró el ".ifecha31($fila1[0],$ilink);
			} else {
				echo ifecha31($fila1[1],$ilink);
			}
			$span = "";
			if($fila1[0] < $fila2[1]) {$span = "rojo";}
			echo " / <span class='$span'>".ifecha31($fila2[1],$ilink)."</span>";
		}
	echo "</td>";

	echo "<td>";
		if($fila2[0]) {
			echo $fila2[0];
			echo " <a title='enviar aviso por mail' class='icon-mail2' href=\"javascript:llamarasincrono('mensajes1.php?usuid=".$fila['id']."&num=$fila2[0]&desde=".$fila['hsmremind']."','usuid".$fila['id']."')\"></a>";
			echo " <span id='usuid".$fila['id']."'>";
			if($fila['hsmremind'] AND $fila['hsmremind'] != "0000-00-00 00:00:00") {
				echo "<br><span class='peq'>Avisado por mail el ".ifecha31($fila['hsmremind'],$ilink)."</span>";
			}
			echo "</span>";
			if($fila3[0]) {
				echo "<span class='peq'>(de foros: ".$fila3[0].")</span>";
			}
		}
	echo "</td>";

	echo "</tr>";
	
}

echo "<table>";

?>