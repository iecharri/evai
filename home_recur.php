<?php

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

require_once APP_DIR . "/ponerobject.php";

?>

    <div class="caja__head"><h3 class="caja__title">

<?php

unset($array);
$array = array();

$array[] = "<a href='indexrecursos.php?op=1'>".i("otrosrecur",$ilink)." ".$_SESSION['asigna']." ".$_SESSION['curso']." ".$_SESSION['grupo']."</a>".
				" &nbsp; <a href='indexrecursos.php?op=1' title=\"".i("mas",$ilink)."\">";

echo $array[0];

?>

</h3></div>


<?php

$solover = 1;

$solo = 6;

$noponer = 1;
$solover = '';

if($nohay AND $_SESSION['auto'] < 5) {
	$noponer = $solover = "";
}

?>

<div class="caja__body">
<?php

require_once APP_DIR . '/recursos.php';

?>

</div>

<?php

$noponer = $solover = "";

?>