<?php

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

if ($_POST['copyfich']) {

	if (!soyadmiano($_POST['copyasigna'],$_POST['copycurso'],$ilink)) {
		$mensaje="<span class='rojo b'>No se ha realizado la copia, no es Administrador de: ".
		$_POST['copyasigna']." - ".$_POST['copycurso']."</span>";
	} else {
		$origen = $_SESSION['tit']."$$".$_SESSION['curso'];
		$destino = trim($_POST['copyasigna'])."$$".trim($_POST['copycurso']);
		$origen = DATA_DIR . "/cursos/".$origen;
		$destino = DATA_DIR . "/cursos/".$destino;
		copy_dir($origen,$destino);
		$mensaje="<span class='txth b'>Ficheros copiados con &eacute;xito a: ".$_POST['copyasigna']
		." - ".$_POST['copycurso']."</span>";
	}
} else {
	echo "Copiar las carpetas de esta [Titulaci&oacute;n Curso] en las carpetas de la [Titulaci&oacute;n Curso] siguiente<p></p>";
	echo "<form method='post' action='?titul=1'>";
	echo " <input class='col-2' type='text' size='15' maxlength='15' name='copyasigna'> ";
	echo "Curso <input class='col-2' type='text' size='4' maxlength='4' name='copycurso'> ";
	echo " <input class='col-1' type='submit' name='copyfich' value=' >> '></form>";
}
if ($mensaje) {echo "<p></p>$mensaje";}

// --------------------------------------------------

function copy_dir($origen,$destino)
{

   if (!is_dir($destino)){mkdir($destino);}
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
            	safe_copy($origen."/".$file, $destino."/".$file);
         	}
      	}
   	}
   	closedir($dh);
   }
}

?>