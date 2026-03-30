<?php

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

if ($_SESSION['auto'] < 5) {
	exit;
}

echo "Copiar Base de Datos de preguntas de <span class='b'>".strtoupper($bolsa)."</span> a la Asignatura<br>";
echo "(Asignaturas que administras, elige una del listado)"; 

echo "<form name='copiar' method='post'><input class='col-1 peq' type='submit' name='copiar2' value='>>COPIAR>>'>";
echo "<p></p><input type='hidden' name='op' value='$op'>";
echo "<input type='hidden' name='copiar' value='1'>";
echo "<select name='copiar1' size='18'>";

iconex(DB1,$ilink);

$result = $ilink->query("SELECT cod, asignatura FROM podasignaturas ORDER BY cod");
while ($fila = $result->fetch_array(MYSQLI_BOTH)) {
	if (esprofesor($fila[0],0,0,$ilink)) {
		echo "<option value='$fila[0]'";
		if ($fila[0] == $copiar1) {echo " selected='selected'";}
		echo ">$fila[0] $fila[1]</option>";
	}
}

iconex(DB2,$ilink);

echo "</select>";
//echo "<p></p><input type='submit' name='copiar2' value='>>COPIAR>>'>";
echo "</form>";

if ($copiar2 AND $copiar1) {
	$temp = strtolower($copiar1)."_";
	$existe = bolsa_existe($temp,$ilink);
	if (!$existe) {
		$ilink->query("CREATE TABLE $temp AS SELECT * FROM ".$bolsa."_");
		echo "<div class='mediana txth'>Preguntas de <span class='b'>strtoupper($bolsa)</span> copiadas a <span class='b'>$copiar1</span>&nbsp;</div>";
	} elseif ($existe == 1) {
		$ilink->query("INSERT INTO $temp SELECT * FROM ".$bolsa."_");
		echo "<div class='mediana txth'>Preguntas de <span class='b'>".strtoupper($bolsa)."</span> copiadas a <span class='b'>$copiar1</span>&nbsp;</div>";
	} elseif ($existe == 2) {
		$max = "SELECT MAX(n) FROM $temp";
		$result = $ilink->query($max);
		$max = $result->fetch_array(MYSQLI_BOTH);
		$sql = "CREATE TEMPORARY TABLE ".$bolsa."_xx AS (SELECT * FROM $bolsa"."_)";
		$ilink->query($sql);
		$sql = "UPDATE ".$bolsa."_xx SET n = n + ".($max[0] + 1);
		$ilink->query($sql);

		$ilink->query("INSERT INTO $temp SELECT * FROM ".$bolsa."_xx");
		//echo "<div class='mediana rojo'>No ha sido posible copiar las preguntas de <span class='b'>".strtoupper($bolsa)."</span> a <span class='b'>$copiar1</span> La Asignatura <span class='b'>$copiar1</span> ya tiene preguntas.&nbsp;</div>";
		echo "<div class='mediana txth'>Preguntas de <span class='b'>".strtoupper($bolsa)."</span> copiadas a <span class='b'>$copiar1</span>&nbsp;</div>";
	}
}

// --------------------------------------------------

function bolsa_existe($busco,$ilink) {

$tablas = $ilink->query("SHOW TABLES FROM ".DB2);
while (list($tabla) = $tablas->fetch_array(MYSQLI_BOTH)) {
	if (strtoupper($busco) == strtoupper($tabla)){
		$existe = 2;
		$iresult = $ilink->query("SELECT * FROM $busco");
		$num = $iresult->num_rows;
		if ($num == 1) {
			//vaciarla, sera la pregunta de prueba
			$ilink->query("DELETE FROM ".$busco." WHERE 1");
			return 1;
		}
	}
}

if (!$existe) {return 0;}

$iresult = $ilink->query("SELECT * FROM $busco");
$num = $iresult->num_rows;
if (!$num) {return 1;}

return 2;

}





?>