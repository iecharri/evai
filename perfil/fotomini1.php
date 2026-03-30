<?php

return;

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

if ($_POST['xmini']) {
	
	$targ_w = $targ_h = 40;
	$jpeg_quality = 100;

	$src = APP_DIR . '/fotos/2$foto';
	$img_r = imagecreatefromjpeg($src);
	$dst_r = ImageCreateTrueColor( $targ_w, $targ_h );

	imagecopyresampled($dst_r,$img_r,0,0,$_POST['x'],$_POST['y'],$targ_w,$targ_h,$_POST['w'],$_POST['h']);
	imagejpeg($dst_r,APP_DIR . '/fotos/1$foto',$jpeg_quality); 
	
}

?>

		<script src="jcrop/jquery.min.js"></script>
		<script src="jcrop/jquery.Jcrop.js"></script>
		<link rel="stylesheet" href="jcrop/css/jquery.Jcrop.css" type="text/css">

		<script language="Javascript">

			$(function(){

				$('#cropbox').Jcrop({
					aspectRatio: 1 / 1,
					setSelect:   [ 20, 20, 100, 100 ],

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
		Selecciona un &aacute;rea y <input class='col-2' type="submit" name='xmini' value="elige como miniatura">

		<img src="<?php echo DATA_URL . "/fotos/2$foto";?>" id="cropbox">
		<!-- This is the form that our event handler fills -->
			<input type="hidden" id="x" name="x">
			<input type="hidden" id="y" name="y">
			<input type="hidden" id="w" name="w">
			<input type="hidden" id="h" name="h">

		</form>

