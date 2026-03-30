<?php

session_start(); //Necesario, se carga en head.php en un <script>

if (isset($_GET['zone'])) {
    $zone = $_GET['zone'];

    try {
        // Validar que sea una zona horaria válida
        new DateTimeZone($zone);

        // Guardar en la sesión
        $_SESSION['zone'] = $zone;

        // Guardar cookie persistente (1 año)
        setcookie(
            "zone",
            $zone,
            [
                'expires'  => time() + 31536000, // 1 año
                'path'     => '/',
                'secure'   => !empty($_SERVER['HTTPS']),
                'httponly' => true,
                'samesite' => 'Lax',
            ]
        );

        http_response_code(204); // Sin contenido, todo OK
    } catch (Exception $e) {
        http_response_code(400); // Zona inválida
    }
    exit;
}

http_response_code(400); // Falta parámetro zone

?>