<?php

require_once __DIR__.'/siempre.php';   // sesión + $ilink
require_once APP_DIR .'/estadis_funcis.php';

header('Referrer-Policy: same-origin'); // reduce fuga del token en Referer

$tokF = (string)($_GET['csrf'] ?? '');
$tokS = (string)($_SESSION['csrf'] ?? '');
if ($tokF === '' || $tokS === '' || !hash_equals($tokS, $tokF)) {
  header('Location: home.php'); exit;
}

if (function_exists('demo_enabled') && demo_enabled()) {
  header('Location: home.php'); exit;
}


$id = $_SESSION['usuid'];
$ilink->query("DELETE FROM tempoestadis WHERE id='$id'");
$sql = "INSERT INTO tempoestadis (id,asigna,curso,grupo) SELECT id,asigna,curso,grupo FROM alumasiano	WHERE id = '$id'"; 
$ilink->query($sql);
$sql = "INSERT INTO tempoestadis (id,asigna,curso,grupo) SELECT usuid,asigna,curso,grupo FROM asignatprof WHERE usuid = '$id'";  
$ilink->query($sql);
$sql = "INSERT INTO tempoestadis (id) VALUES ('$id')";  
$ilink->query($sql);
actualizar($id, '', '', '', $ilink);

// Rota el token para evitar reusos
$_SESSION['csrf'] = bin2hex(random_bytes(16));

//para no hacerlo en var_usu.php, ya que ralentiza, lo incluyo aqui
$asicurgru = strtoupper($_SESSION['asigna']."$$".$_SESSION['curso']."$$".$_SESSION['grupo']);
$titcur = strtoupper($_SESSION['tit']."$$".$_SESSION['curso']);

$dirini = DATA_DIR ."/cursos/$asicurgru/";

if (!is_dir($dirini)){safe_mkdir($dirini);}
if (!is_dir($dirini."actividades/")){safe_mkdir($dirini."actividades/");}
if (!is_dir($dirini."recursos/")){safe_mkdir($dirini."recursos/");}
if (!is_dir($dirini."contenidos/")){safe_mkdir($dirini."contenidos/");}
if (!is_dir($dirini."trabajos/")){safe_mkdir($dirini."trabajos/");}
if (!is_dir($dirini."claseactual/")){safe_mkdir($dirini."claseactual/");}
if (!is_dir($dirini."modulos/")){safe_mkdir($dirini."modulos/");}
if (!is_dir($dirini."compartida/")){safe_mkdir($dirini."compartida/");}

$dirini = DATA_DIR ."/cursos/$titcur/";
$dirini1 = DATA_DIR ."/cursos/$titcur1/";
if (!is_dir($dirini)){safe_mkdir($dirini);}
if (!is_dir($dirini."actividades/")){safe_mkdir($dirini."actividades/");}
if (!is_dir($dirini."recursos/")){safe_mkdir($dirini."recursos/");}
if (!is_dir($dirini."contenidos/")){safe_mkdir($dirini."contenidos/");}
if (!is_dir($dirini."trabajos/")){safe_mkdir($dirini."trabajos/");}
if (!is_dir($dirini."claseactual/")){safe_mkdir($dirini."claseactual/");}
if (!is_dir($dirini."modulos/")){safe_mkdir($dirini."modulos/");}
if (!is_dir($dirini."compartida/")){safe_mkdir($dirini."compartida/");}

header('Location: home.php'); 
exit;

?>