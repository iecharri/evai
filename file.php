<?php

require_once __DIR__ . "/siempre_base.php";

$dirini = isset($_GET['n']) ? base64_decode($_GET['n'], true) : '';
$dir    = $_GET['dir']  ?? '';
$fich   = $_GET['fich'] ?? '';
$ag     = isset($_GET['ag']);

// Validaciones mínimas
if ($ag) {
    if ($dir === '' || $fich === '') {
        header("HTTP/1.1 400 Bad Request");
        echo "Parámetros incompletos.";
        exit;
    }
    $directorio = rtrim(DATA_DIR, '/') . "/cursos/" . $dir . "/recursos/";
} else {
    if ($dirini === '' || $dirini === false || $fich === '') {
        header("HTTP/1.1 400 Bad Request");
        echo "Parámetros inválidos.";
        exit;
    }

    $directorio = rtrim($dirini, '/') . '/' . trim($dir, '/') . '/';
}

// Sanitizar nombre de fichero (evitar ../)
$nombreFich = basename($fich);

// Ruta final
$ruta = $directorio . $nombreFich;$ruta = preg_replace('~//+~', '/', $ruta);
// Normalizar a realpath y comprobar que existe
$real = realpath($ruta);
if ($real === false || !is_file($real) || !is_readable($real)) {
    header("HTTP/1.1 404 Not Found");
    echo "Fichero no encontrado.";
    exit;
}

$root = realpath(DATA_DIR);
if ($root && strpos($real, $root) !== 0) {
    // Si no quieres esta restricción, puedes comentar este bloque
    // pero es recomendable mantenerla.
    header("HTTP/1.1 403 Forbidden");
    echo "Acceso no permitido.";
    exit;
}

// Detectar MIME (básico)
$mime = 'application/octet-stream';
if (function_exists('mime_content_type')) {
    $det = mime_content_type($real);
    if ($det) $mime = $det;
}

// Decide inline/attachment (mínimo cambio: si quieres SIEMPRE descarga, fija attachment)
$disposition = 'inline';
$inlineMimes = [
    'application/pdf', 'text/plain', 'text/html',
    'image/jpeg','image/png','image/gif','image/webp','image/svg+xml',
    'audio/mpeg','audio/ogg','video/mp4','video/webm','video/ogg'
];
if (!in_array($mime, $inlineMimes, true)) {
    $disposition = 'attachment';
}

// Limpia buffers para evitar corrupción de salida
while (function_exists('ob_get_level') && ob_get_level() > 0) { @ob_end_clean(); }

// Headers
$basename = basename($real);
header("X-Content-Type-Options: nosniff");
header("Content-Type: $mime");
header("Content-Length: " . filesize($real));
header("Content-Disposition: $disposition; filename=\"" . rawurlencode($basename) . "\"; filename*=UTF-8''" . rawurlencode($basename));
header("Cache-Control: private, max-age=3600");

// Enviar
$ok = @readfile($real);
if ($ok === false) {
    header("HTTP/1.1 500 Internal Server Error");
    echo "No se pudo leer el fichero.";
}
exit;

?>