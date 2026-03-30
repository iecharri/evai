<?php

// Copyright (c) 2000-2026 Inmaculada Echarri San Adrián
// Copyright (c) 2000-2026 Antonio Grandío Botella
// This file is part of EVAI.
// Licensed under the MIT License.
// See LICENSE.txt for details.

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

if ($_SESSION['auto'] < 10) {exit;}

function quitabarra($x) {return stripslashes($x);}
function ponbarra($x) {return addslashes($x);}
if (!function_exists('comidoble')) {function comidoble($x) {return str_replace("\"", "&#34;", $x);}}

?>

<script language="javascript">
	function borrar(form1) {
	if (document.form1.borrar.checked) {
		return confirm("<?php echo i("confirmborr",$ilink);?>");
	}
}
</script>

<?php

$caso = 6; 

require_once APP_DIR . "/pod/podformfiltro.php";

$sql = "SELECT DISTINCT usuarios.id, mail, alumnon FROM usuarios LEFT JOIN asignatprof ON asignatprof.id = usuarios.id WHERE usuarios.tipo = 'P' AND autorizado > 4 AND fechabaja = '0000-00-00 00:00'";

if ($filtroarea) {
	$sql .= " AND usuarios.area = '$filtroarea'";
}

if ($filtrocurso) {
	$sql .= " AND asignatprof.curso = '$filtrocurso'";
}

if ($filtroarea) {$filtro1 = " AND area = '$filtroarea'";}
if ($filtrocurso) {$filtro1 .= " AND curso = '".trim($filtrocurso)."'";}
$sql = "SELECT DISTINCT usuarios.id, mail, alumnon FROM profcurareafigura";
$sql .= " LEFT JOIN usuarios ON profcurareafigura.profeid=usuarios.id";
$sql .= " WHERE 1=1 $filtro1";

$_SESSION['sql'] = $sql;

if ($pest1 == 2) {
	$filtropod = " mensaje1 LIKE '%[POD] %'";
	$param = "pest=14&pest1=2";
	require_once APP_DIR . "/soloprof/mailssist.php";
	return;
}

$prefijopod = "[POD] ";
$_SESSION['b'][4] = " ";
echo "<br>";
echo "<div class='contiene'>";
require_once APP_DIR . "/soloprof/soloprofmens.php";
echo "</div>";
?>
