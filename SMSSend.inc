<?php
if (!function_exists('sendSMS')) {
    function sendSMS($to, $message, array $opts = []) {
        // TODO: integrar proveedor real (Arsys/Twilio/etc.)
        return false; // indicar "no enviado"
    }
}
?>