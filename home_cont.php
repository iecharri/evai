<?php

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

?>

<div class="layout-3col">

	<div class="col-multi">

	<!---------------------------------------------------------------------------------------->
		<article class="caja" style='padding:10px'>

			<?php
		
			// --------------------------------------------------

			$ip = filter_var($_SERVER['REMOTE_ADDR'], FILTER_VALIDATE_IP) ?: '0.0.0.0';
			$iresult = $ilink->query("SELECT ip, autorizado, obs, nombre, saludo FROM maquinas WHERE ip = '$ip'");
			$ip1 = $iresult->fetch_array(MYSQLI_BOTH);
			if ($ip1[1] > 0) {
				$poner ="<p></p>".$ip1[2]."<br>";
			}
			if ($ip1[0]) {
				$poner = str_replace("<nombre>", $ip1[3], i("hola",$ilink))."<br>".$ip1[4]."<br>";
			} else {
				$poner = str_replace("<nombre>", minom(1,0,$ilink), i("hola",$ilink))."<br>";
			}
			$iresult = $ilink->query("SELECT texto FROM usuarios WHERE id = '".$_SESSION['usuid']."' LIMIT 1");
			$tex = $iresult->fetch_array(MYSQLI_BOTH);

			// --------------------------------------------------

			echo "<h3>".$poner.$tex[0]."</h3>";			

			// --------------------------------------------------

			if ($_SESSION['sinvalidar']) {
				// --------------------------------------------------
				echo "<h3><p class='rojo'> Alert!</p>";
				echo str_replace("<alumnon>", minom(1,0,$ilink), str_replace("<fecha>", $_SESSION['sinvalidar'], i("altanoaun",$ilink)));
				echo "</h3>";
				echo "<hr class='sty'>";
				// --------------------------------------------------
			}
		
			require_once APP_DIR . '/iconmailweb.php';
			
			require_once APP_DIR . '/home_vid.php';
			
			if($auto > 4) {echo "<br><a href='#' class='center' onclick=\"amplred('vidprof');amplred('film');\"><button id='film' class='icon-film grande'></button></a>";}  //verdecalific

			require_once APP_DIR . '/fichaactualiz.php';
	
			// --------------------------------------------------

			echo "<div class='both'>";
				require_once APP_DIR . '/listadasignat.php';
			echo "</div>";

			// --------------------------------------------------

			if ($_SESSION['gic'] OR $_SESSION['numvinc1']) {
				echo "<div class='both'><p></p>";

					echo "<hr class='sty'>";

					$actualiz = "<a href='".APP_URL."/home.php?actu=1&u=$usuid'>".i("profesor",$ilink).": ".i("actuestad",$ilink)."</a><p></p>";

					echo "<h3 class='center'>".i("aquideb",$ilink,$anch)."</h3>";

					$u = $_SESSION['usuid'];
					$a = $_SESSION['asigna'];
					if ($a) {
						require_once APP_DIR . '/estadis_alu.php';
					}

					$a = "";
	
					// --------------------------------------------------
					if (!demo_enabled()) {
						require_once APP_DIR . '/estadis_alu.php';
					}
					// --------------------------------------------------
					


					echo "<br>&nbsp;";
					
				echo "</div>";
	
			}

			?>

		</article>

	</div>

<!---------------------------------------------------------------------------------------->

	<div class="col-multi">
    
		<article class="caja"><?php require_once APP_DIR . '/ultitab.php';?></article> 

		<article class="caja"><?php require_once APP_DIR . '/ultiforo.php';?></article> 

	</div>

	<!---------------------------------------------------------------------------------------->
	
	<div class="col-multi">
	
	<?php
		
// -------------------------------------------------- AGENDA // --------------------------------------------------

// Parametría segura para conservar flags
$params = [];
if (!empty($_GET['asi']))   { $params['asi']   = 1; }
if (!empty($_GET['titul'])) { $params['titul'] = 1; }
$q = http_build_query($params);

// $calen[0] = mes anterior (YYYY-MM-01)
// $calen[1] = mes actual   (YYYY-MM-01)
// $calen[2] = mes siguiente(YYYY-MM-01)

/*if (!demo_enabled()) {
    // fijamos mayo 2021 para el demo
    $calen[0] = '2021-04-01';  
    $calen[1] = '2021-05-01';  
    $calen[2] = '2021-06-01';  
} else {
    // normal → mes actual y anterior/siguiente
    $hoy = date('Y-m-01');
    $calen[0] = date('Y-m-01', strtotime("$hoy -1 month"));
    $calen[1] = $hoy;
    $calen[2] = date('Y-m-01', strtotime("$hoy +1 month"));
}*/

calendariomini($calen,$q,$arraymes,$ilink);

// --------------------------------------------------		
		

		if($_SESSION['asigna']) {
			?><article class="caja"><?php require_once APP_DIR . '/home_guia0.php';?></article><?php
	
			?><article class="caja"><?php require_once APP_DIR . '/home_guia.php';?></article><?php
		}

		if($_SESSION['asigna']) {
			?><article class="caja"><?php require_once APP_DIR . '/home_recur.php';?></article><?php
		}

		if($_SESSION['asigna']) {
			?><article class="caja"><?php require_once APP_DIR . '/home_matdoc.php';?></article><?php
		}

		if($_SESSION['auto'] > 4) {
			?><article class="caja"><?php novedades("P",$ilink);?></article><?php
		}

		if($_SESSION['auto'] == 10) {
			?><article class="caja"><?php novedades("A",$ilink);?></article><?php
		}

		?>

	</div>
	
	<!---------------------------------------------------------------------------------------->
  
</div>

<?php

// --------------------------------------------------

function novedades($para, $ilink) {

	$texto = i("news".$para,$ilink);

	if(!$texto AND $_SESSION['auto'] < 10) {return;}

	if($para == "P" AND $_SESSION['auto'] == 10) {$editp = 1;}
	if($para == "A" AND $_SESSION['soy_superadmin']) {$edita = 1;}

	?><div class='box11 contiene'>

   	 <div class="caja__head"><h3 class="caja__title">
			<?php	
			echo i("evainews",$ilink)." - ";
	
			if($para == "P") {
				echo i("profesores",$ilink);
			} else {
				echo i("administradores",$ilink);
			}

			if(($para == "P" AND $editp) OR ($para == "A" AND $edita)){
				echo "<span id = 'key".$para."' class='icon-keyboard fr'></span>";
			}
	
			?>
	
			</h3>
		</div>
	
		<div class='ml5 mr5 caja__body'>

			<?php echo "<div id='new".$para."'>";

				$texto = str_replace("&nbsp;", " ", $texto);
				$texto = str_replace("<div></div>", "", $texto);	
				$texto = str_replace("</div>", " </div>", $texto);	
				echo conhiper($texto);
	
			echo "</div>";

		echo "</div>";
			
	echo "</div><br>";

}

?>

<!-- </div>  --> <!-- es el div de grid-cajas ???-->

<?php

// --------------------------------------------------

function esdelgru($grupo) {
	$result = $ilink->query("SELECT grupos.id FROM grupos LEFT JOIN gruposusu ON grupos.id = gruposusu.grupo_id WHERE grupos.grupo = '$grupo'");
	if ($result->num_rows OR $_SESSION['auto'] == 10) {return true;}
	return false;
}

// --------------------------------------------------

?>

<script language="JavaScript">

$(document).ready(function(){

	$('#keyP').click(function(){
        $.post("novedades.php", {para:"P", lee:1},
			 function(htmlexterno){
				$( "#newP").html(htmlexterno);
	     },
		  "html")
        $('#keyP').hide();
        document.getElementById('newP').contentEditable='true';
        document.getElementById('newP').className += ' rojo';
        $("#newP").focus();
	});

	$('#keyA').click(function(){
        $.post("novedades.php", {para:"A", lee:1},
			 function(htmlexterno){
				$( "#newA").html(htmlexterno);
	     },
		  "html")
        $('#keyA').hide();
        document.getElementById('newA').contentEditable='true';
        document.getElementById('newA').className += ' rojo';
        $("#newA").focus();
	});
			
	$('#newP').blur(function(){
        $('#keyP').show();
        document.getElementById('newP').contentEditable='false';
        document.getElementById('newP').className -= ' rojo';
        var field = $(this);
        var parent = field.attr('id');
        var texto = document.getElementById(parent).innerHTML; 
        $.post("novedades.php", {para:"P", texto:texto},
			 function(htmlexterno){
				$( "#newP").html(htmlexterno);
	     },
		  "html")
	});
	
	$('#newA').blur(function(){
        $('#keyA').show();
        document.getElementById('newA').contentEditable='false';
        document.getElementById('newA').className -= ' rojo';
        var field = $(this);
        var parent = field.attr('id');
        var texto = document.getElementById(parent).innerHTML; 
        $.post("novedades.php", {para:"A", texto:texto},
			 function(htmlexterno){
				$( "#newA").html(htmlexterno);
	     },
		  "html")
	});

})
	
</script>
