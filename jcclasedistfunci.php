<?php
defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');
?>

<script language="javascript">
function jcclasedistcontrol(){
   $("#jcclasedistcontrol").load("jcclasedistcontrol.php");
}
setInterval( "jcclasedistcontrol()", 5000 );

function jcclasedistimag(){
   $("#jcclasedistimag").load("jcclasedistimag.php");
}
</script>