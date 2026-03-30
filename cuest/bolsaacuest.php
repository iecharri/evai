<?php

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

//Añadir preguntas a un cuestionario
if($anadirpregs) {
	bolsaacuest($bolsa,$cuest,$ilink);
	$opc = 5;
	return;
}

$sql = "SELECT * FROM ".$bolsa."_ WHERE n1 = 0 ORDER BY orden";
$result = $ilink->query($sql); 

?>

<script language="Javascript">
function selecc(pregs){
var check;
if (pregs.all.checked) {check = 'checked'} else {check = ''}
<?php
while ($fila = $result->fetch_array(MYSQLI_BOTH)) {
	echo "pregs.a$fila[0].checked = ";?>check<?php echo ";\n";
}
?>
}
</script>

<?php

$iresult = $ilink->query("SELECT * FROM ".$bolsa."_ WHERE n1 = 0");
$numpreg = $iresult->num_rows;

if (!$numpreg) {
	echo "No hay preguntas en la Bolsa, ve a <a href='?opc=1&opc1=1&bolsa=$bolsa'>Bolsa de Preguntas</a>";
	return;
}
$result = $ilink->query($sql);

?>
	
<form name='pregs' method='post' action='?opc=<?php echo $opc;?>&cuest=<?php echo $cuest;?>'>
	
<ul>

<li class='sortable'>

<input type='checkbox' name='all' onclick='javascript:selecc(pregs)'> 
Marca las Preguntas a añadir al Cuestionario seleccionado y haz click en <input type='submit' name='anadirpregs' class='col-2em' value='>>'>

</li>

	<?php

	while ($fila = $result->fetch_array(MYSQLI_BOTH)) {

		$separador = "";
		if (!$fila['n1'] AND !$fila['input']) {$separador = "b";}
		echo "<li class='colu3'>";
		echo "<input type='checkbox' name='a".$fila['n']."'> ";
		echo "<span class=' $separador'>".$fila['p']."</span>";
		echo "</li>";

	}

	?>
	
</ul>

</form>
	