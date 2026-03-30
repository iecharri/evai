<?php

require_once __DIR__ . '/siempre.php';

// --------------------------------------------------

$array = array();

$array[] = i("coment",$ilink); //$_SESSION['asigna']." - ".

$titpag = "<span class='icon-pencil'></span> ".i("coment",$ilink);
$a_comen = " class = 'active'";
require_once APP_DIR . '/molde_top.php';

echo "$titpag <span class='icon-arrow-right' ></span> ";
$array[0] = i("coment",$ilink);
solapah($array,1,"navhsimple");

// --------------------------------------------------

$conta = $_GET['conta'];

require_once APP_DIR . '/coment.php';

require_once APP_DIR . '/molde_bott.php';

?>


