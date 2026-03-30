<?php

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

?>

<script type="text/javascript">
function formu(form) {
	if (document.form.input1[0].selected==true || document.form.input1[2].selected==true) {
		document.form.amin1.value='';
		document.form.amax1.value='';
		hide("ancho-max");hide("ancho-max1");
		hide("imagen");
		show("textarea");
		hide("larga1");
		show("tipo");
		show('persianacheck');
		if (document.form.input1[0].selected==true) {
			show('persiana1');hide('check1');
		}
		if (document.form.input1[2].selected==true) {
			show('check1');hide('persiana1');
		}
	}
	if (document.form.input1[1].selected==true) {
		hide('persianacheck');hide('persiana1');hide('check1');
		hide("imagen");
		show("textarea");
		hide("larga1");
		show("tipo");
		show("ancho-max");show("ancho-max1");
	}	
	if (document.form.input1[3].selected==true) {
		hide("ancho-max");hide("ancho-max1");
		hide('persianacheck');hide('persiana1');hide('check1');
		hide("tipo");
		hide("imagen");
		show("textarea");
		show("larga1");
		document.form.t1.value='L';
		document.form.amin1.value='';
		document.form.amax1.value='';
	}
	if (document.form.input1[4].selected==true) {
		hide("ancho-max");hide("ancho-max1");
		hide('persianacheck');hide('persiana1');hide('check1');
		hide("tipo");
		show("imagen");
		show("textarea");
		hide("larga1");
		document.form.t1.value='';
		document.form.amin1.value='';
		document.form.amax1.value='';
	}
}

<!--
var era;
var previo=null;
function uncheckRadio(rbutton){
if(previo &&previo!=rbutton){previo.era=false;}
if(rbutton.checked==true && rbutton.era==true){rbutton.checked=false;}
rbutton.era=rbutton.checked;
previo=rbutton;
}
//-->
</script>

<?php

//borrar opciones de respuesta check o persiana
if ($borr) {
	if($borr=='tod') {
		$ilink->query("DELETE FROM ".$bolsa."_ WHERE n = '$regmodif' AND n1");
	} else {
		$ilink->query("DELETE FROM ".$bolsa."_ WHERE n = '$regmodif' AND n1 = '$borr'");
	}
	$borr="";
}

if ($pordefec) {
	if ($pordefec == "no") {
		$ilink->query("UPDATE ".$bolsa."_ SET pordefec='' WHERE n='$regmodif'");
		if($input1=="persiana") {
			$ilink->query("UPDATE ".$bolsa."_ SET pordefec=1 WHERE n='1'");
		}
	} else {
		$ilink->query("UPDATE ".$bolsa."_ SET pordefec=1 WHERE n='$regmodif' AND n1='$pordefec'");
		$ilink->query("UPDATE ".$bolsa."_ SET pordefec='' WHERE n='$regmodif' AND n1!='$pordefec'");
	}
}

if ($correcto) {
	$ilink->query("UPDATE ".$bolsa."_ SET respcorr=1 WHERE n='$regmodif' AND n1='$correcto'");
}

if ($incorrecto) {
	$ilink->query("UPDATE ".$bolsa."_ SET respcorr=0 WHERE n='$regmodif' AND n1='$incorrecto'");
}

// --------------------------------------------------
//se ha pulsado para modificar una pregunta

if($regmodif) {
	
	$result = $ilink->query("SELECT orden FROM ".$bolsa."_ WHERE n='$regmodif' AND !n1");
	$fila = $result->fetch_array(MYSQLI_BOTH);
	$miorden = $fila[0];

	if($miorden == 1) {
		$regant = 1;
	} else {
		$result = $ilink->query("SELECT n FROM ".$bolsa."_ WHERE n AND !n1 AND orden=($miorden-1)");
		$fila = $result->fetch_array(MYSQLI_BOTH);
		$regant = $fila[0];
		if (!$regant) {$regant = $regmodif;}
	}

	$result = $ilink->query("SELECT n FROM ".$bolsa."_ WHERE n AND !n1 AND orden=($miorden+1)");
	$fila = $result->fetch_array(MYSQLI_BOTH);
	$regpost = $fila[0];
	if (!$regpost) {$regpost = $regmodif;}
	
	echo "<p class='center'>";
	echo "<a href='?opc=$opc&bolsa=$bolsa&regmodif=".$regant."'><span class='icon-backward2'></span></a> &nbsp; &nbsp; ";
	echo "Pregunta";
	echo " &nbsp; &nbsp; <a href='?opc=$opc&bolsa=$bolsa&regmodif=".$regpost."'><span class='icon-forward3'></span></a>";
	echo "</p>";
}

// --------------------------------------------------

echo "<form name='form' action='?opc=1&opc1=$opc1&bolsa=$bolsa' method='post' enctype='multipart/form-data'>";

// --------------------------------------------------

//se ha pulsado para anadir una pregunta

if ($reganadir) {

	echo "<input type='hidden' name='reganadir1' value='1'>";
	
}

// --------------------------------------------------

//se ha pulsado para modificar una pregunta

if ($regmodif) {
	
	echo "<input type='hidden' name='regmodif1' value='1'>";
	echo "<input type='hidden' name='regmodif' value='$regmodif'>";
	
	$sql = "SELECT * FROM ".$bolsa."_ WHERE n ='$regmodif' AND !n1";
	$result = $ilink->query($sql);
	$fila = $result->fetch_array(MYSQLI_BOTH);
	$p1 = $fila['p'];
	$t1 = $fila['tipo'];
	if($t1 == "N") {$t1check="on";}
	$amin1 = $fila['amin'];
	$amax1 = $fila['amax'];
	$input1 = $fila['input'];
	$r1 = $fila['r'];
	$ancho = $fila['ancho'];
	$tipofich = $fila['tipofich'];
	$regmodif = $fila[0];
	$youtube = $fila['youtube'];
	$anchoyoutube = $fila['anchoyoutube'];
	if ($fila['imagen']) {$imagen = 1;}

}

// --------------------------------------------------

if (!$confirm) {
	if (!$regmodif) {
		$preg = 1;$imag = 0;$tipo = 1;$lick = 1;$larga = 0;
	} else {
		if (!$input1) {
			$preg = 1;$imag = 1;$tipo = 0;$lick = 0;$anchomax = 0;$check = 0; $persiana = 0;
		} else {
			if ($input1 == 'check' OR $input1 == 'persiana') {
				$preg = 1;$imag = 0;$tipo = 1;$lick = 1;$anchomax = 0;$larga = 0;
				if ($input1 == 'check') {$check = 1;}
				if ($input1 == 'persiana') {$persiana = 1;}
			}
			if ($input1 == 'longtext') {
				$preg = 1;$imag = 0;$tipo = 0;$lick = 0;$anchomax = 0;$larga = 1;
			}
			if ($input1 == 'texto') {
				$preg = 1;$imag = 0;$tipo = 1;$lick = 0;$anchomax = 1;$larga = 0;
			}
		}
	}	
} else {
	if (!$input1) {
		$preg = 1;$imag = 1;$tipo = 0;$lick = 0;$anchomax = 0;$check = 0; $persiana = 0;$larga = 0;
	} else {
		if ($input1 == 'check' OR $input1 == 'persiana') {
			$preg = 1;$imag = 0;$tipo = 1;$lick = 1;$anchomax = 0;$larga = 0;
			if ($input1 == 'check') {$check = 1;}
			if ($input1 == 'persiana') {$persiana = 1;}
		}
		if ($input1 == 'longtext') {
			$preg = 1;$imag = 0;$tipo = 0;$lick = 0;$anchomax = 0;$larga = 1;
		}
		if ($input1 == 'texto') {
			$preg = 1;$imag = 0;$tipo = 1;$lick = 0;$anchomax = 1;$larga = 0;
		}
	}	
}

// --------------------------------------------------

echo "<span id='textarea'><textarea rows='4' class='col-10' name='p1' placeholder=\"Escribe aquí la Pregunta o el texto que quieres que se muestre.
En el caso de que no quieres que sea una Pregunta, selecciona más abajo, en el desplegable: Texto separador, no es una Pregunta.\">".$p1."</textarea></span>";

echo "<br>";

// --------------------------------------------------

// poner como queda

// --------------------------------------------------

echo "<div id='imagen'";
if (!$imag){echo " style='display:none'";}
echo ">"; 

	if ($imagen) {
		$param = "tabla=$bolsa"."_&idfoto=".$regmodif;
		if (preg_match('/^image/',$tipofich)) {
			echo "<br><img src='verfich.php?$param' style='height:$ancho"."px'>";
		}
	}

	if ($youtube) {
			if(!$anchoyoutube) {$anchoyoutube = 70;}
	echo poneryoutub($youtube,$anchoyoutube);
	}

echo "</div>";

// --------------------------------------------------

echo "<div id='check1'";
if (!$check){echo " style='display:none'";}
echo ">";

	//echo " (cuando crees el cuestionario podrás elegir si las opciones irán alineadas a la izquierda o seguidas)";

	$result = $ilink->query("SELECT p,pordefec FROM ".$bolsa."_ WHERE n='$regmodif' AND n1 ORDER BY orden");
	while($fila = $result->fetch_array(MYSQLI_BOTH)) {
		echo "<br><input name='x' type='radio'";
		if($fila[1]) {echo " checked";}
		echo " onclick=\"uncheckRadio(this)\"> $fila[0] ";
	}

echo "</div>";

// --------------------------------------------------

echo "<div id='persiana1'";
if (!$persiana){echo " style='display:none'";}
echo ">";

	echo "<select>";
	$result = $ilink->query("SELECT p,pordefec FROM ".$bolsa."_ WHERE n='$regmodif' AND n1 ORDER BY orden");
	while($fila = $result->fetch_array(MYSQLI_BOTH)) {
		echo "<option";
		if($fila[1]) {echo " selected";}
		echo ">$fila[0]</option>";
	}
	echo "</select>";

echo "</div>";

// --------------------------------------------------

echo "<div id='larga1'";
if (!$larga) {echo " style='display:none'";} 
echo ">";

	echo "<br><textarea class='col-10' rows='5' cols='80' placeholder='vista campo respuesta'></textarea>";

echo "</div>";

// --------------------------------------------------

echo "<div id='ancho-max1'";
if (!$anchomax) {echo " style='display:none'";} 
echo ">";

	$result = $ilink->query("SELECT p,tipo,amin,amax FROM ".$bolsa."_ WHERE n='$regmodif' AND !n1");	
	$fila = $result->fetch_array(MYSQLI_BOTH);
	if($fila['amin'] > 80) {$col = "col-5";} else {$col = "col-2";}
	echo "<input placeholder='vista campo respuesta' class='$col max100' size='";
	echo "' maxlength='".$fila['amax']."'";
	echo ">";

echo "</div>";

// --------------------------------------------------

echo "<p></p>";

// --------------------------------------------------

echo "<div>"; // ------------- div respuesta

echo "Respuesta ";
echo "<select name='input1' onchange=\"formu(form)\">";
echo "<option value='persiana'";
if ($input1 == 'persiana') {echo " selected = 'selected'";}
echo ">Persiana desplegable</option>";
echo "<option value='texto'";
if ($input1 == 'texto') {echo " selected = 'selected'";}
echo ">Texto corto (255 caracteres m&aacute;ximo)</option>";
echo "<option value='check'";
if ($input1 == 'check') {echo " selected = 'selected'";}
echo ">Opciones separadas a elegir</option>";
echo "<option value='longtext'";
if ($input1 == 'longtext') {echo " selected = 'selected'";}
echo ">Recuadro para respuesta larga</option>";
echo "<option value=''";
if (!$input1 AND $regmodif) {echo " selected = 'selected'";}
echo ">Texto separador, no es una pregunta</option>";
echo "</select> ";
echo "<span id='tipo'";
if (!$tipo) {echo " style='display:none'";}
echo ">";
echo " Numérico ";
echo "<input type='checkbox' name='t1check'";
if($t1check == "on") {echo " checked";} 

echo ">";
echo "</span>";

echo " <input class='col-2' type='submit' name='confirm' value='>> Confirmar >>'>";

// --------------------------------------------------

echo "<div id='imagen'";
if (!$imag){echo " style='display:none'";}
echo ">"; 


if($imagen) {
	echo "<div class='peq'><span class='verdecalific'>Imagen opcional</span>: ";
	echo " Alto (70 pixels por defecto) <input class='col-05' type='text' size='3' maxlength='3' name='anchoimag' value='$ancho'> pixels - ";
	echo " Borrar <input type='checkbox' name='borrimag'></div>";
} else {
	echo "<div class='peq'><span class='verdecalific'>Imagen opcional</span>: ";
	echo " <input class='col-3 custom-file-upload' name='upimagen' type='file'>";
	echo "  tamaño (70 pixels por defecto) <input class='col-05' type='text' size='3' maxlength='3' name='anchoimag'></div>";
}

echo "<div class='peq'><span class='verdecalific'>Vídeo opcional</span>: ";
echo "youtube (letras despu&eacute;s de youtube.com/) <input type='text' class='col-1' name='youtube' value='$youtube' size='55' maxlength='255'>";
echo " tamaño (70 pixels por defecto) <input class='col-05' type='text' size='3' maxlength='3' name='anchoyoutube' value='$anchoyoutube'>";
echo "</div>";

echo "</div>";

// --------------------------------------------------

echo "<div id='ancho-max' ";
if (!$anchomax) {echo " style='display:none'";} 
echo ">";
	echo "<div class='peq rojo'>
		&iexcl;Atenci&oacute;n! Si el valor a introducir por el usuario va a ser num&eacute;rico (utilizable
		para estadísiticas, p. ej. su edad) marca <span class='txth'><span class='b'>
		Num&eacute;rico</span>.</div>";	
	echo "Ancho del recuadro de la respuesta <input class='col-05' type='text' name='amin1' size='3' maxlength='3' value='".$amin1."'> &nbsp; \n";
	echo "M&aacute;ximo de caracteres de la respuesta (max. 255) <input class='col-05' type='text' name='amax1' size='3' maxlength='3' value='".$amax1."'>\n";
echo "</div>";

if ($mensaje) {echo " &nbsp; &nbsp; &nbsp; ".$mensaje;}

echo "</div>";  //*** div respuesta

// --------------------------------------------------

echo "<div id='persianacheck'";  // -------------------------------------------------- div que se oculta si no es check o persiana
if (!$lick) {echo " style='display:none'";}
echo ">";

echo "<div class='rojo'><span class='icon-point-right'></span> 
	&iexcl;Atenci&oacute;n! Si los \"Valores\" de la escala van a ser num&eacute;ricos (utilizables
	para estadísiticas, p. ej. likert de 1 a 10) marca <span class='txth'><span class='b'>
	Num&eacute;rico</span>.</div>";
	
$result = $ilink->query("SELECT COUNT(n) FROM ".$bolsa."_ WHERE n='$regmodif'");
if ($regmodif) {$lick = $result->fetch_array(MYSQLI_BOTH);}

$temp = "";
if ($lick[0] >= 2) {
	$temp = " disabled = 'disabled' ";
	echo "<span class='icon-point-right'></span> Si se desea elegir otra escala, antes han de borrarse todos los valores actuales: <a href='?opc=$opc&bolsa=$bolsa&regmodif=".$regmodif."&borr=tod' onclick='return borrar()''>Borrar</a>.";
	echo "<br><span class='icon-point-right'></span> Click en <span class='icon-checkmark verdecalific'></span> o <span class='icon-cross rojo'></span> para indicar si la respuesta es válida o no. Si es irrelevante dejarlo como está.";
	echo "<br><span class='icon-point-right'></span> Click en el guión bajo <span class='verdecalific b'>_</span> para indicar que salga marcada la opción o click en <span class='icon-feed verdecalific'></span> para no marcar";
	echo "<br><span class='icon-point-right'></span> Cambia el orden arrastrando las opciones";
	echo "<div class='both'></div>";
} else {
	 //Escoge el rango de la escala Likert ";
	echo "<select $temp name='lickert'>";
	echo "<option value=''";
	echo "> *** Escoge el rango de la escala Likert o inserta n/valor/feedback*** </option>";
	echo "<option value='5'";
	if ($lickert == "5") {echo " selected = 'selected' ";}
	echo ">Selecci&oacute;n 1 al 5</option>";
	echo "<option value='7'";
	if ($lickert == "7") {echo " selected = 'selected' ";}
	echo ">Selecci&oacute;n 1 al 7</option>";
	echo "<option value='9'";
	if ($lickert == "9") {echo " selected = 'selected' ";}
	echo ">Selecci&oacute;n 1 al 9</option>";
	echo "<option value='10'";
	if ($lickert == "10") {echo " selected = 'selected' ";}
	echo ">Selecci&oacute;n 1 al 10</option>";
	echo "<option value='acuerdo'";
	if ($lickert == "acuerdo") {echo " selected = 'selected' ";}
	echo ">Nivel de acuerdo</option>";
	echo "</select>";
}

$fila="";
if ($editar) {
	$sql = "SELECT * FROM ".$bolsa."_ WHERE n='$regmodif' AND n1='$editar'";
	$result = $ilink->query($sql);
	$fila = $result->fetch_array(MYSQLI_BOTH);
	echo "<input type='hidden' name='editar1' value=\"".$editar."\">";
}

//$anadir = 0;

$sql = "SELECT * FROM ".$bolsa."_ WHERE n='".$regmodif."' AND n1 != '' ORDER BY orden";
$result = $ilink->query($sql);

// --------------------------------------------------

echo "<ul id='sortable'>";

	if ($regmodif AND $result->num_rows > 0) {

		while ($fila = $result->fetch_array(MYSQLI_BOTH)) {
			
			$n1 = $fila['n1'];
			echo "<li id='li_$n1' class='movil contiene'>";
			echo "<div class='col-1 both fl'>";
			echo "<a href='?opc=$opc&bolsa=$bolsa&regmodif=".$regmodif."&borr=".$fila['n1']."' onclick='return borrar()'><span class='icon-bin mr5'></span></a> ";
			echo "<a href='?opc=$opc&bolsa=$bolsa&regmodif=".$regmodif."&editar=".$fila['n1']."'><span class='icon-pencil2 mr5'></span></a> ";
			if ($fila['respcorr']) {
				echo "<a href='?opc=$opc&bolsa=$bolsa&regmodif=$regmodif&incorrecto=".$fila['n1']."'><span class='icon-checkmark verdecalific mr5 b'></span></a>";
			} else {
				echo "<a href='?opc=$opc&bolsa=$bolsa&regmodif=$regmodif&correcto=".$fila['n1']."'><span class='icon-cross rojo mr5'></span></a>";
			}
			if ($fila['pordefec']) {
				echo "<a href='?opc=$opc&bolsa=$bolsa&regmodif=$regmodif&pordefec=no'><span class='icon-feed verdecalific mr5'></span></a>";
			} else {
				echo "<a href='?opc=$opc&bolsa=$bolsa&regmodif=$regmodif&pordefec=".$fila['n1']."'>_</a>";
			}
			echo "</div>";
			if($editar == $fila['n1']) {
				echo "<div class='col-4 fl mr5'><span class='verdecalific peq'>Valor</span>";
				echo "<textarea class='col-10' rows='4' cols='50' name='valor1' placeholder='Añade valor'>".$fila['p']."</textarea>";
				echo "</div>";
				echo "<div class='col-4 fl mr5'><span class='verdecalific peq'>Feedback</span>";
				echo "<textarea class='col-10' rows='4' cols='50' name='feedback1' placeholder='Añade feedback'>".$fila['r']."</textarea>";
				echo "</div>";
				echo "<p></p><input class='col-05' type='submit' name='confirm' value='>>'>";
			} else {
				echo "<div class='col-4 fl'><span class='verdecalific peq'>Valor</span> &nbsp;".$fila['p'];
				echo "</div>";
				echo "<div class='col-4 fl'><span class='verdecalific peq'>Feedback</span> &nbsp;".$fila['r'];
				echo "</div>";
			}
			echo "</li>";
		}

	}

	//para añadir otra opción likert si existe $anadir o editar si $editar
	
	if(!$editar) {

		echo "<li class='contiene'>";
		echo "<div class='col-1 both fl'>&nbsp;";
		echo "</div>";
	
		echo "<div class='col-4 fl mr5'>";
		echo "<textarea class='col-10' rows='4' cols='50' name='valor1' placeholder='Añade valor'></textarea>";
		echo "</div>";
		echo "<div class='col-4 fl mr5'>";
		echo "<textarea class='col-10' rows='4' cols='50' name='feedback1' placeholder='Añade feedback'></textarea>";
		echo "</div>";
		echo "<input type='hidden' name='anadir' value='1'>";
		echo " <input class='col-05' type='submit' name='confirm' value='>>'>";

	}

	echo "<div id='saco'></div>";
	
echo "</ul>";	
	
echo "</form>";

echo "</div>"; // -------------------------------------------------- div que se oculta si no es check o persiana

?>

<script type="text/javascript">

$(document).ready(function(){

	$('#sortable').sortable({
	   axis: 'y',
      opacity: 0.7,
      //handle: '.movil',
      update: function(event, ui) {
   	   var list_sortable = $(this).sortable('toArray').toString();
    		// change order in the database using Ajax
         $.ajax({
           url: 'aux/li_orderlikert.php',
           type: 'POST',
           data: {list_order:list_sortable, n:'<?php echo $regmodif;?>', tabla:'<?php echo $bolsa."_";?>'},
           success: function(data) {
               //finished
               $( "#saco").html( data )
           }
         });
       }
    });	
})
    
</script>

