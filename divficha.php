<?php

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

?>

<nav id='divficha' style='visibility:hidden'>

<ul>

<?php

require_once APP_DIR . '/cab_menuizdaf.php';

?>

</ul>
</nav>

 <!-- Site Overlay - Oscurece el resto de la pantalla-->
 <div id="site-overlay1" style='display:none' onclick="openFic()"></div>