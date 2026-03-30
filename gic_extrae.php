<?php

// Copyright (c) 2000-2026 Inmaculada Echarri San Adrián
// Copyright (c) 2000-2026 Antonio Grandío Botella
// This file is part of EVAI.
// Licensed under the MIT License.
// See LICENSE.txt for details.

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

if (!$_SESSION['fabrir']) {return;}

$id = $_GET['id'];

$sql = "SELECT url FROM vinculos WHERE vinculos.id = $id LIMIT 1";

$result = $ilink->query($sql);

$fila = $result->fetch_array(MYSQLI_BOTH);

$url = $fila['url'];

// Asegurar prefijo http:// o https://
if (!preg_match('~^https?://~i', $url)) {
    $url = 'http://' . $url;
}

// Obtener meta tags
$temp = @get_meta_tags($url) ?: [];

// Recoger keywords y description con seguridad
$keywords    = $temp['keywords']    ?? '';
$description = $temp['description'] ?? '';

// Si no hay nada, salir
if ($keywords === '' && $description === '') {
    echo i("noclanires", $ilink);
    return;
}

// Mostrar resultados
echo "<span class='b'>" . i("claresupg", $ilink) . "</span><p></p>";

echo "<span class='txth b'>" . i("claves", $ilink) . ":</span><br>\n";
$sql = addslashes($keywords);   // ojo: addslashes, no AddSlashes (case-sensitive en PHP)
echo htmlspecialchars($keywords) . "<p></p>";

echo "<span class='txth b'>" . i("resumen", $ilink) . ":</span><br>\n";
$sql = addslashes($description);
echo htmlspecialchars($description) . "<p></p>";

return;





$temp = @get_meta_tags("http://".$fila['url']);

if ($temp[keywords] == '' AND $temp[description] == '') {
	echo i("noclanires",$ilink);
	return;
}

echo "<span class='b'>".i("claresupg",$ilink)."</span><p></p>";
echo "<span class='txth b'>".i("claves",$ilink).":</span><br>\n";

$sql = AddSlashes ($temp['keywords']);

echo "<p></p><span class='txth b'>".i("resumen",$ilink).":</span><br>\n";

$sql = AddSlashes ($temp['description']);

echo "<p></p>";

?>

