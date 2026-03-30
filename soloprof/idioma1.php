<?php

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

if ($_SESSION['auto'] < 10) {exit;}

$i = $_GET['i'];
$m = $_GET['m'];

if ($_POST['i']) {$i = $_POST['i'];}
if ($_POST['m']) {$m = $_POST['m'];}

$onload = "document.form.".$i.".focus();";?>

<span class='b'>&iexcl;Atenci&oacute;n!</span> Es muy importante no cambiar ni borrar lo que va entre los signos <span class='b'><</span> &nbsp; <span class='b'>></span> &nbsp; <span class='b'>(</span> &nbsp; <span class='b'>)</span>, si no, la web dar&aacute; errores.

<?php

$result = $ilink->query("SELECT $i FROM idioma WHERE m = '$m'");

$fila = $result->fetch_array(MYSQLI_BOTH);

echo "<center><form method='post' name='form'>";

if ($i == 'c') {echo "Castellano";}
if ($i == 'v') {echo "Valenciano";}
if ($i == 'i') {echo "Ingl&eacute;s";}

echo "<br><textarea class='col-10' name='texto' rows='5' cols='50'>".stripslashes($fila[$i])."</textarea>";

echo "<br><input class='col-10' type='submit' name='modif' value='Modificar'>";

echo "<input type='hidden' name='i' value='$i'>";
echo "<input type='hidden' name='m' value='$m'>";

?>

</form></center>
