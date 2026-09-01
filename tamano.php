<?php

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

function tamano($tamano){

if($tamano >= 1073741824)
 	{
        $tamano = round($tamano/1073741824*100)/100 . " GB";
	}
elseif($tamano >= 1048576)
	{
        $tamano = round($tamano/1048576*100)/100 . " MB";
	}
elseif($tamano >= 1024)
	{
        $tamano = round($tamano/1024*100)/100 . " KB";
	}
else{
        $tamano = $tamano . " b";
	}

if ($tamano == 0) {$tamano = "";}
return $tamano;

}

function imag($tipo){

if(stristr($tipo,"image")) {
	$icono = "image";
} elseif (stristr($tipo,"Carpeta")) {
	$icono = "folder-open";
} elseif (stristr($tipo,"html")) {
	$icono = "link";
} elseif (stristr($tipo,"zip")) {
	$icono = "file-zip";
} elseif (stristr($tipo,"video")) {
	$icono = "film";
} elseif (stristr($tipo,"text")) {
	$icono = "file-text2";
} elseif (stristr($tipo,"adobe")) {
	$icono = "file-pdf";
} elseif (stristr($tipo,"audio")) {
	$icono = "headphones";
} elseif (stristr($tipo,"word") OR stristr($tipo,"excel") OR stristr($tipo,"powerpoint")) {
	$icono = "file-openoffice";
} else {
	$icono = "file-empty";
}

echo "<span class='icon-$icono azul'></span> ";

}

function imag1($tipo,$ilink) {

$icono = "file-empty";

switch(strtolower($tipo)) {

case "youtube": $icono = "youtube4"; break;
case "youtu.be": $icono = "youtube3"; break;
case ".html": $icono = "link"; break;
case ".htm": $icono = "link"; break;
case ".gif": $icono = "image"; break;
case ".jpg": $icono = "image"; break;
case ".bmp": $icono = "image"; break;
case ".doc": $icono = "file-word"; break;
case ".docx": $icono = "file-word"; break;
case ".xls": $icono = "file-excel"; break;
case ".pps": $icono = "file-openoffice"; break;
case ".ppt": $icono = "file-openoffice"; break;
case strtolower(i("carpeta1",$ilink)): $icono = "folder-open"; break;
case ".pdf": $icono = "file-pdf"; break;
case ".avi": $icono = "film"; break;
case ".wmv": $icono = "film"; break;
case ".mov": $icono = "film"; break;
case ".mp3": $icono = "headphones"; break;
case ".mp4": $icono = "film"; break;
case ".wma": $icono = "headphones"; break;
case ".au": $icono = "headphones"; break;
case ".wav": $icono = "headphones"; break;
case ".txt": $icono = "file-text2"; break;
case ".zip": $icono = "file-zip"; break;
case ".rar": $icono = "file-zip"; break;
case ".pdf": $icono = "file-pdf"; break;

}

return "<span class='icon-$icono azul'></span> ";

}

function esvid($ext) {
	if (!$ext) {return;}
$ext = strtoupper($ext);
if ($ext == "ASF") {return true;} // â> Windows Media
if ($ext == "AVI") {return true;} // (*)â> BSPlayer
if ($ext == "BIK") {return true;} //  â> RAD Video Tools
if ($ext == "DIV") {return true;} //  â> DivX Player
if ($ext == "DIVX") {return true;} //  â> DivX Player
if ($ext == "DVD") {return true;} //  â> PowerDVD
if ($ext == "IVF") {return true;} //  â> Indeo
if ($ext == "M1V") {return true;} //  â> (mpeg)
if ($ext == "MOV") {return true;} // (*) â> QuickTime
if ($ext == "MOVIE") {return true;} //  â> (mov)
if ($ext == "MP2V") {return true;} //  â> (mpeg)
if ($ext == "MP4") {return true;} //  â> (MPEG-4)
if ($ext == "MPA") {return true;} //  â> (mpeg)
if ($ext == "MPE") {return true;} //  â> (mpeg)
if ($ext == "MPEG") {return true;} // (*) â> (mpeg)
if ($ext == "MPG") {return true;} //  â> (mpeg)
if ($ext == "MPV2") {return true;} //  â> (mpeg)
if ($ext == "QT") {return true;} //  â> QuickTime
if ($ext == "QTL") {return true;} //  â> QuickTime
if ($ext == "RPM") {return true;} //  â> RealPlayer
if ($ext == "SMK") {return true;} //  â> RAD Video Tools
if ($ext == "WM") {return true;} //  â> Windows Media
if ($ext == "WMV") {return true;} //  â> Windows Media
if ($ext == "WOB") {return true;} //  â> PowerDVD
}

function sanear_string($string)
{
 
    $string = trim($string);
 
    $string = str_replace(
        array('á', 'à', 'ä', 'â', 'ª', 'Á', 'À', 'Â', 'Ä'),
        array('a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A'),
        $string
    );
 
    $string = str_replace(
        array('é', 'è', 'ë', 'ê', 'É', 'È', 'Ê', 'Ë'),
        array('e', 'e', 'e', 'e', 'E', 'E', 'E', 'E'),
        $string
    );
 
    $string = str_replace(
        array('í', 'ì', 'ï', 'î', 'Í', 'Ì', 'Ï', 'Î'),
        array('i', 'i', 'i', 'i', 'I', 'I', 'I', 'I'),
        $string
    );
 
    $string = str_replace(
        array('ó', 'ò', 'ö', 'ô', 'Ó', 'Ò', 'Ö', 'Ô'),
        array('o', 'o', 'o', 'o', 'O', 'O', 'O', 'O'),
        $string
    );
 
    $string = str_replace(
        array('ú', 'ù', 'ü', 'û', 'Ú', 'Ù', 'Û', 'Ü'),
        array('u', 'u', 'u', 'u', 'U', 'U', 'U', 'U'),
        $string
    );
 
    $string = str_replace(
        array('ñ', 'Ń', 'ç', 'Ç'),
        array('n', 'N', 'c', 'C',),
        $string
    );
 
    //Esta parte se encarga de eliminar cualquier caracter extra&ntilde;o
    $string = str_replace(
        array("\\", "¨", "&deg;", "~",
             "#", "@", "|", "!", "\"",
             "·", "$", "%", "&", "/",
             "(", ")", "?", "'", "&iexcl;",
             "&iquest;", "[", "^", "`", "]",
             "+", "}", "{", "¨", "´",
             ">", "<", ";", ",", ":"),
        '',
        $string
    );
 
    $string = str_replace(
        array(" "),
        '_',
        $string
    );
 
    return $string;
}

