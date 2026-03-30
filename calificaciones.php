<?php

require_once __DIR__ . '/siempre.php';

$a_calif = " class = 'active'";
require_once APP_DIR . '/molde_top.php';

unset($array);
$array[0] = "<a href='#'><span class='icon-dice'></span> ".i("calific",$ilink)." <span class='icon-arrow-right'></span></a>";
solapah($array,1,"navhsimple");

require_once APP_DIR . '/perfil/calificaciones.php';

require_once APP_DIR . '/molde_bott.php';

?>
