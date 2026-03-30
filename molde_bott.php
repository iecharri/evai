<?php
defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

//echo "</body></html>";

//return; exit;

?>

<p></p>

<p class='both'>&nbsp;</p>
	
<footer class='noimprimir'>

<a href='https://github.com/iecharri/evai' target='_blank'>EVAI en GitHub</a> 
	
	<?php 
// --------------------------------------------------
if($script == "login") {
?>
		
. <a href="http://www.evai.net" target="_blank">Evai</a> es Software Libre / Open Source y se distribuye bajo licencia MIT.<br>
Podr&aacute; encontrar m&aacute;s detalles sobre la licencia en [<a href="https://opensource.org/licenses/MIT" target="_blank">Link</a>] o en el fichero <a href='LICENSE.txt' target="_blank">LICENSE.txt</a> inclu&iacute;do en este software.<br>Copyright
&copy; 2000-<?php echo gmdate("Y"); ?> <a href="mailto:inma.echarri@gmail.com" target="_blank">Inmaculada Echarri San Adri&aacute;n</a>
&copy; 2000-<?php echo gmdate("Y"); ?> <a href="http://www.antoniograndio.com" target="_blank">Antonio Grand&iacute;o Botella</a> 
</div>

<?php
}
?>		

</footer>

</div> <!-- container -->

</body>
</html>

<?php
$ilink->close();
?>