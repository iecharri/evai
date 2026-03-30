<?php

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

if ($_SESSION['auto'] < 10) {exit;}

extract($_GET);

// --------------------------------------------------

unset($array);

$array[0] = "<a href='#'>M&aacute;quinas &nbsp; <span class='icon-arrow-right'></span></a>";
$array[1] = "<a href='#' onclick=\"show('divxx1')\" >".i("quees",$ilink)."</a>\n";

solapah($array,1,"navhsimple");

// --------------------------------------------------

$sql = "SELECT * FROM maquinas"; 
$result = $ilink->query($sql);



wintot1("helpadmin.html",'',"divxx1",'IP',1,$ilink);
	
if($_GET['id']) {
	wintot1("maquinas1.php",'',"divm",'IP','',$ilink);
}

echo "<table>";

echo "<tr><th>IP</th><th>".i("nombre",$ilink)."</th><th>Saludo</th><th>Autorizado</th><th>Observaciones</th></tr>\n";

while ($fila = $result->fetch_array(MYSQLI_BOTH)) 

{
	echo "<tr>";
	echo "<td><a href='?pest=2&id=".$fila['id']."'>".$fila['ip']."</a></td><td>".$fila['nombre']."</td><td>".$fila['saludo']."</td><td>".$fila['autorizado']."</td><td>".$fila['obs']."</td></tr>\n";
}

echo "</table>\n";

function totime($buffer)
	{ 
		$buffer = mktime(substr($buffer,8,2),substr($buffer,10,2),substr($buffer,12,2),substr($buffer,4,2),substr($buffer,6,2),substr($buffer,0,4)); 
		return($buffer); 
}

?>
