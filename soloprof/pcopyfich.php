<?php

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

if ($_POST['copyfich']) {
	if (!existe($_POST['copyasigna'],$_POST['copycurso'],$_POST['copygrupo'],$ilink) 
	OR !esprofesor($_POST['copyasigna'],$_POST['copycurso'],$_POST['copygrupo'],$ilink)) {
		$mensaje="<span class='rojo b'>No se ha realizado la copia, no es profesor de: ".
		$_POST['copyasigna']." - ".$_POST['copycurso']." - ".$_POST['copygrupo']."</span>";
	} else {
		$origen = $_SESSION['asigna']."$$".$_SESSION['curso']."$$".$_SESSION['grupo'];
		$destino = trim($_POST['copyasigna'])."$$".trim($_POST['copycurso'])."$$".trim($_POST['copygrupo']);
		$origen = DATA_DIR . "/cursos/".$origen;
		$destino = DATA_DIR . "/cursos/".$destino;
		copy_dir($origen,$destino);
		$mensaje="<span class='txth b'>Ficheros copiados con &eacute;xito a: ".$_POST['copyasigna']
		." - ".$_POST['copycurso']." - ".$_POST['copygrupo']."</span>";
	}
} else {
	echo "Copiar las carpetas de esta [Asignatura Curso Grupo] en las carpetas de la ";
	echo "[Asignatura Curso Grupo] siguiente<p></p><form method='post' action='?'>";
	echo "Asignatura <input class='col-2' type='text' size='15' maxlength='15' name='copyasigna'> ";
	echo "Curso <input class='col-2' type='text' size='4' maxlength='4' name='copycurso'> ";
	echo "Grupo <input class='col-2' type='text' size='1' maxlength='1' name='copygrupo'> ";
	echo " <input class='col-1' type='submit' name='copyfich' value=' >> '></form>";
}
if ($mensaje) {echo "<p></p>$mensaje";}

// --------------------------------------------------

function copy_dir($origen,$destino)
{

   if (!is_dir($destino)){safe_mkdir($destino);}
   if ($dh = opendir($origen))
   {
      while(($file = readdir($dh)) !== false)
      {
         if ($file != "." && $file != "..")
         {
            if (is_dir($origen."/".$file))
            {
               copy_dir($origen."/".$file,$destino."/".$file);
            }
            else
            {
            	copy($origen."/".$file, $destino."/".$file);
         	}
      	}
   	}
   	closedir($dh);
   }
}

?>