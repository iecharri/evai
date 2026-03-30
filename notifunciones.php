<?php

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

function ag_ini($ilink) {
    // 1) Determinar zona (para "hoy" si no llega parametro)
    $zonaUsuario = $_SESSION['zone'] ?? 'UTC';
    $tz = new DateTimeZone($zonaUsuario);

    // 2) Construir fecha base
    if (!empty($_POST['nuevo_mes']) && !empty($_POST['nuevo_ano'])) {
        // POST manda año/mes
        $y = (int)$_POST['nuevo_ano'];
        $m = (int)$_POST['nuevo_mes'];
        // clamp sencillo por si acaso
        if ($m < 1) $m = 1; elseif ($m > 12) $m = 12;
        $base = new DateTime(sprintf('%04d-%02d-01', $y, $m), $tz);
    } else {
        // GET puede venir como YYYY-MM o YYYY-MM-DD
        $ag = $_GET['ag'] ?? '';
        if (is_string($ag) && preg_match('/^\d{4}-\d{2}(-\d{2})?$/', $ag)) {
            // si no trae día, usar 01
            if (strlen($ag) === 7) $ag .= '-01';
            $base = new DateTime($ag, $tz);
        } else {
            // fallback: hoy en zona de usuario
            $base = new DateTime('now', $tz);
            // anclar a primer día del mes para navegación estable
            $base->modify('first day of this month');
        }
    }

    // 3) Calcular meses vecino/anterior/siguiente con DateTime (evita restas de strings)
    $curr = clone $base;                         // mes actual
    $prev = (clone $base)->modify('-1 month');   // mes anterior
    $next = (clone $base)->modify('+1 month');   // mes siguiente

    // 4) Preparar salidas
    $calen = [];
    $calen[] = $prev->format('Y-m');
    $calen[] = $curr->format('Y-m');
    $calen[] = $next->format('Y-m');

    // i($mes, $ilink) -> usamos MM del mes actual
    $mesMM = $curr->format('m');
    $calen[] = i($mesMM, $ilink);

    return $calen;
}


// --------------------------------------------------

function arraymes($ag,$miagenda,$g,$titasi,$ilink) {
	
$poner = array();

$ag = substr($ag,0,7); 

list($inicioUTC, $finUTC) = rangoUTCdesdeYMUsuario($ag);

$sql = "SELECT id, visible, mostrar, DAY(dia) AS diax, hora, asigna, descripcion, autor, detalle, tablon, curso, grupo, titulaci FROM noticias WHERE 
(mostrar = 1 OR autor = '{$_SESSION['usuid']}') AND dia >= '$inicioUTC' AND dia < '$finUTC'";

if ($titasi == 2) {
	$sql .= " AND (asigna = '".$_SESSION['asigna']."'";
	if ($_SESSION['curso']) {$sql .= " AND (curso = '".$_SESSION['curso']."')";} // OR curso = '*')";}
	if ($_SESSION['grupo']) {$sql .= " AND (grupo = '".$_SESSION['grupo']."')";} // OR grupo = '*')";}
	$sql .= ")";
}

if ($titasi == 1) {
	$sql .= " AND (titulaci = '".$_SESSION['tit']."'";
	if ($_SESSION['curso']) {$sql .= " AND (curso = '".$_SESSION['curso']."')";} // OR curso = '*')";}
	$sql .= ")";
}

$sql .= " ORDER BY dia DESC, hora DESC";

$result = $ilink->query($sql);

if ($result) {

	while ($fila = $result->fetch_array(MYSQLI_BOTH)) {

		if ($titasi == "todos") {
			$esmio = ""; $esmiotitul = "";
			if ($fila['asigna']) {$esmio = esmio($fila['asigna'],$fila['curso'],$fila['grupo'],$ilink);}
			if ($fila['titulaci']) {$esmiotitul = esmiotitul($fila['titulaci'],$fila['curso'],$ilink);}
			if (!$esmio AND !$esmiotitul AND $fila['autor'] != $_SESSION['usuid']) {continue;}
		}

		$diax = str_pad($fila['diax'],2,0,STR_PAD_LEFT);
		if (!$fila['mostrar']) {
			if (!$poner[$diax][0]) {
				$poner[$diax][0] = "cajadiayel";
			} elseif ($poner[$diax][0] == "cajadiared") {
				$poner[$diax][0] = "cajadianar";
			}
		} else {
			if (!$poner[$diax][0]) {
				$poner[$diax][0] = "cajadiared"; 
			} elseif ($poner[$diax][0] == "cajadiayel") {
				$poner[$diax][0] = "cajadianar"; 
			}
		}
		$poner[$diax][1] .= $fila['id']."-";

	}

}

[$inicioYmd, $finYmd] = rangoDATEdesdeYMUsuario($ag);
$sql = "SELECT *, DAY(fecha) AS diax FROM clasesgrab WHERE fecha >= '$inicioYmd' AND fecha < '$finYmd'";

if ($titasi == 2) {
	if ($_SESSION['asigna']) {$sql .= " AND codasign = '".$_SESSION['asigna']."'";}
	if ($_SESSION['curso']) {$sql .= " AND (curso = '".$_SESSION['curso']."')";} // OR curso = '*')";}
	if ($_SESSION['grupo']) {$sql .= " AND (grupo = '".$_SESSION['grupo']."')";} // OR grupo = '*')";}
}

if ($titasi == 1) {
	if ($_SESSION['tit']) {$sql .= " AND codtit = '".$_SESSION['tit']."'";}
	if ($_SESSION['curso']) {$sql .= " AND (curso = '".$_SESSION['curso']."')";} // OR curso = '*')";}
}

$result = $ilink->query($sql);

if ($result) {

	while ($fila = $result->fetch_array(MYSQLI_BOTH)) {

		if ($titasi == "todos") {
			if ($fila['codasign']) {$esmio = esmio($fila['codasign'],$fila['curso'],$fila['grupo'],$ilink);}
			if ($fila['codtit']) {$esmiotitul = esmiotitul($fila['codtit'],$fila['curso'],$ilink);}
			if (!$esmio AND !$esmiotitul) {continue;}
		}

		$diax = str_pad($fila['diax'],2,0,STR_PAD_LEFT);
		if (!$poner[$diax][0]) {
			$poner[$diax][0] = "cajadiared"; //"red";
		} elseif ($poner[$diax][0] == "cajadiayel") {
			$poner[$diax][0] = "cajadianar";
		}
		$poner[$diax][2] .= $fila['id']."-";
	
	}

}

if (sizeof($poner)) {krsort($poner);}

if (!$miagenda OR !$poner) {return $poner;}

foreach ($poner as $clave=>$valor)
{

	if ($poner[$clave][0] == "cajadiayel" OR $poner[$clave][1]) {
		$poner[$clave][3] = icononota("$ag-$clave", $titasi);
	}
	if ($poner[$clave][2]) {
		$poner[$clave][3] .= iconomultim($ag,$dia_actual,$poner[$clave][2],$ilink);
	}	

}

if (sizeof($poner)) {krsort($poner);}

return $poner;

}

// --------------------------------------------------

function calendario($ag,$g,$arraymes,$titasi,$asist,$ilink){

	$dia = substr($ag,8,2);
	$mes = substr($ag,5,2);
	$ano = substr($ag,0,4);
	$asig = $_SESSION['asigna'];
	if ($asist) {$param.="&asist=1";}

	$tableid = "id='calendario'"; $px = 5;
	if ($g == 2) {$tableid = "id='calendariog'";}
	if ($g == 3) {$tableid = "id='calendariop'";}
	echo "<table $tableid class='nopadded-table'>";
			echo "<tr>
			    <th><acronym title='".i("l1",$ilink)."' >".i("l",$ilink)."</acronym></th>
			    <th><acronym title='".i("ma1",$ilink)."' >".i("ma",$ilink)."</acronym></th>
			    <th><acronym title='".i("x1",$ilink)."' >".i("x",$ilink)."</acronym></th>
			    <th><acronym title='".i("j1",$ilink)."' >".i("j",$ilink)."</acronym></th>
			    <th><acronym title='".i("v1",$ilink)."' >".i("v",$ilink)."</acronym></th>
			    <th><acronym title='".i("s1",$ilink)."' >".i("s",$ilink)."</acronym></th>
			    <th><acronym title='".i("d1",$ilink)."' >".i("d",$ilink)."</acronym></th>
			</tr>";

	//Variable para llevar la cuenta del dia actual
	$dia_actual = 1;
	
	//calculo el numero del dia de la semana del primer dia
	$numero_dia = calcula_numero_dia_semana(1,$mes,$ano);
	
	//calculo el &uacute;ltimo dia del mes
	$ultimo_dia = ultimoDia($mes,$ano);
	
	//escribo la primera fila de la semana
	echo "<tr>";
	for ($i=0;$i<7;$i++){

		if ($i < $numero_dia){
			//si el dia de la semana i es menor que el numero del primer dia de la semana no pongo nada en la celda
			echo "<td class='sin'></td>";
		} else {
			$dia_actual = str_pad($dia_actual,2,0,STR_PAD_LEFT);
			$temp = $ano."-".$mes."-".$dia_actual;
			$actu = $finde = "";
			if (eshoy($temp)){$actu = "dh ";}
			if($i > 4 AND !$arraymes[$dia_actual][0]) {$finde = "finde ";}
			$d = "<div class='".$arraymes[$dia_actual][0]."'><a class='$finde".$arraymes[$dia_actual][0]."' href='miagenda.php?ag=$temp$param'>$dia_actual</a></div>";
			if ($i < 5) {
				echo "<td class='$actu'>$d";
				if ($g != 3) {
					if (!$g) {
						echo $arraymes[$dia_actual][3];
					} else {
						agenda("$ano-$mes-$dia_actual",$arraymes,$g,$titasi,$ilink);
					}
				}
				echo "</td>";
			} else {
				echo "<td class='".$actu."finde'>$d";
				if ($g != 3) {
					if (!$g) {
						echo $arraymes[$dia_actual][3];
					} else {
						agenda("$ano-$mes-$dia_actual",$arraymes,$g,$titasi,$ilink);
					}
				}
				echo "</td>";
			}
			$dia_actual++;
		}
	}
	echo "</tr>";
	
	//recorro todos los dem&aacute;s d&iacute;as hasta el final del mes
	$numero_dia = 0;
	while ($dia_actual <= $ultimo_dia){
		//si estamos a principio de la semana escribo el <TR>
		if ($numero_dia == 0){
			echo "<tr>";
		}
		$dia_actual = str_pad($dia_actual,2,0,STR_PAD_LEFT);
		$temp = $ano."-".$mes."-".$dia_actual;
		$actu = $finde = "";
		if (eshoy($temp)){$actu = "dh ";}
		if($numero_dia > 4 AND !$arraymes[$dia_actual][0]) {$finde = "finde ";}
		$d = "<div class='".$arraymes[$dia_actual][0]."'><a class='$finde".$arraymes[$dia_actual][0]."' href='miagenda.php?ag=$temp$param'>$dia_actual</a></div>";
		if ($numero_dia < 5) {
			echo "<td class='$actu'>$d";
			if ($g != 3) {
				if (!$g) {
					echo $arraymes[$dia_actual][3];
				} else {
					agenda("$ano-$mes-$dia_actual",$arraymes,$g,$titasi,$ilink);
				}
			}
			echo "</td>";
		} else {
			echo "<td class='".$actu."finde'>$d";
			if ($g != 3) {
				if (!$g) {
					echo $arraymes[$dia_actual][3];
				} else {
					agenda("$ano-$mes-$dia_actual",$arraymes,$g,$titasi,$ilink);
				}
			}
			echo "</td>";
		}
		$dia_actual++;
		$numero_dia++;
		//si es el &uacute;ltimo de la semana, me pongo al principio de la semana y escribo el </tr>
		if ($numero_dia == 7){
			$numero_dia = 0;
			echo "</tr>";
		}
		
		if ($dia_actual > $ultimo_dia) {$i=0;
			if ($numero_dia < 7) {for($i;$i<7-$numero_dia;$i++) {echo "<td class='sin'></td>";}}
			echo "</tr>";
		}
		
	}
	
	echo "</table>";

}	

function calcula_numero_dia_semana($dia,$mes,$ano){
	$numerodiasemana = gmdate('w', mktime(0,0,0,(int)$mes,(int)$dia,(int)$ano));
	if ($numerodiasemana == 0) 
		$numerodiasemana = 6;
	else
		$numerodiasemana--;
	return $numerodiasemana;
}

//funcion que devuelve el &uacute;ltimo d&iacute;­a de un mes y a&ntilde;o dados
function ultimoDia_old($mes,$ano){ 
    $ultimo_dia=28; 
    while (checkdate($mes,$ultimo_dia + 1,$ano)){ 
       $ultimo_dia++; 
    } 
    return $ultimo_dia; 
} 

function ultimoDia($mes, $ano) {
    $fecha = new DateTime("$ano-$mes-01");
    return (int) $fecha->format('t'); // 't' devuelve el último día del mes
}

function formularioCalendario($ag,$ilink){

echo "<br><form action='miagenda.php' method='post'>";
echo "<select name='nuevo_mes'>";

for ($i = 1; $i<=12; $i++) {

	$dia = str_pad($i,2,0,STR_PAD_LEFT);
	echo "<option value='$dia'";
	if (substr($ag,5,2) == $i) {echo "selected = 'selected'";}
	echo ">".i("$dia",$ilink);
	echo "</option>";

}

echo "</select> ";

echo "<select name='nuevo_ano'>";

for($i=2000; $i<=2025; $i++) {

	echo "<option value='$i'";
	if (substr($ag,0,4) == $i) {echo " selected = 'selected'";}
	echo ">$i</option>";

}

echo "</select> <input class='col-2em' type='submit' value='>>'>";
echo "</form>";
}

// --------------------------------------------------

function icononota($ag, $titasi) {
	return "<a href='".$_SERVER['PHP_SELF']."?ag=$ag'>
	<span class='icon-file-text azul'></span>
	</a>";
}

/*function eshoy($fecha,$ilink) {
	$hoy = zone(gmdate('Y-m-d H:i:s'));
	$hoy = explode(" ",$hoy[0]);
	if ($fecha == $hoy[0]) {return 1;}
}*/

function eshoy($fecha) {
    // Normaliza por si $fecha trae hora
    $fecha = substr((string)$fecha, 0, 10); // Y-m-d

    $zonaUsuario = $_SESSION['zone'] ?? 'UTC';
    $hoyUsuario = (new DateTime('now', new DateTimeZone($zonaUsuario)))->format('Y-m-d');

    return $fecha === $hoyUsuario ? 1 : 0;
}

// -------------------------------------------------- A G E N D A // --------------------------------------------------
function agenda($ag,$arraymes,$g,$param,$ilink) {

$dia = substr($ag,8,2);

if ($dia) {

	$dias = explode("-",$arraymes[$dia][1]);
	foreach ($dias as $clave=>$valor) {
		if ($valor) {
			notiuna($valor,1,1,$ilink,$g);
		}
	}
	$dias = explode("-",$arraymes[$dia][2]);
	foreach ($dias as $clave1=>$valor1) {
		if ($valor1) {
			ficheros($valor1,$dia,1,$ilink,$g);
		}
	}

	return ;
}

if (!sizeof($arraymes)) {return;}

foreach ($arraymes as $clave=>$valor)
{

	$dias = explode("-",$valor[1]);
	foreach ($dias as $clave1=>$valor1) {
		if ($valor1) {
			notiuna($valor1,1,1,$ilink,$g);
		}			
	}
	$dias = explode("-",$valor[2]);
	foreach ($dias as $clave1=>$valor1) {
		if ($valor1) {
			ficheros($valor1,$clave,1,$ilink,$g);
		}
	}

}

}

function ficheros($id,$dia,$coment,$ilink,$g) {

$iresult = $ilink->query("SELECT codasign, curso, grupo, video, comentario, autor, codtit, link, fecha FROM clasesgrab WHERE id = '$id' LIMIT 1");
$fila = $iresult->fetch_array(MYSQLI_BOTH);
extract($fila);

if($grupo == "*") {$grupo = "";}

if ($codasign) {$asicurgru .= " $codasign";} else {$asicurgru .= " $codtit";}
if($curso) {$asicurgru .= " - $curso";} // AND $curso != "*"
if($grupo) {$asicurgru .= " - $grupo";} // AND $grupo != "*"

echo "<div class='col-10 contiene'>";
	$mens0 = "<span class='peq'>".ifecha31($fecha,$ilink)."<br><span class='b'>$asicurgru</span></span><br>";
	if ($link) {
		$mens .= enlace($video,1,$comentario,$xcurgru,$link,$ilink);
	} else {
		if ($codasign) {
			$xcurgru = $codasign;
			$xcurgru .= "$$".$curso; //str_replace("*","",$curso);
			$xcurgru .= "$$".$grupo; //str_replace("*","",$grupo);
			$mens .= enlace($video,1,$comentario,$xcurgru,$link,$ilink);
		} else {
			$xcurgru = $codtit;
			$xcurgru .= "$$".$curso; //str_replace("*","",$curso);
			$mens .= enlace($video,1,$comentario,$xcurgru,$link,$ilink);
		}
	}

	//foto, nombre y mensaje
	$delante = "<div class='cajadiared both mr5 ml5 fl di' style='border:1px solid black;padding:3px'>";
	if (strlen($dia) > 2) {$dia = substr($dia,8,2);}
	$delante .= $dia."</div> ";
	if($g) {
		echo $mens;
	} else {
		$usu = ponerusu($autor,1,$ilink);
		?><div class="fila-usuario">
				<div class="foto"><?php
 	 				echo $usu[0]."<br>".$delante;?>	
 				</div>
				<div class="datos"><?php 	
					echo $usu[1]."<br>".$mens0.$mens;?>
				</div>
	    </div>
		<?php
	}

echo "</div><p><br></p><br'>";

}

function iconomultim($ag,$dia_actual,$ides,$ilink) {

$ides = explode("-",$ides);
//$temp = "<br>";
foreach ($ides as $clave=>$valor)
{
	$iresult = $ilink->query("SELECT codasign, curso, grupo, video, codtit, link FROM clasesgrab WHERE id = '$valor' LIMIT 1");
	$fila = $iresult->fetch_array(MYSQLI_BOTH);
	if ($valor) {
		if ($fila['link']) {
			$temp .= enlace("",0,"","",$fila['link'],$ilink);
		} else {
			if ($fila['codasign']) {
				$xcurgru = $fila['codasign'];
				$xcurgru .= "$$".$fila[1]; //str_replace("*","",$fila[1]);
				$xcurgru .= "$$".$fila[2]; //str_replace("*","",$fila[2]);
				$temp .= enlace($fila[3],0,"",$xcurgru,$link,$ilink);
			} else {
				$xcurgru = $fila['codtit'];
				$xcurgru .= "$$".$fila[1]; //str_replace("*","",$fila[1]);
				$temp .= enlace($fila[3],0,"",$xcurgru,$link,$ilink);
			}
		}
	}
}

return $temp;

}

function enlace($video,$coment,$comentario,$asicurgru,$link,$ilink) { //$video es un capo que puede llevar distintos tipos de ficheros, imagen, video...
if ($link) {
	$temp = "<a href='$link' target='_blank'>";
	$ext = strrchr($link,'.');
	if(stristr($link, 'youtube.com') OR stristr($link, 'youtu.be')){
		$ext = "youtube";
	} elseif ("*".stristr($link, 'http://')) {
		$ext = ".html";
	}
	$temp .= imag1($ext,$ilink);
	if ($coment) {$temp .= $comentario;}
	$temp .= "</a>";
	return $temp;
}
$mms="";
$ext = strrchr($video,'.');
$temp = "<a href='" . APP_URL . "/file.php?ag=1&dir=$asicurgru&fich=$video' target='_blank'>";

$temp .= imag1($ext,$ilink);
if ($coment) {$temp .= $comentario;}
$temp .= "</a>";
return $temp;

}

function soyautor($id,$ilink) {
	$iresult = $ilink->query("SELECT autor, visible FROM noticias WHERE id = '$id' LIMIT 1");
	$fila = $iresult->fetch_array(MYSQLI_BOTH);
	if ($fila[0] == $_SESSION['usuid'] OR $_SESSION['auto'] == 10) {return 1;}
}

// --------------------------------------------------

function notis($notis,$contar,$condi,$ponertodo,$conta,$ilink) {
	$noti = "SELECT id,asigna,curso,grupo,titulaci FROM noticias WHERE tablon = 1 $condi ORDER BY dia DESC, hora DESC";
	$result = $ilink->query($noti);
	while ($fila = $result->fetch_array(MYSQLI_BOTH)) {
		if (esmio($fila[1],$fila[2],$fila[3],$ilink) OR esmiotitul($fila[4],$fila[2],$ilink)) {
			if ($conta > 1) {$conta--; continue;}
			extract ($fila);
			$n++;
			if ($contar) {
				if($notis) {return $n;} else {continue;}
			}
			if ($n <= $notis) {
				notiuna($id,$ponertodo,0,$ilink,'');
			}	
		}
	}
	return $n;
}

function notiuna($id,$ponertodo,$agenda,$ilink,$g) {
	$noti = "SELECT * FROM noticias WHERE id = '$id' LIMIT 1";
	$iresult = $ilink->query($noti);
	$noti = $iresult->fetch_array(MYSQLI_BOTH);
	extract($noti);
	if ($visible) {$importante = "<span class='icon-notification prefer' title=\"".i("preferente",$ilink)."\"></span>";}
	$fecha = ifecha31($dia." ".$hora,$ilink);
	$asicurgru = $titulaci.$asigna;
	if ($curso) {$asicurgru .= " - $curso";} // AND $curso != "*"
	if ($grupo) {$asicurgru .= " - $grupo";} // AND $grupo != "*"
	$descripcion = conhiper(consmy(quitabarra($descripcion)));
	$detalle = conhiper(consmy(quitabarra($detalle)));

	$ancho = "justify";
	if ($agenda) {
		$agenda = "cajadiayel";
		if ($mostrar) {$agenda = "cajadiared";}
		$ancho .= " both ";
	} elseif ($ponertodo) {
		$ancho .= " col-6";
	}
	//echo "<div class='contiene'>";
	$mens0 = "<span class='peq'>$fecha</span><br><span class='b peq'>$asicurgru</span>";
	if (soyautor($id,$ilink) AND $ponertodo) {
		$mens0 .= " <a class='nob peq' href='miagenda.php?id=$id&ag=$dia'>[ ".i("editar1",$ilink)." ]</a>";
	}
	$mens0 .= "<br>";
	if ($ponertodo) {
		$mens .= "<br>$importante <span class=' b'>$descripcion</span><br><div class='justify'>$detalle</div>";
	} else {
		if ($_GET['at'] < 2) {$param = "?titasi=2";}
		$mens .= "$importante <a href='mitablon.php$param' title=\"".str_replace("\"","'",$descripcion).": ".strip_tags(str_replace("\"","'",$detalle))."\">";
		$mens .= $descripcion."</a>";
	}
	$usu = ponerusu($autor,1,$ilink);
	if ($agenda) {
		$delante = "<div class='$agenda mr5 ml5 fl' style='border:1px solid black;padding:3px;'>";
		if (strlen($dia) > 2) {$dia = substr($dia,8,2);}
		$delante .= $dia."</div> ";
		if($g) {
			echo $mens;
		} else {
			?><div class="fila-usuario">
 	 			<div class="foto"><?php
 	 				echo $usu[0]."<br>".$delante;?>	
 				</div>
				<div class="datos"><?php 	
					echo $usu[1]."<br>".$mens0.$mens;?>
				</div>
			</div>
			<?php
		}
	} else {
		?><div class="fila-usuario">
 	 		<div class="foto"><?php
 	 			echo $usu[0];?>	
 			</div>
			<div class="datos"><?php 	
				echo $usu[1]."<br>".$mens0.$mens;?>
			</div>
		</div>
		<?php
	}

	echo "<p><br></p>";
}

// --------------------------------------------------

function rangoUTCdesdeYMUsuario($ym) {
    // Separar año y mes
    list($anio, $mes) = explode('-', $ym);

    // Obtener zona del usuario (o UTC por defecto)
    $zona = $_SESSION['zone'] ?? 'UTC';

    // Primer día del mes en zona usuario
    $fechaInicioUsuario = new DateTime("$anio-$mes-01 00:00:00", new DateTimeZone($zona));

    // Clonar para calcular el inicio del mes siguiente
    $fechaFinUsuario = clone $fechaInicioUsuario;
    $fechaFinUsuario->modify('+1 month');

    // Convertir ambos a UTC
    $fechaInicioUsuario->setTimezone(new DateTimeZone('UTC'));
    $fechaFinUsuario->setTimezone(new DateTimeZone('UTC'));

    // Devolver como array [inicioUTC, finUTC]
    return [
        $fechaInicioUsuario->format('Y-m-d H:i:s'),
        $fechaFinUsuario->format('Y-m-d H:i:s')
    ];
}

// Devuelve [inicioYmd, finYmd) en zona del usuario, sin horas.
function rangoDATEdesdeYMUsuario($ym) {
    if (!preg_match('/^\d{4}-\d{2}$/', $ym)) return ["", ""];
    [$anio, $mes] = explode('-', $ym);
    $zona = $_SESSION['zone'] ?? 'UTC';

    $iniUsuario = new DateTime("$anio-$mes-01 00:00:00", new DateTimeZone($zona));
    $finUsuario = (clone $iniUsuario)->modify('+1 month');

    return [$iniUsuario->format('Y-m-d'), $finUsuario->format('Y-m-d')];
}

function calendariomini($calen,$q,$arraymes,$ilink) {?>

<div class="mini-cal">
  <div>
    <a href="miagenda.php?ag=<?= $calen[1] ?><?= $q ? '&'.$q : '' ?>&tod=1">
      <?= ifecha31($calen[1], $ilink) ?>
    </a>
  </div>

  <div>
    <?php calendario($calen[1], 3, $arraymes, "", "", $ilink); ?>
  </div>

  <div>
    <span class="mini-chip">
      <span class="mini-dot cajadiayel"></span><?= i("usuario",$ilink) ?>
    </span>
    <span class="mini-chip">
      <span class="mini-dot cajadiared"></span><?= i("asigna",$ilink) ?>
    </span>
  </div>
</div>

<?php
}
?>