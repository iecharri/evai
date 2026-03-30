<?php

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');
 
function ponerVideoHtml5(string $videoUrl, int $maxPx = 480, ?string $poster = null, bool $autoplay = false): string {
    $src = htmlspecialchars($videoUrl, ENT_QUOTES, 'UTF-8');
    $posterAttr   = $poster ? ' poster="'.htmlspecialchars($poster, ENT_QUOTES, 'UTF-8').'"' : '';
    $autoplayAttr = $autoplay ? ' autoplay muted playsinline' : '';

    $path = parse_url($videoUrl, PHP_URL_PATH) ?? '';
    $ext  = strtolower(pathinfo($path, PATHINFO_EXTENSION));
    $type = ($ext === 'webm') ? 'video/webm' : (($ext === 'ogv' || $ext === 'ogg') ? 'video/ogg' : 'video/mp4');

    return '<div class="galeria-item" style="max-width:'.$maxPx.'px;">'
         .   '<video controls preload="metadata"'.$posterAttr.$autoplayAttr.'>'
         .     '<source src="'.$src.'" type="'.$type.'">'
         .     'Tu navegador no soporta vídeo HTML5.'
         .   '</video>'
         . '</div>';
}

function poneryoutub(string $linkyout, int $maxPx = 480): string {
    // Si te llega una URL completa, quédate con el ID (opcional: elimina esto si ya pasas el ID).
    if (preg_match('~^(?:https?://)?(?:www\\.)?(?:youtube\\.com|youtu\\.be)/~i', $linkyout)) {
        // ID desde v=, youtu.be/, /embed/, /shorts/...
        if (preg_match('~(?:v=|/embed/|/shorts/|youtu\\.be/)([A-Za-z0-9_-]{10,})~', $linkyout, $m)) {
            $linkyout = $m[1];
        }
    }

    $id = htmlspecialchars($linkyout, ENT_QUOTES, 'UTF-8');
    return '<div class="galeria-item" style="max-width:'.$maxPx.'px;">'
         .   '<iframe '
         .     'src="https://www.youtube.com/embed/'.$id.'" '
         .     'title="YouTube video" frameborder="0" '
         .     'allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" '
         .     'allowfullscreen></iframe>'
         . '</div>';
}
 
 
 
?>