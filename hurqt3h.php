<?php

// Copyright (c) 2000-2026 Inmaculada Echarri San Adrián
// Copyright (c) 2000-2026 Antonio Grandío Botella
// This file is part of EVAI.
// Licensed under the MIT License.
// See LICENSE.txt for details.

$tf = decoded($_GET['tf']);
$mess = $_GET['mess'];

$inc = __DIR__.'/SMSSend.inc';  //componente SMSSend de Arsys (Web SMS)
if (is_file($inc)) { require $inc; } // evita fatal si no est�

//Defino las propiedades
$testsms=new smsItem;
$testsms->setAccount("***@xxx.xx");
$testsms->setPwd("******");
$testsms->setTo($tf);
$testsms->setText($mess);

//Recupero los valores establecidos
$Account = $testsms->getAccount();
$Pwd = $testsms->getPwd();
$To = $testsms->getTo();
$Text = $testsms->getText();

//Env&iacute;o del mensaje
$resultado = $testsms->Send();

//Resultado de la operaci&oacute;n
$getResult = $testsms->getResult();
$getDescription = $testsms->getDescription();

?>

<html><head><title><?php echo ucfirst(SITE);?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="estilo.css" rel="STYLESHEET" type="text/css">
</head>
<body bgcolor=#ffffcc>

<?php

if ($getResult == 'OK') {
	echo "<p></p><br>Se ha enviado el mensaje: <b>$mess</b>";
} else {
	echo "<p></p><br>Lo sentimos, no ha sido posible enviar el mensaje v&iacute;a SMS";
}

?>

<center><form name='form3'><input type="BUTTON" name="Button1" value="Cerrar Ventana" ONCLICK="window.close()"></FORM></center>

</body></html>

<?php
function decoded($str)
{
  $alpha_array = 
 array('M','J','R','B','Z',
 'L','V','X','K','S','O');
  $decoded = 
   base64_decode($str);
  list($decoded,$letter) = 
  explode("\+",$decoded);
  for($i=0;$i<count($alpha_array);$i++)
  {
  if($alpha_array[$i] == $letter)
  break;
  }
  for($j=1;$j<=$i;$j++) 
  {
     $decoded = 
      base64_decode($decoded);
  }
  return $decoded;
}//end of decoded function

?>