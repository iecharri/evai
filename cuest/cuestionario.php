<?php

require_once __DIR__ . '/../siempre.php';
require_once APP_DIR . '/cuest/tablaevalfuncis.php';

$result = $ilink->query("SELECT cuestionario FROM atencion");
$cuestppal = $result->fetch_array(MYSQLI_BOTH);

if (!$cuestppal[0]) {
	
	$nohay = 1;

} else {
	
	iconex(DB2,$ilink);
	$result = $ilink->query("SHOW TABLES LIKE '$cuestppal[0]"."1'") ; 
	if(!$result->num_rows) {
		$nohay = 1;
	}

}

// --------------------------------------------------

iconex(DB1,$ilink);

$titulo = ucfirst(i('cuest',$ilink));

$array1 = array();

$array1[] = "<a href='cuestionario.php'>$titulo</a>";
$array1[] = "<a href='cuestionario.php?resul=1'>Resultados</a>";
$solap = 1;
if ($_GET['resul']) {$solap = 2;}

require_once APP_DIR . '/molde_top.php';

solapah($array1,$solap,"navhsimple");

// --------------------------------------------------

if($nohay) {
	echo "<div>".i("nohaycuesti",$ilink)."</div>";
	require_once APP_DIR . '/molde_bott.php';	
	return;
}

// --------------------------------------------------

$titulo = "";

$cuest = $cuestppal[0];

iconex(DB2,$ilink);

// --------------------------------------------------

// Guardar el cuestionario

// --------------------------------------------------

if ($_POST['envi']) {
	if ($nodis OR $nodis1 != 'abcd') {return;} //para evitar entradas masivas a cuestppal
	echo "<div class='verdecalific mediana center'>Gracias por responder el cuestionario</div><p></p>";
	guardarc($cuest,$ilink);
}

// --------------------------------------------------

if ($resul) {
	resultados($cuest,$ilink);
	require_once APP_DIR . '/molde_bott.php';	
	return;
}

// --------------------------------------------------

//Poner la tabla de preguntas

echo "<form name='form1' id='form1' method='post'>\n";

   ?><div class="nodis">
      <label></label>
      <input type="text" id="nodis" name="nodis">
      <label></label>
      <input type="text" value="abcd" name="nodis1">
   </div><?php //para evitar entradas masivas al cuest ppal

	require_once APP_DIR . '/cuest/cuest_ppal.php'; 
	?>

</form>

<?php

// --------------------------------------------------

require_once APP_DIR . '/molde_bott.php';

// --------------------------------------------------

function resultados($cuesti,$ilink) {

extract($_GET);
extract($_POST);

$tip = 'N';
$sql = "SELECT * FROM $cuesti"."1 WHERE n AND tipo = '$tip'";

$result = $ilink->query($sql); 
while ($fila = $result->fetch_array(MYSQLI_BOTH)) :
	$temp1 = $fila[0];
	$result1 = $ilink->query("SELECT AVG(v1) AS avgv, STDDEV(v1) AS stddevv FROM $cuesti"."2 WHERE n = '$temp1'"); 
	$fila2 = $result1->fetch_array(MYSQLI_BOTH);
	$temp2 = round($fila2[0],2);
	$temp3 = round($fila2[1],2);
	$ilink->query("UPDATE $cuesti"."1 SET m = '$temp2', d = '$temp3' WHERE n = '$temp1'");
endwhile;

$sql = "SELECT MAX(cu) AS cu1 FROM $cuesti"."2";
$result = $ilink->query($sql);
$fila = $result->fetch_array(MYSQLI_BOTH);

echo "<center>N&deg; de Cuestionarios respondidos hasta el momento: ".$fila['cu1']."</center><br><table class='conhover'>\n";

$result = $ilink->query("SELECT * FROM $cuesti"."1 WHERE n AND !n1 ORDER BY orden"); //order by!!!

if ($result->num_rows) {

	echo "<tr><th></th><th>Media</th><th>DT</th></tr>\n";

	while ($fila = $result->fetch_array(MYSQLI_BOTH)) {

		echo "<tr>";
		echo "<td>".$fila[2]."</td>\n";
		echo "<td>";
		if ($fila[8] > 0) {echo $fila[8];}
		echo "</td>\n";
		echo "<td>";
		if ($fila[9] > 0) {echo $fila[9];}
		echo "</td>\n";
		echo "</tr>\n";

	}

}

echo "</table><p></p>";
$tip = 'L';

$sql = "SELECT * FROM {$cuesti}1 WHERE n AND tipo = '$tip'";
$result = $ilink->query($sql); 

while ($fila = $result->fetch_array(MYSQLI_BOTH)) :
	echo "<p>&nbsp;&nbsp;<b>".$fila['p'].":</b><p></p>";

	$temp = $fila['n'];
	$sql1 = "SELECT * FROM {$cuesti}2 WHERE n = '$temp' ORDER BY datetime DESC";
	$result1 = $ilink->query($sql1); 

	while ($fila1 = $result1->fetch_array(MYSQLI_BOTH)) :
		if (strlen($fila1['v3']) > 0) {
			$dtime = utcausu1($fila1['datetime']);
			echo "&nbsp;<span class='icon-checkmark txth'></span> <span class='peq txth'>$dtime </span> ".$fila1['v3']."<p></p>";
		}
	endwhile;
endwhile;

}

// --------------------------------------------------

function guardarc($cuest,$ilink) {


	$sql = "SELECT max(cu) FROM ".$cuest."2";
	$temp = $ilink->query($sql);
	if($temp->num_rows) {
		$fila = $temp->fetch_array(MYSQLI_BOTH);
	}
	$cu = $fila[0] + 1;

	$ip = filter_var($_SERVER['REMOTE_ADDR'], FILTER_VALIDATE_IP) ?: '0.0.0.0';

	$result = $ilink->query("SELECT * FROM ".$cuest."1 WHERE n AND !n1 ORDER BY n");

	while ($fila = $result->fetch_array(MYSQLI_BOTH)) {


		$i = $fila['n'];
		$var = $_POST['v'.$i];
		$tfin = gmdate("Y-m-d H:i:s");
		
		if ($var AND ($fila['input'] == 'check' OR $fila['input'] == 'persiana')) {
			$result1 = $ilink->query("SELECT p FROM ".$cuest."1 WHERE n='$i' AND n1='$var'");
			$fila1 = $result1->fetch_array(MYSQLI_BOTH);
			$var = $fila1[0];
		}

		$sql = "INSERT INTO ".$cuest."2 (cu, u, n, ";
		if (!$fila['input']) {
			$sql = $sql." v2,"; $var="separador";
		} else {
			if ($fila['tipo'] == 'N') {$sql = $sql." v1,";} 
			if ($fila['tipo'] == 'C') {$sql = $sql." v2,";}
			if ($fila['tipo'] == 'L') {$sql = $sql." v3,";}
		}

		$sql = $sql." usuid, datetime) VALUES ('$cu', '$ip', '$i', '$var', '".$_SESSION['usuid']."', '$tfin')";
		$ilink->query($sql);
			
	}
		
}

?>
