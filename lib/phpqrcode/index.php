<?php    

if(!$pacadem) {return;}

$PNG_TEMP_DIR = DATA_DIR ."/temp/";

$filename = $PNG_TEMP_DIR.'qr_'.$usuario.'.png';

$_REQUEST['data'] = $pacadem;
$_REQUEST['level'] = "L";
$_REQUEST['size'] = "4";
$errorCorrectionLevel = 'L';
$matrixPointSize = 4;

QRcode::png($_REQUEST['data'], $filename, $errorCorrectionLevel, $matrixPointSize, 2);

?>

    