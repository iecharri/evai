<?php

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

	if ($borrimag) {
		$ilink->query("UPDATE ".$bolsa."_ SET imagen = '', ancho = '', tipofich = '' WHERE  n = '$regmodif' AND n1 = 0");
	}

	if ($_FILES['upimagen']['name']) {
		$archivo = $_FILES["upimagen"]["tmp_name"];
		$tipofich = $_FILES["upimagen"]["type"];
		$imagen = file_get_contents($archivo);
		$imagen = $ilink->real_escape_string($imagen);
		$ilink->query("UPDATE ".$bolsa."_ SET imagen = \"$imagen\", tipofich = '$tipofich'  WHERE n = '$regmodif' AND n1 = 0");
	}
	$t1 = strtoupper($t1);
	if ($input1 == "longtext") {$t1 = "L";}
	if (!$anchoimag) {$anchoimag=70;}
	if($input1 == "check" OR $input1 == "persiana" OR $input1 == "texto") {
		$t1 = "C";
		if($t1check) {$t1 = "N";}
	}

	$ilink->query("UPDATE ".$bolsa."_ SET anchoyoutube = '$anchoyoutube', youtube='$youtube', ancho='$anchoimag', p = '$p1', tipo = '$t1', amin = '$amin1', amax = '$amax1', input ='$input1', r = '$r1'  WHERE n = '$regmodif' AND n1 = 0");

	if ($input1 == 'texto' OR $input1 == 'longtext' OR !$input1) {

		$ilink->query("DELETE FROM ".$bolsa."_ WHERE n = '$regmodif' AND n1 != 0");
		
	} else {

		$iresult = $ilink->query("SELECT n FROM ".$bolsa."_ WHERE n = '$regmodif' AND n1 != 0");
		$numopciones = $iresult->num_rows;

		if ($editar OR $editar1) {$anadir="";}
	
		$max = $ilink->query("SELECT MAX(n1) FROM ".$bolsa."_ WHERE n=$regmodif");
		$max = $max->fetch_array(MYSQLI_BOTH);
		$nn = $max[0] + 1;
		if ($anadir) {
			if ($lickert > 0) {
				for ($i=1;$i<$lickert+1;$i++){
					$ilink->query("INSERT INTO ".$bolsa."_ (n, n1, p, orden) VALUES ('$regmodif', $i, $i, $i)");
				}
			} elseif ($valor1){
				$ilink->query("INSERT INTO ".$bolsa."_ (n, n1, p, r, orden) VALUES ('$regmodif', '$nn', '$valor1', '$feedback1','$nn')");

			} elseif ($lickert == 'acuerdo') {
				$ilink->query("INSERT INTO ".$bolsa."_ (n, n1, p, orden) VALUES ('$regmodif', '1', 'Muy en desacuerdo'),1");
				$ilink->query("INSERT INTO ".$bolsa."_ (n, n1, p, orden) VALUES ('$regmodif', '2', 'En desacuerdo',2)");
				$ilink->query("INSERT INTO ".$bolsa."_ (n, n1, p, orden) VALUES ('$regmodif', '3', 'Indiferente',3)");
				$ilink->query("INSERT INTO ".$bolsa."_ (n, n1, p, orden) VALUES ('$regmodif', '4', 'De acuerdo',4)");
				$ilink->query("INSERT INTO ".$bolsa."_ (n, n1, p, orden) VALUES ('$regmodif', '5', 'Muy de acuerdo',5)");
			}
		}

		if ($editar1 AND $valor1) {
			$ilink->query("UPDATE ".$bolsa."_ SET p = '$valor1', r = '$feedback1' WHERE n = '$regmodif' AND n1 = '$editar1'");
		}

	}
		
?>

