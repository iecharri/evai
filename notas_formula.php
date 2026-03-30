<?php

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

function formula($a,$cu,$g,$ilink) {

$sql = "SELECT * FROM cursasigru WHERE asigna = '$a' AND curso = '$cu' AND grupo = '$g'";
$iresult = $ilink->query($sql);
$c = $iresult->fetch_array(MYSQLI_BOTH);

$test1 = number_format($c['test'],2);
$preg1 = number_format($c['preg'],2);
$prac1 = number_format($c['prac'],2);
$eval1 = number_format($c['eval'],2);
$alu1 = number_format($c['votosalumnos'],2);
$pro1 = number_format($c['notaprofesor'],2);
$mintest1 = number_format($c['mintest'],2);
$minpreg1 = number_format($c['minpreg'],2);
$minprac1 = number_format($c['minprac'],2);
$mineval1 = number_format($c['mineval'],2);
$divisor1 = $c['divisor'];
if (!$divisor1) {$divisor1 = 2;}

return array($test1, $preg1, $prac1, $eval1, $alu1, $pro1, $mintest1, $minpreg1, $minprac1, $mineval1, $divisor1);

}

?>