<?php

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

?>

<SCRIPT LANGUAGE='Javascript'>
function borrar() {
	return confirm('Confirmar borrado.')
}
</SCRIPT>

<?php

if ($_SESSION['auto'] < 5) {
	exit;
}

// --------------------------------------------------

if ($calcu) {
	evaluar1($cuest,$ilink);
}

// --------------------------------------------------

if ($val) {
	if ($visib) {$temp = 1;} else {$temp = 0;}
	if ($ordenadas) {$temp1 = 1;} else {$temp1 = 0;}
	if ($alfabet) {$temp2 = 1;} else {$temp2 = 0;}
	if ($sinnum) {$temp3 = 1;} else {$temp3 = 0;}
	$ilink->query("UPDATE ".$cuest."1 SET visible = '$temp', formula = '$formula', ordenadas = '$temp1', alfabet = '$temp2', sinnum = '$temp3'");
	if ($cuestppal[0] != $_SESSION['cuest']) {
		if ($guard2) {
			$ilink->query("UPDATE ".$cuest."1 SET guardar = '2', mn = '$mn', visialuresp = ''");
		} else {
			if ($guard) {	
				if ($visialuresp) {$temp = 1;} else {$temp = 0;}
				$ilink->query("UPDATE ".$cuest."1 SET guardar = '1', mn = '$mn', visialuresp = '$temp'");
			} else {
				$ilink->query("UPDATE ".$cuest."1 SET guardar = '', mn = '$mn', visialuresp = ''");
			}
		}
	}
}

// --------------------------------------------------

if ($pregunta) {
	$result = $ilink->query("SELECT * FROM ".$bolsa."_ WHERE n = '$pregunta'"); 
	while ($fila = $result->fetch_array(MYSQLI_BOTH)) {
		$imagen = $ilink->real_escape_string($fila['imagen']);
		$ilink->query("INSERT INTO ".$cuest."1 (n, n1, p, tipo, amin, amax, input, defec, r, respcorr, imagen, tipofich, ancho) VALUES ('$numero', '$fila[1]', '$fila[3]', '$fila[4]', '$fila[5]', '$fila[6]',, '$fila[7]' '$fila[12]', '$fila[10]', \"$fila[11]\", \"$imagen\", \"".$fila['tipofich']."\", \"".$fila['ancho']."\")");
	}
}

// --------------------------------------------------


if ($regborr != 0) {
	$ilink->query("DELETE FROM ".$cuest."1 WHERE n = $regborr");
	$regborr == 0;
}

// --------------------------------------------------

if ($regedit1 == 1) {
	$result = $ilink->query("SELECT n FROM $cuest"."1 WHERE n = '$n1'");
	if ($result->num_rows == 0) {
		$ilink->query("UPDATE ".$cuest."1 SET n = '$n1' WHERE n = '$regedit'");
		$regedit1 = 0;
		$regedit = 0;
	}
}

// --------------------------------------------------
$result = $ilink->query("SELECT * FROM ".$cuest."1 WHERE n AND n1 = 0 ORDER BY orden");

if ($result->num_rows) {

	echo "Cambia el orden arrastrando preguntas<p></p><ul id='sortable' class='both'>";	

	while ($fila = $result->fetch_array(MYSQLI_BOTH)) {

		extract($fila);
		
		echo "<li id='li_$n' class='movil contiene'>"; 

			$regis = $fila[0];
			echo "<a class='fl mr5' href='?opc=$opc&regborr=$regis&cuest=$cuest' onclick='return borrar()'><span class='icon-bin'></span></a>";
			
			if (!$fila['n1'] AND !$fila['input']) {
				
				echo "<div class='fl b'>".nl2br(conhiper($fila['p']))."</div>";
				
			} else {
				
				echo "<div class='fl'>".nl2br($fila['p'])."</div>";
				
			}

		echo "</li>";

	}

	//echo "<div id='saco'></div>";
	
	echo "</ul>";
	
} else {
	
	header("Location: cueval.php?bolsa=$bolsa");
	exit;

}

?>

<script language="JavaScript">

function chequeo(form1){
	if (document.form1.guard.checked==false) {
		document.form1.visialuresp.checked=false
	}
}

$(document).ready(function(){

	$('#sortable').sortable({
	   axis: 'y',
      opacity: 0.7,
      //handle: '.movil',
      update: function(event, ui) {
   	   var list_sortable = $(this).sortable('toArray').toString();
    		// change order in the database using Ajax
         $.ajax({
           url: 'aux/li_order.php',
           type: 'POST',
           data: {list_order:list_sortable, tabla:'<?php echo $cuest."1";?>'},
           success: function(data) {
               //finished
               //$( "#saco").html( data )
           }
         });
       }
    });	
})
    
</script>
