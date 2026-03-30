<?php

require_once __DIR__ . "/../siempre_base.php";

$timestamp = time(); // UTC actual
$corte = gmdate('Y-m-d H:i:s', $timestamp - 8); // hace 8 segundos

$sql = "SELECT usuid, asigna FROM chat WHERE fecha <= '$corte'";

$iresult = $ilink->query($sql);
$num = $iresult->num_rows;

$_SESSION['borr'] = 0;

if ($num) {
	$result = $ilink->query($sql);
	
	while ($fila=$result->fetch_array(MYSQLI_BOTH)){
		$usuborr=$fila[0];$asiborr=$fila[1];
		
		$sale = gmdate("Y-m-d H:i:s"); // UTC real para guardar en BD
		//$zona = $_SESSION['zone'] ?? 'UTC'; // por si acaso
		$temp = "sale el ".utcausu1($sale); //." en $zona";

		$ilink->query("INSERT INTO chatlista (asigna, usuid, texto, fecha) VALUES ('$asiborr', '$usuborr', \"<span class='rojo peq'>$temp</span>\", '$sale')");
		$ilink->query("DELETE FROM chat WHERE usuid = '$usuborr' AND asigna = '$asiborr'");
	}
	
	$ilink->query("UPDATE chat SET r_txt=1, r_usu=1 WHERE asigna='$a'"); // qué es $a? será en chats de Recursos, clase directo
	$_SESSION['borr'] = 1;
}

?>
