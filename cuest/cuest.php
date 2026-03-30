<?php

require_once __DIR__ . '/../siempre.php';
require_once APP_DIR . '/cuest/tablaevalfuncis.php';
require_once APP_DIR . "/ponerobject.php";

extract($_GET);
extract($_POST);

?>

<script language="JavaScript">
<!--
var era;
var previo=null;
function uncheckRadio(rbutton){
if(previo &&previo!=rbutton){previo.era=false;}
if(rbutton.checked==true && rbutton.era==true){rbutton.checked=false;}
rbutton.era=rbutton.checked;
previo=rbutton;
}
//-->
</script>

<?php
		
// --------------------------------------------------

if ($_GET['cuest'] AND !$_GET['iniciar']) { //añado esto 30-8-35  AND !$_GET['iniciar']

	//Cuestionario externo o independiente

	iconex(DB2,$ilink);

	$iresult = $ilink->query("SELECT guardar,visible FROM ".$cuest."1 WHERE !n");
	$valores0 = $iresult->fetch_array(MYSQLI_BOTH);

	if(!$valores0['visible']) {return;}
	if(!$valores0['guardar'] == 2) {return;}

	require_once APP_DIR . '/cuest/cuest_indep.php';
	require_once APP_DIR . '/molde_bott.php';
	exit;
	
}

// --------------------------------------------------

if ($_SESSION['auto'] < 3) {exit;} 

// --------------------------------------------------

$titulo = ucfirst(i('eval',$ilink))." ".$_SESSION['asigna'];
require_once APP_DIR . '/molde_top.php';

// --------------------------------------------------

iconex(DB2,$ilink);
$asigna = $_SESSION['asigna'];

if (!$cuest) {
	
	//mostrar desplegable

// --------------------------------------------------

	$sql = "SHOW TABLES FROM ".DB2." LIKE '".strtolower($asigna)."_%1'";
	$result = $ilink->query($sql);
	if (!$result->num_rows) {
		$nohay = 1;	
	}

// --------------------------------------------------

	if ($nohay OR !$_SESSION['asigna']) {
		iconex(DB1,$ilink);
		echo i("nohaycuesti",$ilink);
		require_once APP_DIR . '/molde_top.php';
		return;
	}

	echo "<form name='form2' method='post'>";

	// Listar en una persiana todos los FORMULARIOS (solo los que el profesor autorice! : visible = 1 tabla de preguntas OR visaluresp = 1)

	echo "<div class='center auto'><select name='cuest' class='col-2 center' size='10'>";

	$i = 0;

	while ($fila = $result->fetch_array(MYSQLI_BOTH)) {

		//Ver si est&aacute; visible
		$iresult = $ilink->query("SELECT visible, visialuresp, guardar, formula, soloano FROM $fila[0] WHERE !n");
		$temp = $iresult->fetch_array(MYSQLI_BOTH);
		$visi = "";
		
		if ($temp[2] < 2) {
			if ($temp[0]==1) {
				// es visible pero comprobar que si existe soloano, $_SESSION['curso'] sea ese soloano
				if($temp['4']) {
					if($temp[4] == $_SESSION['curso']) {
						$visi = 1; //visible en el desplegable para elegir un cuest 
					}
				} else {
					$visi = 1; //visible en el desplegable para elegir un cuest 
				}
				
			} 
		}
		if ($visi) {
			$temp = preg_replace('/1$/','',$fila[0]);
			if (!$segundo) {$temp1 = " selected = 'selected'"; $segundo = 1;}
			echo "<option value='$temp' $temp1 ";
			if ($temp == $cuest) {
				echo " selected = 'selected'";
			}
			$temp = preg_replace('/^'.$tab.'_/','',$temp);
			echo ">$temp</option>";
			$almenosuna = 1;
		}
		
	}

	echo "</select></div>";

	if($almenosuna) {
		echo "<p></p><center><input class='col-3' type='submit' name='subm' value=' >> Realizar Evaluaci&oacute;n >> '></center>";
	} else {
		iconex(DB1,$ilink);
		echo "<div class='center'>".i("nohaycuesti",$ilink)."</div>";
		require_once APP_DIR . '/molde_top.php';
		return;
	}
	echo "</form>";

} elseif($cuest) {

// --------------------------------------------------

	$iresult = $ilink->query("SELECT guardar,visible,soloano FROM ".$cuest."1 WHERE !n");
	$valores0 = $iresult->fetch_array(MYSQLI_BOTH);

	if(!$valores0['visible']) {return;}
	
	//ver si el usuario es del año de soloano y está en la asignatura del cuest
	//$asi = explode("_",$cuest);
	//if(strtolower($_SESSION['asigna']) != strtolower($asi[0])) {
	//cambio lo anterior para el caso de asignaturas con guion bajo tipo modulo_006_2017
	$pos = strripos($cuest, "_");
	$asi[0] = substr($cuest,0,$pos);
	$asi[1] = substr($cuest,$pos+1);
	if(strtolower($_SESSION['asigna']) != strtolower($asi[0])) {
		return;	
	}
	if($valores0[2] AND $_SESSION['curso'] != $valores0[2]) {return;}	
	
	//mostrar las preguntas

	if(!$valores0['guardar']) {
		require_once APP_DIR . '/cuest/cuest_noguardar.php';
	} else {
		require_once APP_DIR . '/cuest/cuest_guardar.php';
	}
	
}

// --------------------------------------------------

require_once APP_DIR . '/molde_bott.php';

?>


