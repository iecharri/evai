<?php

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

?>

<script>

$(document).ready(function(){
	$("div[class='oscu']").click(function(){
		$('.oscu').hide();
	});
});

</script>

<?php

if(!$veopasswd) {return;}

if($tipo == "P") {
	
	echo "<div class='col-9' style='margin:auto'>"; 

		echo "<fieldset class=' cajabl'><legend class='cajabl'>".i("profesores",$ilink)."</legend>";

			echo "<form enctype='multipart/form-data' action='ficha.php?usuid=$usuid&op=3' name='form2' method='post'>";
			echo "<span class='b verdecalific'>Mensaje en el Panel</span><br><input class='col-9' type='text' name='mensajep' size='60' maxlength='200' value=\"$mensaje\">";	
			echo " <input type='submit' class='col-2' name='profes' value=\"".i("enviar",$ilink)."\"><br>";
			if($foto) {
				echo "<a href='".APP_URL."/avatar.php?f=$foto' target='_blank'><img src='".APP_URL."/avatar.php?f=2$foto&v=".rand(1,1000)."'></a>";
			} else {
				echo "<div class='cajabl center' style='width:10em;height:10em'>NO HAY FOTO</div>";
			}
			?><div class="bloque-subida">
  			<label class="boton-subida">
    			📷 <?php echo i("foto",$ilink);?> (jpg)
    			<input type="file" name="foto" accept="image/*">
  			</label></div>
			<?php
			echo "<input type='submit' class='col-2' name='profes' value=\"".i("enviar",$ilink)."\">";
			
			echo " <p></p>".i("profpanel",$ilink)."</label> <input type='checkbox' name='profpanel' ";
			if (!$profpanel) {echo "checked='checked'";}
			echo ">";
			echo "&nbsp; <input type='submit' class='col-2' name='profes' value=\"".i("agvalid",$ilink)."\"><br>";
			echo "</form>";
					
		echo "</fieldset>";

	echo "</div><br><p></p>";

}

$vnd = "<input type='submit' class='col-2 fr' name='regis' value=\"".i("validarnd",$ilink)."\">";

// --------------------------------------------------
if ($_SESSION['usuid'] == $id) {
	$verpass = 1;
} elseif ($_SESSION['auto'] > 4) {
	$verpass = verpassword($usuid,$autorizado,$ilink);
}
// --------------------------------------------------

echo "<div class='col-9' style='margin:auto'>"; // ------------- DIV total

if ($fechabaja == "0000-00-00 00:00:00") {
?> 
	<div class='fr col-2'>
	<form name='borrar' method='post'>
	<input type='hidden' name='usuid' value=<?php echo $usuid;?>>
	<input type='submit' name='borrar' value="<?php echo i("borrarusu",$ilink);?>" 
	onclick="return borrar_usuario(<?php echo "'$alumnon', '$alumnoa'";?>)">
	</form>
<?php
	} else {
?>
	<div class='fr col-3' id='borraresp'>
	<form name='desborrar' method='post'> <?php echo i("usuborr",$ilink);?>
	<input type='hidden' name='usuid' value=<?php echo $usuid;?>>
	<input type='submit' name='desborrar' value="<?php echo i("recupusu",$ilink);?>">
	</form>
<?php
}
?>

</div>

<?php
echo "<div id='esperarborrar' style='display:none'>$imgloader".i("esperar",$ilink)."</div>";
?>


<p class='both'></p>

<form enctype='multipart/form-data' action='ficha.php?usuid=<?php echo $usuid;?>&pest=2&op=3' name='form1' method='post' onsubmit="return editar(form1);show('esperar');show('esperar1');">

<?php

// --------------------------------------------------

echo "<fieldset><legend>".i("datosper",$ilink)."</legend>";

echo "<input class='col-3' type='text' name='alumnon' size='30' maxlength='50' value=\"$alumnon\"> <label>* ".i("nombre",$ilink)."</label><br>";

echo "<input class='col-3' type='text' name='alumnoa' size='30' maxlength='50' value=\"$alumnoa\"> <label>* ".i("apellidos",$ilink)."</label><br>";

echo "<input class='col-3' type='text' name='mail' size='30' maxlength='50' onKeypress='if ((event.keyCode < 48 && event.keyCode != 46 && event.keyCode != 45) || event.keyCode > 122 || (event.keyCode > 57 && event.keyCode < 97) && event.keyCode != 64 && event.keyCode != 95) event.returnValue = false;' value=\"$mail\">";
echo " <label> * ".i("mail",$ilink)."</label><br>";

if ($mensaje1) {echo $mensaje1."<br>";}

echo "<input class='col-2' type='text' name='dni' size='30' maxlength='50' value=\"$dni\"> <label> * ".i("dni",$ilink)."</label>";
echo "<br>";

$result = $ilink->query("SELECT id FROM usuarios WHERE dni != '' AND dni = \"".$_POST['dni']."\" AND id != '$usuid' LIMIT 1");

if ($result->num_rows > 0 AND $_SESSION['auto'] == 10) {
	$repe = $result->fetch_array(MYSQLI_BOTH);
	echo "Mensaje a Administradores: <span class='rojo b'>DNI repetido usuario nº [<a href='ficha.php?usuid=$repe[0]&op=3' target='_blank'>$repe[0]</a>]</span><br>\n";
}

echo "<input class='col-2' type='text' name='pais' size='30' maxlength='50' value=\"$pais\"> <label>".i("pais",$ilink)."</label>";
echo "<br>";

echo "<input class='col-2' type='text' name='provincia' size='30' maxlength='50' value=\"$provincia\"> <label>".i("provincia",$ilink)."</label><br>";

echo "<input class='col-2' type='text' name='direccion' size='30' maxlength='255' value=\"$direccion\"> <label>".i("direccion",$ilink)."</label><br>";

echo "<input class='col-2' type='text' name='codpos' size='30' maxlength='50' value=\"$codpos\"> <label>".i("codpos",$ilink)."</label><br>";

echo "<input class='col-2' type='text' name='localidad' size='30' maxlength='50' value=\"$localidad\"> <label>".i("localidad",$ilink)."</label><br>";

echo "<input class='col-2' type='text' name='tfmovil' size='9' maxlength='15' value=\"$tfmovil\"> <label>".i("tfmov",$ilink).".</label>";

echo " <label>".i("mostrar",$ilink)."</label> <input type='checkbox' name='tfmovil1' ";
if ($tfmovil1) {echo "checked='checked'";}
echo "><br>";

echo "<input class='col-2' type='text' name='ocupaci' size='35' maxlength='255' value='$ocupacion'> <label>".i("ocupaci",$ilink)."</label><br>";

echo "<input class='col-2' type='text' name='ppersonal' size='35' maxlength='50' value='$ppersonal'> <label>".i("ppers",$ilink)."</label><br>";

echo "<input class='col-2' type='text' name='titul' size='35' maxlength='50'  value=\"$titul\"> <label>".i("titul",$ilink)."</label><br>";

echo "<input class='col-2' type='text' name='universi' size='35' maxlength='50' value=\"$universi\"> <label>".i("universi",$ilink)."</label><br>";

echo "<label>".i("pacadem",$ilink)."</label><br><input class='col-9' type='text' name='pacadem' size='80' maxlength='255' value=\"$pacadem\"> <br>";

if($tipo == "P") {
	echo "<label>Despacho</label><br><input class='col-5' type='text' name='despacho' size='50' maxlength='50' value=\"$despacho\"> <br>";
}

echo $vnd;

echo "<div class='both fr rojo b mediana' id='esperar1' style='display:none'>$imgloader".i("esperar",$ilink)."</div>";

echo "</fieldset>";

// --------------------------------------------------

echo "<fieldset><legend>Multimedia</legend>";

echo "<label>".i("callto",$ilink)." </label>";
echo "<input class='col-2' type='text' name='callto' size='9' maxlength='50' value=\"$callto\">";
echo " <input type='button' class='col-1' onclick=\"show('div11')\" value = \"".i("quees",$ilink)."\">";
wintot1("","<p class='justify interli'>".i("calltohelp",$ilink)."<p></p>",'div11',"help",1,$ilink);

echo "<br><label>".i("callto1",$ilink)."</label> <input type='checkbox' name='callto1' ";
if ($callto1) {echo "checked='checked'";}

echo "><br>";

echo "<div class='colu'>"; ?>

<div class="bloque-subida">
  <label class="boton-subida">
    📷 <?php echo i("foto",$ilink);?> (jpg)
    <input type="file" name="foto" accept="image/*">
  </label>
  <?php
 	if ($foto) {
		echo "<label>".i("borrarfoto",$ilink)." ".$anch."</label> <input type='checkbox' name='nofoto'>";
	}   
   ?>
  <label class="boton-subida video">
    🎬 vídeo (mp4, webm, ogg)
    <input type="file" name="regisvideo" accept="video/mp4,video/webm,video/ogg">
  </label>
  <?php
  if ($video) {
	echo i("borrvid",$ilink,$anch)." <input type='checkbox' name='novideo'>";
  }
  ?>
</div>

<?php 

echo "<p></p><span class='icon-youtube4 grande'></span> <input class='col-2' type='text' name='video1' size='50' maxlength='255' value='$video1'>";
echo "<br><span class='rojo b'>Escribe el c&oacute;digo del v&iacute;deo.</span> Por ejemplo, si la URL es http://www.youtube.com/watch?v=dsqfkE3tKrU, escribe s&oacute;lo <span class='rojo b'>dsqfkE3tKrU</span>.";

echo "</div>";

// --------------------------------------------------

echo "<br>";

echo "<span class='icon-youtube4 grande'></span> <textarea name='otrosvideos' cols='150' rows='6' class='col-5'>$otrosvideos</textarea>";
echo "<br><span class='rojo b'>".i("fichayout",$ilink)."</span>";

echo "<p></p><span class='icon-instagram grande'></span> <span class='icon-flickr3 grande'></span> &nbsp; ";
echo "<textarea name='otrospics' cols='150' rows='6' class='col-5'>$otrospics</textarea>";
echo "<br><span class='rojo b'>".i("fichainstagr",$ilink)."</span>";

// --------------------------------------------------

echo $vnd;

echo "<div class='both fr rojo b mediana' id='esperar1' style='display:none'>$imgloader".i("esperar",$ilink)."</div>";

echo "</fieldset><br>";
	
// --------------------------------------------------
if ($verpass) {

	echo "<fieldset class='fl col-2'><legend>$usuario - ".i("clave",$ilink)."</legend>";	
	echo "<a href='ficha.php?usuid=$usuid&op=24' class='b fl'>Cambiar Password</a><p></p>";
	echo "</fieldset>";

}

// --------------------------------------------------

echo "<fieldset class='both fl col-2'><legend>".i("privacidad",$ilink)."</legend>";
echo "<input type='text' name='privacidad' maxlength='1' size='1' value='$privacidad' onKeypress='if (event.keyCode < 48 || event.keyCode > 50) event.returnValue = false;'><br><span class='txth'>".i("priv0",$ilink)."<br>".i("priv1",$ilink)."<br>".i("priv2",$ilink)."</span></fieldset>";

// --------------------------------------------------

if ($_SESSION['auto'] > 4) {
	echo "<fieldset class='fl col-2'><legend>".i("estado",$ilink)."</legend>";
	echo "<select name='estado'>";
	echo "<option value='0'";
	if (!$estado) {echo " selected='selected'";}
	echo ">".i("conectado",$ilink)."</option>";
	echo "<option value='1'";
	if ($estado == 1) {echo " selected='selected'";}
	echo ">".i("noconectado",$ilink)."</option>";
	if ($_SESSION['auto'] == 10 AND $usuid == $_SESSION['usuid']) {
		echo "<option value='2'";
		if ($estado == 2) {echo " selected='selected'";}
		echo ">Administrador - No conectado ni para el resto de administradores</option>";
	}
	echo "</select></fieldset><p class='both'>&nbsp;</p>";
}

echo "<p class='both'></p><span class='rojo'>No recordar datos en ning&uacute;n dispositivo</span> ";
echo "<input class='col-1' type='submit' name='norecordardatos' value=' >> '>";

// --------------------------------------------------

echo "<fieldset class='both'><legend>".i("massobre",$ilink)."</legend>";

echo "<h3>Curriculum</h3>";

echo i("curric",$ilink);

if ($mensajecurr) {
	echo "<p class='rojo b'>".$mensajecurr."</p>";
}

echo "<br>".i("filemax",$ilink).": $tamanomax MB. <br>";

?><div class="bloque-subida">
  <label class="boton-subida">
    📄 currículum 
    <input type="file" name="curri" accept=".pdf,.doc,.docx">
  </label>
  </div>
<?php

echo "<p class='both'></p>";
echo i("direccion",$ilink)." (http://...) <br><input class='col-3 fl' type='text' size='110' maxlength='255' name='curriculum' value=\"$curriculum\">";

echo $vnd;

echo "<div class='both fr' id='esperar' style='display:none'>$imgloader".i("esperar",$ilink)."</div>";

//$fnaci = substr($fnaci,8,2)."/".substr($fnaci,5,2)."/".substr($fnaci,0,4);
$fnaci = formatof($fnaci,'');
$fnaci = $fnaci[0];

echo "<p class='both'></p><br><input type='radio' name='sexo' value='h'";
if ($sexo=='h') {echo " checked='checked'";}
echo "> <label>".i("h",$ilink)."</label>";

echo "<input type='radio' name='sexo' value='m'";
if ($sexo=='m') {echo " checked='checked'";}
echo "> <label>".i("m",$ilink)."</label>";
echo " &nbsp; ";
echo "<label>".i("fnaci",$ilink)."</label>";
echo " <input class='col-1 datepicker' type='text' name='fnaci' size='10' maxlength='10' value='$fnaci'><br>";
echo "<input type='radio' name='pareja' value='s'";
if ($pareja=='s') {echo " checked='checked'";}
echo "> <label>".i("conpar",$ilink)."</label>"; 
echo "<input type='radio' name='pareja' value='n'";
if ($pareja=='n') {echo " checked='checked'";}
echo "> <label>".i("sinpar",$ilink)."</label><br>";
echo "<input type='radio' name='amistad' value='s'";
if ($amistad=='s') {echo " checked='checked'";}
echo "> <label>".i("amis",$ilink)."</label>"; 
echo "<input type='radio' name='amistad' value='n'";
if ($amistad=='n') {echo " checked='checked'";}
echo "> <label>".i("nobusco",$ilink)."</label><p></p>";
echo "<h3>".i("interesante",$ilink)."</h3>";
echo "<textarea rows='4' class='col-10' name='interes'>$interesante</textarea>";
echo "<h3>WOW!</h3>";
echo "<textarea rows='4' class='col-10' name='wow'>$wow</textarea>";
echo "<h3>".i("competencias",$ilink)."</h3>";
echo "<textarea rows='4' class='col-10' name='competencias'>$competencias</textarea>";
echo "<h3>".i("mas",$ilink)."</h3> ";
echo " [".str_replace("<caracteres>", "<input class='col-1' readonly='readonly' type='text' name='remLen' size='3' maxlength='3' value='255'>", i("poner",$ilink))."]<br>";

echo "<textarea rows='4' class='col-10' name='mas' wrap='physical' onKeyDown=\"textCounter(this.form.mas,this.form.remLen,255);\" onKeyUp=\"textCounter(this.form.mas,this.form.remLen,255);\">$mas</textarea>";

echo $vnd;

echo "<div class='both fr' id='esperar' style='display:none'>$imgloader".i("esperar",$ilink)."</div>";

echo "</fieldset>";

// --------------------------------------------------

echo "<fieldset class='both'><legend>Social Network</legend>";

echo "<h3>Widget 1</h3>";
echo "<textarea rows='4' class='col-10' name='codigo1'>".stripslashes($codigo1)."</textarea>";
echo "<h3>Widget 2</h3>";
echo "<textarea rows='4' class='col-10' name='codigo2'>".stripslashes($codigo2)."</textarea>";
echo "<h3>Widget 3</h3>";
echo "<textarea rows='4' class='col-10' name='codigo3'>".stripslashes($codigo3)."</textarea>";
echo "<h3>Widget 4</h3>";
echo "<textarea rows='4' class='col-10' name='codigo4'>".stripslashes($codigo4)."</textarea>";

echo $vnd;

echo "<div class='both fr' id='esperar' style='display:none'>$imgloader".i("esperar",$ilink)."</div>";

echo "</fieldset>";

echo "<input type='hidden' name='op' value='3'>";
echo "<input type='hidden' name='regis' value='1'>";

?>

</form>

<?php

echo "</div>"; // ------------- DIV total

echo "

	<script>

	function borrar_usuario(a, b) {
		return confirm(\"".str_replace("<usuario>", "\" +a+\" \"+b+ \"", i("jsborr",$ilink)). " " . SITE . "\");
	}



	function editar(form1) {
		if (form1.pass0.value == \"\" || form1.pass1.value == \"\" || form1.alumnon.value == \"\" || form1.alumnoa.value == \"\")
		{
			alert(\"".i("completaas",$ilink)."\")
			form1.alumnon.focus()
			return false
		}

		if (form1.pass0.value != form1.pass1.value)
		{
			alert(\"".i("contranocoinc",$ilink)."\")
			form1.pass1.select()
			form1.pass1.focus()
			return false
		}

		if (form1.mail.value.indexOf('@') < 1 || form1.mail.value.indexOf('.') < 1)
		{
			alert(\"".i("mailno",$ilink)."\")
			form1.mail.focus()
			return false
		}
	}
	</script>
";

?>

