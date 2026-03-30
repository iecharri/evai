<?php 

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

$asigna = $_SESSION['asigna'];
$curso = $_SESSION['curso'];
$grupo = $_SESSION['grupo'];

extract($_GET);
extract($_POST);

// --------------------------------------------------

if ($submi) {
	if ($d1) {
		$tiniUtc = usuautc1($d1,$h1);
	}
	if ($d2) {
		$tfinUtc = usuautc1($d2,$h2);
	}
	$iresult = $ilink->query("SELECT * FROM gruposexpo WHERE asigna = '$asigna' AND curso = '$curso' AND grupo='$grupo'");
	$num = $iresult->num_rows;
	if (!$num) {
		$ilink->query("INSERT INTO gruposexpo (asigna, curso, grupo, maxusu, descripcion, tini, tfin)
		 VALUES ('$asigna', '$curso', '$grupo', '$maxusu', \"$descripcion\", '$tiniUtc[0] $tiniUtc[1]', '$tfinUtc[0] $tfinUtc[1]')");
	} else {
		$ilink->query("UPDATE gruposexpo SET descripcion = \"$descripcion\", tini='$tiniUtc[0] $tiniUtc[1]', tfin='$tfinUtc[0] $tfinUtc[1]', maxusu='$maxusu'
		WHERE asigna = '$asigna' AND curso = '$curso' AND grupo='$grupo'");
	}
}

// --------------------------------------------------

if ($submied) {
	if ($borrar == 'on') {
		$ilink->query("DELETE FROM gruposexpo WHERE row_id = '$row_id' AND 
		asigna = '$asigna' AND curso = '$curso' AND grupo='$grupo'");
	} else {
		$apuntados = str_replace("\r","$$",trim($apuntados));
		$apuntados = str_replace("$$$$","",$apuntados);
		if ($apuntados) {$apuntados .= "$$";}
		$sql = "UPDATE gruposexpo SET grupoexpo = \"$edgrupo\", descripgrupo = \"$eddescri\",
		 apuntados = \"$apuntados\" WHERE row_id = '$row_id'";
		$ilink->query($sql);
	}
}

// --------------------------------------------------

if ($submiana) {
	$iresult = $ilink->query("SELECT maxusu, descripcion, tini, tfin
	FROM gruposexpo WHERE asigna = '$asigna' AND curso = '$curso' AND grupo='$grupo'");
	$fijos = $iresult->fetch_array(MYSQLI_BOTH);
	extract($fijos);
	$apuntados = str_replace("\r","$$",$apuntados);
	$apuntados = str_replace("\r","",$apuntados);
	$apuntados = str_replace("\n","",$apuntados);
	$apuntados = str_replace("\r$$","",$apuntados);
	$apuntados = str_replace("$$\r","",$apuntados);
	$apuntados = str_replace("$$$$","",$apuntados);
	$sql = "INSERT INTO gruposexpo 
	(asigna, curso, grupo, grupoexpo, descripgrupo, apuntados, maxusu, descripcion, tini, tfin)
	VALUES
	('$asigna', '$curso', '$grupo', \"$edgrupo\", \"$eddescri\", \"$apuntados\", '$maxusu', \"$descripcion\", '$tiniUtc[0] $tiniUtc[1]', '$tfinUtc[0] $tfinUtc[1]')";
	$ilink->query($sql);

}

// --------------------------------------------------

if ($ana) {
	$div = "anadir";
	$mensaje = "<form method='post' action='?pest=$pest&apli=1'>";
	$mensaje .= "Grupo [255]<br >";
	$mensaje .= "<input class='col-10' type='text' name='edgrupo' size='50' maxlength='255'>";
	$mensaje .= "<br>Descripci&oacute;n [255]<br>";
	$mensaje .= "<input class='col-10' type='text' name='eddescri' size='50' maxlength='255'>";
	$mensaje .= "<br>Apuntados<br>";
	$mensaje .= "<textarea class='col-10' name='apuntados' rows='5' cols='40'></textarea>";
	$mensaje .= "<input class='col-10' type='submit' name='submiana' value=' >> '>";
	$mensaje .= "</form>";
	wintot1("", $mensaje, $div, '', 0, $ilink);
}

// --------------------------------------------------

if ($ed) {
	$iresult = $ilink->query("SELECT * FROM gruposexpo WHERE row_id='$ed'");
	$fila = $iresult->fetch_array(MYSQLI_BOTH);
	$apuntados = str_replace("$$","\r",$fila['apuntados']);
	$div = "editar";
	$mensaje = "<form method='post' action='?pest=$pest&apli=1'>";
	$mensaje .= "Grupo [255]<br>";
	$mensaje .= "<input class='col-10' type='text' name='edgrupo' size='50' maxlength='255' value=\"".$fila['grupoexpo']."\">";
	$mensaje .= "<br>Descripci&oacute;n [255]<br>";
	$mensaje .= "<input class='col-10' type='text' name='eddescri' size='50' maxlength='255' value=\"".$fila['descripgrupo']."\">";
	$mensaje .= "<br>Apuntados<br>";
	$mensaje .= "<textarea  class='col-10'name='apuntados' rows='5' cols='40'>$apuntados</textarea>";
	$mensaje .= "<input type='hidden' name='row_id' value='".$fila['row_id']."'>";
	$mensaje .= "<p></p><span class='rojo b'>BORRAR</span> <input type='checkbox' name='borrar'>";
	$mensaje .= " &nbsp; &nbsp; <input class='col-1' type='submit' name='submied' value=' >> '>";
	$mensaje .= "</form>";
	wintot1("", $mensaje, $div, '', 0, $ilink);
}

// --------------------------------------------------

$sql = "SELECT * FROM gruposexpo WHERE asigna = '$asigna' AND curso = '$curso' AND grupo = '$grupo'";
$result = $ilink->query($sql);

if ($result->num_rows > 0) {
	$fila1 = $result->fetch_array(MYSQLI_BOTH);
	extract($fila1);
}

$d1 = utcausu1($fila1['tini']); $d1usu = explode(" ",$d1);
$d2 = utcausu1($fila1['tfin']); $d2usu = explode(" ",$d2);

echo "<p></p><form name='formu' method='post' action = '?pest=$pest&apli=1'>";
echo "<span class='txth'>Descripci&oacute;n</span> [255]<br>";
echo "<input type='text' name='descripcion' value='$descripcion' size='125' maxlength='255'>";
echo "<p></p><span class='txth'>Activo desde el </span>";
echo "<input type='text' name='d1' size='10' maxlength='10' value='".str_replace("-","/",$d1usu[0])."' class='datepicker col-1'>";
echo " <span class='txth'>a las</span>";
echo " <select name='h1'>";
selecthora(substr($d1usu[1],0,5));
echo "</select>";
echo "<span class='txth'> hasta el </span>";
echo "<input type='text' name='d2' size='10' maxlength='10' value='".str_replace("-","/",$d2usu[0])."' class='datepicker col-1'>";
echo " <span class='txth'>a las</span>";
echo " <select name='h2'>";
selecthora(substr($d2usu[1],0,5));
echo "</select>";

	echo "<br> &nbsp; &nbsp; En este momento est&aacute; ";
	$hoy = gmdate('Y-m-d H:i:s');
	if ($fila1['tini'] < $hoy AND $fila1['tfin'] > $hoy AND $fila1['tini'] != "0000-00-00 00:00:00") {
		echo "<span class='txth'>ACTIVO (los Alumnos pueden apuntarse)</span>";
	} else {
		echo "<span class='rojo'>INACTIVO (los Alumnos NO pueden apuntarse)</span>";
	}

echo "<br> &nbsp; &nbsp; <span class='rojo'>(Si no deseas que los Alumnos vean los grupos, deja vac&iacute;o \"Activo desde el \")</span>";
echo "<p></p><span class='txth'>M&aacute;ximo n&uacute;mero de usuarios por grupo</span> ";
echo "<input class='col-1' type='text' size='2' maxlength='2' name='maxusu' value='$maxusu'>";
echo " <input class='col-1' type='submit' value=' >> ' name='submi'>";
echo "</form>";

$result = $ilink->query($sql);
while ($fila = $result->fetch_array(MYSQLI_BOTH)) {
	extract($fila);
	$apuntados = str_replace("$$","<br>",$apuntados);
	if (!$titulo) {
		echo "<table class='conhover'>";
		echo "<tr>";
		echo "<th class='col-01'><a href='?pest=$pest&apli=1&ana=1'>A&ntilde;adir</a></th>";
		echo "<th>Grupo</th>";
		echo "<th>Descripci&oacute;n</th>";
		echo "<th>Apuntados</th>";
		echo "</tr>";
		$titulo = 1;
	}
			
	echo "<tr>";
	echo "<td><a href='?pest=$pest&apli=1&ed=$row_id'>Editar</a></td>";
	echo "<td>$grupoexpo</td><td>$descripgrupo</td>";
	echo "<td class='nowrap'><hr>$apuntados<hr></td>";
	echo "</tr>";
}

if ($titulo) {echo "</table>";}

// --------------------------------------------------

function selecthora($h) {
	echo "<option value='00:00'";if ('00:00' == $h) {echo " selected='selected'";}
	echo ">00:00</option>";
	echo "<option value='00:30'";if ('00:30' == $h) {echo " selected='selected'";}
	echo ">00:30</option>";	
	echo "<option value='01:00'";if ('01:00' == $h) {echo " selected='selected'";} 
	echo ">01:00</option>";	
	echo "<option value='01:30'";if ($h == '01:30') {echo " selected='selected'";} 
	echo ">01:30</option>";	
	echo "<option value='02:00'";if ('02:00' == $h) {echo " selected='selected'";} 
	echo ">02:00</option>";	
	echo "<option value='02:30'";if ('02:30' == $h) {echo " selected='selected'";} 
	echo ">02:30</option>";	
	echo "<option value='03:00'";if ('03:00' == $h) {echo " selected='selected'";} 
	echo ">03:00</option>";	
	echo "<option value='03:30'";if ('03:30' == $h) {echo " selected='selected'";} 
	echo ">03:30</option>";	
	echo "<option value='04:00'";if ('04:00' == $h) {echo " selected='selected'";} 
	echo ">04:00</option>";	
	echo "<option value='04:30'";if ('04:30' == $h) {echo " selected='selected'";} 
	echo ">04:30</option>";	
	echo "<option value='05:00'";if ('05:00' == $h) {echo " selected='selected'";} 
	echo ">05:00</option>";	
	echo "<option value='05:30'";if ('05:30' == $h) {echo " selected='selected'";}
	echo ">05:30</option>";	
	echo "<option value='06:00'";if ('06:00' == $h) {echo " selected='selected'";} 
	echo ">06:00</option>";	
	echo "<option value='06:30'";if ('06:30' == $h) {echo " selected='selected'";} 
	echo ">06:30</option>";	
	echo "<option value='07:00'";if ('07:00' == $h) {echo " selected='selected'";} 
	echo ">07:00</option>";	
	echo "<option value='07:30'";if ('07:30' == $h) {echo " selected='selected'";} 
	echo ">07:30</option>";	
	echo "<option value='08:00'";if ('08:00' == $h) {echo " selected='selected'";} 
	echo ">08:00</option>";	
	echo "<option value='08:30'";if ('08:30' == $h) {echo " selected='selected'";} 
	echo ">08:30</option>";	
	echo "<option value='09:00'";if ('09:00' == $h) {echo " selected='selected'";} 
	echo ">09:00</option>";	
	echo "<option value='09:30'";if ('09:30' == $h) {echo " selected='selected'";} 
	echo ">09:30</option>";	
	echo "<option value='10:00'";if ('10:00' == $h) {echo " selected='selected'";} 
	echo ">10:00</option>";	
	echo "<option value='10:30'";if ('10:30' == $h) {echo " selected='selected'";} 
	echo ">10:30</option>";	
	echo "<option value='11:00'";if ('11:00' == $h) {echo " selected='selected'";} 
	echo ">11:00</option>";	
	echo "<option value='11:30'";if ('11:30' == $h) {echo " selected='selected'";} 
	echo ">11:30</option>";	
	echo "<option value='12:00'";if ('12:00' == $h) {echo " selected='selected'";} 
	echo ">12:00</option>";	
	echo "<option value='12:30'";if ('12:30' == $h) {echo " selected='selected'";} 
	echo ">12:30</option>";	
	echo "<option value='13:00'";if ('13:00' == $h) {echo " selected='selected'";} 
	echo ">13:00</option>";	
	echo "<option value='13:30'";if ('13:30' == $h) {echo " selected='selected'";} 
	echo ">13:30</option>";	
	echo "<option value='14:00'";if ('14:00' == $h) {echo " selected='selected'";}
	echo ">14:00</option>";	
	echo "<option value='14:30'";if ('14:30' == $h) {echo " selected='selected'";} 
	echo ">14:30</option>";	
	echo "<option value='15:00'";if ('15:00' == $h) {echo " selected='selected'";} 
	echo ">15:00</option>";	
	echo "<option value='15:30'";if ('15:30' == $h) {echo " selected='selected'";} 
	echo ">15:30</option>";	
	echo "<option value='16:00'";if ('16:00' == $h) {echo " selected='selected'";} 
	echo ">16:00</option>";	
	echo "<option value='16:30'";if ('16:30' == $h) {echo " selected='selected'";} 
	echo ">16:30</option>";	
	echo "<option value='17:00'";if ('17:00' == $h) {echo " selected='selected'";} 
	echo ">17:00</option>";	
	echo "<option value='17:30'";if ('17:30' == $h) {echo " selected='selected'";} 
	echo ">17:30</option>";	
	echo "<option value='18:00'";if ('18:00' == $h) {echo " selected='selected'";} 
	echo ">18:00</option>";	
	echo "<option value='18:30'";if ('18:30' == $h) {echo " selected='selected'";} 
	echo ">18:30</option>";	
	echo "<option value='19:00'";if ('19:00' == $h) {echo " selected='selected'";} 
	echo ">19:00</option>";	
	echo "<option value='19:30'";if ('19:30' == $h) {echo " selected='selected'";} 
	echo ">19:30</option>";	
	echo "<option value='20:00'";if ('20:00' == $h) {echo " selected='selected'";} 
	echo ">20:00</option>";	
	echo "<option value='20:30'";if ('20:30' == $h) {echo " selected='selected'";} 
	echo ">20:30</option>";	
	echo "<option value='21:00'";if ('21:00' == $h) {echo " selected='selected'";} 
	echo ">21:00</option>";	
	echo "<option value='21:30'";if ('21:30' == $h) {echo " selected='selected'";} 
	echo ">21:30</option>";	
	echo "<option value='22:00'";if ('22:00' == $h) {echo " selected='selected'";} 
	echo ">22:00</option>";	
	echo "<option value='22:30'";if ('22:30' == $h) {echo " selected='selected'";} 
	echo ">22:30</option>";	
	echo "<option value='23:00'";if ('23:00' == $h) {echo " selected='selected'";} 
	echo ">23:00</option>";	
	echo "<option value='23:30'";if ('23:30' == $h) {echo " selected='selected'";}
	echo ">23:30</option>";
}

?>