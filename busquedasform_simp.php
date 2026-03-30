<?php

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

if ($_SESSION['auto'] < 2) {exit;}

$usuvinc = $_POST['usuvinc'];
if ($usuvinc < 5) {$usuvinc = 5;}

?>

<script language="javascript">

function busquedas(form1) {
	if (form1.claves0.value == "")
	{ 
		alert("<?php echo i("eligcondbus",$ilink);?>");
		form1.claves0.focus();
		return false 
	}
	
}

</script>

<form name='form1' method='post' action='<?php echo $_SERVER['PHP_SELF']."?bus=".$_GET['bus']; ?>' target='_self'>

<input class='col-2' type='text' size='30' maxlength='50' id='claves0' name='claves0' value='<?php echo stripslashes($_SESSION['bu'][1]); ?>'> &nbsp; 
<input class='col-2' type='submit' name='subm' value="<?php echo i("busvinc",$ilink);?>" onclick="return busquedas(form1)">

<p class='both'></p><?php echo i("usuinteres",$ilink);?> <input class='col-1' type='text' name='usuvinc' size='2' maxlength='3' value='<?php echo $usuvinc;?>'> <?php echo i("vinculos1",$ilink);?> 
<input type='submit' class='col-1' name='usuarios' value=">>"><br>

</form>

