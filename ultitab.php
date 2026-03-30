<?php

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

$auto = $_SESSION['auto'];
$uid= $_SESSION['usuid'];
$asigna= $_SESSION['asigna'];

if(!$asigna AND $_SESSION['auto'] < 10) {return;}

// --------------------------------------------------

$n_at = $_GET['n_at'];
$f_at = $_GET['f_at'];

if (!$n_at) {$n_at = 1;}

if (!$asigna) {$n_at = 2;}

?>

<div class="caja__head"><h3 class="caja__title">

	<?php

	echo "<a href='mitablon.php?titasi=$titasi'>".i("tablanunc",$ilink)."</a> &nbsp; ";

	if ($n_at != 2) {
		echo "<a href='?n_at=2&f_at=$f_at'>$asigna $curso $grupo</a>";	
	} else {
		echo "<a href='?n_at=1&f_at=$f_at'>".i("todotablon",$ilink)."</a>";
	}	
	
	?>

</h3></div>

<?php

$filtro = "";

if ($n_at == 1) {
	$filtro = " AND asigna = '$asigna'";
	if ($curso AND $curso != "*") {$filtro .= " AND curso = '$curso'";}
	if ($grupo AND $grupo != "*") {$filtro .= " AND grupo = '$grupo'";}
}

?>

<div class="caja__body">

<?php

notis(5,0,$filtro,0,"",$ilink);

?>
</div>
