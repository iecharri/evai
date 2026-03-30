<?php

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

// -------------------------------------------------- AGENDA // --------------------------------------------------

/*if (!demo_enabled()) {
    // fijamos mayo 2021 para el demo
    $calen[0] = '2021-04-01';  
    $calen[1] = '2021-05-01';  
    $calen[2] = '2021-06-01';  
} else {
    // normal → mes actual y anterior/siguiente
    $hoy = date('Y-m-01');
    $calen[0] = date('Y-m-01', strtotime("$hoy -1 month"));
    $calen[1] = $hoy;
    $calen[2] = date('Y-m-01', strtotime("$hoy +1 month"));
}*/

//calendariomini($calen,$q,$arraymes,$ilink);

/*echo "<div class='calend mb1'>";
	if ($_GET['asi']) {$param="asi=1";}
	if ($_GET['titul']) {$param="titul=1";}
	
	//echo "<a class='fl' href='miagenda.php?ag=$calen[0]&$param'><</a>";
	//echo "<a class='fr' href='miagenda.php?ag=$calen[2]&$param'>></a>";

	echo "<a class='peq' style='display:block;text-align:center' href='miagenda.php?ag={$calen[1]}&{$param}&tod=1'>". ifecha31($calen[1],$ilink). "</a>";

	calendario($calen[1],3,$arraymes,"","",$ilink);
	
	echo "<div class='fr'><span class='peq'>".i("usuario",$ilink)."</span> <span class='cajadiayel'>&nbsp; &nbsp; &nbsp;</span>&nbsp;</div>";
	echo "<div class='fr'><span class='peq'>".i("asigna",$ilink)."</span> <span class='cajadiared'>&nbsp; &nbsp; &nbsp;</span>&nbsp;</div>";
echo "</div>";*/

// --------------------------------------------------

echo "<ul class='laterall'>";

if ($_SESSION['auto'] > 4){
	echo "<li class='menuizda'><a href='soloprof/admin.php' target='_blank'><span class='icon-wrench cadmi'></span> <span class='anch'>Admin</span></a></li>";
}
if ($_SESSION['auto'] == 10){
	echo "<li class='menuizda'><a href='pod/pod.php?pest=8' target='_blank'><span class='icon-cogs cpod'></span> <span class='anch'>POD</span></a></li>";
}

?>
<!-- <li><a href="ficha.php" target='_blank'><span class="icon-user cficha"></span> <?php echo i("fichapers",$ilink);?></a></li> -->
<?php

if ($_SESSION['asigna'] AND $_SESSION['tipo'] == "A") {
	?>
	<li><a <?php echo $a_calif;?> href="calificaciones.php"><span class="icon-dice ccalif"></span> <?php echo i("miscalif",$ilink);?></a></li>
	<?php
}

if($_SESSION['asigna']) {
	?>
	<li><a <?php echo $a_tablo;?> href="mitablon.php"><span class="icon-bullhorn cnoti"></span> <?php echo i("avisos",$ilink);?></a></li>
	<?php
}
	?>
<li><a <?php echo $a_foros;?> href="foros.php"><span class="icon-pencil2 cforo"></span> <?php echo i("foro",$ilink);?></a></li>

<?php if($asigna) {
?>
	<li><a <?php echo $a_notas;?> href="notas.php"><span class="icon-dice cnotas"></span> <?php echo i("notas",$ilink);?></a></li>
<?php 
}?>

<?php if($asigna) {?>
	<li><a <?php echo $a_recur;?> href="indexrecursos.php"><span class="icon-folder-open crecur"></span> <?php echo i("recur",$ilink);?></a></li>
<?php }?>

<li><a <?php echo $a_recuc;?> href="recurgen.php"><span class="icon-folder-upload ccompar"></span> <?php echo i("recurgen",$ilink);?></span></a></li>

<li><a <?php echo $a_evalu;?> href="cuest/cuest.php" target='_blank'><span class="icon-list-numbered ceval"></span> <?php echo i("eval",$ilink);?></a></li>

<li><a <?php echo $a_links;?> href="links.php?m=1"><span class="icon-link cvinc"></span> <?php echo i("vinculosen",$ilink)." ".$anch;?> </a></li>

<li><a <?php echo $a_grupo;?> href="grupos.php"><span class="icon-make-group cgru"></span> <?php echo i("grupos",$ilink);?></a></li>

<?php if($asigna) {?>
	<li><a <?php echo $a_orla;?> href="fotoscurso.php"><span class="icon-man-woman corla"></span> <?php echo i("orla",$ilink);?></a></li>
<?php }?>

<li><a <?php echo $a_estad;?> href="estadis.php"><span class="icon-stats-dots cestad"></span> <?php echo i("estad",$ilink);?></a></li>
<li><a <?php echo $a_comp;?> href="comp.php"><span><span class="icon-share2 ccomp"></span> <?php echo i("compartir",$ilink);?></a></li>
<li><a <?php echo $a_chat;?> href="chat/index.php?ini=1"><span class="icon-bubbles2 cchat"></span> <?php echo i("chat",$ilink);?></a></li>
<li><a <?php echo $a_contac;?> href="contacto.php"><span class="icon-mail2 ccontac"></span> <?php echo i("contacto1",$ilink);?></a></li>

</ul>

