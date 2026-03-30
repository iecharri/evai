<?php

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

echo " &nbsp; <span class='mediana'> POD</span>";

if (!$pest) {$pest = 8;}
$sel = "selected='selected'";
$a = "sel".$pest;
$$a = $sel;

?>

<br> &nbsp; <form name='menupod' method='post' action='pod.php'>

<select name='pest' class='selectcss' onchange='javascript:this.form.submit()'>

<option value='1' <?php echo $sel1;?>>&Aacute;reas</option>
<option value='2' <?php echo $sel2;?>>Titulaciones</option>
<option value='3' <?php echo $sel3;?>>Grupos de Asignaturas</option>
<option value='4' <?php echo $sel4;?>>Figuras</option>
<option value='5' <?php echo $sel5;?>>Cargos</option>
<option value='6' <?php echo $sel6;?>>Profesores</option>
<option value='7' <?php echo $sel7;?>>Asignaturas</option>
<option value='8' <?php echo $sel8;?>>Asignaciones</option>
<option value='9' <?php echo $sel9;?>>Repositorio</option>
<option value='10' <?php echo $sel10;?>>Enviar mails</option>

<?php if ($_SESSION['auto'] == 10) {?>
	<option value='11' <?php echo $sel11;?>>Resumen Cr&eacute;ditos por asignar</option>
	<option value='12' <?php echo $sel12;?>>Enviar mails Admin.</option>
	<option value='13' <?php echo $sel13;?>>Mails recibidos</option>
	<option value='14' <?php echo $sel14;?>>Administradores POD</option>
<?php }?>

</select>

</form>

<?php
if ($_SESSION['menusimple'] == 'p') {echo "&nbsp; <a href='index.php'>desconectar</a>";}
?>