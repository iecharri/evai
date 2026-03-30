<?php

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

function mgnmg($tabla,$id,$ilink,$clickar) {
	echo "<p class='both'></p><br>";
	like($tabla,$id,$ilink,$clickar);
}

function like($tabla,$id,$ilink,$clickar) {	

$sql = "SELECT COUNT(id) FROM socialmgnmg WHERE tabla = '$tabla' AND id = '$id' AND mgnmg = '1'";
$iresult = $ilink->query($sql);
$n1 = $iresult->fetch_array(MYSQLI_BOTH);

$sql = "SELECT COUNT(id) FROM socialmgnmg WHERE tabla = '$tabla' AND id = '$id' AND mgnmg = '2'";
$iresult = $ilink->query($sql);
$n2 = $iresult->fetch_array(MYSQLI_BOTH);

$like1 = "$n1[0] <span class='icon-like'></span> ".i("like1",$ilink);
$like2 = "$n2[0] <span class='icon-like2'></span> ".i("like2",$ilink);
$usuid = $_SESSION['usuid'];
$div = $tabla."_".$id."_".$usuid;

echo "<span id='$div'>";
tipotabla($tabla,$ilink);

if ($clickar) {
	echo "<a onclick=\"javascript:llamarasincrono('social_like.php?tabla=$tabla&id=$id&sino=1&clickar=$clickar','$div');\"><button class='likepeq'>$like1</button></a> ";
	echo "<a onclick=\"javascript:llamarasincrono('social_like.php?tabla=$tabla&id=$id&sino=2&clickar=$clickar','$div');\"><button class='likepeq'>$like2</button></a>";
} else {
	echo "<button class='likepeq' disabled>$like1</button> ";
	echo "<button class='likepeq' disabled>$like2</button>";

}

echo "</span>";

}

function tipotabla($tabla,$ilink) {
	echo "<span class='txth peq'>";
	if ($tabla == "vinculos") {	
		echo i("vinculo",$ilink);
	} elseif ($tabla == "foro") {	
		echo i("foro",$ilink);
	}	elseif ($tabla == "coment" OR $tabla == "textos" OR $tabla == "vinchs2") {	
		echo i("comentario",$ilink);
	}	elseif ($tabla == "fotos") {	
		echo i("foto",$ilink);
	}
	echo "</span> ";
}
?>
