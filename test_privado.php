<?php

// diag_webempresa.php — diagnóstico de escritura en /home2/hosting167433eu/evai

error_reporting(E_ALL);
ini_set('display_errors', '1');

define('HOST_ROOT', '/home2/hosting167433eu');
define('APP_DIR',  HOST_ROOT . '/public_html/evai0');
define('DATA_DIR', HOST_ROOT . '/evai');

function p($k, $v) { echo "<div><b>$k:</b> <code>" . htmlspecialchars((string)$v) . "</code></div>"; }
function hr() { echo "<hr>"; }

echo "<h2>EVAi · Diagnóstico de escritura</h2>";

p('PHP SAPI', php_sapi_name());
p('PHP User (get_current_user)', get_current_user());
if (function_exists('posix_geteuid')) {
  $uid = posix_geteuid();
  $info = @posix_getpwuid($uid);
  p('PHP EUID', $uid);
  if ($info) p('PHP user (POSIX)', $info['name'] ?? '');
}
p('open_basedir', ini_get('open_basedir') ?: '(sin restricción)');
p('APP_DIR', APP_DIR);
p('DATA_DIR', DATA_DIR);
p('realpath(DATA_DIR)', @realpath(DATA_DIR));

hr();
echo "<h3>Comprobaciones de permisos</h3>";
p('is_dir(DATA_DIR)', is_dir(DATA_DIR) ? 'sí' : 'no');
p('is_writable(DATA_DIR)', is_writable(DATA_DIR) ? 'sí' : 'no');
p('is_executable(DATA_DIR)', is_executable(DATA_DIR) ? 'sí' : 'no');

$testSub = DATA_DIR . '/prueba';
$testFile = $testSub . '/test.txt';
p('carpeta prueba', $testSub);
p('archivo prueba', $testFile);

hr();
echo "<h3>Intento 1: crear subcarpeta</h3>";
if (!is_dir($testSub)) {
  $mk = @mkdir($testSub, 0775, true);
  p('mkdir', $mk ? 'ok' : 'fallo');
  if (!$mk && ($e = error_get_last())) p('mkdir error', $e['message'] ?? '');
} else {
  echo "La carpeta ya existe.<br>";
}
p('is_dir($testSub)', is_dir($testSub) ? 'sí' : 'no');
p('is_writable($testSub)', is_writable($testSub) ? 'sí' : 'no');

hr();
echo "<h3>Intento 2: escribir con file_put_contents</h3>";
$contenido = "Prueba EVAi (" . date('Y-m-d H:i:s') . ")\n";
$w = @file_put_contents($testFile, $contenido);
p('file_put_contents bytes', $w !== false ? $w : 'fallo');
if ($w === false && ($e = error_get_last())) p('fputc error', $e['message'] ?? '');

hr();
echo "<h3>Intento 3: escribir con fopen('a')</h3>";
$f = @fopen($testFile, 'ab');
p('fopen', $f ? 'ok' : 'fallo');
if (!$f && ($e = error_get_last())) p('fopen error', $e['message'] ?? '');
if ($f) {
  $fw = @fwrite($f, "línea append " . date('H:i:s') . "\n");
  p('fwrite bytes', $fw !== false ? $fw : 'fallo');
  @fclose($f);
  p('fclose', 'ok');
}

hr();
echo "<h3>Lectura</h3>";
if (is_readable($testFile)) {
  echo "<pre>" . htmlspecialchars(file_get_contents($testFile)) . "</pre>";
} else {
  echo "Archivo no legible o no existe.<br>";
}

hr();
echo "<h3>Consejos según resultado</h3>";
echo "<ul>";
echo "<li>Si <b>open_basedir</b> no incluye <code>/home2/hosting167433eu</code>, pide a soporte que lo añadan o te indiquen una ruta permitida (a veces usan otra raíz).</li>";
echo "<li>Si <b>is_writable(DATA_DIR) = no</b> y el usuario de PHP NO coincide con tu usuario, cambia permisos de la carpeta base:</li>";
echo "</ul>";
echo "<pre>chmod 2775 /home2/hosting167433eu/evai
chmod -R ug+rwX /home2/hosting167433eu/evai
# (opcional) asegurar grupo correcto
chgrp -R hosting167433eu /home2/hosting167433eu/evai
</pre>";
echo "<ul><li>El bit <b>2</b> en <code>2775</code> (setgid) hace que los nuevos archivos hereden el grupo, evitando problemas.</li></ul>";

echo "<p>Si nada de esto funciona, copia aquí el bloque de salida y lo afinamos.</p>";

?> 
 
 
 
 


<?php return; exit;
// test_webempresa.php
// Prueba de creación de carpeta y archivo en Webempresa (fuera de public_html)

// Ajusta si lo necesitas — por defecto en tu hosting Webempresa:
define('HOST_ROOT', '/home2/hosting167433eu');        // raíz de hosting
define('APP_DIR',  HOST_ROOT . '/public_html/evai0'); // carpeta de la app
define('DATA_DIR', HOST_ROOT . '/evai');              // carpeta de datos privada (fuera del public_html)

$subfolder = 'prueba';
$carpeta = rtrim(DATA_DIR, '/') . '/' . $subfolder;
$archivo  = $carpeta . '/test.txt';

function salida($msg) {
    echo $msg . "<br>";
}

// Informe inicial
salida("📁 APP_DIR: " . htmlspecialchars(APP_DIR));
salida("🔒 DATA_DIR objetivo: " . htmlspecialchars(DATA_DIR));
salida("➡️ Carpeta a crear: " . htmlspecialchars($carpeta));
salida("➡️ Archivo a crear: " . htmlspecialchars($archivo));

// 1) Comprobación de seguridad: DATA_DIR fuera de APP_DIR
if (strpos(realpath(DATA_DIR), realpath(APP_DIR)) === 0) {
    salida("⚠️ Atención: DATA_DIR está dentro de APP_DIR. Por seguridad conviene que quede fuera del public_html.");
} else {
    salida("✅ DATA_DIR parece estar fuera de APP_DIR (buena práctica).");
}

// 2) Intentar crear la carpeta (recursiva)
if (!is_dir($carpeta)) {
    if (@mkdir($carpeta, 0775, true)) {
        salida("✅ Carpeta creada: " . htmlspecialchars($carpeta));
    } else {
        $err = error_get_last();
        salida("❌ No se pudo crear la carpeta: " . htmlspecialchars($carpeta));
        if ($err && isset($err['message'])) {
            salida("ℹ️ Error PHP: " . htmlspecialchars($err['message']));
        }
        salida("🔧 Posibles causas: permisos insuficientes o restricciones 'open_basedir'.");
        salida("Sugerencias:");
        salida("- Revisa permisos/propietario de " . htmlspecialchars(HOST_ROOT) . " y que tu usuario PHP tenga permiso para escribir en " . htmlspecialchars(DATA_DIR));
        salida("- Si tienes SSH, ejecuta (ajusta el usuario):");
        salida("<code>mkdir -p " . htmlspecialchars($carpeta) . " && chown -R tu_usuario:tu_usuario " . htmlspecialchars(DATA_DIR) . " && chmod -R 775 " . htmlspecialchars(DATA_DIR) . "</code>");
        salida("- Si no tienes SSH, crea la carpeta vía FTP/Panel de Webempresa o pide a soporte que la cree y te asigne permisos.");
        exit;
    }
} else {
    salida("ℹ️ Carpeta ya existía: " . htmlspecialchars($carpeta));
}

// 3) Crear el archivo de prueba
$contenido = "EVAi prueba Webempresa — creado el " . date('Y-m-d H:i:s') . " (server)\n";
$ok = @file_put_contents($archivo, $contenido);

if ($ok !== false) {
    salida("✅ Archivo creado: " . htmlspecialchars($archivo));
    // Mostrar contenido (si es legible)
    if (is_readable($archivo)) {
        salida("📄 Contenido del archivo:");
        echo "<pre>" . htmlspecialchars(file_get_contents($archivo)) . "</pre>";
    } else {
        salida("⚠️ Archivo creado pero no se puede leer (permisos).");
    }
} else {
    $err = error_get_last();
    salida("❌ No se pudo escribir el archivo: " . htmlspecialchars($archivo));
    if ($err && isset($err['message'])) salida("ℹ️ Error PHP: " . htmlspecialchars($err['message']));
    salida("🔧 Comprueba permisos de escritura en la carpeta: " . htmlspecialchars($carpeta));
    exit;
}

// 4) Información adicional útil
salida("👀 Comprueba también en el panel de Webempresa si hay restricciones de seguridad (ej. open_basedir).");
salida("🛡️ Si Webempresa impide escritura fuera de public_html, crea la carpeta /home2/hosting167433eu/evai desde el panel de control o pide soporte para que la cree con propietario correcto.");
?>




<?php return;exit;
// test_privado.php

// Ruta de la carpeta de datos privada (fuera del DocumentRoot)
$dir = '/datos/server/evai';

// Carpeta y archivo de prueba
$carpeta = $dir . '/prueba';
$archivo = $carpeta . '/test.txt';

// Crear carpeta si no existe
if (!is_dir($carpeta)) {
    if (!mkdir($carpeta, 0775, true)) {
        die("❌ No se pudo crear la carpeta: $carpeta");
    } else {
        echo "✅ Carpeta creada: $carpeta<br>";
    }
} else {
    echo "ℹ️ Carpeta ya existía: $carpeta<br>";
}

// Crear archivo de prueba
$contenido = "Esto es un archivo de prueba creado el " . date('Y-m-d H:i:s') . "\n";
if (file_put_contents($archivo, $contenido) !== false) {
    echo "✅ Archivo creado: $archivo<br>";
} else {
    echo "❌ Error al crear el archivo: $archivo<br>";
}

// Verificar permisos
if (is_readable($archivo)) {
    echo "📄 Contenido del archivo:<pre>" . htmlspecialchars(file_get_contents($archivo)) . "</pre>";
} else {
    echo "⚠️ No se puede leer el archivo (permisos?).";
}
?>
