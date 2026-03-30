<?php

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

function listausuarios($usuarios,$ilink) {
	if (!$usuarios) {return;}
	$usuarios = explode(",",$usuarios);
	//echo "<div class='peq'>";
	foreach ($usuarios as $key => $value) {
		$nummens = nummensa($value,$ilink);
		echo "<div class='both'>";
		$usu = ponerusu($value,1,$ilink);
		$temp = "";
		if($nummens[0]) {$temp = "<span class='porleer1'>$nummens[0]</span>";}
		?>		
		<div class="fila-usuario">
 	 	<div class="foto">
		<?php echo $usu[0].$temp;
		echo "</div>";
		
		?><div class="datos"><?php
		echo "$usu[1]<br><span class='estoy peq u'>$usu[2]</span>";
		echo "</div>";
		echo "</div>";

		
		
		echo "</div>";
		//echo "<p></p>";
		if (!$nummens[0]) {$mens++;}
		if ($mens > 100) {echo "<p></p>...";break;}
	}
	//echo "</div><p></p>";
}

// --------------------------------------------------

function nummensa($de,$ilink) {
	$sql = "SELECT COUNT(isread) AS ppp FROM message WHERE parausuid = '".$_SESSION['usuid']."' 
	 AND usuid = '$de' AND isread = 0";
	$iresult = $ilink->query($sql);	
	return $iresult->fetch_array(MYSQLI_BOTH);
}

// --------------------------------------------------

if ($seg) {seguir($usuid,$ilink);}
if ($noseg) {noseguir($usuid,$ilink);}

$amigosusuid1 = arrayamigos1($usuid,$ilink); //sigue a
$amigosusuid2 = arrayamigos2($usuid,$ilink); //le siguen
$amigosyo1 = arrayamigos1($yo,$ilink); //sigo a
$amigosyo2 = arrayamigos2($yo,$ilink); //me siguen

$esmifavorito = esmifavorito($usuid,$amigosyo1);

// --------------------------------------------------

function esmifavorito($usuid, $amigos2) {
	if (stristr(",$amigos2,",",$usuid,")) {return 1;}	
}

// --------------------------------------------------

function arrayamigos1($usuid,$ilink) {
	$result = $ilink->query("SELECT * FROM message"."_usus WHERE usuid = '$usuid' OR parausuid = '$usuid'");
	while ($fila = $result->fetch_array(MYSQLI_BOTH)) {
		if ($fila['usuid'] == $usuid AND $fila['parausuid1'] AND $fila['usuid']) {
			if (!contenido($fila['parausuid'], $amigos)) {
				if ($n) {$amigos .= ",";} else {$n = 1;}
				$amigos .= $fila['parausuid'];
			}
		} elseif ($fila['usuid'] != $usuid AND $fila['usuid1']) {
			if (!contenido($fila['usuid'], $amigos)) {
				if ($n) {$amigos .= ",";} else {$n = 1;}
				$amigos .= $fila['usuid'];
			}
		}
	}
	return $amigos;
}

// --------------------------------------------------

function arrayamigos2($usuid,$ilink) {
	$result = $ilink->query("SELECT * FROM message"."_usus WHERE usuid = '$usuid' OR parausuid = '$usuid'");
	while ($fila = $result->fetch_array(MYSQLI_BOTH)) {
		if ($fila['usuid'] == $usuid AND $fila['usuid1'] AND $fila['usuid']) {
			if (!contenido($fila['parausuid'], $amigos)) {
			if ($n) {$amigos .= ",";} else {$n = 1;}
				$amigos .= $fila['parausuid'];
			}
		} elseif ($fila['usuid'] != $usuid AND $fila['parausuid1']) {
			if (!contenido($fila['usuid'], $amigos)) {
				if ($n) {$amigos .= ",";} else {$n = 1;}
				$amigos .= $fila['usuid'];
			}
		}
	}
	return $amigos;
}

// --------------------------------------------------

function contenido($cadena1, $cadena2) {
	if (stristr(",".$cadena2.",", ",".$cadena1.",")) {return 1;}	
}

// --------------------------------------------------

function seguir($usuid,$ilink) {
	$tablau = "message_usus";
	$ilink->query("INSERT INTO $tablau (usuid, parausuid) VALUES ('$usuid','".$_SESSION['usuid']."')");
	$ilink->query("UPDATE $tablau SET usuid1 = -1 WHERE usuid = '$usuid' AND parausuid = '".$_SESSION['usuid']."'");	
	$ilink->query("UPDATE $tablau SET parausuid1 = -1 WHERE parausuid = '$usuid' AND usuid = '".$_SESSION['usuid']."'");	
}

function noseguir($usuid,$ilink) {
	$tablau = "message_usus";
	$ilink->query("UPDATE $tablau SET usuid1 = 0 WHERE usuid = '$usuid' AND parausuid = '".$_SESSION['usuid']."'");	
	$ilink->query("UPDATE $tablau SET parausuid1 = 0 WHERE parausuid = '$usuid' AND usuid = '".$_SESSION['usuid']."'");	
}

// --------------------------------------------------

function grandefoto($verfoto,$id,$usuid) {
	echo "<p></p><img src='perfil/perfilfich.php?id=$id&tam=1'>";
	if ($usuid == $_SESSION['usuid']) {
		echo "<p></p>";
		//echo "<a href='?fotoperfil=$id&fotos=1' class='mediana b'>Hacer que esta foto sea la principal</a>";
		echo "<a href='?op=".$_GET['op']."&bofoto=$id&fotos=1' onclick='return segu()' class='mediana b'>Borrar esta foto y comentarios</a>";
	}
}

// --------------------------------------------------

function fotoperfil($id,$ilink) {
	//Copiar la foto desde el campo blob a la carpeta fotos	
	$sql = "SELECT fichfoto, tipo FROM social_fotos LEFT JOIN social ON social_fotos.id = social.relid
	 WHERE tabla = 'fotos' AND social_fotos.id = '$id'";
	$iresult = $ilink->query($sql);
	$foto = $iresult->fetch_array(MYSQLI_BOTH);
	if (!$foto[0]) {return;}
	$data = base64_decode($foto[0]);
	$im = imagecreatefromstring($foto[0]);
	if ($im !== false) {
		$dirini = DATA_DIR . '/fotos';
		if (!is_dir($dirini)){safe_mkdir($dirini);}

		//borrar las 3 fotos anteriores del perfil
		$iresult = $ilink->query("SELECT foto FROM usuarios WHERE id = '".$_SESSION['usuid']."' LIMIT 1");
		$nombrefoto = $iresult->fetch_array(MYSQLI_BOTH);
		if ($nombrefoto[0]) {
			if (file_exists($dirini."/".$nombrefoto[0])) {safe_unlink($dirini."/".$nombrefoto[0]);}
			if (file_exists($dirini."/1".$nombrefoto[0])) {safe_unlink($dirini."/1".$nombrefoto[0]);}
			if (file_exists($dirini."/2".$nombrefoto[0])) {safe_unlink($dirini."/2".$nombrefoto[0]);}
		}

		if (strstr($foto[1], "jpeg")) {$ext = "jpg";}
		if (strstr($foto[1], "gif")) {$ext = "gif";}
		if (strstr($foto[1], "png")) {$ext = "png";}

		$nombrefoto = explode('.',$nombrefoto[0]);
		$nombrefoto = $nombrefoto[0];

		$fichnuevo = "$dirini/".$nombrefoto.".".$ext;

		//Crear la foto principal del perfil
		if (strstr($foto[1], "jpeg")) {imagejpeg($im,$fichnuevo);}
		if (strstr($foto[1], "gif")) {imagegif($im,$fichnuevo);}
		if (strstr($foto[1], "png")) {imagepng($im,$fichnuevo);}
		//Crear los otros dos tama&ntilde;os
		foto($nombrefoto,40,"",'', '',1);
		foto($nombrefoto,240,"",'', '',2);
		$cambio = "foto ";
		$iresult = $ilink->query("SELECT usuid FROM fichaactualiz WHERE usuid = '".$_SESSION['usuid']."'");
		if ($iresult->num_rows) {
			$ilink->query("UPDATE fichaactualiz SET cambio = '$cambio', fecha = '".gmdate("Y-m-d H:i:s")."' WHERE usuid = '".$_SESSION['usuid']."'");
		} else {
			$ilink->query("INSERT INTO fichaactualiz (usuid, cambio, fecha) VALUES ('".$_SESSION['usuid']."', '$cambio', '".gmdate("Y-m-d H:i:s")."')");
		}
	}
}

// --------------------------------------------------

function bofoto($id,$ilink) {
	$sql = "SELECT id FROM social WHERE tabla = 'fotos' AND relid = '$id'";
	$iresult = $ilink->query($sql);
	$idsocial = $iresult->fetch_array(MYSQLI_BOTH);
	$sql = "DELETE FROM social WHERE tabla = 'fotos' AND relid = '$id'";
	$ilink->query($sql);
	$sql = "DELETE FROM social_fotos WHERE id = '$id'";
	$ilink->query($sql);
	$sql = "DELETE FROM social_textos WHERE comentarioaid = '$idsocial[0]'"; 
	$ilink->query($sql);
}

// --------------------------------------------------

function thumbfotos($usuid,$ilink) {
	$sql = "SELECT DISTINCT relid FROM social LEFT JOIN social_fotos ON social.relid = social_fotos.id WHERE social_fotos.tipo != '' AND usuid = '$usuid' ORDER BY fecha DESC";
	$result = $ilink->query($sql);
	if (!$result) {return;}
	while ($fila = $result->fetch_array(MYSQLI_BOTH)) {
		echo "&nbsp;<a href='?op=".$_GET['op']."&usuid=$usuid&verfoto=$fila[0]'><img src='perfil/perfilfich.php?id=$fila[0]'></a>";
	}	
}

function thumbamigos($amigos,$tipo,$ilink) {
	if (!$amigos) {return;}
	$amigos = explode(",",$amigos);
	$cuantos = count($amigos);
	echo "<h2 class='b'>$tipo $cuantos</h2>";
	foreach ($amigos as $key => $value) {
		echo "<div class='contiene'>";
		seguirono($value,$ilink);
		$usu = ponerusu($value,1,$ilink);
		echo $usu[0].$usu[1];
		echo "</div>";
	}
}

?>