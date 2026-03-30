<?php

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

function registrar($exito,$accion,$dir1,$fich1,$dir2,$fich2,$ilink) {

	$fich2 = str_replace($dir2, "", $fich2);

	if ($accion == "mkdir") {
		$sql = "INSERT INTO carpprofregactivi (exito, usuid, accion, carpeta2, fichero2, fecha, fichero1) VALUES 
		('$exito', '".$_SESSION['usuid']."', 'Crear Carpeta', \"$dir2\", \"$fich2\", '".gmdate('Y-m-d H:i:s')."', \"$fich1\")";
		$ilink->query($sql);		
	}	

	if ($accion == "fopenw") {
		if ($exito) {$exito = 1;}
		$sql = "INSERT INTO carpprofregactivi (exito, usuid, accion, carpeta2, fichero2, fecha, fichero1) VALUES 
		('$exito', '".$_SESSION['usuid']."', 'Crear Fichero', \"$dir2\", \"$fich2\", '".gmdate('Y-m-d H:i:s')."', \"$fich1\")";
		$ilink->query($sql);		
	}	

	if ($accion == "fopenw1") {
		if ($exito) {$exito = 1;}
		$sql = "INSERT INTO carpprofregactivi (exito, usuid, accion, carpeta2, fichero2, fecha) VALUES 
		('$exito', '".$_SESSION['usuid']."', 'Modificar Fichero', \"$dir2\", \"$fich2\", '".gmdate('Y-m-d H:i:s')."')";
		$ilink->query($sql);		
	}	

	if ($accion == "unlink") {
		$sql = "INSERT INTO carpprofregactivi (exito, usuid, accion, carpeta1, fichero1, fecha) VALUES 
		('$exito', '".$_SESSION['usuid']."', 'Borrar Fichero', \"$dir1\", \"$fich1\", '".gmdate('Y-m-d H:i:s')."')";
		$ilink->query($sql);		
	}	

	if ($accion == "rmdir") {
		$sql = "INSERT INTO carpprofregactivi (exito, usuid, accion, carpeta1, fecha) VALUES 
		('$exito', '".$_SESSION['usuid']."', 'Borrar Carpeta', \"$dir1\", '".gmdate('Y-m-d H:i:s')."')";
		$ilink->query($sql);		
	}	
	
	if ($accion == "subir") {
		$sql = "INSERT INTO carpprofregactivi (exito, usuid, accion, carpeta2, fichero2, fecha, fichero1) VALUES 
		('$exito', '".$_SESSION['usuid']."', 'Subir', \"$dir2\", \"$fich2\", '".gmdate('Y-m-d H:i:s')."', \"$fich1\")";
		$ilink->query($sql);		
	}	

	if ($accion == "subirc") {
		$sql = "INSERT INTO carpprofregactivi (exito, usuid, accion, carpeta2, fichero2, fecha, fichero1) VALUES 
		('$exito', '".$_SESSION['usuid']."', 'Subir curriculum', \"$dir2\", \"$fich2\", '".gmdate('Y-m-d H:i:s')."', \"$fich1\")";
		$ilink->query($sql);		
	}	
	
	if ($accion == "copy") {
		$sql = "INSERT INTO carpprofregactivi (exito, usuid, accion, carpeta1, fichero1, carpeta2, fichero2, fecha) VALUES 
		('$exito', '".$_SESSION['usuid']."', 'Copiar a Carpeta', \"$dir1\", \"$fich1\", \"$dir2\", \"$fich2\", '".gmdate('Y-m-d H:i:s')."')";
		$ilink->query($sql);		
	}	

	if ($accion == "mover") {
		$sql = "INSERT INTO carpprofregactivi (exito, usuid, accion, carpeta1, fichero1, carpeta2, fichero2, fecha) VALUES 
		('$exito', '".$_SESSION['usuid']."', 'Mover a Carpeta', \"$dir1\", \"$fich1\", \"$dir2\", \"$fich2\", '".gmdate('Y-m-d H:i:s')."')";
		$ilink->query($sql);		
	}	

	if ($accion == "rename") {
		$sql = "INSERT INTO carpprofregactivi (exito, usuid, accion, carpeta1, fichero1, carpeta2, fichero2, fecha) VALUES 
		('$exito', '".$_SESSION['usuid']."', 'Renombrar', \"$dir1\", \"$fich1\", \"$dir2\", \"$fich2\", '".gmdate('Y-m-d H:i:s')."')";
		$ilink->query($sql);		
	}	
	
}

?>