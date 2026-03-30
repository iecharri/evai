<?php

require_once __DIR__ . '/../siempre_base.php';

$a = $_GET['enchatusuid'];

$result = $ilink->query("SELECT alumnon, id FROM chat LEFT JOIN usuarios ON usuarios.id = chat.usuid  WHERE asigna = '$a' ORDER BY fechaentra");
while ($fila = $result->fetch_array(MYSQLI_BOTH)){
	$mens = "";
	if ($fila['id'] != $_SESSION['usuid']) {
		$mens = " <a class='b' title=\"texto privado a $fila[0]\" 
 		onclick=\"parent.document.form1.message.value='[$fila[0]] ';parent.document.form1.para.value='$fila[1]';
 		parent.document.form1.message.focus();return false\"	
		>[texto privado]</a>";
	}
	echo "<div class='both peq'>";
	$usu = ponerusu($fila['id'],1,$ilink);
	echo "<span class='fl'>".$usu[0]."</span>".$usu[1].$mens." <span class='peq u'>".$usu[2]."</span>";
	echo "</div>";
}

?>

