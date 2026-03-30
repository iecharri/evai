<?php

require_once __DIR__ . '/siempre_base.php';

$id = $_GET['id'];

$qry = "SELECT tipoatach, attachment, nomatach, usuid FROM grabaciones WHERE id=$id";
$iresult = $ilink->query($qry);
$res = $iresult->fetch_array(MYSQLI_BOTH);
if ($res[3] != $_SESSION['usuid']) {exit;}

$tipo = $res[0];
$contenido = $res[1];
$uid = $res['usuid'];
$temp = gmdate("Y-m-d H:i:s");
$dir = DATA_DIR . '/temp';
if(!is_dir($dir)) {safe_mkdir($dir);}
$DescriptorFichero = safe_fopen(DATA_DIR . "/temp/f".$id.".spx","w");
fputs($DescriptorFichero,$contenido);

?>

<applet id="nanogong" archive="nanogong.jar" code="gong.NanoGong" width="180" height="40">  
<param name="SoundFileURL" value="/<?php echo DATA_URL;?>/temp/f<?php echo $id;?>.spx"> 
<param name='Start' value='true'> 
<param name='ShowAudioLevel' value='true'>
<param name='ShowSpeedButton' value='false'>
<param name='Color' value='#ffffcc'>
<param name='ShowSaveButton' value='false'>
<param name='ShowRecordButton' value='false'>
</applet> 