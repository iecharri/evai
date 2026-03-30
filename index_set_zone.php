<?php

require_once __DIR__ . '/siempre_base.php';

date_default_timezone_set('UTC');

if (isset($_POST['zone']) && in_array($_POST['zone'], timezone_identifiers_list())) {
    $_SESSION['zone'] = $_POST['zone'];
    setcookie("zone", $_POST['zone'], time() + 60*60*24*365, "/");
}

?>