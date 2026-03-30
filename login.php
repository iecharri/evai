<?php

require_once __DIR__ . '/siempre_base.php';
require_once APP_DIR . '/login_func.php';
require_once APP_DIR . '/enviospor.php';
require_once APP_DIR . '/_superadmins.php';
include_once APP_DIR . "/home_previo.php";

cargar_superadmins($ilink);

// --------------------------------------------------

//if(!$_SESSION['index']) {
if (isset($_GET['x']) && $_GET['x']=='1') {
	header("Location: index.php");exit;
}

// --------------------------------------------------
// Esto poner antes de hacer ningún echo, si no los Location: no funcionan

if(isset($_POST['idioma'])) {
	setcookie("i", $_POST['idioma'], time() + 60*60*24*30, "/"); $_SESSION['i'] = $_POST['idioma'];
} else {
	if (isset($_COOKIE['i'])) {$_SESSION['i'] = $_COOKIE['i'];}
}
if (isset($_COOKIE['paleta'])) {$_SESSION['paleta'] = $_COOKIE['paleta'];}
// --------------------------------------------------

if (!empty($_POST['demo'])) {
	
	$_SESSION['demo_mode'] = true;
	$sql = "SELECT id, autorizado, fechaalta, ultasigna, passwordinicial, menusimple FROM usuarios WHERE id = 1 LIMIT 1";
	$result = $ilink->query($sql);
	$fila = $result->fetch_array(MYSQLI_BOTH);
	home_previo($fila['id'], $ilink); // home_previo desvía a home.php
	
}

// --------------------------------------------------

if (!empty($_POST['entrar'])) {
	
	$msg = (string)i('usunoex', $ilink);
	if($msg === "") {$msg = "Usuario/clave incorrectos";}
	
	$porquenoentro = null;  // ← inicializa SIEMPRE

// 1) CSRF: debe existir y coincidir
    $tokenForm = (string)($_POST['csrf'] ?? '');
    $tokenSess = (string)($_SESSION['csrf'] ?? '');

    if ($tokenForm === '' || $tokenSess === '' || !hash_equals($tokenSess, $tokenForm)) {
        // Token inválido → no seguimos con el login
        $porquenoentro = $msg;
    } else {
        // 2) Si el token es válido, ya puedes seguir con tu flujo normal
	
		$usuario  = trim($_POST['usuario']  ?? '');
		$pwd = (string)($_POST['password'] ?? '');

      if ($usuario === '' || $pwd === '') {
         $porquenoentro = $msg;
      }

      if ($porquenoentro === null) {
         $err = err_login($usuario, $pwd, $ilink); // haz que devuelva NULL en éxito
         if ($err !== null && $err !== false && $err !== '') {
             $porquenoentro = is_array($err) ? ($err[1] ?? 'Login incorrecto') : (string)$err;
         }
      }
                
      if ($porquenoentro === null) {

			$row = null; // ← importante
			$sql = "SELECT id, autorizado, ultasigna, pass_hash FROM usuarios WHERE usuario = ? LIMIT 1";
			$stmt = $ilink->prepare($sql);
			if ($stmt !== false) {
				$stmt->bind_param('s', $usuario);
				if ($stmt->execute()) {
					$res = $stmt->get_result();
					if ($res) {
						$row = $res->fetch_assoc() ?: null;
					}
				}
				$stmt->close();
			}
			if ($porquenoentro === null) {
  			  if (!is_array($row) || empty($row['pass_hash']) || !password_verify($pwd, $row['pass_hash'])) {
   	     	$porquenoentro = $msg;
   		  }
   		}
			// Rehash si toca (solo con OK previo)
			if ($porquenoentro === null && is_array($row) && isset($row['id'], $row['pass_hash'])) {
				$algo = defined('PASSWORD_ARGON2ID') ? PASSWORD_ARGON2ID : PASSWORD_DEFAULT;
				if (password_needs_rehash($row['pass_hash'], $algo)) {
    				$nuevo = password_hash($pwd, $algo);
    				$upd = $ilink->prepare("UPDATE usuarios SET pass_hash=? WHERE id=?");
    				$upd->bind_param('si', $nuevo, $row['id']);
    				$upd->execute(); 
    				$upd->close();
				}			
			
			}

			unset($pwd);

			if ($porquenoentro === null && is_array($row) && isset($row['id'])) {
				$porquenoentro = home_previo((int)$row['id'], $ilink); // home_previo desvía a home.php si procede, si no: cargar formulario de login
			}
			
		}
	}
	
}

if ($porquenoentro !== null) { usleep(200000); } // 200 ms   //trabas a fuerza bruta, si no se hace login bien

// --------------------------------------------------

$op = $_GET['op'];
if(!$op) {$op=1;}

if($_POST['mail']) {$op = 3;}

// --------------------------------------------------

require_once APP_DIR . '/head.php'; 

echo "<body $body>";

?>

<a name='inicio'></a>

<div class="login-wrap " style="margin:auto;">
  
  <div class="login-left col-4 ce">
    <?php
      require_once APP_DIR . '/cab_menutopl.php'; 
      formuidioma($ilink,$op);

      if ($op == 2) {
        olvidocuenta($fromid,$ilink,$anch);
      } elseif($op == 3) { 
        require_once APP_DIR . '/login_nuevousu.php';
      } else {
        login($anch,$ilink,$clogin);
        echo "<p></p><span class='rojo b'>".$porquenoentro."</span>";
      }
    ?>
  </div>

  <div class="login-right col-6 ce">
    <?php 
      if ($tit) echo "$tit<br>";
      echo "<img src='" . MEDIA_URL . "/stargr.png' class='logo-evai' alt=\"".i("evai",$ilink)."\" title=\"".i("evai",$ilink)."\">";
    ?>
  </div>

</div>

<?php

require_once APP_DIR .  "/molde_bott.php";
	
// --------------------------------------------------

function sugerencias($admi,$ilink) {
	echo "<a href='mailto:$admi'><span class='icon-mail2'></span>".i("gaciassuger",$ilink)."</a>";
}

?>