<?php

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

function consmy($text) {

$site = MEDIA_URL;
$text = str_replace ("\n", "<br>", $text);
$text = str_replace ("\n\n", "<p></p>", $text);
$text = str_replace ("[b]", "<B>", $text);
$text = str_replace ("[B]", "<B>", $text);
$text = str_replace ("[/b]", "<\/B>", $text);
$text = str_replace ("[/B]", "<\/B>", $text);
$text = str_replace ("[/i]", "<\/i>", $text);
$text = str_replace ("[/I]", "<\/i>", $text);
$text = str_replace ("[i]", "<i>", $text);
$text = str_replace ("[I]", "<i>", $text);
$text = str_replace ("[tab]", "<blockquote>", $text);
$text = str_replace ("[TAB]", "<blockquote>", $text);
$text = str_replace ("[/tab]", "<\/blockquote>", $text);
$text = str_replace ("[/TAB]", "<\/blockquote>", $text);
$text = str_replace ("[citaat]", "<pre>", $text);
$text = str_replace ("[CITAAT]", "<pre>", $text);
$text = str_replace ("[/citaat]", "<\/pre>", $text);
$text = str_replace ("[/CITAAT]", "<\/pre>", $text);
$text = str_replace (":)", "<img src='$site/emo/1.gif'>", $text);
$text = str_replace (":-)", "<img src='$site/emo/1.gif'>", $text);
$text = str_replace (":(", "<img src='$site/emo/2.gif'>", $text);
$text = str_replace (":P", "<img src='$site/emo/3.gif'>", $text);
$text = str_replace (":p", "<img src='$site/emo/3.gif'>", $text);
$text = str_replace (":-P", "<img src='$site/emo/3.gif'>", $text);
$text = str_replace (":-p", "<img src='$site/emo/3.gif'>", $text);
$text = str_replace ("*D", "<img src='$site/emo/4.gif'>", $text);
$text = str_replace (";)", "<img src='$site/emo/5.gif'>", $text);
$text = str_replace (";-)", "<img src='$site/emo/5.gif'>", $text);
$text = str_replace (":D", "<img src='$site/emo/6.gif'>", $text);
$text = str_replace (":Z", "<img src='$site/emo/7.gif'>", $text);
$text = str_replace (":z", "<img src='$site/emo/8.gif'>", $text);
$text = str_replace (":+", "<img src='$site/emo/9.gif'>", $text);
$text = str_replace (":V", "<img src='$site/emo/10.gif'>", $text);
$text = str_replace ("B)", "<img src='$site/emo/11.gif'>", $text);
$text = str_replace (":-(", "<img src='$site/emo/12.gif'>", $text);
$text = str_replace ("}>", "<img src='$site/emo/13.gif'>", $text);
$text = str_replace ("|x(", "<img src='$site/emo/14.gif'>", $text);
$text = str_replace ("O+", "<img src='$site/emo/15.gif'>", $text);
$text = str_replace (":7", "<img src='$site/emo/16.gif'>", $text);
$text = str_replace (":*", "<img src='$site/emo/17.gif'>", $text);
$text = str_replace (":r", "<img src='$site/emo/18.gif'>", $text);
$text = str_replace (";(", "<img src='$site/emo/19.gif'>", $text);
$text = str_replace ("8)", "<img src='$site/emo/20.gif'>", $text);
$text = str_replace (":Y", "<img src='$site/emo/21.gif'>", $text);
$text = str_replace (":9", "<img src='$site/emo/22.gif'>", $text);
$text = str_replace (":&", "<img src='$site/emo/23.gif'>", $text);
$text = str_replace (".*.", "<img src='$site/emo/24.gif'>", $text);
$text = str_replace (".t.", "<img src='$site/emo/25.gif'>", $text);
$text = str_replace (".w.", "<img src='$site/emo/26.gif'>", $text);
$text = str_replace (".r.", "<img src='$site/emo/27.gif'>", $text);
$text = str_replace (".p.", "<img src='$site/emo/28.gif'>", $text);
$text = str_replace (".b.", "<img src='$site/emo/29.gif'>", $text);

return $text;

}

function conhiperxxx($text) {

if (stristr($text,"<a ")) {return $text;}
$text = preg_replace("/(http|ftp|https)(:\/\/[%?=0-9a-zA-Z~$\-\._()&aacute;&eacute;&iacute;&oacute;&uacute;\/&#]+)/", "<a href='\\0' target='_blank'>[\\1...]</a>", $text);
$text = preg_replace("/([0-9a-zA-Z\-\._]+)(@)([0-9a-zA-Z\-\._\/]+)(\.)([0-9a-zA-Z\-\._\/]+)/", "<a href=mailto:\\0>\\0</a>", $text);
return $text;

}

function conhiper($cadena_origen) {
//filtro los enlaces normales
$cadena_resultante= preg_replace("/((http|https|www)[^\s]+)/", '<a href="$1" target="_blank"><span class="icon-link b mediana rojo"></span></a>', $cadena_origen);
//miro si hay enlaces con solamente www, si es así le añado el http://
$cadena_resultante= preg_replace("/href=\"www/", 'href="http://www', $cadena_resultante);
$cadena_resultante = preg_replace("/([0-9a-zA-Z\-\._]+)(@)([0-9a-zA-Z\-\._\/]+)(\.)([0-9a-zA-Z\-\._\/]+)/", "<a href=mailto:\\0>\\0</a>", $cadena_resultante);
return $cadena_resultante;
}

function sinhiper1($archivo) {
//$cadena_resultante = preg_replace('/b(https?|ftp|file)://[-A-Z0-9+&amp;@#/%?=~_|$!:,.;]*[A-Z0-9+&amp;@#/%=~_|$]/i', '', $cadena_origen);
$archivo = preg_replace('/<a href=\"(.*?)\">(.*?)<\/a>/', "\\2 ", $archivo);

return $archivo;
}

function make_clickable($text)
{
    $ret = ' ' . $text;
    $ret = preg_replace("#([\t\r\n ])([a-z0-9]+?){1}://([\w\-]+\.([\w\-]+\.)*[\w]+(:[0-9]+)?(/[^ \"\n\r\t<]*)?)#i", '\1<a class="b" href="\2://\3" target="_blank">\2://\3</a>', $ret);
    $ret = preg_replace("#([\t\r\n ])(www|ftp)\.(([\w\-]+\.)*[\w]+(:[0-9]+)?(/[^ \"\n\r\t<]*)?)#i", '\1<a class="b" href="http://\2.\3" target="_blank">\2.\3</a>', $ret);
    $ret = preg_replace("#([\n ])([a-z0-9\-_.]+?)@([\w\-]+\.([\w\-\.]+\.)*[\w]+)#i", "\\1<a class=\"b\" href=\"mailto:\\2@\\3\">\\2@\\3</a>", $ret);
    $ret = substr($ret, 1);
    return $ret;
}
 
function ponericon() {

$site = MEDIA_URL;
echo "
<a onclick=\"javascript:r('form1',':)');return true\"><img src=\"$site/emo/1.gif\"title=\":)\"></a>
<a onclick=\"javascript:r('form1',':(');return true\"><img src=\"$site/emo/2.gif\"title=\":(\"></a>
<a onclick=\"javascript:r('form1',':p');return true\"><img src=\"$site/emo/3.gif\"title=\":p\"></a>
<a onclick=\"javascript:r('form1','*D');return true\"><img src=\"$site/emo/4.gif\"title=\"*D\"></a>
<a onclick=\"javascript:r('form1',';)');return true\"><img src=\"$site/emo/5.gif\"title=\";)\"></a>
<a onclick=\"javascript:r('form1',':D');return true\"><img src=\"$site/emo/6.gif\"title=\":D\"></a>
<a onclick=\"javascript:r('form1',':Z');return true\"><img src=\"$site/emo/7.gif\" title=\":Z\"></a>
<a onclick=\"javascript:r('form1',':z');return true\"><img src=\"$site/emo/8.gif\" title=\":z\"></a>
<a onclick=\"javascript:r('form1',':+');return true\"><img src=\"$site/emo/9.gif\"title=\":+\"></a>
<a onclick=\"javascript:r('form1',':V');return true\"><img src=\"$site/emo/10.gif\" title=\":V\"></a>
<a onclick=\"javascript:r('form1','B)');return true\"><img src=\"$site/emo/11.gif\"title=\"B)\"></a>
<a onclick=\"javascript:r('form1',':-(');return true\"><img src=\"$site/emo/12.gif\"title=\":-(\"></a>
<a onclick=\"javascript:r('form1','}>');return true\"><img src=\"$site/emo/13.gif\"title=\"}>\"></a>
<a onclick=\"javascript:r('form1','|x(');return true\"><img src=\"$site/emo/14.gif\" title=\"|x(\"></a>
<a onclick=\"javascript:r('form1','O+');return true\"><img src=\"$site/emo/15.gif\"title=\"O+\"></a>
<a onclick=\"javascript:r('form1',':7');return true\"><img src=\"$site/emo/16.gif\"title=\":7\"></a>
<a onclick=\"javascript:r('form1',':*');return true\"><img src=\"$site/emo/17.gif\"title=\":*\"></a>
<a onclick=\"javascript:r('form1',':r');return true\"><img src=\"$site/emo/18.gif\"title=\":r\"></a>
<a onclick=\"javascript:r('form1',';(');return true\"><img src=\"$site/emo/19.gif\"title=\";(\"></a>
<a onclick=\"javascript:r('form1','8)');return true\"><img src=\"$site/emo/20.gif\"title=\"8)\"></a>
<a onclick=\"javascript:r('form1',':Y');return true\"><img src=\"$site/emo/21.gif\" title=\":Y\"></a>
<a onclick=\"javascript:r('form1',':9');return true\"><img src=\"$site/emo/22.gif\"title=\":9\"></a>
<a onclick=\"javascript:r('form1',':&amp;');return true\"><img src=\"$site/emo/23.gif\" title=\":&amp;\"></a>
<a onclick=\"javascript:r('form1','.*.');return true\"><img src=\"$site/emo/24.gif\" title=\".*.\"></a>
<a onclick=\"javascript:r('form1','.t.');return true\"><img src=\"$site/emo/25.gif\" title=\".t.\"></a>
<a onclick=\"javascript:r('form1','.r.');return true\"><img src=\"$site/emo/27.gif\" title=\".r.\"></a>
<a onclick=\"javascript:r('form1','.w.');return true\"><img src=\"$site/emo/26.gif\" title=\".w.\"></a>
<a onclick=\"javascript:r('form1','.p.');return true\"><img src=\"$site/emo/28.gif\" title=\".p.\"></a>
<a onclick=\"javascript:r('form1','.b.');return true\"><img src=\"$site/emo/29.gif\" title=\".p.\"></a>
";

}

?>
