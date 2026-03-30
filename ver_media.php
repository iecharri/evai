<?php

require_once __DIR__ . '/siempre_base.php';

// Recibir dir (puede venir codificado en base64)
if (!empty($_GET['dir64'])) {
    $dir = base64_decode($_GET['dir64']); 
} else {
    $dir = str_replace('\\','/', trim($_GET['dir'] ?? '', "/ \t\n\r\0\x0B"));
}

$f   = $_GET['f'] ?? '';

if ($f === '') { http_response_code(400); exit('Parámetros incorrectos'); }

// Recibir dir (puede venir codificado en base64)
if (!empty($_GET['dir64'])) {
    $dir = base64_decode($_GET['dir64']);
} else {
    $dir = str_replace('\\','/', trim($_GET['dir'] ?? '', "/ \t\n\r\0\x0B"));
}

$base    = realpath(DATA_DIR);
$realDir = realpath(DATA_DIR . '/' . $dir);
$realFile= realpath($realDir . '/' . basename($f));

if ($base === false || $realDir === false || $realFile === false ||
    !is_file($realFile) || strpos(str_replace('\\','/',$realFile), str_replace('\\','/',$base)) !== 0) {
    http_response_code(404); exit('Archivo no encontrado');
}

$ext = strtolower(pathinfo($realFile, PATHINFO_EXTENSION));
$imgExt = ['jpg','jpeg','png','gif','webp'];
$vidExt = ['mp4','webm','ogg','ogv'];
$docExt = ['csv','pdf','doc','docx','odt'];

$mime = mime_content_type($realFile);

// — Imágenes —
if (in_array($ext, $imgExt, true)) {
    if (!@exif_imagetype($realFile)) { http_response_code(415); exit('No es imagen válida'); }
    header('Content-Type: ' . $mime);
    header('Content-Length: ' . filesize($realFile));
    header('Cache-Control: private, max-age=86400');
    header('Content-Disposition: inline; filename="'.rawurlencode(basename($realFile)).'"');
    readfile($realFile);
    exit;
}

// — Vídeos con soporte de Range —
if (in_array($ext, $vidExt, true)) {
    $size  = filesize($realFile);
    $start = 0;
    $end   = $size - 1;

    header('Content-Type: ' . $mime);
    header('Accept-Ranges: bytes');

    if (isset($_SERVER['HTTP_RANGE']) && preg_match('/bytes=\s*(\d*)-(\d*)/i', $_SERVER['HTTP_RANGE'], $m)) {
        if ($m[1] !== '') $start = (int)$m[1];
        if ($m[2] !== '') $end   = (int)$m[2];
        if ($start > $end || $start >= $size) {
            header('HTTP/1.1 416 Range Not Satisfiable');
            header("Content-Range: bytes */$size"); exit;
        }
        header('HTTP/1.1 206 Partial Content');
    }

    $length = $end - $start + 1;
    header("Content-Range: bytes $start-$end/$size");
    header("Content-Length: $length");
    header('Cache-Control: private, max-age=86400');
    header('Content-Disposition: inline; filename="'.rawurlencode(basename($realFile)).'"');

    $fp = fopen($realFile, 'rb'); if ($fp === false) { http_response_code(500); exit('No se pudo abrir'); }
    fseek($fp, $start);
    $buf = 8192; $sent = 0;
    while (!feof($fp) && $sent < $length) {
        $chunk = fread($fp, min($buf, $length - $sent));
        if ($chunk === false) break;
        echo $chunk; $sent += strlen($chunk);
        @ob_flush(); @flush();
        if (connection_aborted()) break;
    }
    fclose($fp); exit;
}

// ── CSV y documentos ───────────────────────────────────────────────
if (in_array($ext, $docExt, true)) {
    header('Content-Type: ' . mime_content_type($realFile));
    header('Content-Length: ' . filesize($realFile));
    header('Cache-Control: private, max-age=86400');
    // Si quieres forzar descarga:
    header('Content-Disposition: attachment; filename="' . basename($realFile) . '"');
    readfile($realFile);
    exit;
}

http_response_code(415);
exit('Tipo de archivo no soportado');
