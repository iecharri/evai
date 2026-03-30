<?php

require_once __DIR__ . '/siempre.php';

if ($_SESSION['entra'] && !demo_enabled()) {
	if (empty($_SESSION['csrf'])) { $_SESSION['csrf']=bin2hex(random_bytes(16)); }$csrf = $_SESSION['csrf'];
	winop1("",'div1','');
	?>
  <div class='center'><p></p><p><span class='verde b mediana'>¿Actualizar tus estadísticas ahora?</span></p><p></p></div>
  
  <div class='center'><a id="btn-actualiza" class='btn' href="home_actualiza.php?csrf=<?= htmlspecialchars($csrf,ENT_QUOTES,'UTF-8') ?>">Actualizar ahora</a></div><p></p><p></p>

  <div id="upd-icon" class="center" hidden><?php require APP_DIR . '/icono_recarga.php'; ?></div> 

	<?php
	echo "</div></div>";
}

if ($_SESSION['entra']) {
	require_once APP_DIR . '/home_entro.php';
} elseif ($_GET['filtroasign']) { 
	if (!demo_enabled()) {
		require_once APP_DIR . '/home_cambioasi.php';
	}
}

if ($reviso) {
	$iresult = $ilink->query("SELECT * FROM usuarios WHERE id = '".$_SESSION['usuid']."' LIMIT 1"); //id, dni, ultasigna, ultcurso, ultgrupo
	$fila = $iresult->fetch_array(MYSQLI_BOTH);
	require_once APP_DIR . '/var_usu.php';  
	require_once APP_DIR . '/var_asig.php';
	if ($_SESSION['entra']) {
		unset($_SESSION['entra']);
	}

	$id = $_SESSION['usuid'];
	$sql = "SELECT id,tipo FROM usuarios WHERE id='$id'";
	
}

$auto = $_SESSION['auto'];

$page_header = i("inicio",$ilink);
$activeinicio = "class = 'active'";

$a_home = "active";

require_once APP_DIR . '/molde_top.php';

require_once APP_DIR . '/home_cont.php';

require_once APP_DIR .  '/molde_bott.php';

function quitabarra($x) {return stripslashes($x);}

?>

