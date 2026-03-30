<?php

// Copyright (c) 2000-2026 Inmaculada Echarri San Adrián
// Copyright (c) 2000-2026 Antonio Grandío Botella
// This file is part of EVAI.
// Licensed under the MIT License.
// See LICENSE.txt for details.

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

?>

<form method='post' name='form1'>

<label>Pregunta Castellano</label><br><textarea name='faqpc' rows=5 cols=50></textarea>
<br>
<label>Respuesta Castellano</label><br><textarea name='faqrc' rows=5 cols=50></textarea>
<br>
<label>Pregunta Valenci&agrave;</label><br><textarea name='faqpv' rows=5 cols=50></textarea>
<br>
<label>Respuesta Valenci&agrave;</label><br><textarea name='faqrv' rows=5 cols=50></textarea>
<br>
<label>Pregunta Ingl&eacute;s</label><br><textarea name='faqpi' rows=5 cols=50></textarea>
<br>
<label>Respuesta Ingl&eacute;s</label><br><textarea name='faqri' rows=5 cols=50></textarea>
<br>
<label><?php echo i("activo",$ilink);?></label> <input type='checkbox' name='activo'>
<p></p>
<input type='submit' name='faqnew' value="<?php echo i("anadir1",$ilink);?>">

</form>
