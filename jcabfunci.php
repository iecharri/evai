<?php

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

?>

<script>
function jcontrol() {
  $("#jcontrol").load("jcontrol.php");
}
setInterval(jcontrol, 10000);

function jcabhsm() {
  $("#jcabhsm").load("jcabhsm.php");
}

function jusuonline() {
  $("#jusuonline").load("jusuonline.php");
}
</script>
