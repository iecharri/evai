<?php

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

$d1 = $_POST['d1'];
$d2 = $_POST['d2'];

if ($_GET['d1']) {
	$d1 = $_GET['d1'];
	$d2 = $_GET['d2'];
	$_POST['vercamb'] = 1;
}

if (!$d1) {
	$d1 = hoyUsu();
	$d2 = hoyUsu();
}

$usu = $_GET['usu'];
$d1a = $d1;
$d2a = $d2;

$d1utc_str = usuautc1($d1,'');
$d1utc = $d1utc_str[0] . ' ' . '00:00:00';

$d2utc_str = usuautc1($d2,'');
$d2utc = $d2utc_str[0] . ' ' . '23:59:59';

// --------------------------------------------------

unset($array);

$array[0] = "<a href='#'>Actividad en Carpetas <span class='icon-arrow-right'></span></a>";
solapah($array,1,"navhsimple");

// --------------------------------------------------

if ($usu) {
	$mens = "&nbsp; &nbsp; <a href='?op=3&pest=$pest&d1=$d1&d2=$d2'>No filtrar por usuario</a>";
	$usua = ponerusu($usu,1,$ilink);
	echo $usua[0].$usua[1].$mens;
}

echo "<form name='accesos' method='post' action = '?pest=$pest&usu=$usu'>";
echo "Actividad entre el ";
echo "<input type='text' name='d1' size='10' maxlength='10' value='$d1a' class='col-1 datepicker'>";
echo " y el ";
echo "<input type='text' name='d2' size='10' maxlength='10' value='$d2a' class='col-1 datepicker'>";

if ($d1 OR $d2) {

	if ($d1) {$filtro .= " AND fecha > '$d1utc'";}
	if ($d2) {$filtro .= " AND fecha < '$d2utc'";}
	if ($usu) {$filtro .= " AND usuid = '$usu'";}

	$sql = "SELECT COUNT(id) FROM carpprofregactivi WHERE 1=1".$filtro;
	//$sql1 = "SELECT * FROM carpprofregactivi WHERE 1=1".$filtro;

	$iresult = $ilink->query($sql);
	$cambios = $iresult->fetch_array(MYSQLI_BOTH);

}

echo " <input class='col-1' type='submit' name='postcambios' value = ' >> '>";
	
if ($d1 OR $d2) {

	echo "&nbsp; &nbsp; <span class='mediana b txth'>$cambios[0]</span>";

	if ($cambios[0]) {	
		echo " &nbsp; &nbsp; <input class='col-2' type='submit' name='vercamb' value='Ver actividad'>";
	}

}

echo "</form>";

if (!$_POST['vercamb']) {return;}

// --------------------------------------------------

$sql = "SELECT usuid, accion, exito, carpeta1, fichero1, carpeta2, fichero2, carpprofregactivi.fecha FROM carpprofregactivi
 LEFT JOIN usuarios ON carpprofregactivi.usuid = usuarios.id WHERE 1=1";
if ($d1) {$sql .= " AND carpprofregactivi.fecha > '$d1utc'";}
if ($d2) {$sql .= " AND carpprofregactivi.fecha < '$d2utc'";}
if ($usu) {$sql .= " AND usuid = '$usu'";}

$orden = " carpprofregactivi.fecha DESC";
if ($_GET['ord']) {$orden = " alumnoa, alumnon, carpprofregactivi.fecha DESC";}

$sql .= " ORDER BY $orden";

$result = $ilink->query($sql);

$num = $result->num_rows;

if ($num > 400) {echo "<br>Restringe la b&uacute;squeda a menos de 400 registros."; return;}

// --------------------------------------------------

echo "<table class = 'conhover'>";

echo "<tr>";
echo "<th>Elegir<br>usuario</th>";
echo "<th><a href='?ord=nom&pest=$pest&d1=$d1a&d2=$d2a&usu=$usu'>".i("nombre",$ilink)."</a><br>Fecha</th>";
echo "<th>Acci&oacute;n<br>&Eacute;xito</th>";
echo "<th>De Carpeta<br>Fichero (o Carpeta)</th>";
echo "<th>A carpeta<br>Fichero (o Carpeta)</th>";
echo "</tr>\n";

while ($fila = $result->fetch_array(MYSQLI_BOTH)) {

	extract($fila);
	$exito1 = "<span class='rojo b'>NO</span>";
	if ($exito) {$exito1 = "<span class='txth b'>S&Iacute;</span>";}
	echo "<tr>";
	echo "<td><a href='?pest=$pest&d1=$d1a&d2=$d2a&usu=$usuid'>*</a></td>";
	echo "<td class='peq'>";
	$fec = "<br><span class='nob'>".utcausu1($fecha)."</span>";
	$usu = ponerusu($usuid,1,$ilink);
	echo $usu[0].$usu[1].$fec;
	echo "</td>";
	echo "<td>$accion<br>$exito1</td>";
	$class = "b";
	if ($accion == "Borrar Fichero" OR $accion == "Borrar Carpeta") {$class .= " rojo";}
	if ($accion == "Subir") {$class .= " txth";}
	if(demo_enabled()) {
		$carpeta1 = $carpeta2 = "carpeta no visible en modo demo";
	}
	echo "<td class='peq'>$carpeta1<br><span class='$class'>$fichero1</span></td>";
	echo "<td class='peq'>$carpeta2<br><span class='$class'>$fichero2</span></td>";
	echo "</tr>\n";

}

echo "</table>";

?>