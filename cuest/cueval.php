<?php

//Guardar = 3 Cuestionario principal de Evai, se puede hacer todas las veces que se quiera y se guardan resultados
//Guardar = 2 Cuestionario independiente de Evai, se guarda resultados y es para enviar su URL por mail a quien queramos que conteste
//Guardar = 1 Cuestionario dependiente, se puede hacer una vez y se guardan resultados y persona que contesta
//Guardar = 0 Cuestionario dependiente, se puede hacer todas las veces que se desee y no se guardan

require_once __DIR__ .  "/../siempre.php";

if ($_SESSION['auto'] < 5) {echo "<p><br>Usuario no autorizado</p>";exit;}

iconex(DB2,$ilink);

require_once APP_DIR . "/cuest/tablaevalfuncis.php";
require_once APP_DIR . "/ponerobject.php";

extract($_GET);
extract($_POST);

$cuest = strtolower($cuest);

if(!$opc) {
	if($_SESSION['op'] == 1) {$opc = 4;}
	if($_SESSION['op'] == 3) {$opc = 8;}
}

// --------------------------------------------------

if($_SESSION['auto'] < 10 OR $opc == 4) {
	$bolsa = strtolower($_SESSION['asigna']);
}

if($cuest) {
	$bolsa = separa($cuest,$ilink);
	$bolsa = $bolsa[0];
}

// --------------------------------------------------

iconex(DB2,$ilink);

if($bolsa) {require_once APP_DIR . "/cuest/aux/nuevabol.php";}

//nuevo cuestionario
if ($nuevocuest) {
	if(existeenc($bolsa,$nuevocuest,$ilink)) {
		$existe = "<span class='rojo b'>$nuevocuest ya existe</span><br>";
	} else {
		$nuevocuest = str_replace("_","",$nuevocuest);
		$nuevocuest = str_replace(" ","",$nuevocuest);
		$nuevocuest = $bolsa."_".$nuevocuest;
		$nuevocuest = strtolower($nuevocuest);
		require_once APP_DIR . "/cuest/aux/nuevaenc.php";
	}
	$nuevo = "";
	$opc = 3;
	$cuest = $nuevocuest;
}

// --------------------------------------------------

//Cambia formula
if ($formu) {
	$formu11 = trim($formu11);
	$guardar = "0";
	if($formu11) {$guardar = "1";}
	$ilink->query("UPDATE $formu"."1 SET formula = '$formu11', guardar='$guardar'");
	$formu = "";
}

// --------------------------------------------------

//Cambia nombre cuestionario
if ($camb11) {
	$camb11 = str_replace("_","",$camb11);
	$camb11 = str_replace(" ","",$camb11);
	$camb11 = strtolower($camb11);
	$ret = separa($camb10,$ilink);
	if(existeenc($ret[0],$camb11,$ilink)) {
		$existe = "<span class='rojo b'>$ret[0]"."_".$camb11." ya existe</span><br>";
	} else {
		$ilink->query("ALTER TABLE $camb10"."1 RENAME ".$ret[0]."_".$camb11."1");
		$ilink->query("ALTER TABLE $camb10"."2 RENAME ".$ret[0]."_".$camb11."2");
		$camb = "";
		}
}

// --------------------------------------------------

//Copiar cuestionario
if ($copi11) {
	$copi11 = str_replace("_","",$copi11);
	$copi11 = str_replace(" ","",$copi11);
	$copi11 = strtolower($copi11);
	$ret = separa($copi10,$ilink);
	if(existeenc($ret[0],$copi11,$ilink)) {
		$existe = "<span class='rojo b'>$ret[0]"."_".$copi11." ya existe</span><br>";
	} else {
		$ilink->query("CREATE TABLE ".$ret[0]."_".$copi11."1 SELECT * FROM ".$copi10."1");
		if ($ilink->errno) {die ("Error1");}
		$ilink->query("CREATE TABLE ".$ret[0]."_".$copi11."2 SELECT * FROM ".$copi10."2");
		if ($ilink->errno) {die ("Error2");}
		$ilink->query("TRUNCATE ".$ret[0]."_".$copi11."2");
		if ($ilink->errno) {die ("Error3");}
		$copi = "";
	}
}

// --------------------------------------------------

//Borrar cuestionario
if ($_GET['borr']) {
	$ilink->query("DROP TABLE $borr"."1");
	$ilink->query("DROP TABLE $borr"."2");
}

// --------------------------------------------------

iconex(DB1,$ilink);

$consulta = $ilink->query("SELECT cuestionario FROM atencion LIMIT 1");
$fila = $consulta->fetch_assoc();
$atencioncuestppal = $fila['cuestionario'] ?? '';

require_once APP_DIR . "/molde_top.php";

// --------------------------------------------------

$array[0] = "<a href='?opc=1&opc1=1&bolsa=$bolsa'>Bolsa de preguntas</a>";
$array[1] = "<a href='?opc=1&opc1=2&bolsa=$bolsa'>Copiar Bolsa</a>";
$array[2] = "<a href='?opc=1&opc1=3&bolsa=$bolsa'>Añadir pregunta</a>";

// --------------------------------------------------

iconex(DB2,$ilink);

require_once APP_DIR . "/cuest/bolsacambios.php";

// --------------------------------------------------

if (!$opc) {$opc = 4;}
if($opc == 1 AND !$opc1) {$opc1=1;}
$pest = 1;
if($opc1) {$pest = $opc1;}

if($opc == 1) {
	solapah($array,$pest,"navhsimple");
}

// --------------------------------------------------

?>

<script language="JavaScript">
function borrar() {
return confirm("<?php echo "Confirmar borrado";?>");
}
</script>

<?php

// --------------------------------------------------

//listado de cuestionarios
if (!$opc OR $opc == 8 OR $opc == 4) {
	require_once APP_DIR . "/cuest/elegireval.php";
}

//gestion bolsa
// --------------------------------------------------
if ($opc == 1) {
	if ($opc1 == 2) {
		require_once APP_DIR . "/cuest/copiarbolsa.php";
	} else {
		if($opc1 == 3) {$reganadir = 1;}
		if ($regmodif OR $reganadir OR $borr) {
			require_once APP_DIR . "/cuest/bolsapregedit.php";
			ordenar($bolsa."_",$ilink);	
		} else {
			require_once APP_DIR . "/cuest/bolsapregs.php";
		}
	}

	$sql = "SELECT orden FROM $bolsa"."_ WHERE !n1 AND orden = '999999'";
	$result = $ilink->query($sql);
	if($result->num_rows) {ordenar($bolsa."_",$ilink);}

}
// --------------------------------------------------

if($cuest) {
	$sql = "SELECT orden FROM $cuest"."1 WHERE !n1 AND orden = '999999'";
	$result = $ilink->query($sql);
	if($result->num_rows) {ordenar($cuest."1",$ilink);}
}

//añadir preguntas al cuest elegido
if ($opc == 3) {
	require_once APP_DIR . "/cuest/bolsaacuest.php";
}

//ver de 1 en 1 respondidos
if ($opc == 7) {
	require_once APP_DIR . "/cuest/ver1en1.php";
}

//previsualizar cuest
if ($opc == 6) {
	require_once APP_DIR . "/cuest/cu_previsu.php";
}

//borrar, reordenar preguntas cuest
if ($opc == 5) {
	require_once APP_DIR . "/cuest/cuestborrordenar.php";
	ordenar($_GET['cuest']."1",$ilink);	
}

iconex(DB1,$ilink);

require_once APP_DIR  .  "/molde_bott.php";

// --------------------------------------------------

function separa($cuest,$ilink) {
	//buscar separadores "_" de atras adelante
	$temp = $cuest;
	while (1 == 1) {
		$pos = strripos($cuest,"_");
		if (!$pos) {break;}
		$cuest = substr($cuest,0,$pos);
		//mirar si $cuest es una asignatura
		$asigna = versiesasigna($cuest,$ilink);
		//si lo es, return como bolsa y cuest actual
		//if ($asigna OR ($cuest == "cuestionario" AND $_SESSION['auto'] == 10)) {
			$ret[0] = $cuest;
			$ret[1] = substr($temp,$pos+1);
			return $ret;
		//}
	}
	return;
}

// --------------------------------------------------

function versiesasigna($bolsa,$ilink) {
	iconex(DB1,$ilink);
	$sql = "SELECT cod FROM podasignaturas WHERE cod = '$bolsa' OR cod = '".strtoupper($cuest)."'";
	$result = $ilink->query($sql);
	if ($result->num_rows == 0) {iconex(DB2,$ilink);return;}
	iconex(DB2,$ilink);
	return $bolsa;
}

// --------------------------------------------------

function existeenc($bolsa,$enc,$ilink) {
	$tablanueva = strtolower($bolsa."_".$enc."1");
	$result = $ilink->query("SHOW TABLES LIKE '$tablanueva'");
	$existe = $result->num_rows;
	return $existe;
}

// --------------------------------------------------

?>

<script language="JavaScript">
<!--
var era;
var previo=null;
function uncheckRadio(rbutton){
if(previo &&previo!=rbutton){previo.era=false;}
if(rbutton.checked==true && rbutton.era==true){rbutton.checked=false;}
rbutton.era=rbutton.checked;
previo=rbutton;
}
//-->
</script>