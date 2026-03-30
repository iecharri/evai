<?php

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

?>

<script type="text/javascript">

$(document).ready(function(){
	$("#form1").submit(function(){
		var dataString = $("#form1").formSerialize();
		//AJAX
		$.ajax({
			type: "POST",
			url: "postform.php",
			data: dataString,
			success: function() {$("#message").val('');$("#message").focus();}
		});
		return false;
	});
	$("#jccontrol").load("jccontrol.php?enchatusuid=<?php echo $usuid;?>");  
});

</script>

<?php

//2025 para evitar usar tablas de date time de mysql
//date_default_timezone_set('UTC');

$a = $enchatusuid;
$u = $_SESSION['usuid'];
$_SESSION['n'] = 0;

$ilink->query("DELETE FROM chat WHERE usuid = '$u' AND asigna = '$a'");

$iresult = $ilink->query("SELECT usuid FROM chat WHERE asigna = '$a'");
$gente = $iresult->num_rows;
if (!$gente[0]) {$ilink->query("DELETE FROM chatlista WHERE asigna = '$a'");}

require_once APP_DIR . "/chat/jccabfunci.php";
require_once APP_DIR . "/chat/controlx.php";

$entra = gmdate("Y-m-d H:i:s");
$temp = "entra el ".utcausu1($entra,$ilink); //." en ".$_SESSION['zone'];
$ilink->query("INSERT INTO chat (usuid, asigna, fechaentra, fecha) VALUES ('$u', '$a', '$entra', '$entra')");
$ilink->query("UPDATE chat SET r_usu=1, r_txt=1 WHERE asigna = '$a'");
$ilink->query("INSERT INTO chatlista (asigna, usuid, texto, fecha) VALUES ('$a', '$u', \"<span class='verdecalific peq'>$temp</span>\", '$entra')");

?>

<div id="jccontrol">
<script language="javascript">
jccontrol();
</script></div>

<div class='fl di col-5' id="mensajeschat" style='overflow:auto;height:400px;border-right:1px solid #c0c0c0;'>
</div>

<div id="jcusuonline" class='fl di col-4' style='margin-left:5px;overflow:auto;height:400px'>
<script language="javascript">
jcusuonline();
</script></div>

<br>
<div id="ContenedorForm" style='height:12%'>
<form name='form1' id='form1' method='post'>
<input type='hidden' name='enchatusuid' value='<?php echo $enchatusuid;?>'>
 &nbsp; <input type='text' size='50' maxlength='200' id='message' name='message' class='col-10'>
<input type='hidden' name='para'>
</form>

<?php 
require_once  APP_DIR . '/hiperen.php';

ponericon();
?>

 &nbsp; &nbsp; <a href= 'javascript:void(0)' class='b' onclick="javascript:ventana('histo.php?a=<?php echo $a;?>'); return false;">
 log del chat</a> &nbsp; &nbsp; 

</div>

<p class='both'>&nbsp;</p>
<p class='both'>&nbsp;</p>
<p class='both'>&nbsp;</p>
<p class='both'>&nbsp;</p>