<?php

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

//nueva bolsa de preguntas. $bolsa es el nombre de la asignatura. La bolsa deberá llevar un guión bajo al final

//Estructura de una bolsa de preguntas

$sql = "
CREATE TABLE IF NOT EXISTS `".$bolsa."_` (
  n INT(3) NOT NULL DEFAULT 0,
  n1 INT(2) NOT NULL,
  p LONGTEXT DEFAULT NULL,
  tipo CHAR(1) DEFAULT NULL,
  amin INT(3) DEFAULT NULL,
  amax INT(3) DEFAULT NULL,
  input CHAR(50) DEFAULT NULL,
  m DECIMAL(4,2) DEFAULT NULL,
  d DECIMAL(3,2) DEFAULT NULL,
  r LONGTEXT DEFAULT NULL,
  respcorr INT(2) DEFAULT NULL,
  pordefec INT(1) DEFAULT NULL,
  imagen LONGBLOB NOT NULL,
  tipofich VARCHAR(255) DEFAULT NULL,
  ancho VARCHAR(3) DEFAULT NULL,
  youtube VARCHAR(255) DEFAULT NULL,
  anchoyoutube VARCHAR(3) DEFAULT NULL,
  orden INT(6) DEFAULT 999999,
  PRIMARY KEY (n, n1)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
";

if (!$ilink->query($sql)) {return;}

?>