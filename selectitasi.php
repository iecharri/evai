<?php

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

if (($_SESSION['tipo'] == "E" AND $_SESSION['auto'] < 10) OR !$_SESSION['asigna']) {return;}

?>

<!-- <div class='center'> -->
<div><form name='selectitasi' method='post'>
<select name='titasi' onchange='javascript:this.form.submit()'> <!-- selectcss --> <!-- class='col-10' -->

<?php

if ($vacio) {
	echo "<option value='todos'";
	if ($titasi == "todos") {echo " selected='selected'";}
	echo ">".i("grtittod",$ilink)."</option>";
}

if ($general) {
	echo "<option value='general'";
	if ($titasi == "general") {echo " selected='selected'";}
	echo ">".i("general",$ilink)."</option>";
}

$iresult = $ilink->query("SELECT titulacion FROM podtitulacion WHERE cod = '".$_SESSION['tit']."'");
$temptit = $iresult->fetch_array(MYSQLI_BOTH);
$iresult = $ilink->query("SELECT asignatura FROM podasignaturas WHERE cod = '".$_SESSION['asigna']."'");
$tempasi = $iresult->fetch_array(MYSQLI_BOTH);

$temptit = $_SESSION['tit']." (".$temptit[0].")";
$tempasi = $_SESSION['asigna']." (".$tempasi[0].")";

if ($_SESSION['curso']) {
	$temptit .= " - ".$_SESSION['curso'];
	$tempasi .= " - ".$_SESSION['curso'];
}

if ($_SESSION['grupo']) {
	$tempasi .= " - ".$_SESSION['grupo'];
}

echo "<option value='1'";
if ($titasi==1) {echo " selected='selected'";}
echo ">".i("titul",$ilink)." ".$temptit."</option>";
echo "<option value='2'";
if ($titasi==2) {echo " selected='selected'";}
echo ">".i("asigna",$ilink)." ".$tempasi."</option>";

?>

</select>
</form>
</div>
<!-- </div> -->