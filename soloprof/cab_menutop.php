<?php

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

if($script == "carpetaficheros") {
	return;
}

?>

<div class='top1'>

<a class="menu" onclick="openNav()"><span class="icon-menu"></span>
<span class='anch'><br><?php echo $anch;?></span><span class='estrech'><br><?php echo $estr;?></span> Admin</a>

<?php

$sel = "active";
$a = "sel".$op;
$$a = $sel;

if ($_SESSION['asigna']) {
	echo "<a class='menu $sel1' href='admin.php?op=1'>
	<span class='icon-books'><br></span><span class='anch'>".i("asigna",$ilink)."</span></a>";
}

if (esadmidetit($tit,$curso,$ilink)) {
	echo "<a class='menu $sel2' href='admin.php?op=2'>
	<span class='icon-library'></span><br><span class='anch'>".i("titul",$ilink)."</span></a>";
}
if ($_SESSION['auto'] == 10) {
	echo "<a class='menu $sel3' href='admin.php?op=3'>
	<span class='icon-lab2'></span><br>";
	echo "<span class='anch'>".$anch."</span>"; 
	echo "</a>";
}

if (!$pest) {$op = 1;}
$pesta = "pesta".$pest;
$$pesta = "class='active'";

echo "</div>";

echo "<div class='casigna'>";

switch($op) {
	
	case 1:
		if (!esprofesor($asigna,$curso,$grupo,$ilink) AND !soyadmiano($asigna,$curso,$ilink)) {header("Location: ../index.php"); exit;}
		cab('',$asigna,$curso,$grupo,$ilink);
		break;
	case 2:
		if (!esprofesor($asigna,$curso,$grupo,$ilink) AND !soyadmiano($asigna,$curso,$ilink)) {header("Location: ../index.php"); exit;}
		cab($tit,'',$curso,'',$ilink);
		break;
	case 3:
		cab('','','','',$ilink);
}

echo "</div>";

// --------------------------------------------------

function cab($tit,$asigna,$curso,$grupo,$ilink) {
	if(!$asigna AND !$tit) {
		echo "Configuración de EVAI";
	} elseif($tit) {
		echo "Configuración de $tit $curso";
	} else {
		echo "Configuración de $asigna $curso $grupo";
	}	
}

?>
