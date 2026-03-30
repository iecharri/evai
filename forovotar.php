<?php

require_once __DIR__ . '/siempre.php';

$id = $_POST['id'];
$voto = $_POST['voto'];
$usuid = $_SESSION['usuid'];
$date = gmdate("Y-m-d H:i:s");

//ver si ya he votado ese foro
$sql = "SELECT voto FROM forovotos WHERE usuid = '$usuid' AND id = '$id'";
$result = $ilink->query($sql);

if (!$result->num_rows){

	$sql = "INSERT INTO forovotos (id, usuid, voto, fecha) VALUES ('$id', '$usuid', '$voto', '$date')";
	$ilink->query($sql);

} else {

	$voto = $result->fetch_array(MYSQLI_BOTH);
	$voto = $voto[0];

}

$sql = "SELECT SUM(voto), COUNT(voto) FROM forovotos WHERE id = '$id'";
$result = $ilink->query($sql);
$fila = $result->fetch_array(MYSQLI_BOTH);

$temp = ($fila[0] / $fila[1]);

$ilink->query("UPDATE foro SET voto = '$temp' WHERE id = '$id'");

$sql = "SELECT COUNT(voto) FROM forovotos WHERE id = '$id'";
$result = $ilink->query($sql);
if ($result->num_rows) {
	$fila = $result->fetch_array(MYSQLI_BOTH);
	$cantivot = $fila[0];
}
	
votos_foro($id,$temp,$voto,$cantivot);

function votos_foro($id,$num,$voto,$cantivot) {


	
	echo "<p></p>";
	if(!$num) {
		$resto = 10;
	} else {
		$int = intval($num);
		$deci = ($num - $int);
		$resto = (10 - $int);
		if($deci) {$resto--;}
	}
	
	$i = $j = 1;
	
	if($int) {
		for ($i = 1; $i <= $int; $i++) {
   		echo "<span id='v$id"."_"."$i' class='icon-star-full grande'></span> ";
		}
		$j = $i;
	}
	
	if($deci) {
   	echo "<span id='v$id"."_"."$j' class='icon-star-half grande'></span> ";
   	$j = ($j + 1);
	}
	
	for ($i = $j; $i <= 10; $i++) {
   	echo "<span id='v$id"."_"."$i' class='icon-star-empty grande nob'></span> ";
	}
	
	if($voto) {echo " &nbsp; <span class='icon-star-full grande'></span>".$voto;}
	if($cantivot) {echo "<br>$cantivot votos";}	
}

?>

