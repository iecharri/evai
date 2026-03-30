<?php
require __DIR__ . '/config.php';

// Sexo: h/m. Por defecto "h" 
$sx = strtolower(trim($_GET['s']) ?? 'h'); //
$sx = ($sx && $sx[0] === 'm')? 'm' : 'h'; // normaliza: cualquier cosa que empiece por "m" -> m, si no -> h  // 

// Nombre relativo del archivo (opcional): p.ej. "1foto23.png"
$f = trim((string)($_GET['f'] ?? ''));
$f = basename($f);                  // sin rutas
$f = str_replace(['..','/','\\'], '', $f);

// Si viene "f", intentamos servirlo desde DATA_DIR/fotos/
$foto = null;
if ($f !== '') {
    $cand = DATA_DIR . "/fotos/" . $f;
    if (is_file($cand)) {
        $foto = $cand;
    }
}

// Fallback: placeholder público según sexo
if (!$foto) {
    $foto = MEDIA_DIR . "/imag/nofoto{$sx}.png";
}

// Seguridad extra
if (!is_file($foto)) {
    http_response_code(404);
    exit('Imagen no encontrada');
}

// Detectar MIME y servir
$finfo = finfo_open(FILEINFO_MIME_TYPE);
$mime  = finfo_file($finfo, $foto) ?: 'image/png';
finfo_close($finfo);

header('Content-Type: ' . $mime);
header('Content-Length: ' . filesize($foto));
header('Cache-Control: public, max-age=86400'); // cachea 1 día
readfile($foto);
exit;
