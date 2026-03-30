<?php

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

?>

<form action="https://www.google.com/accounts/ServiceLoginAuth" method="post" target='_blank'>
<div style='width:80px'>
<table cellspacing="3" cellpadding="5" width="100%" border="0">
  <tr>
  <td valign="top" style="text-align:center" nowrap="nowrap"  bgcolor="#e8eefa">
  <input type="hidden" name="ltmpl" value="default">
  <input type="hidden" name="ltmplcache" value="2">
  <input type="hidden" id="pstMsg" name="pstMsg"  value="0">
  <input type="hidden" id="dnConn" name="dnConn"  value="">
  <div class="loginBox">

  <table align="center" border="0" cellpadding="1" cellspacing="0">
  <tr>
<td colspan="2" align="center">
  <font size="-1">
  Inicio de sesi&oacute;n
  </font>
  <table>
  <tr>
  <td valign="middle" style='text-align:right'>
  <font size="+0"><b>Cuenta de</b></font> &nbsp; 
  </td>
  <td valign="top">
  <img src="https://www.google.com/accounts/google_transparent.gif" alt="Google">
  </td>
  </tr>
</table>
</td>
</tr>
<tr>
  <td colspan="2" align="center">

  </td>
</tr>
<tr id="email-row">
  <td nowrap="nowrap">
  <div align="right">
  <span class="gaia le lbl">
  Nombre de usuario:
  </span>
  </div>
  </td>

  <td>
  <input type="hidden" name="continue" id="continue" value="https://mail.google.com/mail/?hl=es&amp;tab=wm&amp;ui=html&amp;zy=l">
  <input type="hidden" name="service" id="service" value="mail">
  <input type="hidden" name="rm" id="rm" value="false">
  <input type="hidden" name="dsh" id="dsh" value="-4352073829990393946">
  <input type="hidden" name="ltmpl" id="ltmpl" value="default">
  <input type="hidden" name="hl" id="hl" value="es">
  <input type="hidden" name="ltmpl" id="ltmpl" value="default">
  <input type="hidden" name="scc" id="scc" value="1">
  <input type="hidden" name="timeStmp" id="timeStmp" value=''>
  <input type="hidden" name="secTok" id="secTok" value=''>
  <input type="hidden" name="GALX" value="1Ns5TIKZIr0" >
  <input  type="text" name="Email" id="Email" size="18" value="">
  </td>
</tr>
<tr>
  <td></td>
  <td align="left">
  <div style="color: #666666; font-size: 75%;">p. ej.: pat@example.com</div>
  </td>
</tr>
<tr>
  <td align="right" nowrap="nowrap">
  <span class="gaia le lbl">Contrase&ntilde;a:</span>
  </td>
  <td>

  <input type="password" name="Passwd" id="Passwd" size="18">
  </td>
</tr>
<tr>
  <td> </td>
  <td align="left">
  </td>
</tr>
<!--   <tr id="rememberme-row" class="enabled">
  <td align="right" valign="top">

  <input  type="checkbox" name="PersistentCookie" id="PersistentCookie" value="yes">
  <input type="hidden" name='rmShown' value="1">
  </td>
  <td style='text-align:left'>
  <label for="PersistentCookie" id="PersistentCookieLabel">No cerrar sesi&oacute;n</label>
  </td>
</tr> -->
<tr>

  <td>
  </td>
  <td align="left">
  <input type="submit" name="signIn" id="signIn" value="Acceder">
  </td>
</tr>
<tr>
  <td colspan="2" height="33.0" align="center" valign="bottom">
  <a id="link-forgot-passwd" href="https://www.google.com/accounts/recovery?service=mail&amp;continue=https%3A%2F%2Fmail.google.com%2Fmail%2F%3Fhl%3Des%26tab%3Dwm%26ui%3Dhtml%26zy%3Dl"  target='_blank'>
  &iquest;No puedes acceder a tu cuenta?
  </a>

  </td>
</tr>
  </table>
  </div>
  </td>
  </tr>
</table>
</div>
<input type="hidden" name="asts" id="asts" value="">
</form>
