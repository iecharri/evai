<?php

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

if ($_SESSION['auto'] < 5) {exit;}

if($_SESSION['auto'] < 10) {$opc = 4;}

require_once APP_DIR . '/cuest/aux/comporta_cuest.php';

if (isset($_POST['comporta1']) && $_POST['comporta1'] == '1') {
	comporta1($comporta,$ilink);
	unset($comporta);
}
	
if ($comporta) {
	winop("",'div1','');
	comporta($comporta,$ilink);
	echo "</div></div>";	
}


$filtro = "LIKE '$bolsa"."_%1'";
if($opc == '8' AND !$bolsa) {$filtro = "LIKE '%1'";}
$result = $ilink->query("SHOW TABLES FROM ".DB2." $filtro");

if (!$result->num_rows AND !$nuevo) {
	//echo "<p></p><div class='colu'>No se ha creado ning&uacute;n Cuestionario.";
	//if($bolsa) {
	//	echo " Click en <a href='?opc=$opc&bolsa=$bolsa&nuevo=1'>Nuevo Cuestionario</a>";
	//}
	//echo "</div>";
	//return;
}

if($bolsa != $cuestppal) { //"cuestionario"
	echo "<span class='rojo'>Recuerda</span> desactivar los cuestionarios que no quieras que estén a la vista de los Alumnos.";
	echo " Para evitar que Alumnos que no deban vean Cuestionarios, configura <a href='../soloprof/admin.php?op=1' target='_blank'>alta libre</a> en <span class='b'>NO</span>.<br>";
	echo "Si en un Cuestionario se desmarca <span class='b'>Activo</span>, no lo verá NADIE.";
	echo "<br>Si se marca <span class='b'>Activo</span> en los que no son independientes, quién lo verá dependerá de lo que se ponga en \"Solo Curso\":<br>";
	echo "- si está vacío, lo verá cualquiera que pertenezca a esa Asignatura (independientemente de su <span class='b'>Curso</span> y <span class='b'>Grupo</span>).<br>";
	echo "- si se pone un Curso (por ejemplo 2017), solo lo verán los que pertenezcan a esa Asignatura y 2017.<br>";
	echo "La columna <span class='b'>\"Solo Curso\"</span> es irrelevante para los cuestionarios Independientes.<br>";
	echo "<a href='#' onclick=\"amplred('help')\" class='verdecalific'>AYUDA</a>";
	echo "<div id='help' style='display:none'><li>Si no es independiente ni hay fórmula de evaluación, no se guardarán las respuestas y podrán realizarlo las veces que deseen.</li>";
	echo "<li>(*) Si se marca esta opción: se mostrará a cada alumno la evaluación que ha respondido, junto con las respuestas correctas, tal como las ve el profesor. Se utiliza cuando el profesor da por terminado el tiempo de realización del cuestionario. No es posible contestar más cuestionarios y se le presenta al alumno sus resultados. A quien no ha hecho el cuestionario le sale el mensaje: Formulario no respondido. Formulario no activo.</li>";
	echo "<li> Fórmula (A: número de Aciertos, E: número de Errores) por ejempo: A - (E / 2) </li></div>";
}

echo "<table class='conhover'>";

	echo "<tr>";
		echo "<th>";
		if($bolsa) {echo "<a href='?opc=$opc&bolsa=$bolsa&nuevo=1'>Nuevo</a>";}
		echo "</th>
		<th class='col-01'>Likert alineados</th><th class='col-01'>Likert A) B)...</th><th class='col-01'>Numerar</th>
		<th class='col-01'>Activo</th>
		<th class='col-01'>Solo Curso</th>
		<th class='col-01'>Indepte.</th>
		<th class='col-01'>Fórmula evaluación</th>
		<th class='col-01'>Evaluar</th>
		<th class='col-01' title='Mostrar a cada alumno la evaluación que ha respondido, junto con las respuestas correctas, tal como las ve el profesor. 
			Se utiliza cuando el profesor da por terminado el tiempo de realización del cuestionario. No es posible contestar más cuestionarios y se le presenta 
			al alumno sus resultados. A quien no ha hecho el cuestionario le sale el mensaje: Formulario no respondido. Formulario no activo.'>
			Se muestran respuestas correctas<br>(*)</th>
		<th class='col-01' title='Pasado este tiempo, se envía el cuestionario al sistema automáticamente con las respuestas dadas hasta ese momento.' nowrap>Tiempo<br>(mn)</th>
		<th class='col-01'>Respondidos</th>
		<th class='col-01'>&Uacute;ltima inserci&oacute;n<br><span class='peq b'>Remarcado &uacute;ltimas dos semanas</span></th>
		<th class='col-01'>Cambiar nombre</th>
		<th class='col-01'>Copiar a</th>
		<th class='col-01'>Borrar cuestionario<br>y respuestas</th></tr>";

// --------------------------------------------------

	if($bolsa) {
		echo "<tr><td colspan='15'><a href='?opc=1&opc1=1&bolsa=$bolsa'>Bolsa de Preguntas</a></td></tr>";
	}
	
	if($nuevo) {
		echo "<tr><td colspan='15'>";
		echo "<form method='post'>";
		echo "<input class='col-1' type='text' name='nuevocuest' size='10' maxlength='10'>";
		echo " <input class='col-2em' type='submit' value=' >> '></form>";
		echo "</td>";
		//echo str_repeat("<td></td>",14);
	}

// --------------------------------------------------

	while ($cuests = $result->fetch_array(MYSQLI_BOTH)) {

		//if(!$_GET['bolsa'] AND $_GET['bolsa'] == $cuestppal) {continue;}   //substr($cuests[0],0,13) == "cuestionario_"

	  	$ev = substr($cuests[0],0,-1);

  		if($opc == 8) {
  			$bolsa_cuest = separa($ev,$ilink);
  			$bolsa = $bolsa_cuest[0];
  		}

// --------------------------------------------------

		$visible=$indep=$guard=$visialuresp=$mn=$resp=$ulti=$formula=$sinnum=$alfabet=$ordenadas=$esindep=$colorformu=$colorrespu=$haypregs=$evaluar=$soloano="";

		//1
		//2 formu
		//3 indep
		//4 mn
		//5 respu
		//6 numerar
		//7 alfabet
		//8 ordenad
		//9 url
		//10
		
		$tab = $ev."1";
		
		$sql = "SELECT * FROM $tab WHERE n!='0'";
		$result1 = $ilink->query($sql);

		if($result1->num_rows) {

			$haypregs = 1;
			
			$sql = "SELECT * FROM $tab WHERE !n";
			$result1 = $ilink->query($sql);
			$fila = $result1->fetch_array(MYSQLI_BOTH);
			
			$sinnum = ($fila['sinnum'] == '0') ? "<span class='icon-checkmark verdecalific'></span>" : "";			

			$alfabet = ($fila['alfabet'] == '1') ? "<span class='icon-checkmark verdecalific'></span>" : "";

			$ordenadas = ($fila['ordenadas'] == '1') ? "<span class='icon-checkmark verdecalific'></span>" : "";
			
			$mn = ($fila['mn'] == '0') ? '' : $fila['mn'];

			$soloa = ($fila['visible'] == '1' && $fila['soloano'] != '0') ? $fila['soloano'] : "";


			$formula = ($fila['guardar'] == '1') ? $fila['formula'] : "";
  
			$visialuresp = ($fila['visialuresp'] == '1') ? "<span class='icon-checkmark verdecalific'></span>" : ""; 
 
			$visible = ($fila['visible'] == '1') ? "<span class='icon-checkmark verdecalific'></span>" : ""; 

			$indep = ($fila['guardar'] == '2') ? "<span class='icon-checkmark verdecalific'></span>" : ""; 

			$evaluar = ($fila['guardar'] == '1') ? "<span class='icon-checkmark verdecalific'></span>" : "";

			$sql = "SELECT max(cu) FROM $ev"."2";
			$result2 = $ilink->query($sql);
			$fila2 = $result2->fetch_array(MYSQLI_BOTH);
			$resp = $fila2[0];
			$ulti = "SELECT max(datetime) FROM $ev"."2";
			$result2 = $ilink->query($ulti);
			$fila2 = $result2->fetch_array(MYSQLI_BOTH);
			$ulti = $fila2[0];
			$cla = "";
			if ($ulti AND $ulti != "0000-00-00 00:00:00") {
				$ulti14 = gmdate("Y-m-d", strtotime("$ulti +14 day"));
				if ($ulti14 > gmdate("Y-m-d")." 00:00:00") {$cla = "b";}
			} 
			$ulti = explode(" ",$ulti);
			$fecha = explode("-",$ulti[0]);
			$ulti = "<span class='peq nowrap $cla'>".$fecha[2]."-".$fecha[1]."-".$fecha[0]." ".$ulti[1]."</span>";

		}

// --------------------------------------------------
		
		echo "<tr>";

			echo "<td class='nowrap'><a href='?comporta=$tab' class='fr b'>[edit]</a>";
	
// --------------------------------------------------

			if($haypregs) {
				echo " <a href='?opc=6&cuest=$ev'><span class='icon-eye verdecalific' title='Probar sin guardar'></span></a> &nbsp;";
			} else {
				echo " <span class='icon-eye nob'></span> &nbsp;";
			}

			if($resp) {
				echo "<span class='icon-plus nob'></span> &nbsp;";
			} else {
				echo "<a href='?opc=3&cuest=$ev' title='Añadir preguntas de la bolsa'><span class='icon-plus verdecalific'></span></a> &nbsp;";
			}

			if($resp OR !$haypregs) {
				echo "<span class='icon-pencil2 nob'></span> &nbsp;";
			} else {
				echo "<a href='?opc=5&cuest=$ev' title='Modificar Cuestionario'><span class='icon-pencil2 verdecalific'></span></a> &nbsp;";
			}

			if(!$_GET['bolsa'] AND $_SESSION['auto'] == 10) {
				//echo "<a href='?opc=$opc&bolsa=$bolsa'>$ev</a>";
			} else {
				//echo $ev;
			}
			echo $ev;
			echo "<div id='$ev"."_9'>";
			if($haypregs AND $indep) {
				echo "<span title='&Eacute;sta es la url de la p&aacute;gina del Cuestionario a enviar a quien desees que lo responda' class='peq'>
					" . DOMINIO .APP_URL. "/usu_eval.php?cuest=$ev</span>";
			}
			echo "</div>";
			
// --------------------------------------------------
		
			echo "</td>";

			if(!$haypregs) {
				echo str_repeat("<td></td>",9);
			} else {
				echo "<td id='".$ev."_8' class='center'>$ordenadas</td>";
				echo "<td id='".$ev."_7' class='center'>$alfabet</td>";
				echo "<td id='".$ev."_6' class='center'>$sinnum</td>";
				//if($bolsa == "cuestionario") {
					//echo "<td class='center'>";
					/*if($cuestppal == $ev) {			
						echo "<a href='?opc=$opc&noppal=1&bolsa=cuestionario' title='Click para quitar este Cuestionario de la página de inicio'><span class='icon-checkmark verdecalific'></span></a>";
					} else {
						echo "<a href='?opc=$opc&ppal=$ev&bolsa=cuestionario' title='Click para mostrar este Cuestionario en la página de inicio'>_</a>";
					}*/
					//echo "</td>";
				//} else {
					echo "<td id='".$ev."_1' class='center'>$visible</td>";
				//}
				
				if($tab == $atencioncuestppal."1") {		
					echo "<td colspan=6>Cuestionario de la página de inicio</td>";		
				} else {		
					echo "<td id='".$ev."_11' class='center'>";
						echo "<div id='so_$ev' class='peq so center nowrap'>$soloa</div>";					
					echo "</td>";
					echo "<td id='".$ev."_3' class='center'>$indep<br></td>";
					echo "<td id='".$ev."_2' class='center'>";
						echo "<div id='fo_$ev' class='peq fo center nowrap'>$formula</div>";
					echo "</td>";
					echo "<td id='".$ev."_10' class='center'>";
						echo "<div id='eva_$ev' class='center peq'>$evaluar</div>";
					echo "</td>";
					echo "<td id='".$ev."_5' class='center'>";
						echo "<div id='res_$ev'>$visialuresp</div>";
					echo "</td>";
					echo "<td id='".$ev."_4' class='center'>";
						echo "<div id='mn_$ev' class='peq mn center'>$mn</div>";
					echo "</td>";
					if($esindep) {?>
						<script type="text/javascript">
						hide('res_<?php echo $ev;?>');hide('mn_<?php echo $ev;?>');hide('fo_<?php echo $ev;?>');hide('eva_<?php echo $ev;?>');
						</script>
					<?php }
					/*if($formu == "_") {?>
						<script type="text/javascript">
						hide('res_<?php echo $ev;?>');hide('eva_<?php echo $ev;?>');hide('mn_<?php echo $ev;?>');
						</script>
					<?php }*/
				}
			}

			echo "<td class='center'>";
			if($resp) {
				echo "<a href='?opc=7&cuest=$ev'>$resp</a>";
			}
			echo "</td>";
			echo "<td class='center'>$ulti</td>";
			
			echo "<td class='center'>";
			if($bolsa != "cuestionario") {
				if ($camb == $ev) {
					echo "<form method='post'>";
					echo "<span class='peq'>$bolsa"."_<span><input type='text' name='camb11' size='10' maxlength='10'>";
					echo "<input type='hidden' name='camb10' value='$ev'>";
					echo "<input type='submit' value=' >> '></form>";
				} else {
					$temp = "";
					if($opc == 4) {$temp = "bolsa=$bolsa";}
					echo "<a href='?opc=$opc&bolsa=$bolsa&camb=$ev&$temp'>_</a>";
				}
			}
			echo "</td>";
			echo "<td class='center'>";
				if ($copi == $ev) {
					echo "<form method='post'>";
					echo "<span class='peq'>$bolsa"."_</span><input type='text' name='copi11' size='10' maxlength='10'>";
					echo "<input type='hidden' name='copi10' value='$ev'>";
					echo "<input type='submit' value=' >> '></form>";
				} else {
					echo "<a href='?opc=$opc&bolsa=$bolsa&copi=$ev&$temp'>_</a>";
				}
			echo "</td>";
			echo "<td class='center'>";
			if($bolsa != "cuestionario") {
				echo "<a href='?opc=$opc&borr=$ev' onclick=\"return borrar()\">_</a>";
			}
			echo "</td>";
		
		echo "</tr>";

	}

echo "</table>";

// --------------------------------------------------

?>

<script type="text/javascript">

	$('.mn').click(function(){
		var field = $(this);
		var parent = field.attr('id');
		document.getElementById(parent).contentEditable='true';
      document.getElementById(parent).className = 'peq rojo whit';
	});
	
	$('.mn').blur(function(){
        var field = $(this);
        var parent = field.attr('id');
        var id = parent.substring(3);
        var mn = document.getElementById(parent).innerText; 
         $.post("aux/mn.php", {tabla:id, mn:mn},
			 function(htmlexterno){
				$( "#" + parent).html(htmlexterno);
	     },
		  "html")
	});

	$('.fo').click(function(){
		var field = $(this);
		var parent = field.attr('id');
		document.getElementById(parent).contentEditable='true';
      document.getElementById(parent).className = 'peq rojo whit';
      var cont = document.getElementById(parent).innerText;
	});
	
	$('.fo').blur(function(){
        var field = $(this);
        var parent = field.attr('id');
        var id = parent.substring(3);
        var formu = document.getElementById(parent).innerText; 
         $.post("aux/formula.php", {tabla:id, formu:formu},
			 function(htmlexterno){
				$( "#" + parent).html(htmlexterno);
	     },
		  "html")
	});

	$('.so').click(function(){
		var field = $(this);
		var parent = field.attr('id');
		document.getElementById(parent).contentEditable='true';
      document.getElementById(parent).className = 'peq rojo whit';
      var cont = document.getElementById(parent).innerText;
	});
	
	$('.so').blur(function(){
        var field = $(this);
        var parent = field.attr('id');
        var id = parent.substring(3);
        var soloano = document.getElementById(parent).innerText; 
         $.post("aux/soloano.php", {tabla:id, soloano:soloano},
			 function(htmlexterno){
				$( "#" + parent).html(htmlexterno);
	     },
		  "html")
	});
	
function nob(celda) {
	document.getElementById(celda).style.visibility = 'hidden';
}

function quitanob(celda) {
	document.getElementById(celda).style.visibility = 'visible';
}

</script>
