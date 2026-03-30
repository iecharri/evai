<?php

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

//======================
//  Función banner (dejada como la tenía)
//======================
function banner($ilink) {

    if (demo_enabled()) {
		return '<span style="color:#b33; font-weight:600; white-space:nowrap">🔸 <b>DEMO</b> — Sin guardar cambios. Asignaturas, archivos, mensajes y chats están desactivados. Los usuarios en línea son simulados. / Sense guardar canvis. Assignatures, arxius, missatges i xats estan desactivats. Els usuaris en línia són simulats. / No changes are saved. Courses, files, messages and chats are disabled. Online users are simulated.</span>';
    }

    $result = $ilink->query("SELECT atencion FROM atencion");
    $fila   = $result->fetch_array(MYSQLI_BOTH);

    if (trim($fila[0])) {
        $ban = ' <span style="color:#b33; font-weight:600; white-space:nowrap"> 🔸 '.conhiper(consmy(trim($fila[0]))).'</span>';
    }

    if (!$_SESSION['asigna']) { return $ban;}

	$sql = "SELECT banner FROM cursasigru WHERE asigna = '".$_SESSION['asigna']."' AND curso = '".$_SESSION['curso']."' AND grupo = '".$_SESSION['grupo']."'";
	$result = $ilink->query($sql);
	$fila = $result->fetch_array(MYSQLI_BOTH);
	if (trim($fila[0])) {
		$ban .= ' <span style="color:#b33; font-weight:600; white-space:nowrap"> 🔸 '.$fila[0].'</span>';
	}

	return $ban;

}
?>