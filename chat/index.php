<?php

require_once __DIR__ . "/../siempre_base.php";


extract($_GET);
extract($_POST);

$script = "chat";
$enchatusuid = $sala;

if($sala1) {$body = "onload='document.form1.message.focus()'";}

require_once APP_DIR . '/molde_top.php';

// --------------------------------------------------

if ($enchatusuid) {

	require_once APP_DIR . "/banner.php";
	require_once APP_DIR . "/hiperen.php";
	$banner = banner($ilink);

	if ($banner) {
		echo "<marquee width=100% behavior='scroll' direction='left' scrollamount='5'><span class='b whit'> ";
		echo $banner; //conhiper(consmy(trim($banner)));
		echo " </span></marquee>";
	}

	require_once APP_DIR . '/chat/chat.php';
	
} else {
	echo "<div class='center'><form name='crear' method='post'><br><p></p>";
	if ($_SESSION['asigna']) {
		echo "<a class='b' href='?sala=".$_SESSION['asigna']."'>".i("enchatentr",$ilink)." ".$_SESSION['asigna']."</a><p></p>";
	}
	echo i("enchat",$ilink)."<p></p><input class='col-3' type='text' name='sala' size='15' value='GENERAL'> 
	<input class='col-1' type='submit' name='sala1' value=' >> '></form><p></p>";
	require_once APP_DIR . '/chat/controlx.php';
	$iresult = $ilink->query("SELECT usuid FROM chat");
	$numusu = $iresult->num_rows;
	if (!$numusu) {$numusu = 0;}
	echo i("enchatusu",$ilink)." ".$numusu;
	echo "</div>";
}

require_once APP_DIR . '/molde_bott.php';
?>