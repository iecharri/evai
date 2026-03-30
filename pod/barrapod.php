<?php

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

unset($array1);

switch($pest) {
	case 1:
	
	$array1 = array();
	
	$array1[] = "<a href='#'>&Aacute;reas</a>";
	break;
	case 2:
	$array1[] = "<a href='?pest=$pest&pest1=1'>Titulaciones</a>";
	$array1[] = "<a href='?pest=$pest&pest1=2'>Admnistradores de Titulaci&oacute;n</a>";
	break;
	case 3:
	$array1[] = "<a href='?pest=$pest&pest1=1'>Grupos de Asignaturas - cursos</a>";
	$array1[] = "<a href='?pest=$pest&pest1=2'>Grupos de Asignaturas</a>";
	break;
	case 4:
	$array1[] = "<a href='?pest=$pest&pest1=1'>Figuras - Cursos</a>";
	$array1[] = "<a href='?pest=$pest&pest1=2'>Figuras</a>";
	break;
	case 5:
	$array1[] = "<a href='?pest=$pest&pest1=1'>Cargos - Cursos</a></a>";
	$array1[] = "<a href='?pest=$pest&&pest1=2'>Cargos</a>";
	break;
	case 6:
	$array1[] = "<a href='?pest=$pest&pest1=1'>Profesores - Cursos</a></a>";
	$array1[] = "<a href='?pest=$pest&pest1=2'>Profesores</a>";
	break;
	case 7:
	$array1[] = "<a href='?pest=$pest&pest1=1'>Asignaturas - Cursos</a>";
	$array1[] = "<a href='?pest=$pest&pest1=2'>Asignaturas</a>";
	if ($idasigna) {
		$array1[] = "<a href='?pest=$pest&pest1=3&idasigna=$idasigna&idcurso=$idcurso'>Asignatura</a>";
	}
	break;
	case 8:
	$array1[] = "<a href='#'>Asignaciones</a>";
	break;
	case 9:
	$array1[] = "<a href='#'>Repositorio</a>";
	break;
	case 10:
	$array1[] = "<a href='#'>Enviar mails</a>";
	break;
	case 11:
	$array1[] = "<a href='#'>Resumen Cr&eacute;ditos por asignar</a>";
	break;
		case 12:
	$array1[] = "<a href='?pest=$pest&pest1=1&m=1'>Enviar mails - Admin.</a></a>";
	$array1[] = "<a href='?pest=$pest&pest1=2'>Listado de mails enviados</a>";
	break;
		case 13:
	$array1[] = "<a href='?pest=13'>Mails recibidos</a>";
	$array1[] = "<a href='?pest=13&anadir=1'>".i("anadir1",$ilink)."</a>";
	break;
	case 14:
	$array1[] = "<a href='?pest=$pest&pest1=1'>Mensajes</a>";
	$array1[] = "<a href='?pest=$pest&pest1=2'>Crear un POD</a>";
	break;
	default:
		return;	
}

solapah($array1,$pest1,"navhsimple");

?>