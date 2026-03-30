<?php

// Copyright (c) 2000-2026 Inmaculada Echarri San Adrián
// Copyright (c) 2000-2026 Antonio Grandío Botella
// This file is part of EVAI.
// Licensed under the MIT License.
// See LICENSE.txt for details.

function encoded($ses) 
{ 
 $sesencoded = $ses;
 $num = mt_rand(3,9);
 for($i=1;$i<=$num;$i++) 
 {
    $sesencoded = 
    base64_encode($sesencoded);
 }
 $alpha_array = 
 array('M','J','R','B','Z',
 'L','V','X','K','S','O');
 $sesencoded = 
 $sesencoded."+".$alpha_array[$num];
 $sesencoded =
 base64_encode($sesencoded);
 return $sesencoded;
}

?>