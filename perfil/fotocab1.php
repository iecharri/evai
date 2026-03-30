<?php

return;

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

if ($_POST['xcab']) {

	$src = require_once APP_DIR . '/fotos/3$foto';
	
	$targ_w = $_POST['w'];
	$targ_h = $_POST['h'];
	$jpeg_quality = 100;

	$img_r = imagecreatefromjpeg($src);
	$dst_r = ImageCreateTrueColor( $targ_w, $targ_h );

	imagecopyresampled($dst_r,$img_r,0,0,$_POST['x'],$_POST['y'],$targ_w,$targ_h,$_POST['w'],$_POST['h']);
	imagejpeg($dst_r,APP_DIR . '/fotos/3$foto',$jpeg_quality); 
	
}

?>

		<script src="jcrop/jquery.min.js"></script>
		<script src="jcrop/jquery.Jcrop.js"></script>
		<link rel="stylesheet" href="jcrop/css/jquery.Jcrop.css" type="text/css">

		<script language="Javascript">

			$(function(){

				$('#cropbox').Jcrop({
					aspectRatio: 4 / 1,
					setSelect:   [ 0, 0, 100, 100 ],

					onSelect: updateCoords
				});

			});

			function updateCoords(c)
			{
				$('#x').val(c.x);
				$('#y').val(c.y);
				$('#w').val(c.w);
				$('#h').val(c.h);
			};

			function checkCoords()
			{
				if (parseInt($('#w').val())) return true;
				alert('Selecciona una regi&oacute;n de la imagen.');
				return false;
			};

		</script>


		<form action="?<?php echo "pest=$pest&op=$op";?>"
		 method="post" onsubmit="return checkCoords();">
			<input type="submit" name='xcab' value="recorta un &aacute;rea">

		<img src="<?php echo DATA_URL . "/fotos/3$foto";?>" id="cropbox">
		<!-- This is the form that our event handler fills -->
			<input type="hidden" id="x" name="x">
			<input type="hidden" id="y" name="y">
			<input type="hidden" id="w" name="w">
			<input type="hidden" id="h" name="h">

		</form>

