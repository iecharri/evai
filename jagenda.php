<?php

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

?>

<script language="JavaScript">

    var a, mes, dia, anyo, febrero;

	function anyoBisiesto(anyo)
    {
        if (anyo < 100)
            var fin = anyo + 1900;
        else
            var fin = anyo ;
        if (fin % 4 != 0)
            return false;
        else
        {
            if (fin % 100 == 0)
            {
                if (fin % 400 == 0){return true; } else { return false; }
            }
            else
            {
                return true;
            }
        }
    }
    
    function validar(form1)
    {
		<?php $temp = str_replace("/", "", str_replace("%", "", $_SESSION['dformat']));?>
       a=form1.eddia.value;
       dia=a.split("/")[<?php echo strpos($temp, "d");?>];
       mes=a.split("/")[<?php echo strpos($temp, "m");?>];
       anyo=a.split("/")[<?php echo strpos($temp, "Y");?>];

	   if ((form1.eddia.value.indexOf('/',2) < 0 || form1.eddia.value.indexOf('/',5) < 0 ) && form1.eddia.value != "")
		{
		   alert("<?php echo i("fmalfecha",$ilink); ?>");
           form1.eddia.focus();
           form1.eddia.select();
           return false;
		}
	   if(anyoBisiesto(anyo))
           febrero=29;
       else
           febrero=28;
       if ((mes<1) || (mes>12))
       {
           alert("<?php echo i("fmalmes",$ilink); ?>");
           form1.eddia.focus();
           form1.eddia.select();
           return false;
       }
       if ((mes==2) && ((dia<1) || (dia>febrero)))
       {
           alert("<?php echo i("fmaldia",$ilink); ?>");
           form1.eddia.focus();
           form1.eddia.select();
           return false;
       }
       if (((mes==1) || (mes==3) || (mes==5) || (mes==7) || (mes==8) || (mes==10) || (mes==12)) && ((dia<1) || (dia>31)))
       {
           alert("<?php echo i("fmaldia",$ilink); ?>");
           form1.eddia.focus();
           form1.eddia.select();
           return false;
       }
       if (((mes==4) || (mes==6) || (mes==9) || (mes==11)) && ((dia<1) || (dia>30)))
       {
           alert("<?php echo i("fmaldia",$ilink); ?>");
           form1.eddia.focus();
           form1.eddia.select();
           return false;
       }
       if ((anyo<1900) || (anyo>2100))
       {
           alert("<?php echo i("fmalano",$ilink); ?>");
           form1.eddia.focus();
           form1.eddia.select();
           return false;
       } 

    }

</script>
