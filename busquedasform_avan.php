<?php

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

if ($_SESSION['auto'] < 2) {exit;}

?>

<script language="Javascript">

function busquedas(form1) {
	if (form1.asigna0.value == "" && form1.claves0.value == "" && form1.titulo0.value == "" && form1.pagina0.value == "")
	{ 
		alert("<?php echo i("eligcondbus",$ilink);?>");
		form1.claves0.focus();
		return false 
	}
	
}

</script>

<form name='form1' method='post' action='<?php echo $_SERVER['PHP_SELF']."?bus=".$_GET['bus'];?>'>

<input class='col-1' placeholder="<?php echo i("area",$ilink); ?>" type='text' maxlength='50' name='asigna0' value='<?php echo stripslashes($_SESSION['bu'][0]); ?>'>
&nbsp;<select class='selectcss' name = 'orand10'> &nbsp; <option value='and' <?php if ($_SESSION['bu'][4]=="and") { echo "selected = 'selected'"; } ?>> <?php echo i("y",$ilink);?> <option value='or' <?php if ($_SESSION['bu'][4]=="or") { echo "selected = 'selected'"; } ?>> <?php echo i("o",$ilink);?> </select>
&nbsp;<input class='col-1' placeholder="<?php echo i("clave1",$ilink); ?>" type='text' maxlength='50' id='claves0' name='claves0' value='<?php echo stripslashes($_SESSION['bu'][1]); ?>'>
&nbsp;<select class='selectcss' name = 'orand20'><option value='and' <?php if ($_SESSION['bu'][5]=="and") { echo "selected = 'selected'"; } ?>> <?php echo i("y",$ilink);?> <option value='or' <?php if ($_SESSION['bu'][5]=="or") { echo "selected = 'selected'"; } ?>> <?php echo i("o",$ilink);?> </select>
&nbsp;<input class='col-1 ' placeholder="<?php echo i("titulo",$ilink); ?>" type='text' maxlength='50' name='titulo0' value='<?php echo stripslashes($_SESSION['bu'][2]); ?>'>
&nbsp;<select class='selectcss' name = 'orand40'><option value='and' <?php if ($_SESSION['bu'][6]=="and") { echo "selected = 'selected'"; } ?>> <?php echo i("y",$ilink);?> <option value='or' <?php if ($_SESSION['bu'][6]=="or") { echo "selected = 'selected'"; } ?>> <?php echo i("o",$ilink);?> </select>
&nbsp;<input class='col-1' placeholder="Web" type='text' maxlength='50' name='pagina0' value='<?php echo stripslashes($_SESSION['bu'][3]); ?>'>

<?php
//if ($_SESSION['bu'][7]) {$d1 = substr($_SESSION['bu'][7],6,2)."-".substr($_SESSION['bu'][7],4,2)."-".substr($_SESSION['bu'][7],0,4);}
//if ($_SESSION['bu'][8]) {$d2 = substr($_SESSION['bu'][8],6,2)."-".substr($_SESSION['bu'][8],4,2)."-".substr($_SESSION['bu'][8],0,4);}

$d1 = substr(utcausu1($_SESSION['bu'][7][0]),0,10);
$d2 = substr(utcausu1($_SESSION['bu'][8][0]),0,10);

?>

<p></p>

<?php echo i("entref",$ilink);?>
<input type='text' name='d1' size='10' maxlength='10' value='<?php echo $d1;?>' class='col-1 datepicker'> <span class='icon-arrow-right'></span>
<input type='text' name='d2' size='10' maxlength='10' value='<?php echo $d2;?>' class='col-1 datepicker'>

 &nbsp;<input class='col-2' type='submit' name='subm' value="<?php echo i("busvinc",$ilink);?>"> &nbsp;
<input class='col-2' type='button' onclick="vaciar(form1)" value="<?php echo i("vaciarcamp",$ilink);?>"> <!-- onclick="vaciar(form1)"  -->

<p></p>

<?php

if ($_SESSION['gc']) {

	require_once APP_DIR . '/cat.php';

	for ($i=0;$i<5;$i++) {

		echo "<select name='oy[$i]'>";
		echo "<option value='and'";
		if ($_SESSION['cat'][$i][0]=="and") { echo " selected = 'selected'";}
		echo ">".i('y',$ilink)."</option>";
		echo "<option value='or'";
		if ($_SESSION['cat'][$i][0]=="or") { echo " selected = 'selected'";}
		echo ">".i('o',$ilink)."</option></select> ";

		echo $cat[$i][0]."&nbsp;<select name='cat[$i]'><option value=''></option>";
		foreach($cat[$i] as $clave1=>$valor1){
			if ($clave1 != "0") {
				echo "<option value='$clave1'";
				if ($clave1 == $_SESSION['cat'][$i][1]) {echo " selected='selected'";}
				echo ">$valor1</option>";
			}
		}
		echo "</select><br>";

	}

}

?>

</form><br>
