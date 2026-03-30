<?php

// Copyright (c) 2000-2026 Inmaculada Echarri San Adrián
// Copyright (c) 2000-2026 Antonio Grandío Botella
// This file is part of EVAI.
// Licensed under the MIT License.
// See LICENSE.txt for details.

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

$caso = 6; require_once APP_DIR . "/pod/podformfiltro.php";

if (!$filtrocurso OR !$filtroarea) {
	echo "<p class='rojo b'>&iexcl;ATENCI&Oacute;N! seleccionar un CURSO y un &Aacute;REA</p>";
	return;
}

?>

<script language="javascript">
	function prueba(form1) {
		if (document.form1.borrar.checked) {
			return confirm("<?php echo i("confirmborr",$ilink);?>");
		}
	}
</script>

<?php

// -------------------------------------------------- Asignaturas: Cr&eacute;ditos del curso (y &aacute;rea) por asignar // --------------------------------------------------


echo "<table class='tancha conhover'>";

echo "<tr><th>".i("asigna",$ilink)."</th>";
echo "<th class='col-01' title='CT'>CT</th><th class='col-01' title='CP'>CP</th><th class='col-01' title='Total'>Tradicionales</th>";
echo "<th class='col-01' title='CT'>CT</th><th class='col-01' title='CP'>CP</th>";
echo "<th class='col-01' title='CL'>CL</th><th class='col-01' title='CS'>CS</th>";
echo "<th class='col-01' title='CTu'>CTu</th><th class='col-01' title='CE'>CE</th><th class='col-01' title='Total'>ECTS</th>";
echo "<th class='col-01' title='CTu'>Total</th></tr>";

$sql = "SELECT podcursoasignaarea.asigna, asignatura, ctxa, cpxa, ctexa, cprxa, clxa, csxa, ctuxa, cexa
		  FROM podcursoasignaarea LEFT JOIN podasignaturas ON podcursoasignaarea.asigna = podasignaturas.cod
			WHERE podcursoasignaarea.area AND podcursoasignaarea.curso = '".trim($filtrocurso)."' AND podcursoasignaarea.area = '$filtroarea'";
	
$sql .= " ORDER BY podcursoasignaarea.asigna, area";
$result = $ilink->query($sql);
while ($fila = $result->fetch_array(MYSQLI_BOTH)) {
	$a = 0; $b = 0;
	if ($fila['ctxa']==0 AND $fila['cpxa']==0 AND $fila['ctexa']==0 AND $fila['cprxa']==0 AND $fila['clxa']==0 AND $fila['caxa']==0 AND $fila['ctuxa']==0 AND $fila['cexa']==0) {continue;}
	echo "<tr>";
	echo "<td class='col-9'>".$fila['asigna']."";
	echo " - ".$fila['asignatura']."</td>";
	echo "<td class='ri col-01'>";
	if ($fila['ctxa'] != 0) {$a = 1; echo $fila['ctxa']; $tot1 = $tot1 + $fila['ctxa'];}
	echo "</td>";
	echo "<td class='ri col-01'>";
	if ($fila['cpxa'] != 0) {$a = 1; echo $fila['cpxa']; $tot2 = $tot2 + $fila['cpxa'];}
	echo "</td>";
	echo "<td class='ri col-01' style='background:#E3DCD9'>";
	if ($a) {echo $fila['ctxa'] + $fila['cpxa'];}
	echo "</td>";
	echo "<td class='ri col-01'>";
	if ($fila['ctexa'] != 0) {$b = 1; echo $fila['ctexa']; $tot2 = $tot2 + $fila['ctexa'];}
	echo "</td>";
	echo "<td class='ri col-01'>";
	if ($fila['cprxa'] != 0) {$b = 1; echo $fila['cprxa']; $tot2 = $tot2 + $fila['cprxa'];}
	echo "</td>";
	echo "<td class='ri col-01'>";
	if ($fila['clxa'] != 0) {$b = 1; echo $fila['clxa']; $tot2 = $tot2 + $fila['clxa'];}
	echo "</td>";
	echo "<td class='ri col-01'>";
	if ($fila['csxa'] != 0) {$b = 1; echo $fila['csxa']; $tot2 = $tot2 + $fila['csxa'];}
	echo "</td>";
	echo "<td class='ri col-01'>";
	if ($fila['ctuxa'] != 0) {$b = 1; echo $fila['ctuxa']; $tot2 = $tot2 + $fila['ctuxa'];}
	echo "</td>";
	echo "<td class='ri col-01'>";
	if ($fila['cexa'] != 0) {$b = 1; echo $fila['cexa']; $tot2 = $tot2 + $fila['cexa'];}
	echo "</td>";
	echo "<td class='ri col-01' style='background:#E3DCD9'>";
	if ($b) {echo $fila['ctexa']+$fila['cprxa']+$fila['clxa']+$fila['csxa']+$fila['ctuxa']+$fila['cexa'];}
	echo "</td>";
	echo "<td>";
	if ($a OR $b) {echo $fila['ctxa']+$fila['cpxa']+$fila['ctexa']+$fila['cprxa']+$fila['clxa']+$fila['csxa']+$fila['ctuxa']+$fila['cexa'];}
	echo "</td>";
}

echo "</table>";

echo "<br>";

// -------------------------------------------------- Profesores: Cr&eacute;ditos // --------------------------------------------------

echo "<table class='tancha conhover'>";
echo "<tr><th class='col-10'>".i("profesor",$ilink)."</th><th class='col-01'>Cr&eacute;ditos M&aacute;ximos</th>
<th class='col-01'>Cr&eacute;ditos M&iacute;nimos</th><th class='col-01'>Cr&eacute;ditos Asignados</th><th class='col-01'>Cr&eacute;ditos por asignar <br>(o quitar)</th></tr>";

$sql = "SELECT profeid, credmax, credmin, credasignados FROM profcurareafigura";
$sql .= " LEFT JOIN usuarios ON profcurareafigura.profeid = usuarios.id";
$sql .= " WHERE (credmax < credasignados OR credmin > credasignados) AND curso = '".trim($filtrocurso)."'";
if ($filtroarea) {$sql .= " AND area = '$filtroarea'";}
$sql .= " ORDER BY alumnoa, alumnon";
$result = $ilink->query($sql);
while ($fila = $result->fetch_array(MYSQLI_BOTH)) {

	echo "<tr><td><a href='ficha.php?id=".$fila['profeid']."'>";
	$usu = ponerusu($fila['profeid'],1,$ilink);
	echo $usu[0].$usu[1];
	echo "</a></td><td class='ri'>".$fila['credmax']."</td><td class='ri'>".$fila['credmin']."</td><td class='ri'>".$fila['credasignados']."</td>";
	echo "<td class='ri nowrap'>";
	if ($fila['credmin'] - $fila['credasignados'] < 0) {
		echo "Por exceso: ";
		$temp = $fila['credasignados'] - $fila['credmax'];
		$signo = 1;
	} else {
		$temp = $fila['credmin'] - $fila['credasignados'];
	}
	echo number_format($temp,2,'.','');
	$temp = "";
	$signo = "";
	echo "</td>";
	echo "</tr>";

}

echo "</table>";

// --------------------------------------------------

echo "<br><span class='txth b'>Profesores con Cr&eacute;ditos en exceso respecto al m&iacute;nimo</span>";

echo "<table class='tancha conhover'>";

echo "<tr><th class='col-10'>".i("profesor",$ilink)."</th><th class='col-01'>Cr&eacute;ditos M&aacute;ximos</th>
<th class='col-01'>Cr&eacute;ditos M&iacute;nimos</th><th class='col-01'>Cr&eacute;ditos Asignados</th><th class='col-01'>Cr&eacute;ditos que se le pueden quitar</th></tr>";

$sql = "SELECT profeid, credmax, credmin, credasignados FROM profcurareafigura";
$sql .= " LEFT JOIN usuarios ON profeid = usuarios.id";
$sql .= " WHERE credasignados > credmin";
$sql .= " AND curso = '".trim($filtrocurso)."'";
if ($filtroarea) {$sql .= " AND area = '$filtroarea'";}
$sql .= " ORDER BY alumnoa, alumnon";
$result = $ilink->query($sql);
while ($fila = $result->fetch_array(MYSQLI_BOTH)) {

	echo "<tr><td>";
	$usu = ponerusu($fila['profeid'],1,$ilink);
	echo $usu[0].$usu[1];
	echo "</a></td><td class='ri'>".$fila['credmax']."</td><td class='ri'>".$fila['credmin']."</td><td class='ri'>".$fila['credasignados']."</td>";
	echo "<td class='ri nowrap'>";
	$temp = $fila['credasignados'] - $fila['credmin'];
	echo number_format($temp,2,'.','');
	$temp = "";
	echo "</td>";
	echo "</tr>";

}

echo "</table>";

?>
