<?php

require_once __DIR__ . "/siempre_base.php";

extract($_GET);

require_once APP_DIR . "/head.php";

$sql = "SELECT * FROM podpaneles WHERE n='$n'";

$result = $ilink->query($sql);
$fila = $result->fetch_array(MYSQLI_BOTH);

if(!$fila[1] AND !$pver) {return;}

// --------------------------------------------------

//recarga cada 30sg

?>

<body>

<!-- <meta http-equiv="refresh" content="30" /> -->

<script language="javascript">

function panel1(){	
	$.post("panel1.php?n=<?php echo $n;?>&curso=<?php echo $curso;?>", function(data){$("#container").html(data);});			
}
timer1 = setInterval("panel1()", 180000); //300000 cada 5mn, 5x60=300 msg

function increaseFontSize(objId) {
obj = document.getElementById(objId);
//get current font size of obj
currentSize = parseFloat(obj.style.fontSize); //parseFloat gives you just the numerical value, i.e. strips the 'em' bit away
obj.style.fontSize = (currentSize + .1) + "em";
}
function decreaseFontSize(objId) {
obj = document.getElementById(objId);
//get current font size of obj
currentSize = parseFloat(obj.style.fontSize); //parseFloat gives you just the numerical value, i.e. strips the 'em' bit away
obj.style.fontSize = (currentSize - .1) + "em";
}
</script>

<div id='toppanel' style='background:#b7b75E;color:white'>

<a class='fr grande' href="javascript:decreaseFontSize('container');">- &nbsp; </a>
<a class='fr grande' href="javascript:increaseFontSize('container');">+ &nbsp; </a>
<?php
echo "<div class='b center'>$fila[2]</div>";

?>

</div>


<div id='container' style='margin-top:2em;font-size:1em;float:left'>   <!-- ;margin-top:2em -->

	<script language="javascript">panel1();</script>

</div>

<?php if(!$_GET['m']) { ?>

<script type="text/javascript" >

$(document).ready(function () {
    var myInterval = false;
    myInterval = setInterval(function () {

            iScroll = $(document).height();
            $('html, body').animate({
                scrollTop: iScroll
            }, 70000);
   	
 				iScroll = 0;
            $('html, body').animate({
                scrollTop: iScroll
            }, 70000);

    }, 10000);
});


</script>

<?php } ?>

</body>

</html>

