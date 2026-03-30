<?php

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

extract($_GET);
extract($_POST);
$param = "pest=$pest&grupoid=$grupoid";

if ($_GET['id']) {
	$id = $_GET['id'];
} else {
	$id = $_POST['id'];
	echo "<div class='center'>";
	echo "<a class='colu' href='?$param&ini=1'><span class='icon-pencil2' title=\"".i("foroiniciar",$ilink)."\"></span> ".i("foroiniciar",$ilink)."</a>";
	echo "</div><p></p>";
}

if ($_GET['borr']) {
	borrargrupoforo($_GET['id'],$_GET['grupoid'],$ilink);
	$_GET['id'] = "";
}

// -------------------------------------------------- A&Ntilde;ADIR CONTESTACI&Oacute;N --------------------------------------------------

if ($_POST['idcontest'] AND $_POST['comentario']) {
	if ($_POST['idcontest'] == "*") {$_POST['idcontest'] = 0;}
	$temp = gmdate("Y-m-d H:i:s");
	$iresult = $ilink->query("SELECT MAX(foros_id) FROM forogrupos WHERE foro_id = '".$_GET['id']."'");
	$max = $iresult->fetch_array(MYSQLI_BOTH);
	$max = $max[0]+1;
	if(!$comentario) {return;}
	
	// ------------- que no exista ya ese comentario, evita recarga de pagina
	if(yaexiste1($comentario,$ilink)) {return;}
	$result = $ilink->query("INSERT INTO forogrupos (grupo, foro_id, usu_id, comentario, fecha, foros_id, contest_a) VALUES (\"$grupoid\", \"$id\", \"".$_SESSION['usuid']."\", \"".addslashes($comentario)."\", \"$temp\", \"$max\", \"".$_POST['idcontest']."\")");
	$idult = $ilink->insert_id; 
	$ilink->query("UPDATE forogrupos SET fechault = '$temp' WHERE id = '".$_GET['id']."' LIMIT 1");
	$iresult = $ilink->query("SELECT asunto FROM forogrupos WHERE id = '".$_GET['id']."' LIMIT 1");
	$temp = $iresult->fetch_array(MYSQLI_BOTH); 	
	$usuarios = $ilink->query("SELECT DISTINCT usu_id FROM gruposusu LEFT JOIN usuarios ON usu_id = usuarios.id WHERE fechabaja = '0000-00-00 00:00' AND autorizado > 1 AND grupo_id = '$grupoid'");
	$iresult = $ilink->query("SELECT grupo FROM grupos WHERE id = '$grupoid' LIMIT 1");
	$ppal = $iresult->fetch_array(MYSQLI_BOTH);
	while ($fila = $usuarios->fetch_array(MYSQLI_BOTH)) {
		if ($_SESSION['usuid'] != $fila['usu_id'] AND $fila['usu_id']) {
			if ($ppal[0] OR $ppal[1]) {
				$titforo = $ppal[0];
			}
			$para = $fila['usu_id'];
			$message = "Nuevo mensaje en el foro [ $titforo ] sobre el tema: <a href='grupo.php?$param&id=".$_GET['id']."#f$idult' target='ficha' class='b'>$temp[0]</a>";
			porhsm($message,$para,"",$ilink);
		} 
	}
}

// --------------------------------------------------

function grupoforonew($grupoid,$num,$param,$ilink) {

	$temp = "<p><br><form action='?$param' name='form1' method='post'>";
	$temp .= "<div style='margin:auto' class='col-6'>";
	$temp .= "<label class='txth b'>* ".i("asunto",$ilink)."</label><br><input class='col-9' type='text' size='30' maxlength='100' name='asunto' required><br>";
	$temp .= "<label class='txth b'>* ".i("comentario",$ilink)."</label><br>";
	$temp .= "<textarea class='col-9' rows='6' cols='30' name='comentario' required></textarea><br>";
	$temp .= "<input class='col-3' type='submit' class='btn' value=\"".i("anadir1",$ilink)."\">";
	$temp .= "</div></form></p>";
	return $temp;

}

// -------------------------------------------------- EDITAR UN MENSAJE  --------------------------------------------------

if ($_POST['idedit']) {
	$temp="";
	if ($_POST['asunto']) {$temp = "asunto = \"".addslashes($_POST['asunto'])."\", ";}
	$ilink->query("UPDATE forogrupos SET $temp comentario = \"".addslashes($_POST['comentario'])."\" WHERE id = '$idedit' LIMIT 1");
	$asunto = "";
}

// --------------------------------------------------

if ($asunto) {
	$temp = gmdate("Y-m-d H:i:s");
	if(!$asunto OR !$comentario) {return;}
	$sql = "INSERT INTO forogrupos (grupo, usu_id, asunto, comentario, fecha, fechault) VALUES ('$grupoid', '".$_SESSION['usuid']."', '$asunto', '$comentario', '$temp', '$temp')"; 
	$ilink->query($sql);
	if ($ilink->errno) {die ("Error1");}
	$mensaje = str_replace("(asunto)", consmy(conhiper($asunto)), str_replace("(nombre)", minom(1,0,$ilink), i("graciasforo",$ilink)));
	$idult = $ilink->insert_id;
	$iresult = $ilink->query("SELECT grupo FROM grupos WHERE id = '$grupoid' LIMIT 1");
	$ppal = $iresult->fetch_array(MYSQLI_BOTH);
	$usuarios = $ilink->query("SELECT DISTINCT usu_id FROM gruposusu LEFT JOIN usuarios ON usu_id = usuarios.id WHERE fechabaja = '0000-00-00 00:00' AND autorizado > 1 AND grupo_id = '$grupoid'");
	while ($fila = $usuarios->fetch_array(MYSQLI_BOTH)) {
		if ($_SESSION['usuid'] != $fila['usu_id'] AND $fila['usu_id']) {
			$para = $fila['usu_id'];
			$message = "Nuevo mensaje en el foro [ $ppal[0] ] sobre el tema: <a href='grupo.php?$param&id=$idult' target='ficha' class='b'>$asunto</a>";
			porhsm($message,$para,"",$ilink);
		}
	}
	echo "<p><br><div class='mediana center'>".$mensaje."</div></p><br>";
	require_once APP_DIR . "/molde_bott.php";
	exit;
}

if ($_POST['accion'] == 'anadir2') {
	$temp = gmdate("Y-m-d H:i:s");
	if(!$comentario) {return;}
	$ilink->query("INSERT INTO forogrupos (grupo, foro_id, usu_id, comentario, fecha) VALUES ('$grupoid', '$id', '".$_SESSION['usuid']."', '$comentario', '$temp')");
	if ($ilink->errno) {die ("Error2");}
	$ilink->query("UPDATE forogrupos SET fechault = '$temp' WHERE grupo = '$grupoid' AND id = '$id'");
	if ($ilink->errno) {die ("Error3");}
}

// --------------------------------------------------

if ($_GET['id'] OR $_POST['accion'] == 'anadir2') {
	grupoforoasunto($id,$grupoid,$param,$ilink,$imgloader);
	require_once APP_DIR . "/molde_bott.php";
	exit;
}

if ($_GET['ini'] AND !$_POST['asunto']) {
	echo grupoforonew($grupoid,$num,$param,$ilink);
	require_once APP_DIR . "/molde_bott.php";
	exit;
}

$sql = "SELECT * FROM gruposusu WHERE grupo_id = '$grupoid' AND usu_id = '".$_SESSION['usuid']."'";
$result = $ilink->query($sql);

if ($result->num_rows < 1 AND $_SESSION['auto'] < 5) {return;}

// --------------------------------------------------
$sql = "SELECT DISTINCT forogrupos.id, forogrupos.grupo, usu_id, asunto, fechault, comentario, forogrupos.fecha FROM forogrupos LEFT JOIN usuarios ON usuarios.id = forogrupos.usu_id  WHERE ";

if (trim($grupoid)) {
	$sql = $sql." forogrupos.grupo = '$grupoid' AND ";
}

$sql = $sql." asunto != '' ORDER BY fechault DESC";
$result = $ilink->query($sql);
$numvinculos = $result->num_rows;

if ($result->num_rows == 0) {
	echo "<p></p><center>".i("nohaymens",$ilink)."</center>";
	return;
}

$conta = $_GET['conta'];
if (!$_GET['conta']) {$conta = 1;}

$numpag = 10;
pagina($numvinculos,$conta,$numpag,i("temas",$ilink),$param,$ilink);

$result = $ilink->query($sql." LIMIT ".($conta-1).", $numpag");

while ($fila = $result->fetch_array(MYSQLI_BOTH)) {
	extract($fila);
	$sql = "SELECT id FROM forogrupos WHERE  foro_id = '".$fila['id']."' AND asunto = ''";
	$iresult = $ilink->query($sql);
	$num = $iresult->num_rows;

	$asunto = conhiper(consmy($fila['asunto']));
	
	echo "<div class='peq fr'><span class='nob'>";
		echo i("ultimainser",$ilink)." ".ifecha31($fechault,$ilink)."</span> ";
		echo "<span class='icon-pencil2' title=\"".i("forocoment",$ilink)."\"></span> 
		<a href='?pest=$pest&grupoid=$grupoid&id=$id'>"
		.i("comentfor",$ilink)." [$num]</a>";
	echo "</div>";

	$mens = "<br><span class='nob peq'>".ifecha31($fecha,$ilink)."</span><br>";
	$usu = ponerusu($usu_id,1,$ilink);
		
	?><div class="fila-usuario">
   		<div class="foto"><?php
 	 			echo $usu[0];?>	
 			</div>
			<div class="datos"><?php 	
				echo $usu[1]."<br>".$mens;
				$mens = "";
				// --------------------------------------------------
				$flechas1 = "<span class='icon-eye' style='color:black'></span>";
				echo "<a href=\"javascript:amplred('div$id')\">$flechas1</a> ";
				$none = "style='display:none'";
				echo "<span class='b mediana'><a href='?pest=$pest&grupoid=$grupoid&id=$id'>".conhiper(consmy(quitabarra($asunto)))."</a></span><p></p>";
				echo "<div class='interli justify' id='div$id' $none>".conhiper(consmy(quitabarra($comentario)))."</div>";
				// --------------------------------------------------
			?></div>
	</div>
<?php
}


pagina($numvinculos,$conta,$numpag,i("temas",$ilink),$param,$ilink);

// --------------------------------------------------

function grupoforoasunto($id,$grupoid,$param,$ilink,$imgloader) {

	$sql = "SELECT asunto, comentario, forogrupos.fecha, usu_id, foros_id FROM forogrupos LEFT JOIN usuarios ON usuarios.id = forogrupos.usu_id WHERE forogrupos.id = '$id' ";

	$result = $ilink->query($sql);

	if (!$result) {return;}

	$fila = $result->fetch_array(MYSQLI_BOTH);
	$mens = "<br><span class='nob peq'>".ifecha31($fila['fecha'],$ilink)." &nbsp;$temp</span><br>";
	
	$usu = ponerusu($fila['usu_id'],1,$ilink);
	
	?><div class="fila-usuario">
			<div class="foto"><?php
				echo $usu[0];?>	
			</div>
			<div class="datos"><?php 	
				echo $usu[1].$mens;
				//**********
				echo "<span class='b mediana'><a href='?pest=2&grupoid=$grupoid&id=$id'>".conhiper(consmy(quitabarra($fila['asunto'])))."</a></span><br>";
				echo "<div class='justify'>".consmy(conhiper($fila['comentario']))."</div>";
				echo "<br><form method='post' name='f$id' action='".$_SERVER['PHP_SELF']."?$param&id=$id' onsubmit=\"show('esperar$id');hide('ocul$id')\">";
					echo "<textarea name='comentario' rows='5' required></textarea>";
					echo "<input type='hidden' name='idcontest' value='*'>";
					echo "<div id='ocul$id'>";
						echo " <input class='col-2' type='submit' value=\"".i("comentar",$ilink)."\">";
						if($_SESSION['auto'] > 4) {
							echo "<span class='nob'>&nbsp; [<a class='nob peq' href='?$param&id=$id&idedit=$id'><span class='rojo'>".i("solopr",$ilink)."</span>: ".i("editmens",$ilink)."</a>] </span><br>";
						}
					echo "</div>";
					echo "<div id='esperar$id' class='rojo b' style='display:none'>$imgloader ".i("esperar",$ilink)."</div>";
				echo "</form>";
			echo "<a name='f0'></a><p><br></p><br>";
		echo "</div>";
	echo "</div>";
	
	//**********

	$sql = "SELECT comentario, forogrupos.fecha, usu_id, forogrupos.id, foros_id, contest_a, forogrupos.id, invisible FROM forogrupos LEFT JOIN usuarios ON forogrupos.usu_id = usuarios.id WHERE forogrupos.foro_id = '$id' AND asunto = ''";

	if ($_SESSION['auto'] < 5) {$sql .= " AND !invisible";}
		
	$sql .= " ORDER BY forogrupos.fecha DESC";		

	$result = $ilink->query($sql);

	$num = $result->num_rows;
	if ($result->num_rows > 0) {
		while ($fila = $result->fetch_array(MYSQLI_BOTH)) {			$num--;
			if (!$num) {echo "<a name='ulti'></a>";}
			if($_SESSION['auto'] > 4) {
				if ($_GET['id']) {$esid = "&id=".$_GET['id']."&grupoid=".$_GET['grupoid']."&pest=".$_GET['pest'];}
				if ($fila['invisible'] == 2) {
					echo "<span class='rojo nowrap b fr'>".i("mensforoinvi",$ilink)." - <a href='?mvisi=".$fila['id']."$esid&conta=$conta' title=\"".i("mensforonoesvisi",$ilink)."\">".i("hilohacervisi",$ilink)."</a></span>";
				} else {
					echo "<span class=' nowrap verdecalific fr'>".i("mensforovisi",$ilink)." - <a href='?minvisi=".$fila['id']."$esid&conta=$conta' title=\"".i("mensforoesvisi",$ilink)."\">".i("hilohacerinvisi",$ilink)."</a></span>";
				} 
				echo "<p></p>";
			}
				
			$mens = "<span class='nob peq'>".ifecha31($fila['fecha'],$ilink)."</span>";
					
			$usu = ponerusu($fila['usu_id'],1,$ilink);

			?><div class="fila-usuario">
					<div class="foto"><?php
	 						echo $usu[0];?>	
					</div>
					<?php $fondo = ""; if ($fila['invisible'] == 2) {$fondo = "box11";}?>
					<div class="datos <?php echo $fondo;?>"><?php 	
						echo $usu[1]."<br>".$mens;
						//************
						echo "<p></p><div class='justify'><span style='border:1px solid;padding:0 3px' class='b'>".$fila['foros_id']."</span> ";
						if ($fila['contest_a']) {
							echo " REF. <span style='border:1px solid;padding:3px' class='b'>".$fila['contest_a']."</span> ";
						}
						echo consmy(conhiper($fila['comentario']))."</div>";
						echo "<a name='f".$fila['id']."'></a>";
						echo "<div class='both'>";
							echo "<br><form method='post' action='".$_SERVER['PHP_SELF']."?$param&id=$id' onsubmit=\"show('esperar".$fila['id']."');hide('ocul".$fila['id']."')\">";
								echo "<textarea class='col-10' name='comentario' rows='5' required></textarea>";
								echo "<input type='hidden' name='idcontest' value='".$fila['foros_id']."'>";
								echo " <div id='ocul".$fila['id']."'>";
									echo " <input class='col-2' type='submit' value=\"".i("comentar",$ilink)."\">";
								echo "</div>";
								echo "<div id='esperar".$fila['id']."' class='rojo b' style='display:none'>$imgloader".i("esperar",$ilink)."</div>";
						echo "</form>";
					echo "</div>";
					echo grupoforoedit($_GET['id'],$_GET['idedit'],$param,$ilink);
				echo "</div>";
			echo "</div><p><br></p><br>";
			// -------------
		}
	}
}

// --------------------------------------------------

function borrargrupoforo($id,$grupo,$ilink) {
	if ($_SESSION['auto'] == 10) {borrargrupoforo1($id,$grupo,$ilink);}
}

function borrargrupoforo1($id,$grupo,$ilink) {
 $ilink->query("DELETE FROM forogrupos WHERE (id = '$id' OR foro_id = '$id') AND grupo = '$grupo'");
}

// --------------------------------------------------

function grupoforoedit($id,$idedit,$param,$ilink) {

	if (!$idedit OR $_SESSION['auto'] != 10) {return;}
	$iresult = $ilink->query("SELECT asunto, comentario, grupo FROM forogrupos WHERE id = '$idedit' LIMIT 1");
	$fila = $iresult->fetch_array(MYSQLI_BOTH);
	extract($fila);
	$formu = "<div class='colu'><form action='".$_SERVER['PHP_SELF']."?$param&id=$id' name='form1' method='post'>\n";
	if ($fila[0]) {$formu .= "<label class='mediana b'>* ".i("asunto",$ilink)."</label> <input type='text' size='60' maxlength='100' name='asunto' value=\"".quitabarra($fila[0])."\" required><br>";}	
	$formu .= "<label class='mediana b'>* ".i("comentario",$ilink)."</label><br>\n";
	$formu .= "<input type='hidden' name='idedit' value='$idedit'>";
	$formu .= "<textarea rows='6' cols='55' name='comentario' required>".quitabarra($fila[1])."</textarea>\n";
	$formu .= "<br><div id='ocul'><input class='btn' type='submit' name='editar' value=\" >> \" onclick=\"show('esperar');hide('ocul')\"></div></form>\n";
	$formu .= "<p></p><div id='esperar' style='display:none'><p><br></p>";
	$formu .= i("esperar",$ilink);
	$formu .= "<p><br></p></div></div>";	
	return $formu;

}

// --------------------------------------------------

function quitabarra($x) {return stripslashes($x);}

// --------------------------------------------------

function yaexiste1($comentario, $ilink) {

	$iresult = $ilink->query("SELECT comentario FROM forogrupos WHERE comentario=\"".addslashes($comentario)."\"");
	$existe = $iresult->fetch_array(MYSQLI_BOTH);
	if ($existe) {return 1;}

}

?>
