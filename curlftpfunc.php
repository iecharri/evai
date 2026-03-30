<?php
#   En el server (**) tiene que estar activo un server FTP con usuario con permisos de upload
#      al directorio (*) que contiene las carpetas de los ficheros de los distintos entornos virutales
#   En la tabla "atencion", el campo ftppath con el valor: server (**) / directorio (*)

    $tmpfile = $_FILES['fichup']['tmp_name'];
#
    $tmpname = $_FILES['fichup']['name'];
#
    $ftpuser = "elearning";
#
    $ftppass = "ponerlapassdelserver";
#
    $ftppath = "$ftppath$navini$dir"; 
#
    $ftpurl = "ftp://".$ftpuser.":".$ftppass."@".$ftppath;
#
    $fp = fopen($tmpfile, 'r');
#
    $ch = curl_init();
#
    curl_setopt($ch, CURLOPT_URL, $ftpurl.$tmpname);
#
    curl_setopt($ch, CURLOPT_UPLOAD, 1);
#
    curl_setopt($ch, CURLOPT_INFILE, $fp);
#
    curl_setopt($ch, CURLOPT_INFILESIZE, filesize($tmpfile));
#
    curl_exec($ch);
#
    $error = curl_errno($ch);
#
    curl_close ($ch);
#
    if ($error == 0) {
#
        $rpta = "<span class='mediana b txth'>OK</span>";
#
    } else {
#
        $rpta = "<span class='mediana b rojo'>ERROR</span>";
#
    }
    
    echo $rpta;

?>