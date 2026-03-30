<?php

require_once __DIR__ . '/siempre.php';

require_once APP_DIR . '/molde_top.php';

extract($_GET);
extract($_POST);

// --------------------------------------------------

$titulo = "Plazas";

require_once APP_DIR . '/soloprof/soloprofaplic21.php';

// --------------------------------------------------

$enti = ($_SESSION['entix'] ?? 0) > 0 ? (int)$_SESSION['entix']
      : (($_POST['enti'] ?? 0) > 0 ? (int)$_POST['enti']
      : (($_GET['enti'] ?? 0) > 0 ? (int)$_GET['enti']
      : null));

$sql = "SELECT * FROM conventid WHERE n = '$enti'";
$result = $ilink->query($sql);

if (!$enti OR !$result) {
	require_once APP_DIR .  "/molde_bott.php";
	exit;
}

$fila = $result->fetch_array(MYSQLI_BOTH);
extract($fila);

echo $nombre;

// --------------------------------------------------

if (!$_SESSION['entix']) {  // OR ($_GET['enti'] AND $_GET['enti'] != $_SESSION['entix'])
	//$_SESSION['entix'] = "";
	enticontra($n,$ilink);	
	if (!$_SESSION['entix']) {
	require_once APP_DIR .  "/molde_bott.php";
	exit;
	}
}

//Listar las plazas para a&ntilde;adir y editar

$enti = $_SESSION['entix']; 

if ($edenti) {
	echo "	<div class='colu'>[<a href='?enti=$enti'>Plazas</a>]";
	echo "	[<a class='b' href='?enti=$enti&edenti=$enti'>Datos de la entidad</a>]</div>";
} else {
	echo "	<div class='colu'>[<a class='b' href='?enti=$enti'>Plazas</a>]";
	echo "	[<a href='?enti=$enti&edenti=$enti'>Datos de la entidad</a>]</div>";
}

echo "<br>";

if ($_POST['convenioofertado']) {
	if ($_POST['ofertado']) {$ofertado = 1;} else {$ofertado = 0;}
	$ilink->query("UPDATE convenios SET ofertado = '$ofertado' WHERE n = '".$_POST['convenioofertado']."'");
}


if ($edenti OR $editarenti1) {

	editarenti($edenti,1,$ilink);
		
} else {

	if ($bo AND $automodif) {
		$ilink->query("DELETE FROM convenios WHERE n = '$bo'");
	}
	if ($ana == 1) {
		echo "<span class='txth b mediana center'>A&ntilde;adir Plaza</span>";
		anadir($asigna,$curso,$grupo,$enti,$ilink);
	} elseif ($ed) {
		echo "<span class='txth b mediana center'>Modificar Plaza</span>";
		editar($ed,$asigna,$curso,$grupo,$enti,$ilink);
	} else {
		listar(0,0,0,1,$enti,$ilink);
	}

}

require_once APP_DIR .  "/molde_bott.php";

//session_destroy();

// --------------------------------------------------

function enticontra($enti,$ilink) {
$enticontra = $_POST['enticontra'];
$iresult = $ilink->query("SELECT contrasena FROM conventid WHERE n = '$enti'");
$contra = $iresult->fetch_array(MYSQLI_BOTH);
if ($contra[0] AND $contra[0] == $enticontra) {$_SESSION['entix'] = $enti; return;}
//Formulario solicitar contrase&ntilde;a de la entidad $enti
echo "<form name='form1' method='post'>";
echo "<p></p>Introducir la contrase&ntilde;a <input class='col-2' type='password' name='enticontra'> 
<input class='col-1' type='submit' name='envi' value=' >> '><input type='hidden' name='enti' value='$enti'>";
echo "</form>";
}

?>