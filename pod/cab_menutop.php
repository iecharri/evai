<?php

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

?>

<div class='top1'>

<a class="menu" onclick="openNav()"><span class="icon-menu"></span>
<span class='anch'><br><?php echo $anch;?></span><span class='estrech'><br><?php echo $estr;?></span> POD</a>

</div>

<?php 

echo "<div class='casigna'>";

echo "<a $a_profe href='pod.php?pest=6'><span class='icon-checkmark'></span> Profesores</a> &nbsp;";
echo "<a $a_asitu href='pod.php?pest=7'><span class='icon-checkmark'></span> Asignaturas</a> &nbsp;";
echo "<a $a_asign href='pod.php?pest=8'><span class='icon-checkmark'></span> Asignaciones</a>";

echo "</div>";

?>