<?php

require_once APP_DIR . '/molde_top.php';

?>

<article class="caja caja--estrecha">
    <div class="caja__head"><h2><?php echo i("cambiarpass",$ilink);?></h2></div>
    <div class="caja__body">

<?php if($cambiook ==1) {?>
	
	<p><?php echo i("cambiocontraok",$ilink);?></p>
	</div></div></article>

	<?php require_once APP_DIR . '/molde_bott.php'; exit;

}

if (!empty($error)) echo "<p style='color:red'>$error</p>"; ?>

<form method="post">
<label>
    <?php echo i("clave",$ilink);?>
  <input type="password" name="pass1" 
         size="15" maxlength="15"
         required 
         pattern="[A-Za-z0-9._-]{8,15}" 
         title="A-Z a-z 0-9 . - _   (8 a 15 caracteres)">
</label>
<br><br>

<label>
  <?php echo i("repc",$ilink);?>
  <input type="password" name="pass2" 
         size="15" maxlength="15"
         required 
         pattern="[A-Za-z0-9._-]{8,15}" 
         title="A-Z a-z 0-9 . - _   (8 a 15 caracteres)">
</label>

    <p></p><button type="submit"><?php echo i("cambiarpass",$ilink);?></button>
</form>

</div></div></article>

<?php

require_once APP_DIR . '/molde_bott.php';

?>