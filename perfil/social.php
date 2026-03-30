<?php

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

require_once APP_DIR . '/giccomentayvota.php';

extract($_POST);
extract($_GET);

$target = "target = '_blank'";
if ($usuid == $yo) { $target = "target = '_top'";}
$social = 1;

// -------------------------------------------------- COMPARTIR UNA ENTRADA

if ($acc == "comp") {
	$idcomp = $_GET['id'];
	$temp = gmdate('Y-m-d H:i:s');
	$sql = "INSERT INTO social (fecha,fmodif,usuid,tabla,relid) VALUES ('$temp','$temp','$yo','comparto','$idcomp')";
	$ilink->query($sql);
}

// -------------------------------------------------- COMENTAR UNA ENTRADA

if ($_POST['coment']) {
	$comentarioaid = $_POST['comentaid'];
	//Si es un link, el comentario se pone en la tabla vinchs2
	$tabla = "SELECT tabla, relid FROM social WHERE id = '$comentarioaid'";
	$iresult = $ilink->query($tabla);
	$tabla = $iresult->fetch_array(MYSQLI_BOTH);
	$fecha = gmdate("Y-m-d H:i:s");
	if ($tabla[0] == "vinculos") {
		$sql = "INSERT INTO vinchs2 (id, usu_id,comentario, fecha) VALUES ('$tabla[1]', '$yo', \"".$_POST['coment']."\", '$fecha')";
		$ilink->query($sql);	
		$sql = "UPDATE social SET fmodif = '$fecha' WHERE relid = '$tabla[1]'";
		$ilink->query($sql);	
	}	elseif ($tabla == "foro") {
		
	} else {
		$temp = gmdate('Y-m-d H:i:s');
		$sql = "INSERT INTO social_textos (fecha,usuid,texto,comentarioaid) VALUES ('$temp', '$yo','".$_POST['coment']."','$comentarioaid')";
		$ilink->query($sql);	
		$sql = "UPDATE social SET fmodif = '$temp' WHERE id = '$comentarioaid'";
		$ilink->query($sql);	
	}
}

// --------------------------------------------------

socialtodo($usuid,$amigosyo1,$cadmisasig,$ilink);

// --------------------------------------------------
// --------------------------------------------------

function socialtodo($dequien,$amigos1,$cadmisasig,$ilink) {
	
	$sql = "SELECT id, fecha, usuid, tabla, relid, titulaci, social.asigna, social.curso, grupo FROM social";

	//Si estoy viendo lo que comparte otro	
	if ($dequien != $_SESSION['usuid']) {
		//Escrito por &eacute;l y no es foro ni grupo de trabajo
		$sql .= " WHERE usuid = '$dequien' AND tabla != 'foro' AND !sologrupotrab";
	} else {
		//Escrito por m&iacute;
		$sql .= " WHERE usuid = '$dequien'";
		if ($amigos1) {
			//Arreglar cadena para sql
			$amigos1 = str_replace(",","','",$amigos1);
			//o por mis amigos y no es foro ni grupo trabajo
			$sql .= " OR (usuid IN ('".$amigos1."') AND tabla != 'foro' AND !sologrupotrab)";
		}
		//o es de una de mis asignaturas
		$sql .= " OR INSTR('$cadmisasig[0]',concat('#',social.asigna,'$$',social.curso,'$$',social.grupo,'#'))";
		$sql .= " OR INSTR('$cadmisasig[1]',concat('#',social.titulaci,'$$',social.curso,'#'))";
		//o es de uno de mis grupos de trabajo
		$cadmisgrupos = misgrupos($ilink);
		$sql .= " OR INSTR('$cadmisgrupos',concat('*',engrupotrab,'*'))";
	}
	$sql .= " ORDER BY fmodif DESC"; // LIMIT 0,100
	$iresult = $ilink->query($sql);
	$resul = $iresult->num_rows;
	if (!$resul) {
		echo "<p></p><h3 class='rojo'>".i("nodatos",$ilink)."</h3>";
		return;
	}

	if ($dequien != $_SESSION['usuid']) {echo "<p></p>";}
	$conta = $_GET['conta'];
	if (!$conta) {$conta = 1;}
	$iresult = $ilink->query($sql);
	$resul = $iresult->num_rows;

	$numpag = 20;

	$param = "op=".$_GET['op']."&usuid=$dequien";
	pagina($resul,$conta,$numpag,i("comentarios",$ilink),$param,$ilink);
	
	echo "<hr class='sty'>";

	$sql1 = $sql." LIMIT ".($conta-1).", $numpag";

	$result = $ilink->query($sql1);

	while ($fila = $result->fetch_array(MYSQLI_BOTH)) {
		extract($fila);
		if (!$relid) {continue;}
		$usu = ponerusu($usuid,1,$ilink);
		echo "<div class='colu0'>";
			echo "<div class='box25'>";
				echo $usu[0];
			echo "</div>";
			echo "<div style='margin-left:50px'>";
				echo $usu[1];
				$atraves = "";
				if ($tabla == "comparto") {
					$quien = $usuid;
					$sql2 = "SELECT * FROM social WHERE id = '$relid'";
					$result2 = $ilink->query($sql2);
					$fila2 = $result2->fetch_array(MYSQLI_BOTH);
					extract($fila2);
					$atraves = $usuid;
					$usuid = $quien;
				}
				$clickar = 0;
				if ($atraves AND $atraves != $_SESSION['usuid']) {$clickar = 1;}
				if (!$atraves AND $usuid != $_SESSION['usuid']) {$clickar = 1;}
				if ($tabla == "foro") {
					ponerforo($relid,$usuid,$fecha,$atraves,$ilink);
					mgnmg("foro",$relid,$ilink,$clickar);
					comentariosdeforo($relid,$ilink);
				} elseif ($tabla == "vinculos") {
					ponerlink($relid,$usuid,$fecha,$atraves,$ilink);
					mgnmg("vinculos",$relid,$ilink,$clickar);
					if (!$atraves) {pedircompartir($id,$dequien,$ilink);}
					comentariosdelink($relid,"comp",$ilink,$dequien."_".$atraves,'');
				} elseif ($tabla == "textos") {
					ponertexto($relid,$usuid,$fecha,$atraves,$ilink);
					mgnmg("textos",$relid,$ilink,$clickar);
					if (!$atraves) {pedircompartir($id,$dequien,$ilink);}
					comentariosdetxt($id,$ilink,$dequien."_".$atraves);
				} elseif ($tabla == "fotos") {
					ponerfoto($relid,$usuid,$fecha,$atraves,$ilink);
					mgnmg("fotos",$relid,$ilink,$clickar);
					if (!$atraves) {pedircompartir($id,$dequien,$ilink);}
					comentariosdetxt($id,$ilink,$dequien."_".$atraves);
				}
				if (!$comparte AND $tabla != "foro") {
					pedircomentario($id,$ilink);
				}
			echo "</div>";
		echo "</div>";
		echo "<hr class='sty'>";
	}
	
	pagina($resul,$conta,$numpag,i("comentarios",$ilink),$param,$ilink);

}

// --------------------------------------------------

function misgrupos($ilink) {
$result = $ilink->query("SELECT id FROM grupos LEFT JOIN gruposusu ON gruposusu.grupo_id = grupos.id WHERE usu_id = '".$_SESSION['usuid']."'");
if ($result->num_rows) {
	$misgrupos = "*";
	while ($fila = $result->fetch_array(MYSQLI_BOTH)) {
		$misgrupos .= $fila['id']."*";
	}	
}
return $misgrupos;
}

// --------------------------------------------------

function pedircomentario($id,$ilink) {
	echo "<form method='post' name='form$id'><p></p>&nbsp;";	
	echo "<input type='text' size='90' maxlength='255' name='coment' value=\"".i("escribecom1",$ilink)."\" (max. 255)' onfocus=\"this.value=''\" 
	onblur='this.value=\"".i("escribecom1",$ilink)."\"' >";
	echo "<input type='hidden' name='comentaid' value='$id'>";
	echo "</form>";	
}

// --------------------------------------------------
// --------------------------------------------------

function ponertexto($id,$usuid1,$fecha1,$atraves,$ilink) {
	$iresult = $ilink->query("SELECT texto from social_textos where id='$id'");
	$fila = $iresult->fetch_array(MYSQLI_BOTH);
	if (!$fila[0]) {return;}
	if ($atraves) {
		$usu1 = ponerusu($atraves,1,'',$ilink);	
		echo " a trav&eacute;s de ". $usu1[1];
	}
	echo "<div>";
	echo "<br><span class='peq nob'>".ifecha31($fecha1,$ilink)."</span>";
	//echo "<span class='peq fr'>".i("comentario1",$ilink)."</span>";
	echo "<br>".consmy(make_clickable($fila[0]));
	echo "</div>";
}

function ponerfoto($id,$usuid1,$fecha1,$atraves,$ilink) {
	$sql = "SELECT thumb FROM social_fotos where id='$id'";
	$iresult = $ilink->query($sql);
	$fila = $iresult->fetch_array(MYSQLI_BOTH);
	if (!$fila[0]) {return;}
	if ($atraves) {
		$usu1 = ponerusu($atraves,1,$ilink);	
		echo " a trav&eacute;s de ".$usu1[1];
	}
	echo "<div>";
	echo "<br><span class='peq nob'>".ifecha31($fecha1,$ilink)."</span>";
	echo "<p></p><a href='perfil/perfilfich.php?id=$id&tam=1' target='_blank'><img src='perfil/perfilfich.php?id=$id'></a>";
	echo "</div>";	
}

// --------------------------------------------------

function comentariosdetxt($relid,$ilink,$div) {
	$sql = "SELECT * FROM social_textos WHERE comentarioaid = '$relid'";
	$result = $ilink->query($sql);
	if ($result->num_rows < 1) {return $id;}
	$hideonoff = "<span class='icon-eye-blocked'></span> ".i("mostrar1",$ilink)." / ".i("ocultar1",$ilink);
	echo " <a onclick=\"amplred('coment$div"."_"."$relid')\"><button class='peq'>$hideonoff</button></a><p></p>";
	echo "<div class='both' id='coment$div"."_"."$relid' style='display:none'>";
	while ($fila = $result->fetch_array(MYSQLI_BOTH)) {
		ponercomentario($fila,$ilink);		
	}
	echo "</div>";
}

function ponercomentario($fila,$ilink) {
	extract($fila);
	$usu = ponerusu($usuid,1,'',$ilink);	
	echo "<div class='colu0'>";
		echo "<div class='box25'>";
			echo $usu[0];
		echo "</div>";
		echo "<div>";
			echo $usu[1];
			echo "<br><div class='peq nob'>".ifecha31($fecha,$ilink)."</div>";
			echo $texto."<br>";
			if ($usuid != $_SESSION['usuid']) {$clickar = 1;}
			mgnmg("coment",$fila['id'],$ilink,$clickar);
		echo "</div>";
	echo "</div>";
}

// --------------------------------------------------

function ponerlink($id,$usuid1,$fecha1,$atraves,$ilink) {
	if (!$id) {return;}
	$sql = "SELECT * FROM vinculos LEFT JOIN grupos ON vinculos.engrupotrab = grupos.id WHERE vinculos.id = '$id'";
	$iresult = $ilink->query($sql);
	$fila = $iresult->fetch_array(MYSQLI_BOTH);
	extract($fila);
	if ($atraves) {
		$usu1 = ponerusu($usu_id,1,$ilink);
		echo " a trav&eacute;s de ".$usu1[1];
	}
	echo "<br><span class='peq nob'>".ifecha31($fecha1,$ilink)."</span>";
	if ($titulo) {
		echo "<br><span class='b'>".consmy(make_clickable($titulo))."</span>";
	}
	if ($url) {echo "<br>".make_clickable("http://".$url);}
	echo "<div id='div$id'>";
	if ($resumen OR $claves OR $amplia) {
		echo quitabarra($fila['resumen']); //nl2br(
		if ($fila['amplia'] != "") {
			echo "<br>".quitabarra($fila['amplia']);
		}
		if ($fila['claves']) {
			echo "<br><span class='txth'><span class='b'>".i("claves",$ilink)."</span>: ".quitabarra($fila['claves'])."</span>";
		}
	}
	echo "</div>";	
}

// --------------------------------------------------

function ponerforo($id,$usuid1,$fecha1,$atraves,$ilink) {
	$iresult = $ilink->query("SELECT asunto, comentario, fecha, titulaci, asigna, curso, grupo from foro where id='$id'");
	$fila = $iresult->fetch_array(MYSQLI_BOTH);
	if (!$fila[0]) {return;}
	echo "<div>";
	echo "<br><span class='peq nob'>".ifecha31($fecha1,$ilink)."</span>";
	echo "<span class='fr peq'>".i("foro",$ilink)." ".str_replace("*","","$fila[3] $fila[4] $fila[5] $fila[6]")." </span>";
	echo "<br><a href='foros.php?id=$id' class='b'>".conhiper(consmy($fila[0]))."</a><br>".conhiper(consmy($fila[1]));
	echo "</div>";
}

// --------------------------------------------------

function pedircompartir($id,$dequien,$ilink) {
	$iresult = $ilink->query("SELECT usuid, tabla from social where id='$id'");
	$fila = $iresult->fetch_array(MYSQLI_BOTH);
	if ($fila[0] == $_SESSION['usuid'] OR $fila[1] == "comparto") {return;}
	if ($_GET['usuid']) {$temp = "usuid=".$_GET['usuid'];}
	$share = "<span class='icon-share2'></span> ".i("compartir",$ilink);
	echo " <a href='?op=16&$temp&id=$id&acc=comp'><button class='peq'>$share</button></a> ";
}

// --------------------------------------------------

function quitabarra($x) {return stripslashes($x);}

// --------------------------------------------------

/*function comparto($id,$usuid1,$fecha1,$ilink) {
	$sql = "SELECT relid FROM social WHERE id = '$id'";
	$iresult = $ilink->query($sql);
	$fila = $iresult->fetch_array(MYSQLI_BOTH);
	extract($fila);
	$sql = "SELECT relid, tabla, usuid FROM social WHERE id = '$relid'";
	$iresult = $ilink->query($sql);
	$fila = $iresult->fetch_array(MYSQLI_BOTH);
	extract($fila);
	if ($tabla == "vinculos") {
		ponerlink($relid,$usuid1,$fecha1,$usuid,$ilink);
	} elseif ($tabla == "textos") {
		ponertexto($relid,$usuid1,$fecha1,$usuid,$ilink);
	} elseif ($tabla == "fotos") {
		ponerfoto($relid,$usuid1,$fecha1,$usuid,$ilink);
	}
}*/



?>
