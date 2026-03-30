<?php

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

	
if(!$veopasswd) {return;}

$mens = "";





if ($pass1 && $pass1 === $pass0 && strlen($pass1) > 7 && strlen($pass1) < 16 && preg_match('/^[A-Za-z0-9._-]+$/', $pass1)) {

    // Hashear (Argon2id si está, si no, default/bcrypt)
    $algo    = defined('PASSWORD_ARGON2ID') ? PASSWORD_ARGON2ID : PASSWORD_DEFAULT;
    $options = defined('PASSWORD_ARGON2ID') ? ['memory_cost'=>1<<17,'time_cost'=>4,'threads'=>2] : [];

    $hash = password_hash($pass1, $algo, $options);

    // Guardar hash y limpiar columna legacy
    $stmt = $ilink->prepare("UPDATE usuarios SET pass_hash=?, password=NULL WHERE id=? LIMIT 1");
    $stmt->bind_param('si', $hash, $usuid);
    $stmt->execute();
    $stmt->close();
    
	$mens = "<span class='b mediana'>".i("cambiadopass",$ilink)."</span><p></p>";
	$password = $pass1;
	
}

?>

<p></p>

<div class='col-9' style='margin:auto'><?php

echo $mens;

if($password == "123456" || $password == "12345678") {
	echo "<span class='b mediana'>".i("requeridocc",$ilink)."</span><p></p>";
}

echo "<h3 class='center'>".i("tipopasswd",$ilink)."</h3>";?>

</div>

<form method='post' action='ficha.php?usuid=<?php echo $usuid;?>&op=24'>

<?php

echo "<fieldset class='col-3' style='margin:auto'><legend>$usuario - ".i("clave",$ilink)."</legend>";
$type = "password"; 
if ($usuid != $_SESSION['usuid']) {$type="text";}

echo "<label>* ".i("selecc",$ilink)."</label><br>";
echo "<input type='$type' $readonly size='15' maxlength='15' required pattern='[A-Za-z0-9._-]{8,15}' title='A-Z a-z 0-9 . - _    8->15' value='' name='pass0'> 
<br><label>* ".i("repc",$ilink)."</label><br>";
echo "<input type='$type' $readonly size='15' maxlength='15' required pattern='[A-Za-z0-9._-]{8,15}' title='A-Z a-z 0-9 . - _    8->15' value='' name='pass1'> ";


echo "<input type='hidden' name='op' value='24'>";

echo "<p></p><input type='submit' class='col-2' name='cambpass' value=\"".i("validarnd",$ilink)."\">";

echo "</fieldset>";


?>

</form>




<?php


?>