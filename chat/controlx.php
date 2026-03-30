<?php

require_once __DIR__ . "/../siempre_base.php";

$timestamp = time(); // UTC actual
$corte = gmdate('Y-m-d H:i:s', $timestamp - 8); // hace 8 segundos exactos

$sql = "SELECT usuid, asigna FROM chat WHERE fecha <= '$corte'";

$iresult = $ilink->query($sql);
$num = $iresult->num_rows;

$_SESSION['borr'] = 0;

if ($num) {
	$result = $ilink->query($sql);
	
	while ($fila=$result->fetch_array(MYSQLI_BOTH)){
		$usuborr=$fila[0];$asiborr=$fila[1];

		$sale = gmdate("Y-m-d H:i:s"); //se inserta fecha en utc
		$zona = $_SESSION['zone'] ?? 'UTC';
		$temp = "sale el ".utcausu1($sale); //." en $zona"; //se muestra fecha en zona usaurio

		$texto = "<span class='rojo peq'>$temp</span>";
		$texto = $ilink->real_escape_string($texto); // 🔒 importante

		$ilink->query("INSERT INTO chatlista (asigna, usuid, texto, fecha) VALUES ('$asiborr', '$usuborr', '$texto', '$sale')");

		$ilink->query("DELETE FROM chat WHERE usuid = '$usuborr' AND asigna = '$asiborr'");
	}
	$ilink->query("UPDATE chat SET r_txt=1, r_usu=1 WHERE asigna='$asiborr'"); 
	$_SESSION['borr'] = 1;
}

?>
