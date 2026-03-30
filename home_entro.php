<?php

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

$ilink->query("UPDATE usuarios SET fecha='".gmdate('Y-m-d H:i:s')."' WHERE id='".$_SESSION['usuid']."'");
$reviso = 1;

?>