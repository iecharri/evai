<?php

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

require_once APP_DIR . "/giccomentayvota.php";

if ($_POST['editar']) {
	$id = $_GET['id'];
	require_once APP_DIR . "/gic_vinc_edit1.php";
	if ($noexiste == 1) {$_GET['accion'] = "";$_GET['id'] = "";}
	$id = $_GET['id'];
}

$varget = varget($_GET);

if (($_GET['accion'] == "editar" AND !$_POST['editar']) OR $mensaje) {
	wintot1("gic_vinc_edit.php",$mensaje,"div_edit",i("editar1",$ilink),'',$ilink);
}

if ($_GET['accion']=="extraer") {
	wintot1("gic_extrae.php",'',"div_extrae",i("gicextraer",$ilink),'',$ilink);
}

$result = $ilink->query($sql) or die ("_");
$numvinculos = $result->num_rows;

if ($numvinculos <= 0) {echo "<p></p><h4 class='rojo'>".i("nodatos",$ilink)."</h4>";return;}

if ($_POST['usuarios'] AND strlen(trim($_SESSION['bu'][1]))>2) {

	$sql = $sql." ORDER BY alumnoa";
	$result = $ilink->query($sql);
	$n = 0;
	while ($fila = $result->fetch_array(MYSQLI_BOTH)) {
		$id = $fila['id'];
		$sql1 = "SELECT id FROM vinculos LEFT JOIN podasignaturas ON podasignaturas.cod=vinculos.area
			WHERE MATCH(titulo, url, vinculos.area, claves, resumen, amplia) AGAINST('$claves')
			AND usu_id='$id' AND usu_id > 0 AND !sologrupotrab";
		$iresult = $ilink->query($sql1);
		$fila1 = $iresult->num_rows;
		if ($fila1 > $usuvinc) {
			echo "<br>";
			$usu = ponerusu($fila['id'],1,$ilink);
			echo $usu[0].$usu[1];
			echo " ".$fila1;
			$n = $n + 1;
		}
		if ($n > 40) {echo "<p></p>...";break;}
	}
	return;

}

$conta = $_GET['conta'];
if (!$conta) {$conta = 1;}
$bus = $_GET['bus'];
if ($_POST['ord']) {$_GET['ord'] = $_POST['ord'];}
$ord = $_GET['ord'];

if ($ord == 'vinculos.area') { $sql = $sql."  ORDER BY vinculos.area, fechacrea1 DESC";}
if ((!$ord OR $ord == 'fechacrea') AND $bus != 3) { $sql = $sql."  ORDER BY fechacrea1 DESC";}
if ($ord == 'claves') { $sql = $sql."  ORDER BY claves";}
if ($ord == 'nota') { $sql = $sql."  ORDER BY nota DESC, numvotos DESC";}
if ($ord == 'votos') { $sql = $sql."  ORDER BY numvotos DESC, nota DESC";}
if ($_GET['usuid']) {$param = "&usuid=".$_GET['usuid'];}
if ($_GET['asigna']) {$param .= "&asigna=".$_GET['asigna'];}
if ($pest) {$param .= "&pest=$pest";}
if ($op) {$param .= "&op=$op";}

if (!$_GET['id']) {
	if ($_SESSION['pda']) {$numpag = 5;} else {$numpag = 20;}
	pagina($numvinculos,$conta,$numpag,i("vinculos1",$ilink),"bus=$bus&ord=$ord$param",$ilink);
	echo "<br><form name='ordenar' method='post'>";
	echo "<select name='ord'>";
	echo "<option value=''>".i("ultimos",$ilink)."</option>";
	echo "<option value='nota'";
	if ($ord == 'nota') {echo " selected='selected'";}
	echo ">".i("masvalor",$ilink)."</option>";
	echo "</select> <input class='col-05' type='submit' value=' >> '>";
	echo "</form>";
	$result = $ilink->query($sql." LIMIT ".($conta-1).", $numpag");
	echo "<hr class='both col-10 sty'>";
	while ($fila = $result->fetch_array(MYSQLI_BOTH)) {
		poneruno($fila['id'],0,$varget, $n,'',$ilink);
		$n++;
		echo "<hr class='both col-10 sty'>";
	}

	pagina($numvinculos,$conta,$numpag,i("vinculos1",$ilink),"bus=$bus&ord=$ord$param",$ilink);
} else {
	if (!$_POST AND $_GET['accion'] != "editar") {
		click($_GET['id'],$ilink);
	}
	$votado = votos_coment($_GET['id'],$_POST,$ilink);

	$id = $fila['id'];
	if ($_SESSION['gc']) {
		$_GET['vinc'] = $id;
		wintot1("categorizar.php","",'divcateg',i("categorizar",$ilink),1,$ilink);
	}
	echo "<br><table>\n";
	poneruno($_GET['id'],1,$varget,1,$votado,$ilink);
	echo "</table>\n";
}

// --------------------------------------------------

function gc($id,$ilink) {

	$iresult = $ilink->query("SELECT gc0, gc1, gc2, gc3, gc4 FROM vinculos WHERE id = '$id' LIMIT 1");
	$fila = $iresult->fetch_array(MYSQLI_BOTH);

	echo "<span class='u txth'>";
	$numcat = 5;
	for ($i=0;$i<$numcat;$i++) {
		$iresult = $ilink->query("SELECT cat FROM gc2 WHERE n = $i+1 AND subn = '$fila[$i]'");
		$gc = $iresult->fetch_array(MYSQLI_BOTH);
		if ($gc[0]) {
			if ($i == 0) {echo "<br>";}
			echo $gc[0]."-";
		}
	}
	echo "</span>";

}

// --------------------------------------------------

function poneruno($id,$uno,$varget,$n,$votado,$ilink) {

	if ($uno) {
		$iresult = $ilink->query("SELECT url FROM vinculos WHERE id = '$id' LIMIT 1");
		$url = $iresult->fetch_array(MYSQLI_BOTH); 
		if ($_SESSION['fabrir']) {
			$u = trim($url[0]);
			if ($u && !preg_match('~^https?://~i', $u)) {
    			$u = "http://" . $u;  // o "https://" si prefieres forzar
			}
			$f1 = @safe_fopen($u, "r");
			//$f1=@safe_fopen("http://".$url[0],"r");
		} else {
			$f1 = 11;
		}
		if ($f1) {$roto = 0;} else {$roto = 1;}
		$ilink->query("UPDATE vinculos SET roto = '$roto' WHERE id = '$id' LIMIT 1");
	}

	$iresult = $ilink->query("SELECT * FROM vinculos WHERE id = '$id' LIMIT 1");
	$fila = $iresult->fetch_array(MYSQLI_BOTH);

	$estad = "";
	if ($fila['numvotos'] OR $fila['clicks']) {
		if ($fila['clicks']) {
			$estad = "<span class='mediana b'>".$fila['clicks']."</span> clicks<br>";
		}
		if ($fila['numvotos'] >= 1) {
			$estad .= "<span class='mediana b'>".$fila['numvotos']."</span> ".i("votos",$ilink)."<br>";
			$estad .= i("nota",$ilink)."<br><span class='txth b'>".$fila['nota']."</span>";
			$estad .= "<br>Desv.<br><span class='txth b'>";
			if ($fila['desvtip'] == 0) {$estad .= "0.00";} else {$estad .= $fila['desvtip'];}
			$estad .= "</span>";
		}
	}
	echo "<div style='padding:1em'>";
		if($fila['dirimagen']) { //2024 pongo este if
			$f1=@safe_fopen($fila['dirimagen'],"r");
				if ($f1) {
				echo "<img class='fr' src=\"".$fila['dirimagen']."\" style='max-width:25%;padding-bottom:1em'>"; // style='width:150px'
				}
		}
		if ($fila['roto']) {echo "<span class='icon-cross grande rojo' title=\"".i("vincrotos",$ilink)."\"></span>";}
		echo " <span class='grande rojo b'>".$fila['area']."</span> ";
		if (!$_GET['id']) {
			echo " <a href='?$varget";
			if (!$uno) {echo "id=$id";}
			if (!$uno) {echo "&accion=1";}
			echo "' class='grande'>";
			echo quitabarra($fila['titulo']);
			echo "</a>";
		} else {
			echo "<span class='grande'>".quitabarra($fila['titulo'])."</span>";
		}
		echo "<br>";
		$url = trim($fila['url']);
		if ($url && !preg_match('~^https?://~i', $url)) {
    		$url = "http://" . $url; // por defecto http
		}
		echo "<a href='" . htmlspecialchars($url, ENT_QUOTES) . "' target='_blank'>";		
		//echo "<a href='http://".$fila['url']."' target='_blank'>";
		echo substr($fila['url'],0,80)."...</a><br>";
		
		?>		
		<div class="fila-usuario">
 	 	<div class="foto">
		<?php
  		
		if (verautor($id,$ilink)) {
			$usu = ponerusu($fila['usu_id'],1,$ilink);
			echo $usu[0];
		}
		if($estad) {		
			echo "<div style='font-size:.8em;background:white;border:1px solid #c0c0c0;padding:.4em'>$estad</div>";
		} 
		echo "</div>";
		
		?><div class="datos"><?php
			if (verautor($id,$ilink)) {
				echo $usu[1];
			}
			echo "<div class='col-10' style='margin-left:1em'>";
				echo " <span class='nob peq' title='Modif. ".ifecha31($fila['fecha1'],$ilink)."'>".ifecha31($fila['fechacrea1'],$ilink)."</span><br>";
				echo "<span class='mediana'>".quitabarra($fila['resumen'])."</span>"; 
				if ($fila['amplia'] != "") {
					echo "<a name=".$n."></a> [ <a onclick=\"amplred('div".$n."')\" class='txth b'>".i("mas",$ilink)."...</a> ]<br>";
					echo "<div id='div".$n."' class='mediana' style='display:none'>".quitabarra($fila['amplia'])."</div>";
				}
				echo "<br><span class='txth'><span class='b'>".i("claves",$ilink)."</span>: ".quitabarra($fila['claves'])."</span>";
				if ($_SESSION['gc']) {
					gc($fila['id'],$ilink);
				}
				$iresult = $ilink->query("SELECT COUNT(id) FROM vinchs2 WHERE id = '".$fila['id']."'");
				$num = $iresult->fetch_array(MYSQLI_BOTH);
				echo "<br><a class='rojo' href='?$varget";
				if (!$uno) {echo "id=$id";}
				if (!$uno) {echo "&accion=1";}
				echo "'> $num[0] ".i("comentarios",$ilink)."</a>";
				if ($_GET['id']) {
					if ($_SESSION['auto'] == 10 OR trim($fila['usu_id']) == trim($_SESSION['usuid'])) {
						echo " | <a class='rojo' href=\"?$varget"."accion=editar\">";
						if (trim($fila['usu_id']) == trim($_SESSION['usuid'])) {echo i('editar1',$ilink);} else {echo "[".i('editar1',$ilink)." - ADM]";}
						echo "</a>";
					}
					if ($_SESSION['fabrir']) {
						echo " | <a class='rojo' href='?$varget"."accion=extraer'>".i("gicextraer",$ilink)."</a>";
					}
					if ($_SESSION['gc'] AND (!$fila['idcat'] OR $fila['idcat'] == $_SESSION['usuid'] OR $_SESSION['auto'] > 4)) {
						echo " | ";
						echo "<a href='#' onclick=\"show('divcateg')\">".i("categorizar",$ilink)."</a>";
					}
					$temp = str_replace("\n"," ", $fila['titulo'].": ".$fila['resumen']);
					$temp = str_replace("\r"," ", $temp);
					$temp1 = "es-ES";
					if ($fila['idioma'] != "c") {$temp1 = "en-GB";}
					if (strpos($_SERVER['HTTP_USER_AGENT'],"Chrome")) {
						echo " &nbsp; &nbsp; &nbsp; <a href='#' onclick='vozlink(\"$temp\",\"$temp1\")'><img src='".MEDIA_URL."/imag/tierracascos.png'></a>";
					}
				}
				echo "<p></p>";
				if ($_GET['id']) {
					comentariosdelink($id,'',$ilink,"",$votado);
				}
			echo "</div>";
		echo "</div>";
	echo "</div>";
echo "</div>";
	
}

// --------------------------------------------------

function verautor($id,$ilink) {

	if ($_SESSION['auto'] == 10) {return 1;}
	$iresult = $ilink->query("SELECT usu_id FROM vinculos WHERE id = '$id' LIMIT 1");
	$fila = $iresult->fetch_array(MYSQLI_BOTH);
	if ($fila[0] == '0' OR $fila['usu_id'] == $_SESSION['usuid']) {return 1;}
	if (esprofdeid($fila[0],$ilink)) {return 1;}
	$temp = "SELECT vinculos.usu_id FROM votos LEFT JOIN vinculos ON vinculos.id = votos.vinculo_id WHERE votos.vinculo_id = '$id' AND votos.usu_id = '".$_SESSION['usuid']."' AND votos.votos > 0";
	$iresult = $ilink->query($temp);
	$temp = $iresult->fetch_array(MYSQLI_BOTH);
	if ($temp[0] > 0) {return 1;}
	
}

// --------------------------------------------------

function click($id,$ilink) {

	$iresult = $ilink->query("SELECT usu_id, clicks FROM vinculos WHERE id = '$id' LIMIT 1");
	$fila = $iresult->fetch_array(MYSQLI_BOTH);
	if ($fila[0] != $_SESSION['usuid']) {
		$clicks = $fila[1] + 1;
		$ilink->query("UPDATE vinculos SET clicks = '$clicks' WHERE id = '$id' LIMIT 1");
	}

}

// --------------------------------------------------

function varget($var) {

foreach ($var as $a => $b)
{
	$var1 .= "$a=$b&";
}
return $var1;
} 

function quitabarra($x) {return stripslashes($x);}

// --------------------------------------------------

?>

