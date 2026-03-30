<?php

require_once __DIR__ .  "/../../siempre_base.php";

if ($_SESSION['auto'] < 5) exit("No autorizado");

iconex(DB2,$ilink);

$list_order = $_POST['list_order'] ?? '';
$tabla = $_POST['tabla'] ?? '';

if (!$list_order || !$tabla) exit("Datos incompletos");

$list_order = str_replace("li_", "", $list_order);

$ids = explode(',', $list_order);

// eliminar 'saco' u otros elementos no válidos
$ids = array_filter($ids, function($id) {
    return $id !== 'saco' && is_numeric($id);
});

$orden = 1;

foreach ($ids as $id) {
    $id = intval($id);

    $stmt = $ilink->prepare("UPDATE `{$tabla}` SET orden = ? WHERE n = ? AND n1 = 0");
    $stmt->execute([$orden, $id]);

    $orden++;
}

?>
