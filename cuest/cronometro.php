<?php

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

?>

<p></p> 

<?php	
	
	require_once APP_DIR . '/cuest/dms.php';
	echo "<span class='mediana b'>Tiempo: ".dms($mn*60)."</span> ";

?>

       
 <div class="cajabl rojo di colu0">
	<span id="hour">00</span> : <span id="minute">00</span> : <span id="second">00</span>                
</div>

<script language='JavaScript'>

    var tiempo = {
        hora: 0,
        minuto: 0,
        segundo: 0
    };

    var tiempo_corriendo = null; 

            tiempo_corriendo = setInterval(function(){
                // Segundos
                tiempo.segundo++;
                if(tiempo.segundo >= 60)
                {
                    tiempo.segundo = 0;
                    tiempo.minuto++;
                }      

                // Minutos
                if(tiempo.minuto >= 60)
                {
                    tiempo.minuto = 0;
                    tiempo.hora++;
                }

                $("#hour").text(tiempo.hora < 10 ? '0' + tiempo.hora : tiempo.hora);
                $("#minute").text(tiempo.minuto < 10 ? '0' + tiempo.minuto : tiempo.minuto);
                $("#second").text(tiempo.segundo < 10 ? '0' + tiempo.segundo : tiempo.segundo);
            }, 1000);


setTimeout('document.form1.submit()', 60*<?php echo $mn;?>*1000)

</script>




