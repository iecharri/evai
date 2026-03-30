<?php

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

// actualizo cr&eacute;ditos asignados, m&aacute;ximos y m&iacute;nimos en tabla profcurareafigura 

$sql = "SELECT profeid, curso, figura FROM profcurareafigura WHERE curso = '".trim($filtrocurso)."'";

$result = $ilink->query($sql);
while ($fila = $result->fetch_array(MYSQLI_BOTH)) {$y++;
 	$sql1 = "SELECT sum(creditos) FROM podcursocargos LEFT JOIN profecargos ON podcursocargos.codcargo = profecargos.cargo AND profecargos.curso = '$fila[1]' AND profeid='$fila[0]'";
 	$iresult = $ilink->query($sql1);
	$cargos = $iresult->fetch_array(MYSQLI_BOTH);
	if (!$cargos[0]) {$cargos[0] = 0;}
	$sql2 = "UPDATE profcurareafigura SET credasignados = (SELECT sum(ct)+sum(cp)+sum(cte)+sum(cpr)+sum(cl)+sum(cs)+sum(ctu)+sum(ce) FROM asignatprof WHERE 
				usuid = '$fila[0]' AND curso = '$fila[1]'),
				credmax = ((SELECT sum(creditos) FROM podcursofigura WHERE codfigura = '$fila[2]' AND curso = '$fila[1]') - $cargos[0]),
				credmin = ((SELECT sum(creditosmin) FROM podcursofigura WHERE codfigura = '$fila[2]' AND curso = '$fila[1]') - $cargos[0])
				WHERE profeid = '$fila[0]' AND curso = '$fila[1]'";
	$ilink->query($sql2);
}

$sql = "SELECT asigna, ct, cp, cte, cpr, cl, cs, ctu, ce, area FROM podcursoasignaarea WHERE curso = '$filtrocurso'";
$result = $ilink->query($sql);
while ($fila = $result->fetch_array(MYSQLI_BOTH)) {
	$iresult = $ilink->query("SELECT sum(ct), sum(cp), sum(cte), sum(cpr), sum(cl), sum(cs), sum(ctu), sum(ce) FROM asignatprof 
	WHERE asigna = '".$fila['asigna']."' AND area = '".$fila['area']."' AND curso = '$filtrocurso'");
	$temp = $iresult->fetch_array(MYSQLI_BOTH);
	$x = ($fila[1] - $temp[0]);
	$ilink->query("UPDATE podcursoasignaarea SET ctxa = '$x' WHERE asigna ='$fila[0]' AND curso = '$filtrocurso' AND area = '".$fila['area']."'");
	$x = ($fila[2] - $temp[1]);
	$ilink->query("UPDATE podcursoasignaarea SET cpxa = '$x' WHERE asigna ='$fila[0]' AND curso = '$filtrocurso' AND area = '".$fila['area']."'");
	$x = ($fila[3] - $temp[2]);
	$ilink->query("UPDATE podcursoasignaarea SET ctexa = '$x' WHERE asigna ='$fila[0]' AND curso = '$filtrocurso' AND area = '".$fila['area']."'");
	$x = ($fila[4] - $temp[3]);
	$ilink->query("UPDATE podcursoasignaarea SET cprxa = '$x' WHERE asigna ='$fila[0]' AND curso = '$filtrocurso' AND area = '".$fila['area']."'");
	$x = ($fila[5] - $temp[4]);
	$ilink->query("UPDATE podcursoasignaarea SET clxa = '$x' WHERE asigna ='$fila[0]' AND curso = '$filtrocurso' AND area = '".$fila['area']."'");
	$x = ($fila[6] - $temp[5]);
	$ilink->query("UPDATE podcursoasignaarea SET csxa = '$x' WHERE asigna ='$fila[0]' AND curso = '$filtrocurso' AND area = '".$fila['area']."'");
	$x = ($fila[7] - $temp[6]);
	$ilink->query("UPDATE podcursoasignaarea SET ctuxa = '$x' WHERE asigna ='$fila[0]' AND curso = '$filtrocurso' AND area = '".$fila['area']."'");
	$x = ($fila[8] - $temp[7]);
	$ilink->query("UPDATE podcursoasignaarea SET cexa = '$x' WHERE asigna ='$fila[0]' AND curso = '$filtrocurso' AND area = '".$fila['area']."'");
}

echo i("hecho",$ilink);


?>