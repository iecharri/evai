<?php

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

if ($_SESSION['auto'] < 2) {exit;}

if ($_GET['bus'] == 1) {require_once APP_DIR . '/busquedasform_simp.php';}

if ($_GET['bus'] == 2) {require_once APP_DIR . '/busquedasform_avan.php';}

if ($_GET['bus'] == 3) {require_once APP_DIR . '/busquedasform_alertas.php';}

?>

