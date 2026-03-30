<?php

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

if ($regborr != 0) {	
	$ilink->query("DELETE FROM ".$bolsa."_ WHERE n = $regborr");
	$regborr = 0;
}

// --------------------------------------------------

if ($regdupli != 0) {
	$sql = "DESCRIBE ".$bolsa."_";
	$iresult = $ilink->query($sql);
	$numcampos = $iresult->num_rows;
	// --------------------------------------------------//
	$sql = "SELECT MAX(n) FROM ".$bolsa."_";
	$iresult = $ilink->query($sql);
	$max = $iresult->fetch_array(MYSQLI_BOTH);
	$max = $max[0] + 1;
	$sql = "SELECT MAX(orden) FROM ".$bolsa."_";
	$iresult = $ilink->query($sql);
	$orden = $iresult->fetch_array(MYSQLI_BOTH);
	$orden = $orden[0] + 10;
	// --------------------------------------------------//
	$ilink->query("DROP TABLE temporal");
	$sql = "CREATE TABLE temporal SELECT * FROM ".$bolsa."_ WHERE n = '$regdupli'";
	$ilink->query($sql);
	$ilink->query("UPDATE temporal SET n = '$max'");
	$ilink->query("UPDATE temporal SET orden = '$orden' WHERE !n1");
	$ilink->query("INSERT INTO $bolsa"."_ SELECT * FROM temporal");
}

$sql = "SELECT * FROM ".$bolsa."_ WHERE n AND !n1 ORDER BY orden";
$result = $ilink->query($sql); 

$numpreg = $result->num_rows;

if ($numpreg) {
	
	echo "<span class='rojo b peq'>Las modificaciones en la bolsa no se reflejarán en los cuestionarios creados anteriormente.</span><br>";

	echo "Cambia el orden arrastrando preguntas.<p></p><ul id='sortable' class='both'>";
	
	while ($fila = $result->fetch_array(MYSQLI_BOTH)) {
		
		extract($fila);
		
		echo "<li id='li_$n' class='movil contiene'>"; 

			echo "<a class='fl mr5' href='?opc=$opc&bolsa=$bolsa&regborr=$n' onclick='return borrar()'><span class='icon-bin'></span></a>";
			echo "<a class='fl mr5' href='?opc=$opc&bolsa=$bolsa&regmodif=$n'><span class='icon-pencil2'></span></a> &nbsp; ";
			echo "<a class='fl mr5' href='?opc=$opc&bolsa=$bolsa&regdupli=$n'><span class='icon-copy'></span></a>";
			echo "<span class='mr5'> &nbsp; </span>";

			$solop = 1;
			include APP_DIR . '/cuest/cu_1preg.php';
	
		echo "</li>";

	}

	//echo "<div id='saco'></div>";
	
	echo "</ul>";

}

?>

<script type="text/javascript">

$(document).ready(function(){

	$('#sortable').sortable({
	   axis: 'y',
      opacity: 0.7,
      
      update: function(event, ui) {
   	   var list_sortable = $(this).sortable('toArray').toString();
    		// change order in the database using Ajax
         $.ajax({
           url: 'aux/li_order.php',
           type: 'POST',
           data: {list_order:list_sortable, tabla:'<?php echo $bolsa."_";?>'},
           success: function(data) {
               //finished
               //$( "#saco").html( data )
           }
         });
       }
    });	
})
    
</script>



