<?php

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

if ($_GET['m']) {$_SESSION['sql'] = "";}

// --------------------------------------------------

unset($array);
$array[0] = "<a href='#'>Simple mail <span class='icon-arrow-right'></span></a>";
solapah($array,1,"navhsimple");

// --------------------------------------------------

echo "<form method='post'>";
echo "<select name='aquien'>";
echo "<option value=''>Env&iacute;o de mails a... </option>";
echo "<option value='a'";
if ($aquien == "a") {echo " selected='selected'";}
echo ">alumnos</option>";
echo "<option value='p'";
if ($aquien == "p") {echo " selected='selected'";}
echo ">profesores</option>";
echo "</select>";
echo " <input class='col-1' type='submit' name='subm1' value= ' >> '>";
echo "</form>";

// --------------------------------------------------

if ($aquien == "p") {
	$sql = "SELECT DISTINCT usuarios.id, mail FROM asignatprof LEFT JOIN podcursoasignatit
		ON asignatprof.asigna = podcursoasignatit.asigna AND asignatprof.curso = podcursoasignatit.curso
		LEFT JOIN usuarios ON asignatprof.usuid = usuarios.id
		WHERE autorizado > 1 AND fechabaja = '0000-00-00 00:00:00' AND podcursoasignatit.tit = '$tit'
		AND asignatprof.curso = '$curso' AND usuarios.id > 0 ORDER BY alumnoa, alumnon";
}
if ($aquien == "a") {
	$sql = "SELECT DISTINCT usuarios.id, mail FROM alumasiano LEFT JOIN podcursoasignatit
		ON alumasiano.asigna = podcursoasignatit.asigna AND alumasiano.curso = podcursoasignatit.curso
		LEFT JOIN usuarios ON alumasiano.id = usuarios.id
		WHERE auto > 1 AND autorizado > 1 AND fechabaja = '0000-00-00 00:00:00'
		AND podcursoasignatit.tit = '$tit' AND alumasiano.curso = '$curso' ORDER BY alumnoa, alumnon";
}

// --------------------------------------------------
	
if (!$sql) {echo "<p></p><br>";return;}

$result = $ilink->query($sql);

$reg = $result->num_rows;

if (!$reg) {
	wintot1('',i("nodatos",$ilink)."<p></p>","div2","<span class='mediana rojo icon-warning'></span>",'',$ilink);
	return;
}

// --------------------------------------------------

?>

<script language="Javascript">
function selecc(envio){
var check;
if (envio.all.checked) {check = 'checked'} else {check = ''}

<?php
while ($fila = $result->fetch_array(MYSQLI_BOTH)) {
	echo "envio.usuenv$fila[0].checked = ";?>check<?php echo ";\n";
}
?>

}
</script>

<?php

// --------------------------------------------------

if ($_POST['envimail']) {
	$exito = pormailadj($_SESSION['usuid'],$_POST['para2'],trim(nl2br($_POST['texto1'])),trim(nl2br($_POST['texto2'])),1,1,$ilink);
	if ($exito) { 
		$temp = "<span class='txth'>Env&iacute;o realizado por mail</span>";
		wintot1('',"<p class='center'><span class='mediana verdecalific icon-checkmark'></span> $temp</p>","div2","",'',$ilink);
	} else {
		$temp = "<p></p><span class='rojo b'>Error</span>";
		wintot1('',$temp."<p></p>","div2","<span class='mediana rojo icon-warning'></span>",'',$ilink);
	}
	return;
}
// --------------------------------------------------

if ($_POST['subm2']) {

	winop("MENSAJE A ENVIAR","div1",0);
		
	echo "<form enctype='multipart/form-data' name='usu' method='post'>\n";

	$result = $ilink->query($sql);
	while ($fila = $result->fetch_array(MYSQLI_BOTH)) {
		if($_POST['usuenv'.$fila[0]] OR $_POST['listar']) {
			echo "<input type='hidden' name=\"usuenv$fila[0]\" value=\"".$fila[0]."\">";
		}
	}
	echo "<span class='b'>Destinatarios</span>:";
	echo "<br><textarea class='col-10' rows='4' cols='40' name='para2'>";

	$result = $ilink->query($sql);
	while ($fila = $result->fetch_array(MYSQLI_BOTH)) {
		extract($fila);
		if ($_POST['usuenv'.$fila[0]]) {
			$para .= trim($fila['mail']).",";
		}
	}
	$para = substr($para,0,strlen($para)-1);
	echo $para;
	echo "</textarea>";
	
	//****
	$texto1 = htmlspecialchars($_POST['texto1'] ?? '', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
	
	echo "<br><span class='b'>".i("asunto",$ilink)."</span>:<br><input class='col-10' type='text' name='texto1' value=\"$prefijopod ".$texto1."\">
	<br><span class='b'>".i("mensaje",$ilink)."</span>:<br><textarea rows='4' cols='40' name='texto2'>".$_POST['texto2']."</textarea><br>";

	echo "<span class='b'>".i("fiadju",$ilink)."</span>"."<br>";
		?><div class="bloque-subida">
  		<label class="boton-subida">
   	 📁 Select
   	 <input type="file" name="adjunto">
 		 </label>
		</div><?php
	//echo " <input class='col-5' type='file' name='adjunto' class='col-3'>";
	
	echo "<input type='hidden' name='aquien' value='$aquien'>";
	echo " <input class='col-2' type='submit' name='envimail' value='".i("enviar",$ilink)."'>\n";

	echo"</form>";
	
	echo "</div>";
	echo "</div>";

}

// --------------------------------------------------

echo "<form method='post' name='envio'>";
	?>
	<p></p><div class='di wid35'>
	<span class='b verdecalific'>Confirma los destinatarios</span>
	<p></p>
	<?php
	echo "<div class='col-5' style='height:300px;overflow:auto'>";
	echo "<input type='checkbox' name='all' onclick='selecc(envio)'> marcar / desmarcar usuarios<br>";
	$result = $ilink->query($sql);
	while ($fila = $result->fetch_array(MYSQLI_BOTH)) {
		extract($fila);
		echo "<input type='checkbox' name=\"usuenv$fila[0]\" value=\"".$fila[0]."\"";
		if($_POST['usuenv'.$fila[0]] OR $_POST['subm1']) {echo " checked='checked'";}
		echo ">";
		$usua = ponerusu($fila['id'],1,$ilink);
		echo $usua[1];
		echo "<br>";
	}
	echo "</div>";
	echo "<input type='hidden' name='aquien' value='$aquien'>";
	echo "<p></p><input class='col-2' type='submit' name='subm2' value='Continuar'>";
	echo "</div>";
echo "</form>";

?>

