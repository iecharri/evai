<?php

// Copyright (c) 2000-2026 Inmaculada Echarri San Adrián
// Copyright (c) 2000-2026 Antonio Grandío Botella
// This file is part of EVAI.
// Licensed under the MIT License.
// See LICENSE.txt for details.

require_once __DIR__ . '/siempre_base.php';

if (!$_SESSION['usuid']){exit;}

if(!$_SESSION['porleer']) {$_SESSION['porleer'] = 0;}

echo "<a href='usuarios.php?us=m' class='porleer' title='unread' style='position:relative'>".$_SESSION['porleer']."</a>&nbsp;";

?>


