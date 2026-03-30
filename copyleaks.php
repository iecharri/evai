<?php

require_once __DIR__ . "/siempre_base.php";

$tipos = array("txt","pdf","docx","doc","rtf","xml","ppt","xppt","odt","chm","epub","odp","ppsx","pages","xlsx","xls","csv","latex");

$partes = explode(".", $_GET['tabla']);
$ext = end($partes);

$fichrevisar = DATA_DIR.base64_decode($_GET['n']).$_GET['tabla']; 

echo "<p></p>Documento a revisar: ".$_GET['tabla']."<p></p>";

include("php-plagiarism-checker/example_synchronous.php");

echo "<p></p>";

?>
