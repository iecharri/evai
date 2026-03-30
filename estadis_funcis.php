<?php 

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

require_once APP_DIR . "/gic_actu.php";

function actualizar($soloid,$asigna,$curso,$grupo,$ilink) {
	
	$where = "WHERE 1=1";
	if($soloid) {$where .= " AND id='$soloid'";}
	if($asigna) {
		$where .= " AND asigna='$asigna' AND curso='$curso' AND grupo='$grupo'";
		$sql = "SELECT estadisf1,estadisf2 FROM cursasigru $where";
		$result = $ilink->query($sql);
		$fromto = $result->fetch_array(MYSQLI_BOTH);

		$desde = $fromto[0];
		$hasta = $fromto[1]; $hastavinc = $fromto[1];

	}
	
	$sql = "SELECT DISTINCT id FROM tempoestadis $where";
	$result = $ilink->query($sql);
	
	while ($fila = $result->fetch_array(MYSQLI_BOTH)) {

		extract($fila);
		
		if($u != $id) {
			
			$u = $id;

			$datosusu = datosusu($id,$desde,$hasta,$ilink);
			$tabla = datos($id,$desde,$hasta,$ilink);
			$tenlinea = tenlinea($id,$desde,$hasta,$ilink);
			$ultiacc = ultiacc($id,$desde,$hasta,$ilink);

			$sql = "UPDATE tempoestadis SET numvalorfich = '$tabla[3]', mediafich = '$tabla[4]', desvtipfic = '$tabla[5]', numvalorvid = '$tabla[6]', mediavid = '$tabla[7]', 
						desvtipvid = '$tabla[8]', numvisitas = '$datosusu[0]', tacumulado = ";
			if($tenlinea OR $desde OR $hasta) {
				$sql .= "'$tenlinea'";
			} else {
				$sql .= "'$datosusu[2]'";
			}
			$sql .= ", ultiacceso =";
			if(!$desde AND !$hasta AND !$ultiacc) {
				$sql .= "'$datosusu[1]'";
			} else {
				$sql .= "'$ultiacc'";
			}			

			//$sql .= ", numvinc='$datosusu[3]', coment='$datosusu[4]', nota='$datosusu[5]', desvtip='$datosusu[6]', numvincvot='$datosusu[7]'";
	
			$sql .=  " WHERE id = '$u' ";
			$ilink->query($sql);
		
		}

	}
	
	estadis_foro($soloid,$asigna,$curso,$grupo,$ilink);
	estadis_vinc($soloid,$asigna,$curso,$grupo,$desde,$hastavinc,$ilink);
	estadis_tarea($soloid,$asigna,$curso,$grupo,$ilink);
	estadis_notaa($soloid,$asigna,$curso,$grupo,$desde,$hastavinc,$ilink);
	estadis_notap($soloid,$asigna,$curso,$grupo,$desde,$hastavinc,$ilink);
	
}

// --------------------------------------------------

function estadis_notaa($id,$asigna,$curso,$grupo,$desde,$hasta,$ilink) {

	if(!$desde) {$desde = "0000-00-00 00:00:00";}
	if(!$hasta) {$hasta = "9999-12-31 00:00:00";}

	if(!$id) {
		if(!$asigna) {return;}
		//toda una asigna
		//buscar fecha en que puso nota entre desde y hasta
		$sql = "SELECT OF_fecha_nota,EJ_fecha_nota,ES_fecha_nota,OJ_fecha_nota,fecha_nota FROM alumasiano WHERE asigna='$asigna' AND curso='$curso' AND grupo='$grupo'";
		$result = $ilink->query($sql);
		while ($fila = $result->fetch_array(MYSQLI_BOTH)) {
			extract($fila);
			if($OF_fecha_nota != "0000-00-00 00:00:00" AND $OF_fecha_nota >= $desde AND $OF_fecha_nota <= $hasta) {$conv = "OF_";break;}
			if($EJ_fecha_nota != "0000-00-00 00:00:00" AND $EJ_fecha_nota >= $desde AND $EJ_fecha_nota <= $hasta) {$conv = "EJ_";break;}
			if($ES_fecha_nota != "0000-00-00 00:00:00" AND $ES_fecha_nota >= $desde AND $ES_fecha_nota <= $hasta) {$conv = "ES_";break;}
			if($OJ_fecha_nota != "0000-00-00 00:00:00" AND $OJ_fecha_nota >= $desde AND $OJ_fecha_nota <= $hasta) {$conv = "OJ_";break;}
			if($fecha_nota != "0000-00-00 00:00:00" AND $fecha_nota > $desde AND $fecha_nota < $hasta) {$conv = "*";break;}
		}
		if(!$conv) {
			$sql1 = "UPDATE tempoestadis SET notatot = '', aprobado = '' WHERE asigna='$asigna' AND curso='$curso' AND grupo='$grupo'";
			$ilink->query($sql1);
			return;
		}
		if($conv == "*") {$conv="";}
		$sql = "SELECT id, $conv"."fecha_nota, $conv"."total, $conv"."aprobado FROM alumasiano	WHERE asigna='$asigna' AND curso='$curso' AND grupo='$grupo'";
		$result = $ilink->query($sql);
		while ($fila = $result->fetch_array(MYSQLI_BOTH)) {
			$sql1 = "UPDATE tempoestadis SET notatot = '$fila[2]', aprobado = '$fila[3]' WHERE id='$fila[0]' AND asigna='$asigna' AND curso='$curso' AND grupo='$grupo'";
			$ilink->query($sql1);
		}
	} else {
		//un id cada una de sus asigna
		$sql = "SELECT asigna,curso,grupo FROM alumasiano WHERE id='$id'";
		$result = $ilink->query($sql);
		while ($fila = $result->fetch_array(MYSQLI_BOTH)) {
			extract($fila);
			$asigna = trim($asigna);
			$sql1 = "SELECT OF_fecha_nota,EJ_fecha_nota,ES_fecha_nota,OJ_fecha_nota,fecha_nota FROM alumasiano WHERE asigna='$asigna' AND curso='$curso' AND grupo='$grupo'";
			$result1 = $ilink->query($sql1);
			while ($fila1 = $result1->fetch_array(MYSQLI_BOTH)) {
				extract($fila1);
				if($OF_fecha_nota > $desde AND $OF_fecha_nota < $hasta) {$conv = "OF_";break;}
				if($EJ_fecha_nota > $desde AND $EJ_fecha_nota < $hasta) {$conv = "EJ_";break;}
				if($ES_fecha_nota > $desde AND $ES_fecha_nota < $hasta) {$conv = "ES_";break;}
				if($OJ_fecha_nota > $desde AND $OJ_fecha_nota < $hasta) {$conv = "OJ_";break;}
				if($fecha_nota > $desde AND $fecha_nota < $hasta) {$conv = "";break;}
			}
			$sql2 = "SELECT $conv"."fecha_nota, $conv"."total, $conv"."aprobado FROM alumasiano	WHERE id='$id' AND asigna='$asigna' AND curso='$curso' AND grupo='$grupo'";
			$result2 = $ilink->query($sql2);
			$fila2 = $result2->fetch_array(MYSQLI_BOTH);
			$sql3 = "UPDATE tempoestadis SET notatot = '$fila2[2]', aprobado = '$fila2[3]' WHERE id='$id' AND asigna='$asigna' AND curso='$curso' AND grupo='$grupo'";
			$ilink->query($sql3);
		}
	}
	
}

// --------------------------------------------------

function estadis_notap($id,$asigna,$curso,$grupo,$desde,$hasta,$ilink) {

	//nota recibida por profesores en profvotar
	
	if(!$desde) {$desde = "0000-00-00 00:00:00";}
	if(!$hasta) {$hasta = "9999-12-31 00:00:00";}
	
	if(!$id) {
		//toda una asigna
		if(!$asigna) {return;} 
		$sql = "SELECT usuid FROM asignatprof WHERE asigna='$asigna' AND curso='$curso' AND grupo='$grupo'";
		$result = $ilink->query($sql);
		while ($fila = $result->fetch_array(MYSQLI_BOTH)) {
			$sql1 = "SELECT AVG((activi + materia + asist)/3) FROM profvotar WHERE asicurgru = '$asigna*$curso*$grupo' AND id='$fila[0]' AND fecha >= '$desde' AND fecha <= '$hasta'";
			$result1 = $ilink->query($sql1);
			$fila1 = $result1->fetch_array(MYSQLI_BOTH);
			$sql2 = "UPDATE tempoestadis SET notatot = '$fila1[0]' WHERE id='$fila[0]' AND asigna='$asigna' AND curso='$curso' AND grupo='$grupo'";
			$ilink->query($sql2);
		}
		
	} else {
		//un id cada una de sus asigna
		$sql = "SELECT asigna,curso,grupo FROM asignatprof WHERE usuid='$id'";
		$result = $ilink->query($sql);
		while ($fila = $result->fetch_array(MYSQLI_BOTH)) {
			extract($fila);
			$asigna = trim($asigna);
			$sql1 = "SELECT  AVG((activi + materia + asist)/3) FROM profvotar WHERE asicurgru = '$asigna*$curso*$grupo' AND id='$id' AND fecha >= '$desde' AND fecha <= '$hasta'";
			$result1 = $ilink->query($sql1);
			$fila1 = $result1->fetch_array(MYSQLI_BOTH);
			$sql2 = "UPDATE tempoestadis SET notatot = '$fila1[0]' WHERE id='$id' AND asigna='$asigna' AND curso='$curso' AND grupo='$grupo'";
			$ilink->query($sql2);
		}
	}	
	
}

// --------------------------------------------------

function estadis_tarea($id,$asigna,$curso,$grupo,$ilink) {

	$ruta = DATA_DIR . '/usuarios/';
	$asicurgru = $asigna."$$".$curso."$$".$grupo;
	
	if(!$id) {
		if(!$asigna) {return;}
		//toda una asigna
		$sql = "SELECT alumasiano.id, usuario FROM alumasiano LEFT JOIN usuarios ON alumasiano.id=usuarios.id WHERE fechabaja='0000-00-00 00:00:00' AND asigna='$asigna' AND curso='$curso' AND grupo='$grupo'";
		$result = $ilink->query($sql);
		while ($fila = $result->fetch_array(MYSQLI_BOTH)) {
			extract($fila);
			$ruta1 = $ruta.$usuario."/profesor/".$asicurgru."/";
			if(!file_exists($ruta1)) {continue;}
			$dir = opendir($ruta1);
			$ultime = "";
			while ($elem = readdir($dir)) {
				if ($elem == "." OR $elem == "..") {continue;}
				$fich = $ruta1.$elem;
				$time = filemtime($fich);
				if($time > $ultime) {$ultime = $time;}
			}
			if($ultime) {
				$sql = "UPDATE tempoestadis SET ultimetarea = '".gmdate('Y-m-d H:i:s',$ultime)."' WHERE id = '$id' AND asigna = '$asigna' AND curso = '$curso' AND grupo = '$grupo'";
				$ilink->query($sql);
			}
		}
	} else {
		//un id cada una de sus asigna
		$sql = "SELECT usuario FROM usuarios WHERE id='$id'";
		$result = $ilink->query($sql);
		$fila = $result->fetch_array(MYSQLI_BOTH);
		$ruta .= "$fila[0]/profesor/";
		if(!file_exists($ruta)) {return;}
		$dir = opendir($ruta);
		while ($elem = readdir($dir)) {
			if ($elem == "." OR $elem == ".." OR !is_dir($ruta.$elem)) {continue;}
			$ruta1 = $ruta.$elem."/";
			$dir1 = opendir($ruta1);
			$ultime = "";
			while ($elem1 = readdir($dir1)) {
				if ($elem1 == "." OR $elem1 == "..") {continue;}
				$acg = explode("$$", $elem);
				$fich1 = $ruta1.$elem1;
				$time = filemtime($fich1);
				if($time > $ultime) {$ultime = $time;}
			}
			if($ultime) {
				$sql = "UPDATE tempoestadis SET ultimetarea = '".gmdate('Y-m-d H:i:s',$ultime)."' WHERE id = '$id' AND asigna = '$acg[0]' AND curso = '$acg[1]' AND grupo = '$acg[2]'";
				$ilink->query($sql);
			}
		}
	}	

}

// --------------------------------------------------

function estadis_vinc($id,$asigna,$curso,$grupo,$desde,$hasta,$ilink) {

	//necesito numvinc, numvotrec, nota, numvincvot, (media votos emitidos), coment en un tiempo y asicurgru
	//$desde = str_replace("-","",$desde);
	//$hasta = str_replace("-","",$hasta);
	if($desde) {$desdecom = "AND vinchs2.fecha >= '$desde'";$desde = "AND fechacrea1 >= '$desde'";}
	if($hasta) {$hastacom = "AND vinchs2.fecha <= '$hasta'";$hasta = "AND fechacrea1 <= '$hasta'";}
	if($area) {$area = "AND area == '$asigna'";}
	
	if(!$id) {
		if(!$asigna) {
			//todos
			$sql = "SELECT usu_id AS idx, COUNT(id) FROM vinculos GROUP BY usu_id,area";
			//v recibidos n, media
			$sqlrec = "SELECT vinculos.usu_id AS idx,COUNT(votos),AVG(votos),STDDEV(votos),area AS asigna FROM votos LEFT JOIN vinculos ON votos.vinculo_id=vinculos.id GROUP BY vinculos.usu_id,area";
			//v emitidos n, media
			$sqlemi = "SELECT votos.usu_id AS idx,COUNT(votos),AVG(votos),STDDEV(votos),area AS asigna FROM `votos` left join vinculos on votos.vinculo_id=vinculos.id GROUP BY votos.usu_id,area";
			$coment = "SELECT vinchs2.usu_id AS idx,COUNT(vinchs2.id),area AS asigna FROM vinchs2 LEFT JOIN vinculos ON vinchs2.id=vinculos.id GROUP BY vinchs2.usu_id,area";
		} else {
			//toda una asigna
			$sql = "SELECT usu_id AS idx, COUNT(id) FROM vinculos WHERE area = '$asigna' $desde $hasta GROUP BY usu_id";
			//v recibidos n, media
			$sqlrec = "SELECT vinculos.usu_id AS idx,COUNT(votos),AVG(votos),STDDEV(votos),area AS asigna FROM votos LEFT JOIN vinculos ON votos.vinculo_id=vinculos.id 
							WHERE area = '$asigna' $desde $hasta GROUP BY vinculos.usu_id";
			//v emitidos n, media
			$sqlemi = "SELECT votos.usu_id AS idx,COUNT(votos),AVG(votos),STDDEV(votos),area AS asigna FROM `votos` left join vinculos ON votos.vinculo_id=vinculos.id 
							WHERE area = '$asigna' $desde $hasta GROUP BY votos.usu_id,area";
			$coment = "SELECT vinchs2.usu_id AS idx,COUNT(vinchs2.id),area AS asigna FROM vinchs2 LEFT JOIN vinculos ON vinchs2.id=vinculos.id 
							WHERE area = '$asigna' $desdecom $hastacom GROUP BY vinchs2.usu_id,area"; 

		}
	} else {
		//un id cada una de sus asigna
		$sql = "SELECT usu_id AS idx, COUNT(id), area AS asigna FROM vinculos WHERE usu_id='$id' GROUP BY usu_id,area";
		//v recibidos n, media
		$sqlrec = "SELECT vinculos.usu_id AS idx,COUNT(votos),AVG(votos),STDDEV(votos),area AS asigna FROM votos LEFT JOIN vinculos ON votos.vinculo_id=vinculos.id 
						WHERE vinculos.usu_id='$id' $desde $hasta GROUP BY vinculos.usu_id,area";
		//v emitidos n, media
		$sqlemi = "SELECT votos.usu_id AS idx,COUNT(votos),AVG(votos),STDDEV(votos),area AS asigna FROM votos left join vinculos on votos.vinculo_id=vinculos.id 
						WHERE votos.usu_id='$id' $desde $hasta GROUP BY votos.usu_id,area";
		$coment = "SELECT vinchs2.usu_id AS idx,COUNT(vinchs2.id),area AS asigna FROM vinchs2 LEFT JOIN vinculos ON vinchs2.id=vinculos.id 
						WHERE vinchs2.usu_id = '$id' $desdecom $hastacom GROUP BY vinchs2.usu_id,area";						
	}

	$result = $ilink->query($sql);
	while ($fila = $result->fetch_array(MYSQLI_BOTH)) {
		extract($fila);
		if($asigna) {$temp = "AND asigna='$asigna'";} else {$temp = "AND asigna=''";}
		$sql1 = "UPDATE tempoestadis SET numvinc='$fila[1]' WHERE id='$idx' $temp";
		$ilink->query($sql1);
		totvincusu($idx,$ilink);
	}
	$result = $ilink->query($sqlrec);
	while ($fila = $result->fetch_array(MYSQLI_BOTH)) {
		extract($fila);
		if($asigna) {$temp = "AND asigna='$asigna'";} else {$temp = "AND asigna=''";}
		$sql1 = "UPDATE tempoestadis SET numvotrec='$fila[1]', nota='$fila[2]', desvtip='$fila[3]' WHERE id='$idx' $temp";
		$ilink->query($sql1);
		totvincusu($idx,$ilink);
	}
	$result = $ilink->query($sqlemi);
	while ($fila = $result->fetch_array(MYSQLI_BOTH)) {
		extract($fila);
		if($asigna) {$temp = "AND asigna='$asigna'";} else {$temp = "AND asigna=''";}
		$sql1 = "UPDATE tempoestadis SET numvincvot='$fila[1]', notaemi='$fila[2]', desvtipemi='$fila[3]' WHERE id='$idx' $temp";
		$ilink->query($sql1);
		totvincusu($idx,$ilink);
	}
	$result = $ilink->query($coment);
	while ($fila = $result->fetch_array(MYSQLI_BOTH)) {
		extract($fila);
		if($asigna) {$temp = "AND asigna='$asigna'";} else {$temp = "AND asigna=''";}
		$sql1 = "UPDATE tempoestadis SET coment='$fila[1]' WHERE id='$idx' $temp";
		$ilink->query($sql1);
		totvincusu($idx,$ilink);
	}
	
}

// --------------------------------------------------

function totvincusu($idx,$ilink) {

	//un id total
	$sql = "SELECT usu_id AS idx, COUNT(id) FROM vinculos WHERE usu_id='$idx'";
	$sqlrec = "SELECT vinculos.usu_id AS idx,COUNT(votos),AVG(votos),STDDEV(votos) FROM votos LEFT JOIN vinculos ON votos.vinculo_id=vinculos.id WHERE vinculos.usu_id='$idx'";
	$sqlemi = "SELECT votos.usu_id AS idx,COUNT(votos),AVG(votos),STDDEV(votos) FROM `votos` left join vinculos on votos.vinculo_id=vinculos.id WHERE votos.usu_id='$idx'";

	$result = $ilink->query($sql);
	$fila = $result->fetch_array(MYSQLI_BOTH);
	extract($fila);
	$sql = "UPDATE tempoestadis SET numvinc='$fila[1]' WHERE id='$idx' AND asigna=''";
	$ilink->query($sql);

	$result = $ilink->query($sqlrec);
	$fila = $result->fetch_array(MYSQLI_BOTH);
	extract($fila);
	$sql = "UPDATE tempoestadis SET numvotrec='$fila[1]', nota='$fila[2]', desvtip='$fila[3]' WHERE id='$idx' AND asigna=''";
	$ilink->query($sql);

	$result = $ilink->query($sqlemi);
	$fila = $result->fetch_array(MYSQLI_BOTH);
	extract($fila); //corregido 9-2023 en líena siguiente ponía numvvincvot
	$sql = "UPDATE tempoestadis SET numvincvot='$fila[1]', notaemi='$fila[2]', desvtipemi='$fila[3]' WHERE id='$idx' AND asigna=''";
	$ilink->query($sql);

}

// --------------------------------------------------

function estadis_foro($id,$asigna,$curso,$grupo,$ilink) {

	if(!$id) {
		if(!$asigna) {
			//todos
			$sql = "SELECT usu_id AS idx,asigna,curso,grupo,COUNT(usu_id),SUM(CHARACTER_LENGTH(comentario)) FROM foro GROUP BY usu_id,asigna,curso,grupo";
			//v recibidos n, media
			$sqlrec = "SELECT foro.usu_id AS idx,asigna,curso,grupo,COUNT(forovotos.voto),AVG(forovotos.voto),STDDEV(forovotos.voto) FROM `forovotos` LEFT JOIN foro ON forovotos.id = foro.id 
							GROUP BY usu_id,asigna,curso,grupo";
			//v emitidos n, media
			$sqlemi = "SELECT forovotos.usuid AS idx,asigna,curso,grupo,COUNT(forovotos.voto),AVG(forovotos.voto),STDDEV(forovotos.voto) FROM `forovotos` LEFT JOIN foro ON forovotos.id = foro.id 
							GROUP BY usuid,asigna,curso,grupo";
		} else {
			//toda una asigna
			$sql = "SELECT usu_id AS idx,asigna,curso,grupo,COUNT(usu_id),SUM(CHARACTER_LENGTH(comentario)) FROM foro WHERE asigna='$asigna' AND curso='$curso' AND grupo='$grupo' GROUP BY usu_id";
			//v recibidos n, media
			$sqlrec = "SELECT foro.usu_id AS idx,asigna,curso,grupo,COUNT(forovotos.voto),AVG(forovotos.voto),STDDEV(forovotos.voto) FROM `forovotos` LEFT JOIN foro ON forovotos.id = foro.id 
							WHERE asigna='$asigna' AND curso='$curso' AND grupo='$grupo' GROUP BY usu_id";
			//v emitidos n, media
			$sqlemi = "SELECT forovotos.usuid AS idx,asigna,curso,grupo,COUNT(forovotos.voto),AVG(forovotos.voto),STDDEV(forovotos.voto) FROM `forovotos` LEFT JOIN foro ON forovotos.id = foro.id 
							WHERE asigna='$asigna' AND curso='$curso' AND grupo='$grupo' GROUP BY usuid";
		}
	} else {
		//un id cada una de sus asigna
		$sql = "SELECT usu_id AS idx,asigna,curso,grupo,COUNT(usu_id),SUM(CHARACTER_LENGTH(comentario)) FROM foro WHERE usu_id='$id' GROUP BY asigna,curso,grupo";
		//v recibidos n, media
		$sqlrec = "SELECT foro.usu_id AS idx,asigna,curso,grupo,COUNT(forovotos.voto),AVG(forovotos.voto),STDDEV(forovotos.voto) FROM `forovotos` LEFT JOIN foro ON forovotos.id = foro.id 
						WHERE usu_id='$id' GROUP BY asigna,curso,grupo";
		//v emitidos n, media
		$sqlemi = "SELECT forovotos.usuid AS idx,asigna,curso,grupo,COUNT(forovotos.voto),AVG(forovotos.voto),STDDEV(forovotos.voto) FROM `forovotos` LEFT JOIN foro ON forovotos.id = foro.id 
						WHERE usuid='$id' GROUP BY asigna,curso,grupo";
		
	}

	$result = $ilink->query($sql);
	while ($fila = $result->fetch_array(MYSQLI_BOTH)) {
		extract($fila);
		if($asigna) {$temp = "AND asigna='$asigna' AND curso='$curso' AND grupo='$grupo'";} else {$temp = "AND asigna=''";}
		$sql1 = "UPDATE tempoestadis SET forowri='$fila[4]', forochar='$fila[5]' WHERE id='$idx' $temp";
		$ilink->query($sql1);
		totforousu($idx,$ilink);
	}
	$result = $ilink->query($sqlrec);
	while ($fila = $result->fetch_array(MYSQLI_BOTH)) {
		extract($fila);
		if($asigna) {$temp = "AND asigna='$asigna' AND curso='$curso' AND grupo='$grupo'";} else {$temp = "AND asigna=''";}
		$sql1 = "UPDATE tempoestadis SET forovrec='$fila[4]', fororecmed='$fila[5]', fororecds='$fila[6]' WHERE id='$idx' $temp";
		$ilink->query($sql1);
	}
	$result = $ilink->query($sqlemi);
	while ($fila = $result->fetch_array(MYSQLI_BOTH)) {
		extract($fila);
		if($asigna) {$temp = "AND asigna='$asigna' AND curso='$curso' AND grupo='$grupo'";} else {$temp = "AND asigna=''";}
		$sql1 = "UPDATE tempoestadis SET forovemi='$fila[4]', foroemimed='$fila[5]', foroemids='$fila[6]' WHERE id='$idx' $temp";
		$ilink->query($sql1);
	}
	
}


function totforousu($idx,$ilink){

	//un id total
	$sql = "SELECT usu_id AS idx,asigna,curso,grupo,COUNT(usu_id),SUM(CHARACTER_LENGTH(comentario)) FROM foro WHERE usu_id='$idx'";
	$sqlrec = "SELECT foro.usu_id AS idx,asigna,curso,grupo,COUNT(forovotos.voto),AVG(forovotos.voto),STDDEV(forovotos.voto) FROM `forovotos` LEFT JOIN foro ON forovotos.id = foro.id 
					WHERE usu_id='$idx'";
	$sqlemi = "SELECT forovotos.usuid AS idx,asigna,curso,grupo,COUNT(forovotos.voto),AVG(forovotos.voto),STDDEV(forovotos.voto) FROM `forovotos` LEFT JOIN foro ON forovotos.id = foro.id 
					WHERE usuid='$idx'";
	$result = $ilink->query($sql);
	$fila = $result->fetch_array(MYSQLI_BOTH);
	extract($fila);
	$sql = "UPDATE tempoestadis SET forowri='$fila[4]', forochar='$fila[5]' WHERE id='$idx' AND asigna=''";
	$ilink->query($sql);
	$result = $ilink->query($sqlrec);
	$fila = $result->fetch_array(MYSQLI_BOTH);
	extract($fila);
	$sql = "UPDATE tempoestadis SET forovrec='$fila[4]', fororecmed='$fila[5]', fororecds='$fila[6]' WHERE id='$idx' AND asigna=''";
	$ilink->query($sql);
	$result = $ilink->query($sqlemi);
	$fila = $result->fetch_array(MYSQLI_BOTH);
	extract($fila);
	$sql = "UPDATE tempoestadis SET forovemi='$fila[4]', foroemimed='$fila[5]', foroemids='$fila[6]' WHERE id='$idx' AND asigna=''";
	$ilink->query($sql);

}

// --------------------------------------------------

function datosusu($usuid,$desde,$hasta,$ilink) {

	$sql = "SELECT numvisitas,fechalogin,(tultimo+tacumulado),numvinc,coment,nota,desvtip,numvincvot FROM usuarios WHERE id = '$usuid'";
	$result = $ilink->query($sql);
	$fila = $result->fetch_array(MYSQLI_BOTH);
	return $fila;

}

// --------------------------------------------------

function ultiacc($usuid,$desde,$hasta,$ilink) {

	if($desde) {$desde = "AND entra >= '$desde'";}
	if($hasta) {$hasta = "AND sale <= '$hasta'";}
	$sql = "SELECT entra, sale FROM usosistema WHERE id = '$usuid' $desde $hasta ORDER BY entra DESC LIMIT 1";
	$result = $ilink->query($sql);
	if($result->num_rows) {
		$ulti = $result->fetch_array(MYSQLI_BOTH);
		if($ulti[1] != "0000-00-00 00:00:00") {
			return $ulti[1];
		}
		if($ulti[0] != "0000-00-00 00:00:00") {
			return $ulti[0];
		}
	}
}

// --------------------------------------------------

function tenlinea($usuid,$desde,$hasta,$ilink) {

	$sql = "SELECT SUM(TIME_TO_SEC(TIMEDIFF(sale, entra))) AS diff FROM usosistema WHERE sale != '0000-00-00 00:00:00' AND id = '$usuid'
				AND sale >= '$desde' AND entra <= '$hasta'";
	$result = $ilink->query($sql);
	$totime = $result->fetch_array(MYSQLI_BOTH);
	if($totime[0]) {
		return $totime[0];
	}
	
}

// --------------------------------------------------

function datos($id,$desde,$hasta,$ilink) {  

	if($desde) {$desde = "AND fecha >= '$desde'";}
	if($hasta) {$hasta = "AND fecha <= '$hasta'";}
	
	$iresult = $ilink->query("SELECT COUNT(usuid) AS fusuid, AVG(ficha) AS fficha, STDDEV(ficha) AS sficha FROM fichavaloracion WHERE usuid = '$id' $desde $hasta AND ficha > 0");
	$valoraf = $iresult->fetch_array(MYSQLI_BOTH);
	extract($valoraf);

	$numvalorfich = $fusuid;
	$mediafich = $fficha;
	$desvtipfic = $sficha;

	$iresult = $ilink->query("SELECT COUNT(usuid) AS vusuid, AVG(video) AS vvideo, STDDEV(video) AS svideo FROM fichavaloracion WHERE usuid = '$id' $desde $hasta AND video > 0");
	$valorav = $iresult->fetch_array(MYSQLI_BOTH);
	extract($valorav);

	$numvalorvid = $vusuid;
	$mediavid = $vvideo;
	$desvtipvid = $svideo;

	$tabla[3] = $numvalorfich;
	$tabla[4] = $mediafich;
	$tabla[5] = $desvtipfic;
	$tabla[6] = $numvalorvid;
	$tabla[7] = $mediavid;
	$tabla[8] = $desvtipvid;
	
	return $tabla;
	
}

// --------------------------------------------------

function fromto($asigna,$curso,$grupo,$ilink) {

	$sql = "SELECT estadisf1, estadisf2 FROM cursasigru WHERE asigna='$asigna' AND curso='$curso' AND grupo='$grupo' LIMIT 1";
	$result = $ilink->query($sql);
	$fila = $result->fetch_array(MYSQLI_BOTH);

	$d1utc = $fila[0];
	$d2utc = $fila[1];
	
	$d1 = utcausu1($d1utc);
	$d2 = utcausu1($d2utc);

	if($_POST['submfromto']) {
		$d1 = $_POST['d1'];
		$d2 = $_POST['d2'];

		$d1utc = usuautc1($d1,''); $d1utc = $d1utc[0];
		$d2utc = usuautc1($d2,''); $d2utc = $d2utc[0];

		$sql = "UPDATE cursasigru SET estadisf1='$d1utc', estadisf2='$d2utc' WHERE asigna='$asigna' AND curso='$curso' AND grupo='$grupo'";
		$ilink->query($sql);

	}

	if($_SESSION['auto'] > 4) {
		$temp = "datepicker";
	} else {
		$temp1 = "disabled";	
	}
	
	echo "<form method='post'>";	
	echo "<input type='text' name='d1' size='10' maxlength='10' value='$d1' class='col-05 peq $temp' $temp1>";
	echo " -> ";
	echo "<input type='text' name='d2' size='10' maxlength='10' value='$d2' class='col-05 peq $temp' $temp1>";
	if($_SESSION['auto'] > 4) {
		echo " <input type='submit' name='submfromto' value='>>' class='col-05'>";
		echo "<input type='hidden' name='actu' value='1'>";
	}
	echo "</form>";
	
}

if(empty($d1utc) || empty($d2utc) || $d1utc == '0000-00-00' || $d2utc == '0000-00-00') {return 1;}

?>
