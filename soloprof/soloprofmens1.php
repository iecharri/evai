<script>

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

function enviar(comunic) {
	if (document.comunic.pormail.checked || document.comunic.porsms.checked) {
		return confirm("<?php echo i("envioconfir",$ilink);?>");
	}
}

$(document).ready(function(){
	$("div[class='oscu']").click(function(){
		$('.oscu').hide();
	});
});

</script>

<?php

if (!$_POST['envimail'] AND $tipomens == 2 AND !$_POST['enviarnota']) {return;}

$result = $ilink->query($sql);
$reg = $result->num_rows;//$reg="";
if (!$reg) {
	wintot1('',"<span class='rojo'>".i("nodatos",$ilink)."</span><p></p>",'div2','&nbsp;','',$ilink);
	return;
}

// --------------------------------------------------

$result = $ilink->query("SELECT mail FROM usuarios WHERE id = '".$_SESSION['usuid']."' LIMIT 1");
$temp = $result->fetch_array(MYSQLI_BOTH);
$from1 = minom(1,1,$ilink); $from2 =trim($temp[0]);

if (strpos($_SERVER['PHP_SELF'],"pod.php") == 0)  {

	$conv = $_SESSION['b'][4];
	$iresult = $ilink->query("SELECT * FROM cursasigru WHERE asigna = '$asigna' AND curso = '$curso' AND grupo = '$grupo'");	$texto = $iresult->fetch_array(MYSQLI_BOTH);

	$asuntomail = $texto['notasmail1'];
	$asuntomail = str_replace("#asignatura#",$asigna,$asuntomail);
	$asuntomail = str_replace("#curso#",$curso,$asuntomail);
	$asuntomail = str_replace("#grupo#",$grupo,$asuntomail);
	$asuntomail = str_replace("#convocatoria#",$conv,$asuntomail);

	$textomail = $texto['notasmail2'];
	$textomail = str_replace("#asignatura#",$asigna,$textomail);
	$textomail = str_replace("#curso#",$curso,$textomail);
	$textomail = str_replace("#grupo#",$grupo,$textomail);
	$textomail = str_replace("#convocatoria#",$conv,$textomail);

	$textohsm = $texto['notashsm'];
	$textohsm = str_replace("#asignatura#",$asigna,$textohsm);
	$textohsm = str_replace("#curso#",$curso,$textohsm);
	$textohsm = str_replace("#grupo#",$grupo,$textohsm);
	$textohsm = str_replace("#convocatoria#",$conv,$textohsm);

	$textosms = $texto['notassms'];
	$textosms = str_replace("#asignatura#",$asigna,$textosms);
	$textosms = str_replace("#curso#",$curso,$textosms);
	$textosms = str_replace("#grupo#",$grupo,$textosms);
	$textosms = str_replace("#convocatoria#",$conv,$textosms);

	$formula = formula($asigna,$curso,$grupo,$ilink);
	$test1 = $formula[0]; $preg1 = $formula[1]; $prac1 = $formula[2]; $eval1 = $formula[3];
	if ($conv != "_") {$conv .= "_";} else {$conv = "";}

}

if ($_POST['texto1'] OR $_POST['texto2']) {
	$asuntomail = $_POST['prefijopod'].nl2br($_POST['texto1']);
	$textomail = nl2br($_POST['texto2']);
	$textohsm = nl2br($_POST['texto2']);
	$textosms = nl2br($_POST['texto2']);
}

?>

<p></p>

<form name='comunic' method='post' action='?pest=<?php echo $pest;?>' onsubmit="return enviar(comunic)">

<table class='conhover'>

<tr>
<th>

<?php echo i("envimens",$ilink);?></th>
<th>Mail: <input type='checkbox' name='pormail' <?php if (!$_POST['enviarnota']) {echo "checked='checked'";}?>></th>
<th>HSM: <input type='checkbox' name='porhsm'></th>
<th>SMS: <input type='checkbox' name='porsms' disabled='disabled'></th>
<?php

	echo "<input type='hidden' name='sql' value=\"$sql\">";
	$result = $ilink->query($sql." ORDER BY alumnoa, alumnon");
	while ($fila = $result->fetch_array(MYSQLI_BOTH)) {
		if($_POST['usuenv'.$fila[0]] OR $_POST['listar']) {
			echo "<input type='hidden' name=\"usuenv$fila[0]\" value=\"".$fila[0]."\">";
		}
	}

if (!$_POST['enviarnota']) {
	echo "<th><input type='hidden' name='texto1' value=\"".comidoble($_POST['texto1'])."\">";
	echo "<input type=hidden name='texto2' value=\"".comidoble($_POST['texto2'])."\">";
	echo "<span class='b'>";
	echo i("enviar",$ilink);
	echo " <input type='submit' value='>>>>' name='enviarnota'></span></th>";
} else {
	echo "<th></th>";
}
?>
</tr>

<?php

$result = $ilink->query($sql." ORDER BY alumnoa, alumnon");
$n = 0;$conta = 0;$smsmens = array();
while ($fila = $result->fetch_array(MYSQLI_BOTH)) {

	if (!$_POST['usuenv'.$fila[0]]) {continue;}

	extract($fila);

	if ($fila[$conv.'aprobado'] == 2) {
		$mensaje = ": ".i("suspensodesc",$ilink);
		$fila[$conv.'total'] = "";
	} else {
		if ($fila[$conv.'total'] < 5) {$mensaje = " ".i("suspenso",$ilink);}
		if ($fila[$conv.'total'] >= 5 AND $fila[$conv.'total'] < 7) {$mensaje = " ".i("aprobado",$ilink);}
		if ($fila[$conv.'total'] >= 7 AND $fila[$conv.'total'] < 9) {$mensaje = " ".i("notable",$ilink);}
		if ($fila[$conv.'total'] >= 9) {$mensaje = " ".i("sobresaliente",$ilink);}
		$fila[$conv.'total'] = number_format($fila[$conv.'total'],2,',','.');
	}
	$fila[$conv.'total'] .= $mensaje;

	$asuntomailx = str_replace("#nombre#",$alumnon,$asuntomail);
	$asuntomailx = str_replace("#apellidos#",$alumnoa,$asuntomailx);
	$asuntomailx = str_replace("#test#",number_format(($fila[$conv.'test']*$test1),2,',','.'),$asuntomailx);
	$asuntomailx = str_replace("#preguntas#",number_format(($fila[$conv.'preg']*$preg1),2,',','.'),$asuntomailx);
	$asuntomailx = str_replace("#practicas#",number_format(($fila[$conv.'prac']*$prac1),2,',','.'),$asuntomailx);
	$asuntomailx = str_replace("#evaluacion#",number_format(($fila[$conv.'eval']*$eval1),2,',','.'),$asuntomailx);
	$asuntomailx = str_replace("#total#",$fila[$conv.'total'],$asuntomailx);

	$textomailx = str_replace("#nombre#",$alumnon,$textomail);
	$textomailx = str_replace("#apellidos#",$alumnoa,$textomailx);
	$textomailx = str_replace("#test#",number_format(($fila[$conv.'test']*$test1),2,',','.'),$textomailx);
	$textomailx = str_replace("#preguntas#",number_format(($fila[$conv.'preg']*$preg1),2,',','.'),$textomailx);
	$textomailx = str_replace("#practicas#",number_format(($fila[$conv.'prac']*$prac1),2,',','.'),$textomailx);
	$textomailx = str_replace("#evaluacion#",number_format(($fila[$conv.'eval']*$eval1),2,',','.'),$textomailx);
	$textomailx = str_replace("#total#",$fila[$conv.'total'],$textomailx);

	$textohsmx = str_replace("#nombre#",$alumnon,$textohsm);
	$textohsmx = str_replace("#apellidos#",$alumnoa,$textohsmx);
	$textohsmx = str_replace("#test#",number_format(($fila[$conv.'test']*$test1),2,',','.'),$textohsmx);
	$textohsmx = str_replace("#preguntas#",number_format(($fila[$conv.'preg']*$preg1),2,',','.'),$textohsmx);
	$textohsmx = str_replace("#practicas#",number_format(($fila[$conv.'prac']*$prac1),2,',','.'),$textohsmx);
	$textohsmx = str_replace("#evaluacion#",number_format(($fila[$conv.'eval']*$eval1),2,',','.'),$textohsmx);
	$textohsmx = str_replace("#total#",$fila[$conv.'total'],$textohsmx);

	if ($fila['tfmovil'] > 0) {
		$textosmsx = str_replace("#nombre#",$alumnon,$textosms);
		$textosmsx = str_replace("#apellidos#",$alumnoa,$textosmsx);
		$textosmsx = str_replace("#test#",number_format(($fila[$conv.'test']*$test1),2,',','.'),$textosmsx);
		$textosmsx = str_replace("#preguntas#",number_format(($fila[$conv.'preg']*$preg1),2,',','.'),$textosmsx);
		$textosmsx = str_replace("#practicas#",number_format(($fila[$conv.'prac']*$prac1),2,',','.'),$textosmsx);
		$textosmsx = str_replace("#evaluacion#",number_format(($fila[$conv.'eval']*$eval1),2,',','.'),$textosmsx);
		$textosmsx = str_replace("#total#",$fila[$conv.'total'],$textosmsx);
		$tf = encoded($fila['tfmovil']);
		$smsmens[$conta][0] = $tf;
		$smsmens[$conta][1] = $textosmsx.". Servicio de Human Site";
		$conta = $conta+1;
	}

	echo "<tr>";
	echo "<td>";
	$usua = ponerusu($fila[0],1,$ilink);
	echo $usua[1];
	echo "</td>";
	echo "<td>";
	if ($asuntomailx) {echo "<span class=b>".i("asunto",$ilink)."</span>: $asuntomailx";}
	if ($textomailx) {echo "<br><span class=b>".i("mensaje",$ilink)."</span>: $textomailx";}
	if ($_POST['pormail'] AND $_POST['usuenv'.$fila[0]]) {
		$to = trim($fila['alumnon'])." ".trim($fila['alumnoa'])." <".$fila['mail'].">";
		if ($asuntomailx OR $textomailx) {
			$exito = pormail($_SESSION['usuid'],$fila[0],trim(nl2br($asuntomailx)),trim(nl2br($textomailx)),trim($textomailx),$ilink);
			if ($exito) {
				echo "<br><h3>Env&iacute;o realizado por mail</h3>";
			} else {
				echo "<p></p><span class='rojo b'>Error</span>";
			}
		}
	}
	echo "</td>";
	echo "<td>$textohsmx";
	if ($_POST['porhsm']) {
		$textohsmx = str_replace("<br>", "", $textohsmx);
		if (porhsm($textohsmx,$fila[0],1,$ilink)) {echo "<br><span class='txth'>".i("mesenvihsm",$ilink)."</span>";}
	}
	echo "</td>";
	echo "<td>$textosmsx";
	echo "</td>";
	echo "<td>";
	if ($fila[0] != $_SESSION['usuid']) {
		echo "<a href='../ficha.php?usuid=$fila[0]&op=8' target='_blank'>".i("histoenvi",$ilink)."</a>";
	}
	echo "</td>";

	echo "</tr>";
}

if ($smsmens) {$smsmens = urlencode(serialize($smsmens));}
echo "<input type='hidden' name='smsmens' value=\"$smsmens\">";

?>

</table>

</form>