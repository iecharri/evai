<?php

require_once __DIR__ . "/../siempre_base.php";

if ($_SESSION['auto'] < 10 ) {
	exit;
}

$ilink->query("DELETE FROM chat");
$ilink->query("DELETE FROM chatlista");

echo "0";

?>