<?php

return;

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

$temp = "SELECT privacidad, geo FROM usuarios WHERE id = '".$_SESSION['usuid']."'";
$result = $ilink->query($temp);
$fila = $result->fetch_array(MYSQLI_BOTH);
if ($fila[0] AND $_SESSION['auto'] < 5) {
	echo "<p>Para ver a un usuario en el mapa, elige privacidad 0 en tu ficha</p>";
	return;
}
if (!$fila[1]) {
	echo "<p>No puedes ver la situación de un usuario en el mapa sin activar tu propia geolocalización. Activa desde [<a href='usuarios.php?us=l'>Link</a>]</p>";
	return;
}

$temp = "SELECT id, usuario, geo, foto FROM usuarios WHERE id = '".$_SESSION['usuid']."'";
$result = $ilink->query($temp);
$fila = $result->fetch_array(MYSQLI_BOTH);

$temp = "SELECT id, usuario, geo, foto, fecha, privacidad, estado FROM usuarios WHERE id = '$usuid'";
$result = $ilink->query($temp);
$fila = $result->fetch_array(MYSQLI_BOTH);
if (!$fila[2] OR (!$_SESSION['soy_superadmin'] AND ($fila[5] != 0 OR $fila[6] != 0))) {
	echo "<p>No hay datos de situación del usuario</p>";
	return;
}
if($fila[3]){
	$lafoto = ",icon:'".DATA_URL."/fotos/1".$fila[3]."'";
}
$temp1 = explode('*',$fila[2]);

?>

<script src="http://maps.google.com/maps/api/js"></script> <!-- ?sensor=false -->
<script type="text/javascript">
var x=document.getElementById("demo");

function cargarmap(){
navigator.geolocation.getCurrentPosition(showPosition,showError);
	function showPosition(position)
	{
	<?php
	echo "lat = $temp1[0];\n";
	echo "lon = $temp1[1];\n";
	echo "latlon=new google.maps.LatLng(lat, lon)";
	?>
	
  mapholder=document.getElementById('mapholder')
  mapholder.style.height='15em';
  mapholder.style.width='100%';
  
  var myOptions={
  center:latlon,
  zoom:15,
  mapTypeId:google.maps.MapTypeId.HYBRID,
  mapTypeControl:false,
  navigationControlOptions:{style:google.maps.NavigationControlStyle.ZOOM_PAN}
  };
  
  var map=new google.maps.Map(document.getElementById("mapholder"),myOptions);
  var marker=new google.maps.Marker({position:latlon,map:map,title:"visto aquí" <?php echo $lafoto; ?>});
} 


function showError(error)
  {
  switch(error.code) 
    {
    case error.PERMISSION_DENIED:
      x.innerHTML="Denegada la peticion de Geolocalización en el navegador."
      break;
    case error.POSITION_UNAVAILABLE:
      x.innerHTML="La información de la localización no esta disponible."
      break;
    case error.TIMEOUT:
      x.innerHTML="El tiempo de petición ha expirado."
      break;
    case error.UNKNOWN_ERROR:
      x.innerHTML="Ha ocurrido un error desconocido."
      break;
    }
  }}
</script>

<div id="mapholder"></div>
<div id="demo"></div>