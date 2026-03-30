<?php

if (!defined('EVA_BOOTSTRAP')) define('EVA_BOOTSTRAP', 1);

require_once __DIR__ . '/siempre_base.php';

$u = isset($_GET['u']) ? (int)$_GET['u'] : 0;
$t = $_GET['t'] ?? '';
if ($u <= 0 || $t === '') { echo 'ERROR'; exit; }

// --------------------------------------------------
// 1) Traer datos necesarios: token-hash y si venció el plazo
$sql = "SELECT passwordinicial, (UTC_DATE() >= DATE_ADD(fechaalta, INTERVAL 7 DAY)) AS plazo_cumplido, autorizado, tipo FROM usuarios WHERE id = ? LIMIT 1";
$stmt = $ilink->prepare($sql);
$stmt->bind_param('i', $u);
$stmt->execute();
$stmt->bind_result($passwordinicial, $plazo_cumplido, $autorizado, $tipo);

if (!$stmt->fetch()) {
    $stmt->close();
    $x = 1; // Imposible activar / ya activa
} else {
    $stmt->close();

    // 2) Decidir resultado
    if ($passwordinicial === null || $passwordinicial === '') {
        $x = 1; // ya estaba activada
    } elseif ((int)$plazo_cumplido === 1) {
        $x = 3; // plazo de 7 días caducado
    } elseif (!password_verify($t, $passwordinicial)) {
        $x = 2; // token inválido
    } else {
        // 3) Activar: limpiar token y auditar como hacías
        $date = gmdate('Y-m-d H:i:s');

        // Limpia passwordinicial (tu código usaba cadena vacía) y pone campos autorizado y fecha
			$auto = 4;
			if ($autorizado == 0 AND $tipo == 'P') {$auto = 5;}
			$date = gmdate('Y-m-d H:i:s');
			$upd = $ilink->prepare("UPDATE usuarios SET passwordinicial = '', autorizado = ?, fecha = ? WHERE id = ?");
			$upd->bind_param('isi', $auto, $date, $u);
         $upd->execute();
         $upd->close();
			
        // Registro en fichaactualiz (como tenías)
        $ins = $ilink->prepare("INSERT INTO fichaactualiz (usuid, cambio, fecha) VALUES (?, 'newuser', ?)");
        $ins->bind_param('is', $u, $date);
        $ins->execute();
        $ins->close();

        $x = 0; // activada ok
    }
}

// --------------------------------------------------
// 4) Salida: tu texto y link, usando tus mensajes
$link = "<a href='" . DOMINIO .APP_URL . "/index.php'><img src='" . DOMINIO . MEDIA_URL . "/cabpeq.png'> &nbsp; " . strtoupper(SITE) . "</a> &nbsp; ";
echo $link;

// Mensaje según $x, usando tu función (ahora devuelve texto)
echo yaact($x, $ilink)." "."<a href='" . DOMINIO . APP_URL . "/index.php'>".strtoupper(SITE)."</a>";

require_once APP_DIR . "/molde_bott.php";
exit;

// --------------------------------------------------
// Función de mensajes: solo devuelve el texto (no imprime)
function yaact($x, $ilink) {
    // 0 = activada OK
    if ($x === 0) {
        // "cuentaacti" era tu clave de idioma para "Cuenta activada"
        return i("cuentaacti", $ilink);
    }
    // 1 = Imposible activar / ya activa
    if ($x === 1) {
        return i("altaerror1", $ilink); // "Imposible activar la cuenta o ya está activa."
    }
    // 2 = Clave/token no válido
    if ($x === 2) {
        return i("altaerror2", $ilink); // "Clave no válida."
    }
    // 3 = No activada en tiempo
    if ($x === 3) {
        return i("altaerror3", $ilink); // "Cuenta no activada en el tiempo requerido."
    }
    // Por si acaso
    return i("altaerror1", $ilink);
}
