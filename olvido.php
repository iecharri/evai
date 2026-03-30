<?php

require_once __DIR__ . "/siempre_base.php";   // conexión $ilink

// 1. Recibir el token por GET
$token = $_GET['token'] ?? '';
if (!$token) {
    die("Enlace inválido");
}

// 2. Buscar token en la tabla pass_reset
$stmt = $ilink->prepare("SELECT user_id, expira, usado FROM pass_reset WHERE token = ? LIMIT 1");
$stmt->bind_param("s", $token);
$stmt->execute();
$res = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$res) {
    die("Enlace inválido o inexistente");
}
if ($res['usado']) {
    die("Este enlace ya se ha utilizado");
}
if (strtotime($res['expira']) < time()) {
    die("Este enlace ha caducado");
}

$userId = (int)$res['user_id'];

// 3. ¿El usuario ya ha enviado la nueva contraseña?
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pass1 = trim($_POST['pass1'] ?? '');
    $pass2 = trim($_POST['pass2'] ?? '');

    if ($pass1 === '' || $pass1 !== $pass2) {
        $error = i("contranocoinc",$ilink); //no coinciden
    } elseif (strlen($pass1) < 8) {
        $error = i("tipopasswd",$ilink);  // deben ser entre 8 y 15 caracteres
    } else {
        // 4. Guardar nueva contraseña
        $hash = password_hash($pass1, PASSWORD_DEFAULT);

        $stmt = $ilink->prepare("UPDATE usuarios SET pass_hash = ? WHERE id = ?");
        $stmt->bind_param("si", $hash, $userId);
        $stmt->execute();
        $stmt->close();

        // 5. Marcar token como usado
        $stmt = $ilink->prepare("UPDATE pass_reset SET usado = 1 WHERE token = ?");
        $stmt->bind_param("s", $token);
        $stmt->execute();
        $stmt->close();

        $cambiook = 1;
        
    }
}

require_once APP_DIR . "/olvido1.php";   

?>



