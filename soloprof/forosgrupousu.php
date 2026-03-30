<?php

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

$usuid = $_GET['usuid'];

echo "T&iacute;tulo del Hilo en letra m&aacute;s grande cuando &eacute;l lo inicia<p></p>";

$usu = ponerusu($usuid,1,$ilink);
echo $usu[0].$usu[1];
echo "<div class='both'>&nbsp;</div>";

$sql = "SELECT * FROM foro WHERE usu_id = '$usuid'";
if ($_SESSION['auto'] < 10) {$sql .= " AND !invisible";}
$sql .= " ORDER BY fecha DESC";

$sql = "SELECT DISTINCT grupos.id,grupos.grupo FROM grupos LEFT JOIN gruposusu ON grupos.id = gruposusu.grupo_id LEFT JOIN
 alumasiano ON alumasiano.id = gruposusu.usu_id WHERE gruposusu.usu_id = '$usuid' AND 
 grupos.asigna = '".$_SESSION['asigna']."'";

$result = $ilink->query($sql);

echo "<div style='height:25em;overflow:auto'>";

$ret[0] = 0;
$ret[1] = 0;

while ($fila = $result->fetch_array(MYSQLI_BOTH)) {

	$sql1 = "SELECT * FROM forogrupos WHERE grupo = '$fila[0]' AND usu_id = '$usuid'";
	$result1 = $ilink->query($sql1);
	if ($result1->num_rows == 0) {continue;}
	while ($fila1 = $result1->fetch_array(MYSQLI_BOTH)) {
		$filaid = $fila1['id'];
		if ($fila1['asunto']) {
			$asunto = "<span class='mediana b'>".conhiper(consmy(quitabarra($fila1['asunto'])))."</span>";
			$id = $fila['id'];
		} else {
			$iresult2 = $ilink->query("SELECT asunto, id FROM foro WHERE id = '".$fila1['foro_id']."' LIMIT 1");
			$asunto = $iresult2->fetch_array(MYSQLI_BOTH);
			$id = $asunto[1];
			$asunto = $asunto[0];
		}
		$ret[0]++;
		$ret[1] = $ret[1] + strlen($fila1['comentario']);
		echo "<div class='colu'><span class='peq'>".ifecha31($fila1['fecha'],$ilink)."</span> $temp 
		<a href=\"../grupo.php?pest=2&grupoid=$fila[0]\">$asunto</a>";
		if (strlen($fila1['comentario']) > 100) {echo " <a onclick=\"amplred('2div$filaid');amplred('divf$filaid')\" class='txth b'>[Ampliar/reducir]</a>";}
		echo " <span class='rojo'>$fila[1]</span><div id='divf$filaid'>".conhiper(consmy(quitabarra(substr($fila1['comentario'],0,100))));
		if (strlen($fila1['comentario']) > 100) {echo "...";}
		echo "</div><div id='2div$filaid' style='display:none' class='interli'>".conhiper(consmy(quitabarra($fila1['comentario'])))."</div></div><p></p>";
			
	}
}

echo "</div>";

?>