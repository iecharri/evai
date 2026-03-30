<?php

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');
	
	if ($_FILES['upimagen']['name']) {
		$archivo = $_FILES["upimagen"]["tmp_name"];
		$tipofich = $_FILES["upimagen"]["type"];
		$imagen = file_get_contents($archivo);
		$imagen = $ilink->real_escape_string($imagen);
	}
	
	$iresult = $ilink->query("SELECT MAX(n) FROM ".$bolsa."_");
	$fila = $iresult->fetch_array(MYSQLI_BOTH);
	$tempn = $fila[0]+1;
	$t1 = "C";
	if($t1check == "on") {$t1 = "N";}
	
	if ($input1 == "longtext") {$t1 = "L";}
	if (!$input1) {$t1 = "";}
	
	if (!($input1=='persiana' OR $input1=='check') OR (
						($input1=='persiana' OR $input1=='check') AND ($valor1 OR $lickert))
						) {
		
		if (!$anchoimag) {$anchoimag=70;}
		
		if ($imagen) {
			$sql = "INSERT INTO ".$bolsa."_ (n, orden, p, tipo, amin, amax, input, r, imagen, tipofich, ancho) VALUES 
			('$tempn', 999999, '$p1', '$t1', '$amin1', '$amax1', '$input1', '$r1', \"$imagen\", '$tipofich', '$anchoimag')";
		} else {
			$sql = "INSERT INTO ".$bolsa."_ (n, orden, p, tipo, amin, amax, input, r, youtube, anchoyoutube) VALUES 
			('$tempn', 999999, '$p1', '$t1', '$amin1', '$amax1', '$input1', '$r1', '$youtube', '$anchoyoutube')";
		}

		$ilink->query($sql);
	
		if ($input1 == 'persiana' OR $input1 == 'check') {
			
			if ($lickert) {
				for ($i=1;$i<$lickert+1;$i++){
					$ilink->query("INSERT INTO ".$bolsa."_ (n, n1, p, orden) VALUES ('$tempn', $i, $i, $i)");
				}
			} else {
				$ilink->query("INSERT INTO ".$bolsa."_ (n, n1, p, r, orden) VALUES ('$tempn', 1, '$valor1', '$feedback1',1)");
			}
			//$reganadir1 = 0;
			
		}
		
		$regmodif = $tempn;
		$reganadir = 0;
		$reganadir1 = 0;
		
	}


?>