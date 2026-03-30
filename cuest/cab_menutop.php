<?php

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

if($script == "cueval" OR $script == "cuestionario") {
	
	?>

	<div class='top1'>

		<a href='<?php echo APP_URL;?>/home.php' class="menu"><span class="icon-home"></span>
		<span class='anch'><br><?php echo ucfirst(SITE);?></span><span class='estrech'><br><?php echo ucfirst(SITE);?></span></a>

	</div>

	<?php	

	if($script == "cueval") {
	
		echo " &nbsp;<a href='?'>Cuestionarios y Evaluaciones</a> ";
	
	}
	
	if($bolsa) {echo " - <a href='?bolsa=$bolsa'>".strtoupper($bolsa)."</a>";}
	if($cuest) {echo "<br>&nbsp;".$cuest;}
	return;
	
}

if($_SESSION['indep']) {
	echo "<div class='menu'><a href='../index.php'><span class='icon-menu'></span>
	<span class='anch'><br>".ucfirst(SITE)."</span><span class='estrech'>$estr</span></a></div>";
	return;
}

echo "<div class='menu0'>";

	//echo "<span class='icon-menu'></span>";
	echo "<span class='anch'><br>".ucfirst(SITE)."</span><span class='estrech'><br>".ucfirst(SITE)."</span> ".$titulo;

echo "</div>";

?>


