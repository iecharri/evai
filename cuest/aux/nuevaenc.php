<?php

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

//crear dos tablas

//Estructura de ambas tablas:

$sql = "
CREATE TABLE IF NOT EXISTS `".$nuevocuest."1` (
  n INT(3) NOT NULL DEFAULT 0,
  n1 INT(2) NOT NULL DEFAULT 0,
  p LONGTEXT DEFAULT NULL,
  tipo CHAR(1) DEFAULT NULL,
  amin INT(3) DEFAULT NULL,
  amax INT(3) DEFAULT NULL,
  input CHAR(50) DEFAULT NULL,
  defec CHAR(30) DEFAULT NULL,
  m DECIMAL(3,2) DEFAULT NULL,
  d DECIMAL(3,2) DEFAULT NULL,
  r LONGTEXT DEFAULT NULL,
  respcorr INT(2) DEFAULT NULL,
  visible INT(1) DEFAULT NULL,
  guardar INT(1) DEFAULT NULL,
  mn INT(4) DEFAULT NULL,
  visialuresp INT(1) DEFAULT NULL,
  formula VARCHAR(30) DEFAULT NULL,
  ordenadas INT(1) DEFAULT NULL,
  alfabet INT(1) DEFAULT NULL,
  imagen LONGBLOB NOT NULL,
  tipofich VARCHAR(255) DEFAULT NULL,
  ancho VARCHAR(3) DEFAULT NULL,
  youtube VARCHAR(255) DEFAULT NULL,
  anchoyoutube VARCHAR(3) DEFAULT NULL,
  sinnum INT(1) DEFAULT NULL,
  orden INT(6) DEFAULT 999999,
  soloano INT(4) NOT NULL,
  PRIMARY KEY (n, n1)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
";

if (!$ilink->query($sql)) {return;}

$sql = "INSERT INTO $nuevocuest"."1 () VALUES ()";
if (!$ilink->query($sql)) {return;}

$sql = "UPDATE $nuevocuest"."1 SET sinnum=1";
if (!$ilink->query($sql)) {return;}

$sql = "
CREATE TABLE IF NOT EXISTS `".$nuevocuest."2` (
  u CHAR(16) DEFAULT NULL,
  cu INT(11) NOT NULL DEFAULT 0,
  n INT(3) NOT NULL DEFAULT 0,
  v1 INT(10) DEFAULT NULL,
  v2 CHAR(255) DEFAULT NULL,
  v3 LONGTEXT DEFAULT NULL,
  usuid INT(10) DEFAULT NULL,
  obs CHAR(255) DEFAULT NULL,
  datetime DATETIME DEFAULT NULL,
  t_ini DATETIME DEFAULT NULL,
  aciertoerror INT(1) NOT NULL,
  nota DECIMAL(4,2) NOT NULL,
  codigo VARCHAR(50) NOT NULL,
  PRIMARY KEY (cu, n)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
";

if (!$ilink->query($sql)) {return;}

?>