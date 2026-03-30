<?php

require_once __DIR__ .  "/../../siempre_base.php";

if ($_SESSION['auto'] < 5) {echo "<p><br>Usuario no autorizado</p>";exit;}

iconex(DB2,$ilink);

$list_order = $_POST['list_order'] ?? '';
$n = $_POST['n'] ?? '';
$tabla = $_POST['tabla'] ?? '';

if (!$list_order || !$tabla || !$n) exit("Datos incompletos");

$list_order = str_replace("li_", "", $list_order);

$ids = explode(',', $list_order);echo $list_order;
$orden = 1;

foreach ($ids as $id) {
    $id = intval($id); $n1 = $id;
    $stmt = $ilink->prepare("UPDATE `{$tabla}` SET orden = ? WHERE n1 = ? AND n = ?");
    $stmt->execute([$orden, $id, $n]);
    $orden++;
}

?>
