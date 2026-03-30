<?php

require_once __DIR__ . '/../siempre_base.php';

$a = $_GET['enchatusuid'];
$u = $_SESSION['usuid'];

$fecha = gmdate("Y-m-d H:i:s");
$ilink->query("UPDATE chat SET fecha = '$fecha' WHERE usuid = '$u' AND asigna = '$a'");

require_once APP_DIR . '/chat/controlx.php';

$m=0;
$iresult = $ilink->query("SELECT r_usu FROM chat WHERE usuid='$u' AND asigna = '$a'");
$c = $iresult->fetch_array(MYSQLI_BOTH);

if ($c[0]==1 OR $_SESSION['borr']==1) {
	$m=1;
	$ilink->query("UPDATE chat SET r_usu = 0 WHERE usuid = '$u' AND asigna = '$a'");
	?>
	<script language="javascript">jcusuonline();</script>
	<?php
}

if ($_SESSION['n'] == 0) {$_SESSION['n'] = 1;}

$iresult = $ilink->query("SELECT r_txt FROM chat WHERE usuid='$u' AND asigna = '$a'");
$c = $iresult->fetch_array(MYSQLI_BOTH);

if ($c[0]==1) {
	$ilink->query("UPDATE chat SET r_txt = 0 WHERE usuid='$u' AND asigna = '$a'");
	require_once APP_DIR . '/chat/mensajes.php';
	mensajes($a,$u,$_SESSION['n'],$ilink);
}

// --------------------------------------------------

?>
<script language="JavaScript">
document.getElementById('mensajeschat').scrollTop = 1000000;
</script>
