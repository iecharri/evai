<?php

require_once __DIR__ . '/siempre.php';
require_once APP_DIR . '/jsspeech.js';

if ($_SESSION['auto'] < 5) {exit;}

$_SESSION['leer'] = 0;
$_SESSION['listar'] = 0;

$_SESSION['asignas'] = "1=1";
$_SESSION['sg'] = $_POST['sg'];
if ($_POST['rec5mn']) {$_SESSION['rec5mn'] = "";} else {$_SESSION['rec5mn'] = "*";}

// --------------------------------------------------

if ($_POST['demo']) {
	$iresult = $ilink->query("SELECT id FROM vinculos WHERE area != 'GEN' AND usu_id > 0");
	$_SESSION['numvinc'] = $iresult->num_rows;
	$_SESSION['demo'] = $_SESSION['numvinc']; //3000;
	if (!$_SESSION['demo']) {
		$titulo = "<p></p><div class='center mediana'>Lo sentimos. No hay v&iacute;nculos para hacer una demo.</div>";
		$return = 1;
	}
	$_SESSION['listar'] = 0;
	$titulo = "<span class='b'>DEMO</span>";
	$_SESSION['sg'] = 16;
	$_SESSION['rec5mn'] = "";
} else {
	$_SESSION['demo'] = '';
	$_SESSION['asignas'] = "";
	if ($_POST['asignastempo']) {
		foreach ($_POST['asignastempo'] as $asigna) {
			$_SESSION['asignas'] .= "area = '$asigna' OR ";
			if (strlen($titulo) < 20) {
				$titulo .= $asigna." ";
			} else {
				if (!$largo) {$titulo .= ".."; $largo = 1;}
			} 
		}
		$_SESSION['asignas'] = substr($_SESSION['asignas'], 0, strlen($_SESSION['asignas']) -4);
		$_SESSION['desde'] = gmdate("Y-m-d H:i:s");
	}
}

// --------------------------------------------------

$titpag = $titulo;
$a_notas = " class = 'active'";
require_once APP_DIR . '/molde_top.php';

// --------------------------------------------------

$sg = $_SESSION['sg'];

if($return) {
	require_once APP_DIR . "/molde_bott.php";
	return;
}

if (!($_POST['sg'] AND $_POST['asignastempo']) AND !$_POST['demo']) {
	$mensaje .= "<p></p>".i("selecasitiempo",$ilink);
	$titulo = "";
} 

?>

<script language="javascript">
function gictemposg(){	
	$.post("<?php echo APP_URL;?>/gictemposg.php", function(data){$("#gictemposg").html(data);});			
}
timer1 = setInterval("gictemposg()", 300000); //300000

function gictempocontrol(){	
	$.post("<?php echo APP_URL;?>/gictempocontrol.php", function(data){$("#gictempocontrol").html(data);});			
}
timer2 = setInterval("gictempocontrol()", <?php echo ($sg*1000);?>);

function gictempovinc(){	
	$.post("<?php echo APP_URL;?>/gictempovinc.php", function(data){$("#gictempovinc").html(data);});			
}
</script>

<?php

if ($sg) {$titulo .= ". &Uacute;ltimos v&iacute;nculos insertados. Refresco cada $sg segundos.";}

?>


<form name="crono" class='center nowrap'>
<?php
if (!$_SESSION['rec5mn']) {
	echo "<span class='mediana'>Recuento parcial cada 5 minutos&nbsp;</span>";
}
?>
<input class='col-1' type="text" size="7" name="face" title="Cron&oacute;metro">
<script language="JavaScript">
<!-- 
var timeCrono; 
var hor = 0;
var min = 0;
var seg = 0;
var startTime = new Date(); 
var start = startTime.getSeconds();
StartCrono();
function StartCrono() {
if (seg + 1 > 59) { 
min+= 1 ;
}
if (min > 59) {
min = 0;
hor+= 1;
}
var time = new Date(); 
if (time.getSeconds() >= start) {
seg = time.getSeconds() - start;
} 
else {
seg = 60 + (time.getSeconds() - start);
}
timeCrono= (hor < 10) ? "0" + hor : hor;
timeCrono+= ((min < 10) ? ":0" : ":") + min;
timeCrono+= ((seg < 10) ? ":0" : ":") + seg;
document.crono.face.value = timeCrono;
setTimeout("StartCrono()",1000);
} //--> 
</script>
</form>


<div id="gictemposg">
<script language="javascript">gictemposg();</script>
</div>

<div id="gictempocontrol" style='overflow:auto'>
<script language="javascript">gictempocontrol();</script>
</div>

<div class='colu col-10' style='height:600px;overflow:auto'>
<div id="gictempovinc"></div>
</div>

<script>

function vozlink(texto, idioma) {
    var utterance = new SpeechSynthesisUtterance(texto);
    utterance.lang = idioma;
    speechUtteranceChunker(utterance, {
        chunkLength: 120,
        langu: idioma
    }, function () {
        // Acción al terminar, si la necesitas
    });
}

</script>

<?php

require_once APP_DIR .  "/molde_bott.php";

?>