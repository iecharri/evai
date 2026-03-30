<?php

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

${'a'.$op} = "active";

?>

<div class='top1'>

<a class="menu" href='home.php'><span class="icon-home"></span>
<span class='anch'><br><?php echo $anch;?></span>
<span class='estrech'><br><?php echo $estr;?></span>
</a>

</div>

<div class='casigna'>

<?php

switch ($op) {
	case 1:
		echo " &nbsp; <span class='icon-profile'></span> ".i("perfil",$ilink);
		break;
	case 3:
		echo " &nbsp; <span class='icon-profile'></span> ".i("editar",$ilink);
		break;
	case 4:
		echo " &nbsp; <span class='icon-bubbles3'></span> ".i("envimens1",$ilink);
		break;
	case 5:
		echo " &nbsp; <span class='icon-cog'></span> ".i("personalizar",$ilink);
		break;
	case 10:
		echo " &nbsp; <span class='icon-books'></span> ".i("misasigna",$ilink);
		break;
	case 11:
		echo " &nbsp; <span class='icon-dice'></span> ".i("miscalif",$ilink);
		break;
	case 16:
		echo " &nbsp; <span class='icon-share2'></span> ".i("comparte",$ilink);
		break;
	case 17:
		echo " &nbsp; <span class='icon-images'></span> ".i("fotos",$ilink);
		break;
 	case 18:
		echo " &nbsp; <span class='icon-users'></span> ".i("social",$ilink);
		break;
 	case 19:
		echo " &nbsp; <span class='icon-folder'></span> ".i("carpeta",$ilink);
		break;
 	case 20:
		echo " &nbsp; <span class='icon-hour-glass'></span> ".i("bancodet",$ilink);
		break;
 	case 7:
		echo " &nbsp; <span class='icon-user-check'></span> ".ucfirst(strtolower(i("perm",$ilink)));
		break;
 	case 8:
		echo " &nbsp; <span class='icon-history'></span> ".i("histoenvi",$ilink);
		break;
 	case 9:
		echo " &nbsp; <span class='icon-flag'></span> <a href='ficha.php?usuid=$usuid&op=$op'>".i("actividad",$ilink)."</a>";
		break;
   case 22:
      echo " &nbsp; <a $a22 href='ficha.php?usuid=$usuid&op=$op'><span class='icon-pencil2'></span> ".i("anotaciones",$ilink)."</a>";
		break;
   case 23:
      echo " &nbsp; <a $a23 href='ficha.php?usuid=$usuid&op=$op'><span class='icon-pencil2'></span> ".i("anotaciones",$ilink)."</a>";
		break;

}

?>

</div>