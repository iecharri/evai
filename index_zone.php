<?php
if (
    (empty($_SESSION['zone']) || ($_SESSION['zone'] === 'UTC' && empty($_COOKIE['zone'])))
    && empty($_SESSION['zone_try'])
) {
    $_SESSION['zone_try'] = 1;   // ← evita recarga infinita

    echo <<<HTML
<!doctype html><meta charset="utf-8">
<script>
(function () {
  function reload(){ location.replace(location.href); }
  var tz = 'UTC';
  try {
    var o = (typeof Intl!=='undefined' && Intl.DateTimeFormat && Intl.DateTimeFormat().resolvedOptions)
            ? Intl.DateTimeFormat().resolvedOptions() : null;
    if (o && typeof o.timeZone==='string') tz = o.timeZone;
  } catch(e){}
  if (!/^[A-Za-z_]+\\/[A-Za-z_]+(?:\\/[A-Za-z_]+)?$/.test(tz)) tz = 'UTC';

  var guard = setTimeout(reload, 1500);

  fetch("index_set_zone.php", {
    method:"POST",
    headers:{ "Content-Type":"application/x-www-form-urlencoded" },
    body: "zone=" + encodeURIComponent(tz) + "&ts=" + Date.now(),
    credentials:"same-origin"
  }).then(function(){ clearTimeout(guard); reload(); })
    .catch(function(){ clearTimeout(guard); reload(); });
})();
</script>
HTML;
    exit;
}

if (!empty($_SESSION['zone']) || !empty($_COOKIE['zone'])) {
    unset($_SESSION['zone_try']);
}
?>

