<?php 

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

require_once APP_DIR . '/head.php';

?>

<body <?php echo $body;?>>

<a name='inicio'></a>

<?php

//es un cuest independiente

if($indep AND ($script == "cuest" OR $script == "panel")) {return;}

if ($abriralerta) {
	wintot1('',"<span class='mediana rojo'>".i("noopci",$ilink)."</span><p></p>","div9","<span class='mediana rojo icon-warning'></span>",'',$ilink);
	$abriralerta = 0;
}

?>  

<div id='top' class="evai-header" >
	 		
	<?php
	$temp = $_SESSION['usuid'];
	if($script == "ficha"){$temp = $usuid;}
	if($_SESSION['usuid']) {
		$usu = ponerusuf($temp,2,$ilink);	
		echo "<div class='top2'>";
		echo "<span class='fr'>".$usu[0]."</span>";
		echo "<span class='usuno fr mr5 peq'>".$usu[1]."<br><span class='u peq'>$usu[2]</i></span>";
		echo "</div>";
	}

  if($script == "ficha" AND $usuid != $_SESSION['usuid']) {
  	require_once APP_DIR . '/cab_menutopf.php';
  } elseif($script == "grupo") {
	require_once APP_DIR . '/cab_menutopg.php';
  } elseif($script == "gictempo") {
	require_once APP_DIR . '/cab_menutopgic.php';
  } elseif($script == "hsmhome") {
	require_once APP_DIR . '/cab_menutophsm.php';
  } elseif($script == "chat") {
	require_once APP_DIR . '/chat/cab_menutop.php';
  } elseif($script == "pod") {
	require_once APP_DIR . '/pod/cab_menutop.php';
  } elseif($script == "admin") {
	require_once APP_DIR . '/soloprof/cab_menutop.php';
   } elseif($script == "cueval" OR $script == "cuest" OR $script == "cuestionario") {
	require_once APP_DIR . '/cuest/cab_menutop.php';
 } else {
  	require_once APP_DIR . '/cab_menutop.php';
  }
	?>
	
</div>

<?php

if ($_SESSION['usuid'] && $script != "plazasext") {
	if($script == "usuarios") {$usuid = $_SESSION['usuid'];}
	require_once APP_DIR . '/divficha.php';
}

if($_SESSION['usuid'] AND $script != "grupo" AND $script != "gictempo" AND $script != "cueval" AND $script != "plazasext" AND $script != "chat") {
// --------------------------------------------------
?>

	<nav id='lateral' style='margin-left:-50em'>
		
		<?php
		if($script == "pod") {
			require_once APP_DIR . '/pod/cab_menuizda.php';
		} elseif($script == "admin") {
			require_once APP_DIR . '/soloprof/cab_menuizda.php';
		} else {
			require_once APP_DIR . '/cab_menuizda.php';
		}
		?>

	</nav>
	<?php
// --------------------------------------------------
	}?>

 <!-- Site Overlay - Oscurece el resto de la pantalla-->
 <div id="site-overlay" style='display:none' onclick="openNav()"></div>

</div><div id="container">  <!--  </div> este fin de div es nuevo -->

<?php

$skipScripts = ['pod', 'admin', 'cueval', 'cuest', 'ficha','hsmhome', 'login', 'grupo', 'activ', 'plazasext','olvido'];

if (in_array($script, $skipScripts, true) || $sala || $newuser) {
    return;
}

 // ------------- FRASES EN MOVIMIENTO 

require_once APP_DIR . "/banner.php";
require_once APP_DIR . "/hiperen.php";
$banner = banner($ilink);

if ($banner) {
	?>	
	<marquee behavior="scroll" direction="left" scrollamount="4">
	<?php 
	echo conhiper(consmy($banner));
	?>
	</marquee>	
	<?php	
}

if($script == "usuarios" OR $script == "ficha") {return;}

// ------------- MANDO A DISTANCIA 
	require_once APP_DIR . "/mandoadist.php";
// --------------------------------------------------

?>
