<?php

require_once  __DIR__ . '/../siempre_base.php';

if (!$_POST['message']) {return;}

$a = $_POST['enchatusuid'];
$message = $_POST['message'];
$message = str_replace("\"", "&#34;",$message);
$ilink->query("INSERT INTO chatlista (asigna, usuid, texto, fecha, parausuid) VALUES ('$a', '".$_SESSION['usuid']."', \"$message\", '".gmdate("Y-m-d H:i:s")."', '".$_POST['para']."')");
$ilink->query("UPDATE chat SET r_txt=1 WHERE asigna='$a'");

?>