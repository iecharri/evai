<?php

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

extract($_GET);
extract($_POST);

if ($nom OR $auto1 OR $sal OR $obs) {
	$ilink->query("UPDATE maquinas SET nombre = '$nom', autorizado = '$auto1', saludo = '$sal', obs = '$obs' WHERE id = '$id'");
}

$result = $ilink->query("SELECT * FROM maquinas WHERE id = '$id'");
$fila = $result->fetch_array(MYSQLI_BOTH);

echo "<h3>".$fila['ip']."</h3>";

echo "<form name='form1' method='post'>\n";

echo i("nombre",$ilink);
echo "<br><input class='col-10' type='text' name='nom' value='".$fila['nombre']."'>";
echo "<br>Saludo";
echo "<br><input class='col-10' type='text' name='sal' value='".$fila['saludo']."'>";
echo "<br>Autorizado";
echo "<br><input class='col-1' type='text' name='auto1' value='".$fila['autorizado']."'>";
echo "<br>Observaciones";
echo "<br><input class='col-10' type='text' name='obs' value='".$fila['obs']."'>";
echo "<input type=hidden name=id value=".$id.">\n";
echo "<input class='col-1' type='submit' value=\"".i("agvalid",$ilink)."\">"; 
echo "</form>";
?>
