<?php

require_once __DIR__ . '/../siempre_base.php';

$a = $_GET['enchatusuid'];

$result = $ilink->query("SELECT alumnon, CONCAT(alumnon,' ', alumnoa) AS usu, id FROM chat LEFT JOIN usuarios ON usuarios.id = chat.usuid  WHERE asigna = '$a' ORDER BY fechaentra");

while ($fila = $result->fetch_array(MYSQLI_BOTH)){
	$usu = $fila['usu'];
	$mens = "<span title='$usu'>".$fila['alumnon']."</span>";
	if ($fila['id'] != $_SESSION['usuid']) {
		echo "<a title=\"Texto privado a $usu\" 
 		onclick=\"parent.document.formchat.message.value='[".$fila['alumnon']."] ';parent.document.formchat.para.value='".$fila['id']."';parent.document.formchat.message.focus();return false\"	
		>";
	}
	echo $fila['alumnon'];
	if ($fila['id'] != $_SESSION['usuid']) {
		echo "</a>";
	}
	echo "<br>";
}

?>

