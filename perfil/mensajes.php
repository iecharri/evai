<?php

require_once __DIR__ . "/../siempre_base.php";

extract($_GET);
extract($_POST);

$yo = $_SESSION['usuid'];
if (!$usuid) {$usuid = $yo;}

?>

<script type="text/javascript">
function jcontrolhsm(){
  	$("#jcontrolhsm").load("perfil/jcontrolhsm.php?usuid=<?php echo $usuid;?>");
}
setInterval( "jcontrolhsm()", 5000 );
</script>

<?php

if ($histo) {
	$usu = ponerusu($usuid,1,$ilink);
	echo $usu[0];
	echo $usu[1];
	require_once APP_DIR . '/perfil/messhisto.php';	
	return;
}

if ($histot) {
	require_once APP_DIR . '/perfil/messhistotodos.php';	
	return;
}

if ($usuid == $yo) {
	
	if($us == "m") {
		if($lee) {
			$sql = "UPDATE message SET isread = '1' WHERE parausuid = '$yo' AND (message LIKE 'Nuevo mensaje en el foro%' OR message LIKE 'Este es un mensaje automático.%')";
			$ilink->query($sql);
		}
		echo "<a href='?usuid=$usuid&histot=1'><span class='icon-history' title=\"".i("histo",$ilink)."\"></span></a>";
		echo " &nbsp; Para dar por leídos todos los mensajes automáticos de Foros y Grupos... <a href='?us=m&lee=1'>CLICK</a>";
		echo "<p></p>";
	}
	
	$ilink->query("UPDATE message SET isread = 1 WHERE parausuid = '$yo' AND usuid= '$yo'");
	$ilink->query("UPDATE message SET aviso = 1 WHERE parausuid = '$yo'");

	$confoto = 1;
	require_once APP_DIR . '/perfil/ultimens.php';
	
	?>
 	<script language="JavaScript">
		document.getElementById('mensajes').scrollTop = 1000000;
	</script>
	
	<?php

} else {

// --------------------------------------------------

	$ilink->query("UPDATE message SET isread = 1, aviso = 1 WHERE parausuid = '$yo' AND usuid= '$usuid'");
	$usu = ponerusu($usuid,1,$ilink);
	echo $usu[0];
	echo $usu[1]." <span class='estoy peq u'>$usu[2]</span>";
	echo " &nbsp; &nbsp; <a href= '?usuid=$usuid&mens=1&histo=1&op=4'><span class='icon-history' title=\"".i("histo",$ilink)."\"></span></a>"; 
}

?>

<div id="jcontrolhsm">
<script language="javascript">
jcontrolhsm();
</script></div>

<?php

if ($usuid == $yo) {return;}

echo "<div id='mensajes'>";
require_once APP_DIR . '/perfil/ultimens.php';
echo "</div>";

?>
<script languaje='javascript'>
 		document.getElementById('mensajes').scrollTop = 1000000;
	</script>
	
<?php	

$sql = "SELECT fechabaja FROM usuarios WHERE id = '$usuid' LIMIT 1";
$iresult = $ilink->query($sql);
$fila = $iresult->fetch_array(MYSQLI_BOTH);
if ($fila[0] != "0000-00-00 00:00:00") {return;} //Es borrado

//poner el div de formulario para mandar mensajes, ficheros...

?>

<script>
function send(form1) {

	if (form1.message.value == "" && form1.file.value == "")
	{
		return false;
	}
	hide('iconos');hide('envi');show('esperar');
}
</script>

<iframe  name="iframeUpload" style='display:none'>
</iframe>

<div class='col-10'>

	<form enctype='multipart/form-data' action = '<?php echo APP_URL;?>/perfil/postform.php' name='form1' id='form1' method='post' target='iframeUpload' onsubmit="send(form1)">

	<?php
	echo "<input type='hidden' name='usuid' value='$usuid'>";
		
	?><div class="bloque-subida">
  		<label class="boton-subida">
   	 📁 Select File
   	 <input type="file" id='file' name='file'>
 		 </label>
 	  <?php
		
	echo "<a onclick=\"amplred('iconos');\"><span class='icon-smile'></span></a> ";

	echo "
	<input type='text' x-webkit-speech='' name='message' autofocus id='message' class='col-6' maxlength='255' tabindex='1'>
	<button type='submit' style='border:0;padding-top:.3em' tabindex='2'><span class='icon-circle-right'></span></button>";
			
	echo "</div>";

	echo "<div id='iconos' style='display:none;'>";
		ponericon();
	echo "</div>";		
	
	?>

	<div id='esperar' style='display:none'>
		<?php echo "<span class='icon-spinner'></span> ".i("esperar",$ilink);?>
	</div>

	</form>

</div>

