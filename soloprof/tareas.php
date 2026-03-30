<?php

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

extract($_GET);
extract($_POST);

unset($array);
$array[0] = "<a href='?pest=11&pestx=1'>Consultas <span class='icon-arrow-right'></span></a>";
$array[1] = "";
$array[2] = "";
$array[3] = "<a href='?pest=11&pestx=4'>".i("anadir1",$ilink)."</a>";
if ($id) {$array[1] = "<a href='#'>Tarea ".$id."</a>";}

// --------------------------------------------------

if (!$pestx) {$pestx = 1;}
if ($id) {$pestx = 2;}

solapah($array,$pestx,"navhsimple");

// --------------------------------------------------

if ($pestx == 4) {$pestx = anadir($ilink);}
if ($pestx == 2) {$pestx = editar($id,$ilink);}
if ($pestx == 1) {listar($ilink);}

// --------------------------------------------------

function listar($ilink) {
	$sql = "SELECT * FROM tareas ORDER BY estado, fecha DESC";
	$result = $ilink->query($sql);
	if (!$result->num_rows) {echo "No hay consultas"; return;}
	echo "<table class='conhover'><tr><th class='col-01'>#id</th><th class='col-3'></th><th class='col-10'>Consulta</th><th>Estado</th>";
	while ($fila = $result->fetch_array(MYSQLI_BOTH)) {
		extract($fila);
		echo "<tr><td class='center'><a href='?pest=11&id=$id'>$id</a></td>";
		echo "<td>";
			$usu = ponerusu($usuario,1,$ilink);
			echo $usu[0].$usu[1];
		echo "</td>";
		echo "<td>";
		if ($adjunto) {
			echo "<a href='fichtareas.php?id=$id'>";
			imag($tipoadj);
			echo "</a> ";
		}
		echo "<span class='txth b'>$resumen</span><br>".nl2br($detalle)."</td>";
		if (!$estado) {$estado = "Pendiente";}
		if ($estado == 1) {$estado = "Cerrada";}
		echo "<td class='center'>$estado</td></tr>";	
	}
	echo "</table>";
}

// --------------------------------------------------

function anadir($ilink) {
	if ($_POST['resu'] AND $_POST['deta']) {
		if ($_FILES['fichup']['name']) {
			$nomatach = $_FILES['fichup']['name'];
			$tipo    = $_FILES["fichup"]["type"];
			$archivo = $_FILES["fichup"]["tmp_name"];
			$contenido = file_get_contents($archivo);
			$contenido = $ilink->real_escape_string($contenido);
		}
		$resumen = addslashes($_POST['resu']);
		$detalle = addslashes($_POST['deta']);
		$ilink->query("INSERT INTO tareas (fecha, usuario, resumen, detalle, tipoadj ,adjunto, nomadj) VALUES 
		('".mdate("Y-m-d H:i:s")."', '".$_SESSION['usuid']."', \"$resumen\", \"$detalle\", '$tipo', \"$contenido\", \"$nomatach\")");

		$id=$ilink->insert_id;
		$temp = gmdate("Y-n-d H:i:s");
		$message = "<a href='soloprof/admin.php?op=3&pest=11&id=$id' target='_blank'>New Adm query ".$id."</a> $resumen";
		$sql = "SELECT id FROM usuarios WHERE autorizado > 9 AND fechabaja = '0000-00-00 00:00:00'";
		$result = $ilink->query($sql);
		while ($fila = $result->fetch_array(MYSQLI_BOTH)) {
			$sql1 = "INSERT INTO message (message, usuid, parausuid, date) VALUES (\"$message\", '".$_SESSION['usuid']."', '".$fila['id']."','$temp')";
			$ilink->query($sql1);
		}
		return 1;
	}
	echo "<h3 class=rojo b'>Formulario de consulta sobre el funcionamiento del Entorno ".ucfirst(SITE)." o de indicación de errores. Dar el máximo detalle sobre lugar exacto donde se produce, 
	en qué Titulación, Asignatura, Curso y Grupo, Usuario que detecta el error y si es un Profesor si lo detecta en un Usuario determinado, tipo de fichero html, pdf, etc con el que sucede...</h3><br>";
	echo "<table><form method='post' action='?pest=11&pestx=4' enctype=\"multipart/form-data\">";
	echo "<tr>";
	echo "<td class='col-01 nowrap'>Resumen (no dejar vac&iacute;o)</td>";
	echo "<td class='col-10'><input class='col-8' type='text' name='resu' size='50' maxlength='50'></td>";
	echo "</tr>";
	echo "<tr>";
	echo "<td class='col-01 nowrap'>Detalle (no dejar vac&iacute;o)</td>";
	echo "<td class='col-10'><br><textarea class='col-8' name='deta' rows='8' cols='90'></textarea></td>";
	echo "</tr>";
	echo "<tr>";
	echo "<td class='col-01 nowrap'>Adjunta un fichero</td>";
	echo "<td class='col-10'><h3 class='rojo'>aquí puedes adjuntar una captura de pantalla</h3><input class='col-3' name='fichup' type='file'></td>";
	echo "</tr>";
	echo "<tr>";
	echo "<td class='col-01'></td>";
	echo "<td class='col-10'><input class='col-2' type='submit' value= '>>>>'></td>";
	echo "</tr>";
	echo "</form></table>";
	return 4;	
}

// --------------------------------------------------

function editar($id,$ilink) {
	if (!$id) {return 1;}
	if ($_POST['motivocierre']) {$ilink->query("UPDATE tareas SET motivocierre = \"".addslashes($_POST['motivocierre'])."\", estado='1' WHERE id = '$id'");}
	$sql = "SELECT * FROM tareas WHERE id = '$id'";
	$result = $ilink->query($sql);
	if (!$result->num_rows) {return 1;}
	$fila = $result->fetch_array(MYSQLI_BOTH);
	extract($fila);
	if ($_POST['soluci']) {
		$solucion .= "$$".$_SESSION['usuid']."**".gmdate("Y-m-d H:i:s")."**".$_POST['soluci'];
		$ilink->query("UPDATE tareas SET solucion = \"".addslashes($solucion)."\" WHERE id = '$id'");
		$message = "New Adm query $id";
		porhsm($message, $usuario, "",$ilink);
	}
	$sql = "SELECT * FROM tareas WHERE id = '$id'";
	$result = $ilink->query($sql);
	$fila = $result->fetch_array(MYSQLI_BOTH);
	extract($fila);
	echo "<table>";
	echo "<tr>";
	echo "<td class='col-01'>#id</td>";
	echo "<td class='col-10'>$id ";
	if ($estado) {
		echo "&nbsp; &nbsp; &nbsp; <span class='mediana txth b'>Consulta cerrada</span>. $motivocierre";	
	}
	echo "</td>";
	echo "</tr>";
	echo "<tr>";
	echo "<td class='col-01'>Usuario</td>";
	echo "<td class='col-10'>";
	$usu = ponerusu($usuario,1,$ilink);
	echo $usu[0].$usu[1]." ".ifecha31($fecha,$ilink);
	echo "</td>";
	echo "</tr>";
	echo "<tr>";
	echo "<td class='col-01'>Consulta</td>";
	echo "<td class='col-10'>";
	if ($adjunto) {
		echo "<a href='fichtareas.php?id=$id'>";
		imag($tipoadj);
		echo "</a> ";
	}
	echo "<span class='txth b'>$resumen</span><br>".nl2br($detalle)."</td>";
	echo "</tr>";
	echo "<tr>";
	echo "<td class='col-01'>Soluciones</td>";
	$solucion = explode("$$",$solucion."$$");
	echo "<td class='col-10'>";
	foreach ($solucion AS $key=>$value) {
		if (!$value) {continue;}
		$value = explode("**",$value);
		$usu = ponerusu($usuario,1,$ilink);
		echo $usu[0].$usu[1]." ".ifecha31($fecha,$ilink);
		echo "<br><span class='col-01 nowrap center nob peq'>".ifecha31($value[1],$ilink)."</span><br><span class='txth b'>".nl2br($value[2],$ilink)."</span>";
		echo "<p class='both'>&nbsp;</p>";
	}
	if (!$estado) {
		echo "<form method='post' action='?pest=11&id=$id&sol=1'>";
		echo "A&ntilde;ade tu soluci&oacute;n<br><textarea class='col-8' rows='8' cols='90' name='soluci'></textarea><p></p><input class='col-2' type='submit' value= '>>>>'>";
		echo "</form><p></p>";
		if ($usuario == $_SESSION['usuid']) {
			echo "<form method='post' action='?pest=11&id=$id'>";
			echo "<span class='b txth'>Cerrar la consulta</span>. Indica el motivo<br><input class='col-8' type='text' size='50' maxlength='50' name='motivocierre'><p></p>
			<input class='col-2' type='submit' value= '>>>>'>";
			echo "</form>";
		}
	}
	echo "</td>";
	echo "</tr>";
	echo "</table>";
	return 2;
}

?>
