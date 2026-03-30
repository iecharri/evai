<?php

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

if ($_GET['m']) {
	$_SESSION['tipomens'] = "";
	if($script != "pod") {
		$_SESSION['sql'] = "";
	}
}

if ($_POST['tipomens']) {$_SESSION['tipomens'] = $_POST['tipomens'];}
	
// --------------------------------------------------

$temp = "";

if(!$pcomu) {$pcomu = 1;}
if($_POST['listar']) {$pcomu = 3;}

unset($array);

$array[0] ="<a href='#'>Comunicaciones <span class='icon-arrow-right'></span></a>";
$array[1] = "<a href='#'>1 - Elige el tipo de mail</a>";
if ($script != "pod")  {
	$array[2] = "<a href='#'>2 - Elige los destinatarios</a>";$temp3 = "3 - ";$temp4 = "4 - ";
} else {
	$array[2] = "";
	$temp3 = "2 - ";$temp4 = "3 - ";
}
$array[3] = "<a href='#'>".$temp3." Confirma los destinatarios</a>";
$array[4] = "<a href='#'>".$temp4." Env&iacute;o</a>";

solapah($array,$pcomu+1,"navhsimple");

// --------------------------------------------------

// ------------- pcomu = 1 pedir tipo de mail
paso1($prefijopod,$script,$pest);
if (!$_SESSION['tipomens']) {return;}
// ------------- pcomu = 2 (admin) o 3 (pod) 

// --------------------------------------------------

if ($script == "admin")  {
	$temp = "";
	if($pcomu != 2) {$temp = "style='display:none'";}
	echo "<div class='col-5 fl' $temp>";
	require_once APP_DIR . "/sqlusuarios.php";
	echo "</div>";
	if ($_POST['listar']) {
		$_SESSION['sql'] = $sql;
	}
} else {
	$_POST['listar'] = 1;
}

if (!$_SESSION['sql']) {return;}
$sql = $_SESSION['sql'];

// --------------------------------------------------

?>

<script language="Javascript">
function selecc(envio){
var check;
if (envio.all.checked) {check = 'checked'} else {check = ''}
<?php 
$result = $ilink->query($sql." ORDER BY alumnoa, alumnon");
while ($fila = $result->fetch_array(MYSQLI_BOTH)) {
	echo "envio.usuenv$fila[0].checked = ";?>check<?php echo ";\n";
}
?>
}
</script>

<?php

// --------------------------------------------------

$result = $ilink->query($sql);
$reg = $result->num_rows;
	
if (!$reg) {
	echo "<div class='center mediana rojo'>".i("nodatos",$ilink)."</div>";
	return;
}

// --------------------------------------------------

echo "<form method='post' name='envio' action=?pest=$pest>";
$temp = "";
if($pcomu != 3) {	$temp = "style='display:none'";}
	?>
	<div class='col-5 fl' <?php echo $temp;?>>
	<input type='hidden' name='sql' value="<?php echo $sql;?>">
	<p></p>
	<?php

	$result = $ilink->query($sql." ORDER BY alumnoa, alumnon");
	echo "<input type='checkbox' name='incluirme' checked='checked' class='b'>Incluirme<p></p>";
	echo "<input type='checkbox' name='all' onclick='selecc(envio)'> marcar / desmarcar usuarios<br>";
	while ($fila = $result->fetch_array(MYSQLI_BOTH)) {
		extract($fila);
		echo "<input type='checkbox' name=\"usuenv$fila[0]\" value=\"".$fila[0]."\"";
		if($_POST['usuenv'.$fila[0]] OR $_POST['listar']) {echo " checked='checked'";}
		echo ">";
		$usua = ponerusu($fila[0],1,$ilink);
		echo $usua[1];
		echo "<br>";
	}

	echo "<div class='both'></div><input class='col-4 both' type='submit' name='enviar' value='Continuar'>";
	$pcomu++;
	echo "<input type='hidden' name='pcomu' value='$pcomu'>";
	echo "</div>";

echo "</form>";

// --------------------------------------------------

if (!$_POST['enviar'] AND !$_POST['envimail'] AND !$_POST['enviarnota']) {return;}

if ($_SESSION['tipomens'] == 2 AND $_SESSION['b'][4] == " ") {$tipomens = 2;}

if (($_SESSION['tipomens'] == 1 OR $tipomens == 2) AND $_POST['enviar']) {

	echo "<h3'>MENSAJE(S) A ENVIAR</h3><p></p>";
	echo "<form enctype='multipart/form-data' action='?pest=$pest' name='usu' method='post'>\n";

	$result = $ilink->query($sql." ORDER BY alumnoa, alumnon");
	while ($fila = $result->fetch_array(MYSQLI_BOTH)) {
		if($_POST['usuenv'.$fila[0]] OR $_POST['listar']) {
			echo "<input type='hidden' name=\"usuenv$fila[0]\" value=\"".$fila[0]."\">";
		}
	}

	if (!$tipomens) {

		echo "<span class='b'>Destinatarios</span>:";
		echo "<br><textarea class='col-5' rows='4' cols='40' name='para2'>";
		$result = $ilink->query($sql." ORDER BY alumnoa, alumnon");

		while ($fila = $result->fetch_array(MYSQLI_BOTH)) {
			extract($fila);
			if ($_POST['usuenv'.$fila[0]]) {
			$para .= trim($fila['mail']).",";
			}
		}
		$para = substr($para,0,strlen($para)-1);
		if($_POST['incluirme']) {
			$tambien = "SELECT mail FROM usuarios WHERE id='".$_SESSION['usuid']."'";
			$result = $ilink->query($tambien);
			$fila = $result->fetch_array(MYSQLI_BOTH);
			$para .= ",".$fila[0];
		}
		echo $para;
		echo "</textarea>";
	
	}
	
	echo "<br><span class='b'>".i("asunto",$ilink)."</span>:<br>";
	echo "<input class='col-5' type='text' name='texto1' value=\"$prefijopod ".comidoble($_POST['texto1'])."\"><br>";
	echo "<span class='b'>".i("mensaje",$ilink)."</span>:<br><textarea class='col-5' rows='4' cols='40' name='texto2'>".$_POST['texto2']."</textarea><br>";


	if ($tipomens) {
		echo "#nombre# - ".i("nomusu",$ilink);
		echo "<p></p><input class='col-4' type='submit' name='envimail' value='".i("conti",$ilink)."'>\n";
	} else {
		echo "<span class='b'>".i("fiadju",$ilink)."</span>";
		?><div class="bloque-subida">
  		<label class="boton-subida">
   	 📁 Select
   	 <input type="file" name="adjunto">
 		 </label>
		</div><?php
		echo "<p></p><input class='col-5' type='submit' name='envimail' value='".i("enviar",$ilink)."'>\n";
	}
	echo "<input type='hidden' name='pcomu' value='4'>";
	echo"</form>";

}
	
if ($_POST['envimail'] AND $_SESSION['tipomens'] == 1) {

	$exito = pormailadj($_SESSION['usuid'],$_POST['para2'],trim(nl2br($_POST['texto1'])),trim(nl2br($_POST['texto2'])),1,1,$ilink); 

	if ($exito) {
		$temp = "<br><h3>Env&iacute;o realizado por mail</h3>";
	} else {
		$temp = "<p></p><span class='rojo b'>Error</span>";
	}

	echo "<div class='mediana'>$temp</div>";
}

if ($_SESSION['tipomens'] == 2) {

	require_once APP_DIR . "/soloprof/soloprofmens1.php";

}

// --------------------------------------------------

function paso1($prefijopod,$script,$pest) {
	if($script == "pod") {$pcomu = 3;} else {$pcomu = 2;}
	echo "<form method='post' action='?pest=$pest'>";
	echo "<input type='hidden' name='pcomu' value='$pcomu'>";
	echo "<input type='radio' value='1' name='tipomens' onclick=\"submit()\"";
	if ($_SESSION['tipomens'] == 1) {echo "checked = 'checked'";}
	echo "> Mail &uacute;nico a un grupo de usuarios, no personalizado, con posibilidad de enviar un fichero adjunto<br>";
	echo "<input type='radio' value='2' name='tipomens' onclick=\"submit()\"";
	if ($_SESSION['tipomens'] == 2) {echo "checked = 'checked'";}
	echo "> Mails o mensajes v&iacute;a sms o hsm <span class='b'>personalizados</span>";
	if (!$prefijopod) {echo ", ya sea poniendo el nombre de cada usuario, la nota de un examen (para ello es necesario elegir un tipo de convocatoria en el campo <span class='rojo b'>\"con nota en\"</span> y rellenar los campos de <a href='admin.php?op=1&pest=4'>Textos a enviar</a>), etc.<p></p>";}
	echo "</form>";
	echo "<div class='both'>&nbsp;</div>";
}

?>

