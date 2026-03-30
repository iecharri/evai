<?php

require_once __DIR__ . "/../siempre_base.php";

?>

<script language="javascript">
function jccontrol(){
   $("#jccontrol").load("jccontrol.php?enchatusuid=<?php echo $enchatusuid;?>");
}
setInterval( "jccontrol()", 5000 );

function jcusuonline(){
   $("#jcusuonline").load("jcusuonline.php?enchatusuid=<?php echo $enchatusuid;?>");
}
</script>