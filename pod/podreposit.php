<?php

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

$caso = 6; require_once APP_DIR . "/pod/podformfiltro.php";

echo "<br>";

if (!$filtrocurso OR !$filtroarea) {
	echo "<p class='rojo b'>&iexcl;ATENCI&Oacute;N! Seleccionar un CURSO y &Aacute;REA</p>";
	return;
}

// --------------------------------------------------

$dirini = DATA_DIR . "/pod/";
if (!is_dir($dirini)){safe_mkdir($dirini);}

$dirini .= "repositorio/";
if (!is_dir($dirini)){safe_mkdir($dirini);}

$dirini .= $filtroarea."$$".trim($filtrocurso)."/";
if (!is_dir($dirini)){safe_mkdir($dirini);}

$puedounzip=1;

$script = "pod.php?";

$fichphp = APP_URL . "/file.php?n=".base64_encode($dirini);
require_once APP_DIR . "/explorernue.php";

?>
