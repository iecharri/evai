<?php

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>EVAi Entorno Virtual de Aprendizaje Interactivo</title>
  <meta name="description" content="Acceso a EVAi, la plataforma educativa interactiva que permite aprendizaje colaborativo, seguimiento de alumnos y evaluación en línea.">
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <link rel="shortcut icon" href="<?php echo MEDIA_URL; ?>/imag/favicon.ico" type="image/x-icon">
	<link rel="canonical" href="https://evaidemo.org/" />

  <link rel="stylesheet" href='<?php echo APP_URL;?>/css/normalize.css'>
  <link rel="stylesheet" href='<?php echo APP_URL;?>/css/lateral.css'>
  <link rel="stylesheet" href='<?php echo APP_URL;?>/css/fonts.css'>
  <link rel="stylesheet" href='<?php echo APP_URL;?>/css/jdatepicker.css'>
  <link rel="stylesheet" href='<?php echo APP_URL;?>/css/print.css' media="print">

  <link rel="stylesheet" type="text/css" href='<?php echo APP_URL;?>/css/estilotodos.css?v=2' media="screen">

  <link rel="stylesheet" href="<?php echo APP_URL;?>/css/tema.css?v=3">
  <link rel="stylesheet" href="<?php echo APP_URL;?>/css/calendario.css?v=2">
  
	<?php $color = $_SESSION['paleta'] ?? 'amarillo';?> 
	<link rel="stylesheet" type="text/css" href="<?php echo APP_URL;?>/css/tema-<?php echo htmlspecialchars($color);?>.css?v=debug63"  media="screen">

  <!-- JS clásicos -->
  <script src='<?php echo APP_URL;?>/jqueryetc/jquery.min.js'></script>
  <script src='<?php echo APP_URL;?>/jqueryetc/jquery-ui.js'></script>
  <script src='<?php echo APP_URL;?>/jqueryetc/jquery.form.js'></script>
  <script src='<?php echo APP_URL;?>/jqueryetc/jquery.ui.touch-punch.min.js'></script>
  <script src='<?php echo APP_URL;?>/js/js.js?v=2'></script>

  <link rel="stylesheet" href='<?php echo APP_URL;?>/jqueryetc/jquery-ui.css'>
  <link rel="stylesheet" href='<?php echo APP_URL;?>/jqueryetc/css.css'>

  <?php
  if (!$_GET['sala']) {
    require_once APP_DIR . '/jcabfunci.php';
    require_once APP_DIR . '/jdatepicker.php';
  }

  if ($script == "agenda") {
    require_once APP_DIR . '/jagenda.php';
  }
  ?>

<script>
document.addEventListener('DOMContentLoaded', function () {
  // 1) Pintar cualquier fecha UTC que venga en data-utc (YYYY-MM-DD HH:MM[:SS])
  document.querySelectorAll('.fechautc').forEach(function (el) {
    const utcRaw = (el.dataset.utc || '').trim();
    if (!utcRaw) return;

    const hasT = utcRaw.includes('T');
    const iso = (hasT ? utcRaw : utcRaw.replace(' ', 'T')) + 'Z';

    const d = new Date(iso);
    if (!isNaN(d)) {
      el.textContent = new Intl.DateTimeFormat(undefined, {
        dateStyle: 'medium',
        timeStyle: 'short'
      }).format(d);
    }
  });

  // 2) Sincronizar zona navegador ↔ cookie/servidor
  const navegadorZone = Intl.DateTimeFormat().resolvedOptions().timeZone;
  const cookieZone = document.cookie.split('; ').find(row => row.startsWith('zone='))
                     ?.split('=')[1];

  // Si falta cookie o ha cambiado, actualizamos
  if (!cookieZone || cookieZone !== navegadorZone) {
    document.cookie = "zone=" + encodeURIComponent(navegadorZone)
                    + "; max-age=31536000; path=/";

    fetch("<?php echo APP_URL; ?>/setzona.php?zone=" + encodeURIComponent(navegadorZone), {
      method: "GET",
      credentials: "same-origin"
    }).catch(() => {});
  }
});
</script>

<script>
  if (window.self !== window.top) {
    document.documentElement.classList.add('embed');
  }
</script>

</head>
