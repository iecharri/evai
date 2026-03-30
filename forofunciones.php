<?php

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

//para la pagina de inicio, ultimos foros
function ultiforos($fila,$ilink) {
	extract($fila);
	if ($foro_id) {
		$fid = $foro_id;
	} else {
		$fid = $id;
	}
	$temp = "SELECT titulaci, asigna, curso, grupo, asunto, cerrado FROM foro WHERE id = '$fid' LIMIT 1";
	$iresult = $ilink->query($temp);
	$temp = $iresult->fetch_array(MYSQLI_BOTH);
	extract($temp);
	$asicurgru = $titulaci.$asigna;
	if (!$asicurgru) {$asicurgru = "General";}
	if ($curso) {$asicurgru .= " - $curso";} // AND $curso != "*"
	if ($grupo) {$asicurgru .= " - $grupo";} // AND $grupo != "*"
	$asunto = conhiper(consmy(quitabarra($asunto)));
	$comentario = conhiper(consmy(quitabarra($comentario)));
	
	//echo "<div class=' contiene'>";
		$mens = "<span class='peq'>".ifecha31($fecha,$ilink)."</span><br><span class='b peq'>$asicurgru</span><br>";
		$temp = $asunto; if(!$temp) {$temp = "-";}
		$mens .= "<a href='foros.php?id=$fid' title=\"".str_replace("\"","'",$asunto).": ".strip_tags(str_replace("\"","'",$comentario))."\">".str_replace("\"","'",$temp)."</a><br>"; //substr( ,0,55)  ...
		if (isset($cerrado) && $cerrado !== '0000-00-00 00:00:00') {
			$mens .= "<span class='fr'> &nbsp; [ <span class='rojo peq'>".i("hilocerrado",$ilink)." ".ifecha31($cerrado,$ilink)." ] </span>";
		}
		//foto, nombre y mensaje
		$usu = ponerusu($usu_id,1,$ilink);
		?><div class="fila-usuario">
 	 		<div class="foto"><?php
 	 			echo $usu[0];?>	
 			</div>
			<div class="datos"><?php 	
				echo $usu[1]."<br>".$mens;?>
			</div>
		</div>
		<?php
		echo "<p><br></p>";
	}

// --------------------------------------------------

//sql de hilos
function traesqllista() {
	$asigna = $_SESSION['asigna'];
	$curso = $_SESSION['curso'];
	$tit = $_SESSION['tit'];
	$titasi = $_SESSION['titasi'];
	
	$foro = "SELECT id, asigna, curso, grupo, titulaci, fecha, invisible, foro_id FROM foro 
	WHERE foro_id = 0";
	if ($_SESSION['auto'] < 10) {$foro .= " AND !invisible";}

	if ($titasi == "general") {
		$foro .= " AND asigna = '' AND titulaci = '' ";
	} elseif ($titasi == 2) {
		$foro .= " AND asigna = '$asigna'";
		if ($curso) {$foro .= " AND (curso = '$curso')";} // OR curso = '*'
	} elseif ($titasi == 1) {
		$foro .= " AND titulaci = '$tit'";
		if ($curso) {$foro .= " AND (curso = '$curso')";} // OR curso = '*'
	}
	return $foro;
}

//numero total de hilos que puedo ver
function nummens($sql,$ilink) {
	$result = $ilink->query($sql);
	if(!$result) {return 0;}
	while ($fila = $result->fetch_array(MYSQLI_BOTH)) {
		if (lopuedover($fila,$ilink)) {
			$n++;
		}
	}
	return $n;
}

//listado de hilos de una p&aacute;gina
function foro($sql,$conta,$numpag,$ilink) {
	$result = $ilink->query($sql);
	$conta1 = $conta;
	echo "<p><br</p>";
	while ($fila = $result->fetch_array(MYSQLI_BOTH)) {
		if (lopuedover($fila,$ilink)) {
		if ($conta > 1) {$conta--; continue;}
		$n++;
		if ($n <= $numpag) {
			primdehilo($fila['id'],0,$ilink,$conta1,'');
		}	
		}
	}
}

//ver si un hilo lo puedo ver
function lopuedover($fila,$ilink) {
	if ($fila['foro_id']) {	
		$esgen = "SELECT asigna, titulaci, curso, grupo FROM foro WHERE id = '".$fila['foro_id']."' LIMIT 1";
		$iresult = $ilink->query($esgen);
		$esgen = $iresult->fetch_array(MYSQLI_BOTH);
		$asigna = $esgen[0]; $tit = $esgen[1]; $curso = $esgen[2]; $grupo = $esgen[3];
	} else {
		$asigna = $fila['asigna']; $tit = $fila['titulaci']; $curso = $fila['curso']; $grupo = $fila['grupo'];
	}
	if (!$asigna AND !$tit) {return 1;}
	if (!$_SESSION['asigna'] AND $_SESSION['auto'] < 10) {return 0;}
	if (esmio($asigna,$curso,$grupo,$ilink) OR esmiotitul($tit,$curso,$ilink)) {
		return 1;
	}
}

//poner un inicio de hilo
function primdehilo($id,$hilo,$ilink,$conta,$imgloader) {
	if($_GET['impr']) {$noimp = "noponer";}
	$sql = "SELECT foro.asigna, usu_id, asunto, fecha, comentario, foro_id, curso, grupo, fechault, titulaci, palabra, invisible, cerrado, voto FROM foro LEFT JOIN forocategorias ON forocategorias.id = foro.categoria WHERE foro.id = '$id'";
	$iresult = $ilink->query($sql);
	$fila = $iresult->fetch_array(MYSQLI_BOTH);
	if (!$fila) {return;}
	extract($fila);
	$iresult = $ilink->query("SELECT id FROM foro WHERE  foro_id = '$id' AND asunto = ''");
	$num = $iresult->num_rows;

	if ($asigna == '' AND $titulaci == '') {
		$temp = 'General';
	} else {
		$temp = $titulaci.$asigna;
		if ($curso) {$temp .= " - $curso";} // AND $curso != "*"
		if ($grupo) {$temp .= " - $grupo";} // AND $grupo != "*"
	}
	$temp = "<span class='b'>$temp</span>";
	if ($_SESSION['auto'] == 10) {
		$x=1;
	} else {
		if ($titulaci AND esadmidetit($titulaci,$curso,$ilink)
		OR ($asigna AND (esprofesor($asigna,$curso,$grupo,$ilink) OR
		 esprofesordetit($titulaci,$curso,$ilink)))) {$x=1;}
	}

	if(!$noimp) {
	
	?>
			
	<div class='fr peq'>
		<?php
		if ($_GET['id']) {$esid = "&id=".$_GET['id'];}
		if ($temp != 'General') {
			if ($x == 1) {
				if ($invisible) {
					echo "<span class='rojo nowrap'>".i("hiloinvi",$ilink)." - <a href='?visi=$id$esid&conta=$conta' title=\"".i("hilonoesvisi",$ilink)."\">".i("hilohacervisi",$ilink)."</a></span>";
				} else {
					echo "<span class='txth nowrap'>".i("hilovisi",$ilink)." - <a href='?invisi=$id$esid&conta=$conta' title=\"".i("hiloesvisi",$ilink)."\">".i("hilohacerinvisi",$ilink)."</a></span>";
				} 
			}
		} else {
			if ($invisible) {echo "<span class='b rojo'>".i("hiloinvisinoadmi",$ilink)."</span>";}
		}

		if (isset($cerrado) && $cerrado !== '0000-00-00 00:00:00') {
			echo "<span class=''> &nbsp; [ <span class='rojo peq'>".i("hilocerrado",$ilink)." ".ifecha31($cerrado,$ilink)."</span>";
			if ($x == 1) {
				echo " - <a href='?abrir=$id$esid&conta=$conta' class='rojo' title=\"".i("hilodejaranadir",$ilink)."\">".i("hiloabrir",$ilink)."</a>";
			}
			echo " ] &nbsp; </span>";
		} elseif ($x == 1) {
			echo "<span class=' nob'> &nbsp; [ <a href='?cerr=$id$esid&conta=$conta' class='nob' title=\"".i("hilonodejaranadir",$ilink)."\">".i("hilocerrar",$ilink)."</a> ] &nbsp; </span>";
		}

		if ($hilo AND $x==1) {
			echo "<span class='nob'> &nbsp; [ <a class='nob' title='para borrado definitivo del hilo' href='?$param&id=$id&borr=1' onclick='return confirm(\"".i("confirmborr",$ilink)."\")'>".i("borrhilo",$ilink)."</a> ]</span>";
		}
				
		if (!$hilo) {
			echo "<span class='fr'><span class='nob'>".i("ultimainser",$ilink)." ".ifecha31($fechault,$ilink)."</span> &nbsp; ";
			echo "<span class='icon-pencil2'></span> <a class='' href='?id=$id'>";
			echo i("comentfor",$ilink)." [$num]</a></span>";
		}
		?>
		
	</div><br>
			
	<?php

	}
			
	$usu = ponerusu($usu_id,1,$ilink);

	?><div class="fila-usuario">
		<div class="foto"><?php
 	 		echo $usu[0];?>	
 		</div>
		<div class="datos">
			
			<?php echo $usu[1];
			// --------------------------------------------------
			$mens = "<span class='nob peq'>".ifecha31($fecha,$ilink)."</span><br>$temp";
			echo "<br>".$mens."<br>";
			$mens = "";
			if (!$hilo) {
				$flechas1 = "<span class='icon-eye' style='color:black'></span>";
				echo "<a href=\"javascript:amplred('div$id')\">$flechas1</a> ";
				$none = "style='display:none'";
			}
			echo "<span class='b'><a href='?id=$id'>".conhiper(consmy(quitabarra($asunto)))."</a></span>";
			if ($palabra) {$palabra = "<br><span class='rojo'>$palabra</span><br>";}
			echo $palabra;
			$palabra = "";
			?>
			<div <?php echo $none;?> class='col-10 justify' id='div<?php echo $id;?>'>
				<?php
				echo conhiper(consmy(quitabarra($comentario)));
				echo "<div id='votos".$id."'>";	
					votos($id,$voto,$usu_id,$ilink,$cerrado,'');
				echo "</div>";	$palabra = "pppppp";		
				if ($hilo AND !$noimp) {
					if ($cerrado == "0000-00-00 00:00:00") {
						echo "<br><form class='noimprimir' method='post' name='f$id' action='foros.php?id=$id' onsubmit=\"show('esperar$id');hide('ocul$id')\">";
						echo "<textarea name='comentario' rows='5' class='col-10' required></textarea>";
						echo "<div id='ocul$id'>";
							echo "<input class='col-2' type='submit' value=\" >> ".i("comentar",$ilink)." >> \">";
							if($hilo AND $x == 1) {
								echo "<span class='nob'>&nbsp; [<a class='nob peq' href='?$param&id=$id&idedit=$id'><span class='rojo'>".i("solopr",$ilink)."</span>: ".i("editmens",$ilink)."</a>] </span><br>";
							}
						echo "</div>";
						echo "<div id='esperar$id' class='rojo b' style='display:none'>$imgloader".i("esperar",$ilink)."</div>";
						echo "</form>";
					}
				}
				?>
			</div>
		</div>
	</div>
	
	<p><br</p><p><br></p><br><p><br></p>

<?php
return $x;

}

//poner el resto de mensajes del hilo
function restohilo($id,$puedoedit,$ilink,$imgloader) {
	if($_GET['impr']) {$noimp = "noponer";}
	$sql = "SELECT comentario, fecha, usu_id, id, foros_id, contest_a, voto, invisible FROM foro WHERE foro_id = '$id' AND asunto = '' ORDER BY fecha DESC";
	$result = $ilink->query($sql);
	if (!$result) {return;}
	
	$num = $result->num_rows;
	while ($fila = $result->fetch_array(MYSQLI_BOTH)) {
		$num--;
		
		if ($fila['invisible'] == 2 AND !$puedoedit){continue;}		
		
		if (!$num) {echo "<a name='ulti'></a>";}
		echo "<a name='f".$fila['id']."'></a>";

		if($puedoedit) {
			if ($_GET['id']) {$esid = "&id=".$_GET['id'];}
			if ($fila['invisible'] == 2) {
				echo "<span class='rojo nowrap'>".i("mensforoinvi",$ilink)." - <a href='?mvisi=".$fila['id']."$esid&conta=$conta' title=\"".i("mensforonoesvisi",$ilink)."\">".i("hilohacervisi",$ilink)."</a></span>";
			} else {
				echo "<span class='txth nowrap'>".i("mensforovisi",$ilink)." - <a href='?minvisi=".$fila['id']."$esid&conta=$conta' title=\"".i("mensforoesvisi",$ilink)."\">".i("hilohacerinvisi",$ilink)."</a></span>";
			} 
			echo "<p></p>";
		}

		$mens = "<span class='nob peq'>".ifecha31($fila['fecha'],$ilink)."</span>";
			
		$usu = ponerusu($fila['usu_id'],1,$ilink);
			
		?><div class="fila-usuario">
 	 		<div class="foto"><?php
 	 			echo $usu[0];?>	
 			</div>
			<?php	
			$fondo = ""; if ($fila['invisible'] == 2) {$fondo = "box11";}
			?>
			<div class="datos <?php echo $fondo;?>"><?php 	
				echo $usu[1]."<br>";?>
				<?php echo $mens."<br>";
				echo "<div class='justify'><span style='border:1px solid;padding:0 3px' class='b'>".$fila['foros_id']."</span> ";
					if ($fila['contest_a']) {echo " REF. <span style='border:1px solid;padding:0 3px' class='b'>".$fila['contest_a']."</span> ";}
					echo conhiper(consmy(quitabarra($fila['comentario'])));
					echo "<div id='votos".$fila['id']."'>";	
						votos($fila['id'],$fila['voto'],$fila['usu_id'],$ilink,$cerrado[0],'');
					echo "</div>";			
					?>
				</div>
				<div class='both'>
				<?php
					$iresult = $ilink->query("SELECT cerrado FROM foro WHERE id = '$id' LIMIT 1");
					$cerrado = $iresult->fetch_array(MYSQLI_BOTH);
					if ($cerrado[0]  == "0000-00-00 00:00:00" AND !$noimp) {
						echo "<br><form class='noimprimir' method='post' action='foros.php?id=$id' onsubmit=\"show('esperar".$fila['id']."');hide('ocul".$fila['id']."')\">";
						echo "<textarea name='comentario' class='col-10' rows='5' required></textarea>";
						echo "<input type='hidden' name='g' value='".$fila['foros_id']."'>";
						echo " <div id='ocul".$fila['id']."'>";
						echo "<input type='submit' class='col-2' value=\" >> ".i("comentar",$ilink)." >> \">";
						if ($puedoedit AND !$noimp) {
							echo "<span class='nob noimprimir'>&nbsp; [<a class='nob peq' href='?$param&id=$id&idedit=$fila[3]'>";
							echo "<span class='rojo'>".i("solopr",$ilink)."</span>: ".i("editmens",$ilink)."</a>]</span><br>";
						}
						echo "</div>";
						echo "<div id='esperar".$fila['id']."' class='rojo b' style='display:none'>$imgloader".i("esperar",$ilink)."</div>";
						echo "</form>";
					}
					if ($_GET['idcontest'] == $fila['id']) {
						$idcontest = $_GET['idcontest'];
						$contest = contestar($_GET['id'], $idcontest);
						echo "<p></p>".$contest;
					}
				?>
				</div>
			</div>
		</div><p><br></p>
		<?php
	}
}

//poner un hilo
function ponerunhilo($id,$ilink,$conta,$imgloader) {
	$iresult = $ilink->query("SELECT asigna, curso, grupo FROM foro WHERE id = '$id' LIMIT 1");
	$fila = $iresult->fetch_array(MYSQLI_BOTH);
	$puedoedit = primdehilo($id,1,$ilink,$conta,$imgloader);
	restohilo($id,$puedoedit,$ilink,$imgloader);
}

// --------------------------------------------------

//Descripci&oacute;n asignatura y titulaci&oacute;n
function descrip($ilink) {
	$iresult = $ilink->query("SELECT titulacion FROM podtitulacion WHERE cod = '".$_SESSION['tit']."'");
	$temp0 = $iresult->fetch_array(MYSQLI_BOTH);
	$iresult = $ilink->query("SELECT asignatura FROM podasignaturas WHERE cod = '".$_SESSION['asigna']."'");
	$temp1 = $iresult->fetch_array(MYSQLI_BOTH);
	$temp[0] = $temp0[0];
	$temp[1] = $temp1[0];
	return $temp;
}

//Icono y mensaje para iniciar hilo
function foroiniciar($titasi,$ilink) {
	if ($titasi == "todos") {//echo "<p></p>";
	return;}
	echo "<div style='margin:auto' class='col-2 noimprimir colu center'>";
	echo "<a href='?titasi=$titasi&ini=1'>";
	echo "<span class='icon-pencil2' style='color:black'></span> ";
	echo i("foroiniciar",$ilink)."</a></div>";
}

function nohaymens($ilink) {
	echo "<div class='center'><br>".i("nohaymens",$ilink)."</div>";
	return;
}

// --------------------------------------------------

//A&ntilde;adir nuevo hilo, formulario
function foronew($titasi,$ilink,$imgloader) { 
	if($titasi == "todos") {return;}
	echo "<br><form method='post' name='form1'  onsubmit=\"show('esperar');hide('ocul')\">";
	echo "<div style='margin:auto' class='col-5'>";
	if ($titasi == "general" AND $_SESSION['asigna']) {echo "<span id = 'mensa1' class='peq rojo'>".i("attforo",$ilink)."</span><p></p>";}
	echo "<label class='txth b'>".i("categoria",$ilink)."</label><br><input type='text' size='30' maxlength='100' name='categoria' class='col-10'>";
	echo "<p></p>";
	echo "<label class='txth b'>* ".i("asunto",$ilink)."</label><br><input type='text' size='30' maxlength='100' name='asunto' class='col-10' autofocus required>";
	echo "<p></p>";
	echo "<label class='txth b'>* ".i("comentario",$ilink)."</label><br><textarea rows='6' cols='50' name='comentario' class='col-10' required></textarea><p></p>";
	//echo "<div id='ocul'>";
	echo "<input id='ocul' class='col-3' type='submit' value=\" >> ".i("anadir1",$ilink)." >> \">";
	echo "<div id='esperar' style='display:none'>$imgloader".i("esperar",$ilink)."</div>";
	//echo "</div>";
	echo "<input type='hidden' name='foroini' value=1>";
	echo "</form><p></p></div>";
}

// --------------------------------------------------

//a&ntilde;adir comentario en foro id a comentario
function anadircoment($id,$titulaci,$asigna,$curso,$grupo,$ilink) {
	extract($_POST);
	$temp = gmdate("Y-m-d H:i:s");
	extract($_POST);
	if ($id) {
		$sql = "SELECT CONCAT(titulaci,' ',asigna,' ',curso,' ',grupo) FROM foro WHERE id = '$id'";
		$result = $ilink->query($sql);
		$fila = $result->fetch_array(MYSQLI_BOTH);
		$iresult = $ilink->query("SELECT MAX(foros_id) FROM foro WHERE foro_id = '$id'");
		$max = $iresult->fetch_array(MYSQLI_BOTH);
		$max = $max[0]+1;
		$titulaci = ""; $asigna = ""; $curso = ""; $grupo = "";
		$titasicurgru = $fila[0];
	} else {
		if ($_POST['categoria']) {$idpalabra = nuevacat($_POST['categoria'],$titulaci,$asigna,'',$ilink);}
		$titasicurgru = $titulaci." ".$asigna." ".$curso." ".$grupo;
	}
	if(!$comentario OR ($foroini AND !$asunto)) {return;}

	// ------------- que no exista ya ese comentario, evita recarga de pagina
	if(yaexiste($comentario,$ilink)) {return;}

	$result = $ilink->query("INSERT INTO foro (foro_id, usu_id, asunto, comentario, fecha, foros_id, contest_a, fechault, titulaci, asigna, curso, grupo, categoria) VALUES 
				('$id', '".$_SESSION['usuid']."', \"".addslashes($asunto)."\", \"".addslashes($comentario)."\", \"$temp\", \"$max\", '$g', \"$temp\", '$titulaci', '$asigna', '$curso', '$grupo', 
				'$idpalabra')");
	$idult = $ilink->insert_id;
	if (!$id) {
		$ilink->query("INSERT INTO social (fecha, fmodif, usuid, tabla, relid, titulaci, asigna, curso, grupo) VALUES ('$temp', \"$temp\", '".$_SESSION['usuid']."', 'foro', '$idult', '$titulaci', '$asigna', '$curso', '$grupo')");
	} else {
		$ilink->query("UPDATE social SET fmodif = '$temp' WHERE relid = '$id'");
	}
	if ($id) {
		$result = $ilink->query("UPDATE social SET fecha = '$temp' WHERE relid = '$id'");
		$result = $ilink->query("UPDATE foro SET fechault = '$temp' WHERE id = '$id' LIMIT 1");
		$usuarios = $ilink->query("SELECT DISTINCT usu_id FROM foro WHERE id = '$id' OR foro_id = '$id'");
		$iresult = $ilink->query("SELECT titulaci, asigna, curso, grupo, asunto FROM foro WHERE id = '$id' LIMIT 1");
		$ppal = $iresult->fetch_array(MYSQLI_BOTH);
		while ($fila = $usuarios->fetch_array(MYSQLI_BOTH)) {
			if ($_SESSION['usuid'] != $fila['usu_id'] AND $fila['usu_id']) {
				$titforo = "GENERAL";
				if ($ppal[0] OR $ppal[1]) {$titforo = "$ppal[0] $ppal[1] $ppal[2] $ppal[3]";}
				$para = $fila['usu_id'];
				$message = "Nuevo mensaje en el foro [ $titforo ] sobre el tema: <a href='foros.php?id=$id#f$idult' target='ficha' class='b'>$ppal[4]</a>";
				porhsm($message,$para,"",$ilink);
			}
		}
	} else {
		$id = $idult;
		$ppal[0] = $titulaci; $ppal[1] = $asigna;
		$gracias = str_replace("(asunto)", conhiper(consmy($asunto)), str_replace("(nombre)", minom(1,0,$ilink), i("graciasforo",$ilink)));
	}
	if ($ppal[0] OR $ppal[1]) {fxmail($idult,$id,$ilink);}
	return $gracias;
}

//Borrar un hilo
function borrarforo($id,$ilink) {
	if ($_SESSION['auto'] == 10) {borrarforo1($id,$ilink);}
	$iresult = $ilink->query("SELECT titulaci, asigna, curso, grupo FROM foro WHERE id = '$id' LIMIT 1");
	$fila = $iresult->fetch_array(MYSQLI_BOTH);
	if ($fila[0]) {
		if (esadmidetit($fila[0],$fila[2],$ilink)) {borrarforo1($id,$ilink);}
		return;
	}
	if ($fila[1]) {
		if (esprofesor($fila[1],$fila[2],$fila[3],$ilink)) {borrarforo1($id,$ilink); return;}
		$iresult = $ilink->query("SELECT tit FROM podcursoasignatit WHERE curso='$fila[2] AND asigna = '$fila[1]'");
		$tit = $iresult->fetch_array(MYSQLI_BOTH);
		if (esprofesordetit($tit[0],$fila[2],$ilink)) {borrarforo1($id,$ilink);}}
}
function borrarforo1($id,$ilink) {
	$sql = "SELECT id FROM foro WHERE id = '$id' LIMIT 1";
	$result = $ilink->query($sql);
	if (!$result) {return;}
	$ilink->query("DELETE FROM foro WHERE id = '$id' OR foro_id = '$id'");
	$ilink->query("DELETE FROM social WHERE relid = '$id' AND tabla='foro'");
}

//Cerrar un hilo
function hilocerrar($id,$ilink) {
	if ($_SESSION['auto'] == 10) {hilocerrar1($id,$ilink);}
	$iresult = $ilink->query("SELECT titulaci, asigna, curso, grupo FROM foro WHERE id = '$id' LIMIT 1");
	$fila = $iresult->fetch_array(MYSQLI_BOTH);
	if ($fila[0]) {
		if (esadmidetit($fila[0],$fila[2],$ilink)) {hilocerrar1($id,$ilink);}
		return;
	}
	if ($fila[1]) {
		if (esprofesor($fila[1],$fila[2],$fila[3],$ilink)) {hilocerrar1($id,$ilink); return;}
		$iresult = $ilink->query("SELECT tit FROM podcursoasignatit WHERE curso='$fila[2] AND asigna = '$fila[1]'");
		$tit = $iresult->fetch_array(MYSQLI_BOTH);
		if (esprofesordetit($tit[0],$fila[2],$ilink)) {hilocerrar1($id,$ilink);}}
}
function hilocerrar1($id,$ilink) {
	$ilink->query("UPDATE foro SET cerrado = '".gmdate("Y-m-d H:i:s")."' WHERE id = '$id' LIMIT 1");
}

//Invisibilizar un mensaje
function mensinvisi($id,$ilink) {
	$ilink->query("UPDATE foro SET invisible='2' WHERE id='$id' LIMIT 1");	
}

//Visibilizar un mensaje
function mensvisi($id,$ilink) {
	$ilink->query("UPDATE foro SET invisible='' WHERE id='$id' LIMIT 1");	
}

//Invisibilizar un hilo
function hiloinvisi($id,$ilink) {
	$ilink->query("UPDATE foro SET invisible='1' WHERE id='$id' LIMIT 1");	
}

//Visibilizar un hilo
function hilovisi($id,$ilink) {
	$ilink->query("UPDATE foro SET invisible='' WHERE id='$id' LIMIT 1");	
}

//Abrir un hilo
function hiloabrir($id,$ilink) {
	if ($_SESSION['auto'] == 10) {hiloabrir1($id,$ilink);}
	$iresult = $ilink->query("SELECT titulaci, asigna, curso, grupo FROM foro WHERE id = '$id' LIMIT 1");
	$fila = $iresult->fetch_array(MYSQLI_BOTH);
	if ($fila[0]) {
		if (esadmidetit($fila[0],$fila[2],$ilink)) {hiloabrir1($id,$ilink);}
		return;
	}
	if ($fila[1]) {
		if (esprofesor($fila[1],$fila[2],$fila[3],$ilink)) {hiloabrir1($id,$ilink); return;}
		$iresult = $ilink->query("SELECT tit FROM podcursoasignatit WHERE curso='$fila[2] AND asigna = '$fila[1]'");
		$tit = $iresult->fetch_array(MYSQLI_BOTH);
		if (esprofesordetit($tit[0],$fila[2],$ilink)) {hiloabrir1($id,$ilink);}}
}
function hiloabrir1($id,$ilink) {
	$ilink->query("UPDATE foro SET cerrado = '0000-00-00 00:00:00' WHERE id = '$id' LIMIT 1");
}

//Categor&iacute;as
function nuevacat($palabra,$entit,$enforo,$idedit,$ilink) {

	if($idedit) {
		$result = $ilink->query("SELECT palabra FROM forocategorias WHERE id = '$idedit' LIMIT 1");
		$fila = $result->fetch_array(MYSQLI_BOTH);
		if($palabra == $fila[0]) {return $idedit;}
	}

	if (!$entit AND !$enforo) {
		$iresult = $ilink->query("SELECT id, palabra FROM forocategorias WHERE tit='' AND asigna='' AND palabra=\"$palabra\"");
		$existe = $iresult->fetch_array(MYSQLI_BOTH);
		if ($existe) {return $existe[0];}
		$ilink->query("INSERT INTO forocategorias (palabra) VALUES (\"".$palabra."\")");
		return $ilink->insert_id;
	}
	
	if ($enforo) {
		$iresult = $ilink->query("SELECT id, palabra FROM forocategorias WHERE tit='' AND asigna='$enforo' AND palabra=\"$palabra\"");
		$existe = $iresult->fetch_array(MYSQLI_BOTH);
		if ($existe) {return $existe[0];}
		$ilink->query("INSERT INTO forocategorias (asigna, palabra) VALUES ('$enforo', \"".$palabra."\")");
		return $ilink->insert_id;
	}

	if ($entit) {
		$iresult = $ilink->query("SELECT id, palabra FROM forocategorias WHERE tit='$entit' AND asigna='' AND palabra=\"$palabra\"");
		$existe = $iresult->fetch_array(MYSQLI_BOTH);
		if ($existe) {return $existe[0];}
		$ilink->query("INSERT INTO forocategorias (tit, palabra) VALUES ('$entit', \"".$palabra."\")");
		return $ilink->insert_id;
	}
	
}

//En Social
function comentariosdeforo($relid,$ilink) {
	$sql = "SELECT * FROM foro WHERE foro_id ='$relid' ORDER BY fecha";
	$result = $ilink->query($sql);
	if (!$result->num_rows) {return;}
	echo " <a onclick=\"amplred('foro$relid')\"><button class='peq'><span class='icon-eye-blocked'></span> ".i("mostrar1",$ilink)." / ".i("ocultar1",$ilink)."</button></a><p></p>";
	echo "<div id='foro$relid' style='display:none'>";
	while ($fila = $result->fetch_array(MYSQLI_BOTH)) {
		extract($fila);
		if($fila['usu_id'] AND $fila['usu_id'] != $_SESSION['usuid']) {$clickar = 1;}
		echo "<div class='colu0'>";
		echo "<div class='fl'>";
			$usu = ponerusu($fila['usu_id'],1,$ilink);
			echo $usu[0];
			echo "</div>";
			echo "<div style='margin-left:50px;padding:13px'>";
				echo $usu[1];
				echo "<br><div class='peq nob'>".ifecha31($fila['fecha'],$ilink)."</div>";
				echo "<span style='border:1px solid;padding:0 3px' class='b'>".$fila['foros_id']."</span> ";
				if ($fila['contest_a']) {echo " REF. <span style='border:1px solid;padding:0 3px' class='b'>".$fila['contest_a']."</span> ";}
				echo conhiper(consmy($fila['comentario']));
			echo "</div>";
			mgnmg("foro",$id,$ilink,$clickar);
		echo "</div>";
	}
	echo "</div>";
	
}

function votos($id,$num,$usuid,$ilink,$cerrado,$mivoto) {

	$sql = "SELECT COUNT(voto) FROM forovotos WHERE id = '$id'";
	$result = $ilink->query($sql);
	if ($result->num_rows) {
		$fila = $result->fetch_array(MYSQLI_BOTH);
		$cantivot = $fila[0];
	}
	$sql = "SELECT voto FROM forovotos WHERE usuid ='".$_SESSION['usuid']."' AND id = '$id'";
	$result = $ilink->query($sql);
	if ($result->num_rows) {
		$fila = $result->fetch_array(MYSQLI_BOTH);
		$voto = $fila[0];
	}

	$temp = "voto";
	if($usuid == $_SESSION['usuid'] OR $voto OR ($cerrado AND $cerrado != '0000-00-00 00:00:00')) {$temp = "";}
	echo "<p></p>";
	if(!$num) {
		$resto = 10;
	} else {
		$int = intval($num);
		$deci = ($num - $int);
		$resto = (10 - $int);
		if($deci) {$resto--;}
	}
	
	$i = $j = 1;
	
	if($int) {
		for ($i = 1; $i <= $int; $i++) {
   		echo "<span id='v$id"."_"."$i' class='$temp icon-star-full grande'></span> ";
		}
		$j = $i;
	}
	
	if($deci) {
   	echo "<span id='v$id"."_"."$j' class='$temp icon-star-half grande'></span> ";
   	$j = ($j + 1);
	}
	
	for ($i = $j; $i <= 10; $i++) {
   	echo "<span id='v$id"."_"."$i' class='$temp icon-star-empty grande nob'></span> ";
	}
	
	if($voto AND !$mivoto) {echo " &nbsp; <span class='icon-star-full grande'></span>".$voto;}
	if($cantivot) {echo "<br>$cantivot votos";}
	
}

// --------------------------------------------------

function yaexiste($comentario, $ilink) {

	$iresult = $ilink->query("SELECT comentario FROM foro WHERE comentario=\"".addslashes($comentario)."\"");
	$existe = $iresult->fetch_array(MYSQLI_BOTH);
	if ($existe) {return 1;}

}

?>

