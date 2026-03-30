<?php

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

// comentarios en la carpeta del usuario  /profesor/asignatura$$curso$$grupo

if (!strpos($dir,"$$")) {return;}

$asi = $dir;
if (substr($asi,0,9) == "profesor/") {$asi = substr($asi,9);}
$asi = explode("/",$asi);
if ($asi[1]) {return;}

$asi = $asi[0];

if (!strpos($asi,"$$")) {return;}

if ($_SESSION['auto'] > 4 AND $cambiacoment) {
	if (!$_POST['coment']) {
		$ilink->query("DELETE FROM carpprofcoment WHERE id = '".$_POST['comentaid']."' LIMIT 1");
	}
	$sql = "UPDATE carpprofcoment SET comentario = \"".addslashes($_POST['coment'])."\" WHERE id = '".$_POST['comentaid']."' LIMIT 1";
	$ilink->query($sql);
	$vercom = 1;	
}

if ($_SESSION['auto'] > 4 AND $nuevocoment) {
	$sql = "INSERT INTO carpprofcoment (fecha, deid, paraid, carpeta, comentario) values
	('".gmdate('Y-m-d H:i:s')."', '".$_SESSION['usuid']."', '".$_GET['usuid']."', '$asi', \"".addslashes($_POST['coment'])."\")";
	$ilink->query($sql);	
	$vercom = 1;	
}

if (!$vercom) {$displ = " style='display:none'";}

?>

<br><a href='#' class='rojo b' onclick="amplred('vercoment')"><?php echo i("comentprofver",$ilink);?></a>

<div id='vercoment' <?php echo $displ;?>>

<?php

$sql = "SELECT * FROM carpprofcoment WHERE paraid = '".$_GET['usuid']."' AND carpeta = '$asi' ORDER BY fecha ASC";
$result = $ilink->query($sql);
if ($_GET['usuid'] == $_SESSION['usuid'] AND !$result->num_rows) {
	echo "<p></p>".i("nocometprof",$ilink)."</div>"; return;
}

echo "<br><table>";

echo "<tr><th>".i("profesor",$ilink)."</th><th></th></tr>";
while ($fila = $result->fetch_array(MYSQLI_BOTH)) {
	extract($fila);
	echo "<tr>";
	echo "<td>";
		$usu = ponerusu($fila['deid'],1,$ilink);
		echo $usu[0].$usu[1];
	echo "</td>";
	echo "<td><span class='peq'>".ifecha31($fecha,$ilink)."</span><br>";
	if ($deid == $_SESSION['usuid']) {
		//Si lo he comentado yo, ponerlo en forma de form
		echo "<form method='post' name='form$id'>";
		echo "<textarea class='col-5' rows='3' cols='60' name='coment'>".$comentario."</textarea>";
		echo "<input type='hidden' name='comentaid' value='$id'>";
		echo " &nbsp; <input class='col-1' type='submit' value=' >> ' name='cambiacoment'>";
		echo "</form>";	
	} else {
		//Si lo ha puesto otro profesor o soy el alumno, mostrarlo
		echo "<textarea class='col-5' rows='3' cols='60' readonly='readonly'>".$comentario."</textarea>";
	}
	echo "</td>";
	echo "</tr>";
}

if ($_SESSION['auto'] > 4) {
	//Al final, si soy profesor dar la opci&oacute;n de poner otro comentario
	echo "<tr>";
	echo "<td>";
	$usu = ponerusu($_SESSION['usuid'],1,$ilink);
	echo $usu[0].$usu[1];
	echo "</td>";
	echo "<td><span class='peq'>".ifecha31(gmdate("Y-m-d H:i:s"),$ilink)."</span><br>";
	echo "<form method='post' name='formfin'>";
	echo "<textarea class='col-5' rows='3' cols='60' name='coment'></textarea>";
	echo " &nbsp; <input class='col-1' type='submit' value=' >> ' name='nuevocoment'>";
	echo "</form>";	
	echo "</td>";
	echo "</tr>";
}

echo "</table>";


?>

</div><p></p>
