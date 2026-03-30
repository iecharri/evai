<?php

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

if($_SESSION['auto'] < 10) {header("Location: ../index.php"); exit;}

$conta = "";

if ($_POST['buscar']) {$_SESSION['frase']= $_POST['frase']; $_GET['conta'] = ""; $_GET['i'] = "";}

$frase = $_SESSION['frase']; 

if ($_POST['modif']) {
	$m = $_POST['m'];
	$i = $_GET['i'];
	$temp = nl2br(addslashes($_POST['texto']));
	$ilink->query("UPDATE idioma SET $i = \"$temp\" WHERE m = '$m'") or die ("Error");
	$_GET['i'] = "";
	$_POST['buscar'] = 1;
}

?>

<form method='post' name='form' action='?'>
Busca palabras o frases para modificar<br>
<input class='col-5' type='text' size='20' maxlength='20' name='frase' value = "<?php echo $frase;?>"
 onclick="form.frase.value=''">
<input class='col-1' type='submit' name='buscar' value=' >> '>
</form>

<?php

if ($_GET['i']) {require_once APP_DIR . "/soloprof/idioma1.php";}

if ($_POST['buscar']) {

	$sql = "SELECT * FROM idioma WHERE c LIKE '%$frase%' OR  v LIKE '%$frase%' OR i LIKE '%$frase%' OR m LIKE '%$frase%' ORDER BY m";
	$result = $ilink->query($sql);
	$num = $result->num_rows;

	if ($result) {
		echo "<div class='col-10' style='height:20em;overflow:auto'>";
		while ($fila = $result->fetch_array(MYSQLI_BOTH)) {
			echo "[<span class='b peq'>".$fila['m']."</span>] 
			<a class='bi' href='?accion=editar&m=".$fila['m']."&i=c&conta=$conta'>Castellano</a>: 
			<a href='?accion=editar&m=".$fila['m']."&i=c&conta=$conta'>
			<code>".nl2br(stripslashes(str_replace(">", ")", str_replace("<", "(", $fila['c']))))."</code>
			</a>
			<p></p>
			[<span class='b peq'>".$fila['m']."</span>] 
			<a class='bi' href='?accion=editar&m=".$fila['m']."&i=v&conta=$conta'>Valencià</a>: 
			<a href='?accion=editar&m=".$fila['m']."&i=v&conta=$conta'>
			<code>".nl2br(stripslashes(str_replace(">", ")", str_replace("<", "(",$fila['v']))))."</code>
			</a><p></p>[<span class='b peq'>".$fila['m']."</span>] 
			<a class='bi' href='?accion=editar&m=".$fila['m']."&i=i&conta=$conta'>English</a>: 
			<a href='?accion=editar&m=".$fila['m']."&i=i&conta=$conta'>
			<code>".nl2br(stripslashes(str_replace(">", ")", str_replace("<", "(",$fila['i']))))."</code></a><hr>";
		}
		echo "</div>";
	}

}

?>


