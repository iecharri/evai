<?php

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

if (!$_SESSION['usuid']) {return;}

//Formulario de b&uacute;squeda de competencias ajenas
?>
<p></p><br>
<form method='post' action='?op=<?php echo $op;?>&apli=1'>
<?php echo i("buscompet",$ilink);?> 
<input class='col-2' type='text' name='compet' size='30' maxlength='30' value="<?php echo $compet;?>">
<input class='col-1' type='submit' name='compet1' value=' >> '>
</form>


<?php

require_once APP_DIR . "/bancot/bancofunc.php";
cambios($ilink);

//listado de competencias ofertadas y tiempos
$sql = "SELECT * FROM bancot1 WHERE competencia LIKE \"%$compet%\" AND activo ORDER BY fecha DESC ";
$result = $ilink->query($sql);
if ($result->num_rows < 1) {
	echo "<div class='rojo mediana b center'>".i("nodatos",$ilink)."</div>";
	return;
}

$numvinculos = $result->num_rows;

//Paginar resultados

$conta = $_GET['conta'];
if (!$_GET['conta']) {$conta = 1;}
$result = $ilink->query($sql." LIMIT ".($conta-1).", 50");
$numpag = 50;

pagina($numvinculos,$conta,$numpag,i("competencias",$ilink),"op=$op&apli=1",$ilink);
cabecera("busca");
$param = "op=$op&apli=1&conta=$conta";
while ($fila = $result->fetch_array(MYSQLI_BOTH)) {
	competencia($fila,"busca",$param,$ilink);
}
pie();
echo "<p></p>";
pagina($numvinculos,$conta,$numpag,i("competencias",$ilink),"op=$op&apli=1",$ilink);

//posibilidad de solicitar un tiempo 

?>