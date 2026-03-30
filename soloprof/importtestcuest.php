<?php

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

// class='modal_btn'
echo "<a href='notas.php?imp=1'> 
Importar notas test de un cuestionario
</a> (antes de hacer la importaci&oacute;n se mostrar&aacute; un aviso). ";
echo "Recuerda poner coeficientes en <a href='soloprof/admin.php?op=1&pest=5' target='_blank'>[Link]</a>.<p></p>";

$hide = 1; if ($_GET['imp'] OR $_GET['table'] OR $_GET['conv'] OR $_GET['imp']) {$hide = '';}

wintot1(APP_DIR . "/soloprof/import1.php",'','divp','Importar notas test de un cuestionario',$hide,$ilink);

?>


