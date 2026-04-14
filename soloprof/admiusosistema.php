<?php

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

$d1 = $_POST['d1'];
$d2 = $_POST['d2'];

if ($_GET['d1']) {
	$d1 = $_GET['d1'];
	$d2 = $_GET['d2'];
	$_POST['veracc'] = 1;
}

if (!$d1) {
	$d1 = hoyUsu();
	$d2 = hoyUsu();
}

$usu = $_GET['usu'] ?? '';
$d1a = $d1; // Para mantenerlo visible en el input
$d2a = $d2;

$d1utc_str = usuautc1($d1, '');
$d1utc = $d1utc_str[0] . ' ' . '00:00:00';

$d2utc_str = usuautc1($d2, '');
$d2utc = $d2utc_str[0] . ' ' . '23:59:59';

// --------------------------------------------------

unset($filtro);

if ($d1utc) {
	$filtro .= " AND entra >= '$d1utc'";
}
if ($d2utc) {
	$filtro .= " AND ((sale != '0000-00-00 00:00:00' AND sale <= '$d2utc')";
	$filtro .= " OR (sale = '0000-00-00 00:00:00' AND entra <= '$d2utc'))";
}
if ($usu) {
	$filtro .= " AND id = '$usu'";
}

$sql = "SELECT COUNT(rowid) FROM usosistema WHERE 1=1 $filtro";
$sql1 = "SELECT SUM(TIME_TO_SEC(TIMEDIFF(sale, entra))) AS diff FROM usosistema WHERE sale != '0000-00-00 00:00:00' $filtro";

$iresult = $ilink->query($sql);
$accesos = $iresult->fetch_array(MYSQLI_BOTH);
$iresult = $ilink->query($sql1);
$totime = $iresult->fetch_array(MYSQLI_BOTH);

echo "<form name='accesos' method='post' action='?pest=$pest&usu=$usu'>";
echo "Accesos desde el ";
echo "<input type='text' name='d1' size='10' maxlength='10' value='$d1a' class='col-1 datepicker'>";
echo " hasta el ";
echo "<input type='text' name='d2' size='10' maxlength='10' value='$d2a' class='col-1 datepicker'>";
echo " <input class='col-1' type='submit' name='postaccesos' value=' >> '>";

if ($d1utc || $d2utc) {
    echo "&nbsp; &nbsp; <span class='mediana b txth'>$accesos[0]</span>";
    if ($accesos[0]) {
        echo " &nbsp; &nbsp; <input class='col-2' type='submit' name='veracc' value='Ver accesos'>";
    }
}

echo "</form>";

echo  "<br><span class='peq'>Total: ".sgtodate($totime[0])."</span>";

if (!$_POST['veracc']) {return;}

// --------------------------------------------------

$sql = "SELECT entra, sale, usosistema.ip, alumnon, alumnoa, usosistema.id, TIMEDIFF(sale, entra) AS diff FROM usosistema
 LEFT JOIN usuarios ON usosistema.id = usuarios.id WHERE 1=1";
if ($d1) {$sql .= " AND entra >= '$d1utc'";}
if ($d2) {$sql .= " AND sale <= '$d2utc'";}
if ($d2) {
	$sql .= " AND ((sale != '0000-00-00 00:00:00' AND sale <= '$d2utc')";
	$sql .= " OR (sale = '0000-00-00 00:00:00' AND entra <= '$d2utc'))";
}
if ($usu) {$sql .= " AND usosistema.id = '$usu'";}
$orden = " entra DESC";
if ($_GET['ord']) {$orden = " alumnoa, alumnon, entra DESC";}

$sql .= " ORDER BY $orden";

$result = $ilink->query($sql);

$num = $result->num_rows;

if ($num > 400) {echo "<br>Restringe la b&uacute;squeda a menos de 400 registros."; return;}

// --------------------------------------------------

echo "<table class='conhover'>";

echo "<tr>";
echo "<th>Elegir<br>usuario</th>";
echo "<th><a href='?ord=nom&pest=$pest&d1=$d1a&d2=$d2a&usu=$usu'>".i("nombre",$ilink)."</a></th>";
echo "<th>Entra</th>";
echo "<th>Sale</th>";
echo "<th>IP</th>";
echo "<th>Tiempo</th>";
echo "</tr>\n";

require_once APP_DIR . "/soloprof/geoip.inc";
// read GeoIP database
$handle = geoip_open("GeoIP.dat", GEOIP_STANDARD);

while ($fila = $result->fetch_array(MYSQLI_BOTH)) {

	$lugar = lugar($fila['ip'], $handle);
	echo "<tr>";
	echo "<td><a href='?pest=$pest&d1=$d1a&d2=$d2a&usu=".$fila['id']."'>*</a></td>";
	echo "<td class='peq'>";
	$usu = ponerusu($fila['id'],1,$ilink);
	echo $usu[0].$usu[1];
	echo "</td>";
	echo "<td>".utcausu1($fila['entra'])."</td>";
	$temp = ""; 
	if ($fila['sale'] != "0000-00-00 00:00:00") {
		$temp = utcausu1($fila['sale']);
	}
	echo "<td>".$temp."</td>";
	echo "<td>";
	if (demo_enabled()) {
		echo " <span class='rojo b'>DEMO VERSION</span>";
	} else {
		echo $fila['ip']."<br>".$lugar;
	}
	echo "</td>";
	echo "<td>";
	if ($fila['sale'] > 1) {echo $fila['diff'];}
	echo "</td>";
	echo "</tr>\n";

}

echo "</table>";

geoip_close($handle);

// --------------------------------------------------

function lugar($ip, $handle) {

$lugar = geoip_country_name_by_addr($handle, $ip) . " (" . geoip_country_code_by_addr($handle, $ip) . ")";
return $lugar;

}

// --------------------------------------------------

function sgtodate($totaltiempo) {
	
$seg = ($totaltiempo%60);
$minutos = floor($totaltiempo/60);
$mn = ($minutos%60);
$horas = floor($minutos/60);
$h = ($horas%24);
$dias = floor($horas/24);
if ($dias) {$ret = "$dias d&iacute;as";}
if ($h) {
	if ($dias) {$ret .= ", ";}
	$ret .= "$h horas";
}
if ($mn) {
	if ($ret) {$ret .= ", ";} 
	$ret .= "$mn minutos";
}
if ($seg) {
	if ($ret) {$ret .= ", ";}
	$ret .= "$seg segundos";
}

return $ret;
	
}

// --------------------------------------------------

function actualiza($ilink) {

$sql = "ALTER TABLE usosistema DROP rowid";
$result = $ilink->query($sql);
$sql = "ALTER TABLE usosistema ADD rowid INT(15) NOT NULL AUTO_INCREMENT FIRST, ADD PRIMARY KEY (rowid)";
$result = $ilink->query($sql);

$sql = "SELECT * FROM usosistema WHERE sale != '0000-00-00 00:00:00' ORDER BY id, sale DESC, entra DESC";
$result = $ilink->query($sql);

$controlid = "*";
$controlsale = "*";
$controlentra = "*";

while ($fila = $result->fetch_array(MYSQLI_BOTH)) {

	extract($fila);
	
	if($controlid != $id) {
		$controlid = $id;
		$controlsale = $sale;
		$controlentra = $entra;
		continue;
	}
	
	if($controlsale == $sale) {
		$sql1 = "DELETE FROM usosistema WHERE rowid = '$rowid'";
		$ilink->query($sql1);
	} else {
		$controlsale = $sale;
		$controlentra = $entra;
	}

}

}


?>