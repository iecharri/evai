<?php

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

$auto = $_SESSION['auto'];
$uid= $_SESSION['usuid'];
$asigna= $_SESSION['asigna'];

// --------------------------------------------------

$n_at = $_GET['n_at'];
$f_at = $_GET['f_at'];

if (!$f_at) {$f_at = 1;}
if (!$asigna) {$f_at = 2;}

?>

<!--   <article class="caja caja h-260"> -->
    <div class="caja__head"><h3 class="caja__title">

<?php

//echo "<div class='colu1'>";

echo "<a href='foros.php?titasi=$titasi'>".i("foro",$ilink)."</a> ";

if ($asigna) {
	if ($f_at == 2) {
		echo "<a href='?n_at=$n_at&f_at=1'>".i("todotablon",$ilink)."</a>";
	} else { 
		echo "<a href='?n_at=$n_at&f_at=2'>$asigna $curso $grupo</a>";
	}
}

//echo" &nbsp; <a href='foros.php?titasi=$titasi' title=\"".i("mas",$ilink)."\"><span class='icon-plus fr'></span></a>";

?>


</h3></div>

<?php

$filtro = "";

if ($f_at == 1) {
	$filtro = " AND !foro_id AND asigna = '$asigna'";
	if ($curso AND $curso != "*") {$filtro .= " AND curso = '$curso'";}
	if ($grupo AND $grupo != "*") {$filtro .= " AND grupo = '$grupo'";}
}

// ---------------------------- poner &uacute;ltimos mensajes del foro 

$sqlfor = "SELECT * FROM foro WHERE 1=1";
if ($_SESSION['auto'] < 10) {$sqlfor .= " AND !invisible";}
$sqlfor .= " $filtro ORDER BY fecha DESC"; //con $filtro lo prefieren, solo se ver&aacute;n las cabeceras de los foros cuando se ven los de asignatura 
$resultfor = $ilink->query($sqlfor);

?>

<div class="caja__body">

<?php $n=0;

while ($fila = $resultfor->fetch_array(MYSQLI_BOTH)) {
	if (lopuedover($fila,$ilink)) {
		ultiforos($fila,$ilink);
		$n++; 
		if ($n == 5) {break;}
	}		
}

?>
</div>
