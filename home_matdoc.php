<?php

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

?>

<article class='caja'>

<div class="caja__head"><h3 class="caja__title">
    
   <?php
	echo "<a href='indexrecursos.php?op=4'>".i("matdocente",$ilink)." ".$_SESSION['asigna']." ".$_SESSION['curso']." ".$_SESSION['grupo']."</a>";// &nbsp; <a href='indexrecursos.php?op=4' title=\"".i("mas",$ilink)."\"><span class='icon-plus fr'></span></a>";
	?>

</h3></div>

<div class="caja__body">
<object type="text/html" data="home_matdoc_guia.php?carpeta=md" class='col-10' style='height:100%;background:white'></object>
</div>

</article>
