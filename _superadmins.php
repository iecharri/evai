<?php

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

function cargar_superadmins(mysqli $db): array {
    // Cachea en sesión para no consultar cada vez
    if (isset($_SESSION['superadmins_cache']) && is_array($_SESSION['superadmins_cache'])) {
        return $_SESSION['superadmins_cache'];
    }

    $ids = [];
    // Ajusta este SELECT a tu tabla/columna reales:
    $sql = "SELECT superadmins FROM atencion LIMIT 1";
    if ($res = $db->query($sql)) {
        if ($row = $res->fetch_row()) {
            $str = trim((string)$row[0]);       // "x*y"
            if ($str !== '') {
                $parts = explode('*', $str);    // ["x","y"]
                // Normaliza a enteros y filtra vacíos
                $ids = array_values(array_filter(array_map('intval', $parts), fn($v) => $v > 0));
            }
        }
        $res->free();
    }

    // Guarda en sesión para esta sesión de usuario
    $_SESSION['superadmins_cache'] = $ids;
    return $ids;
}
?>