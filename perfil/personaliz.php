<?php

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

$i = $_SESSION['i'];
$usuid = $_SESSION['usuid'];

?>

<article class='caja caja--estrecha center'>

<!--  -------------------------------------------------------------- -->
<!--  idiomas -->

<form method='post'><input type='hidden' name='accion' value="idioma">

<h2><?php echo i("idioma",$ilink);?></h2>

<input type='radio' name='idioma' value="c" <?php if ($i == 'c'){echo "checked='checked'";}?>> <span class='b'>Castellano</span> &nbsp; &nbsp; &nbsp; &nbsp; 
<input type='radio' name='idioma' value="v" <?php if ($i == 'v'){echo "checked='checked'";}?>> <span class='b'>Valencià</span> &nbsp; &nbsp; &nbsp; &nbsp; 
<input type='radio' name='idioma' value="i" <?php if ($i == 'i'){echo "checked='checked'";}?>> <span class='b'>English</span>

<p></p>

<h2><?php echo i("formatof",$ilink);?></h2>
<p></p>

<?php $sql = "SELECT dateformat FROM usuarios WHERE id = '".$_SESSION['usuid']."' LIMIT 1";
$iresult = $ilink->query($sql);
$dateformat = $iresult->fetch_array(MYSQLI_BOTH);
?>

<input type='radio' name='fecha' value="%d/%m/%Y" <?php if ($dateformat[0] == '%d/%m/%Y'){echo "checked='checked'";}?>> dd/mm/yyyy<p></p>
<input type='radio' name='fecha' value="%m/%d/%Y" <?php if ($dateformat[0] == '%m/%d/%Y'){echo "checked='checked'";}?>> mm/dd/yyyy<p></p>
<input type='radio' name='fecha' value="%Y/%m/%d" <?php if ($dateformat[0] == '%Y/%m/%d'){echo "checked='checked'";}?>> yyyy/mm/dd

<!-- -------------------------------------------------------------- -->
 <!-- paletas -->

<style>
.paletas { display:grid; grid-template-columns: repeat(auto-fit,minmax(180px,1fr)); gap:12px; }
.paleta { display:flex; align-items:center; gap:10px; padding:10px; border:1px solid #cbd5e1; border-radius:10px; background:#fff; }
.swatch { width:36px; height:24px; border-radius:6px; border:1px solid #cbd5e1; }
.sw-azul     { background: linear-gradient(135deg,#4facfe,#00f2fe); }
.sw-amarillo { background: linear-gradient(135deg,#facc15,#fde047); }
.sw-verde    { background: linear-gradient(135deg,#34d399,#10b981); }
.sw-marron   { background: linear-gradient(135deg,#8b5e3c,#b08968); }
.sw-lila 	 { background: linear-gradient(135deg,#7c3aed, #c084fc);}

.sw-rojo     { background: linear-gradient(135deg, #ff6b6b, #f06595); }
.sw-turquesa { background: linear-gradient(135deg, #0f766e, #2dd4bf); }
.sw-naranja  { background: linear-gradient(135deg, #f59e0b, #f97316); }
.sw-menta    { background: linear-gradient(135deg, #2dd4bf, #a7f3d0); }
.sw-rosa     { background: linear-gradient(135deg, #ec4899, #f472b6); }
.sw-grafito  { background: linear-gradient(135deg, #374151, #111827); } 

.msg { margin:10px 0; color:#065f46; }
</style>

<h2><?php echo i("paleta",$ilink);?></h2>

<?php
// Leer selección actual (BD)
$selActual = 'azul';
$selActual1 = 'c'; //cuadrada
$res = $ilink->query("SELECT colores, modofoto FROM usuarios WHERE id=".$usuid." LIMIT 1");
if ($res && $row = $res->fetch_row()) {
    $selActual = $row[0] ?: $selActual;
    $selActual1 = $row[1] ?: $selActual1;
   }
?>

<div class="paletas">
   <?php foreach (PALETAS as $p): ?>
     <label class="paleta">
     <input type="radio" name="paleta" value="<?= htmlspecialchars($p) ?>"<?= ($p === $selActual ? 'checked' : '') ?>>
     <span class="swatch sw-<?= htmlspecialchars($p) ?>"></span>
     <span><?= ucfirst($p) ?></span>
     </label>
   <?php endforeach; ?>
</div>

<!-- -------------------------------------------------------------- -->
 <!-- fotos -->
<h2>Mostrar fotos</h2>
<div class="formfotos">
   <?php foreach (FORMFOTO as $f): 
   	$f1 = strtolower($f[0]);?>
     <label class="formfoto">
     <input type="radio" name="modofoto" value="<?= htmlspecialchars($f1) ?>"<?= ($f1 === $selActual1 ? 'checked' : '') ?>>
     <span class="swatch sw-<?= htmlspecialchars($f) ?>"></span>
     <span><?= ucfirst($f) ?></span>
     </label>
   <?php endforeach; ?>
</div>



<p></p><input class='col-1' type='submit' value="<?php echo i("guardar",$ilink);?>">

</form>

<?php

require_once APP_DIR . '/perfil/mesiento.php';	

?>

</article>
