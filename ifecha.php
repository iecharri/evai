<?php

defined('EVA_BOOTSTRAP') or exit('Acceso directo no permitido');

function zone($fecha) {
    // Usa la zona del usuario almacenada en la sesión
    $zona = isset($_SESSION['zone']) ? $_SESSION['zone'] : 'UTC';
    try {
        $dt = new DateTime($fecha, new DateTimeZone('UTC'));
        $dt->setTimezone(new DateTimeZone($zona));
        return [$dt->format('Y-m-d H:i:s')]; // Simula array como fetch_array()
    } catch (Exception $e) {
        return [""]; // Si hay error (zona inválida), devuelve vacío
    }
}

// --------------------------------------------------

function fecha_actual_usuario_his(): string {
    $fmt = $_SESSION['dformat'] ?? '%d/%m/%Y';
    $z   = $_SESSION['zone'] ?? 'UTC';

    try { $tz = new DateTimeZone($z); }
    catch (Exception $e) { $tz = new DateTimeZone('UTC'); }

    $dt = new DateTime('now', $tz);

    // Sustituye fecha (numérica) según tu dformat
    $out = str_replace(
        ['%d','%m','%Y','%H','%i','%s'],
        [$dt->format('d'), $dt->format('m'), $dt->format('Y'),
         $dt->format('H'), $dt->format('i'), $dt->format('s')],
        $fmt
    );

    // Si el dformat no trae hora, añádela al final
    if (strpos($fmt, '%H') === false && strpos($fmt, '%i') === false && strpos($fmt, '%s') === false) {
        $out .= ' ' . $dt->format('H:i:s');
    }

	 //$out = str_replace('/', '-', $out);
    return $out;
}

// --------------------------------------------------

function formatof($fecha,$mes) {
	$fecha = explode(" ",$fecha);
	$dia = explode("-",$fecha[0]);
	if ($mes) {$dia[1] = $mes;}
	$ppp[0] = str_replace("--","-",str_replace("%d", $dia[2], str_replace("%m", $dia[1], str_replace("%Y", $dia[0], $_SESSION['dformat']))));
	$ppp[1] = $fecha[1];
	return $ppp;
}

// --------------------------------------------------

function fechaen($fecha, $ilink) {
	if (!$fecha) $fecha = gmdate('Y-m-d H:i:s');
	$utc = $fecha; // valor original sin convertir aún
	$fecha = zone($fecha);
	if ($fecha[0]) {
		$fecha = formatof($fecha[0], '');
	} else {
		$fecha[] = ""; $fecha[] = "";
	}
	$fechatxt = "$fecha[0] $fecha[1]";
	return "<span class='peq fechautc' data-utc='$utc'>$fechatxt</span>";
}

// --------------------------------------------------

function tiempo($his) {
	$temp = explode(":",$his);
	if ($temp[0] > 0) {$t = $temp[0]."h ";}
	if ($temp[1] > 0) {$t .= $temp[1]."m ";}
	//if ($temp[2] > 0) {$t .= $temp[2]."s ";}
	return $t;
}

// --------------------------------------------------

// UTC → Usuario (usa $_SESSION['dformat']; solo añade hora si venía en la entrada)
function utcausu1($fecha) {
    if (!$fecha || $fecha === '0000-00-00 00:00:00' || $fecha === '0000-00-00') return "";

    $zona   = $_SESSION['zone'] ?? 'UTC';
    $tzUser = new DateTimeZone($zona);

    // Formato base de usuario (solo fecha)
    $dformat = $_SESSION['dformat'] ?? '%d/%m/%Y';
    // Normalizamos separadores a "/"
    $dformat = str_replace(['-', '.', ' '], '/', $dformat);

    // ¿La cadena original incluye hora? (… HH:MM o HH:MM:SS)
    $inputTieneHora = (strlen($fecha) > 10) && preg_match('/\d{2}:\d{2}(:\d{2})?$/', $fecha);

    // ¿Solo año-mes? ¿Solo año?
    $soloAnioMes = (bool)preg_match('/^\d{4}-\d{2}$/', $fecha);
    $soloAnio    = (bool)preg_match('/^\d{4}$/', $fecha);

    // Mapeo strftime(%) → DateTime::format()
    $phpDate = strtr($dformat, [
        '%d' => 'd', '%e' => 'j',
        '%m' => 'm', '%Y' => 'Y', '%y' => 'y'
    ]);

    try {
        $dt = new DateTime(trim($fecha), new DateTimeZone('UTC'));
        $dt->setTimezone($tzUser);

        // Casos “solo año” o “año-mes”: no mostrar día ni hora
        if ($soloAnio) {
            return $dt->format('Y');
        }
        if ($soloAnioMes) {
            // mes en número → sustitúyelo por texto si quieres (como haces en ifecha31)
            // Aquí dejamos numérico por simplicidad:
            return $dt->format('m') . '/' . $dt->format('Y');
        }

        // Render base: solo fecha
        $out = str_replace('-', '/', $dt->format($phpDate));

        // Añadir hora SOLO si venía en el input y no es 00:00:00
        if ($inputTieneHora && $dt->format('H:i:s') !== '00:00:00') {
            $out .= ' ' . $dt->format('H:i'); // o ' H:i:s' si prefieres segundos
        }

        return $out;
    } catch (Exception $e) {
        return "";
    }
}

// --------------------------------------------------

function ifecha31($ag, $ilink) {  // más completa que ifecha3; respeta zona y formato usuario
    if (!$ag || $ag === "0000-00-00" || $ag === "0000-00-00 00:00:00") return "";

    $zona = $_SESSION['zone'] ?? 'UTC';

    // Detectar qué formato trae la cadena original
    $inputTieneHora = (strlen($ag) > 10) && preg_match('/\d{2}:\d{2}(:\d{2})?$/', $ag);
    $inputSoloAnioMes = (preg_match('/^\d{4}-\d{2}$/', $ag) === 1);

    try {
        // Interpretar como UTC
        $dt = new DateTime($ag, new DateTimeZone('UTC'));
        $dt->setTimezone(new DateTimeZone($zona));

        $ano    = $dt->format('Y');
        $mesNum = $dt->format('m');
        $mesTxt = i($mesNum, $ilink);  // "enero", "febrero"…

        // Si es solo año-mes, devolvemos "mes año"
        if ($inputSoloAnioMes) {
            return $mesTxt . ' ' . $ano;
        }

        // Formato de usuario normal
        $dia    = $dt->format('d');
        $dformat = $_SESSION['dformat'] ?? '%d/%m/%Y';
        $texto = strtr($dformat, [
            '%d' => $dia,
            '%m' => $mesTxt,
            '%Y' => $ano,
        ]);
        $texto = str_replace(['/', '-', '.'], ' ', $texto);

        // Añadir hora solo si viene en el input y no es 00:00:00
        if ($inputTieneHora && $dt->format('H:i:s') !== '00:00:00') {
            $texto .= ', ' . $dt->format('H:i');
        }

        return $texto;
    } catch (Throwable $e) {
        return "";
    }
}

// --------------------------------------------------

function ifecha1($ag) {  //es usada por usuautc
	$fecha = explode("/", $ag);
	$temp = str_replace("/", "", str_replace("%", "", $_SESSION['dformat']));
	$d = $fecha[strpos($temp, "d")];
	$m = $fecha[strpos($temp, "m")];
	$Y = $fecha[strpos($temp, "Y")];
	return "$Y-$m-$d";
}

// --------------------------------------------------

// Usuario → UTC (devuelve array [fecha, hora])
function usuautc($fechaInput, $hora) {
    if (!$fechaInput) return ["", ""];

    $zona = $_SESSION['zone'] ?? 'UTC';

    // Acepta guiones o barras como separadores
    $fechaInput = str_replace("-", "/", trim($fechaInput));

    // Convertir dd/mm/yyyy → yyyy-mm-dd
    $fecha = function_exists('ifecha1') ? ifecha1($fechaInput) : str_replace("/", "-", $fechaInput);

	 if (empty($hora)) {
        $hora = '12:00:00';
    }
    
    try {
        $dt = new DateTime($fecha . ' ' . $hora, new DateTimeZone($zona));
        $dt->setTimezone(new DateTimeZone('UTC'));
        return [$dt->format('Y-m-d'), $dt->format('H:i:s')];
    } catch (Exception $e) {
        return ["", ""];
    }
}

// --------------------------------------------------

function usuautc1($fechaInput, $hora) {
    if (!$fechaInput) return ["", ""];

    // Zona del usuario (fallback UTC)
    $zona = $_SESSION['zone'] ?? 'UTC';
    $tzUser = new DateTimeZone($zona);
    $tzUTC  = new DateTimeZone('UTC');

    // Formato del usuario (fallback dd/mm/YYYY)
    $dformat = $_SESSION['dformat'] ?? '%d/%m/%Y';

    // Normaliza separadores en la fecha de entrada
    $f = trim($fechaInput);
    $f = preg_replace('~[.\-\s]+~', '/', $f); // todo a "/"

    // --- Construir un regex según dformat ---
    // Soporta %d, %m, %Y y %y (2 dígitos)
    $fmt = $dformat;
    $fmt = preg_replace('~[.\-\s]+~', '/', $fmt); // normaliza como arriba

    // Escapa y convierte tokens a grupos con nombre
    $pat = preg_quote($fmt, '~');
    $pat = str_replace(['%d','%m','%Y','%y'], ['(?P<d>\d{1,2})','(?P<m>\d{1,2})','(?P<Y>\d{4})','(?P<y>\d{2})'], $pat);
    $pat = '~^' . $pat . '$~';

    if (!preg_match($pat, $f, $m)) {
        // Intento de último recurso para entradas tipo dd/mm/yyyy sin respetar el formato
        if (!preg_match('~^(?P<d>\d{1,2})/(?P<m>\d{1,2})/(?P<Y>\d{4})$~', $f, $m)) {
            return ["", ""];
        }
    }

    // Resolver año (Y o y)
    if (isset($m['Y']) && $m['Y']) {
        $Y = (int)$m['Y'];
    } elseif (isset($m['y']) && $m['y'] !== '') {
        $yy = (int)$m['y'];
        // Regla típica de pivot: 00-69 => 2000-2069, 70-99 => 1970-1999
        $Y = ($yy <= 69) ? (2000 + $yy) : (1900 + $yy);
    } else {
        return ["", ""];
    }

	 $Y = isset($m['Y']) ? (int)$m['Y'] : null;  
    $d = isset($m['d']) ? (int)$m['d'] : null;
    $M = isset($m['m']) ? (int)$m['m'] : null;

    if (!$d || !$M || !$Y || !checkdate($M, $d, $Y)) {
        return ["", ""];
    }

    // --- Normalizar hora ---
    $hora = trim((string)$hora);
    if ($hora === '') {
        $hora = '12:00:00'; // mediodía para evitar sesgos de DST
    } else {
        // Permite "H", "H:M" o "H:M:S"
        if (preg_match('~^\d{1,2}$~', $hora)) {
            $hora .= ':00:00';
        } elseif (preg_match('~^\d{1,2}:\d{2}$~', $hora)) {
            $hora .= ':00';
        } elseif (!preg_match('~^\d{1,2}:\d{2}:\d{2}$~', $hora)) {
            return ["", ""]; // formato de hora inválido
        }
    }

    try {
        $localStr = sprintf('%04d-%02d-%02d %s', $Y, $M, $d, $hora);
        $dt = new DateTime($localStr, $tzUser); // interpreta en zona del usuario
        $dt->setTimezone($tzUTC);               // convierte a UTC
        return [$dt->format('Y-m-d'), $dt->format('H:i:s')];
    } catch (Throwable $e) {
        return ["", ""];
    }
}

// --------------------------------------------------

function hoyUsu() {
    // Siempre trabajamos en UTC internamente
    $ahoraUTC = new DateTime("now", new DateTimeZone("UTC"));

    // Zona del usuario (fallback a UTC si no está)
    $zona = $_SESSION['zone'] ?? 'UTC';
    try {
        $ahoraUTC->setTimezone(new DateTimeZone($zona));
    } catch (Exception $e) {
        // Si la zona no es válida, se queda en UTC
    }

    // Formato del usuario (ej: %d/%m/%Y)
    $dformat = $_SESSION['dformat'] ?? '%d/%m/%Y';

    // Sustituimos % por nada porque PHP usa otra sintaxis
    $phpFormat = str_replace(
        ['%d','%m','%Y','%H','%i','%s'],
        ['d','m','Y','H','i','s'],
        $dformat
    );

    return $ahoraUTC->format($phpFormat);
}

// --------------------------------------------------// --------------------------------------------------//

?>
