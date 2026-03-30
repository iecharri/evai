<?php

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

if ($_SESSION['tipo'] == "E" AND $_SESSION['auto'] < 10) {return;}

echo "<div class='casigna'>";
	if ($_SESSION['asigna'] AND esmio($_SESSION['asigna'],$_SESSION['curso'],$_SESSION['grupo'],$ilink)) {
		$result = $ilink->query("SELECT asignatura FROM podasignaturas WHERE cod = '".$_SESSION['asigna']."'"); 
		$fila = $result->fetch_array(MYSQLI_BOTH);
		echo "<span class='icon-pushpin'></span> <a href='misasignaturas.php' alt=\"".i("cambasi",$ilink)."\" title=\"".i("cambasi",$ilink)."\">";
		echo $_SESSION['asigna']." - ".$fila[0];
		if ($_SESSION['curso']) {echo " <span class='b'>".i("curso",$ilink)."</span> ".$_SESSION['curso'];}
		if ($_SESSION['grupo']) {echo " <span class='b'>".i("grupo",$ilink)."</span> ".$_SESSION['grupo'];}
		echo "</a>";
		if ($_SESSION['auto'] > 4) {		
			$sql = "SELECT DISTINCT grupo FROM asignatprof WHERE ";
			if ($_SESSION['auto'] < 6) {$sql .= "usuid = '".$_SESSION['usuid']."' AND ";}
			$sql .= "asigna = '".$_SESSION['asigna']."' AND curso = '".$_SESSION['curso']."' AND grupo != '".$_SESSION['grupo']."'";
			$result = $ilink->query($sql);
			$n=1;
			if ($result) {
				$param1 = implode_get();
				while ($fila = $result->fetch_array(MYSQLI_BOTH)) {
				if ($n==1) {echo " [ ";$n=0;}
					if (esmio($_SESSION['asigna'],$_SESSION['curso'],$fila['grupo'],$ilink)) {
						echo "<a href='home.php?filtroasign=".$_SESSION['asigna']."&curso=".$_SESSION['curso']."&grupo=".$fila['grupo']."&y=1$param1'>".$fila['grupo']."</a> ";
					}
				}
				if (!$n) {echo "]";}
			}
		}
	} else {
		echo "<a href='misasignaturas.php'><span class='icon-pushpin'></span> ".i("seleccasi",$ilink)."</a>";
		$_SESSION['asigna'] = "";
		$_SESSION['curso'] = "";
		$_SESSION['grupo'] = "";
		$_SESSION['tit'] = "";
	}
echo "</div>";


function implode_get() {
    $output = '';
    foreach($_GET as $key => $value) {
	 if ($key == "filtroasign" OR $key == "curso" OR $key == "grupo" OR $key == "y") {continue;}
   	 $output .= '&'.$key.'='.$value;   
    }
    return $output;
}

?>
