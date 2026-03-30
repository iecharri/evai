<?php

return; exit;

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

if ($_SESSION['auto'] < 5) {exit;}

// --------------------------------------------------

if ($_GET['borr']) {
	$ilink->query("DELETE FROM grabaciones WHERE id = '".$_GET['borr']."'");
}

if ($_POST['submtext']) {
	$ilink->query("UPDATE grabaciones SET texto = '".$_POST['textoaudio']."' WHERE id = '".$_POST['id']."'");
}

// --------------------------------------------------

?>

<script language="javascript">
function prueba() {
	return confirm("<?php echo i("confirmborr",$ilink);?>");
}
</script>

<script language="JavaScript">
function submitVoice() {
  var applet = document.getElementById("nanogong");
  var ret = applet.sendGongRequest( "PostToForm", "autograb2.php", "file", "", "temp.spx"); 
  if (ret == null || ret == "") alert("&iexcl;Error!");
  //else alert("Voice recording has been submitted!");
} 
</script> 

<div class='center'>
 <applet id="nanogong" archive="nanogong.jar" code="gong.NanoGong" width="180" height="40">
 <param name=" AudioFormat" value="Speex">
 <param name='ShowAudioLevel' value='true'>
 <param name='ShowSpeedButton' value='false'>
 <param name='Color' value='#ffffff'>
 <param name='ShowSaveButton' value='false'>
 </applet>

  <form>
  <br><input class='col-1' type="button" value="Guardar" onclick="submitVoice()">
  </form>
</div>
 
<table class='conhover'>

<tr>
<th class='nowrap col-01'><a href='?usuid=<?php echo $usuid;?>&pest=11&op=<?php echo $op;?>' class='txth b'>ACTUALIZAR</a></th>
<th class='nowrap col-01'>Fecha</th><th class='nowrap col-01'>Audio</th><th>Texto</th>
</tr>

<?php
$sql = "SELECT * FROM grabaciones WHERE usuid = '$usuid' ORDER BY date DESC";
$result = $ilink->query($sql);
while ($fila = $result->fetch_array(MYSQLI_BOTH)) {
	echo "<tr>";
	echo "<td class='nowrap col-01'><a href='?usuid=$usuid&op=$op&borr=".$fila['id']."' onclick='return prueba()'>BORRAR</a>";
	echo "</td>";
	echo "<td class='nowrap col-01'>".ifecha31($fila['date'],$ilink)."</td>"; //$fila['date'] se insertó como UTC
	echo "<td class='center nowrap col-01'>";
	echo "<div id='audio".$fila['id']."'>";
	echo "<a href=\"javascript:Enviar('autograb3.php?id=".$fila['id']."','audio".$fila['id']."')\" >";
	echo "<span class='icon-play grande'></span></a></div>";
	echo tamano($fila['tamatach']);
	echo "</td>";
	echo "<td>";
	echo "<form method='post'>";
	echo "<input type='hidden' name='id' value='".$fila['id']."'>";
	echo "<textarea class='col-6' name='textoaudio' rows='3' cols='60'>".$fila['texto']."</textarea>";
	echo " &nbsp; <input class='col-1' type='submit' name='submtext' value=' >> '>";
	echo "</form>";
	echo "</td>";
	echo "</tr>";
}
?>

</table> 
 
<?php
$path = APP_DIR . '/temp/';
$dir = opendir($path);
while($f = readdir($dir)) {
	if((time()-filemtime($path.$f) > 1) and !(is_dir($path.$f)) AND $f != '.' AND $f != '..')
	{safe_unlink($path.$f);} // > 3600*24*7
}
closedir($dir);
?>
