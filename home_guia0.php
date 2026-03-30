<?php

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

?>

<div class="caja__head"><h3 class="caja__title">
	<?php 
	echo i("guiadocen",$ilink)." ".$_SESSION['tit']." ".$_SESSION['curso'];
	?></h3>
</div>

<div class='caja__body'>
	<object type="text/html" data="home_matdoc_guia.php?carpeta=gdt" class='col-10' style='height:100%;background:white'></object>
</div>
