<?php
// ========================================
// qr.php — muestra códigos QR generados en DATA_DIR/temp/
// ========================================

require_once __DIR__ . '/siempre_base.php';

// --- validación básica ---
$f = $_GET['f'] ?? '';
$f = basename($f);  // evita rutas tipo ../../

if ($f === '') {
    http_response_code(400);
    exit('Falta parámetro f');
}

// --- seguridad: solo nombres del tipo qr_XXXXX.png ---
if (!preg_match('/^qr_[A-Za-z0-9_-]+\.png$/', $f)) {
    http_response_code(403);
    exit('Nombre de fichero no permitido');
}

// --- ruta real ---
$path = DATA_DIR . "/temp/" . $f;

// --- comprobar existencia ---
if (!is_file($path)) {
    http_response_code(404);
    exit('QR no encontrado');
}

// --- enviar cabeceras ---
header('Content-Type: image/png');
header('Content-Length: ' . filesize($path));
header('Cache-Control: public, max-age=31536000'); // un año
header('Expires: ' . gmdate('D, d M Y H:i:s', time() + 31536000) . ' GMT');

// --- salida del archivo ---
readfile($path);
exit;
?>