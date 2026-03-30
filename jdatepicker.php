<?php

require_once APP_DIR . "/siempre_base.php";

$temp = $_SESSION['dformat'];
$temp = str_replace('%m','mm',$temp);
$temp = str_replace('%d','dd',$temp);
$temp = str_replace('%Y','yy',$temp);

?>

<script>
$(function() {
$('.datepicker').datepicker({
		  showButtonPanel: true,
        dateFormat: "<?php echo $temp;?>",
        firstDay: 1,
        dayNamesMin: ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa"],
        dayNamesShort: ["Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab"],
        monthNames:
            ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio",
            "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
        monthNamesShort:
            ["Ene", "Feb", "Mar", "Abr", "May", "Jun",
            "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"]
});
});
</script>