<?php

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

?>

<ul class='laterall'>

<?php

if (!$pest) {$pest = 8;}

echo "<li><a $a_areas href='pod.php?pest=1'><span class='icon-checkmark'></span> &Aacute;reas</a></li>";
echo "<li><a $a_titul href='pod.php?pest=2'><span class='icon-checkmark'></span> Titulaciones</a></li>";
echo "<li><a $a_grasi href='pod.php?pest=3'><span class='icon-checkmark'></span> Grupos de Asignaturas</a></li>";
echo "<li><a $a_figur href='pod.php?pest=4'><span class='icon-checkmark'></span> Figuras</a></li>";
echo "<li><a $a_cargo href='pod.php?pest=5'><span class='icon-checkmark'></span> Cargos</a></li>";
echo "<li><a $a_profe href='pod.php?pest=6'><span class='icon-checkmark'></span> Profesores</a></li>";
echo "<li><a $a_asitu href='pod.php?pest=7'><span class='icon-checkmark'></span> Asignaturas</a></li>";
echo "<li><a $a_asign href='pod.php?pest=8'><span class='icon-checkmark'></span> Asignaciones</a></li>";
echo "<li><a $a_repos href='pod.php?pest=9'><span class='icon-checkmark'></span> Repositorio</a></li>";
echo "<li><a $a_envim href='pod.php?pest=10'><span class='icon-checkmark'></span> Enviar mails</a></li>";

if ($_SESSION['auto'] == 10) {
	
	echo "<li><a $a_creda href='pod.php?pest=11'><span class='icon-checkmark'></span> Resumen Cr&eacute;ditos por asignar</a></li>";
	echo "<li><a $a_envima href='pod.php?pest=12&m=1'><span class='icon-checkmark'></span> Enviar mails Admin.</a></li>";
	echo "<li><a $a_recim href='pod.php?pest=13'><span class='icon-checkmark'></span> Mails recibidos</a></li>";
	echo "<li><a $a_admip href='pod.php?pest=14'><span class='icon-checkmark'></span> Administradores POD</a></li>";
	echo "<li><a $a_recalcu href='pod.php?pest=15'><span class='icon-checkmark'></span> Recalcular Cr&eacute;ditos y Asignaciones</a></li>";
	echo "<li><a $a_paneles href='pod.php?pest=16'><span class='icon-checkmark'></span> Paneles</a></li>";
	
}

?>

</ul>
