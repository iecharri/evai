<?php

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

$iresult = $ilink->query("SELECT adminid, altalibre, cuestionario FROM atencion");
$from = $iresult->fetch_array(MYSQLI_BOTH);
$altalibre = $from[1]; $fromid = $from[0];$cuestppal = $from[2];
$iresult = $ilink->query("SELECT mail FROM usuarios WHERE id = '$from[0]' LIMIT 1");
$from = $iresult->fetch_array(MYSQLI_BOTH);
$admi = $from[0];

if(!$op) {$op = 1;}

if($cuestppal) {
	iconex(DB2,$ilink);
	$result = $ilink->query("SHOW TABLES LIKE '$cuestppal"."1'");
	if(!$result->num_rows) {
		$cuestppal = "";
	}
	iconex(DB1,$ilink);
}

$sel = "active";
$a = "a".$op;
$$a = $sel;

echo "<h1>".strtoupper(SITE)."</h1>";

echo "<div class='peq ib'><a class='menu $a1' href='?op=1'><span class='icon-user'><br></span><span class='anch'>Login</span></a>";

if(OLVIDO_YNUEVOUSU) {$temp = "href='?op=2'"; } else {$temp = "href='#' title=\"".i("desactivado",$ilink)."\" style='color: inherit;pointer-events:none;'";}
echo "<a class='menu $a2' $temp>🔑<br><span class='anch'>".i("olvido2",$ilink)."</span></a>"; //<span class='icon-point-up'></span>
if ($altalibre) {
	if(OLVIDO_YNUEVOUSU) {$temp = "href='?op=3'"; } else {$temp = "href='#' title=\"".i("desactivado",$ilink)."\" style='color: inherit;pointer-events:none;'";}
	echo "<a class='menu $a3' $temp><span class='icon-user-plus'></span><br><span class='anch'>".i("nuevousu",$ilink)."</span></a>";
}
echo "<a class='menu' href='mailto:".$admi."'><span class='icon-mail2'></span><br><span class='anch'>".i("contacto1",$ilink)."</span></a>";

if ($cuestppal) {echo "<a class='menu' href='cuest/cuestionario.php' target='cuest'><span class='icon-list-numbered'></span><br><span class='anch'>".i("cuest",$ilink)."</span></a>";}

echo "</div>";