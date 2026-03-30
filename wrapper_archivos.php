<?php

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

// wrapper_archivos.php

function safe_unlink($filename) {
    if (demo_enabled()) return true;
    return unlink($filename);
}

function safe_move_uploaded_file($from, $to) {
    if (demo_enabled()) return true;
    return move_uploaded_file($from, $to);
}

function safe_file_put_contents($filename, $data, $flags = 0, $context = null) {
    if (demo_enabled()) return true;
    return $context ? file_put_contents($filename, $data, $flags, $context) : file_put_contents($filename, $data, $flags);
}

function safe_mkdir($path, $mode = 0777, $recursive = false, $context = null) {
    if (demo_enabled()) return true;
    return $context ? mkdir($path, $mode, $recursive, $context) : mkdir($path, $mode, $recursive);
}

function safe_rmdir($path, $context = null) {
    if (demo_enabled()) return true;
    return $context ? rmdir($path, $context) : rmdir($path);
}

function safe_rename($old, $new, $context = null) {
    if (demo_enabled()) return true;
    return $context ? rename($old, $new, $context) : rename($old, $new);
}

function safe_copy($from, $to, $context = null) {
    if (demo_enabled()) return true;
    return $context ? copy($from, $to, $context) : copy($from, $to);
}

function safe_fopen($filename, $mode, $use_include_path = false, $context = null) {
    if (demo_enabled() && strpbrk($mode, 'waxc+')) return true; // evita modos de escritura
    return $context ? fopen($filename, $mode, $use_include_path, $context) : fopen($filename, $mode, $use_include_path);
}

?>

