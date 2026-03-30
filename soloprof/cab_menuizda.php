<?php

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

?>

<ul class='laterall'>

<?php

switch($op) {
	case 1:

	echo "<li><a $pesta1 href='?pest=1'><span class='icon-checkmark'></span> General</a></li>";
	echo "<li><a $pesta2 href='?pest=2'><span class='icon-checkmark'></span> ".i("usus",$ilink)."</a></li>";
	echo "<li><a $pesta3 href='?pest=3'><span class='icon-checkmark'></span> GIC</a></li>";
	echo "<li><a $pesta4 href='?pest=4'><span class='icon-checkmark'></span> ".i("textaenvi",$ilink)."</a></li>";
	echo "<li><a $pesta5 href='?pest=5'><span class='icon-checkmark'></span> ".i("notas",$ilink)."</a></li>";
	echo "<li><a $pesta7 href='?pest=7&m=1'><span class='icon-checkmark'></span> ".i("comunicaciones",$ilink)."</a></li>";
	echo "<li><a $pesta9 href='?pest=9$param'><span class='icon-checkmark'></span> ".i("recur",$ilink)."</a></li>";
	echo "<li><a $pesta11 href='?pest=11'><span class='icon-checkmark'></span> ".i("practext",$ilink)."</a></li>";
	echo "<li><a $pesta12 href='?pest=12'><span class='icon-checkmark'></span> ".i("trabpers",$ilink)."</a></li>";
	echo "<li><a $pesta13 href='?pest=13'><span class='icon-checkmark'></span> Trabajos Grupos</a></li>";
	echo "<li><a $pesta14 href='?pest=14'><span class='icon-checkmark'></span> ".i("fichs",$ilink)."</a></li>";
	echo "<li><a $pesta15 href='?pest=15'><span class='icon-checkmark'></span> Asistencia</a></li>";
	break;

	case 2:

	echo "<li><a $pesta1 href='?pest=1$param'><span class='icon-checkmark'></span> General</a></li>";
	echo "<li><a $pesta7 href='?pest=7$param&m=1'><span class='icon-checkmark'></span> simple mail</a></li>";
	echo "<li><a $pesta9 href='?pest=9$param'><span class='icon-checkmark'></span> ".i("recur",$ilink)."</a></li>";
	echo "<li><a $pesta11 href='?pest=11'><span class='icon-checkmark'></span> ".i("practext",$ilink)."</a></li>";
	echo "<li><a $pesta12 href='?pest=12'><span class='icon-checkmark'></span> ".i("fichs",$ilink)."</a></li>";
	break;

	case 3:
		
	echo "<li><a $pesta1 href='?pest=1'><span class='icon-checkmark'></span> General</a></li>";
	echo "<li><a $pesta2 href='?pest=2'><span class='icon-checkmark'></span> M&aacute;quinas</a></li>";
	echo "<li><a $pesta3 href='?pest=3'><span class='icon-checkmark'></span> Usuarios</a></li>";
	echo "<li><a $pesta5 href='?pest=5&m=1'><span class='icon-checkmark'></span> Comunicaciones</a></li>";
	echo "<li><a $pesta6 href='?pest=6'><span class='icon-checkmark'></span> Mails sistema</a></li>";
	echo "<li><a $pesta9 href='?pest=9'><span class='icon-checkmark'></span> Uso del sistema</a></li>";
	echo "<li><a $pesta10 href='?pest=10'><span class='icon-checkmark'></span> Actividad en Carpetas</a></li>";
	if ($_SESSION['soy_superadmin']) {echo "<li><a $pesta11 href='?pest=11'><span class='icon-checkmark'></span> Consultas</a></li>";}
	//echo "<li><a $pesta12 href='?pest=12'><span class='icon-checkmark'></span> Reuniones</a></li>";
	echo "<li><a $pesta13 href='?pest=13'><span class='icon-checkmark'></span> ".i("fichs",$ilink)."</a></li>";
	echo "<li><a $pesta14 href='?pest=14'><span class='icon-checkmark'></span> ".ucfirst(i("mensajes",$ilink))."</a></li>";

}

?>

</ul>



