<?php

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

function zodiaco($fecha) {

if ($fecha == "0000-00-00") {return;}

$ano = substr($fecha,0,4);

if ($fecha >= $ano."-03-21" AND $fecha <= $ano."-04-21") {$z = "Aries";}
if ($fecha >= $ano."-04-22" AND $fecha <= $ano."-05-21") {$z = "Tauro";}
if ($fecha >= $ano."-05-22" AND $fecha <= $ano."-06-21") {$z = "Géminis";}
if ($fecha >= $ano."-06-22" AND $fecha <= $ano."-07-22") {$z = "Cáncer";}
if ($fecha >= $ano."-07-23" AND $fecha <= $ano."-08-22") {$z = "Leo";}
if ($fecha >= $ano."-08-23" AND $fecha <= $ano."-09-22") {$z = "Virgo";}
if ($fecha >= $ano."-09-23" AND $fecha <= $ano."-10-22") {$z = "Libra";}
if ($fecha >= $ano."-10-23" AND $fecha <= $ano."-11-22") {$z = "Escorpio";}
if ($fecha >= $ano."-11-23" AND $fecha <= $ano."-12-21") {$z = "Sagitario";}
if ($fecha >= $ano."-12-22" OR $fecha <= $ano."-01-20") {$z = "Capricornio";}
if ($fecha >= $ano."-01-21" AND $fecha <= $ano."-02-20") {$z = "Acuario";}
if ($fecha >= $ano."-02-21" AND $fecha <= $ano."-03-20") {$z = "Piscis";}

return $z;

}

?>