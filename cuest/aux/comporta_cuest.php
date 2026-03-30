<?php

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

function comporta($tabla1,$ilink) {

iconex(DB1,$ilink);
$stmt = $ilink->prepare("SELECT cuestionario FROM atencion");
$stmt->execute();
$resultado = $stmt->get_result();
$cuppal = $resultado->fetch_assoc();
iconex(DB2,$ilink);

echo "<div class='center b rojo'>$tabla1</div>";
$n = 0;
$stmt = $ilink->prepare("SELECT * FROM $tabla1 WHERE n = ?");
$stmt->bind_param("i", $n);
$stmt->execute();
$resultado = $stmt->get_result();
$datos = $resultado->fetch_assoc(); // ✅ correcto en MySQLi

?>	

<form action="" method="post" style="text-align: center" onsubmit="return validarSoloAno()">

<?php
$cuppal_valor = ($cuppal['cuestionario'] . '1' == $tabla1) ? '1' : '0';
?>

	<div style="display: flex; justify-content: center; align-items: center; margin-bottom: 5px;">
 	 <label for="cuppal" style="margin-right: 10px; min-width: 300px; text-align: right;">
 	   ¿Es el Cuestionario de la página de inicio?
 	 </label>
 	 <select id="cuppal" name="cuppal" style="width: 3em;">
    	<option value="1" <?= $cuppal_valor == '1' ? 'selected' : '' ?>>Sí</option>
  	  <option value="0" <?= $cuppal_valor == '0' ? 'selected' : '' ?>>No</option>
 	 </select>
	</div>

  <div style="display: flex; justify-content: center; align-items: center; margin-bottom: 5px;">
    <label for="ordenadas" style="margin-right: 10px; min-width: 300px; text-align: right;">Likert alineados:</label>
    <select id="ordenadas" name="ordenadas" style="width: 3em;">
      <option value="1" <?= ($datos['ordenadas'] ?? '') == '1' ? 'selected' : '' ?>>Sí</option>
      <option value="0" <?= ($datos['ordenadas'] ?? '') == '0' ? 'selected' : '' ?>>No</option>
    </select>
  </div>

  <div style="display: flex; justify-content: center; align-items: center; margin-bottom: 5px;">
    <label for="alfabet" style="margin-right: 10px; min-width: 300px; text-align: right;">Likert A, B, etc:</label>
    <select id="alfabet" name="alfabet" style="width: 3em;">
      <option value="1" <?= ($datos['alfabet'] ?? '') == '1' ? 'selected' : '' ?>>Sí</option>
      <option value="0" <?= ($datos['alfabet'] ?? '') == '0' ? 'selected' : '' ?>>No</option>
    </select>
  </div>

  <div style="display: flex; justify-content: center; align-items: center; margin-bottom: 5px;">
    <label for="sinnum" style="margin-right: 10px; min-width: 300px; text-align: right;">Numerar:</label>
    <select id="sinnum" name="sinnum" style="width: 3em;">
      <option value="0" <?= ($datos['sinnum'] ?? '') == '0' ? 'selected' : '' ?>>Sí</option>
      <option value="1" <?= ($datos['sinnum'] ?? '') == '1' ? 'selected' : '' ?>>No</option>
    </select>
  </div>

  <div style="display: flex; justify-content: center; align-items: center; margin-bottom: 5px;">
    <label for="visible" style="margin-right: 10px; min-width: 300px; text-align: right;">Activo:</label>
    <select id="visible" name="visible" style="width: 3em;">
      <option value="1" <?= ($datos['visible'] ?? '') == '1' ? 'selected' : '' ?>>Sí</option>
      <option value="0" <?= ($datos['visible'] ?? '') == '0' ? 'selected' : '' ?>>No</option>
    </select>
  </div>

<?php

if($cuppal_valor == '1') {
	
	?>

  	<div style="margin-top: 20px;">
   	 <button type="submit">Guardar</button>
  	</div>
  
  	<input type='hidden' name='comporta1' value=1>
  
	</form>	
	
	<?php
	
	return;
	
}

?>

<div style="display: flex; justify-content: center; align-items: center; margin-bottom: 5px;">
  <label for="soloano" style="margin-right: 10px; min-width: 300px; text-align: right;">Solo curso:</label>
  <input type="text" id="soloano" name="soloano" maxlength="4" pattern="20[1-9][0-9]|2[1-9][0-9]{2}" style="width: 6ch;"
    value="<?= ($datos['soloano'] ?? '') == '0' ? '' : htmlspecialchars($datos['soloano'], ENT_QUOTES) ?>"
    title="Debe ser un año mayor que 2000">
</div>


<div style="display: flex; justify-content: center; align-items: center; margin-bottom: 5px;">
  <label for="esindep" style="margin-right: 10px; min-width: 300px; text-align: right;">Independiente:</label>
  <select id="esindep" name="esindep" style="width: 3em;">
    <option value="2" <?= ($datos['guardar'] ?? '') == '2' ? 'selected' : '' ?>>Sí</option>
    <option value="0" <?= ($datos['guardar'] ?? '') != '2' ? 'selected' : '' ?>>No</option>
  </select>
</div>

  <div style="display: flex; justify-content: center; align-items: center; margin-bottom: 5px;">
    <label for="formula" style="margin-right: 10px; min-width: 300px; text-align: right;">Fórmula evaluación:<br><span class='peq'>(A: número de Aciertos, E: número de Errores) por ejempo: A - (E / 2)</span></label>
    <input type="text" id="formula" name="formula" maxlength="30" style="width: 30ch;" value="<?= htmlspecialchars($datos['formula'] ?? '', ENT_QUOTES) ?>">
  </div>

<div style="display: flex; justify-content: center; align-items: center; margin-bottom: 5px;">
  <label for="guardar" style="margin-right: 10px; min-width: 300px; text-align: right;">Evaluar:<br><span class='peq'>(irrelevante si Independiente es Si)</span></label>
  <select id="guardar" name="guardar" style="width: 3em;">
    <option value="1" <?= ($datos['guardar'] ?? '') == '1' ? 'selected' : '' ?>>Sí</option>
    <option value="0" <?= ($datos['guardar'] ?? '') == '0' ? 'selected' : '' ?>>No</option>
  </select>
</div>

  <div style="display: flex; justify-content: center; align-items: center; margin-bottom: 5px;">
    <label for="visialuresp" style="margin-right: 10px; min-width: 300px; text-align: right;">Se muestran respuestas correctas:</label>
    <select id="visialuresp" name="visialuresp" style="width: 3em;">
      <option value="1" <?= ($datos['visialuresp'] ?? '') == '1' ? 'selected' : '' ?>>Sí</option>
      <option value="0" <?= ($datos['visialuresp'] ?? '') == '0' ? 'selected' : '' ?>>No</option>
    </select>
  </div>
  
  <div style="display: flex; justify-content: center; align-items: center; margin-bottom: 5px;">
    <label for="mn" style="margin-right: 10px; min-width: 300px; text-align: right;">Tiempo, minutos:</label>
	 <input type="text" id="mn" name="mn" maxlength="4" style="width: 6ch;" value="<?= ($datos['mn'] ?? '') == '0' ? '' : htmlspecialchars($datos['mn'], ENT_QUOTES) ?>">
  </div>

  <div style="margin-top: 20px;">
    <button type="submit">Guardar</button>
  </div>
  
  <input type='hidden' name='comporta1' value=1>
  
</form>

<script>
function validarSoloAno() {
  const valor = document.getElementById('soloano').value.trim();

  if (valor === '') return true; // ✅ permitir vacío

  const anio = parseInt(valor, 10);

  if (!/^\d{4}$/.test(valor) || isNaN(anio) || anio <= 2000) {
    alert("Introduce un año mayor que 2000 o deja el campo vacío.");
    document.getElementById('soloano').focus();
    return false;
  }

  return true;
}
</script>

<?php

}

// --------------------------------------------------

function comporta1($tabla1, $ilink) {
	
	 //Si cuppal es si, actualizar el valor de cuestionario en tabla atencion de evai
	
    // Campos reales a actualizar en la tabla
    $campos_validos = ['ordenadas', 'alfabet', 'sinnum', 'visible', 'soloano', 'formula', 'visialuresp', 'mn'];

    $valores = [];
    $tipos = '';
    $sets = [];

    // Lógica especial para poner y quitar cuestionario (ppal) en tabla atencion
	iconex(DB1,$ilink);
	$stmt = $ilink->prepare("SELECT cuestionario FROM atencion");
	$stmt->execute();
	$resultado = $stmt->get_result();
	$datos = $resultado->fetch_assoc();
	if (isset($_POST['cuppal'])) {
    	if ($_POST['cuppal'] == '0' && ($datos['cuestionario'] . '1') == $tabla1) {
        	// Si cuppal es 0 y coincide cuestionario1 == tabla1 → borrar
        	$stmt = $ilink->prepare("UPDATE atencion SET cuestionario = ''");
        	$stmt->execute();
        	$stmt->close();
    	} elseif ($_POST['cuppal'] == '1') {
       	 // Si cuppal es 1 → guardar nombre del cuestionario sin el 1 final
        	$cuestionario_base = rtrim($tabla1, '1');
      	$stmt = $ilink->prepare("UPDATE atencion SET cuestionario = ?");
       	$stmt->bind_param("s", $cuestionario_base);
       	$stmt->execute();
        	$stmt->close();
    	}
	}
	iconex(DB2,$ilink);


    // Lógica especial para 'guardar' y campos relacionados
    if (isset($_POST['esindep']) && $_POST['esindep'] == '2') {
        $guardar = '2';
        $_POST['visialuresp'] = '';
        $_POST['soloano'] = '';
        $_POST['mn'] = '';
    } else {
        $guardar = (isset($_POST['guardar']) && $_POST['guardar'] == '1') ? '1' : '0';
    }

    // Añadir campos válidos
    foreach ($campos_validos as $campo) {
        if (isset($_POST[$campo])) {
            $valores[] = $_POST[$campo];
            $tipos .= 's';
            $sets[] = "$campo = ?";
        }
    }

    // Añadir 'guardar'
    $valores[] = $guardar;
    $tipos .= 's';
    $sets[] = "guardar = ?";

    // WHERE n = 0
    $valores[] = 0;
    $tipos .= 'i';

    // Ejecutar
    $sql = "UPDATE $tabla1 SET " . implode(', ', $sets) . " WHERE n = ?";
    $stmt = $ilink->prepare($sql);
    $stmt->bind_param($tipos, ...$valores);
    $stmt->execute();

    if ($stmt->affected_rows >= 0) {
        echo "<div class='verde'>✔ Datos actualizados correctamente</div>";
    } else {
        echo "<div class='rojo'>❌ Error al actualizar</div>";
    }

    $stmt->close();
}


function comporta2($tabla1, $ilink) {
    // Lista de campos válidos a actualizar, guardar se repite, si esindep=2 -> guardar=2 si no, guardar=0 si evaluar=0 y guardar=1 si evaluar=1
    // Campos a guardar directamente
    $campos_validos = ['ordenadas', 'alfabet', 'sinnum', 'visible', 'soloano', 'formula', 'guardar', 'visialuresp', 'mn', 'esindep'];

    $valores = [];
    $tipos = '';
    $sets = [];

    foreach ($campos_validos as $campo) {
        if (isset($_POST[$campo])) {
            $valores[] = $_POST[$campo];
            $tipos .= 's';
            $sets[] = "$campo = ?";
        }
    }

    // Lógica especial para guardar
    if (isset($_POST['esindep']) && $_POST['esindep'] == '2') {
        $guardar = '2';
        $visialuresp = '0';
        $soloano = '0';
        $mn = '0';
    } else {
        $guardar = (isset($_POST['guardar']) && $_POST['guardar'] == '1') ? '1' : '0';
    }

    $valores[] = $guardar;
    $tipos .= 's';
    $sets[] = "guardar = ?";

    // WHERE n = 0
    $valores[] = 0;
    $tipos .= 'i';

    $sql = "UPDATE $tabla1 SET " . implode(', ', $sets) . " WHERE n = ?";
    $stmt = $ilink->prepare($sql);
    $stmt->bind_param($tipos, ...$valores);
    $stmt->execute();

    if ($stmt->affected_rows >= 0) {
        echo "<div class='verde'>✔ Datos actualizados correctamente</div>";
    } else {
        echo "<div class='rojo'>❌ Error al actualizar</div>";
    }

    $stmt->close();
}

// --------------------------------------------------
?>