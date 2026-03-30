<?php

require_once __DIR__ . "/siempre_base.php";

$iresult = $ilink->query("SELECT mandoadist FROM cursasigru WHERE 
 asigna = '".$_SESSION['asigna']."' AND curso = '".$_SESSION['curso']."' AND
  grupo = '".$_SESSION['grupo']."'");
$activo = $iresult->fetch_array(MYSQLI_BOTH);

echo " &nbsp; &nbsp; ";

if (esprofesor($_SESSION['asigna'],$_SESSION['curso'],$_SESSION['grupo'],$ilink)) {

	if ($activo[0]) {
		echo "ACTIVO &nbsp; &nbsp; [ <a href='?op=6&apli=2&act=2'>Desactivar</a> ]";
	} else {
		echo "INACTIVO &nbsp; &nbsp; [ <a href='?op=6&apli=2&act=1'>Activar</a> ]";
	}

} else {
	
	if (!$activo[0]) {
		echo "El sistema est&aacute; inactivo";
	}
	
}

$iresult = $ilink->query("SELECT COUNT(click) FROM mandoadist WHERE usuid = '".$_SESSION['usuid']."' AND asigna = '".$_SESSION['asigna']."' AND curso = '".$_SESSION['curso']."' AND grupo = '".$_SESSION['grupo']."'");
$hepulsado = $iresult->fetch_array(MYSQLI_BOTH);
if ($hepulsado[0]) {echo " &nbsp; &nbsp; <span class='rojo b'>Ya has pulsado en esta Asignatura</span>";}

$iresult = $ilink->query("SELECT COUNT(click) FROM mandoadist WHERE 
asigna = '".$_SESSION['asigna']."' AND curso = '".$_SESSION['curso']."' AND grupo = '".$_SESSION['grupo']."'");
$nuevos = $iresult->fetch_array(MYSQLI_BOTH);

if (!$_SESSION['mando'] AND $activo[0]) {
	echo "<a href='?op=6&apli=2&mandooff=2' class='fr'>MANDO</a>";	
}

if ($nuevos != $_SESSION['nuevos']) {
	$_SESSION['nuevos'] = $nuevos;
	?>
	<script language="javascript">
	mandoestad();
	</script>
	<?php
}
?>



