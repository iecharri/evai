<?php

require_once __DIR__ . '/siempre.php';

// --------------------------------------------------

if (!$_SESSION['titasi']) {$_SESSION['titasi'] = 2;}

if ($_GET['titasi']) {$_SESSION['titasi'] = $_GET['titasi'];}

if ($_POST['titasi']) {$_SESSION['titasi'] = $_POST['titasi'];}

if (!$asigna) {$_SESSION['titasi'] = "general";}

$titasi = $_SESSION['titasi'];

if($titasi == 1) {$titul = 1;}
if($titasi == 2) {$asi = 1;}

if ($titasi == 1) {
	
	$sqlprof = "SELECT DISTINCT usuarios.id, autorizado, privacidad, usuarios.mail FROM asignatprof LEFT JOIN podcursoasignatit
		ON asignatprof.asigna = podcursoasignatit.asigna AND asignatprof.curso = podcursoasignatit.curso
		LEFT JOIN usuarios ON asignatprof.usuid = usuarios.id
		WHERE autorizado > 1 AND fechabaja = '0000-00-00 00:00:00' AND podcursoasignatit.tit = '$tit'
		AND asignatprof.curso = '$curso' AND usuarios.id > 0 ORDER BY usuarios.alumnon ";
	$pest = 1;
	} else {
	
	$sqlprof = "SELECT DISTINCT usuarios.id, autorizado, privacidad, mail FROM asignatprof LEFT JOIN usuarios ON asignatprof.usuid = usuarios.id WHERE autorizado > 1 AND fechabaja = '0000-00-00 00:00:00' AND asigna = '$asigna' AND curso = '$curso' AND grupo = '$grupo' AND usuarios.id > 0 ORDER BY usuarios.alumnon ";
	$pest = 2;
	
}

// --------------------------------------------------

$a_contac = " class = 'active'";
require_once APP_DIR . '/molde_top.php';

// --------------------------------------------------

unset($array);

$titpag = "<span class='icon-mail2'></span> ".i("contacto1",$ilink);

$array[0] =  "<a href='#'>$titpag <span class='icon-arrow-right'></span></a>";

solapah($array,0,"navhsimple");

require_once APP_DIR . '/selectitasi.php';

$result = $ilink->query($sqlprof);
if ($result->num_rows) {
	echo "<h3>".i("profesores",$ilink)."</h3>";
	listorla($result,$ilink);
}

// --------------------------------------------------

echo "<h3>Administraci&oacute;n de ".strtoupper(SITE)."</h3>";

$iresult = $ilink->query("SELECT adminid FROM atencion");
$admi = $iresult->fetch_array(MYSQLI_BOTH);
$result = $ilink->query("SELECT id, autorizado, privacidad, mail FROM usuarios WHERE id = '$admi[0]' LIMIT 1");
listorla($result,$ilink);

require_once APP_DIR .  "/molde_bott.php";

// --------------------------------------------------

function listorla($result,$ilink) {
	
	
	while ($fila = $result->fetch_array(MYSQLI_BOTH)) {
		extract($fila);

		if ($privacidad > 0 AND $autorizado >= $_SESSION['auto'] AND $_SESSION['auto'] < 10) {
			$mens="";
		} else {
			$mens = $mail;
		}		

		$datos = $ilink->query("SELECT mail, callto, callto1, direccion, codpos, localidad, provincia, pais,alumnon, fecha, estado FROM usuarios WHERE id = '$id' LIMIT 1");
			
		$usu = ponerusu($id,1,$ilink);

		?><div class="fila-usuario">
 			<div class="foto"><?php
 				echo $usu[0];?>	
 			</div>
			<div class="datos"><?php 	
				echo $usu[1]."<br>".$mens;?>
			</div>
		</div><p><br></p><?php
							
	}

}

?>
