<?php

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

if (!$esmigrupo) {return;}

if ($_POST['regis']) {
	require_once APP_DIR . "/grupo1.php";
	$sql = "SELECT * FROM grupos WHERE id = '$grupoid' LIMIT 1";
	$result = $ilink->query($sql);
	$fila = $result->fetch_array(MYSQLI_BOTH);
	extract($fila);
}

?>

<form enctype='multipart/form-data' action='grupo.php?grupoid=<?php echo $grupoid;?>&pest=7' name='form1' method='post' onsubmit="setTimeout('return true',50000);hide('esperar');show('esperar1');">

<?php

// --------------------------------------------------

echo "<br>";

echo "<span class='icon-youtube4 grande' title='Youtube'></span> <textarea placeholder=\"".i("grupoyout",$ilink)."\" class='col-6' name='video1' cols='150' rows='6'>$video1</textarea>";
//echo "<br><span class='rojo b'>".i("grupoyout",$ilink)."</span>";

echo "<p></p><span class='icon-instagram grande' title='Instagram'></span> <span class='icon-flickr grande' title='Flickr'></span> &nbsp; ";
echo "<textarea placeholder=\"".i("grupoinstagr",$ilink)."\" class='col-6' name='otros' cols='150' rows='6'>$otros</textarea>";
//echo "<br><span class='rojo b'>".i("grupoinstagr",$ilink)."</span>";

// --------------------------------------------------

echo "<p class='mediana verdecalific'>".i("grupomas",$ilink)."</p>";

echo i("interesante",$ilink)."<br>";
echo "<textarea class='col-6' rows='4' name='interes'>$interesante</textarea><p></p>";
echo "WOW!<br>";
echo "<textarea class='col-6' rows='4' name='wow'>$wow</textarea><p></p>";
echo i("competencias",$ilink)."<br>";
echo "<textarea class='col-6' rows='4' name='competencias'>$competencias</textarea><p></p>";
echo i("mas",$ilink);
echo " (".str_replace("<caracteres>", "<input class='col-05' readonly='readonly' type='text' name='remLen' size='3' maxlength='3' value='255'>", i("poner",$ilink)).")<br>";

echo "<textarea class='col-6' rows='4' name='mas' wrap='physical' onKeyDown=\"textCounter(this.form.mas,this.form.remLen,255);\" onKeyUp=\"textCounter(this.form.mas,this.form.remLen,255);\">$mas</textarea>";

// --------------------------------------------------

echo "<div id='esperar'><input class='col-2' type='submit' name='regis' value=\"".i("validarnd",$ilink)."\"></div>";
echo "<div class='both rojo b mediana' id='esperar1' style='display:none'>$imgloader".i("esperar",$ilink)."</div>";

echo "</form>";

?>