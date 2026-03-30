<?php

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

if ($_SESSION['auto'] < 5 OR $usuid != $_SESSION['usuid']) {return;}

echo "<p></p><br><a class='mediana b txth' target='_blank' href = 'blogs/wp-login'>Entrar en Blogs</a>";

?>