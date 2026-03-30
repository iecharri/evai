<?php

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

iconex(DB2,$ilink);

$guardo = $_POST;

//si no existe, anadir campo guardar
//2025
/*$res = $ilink->query("SHOW COLUMNS FROM `$cuest"."2` LIKE 'codigo'");
if ($res->num_rows == 0) {
    $sql = "ALTER TABLE `$cuest"."2` ADD codigo VARCHAR(50) NOT NULL AFTER nota";
    $ilink->query($sql);
}*/

if($_POST['codrecu']) {
	$existecod = recupera($cuest,$_POST['codrecu'],$ilink);
	if($existecod != "*") {
		echo "<br> &nbsp; ".$existecod. " <span class='rojo b'>".$_POST['codrecu']."</span>";
		return;
	}
}

if ($envi AND !$previsu) {
	if($_POST['codrecu']) {
		$sql = "DELETE FROM $cuest"."2 WHERE codigo = '".$_POST['codrecu']."'";
		$_POST = $guardo;
		$ilink->query($sql);
	}
	guardarc($cuest,$ilink);
}

if ($envi) {
	echo  "<br><div class='center b'>Ha quedado registrado el cuestionario.";
	if(($_POST['codrecu'] OR $_POST['codigo']) AND !$previsu) {
		echo " Código de recuperación <span class='rojo'>".$_POST['codrecu'].$_POST['codigo']."</span>";
	}
	echo "</div>";
}

$indep = 1; //para que no ponga cabecera

if(!$previsu) {
	
	iconex(DB1,$ilink);
	require_once APP_DIR . '/molde_top.php';
	iconex(DB2,$ilink);

}

$result = $ilink->query("SELECT ordenadas, alfabet, sinnum FROM ".$cuest."1 WHERE !n");
$fila = $result->fetch_array(MYSQLI_BOTH);
extract($fila);

if(!$sinnum) {$numera = 1;}
	
// --------------------------------------------------

echo "<div style='margin:.5em'>";

if(!$envi) {
	if($_POST['codrecu1'] AND $_POST['codrecu']) {
		$slq = "SELECT codigo FROM ".$cuest."2 WHERE cuest = '".$_POST['codrecu']."'";
		echo "Cuestionario <span class='b'>".$_POST['codrecu']."</span>";
	} elseif(!$previsu) {
		echo "<div class='cajabl center peq'>Si has realizado anteriormente el cuestionario y dispones del código de recuperación, introdúcelo aquí, si no, realiza el cuestionario normalmente.<br>";
		echo "<form name='form2' method='post' >";
		echo "<input type='text' size='50' class='col-2' maxlength='50' id='codrecu' name='codrecu' title='de 4 a 50 caracteres' placeholder='código de recuperación' 
			pattern='[A-Za-z0-9.-_]{4,50}' autofocus required>";	
		echo " <input type='submit' name='codrecu1' value='recuperar un cuestionario'></form><p></p>";
		echo "</div>";
	}
	echo "<form name='form1' id='form1' method='post'>";
	echo "<input type='hidden' name='tini' value='".gmdate("Y-m-d H:i:s")."'>";
	$ponerform = 1;
}

// --------------------------------------------------

$result = $ilink->query("SELECT * FROM ".$cuest."1 WHERE n AND !n1 ORDER BY orden");

while ($fila = $result->fetch_array(MYSQLI_BOTH)) {

	$n = $fila['n'];
	$post = $_POST['v'.$n];
	
	if($_POST['codrecu']) {
		include APP_DIR . '/cuest/cu_1preg_indep.php';
		continue;
	} else {
		include APP_DIR . '/cuest/cu_1preg.php';	
	}

	if(!$fila['input'] OR (!$envi AND !$_POST['codrecu'])) {continue;}
		
	$color=$letra=$escorr_feed="";

	echo "<div class='colu2 contiene'>";

	//ver si es correcta y tiene feedbak
		
	if ($fila['input'] != 'check' AND $fila['input'] != 'persiana') {
		
		$texto = $post;

	} else {		
		
		//devuelve p,r,respcorr 
		if($post) {
			$escorr_feed = escorr_feed($n,$post,$cuest,$ilink);
			//devuelve p,r,respcorr
			if($alfabet) {$letra = chr(64+$post).")";}
			$texto = $escorr_feed[0];
		}
		
	}

	echo "<span class='b'>Tu respuesta:</span>";
		
	if($post) {echo "<br><span class='$color'>$letra $texto</span>";}
		
	echo "</div>";
		
}

// --------------------------------------------------

if(!$envi) {
	
	echo "<input type='hidden' name='cuest' value='$cuest'>";

	if(!$previsu) {
		echo "código de recuperación del cuestionario, para continuar en otro momento (<span class='b'>cópialo</span>) ";
		if($_POST['codrecu']) {
			echo "<input type='text' size='50' maxlength='50' class='col-2' value='".$_POST['codrecu']."' disabled>";
			echo "<input type='hidden' value='".$_POST['codrecu']."' id='codrecu' name='codrecu'>";
		} else {
			$nuevocod = codigo();
			echo "<input type='text' size='15' maxlength='15' class='col-2' value='$nuevocod' disabled>";
			echo "<input type='hidden' name='codigo' value='$nuevocod'>";
		}
	}
	echo "<br>";
	echo "<input class='col-10' type='submit' name = 'envi' value='>> Enviar >>'>";
	echo "</form>";
		
}

echo "</div>";

// --------------------------------------------------

function guardarc($cuest,$ilink) {
	
	$sql = "SELECT max(cu) FROM ".$cuest."2";
	$temp = $ilink->query($sql);
	if($temp->num_rows) {
		$fila = $temp->fetch_array(MYSQLI_BOTH);
	}
	$cu = $fila[0] + 1;

	$ip = filter_var($_SERVER['REMOTE_ADDR'], FILTER_VALIDATE_IP) ?: '0.0.0.0';
	$tfin = gmdate("Y-m-d H:i:s");

	$result = $ilink->query("SELECT * FROM ".$cuest."1 WHERE n AND !n1 ORDER BY n");

	while ($fila = $result->fetch_array(MYSQLI_BOTH)) {

		$i = $fila['n'];
		$var = $_POST['v'.$i];

		if ($var AND ($fila['input'] == 'check' OR $fila['input'] == 'persiana')) {
			$result1 = $ilink->query("SELECT p FROM ".$cuest."1 WHERE n='$i' AND n1='$var'");
			$fila1 = $result1->fetch_array(MYSQLI_BOTH);			$var = $fila1[0];
		}

		$sql = "INSERT INTO ".$cuest."2 (t_ini, cu, u, n, ";
		if (!$fila['input']) {
			$sql = $sql." v2,"; $var="separador";
		} else {
			if ($fila['tipo'] == 'N') {$sql = $sql." v1,";} 
			if ($fila['tipo'] == 'C') {$sql = $sql." v2,";}
			if ($fila['tipo'] == 'L') {$sql = $sql." v3,";}
		}
		
		$temp = $_POST['codigo'];
		if($_POST['codrecu']) {$temp = $_POST['codrecu'];}

		$sql = $sql." usuid, datetime,codigo) VALUES ('', '$cu', '$ip', '$i', '$var', '', '$tfin','$temp')";
		$ilink->query($sql);
			
	}
		
}

function recupera($cuest,$codigo,$ilink) {

	$sql = "SELECT cu, codigo FROM ".$cuest."2 WHERE codigo = '$codigo'";
	
	$result = $ilink->query($sql);
	if ($result->num_rows > 0) {
		// existe el $codigo
		$fila = $result->fetch_array(MYSQLI_BOTH);
		extract($fila);
		//creo variables POST
		$sql = "SELECT n,n1,tipo,input FROM ".$cuest."1 WHERE n AND !n1";
		$result = $ilink->query($sql);
		while ($fila = $result->fetch_array(MYSQLI_BOTH)) {
			$i = $fila['n'];
			if ($fila['tipo'] == 'N') {$campo = " v1";} 
			if ($fila['tipo'] == 'C') {$campo = " v2";} 
			if ($fila['tipo'] == 'L') {$campo = " v3";} 
			if (!$fila['tipo']) {continue;}
			$sql1 = "SELECT $campo, obs FROM $cuest"."2 WHERE n = '$i' AND codigo='$codigo'";
			$result1 = $ilink->query($sql1);
			$fila1 = $result1->fetch_array(MYSQLI_BOTH);
			if ($fila['input'] == 'check' OR $fila['input'] == 'persiana') {
				$sql2 = "SELECT n1 FROM $cuest"."1 WHERE n='$i' AND p = '$fila1[0]'";
				$result2 = $ilink->query($sql2);
				$n1 = $result2->fetch_array(MYSQLI_BOTH);
				$fila1[0] = $n1[0];
			}	
			$_POST['v'.$i] = $fila1[0];
			$_POST['obs'.$i] = $fila1[1];
		}
		return "*";
	} else {
		return "no existe";
	}

}

function codigo($length = 4) {
	
    $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString."_".gmdate("YmdHis");	
	
}

?>	