<?php

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

if(demo_enabled()) {
	return;
}

$ilink->query("UPDATE usuasi SET numvinc = 0, rotos = 0, numvotrec = 0, nota = 0, desvtip = 0 WHERE id ='$u'");

$res = $ilink->query("SELECT area, count(usu_id) AS count, SUM(roto) AS rotos FROM vinculos WHERE usu_id = '$u' GROUP BY area ");

while ($fi = $res->fetch_array(MYSQLI_BOTH)) {

	$asi = $fi['area']; $count = $fi['count']; $rotos = $fi['rotos'];
	$temp = "SELECT * FROM usuasi WHERE id = '$u' AND asigna='$asi'";
	$iresult = $ilink->query($temp);
	if ($iresult->num_rows == 0) {
		$ilink->query("INSERT INTO usuasi (id, asigna, numvinc, rotos) VALUES ('$u', '$asi', '$count' , '$rotos')");
	} else {
		$ilink->query("UPDATE usuasi SET numvinc = '$count', rotos = '$rotos' WHERE id = '$u' AND asigna = '$asi'");
	}

}

$res = $ilink->query("SELECT asigna FROM usuasi WHERE id = '$u'");

while ($fi = $res->fetch_array(MYSQLI_BOTH)) {

	$asig = $fi['asigna'];
	$iresult = $ilink->query("SELECT COUNT(votos), AVG(votos), STDDEV(votos) FROM votos LEFT JOIN vinculos ON votos.vinculo_id=vinculos.id WHERE vinculos.usu_id = '$u' and votos > 0 AND area = '$asig'");
	$temp = $iresult->fetch_array(MYSQLI_BOTH);
	$votosrec = $temp[0];
	$puntu = $temp[1];
	$desvi = $temp[2];
	$ilink->query("UPDATE usuasi SET numvotrec = '$votosrec', nota = '$puntu', desvtip = '$desvi' WHERE id = '$u' AND asigna = '$asig'");

}

$iresult = $ilink->query("SELECT SUM(numvinc), SUM(numvotrec), SUM(rotos) FROM usuasi WHERE usuasi.id = '$u'");
$temp = $iresult->fetch_array(MYSQLI_BOTH);
$numvinc1 = $temp[0];
$votosrec = $temp[1];
$rotos = $temp[2];

$iresult = $ilink->query("SELECT COUNT(votos), AVG(votos), STDDEV(votos) FROM votos LEFT JOIN vinculos ON votos.vinculo_id=vinculos.id WHERE vinculos.usu_id = '$u' and votos > 0");
$temp = $iresult->fetch_array(MYSQLI_BOTH);
$puntu = $temp[1];
$desvi = $temp[2];

$iresult = $ilink->query("SELECT COUNT(usu_id) FROM vinchs2 WHERE usu_id = '$u'");
$temp = $iresult->fetch_array(MYSQLI_BOTH);
$coment = $temp[0];

$iresult = $ilink->query("SELECT COUNT(usu_id) FROM votos WHERE usu_id = '$u' and votos > 0");
$temp = $iresult->fetch_array(MYSQLI_BOTH);
$votemi = $temp[0];

$ilink->query("UPDATE usuarios SET coment = '$coment', numvinc = '$numvinc1', numvincvot ='$votemi', numvotrec = '$votosrec', rotos = '$rotos', nota = '$puntu', desvtip = '$desvi' WHERE id = '$u'");

$iresult = $ilink->query("SELECT asigna FROM usuasi WHERE id = '$u' AND asigna != 'GEN'");
$temp = $iresult->num_rows;

if ($temp > 0) {
	$ilink->query("DELETE FROM usuasi WHERE id = '$u' AND asigna = 'GEN' AND numvinc = 0");
} else {
	if ($_SESSION['tipo'] == 'A') {$ilink->query("UPDATE usuarios SET tipo = 'E' WHERE id = '$u'");}
}

?>