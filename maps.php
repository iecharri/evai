<?php

return;

if($_POST['myInputLatitud']) {
	$temp = $_POST['myInputLatitud']."*".$_POST['myInputLongitud'];
	$ilink->query("UPDATE usuarios SET geo = '$temp' WHERE id = '".$_SESSION['usuid']."'");
	
} elseif($_POST['si_geo']) {
	echo "<form method='post'>";
	?>
	<script type="text/javascript">
	if (navigator.geolocation) {
		navigator.geolocation.getCurrentPosition(mostrarUbicacion);
	} else {
		alert("¡Error! Este navegador no soporta la Geolocalización.");
	}
	function mostrarUbicacion(position) {
		document.getElementById('myInputLatitud').value = position.coords.latitude
		document.getElementById('myInputLongitud').value = position.coords.longitude	
	}	
	</script>
	<input type='hidden' id='myInputLatitud' name='myInputLatitud'>
	<input type='hidden' id='myInputLongitud' name='myInputLongitud'>
	<input type='submit' class='col-5' value='mostrar mapa'>
	<?php
	echo "</form>";return;
}

$sql = "SELECT geo, privacidad FROM usuarios WHERE id = '".$_SESSION['usuid']."'";
$result = $ilink->query($sql);
$fila = $result->fetch_array(MYSQLI_BOTH);

if ($fila[1] AND $_SESSION['auto'] < 5) {
	echo "<p><span class='icon-location'></span>  Para ver los usuarios en línea en google maps, elige privacidad 0 en tu ficha</p>";
	return;
}

if(!$fila[0] AND !$_POST['si_geo']) {
	$user_agent = $_SERVER['HTTP_USER_AGENT'];
	if(!strpos($user_agent, 'Firefox')) {
   	echo " &nbsp;  <span class='rojo'>¡Atención! si no ves el mapa tras pulsar el siguiente botón, es posible que tu navegador no lo soporte. Usa 
   	<a href='https://www.mozilla.org/es-ES/firefox/new/' target='_blank'><span class='icon-firefox rojo grande'></span> Mozilla Firefox.</a></span><p></p>";
   	//return;
	}
	//preguntar
	echo "<form method='post'>";
	echo "<span class='icon-location'></span>  Aquí podrás ver un mapa de google maps con los usuarios conectados. Ellos han dado su autorización para ser situados en el mapa.
	Si deseas verlo y aparecer en él, has de pulsar el siguiente botón. Además el navegador te pedirá autorización para geolocalizarte.
	Si lo pulsas, en cuaquier momento podrás anular el consentimiento si lo deseas.<p></p>Si no ves el mapa tras pulsar la flecha, puede ser que hayas bloqueado el acceso a tu 
	ubicación en el navegador o que tu navegador no soporte su visualización.";

	echo " <input class='col-05' type='submit' name='si_geo' value='>>'>";
	echo "</form>";
	return;
}

if(!$_POST['si_geo']) {
	echo "<form method='post'>";
	echo "<span class='icon-location'></span> Si aquí debajo ves el mapa de google maps y no deseas aparecer en él, pulsa ";
	echo "<input class='col-2em' type='submit' name='no_geo' value='>>'>";
	echo "</form>";
}

  $server = MEDIA_URL . "/server.png"; 

?>


    <script>

function initMap() {

  var myLatLng = {lat: 39.995033, lng: -0.067270};

  var map = new google.maps.Map(document.getElementById('map'), {
    zoom: 8,
    center: myLatLng
  });


/*  var infoWindow = new google.maps.InfoWindow({map: map});

  // Try HTML5 geolocation.
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(function(position) {
      var pos = {
        lat: position.coords.latitude,
        lng: position.coords.longitude
      };

      infoWindow.setPosition(pos);
      infoWindow.setContent('Location found.');
      map.setCenter(pos);
    }, function() {
      handleLocationError(true, infoWindow, map.getCenter());
    });
  } else {
    // Browser doesn't support Geolocation
    handleLocationError(false, infoWindow, map.getCenter());
  }
*/





  var marker = new google.maps.Marker({
    position: myLatLng,
    map: map,
    title: 'Server Uji',icon:'<?php echo $server;?>'
  });

<?php
$n = 0;

$timestamp = time(); // UTC actual
$corte = gmdate('Y-m-d H:i:s', $timestamp - 30); // hace 30 segundos

// Construcción del SQL en UTC
$sql = "SELECT id, usuario, geo, foto FROM usuarios WHERE fecha >= '$corte' AND !privacidad";

if (!$_SESSION['soy_superadmin']) {
    $sql .= " AND !estado";
}

// Opción: excluir al usuario actual (comentada en tu código)
// $sql .= " AND id != '".$_SESSION['usuid']."'";

$sql .= " ORDER BY fechalogin DESC";

// Ejecutar
$res = $ilink->query($sql);

while ($fila = $res->fetch_array(MYSQLI_BOTH)) {
	$temp1 = explode('*',$fila[2]);
	if (!$temp1[1]) {continue;}
	$n++;//if (!$n) {$temp1[0] = ($temp1[0] + 50);}
		
	
	echo "var myLatLng = {lat: $temp1[0], lng: $temp1[1]};";
	?>
 	var marker = new google.maps.Marker({
   	position: myLatLng,
   	map: map,
   	title: '',icon:'/<?php echo DATA_URL . "/fotos/1".$fila[3];?>'
  	});	
	
	<?php

}
?>

}

    </script>

<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyATbm2B0fsouqbhUNPXbHSL5OxKnypAO5A&callback=initMap">

</script>

<div id="map"></div>
    