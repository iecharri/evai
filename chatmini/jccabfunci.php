<?php

require_once __DIR__ . "/../siempre_base.php";

?>

<script language="javascript">
function jccontrol(){
   $("#jccontrol").load("chatmini/jccontrol.php?enchatusuid=<?php echo $enchatusuid;?>");
}
setInterval( "jccontrol()", 5000 );

function jcusuonline(){
   $("#jcusuonline").load("chatmini/jcusuonline.php?enchatusuid=<?php echo $enchatusuid;?>");
}
</script>