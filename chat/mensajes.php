<?php

require_once  __DIR__ . '/../siempre_base.php';
require_once  APP_DIR . '/hiperen.php';

function mensajes($a,$u,$n,$ilink) {

$iresult = $ilink->query("SELECT fechaentra FROM chat WHERE asigna = '$a' AND usuid = '$u'");
$fechaentra = $fechaentra[0] ?? '2000-01-01 00:00:00'; // por si no hay fecha de entrada

$result = $ilink->query("SELECT n, chatlista.texto, alumnon, CONCAT(alumnon,' ', alumnoa) AS usu FROM chatlista LEFT JOIN usuarios ON usuarios.id = chatlista.usuid WHERE n > '$n' AND asigna = '$a' AND chatlista.fecha > '$fechaentra[0]' AND (usuid = $u OR parausuid = '$u' OR parausuid = 0) ORDER BY chatlista.fecha");

while ($fila = $result->fetch_array(MYSQLI_BOTH)){

	$usu = $fila['usu'];
	$fila['texto'] = consmy(conhiper($fila['texto']));

	$mens = "<span title='$usu' class='b'>".$fila['alumnon']."</span>: ".$fila['texto']."<br>";
	
	?>
	
	<script>
    	document.getElementById('mensajeschat').innerHTML += <?php echo json_encode($mens); ?>;
	</script>	

	<?php
	$_SESSION['n'] = $fila['n'];

}

}

?>