<?php

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

?>

<script type="text/javascript">

$(document).ready(function(){
	$("#formchat").submit(function(){
		var dataString = $("#formchat").formSerialize();
		//AJAX
		$.ajax({
			type: "POST",
			url: "chatmini/postform.php",
			data: dataString,
			success: function() {$("#message").val('');$("#message").focus();}
		});
		return false;
	});
});

</script>

<?php

$a = $enchatusuid;
$u = $_SESSION['usuid'];
$_SESSION['n'] = 0;

$ilink->query("DELETE FROM chat WHERE usuid = '$u' AND asigna = '$a'");

$iresult = $ilink->query("SELECT usuid FROM chat WHERE asigna = '$a'");
$gente = $iresult->num_rows;
if (!$gente[0]) {$ilink->query("DELETE FROM chatlista WHERE asigna = '$a'");}

require_once __DIR__ . '/../siempre_base.php';
require_once APP_DIR . "/chatmini/jccabfunci.php";
require_once APP_DIR . "/chatmini/controlx.php";

$entra = gmdate("Y-m-d H:i:s");
$temp = "entra el ".utcausu1($entra,$ilink);
$ilink->query("INSERT INTO chat (usuid, asigna, fechaentra, fecha) VALUES ('$u', '$a', '$entra', '$entra')");
$ilink->query("UPDATE chat SET r_usu=1, r_txt=1 WHERE asigna = '$a'");
$ilink->query("INSERT INTO chatlista (asigna, usuid, texto, fecha) VALUES ('$a', '$u', \"<span class='verdecalific peq'>$temp</span>\", '$entra')");

?>

<div id="jccontrol">
  <script>
    jccontrol();
  </script>
</div>

<div class="chatmini">
  <span class="fr peq mr5"><?php echo i("listusers",$ilink);?> &nbsp;</span>
  Chat <?php echo $titchat;?>
</div>

<div class="chat-container">
  
  <div id="mensajeschat" class="chat-mensajes">
    <!-- mensajes -->
  </div>

  <div id="jcusuonline" class="chat-usuarios">
    <script>
      jcusuonline();
    </script>
  </div>
  
</div>

<div id="ContenedorForm" class="chat-form">
  <form name="formchat" id="formchat" method="post">
    <input type="hidden" name="enchatusuid" value="<?php echo $enchatusuid;?>">
    <input type="text" id="message" name="message" maxlength="200"
           placeholder="Escribe un mensaje...">
    <input type="hidden" name="para">
  </form>
</div>
