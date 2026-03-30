<?php

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

// --------------------------------------------------

function formuidioma($ilink,$op) {
	
	$i = $_SESSION['i'];
	
	?>
	
	<p class='mt5'></p>
	<form method='post' action='login.php?op=<?php echo $op;?>'>
	<select name='idioma' onchange='this.form.submit()'>
	<option value='c' <?php if ($i == 'c'){echo "selected='selected'";}?>>Castellano</option>
	<option value='v' <?php if ($i == 'v'){echo "selected='selected'";}?>>Valenci&agrave;</option>
	<option value='i' <?php if ($i == 'i'){echo "selected='selected'";}?>>English</option>
	</select> 
	</form>
 
<?php
}

// --------------------------------------------------

function login($anch,$ilink,$clogin) {

	if (DEMO_BTN): ?>

	 <p style="margin-top:1em;font-weight:600;">
  		👉 <?php echo i("demologin1",$ilink);?>
	</p>

    <!-- Botón para entrar en modo DEMO -->
    <form method="post" action="login.php" style="margin-bottom:1em; text-align:center;">
    <button type="submit" name="demo" value="1" class="btn">DEMO MODE</button>   <!--  -->
    </form>
    
   <?php else: ?>
   
    <p></p>	
    
	<?php endif; ?>

	<div class='login-card'>

	<form class='ib col-5' action='login.php' name='form' method='post' autocomplete='off'>
	
   <input type="hidden" name="csrf" value="<?=htmlspecialchars($_SESSION['csrf'])?>">

	<?php
	
	$usuario_old = htmlspecialchars($_POST['usuario'] ?? '', ENT_QUOTES, 'UTF-8');
	
	?>
	
	<?php if (DEMO_BTN): ?>
	
	<p style="font-weight:600;">
  		<?php echo "👤 ".i("demologin2",$ilink);?>
	</p>
		
	<?php else: ?>
	
	<h4><span class='icon-user'> </span><span class='anch'></span><?php echo $anch."&nbsp;".i("estudiyprof",$ilink);?></h4>

	<?php endif; ?>


	<input type="text" id="usuario" name="usuario"
  placeholder="<?php echo htmlspecialchars(i('usuario', $ilink), ENT_QUOTES, 'UTF-8');?>"
  value="<?php echo $usuario_old; ?>"
  maxlength="15" autocomplete="username"
  style="width:150px; padding:0.4em;"><br>

	<input type="password" name="password"
  placeholder="<?php echo htmlspecialchars(i('clave', $ilink), ENT_QUOTES, 'UTF-8');?>"
  maxlength="15" autocomplete="current-password"
  style="width:150px; padding:0.4em;">

  <br>
    
  <input type="checkbox" name="recordar">
  <span class="peq"><?php echo i('recordar', $ilink);?></span>
  <br>
  <button type="submit" name="entrar" value="1" class="btn"><?php echo i("entrar",$ilink);?></button>
    
	</form> 
	
	</div>   
    
<?php

}

// --------------------------------------------------

function olvidocuenta($fromid,$ilink,$anch) {
	
	if(!OLVIDO_YNUEVOUSU) {return;}

	extract($_POST);

	?>
	<form name='olvido' method='post' action='login.php?op=2'>

		<h3><span class='icon-point-up'></span> <?php echo $anch." ".i("olvido2",$ilink);?></span></h3>
		<?php echo "<div class='justify' style='margin:1em'>".i("olvido",$ilink)."</div><p></p>";?>

		<input class="form-control" type='email' name='olvimail' size='20' maxlength='50' value='<?php echo $olvimail;?>' autofocus="" required>

		<p></p>
		<input type='submit' value="<?php echo strtoupper(i("enviar",$ilink));?>" name='olvido1'>

	</form>
	<?php

	if (!$olvido1) {return;}
	
	// 1. Recibir mail del formulario
	$olvimail = trim($_POST['olvimail']);

	// 2. Buscar el usuario
	$stmt = $ilink->prepare("SELECT id FROM usuarios WHERE mail = ? LIMIT 1");
	$stmt->bind_param("s", $olvimail);
	$stmt->execute();
	$res = $stmt->get_result();
	$user = $res->fetch_assoc();
	$stmt->close();

	if (!$user) {
    	// No existe ese correo
    	echo "ERROR";
    	return; exit;
	}

	$userId = (int)$user['id'];

	// 3. Generar token y fecha de caducidad
	$token  = bin2hex(random_bytes(32)); // 64 caracteres hex
	$expira = date('Y-m-d H:i:s', time() + 3600); // +1 hora

	// 4. Guardar en la tabla pass_reset
	$stmt = $ilink->prepare("INSERT INTO pass_reset (user_id, token, expira) VALUES (?, ?, ?)");
	$stmt->bind_param("iss", $userId, $token, $expira);
	$stmt->execute();	
	
	// 5. Enviar mail con el enlace
	$url = DOMINIO.APP_URL."/olvido.php?token=" . urlencode($token);	
	$link = "<a href=\"$link\">$link</a>";

	$mailasunto = i("olvidoasunto",$ilink);
	$mailtexto  = i("olvidomail",$ilink);

// 2. Si quieres versión HTML clicable:
	$link = "<a href=\"$url\">$url</a>";
	$mailasunto = reempl("<SITE>", strtoupper(SITE),$mailasunto);
	$mailtexto = reempl("<SITE>", strtoupper(SITE),$mailtexto);
	$mailtexto1 = reempl("<LINK>", $link,$mailtexto);
	$mailtexto2 = reempl("<LINK>", $url,$mailtexto);

	$exito = pormail($fromid, $userId, $mailasunto,$mailtexto1,$mailtexto2,$ilink);
	
	if ($exito) {
		echo "<p>".i("olvidoenvio",$ilink).$mail."</p>";
	} else {
		if(demo_enabled()) {
			echo "Not in Demo mode";
		} else {
			echo "<br><p class='auto'>ERROR</p>";
		}
	}

}

// --------------------------------------------------

function reempl($a,$b,$cadena) {
	return str_replace($a, $b, $cadena);
}

// --------------------------------------------------

function err_login(string $usu, string $pass, mysqli $db): ?array {
    $usu  = trim($usu);

    // Usuario: 3–15, letras/números/._-
    if (!preg_match('/\A[a-z0-9._-]{3,15}\z/i', $usu)) {
        return [1, i('usunoex', $db)];
    }

    // Password: 4–15, sin espacios, ni ' " \
    if (!preg_match('/\A[^\s\'"\\\\]{4,15}\z/u', $pass)) {
        return [1, i('usunoex', $db)];
    }
    
    return null; // ok
}

// --------------------------------------------------

function recordar(int $usuid, mysqli $ilink): void
{
    // 0) Preferimos el usuid de sesión si existe
    if (!empty($_SESSION['usuid'])) {
        $usuid = (int)$_SESSION['usuid'];
    }
    $usuid = (int)$usuid;
    if ($usuid <= 0) { return; } // ✅ comprobación de usuid

    // Helper: token válido = hex de 64 chars (random_bytes(32) → bin2hex)
    $isValidToken = static function ($t): bool {
        return is_string($t) && preg_match('/^[a-f0-9]{64}\z/i', $t) === 1;
    };

    // 1) Leer lista actual de tokens (y filtrar válidos)
    $tokens = [];
    $stmt = $ilink->prepare("SELECT recordar FROM usuarios WHERE id = ?");
    $stmt->bind_param('i', $usuid);
    $stmt->execute();
    $res = $stmt->get_result();
    if ($row = $res->fetch_assoc()) {
        $raw = (string)($row['recordar'] ?? '');
        $tokens = array_values(array_filter(
            explode('*', $raw),
            fn($t) => $t !== '' && $isValidToken($t)
        ));
    }
    $stmt->close();

    $cookieName = defined('SITE') ? SITE : 'evai';
    $cookieVal  = $_COOKIE[$cookieName] ?? '';
    if ($cookieVal !== '' && !$isValidToken($cookieVal)) {
        // ✅ validación mínima del token de cookie
        $cookieVal = '';
    }

    // 2) ¿Usuario marcó "recordar"?
    if (!empty($_POST['recordar'])) {

        // Si no hay cookie, la creamos con token fuerte
        if ($cookieVal === '') {
            $cookieVal = bin2hex(random_bytes(32)); // 64 chars
            setcookie(
                $cookieName,
                $cookieVal,
                [
                    'expires'  => time() + 60*60*24*365,
                    'path'     => '/',
                    'secure'   => !empty($_SERVER['HTTPS']),
                    'httponly' => true,
                    'samesite' => 'Lax',
                ]
            );
            $_COOKIE[$cookieName] = $cookieVal; // reflejo en este request
        }

        // Añadir evitando duplicados exactos
        if (!in_array($cookieVal, $tokens, true)) {
            $tokens[] = $cookieVal;
        }

        // ✅ capado: guarda solo los últimos 5
        $max = 5;
        if (count($tokens) > $max) {
            $tokens = array_slice($tokens, -$max);
        }

        $nuevo = implode('*', $tokens);
        $stmt = $ilink->prepare("UPDATE usuarios SET recordar = ? WHERE id = ?");
        $stmt->bind_param('si', $nuevo, $usuid);
        $stmt->execute();
        $stmt->close();

    } else {
        // 3) Si existe cookie pero NO se marcó "recordar", la quitamos
        if ($cookieVal !== '') {
            // Quitar el token actual
            $tokens = array_values(array_filter($tokens, fn($t) => $t !== $cookieVal));

            // ✅ (opcional) mantener el límite también aquí
            $max = 5;
            if (count($tokens) > $max) {
                $tokens = array_slice($tokens, -$max);
            }

            $nuevo = implode('*', $tokens);
            $stmt = $ilink->prepare("UPDATE usuarios SET recordar = ? WHERE id = ?");
            $stmt->bind_param('si', $nuevo, $usuid);
            $stmt->execute();
            $stmt->close();

            // Borrar cookie (mismo nombre y path)
            setcookie(
                $cookieName,
                '',
                [
                    'expires'  => time() - 3600,
                    'path'     => '/',
                    'secure'   => !empty($_SERVER['HTTPS']),
                    'httponly' => true,
                    'samesite' => 'Lax',
                ]
            );
            unset($_COOKIE[$cookieName]);
        }
    }
}

?>