<?php

require_once __DIR__ . "/siempre_base.php";

if ($_SESSION['auto'] < 5 ) {
	exit;
}

$sg = $_SESSION['sg'];

// --------------------------------------------------

$result = $ilink->query("SELECT frase, accion, mover FROM merlinhabla WHERE usuid = '".$_SESSION['usuid']."' AND decir = '1'");

if ($result AND $result->num_rows>0) {

	if ($_SESSION['idioma'] != 'i') {$lang = "es-ES";} else {$lang = "en-GB";}

	while ($fila = $result->fetch_array(MYSQLI_BOTH)) {

		?>

	 	<script>

		vozlink("<?php echo $fila[0];?>","<?php echo $lang;?>"); 
		
 	 	</script>

		<?php		
		
	}

	$ilink->query("DELETE FROM merlinhabla WHERE usuid = '".$_SESSION['usuid']."' AND decir = '1'");
	$ilink->query("UPDATE merlinhabla SET decir = '0' WHERE usuid = '".$_SESSION['usuid']."' AND decir = '1'");
	
}
//$n=1;

// --------------------------------------------------

if ($_SESSION['demo']) {

	$_SESSION['demo'] --;
	if (!$_SESSION['demo']) {$_SESSION['demo'] = $_SESSION['numvinc'];}
	if (!$_SESSION['demo'] OR $_SESSION['demo'] == -1) {$_SESSION['demo'] = -1; return;}
	$_SESSION['leer'] = 1;
	$_SESSION['listar'] = $_SESSION['numvinc'] - $_SESSION['demo']; 
	?>
	<script language="javascript">
	gictempovinc();
	</script>
	<?php
	//$n = 1;
	
} else {

	$temp = $_SESSION['asignas']; if(!$_SESSION['asignas']) {$temp = "1=1";}
	$sql = "SELECT COUNT(id) FROM vinculos WHERE (".$temp.") AND usu_id > 0 AND vinculos.fechacrea > '".$_SESSION['desde']."'";
	$result = $ilink->query($sql);
	if ($result AND $result->num_rows) {
		$fila = $result->fetch_array(MYSQLI_BOTH);
		$lee1 = $fila[0];

		if ($lee1 AND $lee1 != $_SESSION['listar']) {
			$_SESSION['leer'] = $lee1 - $_SESSION['listar'];
			$_SESSION['listar'] = $lee1;
			?>
			<script language="javascript">
			gictempovinc();
			</script>
			<?php
			//$n = 1;
		}
	}
	
}

// --------------------------------------------------

function crearwav($txt, $n) {
	//Creo fichero txt usu-txt-n
	$fich = "u".$_SESSION['usuid']."_".$n;
	$ar=safe_fopen("tmp/$fich.txt","w");
	fputs($ar,$txt);
	fclose($ar);
	$ejecutar = trim($_SESSION['espeak'])." -f tmp/$fich.txt -w tmp/$fich.wav";
	system($ejecutar);
	return $fich.".wav";	
}

?>



