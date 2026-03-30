<?php

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

extract($_POST);
$temp = "";

if ($anadir AND $newpanel) {
	foreach($_POST as $campo => $valor){
  		if(substr($campo,0,6) == "usuenv") {
  			$temp .= substr($campo,6)."*";
  		}
	}	
	if($temp != "*" AND $temp) {
		$max = $ilink->query("SELECT MAX(n) FROM podpaneles");
		$fila = $max->fetch_array(MYSQLI_BOTH);
		$max = $fila[0]+1;
		if(!$max) {$max = 1;}
		$ilink->query("INSERT INTO podpaneles (n, nombre, profesores) VALUES ('$max', \"$newpanel\", '$temp')");
	}
	$accion = "";
}

if($r1ecursos) {
	foreach($recu as $campo => $dosrecs){
		if($dosrecs[0] OR $dosrecs[1]) {$guardar .= "$$".$dosrecs[0]."**".$dosrecs[1];}
	}
	
	$ilink->query("UPDATE podpaneles SET recursos = '$guardar' WHERE n='$n'");	
}

if($editar1 AND $edpanel) {
	foreach($_POST as $campo => $valor){
  		if(substr($campo,0,6) == "usuenv") {
  			$temp .= substr($campo,6)."*"; 
			$ilink->query("UPDATE usuarios SET pacadem = '".$_POST['pacadem'.substr($campo,6)]."', mensaje = '".$_POST['mens'.substr($campo,6)]."', despacho='".$_POST['desp'.substr($campo,6)]."', telefono='".$_POST['telf'.substr($campo,6)]."' WHERE id='".substr($campo,6)."'");
			//si está vacío borrar el fichero qr
			if(!$_POST['pacadem'.substr($campo,6)]) {
				$result = $ilink->query("SELECT usuario FROM usuarios WHERE id = '".substr($campo,6)."'");
				$fila = $result->fetch_array(MYSQLI_BOTH);
				safe_unlink(DATA_DIR . "/fotos/qr_".$fila[0].".png");
			}
  		}
	}
	if($temp != "*" AND $temp) {
		$ilink->query("UPDATE podpaneles SET nombre = \"$edpanel\", profesores = '$temp' WHERE n=$n");
	}
	$accion = "";
}

if($editar1 AND $borrar) {
	$ilink->query("DELETE FROM podpaneles WHERE n=$n");
}

if ($accion == 'anadir') {
	winop(i("anadir1",$ilink),'div1','');
	echo "<form name='form1' method='post'>";
	echo "<label class='b'>Título del Panel</label><br>";
	echo "<input class='col-10' type='text' name='newpanel' size='50' maxlength='400' value='$newpanel'><br>";
	echo "<label class='b'>Profesores integrantes</label>";
	echo " &nbsp; <input class='col-2' type='submit' name='anadir' value=\"".i("agvalid",$ilink)."\"><br>";
	$sql = "SELECT id FROM usuarios WHERE tipo = 'P' AND fechabaja = '0000-00-00 00:00' ORDER BY alumnoa, alumnon";
	$result = $ilink->query($sql);
	echo "<table class='col-5 conhover'>";
	while ($fila = $result->fetch_array(MYSQLI_BOTH)) {
		echo "<tr>";
		echo "<td class='col-01'><input type='checkbox' name=\"usuenv$fila[0]\"";
		echo "></td><td>";
			$usu = ponerusu($fila['id'],1,$ilink);
			echo $usu[0].$usu[1];
		echo "</td></tr>";
	}
	echo "</table>";
	echo "<input class='col-2' type='submit' name='anadir' value=\"".i("anadir1",$ilink)."\">";
	echo "</form><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p>";
	echo "</div></div>";
}	

if ($accion == 'recursos' AND $n) {
	$sql = "SELECT recursos FROM podpaneles WHERE n = '$n'";
	$result = $ilink->query($sql);
	if ($ilink->errno) {echo $ilink->errno; exit;}
	$fila = $result->fetch_array(MYSQLI_BOTH);
	winop("Recursos",'div1','');
	echo "<form name='form1' method='post'>";
	echo "<input class='col-2' type='submit' value=\"".i("agvalid",$ilink)."\"><br>";
	$rec = explode("$$",$fila[0]);
	foreach ($rec as $clave => $valor) {
		$dat = explode("**",$valor);
		echo "<input type='text' name='recu[$clave][0]' size='100' maxlength='100' value=\"$dat[0]\" placeholder='URL'><br>";
		echo "<input type='text' name='recu[$clave][1]' size='100' maxlength='100' value=\"$dat[1]\" placeholder='Texto'><p></p>";
	}
	echo "<input type='hidden' name='r1ecursos' value=1>";
	echo "</form>";
	echo "</div></div>";
}

if ($accion == 'editar' AND $n) {
	$sql = "SELECT * FROM podpaneles WHERE n = '$n'";
	$result = $ilink->query($sql);
	if ($ilink->errno) {echo $ilink->errno; exit;}
	$fila = $result->fetch_array(MYSQLI_BOTH);
	winop(i("editar1",$ilink),'div1','');
	echo "<form name='form1' method='post' onsubmit='return prueba(form1)'>";
	echo "<span class='fr rojo b'>BORRAR <input type='checkbox' name='borrar'></span>";
	echo "<label class='b'>Título del Panel</label><br>";
	echo "<input class='col-10' type='text' name='edpanel' size='50' maxlength='254' value=\"$fila[2]\"><br>";
	echo "<label class='b'>Profesores integrantes</label>";
	echo " &nbsp; <input class='col-2' type='submit' value=\"".i("agvalid",$ilink)."\">";
	$sql = "SELECT id, pacadem, mensaje, despacho, telefono FROM usuarios WHERE tipo = 'P' AND fechabaja = '0000-00-00 00:00' ORDER BY alumnoa, alumnon";
	$result = $ilink->query($sql);
	echo "<table class='conhover'>";
	echo "<tr><th></th><th></th><th>".i("pacadem",$ilink)." / Mensaje</th></tr>";
	while ($fila1 = $result->fetch_array(MYSQLI_BOTH)) {
		echo "<tr>";
		echo "<td class='col-01'><input type='checkbox' name=\"usuenv$fila1[0]\"";
		if(strpos("**".$fila[3],"*".$fila1[0]."*")) {echo " checked='checked'";$che = 1;}
		echo "></td><td>";
			$usu = ponerusu($fila1['id'],1,$ilink);
			echo $usu[0].$usu[1];
		echo "</td>";
		echo "<td>";
		if($che) {
			$che = "";
			echo "<div class='peq'>Pag.</div><input type='text' name='pacadem$fila1[0]' size='50' maxlength='500' value=\"$fila1[1]\">";
			echo "<div class='peq'>Mensaje</div><input type='text' name='mens$fila1[0]' size='50' maxlength='200' value=\"$fila1[2]\">";
			echo "<div class='peq'>Despacho</div><input type='text' name='desp$fila1[0]' size='50' maxlength='50' value=\"$fila1[3]\">";
			echo "<div class='peq'>Teléfono</div><input type='text' name='telf$fila1[0]' size='15' maxlength='15' value=\"$fila1[4]\">";
		} else {
			echo $fila1[1];
		}
		echo "</td>";
		echo "</tr>";
	}
	echo "</table>";
	echo " &nbsp; <input class='col-2' type='submit' value=\"".i("agvalid",$ilink)."\">";
	echo "<input type='hidden' name='editar1' value=1>";
	echo "</form><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p>";
	echo "</div></div>";
}	

if($activar) {

	$sql = "SELECT activo FROM podpaneles WHERE n=$activar";
	$result = $ilink->query($sql);
	$fila1 = $result->fetch_array(MYSQLI_BOTH);
	if($fila1[0]) {$activo = "";} else {$activo = 1;}
	$ilink->query("UPDATE podpaneles SET activo = '$activo' WHERE n=$activar");	
	
}

$sql = "SELECT * FROM podpaneles ORDER BY n DESC";

$result = $ilink->query($sql);

echo "<table class='conhover'>";

echo "<tr><th class='col-1'><a href='?pest=$pest&accion=anadir'>A&ntilde;adir</a></th>";
echo "<th class='col-7'>Panel</th>";
echo "<th class='col-05'>Profesores</th>";
echo "</tr>";

while ($fila = $result->fetch_array(MYSQLI_BOTH)) {
	echo "<tr>";

	echo "<td>";
	
	echo "<a href='?pest=$pest&activar=$fila[0]'>";
	if($fila[1]) {echo "Desactivar";} else {echo "Activar";}
	echo "</a><br>";
	
	echo "<a href='?pest=$pest&accion=editar&n=$fila[0]'>Editar</a><br>";
	echo "<a href='?pest=$pest&accion=recursos&n=$fila[0]'>Recursos</a><br>";
	echo "<a href='../panel.php?n=$fila[0]&pver=1&curso=".$_SESSION['curso']."'><div class='icon-eye verdecalific grande'></div></a></td>";

	echo "<td>$fila[2]</td><td>";

	echo substr_count($fila[3], '*');
	
	echo "</td></tr>";
	
}

echo "</table>";


?>