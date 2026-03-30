<?php

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

if($_POST['videnppal1']) {
	if($_POST['videnppal']) {$_POST['videnppal'] = base64_encode($_POST['videnppal']);}
	$result = $ilink->query("UPDATE cursasigru SET video = \"".$_POST['videnppal']."\", vidtxt = \"".$_POST['vidtxt']."\" WHERE asigna = '$asigna' AND curso = '$curso' AND grupo = '$grupo'");
}

$video = vid_home($ilink);

if($_SESSION['auto'] < 5) {
	return;
}

echo "<div id='vidprof' style='display:none' class='center'>";	
	echo "<form method='post'><textarea name='videnppal' rows='8' placeholder=\"".i("vidhome",$ilink)."\">".base64_decode($video[0])."</textarea>";
	echo "<input type='text' class='col-10' name='vidtxt' placeholder=\"".i("254chars",$ilink)."\" value=\"".$video[1]."\">";
	?>
	<input type='hidden' name='videnppal1' value='1' >
	<button type="submit" style="border:0">
  		<span class='icon-play grande verdecalific'></span>
	</button>
	<?php		
	echo "</form>";
echo "</div>";

function vid_home($ilink) {

	$asigna = $_SESSION['asigna'];
	$curso = $_SESSION['curso'];
	$grupo = $_SESSION['grupo'];

	$sql = "SELECT video,vidtxt FROM cursasigru WHERE asigna = '$asigna' AND curso = '$curso' AND grupo = '$grupo'";
	
	$result = $ilink->query($sql);
	$video = $result->fetch_array(MYSQLI_BOTH);
	
	if(!$video[0]) {return;}

	?>

	<div class="video-responsive">
		<?php echo base64_decode($video[0]);?>
	</div>
	
	<?php

	if($video[1]) {echo "<div class='colu2 col-10'>".$video[1]."</div>";}
	
	return $video;
	
}

?>

