<?php 

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

?>

<div class='top1'>

<?php

// --------------------------------------------------

if($script == "plazasext") {
	echo "<a href='". DOMINIO .APP_URL."/index.php' class='menu'> &nbsp; <span class='anch'><br>$anch</span><span class='estrech'>$estr</span></a>";	
	echo "</div>";
	return;	
}

// --------------------------------------------------

?>

<a class="menu" onclick="openNav()"><span class="icon-menu"></span>
<span class='anch'><br><?php echo $anch;?></span>
<span class='estrech'><br><?php echo $estr;?></span>
</a>

<?php if(!$_SESSION['usuid']) {return;}?>

<a class='menu <?php echo $a_home;?>' href='home.php'"><span class="icon-home"><br></span><span class='anch'><?php echo i("inicio",$ilink);?></span></a>
<a class='menu' href="index.php?x=1"><span class="icon-exit"></span><br><span class='anch'><?php echo i("salir",$ilink);?></span></a>
<?php if($_SESSION['auto'] > 9 OR $_SESSION['asigna']) {
	?>
<a class='menu <?php echo $a_misa;?>' href="misasignaturas.php"><span class="icon-books"></span><br><span class='anch'><?php echo i("asignas",$ilink);?></span></a>
	<?php
	}

	//$tut = "http://www.evai.net/evaih/tutoriales/prueba/index.php";
	//if($site == "iidl") {$tut = "/iidl/iidlayuda/iidlp.html";}	
	
	if ($_SESSION['auto'] > 4){
		echo "<div class='peqno'><a class='menu' href='soloprof/admin.php' target='_blank'><span class='icon-wrench'></span><br><span class='anch'>Admin</span></a></div>";
	}
	if ($_SESSION['auto'] == 10){
		echo "<div class='peqno'><a class='menu' href='pod/pod.php?pest=8' target='_blank'><span class='icon-cogs'></span><br><span class='anch'>POD</span></a></div>";
	}

?>

<a href='usuarios.php?us=l' class='menu <?php echo $a_usus;?>'><div class='di' id="jcabhsm"><script language="javascript">jcabhsm();</script></div><span class='icon-users'></span>
<br><span class='anch'><?php echo ucfirst(i("usuarios",$ilink));?></span>
</a>
	
<span id="jcontrol"><script language="javascript">jcontrol()</script></span>

</div>

<?php

require_once APP_DIR . '/asigna_elegir.php';

?>