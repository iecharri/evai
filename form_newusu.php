<?php 

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

 extract($_POST);

?>

	<div class="nodis">
   	<label></label>
   	<input type="text" id="nodis" name="nodis">
  		<label></label>
   	<input type="text" value="abcd" name="nodis1">
	</div>

<!-- USUARIO -->	
	<input type='text' title="<?php echo i("usuformat",$ilink);?>" maxlength='15' name='usuario' placeholder="<?php echo i("usuario",$ilink);?>" value="<?php echo $usuario;?>" autofocus="" 
	 pattern='[a-z0-9.-_]{4,15}' title='a-z 0-9 . - _    4->15' required>
	
	<?php
		if($mal[0] == 1) {echo "<p class=' rojo b peq'>$mal[1]</p>";} else {echo "<br>";}
	?>

<!-- PASSWORD -->		
	<input type='password' size='15' maxlength='15' name='password' placeholder="<?php echo i("clave",$ilink);?>" value="<?php echo $password;?>" 
	 required pattern='[A-Za-z0-9._-]{8,15}' title='A-Z a-z 0-9 . - _    8->15'>
	<?php
		if($mal[0] == 2) {echo "<p class=' rojo b peq'>$mal[1]</p>";} else {echo "<br>";}
	?>

<!-- PASSWORD -->			
	<input type='password' size='15' maxlength='15' name='password1' placeholder="<?php echo i("repc",$ilink);?>" value="<?php echo $password1;?>" 
	  required pattern='[A-Za-z0-9._-]{8,15}' title='A-Z a-z 0-9 . - _    8->15'>
	<?php
		if($mal[0] == 3) {echo "<p class=' rojo b peq'>$mal[1]</p>";}
	?>
	<?php
		if($mal[0] == 4) {echo "<p class=' rojo b peq'>$mal[1]</p>";} else {echo "<br>";}
	?>

<!-- ALUMNON -->		
	
	<input type='text' name='alumnon' maxlength='50' value="<?php echo $alumnon;?>"  placeholder="<?php echo i("nombre",$ilink);?>" 
	 required>
	<?php
		if($mal[0] == 5) {echo "<p class=' rojo b peq'>$mal[1]</p>";} else {echo "<br>";}
	?>
	
<!-- ALUMNOA -->		
	<input type='text' name='alumnoa' placeholder="<?php echo i("apellidos",$ilink);?>" maxlength='50' value="<?php echo $alumnoa;?>" 
	 required>
	<?php
		if($mal[0] == 6) {echo "<p class=' rojo b peq'>$mal[1]</p>";} else {echo "<br>";}
	?>

<!-- EMAIL -->			
	<input type='email' title="<?php echo i("mailacademico",$ilink);?>" name='mail' placeholder="<?php echo i("mail",$ilink);?>" maxlength='50' value="<?php echo $mail;?>" 
	 required>
	<?php
		if($mal[0] == 7) {echo "<p class=' rojo b peq'>$mal[1]</p>";} else {echo "<br>";}

// --------------------------------------------------
	
	//Si script POD return
	if($script == "pod") {return;}
		
// --------------------------------------------------
	
// ------------- DNI: requerido para nuevousu

	?>
	<input type='text' placeholder='DNI' name='dni' title="<?php echo i("dni",$ilink);?>" maxlength='50' value="<?php echo $dni;?>" required>
	<?php
	if($mal[0] == 8) {echo "<p class=' rojo b peq'>$mal[1]</p>";} else {echo "<br>";}
		
// ------------- TIPO
	if (stristr($mail, "alumail.uji.es")) {$tipo = "A";}
	?>
	<p class='peq'>
	 <input type="radio" name="tipo" value="A" <?php if ($tipo == "A") {echo "checked='checked'";}?> onclick="hide('ddiv2');show('ddiv1')" required> <?php echo i("alumno",$ilink);?> 
	 <input type="radio" name="tipo" value="P" <?php if ($tipo == "P") {echo "checked='checked'";}?> onclick="hide('ddiv1');show('ddiv2')" required> <?php echo i("profesor",$ilink);?> 
	 <input type="radio" name="tipo" value="E" <?php if ($tipo == "E") {echo "checked='checked'";}?> onclick="hide('ddiv1');hide('ddiv2')" required> <?php echo i("externo",$ilink);?>
	</p>

	<?php
	
	if($mal[0] AND $mal[0] < 10) {return;}
	
// --------------------------------------------------
	
	//Si script admin return
	if($script == "admin") {return;}
		
// --------------------------------------------------

	if ($tipo == "A") {$disp = "''";} else {$disp = "none";}?>
	<div id='ddiv1' style="display:<?php echo $disp;?>">
		<?php
		echo "<p class='peq justify'>".i("altahasele",$ilink)."</p>";
		if($mal[0] == 71 OR $mal[0] == 711) {echo "<p class=' rojo b peq'>$mal[1]</p>";} //else {echo "<br>";}
		$sql = "SELECT DISTINCT podasignaturas.asignatura, podasignaturas.cod,podtitulacion.titulacion,
		podcursoasignatit.curso, asignatprof.grupo FROM asignatprof
		LEFT JOIN podcursoasignatit ON asignatprof.curso = podcursoasignatit.curso AND
		asignatprof.asigna = podcursoasignatit.asigna
		LEFT JOIN cursasigru ON asignatprof.asigna = cursasigru.asigna AND
		asignatprof.curso = cursasigru.curso AND asignatprof.grupo = cursasigru.grupo
		LEFT JOIN podasignaturas ON asignatprof.asigna =  podasignaturas.cod
		LEFT JOIN podtitulacion ON podcursoasignatit.tit = podtitulacion.cod
		LEFT JOIN usuarios ON asignatprof.usuid = usuarios.id
		WHERE visibleporalumnos = 1 AND
		(podcursoasignatit.curso = '' OR podcursoasignatit.curso >= '".gmdate("Y")."')
		AND fechabaja = '0000-00-00 00:00:00'
		ORDER BY podcursoasignatit.curso,podcursoasignatit.asigna";
		$result = $ilink->query($sql);
		if(!$result->num_rows) {
			echo "En estos momentos no hay asignaturas disponibles.<p></p>";
		} else {
			echo "<select name='edcurasigru' class='peq col-10'>";
			$ed = explode("*",$_POST['edcurasigru']);
			while ($fila = $result->fetch_array(MYSQLI_BOTH)) {
				echo "<option value = '$fila[3]*$fila[1]*$fila[4]' ";
				if ($fila[3] == $ed[0] AND $fila[1] == $ed[1] AND $fila[4] == $ed[2]) {echo " selected = 'selected'";}
				$temp = $fila[3]; if (!$temp) {$temp = "Indef.";}
				if ($fila[4]) {$temp1 = " - Grupo $fila[4]";}
				echo ">".$temp.$temp1." - ".$fila[1]." ".$fila[0]." - ".$fila[2];
				echo "</option>\n";
			}
			echo "</select><p></p>";
		}
		?>
	</div>
	
	<?php
	
// --------------------------------------------------
	
	if ($tipo == "P") {$disp = "''";} else {$disp = "none";}?>
	<div id='ddiv2' style="display:<?php echo $disp;?>">
		<?php echo "<p class='peq'>".i("deseoclave",$ilink)."</p>";
		if($mal[0] == 72) {echo "<p class=' rojo b peq'>$mal[1]</p>";} //else {echo "<br>";}
		?>
		<textarea rows='10' cols='40' name='solicitar'><?php echo $solicitar;?></textarea>
		<?php if ($mensaje_p) {echo "<h4 class='rojo'>$mensaje_p</h4>\n";}?>
	</div>

