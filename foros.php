<?php

require_once __DIR__ . '/siempre.php';
require_once APP_DIR . '/fxmail.php';

$tit = $_SESSION['tit'];
$titasi = $_SESSION['titasi'];

extract($_GET);
extract($_POST);
if ($_GET['tod'] AND !$_POST['titasi']) {$titasi = "todos";}

if (!$titasi) {$titasi = "todos";}
if ($titasi) {$_SESSION['titasi'] = $titasi;}
$titasi = $_SESSION['titasi'];

if ($titasi == "todos") {
	$num = 1;
} elseif ($titasi == "general") {
	$num = 2;
}
if ($titasi == 1) {
	$num = 3; 
} elseif ($titasi == 2) {
	$num = 4; 
} 
if ($titasi == 1) {$tit1 = $tit; $curso1 = $curso;}
if ($titasi == 2) {$asigna1 = $asigna; $curso1 = $curso; $grupo1 = $grupo;}

// --------------------------------------------------

if ($_GET['ini'] AND !$_POST['asunto']) {$onload = "onload='document.form1.asunto.focus();'";}
$a_foros = " class = 'active'";
require_once APP_DIR . '/molde_top.php';

?>

<script language="JavaScript">

$(document).ready(function(){

	$('.voto').click(function(){
        var field = $(this);
        var parent = field.attr('id');
        var elid = parent.substring(1);
        var elem = elid.split('_');
        var elid = elem[0]; 
        var voto = elem[1];
        $.post("forovotar.php", {id:elid, voto:voto},
			 function(htmlexterno){
				$( "#votos" + elid).html(htmlexterno);
	     },
		  "html")
	});

})
	
function compruebacamposforo1(form1) {

	if (form1.asunto.value == "" || form1.comentario.value == "")
	{
		alert("<?php echo i("insertaasucomen",$ilink);?>")
		form1.asunto.focus()
		return false
	}

}

function compruebacamposforo2(form1) {

	if (form1.comentario.value == "")
	{
		alert("<?php echo i("insertacomen",$ilink);?>")
		form1.comentario.focus()
		return false
	}

}
</script>

<?php
// --------------------------------------------------

unset($array);

$array[0] = "<span class='icon-pencil2'></span> ".i("foro",$ilink)." <span class='icon-arrow-right'></span>";
if($_GET['ini']) {$array[0] .= " ".i("foronew",$ilink);}

$array[0] = "<a href='foros.php'>".$array[0]."</a>";

if ($_SESSION['asigna']) {
	$array[1] = "<a href='foros.php?titasi=todos'>".i("todoforo",$ilink)."</a>";
} else {
	$array[1] = "";
}

$array[2] = "<a href='foros.php?titasi=general'>General</a>";
$array[3] = "";
$array[4] = "";

if ($asigna) {
	$descrip = descrip($ilink);
	$array[3] = "<a href='?titasi=1'>$tit";
	if ($curso) {$array[3] .= " - $curso";}
	$array[3] .= "</a>";
	$array[4] = "<a href='?titasi=2'>$asigna";
	if ($curso) {$array[4] .= " - $curso";}
	if ($grupo) {$array[4] .= " - $grupo";} // AND $grupo != "*"
	$array[4] .= "</a>";
} else {
	$num = 2;
}
if ($titasi == 2) {$xtitasi = $descrip[1];}
if ($titasi == 1) {$xtitasi = $descrip[0];} 

if ($id AND !$ini) {
	$array[5] = "<a href='#'>".i("mensaje",$ilink)."</a>";
	$num = 5;
}

// --------------------------------------------------

if ($_GET['idedit']) {
	wintot1("foroedit.php",$mensaje,"div_edit",i("editar1",$ilink),'',$ilink);
	unset($_POST);
	
}

// --------------------------------------------------

solapah($array,$num+1,"navhsimple");

// --------------------------------------------------

if ($_POST['comentario']) {
	//se a&ntilde;ade un comentario a un foro	
	$gracias = anadircoment($id,$tit1,$asigna1,$curso1,$grupo1,$ilink);	
}

if ($titasi == 1 OR $titasi == 2) {echo "<div class='center mediana'>".$xtitasi."</div>";}	

// --------------------------------------------------

if ($gracias) {
	echo "<div class='mediana center'>".$gracias."</div>";
	require_once APP_DIR . "/molde_bott.php";
	exit;
}

if ($_GET['borr']) {
	borrarforo($_GET['id'],$ilink);
	echo "<span class='rojo b center mediana'>Mensaje borrado.</span>";
	require_once APP_DIR . "/molde_bott.php";
	exit;
}

if ($_GET['cerr']) {
	hilocerrar($_GET['cerr'],$ilink);
}

if ($_GET['abrir']) {
	hiloabrir($_GET['abrir'],$ilink);
}

if ($_GET['visi']) {
	hilovisi($_GET['visi'],$ilink);
}

if ($_GET['invisi']) {
	hiloinvisi($_GET['invisi'],$ilink);
}

if ($_GET['mvisi']) {
	mensvisi($_GET['mvisi'],$ilink);
}

if ($_GET['minvisi']) {
	mensinvisi($_GET['minvisi'],$ilink);
}

if ($_GET['ini'] AND !$_POST['asunto']) {
	$formforonew = foronew($titasi,$ilink,$imgloader);
	require_once APP_DIR .  "/molde_bott.php";
	exit;
}

// Es listado de cabeceras
if (!$_GET['id']) {
	
	//echo "<br>";

	foroiniciar($titasi,$ilink);
	
	// Saber num mensajes totales (para paginar)
	// Saber el $sql
	$sql = traesqllista();
	//hay que recorrer todos los mensajes para saber cuantos son, depende de mis asignaturas
	$nummens = nummens($sql,$ilink);

	if (!$nummens) {
		
		nohaymens($ilink);
		
	} else {
	
		echo "<span class='noimprimir'>";
		$conta = $_GET['conta'];
		if (!$_GET['conta']) {$conta = 1;}
		if ($_SESSION['pda']) {$numpag = 5;} else {$numpag = 20;}
		if($_SESSION['auto'] > 4) {
			if($impr) {
				echo "[<a href='?impr='>PAGED</a>]<p></p>";
			} elseif($xtitasi) {
				echo "[<a href='?impr=1'>ALL</a>] &nbsp; ";
			}
		}
		echo "</span>";
		
		if($impr AND $_SESSION['auto'] > 4) {
			require_once APP_DIR . '/foros_impr.php';
		} else {
			pagina($nummens,$conta,$numpag,i("temas",$ilink),"",$ilink);
			echo "<p></p>";
			foro($sql." ORDER BY fechault DESC",$conta,$numpag,$ilink);
			echo "<p></p>";
			pagina($nummens,$conta,$numpag,i("temas",$ilink),"",$ilink);
		}
	}
	
} else {

	$sql = "SELECT * FROM foro WHERE id = '".$_GET['id']."' LIMIT 1";
	$result = $ilink->query($sql);
	$fila = $result->fetch_array(MYSQLI_BOTH);
	
	if (lopuedover($fila,$ilink)) {

		ponerunhilo($_GET['id'],$ilink,$conta,$imgloader);
		
	}
	
}

require_once APP_DIR .  "/molde_bott.php";

// --------------------------------------------------

function quitabarra($x) {return stripslashes($x);}

// --------------------------------------------------

?>