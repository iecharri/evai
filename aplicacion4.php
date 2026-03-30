<?php 

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

$_SESSION['nuevos'] = "**";

if (esprofesor($_SESSION['asigna'],$_SESSION['curso'],$_SESSION['grupo'],$ilink)) {
	
	if ($act AND !$cl) {
		if ($act == 1) {$temp = 1;}
		if ($act == 2) {$temp = '';}
		$ilink->query("DELETE FROM mandoadist WHERE 
		asigna = '".$_SESSION['asigna']."' AND curso = '".$_SESSION['curso']."' AND grupo = '".$_SESSION['grupo']."'");
		$ilink->query("UPDATE cursasigru SET mandoadist = '$temp' WHERE
		asigna = '".$_SESSION['asigna']."' AND curso = '".$_SESSION['curso']."' AND grupo = '".$_SESSION['grupo']."'");
	}

}

?>

<script language="javascript">
function mandocontrol(){	
	$.post("aplicacion41.php", function(data){$("#mandocontrol").html(data);});			
}
timer2 = setInterval("mandocontrol()", <?php echo (5000);?>);
function mandoestad(){	
	$.post("aplicacion42.php", function(data){$("#mandoestad").html(data);});			
}
</script>


<div id="mandocontrol" class='di'>
<script language="javascript">mandocontrol();</script>
</div>

<div id="mandoestad"></div>
