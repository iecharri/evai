-- phpMyAdmin SQL Dump
-- version 5.2.1deb3
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 16-07-2025 a las 11:51:22
-- Versión del servidor: 10.11.13-MariaDB-0ubuntu0.24.04.1
-- Versión de PHP: 8.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `evai`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alumasiano`
--

CREATE TABLE `alumasiano` (
  `id` int(10) NOT NULL DEFAULT 0,
  `asigna` varchar(15) NOT NULL DEFAULT '',
  `curso` varchar(4) NOT NULL,
  `grupo` varchar(4) NOT NULL,
  `auto` int(1) NOT NULL,
  `veforo` int(1) NOT NULL DEFAULT 0,
  `OF_nota1` decimal(3,2) NOT NULL DEFAULT 0.00,
  `OF_fecha_nota` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `OF_notprofp` decimal(4,2) NOT NULL DEFAULT 0.00,
  `OF_test` decimal(4,2) NOT NULL DEFAULT 0.00,
  `OF_preg` decimal(4,2) NOT NULL DEFAULT 0.00,
  `OF_prac` decimal(4,2) NOT NULL DEFAULT 0.00,
  `OF_eval` decimal(4,2) NOT NULL,
  `OF_total` decimal(4,2) NOT NULL DEFAULT 0.00,
  `OF_aprobado` char(1) NOT NULL DEFAULT '',
  `EJ_nota1` decimal(3,2) NOT NULL DEFAULT 0.00,
  `EJ_fecha_nota` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `EJ_notprofp` decimal(4,2) NOT NULL DEFAULT 0.00,
  `EJ_test` decimal(4,2) NOT NULL DEFAULT 0.00,
  `EJ_preg` decimal(4,2) NOT NULL DEFAULT 0.00,
  `EJ_prac` decimal(4,2) NOT NULL DEFAULT 0.00,
  `EJ_eval` decimal(4,2) NOT NULL,
  `EJ_total` decimal(4,2) NOT NULL DEFAULT 0.00,
  `EJ_aprobado` char(1) NOT NULL DEFAULT '',
  `ES_nota1` decimal(3,2) NOT NULL DEFAULT 0.00,
  `ES_fecha_nota` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `ES_notprofp` decimal(4,2) NOT NULL DEFAULT 0.00,
  `ES_test` decimal(4,2) NOT NULL DEFAULT 0.00,
  `ES_preg` decimal(4,2) NOT NULL DEFAULT 0.00,
  `ES_prac` decimal(4,2) NOT NULL DEFAULT 0.00,
  `ES_eval` decimal(4,2) NOT NULL,
  `ES_total` decimal(4,2) NOT NULL DEFAULT 0.00,
  `ES_aprobado` char(1) NOT NULL DEFAULT '',
  `OJ_nota1` decimal(3,2) NOT NULL DEFAULT 0.00,
  `OJ_fecha_nota` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `OJ_notprofp` decimal(4,2) NOT NULL DEFAULT 0.00,
  `OJ_test` decimal(4,2) NOT NULL DEFAULT 0.00,
  `OJ_preg` decimal(4,2) NOT NULL DEFAULT 0.00,
  `OJ_prac` decimal(4,2) NOT NULL DEFAULT 0.00,
  `OJ_eval` decimal(4,2) NOT NULL,
  `OJ_total` decimal(4,2) NOT NULL DEFAULT 0.00,
  `OJ_aprobado` char(1) NOT NULL DEFAULT '',
  `nota1` decimal(3,2) NOT NULL DEFAULT 0.00,
  `fecha_nota` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `notprofp` decimal(4,2) NOT NULL DEFAULT 0.00,
  `test` decimal(4,2) NOT NULL DEFAULT 0.00,
  `preg` decimal(4,2) NOT NULL DEFAULT 0.00,
  `prac` decimal(4,2) NOT NULL DEFAULT 0.00,
  `eval` decimal(4,2) NOT NULL,
  `total` decimal(4,2) NOT NULL DEFAULT 0.00,
  `aprobado` char(1) NOT NULL DEFAULT '',
  `disponible` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asignatprof`
--

CREATE TABLE `asignatprof` (
  `id` int(10) NOT NULL,
  `area` varchar(4) NOT NULL,
  `usuid` int(10) NOT NULL DEFAULT 0,
  `asigna` varchar(15) NOT NULL,
  `curso` varchar(4) NOT NULL DEFAULT '0',
  `grupo` varchar(4) NOT NULL,
  `semestre` int(1) NOT NULL,
  `ct` decimal(5,2) NOT NULL,
  `cp` decimal(5,2) NOT NULL,
  `cte` decimal(5,2) NOT NULL,
  `cpr` decimal(5,2) NOT NULL,
  `cl` decimal(5,2) NOT NULL,
  `cs` decimal(5,2) NOT NULL,
  `ctu` decimal(5,2) NOT NULL,
  `ce` decimal(5,2) NOT NULL,
  `disponible` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asistencia`
--

CREATE TABLE `asistencia` (
  `usuid` varchar(10) NOT NULL DEFAULT '',
  `asigna` varchar(15) NOT NULL DEFAULT '',
  `curso` varchar(4) NOT NULL DEFAULT '',
  `grupo` char(1) NOT NULL DEFAULT '',
  `asistencia` char(1) NOT NULL DEFAULT '',
  `fecha` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `atencion`
--

CREATE TABLE `atencion` (
  `atencion` char(255) NOT NULL DEFAULT '',
  `hablamerlin` char(255) NOT NULL DEFAULT '',
  `vernotas` int(1) NOT NULL DEFAULT 0,
  `numvinc` int(10) NOT NULL DEFAULT 0,
  `vincmail` date NOT NULL DEFAULT '2003-09-04',
  `path` char(255) NOT NULL DEFAULT '',
  `ftppath` varchar(255) NOT NULL,
  `adminid` int(10) NOT NULL DEFAULT 0,
  `fichasemana` int(10) NOT NULL DEFAULT 0,
  `fechafichasemana` date NOT NULL DEFAULT '0000-00-00',
  `altalibre` int(1) NOT NULL DEFAULT 0,
  `fechaforgen` date NOT NULL,
  `cuestionario` varchar(255) NOT NULL,
  `espeak` varchar(255) NOT NULL,
  `espeakdir` varchar(255) NOT NULL,
  `espeakdef` varchar(255) NOT NULL,
  `superadmins` varchar(255) NOT NULL,
  `ayuda1` varchar(255) NOT NULL,
  `ayuda2` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `atencion`
--

INSERT INTO `atencion` (`atencion`, `hablamerlin`, `vernotas`, `numvinc`, `vincmail`, `path`, `ftppath`, `adminid`, `fichasemana`, `fechafichasemana`, `altalibre`, `fechaforgen`, `cuestionario`, `espeak`, `espeakdir`, `espeakdef`, `superadmins`, `ayuda1`, `ayuda2`) VALUES
('', '', 0, 0, '0000-00-00', '', '', 1, 0, '2025-07-16', 1, '0000-00-00', 'cuestionario_ppal', 'c:\\espeak\\command_line\\espeak.exe', 'c:\\espeak\\command_line\\espeak.exe ', '-v mb-vz1 -s150 -p50', '*1*', '', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bancot1`
--

CREATE TABLE `bancot1` (
  `bancoid` int(10) NOT NULL,
  `usuid` int(10) NOT NULL,
  `activo` int(1) NOT NULL,
  `competencia` varchar(255) NOT NULL,
  `tiempo` time NOT NULL,
  `fecha` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bancot2`
--

CREATE TABLE `bancot2` (
  `bancoid` int(10) NOT NULL,
  `usurecibe` int(10) NOT NULL,
  `aceptado` date NOT NULL,
  `fecha` date NOT NULL,
  `tiempo` time NOT NULL,
  `satisfac` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `boletin`
--

CREATE TABLE `boletin` (
  `id` int(4) NOT NULL,
  `fecha` date NOT NULL DEFAULT '0000-00-00',
  `html` longtext NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `b_autores`
--

CREATE TABLE `b_autores` (
  `cod` int(10) NOT NULL,
  `autor` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `b_editoriales`
--

CREATE TABLE `b_editoriales` (
  `cod` int(10) NOT NULL,
  `editorial` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `b_material`
--

CREATE TABLE `b_material` (
  `cod` int(10) NOT NULL,
  `tipo` char(1) NOT NULL DEFAULT '',
  `CAS_` double DEFAULT NULL,
  `ano` int(4) DEFAULT NULL,
  `titulo` varchar(255) NOT NULL DEFAULT '',
  `editorial` varchar(255) DEFAULT NULL,
  `propietario` varchar(255) DEFAULT NULL,
  `clave` varchar(15) DEFAULT NULL,
  `tema1` varchar(254) DEFAULT NULL,
  `Señal` tinyint(1) DEFAULT NULL,
  `url` varchar(100) DEFAULT NULL,
  `Archivo` varchar(30) DEFAULT NULL,
  `autor` int(10) DEFAULT NULL,
  `tema2` longtext DEFAULT NULL,
  `pclave` varchar(255) DEFAULT NULL,
  `leidopor` varchar(255) NOT NULL DEFAULT '',
  `id` int(10) NOT NULL DEFAULT 0,
  `asigna` varchar(15) NOT NULL,
  `proyecto` varchar(255) NOT NULL DEFAULT '',
  `citasclave` varchar(255) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `b_submaterial`
--

CREATE TABLE `b_submaterial` (
  `cod` int(10) NOT NULL,
  `tipo` char(1) NOT NULL DEFAULT '',
  `codmaterial` int(10) NOT NULL DEFAULT 0,
  `CAS_` double DEFAULT NULL,
  `ano` int(4) DEFAULT NULL,
  `titulo` varchar(255) NOT NULL DEFAULT '',
  `editorial` varchar(255) DEFAULT NULL,
  `propietario` varchar(20) DEFAULT NULL,
  `clave` varchar(15) DEFAULT NULL,
  `tema1` varchar(254) DEFAULT NULL,
  `Señal` tinyint(1) DEFAULT NULL,
  `url` varchar(100) DEFAULT NULL,
  `Archivo` varchar(30) DEFAULT NULL,
  `autor` int(10) DEFAULT NULL,
  `tema2` longtext DEFAULT NULL,
  `pclave` varchar(255) DEFAULT NULL,
  `leidopor` varchar(255) NOT NULL DEFAULT '',
  `paginas` varchar(255) NOT NULL DEFAULT '',
  `objetivo` mediumtext NOT NULL,
  `muestra` mediumtext NOT NULL,
  `metodologia` mediumtext NOT NULL,
  `resultados` mediumtext NOT NULL,
  `limitaciones` mediumtext NOT NULL,
  `implicaciones` mediumtext NOT NULL,
  `queaporta` mediumtext NOT NULL,
  `proyecto` varchar(255) NOT NULL DEFAULT '',
  `citasclave` mediumtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carpprofcoment`
--

CREATE TABLE `carpprofcoment` (
  `id` int(10) NOT NULL,
  `fecha` datetime NOT NULL,
  `deid` int(10) NOT NULL,
  `paraid` int(10) NOT NULL,
  `carpeta` varchar(255) NOT NULL,
  `comentario` longtext NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carpprofregactivi`
--

CREATE TABLE `carpprofregactivi` (
  `id` int(10) NOT NULL,
  `usuid` int(10) NOT NULL,
  `accion` varchar(50) NOT NULL,
  `exito` tinyint(1) NOT NULL,
  `carpeta1` varchar(255) NOT NULL,
  `fichero1` varchar(255) NOT NULL,
  `carpeta2` varchar(255) NOT NULL,
  `fichero2` varchar(255) NOT NULL,
  `tipo` varchar(255) NOT NULL,
  `size` int(12) NOT NULL,
  `fecha` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `chat`
--

CREATE TABLE `chat` (
  `asigna` varchar(30) NOT NULL,
  `usuid` int(10) NOT NULL DEFAULT 0,
  `fecha` datetime DEFAULT NULL,
  `fechaentra` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `r_usu` int(1) NOT NULL DEFAULT 0,
  `r_txt` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `chatlista`
--

CREATE TABLE `chatlista` (
  `n` int(10) NOT NULL,
  `asigna` varchar(30) NOT NULL,
  `usuid` int(10) NOT NULL DEFAULT 0,
  `parausuid` int(10) NOT NULL DEFAULT 0,
  `fecha` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `texto` varchar(255) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clasesgrab`
--

CREATE TABLE `clasesgrab` (
  `id` int(10) NOT NULL,
  `codtit` varchar(5) NOT NULL DEFAULT '',
  `codasign` varchar(15) NOT NULL,
  `curso` varchar(4) NOT NULL DEFAULT '',
  `grupo` varchar(4) NOT NULL,
  `fecha` date NOT NULL DEFAULT '0000-00-00',
  `video` varchar(255) NOT NULL DEFAULT '',
  `comentario` varchar(255) NOT NULL DEFAULT '',
  `autor` int(10) NOT NULL DEFAULT 0,
  `link` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `dni` int(11) NOT NULL,
  `cliente` char(50) DEFAULT NULL,
  `domicilio` char(50) DEFAULT NULL,
  `ciudad` char(20) DEFAULT NULL,
  `codpost` int(11) DEFAULT NULL,
  `telefono` char(10) DEFAULT NULL,
  `letradni` char(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `control`
--

CREATE TABLE `control` (
  `id` int(20) NOT NULL,
  `datetime` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `usuid` int(10) NOT NULL,
  `php` varchar(50) NOT NULL,
  `get` varchar(255) NOT NULL,
  `post` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `convenios`
--

CREATE TABLE `convenios` (
  `n` int(10) NOT NULL,
  `visible` int(1) NOT NULL,
  `asigna` varchar(15) NOT NULL,
  `curso` varchar(4) NOT NULL,
  `grupo` varchar(4) NOT NULL,
  `entidad` int(10) NOT NULL,
  `responom` int(10) NOT NULL,
  `respocargo` varchar(100) NOT NULL,
  `respodep` varchar(100) NOT NULL,
  `supervinom` int(10) NOT NULL,
  `supervinomb` varchar(100) NOT NULL,
  `supervitel` varchar(20) NOT NULL,
  `superviema` varchar(100) NOT NULL,
  `supervicargo` varchar(100) NOT NULL,
  `supervidep` varchar(100) NOT NULL,
  `tutornom` int(10) NOT NULL,
  `tutorcargo` varchar(100) NOT NULL,
  `tutordep` varchar(100) NOT NULL,
  `plazadescrip` longtext NOT NULL,
  `plazatitreque` varchar(100) NOT NULL,
  `plazaidiomas` varchar(100) NOT NULL,
  `plazaotros` longtext NOT NULL,
  `localizplaza` varchar(100) NOT NULL,
  `numplazas` varchar(100) NOT NULL,
  `tipplaza` varchar(50) NOT NULL,
  `mesini` varchar(100) NOT NULL,
  `desarrpract` varchar(100) NOT NULL,
  `horario` varchar(100) NOT NULL,
  `ayudaec` varchar(100) NOT NULL,
  `ayudacanti` varchar(100) NOT NULL,
  `ayudatipo` varchar(100) NOT NULL,
  `alojamiento` varchar(100) NOT NULL,
  `recuestudiante` varchar(100) NOT NULL,
  `insercionpost` varchar(100) NOT NULL,
  `obs` longtext NOT NULL,
  `apuntados` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `conventid`
--

CREATE TABLE `conventid` (
  `n` int(10) NOT NULL,
  `pais` varchar(50) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `cif` varchar(255) NOT NULL,
  `persconta` varchar(100) NOT NULL,
  `descrienti` longtext NOT NULL,
  `ambgeo` varchar(100) NOT NULL,
  `sector` varchar(100) NOT NULL,
  `numemp` varchar(100) NOT NULL,
  `paisactu` varchar(100) NOT NULL,
  `calle` varchar(100) NOT NULL,
  `localidad` varchar(100) NOT NULL,
  `codpos` varchar(100) NOT NULL,
  `tf` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `web` varchar(100) NOT NULL,
  `responom1` int(10) NOT NULL,
  `respocargo1` varchar(100) NOT NULL,
  `respodep1` varchar(100) NOT NULL,
  `contrasena` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `convsolicitudes`
--

CREATE TABLE `convsolicitudes` (
  `convenio` int(10) NOT NULL,
  `alumno` int(10) NOT NULL,
  `preferencia` int(1) NOT NULL,
  `aceptada` int(1) NOT NULL,
  `tutorid` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `convtitul`
--

CREATE TABLE `convtitul` (
  `n` int(3) NOT NULL,
  `titulacion` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cuentas`
--

CREATE TABLE `cuentas` (
  `row_id` int(11) NOT NULL,
  `cuenta` int(11) NOT NULL,
  `descripcio` char(255) DEFAULT NULL,
  `subgrupo` int(11) DEFAULT NULL,
  `sdo3cd` double DEFAULT NULL,
  `sdo3ca` double DEFAULT NULL,
  `sdebe` double NOT NULL,
  `shaber` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cuentas4`
--

CREATE TABLE `cuentas4` (
  `row_id` int(11) NOT NULL,
  `cuenta` int(11) NOT NULL,
  `descripcio` char(255) DEFAULT NULL,
  `cuenta3` int(11) DEFAULT NULL,
  `sdo4d` double DEFAULT NULL,
  `sdo4h` double DEFAULT NULL,
  `sdebe` double NOT NULL,
  `shaber` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cuentas5`
--

CREATE TABLE `cuentas5` (
  `row_id` int(11) NOT NULL,
  `cuenta` int(11) NOT NULL,
  `descripcio` char(255) DEFAULT NULL,
  `cuenta4` int(11) DEFAULT NULL,
  `sdo5d` double DEFAULT NULL,
  `sdo5h` double DEFAULT NULL,
  `sdebe` double NOT NULL,
  `shaber` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cursasigru`
--

CREATE TABLE `cursasigru` (
  `asigna` varchar(15) NOT NULL,
  `curso` varchar(4) NOT NULL DEFAULT '0',
  `grupo` varchar(4) NOT NULL,
  `programa` varchar(100) NOT NULL DEFAULT '',
  `vernota` int(1) NOT NULL DEFAULT 0,
  `verlistanota` int(1) NOT NULL,
  `coefi` int(1) NOT NULL DEFAULT 0,
  `test` decimal(3,2) NOT NULL DEFAULT 0.00,
  `preg` decimal(3,2) NOT NULL DEFAULT 0.00,
  `prac` decimal(3,2) NOT NULL DEFAULT 0.00,
  `eval` decimal(3,2) NOT NULL,
  `votosalumnos` decimal(3,2) NOT NULL DEFAULT 0.00,
  `notaprofesor` decimal(3,2) NOT NULL DEFAULT 0.00,
  `divisor` int(1) NOT NULL,
  `mintest` decimal(3,2) NOT NULL DEFAULT 0.00,
  `minpreg` decimal(3,2) NOT NULL DEFAULT 0.00,
  `minprac` decimal(3,2) NOT NULL DEFAULT 0.00,
  `mineval` decimal(3,2) NOT NULL,
  `hablamerlin` varchar(255) NOT NULL DEFAULT '',
  `banner` varchar(255) NOT NULL DEFAULT '',
  `notasmail1` varchar(255) NOT NULL DEFAULT '',
  `notasmail2` mediumtext NOT NULL,
  `notashsm` mediumtext NOT NULL,
  `notassms` varchar(255) NOT NULL DEFAULT '',
  `texto` longtext NOT NULL,
  `visibleporalumnos` int(1) NOT NULL DEFAULT 0,
  `gic` int(1) NOT NULL DEFAULT 0,
  `altalibre` int(1) NOT NULL DEFAULT 0,
  `patronmail` varchar(20) NOT NULL DEFAULT '',
  `forospormail` int(1) NOT NULL DEFAULT 0,
  `notispormail` int(1) NOT NULL DEFAULT 0,
  `horario` varchar(255) NOT NULL,
  `nomprogfile` varchar(255) NOT NULL,
  `programafile` longblob NOT NULL,
  `textos` varchar(255) NOT NULL,
  `superprofes` longtext NOT NULL,
  `mandoadist` int(1) NOT NULL,
  `mandotw` int(1) NOT NULL,
  `menualumnos` int(1) NOT NULL,
  `clasedistancia` longtext NOT NULL,
  `apartirde` date NOT NULL,
  `estadisf1` date NOT NULL,
  `estadisf2` date NOT NULL,
  `video` longtext NOT NULL,
  `vidtxt` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cursoareagrupoa`
--

CREATE TABLE `cursoareagrupoa` (
  `grupoa` int(4) NOT NULL,
  `texto` varchar(50) NOT NULL,
  `respons` int(10) NOT NULL,
  `area` varchar(4) NOT NULL,
  `curso` varchar(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empresa`
--

CREATE TABLE `empresa` (
  `nombre` char(50) NOT NULL,
  `domicilio` char(30) NOT NULL,
  `localidad` char(20) NOT NULL,
  `cp` int(5) UNSIGNED NOT NULL DEFAULT 0,
  `campo1` tinyint(4) NOT NULL DEFAULT 0,
  `campo2` tinyint(4) NOT NULL DEFAULT 0,
  `ultfecha` date NOT NULL DEFAULT '0000-00-00',
  `ultfact` char(11) NOT NULL,
  `ultasi` int(11) NOT NULL,
  `nomreduc` char(8) NOT NULL,
  `anocont` int(4) NOT NULL,
  `menu1` int(1) NOT NULL,
  `menu2` int(1) NOT NULL,
  `menu3` int(1) NOT NULL,
  `menu4` int(1) NOT NULL,
  `actualizaciones` int(1) NOT NULL,
  `bloq` int(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `enviospor`
--

CREATE TABLE `enviospor` (
  `n` int(15) NOT NULL,
  `fecha` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deidn` varchar(255) NOT NULL DEFAULT '0',
  `deid` int(10) NOT NULL DEFAULT 0,
  `paraid` int(10) NOT NULL DEFAULT 0,
  `tipo` varchar(4) NOT NULL DEFAULT '',
  `mensaje1` longtext NOT NULL,
  `mensaje2` longtext NOT NULL,
  `exito` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ex_aulas`
--

CREATE TABLE `ex_aulas` (
  `cod` int(10) NOT NULL,
  `aula` varchar(10) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ex_examen`
--

CREATE TABLE `ex_examen` (
  `id` int(10) NOT NULL,
  `asigna` varchar(15) DEFAULT NULL,
  `curso` int(4) NOT NULL DEFAULT 0,
  `grupo` char(1) NOT NULL DEFAULT '',
  `conv` char(2) NOT NULL DEFAULT '',
  `obs` varchar(255) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `ex_examen`
--

INSERT INTO `ex_examen` (`id`, `asigna`, `curso`, `grupo`, `conv`, `obs`) VALUES
(19, 'A76', 2004, 'a', 'EJ', 'aaaaaaaaaaaaaaaaaaaaa'),
(20, 'A55', 2004, 'a', 'OJ', 'aaaaaaaa'),
(21, 'RC50', 2004, 'a', 'EJ', ''),
(22, '441', 2004, 'a', '', 'jjjjjjjjjj'),
(23, 'A76', 2004, 'a', 'OF', 'jjjjjjjjjj'),
(24, 'A76', 2004, 'm', 'EJ', 'hhhhhhhhhhhhhhhkkk'),
(25, 'P2', 2004, 'a', 'OJ', 'mmmmmmmmmmmmkkooolll'),
(26, 'I08', 2004, 'a', 'EJ', 'aaaaaaaaaaaa');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ex_prof`
--

CREATE TABLE `ex_prof` (
  `codprof` int(10) NOT NULL DEFAULT 0,
  `examen` int(10) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ex_tot`
--

CREATE TABLE `ex_tot` (
  `id` int(10) NOT NULL DEFAULT 0,
  `aula` varchar(10) NOT NULL DEFAULT '',
  `dia` date NOT NULL DEFAULT '0000-00-00',
  `hora` time NOT NULL DEFAULT '00:00:00',
  `duracion` time NOT NULL DEFAULT '00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `ex_tot`
--

INSERT INTO `ex_tot` (`id`, `aula`, `dia`, `hora`, `duracion`) VALUES
(19, '2', '2004-06-07', '11:00:00', '00:00:00'),
(20, '2', '2004-06-07', '13:00:00', '00:00:00'),
(21, '1', '2004-06-07', '13:00:00', '00:00:00'),
(22, '2', '2004-06-07', '15:00:00', '00:00:00'),
(23, '2', '2004-02-03', '12:00:00', '00:00:00'),
(24, '2', '2004-06-09', '12:00:00', '00:00:00'),
(25, '1', '2004-06-08', '11:00:00', '00:00:00'),
(26, '2', '2004-06-03', '11:00:00', '00:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `factemi`
--

CREATE TABLE `factemi` (
  `row_id` int(11) NOT NULL DEFAULT 0,
  `fecha` date DEFAULT NULL,
  `n_` int(10) NOT NULL DEFAULT 0,
  `total` double DEFAULT NULL,
  `letra` char(1) DEFAULT NULL,
  `clave` double DEFAULT NULL,
  `traspaso` char(1) DEFAULT NULL,
  `dni` char(10) DEFAULT NULL,
  `cliente` char(80) DEFAULT NULL,
  `benefbrut` int(11) DEFAULT NULL,
  `asiento` int(11) DEFAULT NULL,
  `fich` longblob NOT NULL,
  `tipofich` varchar(255) NOT NULL,
  `tipivar1` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `factrec`
--

CREATE TABLE `factrec` (
  `row_id` int(11) NOT NULL,
  `fecha` date DEFAULT NULL,
  `fact` char(10) DEFAULT NULL,
  `proveed` char(40) DEFAULT NULL,
  `codigo` int(11) NOT NULL DEFAULT 0,
  `totalr` double DEFAULT NULL,
  `clave` double DEFAULT NULL,
  `traspaso` char(1) DEFAULT NULL,
  `totbruto` double DEFAULT NULL,
  `desctofr` double DEFAULT NULL,
  `verificada` char(1) DEFAULT NULL,
  `punteo` char(1) DEFAULT NULL,
  `tipivar1` double DEFAULT NULL,
  `tipivar2` double DEFAULT NULL,
  `tipivar3` double DEFAULT NULL,
  `totalr1` double DEFAULT NULL,
  `totalr2` double DEFAULT NULL,
  `totalr3` double DEFAULT NULL,
  `descrip` char(30) DEFAULT NULL,
  `gasto` char(1) DEFAULT NULL,
  `concepto` char(30) DEFAULT NULL,
  `sistema` char(15) DEFAULT NULL,
  `cta` int(11) DEFAULT NULL,
  `tipirpf` double DEFAULT NULL,
  `gastod` int(11) DEFAULT NULL,
  `nomretss` int(11) DEFAULT NULL,
  `asiento` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `faq`
--

CREATE TABLE `faq` (
  `id` int(10) NOT NULL,
  `para` int(2) NOT NULL DEFAULT 0,
  `titulaci` varchar(5) NOT NULL DEFAULT '',
  `asigna` varchar(15) NOT NULL,
  `pr_c` varchar(255) NOT NULL DEFAULT '',
  `pr_v` varchar(255) NOT NULL DEFAULT '',
  `pr_i` varchar(255) NOT NULL DEFAULT '',
  `res_c` longtext NOT NULL,
  `res_v` longtext NOT NULL,
  `res_i` longtext NOT NULL,
  `activo` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fichaactualiz`
--

CREATE TABLE `fichaactualiz` (
  `usuid` int(10) NOT NULL DEFAULT 0,
  `cambio` varchar(255) NOT NULL DEFAULT '',
  `fecha` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fichaanotaci`
--

CREATE TABLE `fichaanotaci` (
  `n` int(10) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deid` int(10) NOT NULL,
  `sobreid` int(10) NOT NULL,
  `texto` longtext NOT NULL,
  `fich` longblob NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fichavaloracion`
--

CREATE TABLE `fichavaloracion` (
  `usuid` int(10) NOT NULL DEFAULT 0,
  `deusuid` int(10) NOT NULL DEFAULT 0,
  `fecha` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `video` int(2) NOT NULL DEFAULT 0,
  `ficha` int(2) NOT NULL DEFAULT 0,
  `comentario` varchar(255) NOT NULL DEFAULT '',
  `sesion` varchar(255) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `foro`
--

CREATE TABLE `foro` (
  `id` int(5) NOT NULL,
  `categoria` int(10) NOT NULL DEFAULT 0,
  `titulaci` varchar(5) NOT NULL DEFAULT '',
  `asigna` varchar(15) NOT NULL,
  `curso` varchar(4) NOT NULL DEFAULT '',
  `grupo` varchar(4) NOT NULL DEFAULT '0',
  `foros_id` int(11) NOT NULL DEFAULT 0,
  `contest_a` int(11) NOT NULL DEFAULT 0,
  `foro_id` int(11) NOT NULL DEFAULT 0,
  `usu_id` int(10) NOT NULL DEFAULT 0,
  `asunto` varchar(100) NOT NULL DEFAULT '',
  `comentario` longtext NOT NULL,
  `fecha` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `fechault` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `boletin` int(1) NOT NULL DEFAULT 0,
  `invisible` int(1) NOT NULL,
  `cerrado` datetime NOT NULL,
  `voto` decimal(5,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `forocategorias`
--

CREATE TABLE `forocategorias` (
  `id` int(10) NOT NULL,
  `tit` varchar(5) NOT NULL DEFAULT '',
  `asigna` varchar(15) NOT NULL DEFAULT '',
  `palabra` varchar(100) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `forogrupos`
--

CREATE TABLE `forogrupos` (
  `id` int(5) NOT NULL,
  `grupo` int(10) NOT NULL DEFAULT 0,
  `foros_id` int(11) NOT NULL DEFAULT 0,
  `contest_a` int(11) NOT NULL DEFAULT 0,
  `foro_id` int(11) NOT NULL DEFAULT 0,
  `usu_id` int(10) NOT NULL DEFAULT 0,
  `asunto` varchar(100) NOT NULL DEFAULT '',
  `comentario` longtext NOT NULL,
  `fecha` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `fechault` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `invisible` int(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `forovotos`
--

CREATE TABLE `forovotos` (
  `id` int(5) NOT NULL DEFAULT 0,
  `usuid` int(10) NOT NULL DEFAULT 0,
  `voto` int(2) NOT NULL DEFAULT 0,
  `fecha` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gc1`
--

CREATE TABLE `gc1` (
  `n` int(2) NOT NULL,
  `cat` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gc2`
--

CREATE TABLE `gc2` (
  `n` int(2) NOT NULL,
  `subn` varchar(1) NOT NULL,
  `cat` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `grabaciones`
--

CREATE TABLE `grabaciones` (
  `id` int(11) NOT NULL,
  `usuid` int(10) NOT NULL DEFAULT 0,
  `date` datetime DEFAULT NULL,
  `tamatach` int(20) NOT NULL DEFAULT 0,
  `tipoatach` varchar(255) NOT NULL DEFAULT '',
  `nomatach` text NOT NULL,
  `attachment` longblob DEFAULT NULL,
  `texto` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci PACK_KEYS=1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `grupos`
--

CREATE TABLE `grupos` (
  `id` int(10) NOT NULL,
  `grupo` varchar(10) NOT NULL DEFAULT '',
  `password` varchar(10) NOT NULL DEFAULT '',
  `asigna` varchar(15) NOT NULL,
  `eslogan` varchar(255) NOT NULL DEFAULT '',
  `logo` varchar(100) NOT NULL DEFAULT '',
  `fechacrea` date NOT NULL DEFAULT '0000-00-00',
  `numvinc` int(10) DEFAULT NULL,
  `video1` longtext NOT NULL,
  `interesante` text NOT NULL,
  `wow` text DEFAULT NULL,
  `competencias` longtext DEFAULT NULL,
  `mas` longtext DEFAULT NULL,
  `otros` longtext NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gruposexpo`
--

CREATE TABLE `gruposexpo` (
  `row_id` int(15) NOT NULL,
  `asigna` varchar(15) NOT NULL,
  `curso` varchar(4) NOT NULL,
  `grupo` varchar(4) NOT NULL,
  `maxusu` int(3) NOT NULL,
  `descripcion` varchar(255) NOT NULL,
  `grupoexpo` varchar(255) NOT NULL,
  `descripgrupo` varchar(255) NOT NULL,
  `tini` datetime NOT NULL,
  `tfin` datetime NOT NULL,
  `apuntados` longtext NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gruposexpotit`
--

CREATE TABLE `gruposexpotit` (
  `row_id` int(15) NOT NULL,
  `tit` varchar(15) NOT NULL,
  `curso` varchar(4) NOT NULL,
  `maxusu` int(3) NOT NULL,
  `descripcion` varchar(255) NOT NULL,
  `grupoexpo` varchar(255) NOT NULL,
  `descripgrupo` varchar(255) NOT NULL,
  `tini` datetime NOT NULL,
  `tfin` datetime NOT NULL,
  `apuntados` longtext NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gruposusu`
--

CREATE TABLE `gruposusu` (
  `grupo_id` int(10) NOT NULL DEFAULT 0,
  `usu_id` int(10) NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `idioma`
--

CREATE TABLE `idioma` (
  `m` varchar(50) NOT NULL DEFAULT '',
  `c` mediumtext DEFAULT NULL,
  `v` mediumtext DEFAULT NULL,
  `i` mediumtext DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `idioma`
--

INSERT INTO `idioma` (`m`, `c`, `v`, `i`) VALUES
('adios', 'Adios <nombre>, que tengas un buen día.', 'Adeu <nombre>, que tingues un bon dìa.', 'Bye <nombre>'),
('quees', 'Ayuda', 'Ajuda', 'Help'),
('salir', 'Salir', 'Eixir', 'Quit'),
('elegir', 'Elegir Asignatura', 'Elegir Assignatura', 'Choose Subject'),
('cuest', 'Cuestionario', 'Qüestionari', 'Questionnaire'),
('nuevousu', 'Nuevo Usuario', 'Nou Usuari', 'New User'),
('clave', 'Contraseña', 'Contrasenya', 'Password'),
('entrar', 'Entrar', 'Entrar', 'Enter'),
('activa', 'Clave de activación', 'Clau d´activació', 'Activation key'),
('frase1', 'El Administrador puede cambiar este párrafo por otro en \"General\" \"Sólo Administrador\" \"Traductor\".', 'El Administrador puede cambiar este párrafo por otro en \"General\" \"Sólo Administrador\" \"Traductor\".', 'El Administrador puede cambiar este párrafo por otro en \"General\" \"Sólo Administrador\" \"Traductor\".'),
('frase2', 'El Administrador puede cambiar este otro  párrafo por otro en \"General\" \"Sólo Administrador\" \"Traductor\".', 'El Administrador puede cambiar este otro  párrafo por otro en \"General\" \"Sólo Administrador\" \"Traductor\".', 'El Administrador puede cambiar este otro  párrafo por otro en \"General\" \"Sólo Administrador\" \"Traductor\".'),
('seleccasi', 'Selecciona una Asignatura', 'Selecciona una Asignatura', 'Selecciona una Asignatura'),
('masinfo', 'Más información sobre', 'Más información sobre', 'Más información sobre'),
('problem', 'Si tienes problemas para entrar haz click aquí', 'Si tens problemes per a entrar fes clic ací', 'Click here if you have problems to enter'),
('gaciassuger', 'Contacto', 'Contacto', 'Contact'),
('estudiyprof', 'identificación', 'identificación', 'identification'),
('libre', 'Libre', 'Libre', 'Libre'),
('ocupado', 'Ocupado', 'Ocupado', 'Ocupado'),
('usuanadido', 'El usuario ha sido añadido', 'El usuario ha sido añadido', 'El usuario ha sido añadido'),
('asinovisi', 'El profesor no ha hecho accesible esta asignatura', 'El profesor no ha hecho accesible esta asignatura', 'The teacher hasn\'t made this subject accessible.'),
('cambasi', 'Cambiar de asignatura', 'Cambiar de asignatura', 'Cambiar de asignatura'),
('nopermialta', 'Registro no permitido. Ponerse en contacto con los profesores de', 'Registro no permitido. Ponerse en contacto con los profesores de', 'Registro no permitido. Ponerse en contacto con los profesores de'),
('mqnoaut', 'Máquina no autorizada', 'Máquina no autorizatda', 'Non authorized machine.'),
('usunoex', 'Usuario no existente o contraseña incorrecta', 'Usuari no existent o contrasenya incorrecta', 'Non existent user or wrong password.'),
('usunoaut', 'Usuario no autorizado, temporal o indefinidamente. <br />Ponte en contacto con el administrador de <span class=\'b\'><site></span>', 'Usuari no autoritzat, temporal o indefinidament. <br />Posa´t en contacte amb l´administrador de <span class=\'b\'><site></span>', 'Not, temporally or permanently, authorized user. <br />Please contact <span class=\'b\'><site></span> administrator.'),
('profval', 'Profesor pendiente de validación', 'Professor pendent de validació', 'Validation pendent teacher.'),
('noautasi', 'No autorizado en esta Asignatura', 'No autoritzat en esta Assignatura', 'Not authorized in this subject.'),
('pda', '<site> para PDA en construcción', '<site> per a PDA en construcció', '<site> for PDA in construction'),
('hola1', 'Hola, te conectas desde una máquina desconocida para mí', 'Hola, et connectes des d´una màquina desconeguda per a mi', 'Hello, you are connecting from an unknown machine'),
('netsc', '¡ATENCIÓN! Estás usando otro navegador, el ayudante Merlin sólo funciona con Microsoft Internet Explorer', 'ATENCIÓ! Estàs usant un altre navegador web, l´ajudant Merlí només funciona amb Microsoft Internet Explorer', 'WARNING! You are using another web explorer. Merlin assistant works only with Microsoft Internet Explorer'),
('altaerror1', 'Imposible activar la cuenta o la cuenta ya está activa.', 'Imposible activar la cuenta o la cuenta ya está activa.', 'Impossible activate the account or account is already active.'),
('altaerror2', 'Clave no válida.', 'Clave no válida.', 'Not a valid key.'),
('altaerror3', 'Cuenta no activada en el tiempo requerido.', 'Cuenta no activada en el tiempo requerido.', 'Account not activated in required time.'),
('tamanofichgr', 'El tamaño del fichero ha de ser menor de: ', 'El tamaño del fichero ha de ser menor de: ', 'File size must be lees than:'),
('callto1', 'Permitir al resto de usuarios iniciar llamadas multimedia', 'Permitir al resto de usuarios iniciar llamadas multimedia', 'Permitir al resto de usuarios iniciar llamadas multimedia'),
('noselec', 'No has seleccionado ninguna asignatura.<p>Para añadir otras asignaturas, borrar, etc, pincha en <selecasigna><span class=\'b\'>Gestión Asignaturas</span>', 'No has seleccionat cap assignatura.<p>Per a afegir altres assignatures, esborrar, etc, punxa en <selecasigna><span class=\'b\'>Gestió Assignatures</span>', 'No has seleccionado ninguna asignatura.<p>Para añadir otras asignaturas, borrar, etc, pincha en <selecasigna><span class=\'b\'>Gestión Asignaturas</span>'),
('admi1', '(Administrador: se listan todas las asignaturas)', '(Administrador: es llisten totes les assignatures)', '(Administrator: all subjects are listed)'),
('aquideb', 'Aquí debajo verás tus estadísticas de vínculos. Los totales se actualizan cada vez que entras en <site>', 'Ací davall voràs les teues estadístiques de vincles. Els totals s´actualitzen cada vegada que entres en <site>', 'You can see your link statistics below. Totals are updated each time you enter in <site>'),
('estascon', 'Estás conectado a <site> en la asignatura <asigna>', 'Estàs connectat a <site> en l´assignatura <asigna>', 'You are connected to <site> in subject <asigna>'),
('ultavi', 'Últimos avisos', 'Últims avisos', 'Last messages'),
('mas', 'más', 'més', 'more'),
('maila', 'Mail a Profesores', 'Mail a Professors', 'Mail to Teachers'),
('web', 'Página web Profesor', 'Pàgina web Professor', 'Teacher web page'),
('pers', 'Datos personales', 'Dades personals', 'Personal Data'),
('exped', 'Expediente', 'Expedient', 'Expedient'),
('merlin', 'Ayudante Merlin', 'Ajudant Merlí', 'Merlin Assistant'),
('colores', 'Colores', 'Colors', 'Colors'),
('agenda', 'Mi Agenda', 'La Meua Agenda', 'My Diary'),
('carpeta', 'Mi Carpeta', 'La Meua Carpeta', 'My Folder'),
('asignas', 'Asignaturas', 'Assignatures', 'Subjects'),
('misvinc', 'Mis Vínculos', 'Els Meus Vincles', 'My Links'),
('anadir', 'Añadir Vínculo', 'Afegir Vincle', 'Add Link'),
('soload', 'Sólo Administrador', 'Només Administrador', 'Only Administrator'),
('solopr', 'Sólo Profesor', 'Només Professor', 'Only Teacher'),
('avisos', 'Anuncios y Avisos', 'Anuncis i Avisos', 'Annoucements and Notifications'),
('notas', 'Notas', 'Notes', 'Marks'),
('recur', 'Recursos', 'Recursos', 'Resources'),
('cont', 'Contenidos', 'Continguts', 'Contents'),
('acti', 'Actividades', 'Activitats', 'Activities'),
('eval', 'Evaluaciones', 'Avaluacions', 'Evaluations'),
('dist', 'Clase a distancia', 'Classe a distància', 'Distance Classes'),
('usus', 'Usuarios', 'Usuaris', 'Users'),
('usuario', 'Usuario', 'Usuari', 'User'),
('bd', 'Base de datos', 'Base de dades', 'Data Base'),
('comentvinc', 'Comentarios a los vínculos', 'Comentaris als vincles', 'Comments to Links'),
('estad', 'Estadísticas', 'Estadístiques', 'Statistics'),
('grupos', 'Grupos de Trabajo', 'Grups de Treball', 'Teamwork Groups'),
('foro', 'Foro', 'Fòrum', 'Forum'),
('chat', 'Chat', 'Xat', 'Chat'),
('admi', 'Mail al Administrador', 'Mail al Administrador', 'Mail to Administrator'),
('hola', '¡Hola <nombre>!', '¡Hola <nombre>!', '¡Hello <nombre>!'),
('bienve', 'Bienvenido a <site>', 'Benvingut a <site>', 'Welcome to <site>'),
('bienvasigna', 'Bienvenido a la asignatura <asigna>', 'Benvingut a l´assignatura <asigna>', 'Welcome to <asigna> subject'),
('porleer', 'Tienes <mensajes> mensajes por leer en <site> messenger', 'Tens <mensajes> missatges per llegir en <site> messenger', 'You have <mensajes> messages for reading in <site> messenger'),
('nomens', 'No tienes mensajes por leer en <site> messenger', 'No tens missatges per llegir en <site> messenger', 'You do not have messages for reading in <site> messenger'),
('estadis', 'De <numvinc> vínculos añadidos por <numusu> usuarios, tuyos son <vinctuyos> siendo el <ranking>º usuario que más vínculos ha añadido. Has votado <votados> vínculos y has recibido <numvotrec> votos, siendo la puntuación media recibida de <nota>. Por otro lado has comentado <coment1> vínculos', 'De <numvinc> vincles afegits per <numusu> usuaris, teus són <vinctuyos> sent el <ranking>º usuari que més vincles ha afegit. Has votat <votados> vincles i has rebut <numvotrec> vots, sent la puntuació mitjana rebuda de <nota>. D´altra banda has comentat <coment1> vincles', 'From <numvinc> added links by <numusu> users, <vinctuyos> are yours, being the <ranking>º user the most links have added. You have voted <votados> links and you have received <numvotrec> votes, being the average received score <nota>. Moreover you have commented <coment1> links.'),
('pg', 'Página', 'Pàgina', 'Page'),
('datosusu', 'Datos de usuario', 'Dades d´usuari', 'User´s Data'),
('parausar', 'Para usar <site> necesitas un nombre de usuario y una contraseña.', 'Per a usar <site> necessites un nom de usuari i una contrasenya.', 'Para usar <site> necesitas un nombre de usuario y una contraseña.'),
('orla', 'Orla', 'Orla', 'Student Pics'),
('noexiste', 'No existe', 'No existe', 'No existe'),
('registrarme', 'Registrarme', 'Registrarme', 'Registrarme'),
('borrarme', 'Borrarme', 'Borrarme', 'Borrarme'),
('selecasi', 'Selecciona una asignatura, curso y grupo en que te quieras registrar', 'Selecciona una asignatura, curso y grupo en que te quieras registrar', 'Selecciona una asignatura, curso y grupo en que te quieras registrar'),
('nexistprof', 'No existe profesor para', 'No existe profesor para', 'There\'s no teacher for'),
('noregis', 'No se puede realizar el registro.', 'No se puede realizar el registro.', 'No se puede realizar el registro.'),
('usu', 'Datos de usuario', 'Dades d`usuari', 'User´s Data'),
('selecc', 'Seleccionar una Contraseña', 'Seleccionar una Contrasenya', 'Select a password'),
('repc', 'Repetir la Contraseña', 'Repetir la Contrasenya', 'Repeat the password'),
('minus', 'minúsculas', 'minúscules', 'lower'),
('conti', 'Continuar', 'Continuar', 'Next'),
('inicio', 'Inicio', 'Inici', 'Home'),
('usuexiste', '<span class=\'b\'>Atención:</span> lo sentimos. El nombre de usuario <usuario> ya existe, elige otro por favor', '<span class=\'b\'>Atenció:</span> ho sentim. El nom d´usuari <usuario> ja existix, elegix un altre per favor.', '<span class=\'b\'>Warning:</span> We are sorry. The user name <usuario> already exists, please choose another one.'),
('datosper', 'Datos personales', 'Dades personals', 'Personal data'),
('usunov', 'Usuario no válido', 'Usuari no vàlid', 'User no valid'),
('volver', 'Volver', 'Tornar', 'Return'),
('notaaster', '<span class=\'b\'>Nota</span>: Los Campos con asterisco * son obligatorios.', '<span class=\'b\'>Nota</span>: Els Campos amb asterisc * són obligatoris.', '<span class=\'b\'>Note</span>: The fields with asterisc * are obligatories.'),
('nombre', 'Nombre', 'Nom', 'Name'),
('apellidos', 'Apellidos', 'Cognoms', 'Last Name'),
('mail', 'Mail', 'Mail', 'Mail'),
('dni', 'D.N.I. (DNI, pasaporte, carnet de conducir o documento de identificación, según el país)', 'D.N.I. (DNI, pasaporte, carnet de conducir o documento de identificación, según el país)', 'D.N.I. (DNI, passport, driver license or identification document, depending on the country)'),
('pais', 'País', 'País', 'Country'),
('provincia', 'Provincia', 'Província', 'Provincia'),
('direccion', 'Dirección', 'Adreça', 'Address'),
('codpos', 'Código Postal', 'Codi Postal', 'Postal code'),
('localidad', 'Localidad', 'Localitat', 'City'),
('tfmov', 'Teléfono Móvil', 'Telèfon Mòbil', 'Cell Phone'),
('mostrar', 'Mostrar teléfono al resto de usuarios', 'Mostrar telèfon a la resta d´usuaris', 'Show telephone to the rest of users'),
('ppers', 'Página Personal', 'Pàgina Personal', 'Personal Page'),
('titul', 'Titulación', 'Titulació', 'Studies'),
('universi', 'Universidad', 'Universitat', 'University'),
('sexo', 'Sexo', 'Sexe', 'Sex'),
('fnaci', 'Fecha de nacimiento (dd/mm/aaaa)', 'Data de naixement (dd/mm/aaaa)', 'Birth Date (dd/mm/yyyy)'),
('conpar', 'Con pareja', 'Amb parella', 'With girl-boyfriend'),
('amis', 'Busco nuevas amistades', 'Busque noves amistats', 'I\'m looking for new friends'),
('masmi', 'Para tener cierta idea sobre mi: (máximo 255 caracteres. )', 'Per a tindre certa idea sobre mon: (màxim 255 caràcters. )', 'For having some idea about me: (maximum 255 characters. )'),
('si', 'SI', 'SI', 'YES'),
('no', 'NO', 'NO', 'NO'),
('h', 'Hombre', 'Hombre', 'Man'),
('m', 'Mujer', 'Dona', 'Woman'),
('poner', 'puedes poner todavía <caracteres> caracteres más', 'pots posar encara <caracteres> caràcters més', 'you can put <caracteres> characters more'),
('completaas', 'Completa todos los campos señalados con un asterisco', 'Completa tots els camps assenyalats amb un asterisc', 'Please, complete all fields with asterisk'),
('mailno', 'El campo mail no es válido', 'El camp mail no és vàlid', 'mail is not valid'),
('eligeop', 'Elige una opción', 'Elegix una opció', 'Choose an option'),
('mailnoa', 'El mail no corresponde a alumno de la UJI', 'El mail no correspon a alumne de la UJI', 'El mail no corresponde a alumno de la UJI'),
('mailalu', 'El mail corresponde a alumno de la UJI', 'El mail correspon a alumne de la UJI', 'El mail corresponde a alumno de la UJI'),
('losenti', '<span class=\'b\'>Atención:</span> lo sentimos, ya existe dado de alta un usuario con ese mail', '<span class=\'b\'>Atenció:</span> ho sentim, ja existix donat d´alta un usuari amb eixe mail', '<span class=\'b\'>Atención:</span> lo sentimos, ya existe dado de alta un usuario con ese mail'),
('mailmal', 'Mail incorrecto', 'Mail incorrecte', 'Mail incorrecto'),
('tipo', 'Tipo de afiliación a <site>', 'Tipus d´afiliació a <site>', 'Tipo de afiliación a <site>'),
('alumno', 'Estudiante', 'Estudiant', 'Student'),
('profesor', 'Profesor', 'Professor', 'Teacher'),
('externo', 'Usuario externo', 'Usuari extern', 'External user'),
('motivo', 'Escribe en el recuadro de texto el motivo de tu solicitud', 'Escriu en el requadro de text el motiu de la teua sol·licitud', 'Escribe en el recuadro de texto el motivo de tu solicitud'),
('fin', 'Fin del proceso', 'Fi del procés', 'Fin del proceso'),
('deseoclave', 'Deseo obtener la cuenta de profesor para', 'Desitge obtindre la compte de professor per a', 'I want to obtain the teacher account for'),
('solicitar', 'Solicitar', 'Sol·licitar', 'Solicitar'),
('completa', 'Completa todos los campos.', 'Completa tots els camps.', 'Please, complete all fields.'),
('cursomay', 'El curso ha de ser <curso> o mayor', 'El curs ha de ser <curso> o major', 'Course has to be <curso> or higher.'),
('asigna', 'Asignatura', 'Assignatura', 'Subject'),
('hasele', 'Has elegido darte de alta como <span class=\'b\'>Alumno</span>. Ahora tienes que <span class=\'rojo\'>elegir una asignatura</span> de la lista siguiente, el curso y el grupo en que te vas a matricular', 'Has elegit donar-te d´alta com <span class=\'b\'>Alumne</span>. Ara tens que <span class=\'rojo\'>elegir una assignatura</span> de la llista següent, el curs i el grup en què et vas a matricular', 'Has elegido darte de alta como <span class=\'b\'>Alumno</span>. Ahora tienes que <span class=\'rojo\'>elegir una asignatura</span> de la lista siguiente, el curso y el grupo en que te vas a matricular'),
('curso', 'Curso', 'Curs', 'Course'),
('grupo', 'Grupo', 'Grup', 'Group'),
('daralta', 'Dar de alta', 'Donar d´alta', 'Register'),
('selecacgadmi', 'Selecciona una Asignatura, un Curso y un Grupo que exista para poder acceder a estas opciones.', 'Selecciona una Asignatura, un Curso y un Grupo que exista para poder acceder a estas opciones.', 'Selecciona una Asignatura, un Curso y un Grupo que exista para poder acceder a estas opciones.'),
('opcomun', 'Estas son opciones comunes a todos los profesores de', 'Estas son opciones comunes a todos los profesores de', 'Estas son opciones comunes a todos los profesores de'),
('carpfichde', 'Carpeta de Ficheros de', 'Carpeta de Ficheros de', 'Files Folder'),
('gestievalde', 'Gestión de Evaluaciones de', 'Gestiò d\'Avaluacions de', 'Evaluations Management of'),
('textaenvi', 'Textos a enviar', 'Textos a enviar', 'Textos a enviar'),
('logoydescr', 'Logo y Descripción Asignatura', 'Logo y Descripción Asignatura', 'Logo y Descripción Asignatura'),
('comunicaciones', 'Comunicación', 'Comunicació', 'Notification'),
('alumnos', 'Alumnos', 'Alumnos', 'Students'),
('error', 'Se ha producido un error, ponte en contacto con el Administrador de <site>', 'S´ha produït un error, posa´t en contacte amb l´Administrador de <site>', 'It has been an error, please contact the <site> administrator.'),
('textasunto', 'cuenta en <site>', 'compte a <site>', 'cuenta en <site>'),
('buscar', 'buscar', 'buscar', 'search'),
('sobresaliente', 'Sobresaliente', 'Excel·lent', 'Outstanding'),
('notable', 'Notable', 'Notable', 'B grade'),
('aprobado', 'Aprobado', 'Aprovat', 'Pass'),
('suspenso', 'Suspenso', 'Suspès', 'Fail'),
('suspensodesc', 'Suspenso descompensado', 'Suspès descompensat', 'Unbalanced fail'),
('carpactu', 'Carpeta actual', 'Carpeta actual', 'Current folder'),
('filemax', 'Tamaño máximo de los ficheros a enviar', 'Tamaño máximo de los ficheros a enviar', 'Maximum file size to be send'),
('formatof', 'Formato de fecha', 'Formato de fecha', 'Formato de fecha'),
('fotosino', 'Mostrar u ocultar fotos en los listados para una navegación más ligera', 'Mostrar u ocultar fotos en los listados para una navegación más ligera', 'Show or hide pictures in reports for a lighter browsing'),
('fotosver', 'Mostrar fotos', 'Mostrar fotos', 'Show pictures'),
('conmarca', 'Con marca', 'Con marca', 'Width mark'),
('sendfile', 'Enviar fichero', 'Enviar fichero', 'Send file'),
('createfile', 'Crear fichero', 'Crear fichero', 'Create file'),
('createfolder', 'Crear carpeta', 'Crear carpeta', 'Create folder'),
('borrarfich', 'Borrar', 'Esborrar', 'Delete'),
('copytofol', 'Copiar a carpeta', 'Copiar a carpeta', 'Copy to folder'),
('rename', 'Renombrar a', 'Renombrar a', 'Rename'),
('movetofol', 'Mover a carpeta', 'Mover a carpeta', 'Move to folder'),
('borrarfichmarc', '¿Borrar ficheros marcados?', '¿Borrar ficheros marcados?', 'Delete selected files?'),
('enesta', 'En esta asignatura', 'En esta assignatura', 'In this subject'),
('totales', 'Totales', 'Totals', 'Total'),
('numvinc', 'Vínculos añadidos', 'Vincles afegits', 'Added links'),
('votosrec', 'Votos recibidos', 'Vots rebuts', 'Received Votes'),
('puntu', 'Puntuación', 'Puntuació', 'Score'),
('ajenos', 'votados', 'votats', 'voted'),
('coment', 'Comentarios añadidos', 'Comentaris afegits', 'Added comments'),
('massobre', 'Más sobre mí', 'Mès sobre mí', 'More about me'),
('privacidad', 'Privacidad', 'Privacitat', 'Privacity'),
('priv0', '0 - Mostrar todos los datos', '0 - Mostrar totes les dades', '0 - Show all data'),
('priv1', '1 - Mostrar sólo el nombre y apellidos', '1 - Mostrar no mès nom i cognom', '1 - Show only names'),
('priv2', '2 - Mostrar sólo el \"usuario\" o \"nick\"', '2 - Mostrar no mès \"usuari\" o \"nick\"', '2 - Show only \"user\" or \"nick\" '),
('borrar', '>> Borrar Ficha >>', '>> Esborrar Fitxa >>', '>> DELETE REGISTER >>'),
('novid', 'No hay vídeo disponible', 'No hi ha vídeo disponible', 'There is no video available'),
('nofoto', 'No hay foto disponible', 'No hi ha foto disponible', 'There is no available picture '),
('foto', 'Foto', 'Foto', 'Picture'),
('video', 'Vídeo', 'Vídeo', 'Vídeo'),
('borrarfoto', 'Borrar mi foto de', 'Borrar mi foto de', 'Erase my picture from'),
('borrvid', 'Borrar mi vídeo de <site>', 'Borrar mi vídeo de <site>', 'Erase my video from <site>'),
('vervid', 'Ver el vídeo enviado por', 'Ver el vídeo enviado por', 'Ver el vídeo enviado por'),
('pertgr', 'Pertenece a los grupos de trabajo', 'Pertenece a los grupos de trabajo', 'Pertenece a los grupos de trabajo'),
('enlinea', '¡ En línea !', '¡ En línea !', '¡ On Line !'),
('lanzar', 'Lanzar conferencia multimedia con', 'Lanzar conferencia multimedia con', 'Lanzar conferencia multimedia con'),
('netscape', 'Estás usando <span class=\'b\'>Netscape</span>, por lo que las opciones de audio/videoconferencia con este usuario no están activadas.', 'Estás usando <span class=\'b\'>Netscape</span>, por lo que las opciones de audio/videoconferencia con este usuario no están activadas.', 'Estás usando <span class=\'b\'>Netscape</span>, por lo que las opciones de audio/videoconferencia con este usuario no están activadas.'),
('nmpg', 'NetMeeting en la página', 'NetMeeting en la página', 'NetMeeting en la página'),
('nolin', 'El usuario no está en línea y no se pude hacer videoconferencia.', 'El usuario no está en línea y no se pude hacer videoconferencia.', 'El usuario no está en línea y no se pude hacer videoconferencia.'),
('sinpar', 'Sin pareja', 'Sense parella', 'Without boy/girlfriend'),
('nobusco', 'No busco nuevas amistades', 'No vull noves amistats', 'I\'m not looking for new friends'),
('carpvisi', 'Carpeta del usuario, visible sólo para profesores.', 'Carpeta del usuario, visible sólo para profesores.', 'User folder, only visible for teachers.'),
('jsborr', 'Se va a borrar a <usuario> de la Base de Datos. Los vínculos pasarán a formar parte de la base de datos general de', 'Se va a borrar a <usuario> de la Base de Datos. Los vínculos pasarán a formar parte de la base de datos general de', 'Se va a borrar a <usuario> de la Base de Datos. Los vínculos pasarán a formar parte de la base de datos general de'),
('usuborr', 'El usuario ha sido borrado', 'El usuario ha sido borrado', 'El usuario ha sido borrado'),
('ver', 'Ver Ficha', 'Veure Fitxa', 'See File'),
('editar', 'Cambiar Perfil', 'Cambiar Perfil', 'Change Profile'),
('perm', 'PERMISOS', 'PERMISOS', 'PERMISOS'),
('claveact', 'Clave de activación', 'Clave de activación', 'Activation key'),
('contranocoinc', 'Las contraseñas introducidas no coinciden.', 'Las contraseñas introducidas no coinciden.', 'Introduced passwords don\'t match.'),
('mi', 'MI', 'EL MEU', 'MY'),
('vincnew', 'Introduce sólo la dirección de la página (campo <span class=\'b\'>Web</span>) y pulsa en <span class=\'b\'>Verificar</span> para comprobar si ese vínculo ya ha sido introducido por otro usuario. Pulsa en <span class=\'b\'>Extraer Claves y Resumen</span> para que se rellenen <span class=\'rojo\'>automáticamente los campos <span class=\'b\'>Claves</span> y <span class=\'b\'>Resumen</span></span> (podrás modificarlos a tu gusto) cuando la página lo permita.  Luego, para <span class=\'b\'>Añadir</span> el vínculo, han de estar completados los campos señalados con un asterisco (*).', 'Introduïx només l\'adreça de la pàgina (camp <span class=\'b\'>Web</span>) i polsa en <span class=\'b\'>Verificar</span> per a comprovar si eixe vincle ja ha sigut introduït per un altre usuari. Polsa en <span class=\'b\'>Extraure Claus i Resum </span> perquè se òmpliguen <span class=\'rojo\'> automàticament els camps <span class=\'b\'>Claus</span> i <span class=\'b\'>Resum </span></span> (podràs modificar-los al teu gust) quan la pàgina ho permeta. Després, per a <span class=\'b\'>Afegir</span> el vincle, han d\'estar completats els camps assenyalats amb un asterisc (*).', 'Insert only the web page address (field <span class=\'b\'>Web</span>) and click on <span class=\'b\'>Verify</span> for checking if this link has been already added by another user. Click on <span class=\'b\'>Extract Keys and Abstract</span> for <span class=\'rojo\'>automatically filling up the fields <span class=\'b\'>Key Words</span> and <span class=\'b\'>Abstract</span></span> (when the page have this feature). Then, you will be able to modify the fields as desired. After that, for <span class=\'b\'>Add</span> the link, all the fields marked with asterisc (*) must be filled.'),
('area', 'Área', 'Área', 'Area'),
('titulo', 'Título', 'Tìtol', 'Title'),
('claves', 'Palabras Clave', 'Paraules Clau', 'Key Words'),
('resumen', 'Resumen', 'Resum', 'Abstract'),
('ampliacion', 'Ampliación', 'Ampliació', 'Extension'),
('web1', 'Intruduce un valor en el campo Web', 'Intruduce un valor en el campo Web', 'Intruduce un valor en el campo Web'),
('webexiste', 'Lo sentimos, <nombre>, el vínculo <url> ya ha sido insertado por <nombre1>', 'Lo sentimos, <nombre>, el vínculo <url> ya ha sido insertado por <nombre1>', 'Lo sentimos, <nombre>, el vínculo <url> ya ha sido insertado por <nombre1>'),
('vinculosen', 'Vínculos en ', 'Vincles a', 'Links in '),
('usuenlin', 'Actualizar usuarios en línea', 'Actualitzar usuaris en línia', 'Refresh online users'),
('vincnoex', '¡Enhorabuena! El vínculo no está en la base de datos de vínculos.', '¡Enhorabuena! El vínculo no está en la base de datos de vínculos.', '¡Enhorabuena! El vínculo no está en la base de datos de vínculos.'),
('gicextraer', 'Extraer Claves y Resumen', 'Extraure Claus i Resum', 'Extract Keys and Abstract'),
('gicverif', 'Verificar', 'Verificar', 'Verify'),
('giclosenti', 'Lo sentimos, <usuario>, pero <vinc> ya ha sido introducido por <por>', 'Lo sentimos, <usuario>, pero <vinc> ya ha sido introducido por <por>', 'Lo sentimos, <usuario>, pero <vinc> ya ha sido introducido por <por>'),
('gicnoexiste', 'Lo sentimos, <usuario>, pero no existe el vínculo.', 'Lo sentimos, <usuario>, pero no existe el vínculo.', 'Lo sentimos, <usuario>, pero no existe el vínculo.'),
('comentvinc1', 'Comentar el vínculo', 'Comentar el vínculo', 'Comentar el vínculo'),
('gicnocompl', 'Lo sentimos, <nombre>, pero no has completado todos los campos.', 'Lo sentimos, <nombre>, pero no has completado todos los campos.', 'Lo sentimos, <nombre>, pero no has completado todos los campos.'),
('gicgracias', '¡Gracias por tu aportación <usuario>!. El vínculo <url>, con el título: <titulo>, ha sido introducido en la Base de Datos de <site>. A partir de ahora este vínculo queda asociado a tu nombre en nuestros registros.', '¡Gracias por tu aportación <usuario>!. El vínculo <url>, con el título: <titulo>, ha sido introducido en la Base de Datos de <site>. A partir de ahora este vínculo queda asociado a tu nombre en nuestros registros.', '¡Gracias por tu aportación <usuario>!. El vínculo <url>, con el título: <titulo>, ha sido introducido en la Base de Datos de <site>. A partir de ahora este vínculo queda asociado a tu nombre en nuestros registros.'),
('gicyahay', 'Ya hay <numvinc> vínculos de la asignatura, de los cuales tu has puesto <numvinc1>', 'Ya hay <numvinc> vínculos de la asignatura, de los cuales tu has puesto <numvinc1>', 'Ya hay <numvinc> vínculos de la asignatura, de los cuales tu has puesto <numvinc1>'),
('gicgen', 'GEN - Asignatura Genérica', 'GEN - Asignatura Genérica', 'GEN - Asignatura Genérica'),
('max255', '(máximo 255 caracteres.)', '(màxim 255 caràcters.)', '(maximum 255 characters.)'),
('timismo', 'ti mismo', 'ti mismo', 'ti mismo'),
('quesean', 'que sean', 'que siguen', 'that are'),
('cuyonom', 'cuyo nombre o apellido contenga', 'cuyo nombre o apellido contenga', 'whose name or surname contains'),
('delcurso', 'del Curso / Grupo', 'del Curso / Grupo', 'of the course / group'),
('delaasigna', 'de la asignatura', 'de la asignatura', 'of the subject'),
('connota', 'con nota en', 'con nota en', 'with marks in'),
('enlinea1', 'en línea', 'en línea', 'on line'),
('fotosi', 'con foto', 'amb foto', 'with picture'),
('fotono', 'sin foto', 'sense foto', 'without picture'),
('videosi', 'con vídeo', 'amb vídeo', 'with video'),
('videono', 'sin vídeo', 'sense vídeo', 'without video'),
('engrupo', 'que pertenezcan a un grupo de trabajo', 'que pertenezcan a un grupo de trabajo', 'that belong to a working group'),
('vaciarcamp', 'Vaciar campos', 'Esborrar camps', 'Empty Fields'),
('verusu', 'Ver Usuarios', 'Veure Usuaris', 'See Users'),
('buscarusu', 'Buscar Usuarios ...', 'Cercar Usuaris ...', 'Search for Users ...'),
('anadir1', 'Añadir', 'Afegir', 'Add'),
('misasigna', 'Mis Asignaturas', 'Les meues assignatures', 'My Subjects'),
('borrarasi', '<span class=\'b u\'>BORRARME DE LA ASIGNATURA / CURSO / GRUPO SELECCIONADOS</span>', '<span class=\'b u\'>BORRARME DE LA ASIGNATURA / CURSO / GRUPO SELECCIONADOS</span>', '<span class=\'b u\'>DELETE ME FROM THE SELECTED SUBJECT / COURSE / GROUP</span>'),
('traspvinc', 'Traspasar vínculos a', 'Traspasar vínculos a', 'Traspasar vínculos a'),
('tengovinc', 'Tengo vínculos en', 'Tinc vincles a', 'I have links in'),
('yaaltaprof', 'Ya estás dado de alta como profesor en ', 'Ja estàs donat d\'alta com a professor en ', 'Ya estás dado de alta como profesor en '),
('estanasigna', '¿Están tus asignaturas dadas de alta ya?. En ese caso selecciónalas en el siguiente listado y pulsa \"Añadir\".<br>Si no, pulsa en ', 'Estan les teues assignatures donades d\'alta ja?. En eixe cas selecciona-les en el següent llistat i polsa \"Afegir\".<br>Si no, polsa en', 'Are your subjects already registered? in this case select them in the following list and click on \"Add\". <br>If not so, click on '),
('crearasig', 'Crear Nueva Asignatura', 'Crear Nueva Asignatura', 'Create new subject'),
('asigdispo', 'Asignaturas disponibles', 'Asignaturas disponibles', 'Available subjects'),
('soyprofde', 'Soy profesor de', 'Soc professor de', 'I am teacher of'),
('campotip', 'Campo <span class=\'b\'>Tipo</span> no válido.', 'Campo <span class=\'b\'>Tipo</span> no válido.', 'Not valid <span class=\'b\'>Format</span> field.'),
('asigna2c', 'Asignatura debe de tener al menos dos caracteres.', 'Asignatura debe de tener al menos dos caracteres.', 'Subject must have at less two characters.'),
('sehaanad', 'Se ha añadido una asignatura con los siguientes datos', 'Se ha añadido una asignatura con los siguientes datos', 'Se ha añadido una asignatura con los siguientes datos'),
('descrip', 'Descripción', 'Descripción', 'Description'),
('tipo1', 'Tipo:  0 - Indefinida. 1 - Semestral: 1er semestre &nbsp; 2 - Semestral: 2º semestre &nbsp; 3 - Anual', 'Tipo: 0 - Indefinida. 1 - Semestral: 1er semestre &nbsp; 2 - Semestral: 2º semestre &nbsp; 3 - Anual', 'Tipo: 0 - Indefinida. 1 - Semestral: 1er semestre &nbsp; 2 - Semestral: 2º semestre &nbsp; 3 - Anual'),
('noextit', 'No existe la Titulación <span class=\'b\'><titulacion></span>, pon la descripción', 'No existe la Titulación <span class=\'b\'><titulacion></span>, pon la descripción', 'No existe la Titulación <span class=\'b\'><titulacion></span>, pon la descripción'),
('asignaselec', 'Asignaturas seleccionadas', 'Asignaturas seleccionadas', 'Chosen subjects'),
('setehanana', 'Se te han añadido las siguientes asignaturas', 'Se te han añadido las siguientes asignaturas', 'Se te han añadido las siguientes asignaturas'),
('editar1', 'Editar', 'Editar', 'Edit'),
('buscarenbd', 'Buscar en la Base de Datos', 'Buscar en la Base de Datos', 'Search in data base'),
('nohasselec', 'No has seleccionado ninguna asignatura', 'No has seleccionat cap assignatura', 'No has seleccionado ninguna asignatura'),
('profesores', 'Profesores', 'Professors', 'Teachers'),
('clave1', 'Clave', 'Clau', 'Key'),
('buscarenint', 'Buscar en Internet', 'Cerca a Internet', 'Search in the Internet'),
('cambiarabs', 'búsqueda simple', 'búsqueda simple', 'simple search'),
('cambiaraba', 'búsqueda avanzada', 'búsqueda avanzada', 'advanced search'),
('busenweb', 'Buscar en la Web ', 'Buscar en la Web ', 'Search in the web'),
('busenespa', 'Buscar sólo páginas en español', 'Buscar sólo páginas en español', 'Search only pages in spanish'),
('buscongo', 'Búsqueda con Google', 'Búsqueda con Google', 'Search with Google'),
('otrosbus', 'Otros Buscadores', 'Altres Buscadors', 'Other Searchers'),
('busvinc', 'Buscar vínculos', 'Buscar vínculos', 'Search links'),
('y', 'y', 'y', 'and'),
('o', 'o', 'o', 'or'),
('vinculos', 'Vínculos', 'Vincles', 'Links'),
('vinculo', 'Vínculo', 'Vincle', 'Link'),
('vincrotos', '(Los vínculos marcados con una cruz roja se han detectado como rotos)', '(Els vincles marcats amb una creu roja han segut detectats com a trencats)', '(The red cross marked links have been detected as broken)'),
('arriba', 'Arriba', 'Arriba', 'Top'),
('grver', 'Ver el listado de todos los grupos', 'Veure el llistat de tots els grups', 'See the list of all groups'),
('grveryo', 'Mis Grupos de Trabajo', 'Els meus Grups de Treball', 'My Working Groups'),
('grcrear', 'Crear un Grupo', 'Crear un Grup', 'Create a Group'),
('grunirse', 'Unirse a un grupo. Tienes que saber su contraseña.', 'Afegirse a un grup. Tens que saber la seua contrasenya.', 'Join a group. You have to know its password.'),
('grsalir', 'Salir de un grupo', 'Eixir de un grup', 'Leave a group'),
('estosson', 'Estos son los <span class=\'verde b\'><numvinculos></span> vínculos <deasigna> que he añadido hasta ahora', 'Aquests son els <span class=\'verde b\'><numvinculos></span> vincles <deasigna> que he afegit fins ara', 'These are the <span class=\'verde b\'><numvinculos></span> links<deasigna> I have added until now.'),
('de', 'de', 'de', 'of'),
('asignadispo', 'Asignaturas disponibles', 'Asignaturas disponibles', 'Available subjects'),
('enloscur', 'En los cursos', 'En los cursos', 'In the courses'),
('nota', 'Nota', 'Nota', 'Mark'),
('insmodif', 'Inserción<br>Modificación', 'Inserció<br>Modificació', 'Added<br>Modificated'),
('votos', 'Votos', 'Votos', 'Votos'),
('eligcondbus', 'Elige alguna condición de búsqueda.', 'Elige alguna condición de búsqueda.', 'Choose a search condition'),
('avisarmail', '<span class=\'verde b\'>Avisarme por mail cuando...</span> haya nuevos vínculos sobre', '<span class=\'verde b\'>Avisarme por mail cuando...</span> haya nuevos vínculos sobre', '<span class=\'verde b\'>Alert me by mail when ...</span> there are new links about'),
('usuinteres', 'Usuarios interesados por haber insertado más de:', 'Usuaris interesats per haver afegit mès de:', 'Interested Users for having added more than:'),
('vinculos1', 'vínculos', 'vincles', 'links'),
('colorfon', 'Color de fondo:', 'Color de fondo:', 'Background colour:'),
('dejarvacio', '(Dejar vacío para tener textura de fondo por defecto)', '(Dejar vacío para tener textura de fondo por defecto)', '(Leave blank for default background texture)'),
('enviadocomen', 'Se ha enviado tu comentario sobre este vínculo.', 'Se ha enviado tu comentario sobre este vínculo.', 'Your comment about this link has been sent.'),
('nohaycomen', 'No hay comentarios sobre este vínculo.', 'No hi ha comentaris de aquest vincle', 'The are no comment about this link'),
('autorcomen', 'Autor de los comentarios:', 'Autor de los comentarios:', 'Comments author:'),
('nohaycomen1', 'No hay comentarios para esa selección.', 'No hi ha comentaris per aquesta selecció.', 'No hay comentarios para esa selección.'),
('comentarios', 'comentarios', 'comentarios', 'Comments'),
('noseenc', 'No se encontraron datos.', 'No se encontraron datos.', 'No se encontraron datos.'),
('medoro', 'Medalla de oro :-)', 'Medalla de oro :-)', 'Medalla de oro :-)'),
('medplata', 'Medalla de plata :-)', 'Medalla de plata :-)', 'Medalla de plata :-)'),
('medbronce', 'Medalla de bronce :-)', 'Medalla de bronce :-)', 'Medalla de bronce :-)'),
('usuarios', 'usuarios', 'usuaris', 'users'),
('punturecib', 'Puntuación<br>recibida', 'Puntuació<br>rebuda', 'Received<br>score'),
('dt', 'Desviación Típica', 'Desviación Típica', 'Standard deviation'),
('rotos', 'Rotos', 'Rotos', 'Rotos'),
('actuestad', 'Actualizar estadística', 'Actualizar estadística', 'Statistics update'),
('profde', 'Profesor de', 'Professor de', 'Teacher of'),
('alude', 'Alumno de', 'Alumno de', 'Student of'),
('yanovinc', 'Ya no existe el vínculo.', 'Ya no existe el vínculo.', 'Ya no existe el vínculo.'),
('noclanires', 'LA PÁGINA NO PROPORCIONA CLAVES NI RESUMEN', 'LA PÀGINA NO PROPORCIONA CLAUS NI RESUM', 'PAGE DON\'T PROVIDE ANY KEY NOR ABSTRACTS'),
('cerrarvent', 'Cerrar Ventana', 'Tancar finestra', 'Close window'),
('grupocerr', 'Grupo cerrado de la asignatura: ', 'Grupo cerrado de la asignatura: ', 'Grupo cerrado de la asignatura: '),
('grupoabierto', 'Grupo Abierto', 'Grupo Abierto', 'Grupo Abierto'),
('foroiniciar', 'Iniciar un Asunto', 'Iniciar un Asumpte', 'Start new topic'),
('nohaymens', 'No hay mensajes.', 'No hi han misatges.', 'There are no messages.'),
('asunto', 'Asunto', 'Asunto', 'Topic'),
('ultimainser', 'Última inserción', 'Darrera inserció', 'Last added'),
('numcontest', 'Nº de contestaciones', 'Nº de contestacions', 'Nº of answers'),
('temas', 'temas', 'temas', 'temas'),
('insertacomen', 'Inserta tu comentario', 'Inserta tu comentario', 'Inserta tu comentario'),
('anadircomen', 'Añadir un comentario', 'Añadir un comentario', 'Add a comment'),
('comentario', 'Comentario', 'Comentario', 'Comment'),
('insertaasucomen', 'Inserta tu asunto y comentario', 'Inserta tu asunto y comentario', 'Inserta tu asunto y comentario'),
('publibolet', 'Publicar en el boletín', 'Publicar en el boletín', 'Publicar en el boletín'),
('max2000', '(máximo 2000 caracteres.)', '(màxim 2000 caràcters.)', '(maximum 2000 characters.)'),
('vincborr', 'El vínculo ha sido borrado', 'El vínculo ha sido borrado', 'El vínculo ha sido borrado'),
('vervinc', 'Ver vínculo', 'Ver vínculo', 'Ver vínculo'),
('vercoment', 'Ver comentarios', 'Ver comentarios', 'Ver comentarios'),
('comentar', 'Comentar', 'Comentar', 'Comment'),
('votar', 'Votar', 'Votar', 'Votar'),
('usunoautovot', 'Usuario no autorizado para realizar votaciones', 'Usuario no autorizado para realizar votaciones', 'Usuario no autorizado para realizar votaciones'),
('vincborrar', '¿Estás seguro de que quieres borrar el vínculo?', '¿Estás seguro de que quieres borrar el vínculo?', '¿Estás seguro de que quieres borrar el vínculo?'),
('aceptar', 'Aceptar', 'Aceptar', 'Accept'),
('borrvinc', '¡Borrar vínculo!', '¡Borrar vínculo!', 'Delete link!'),
('nopermivincusu', 'No permitido ver los vínculos del usuario en esta asignatura en este momento.', 'No permitido ver los vínculos del usuario en esta asignatura en este momento.', 'No permitido ver los vínculos del usuario en esta asignatura en este momento.'),
('vincinserpor', 'Vínculo insertado por', 'Vínculo insertado por', 'Vínculo insertado por'),
('regisvoto', 'Ha quedado registrado tu voto.', 'Ha quedado registrado tu voto.', 'Ha quedado registrado tu voto.'),
('evalvinc', 'Evaluar vínculo (de 1 a 10):', 'Evaluar vínculo (de 1 a 10):', 'Evaluar vínculo (de 1 a 10):'),
('vota110', 'Vota de 1 a 10', 'Vota de 1 a 10', 'Vota de 1 a 10'),
('comentestevinc', 'Comentar este vínculo:', 'Comentar este vínculo:', 'Comment this link:'),
('enviar', 'Enviar', 'Enviar', 'Send'),
('vermiscomen', 'Ver mis comentarios', 'Veure els meus comentaris', 'See my comments'),
('grintegra', 'Integrantes', 'Integrantes', 'Integrantes'),
('abierto', 'Abierto', 'Abierto', 'Open'),
('modificar', 'Modificar', 'Modificar', 'Modificar'),
('frasegr', 'Frase que define al grupo', 'Frase que define al grupo', 'Frase que define al grupo'),
('secreagrab', 'Se creará un grupo abierto a cualquier usuario', 'Se creará un grupo abierto a cualquier usuario', 'Se creará un grupo abierto a cualquier usuario'),
('paracerr', 'para crear uno cerrado a usuarios de una Asignatura, has de elegirla en el menú desplegable de arriba', 'para crear uno cerrado a usuarios de una Asignatura, has de elegirla en el menú desplegable de arriba', 'para crear uno cerrado a usuarios de una Asignatura, has de elegirla en el menú desplegable de arriba'),
('creargr', 'Crear Grupo', 'Crear Grupo', 'Crear Grupo'),
('grupos1', 'grupos', 'grupos', 'groups'),
('salirgr', 'Salir del grupo', 'Salir del grupo', 'Salir del grupo'),
('grunirse1', 'Unirse al Grupo', 'Afegirse a un grup', 'Join a group'),
('sinautogr', 'Sin autorización para acceder a los grupos de trabajo.', 'Sin autorización para acceder a los grupos de trabajo.', 'Sin autorización para acceder a los grupos de trabajo.'),
('grexiste', 'El grupo <span class=\'b\'>(grupo)</span> ya existe.', 'El grupo <span class=\'b\'>(grupo)</span> ya existe.', 'El grupo <span class=\'b\'>(grupo)</span> ya existe.'),
('frasemodif', 'Se ha modificado la frase.', 'Se ha modificado la frase.', 'Se ha modificado la frase.'),
('yaengr', 'Ya perteneces al grupo', 'Ya perteneces al grupo', 'Ya perteneces al grupo'),
('entradoengr', 'Has entrado al grupo', 'Has entrado al grupo', 'Has entrado al grupo'),
('grmalcontra', 'El grupo <span class=\'b\'>(grupo)</span> existe pero es incorrecta la contraseña para entrar o es un grupo cerrado de la Asignatura y no la tienes asociada en el menú de arriba.', 'El grupo <span class=\'b\'>(grupo)</span> existe pero es incorrecta la contraseña para entrar o es un grupo cerrado de la Asignatura y no la tienes asociada en el menú de arriba.', 'El grupo <span class=\'b\'>(grupo)</span> existe pero es incorrecta la contraseña para entrar o es un grupo cerrado de la Asignatura y no la tienes asociada en el menú de arriba.'),
('grnoex', 'El grupo <span class=\'b\'>(grupo)</span> no existe.', 'El grupo <span class=\'b\'>(grupo)</span> no existe.', 'El grupo <span class=\'b\'>(grupo)</span> no existe.'),
('mensauto', 'Este es un mensaje automático. He entrado en el grupo (grupo).', 'Este es un mensaje automático. He entrado en el grupo (grupo).', 'Este es un mensaje automático. He entrado en el grupo (grupo).'),
('noestasengr', 'No estás en el grupo <span class=\'b\'>(grupo)</span>', 'No estás en el grupo <span class=\'b\'>(grupo)</span>', 'No estás en el grupo <span class=\'b\'>(grupo)</span>'),
('atencionborrgr', '¡Atención! Eres el único integrante del grupo. Se borrará el grupo <span class=\'rojo\'>(grupo)</span> y todos sus ficheros', '¡Atención! Eres el único integrante del grupo. Se borrará el grupo <span class=\'rojo\'>(grupo)</span> y todos sus ficheros', '¡Atención! Eres el único integrante del grupo. Se borrará el grupo <span class=\'rojo\'>(grupo)</span> y todos sus ficheros'),
('confirmborr', 'Confirmar borrado', 'Confirmar borrado', 'Confirmar borrado'),
('hasabgr', 'Has abandonado el grupo <span class=\'b\'>(grupo)</span>', 'Has abandonado el grupo <span class=\'b\'>(grupo)</span>', 'Has abandonado el grupo <span class=\'b\'>(grupo)</span>'),
('mensauto1', 'Este es un mensaje automático. He salido del grupo (grupo)', 'Este es un mensaje automático. He salido del grupo (grupo)', 'Este es un mensaje automático. He salido del grupo (grupo)'),
('grborr', 'El grupo <span class=\'b\'>(grupo)</span> ha sido borrado', 'El grupo <span class=\'b\'>(grupo)</span> ha sido borrado', 'El grupo <span class=\'b\'>(grupo)</span> ha sido borrado'),
('gracceso', '(Si no puedes acceder a los ficheros de un grupo, selecciona primero la asignatura que corresponde en la opción ASIGNATURAS.)', '(Si no puedes acceder a los ficheros de un grupo, selecciona primero la asignatura que corresponde en la opción ASIGNATURAS.)', '(Si no puedes acceder a los ficheros de un grupo, selecciona primero la asignatura que corresponde en la opción ASIGNATURAS.)'),
('nogrupos', 'No hay grupos', 'No hay grupos', 'No hay grupos'),
('nogrupos1', 'en esta asignatura', 'en esta asignatura', 'en esta asignatura'),
('fechacreagr', 'Fecha de creación', 'Fecha de creación', 'Fecha de creación'),
('graciasforo', '¡Gracias por tu aportación <span class=\'b\'>(nombre)</span>!. El comentario <span class=\'b\'>(asunto)</span> ha sido introducido en el foro.', '¡Gracias por tu aportación <span class=\'b\'>(nombre)</span>!. El comentario <span class=\'b\'>(asunto)</span> ha sido introducido en el foro.', '¡Gracias por tu aportación <span class=\'b\'>(nombre)</span>!. El comentario <span class=\'b\'>(asunto)</span> ha sido introducido en el foro.'),
('envionotasalu', 'Envío de notas al alumno', 'Envío de notas al alumno', 'Sending marks to the student'),
('mensenvi', 'Mensaje enviado', 'Mensaje enviado', 'Mensaje enviado'),
('mesenvimail', 'Mensaje enviado por MAIL', 'Mensaje enviado por MAIL', 'Mensaje enviado por MAIL'),
('mesenvisms', 'Mensaje enviado por SMS', 'Mensaje enviado por SMS', 'Mensaje enviado por SMS'),
('mesenvihsm', 'Mensaje enviado por Messenger', 'Mensaje enviado por Messenger', 'Mensaje enviado por Messenger'),
('comunicestand', 'Atención: para cambiar el texto estandar ir a: Sólo Profesor - Textos a enviar.', 'Atención: para cambiar el texto estandar ir a: Sólo Profesor - Textos a enviar.', 'Atención: para cambiar el texto estandar ir a: Sólo Profesor - Textos a enviar.'),
('agampliar', 'AMPLIAR', 'AMPLIAR', 'EXPAND'),
('agagenda', 'AGENDA', 'AGENDA', 'DIARY'),
('agmes1', 'Mes anterior', 'Mes anterior', 'Previous Month'),
('agedit', 'EDITANDO', 'EDITANDO', 'EDITING'),
('agnotaper', 'Ninguna, es una nota personal', 'Ninguna, es una nota personal', 'None, it\'s a personal note.'),
('agfecha', 'Fecha', 'Fecha', 'Date'),
('agborrar', 'BORRAR', 'ESBORRAR', 'DELETE'),
('agdetall', 'Detalle', 'Detalle', 'Detail'),
('agmenspref', 'Mensaje preferente', 'Missatge preferent', 'Top on message list'),
('agaagenda', 'A Agenda', 'A Agenda', 'To diary'),
('agatablon', 'A Tablón', 'A Tauler', 'To Board'),
('agvalid', 'Validar', 'Validar', 'Validate'),
('aganadiendo', 'AÑADIENDO', 'AFEGINT', 'ADDING'),
('aganadir1', 'Añadir', 'Afegir', 'Add'),
('agmesactu', 'Mes actual', 'Mes actual', 'Present month'),
('agira', 'Ir a', 'Anar a', 'Go to'),
('aspecticon', 'Aspecto de los iconos', 'Aspecto de los iconos', 'Aspecto de los iconos'),
('ultiacces', 'Último acceso el', 'Último acceso el', 'Último acceso el'),
('vernotas', 'VER NOTAS', 'VER NOTAS', 'VER NOTAS'),
('edicion', 'EDICIÓN', 'EDICIÓN', 'EDICIÓN'),
('comentario1', 'Comentario', 'Comentario', 'Comentario'),
('clasesgrab', 'Clases Grabadas', 'Classes Grabades', 'Recorded Class'),
('apinter', 'Apuntes de Internet', 'Apuntes de Internet', 'Apuntes de Internet'),
('evaluacion', 'Evaluación', 'Evaluación', 'Evaluación'),
('yaestasasigna', 'Ya estás dado de alta en <span class=\'b\'>(asigna)</span> el año <span class=\'b\'>(ano)</span>.', 'Ja estàs donat d\'alta en <span class=\'b\'>(asigna)</span> l\'any <span class=\'b\'>(anus)</span>.', 'Ya estás dado de alta en <span class=\'b\'>(asigna)</span> el año <span class=\'b\'>(ano)</span>.'),
('borrasi', 'Confirma que deseas borrarte de la asignatura', 'Confirma que deseas borrarte de la asignatura', 'Confirma que deseas borrarte de la asignatura'),
('borrasig1', 'Si tienes vínculos en ella, no se borrarán, pero no quedarán asociados a ninguna asignatura.', 'Si tienes vínculos en ella, no se borrarán, pero no quedarán asociados a ninguna asignatura.', 'Si tienes vínculos en ella, no se borrarán, pero no quedarán asociados a ninguna asignatura.'),
('borrasi1', 'No has seleccionado Asignatura y Curso a borrar', 'No has seleccionado Asignatura y Curso a borrar', 'No has seleccionado Asignatura y Curso a borrar'),
('eligeasigna', 'Elige asignatura.', 'Elige asignatura.', 'Elige asignatura.'),
('eligeabc', 'Da un valor para el GRUPO: A, B, C,...', 'Da un valor para el GRUPO: A, B, C,...', 'Da un valor para el GRUPO: A, B, C,...'),
('vincrep', '<span class=\'b\'>Lo sentimos, (nombre) (apellidos)</span>, pero este (vinculo) ya ha sido introducido por <span class=\'b\'>(porusuario)</span>, por lo que no se ha modificado tu vínculo.', '<span class=\'b\'>Lo sentimos, (nombre) (apellidos)</span>, pero este (vinculo) ya ha sido introducido por <span class=\'b\'>(porusuario)</span>, por lo que no se ha modificado tu vínculo.', '<span class=\'b\'>Lo sentimos, (nombre) (apellidos)</span>, pero este (vinculo) ya ha sido introducido por <span class=\'b\'>(porusuario)</span>, por lo que no se ha modificado tu vínculo.'),
('vincnoexis', 'El vínculo no existe.', 'El vínculo no existe.', 'El vínculo no existe.'),
('vinceditno', '<span class=\'b\'>Lo sentimos</span>, <span class=\'b\'>(nombre)</span>, pero no has completado todos los campos. No se ha modificado el vínculo.', '<span class=\'b\'>Lo sentimos</span>, <span class=\'b\'>(nombre)</span>, pero no has completado todos los campos. No se ha modificado el vínculo.', '<span class=\'b\'>Lo sentimos</span>, <span class=\'b\'>(nombre)</span>, pero no has completado todos los campos. No se ha modificado el vínculo.'),
('nodatos', 'No se han encontrado datos.', 'No se han encontrado datos.', 'No se han encontrado datos.'),
('cambiapriv', 'Para poder enviar mensajes cambia tu privacidad en tu ficha personal.', 'Para poder enviar missatges canvia la teua privacitat  a la teua fitxa personal.', 'Change your privacy in your personal profile to send messages.'),
('msagent', '¡¡ATENCIÓN!! Si es la primera vez que ejecutas el Microsoft Agent, se instalarán una serie de programas en tu ordenador. Esto llevará un tiempo, sobre todo si conectas por modem. ¿Está seguro de que quieres activarlo?', '¡¡ATENCIÓN!! Si es la primera vez que ejecutas el Microsoft Agent, se instalarán una serie de programas en tu ordenador. Esto llevará un tiempo, sobre todo si conectas por modem. ¿Está seguro de que quieres activarlo?', '¡¡ATENCIÓN!! Si es la primera vez que ejecutas el Microsoft Agent, se instalarán una serie de programas en tu ordenador. Esto llevará un tiempo, sobre todo si conectas por modem. ¿Está seguro de que quieres activarlo?'),
('msagent1', 'Confirmar que se desea desactivar Microsoft Agent', 'Confirmar que se desea desactivar Microsoft Agent', 'Confirmar que se desea desactivar Microsoft Agent'),
('msagent2', 'Has activado el ayudante (agente). Si quieres usar otro y es la primera vez que lo haces, has de INSTALARLO antes mediante el enlace correspondiente. Luego ya puedes elegirlo pinchando en su icono.', 'Has activat l\'ajudant (agent). Si vols usar un altre i és la primera vegada que ho fas, has d\'INSTAL·LAR-HO abans per mitjà de l\'enllaç corresponent. Després ja pots triar-ho punxant en el seu icona.', 'You have enabled the assistant (agente). If you want to use another one and is the first time you do it, you have to INSTALL IT before by the correspondent link. After this you can choose it by clicking on its icon.'),
('msagent3', 'Si quieres usar un ayudante y es la primera vez que lo haces, has de INSTALARLO antes mediante el enlace correspondiente. Luego ya puedes elegirlo pinchando en su icono.', 'Si quieres usar un ayudante y es la primera vez que lo haces, has de INSTALARLO antes mediante el enlace correspondiente. Luego ya puedes elegirlo pinchando en su icono.', 'Si quieres usar un ayudante y es la primera vez que lo haces, has de INSTALARLO antes mediante el enlace correspondiente. Luego ya puedes elegirlo pinchando en su icono.');
INSERT INTO `idioma` (`m`, `c`, `v`, `i`) VALUES
('msagent4', 'EL AYUDANTE (agente) ESTÁ ACTIVO. PINCHA SOBRE ÉL PARA DESACTIVARLO O SOBRE OTRO PARA ELEGIRLO.', 'EL AYUDANTE (agente) ESTÁ ACTIVO. PINCHA SOBRE ÉL PARA DESACTIVARLO O SOBRE OTRO PARA ELEGIRLO.', 'EL AYUDANTE (agente) ESTÁ ACTIVO. PINCHA SOBRE ÉL PARA DESACTIVARLO O SOBRE OTRO PARA ELEGIRLO.'),
('msagent5', 'El Ayudante (agente) está desactivado. Pincha sobre él para activarlo.', 'L\'Ajudant (agente) està desactivat. Punxa sobre ell per a activar-ho.', 'The assistant (agente) is disabled. Click on him to enable.'),
('instalar', 'Instalar', 'Instalar', 'Install'),
('msagent6', 'Quiero que (agente) me salude con esta frase', 'Quiero que (agente) me salude con esta frase', 'Quiero que (agente) me salude con esta frase'),
('msagent7', 'Para que cite tu nombre en los saludos incluye <span class=\'verde b\'>#####</span> en el texto.', 'Para que cite tu nombre en los saludos incluye <span class=\'verde b\'>#####</span> en el texto.', 'Para que cite tu nombre en los saludos incluye <span class=\'verde b\'>#####</span> en el texto.'),
('msagent8', 'y que se despida así', 'y que se despida así', 'y que se despida así'),
('opnovalid', 'Opción no válida en este momento.', 'Opción no válida en este momento.', 'Opción no válida en este momento.'),
('hainsertado', '<span class=\'rojo\'>(nombre)</span> ha insertado <span class=\'rojo\'>(vinculos)</span> vínculos', '<span class=\'rojo\'>(nombre)</span> ha insertado <span class=\'rojo\'>(vinculos)</span> vínculos', '<span class=\'rojo\'>(nombre)</span> ha insertado <span class=\'rojo\'>(vinculos)</span> vínculos'),
('criteriobus', 'Introducir algún criterio de búsqueda', 'Introducir algún criterio de búsqueda', 'Introducir algún criterio de búsqueda'),
('grmrcar', 'marcar para crear un grupo de trabajo cerrado de alumnos de la asignatura', 'marcar para crear un grupo de trabajo cerrado de alumnos de la asignatura', 'marcar para crear un grupo de trabajo cerrado de alumnos de la asignatura'),
('grdarcontras', 'Has de dar alguna contraseña', 'Has de dar alguna contraseña', 'Has de dar alguna contraseña'),
('grtipo', 'Tipo de Grupo', 'Tipo de Grupo', 'Tipo de Grupo'),
('grnoauto', 'Sin autorización para acceder a los grupos de trabajo.', 'Sin autorización para acceder a los grupos de trabajo.', 'Sin autorización para acceder a los grupos de trabajo.'),
('mess1', 'Para añadir usuarios a tu lista del Messenger, búscalos y envíales un mensaje desde su ficha personal.', 'Para añadir usuarios a tu lista del Messenger, búscalos y envíales un mensaje desde su ficha personal.', 'To add users to your Messanger contact list, search them and send a personal message form their personal profile.'),
('charvalid', 'Utiliza entre 4 y 15 caracteres: letras a-z, A-Z, números 0-9 ó  -_', 'Utiliza entre 4 y 15 caracteres: letras a-z, A-Z, números 0-9 ó  -_', 'Utiliza entre 4 y 15 caracteres: letras a-z, A-Z, números 0-9 ó  -_'),
('cerrar', 'Cerrar', 'Tancar', 'Close'),
('messfile', 'Elegir un <span class=\'b\'>archivo</span> para enviar', 'Elegir un <span class=\'b\'>archivo</span> para enviar', 'Elegir un <span class=\'b\'>archivo</span> para enviar'),
('messhisto', 'Historial de mensajes', 'Historial de mensajes', 'Historial de mensajes'),
('messenv', 'Enviar a', 'Enviar a', 'Send to'),
('messno', 'No hay mensajes', 'No hay mensajes', 'There are no messages'),
('messverde', 'Los mensajes con el <span class=\'verde\'>NOMBRE</span> en color verde NO han sido leídos por el destinatario del mensaje.', 'Los mensajes con el <span class=\'verde\'>NOMBRE</span> en color verde NO han sido leídos por el destinatario del mensaje.', 'Los mensajes con el <span class=\'verde\'>NOMBRE</span> en color verde NO han sido leídos por el destinatario del mensaje.'),
('idioma', 'Idioma', 'Llengua', 'Language'),
('ayudante', 'Ayudante', 'Ajudant', 'Assistant'),
('menu', 'Menu', 'Menu', 'Menu'),
('personalizar', 'Personalizar', 'Personalitzar', 'Customize'),
('todoforo', 'Todos los foros', 'Todos los foros', 'All forum'),
('fmalfecha', 'El formato de la fecha no es válido. Por favor, introdúcela correctamente.', 'El formato de la fecha no es válido. Por favor, introdúcela correctamente.', 'El formato de la fecha no es válido. Por favor, introdúcela correctamente.'),
('fmalmes', 'El mes introducido no es válido. Por favor, introduce un mes correcto.', 'El mes introducido no es válido. Por favor, introduce un mes correcto.', 'El mes introducido no es válido. Por favor, introduce un mes correcto.'),
('fmaldia', 'El día introducido no es válido. Por favor, introduce un día correcto.', 'El día introducido no es válido. Por favor, introduce un día correcto.', 'El día introducido no es válido. Por favor, introduce un día correcto.'),
('fmalano', 'El año introducido no es válido. Por favor, introduce un año entre 1900 y 2100', 'El año introducido no es válido. Por favor, introduce un año entre 1900 y 2100', 'El año introducido no es válido. Por favor, introduce un año entre 1900 y 2100'),
('enero', 'Enero', 'Enero', 'January'),
('febrero', 'Febrero', 'Febrero', ' February'),
('marzo', 'Marzo', 'Marzo', 'March'),
('abril', 'Abril', 'Abril', 'April'),
('mayo', 'Mayo', 'Mayo', 'May'),
('junio', 'Junio', 'Junio', 'June'),
('julio', 'Julio', 'Julio', 'July'),
('agosto', 'Agosto', 'Agosto', 'August'),
('septiembre', 'Septiembre', 'Septiembre', 'September'),
('octubre', 'Octubre', 'Octubre', 'October'),
('noviembre', 'Noviembre', 'Noviembre', 'November'),
('diciembre', 'Diciembre', 'Diciembre', 'December'),
('agmes2', 'Mes siguiente', 'Mes siguiente', 'Next Month'),
('agreducir', 'REDUCIR', 'REDUCIR', 'REDUCE'),
('agrecurdia', 'Recursos del día', 'Recursos del día', 'Current resources'),
('nohayfich', 'No hay ficheros.', 'No hay ficheros.', 'No hay ficheros.'),
('progrmaster', 'Programa del Master', 'Programa del Master', 'Master Program'),
('general', 'General', 'General', 'General'),
('alertas', 'alertas automáticas', 'alertas automáticas', 'automatic alerts'),
('grtitsal', 'Salir', 'Eixir', 'Leave'),
('grtitent', 'Unirse', 'Afegir', 'Join'),
('grtitcre', 'Crear', 'Crear', 'Create'),
('grtitmis', 'Mis grupos', 'Els meus Grups', 'My groups'),
('grtittod', 'Todos', 'Tots', 'All'),
('asigregis', 'Registro realizado.', 'Registro realizado.', 'Registro realizado.'),
('borrasig2', 'Al borrarte de la única asignatura en la que estás registrado, dejarás de ser alumno, pasando a ser usuario externo.', 'Al borrarte de la única asignatura en la que estás registrado, dejarás de ser alumno, pasando a ser usuario externo.', 'Al borrarte de la única asignatura en la que estás registrado, dejarás de ser alumno, pasando a ser usuario externo.'),
('hecho', 'HECHO', 'HECHO', 'DONE'),
('tipo2', 'Tipo', 'Tipo', 'Tipo'),
('filtrar', 'FILTRAR', 'FILTRAR', 'FILTER'),
('inlinet', 'Tiempo en línea', 'Tiempo en línea', 'Tiempo en línea'),
('inlinetacu', 'Tiempo acumulado', 'Tiempo acumulado', 'Tiempo acumulado'),
('selecacgprof', 'Selecciona una Asignatura, un Curso y un Grupo de los que seas profesor para poder acceder a estas opciones.', 'Selecciona una Asignatura, un Curso y un Grupo de los que seas profesor para poder acceder a estas opciones.', 'Selecciona una Asignatura, un Curso y un Grupo de los que seas profesor para poder acceder a estas opciones.'),
('aluval', 'Alumno pendiente de validación ', 'Alumno pendent de validació', 'Validation pendent student'),
('enlace', 'Enlace', 'Enlace', 'Link'),
('leer', 'Leer', 'Leer', 'Read'),
('mensajes', 'mensajes', 'misatges', 'messages'),
('callto', 'Usuario de conferencia multimedia', 'Usuario de conferencia multimedia', 'Usuario de conferencia multimedia'),
('calltohelp', 'Introduce tu usuario Skype si quieres ser llamado por otros usuarios a través de Skype.\r\n\r\nSi deseas ser llamado por Netmeeting escribe en este campo simplemente [ip].\r\n\r\nPor otro lado tendrás que configurar tu navegador con tu programa favorito de conferencia multimedia para poder comunicar con él con otros usuarios de <site>.', 'Introduce tu usuario Skype si quieres ser llamado por otros usuarios a través de Skype.\r\n\r\nSi deseas ser llamado por Netmeeting escribe en este campo simplemente [ip].\r\n\r\nPor otro lado tendrás que configurar tu navegador con tu programa favorito de conferencia multimedia para poder comunicar con él con otros usuarios de <site>.', 'Introduce tu usuario Skype si quieres ser llamado por otros usuarios a través de Skype.\r\n\r\nSi deseas ser llamado por Netmeeting escribe en este campo simplemente [ip].\r\n\r\nPor otro lado tendrás que configurar tu navegador con tu programa favorito de conferencia multimedia para poder comunicar con él con otros usuarios de <site>.'),
('recurgen', 'Recursos Compartidos', 'Recursos Compartits', 'Shared Resources'),
('nuevosvinc', 'Nuevos vínculos añadidos por', 'Nous vinculs afegits per', 'New links added by'),
('delgrupo', 'del grupo <grupo>', 'del grupo <grupo>', 'from the group <grupo>'),
('forocoment', 'Comentar', 'Comentar', 'Comentar'),
('nogpl', '¡ATENCIÓN! Esta distribución de EVAI es GPL y no lleva los módulos de Microsoft Agent para el funcionamiento de los Ayudantes de voz en el navegador Microsoft Internet Explorer. Solicitar su instalción al Administrador. Para obtener los módulos escribir a <a href=\"mailto:mail@antoniograndio.com\">Antonio Grandío</a> o <a href=\"mailto:mail@inmaecharri.com\">Inma Echarri</a>.', '¡ATENCIÓN! Esta distribución de EVAI es GPL y no lleva los módulos de Microsoft Agent para el funcionamiento de los Ayudantes de voz en el navegador Microsoft Internet Explorer. Solicitar su instalción al Administrador. Para obtener los módulos escribir a <a href=\"mailto:mail@antoniograndio.com\">Antonio Grandío</a> o <a href=\"mailto:mail@inmaecharri.com\">Inma Echarri</a>.', '¡ATENCIÓN! Esta distribución de EVAI es GPL y no lleva los módulos de Microsoft Agent para el funcionamiento de los Ayudantes de voz en el navegador Microsoft Internet Explorer. Solicitar su instalción al Administrador. Para obtener los módulos escribir a <a href=\"mailto:mail@antoniograndio.com\">Antonio Grandío</a> o <a href=\"mailto:mail@inmaecharri.com\">Inma Echarri</a>.'),
('validarnd', '>> Validar Nuevos Datos >>', '>> Validar Noves Dades >>', '>> Validate New Data >>'),
('altabienve', 'Bienvenido al asistente de nuevos usuarios de <site>. Vamos a intentar guiarte paso a paso en el proceso de alta en el Entorno Virtual de Aprendizaje.', 'Benvingut a l\'assistent de nous usuaris de <site>. Intentarem guiar-te pas a pas en el procés d\'alta en l\'Entorn Virtual d\'Aprenentatge.', 'Welcome to the <site> Assistant for New Users. We are trying to help you, step by step, joining the Virtual Interactive Learning Enviroment.'),
('altamailtexto_p_a', 'A la atención del profesor de [<asigna> - <curso> - <grupo>] en <site>.<br>Se ha recibido una solicitud de alta como alumno de la siguiente persona.', 'A l\'atenció del professor de [<asigna> - <curso> - <grupo>] en <site>.<br>S\'ha rebut una sol·licitud d\'alta com a alumne de la següent persona.', 'A la atención del profesor de [<asigna> - <curso> - <grupo>] en <site>.<br>Se ha recibido una solicitud de alta como alumno de la siguiente persona.'),
('altahasele', 'Has elegido darte de alta como <span class=b>Alumno</span>. Ahora tienes que <span class=rojo>elegir una asignatura</span> de la lista siguiente, el curso y el grupo en que te vas a matricular.', 'Has triat donar-te d\'alta com <span class=b>Alumno</span>. Ara tens que <span class=rojo>triar una assignatura</span> de la llista següent, el curs i el grup en què et vas a matricular.', 'You have chosen to register as <span class=b>Alumno</span>. Now you have to <span class=rojo>choose a subject</span> of the following list, the course and the group in which you are going to register.'),
('altamens_ea', 'Hola <alumnon>, a partir de ahora eres un usuario registrado en <site>. Sin embargo tienes que \"validarte\" para serlo de modo definitivo.<p>Para hacerlo, se te ha enviado un email a la cuenta de correo que has introducido: <mail>.<p>Deberías recibirlo en menos de 24 horas (lo normal es menos de 20 minutos). Una vez recibido, debes pinchar en el enlace.<p>Si en ese tiempo no lo has recibido, por favor ponte en contacto con <admi>, porque tu registro se bloqueará cuando haya transcurrido una semana sin validarte.<p>Muchas gracias por tu interés en <site>, y esperamos que te guste la experiencia.<p><br><p>Recuerda que tu nombre de usuario es: <usuario> y tu contraseña: <clave>, lo necesitarás para gestionar tus datos (altas, bajas y modificaciones, etc.) en <site>.<p>Ya te puedes conectar a <linksite>.', 'Hola <alumnon>, a partir d´ara ets un usuari registrat a <site>. No obstant tens que \"validar-te\" per a ser-ho de mode definitiu.<p>Per a fer-ho, s´t´ha enviat un mail al compte de correu que has introduït: <mail>. Hauries de rebre-lo en menys de 24 hores (allò normal és menys de 20 minuts). Una vegada rebuda, has de pinchar en el enlace.<p>Si en eixe temps no l´has ebut, per favor posa´t en contacte amb <admi>, perquè el teu registre es bloquejarà quan haja transcorregut una setmana sense validar-te.<p>Moltes gràcies pel teu interés en <site>, i esperem que t´agrade l´experiència.<p><br><p>Recorda que el teu nom d´usuari és: <usuario> i la teua contrasenya: <clave>, el necessitaràs per a gestionar els teus dades(altas, bajas y modificaciones, etc.) en <site>.<p>Ya te puedes conectar a <linksite>.', 'Hello <alumnon>, since now you are a <site> registered user. Nevertheless, you have to \"validate\" in order to be in a permanent mode.<p>For doing so, it has been sent an mail to the e-mail address you have entered: <mail>. You should receive mail in less of 24 hours (the usual is less than 20 minutes). Once received, you must click in the link.<p>If you haven\'t received the key in that time, please contact with <admi>, because your registering will be blocked through a week without validating.<p>Thank you for your interest in <site>, and we hope you\'ll enjoy the experience.<p><br><p>Remember that your user name is: <usuario> and your password: <clave>, you will need them for managing your data (adding, erasing and modifications, etc.) in <site>.<p><center>Your are ready to connect to <linksite>.'),
('altamailasunto_ea', 'cuenta en <site>', 'compte a <site>', 'account in <site>'),
('altamailtexto_ea', 'Se ha recibido desde <mail> una solicitud de alta como <tipo> en <site> a nombre de <alumnon> <alumnoa>.<p>Pinchar en <linkacti> para activar la cuenta antes de 7 días a partir del <fecha> para que no sea bloqueada.<p>El nombre de usuario es <usuario> y la contraseña es <clave>.<p>Saludos.<p>', 'S\'ha rebut des de <mail> una sol·licitud d\'alta com <tipo> en <site> a nom de <alumnon> <alumnoa>.<p>Punxar en <linkacti> per a activar el compte abans de 7 dies a partir del <fecha> perquè no siga bloquejada.<p>El nom d\'usuari és <usuario> i la contrasenya és <clave>.<p>Salutacions.<p>', 'Se ha recibido desde <mail> una solicitud de alta como <tipo> en <site> a nombre de <alumnon> <alumnoa>.<p>Pinchar en <linkacti> para activar la cuenta antes de 7 días a partir del <fecha> para que no sea bloqueada.<p>El nombre de usuario es <usuario> y la contraseña es <clave>.<p>Saludos.<p>'),
('altamailtexto_p', 'A la atención del administrador del sistema del <site>.<br>Se ha recibido una solicitud de alta como profesor de la siguiente persona.', 'A la atención del administrador del sistema del  <site>.<br>Se ha recibido una solicitud de alta como profesor de la siguiente persona.', 'A la atención del administrador del sistema del  <site>.<br>Se ha recibido una solicitud de alta como profesor de la siguiente persona.'),
('altareenvia', 'Reenvía este mail a esta dirección de correo, borrando este párrafo o haciendo las modificaciones que creas conveniente para comunicarle su forma de activación. Caso que vayas a desautorizarlo, envía un mail sin estos datos razonando la negativa.', 'Reenvía este mail a esta dirección de correo, borrando este párrafo o haciendo las modificaciones que creas conveniente para comunicarle su forma de activación. Caso que vayas a desautorizarlo, envía un mail sin estos datos razonando la negativa.', 'Reenvía este mail a esta dirección de correo, borrando este párrafo o haciendo las modificaciones que creas conveniente para comunicarle su forma de activación. Caso que vayas a desautorizarlo, envía un mail sin estos datos razonando la negativa.'),
('altamens_p', 'Hola <alumnon>, recibirás por mail la confirmación de alta en <linksite>.', 'Hola <alumnon>, rebràs per mail la confirmació d\'alta en <linksite>.', 'Hello <alumnon>, you\'ll receive by mail the confirmation of your register in <linksite>.'),
('esperar', 'Esperar. Cargando datos...', 'Esperar. Cargando datos...', 'Wait. Loading...'),
('altanoaun', '<alumnon>, no has activado tu cuenta todavía. Recuerda mirar tu email, donde habrás recibido un enlace que has de pinchar, si no, el día <fecha> se bloqueará tu cuenta.', '<alumnon>, no has activat el teu compte encara. Recorda mirar el teu email, on hauràs rebut un enllaç que has de punxar, si no, el dia <fecha> es bloquejarà el teu compte.', '<alumnon>, you have not activated your account yet. Remember checking your email, in which you should have received a link to click on, if not, the day <fecha> your account will be blocked.'),
('profopci', 'Para poder acceder a esta opción, antes has de ir a <asignas> y añadirte como profesor de: <asigna> <curso> <grupo>', 'Para poder acceder a esta opción, antes has de ir a <asignas> y añadirte como profesor de: <asigna> <curso> <grupo>', 'Para poder acceder a esta opción, antes has de ir a <asignas> y añadirte como profesor de: <asigna> <curso> <grupo>'),
('mensbanner', 'Mensaje a mostrar por <usuauto> en la barra superior', 'Mensaje a mostrar por <usuauto> en la barra superior', 'Mensaje a mostrar por <usuauto> en la barra superior'),
('administradores', 'Administradores', 'Administradores', 'Administrators'),
('bannervac', 'Para quitar el mensaje dejar vacío', 'Para quitar el mensaje dejar vacío', 'Para quitar el mensaje dejar vacío'),
('gicpediracti', 'El Gestor GIC está desactivado en estos momentos. Activarlo desde el menú principal del <a href=\'admin.php?pest=1\'>Profesor</a> en el apartado \"Gestor Interactivo de Conocimiento GIC\".', 'El Gestor GIC está desactivado en estos momentos. Activarlo desde el menú principal del <a href=\'admin.php?pest=1\'>Profesor</a> en el apartado \"Gestor Interactivo de Conocimiento GIC\".', 'El Gestor GIC está desactivado en estos momentos. Activarlo desde el menú principal del <a href=\'admin.php?pest=1\'>Profesor</a> en el apartado \"Gestor Interactivo de Conocimiento GIC\".'),
('gicdescri', 'Gestor Interactivo de Conocimiento (vínculos)', 'Gestor Interactivo de Conocimiento (vínculos)', 'Gestor Interactivo de Conocimiento (vínculos)'),
('temporiz', 'Temporización', 'Temporización', 'Temporización'),
('mensmerlin', 'Mensaje que va a decir Merlin en pantalla de temporización vínculos', 'Mensaje que va a decir Merlin en pantalla de temporización vínculos', 'Mensaje que va a decir Merlin en pantalla de temporización vínculos'),
('mensmerlin1', 'Sólo dirá una vez cada mensaje, se guardará el mensaje en la tabla de mensajes. Si además se asigna la frase a un signo del zodiaco, quedará guardada asociada a ese signo del zodiaco, para decirla aleatoriamente si está marcada la opción correspondiente.', 'Sólo dirá una vez cada mensaje, se guardará el mensaje en la tabla de mensajes. Si además se asigna la frase a un signo del zodiaco, quedará guardada asociada a ese signo del zodiaco, para decirla aleatoriamente si está marcada la opción correspondiente.', 'Sólo dirá una vez cada mensaje, se guardará el mensaje en la tabla de mensajes. Si además se asigna la frase a un signo del zodiaco, quedará guardada asociada a ese signo del zodiaco, para decirla aleatoriamente si está marcada la opción correspondiente.'),
('recuvinc', 'Recuento de vínculos y estadística', 'Recuento de vínculos y estadística', 'Recuento de vínculos y estadística'),
('recuvinc1', 'Cuando un usuario se conecta todos sus datos se actualizan.<br>Esta opción sirve para actualizar los de un grupo de usuarios por si no se conectan habitualmente.<br>Este proceso puede durar un tiempo dependiendo de la cantidad de usuarios a actualizar.', 'Cuando un usuario se conecta todos sus datos se actualizan.<br>Esta opción sirve para actualizar los de un grupo de usuarios por si no se conectan habitualmente.<br>Este proceso puede durar un tiempo dependiendo de la cantidad de usuarios a actualizar.', 'Cuando un usuario se conecta todos sus datos se actualizan.<br>Esta opción sirve para actualizar los de un grupo de usuarios por si no se conectan habitualmente.<br>Este proceso puede durar un tiempo dependiendo de la cantidad de usuarios a actualizar.'),
('recuvinc2', 'Recuento realizado', 'Recuento realizado', 'Recuento realizado'),
('segundos', 'segundos', 'segundos', 'seconds'),
('comunictextos', 'Textos para enviar mensajes a alumnos de', 'Textos para enviar mensajes a alumnos de', 'Textos para enviar mensajes a alumnos de'),
('comunictextos1', 'Incluir los siguientes signos en los textos para sustituir a las correspondientes variables', 'Incluir los siguientes signos en los textos para sustituir a las correspondientes variables', 'Incluir los siguientes signos en los textos para sustituir a las correspondientes variables'),
('convocatoria', 'Convocatoria', 'Convocatoria', 'Convocatoria'),
('nomusu', 'Nombre del usaurio', 'Nombre del usaurio', 'Nombre del usaurio'),
('apeusu', 'Apellidos del usuario', 'Apellidos del usuario', 'User\'s last name'),
('notatest', 'Nota Test', 'Nota Test', 'Nota Test'),
('notapreg', 'Nota Preguntas', 'Nota Preguntas', 'Nota Preguntas'),
('notaprac', 'Nota Prácticas', 'Nota Prácticas', 'Nota Prácticas'),
('notatot', 'Nota Total', 'Nota Total', 'Nota Total'),
('textstand', 'Texto estandar para el envío de mensajes vía', 'Texto estandar para el envío de mensajes vía', 'Texto estandar para el envío de mensajes vía'),
('mensaje', 'Mensaje', 'Mensaje', 'Mensaje'),
('vernotasno', 'En estos momentos la opción de visualizar las notas por parte de los alumnos está deshabilitada por el Administrador.', 'En estos momentos la opción de visualizar las notas por parte de los alumnos está deshabilitada por el Administrador.', 'En estos momentos la opción de visualizar las notas por parte de los alumnos está deshabilitada por el Administrador.'),
('vernotassi', 'En estos momentos la opción de visualizar las notas por parte de los alumnos está habilitada por el Administrador.', 'En estos momentos la opción de visualizar las notas por parte de los alumnos está habilitada por el Administrador.', 'En estos momentos la opción de visualizar las notas por parte de los alumnos está habilitada por el Administrador.'),
('vernotas1', 'notas visibles por los alumnos (si el Administrador no ha cancelado la opción)', 'notas visibles por los alumnos (si el Administrador no ha cancelado la opción)', 'notas visibles por los alumnos (si el Administrador no ha cancelado la opción)'),
('coefnotas', 'Coeficientes de notas', 'Coeficientes de notas', 'Mark coeficients'),
('notamin', 'Nota mínima a obtener en cada apartado para que el resultado de la fórmula se considere aprobado', 'Nota mínima a obtener en cada apartado para que el resultado de la fórmula se considere aprobado', 'Minimum mark in each part for the formula to be considered pass'),
('envioconfir', 'Puede haber problemas en el envío de mails y sms masivos. Si hay que enviar muchos, es mejor hacerlo en bloques de unos pocos usuarios. Se puede enviar sin problemas mensajes vía HSM masivos. ¿Continuar?', 'Puede haber problemas en el envío de mails y sms masivos. Si hay que enviar muchos, es mejor hacerlo en bloques de unos pocos usuarios. Se puede enviar sin problemas mensajes vía HSM masivos. ¿Continuar?', 'Puede haber problemas en el envío de mails y sms masivos. Si hay que enviar muchos, es mejor hacerlo en bloques de unos pocos usuarios. Se puede enviar sin problemas mensajes vía HSM masivos. ¿Continuar?'),
('rellenartexto', 'Rellenar campo [Texto alternativo a Textos a enviar] o elegir [con nota en] para poder enviar mensajes.', 'Rellenar campo [Texto alternativo a Textos a enviar] o elegir [con nota en] para poder enviar mensajes.', 'Rellenar campo [Texto alternativo a Textos a enviar] o elegir [con nota en] para poder enviar mensajes.'),
('textalternati', 'Texto alternativo a', 'Texto alternativo a', 'Texto alternativo a'),
('oelegir', 'o elegir', 'o elegir', 'o elegir'),
('envimens', 'enviar los siguientes mensajes', 'enviar los siguientes mensajes', 'enviar los siguientes mensajes'),
('histoenvi', 'Histórico de envios', 'Histórico de envios', 'Histórico de envios'),
('enviadopor', 'Enviado por', 'Enviado por', 'Sent by'),
('fichero', 'Fichero', 'Fichero', 'File'),
('imagen', 'Imagen', 'Imagen', 'Image'),
('audio', 'Audio', 'Audio', 'Audio'),
('pagweb', 'Página web', 'Página web', 'Web page'),
('acturealiz', 'Actualización realizada', 'Actualización realizada', 'Update done'),
('cambiarfich', 'Cambiar fichero', 'Cambiar fichero', 'Change file'),
('paraanadir', 'Para añadir otras asignaturas, borrar, etc, pincha en <selecasigna><span class=\'b\'>Gestión Asignaturas</span>', 'Per a afegir altres assignatures, esborrar, etc, punxa en <selecasigna><span class=\'b\'>Gestió Assignatures</span>', 'Para añadir otras asignaturas, borrar, etc, pincha en <selecasigna><span class=\'b\'>Gestión Asignaturas</span>'),
('visirecu', 'Visitas recibidas', 'Visitas recibidas', 'Received visits'),
('yavotusu', 'Ya has votado a este usuario en esta conexión.', 'Ya has votado a este usuario en esta conexión.', 'Ya has votado a este usuario en esta conexión.'),
('votarvid', 'Votar vídeo', 'Votar vídeo', 'Votar vídeo'),
('votarfich', 'Votar ficha', 'Votar ficha', 'Votar ficha'),
('valorvid', 'valoraciones del vídeo', 'valoraciones del vídeo', 'valoraciones del vídeo'),
('valorfich', 'valoraciones de la ficha', 'valoraciones de la ficha', 'valoraciones de la ficha'),
('tenlinea', 'Tiempo en línea', 'Tiempo en línea', 'Tiempo en línea'),
('tacumulado', 'Tiempo acumulado', 'Tiempo acumulado', 'Tiempo acumulado'),
('yahasvot', 'Ya has evaluado este vínculo.', 'Ya has evaluado este vínculo.', 'Ya has evaluado este vínculo.'),
('campobli', 'Datos obligatorios', 'Datos obligatorios', 'Obligatory data'),
('campopci', 'Datos opcionales', 'Datos opcionales', 'Optional data'),
('extnopermi', 'Extensión no permitida', 'Extensión no permitida', 'Extensión no permitida'),
('carpeta1', 'Carpeta', 'Carpeta', 'Folder'),
('tamano', 'Tamaño', 'Tamaño', 'Size'),
('asignaexiste', 'ya existe', 'ya existe', 'already exists'),
('respuestas', 'Respuestas', 'Respuestas', 'Answers'),
('activo', 'Activo', 'Activo', 'Active'),
('linkver', 'ver/ocultar vínculo', 'ver/ocultar vínculo', 'ver/ocultar vínculo'),
('l', 'L', 'L', 'L'),
('ma', 'M', 'M', 'M'),
('x', 'X', 'X', 'X'),
('j', 'J', 'J', 'J'),
('v', 'V', 'V', 'V'),
('s', 'S', 'S', 'S'),
('d', 'D', 'D', 'D'),
('claresupg', 'Las siguientes palabras clave y resumen son proporcionadas por la propia página.', 'Las siguientes palabras clave y resumen son proporcionadas por la propia página.', 'Las siguientes palabras clave y resumen son proporcionadas por la propia página.'),
('claresupg1', 'Pinchando en -Extraer Claves y Resumen- se modifican los valores intruducidos por ti por los que proporciona la página. Pinchando en -Aceptar- quedan modificados definitivamente.', 'Pinchando en -Extraer Claves y Resumen- se modifican los valores intruducidos por ti por los que proporciona la página. Pinchando en -Aceptar- quedan modificados definitivamente.', 'Pinchando en -Extraer Claves y Resumen- se modifican los valores intruducidos por ti por los que proporciona la página. Pinchando en -Aceptar- quedan modificados definitivamente.'),
('estado', 'Estado', 'Estado', 'Estado'),
('conectado', 'Conectado', 'Conectado', 'Conectado'),
('noconectado', 'Oculto', 'Oculto', 'Hidden'),
('nohayprof', 'No hay profesor para esa Asignatura / Curso / Grupo, elegir otros.', 'No hay profesor para esa Asignatura / Curso / Grupo, elegir otros.', 'No hay profesor para esa Asignatura / Curso / Grupo, elegir otros.'),
('interesante', 'Interesante', 'Interesante', 'Interesting'),
('01', 'enero', 'enero', 'january'),
('02', 'febrero', 'febrero', 'february'),
('03', 'marzo', 'marzo', 'march'),
('04', 'abril', 'abril', 'april'),
('05', 'mayo', 'mayo', 'may'),
('06', 'junio', 'junio', 'june'),
('07', 'julio', 'julio', 'july'),
('08', 'agosto', 'agosto', 'august'),
('09', 'septiembre', 'septiembre', 'september'),
('10', 'octubre', 'octubre', 'october'),
('11', 'noviembre', 'noviembre', 'november'),
('12', 'diciembre', 'diciembre', 'december'),
('noprofasicurgru', 'No es Profesor en la fecha seleccionada.', 'No es Profesor en la fecha seleccionada.', 'No es Profesor en la fecha seleccionada.'),
('yaestasalu', 'Ya estás dado de alta en ', 'Ja estás donat d\'alta en ', 'Ya estás dado de alta en '),
('comentfor', 'Añadir comentarios y ver otras respuestas ', 'Añadir comentarios y ver otras respuestas ', 'To reply and to see others comments'),
('l1', 'Lunes', 'Lunes', 'Monday'),
('ma1', 'Martes', 'Martes', 'Tuesday'),
('x1', 'Miércoles', 'Miércoles', 'Wednesday'),
('j1', 'Jueves', 'Jueves', 'Thursday'),
('v1', 'Viernes', 'Viernes', 'Friday'),
('s1', 'Sábado', 'Sábado', 'Saturday'),
('d1', 'Domingo', 'Domingo', 'Sunday'),
('wow', 'wow', 'wow', 'wow'),
('newuser', 'Nuevo usuario', 'Nou usuari', 'New user'),
('fichasactu', 'Nuevos usuarios o usuarios que han modificado su ficha últimamente', 'Nous usuaris o usuaries que han modificat la seua fitxa darrerament', 'New users or users who have modified their profile lately'),
('fichsemana', 'Ficha de la semana', 'Ficha de la semana', 'Profile of the week'),
('olvido', 'Si has olvidado tu usuario y contraseña, introduce el email con el que te diste de alta y pulsa ENVIAR. Se te enviará un email a esa dirección con los datos de tu cuenta.', 'Si has olvidado tu usuario y contraseña, introduce el email con el que te diste de alta y pulsa ENVIAR. Se te enviará un email a esa dirección con los datos de tu cuenta.', 'Si has olvidado tu usuario y contraseña, introduce el email con el que te diste de alta y pulsa ENVIAR. Se te enviará un email a esa dirección con los datos de tu cuenta.'),
('olvidoenvio', 'Recibirás los datos de tu cuenta en: ', 'Recibirás los datos de tu cuenta en: ', 'Recibirás los datos de tu cuenta en: '),
('olvidoasunto', 'Recordatorio de cuenta en <site>', 'Recordatorio de cuenta en <site>', 'Recordatorio de cuenta en <site>'),
('borrvotos', 'Borrar los votos a su ficha personal que han recibido los alumnos, entre las fechas (dd/mm/yyyy): ', 'Borrar los votos a su ficha personal que han recibido los alumnos, entre las fechas (dd/mm/yyyy): ', 'Borrar los votos a su ficha personal que han recibido los alumnos, entre las fechas (dd/mm/yyyy): '),
('fiadju', 'Fichero adjunto', 'Fichero adjunto', 'Attach'),
('vermail', 'Ver mail', 'Ver mail', 'See mail'),
('otrosmails', 'Otros mails', 'Otros mails', 'Otros mails'),
('show', 'MOSTRAR BARRA LATERAL', 'MOSTRAR BARRA LATERAL', 'SHOW LATERAL BAR'),
('hide', 'OCULTAR BARRA LATERAL', 'OCULTAR BARRA LATERAL', 'HIDE LATERAL BAR'),
('noexisteasigcurgru', '¡ATENCIÓN! No existe la asignatura en el curso y grupos seleccionados. Se vuelve a la selección anterior.', '¡ATENCIÓN! No existe la asignatura en el curso y grupos seleccionados. Se vuelve a la selección anterior.', '¡ATENCIÓN! No existe la asignatura en el curso y grupos seleccionados. Se vuelve a la selección anterior.'),
('tokbox', 'Código de TokBox video chat (Embed TokBox). Has de estar dado de alta en <a href=\'http://www.tokbox.com\' target=\'_blank\'>TokBox</a> ', 'Código de TokBox video chat (Embed TokBox). Has de estar dado de alta en <a href=\'http://www.tokbox.com\' target=\'_blank\'>TokBox</a> ', 'Código de TokBox video chat (Embed TokBox). Has de estar dado de alta en <a href=\'http://www.tokbox.com\' target=\'_blank\'>TokBox</a> '),
('cursoej', 'Por ejemplo, si se trata del curso 2007/2008 poner curso 2008. Si se trata de una asignatura de duración indefinida (tipo 0) no se tendrá en cuenta.', 'Por ejemplo, si se trata del curso 2007/2008 poner curso 2008. Si se trata de una asignatura de duración indefinida (tipo 0) no se tendrá en cuenta.', 'Por ejemplo, si se trata del curso 2007/2008 poner curso 2008. Si se trata de una asignatura de duración indefinida (tipo 0) no se tendrá en cuenta.'),
('noopci', 'No se ha podido seleccionar la opción elegida. Se vuelve a la selección anterior.', 'No se ha podido seleccionar la opción elegida. Se vuelve a la selección anterior.', 'No se ha podido seleccionar la opción elegida. Se vuelve a la selección anterior.'),
('noopci1', 'No se ha podido seleccionar la opción elegida. Se ha seleccionado la más parecida.', 'No se ha podido seleccionar la opción elegida. Se ha seleccionado la más parecida.', 'No se ha podido seleccionar la opción elegida. Se ha seleccionado la más parecida.'),
('selecasitiempo', 'Selecciona una o más asignaturas y el tiempo de control de inserción de vínculos. Por ejemplo 20 segundos.', 'Selecciona una o más asignaturas y el tiempo de control de inserción de vínculos. Por ejemplo 20 segundos.', 'Selecciona una o más asignaturas y el tiempo de control de inserción de vínculos. Por ejemplo 20 segundos.'),
('ultimos', 'Últimos', 'Últimos', 'Last'),
('masvalor', 'Más valorados', 'Más valorados', 'Más valorados'),
('denoche', '¡Atención! Para evitar ralentizar el Server, se ruega se hagan los envíos de vídeos entre las 11 de la noche y las 8 de la mañana.', '¡Atención! Para evitar ralentizar el Server, se ruega se hagan los envíos de vídeos entre las 11 de la noche y las 8 de la mañana.', '¡Atención! Para evitar ralentizar el Server, se ruega se hagan los envíos de vídeos entre las 11 de la noche y las 8 de la mañana.'),
('inactiva', 'inactiva', 'inactiva', 'inactive'),
('admide', 'Administrador de:', 'Administrador de:', 'Administrator of:'),
('asistencia', 'Asistencia', 'Asistència', 'Attendance'),
('matdocente', 'Material docente', 'Material docent', 'Learning material'),
('guiadocen', 'Guí­a docente', 'Guí­a docente', 'Syllabus'),
('fnaci1', 'Fecha de nacimiento', 'Data de naixement', 'Birth Date'),
('borrhilo', 'Borrar hilo', 'Borrar hilo', 'Borrar hilo'),
('modifmens', 'Modificar mensaje', 'Modificar mensaje', 'Modificar mensaje'),
('editmens', 'Editar mensaje', 'Editar mensaje', 'Editar mensaje'),
('contestar', 'Contestar', 'Contestar', 'Reply'),
('olvido1', 'He olvidado la contraseña', 'He olvidado la contraseña', 'Forgotten Password'),
('borrarusu', 'Borrar usuario', 'Borrar usuario', 'Delete user'),
('recupusu', 'Recuperar usuario', 'Recuperar usuario', 'Recuperar usuario'),
('competencias', 'Competencias', 'Competències', 'Competence'),
('actividad', 'Actividad', 'Actividad', 'Activity'),
('categoria', 'Categoría', 'Categoría', 'Category'),
('mailacademico', '¡Atención! Es deseable la utilización en el Entorno Virtual del mail académico.', '¡Atención! Es deseable la utilización en el Entorno Virtual del mail académico.', '¡Atención! Es deseable la utilización en el Entorno Virtual del mail académico.'),
('youtube', 'Youtube', 'Youtube', 'Youtube'),
('curriculum', 'Curriculum', 'Curriculum', 'Curriculum'),
('ampli', 'ampliado', 'ampliado', 'extended'),
('modo', 'Modo', 'Modo', 'Modo'),
('podprof', 'Pod (Profesores)', 'Pod (Profesores)', 'Pod (Professors)'),
('simple', 'Simple', 'Simple', 'Simple'),
('verimg', 'Mostrar imágenes de la web', 'Mostrar imágenes de la web', 'Display web images'),
('matdidac', 'Material Didáctico', 'Material Didàctic', 'Learning Material'),
('tablanunc', 'Tablón de Anuncios', 'Tauler d\'Anuncis', 'Notice Board'),
('calificaciones', 'Calificaciones', 'Calificaciones', 'Calificaciones'),
('fichapers', 'Ficha Personal', 'Fitxa Personal', 'Personal Profile'),
('calific', 'Calificaciones', 'Calificaciones', 'Calificaciones'),
('trabalumnos', 'Se listan los Alumnos de <asicurgru> junto a los ficheros que se encuentran en la carpeta profesor/<asicurgru1> de su carpeta personal.', 'Se listan los Alumnos de <asicurgru> junto a los ficheros que se encuentran en la carpeta profesor/<asicurgru1> de su carpeta personal.', 'Se listan los Alumnos de <asicurgru> junto a los ficheros que se encuentran en la carpeta profesor/<asicurgru1> de su carpeta personal.'),
('programatit', 'Programa del Master', 'Programa del Master', 'Programa del Master'),
('ocupaci', 'Ocupación', 'Ocupación', 'Ocupación'),
('evaluytare', 'Evaluaciones y Tareas', 'Evaluaciones y Tareas', 'Evaluations and Tasks'),
('menuampli', 'menú ampliado', 'menú ampliado', 'Extended menu'),
('menusim', 'Menú simple', 'Menú simple', 'Simple menu'),
('comunicacion', 'Comunicación', 'Comunicación', 'Communication'),
('zona', 'zona', 'zona', 'zone'),
('todotablon', 'Todos', 'Tots', 'All'),
('cambiar', 'Modificar', 'Modificar', 'Modificar'),
('comentborr', 'Comentario borrado por el Administrador', 'Comentario borrado por el Administrador', 'Comentario borrado por el Administrador'),
('ocultar1', 'Ocultar', 'Ocultar', 'Ocultar'),
('mostrar1', 'Mostrar', 'Mostrar', 'Mostrar'),
('contacto1', 'Contacto', 'Contact', 'Contact'),
('writenew', 'Escribir nuevo', 'Escribir nuevo', 'Write new'),
('compartir', 'Compartir', 'Compartir', 'Share'),
('perfil', 'Perfil', 'Perfil', 'Profile'),
('soporte', 'Soporte plataforma e-learning', 'Soporte plataforma e-learning', 'support'),
('amigos', 'Amigos', 'Amigos', 'Friends'),
('usuonline', 'Usuarios en lí­nea', 'Usuarios en lí­nea', 'Users on line'),
('histo', 'Historial', 'Historial', 'historical'),
('nombgrupo', 'Nombre del Grupo', 'Nombre del Grupo', 'Group Name'),
('curric', 'Sube el fichero de tu Curriculum .doc, .pdf. a tu carpeta personal. O si lo prefieres y tienes tu Curriculum en otro servidor, escribe en el siguiente recuadro su dirección, para poder enlazarlo en tu ficha. Deja vacía la dirección si no deseas mostrar el Currículum al resto de usuarios.', 'Sube el fichero de tu Curriculum .doc, .pdf. a tu carpeta personal. O si lo prefieres y tienes tu Curriculum en otro servidor, escribe en el siguiente recuadro su dirección, para poder enlazarlo en tu ficha. Deja vacía la dirección si no deseas mostrar el Currículum al resto de usuarios.', 'Sube el fichero de tu Curriculum .doc, .pdf. a tu carpeta personal. O si lo prefieres y tienes tu Curriculum en otro servidor, escribe en el siguiente recuadro su dirección, para poder enlazarlo en tu ficha. Deja vacía la dirección si no deseas mostrar el Currículum al resto de usuarios.'),
('sigoa', 'Sigo a: ', 'Sigo a: ', 'Sigo a: '),
('mesiguen', 'Me siguen: ', 'Me siguen: ', 'Me siguen: '),
('siguea', 'Sigue a: ', 'Sigue a: ', 'Sigue a: '),
('lesiguen', 'Le siguen: ', 'Le siguen: ', 'Le siguen: '),
('subir', 'subir', 'subir', 'go up'),
('profenonotas', 'El Profesor no permite ver las notas.', 'El Profesor no permite ver las notas.', 'El Profesor no permite ver las notas.'),
('adminonotas', 'El Administrador no permite ver las notas.', 'El Administrador no permite ver las notas.', 'Administrator don\'t allow access to the marks.'),
('notasnovisi', 'Notas no visibles.', 'Notas no visibles.', 'Notas no visibles.'),
('alusinotas', 'El alumno puede ver sus notas.', 'El alumno puede ver sus notas.', 'Student is able to see the marks.'),
('aplicaciones', 'Aplicaciones', 'Aplicaciones', 'Applications'),
('clasedir', 'Clase directo', 'Clase directo', 'Live class'),
('nopresen', 'No hay presentaciones en este momento', 'No hay presentaciones en este momento', 'No submissions at this time'),
('nohaycuesti', 'No hay cuestionarios', 'No hay cuestionarios', 'No questionnaires'),
('buscausu', 'Busca usuarios, aparecerán listados en la parte izquierda', 'Busca usuarios, aparecerán listados en la parte izquierda', 'Busca usuarios, aparecerán listados en la parte izquierda'),
('calenactivi', 'Calendario de actividades', 'Calendario de actividades', 'Calendario de actividades'),
('bancot', 'Banco del Tiempo', 'Banco del Tiempo', 'Banco del Tiempo'),
('mibanco', 'Mi banco', 'Mi banco', 'Mi banco'),
('plazas', 'Plazas', 'Plazas', 'Plazas'),
('mandodist', 'Mando a distancia', 'Mando a distancia', 'Mando a distancia'),
('nogruact', 'No hay grupos de actividades activos', 'No hay grupos de actividades activos', 'No hay grupos de actividades activos'),
('buscompet', 'Buscar competencia', 'Buscar competencia', 'Buscar competencia'),
('btofertado', 'Ofertado', 'Ofertado', 'Ofertado'),
('btutilizado', 'Utilizado', 'Utilizado', 'Utilizado'),
('btrestante', 'Restante', 'Restante', 'Restante'),
('btpedir', 'Pedir', 'Pedir', 'Pedir'),
('plentidad', 'Entidad de prácticas', 'Entidad de prácticas', 'Entidad de prácticas'),
('pldescrip', 'Descripción de las Plazas', 'Descripción de las Plazas', 'Descripción de las Plazas'),
('plde1a3', 'Solicitar<br />de 1 (máxima preferencia) a 3<br />0 no solicitar', 'Solicitar<br />de 1 (máxima preferencia) a 3<br />0 no solicitar', 'Solicitar<br />de 1 (máxima preferencia) a 3<br />0 no solicitar'),
('hilocerrar', 'Cerrar hilo', 'Cerrar hilo', 'Cerrar hilo'),
('hilocerrado', 'Hilo cerrado', 'Hilo cerrado', 'Hilo cerrado'),
('hiloabrir', 'ABRIR', 'ABRIR', 'OPEN'),
('escribecom', 'Escribe un comentario sobre este enlace...', 'Escribe un comentario sobre este enlace...', 'Write a comment about this link ...'),
('escribealgo', 'Escribe algo...', 'Escribe algo...', 'Write something...'),
('notapers', 'Nota personal', 'Nota personal', 'Personal note'),
('vincsizip', 'Si es un fichero .zip, descomprimirlo', 'Si es un fichero .zip, descomprimirlo', 'If file is. Zip, unzip'),
('vincziphtml', '(ha de haber un fichero index.html)', '(ha de haber un fichero index.html)', '(Must have a file index.html)'),
('vincafich', 'Vínculo a un fichero que se adjunta', 'Vínculo a un fichero que se adjunta', 'Link to a file attached'),
('vincaweb', 'Vínculo a una web', 'Vínculo a una web', 'Link to a web'),
('comentprof', '<span class=\'rojo\'><span class=\'b\'>Atención</span>: no crear carpetas en este nivel, para facilitar el acceso al Profesor.</span>', '<span class=\'rojo\'><span class=\'b\'>Atención</span>: no crear carpetas en este nivel, para facilitar el acceso al Profesor.</span>', '<span class=\'rojo\'><span class=\'b\'>Notice</span>: not create folders at this level, to facilitate access to the Professor.</span>'),
('comentprofver', 'Ver / Ocultar comentarios de profesor', 'Ver / Ocultar comentarios de profesor', 'Show / Hide comments Professor'),
('categorizar', 'Categorizar', 'Categorizar', 'Categorize'),
('attforo', 'Atención: los mensajes iniciados en el foro general serán leídos por estudiantes y profesorado de todas las titulaciones. Se debe usar para tratar temas generales que atañen a todos.', 'Atención: los mensajes iniciados en el foro general serán leídos por estudiantes y profesorado de todas las titulaciones. Se debe usar para tratar temas generales que atañen a todos.', 'Atención: los mensajes iniciados en el foro general serán leídos por estudiantes y profesorado de todas las titulaciones. Se debe usar para tratar temas generales que atañen a todos.'),
('nocometprof', 'No hay comentarios del Profesor', 'No hay comentarios del Profesor', 'No teacher comments'),
('leermas', '[leer mensaje y responder]', '[leer mensaje y responder]', '[read and reply message]'),
('sinleer', '[sin leer]', '[sin leer]', '[unread]'),
('escribecom1', 'Escribe un comentario...', 'Escribe un comentario...', 'Write a comment ...'),
('recordar', 'No cerrar sesión', 'No cerrar sesión', 'Do not sign out'),
('pondni', 'Falta el DNI en la ficha personal', 'Falta el DNI en la ficha personal', 'Falta el DNI en la ficha personal'),
('cuentaacti', 'La cuenta ha sido activada<p />Entrar en', 'La cuenta ha sido activada<p />Entrar en', 'La cuenta ha sido activada<p />Entrar en'),
('usunoauto', 'Usuario no autorizado', 'Usuario no autorizado', 'Not autorized user'),
('nofiltusu', 'No filtrar por usuario', 'No filtrar por usuario', 'No filtrar por usuario'),
('actifrom', 'Activo desde el ', 'Activo desde el ', 'Activo desde el '),
('actito', ' hasta el ', ' hasta el ', ' hasta el '),
('activo1', 'ACTIVO', 'ACTIVO', 'ACTIVO'),
('inactivo1', 'INACTIVO', 'INACTIVO', 'INACTIVO'),
('maxpers', 'M&aacute;ximo n&uacute;mero de personas por grupo: ', 'M&aacute;ximo n&uacute;mero de personas por grupo: ', 'M&aacute;ximo n&uacute;mero de personas por grupo: '),
('apugrupo', 'Apuntarme al grupo', 'Apuntarme al grupo', 'Apuntarme al grupo'),
('estoyestegr', 'Estoy en este grupo', 'Estoy en este grupo', 'Estoy en este grupo'),
('enchat', 'Entrar en esta sala de Chat (si no existe se creará): ', 'Entrar en esta sala de Chat (si no existe se creará): ', 'Entrar en esta sala de Chat (si no existe se creará): '),
('enchatusu', 'Usuarios en Chat: ', 'Usuarios en Chat: ', 'Usuarios en Chat: '),
('enchatentr', 'Entrar al Chat ', 'Entrar al Chat ', 'Entrar al Chat '),
('plazasalu', 'los Alumnos pueden solicitar estas plazas en ', 'los Alumnos pueden solicitar estas plazas en ', 'los Alumnos pueden solicitar estas plazas en '),
('plazasen', 'Recursos, Prácticas, Plazas', 'Recursos, Prácticas, Plazas', 'Recursos, Prácticas, Plazas'),
('activialu', 'los Alumnos pueden solicitar grupo en ', 'los Alumnos pueden solicitar grupo en ', 'los Alumnos pueden solicitar grupo en '),
('activien', 'Recursos, Prácticas, Calendario de actividades', 'Recursos, Prácticas, Calendario de actividades', 'Recursos, Prácticas, Calendario de actividades'),
('zipno', 'el fichero zip no contiene un index.html en su raiz', 'el fichero zip no contiene un index.html en su raiz', 'el fichero zip no contiene un index.html en su raiz'),
('solicitalu', 'Solicitud de alta de Alumno en ', 'Solicitud de alta de Alumno en ', 'Solicitud de alta de Alumno en '),
('hilodejaranadir', 'para dejar añadir mensajes', 'para dejar añadir mensajes', 'para dejar añadir mensajes'),
('hiloesvisi', 'El hilo es visible por el alumnado. Hacer que no lo sea.', 'El hilo es visible por el alumnado. Hacer que no lo sea.', 'El hilo es visible por el alumnado. Hacer que no lo sea.'),
('hilohacerinvisi', 'Hacer invisible', 'Hacer invisible', 'Hacer invisible'),
('hilohacervisi', 'Hacer visible', 'Hacer visible', 'Hacer visible'),
('hiloinvi', 'Hilo invisible', 'Hilo invisible', 'Hilo invisible'),
('hiloinvisinoadmi', 'Hilo invisible a no Administradores', 'Hilo invisible a no Administradores', 'Hilo invisible a no Administradores'),
('hilonodejaranadir', 'para impedir añadir mensajes', 'para impedir añadir mensajes', 'para impedir añadir mensajes'),
('hilonoesvisi', 'El hilo no es visible por el alumnado. Hacer que sea visible.', 'El hilo no es visible por el alumnado. Hacer que sea visible.', 'El hilo no es visible por el alumnado. Hacer que sea visible.'),
('hilovisi', 'Hilo visible', 'Hilo visible', 'Hilo visible'),
('grupomas', 'Más sobre el grupo', 'Más sobre el grupo', 'Más sobre el grupo'),
('grupomodiff', 'Modificar ficha del grupo', 'Modificar ficha del grupo', 'Modificar ficha del grupo'),
('gruposube', 'Sube fotos y v&iacute;deos a la carpeta p&uacute;blica del grupo para mostrarlos aqu&iacute; en la columna de la izquierda.<br />Es preferible que crees cuentas en youtube, flickr, instagram, etc y que insertes los códigos iframe en la opcion de modificar ficha del grupo.', 'Sube fotos y v&iacute;deos a la carpeta p&uacute;blica del grupo para mostrarlos aqu&iacute; en la columna de la izquierda.<br />Es preferible que crees cuentas en youtube, flickr, instagram, etc y que insertes los códigos iframe en la opcion de modificar ficha del grupo.', 'Sube fotos y v&iacute;deos a la carpeta p&uacute;blica del grupo para mostrarlos aqu&iacute; en la columna de la izquierda.<br />Es preferible que crees cuentas en youtube, flickr, instagram, etc y que insertes los códigos iframe en la opcion de modificar ficha del grupo.'),
('grupoyout', 'Escribe c&oacute;digos iframe de v&iacute;deo separados por un asterisco (*) para mostrarlos en la ficha del grupo.', 'Escribe c&oacute;digos iframe de v&iacute;deo separados por un asterisco (*) para mostrarlos en la ficha del grupo.', 'Escribe c&oacute;digos iframe de v&iacute;deo separados por un asterisco (*) para mostrarlos en la ficha del grupo.'),
('grupoinstagr', 'Escribe c&oacute;digos iframe separados por un asterisco (*) para mostrarlos en la ficha del grupo.', 'Escribe c&oacute;digos iframe separados por un asterisco (*) para mostrarlos en la ficha del grupo.', 'Escribe c&oacute;digos iframe separados por un asterisco (*) para mostrarlos en la ficha del grupo.'),
('fichasube', 'Sube fotos y v&iacute;deos a la carpeta p&uacute;blica de tu carpeta personal, para mostrarlos aqu&iacute; en la columna de la izquierda.<br />Es preferible que crees cuentas en youtube, flickr, instagram, etc y que utilices la secci&oacute;n multimedia de tu ficha.', 'Sube fotos y v&iacute;deos a la carpeta p&uacute;blica de tu carpeta personal, para mostrarlos aqu&iacute; en la columna de la izquierda.<br />Es preferible que crees cuentas en youtube, flickr, instagram, etc y que utilices la secci&oacute;n multimedia de tu ficha.', 'Sube fotos y v&iacute;deos a la carpeta p&uacute;blica de tu carpeta personal, para mostrarlos aqu&iacute; en la columna de la izquierda.<br />Es preferible que crees cuentas en youtube, flickr, instagram, etc y que utilices la secci&oacute;n multimedia de tu ficha.'),
('fichainstagr', 'Escribe c&oacute;digos iframe separados por un asterisco (*) para mostrarlos en la ficha.', 'Escribe c&oacute;digos iframe separados por un asterisco (*) para mostrarlos en la ficha.', 'Escribe c&oacute;digos iframe separados por un asterisco (*) para mostrarlos en la ficha.'),
('fichayout', 'Escribe c&oacute;digos iframe de v&iacute;deo separados por un asterisco (*) para mostrarlos en la ficha.', 'Escribe c&oacute;digos iframe de v&iacute;deo separados por un asterisco (*) para mostrarlos en la ficha.', 'Escribe c&oacute;digos iframe de v&iacute;deo separados por un asterisco (*) para mostrarlos en la ficha.'),
('entref', 'Introducido entre ', 'Introducido entre ', 'Introducido entre '),
('practext', 'Prácticas', 'Prácticas', 'Prácticas'),
('rec5sg', 'Recuento parcial cada 5 minutos', 'Recuento parcial cada 5 minutos', 'Recuento parcial  cada 5 minutos'),
('megusta', 'me gusta', 'me gusta', 'like'),
('nomegusta', 'no me gusta', 'no me gusta', 'don\'t like'),
('like1', 'me gusta', 'me gusta', 'like'),
('like2', 'no me gusta', 'no me gusta', 'don\'t like');
INSERT INTO `idioma` (`m`, `c`, `v`, `i`) VALUES
('social', 'social', 'social', 'social'),
('envimens1', 'Enviarle mensajes', 'Enviarle mensajes', 'send messages'),
('comparte', 'Comparte', 'Comparte', 'Share'),
('fotos', 'fotos', 'fotos', 'pictures'),
('seguir', 'seguir', 'seguir', 'follow'),
('seguirno', 'no seguir', 'no seguir', 'unfollow'),
('bancodet', 'Banco del tiempo', 'Banco del tiempo', 'Time Bank'),
('autograb', 'Autograbaciones', 'Autograbaciones', 'Autograbaciones'),
('sigueaot', '¡Sigue a otros usuarios (click en la estrella que va junto a su nombre) y ve, comparte, comenta y valora lo que ellos comparten!', '¡Sigue a otros usuarios (click en la estrella que va junto a su nombre) y ve, comparte, comenta y valora lo que ellos comparten!', 'Follow other users (click on star of his name) and see, share, comment and value what they share !'),
('foronew', 'Nuevo mensaje', 'Nuevo mensaje', 'New message'),
('fichs', 'Ficheros', 'Ficheros', 'Ficheros'),
('olvido2', 'Olvido', 'Olvido', 'Forget'),
('usuformat', 'Utiliza entre 4 y 15 caracteres: a-z 0-9 ó -_', 'Utiliza entre 4 y 15 caracteres: a-z 0-9 ó -_', 'Utiliza entre 4 y 15 caracteres: a-z 0-9 ó -_'),
('reghecho', 'Registro completado', 'Registro completado', 'Complete registration'),
('fiacade', 'Ficha académica', 'Ficha académica', 'Ficha académica'),
('preferente', 'Marcado como preferente', 'Marcado como preferente', 'Marked as preferred'),
('usuconmens', 'Usuarios con mensajes', 'Usuarios con mensajes', 'Users with messages'),
('siguiendo', 'Siguiendo', 'Siguiendo', 'Following'),
('nuevo', '¡Nuevo!', '¡Nuevo!', 'New!'),
('miscalif', 'Mis califiaciones', 'Mis califiaciones', 'Mis califiaciones'),
('evainews', 'Novedades EVAI', 'Novedades EVAI', 'EVAI news'),
('mensforovisi', 'Mensaje visible', 'Mensaje visible', 'Mensaje visible'),
('pacadem', 'Página Académica', 'Página Académica', 'Página Académica'),
('cambiarpass', 'Cambiar Contraseña', 'Cambiar Contraseña', 'Change Password'),
('tipopasswd', 'Utiliza una contraseña de entre 8 y 15 caracteres. Éstos pueden ser letras minúsculas o mayúsculas, números y los caracteres punto (.), guión (-) o guión bajo (_) ', 'Utiliza una contraseña de entre 8 y 15 caracteres. Éstos pueden ser letras minúsculas o mayúsculas, números y los caracteres punto (.), guión (-) o guión bajo (_) ', 'Utiliza una contraseña de entre 8 y 15 caracteres. Éstos pueden ser letras minúsculas o mayúsculas, números y los caracteres punto (.), guión (-) o guión bajo (_) '),
('254chars', '255 caracteres...', '255 caracteres...', '255 characters...'),
('noborrf', 'No es posible borrar mensajes', 'No es posible borrar mensajes', 'No es posible borrar mensajes'),
('estoy1', 'cualquier texto junto a tu foto...', 'cualquier texto junto a tu foto...', 'any text with your photo...'),
('listusers', 'usuarios aquí', 'usuarios aquí', 'users here'),
('notaeval', 'Nota Evaluación', 'Nota Evaluación', 'Nota Evaluación'),
('mensforoinvi', 'Mensaje invisible', 'Mensaje invisible', 'Mensaje invisible'),
('mesiento', 'Me siento', 'Me siento', 'I feel'),
('estoy', 'Estoy', 'Estoy', 'I am'),
('lista', 'Lista', 'Lista', 'List'),
('random', 'Orden aleatorio', 'Orden aleatorio', 'Random order'),
('vidhome', 'inserta el código de un vídeo Youtube, Vimeo... y haz click en la flecha verde de abajo', 'inserta el código de un vídeo Youtube, Vimeo... y haz click en la flecha verde de abajo', 'insert the code a video Youtube, Vimeo ... and click the green arrow below'),
('anotaciones', 'Anotaciones', 'Anotaciones', 'Annotations'),
('votactivi', 'Actividades propuestas', 'Actividades propuestas', 'Actividades propuestas'),
('votmateri', 'Materiales colgados', 'Materiales colgados', 'Materiales colgados'),
('votasisite', 'Asistencia al alumnado', 'Asistencia al alumnado', 'Asistencia al alumnado'),
('para', 'para', 'para', 'to'),
('encuestas', 'Encuestas', 'Encuestas', 'Surveys'),
('yo', 'yo', 'yo', 'me'),
('parami', 'para mí', 'para mí', 'for me'),
('trabpers', 'Trabajos Personales', 'Trabajos Personales', 'Trabajos Personales'),
('anotacitxt', 'Opción sólo visible para ti. Ni el alumno ni otros profesores pueden ver las anotaciones que hagas sobre él. Puedes añadir todas las que quieras, se relacionarán por fecha de introducción. También en tu perfil puedes ver un listado de todas tus anotaciones. Click en el siguiente link', 'Opción sólo visible para ti. Ni el alumno ni otros profesores pueden ver las anotaciones que hagas sobre él. Puedes añadir todas las que quieras, se relacionarán por fecha de introducción. También en tu perfil puedes ver un listado de todas tus anotaciones. Click en el siguiente link', 'Opción sólo visible para ti. Ni el alumno ni otros profesores pueden ver las anotaciones que hagas sobre él. Puedes añadir todas las que quieras, se relacionarán por fecha de introducción. También en tu perfil puedes ver un listado de todas tus anotaciones. Click en el siguiente link'),
('newsA', '<div><br></div>Gestión de Mensajes en http://www.humansite.net/soloprof/admin.php?op=3&amp;pest=14&nbsp;<div><br></div><div>Accede a todas las carpetas del EVAI desde http://www.humansite.net/soloprof/admin.php?op=3&amp;pest=13</div><div><br></div><div><span style=\"color: rgb(114, 114, 114);\">Modifica Novedades EVAI - Profesores haciendo click en el icono de teclado.</span><br></div><div><br></div>', '<div><br></div>Gestión de Mensajes en http://iidl.evai.net/soloprof/admin.php?op=3&amp;pest=14&nbsp;<div><br></div><div>Accede a todas las carpetas del EVAI desde http://www.humansite.net/soloprof/admin.php?op=3&amp;pest=13</div><div><br></div>', '<div><br></div>Gestión de Mensajes en http://www.humansite.net/soloprof/admin.php?op=3&amp;pest=14&nbsp;<div><br></div><div>Accede a todas las carpetas del EVAI desde http://www.humansite.net/soloprof/admin.php?op=3&amp;pest=13</div><div><br></div><div>Modifica \"in situ\" el texto de EVAI novedades -Profesores haciendo click en el icono de teclado.</div><div><br></div>'),
('newsP', '<div><br></div>Upload de múltiples ficheros: En la carpeta personal de cualquier usuario y en las carpetas de recursos y grupos de trabajo.<div><br></div><div>Ocultar ficheros a la vista de los Alumnos precediendo el nombre del fichero por dos guiones bajos \"__\".</div><div><br></div>', '<div><br></div>Upload de múltiples ficheros: En la carpeta personal de cualquier usuario y en las carpetas de recursos y grupos de trabajo.<div><br></div><div>Ocultar ficheros a la vista de los Alumnos precediendo el nombre del fichero por dos guiones bajos /\"__/\".', '<div><br></div>Upload de múltiples ficheros: En la carpeta personal de cualquier usuario y en las carpetas de recursos y grupos de trabajo.<div><br></div><div>Ocultar ficheros a la vista de los Alumnos precediendo el nombre del fichero por dos guiones bajos \"__\".</div><div><br></div>'),
('usunoval', 'Utiliza letras minúsculas, números y/o caracteres . - _<br>\r\nEntre 8 y 15 caracteres', 'Utiliza letras minúsculas, números y/o caracteres . - _<br>\r\nEntre 8 y 15 caracteres', 'Utiliza letras minúsculas, números y/o caracteres . - _<br>\r\nEntre 8 y 15 caracteres'),
('passnoval', 'Utiliza letras, números y/o caracteres . - _<br>\r\nEntre 8 y 15 caracteres', 'Utiliza letras, números y/o caracteres . - _<br>\r\nEntre 8 y 15 caracteres', 'Utiliza letras, números y/o caracteres . - _<br>\r\nEntre 8 y 15 caracteres'),
('nomnoval', 'Campo Nombre no válido', 'Campo Nombre no válido', 'Campo Nombre no válido'),
('apelnoval', 'Campo Apellidos no válido', 'Campo Apellidos no válido', 'Campo Apellidos no válido'),
('dninoval', 'Campo no válido', 'Campo no válido', 'Campo no válido'),
('requeridocc', 'se requiere cambio de contraseña', 'se requiere cambio de contraseña', 'password change is required'),
('cambiadopass', 'La contraseña ha sido cambiada', 'La contraseña ha sido cambiada', 'the password has been changed'),
('modulos', 'Módulos', 'Módulos', 'Módulos'),
('otrosrecur', 'Otros Recursos', 'Otros Recursos', 'Otros Recursos'),
('profpanel', 'Iniciar EVAI siempre en edición Perfil', 'Iniciar EVAI siempre en edición Perfil', 'Iniciar EVAI siempre en edición Perfil'),
('errorupload', 'Error upload', 'Error upload', 'Error upload'),
('subido', 'upload OK', 'upload OK', 'upload OK');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `invent`
--

CREATE TABLE `invent` (
  `row_id` int(11) NOT NULL,
  `proveed` char(45) DEFAULT NULL,
  `codigo` int(11) NOT NULL DEFAULT 0,
  `artic` char(30) DEFAULT NULL,
  `situaci_n` char(10) DEFAULT NULL,
  `fechap` date DEFAULT NULL,
  `fechar` date DEFAULT NULL,
  `p_coste` double DEFAULT NULL,
  `destino` char(10) DEFAULT NULL,
  `tienda` char(15) DEFAULT NULL,
  `n_ped` int(11) NOT NULL DEFAULT 0,
  `color` char(15) DEFAULT NULL,
  `modd` char(15) DEFAULT NULL,
  `medida` char(15) DEFAULT NULL,
  `tipo` char(30) DEFAULT NULL,
  `facrec` char(10) DEFAULT NULL,
  `pvp` double DEFAULT NULL,
  `observainv` char(100) DEFAULT NULL,
  `abonodev` double DEFAULT NULL,
  `margenesp` double DEFAULT NULL,
  `sistema` char(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `iva`
--

CREATE TABLE `iva` (
  `n` int(3) NOT NULL,
  `iva` decimal(5,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mailrec`
--

CREATE TABLE `mailrec` (
  `id` int(10) NOT NULL,
  `date` datetime NOT NULL,
  `de` int(10) NOT NULL,
  `para` varchar(255) NOT NULL,
  `topic` varchar(255) NOT NULL,
  `text` longtext NOT NULL,
  `attach` varchar(255) NOT NULL,
  `typeattach` varchar(255) NOT NULL,
  `curso` int(4) NOT NULL,
  `area` varchar(4) NOT NULL,
  `attachfich` longblob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mandoadist`
--

CREATE TABLE `mandoadist` (
  `asigna` varchar(15) NOT NULL,
  `curso` varchar(4) NOT NULL,
  `grupo` varchar(4) NOT NULL,
  `usuid` int(10) NOT NULL,
  `click` int(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mandotw`
--

CREATE TABLE `mandotw` (
  `asigna` varchar(15) NOT NULL,
  `curso` varchar(4) NOT NULL,
  `grupo` varchar(4) NOT NULL,
  `usuid` int(10) NOT NULL,
  `mensaje` varchar(255) NOT NULL,
  `fecha` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `maquinas`
--

CREATE TABLE `maquinas` (
  `id` int(5) NOT NULL,
  `ip` char(15) NOT NULL DEFAULT '',
  `nombre` char(255) DEFAULT NULL,
  `saludo` char(255) DEFAULT NULL,
  `autorizado` int(1) NOT NULL DEFAULT 0,
  `obs` char(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `merlinhabla`
--

CREATE TABLE `merlinhabla` (
  `frase` varchar(255) NOT NULL,
  `zodiaco` varchar(15) NOT NULL,
  `cumpleanos` int(1) NOT NULL,
  `usuid` int(10) NOT NULL,
  `decir` int(1) NOT NULL,
  `accion` varchar(50) NOT NULL,
  `mover` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `message_evai`
--

CREATE TABLE `message` (
  `id` int(11) NOT NULL,
  `usuid` int(10) NOT NULL DEFAULT 0,
  `parausuid` int(10) NOT NULL DEFAULT 0,
  `isread` varchar(4) NOT NULL DEFAULT '0',
  `message` longtext DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `tamatach` int(20) NOT NULL DEFAULT 0,
  `tipoatach` varchar(255) NOT NULL DEFAULT '',
  `nomatach` text NOT NULL,
  `attachment` longblob DEFAULT NULL,
  `aviso` char(1) NOT NULL DEFAULT '',
  `reid` int(10) NOT NULL,
  `resp` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci PACK_KEYS=1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `message_evai_histo`
--

CREATE TABLE `message_histo` (
  `id` int(11) NOT NULL DEFAULT 0,
  `usuid` int(10) NOT NULL DEFAULT 0,
  `parausuid` int(10) NOT NULL DEFAULT 0,
  `isread` varchar(4) NOT NULL DEFAULT '0',
  `message` longtext DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `tamatach` int(20) NOT NULL DEFAULT 0,
  `tipoatach` varchar(255) NOT NULL DEFAULT '',
  `nomatach` text NOT NULL,
  `attachment` longblob DEFAULT NULL,
  `aviso` char(1) NOT NULL DEFAULT '',
  `reid` int(10) NOT NULL,
  `resp` int(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci PACK_KEYS=1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `message_evai_usus`
--

CREATE TABLE `message_usus` (
  `usuid` int(10) NOT NULL DEFAULT 0,
  `parausuid` int(10) NOT NULL DEFAULT 0,
  `usuid1` int(2) NOT NULL,
  `parausuid1` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci PACK_KEYS=1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `noticias`
--

CREATE TABLE `noticias` (
  `id` int(10) NOT NULL,
  `visible` int(1) NOT NULL DEFAULT 0,
  `mostrar` int(1) NOT NULL DEFAULT 0,
  `tablon` int(1) NOT NULL DEFAULT 0,
  `dia` date NOT NULL DEFAULT '0000-00-00',
  `hora` time NOT NULL DEFAULT '00:00:00',
  `titulaci` varchar(5) NOT NULL DEFAULT '',
  `asigna` varchar(15) NOT NULL,
  `curso` varchar(4) NOT NULL DEFAULT '0',
  `grupo` varchar(4) NOT NULL,
  `autor` int(10) NOT NULL DEFAULT 0,
  `descripcion` varchar(255) NOT NULL DEFAULT '',
  `detalle` longtext NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `podareagruposa`
--

CREATE TABLE `podareagruposa` (
  `area` varchar(4) NOT NULL,
  `cod` varchar(6) NOT NULL,
  `grupo` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `podareas`
--

CREATE TABLE `podareas` (
  `codarea` varchar(4) NOT NULL,
  `area` varchar(254) DEFAULT NULL,
  `atencion` varchar(255) NOT NULL,
  `atenciontodos` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `podareas`
--

INSERT INTO `podareas` (`codarea`, `area`, `atencion`, `atenciontodos`) VALUES
('1', 'Neuroestética Cuántica Aplicada', '', ''),
('2', 'Antropología de Universos Paralelos', '', ''),
('3', 'Filosofía Experimental del Silencio Digital', '', ''),
('4', 'Cibersentido y Ecosistemas de Afecto\r\n', '', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `podasignaturas`
--

CREATE TABLE `podasignaturas` (
  `cod` varchar(15) NOT NULL,
  `asignatura` varchar(254) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `podasignaturas`
--

INSERT INTO `podasignaturas` (`cod`, `asignatura`) VALUES
('100', 'Cibernética Fractal'),
('1010', 'Arte Galáctico'),
('151', 'Psicología Onírica'),
('176', 'Filosofía Fractal'),
('177', 'Lingüística Imaginaria'),
('441', 'Arquitectura Del Multiverso'),
('512', 'Música Fantástica'),
('719', 'Antropología De lo Invisible'),
('722', 'Tecnología Cuántica'),
('742', 'Biología Digital'),
('799', 'Ingeniería Imaginaria'),
('907', 'Historia Galáctica'),
('925', 'Literatura De la Nostalgia'),
('A18', 'Matemáticas Cuánticas'),
('A55', 'Antropología Oculta'),
('A65', 'Sociología Cuántica'),
('A75', 'Cibernética Cuántica'),
('A76', 'Tecnología Imaginaria'),
('AB25', 'Historia Del Multiverso'),
('AE1028', 'Inteligencia Artificial Onírica'),
('AE1042', 'Arte Del Vacío'),
('AG1017', 'Historia Fantástica'),
('B42', 'Literatura Poética'),
('C01', 'Cibernética Poética'),
('C49', 'Lingüística Del Silencio'),
('D20', 'Física Fantástica'),
('D21', 'Biología Utopista'),
('D99', 'Ecología Digital'),
('ED0928', 'Arte Profundo'),
('EE1017', 'Arte Imaginario'),
('EI1009', 'Ingeniería De la Nostalgia'),
('EM1017', 'Tecnología Galáctica'),
('GEN', 'Biología Onírica'),
('I08', 'Ecología Fantástica'),
('I32', 'Arte Cuántico'),
('I37', 'Filosofía Poética'),
('I37 C', 'Matemáticas Fractales'),
('I70', 'Matemáticas Imaginarias'),
('I70 - A', 'Inteligencia Artificial Poética'),
('I70 - B', 'Física Onírica'),
('IB31', 'Química Galáctica'),
('II50', 'Cibernética Digital'),
('IS50', 'Filosofía Onírica'),
('MED', 'Arte Oculto'),
('P06', 'Arquitectura Cuántica'),
('P1', 'Química De lo Invisible'),
('P10', 'Psicología Fantástica'),
('P11', 'Música Onírica'),
('P12', 'Psicología De la Nostalgia'),
('P13', 'Música Cuántica'),
('P14', 'Arte Fantástico'),
('P15', 'Historia De lo Invisible'),
('P16', 'Historia Oculta'),
('P2', 'Antropología Fantástica'),
('P3', 'Filosofía Fantástica'),
('P4', 'Ecología Onírica'),
('P5', 'Tecnología Del Vacío'),
('P6', 'Arquitectura Etérea'),
('P7', 'Física Cuántica'),
('P8', 'Arte Utopista'),
('P9', 'Biología Cuántica'),
('PRUEBA', 'Arte Onírico'),
('PS1013', 'Ingeniería Poética'),
('PS1019', 'Arquitectura Imaginaria'),
('QORG', 'Biología Galáctica'),
('R25', 'Literatura Onírica'),
('R26', 'Psicología Cuántica'),
('R56', 'Física Del Multiverso'),
('R57', 'Ecología Fractal'),
('R58', 'Física Imaginaria'),
('RA11', 'Antropología Imaginaria'),
('RA16', 'Matemáticas Cuánticas'),
('RA24', 'Arte De la Nostalgia'),
('RC03', 'Cibernética Oculta'),
('RC09', 'Historia De la Nostalgia'),
('RC13', 'Ingeniería Digital'),
('RC16', 'Arquitectura Del Silencio'),
('RC30', 'Física Transdimensional'),
('RC33', 'Matemáticas Ocultas'),
('RC48', 'Química Cuántica'),
('RC50', 'Arte Etéreo'),
('RC51', 'Literatura Cuántica'),
('RL0904', 'Ingeniería Transdimensional'),
('RL0912', 'Filosofía Cuántica'),
('RL0917', 'Sociología De lo Invisible'),
('RL0919', 'Arte Imaginaria'),
('RL0928', 'Ecología Imaginaria'),
('RL0929', 'Historia Mágica'),
('RL0940', 'Biología Fantástica'),
('RL0944', 'Lingüística Cuántica'),
('RL0945', 'Cibernética Del Silencio'),
('SAP225', 'Ingeniería Onírica'),
('SRB001', 'Inteligencia Artificial Imaginaria'),
('SRD508', 'Arquitectura Oculta'),
('SRO006', 'Literatura Fantástica'),
('SRO008', 'Ecología Etérea'),
('TU0939', 'Psicología Imaginaria'),
('X01', 'Ingeniería Etérea'),
('Z01', 'Filosofía Del Vacío'),
('Z02', 'Lingüística Oculta'),
('Z03', 'Matemáticas Transdimensionales'),
('Z04', 'Ecología Cuántica'),
('Z05', 'Antropología Utopista'),
('Z06', 'Cibernética Interplanetaria'),
('Z07', 'Filosofía Etérea'),
('Z08', 'Sociología Utopista'),
('Z09', 'Química Poética'),
('Z10', 'Literatura De lo Invisible'),
('Z11', 'Biología De lo Invisible'),
('Z12', 'Inteligencia Artificial Fantástica'),
('Z13', 'Tecnología De lo Invisible'),
('Z14', 'Arquitectura Fractal'),
('Z15', 'Ingeniería Galáctica'),
('Z65', 'Inteligencia Artificial Cuántica'),
('Z97', 'Ecología Utopista'),
('Z98', 'Biología Oculta'),
('Z99', 'Música Fractal'),
('ZSOMI', 'Tecnología Etérea');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `podcargos`
--

CREATE TABLE `podcargos` (
  `cod` varchar(4) NOT NULL,
  `tipo` char(150) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `podcargos`
--

INSERT INTO `podcargos` (`cod`, `tipo`) VALUES
('1', 'Cargo 1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `podcursoareagruposa`
--

CREATE TABLE `podcursoareagruposa` (
  `curso` varchar(4) NOT NULL,
  `area` varchar(4) NOT NULL,
  `cod` varchar(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `podcursoasigna`
--

CREATE TABLE `podcursoasigna` (
  `curso` varchar(15) NOT NULL,
  `asigna` varchar(15) NOT NULL,
  `responsabl` int(10) NOT NULL,
  `cursoasi` int(1) NOT NULL,
  `tipo` varchar(20) NOT NULL,
  `gic` int(1) NOT NULL DEFAULT 0,
  `gc` int(1) NOT NULL DEFAULT 0,
  `logo` varchar(50) NOT NULL DEFAULT '',
  `tipasig` int(1) NOT NULL DEFAULT 0,
  `altalibre` int(1) NOT NULL DEFAULT 0,
  `patronmail` varchar(20) NOT NULL DEFAULT '',
  `inactiva` int(1) NOT NULL DEFAULT 0,
  `creditost` decimal(5,2) NOT NULL,
  `creditosp` decimal(5,2) NOT NULL,
  `creditoste` decimal(5,2) NOT NULL,
  `creditospr` decimal(5,2) NOT NULL,
  `creditosl` decimal(5,2) NOT NULL,
  `creditoss` decimal(5,2) NOT NULL,
  `creditostu` decimal(5,2) NOT NULL,
  `creditose` decimal(5,2) NOT NULL,
  `creditos` decimal(5,2) NOT NULL,
  `creditosects` decimal(5,2) NOT NULL,
  `ctxasignar` decimal(5,2) NOT NULL,
  `cpxasignar` decimal(5,2) NOT NULL,
  `ctexasignar` decimal(10,2) NOT NULL,
  `cprxasignar` decimal(10,2) NOT NULL,
  `clxasignar` decimal(10,2) NOT NULL,
  `csxasignar` decimal(10,2) NOT NULL,
  `ctuxasignar` decimal(10,2) NOT NULL,
  `cexasignar` decimal(10,2) NOT NULL,
  `grupoa` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `podcursoasigna`
--

INSERT INTO `podcursoasigna` (`curso`, `asigna`, `responsabl`, `cursoasi`, `tipo`, `gic`, `gc`, `logo`, `tipasig`, `altalibre`, `patronmail`, `inactiva`, `creditost`, `creditosp`, `creditoste`, `creditospr`, `creditosl`, `creditoss`, `creditostu`, `creditose`, `creditos`, `creditosects`, `ctxasignar`, `cpxasignar`, `ctexasignar`, `cprxasignar`, `clxasignar`, `csxasignar`, `ctuxasignar`, `cexasignar`, `grupoa`) VALUES
('', 'P06', 0, 0, '', 0, 1, '', 0, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('', 'P4', 0, 0, '', 0, 0, '', 0, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('', 'R57', 0, 0, '', 0, 0, '', 1, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('', 'Z07', 0, 0, '', 1, 0, '', 0, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('', 'Z65', 0, 0, '', 1, 0, '', 0, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('', 'Z97', 0, 0, '', 0, 0, '', 3, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('1', 'I08', 0, 0, '', 0, 0, '', 1, 1, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('1', 'RC33', 0, 0, '', 0, 0, '', 2, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2', 'RC33', 0, 0, '', 0, 0, '', 2, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2000', '742', 0, 0, '', 1, 0, '', 2, 1, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2000', 'A55', 0, 0, '', 1, 0, '', 2, 1, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2000', 'A76', 0, 0, '', 1, 0, '', 1, 1, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2000', 'B42', 0, 0, '', 1, 0, '', 1, 1, '', 1, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2000', 'C49', 0, 0, '', 1, 0, '', 1, 1, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2000', 'D21', 0, 0, '', 1, 0, '', 2, 1, '', 1, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2000', 'D99', 0, 0, '', 1, 0, '', 2, 1, '', 1, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2000', 'I08', 0, 0, '', 0, 0, '', 1, 1, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2000', 'I37', 0, 0, '', 1, 0, '', 2, 1, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2000', 'RC13', 0, 0, '', 1, 0, '', 3, 1, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2000', 'RC30', 0, 0, '', 1, 0, '', 1, 1, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2000', 'Z01', 0, 0, '', 1, 0, '', 3, 1, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2000', 'Z03', 0, 0, '', 1, 0, '', 0, 1, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2000', 'Z04', 0, 0, '', 1, 0, '', 0, 1, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2001', '742', 0, 0, '', 1, 0, '', 2, 1, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2001', 'A55', 0, 0, '', 1, 0, '', 2, 1, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2001', 'A76', 0, 0, '', 1, 0, '', 1, 1, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2001', 'B42', 0, 0, '', 1, 0, '', 1, 1, '', 1, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2001', 'C49', 0, 0, '', 1, 0, '', 1, 1, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2001', 'D20', 0, 0, '', 1, 0, '', 1, 1, '', 1, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2001', 'D21', 0, 0, '', 1, 0, '', 2, 1, '', 1, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2001', 'D99', 0, 0, '', 1, 0, '', 2, 1, '', 1, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2001', 'I08', 0, 0, '', 0, 0, '', 1, 1, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2001', 'I37', 0, 0, '', 1, 0, '', 2, 1, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2001', 'RC13', 0, 0, '', 1, 0, '', 3, 1, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2001', 'RC30', 0, 0, '', 1, 0, '', 1, 1, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2001', 'Z01', 0, 0, '', 1, 0, '', 3, 1, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2001', 'Z03', 0, 0, '', 1, 0, '', 0, 1, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2001', 'Z04', 0, 0, '', 1, 0, '', 0, 1, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2002', '742', 0, 0, '', 1, 0, '', 2, 1, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2002', 'A55', 0, 0, '', 1, 0, '', 2, 1, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2002', 'A76', 0, 0, '', 1, 0, '', 1, 1, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2002', 'B42', 0, 0, '', 1, 0, '', 1, 1, '', 1, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2002', 'C49', 0, 0, '', 1, 0, '', 1, 1, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2002', 'D20', 0, 0, '', 1, 0, '', 1, 1, '', 1, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2002', 'D21', 0, 0, '', 1, 0, '', 2, 1, '', 1, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2002', 'D99', 0, 0, '', 1, 0, '', 2, 1, '', 1, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2002', 'I08', 0, 0, '', 0, 0, '', 1, 1, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2002', 'I37', 0, 0, '', 1, 0, '', 2, 1, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2002', 'RC13', 0, 0, '', 1, 0, '', 3, 1, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2002', 'RC30', 0, 0, '', 1, 0, '', 1, 1, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2002', 'Z01', 0, 0, '', 1, 0, '', 3, 1, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2002', 'Z03', 0, 0, '', 1, 0, '', 0, 1, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2002', 'Z04', 0, 0, '', 1, 0, '', 0, 1, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2003', '742', 0, 0, '', 1, 0, '', 2, 1, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2003', 'A55', 0, 0, '', 1, 0, '', 2, 1, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2003', 'A76', 0, 0, '', 1, 0, '', 1, 1, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2003', 'B42', 0, 0, '', 1, 0, '', 1, 1, '', 1, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2003', 'C49', 0, 0, '', 1, 0, '', 1, 1, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2003', 'D20', 0, 0, '', 1, 0, '', 1, 1, '', 1, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2003', 'D21', 0, 0, '', 1, 0, '', 2, 1, '', 1, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2003', 'D99', 0, 0, '', 1, 0, '', 2, 1, '', 1, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2003', 'I08', 0, 0, '', 0, 0, '', 1, 1, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2003', 'I37', 0, 0, '', 1, 0, '', 2, 1, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2003', 'RC13', 0, 0, '', 1, 0, '', 3, 1, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2003', 'RC30', 0, 0, '', 1, 0, '', 1, 1, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2003', 'Z01', 0, 0, '', 1, 0, '', 3, 1, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2003', 'Z03', 0, 0, '', 1, 0, '', 0, 1, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2003', 'Z04', 0, 0, '', 1, 0, '', 0, 1, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2004', '742', 0, 0, '', 1, 0, '', 2, 1, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2004', 'A55', 0, 0, '', 1, 0, '', 2, 1, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2004', 'A76', 0, 0, '', 1, 0, '', 1, 1, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2004', 'B42', 0, 0, '', 1, 0, '', 1, 1, '', 1, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2004', 'C49', 0, 0, '', 1, 0, '', 1, 1, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2004', 'D20', 0, 0, '', 1, 0, '', 1, 1, '', 1, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2004', 'D21', 0, 0, '', 1, 0, '', 2, 1, '', 1, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2004', 'D99', 0, 0, '', 1, 0, '', 2, 1, '', 1, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2004', 'I08', 0, 0, '', 0, 0, '', 1, 1, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2004', 'I37', 0, 0, '', 1, 0, '', 2, 1, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2004', 'RC13', 0, 0, '', 1, 0, '', 3, 1, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2004', 'RC30', 0, 0, '', 1, 0, '', 1, 1, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2004', 'Z01', 0, 0, '', 1, 0, '', 3, 1, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2004', 'Z03', 0, 0, '', 1, 0, '', 0, 1, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2004', 'Z04', 0, 0, '', 1, 0, '', 0, 1, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2005', '441', 0, 0, 'Troncal', 1, 0, '', 3, 1, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2005', 'C49', 0, 0, '', 1, 0, '', 1, 1, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2005', 'D99', 0, 0, '', 1, 0, '', 2, 1, '', 1, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2005', 'I32', 0, 0, '', 1, 0, '', 3, 1, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2005', 'I37', 0, 0, '', 1, 0, '', 2, 1, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2005', 'R26', 0, 0, '', 1, 0, '', 1, 1, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2005', 'R56', 0, 0, '', 0, 0, '', 2, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2005', 'RC13', 0, 0, '', 1, 0, '', 3, 1, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2005', 'RC50', 0, 0, '', 1, 0, '', 1, 1, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2006', '151', 0, 0, '', 1, 0, '', 2, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2006', '177', 0, 0, '', 1, 0, '', 2, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2006', '441', 0, 0, 'Troncal', 1, 0, '', 3, 1, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2006', '742', 0, 0, '', 1, 0, '', 2, 1, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2006', '925', 0, 0, '', 1, 0, '', 2, 1, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2006', 'A55', 0, 0, '', 1, 0, '', 2, 1, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2006', 'A76', 0, 0, '', 1, 0, '', 1, 1, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2006', 'C49', 0, 0, '', 1, 0, '', 1, 1, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2006', 'D20', 0, 0, '', 1, 0, '', 1, 1, '', 1, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2006', 'D99', 0, 0, '', 1, 0, '', 2, 1, '', 1, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2006', 'I08', 0, 0, '', 0, 0, '', 1, 1, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2006', 'I32', 0, 0, '', 1, 0, '', 3, 1, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2006', 'I37', 0, 0, '', 1, 0, '', 2, 1, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2006', 'P06', 0, 0, '', 0, 1, '', 0, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2006', 'P1', 0, 0, '', 0, 0, '', 0, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2006', 'P2', 0, 0, '', 1, 0, '', 3, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2006', 'R25', 0, 0, '', 0, 0, '', 2, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2006', 'R26', 0, 0, '', 1, 0, '', 1, 1, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2006', 'RC13', 0, 0, '', 1, 0, '', 3, 1, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2006', 'RC30', 0, 0, '', 1, 0, '', 1, 1, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2006', 'RC33', 0, 0, '', 0, 0, '', 2, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2006', 'RC50', 0, 0, '', 1, 0, '', 1, 1, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2006', 'RC51', 0, 0, '', 1, 0, '', 2, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2006', 'Z01', 0, 0, '', 1, 0, '', 3, 1, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2006', 'Z05', 0, 0, '', 0, 0, '', 3, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2006', 'Z06', 0, 0, '', 0, 0, '', 3, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2006', 'Z08', 0, 0, '', 1, 0, '', 2, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2006', 'Z09', 0, 0, '', 1, 0, '', 3, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2006', 'Z10', 0, 0, '', 1, 0, '', 0, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2007', '100', 0, 0, '', 0, 0, '', 2, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2007', '151', 0, 0, '', 1, 0, '', 2, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2007', '441', 0, 0, 'Troncal', 1, 0, '', 3, 1, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2007', '722', 0, 0, '', 0, 0, '', 2, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2007', '907', 0, 0, 'Troncal', 0, 0, '', 1, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2007', '925', 0, 0, '', 1, 0, '', 2, 1, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2007', 'A18', 0, 0, '', 0, 0, '', 1, 1, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2007', 'A76', 0, 0, '', 1, 0, '', 1, 1, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2007', 'C01', 0, 0, '', 1, 0, '', 2, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2007', 'C49', 0, 0, '', 1, 0, '', 1, 1, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2007', 'I08', 0, 0, '', 0, 0, '', 1, 1, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2007', 'I32', 0, 0, '', 1, 0, '', 3, 1, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2007', 'I37', 0, 0, '', 1, 0, '', 2, 1, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2007', 'II50', 0, 0, '', 1, 0, '', 2, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2007', 'IS50', 0, 0, '', 1, 0, '', 2, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2007', 'R25', 0, 0, '', 0, 0, '', 2, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2007', 'R26', 0, 0, '', 1, 0, '', 1, 1, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2007', 'RA11', 0, 0, '', 0, 0, '', 1, 1, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2007', 'RC13', 0, 0, '', 1, 0, '', 3, 1, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2007', 'RC16', 0, 0, '', 0, 0, '', 2, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2007', 'RC30', 0, 0, '', 1, 0, '', 1, 1, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2007', 'RC33', 0, 0, '', 0, 0, '', 2, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2007', 'RC51', 0, 0, '', 1, 0, '', 2, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2007', 'Z01', 0, 0, '', 1, 0, '', 3, 1, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2007', 'Z09', 0, 0, '', 1, 0, '', 3, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2008', '151', 0, 0, '', 1, 0, '', 2, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2008', '176', 0, 0, '', 0, 0, '', 1, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2008', '441', 0, 0, 'Troncal', 1, 0, '', 3, 1, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2008', '512', 0, 0, 'Troncal', 0, 0, '', 1, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2008', '722', 0, 0, '', 0, 0, '', 2, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2008', '907', 0, 0, 'Troncal', 0, 0, '', 1, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2008', '925', 0, 0, '', 1, 0, '', 2, 1, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2008', 'A18', 0, 0, '', 0, 0, '', 1, 1, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2008', 'A76', 0, 0, '', 1, 0, '', 1, 1, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2008', 'AB25', 0, 0, '', 0, 0, '', 1, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2008', 'C49', 0, 0, '', 1, 0, '', 1, 1, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2008', 'I08', 0, 0, '', 0, 0, '', 1, 1, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2008', 'I37', 0, 0, '', 1, 0, '', 2, 1, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2008', 'I70', 0, 0, '', 0, 0, '', 1, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2008', 'R25', 0, 0, '', 0, 0, '', 2, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2008', 'R26', 0, 0, '', 1, 0, '', 1, 1, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2008', 'R57', 0, 0, '', 0, 0, '', 1, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2008', 'RA11', 0, 0, '', 0, 0, '', 1, 1, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2008', 'RA16', 0, 0, '', 0, 0, '', 2, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2008', 'RA24', 0, 0, '', 1, 0, '', 2, 1, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2008', 'RC03', 0, 0, '', 1, 0, '', 3, 1, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2008', 'RC09', 0, 0, '', 0, 0, '', 1, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2008', 'RC13', 0, 0, '', 1, 0, '', 3, 1, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2008', 'RC16', 0, 0, '', 0, 0, '', 2, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2008', 'RC33', 0, 0, '', 0, 0, '', 2, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2008', 'RC48', 0, 0, '', 1, 0, '', 2, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2008', 'Z08', 0, 0, '', 1, 0, '', 2, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2008', 'Z11', 0, 0, '', 1, 0, '', 3, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2008', 'Z98', 0, 0, '', 1, 0, '', 3, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2008', 'Z99', 0, 0, '', 1, 0, '', 3, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2009', '151', 0, 0, '', 1, 0, '', 2, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2009', '176', 0, 0, '', 0, 0, '', 1, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2009', '441', 0, 0, 'Troncal', 1, 0, '', 3, 1, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2009', '722', 0, 0, '', 0, 0, '', 2, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2009', '907', 0, 0, 'Troncal', 0, 0, '', 1, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2009', '925', 0, 0, '', 1, 0, '', 2, 1, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2009', 'A18', 0, 0, '', 0, 0, '', 1, 1, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2009', 'A65', 0, 0, '', 0, 0, '', 1, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2009', 'A76', 0, 0, '', 1, 0, '', 1, 1, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2009', 'C49', 0, 0, '', 1, 0, '', 1, 1, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2009', 'I37', 0, 0, '', 1, 0, '', 2, 1, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2009', 'I37 C', 0, 0, '', 0, 0, '', 2, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2009', 'I70', 0, 0, '', 0, 0, '', 1, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2009', 'I70 - A', 0, 0, '', 0, 0, '', 1, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2009', 'I70 - B', 0, 0, '', 0, 0, '', 1, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2009', 'P3', 0, 0, '', 0, 0, '', 2, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2009', 'PRUEBA', 0, 0, '', 0, 1, '', 3, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2009', 'R26', 0, 0, '', 1, 0, '', 1, 1, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2009', 'RA11', 0, 0, '', 0, 0, '', 1, 1, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2009', 'RA16', 0, 0, '', 0, 0, '', 2, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2009', 'RC03', 0, 0, '', 1, 0, '', 3, 1, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2009', 'RC09', 0, 0, '', 0, 0, '', 1, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2009', 'RC13', 0, 0, '', 1, 0, '', 3, 1, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2009', 'RC16', 0, 0, '', 0, 0, '', 2, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2009', 'RC30', 0, 0, '', 1, 0, '', 1, 1, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2009', 'RC33', 0, 0, '', 0, 0, '', 2, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2009', 'Z11', 0, 0, '', 1, 0, '', 3, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2009', 'Z12', 0, 0, '', 0, 0, '', 2, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2009', 'Z97', 0, 0, '', 0, 0, '', 3, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2009', 'Z99', 0, 0, '', 1, 0, '', 3, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2010', '151', 0, 0, 'Troncal', 0, 0, '', 2, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, -5.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2010', '176', 0, 0, 'Troncal', 0, 0, '', 1, 0, '', 0, 5.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 5.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2010', '907', 2541, 2, 'Troncal', 0, 0, '', 1, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, -5.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2010', '925', 0, 0, 'Troncal', 0, 0, '', 2, 0, '', 0, 5.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 5.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2010', 'A18', 0, 2, 'Troncal', 0, 0, '', 1, 0, '', 0, 12.00, 10.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 22.00, 0.00, 0.00, 8.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2010', 'A75', 0, 4, 'Optativa', 0, 0, '', 1, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, -3.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2010', 'A76', 1, 4, 'Optativa', 1, 0, '', 1, 1, '', 0, 3.00, 2.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 5.00, 0.00, 3.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2010', 'C49', 1, 3, 'Optativa', 0, 0, '', 1, 0, '', 0, 5.00, 4.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 9.00, 0.00, -5.00, 4.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2010', 'I37', 0, 0, 'Troncal', 0, 0, '', 2, 0, '', 0, 6.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 6.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2010', 'I70', 0, 0, 'Troncal', 0, 0, '', 1, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, -3.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2010', 'IB31', 0, 0, 'Troncal', 0, 0, '', 1, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, -5.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2010', 'P10', 6989, 2, 'Troncal', 0, 0, '', 1, 0, '', 0, 2.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 2.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2010', 'P11', 6989, 2, 'Troncal', 0, 0, '', 1, 0, '', 0, 2.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 2.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2010', 'P12', 6989, 2, 'Troncal', 0, 0, '', 1, 0, '', 0, 2.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 2.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2010', 'P13', 0, 0, 'Troncal', 0, 0, '', 0, 0, '', 0, 5.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 5.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2010', 'P5', 2541, 0, 'Troncal', 0, 0, '', 3, 0, '', 0, 2.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 2.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2010', 'P7', 2541, 3, 'Troncal', 0, 0, '', 1, 0, '', 0, 2.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 2.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2010', 'P8', 6989, 0, 'Troncal', 0, 0, '', 1, 0, '', 0, 2.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 2.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2010', 'P9', 6989, 2, 'Troncal', 0, 0, '', 1, 0, '', 0, 2.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 2.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2010', 'R26', 0, 0, 'Troncal', 0, 0, '', 1, 0, '', 0, 5.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 5.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2010', 'RA11', 0, 2, 'Troncal', 0, 0, '', 1, 0, '', 0, 3.00, 1.50, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 4.50, 0.00, -1.00, 1.50, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2010', 'RC09', 0, 0, 'Troncal', 0, 0, '', 1, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, -5.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2010', 'RC13', 1, 2, 'Troncal', 0, 0, '', 3, 0, '', 0, 6.00, 4.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 10.00, 0.00, 0.00, 4.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2010', 'RC16', 0, 0, 'Troncal', 0, 0, '', 2, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, -9.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2010', 'RC33', 2704, 3, 'Optativa', 0, 0, '', 2, 0, '', 0, 5.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 5.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2010', 'SAP225', 0, 0, 'Troncal', 0, 1, '', 2, 0, '', 0, 8.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 8.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2010', 'SRB001', 1, 1, 'Troncal', 0, 0, '', 1, 0, '', 0, 2.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 2.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2010', 'SRD508', 1192, 0, 'Troncal', 0, 0, '', 2, 0, '', 0, 4.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 4.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2010', 'Z11', 1, 1, 'Troncal', 0, 0, '', 1, 0, '', 0, 2.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 2.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2010', 'Z14', 1, 1, 'Troncal', 0, 0, '', 1, 0, '', 0, 2.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 2.00, 0.00, 1.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2010', 'Z15', 1, 0, 'Troncal', 0, 0, '', 2, 0, '', 0, 5.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 5.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2010', 'Z97', 0, 0, 'Troncal', 0, 0, '', 2, 0, '', 0, 4.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 4.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2011', '151', 2146, 0, 'Troncal', 0, 0, '', 2, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2011', '176', 2146, 0, 'Troncal', 0, 0, '', 1, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2011', '907', 2541, 2, 'Troncal', 0, 0, '', 1, 0, '', 0, 3.00, 3.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 6.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2011', '925', 0, 0, 'Optativa', 0, 0, '', 2, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2011', 'A18', 2585, 2, 'Troncal', 0, 0, '', 1, 0, '', 0, 3.00, 2.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 5.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2011', 'A76', 1, 4, 'Optativa', 0, 0, '', 1, 0, '', 0, 3.00, 2.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 5.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2011', 'C49', 1, 3, 'Optativa', 0, 0, '', 1, 0, '', 0, 6.00, 4.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 10.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2011', 'I37', 0, 0, 'Troncal', 0, 0, '', 2, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2011', 'I70', 0, 0, 'Optativa', 0, 0, '', 0, 0, '', 0, 10.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 10.00, 0.00, 6.00, -2.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2011', 'MED', 1117, 1, 'Troncal', 0, 0, '', 3, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2011', 'P15', 2091, 1, 'Troncal', 0, 0, '', 1, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2011', 'QORG', 2585, 1, 'Troncal', 0, 0, '', 1, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2011', 'R57', 0, 0, 'Troncal', 0, 0, '', 1, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, -5.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2011', 'RA11', 2585, 0, 'Troncal', 0, 0, '', 1, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, -3.00, -2.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2011', 'RC13', 1, 2, 'Troncal', 0, 0, '', 3, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2011', 'RC16', 0, 0, 'Troncal', 0, 0, '', 2, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2011', 'RL0912', 0, 2, 'Troncal', 0, 0, '', 1, 0, '', 0, 3.00, 2.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 5.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2011', 'RL0919', 0, 0, 'Troncal', 0, 0, '', 2, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2011', 'SAP225', 1, 1, 'Troncal', 0, 1, '', 1, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2011', 'SRB001', 0, 0, 'Troncal', 0, 0, '', 1, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2012', '176', 2146, 0, 'Troncal', 0, 0, '', 1, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2012', '907', 2091, 2, 'Troncal', 0, 0, '', 1, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2012', 'A76', 1, 4, 'Optativa', 0, 0, '', 1, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2012', 'C49', 7961, 3, 'Optativa', 0, 0, '', 1, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2012', 'RA11', 2585, 0, 'Troncal', 0, 0, '', 1, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2012', 'RL0917', 2585, 3, 'Obligatoria', 0, 0, '', 2, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2012', 'RL0928', 2585, 3, 'Obligatoria', 0, 0, '', 2, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2012', 'RL0929', 1, 3, 'Troncal', 0, 0, '', 2, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2012', 'SAP225', 1, 1, 'Troncal', 0, 1, '', 1, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2012', 'SRB001', 1, 1, 'Troncal', 0, 0, '', 1, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2013', '176', 2146, 0, 'Troncal', 0, 0, '', 1, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2013', '907', 2091, 2, 'Troncal', 0, 0, '', 1, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2013', 'A76', 1, 4, 'Optativa', 0, 0, '', 1, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2013', 'AE1028', 0, 0, 'Troncal', 0, 0, '', 0, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2013', 'C49', 7961, 3, 'Optativa', 0, 0, '', 1, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2013', 'EE1017', 0, 2, 'Obligatoria', 0, 0, '', 2, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2013', 'MED', 0, 0, 'Troncal', 0, 0, '', 2, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2013', 'PS1019', 1192, 2, 'Troncal', 0, 0, '', 2, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2013', 'RA11', 2585, 0, 'Troncal', 0, 0, '', 1, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2013', 'RL0917', 2585, 3, 'Obligatoria', 0, 0, '', 2, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2013', 'RL0928', 2585, 3, 'Obligatoria', 0, 0, '', 2, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2013', 'RL0929', 1, 3, 'Troncal', 0, 0, '', 2, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2013', 'RL0945', 1, 4, 'Optativa', 0, 0, '', 2, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2013', 'SAP225', 1, 1, 'Troncal', 0, 1, '', 1, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2013', 'SRB001', 1, 1, 'Troncal', 0, 0, '', 1, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2013', 'SRD508', 1, 1, 'Troncal', 0, 0, '', 1, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2013', 'TU0939', 7961, 0, 'Troncal', 0, 0, '', 1, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2014', '1010', 8578, 1, 'Troncal', 0, 0, '', 1, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2014', '176', 2146, 0, 'Troncal', 0, 0, '', 1, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2014', '907', 2091, 2, 'Troncal', 0, 0, '', 1, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2014', 'A76', 1, 4, 'Optativa', 0, 0, '', 1, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2014', 'AE1028', 0, 0, 'Troncal', 0, 0, '', 0, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2014', 'AE1042', 2091, 4, 'Optativa', 0, 0, '', 1, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2014', 'C49', 7961, 3, 'Optativa', 0, 0, '', 1, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2014', 'EE1017', 0, 2, 'Obligatoria', 0, 0, '', 2, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2014', 'MED', 0, 0, 'Troncal', 0, 0, '', 2, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2014', 'PS1019', 1192, 2, 'Troncal', 0, 0, '', 2, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2014', 'RA11', 2585, 0, 'Troncal', 0, 0, '', 1, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2014', 'RL0917', 2585, 3, 'Obligatoria', 0, 0, '', 2, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2014', 'RL0928', 2585, 3, 'Obligatoria', 0, 0, '', 2, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2014', 'RL0929', 1, 3, 'Troncal', 0, 0, '', 2, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2014', 'RL0945', 1, 4, 'Optativa', 0, 0, '', 2, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2014', 'SAP225', 1, 1, 'Troncal', 0, 1, '', 1, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2014', 'SRB001', 1, 1, 'Troncal', 0, 0, '', 1, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2014', 'SRD508', 1, 1, 'Troncal', 0, 0, '', 1, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2014', 'TU0939', 0, 4, 'Troncal', 0, 0, '', 1, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0);
INSERT INTO `podcursoasigna` (`curso`, `asigna`, `responsabl`, `cursoasi`, `tipo`, `gic`, `gc`, `logo`, `tipasig`, `altalibre`, `patronmail`, `inactiva`, `creditost`, `creditosp`, `creditoste`, `creditospr`, `creditosl`, `creditoss`, `creditostu`, `creditose`, `creditos`, `creditosects`, `ctxasignar`, `cpxasignar`, `ctexasignar`, `cprxasignar`, `clxasignar`, `csxasignar`, `ctuxasignar`, `cexasignar`, `grupoa`) VALUES
('2015', '1010', 8578, 1, 'Troncal', 0, 0, '', 1, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2015', '176', 2146, 0, 'Troncal', 0, 0, '', 1, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2015', '907', 2091, 2, 'Troncal', 0, 0, '', 1, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2015', 'A76', 1, 4, 'Optativa', 0, 0, '', 1, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2015', 'AE1028', 0, 0, 'Troncal', 0, 0, '', 0, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2015', 'AE1042', 2091, 4, 'Optativa', 0, 0, '', 1, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2015', 'C49', 7961, 3, 'Optativa', 0, 0, '', 1, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2015', 'EE1017', 0, 2, 'Obligatoria', 0, 0, '', 2, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2015', 'MED', 0, 0, 'Troncal', 0, 0, '', 2, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2015', 'P16', 2541, 1, 'Troncal', 0, 0, '', 2, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2015', 'PS1013', 0, 2, 'Troncal', 0, 0, '', 1, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2015', 'PS1019', 1192, 2, 'Troncal', 0, 0, '', 2, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2015', 'RA11', 2585, 0, 'Troncal', 0, 0, '', 1, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2015', 'RL0917', 2585, 3, 'Obligatoria', 0, 0, '', 2, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2015', 'RL0928', 2585, 3, 'Obligatoria', 0, 0, '', 2, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2015', 'RL0929', 1, 3, 'Troncal', 0, 0, '', 2, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2015', 'RL0945', 1, 4, 'Optativa', 0, 0, '', 2, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2015', 'SAP225', 1, 1, 'Troncal', 0, 1, '', 1, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2015', 'SRB001', 1, 1, 'Troncal', 0, 0, '', 1, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2015', 'SRD508', 1, 1, 'Troncal', 0, 0, '', 1, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2015', 'TU0939', 0, 4, 'Troncal', 0, 0, '', 1, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2015', 'ZSOMI', 1117, 0, 'Troncal', 0, 0, '', 2, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2016', '1010', 8578, 1, 'Troncal', 0, 0, '', 1, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2016', '176', 2146, 0, 'Troncal', 0, 0, '', 1, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2016', '907', 2091, 2, 'Troncal', 0, 0, '', 1, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2016', 'A76', 1, 4, 'Optativa', 0, 0, '', 1, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2016', 'AE1028', 0, 0, 'Troncal', 0, 0, '', 0, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2016', 'AE1042', 2091, 4, 'Optativa', 0, 0, '', 1, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2016', 'C49', 7961, 3, 'Optativa', 0, 0, '', 1, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2016', 'EE1017', 0, 2, 'Obligatoria', 0, 0, '', 2, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2016', 'MED', 0, 0, 'Troncal', 0, 0, '', 2, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2016', 'P16', 2541, 1, 'Troncal', 0, 0, '', 2, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2016', 'PS1013', 0, 2, 'Troncal', 0, 0, '', 1, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2016', 'PS1019', 1192, 2, 'Troncal', 0, 0, '', 2, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2016', 'RA11', 2585, 0, 'Troncal', 0, 0, '', 1, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2016', 'RL0917', 2585, 3, 'Obligatoria', 0, 0, '', 2, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2016', 'RL0928', 2585, 3, 'Obligatoria', 0, 0, '', 2, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2016', 'RL0929', 1, 3, 'Troncal', 0, 0, '', 2, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2016', 'RL0945', 1, 4, 'Optativa', 0, 0, '', 2, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2016', 'SAP225', 1, 1, 'Troncal', 0, 1, '', 2, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2016', 'SRB001', 1, 1, 'Troncal', 0, 0, '', 1, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2016', 'SRD508', 1, 1, 'Troncal', 0, 0, '', 1, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2016', 'TU0939', 0, 4, 'Troncal', 0, 0, '', 1, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2016', 'X01', 1117, 4, 'Troncal', 0, 0, '', 2, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2016', 'ZSOMI', 1117, 0, 'Troncal', 0, 0, '', 2, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2017', '1010', 8578, 1, 'Troncal', 0, 0, '', 1, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2017', '176', 2146, 0, 'Troncal', 0, 0, '', 1, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2017', '907', 2091, 2, 'Troncal', 0, 0, '', 1, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2017', 'A76', 1, 4, 'Optativa', 0, 0, '', 1, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2017', 'AE1028', 0, 0, 'Troncal', 0, 0, '', 0, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2017', 'AE1042', 2091, 4, 'Optativa', 0, 0, '', 1, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2017', 'C49', 7961, 3, 'Optativa', 0, 0, '', 1, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2017', 'EE1017', 0, 2, 'Obligatoria', 0, 0, '', 2, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2017', 'MED', 0, 0, 'Troncal', 0, 0, '', 2, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2017', 'P16', 2541, 1, 'Troncal', 0, 0, '', 2, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2017', 'PS1013', 0, 2, 'Troncal', 0, 0, '', 1, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2017', 'PS1019', 1192, 2, 'Troncal', 0, 0, '', 2, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2017', 'RA11', 2585, 0, 'Troncal', 0, 0, '', 1, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2017', 'RL0917', 2585, 3, 'Obligatoria', 0, 0, '', 2, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2017', 'RL0928', 2585, 3, 'Obligatoria', 0, 0, '', 2, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2017', 'RL0929', 1, 3, 'Troncal', 0, 0, '', 2, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2017', 'RL0945', 1, 4, 'Optativa', 0, 0, '', 2, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2017', 'SAP225', 1, 1, 'Troncal', 0, 1, '', 2, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2017', 'SRB001', 1, 1, 'Troncal', 0, 0, '', 1, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2017', 'SRD508', 1, 1, 'Troncal', 0, 0, '', 1, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2017', 'SRO006', 0, 1, 'Troncal', 0, 0, '', 1, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2017', 'TU0939', 0, 4, 'Troncal', 0, 0, '', 1, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2017', 'X01', 1117, 4, 'Troncal', 0, 0, '', 2, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2017', 'ZSOMI', 1117, 0, 'Troncal', 0, 0, '', 2, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2018', '1010', 8578, 1, 'Troncal', 0, 0, '', 1, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2018', '176', 2146, 0, 'Troncal', 0, 0, '', 1, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2018', '907', 2091, 2, 'Troncal', 0, 0, '', 1, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2018', 'A76', 1, 4, 'Optativa', 0, 0, '', 1, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2018', 'AE1028', 0, 0, 'Troncal', 0, 0, '', 0, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2018', 'AE1042', 2091, 4, 'Optativa', 0, 0, '', 1, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2018', 'C49', 7961, 3, 'Optativa', 0, 0, '', 1, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2018', 'EE1017', 0, 2, 'Obligatoria', 0, 0, '', 2, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2018', 'MED', 0, 0, 'Troncal', 0, 0, '', 2, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2018', 'P16', 2541, 1, 'Troncal', 0, 0, '', 2, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2018', 'PS1013', 0, 2, 'Troncal', 0, 0, '', 1, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2018', 'PS1019', 1192, 2, 'Troncal', 0, 0, '', 2, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2018', 'RA11', 2585, 0, 'Troncal', 0, 0, '', 1, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2018', 'RL0917', 2585, 3, 'Obligatoria', 0, 0, '', 2, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2018', 'RL0928', 2585, 3, 'Obligatoria', 0, 0, '', 2, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2018', 'RL0929', 1, 3, 'Troncal', 0, 0, '', 2, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2018', 'RL0945', 1, 4, 'Optativa', 0, 0, '', 2, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2018', 'SAP225', 1, 1, 'Troncal', 0, 1, '', 2, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2018', 'SRB001', 1, 1, 'Troncal', 0, 0, '', 1, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2018', 'SRD508', 1, 1, 'Troncal', 0, 0, '', 1, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2018', 'SRO006', 0, 1, 'Troncal', 0, 0, '', 1, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2018', 'TU0939', 0, 4, 'Troncal', 0, 0, '', 1, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2018', 'X01', 1117, 4, 'Troncal', 0, 0, '', 2, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2018', 'ZSOMI', 1117, 0, 'Troncal', 0, 0, '', 2, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2019', '1010', 8578, 1, 'Troncal', 0, 0, '', 1, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2019', '176', 2146, 0, 'Troncal', 0, 0, '', 1, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2019', '907', 2091, 2, 'Troncal', 0, 0, '', 1, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2019', 'A76', 1, 4, 'Optativa', 0, 0, '', 1, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2019', 'AE1028', 0, 0, 'Troncal', 0, 0, '', 0, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2019', 'AE1042', 2091, 4, 'Optativa', 0, 0, '', 1, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2019', 'C49', 7961, 3, 'Optativa', 0, 0, '', 1, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2019', 'EE1017', 0, 2, 'Obligatoria', 0, 0, '', 2, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2019', 'MED', 0, 0, 'Troncal', 0, 0, '', 2, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2019', 'P16', 2541, 1, 'Troncal', 0, 0, '', 2, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2019', 'PS1013', 0, 2, 'Troncal', 0, 0, '', 1, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2019', 'PS1019', 1192, 2, 'Troncal', 0, 0, '', 2, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2019', 'RA11', 2585, 0, 'Troncal', 0, 0, '', 1, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2019', 'RL0917', 2585, 3, 'Obligatoria', 0, 0, '', 2, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2019', 'RL0928', 2585, 3, 'Obligatoria', 0, 0, '', 2, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2019', 'RL0929', 1, 3, 'Troncal', 0, 0, '', 2, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2019', 'RL0945', 1, 4, 'Optativa', 0, 0, '', 2, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2019', 'SAP225', 1, 1, 'Troncal', 0, 1, '', 2, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2019', 'SRB001', 1, 1, 'Troncal', 0, 0, '', 1, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2019', 'SRD508', 1, 1, 'Troncal', 0, 0, '', 1, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2019', 'SRO006', 0, 1, 'Troncal', 0, 0, '', 1, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2019', 'TU0939', 0, 4, 'Troncal', 0, 0, '', 1, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2019', 'X01', 1117, 4, 'Troncal', 0, 0, '', 2, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2019', 'ZSOMI', 1117, 0, 'Troncal', 0, 0, '', 2, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2020', '1010', 8578, 1, 'Troncal', 0, 0, '', 1, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2020', '176', 2146, 0, 'Troncal', 0, 0, '', 1, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2020', '907', 2091, 2, 'Troncal', 0, 0, '', 1, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2020', 'A76', 1, 4, 'Optativa', 0, 0, '', 1, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2020', 'AE1028', 0, 0, 'Troncal', 0, 0, '', 0, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2020', 'AE1042', 2091, 4, 'Optativa', 0, 0, '', 1, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2020', 'C49', 7961, 3, 'Optativa', 0, 0, '', 1, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2020', 'EE1017', 0, 2, 'Obligatoria', 0, 0, '', 2, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2020', 'MED', 0, 0, 'Troncal', 0, 0, '', 2, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2020', 'P16', 2541, 1, 'Troncal', 0, 0, '', 2, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2020', 'PS1013', 0, 2, 'Troncal', 0, 0, '', 1, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2020', 'PS1019', 1192, 2, 'Troncal', 0, 0, '', 2, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2020', 'RA11', 2585, 0, 'Troncal', 0, 0, '', 1, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2020', 'RL0904', 2091, 1, 'Troncal', 0, 0, '', 1, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2020', 'RL0917', 2585, 3, 'Obligatoria', 0, 0, '', 2, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2020', 'RL0928', 2585, 3, 'Obligatoria', 0, 0, '', 2, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2020', 'RL0929', 1, 3, 'Troncal', 0, 0, '', 2, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2020', 'RL0945', 1, 4, 'Optativa', 0, 0, '', 2, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2020', 'SAP225', 1, 1, 'Troncal', 0, 1, '', 2, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2020', 'SRB001', 1, 1, 'Troncal', 0, 0, '', 1, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2020', 'SRD508', 1, 1, 'Troncal', 0, 0, '', 1, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2020', 'SRO006', 1, 1, 'Troncal', 0, 0, '', 1, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2020', 'SRO008', 2585, 1, 'Troncal', 0, 0, '', 2, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2020', 'TU0939', 0, 4, 'Troncal', 0, 0, '', 1, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2020', 'X01', 1117, 4, 'Troncal', 0, 0, '', 2, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2020', 'ZSOMI', 1117, 0, 'Troncal', 0, 0, '', 2, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2021', '1010', 8578, 1, 'Troncal', 0, 0, '', 1, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2021', '176', 2146, 0, 'Troncal', 0, 0, '', 1, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2021', '907', 2091, 2, 'Troncal', 0, 0, '', 1, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2021', 'A76', 1, 4, 'Optativa', 0, 0, '', 1, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2021', 'AE1028', 0, 0, 'Troncal', 0, 0, '', 0, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2021', 'AE1042', 2091, 4, 'Optativa', 0, 0, '', 1, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2021', 'C49', 7961, 3, 'Optativa', 0, 0, '', 1, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2021', 'EE1017', 0, 2, 'Obligatoria', 0, 0, '', 2, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2021', 'MED', 0, 0, 'Troncal', 0, 0, '', 2, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2021', 'P16', 2541, 1, 'Troncal', 0, 0, '', 2, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2021', 'PS1013', 0, 2, 'Troncal', 0, 0, '', 1, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2021', 'PS1019', 1192, 2, 'Troncal', 0, 0, '', 2, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2021', 'RA11', 2585, 0, 'Troncal', 0, 0, '', 1, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2021', 'RL0904', 2091, 1, 'Troncal', 0, 0, '', 1, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2021', 'RL0917', 2585, 3, 'Obligatoria', 0, 0, '', 2, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2021', 'RL0919', 0, 0, 'Troncal', 0, 0, '', 1, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2021', 'RL0928', 2585, 3, 'Obligatoria', 0, 0, '', 2, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2021', 'RL0929', 1, 3, 'Troncal', 0, 0, '', 2, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2021', 'RL0940', 1192, 4, 'Optativa', 0, 0, '', 1, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2021', 'RL0944', 4809, 4, 'Optativa', 0, 0, '', 2, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2021', 'RL0945', 1, 4, 'Optativa', 0, 0, '', 2, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2021', 'SAP225', 1, 1, 'Troncal', 0, 1, '', 2, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2021', 'SRB001', 1, 1, 'Troncal', 0, 0, '', 1, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2021', 'SRD508', 1, 1, 'Troncal', 0, 0, '', 1, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2021', 'SRO006', 1, 1, 'Troncal', 0, 0, '', 1, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2021', 'SRO008', 2585, 1, 'Troncal', 0, 0, '', 2, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2021', 'TU0939', 0, 4, 'Troncal', 0, 0, '', 1, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2021', 'X01', 1117, 4, 'Troncal', 0, 0, '', 2, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2021', 'ZSOMI', 1117, 0, 'Troncal', 0, 0, '', 2, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2022', '1010', 8578, 1, 'Troncal', 0, 0, '', 1, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2022', '176', 2146, 0, 'Troncal', 0, 0, '', 1, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2022', '907', 2091, 2, 'Troncal', 0, 0, '', 1, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2022', 'A76', 1, 4, 'Optativa', 0, 0, '', 1, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2022', 'AE1028', 0, 0, 'Troncal', 0, 0, '', 0, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2022', 'AE1042', 2091, 4, 'Optativa', 0, 0, '', 1, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2022', 'C49', 7961, 3, 'Optativa', 0, 0, '', 1, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2022', 'EE1017', 0, 2, 'Obligatoria', 0, 0, '', 2, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2022', 'MED', 0, 0, 'Troncal', 0, 0, '', 2, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2022', 'P16', 2541, 1, 'Troncal', 0, 0, '', 2, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2022', 'PS1013', 0, 2, 'Troncal', 0, 0, '', 1, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2022', 'PS1019', 1192, 2, 'Troncal', 0, 0, '', 2, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2022', 'RA11', 2585, 0, 'Troncal', 0, 0, '', 1, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2022', 'RL0904', 2091, 1, 'Troncal', 0, 0, '', 1, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2022', 'RL0917', 2585, 3, 'Obligatoria', 0, 0, '', 2, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2022', 'RL0919', 0, 0, 'Troncal', 0, 0, '', 1, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2022', 'RL0928', 2585, 3, 'Obligatoria', 0, 0, '', 2, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2022', 'RL0929', 1, 3, 'Troncal', 0, 0, '', 2, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2022', 'RL0940', 1192, 4, 'Optativa', 0, 0, '', 1, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2022', 'RL0944', 4809, 4, 'Optativa', 0, 0, '', 2, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2022', 'RL0945', 1, 4, 'Optativa', 0, 0, '', 2, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2022', 'SAP225', 1, 1, 'Troncal', 0, 1, '', 2, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2022', 'SRB001', 1, 1, 'Troncal', 0, 0, '', 1, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2022', 'SRD508', 1, 1, 'Troncal', 0, 0, '', 1, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2022', 'SRO006', 1, 1, 'Troncal', 0, 0, '', 1, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2022', 'SRO008', 2585, 1, 'Troncal', 0, 0, '', 2, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2022', 'TU0939', 0, 4, 'Troncal', 0, 0, '', 1, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2022', 'X01', 1117, 4, 'Troncal', 0, 0, '', 2, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2022', 'ZSOMI', 1117, 0, 'Troncal', 0, 0, '', 2, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2023', '1010', 8578, 1, 'Troncal', 0, 0, '', 1, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2023', '176', 2146, 0, 'Troncal', 0, 0, '', 1, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2023', '907', 2091, 2, 'Troncal', 0, 0, '', 1, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2023', 'A76', 1, 4, 'Optativa', 0, 0, '', 1, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2023', 'AE1028', 0, 0, 'Troncal', 0, 0, '', 0, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2023', 'AE1042', 2091, 4, 'Optativa', 0, 0, '', 1, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2023', 'C49', 7961, 3, 'Optativa', 0, 0, '', 1, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2023', 'EE1017', 0, 2, 'Obligatoria', 0, 0, '', 2, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2023', 'MED', 0, 0, 'Troncal', 0, 0, '', 2, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2023', 'P16', 2541, 1, 'Troncal', 0, 0, '', 2, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2023', 'PS1013', 0, 2, 'Troncal', 0, 0, '', 1, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2023', 'PS1019', 1192, 2, 'Troncal', 0, 0, '', 2, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2023', 'RA11', 2585, 0, 'Troncal', 0, 0, '', 1, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2023', 'RL0904', 2091, 1, 'Troncal', 0, 0, '', 1, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2023', 'RL0917', 2585, 3, 'Obligatoria', 0, 0, '', 2, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2023', 'RL0919', 0, 0, 'Troncal', 0, 0, '', 1, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2023', 'RL0928', 2585, 3, 'Obligatoria', 0, 0, '', 2, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2023', 'RL0929', 1, 3, 'Troncal', 0, 0, '', 2, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2023', 'RL0940', 1192, 4, 'Optativa', 0, 0, '', 1, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2023', 'RL0944', 4809, 4, 'Optativa', 0, 0, '', 2, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2023', 'RL0945', 1, 4, 'Optativa', 0, 0, '', 2, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2023', 'SAP225', 1, 1, 'Troncal', 0, 1, '', 2, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2023', 'SRB001', 1, 1, 'Troncal', 0, 0, '', 1, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2023', 'SRD508', 1, 1, 'Troncal', 0, 0, '', 1, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2023', 'SRO006', 1, 1, 'Troncal', 0, 0, '', 1, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2023', 'SRO008', 2585, 1, 'Troncal', 0, 0, '', 2, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2023', 'TU0939', 0, 4, 'Troncal', 0, 0, '', 1, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2023', 'X01', 1117, 4, 'Troncal', 0, 0, '', 2, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('2023', 'ZSOMI', 1117, 0, 'Troncal', 0, 0, '', 2, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0),
('3', 'RC33', 0, 0, '', 0, 0, '', 2, 0, '', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `podcursoasignaarea`
--

CREATE TABLE `podcursoasignaarea` (
  `asigna` varchar(15) NOT NULL,
  `curso` varchar(4) NOT NULL,
  `area` varchar(4) NOT NULL,
  `ct` decimal(5,2) NOT NULL,
  `cp` decimal(5,2) NOT NULL,
  `cte` decimal(5,2) NOT NULL,
  `cpr` decimal(5,2) NOT NULL,
  `cl` decimal(5,2) NOT NULL,
  `cs` decimal(5,2) NOT NULL,
  `ctu` decimal(5,2) NOT NULL,
  `ce` decimal(5,2) NOT NULL,
  `ctxa` decimal(5,2) NOT NULL,
  `cpxa` decimal(5,2) NOT NULL,
  `ctexa` decimal(5,2) NOT NULL,
  `cprxa` decimal(5,2) NOT NULL,
  `clxa` decimal(5,2) NOT NULL,
  `csxa` decimal(5,2) NOT NULL,
  `ctuxa` decimal(5,2) NOT NULL,
  `cexa` decimal(5,2) NOT NULL,
  `grupoa` varchar(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `podcursoasignaarea`
--

INSERT INTO `podcursoasignaarea` (`asigna`, `curso`, `area`, `ct`, `cp`, `cte`, `cpr`, `cl`, `cs`, `ctu`, `ce`, `ctxa`, `cpxa`, `ctexa`, `cprxa`, `clxa`, `csxa`, `ctuxa`, `cexa`, `grupoa`) VALUES
('P06', '', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('P4', '', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('R57', '', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('Z07', '', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('Z65', '', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('Z97', '', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('I08', '1', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('RC33', '1', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('RC33', '2', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('742', '2000', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('A55', '2000', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('A76', '2000', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('B42', '2000', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('C49', '2000', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('D20', '2000', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('D21', '2000', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('D99', '2000', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('I08', '2000', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('I37', '2000', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('RC13', '2000', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('RC30', '2000', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('Z01', '2000', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('Z03', '2000', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('Z04', '2000', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('742', '2001', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('A55', '2001', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('A76', '2001', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('B42', '2001', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('C49', '2001', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('D20', '2001', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('D21', '2001', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('D99', '2001', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('I08', '2001', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('I37', '2001', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('RC13', '2001', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('RC30', '2001', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('Z01', '2001', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('Z03', '2001', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('Z04', '2001', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('742', '2002', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('A55', '2002', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('A76', '2002', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('B42', '2002', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('C49', '2002', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('D20', '2002', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('D21', '2002', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('D99', '2002', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('I08', '2002', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('I37', '2002', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('RC13', '2002', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('RC30', '2002', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('Z01', '2002', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('Z03', '2002', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('Z04', '2002', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('742', '2003', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('A55', '2003', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('A76', '2003', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('B42', '2003', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('C49', '2003', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('D20', '2003', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('D21', '2003', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('D99', '2003', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('I08', '2003', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('I37', '2003', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('RC13', '2003', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('RC30', '2003', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('Z01', '2003', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('Z03', '2003', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('Z04', '2003', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('742', '2004', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('A55', '2004', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('A76', '2004', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('B42', '2004', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('C49', '2004', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('D20', '2004', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('D21', '2004', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('D99', '2004', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('I08', '2004', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('I37', '2004', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('RC13', '2004', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('RC30', '2004', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('Z01', '2004', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('Z03', '2004', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('Z04', '2004', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('441', '2005', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('C49', '2005', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('D99', '2005', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('I32', '2005', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('I37', '2005', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('R26', '2005', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('R56', '2005', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('RC13', '2005', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('RC50', '2005', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('151', '2006', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('177', '2006', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('441', '2006', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('742', '2006', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('925', '2006', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('A55', '2006', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('A76', '2006', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('C49', '2006', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('D20', '2006', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('D99', '2006', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('I08', '2006', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('I32', '2006', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('I37', '2006', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('P06', '2006', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('P1', '2006', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('P2', '2006', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('R25', '2006', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('R26', '2006', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('RC13', '2006', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('RC30', '2006', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('RC33', '2006', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('RC50', '2006', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('RC51', '2006', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('Z01', '2006', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('Z05', '2006', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('Z06', '2006', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('Z08', '2006', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('Z09', '2006', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('Z10', '2006', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('100', '2007', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('151', '2007', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('441', '2007', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('722', '2007', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('907', '2007', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('925', '2007', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('A18', '2007', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('A76', '2007', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('C01', '2007', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('C49', '2007', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('I08', '2007', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('I32', '2007', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('I37', '2007', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('II50', '2007', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('IS50', '2007', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('R25', '2007', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('R26', '2007', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('RA11', '2007', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('RC13', '2007', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('RC16', '2007', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('RC30', '2007', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('RC33', '2007', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('RC51', '2007', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('Z01', '2007', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('Z09', '2007', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('151', '2008', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('176', '2008', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('441', '2008', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('512', '2008', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('722', '2008', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('907', '2008', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('925', '2008', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('A18', '2008', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('A76', '2008', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('AB25', '2008', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('C49', '2008', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('I08', '2008', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('I37', '2008', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('I70', '2008', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('R25', '2008', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('R26', '2008', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('R57', '2008', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('RA11', '2008', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('RA16', '2008', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('RA24', '2008', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('RC03', '2008', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('RC09', '2008', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('RC13', '2008', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('RC16', '2008', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('RC33', '2008', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('RC48', '2008', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('Z08', '2008', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('Z11', '2008', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('Z98', '2008', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('Z99', '2008', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('151', '2009', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('176', '2009', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('441', '2009', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('722', '2009', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('907', '2009', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('925', '2009', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('A18', '2009', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('A65', '2009', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('A76', '2009', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('C49', '2009', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('I37', '2009', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('I37 C', '2009', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('I70', '2009', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('I70 - A', '2009', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('I70 - B', '2009', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('P3', '2009', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('PRUEBA', '2009', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('R26', '2009', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('RA11', '2009', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('RA16', '2009', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('RC03', '2009', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('RC09', '2009', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('RC13', '2009', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('RC16', '2009', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('RC30', '2009', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('RC33', '2009', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('Z11', '2009', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('Z12', '2009', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('Z97', '2009', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('Z99', '2009', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('151', '2010', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('176', '2010', '1', 5.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('907', '2010', '2', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('925', '2010', '2', 5.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('A18', '2010', '2', 12.00, 10.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('A75', '2010', '2', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('A76', '2010', '2', 3.00, 2.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('C49', '2010', '2', 5.00, 4.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('I37', '2010', '1', 6.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('I70', '2010', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('I70', '2010', '2', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('IB31', '2010', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('P10', '2010', '2', 2.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('P11', '2010', '2', 2.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('P12', '2010', '2', 2.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('P13', '2010', '1', 5.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('P5', '2010', '2', 2.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('P7', '2010', '2', 2.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('P8', '2010', '2', 2.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('P9', '2010', '2', 2.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('R26', '2010', '1', 5.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('RA11', '2010', '2', 3.00, 1.50, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('RC09', '2010', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('RC13', '2010', '2', 6.00, 4.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('RC16', '2010', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('RC33', '2010', '1', 5.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('SAP225', '2010', '1', 4.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('SAP225', '2010', '2', 4.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('SRB001', '2010', '2', 2.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('SRD508', '2010', '1', 2.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('SRD508', '2010', '2', 2.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('Z11', '2010', '2', 2.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('Z14', '2010', '1', 1.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('Z14', '2010', '2', 1.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('Z15', '2010', '2', 5.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('Z97', '2010', '1', 2.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('Z97', '2010', '2', 2.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('151', '2011', '1', 5.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('176', '2011', '1', 5.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('907', '2011', '1', 3.00, 3.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('925', '2011', '1', 5.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('A18', '2011', '1', 3.00, 2.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('A76', '2011', '1', 3.00, 2.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('C49', '2011', '1', 6.00, 4.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('I37', '2011', '1', 3.00, 2.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('I70', '2011', '1', 10.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('MED', '2011', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('P15', '2011', '1', 5.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('QORG', '2011', '1', 3.00, 3.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('R57', '2011', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('RA11', '2011', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('RC13', '2011', '1', 5.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('RC16', '2011', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('RL0912', '2011', '1', 3.00, 2.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('RL0919', '2011', '1', 5.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('SAP225', '2011', '1', 4.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('SRB001', '2011', '1', 2.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('176', '2012', '1', 5.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('907', '2012', '1', 6.00, 3.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('907', '2012', '2', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('A76', '2012', '1', 5.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('C49', '2012', '1', 5.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('RA11', '2012', '1', 5.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('RL0917', '2012', '1', 0.00, 0.00, 6.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('RL0928', '2012', '1', 0.00, 0.00, 6.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('RL0929', '2012', '1', 0.00, 0.00, 6.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('SAP225', '2012', '1', 0.00, 0.00, 4.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('SRB001', '2012', '1', 5.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('176', '2013', '1', 5.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 5.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('907', '2013', '1', 6.00, 3.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 6.00, 3.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('A76', '2013', '1', 5.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 5.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('AE1028', '2013', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('C49', '2013', '1', 5.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 4.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('EE1017', '2013', '1', 5.00, 4.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 5.00, 1.95, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('MED', '2013', '1', 2.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('PS1019', '2013', '1', 6.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('RA11', '2013', '1', 5.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 5.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('RL0917', '2013', '1', 0.00, 0.00, 6.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 6.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('RL0928', '2013', '1', 0.00, 0.00, 6.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 6.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('RL0929', '2013', '1', 0.00, 0.00, 6.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 6.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('RL0945', '2013', '1', 0.00, 0.00, 6.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('SAP225', '2013', '1', 0.00, 0.00, 4.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 4.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('SRB001', '2013', '1', 5.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 5.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('SRD508', '2013', '1', 4.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('TU0939', '2013', '1', 5.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('1010', '2014', '1', 6.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('176', '2014', '1', 5.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 5.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('907', '2014', '1', 6.00, 3.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 6.00, 3.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('A76', '2014', '1', 5.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 5.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('AE1028', '2014', '1', 6.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('AE1042', '2014', '1', 6.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('C49', '2014', '1', 5.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 4.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('EE1017', '2014', '1', 5.00, 4.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 5.00, 1.95, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('MED', '2014', '1', 2.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('PS1019', '2014', '1', 6.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('RA11', '2014', '1', 5.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 5.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('RL0917', '2014', '1', 0.00, 0.00, 6.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 6.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('RL0928', '2014', '1', 0.00, 0.00, 6.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 6.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('RL0929', '2014', '1', 0.00, 0.00, 6.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 6.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('RL0945', '2014', '1', 0.00, 0.00, 6.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('SAP225', '2014', '1', 0.00, 0.00, 4.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 4.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('SRB001', '2014', '1', 5.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 5.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('SRD508', '2014', '1', 4.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('TU0939', '2014', '1', 6.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('1010', '2015', '1', 6.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('176', '2015', '1', 5.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 5.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('907', '2015', '1', 6.00, 3.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 6.00, 3.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('A76', '2015', '1', 5.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 5.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('AE1028', '2015', '1', 6.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('AE1042', '2015', '1', 6.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('C49', '2015', '1', 5.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 4.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('EE1017', '2015', '1', 5.00, 4.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 5.00, 1.95, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('MED', '2015', '1', 2.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('P16', '2015', '1', 5.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('PS1013', '2015', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('PS1019', '2015', '1', 6.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('RA11', '2015', '1', 5.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 5.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('RL0917', '2015', '1', 0.00, 0.00, 6.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 6.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('RL0928', '2015', '1', 0.00, 0.00, 6.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 6.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('RL0929', '2015', '1', 0.00, 0.00, 6.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 6.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('RL0945', '2015', '1', 0.00, 0.00, 6.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('SAP225', '2015', '1', 0.00, 0.00, 4.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 4.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('SRB001', '2015', '1', 5.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 5.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('SRD508', '2015', '1', 4.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('TU0939', '2015', '1', 6.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('ZSOMI', '2015', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('1010', '2016', '1', 6.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('176', '2016', '1', 5.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 5.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('907', '2016', '1', 6.00, 3.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 6.00, 3.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('A76', '2016', '1', 5.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 5.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('AE1028', '2016', '1', 6.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('AE1042', '2016', '1', 6.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('C49', '2016', '1', 5.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 4.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('EE1017', '2016', '1', 5.00, 4.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 5.00, 1.95, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('MED', '2016', '1', 2.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('P16', '2016', '1', 5.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('PS1013', '2016', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('PS1019', '2016', '1', 6.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('RA11', '2016', '1', 5.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 5.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('RL0917', '2016', '1', 0.00, 0.00, 6.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 6.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('RL0928', '2016', '1', 0.00, 0.00, 6.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 6.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('RL0929', '2016', '1', 0.00, 0.00, 6.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 6.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('RL0945', '2016', '1', 0.00, 0.00, 6.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('SAP225', '2016', '1', 4.00, 0.00, 4.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 4.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('SRB001', '2016', '1', 5.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 5.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('SRD508', '2016', '1', 4.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('TU0939', '2016', '1', 6.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('X01', '2016', '1', 1.00, 0.00, 1.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('ZSOMI', '2016', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('1010', '2017', '1', 6.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('176', '2017', '1', 5.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 5.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('907', '2017', '1', 6.00, 3.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 6.00, 3.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('A76', '2017', '1', 5.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 5.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('AE1028', '2017', '1', 6.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('AE1042', '2017', '1', 6.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('C49', '2017', '1', 5.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 4.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('EE1017', '2017', '1', 5.00, 4.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 5.00, 1.95, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('MED', '2017', '1', 2.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('P16', '2017', '1', 5.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('PS1013', '2017', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('PS1019', '2017', '1', 6.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('RA11', '2017', '1', 5.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 5.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('RL0917', '2017', '1', 0.00, 0.00, 6.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 6.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('RL0928', '2017', '1', 0.00, 0.00, 6.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 6.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('RL0929', '2017', '1', 0.00, 0.00, 6.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 6.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('RL0945', '2017', '1', 0.00, 0.00, 6.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('SAP225', '2017', '1', 4.00, 0.00, 4.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 4.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('SRB001', '2017', '1', 5.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 5.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('SRD508', '2017', '1', 4.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('SRO006', '2017', '1', 4.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('TU0939', '2017', '1', 6.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('X01', '2017', '1', 1.00, 0.00, 1.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('ZSOMI', '2017', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('1010', '2018', '1', 6.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('176', '2018', '1', 5.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 5.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('907', '2018', '1', 6.00, 3.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 6.00, 3.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('A76', '2018', '1', 5.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 5.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('AE1028', '2018', '1', 6.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('AE1042', '2018', '1', 6.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('C49', '2018', '1', 5.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 4.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('EE1017', '2018', '1', 5.00, 4.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 5.00, 1.95, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('MED', '2018', '1', 2.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('P16', '2018', '1', 5.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('PS1013', '2018', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('PS1019', '2018', '1', 6.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('RA11', '2018', '1', 5.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 5.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('RL0917', '2018', '1', 0.00, 0.00, 6.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 6.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('RL0928', '2018', '1', 0.00, 0.00, 6.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 6.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('RL0929', '2018', '1', 0.00, 0.00, 6.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 6.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('RL0945', '2018', '1', 0.00, 0.00, 6.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('SAP225', '2018', '1', 4.00, 0.00, 4.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 4.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('SRB001', '2018', '1', 5.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 5.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('SRD508', '2018', '1', 4.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('SRO006', '2018', '1', 4.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('TU0939', '2018', '1', 6.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('X01', '2018', '1', 1.00, 0.00, 1.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('ZSOMI', '2018', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('1010', '2019', '1', 6.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('176', '2019', '1', 5.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 5.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('907', '2019', '1', 6.00, 3.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 6.00, 3.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('A76', '2019', '1', 5.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 5.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('AE1028', '2019', '1', 6.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('AE1042', '2019', '1', 6.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('C49', '2019', '1', 5.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 4.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('EE1017', '2019', '1', 5.00, 4.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 5.00, 1.95, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, '');
INSERT INTO `podcursoasignaarea` (`asigna`, `curso`, `area`, `ct`, `cp`, `cte`, `cpr`, `cl`, `cs`, `ctu`, `ce`, `ctxa`, `cpxa`, `ctexa`, `cprxa`, `clxa`, `csxa`, `ctuxa`, `cexa`, `grupoa`) VALUES
('MED', '2019', '1', 2.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('P16', '2019', '1', 5.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('PS1013', '2019', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('PS1019', '2019', '1', 6.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('RA11', '2019', '1', 5.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 5.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('RL0917', '2019', '1', 0.00, 0.00, 6.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 6.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('RL0928', '2019', '1', 0.00, 0.00, 6.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 6.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('RL0929', '2019', '1', 0.00, 0.00, 6.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 6.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('RL0945', '2019', '1', 0.00, 0.00, 6.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('SAP225', '2019', '1', 4.00, 0.00, 4.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 4.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('SRB001', '2019', '1', 5.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 5.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('SRD508', '2019', '1', 4.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('SRO006', '2019', '1', 4.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('TU0939', '2019', '1', 6.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('X01', '2019', '1', 1.00, 0.00, 1.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('ZSOMI', '2019', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('1010', '2020', '1', 6.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('176', '2020', '1', 5.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 5.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('907', '2020', '1', 6.00, 3.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 6.00, 3.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('A76', '2020', '1', 5.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 5.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('AE1028', '2020', '1', 6.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('AE1042', '2020', '1', 6.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('C49', '2020', '1', 5.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 4.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('EE1017', '2020', '1', 5.00, 4.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 5.00, 1.95, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('MED', '2020', '1', 2.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('P16', '2020', '1', 5.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('PS1013', '2020', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('PS1019', '2020', '1', 6.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('RA11', '2020', '1', 5.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 5.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('RL0904', '2020', '1', 0.00, 0.00, 6.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('RL0917', '2020', '1', 0.00, 0.00, 6.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 6.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('RL0928', '2020', '1', 0.00, 0.00, 6.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 6.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('RL0929', '2020', '1', 0.00, 0.00, 6.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 6.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('RL0945', '2020', '1', 0.00, 0.00, 6.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('SAP225', '2020', '1', 4.00, 0.00, 4.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 4.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('SRB001', '2020', '1', 5.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 5.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('SRD508', '2020', '1', 4.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('SRO006', '2020', '2', 4.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('SRO008', '2020', '2', 0.00, 0.00, 4.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('TU0939', '2020', '1', 6.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('X01', '2020', '1', 1.00, 0.00, 1.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('ZSOMI', '2020', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('1010', '2021', '1', 6.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('176', '2021', '1', 5.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 5.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('907', '2021', '1', 6.00, 3.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 6.00, 3.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('A76', '2021', '1', 5.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 5.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('AE1028', '2021', '2', 6.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('AE1042', '2021', '1', 6.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('C49', '2021', '1', 5.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 4.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('EE1017', '2021', '1', 5.00, 4.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 5.00, 1.95, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('MED', '2021', '1', 2.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('P16', '2021', '1', 5.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('PS1013', '2021', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('PS1019', '2021', '1', 6.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('RA11', '2021', '1', 5.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 5.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('RL0904', '2021', '2', 0.00, 0.00, 6.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('RL0917', '2021', '2', 0.00, 0.00, 6.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 6.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('RL0919', '2021', '4', 0.00, 0.00, 6.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('RL0928', '2021', '2', 0.00, 0.00, 6.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 6.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('RL0929', '2021', '2', 0.00, 0.00, 6.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 6.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('RL0940', '2021', '4', 0.00, 0.00, 6.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('RL0944', '2021', '2', 0.00, 0.00, 6.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('RL0945', '2021', '2', 0.00, 0.00, 6.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('SAP225', '2021', '2', 4.00, 0.00, 4.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 4.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('SRB001', '2021', '2', 5.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 5.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('SRD508', '2021', '1', 4.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('SRO006', '2021', '2', 4.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('SRO008', '2021', '2', 0.00, 0.00, 4.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('TU0939', '2021', '1', 6.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('X01', '2021', '1', 1.00, 0.00, 1.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('ZSOMI', '2021', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('1010', '2022', '1', 6.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('176', '2022', '1', 5.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 5.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('907', '2022', '1', 6.00, 3.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 6.00, 3.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('A76', '2022', '1', 5.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 5.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('AE1028', '2022', '2', 6.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('AE1042', '2022', '1', 6.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('C49', '2022', '1', 5.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 4.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('EE1017', '2022', '1', 5.00, 4.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 5.00, 1.95, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('MED', '2022', '1', 2.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('P16', '2022', '1', 5.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('PS1013', '2022', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('PS1019', '2022', '1', 6.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('RA11', '2022', '1', 5.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 5.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('RL0904', '2022', '2', 0.00, 0.00, 6.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('RL0917', '2022', '2', 0.00, 0.00, 6.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 6.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('RL0919', '2022', '4', 0.00, 0.00, 6.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('RL0928', '2022', '2', 0.00, 0.00, 6.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 6.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('RL0929', '2022', '2', 0.00, 0.00, 6.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 6.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('RL0940', '2022', '4', 0.00, 0.00, 6.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('RL0944', '2022', '2', 0.00, 0.00, 6.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('RL0945', '2022', '2', 0.00, 0.00, 6.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('SAP225', '2022', '2', 4.00, 0.00, 4.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 4.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('SRB001', '2022', '2', 5.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 5.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('SRD508', '2022', '1', 4.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('SRO006', '2022', '2', 4.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('SRO008', '2022', '2', 0.00, 0.00, 4.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('TU0939', '2022', '1', 6.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('X01', '2022', '1', 1.00, 0.00, 1.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('ZSOMI', '2022', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('1010', '2023', '1', 6.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 6.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('176', '2023', '1', 5.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 5.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('907', '2023', '1', 6.00, 3.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 6.00, 3.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('A76', '2023', '1', 5.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('AE1028', '2023', '2', 6.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 6.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('AE1042', '2023', '1', 6.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 2.00, -2.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('C49', '2023', '1', 5.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 5.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('EE1017', '2023', '1', 5.00, 4.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 5.00, 4.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('MED', '2023', '1', 2.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 2.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('P16', '2023', '1', 5.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 1.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('PS1013', '2023', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, -1.00, 0.00, -8.00, -6.00, 0.00, 0.00, 0.00, 0.00, ''),
('PS1019', '2023', '1', 6.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 6.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('RA11', '2023', '1', 5.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 5.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('RL0904', '2023', '2', 0.00, 0.00, 6.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 6.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('RL0917', '2023', '2', 0.00, 0.00, 6.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 6.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('RL0919', '2023', '4', 0.00, 0.00, 6.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 6.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('RL0928', '2023', '2', 0.00, 0.00, 6.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 6.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('RL0929', '2023', '2', 0.00, 0.00, 6.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, -2.00, 6.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('RL0940', '2023', '4', 0.00, 0.00, 6.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 6.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('RL0944', '2023', '2', 0.00, 0.00, 6.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 6.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('RL0945', '2023', '2', 0.00, 0.00, 6.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 6.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('SAP225', '2023', '2', 4.00, 0.00, 4.00, 0.00, 0.00, 0.00, 0.00, 0.00, 4.00, 0.00, 4.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('SRB001', '2023', '2', 5.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 5.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('SRD508', '2023', '1', 4.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 4.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('SRO006', '2023', '2', 4.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 4.00, 0.00, -2.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('SRO008', '2023', '2', 0.00, 0.00, 4.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 2.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('TU0939', '2023', '1', 6.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 1.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('X01', '2023', '1', 1.00, 0.00, 1.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 1.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('ZSOMI', '2023', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, -2.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, ''),
('RC33', '3', '1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `podcursoasignatit`
--

CREATE TABLE `podcursoasignatit` (
  `curso` varchar(4) NOT NULL,
  `asigna` varchar(15) NOT NULL,
  `tit` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `podcursoasignatit`
--

INSERT INTO `podcursoasignatit` (`curso`, `asigna`, `tit`) VALUES
('', 'P06', 'P'),
('', 'P4', 'P'),
('', 'R57', 'R'),
('', 'Z07', 'Z'),
('', 'Z65', 'Z'),
('', 'Z97', 'Z'),
('1', 'I08', 'I'),
('1', 'RC33', 'RC'),
('2', 'RC33', 'RC'),
('2000', '742', '7'),
('2000', 'A55', 'A'),
('2000', 'A76', 'A'),
('2000', 'B42', 'B'),
('2000', 'C49', 'C'),
('2000', 'D20', 'D'),
('2000', 'D21', 'D'),
('2000', 'D99', 'D'),
('2000', 'I08', 'I'),
('2000', 'I37', 'I'),
('2000', 'RC13', 'RC'),
('2000', 'RC30', 'RC'),
('2000', 'Z01', 'Z'),
('2000', 'Z03', 'a'),
('2000', 'Z04', 'Z'),
('2001', '742', '7'),
('2001', 'A55', 'A'),
('2001', 'A76', 'A'),
('2001', 'B42', 'B'),
('2001', 'C49', 'C'),
('2001', 'D20', 'D'),
('2001', 'D21', 'D'),
('2001', 'D99', 'D'),
('2001', 'I08', 'I'),
('2001', 'I37', 'I'),
('2001', 'RC13', 'RC'),
('2001', 'RC30', 'RC'),
('2001', 'Z01', 'Z'),
('2001', 'Z03', 'a'),
('2001', 'Z04', 'Z'),
('2002', '742', '7'),
('2002', 'A55', 'A'),
('2002', 'A76', 'A'),
('2002', 'B42', 'B'),
('2002', 'C49', 'C'),
('2002', 'D20', 'D'),
('2002', 'D21', 'D'),
('2002', 'D99', 'D'),
('2002', 'I08', 'I'),
('2002', 'I37', 'I'),
('2002', 'RC13', 'RC'),
('2002', 'RC30', 'RC'),
('2002', 'Z01', 'Z'),
('2002', 'Z03', 'a'),
('2002', 'Z04', 'Z'),
('2003', '742', '7'),
('2003', 'A55', 'A'),
('2003', 'A76', 'A'),
('2003', 'B42', 'B'),
('2003', 'C49', 'C'),
('2003', 'D20', 'D'),
('2003', 'D21', 'D'),
('2003', 'D99', 'D'),
('2003', 'I08', 'I'),
('2003', 'I37', 'I'),
('2003', 'RC13', 'RC'),
('2003', 'RC30', 'RC'),
('2003', 'Z01', 'Z'),
('2003', 'Z03', 'a'),
('2003', 'Z04', 'Z'),
('2004', '742', '7'),
('2004', 'A55', 'A'),
('2004', 'A76', 'A'),
('2004', 'B42', 'B'),
('2004', 'C49', 'C'),
('2004', 'D20', 'D'),
('2004', 'D21', 'D'),
('2004', 'D99', 'D'),
('2004', 'I08', 'I'),
('2004', 'I37', 'I'),
('2004', 'RC13', 'RC'),
('2004', 'RC30', 'RC'),
('2004', 'Z01', 'Z'),
('2004', 'Z03', 'a'),
('2004', 'Z04', 'Z'),
('2005', '441', '4'),
('2005', 'C49', 'C'),
('2005', 'D99', 'D'),
('2005', 'I32', 'I'),
('2005', 'I37', 'I'),
('2005', 'R26', 'R'),
('2005', 'R56', '4'),
('2005', 'RC13', 'RC'),
('2005', 'RC50', 'RC'),
('2006', '151', '1'),
('2006', '177', '1'),
('2006', '441', '4'),
('2006', '742', '7'),
('2006', '925', '9'),
('2006', 'A55', 'A'),
('2006', 'A76', 'A'),
('2006', 'C49', 'C'),
('2006', 'D20', 'D'),
('2006', 'D99', 'D'),
('2006', 'I08', 'I'),
('2006', 'I32', 'I'),
('2006', 'I37', 'I'),
('2006', 'P06', 'P'),
('2006', 'P1', 'P'),
('2006', 'P2', 'P'),
('2006', 'R25', 'R'),
('2006', 'R26', 'R'),
('2006', 'RC13', 'RC'),
('2006', 'RC30', 'RC'),
('2006', 'RC33', 'RC'),
('2006', 'RC50', 'RC'),
('2006', 'RC51', 'RC'),
('2006', 'Z01', 'Z'),
('2006', 'Z05', 'Z'),
('2006', 'Z06', 'Z'),
('2006', 'Z08', 'Z'),
('2006', 'Z09', 'Z'),
('2006', 'Z10', 'Z'),
('2007', '100', '1'),
('2007', '151', '1'),
('2007', '441', '4'),
('2007', '722', '7'),
('2007', '907', '9'),
('2007', '925', '9'),
('2007', 'A18', 'A'),
('2007', 'A76', 'A'),
('2007', 'C01', 'C'),
('2007', 'C49', 'C'),
('2007', 'I08', 'I'),
('2007', 'I32', 'I'),
('2007', 'I37', 'I'),
('2007', 'II50', 'II'),
('2007', 'IS50', 'IS'),
('2007', 'R25', 'R'),
('2007', 'R26', 'R'),
('2007', 'RA11', 'RA'),
('2007', 'RC13', 'RC'),
('2007', 'RC16', 'RC'),
('2007', 'RC30', 'RC'),
('2007', 'RC33', 'RC'),
('2007', 'RC51', 'RC'),
('2007', 'Z01', 'Z'),
('2007', 'Z09', 'Z'),
('2008', '151', '1'),
('2008', '176', '1'),
('2008', '441', '4'),
('2008', '512', '5'),
('2008', '722', '7'),
('2008', '907', '9'),
('2008', '925', '9'),
('2008', 'A18', 'A'),
('2008', 'A76', 'A'),
('2008', 'AB25', 'AB'),
('2008', 'C49', 'C'),
('2008', 'I08', 'I'),
('2008', 'I37', 'I'),
('2008', 'I70', 'I'),
('2008', 'R25', 'R'),
('2008', 'R26', 'R'),
('2008', 'R57', 'R'),
('2008', 'RA11', 'RA'),
('2008', 'RA16', 'RA'),
('2008', 'RA24', 'RA'),
('2008', 'RC03', 'RC'),
('2008', 'RC09', 'RC'),
('2008', 'RC13', 'RC'),
('2008', 'RC16', 'RC'),
('2008', 'RC33', 'RC'),
('2008', 'RC48', 'RC'),
('2008', 'Z08', 'Z'),
('2008', 'Z11', 'Z'),
('2008', 'Z98', 'Z'),
('2008', 'Z99', 'Z'),
('2009', '151', '1'),
('2009', '176', '1'),
('2009', '441', '4'),
('2009', '722', '7'),
('2009', '907', '9'),
('2009', '925', '9'),
('2009', 'A18', 'A'),
('2009', 'A65', 'A'),
('2009', 'A76', 'A'),
('2009', 'C49', 'C'),
('2009', 'I37', 'I'),
('2009', 'I37 C', 'I'),
('2009', 'I70', 'I'),
('2009', 'I70 - A', 'I'),
('2009', 'I70 - B', 'I'),
('2009', 'P3', 'P'),
('2009', 'PRUEBA', 'PRUEB'),
('2009', 'R26', 'R'),
('2009', 'RA11', 'RA'),
('2009', 'RA16', 'RA'),
('2009', 'RC03', 'RC'),
('2009', 'RC09', 'RC'),
('2009', 'RC13', 'RC'),
('2009', 'RC16', 'RC'),
('2009', 'RC30', 'RC'),
('2009', 'RC33', 'RC'),
('2009', 'Z11', 'Z'),
('2009', 'Z12', 'Z'),
('2009', 'Z97', 'Z'),
('2009', 'Z99', 'Z'),
('2010', '151', '1'),
('2010', '176', '1'),
('2010', '907', '9'),
('2010', '925', '9'),
('2010', 'A18', 'A'),
('2010', 'A75', 'A'),
('2010', 'A76', 'A'),
('2010', 'C49', 'C'),
('2010', 'I37', 'I'),
('2010', 'I70', 'I'),
('2010', 'IB31', 'IB'),
('2010', 'P10', 'P'),
('2010', 'P11', 'P'),
('2010', 'P12', 'P'),
('2010', 'P13', 'P'),
('2010', 'P5', 'P'),
('2010', 'P7', 'P'),
('2010', 'P8', 'P'),
('2010', 'P9', 'P'),
('2010', 'R26', 'R'),
('2010', 'RA11', 'RA'),
('2010', 'RC09', 'RA'),
('2010', 'RC13', 'RC'),
('2010', 'RC16', 'RC'),
('2010', 'RC33', 'D'),
('2010', 'SAP225', 'SAP'),
('2010', 'SRB001', 'SRB'),
('2010', 'SRD508', 'SRD'),
('2010', 'Z11', 'Z'),
('2010', 'Z14', 'Z'),
('2010', 'Z15', 'Z'),
('2010', 'Z97', 'Z'),
('2011', '151', '1'),
('2011', '176', '1'),
('2011', '907', '9'),
('2011', '925', '9'),
('2011', 'A18', 'A'),
('2011', 'A76', 'A'),
('2011', 'C49', 'C'),
('2011', 'I37', 'I'),
('2011', 'I70', 'I'),
('2011', 'MED', 'I'),
('2011', 'P15', 'P'),
('2011', 'QORG', 'P'),
('2011', 'R57', 'R'),
('2011', 'RA11', 'RA'),
('2011', 'RC16', 'RC'),
('2011', 'RL0912', 'RL'),
('2011', 'RL0919', 'RL'),
('2011', 'SAP225', 'SAP'),
('2011', 'SRB001', 'SRB'),
('2012', '176', '1'),
('2012', '907', '9'),
('2012', 'A76', 'A'),
('2012', 'C49', 'C'),
('2012', 'RA11', 'RA'),
('2012', 'RL0917', 'RL'),
('2012', 'RL0928', 'RL'),
('2012', 'RL0929', 'RL'),
('2012', 'SAP225', 'SAP'),
('2012', 'SRB001', 'SRB'),
('2013', '176', '1'),
('2013', '907', '9'),
('2013', 'A76', 'A'),
('2013', 'C49', 'C'),
('2013', 'EE1017', 'EE'),
('2013', 'MED', 'PRUEB'),
('2013', 'PS1019', 'PS'),
('2013', 'RA11', 'RA'),
('2013', 'RL0917', 'RL'),
('2013', 'RL0928', 'RL'),
('2013', 'RL0929', 'RL'),
('2013', 'RL0945', 'RL'),
('2013', 'SAP225', 'SAP'),
('2013', 'SRB001', 'SRB'),
('2013', 'SRD508', 'SRD'),
('2013', 'TU0939', 'GRT'),
('2014', '1010', 'AE'),
('2014', '176', '1'),
('2014', '907', '9'),
('2014', 'A76', 'A'),
('2014', 'AE1028', 'AE'),
('2014', 'AE1042', 'AE'),
('2014', 'C49', 'C'),
('2014', 'EE1017', 'EE'),
('2014', 'MED', 'PRUEB'),
('2014', 'PS1019', 'PS'),
('2014', 'RA11', 'RA'),
('2014', 'RL0917', 'RL'),
('2014', 'RL0928', 'RL'),
('2014', 'RL0929', 'RL'),
('2014', 'RL0945', 'RL'),
('2014', 'SAP225', 'SAP'),
('2014', 'SRB001', 'SRB'),
('2014', 'SRD508', 'SRD'),
('2014', 'TU0939', 'GRT'),
('2015', '1010', 'AE'),
('2015', '176', '1'),
('2015', '907', '9'),
('2015', 'A76', 'A'),
('2015', 'AE1028', 'AE'),
('2015', 'AE1042', 'AE'),
('2015', 'C49', 'C'),
('2015', 'EE1017', 'EE'),
('2015', 'MED', 'PRUEB'),
('2015', 'P16', 'P'),
('2015', 'PS1013', 'PS'),
('2015', 'PS1019', 'PS'),
('2015', 'RA11', 'RA'),
('2015', 'RL0917', 'RL'),
('2015', 'RL0928', 'RL'),
('2015', 'RL0929', 'RL'),
('2015', 'RL0945', 'RL'),
('2015', 'SAP225', 'SAP'),
('2015', 'SRB001', 'SRB'),
('2015', 'SRD508', 'SRD'),
('2015', 'TU0939', 'GRT'),
('2015', 'ZSOMI', 'Z'),
('2016', '1010', 'AE'),
('2016', '176', '1'),
('2016', '907', '9'),
('2016', 'A76', 'A'),
('2016', 'AE1028', 'AE'),
('2016', 'AE1042', 'AE'),
('2016', 'C49', 'C'),
('2016', 'EE1017', 'EE'),
('2016', 'MED', 'PRUEB'),
('2016', 'P16', 'P'),
('2016', 'PS1013', 'PS'),
('2016', 'PS1019', 'PS'),
('2016', 'RA11', 'RA'),
('2016', 'RL0917', 'RL'),
('2016', 'RL0928', 'RL'),
('2016', 'RL0929', 'RL'),
('2016', 'RL0945', 'RL'),
('2016', 'SAP225', 'SAP'),
('2016', 'SRB001', 'SRB'),
('2016', 'SRD508', 'SRD'),
('2016', 'TU0939', 'GRT'),
('2016', 'X01', 'X'),
('2016', 'ZSOMI', 'Z'),
('2017', '1010', 'AE'),
('2017', '176', '1'),
('2017', '907', '9'),
('2017', 'A76', 'A'),
('2017', 'AE1028', 'AE'),
('2017', 'AE1042', 'AE'),
('2017', 'C49', 'C'),
('2017', 'EE1017', 'EE'),
('2017', 'MED', 'PRUEB'),
('2017', 'P16', 'P'),
('2017', 'PS1013', 'PS'),
('2017', 'PS1019', 'PS'),
('2017', 'RA11', 'RA'),
('2017', 'RL0917', 'RL'),
('2017', 'RL0928', 'RL'),
('2017', 'RL0929', 'RL'),
('2017', 'RL0945', 'RL'),
('2017', 'SAP225', 'SAP'),
('2017', 'SRB001', 'SRB'),
('2017', 'SRD508', 'SRD'),
('2017', 'SRO006', 'SRO'),
('2017', 'TU0939', 'GRT'),
('2017', 'X01', 'X'),
('2017', 'ZSOMI', 'Z'),
('2018', '1010', 'AE'),
('2018', '176', '1'),
('2018', '907', '9'),
('2018', 'A76', 'A'),
('2018', 'AE1028', 'AE'),
('2018', 'AE1042', 'AE'),
('2018', 'C49', 'C'),
('2018', 'EE1017', 'EE'),
('2018', 'MED', 'PRUEB'),
('2018', 'P16', 'P'),
('2018', 'PS1013', 'PS'),
('2018', 'PS1019', 'PS'),
('2018', 'RA11', 'RA'),
('2018', 'RL0917', 'RL'),
('2018', 'RL0928', 'RL'),
('2018', 'RL0929', 'RL'),
('2018', 'RL0945', 'RL'),
('2018', 'SAP225', 'SAP'),
('2018', 'SRB001', 'SRB'),
('2018', 'SRD508', 'SRD'),
('2018', 'SRO006', 'SRO'),
('2018', 'TU0939', 'GRT'),
('2018', 'X01', 'X'),
('2018', 'ZSOMI', 'Z'),
('2019', '1010', 'AE'),
('2019', '176', '1'),
('2019', '907', '9'),
('2019', 'A76', 'A'),
('2019', 'AE1028', 'AE'),
('2019', 'AE1042', 'AE'),
('2019', 'C49', 'C'),
('2019', 'EE1017', 'EE'),
('2019', 'MED', 'PRUEB'),
('2019', 'P16', 'P'),
('2019', 'PS1013', 'PS'),
('2019', 'PS1019', 'PS'),
('2019', 'RA11', 'RA'),
('2019', 'RL0917', 'RL'),
('2019', 'RL0928', 'RL'),
('2019', 'RL0929', 'RL'),
('2019', 'RL0945', 'RL'),
('2019', 'SAP225', 'SAP'),
('2019', 'SRB001', 'SRB'),
('2019', 'SRD508', 'SRD'),
('2019', 'SRO006', 'SRO'),
('2019', 'TU0939', 'GRT'),
('2019', 'X01', 'X'),
('2019', 'ZSOMI', 'Z'),
('2020', '1010', 'AE'),
('2020', '176', '1'),
('2020', '907', '9'),
('2020', 'A76', 'A'),
('2020', 'AE1028', 'AE'),
('2020', 'AE1042', 'AE'),
('2020', 'C49', 'C'),
('2020', 'EE1017', 'EE'),
('2020', 'MED', 'PRUEB'),
('2020', 'P16', 'P'),
('2020', 'PS1013', 'PS'),
('2020', 'PS1019', 'PS'),
('2020', 'RA11', 'RA'),
('2020', 'RL0904', 'RL'),
('2020', 'RL0917', 'RL'),
('2020', 'RL0928', 'RL'),
('2020', 'RL0929', 'RL'),
('2020', 'RL0945', 'RL'),
('2020', 'SAP225', 'SAP'),
('2020', 'SRB001', 'SRB'),
('2020', 'SRD508', 'SRD'),
('2020', 'SRO006', 'SRO'),
('2020', 'SRO008', 'SRO'),
('2020', 'TU0939', 'GRT'),
('2020', 'X01', 'X'),
('2020', 'ZSOMI', 'Z'),
('2021', '1010', 'AE'),
('2021', '176', '1'),
('2021', '907', '9'),
('2021', 'A76', 'A'),
('2021', 'AE1028', 'AE'),
('2021', 'AE1042', 'AE'),
('2021', 'C49', 'C'),
('2021', 'EE1017', 'EE'),
('2021', 'MED', 'PRUEB'),
('2021', 'P16', 'P'),
('2021', 'PS1013', 'PS'),
('2021', 'PS1019', 'PS'),
('2021', 'RA11', 'RA'),
('2021', 'RL0904', 'RL'),
('2021', 'RL0917', 'RL'),
('2021', 'RL0919', 'RL'),
('2021', 'RL0928', 'RL'),
('2021', 'RL0929', 'RL'),
('2021', 'RL0940', 'RL'),
('2021', 'RL0944', 'RL'),
('2021', 'RL0945', 'RL'),
('2021', 'SAP225', 'SAP'),
('2021', 'SRB001', 'SRB'),
('2021', 'SRD508', 'SRD'),
('2021', 'SRO006', 'SRO'),
('2021', 'SRO008', 'SRO'),
('2021', 'TU0939', 'GRT'),
('2021', 'X01', 'X'),
('2021', 'ZSOMI', 'Z'),
('2022', '1010', 'AE'),
('2022', '176', '1'),
('2022', '907', '9'),
('2022', 'A76', 'A'),
('2022', 'AE1028', 'AE'),
('2022', 'AE1042', 'AE'),
('2022', 'C49', 'C'),
('2022', 'EE1017', 'EE'),
('2022', 'MED', 'PRUEB'),
('2022', 'P16', 'P'),
('2022', 'PS1013', 'PS'),
('2022', 'PS1019', 'PS'),
('2022', 'RA11', 'RA'),
('2022', 'RL0904', 'RL'),
('2022', 'RL0917', 'RL'),
('2022', 'RL0919', 'RL'),
('2022', 'RL0928', 'RL'),
('2022', 'RL0929', 'RL'),
('2022', 'RL0940', 'RL'),
('2022', 'RL0944', 'RL'),
('2022', 'RL0945', 'RL'),
('2022', 'SAP225', 'SAP'),
('2022', 'SRB001', 'SRB'),
('2022', 'SRD508', 'SRD'),
('2022', 'SRO006', 'SRO'),
('2022', 'SRO008', 'SRO'),
('2022', 'TU0939', 'GRT'),
('2022', 'X01', 'X'),
('2022', 'ZSOMI', 'Z'),
('2023', '1010', 'AE'),
('2023', '176', '1'),
('2023', '907', '9'),
('2023', 'A76', 'A'),
('2023', 'AE1028', 'AE'),
('2023', 'AE1042', 'AE'),
('2023', 'C49', 'C'),
('2023', 'EE1017', 'EE'),
('2023', 'MED', 'PRUEB'),
('2023', 'P16', 'P'),
('2023', 'PS1013', 'PS'),
('2023', 'PS1019', 'PS'),
('2023', 'RA11', 'RA'),
('2023', 'RL0904', 'RL'),
('2023', 'RL0917', 'RL'),
('2023', 'RL0919', 'RL'),
('2023', 'RL0928', 'RL'),
('2023', 'RL0929', 'RL'),
('2023', 'RL0940', 'RL'),
('2023', 'RL0944', 'RL'),
('2023', 'RL0945', 'RL'),
('2023', 'SAP225', 'SAP'),
('2023', 'SRB001', 'SRB'),
('2023', 'SRD508', 'SRD'),
('2023', 'SRO006', 'SRO'),
('2023', 'SRO008', 'SRO'),
('2023', 'TU0939', 'GRT'),
('2023', 'X01', 'X'),
('2023', 'ZSOMI', 'Z'),
('3', 'RC33', 'RC');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `podcursocargos`
--

CREATE TABLE `podcursocargos` (
  `curso` varchar(4) NOT NULL,
  `codcargo` varchar(4) NOT NULL,
  `creditos` decimal(6,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `podcursocargos`
--

INSERT INTO `podcursocargos` (`curso`, `codcargo`, `creditos`) VALUES
('', '1', 0.00),
('1', '1', 0.00),
('2', '1', 0.00),
('2000', '1', 0.00),
('2001', '1', 0.00),
('2002', '1', 0.00),
('2003', '1', 0.00),
('2004', '1', 0.00),
('2005', '1', 0.00),
('2006', '1', 0.00),
('2007', '1', 0.00),
('2008', '1', 0.00),
('2009', '1', 0.00),
('2010', '1', 0.00),
('3', '1', 0.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `podcursofigura`
--

CREATE TABLE `podcursofigura` (
  `curso` varchar(4) NOT NULL,
  `codfigura` varchar(4) NOT NULL,
  `creditos` decimal(6,2) DEFAULT NULL,
  `creditosmin` decimal(6,2) NOT NULL,
  `tiempo` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `podcursofigura`
--

INSERT INTO `podcursofigura` (`curso`, `codfigura`, `creditos`, `creditosmin`, `tiempo`) VALUES
('', '1', NULL, 0.00, 0),
('1', '1', NULL, 0.00, 0),
('2', '1', NULL, 0.00, 0),
('2000', '1', NULL, 0.00, 0),
('2001', '1', NULL, 0.00, 0),
('2002', '1', NULL, 0.00, 0),
('2003', '1', NULL, 0.00, 0),
('2004', '1', NULL, 0.00, 0),
('2005', '1', NULL, 0.00, 0),
('2006', '1', NULL, 0.00, 0),
('2007', '1', NULL, 0.00, 0),
('2008', '1', NULL, 0.00, 0),
('2009', '1', NULL, 0.00, 0),
('2010', '1', NULL, 0.00, 0),
('2011', '1', 0.00, 0.00, 2),
('2012', '1', 24.00, 21.00, 2),
('2012', '2', 24.00, 21.00, 2),
('2012', '3', 28.00, 24.00, 2),
('2012', '4', 24.00, 21.00, 2),
('2012', '5', 24.00, 21.00, 2),
('2012', '6', 6.00, 4.50, 2),
('2012', '7', 12.00, 6.00, 2),
('2012', '8', 18.00, 9.00, 1),
('2013', '1', 24.00, 21.00, 2),
('2013', '2', 24.00, 21.00, 2),
('2013', '3', 28.00, 24.00, 2),
('2013', '4', 24.00, 21.00, 2),
('2013', '5', 24.00, 21.00, 2),
('2013', '6', 6.00, 4.50, 2),
('2013', '7', 12.00, 6.00, 2),
('2013', '8', 18.00, 9.00, 1),
('2014', '1', 24.00, 21.00, 2),
('2014', '2', 24.00, 21.00, 2),
('2014', '3', 28.00, 24.00, 2),
('2014', '4', 24.00, 21.00, 2),
('2014', '5', 24.00, 21.00, 2),
('2014', '6', 6.00, 4.50, 2),
('2014', '7', 12.00, 6.00, 2),
('2014', '8', 18.00, 9.00, 1),
('2015', '1', 24.00, 21.00, 2),
('2015', '2', 24.00, 21.00, 2),
('2015', '3', 28.00, 24.00, 2),
('2015', '4', 24.00, 21.00, 2),
('2015', '5', 24.00, 21.00, 2),
('2015', '6', 6.00, 4.50, 2),
('2015', '7', 12.00, 6.00, 2),
('2015', '8', 18.00, 9.00, 1),
('2016', '1', 24.00, 21.00, 2),
('2016', '2', 24.00, 21.00, 2),
('2016', '3', 28.00, 24.00, 2),
('2016', '4', 24.00, 21.00, 2),
('2016', '5', 24.00, 21.00, 2),
('2016', '6', 6.00, 4.50, 2),
('2016', '7', 12.00, 6.00, 2),
('2016', '8', 18.00, 9.00, 1),
('2017', '1', 24.00, 21.00, 2),
('2017', '2', 24.00, 21.00, 2),
('2017', '3', 28.00, 24.00, 2),
('2017', '4', 24.00, 21.00, 2),
('2017', '5', 24.00, 21.00, 2),
('2017', '6', 6.00, 4.50, 2),
('2017', '7', 12.00, 6.00, 2),
('2017', '8', 18.00, 9.00, 1),
('2018', '1', 24.00, 21.00, 2),
('2018', '2', 24.00, 21.00, 2),
('2018', '3', 28.00, 24.00, 2),
('2018', '4', 24.00, 21.00, 2),
('2018', '5', 24.00, 21.00, 2),
('2018', '6', 6.00, 4.50, 2),
('2018', '7', 12.00, 6.00, 2),
('2018', '8', 18.00, 9.00, 1),
('2019', '1', 24.00, 21.00, 2),
('2019', '2', 24.00, 21.00, 2),
('2019', '3', 28.00, 24.00, 2),
('2019', '4', 24.00, 21.00, 2),
('2019', '5', 24.00, 21.00, 2),
('2019', '6', 6.00, 4.50, 2),
('2019', '7', 12.00, 6.00, 2),
('2019', '8', 18.00, 9.00, 1),
('2020', '1', 24.00, 21.00, 2),
('2020', '2', 24.00, 21.00, 2),
('2020', '3', 28.00, 24.00, 2),
('2020', '4', 24.00, 21.00, 2),
('2020', '5', 24.00, 21.00, 2),
('2020', '6', 6.00, 4.50, 2),
('2020', '7', 12.00, 6.00, 2),
('2020', '8', 18.00, 9.00, 1),
('2021', '1', 24.00, 21.00, 2),
('2021', '2', 24.00, 21.00, 2),
('2021', '3', 28.00, 24.00, 2),
('2021', '4', 24.00, 21.00, 2),
('2021', '5', 24.00, 21.00, 2),
('2021', '6', 6.00, 4.50, 2),
('2021', '7', 12.00, 6.00, 2),
('2021', '8', 18.00, 9.00, 1),
('2022', '1', 24.00, 21.00, 2),
('2022', '2', 24.00, 21.00, 2),
('2022', '3', 28.00, 24.00, 2),
('2022', '4', 24.00, 21.00, 2),
('2022', '5', 24.00, 21.00, 2),
('2022', '6', 6.00, 4.50, 2),
('2022', '7', 12.00, 6.00, 2),
('2022', '8', 18.00, 9.00, 1),
('2022', '9', 16.00, 6.00, 2),
('2023', '1', 24.00, 21.00, 2),
('2023', '2', 24.00, 21.00, 2),
('2023', '3', 28.00, 24.00, 2),
('2023', '4', 24.00, 21.00, 2),
('2023', '5', 24.00, 21.00, 2),
('2023', '6', 6.00, 4.50, 2),
('2023', '7', 12.00, 6.00, 2),
('2023', '8', 18.00, 9.00, 1),
('2023', '9', 16.00, 6.00, 2),
('3', '1', NULL, 0.00, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `podfiguras`
--

CREATE TABLE `podfiguras` (
  `cod` varchar(4) NOT NULL,
  `figura` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `podfiguras`
--

INSERT INTO `podfiguras` (`cod`, `figura`) VALUES
('1', 'No Definido'),
('2', 'Titular de Universidad'),
('3', 'Titular de Escuela Universitaria'),
('4', 'Contratado Doctor'),
('5', 'Catedrático de Universidad'),
('6', 'Ayudante'),
('7', 'Ayudante Doctor'),
('8', 'Asociado'),
('9', 'Personal investigador en formación');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `podpaneles`
--

CREATE TABLE `podpaneles` (
  `n` int(10) NOT NULL,
  `activo` int(1) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `profesores` text NOT NULL,
  `recursos` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `podtitulacion`
--

CREATE TABLE `podtitulacion` (
  `cod` varchar(5) NOT NULL,
  `titulacion` varchar(254) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `podtitulacion`
--

INSERT INTO `podtitulacion` (`cod`, `titulacion`) VALUES
('1', 'Grado en Ciencias Fantásticas Aplicadas'),
('10', 'Grado en Ingeniería de Realidades Alternativas'),
('20', 'Grado en Humanidades Imaginarias'),
('3', 'Grado en Artes y Comunicación Post-Humana'),
('4', 'Grado en Ciencias Sociales Futuristas'),
('5', 'Grado en Filosofía del Multiverso'),
('7', 'Grado en Medicina de lo Imposible'),
('9', 'Grado en Psicología de Criaturas Extrañas'),
('A', 'Grado en Inteligencia Artificial Poética'),
('AB', 'Grado en Gestión de Universos'),
('AE', 'Grado en Historia de las Ideas Imposibles'),
('AG', 'Grado en Ciencia Ficción Aplicada'),
('B', 'Grado en Antropología de lo Invisible'),
('C', 'Grado en Programación Bioemocional'),
('D', 'Grado en Química de las Sensaciones'),
('E', 'Grado en Arquitectura del Inconsciente'),
('EE', 'Grado en Filosofía del Silencio y el Vacío'),
('F', 'Grado en Lógica de los Sueños'),
('G', 'Grado en Relaciones Internacionales Interplanetarias'),
('GRT', 'Grado en Ciencias de la Nostalgia'),
('I', 'Diplomatura en Tecnología de la Magia'),
('IA', 'Diplomatura en Lingüística Paranormal'),
('IB', 'Diplomatura en Música Cuántica'),
('IG', 'Diplomatura en Ciberteología'),
('II', 'Diplomatura en Magia Comparada'),
('IS', 'Diplomatura en Narrativas Utopistas'),
('MAA', 'Diplomatura en Sociología de Mundos Distópicos'),
('MAC', 'Diplomatura en Paleontología de Seres Mitológicos'),
('MIA', 'Diplomatura en Arte Digital Fantástico'),
('MR', 'Diplomatura en Derecho de Criaturas Transdimensionales'),
('MRA', 'Diplomatura en Ética Cibernética'),
('MRB', 'Diplomatura en Neurociencia Literaria'),
('MRC', 'Diplomatura en Cartografía Interdimensional'),
('MRD', 'Diplomatura en Semiología Cuántica'),
('MRE', 'Diplomatura en Retórica Visual'),
('MT', 'Diplomatura en Historia de la Magia Urbana'),
('MX', 'Diplomatura en Teología de Sistemas Inteligentes'),
('N', 'Diplomatura en Semiología del Tiempo'),
('P', 'Diplomatura en Psicología de lo Extraordinario'),
('PRUEB', 'Diplomatura en Pensamiento Fractal'),
('PS', 'Ingeniería en Computación Onírica'),
('R', 'Ingeniería Robótica Emocional'),
('RA', 'Ingeniería de Sueños'),
('RB', 'Ingeniería de Portales Cuánticos'),
('RC', 'Ingeniería del Caos Creativo'),
('RL', 'Ingeniería de Realidades Alternativas'),
('SAP', 'Ingeniería de Lenguajes Secretos'),
('SE', 'Ingeniería de Sistemas Etéreos'),
('SRB', 'Ingeniería de Memoria Arquitectónica'),
('SRD', 'Ingeniería de Civilizaciones Simuladas'),
('SRO', 'Ingeniería de Modelos Filosófico-Matemáticos'),
('SSS', 'Ingeniería Bioética y Cuántica'),
('X', 'Ingeniería en Estética Expandida'),
('Z', 'Ingeniería Cibernética Avanzada');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pracenti`
--

CREATE TABLE `pracenti` (
  `n` int(10) NOT NULL,
  `pais` varchar(50) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `ambgeo` varchar(100) NOT NULL,
  `sector` varchar(100) NOT NULL,
  `numemp` varchar(100) NOT NULL,
  `paisactu` varchar(100) NOT NULL,
  `calle` varchar(100) NOT NULL,
  `localidad` varchar(100) NOT NULL,
  `codpos` varchar(100) NOT NULL,
  `tf` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `web` varchar(100) NOT NULL,
  `responom` varchar(100) NOT NULL,
  `respocargo` varchar(100) NOT NULL,
  `respodep` varchar(100) NOT NULL,
  `supervinom` varchar(100) NOT NULL,
  `supervicargo` varchar(100) NOT NULL,
  `supervidep` varchar(100) NOT NULL,
  `plazadescrip` longtext NOT NULL,
  `plazatitreque` varchar(100) NOT NULL,
  `plazaidiomas` varchar(100) NOT NULL,
  `plazaotros` varchar(100) NOT NULL,
  `localizplaza` varchar(100) NOT NULL,
  `numplazas` varchar(100) NOT NULL,
  `mesini` varchar(100) NOT NULL,
  `desarrpract` varchar(100) NOT NULL,
  `horario` varchar(100) NOT NULL,
  `ayudaec` varchar(100) NOT NULL,
  `ayudacanti` varchar(100) NOT NULL,
  `ayudatipo` varchar(100) NOT NULL,
  `alojamiento` varchar(100) NOT NULL,
  `recuestudiante` varchar(100) NOT NULL,
  `insercionpost` varchar(100) NOT NULL,
  `obs` longtext NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `profcurareafigura`
--

CREATE TABLE `profcurareafigura` (
  `profeid` int(10) NOT NULL,
  `curso` varchar(4) NOT NULL,
  `area` varchar(4) NOT NULL,
  `figura` int(10) NOT NULL,
  `doctor` int(1) NOT NULL,
  `credmax` decimal(6,2) NOT NULL,
  `credmin` decimal(6,2) NOT NULL,
  `credasignados` decimal(5,2) NOT NULL,
  `credasignadosn` decimal(10,2) NOT NULL,
  `examenes` varchar(30) NOT NULL,
  `exacum` varchar(30) NOT NULL,
  `n_prof` varchar(30) NOT NULL,
  `obs` varchar(255) NOT NULL,
  `obs2` varchar(255) NOT NULL,
  `mail2` varchar(50) NOT NULL,
  `telefono1` varchar(15) NOT NULL,
  `telefono` varchar(15) NOT NULL,
  `despacho` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `profecargos`
--

CREATE TABLE `profecargos` (
  `curso` varchar(4) NOT NULL,
  `profeid` int(10) NOT NULL,
  `cargo` varchar(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `profvotar`
--

CREATE TABLE `profvotar` (
  `id` int(10) NOT NULL,
  `deid` int(10) NOT NULL,
  `asicurgru` varchar(30) NOT NULL,
  `activi` int(2) NOT NULL,
  `materia` int(2) NOT NULL,
  `asist` int(2) NOT NULL,
  `fecha` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `recurgen`
--

CREATE TABLE `recurgen` (
  `id` int(11) NOT NULL,
  `titulaci` varchar(5) NOT NULL DEFAULT '',
  `asigna` varchar(15) NOT NULL DEFAULT '',
  `curso` varchar(4) NOT NULL DEFAULT '',
  `grupo` varchar(4) NOT NULL,
  `usuid` int(10) NOT NULL DEFAULT 0,
  `descrip` longtext DEFAULT NULL,
  `date` datetime NOT NULL,
  `tamatach` int(20) NOT NULL DEFAULT 0,
  `tipoatach` varchar(255) NOT NULL DEFAULT '',
  `nomatach` text NOT NULL,
  `attachment` longblob DEFAULT NULL,
  `invisible` int(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `social`
--

CREATE TABLE `social` (
  `id` int(20) NOT NULL,
  `fecha` datetime NOT NULL,
  `fmodif` datetime NOT NULL,
  `usuid` int(10) NOT NULL,
  `tabla` varchar(60) NOT NULL,
  `relid` int(20) NOT NULL,
  `titulaci` varchar(5) NOT NULL,
  `asigna` varchar(15) NOT NULL,
  `curso` varchar(4) NOT NULL,
  `grupo` varchar(4) NOT NULL,
  `sologrupotrab` int(1) NOT NULL,
  `engrupotrab` int(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `socialmgnmg`
--

CREATE TABLE `socialmgnmg` (
  `tabla` varchar(10) NOT NULL,
  `Id` int(20) NOT NULL,
  `usuid` int(10) NOT NULL,
  `mgnmg` int(1) NOT NULL,
  `fecha` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `social_fotos`
--

CREATE TABLE `social_fotos` (
  `id` int(20) NOT NULL,
  `tipo` varchar(20) NOT NULL,
  `fichfoto` longblob NOT NULL,
  `thumb` longblob NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `social_textos`
--

CREATE TABLE `social_textos` (
  `id` int(20) NOT NULL,
  `usuid` int(10) NOT NULL,
  `texto` mediumtext NOT NULL,
  `comentarioaid` int(10) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `social_textos`
--

INSERT INTO `social_textos` (`id`, `usuid`, `texto`, `comentarioaid`, `fecha`) VALUES
(7, 1, 'muy bonita', 1, '2012-12-01 12:56:27'),
(8, 306, 'escribo algo', 0, '2012-12-01 13:12:20'),
(9, 1, 'yo también', 65609, '2012-12-01 13:12:59'),
(10, 1, 'parece que funciona', 65609, '2012-12-01 13:13:30'),
(11, 306, 'lo que lea cada uno ya no sé', 65609, '2012-12-01 13:13:50'),
(12, 1, 'Me encanta estar probando esta nueva funcionalidad de EVAI al estilo de Red Social.', 0, '2015-03-25 12:42:26'),
(13, 8300, '“libre como en libertad, no como en cerveza gratis“', 0, '2015-04-15 08:37:20'),
(14, 8220, 'Cerveza gratis :)', 74700, '2015-04-15 08:38:46');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tareas`
--

CREATE TABLE `tareas` (
  `id` int(10) NOT NULL,
  `fecha` datetime NOT NULL,
  `usuario` int(10) NOT NULL,
  `resumen` varchar(50) NOT NULL,
  `detalle` longtext NOT NULL,
  `adjunto` longblob NOT NULL,
  `tipoadj` varchar(255) NOT NULL,
  `nomadj` varchar(255) NOT NULL,
  `solucion` longtext NOT NULL,
  `estado` int(1) NOT NULL,
  `motivocierre` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tempo`
--

CREATE TABLE `tempo` (
  `usu_id` int(10) NOT NULL DEFAULT 0,
  `vinculos` int(10) NOT NULL DEFAULT 0,
  `asigna` char(15) DEFAULT NULL,
  `curso` varchar(4) NOT NULL,
  `grupo` varchar(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tempoestadis`
--

CREATE TABLE `tempoestadis` (
  `id` int(10) NOT NULL,
  `asigna` varchar(15) NOT NULL,
  `curso` varchar(4) NOT NULL,
  `grupo` varchar(4) NOT NULL,
  `ultimetarea` datetime NOT NULL,
  `notatot` decimal(4,2) NOT NULL,
  `aprobado` varchar(1) NOT NULL,
  `tacumulado` int(15) DEFAULT NULL,
  `ultiacceso` datetime DEFAULT NULL,
  `numvalorfich` int(11) DEFAULT NULL,
  `mediafich` decimal(6,2) DEFAULT NULL,
  `desvtipfic` decimal(6,2) DEFAULT NULL,
  `numvalorvid` int(11) DEFAULT NULL,
  `mediavid` decimal(6,2) DEFAULT NULL,
  `desvtipvid` decimal(6,2) DEFAULT NULL,
  `numvisitas` int(11) DEFAULT NULL,
  `numvinc` int(5) NOT NULL,
  `coment` int(5) NOT NULL,
  `numvincvot` int(5) NOT NULL,
  `notaemi` decimal(4,2) NOT NULL,
  `desvtipemi` decimal(4,2) NOT NULL,
  `numvotrec` int(5) NOT NULL,
  `nota` decimal(4,2) NOT NULL,
  `desvtip` decimal(4,2) NOT NULL,
  `forowri` int(4) NOT NULL,
  `forochar` int(10) NOT NULL,
  `forovrec` int(4) NOT NULL,
  `fororecmed` decimal(4,2) NOT NULL,
  `fororecds` decimal(4,2) NOT NULL,
  `forovemi` int(4) NOT NULL,
  `foroemimed` decimal(4,2) NOT NULL,
  `foroemids` decimal(4,2) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `tempoestadis`
--

INSERT INTO `tempoestadis` (`id`, `asigna`, `curso`, `grupo`, `ultimetarea`, `notatot`, `aprobado`, `tacumulado`, `ultiacceso`, `numvalorfich`, `mediafich`, `desvtipfic`, `numvalorvid`, `mediavid`, `desvtipvid`, `numvisitas`, `numvinc`, `coment`, `numvincvot`, `notaemi`, `desvtipemi`, `numvotrec`, `nota`, `desvtip`, `forowri`, `forochar`, `forovrec`, `fororecmed`, `fororecds`, `forovemi`, `foroemimed`, `foroemids`) VALUES
(1, '', '', '', '0000-00-00 00:00:00', 0.00, '', 30039663, '2025-07-16 11:46:21', 0, 0.00, 0.00, 0, 0.00, 0.00, 9980, 0, 0, 0, 0.00, 0.00, 0, 0.00, 0.00, 0, 0, 0, 0.00, 0.00, 0, 0.00, 0.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `titcuradmi`
--

CREATE TABLE `titcuradmi` (
  `titulaci` varchar(5) NOT NULL DEFAULT '',
  `curso` varchar(4) NOT NULL DEFAULT '0',
  `usuid` int(10) NOT NULL DEFAULT 0,
  `forospormail` int(1) NOT NULL DEFAULT 0,
  `notispormail` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usosistema`
--

CREATE TABLE `usosistema` (
  `rowid` int(15) NOT NULL,
  `entra` datetime NOT NULL,
  `id` int(10) NOT NULL,
  `sesion` varchar(255) NOT NULL,
  `sale` datetime NOT NULL,
  `ip` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(10) NOT NULL,
  `tipo` char(1) NOT NULL DEFAULT '',
  `privacidad` int(1) NOT NULL DEFAULT 0,
  `usuario` varchar(15) NOT NULL DEFAULT '',
  `password` varchar(15) NOT NULL DEFAULT '',
  `passwordinicial` varchar(15) NOT NULL DEFAULT '',
  `passwordinicial_borrar` varchar(15) NOT NULL DEFAULT '',
  `ipalta` varchar(15) NOT NULL DEFAULT '',
  `mail` varchar(80) NOT NULL DEFAULT '',
  `alumnon` varchar(80) NOT NULL DEFAULT '',
  `alumnoa` varchar(100) NOT NULL DEFAULT '',
  `ppersonal` varchar(100) DEFAULT NULL,
  `ocupacion` varchar(255) NOT NULL,
  `titul` varchar(100) NOT NULL DEFAULT '',
  `universi` varchar(100) NOT NULL DEFAULT '0',
  `convocatoria` char(2) NOT NULL DEFAULT '',
  `sexo` char(1) NOT NULL DEFAULT '',
  `fnaci` date NOT NULL DEFAULT '0000-00-00',
  `pareja` char(1) NOT NULL DEFAULT '',
  `interesante` text NOT NULL,
  `wow` text NOT NULL,
  `amistad` char(1) NOT NULL DEFAULT '',
  `competencias` longtext NOT NULL,
  `mas` longtext DEFAULT NULL,
  `fecha` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `numvinc` int(5) DEFAULT NULL,
  `coment` int(5) NOT NULL DEFAULT 0,
  `numvincvot` int(5) NOT NULL DEFAULT 0,
  `numvotrec` int(5) NOT NULL DEFAULT 0,
  `nota` decimal(4,2) NOT NULL DEFAULT 0.00,
  `desvtip` decimal(4,2) NOT NULL DEFAULT 0.00,
  `ip` varchar(15) NOT NULL DEFAULT '',
  `fechaalta` date NOT NULL DEFAULT '0000-00-00',
  `fechalogin` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `tultimo` int(10) NOT NULL DEFAULT 0,
  `tacumulado` int(10) NOT NULL DEFAULT 0,
  `recarga` int(1) NOT NULL DEFAULT 0,
  `autorizado` int(1) NOT NULL DEFAULT 0,
  `texto` varchar(255) NOT NULL DEFAULT '',
  `foto` varchar(50) NOT NULL DEFAULT '',
  `video` varchar(50) NOT NULL DEFAULT '',
  `video1` varchar(255) NOT NULL,
  `msagent` varchar(10) NOT NULL DEFAULT '0',
  `rooms` varchar(128) NOT NULL DEFAULT '',
  `iconos` varchar(15) NOT NULL DEFAULT '',
  `fondo` varchar(7) NOT NULL DEFAULT '',
  `reg_time` int(11) NOT NULL DEFAULT 0,
  `dni` varchar(50) NOT NULL DEFAULT '',
  `pais` varchar(50) NOT NULL DEFAULT '',
  `provincia` varchar(50) NOT NULL DEFAULT '',
  `direccion` varchar(255) DEFAULT NULL,
  `codpos` varchar(50) NOT NULL DEFAULT '',
  `localidad` varchar(50) NOT NULL DEFAULT '',
  `saludo0` varchar(255) NOT NULL DEFAULT '',
  `saludo1` varchar(255) NOT NULL DEFAULT '',
  `buscar` varchar(255) NOT NULL DEFAULT '',
  `rotos` int(10) NOT NULL DEFAULT 0,
  `tfmovil` int(15) NOT NULL DEFAULT 0,
  `tfmovil1` char(1) NOT NULL DEFAULT '',
  `ultasigna` varchar(15) DEFAULT NULL,
  `ultcurso` varchar(4) DEFAULT NULL,
  `ultgrupo` varchar(4) DEFAULT NULL,
  `dateformat` varchar(10) NOT NULL DEFAULT '%d/%m/%Y',
  `confoto` int(1) NOT NULL DEFAULT 1,
  `callto` varchar(50) NOT NULL DEFAULT '',
  `callto1` int(1) NOT NULL DEFAULT 0,
  `perm` int(1) DEFAULT NULL,
  `numvisitas` int(10) NOT NULL DEFAULT 0,
  `menugen` int(1) NOT NULL DEFAULT 1,
  `menuasi` int(1) NOT NULL DEFAULT 1,
  `menupers` int(1) NOT NULL DEFAULT 1,
  `menuon` int(1) NOT NULL DEFAULT 1,
  `vozi` varchar(255) NOT NULL DEFAULT '',
  `voz` varchar(255) NOT NULL DEFAULT '',
  `estado` int(1) NOT NULL DEFAULT 0,
  `menus` varchar(6) NOT NULL DEFAULT '',
  `calc` longtext NOT NULL,
  `menu` int(1) NOT NULL DEFAULT 0,
  `tokbox` mediumtext NOT NULL,
  `autonoti` int(1) NOT NULL DEFAULT 0,
  `autocomen` int(1) NOT NULL DEFAULT 0,
  `fechabaja` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `codigo1` longtext NOT NULL,
  `codigo2` longtext NOT NULL,
  `codigo3` longtext NOT NULL,
  `codigo4` longtext NOT NULL,
  `curriculum` varchar(255) NOT NULL,
  `menusimple` varchar(1) NOT NULL,
  `priventwit` int(1) NOT NULL,
  `espeak` varchar(255) NOT NULL,
  `recordar` longtext NOT NULL,
  `otrospics` longtext NOT NULL,
  `otrosvideos` longtext NOT NULL,
  `geo` varchar(255) NOT NULL,
  `colores` varchar(255) NOT NULL,
  `hsmremind` datetime NOT NULL,
  `mesiento` varchar(20) NOT NULL,
  `estoy` varchar(40) NOT NULL,
  `pacadem` text DEFAULT NULL,
  `mensaje` varchar(255) NOT NULL,
  `despacho` varchar(50) NOT NULL,
  `telefono` varchar(15) NOT NULL,
  `profpanel` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `tipo`, `privacidad`, `usuario`, `password`, `passwordinicial`, `passwordinicial_borrar`, `ipalta`, `mail`, `alumnon`, `alumnoa`, `ppersonal`, `ocupacion`, `titul`, `universi`, `convocatoria`, `sexo`, `fnaci`, `pareja`, `interesante`, `wow`, `amistad`, `competencias`, `mas`, `fecha`, `numvinc`, `coment`, `numvincvot`, `numvotrec`, `nota`, `desvtip`, `ip`, `fechaalta`, `fechalogin`, `tultimo`, `tacumulado`, `recarga`, `autorizado`, `texto`, `foto`, `video`, `video1`, `msagent`, `rooms`, `iconos`, `fondo`, `reg_time`, `dni`, `pais`, `provincia`, `direccion`, `codpos`, `localidad`, `saludo0`, `saludo1`, `buscar`, `rotos`, `tfmovil`, `tfmovil1`, `ultasigna`, `ultcurso`, `ultgrupo`, `dateformat`, `confoto`, `callto`, `callto1`, `perm`, `numvisitas`, `menugen`, `menuasi`, `menupers`, `menuon`, `vozi`, `voz`, `estado`, `menus`, `calc`, `menu`, `tokbox`, `autonoti`, `autocomen`, `fechabaja`, `codigo1`, `codigo2`, `codigo3`, `codigo4`, `curriculum`, `menusimple`, `priventwit`, `espeak`, `recordar`, `otrospics`, `otrosvideos`, `geo`, `colores`, `hsmremind`, `mesiento`, `estoy`, `pacadem`, `mensaje`, `despacho`, `telefono`, `profpanel`) VALUES
(1, 'P', 0, 'agrandio', 'penchelendin60', '', '', '', '1@gmail.com', 'Antonio', 'Torrefacto Morales', '', 'Profesor', 'Doctor', '', '', 'h', '1959-02-07', 's', 'Desde joven me interesó el esoterismo, considerado como una especie de \'\'sabiduría eterna\'\' que describe la realidad oculta tras la percepción corriente. La mayoría de mis orientaciones en docencia e investigación tienen este marco conceptual como trasfondo. Llegué a ello estudiando primero astrología y cosas de OVNIS y, la verdad, he dedicado y sigo dedicando, mucho tiempo a su estudio. En pocas palabras, todo es un universo vibratorio y armónico, matemáticamente caótico, la materia y la muerte son ilusiones, el miedo y las creencias son las semillas de la corrupción. Y, aunque las religiones la han cagado con estas dos cosas, hablaban de una realidad que siempre ha estado ahí, dentro y fuera de uno mismo.', 'Sin darme cuenta, siempre voy por todas partes cantando. Mis compas de Universidad me dicen que saben que estoy porque me oyen cantar por los pasillos. El lenguaje más perfecto del universo es la música, me enferman los que desafinan en los karaokes. A los 15 años quería ser cantante. Daba recitales en muchos sitios y, acompañándome con una guitarra, cantaba a mi favorito Bob Dylan, a Leonard Cohen y a Neil Young. Hasta compuse 10 o 12 canciones propias. Hoy, como un alumno me dijo: \'\'iba para cantante y me quedé en profesor\'\'. Ya sólo canto en los karaokes snifff ¡¡triste vida!!  Si queréis saber más sobre mi, visitad mi página personal en www.antoniograndio.com', 's', 'Informática, TICC\'s, Esoterismo, Autorrealización, Espiritualidad', 'Me apasionan las tecnologías de la información, conocimiento y comunicación aplicadas a las organizaciones y a la interacción humana. Creo que \r\nentramos en un mundo virtual y que es interesante acelerar la entrada en \r\nél.', '2025-07-16 11:50:51', 0, 0, 0, 0, 0.00, 0.00, '::1', '0000-00-00', '2025-07-16 11:46:21', 7470, 30039663, 0, 10, '', 'agrandio.jpg', '', 'http://www.youtube.com/v/Kh2CXrqaIkU', 'merlin', '', 'nuvola', '#ffffcc', 1083260897, '18916345H', 'España', 'Castellón', '', '12005', 'Castellón', '¡Hola Antonio! ¡Ya está aquí tu genio para currar para ti! ¡dueño mío! Es que eres mi humano preferido. Estaba durmiendo dentro de la lámpara pero si me llamas, aquí estoy.', 'Adios Antonio, hasta pronto. Me voy a dormir dentro de la lámpara otra vez. Te echaré de menos.', 'motivación', 0, 607280730, '0', 'RL0945', '2020', 'A', '%d/%m/%Y', 0, 'agrandio1', 1, 5, 9980, 1, 1, 1, 1, '', '', 1, '121111', '', 1, '<object type=\"application/x-shockwave-flash\" data=\"http://www.tokbox.com/f/6xrZEepwNd\" width=\"428\" height=\"207\"><param name=\"movie\" value=\"http://www.tokbox.com/f/6xrZEepwNd\"></param></object><div style=\"text-align: center;\">Get your own TokBox at <a href=\"http://tokbox.com/?e=\" target=\"_blank\">www.tokbox.com</a>.</div><img style=\"visibility:hidden;width:0px;height:0px;\" border=0 width=0 height=0 src=\"http://counters.gigya.com/wildfire/CIMP/Jmx0PTExOTA1NjYwNjgxNjAmcHQ9MTE5MDU2NjA3MTA0NCZwPTEzODUxJmQ9Jm49.jpg\" />', 1, 1, '0000-00-00 00:00:00', '<object classid=\"clsid:d27cdb6e-ae6d-11cf-96b8-444553540000\" width=\"480\" height=\"296\" id=\"utv20604\"><param name=\"flashvars\" value=\"autoplay=false&brand=embed&cid=9399288&v3=1\"/><param name=\"allowfullscreen\" value=\"true\"/><param name=\"allowscriptaccess\" value=\"always\"/><param name=\"movie\" value=\"http://www.ustream.tv/flash/viewer.swf\"/><embed flashvars=\"autoplay=false&brand=embed&cid=9399288&v3=1\" width=\"480\" height=\"296\" allowfullscreen=\"true\" allowscriptaccess=\"always\" id=\"utv20604\" name=\"utv_n_481114\" src=\"http://www.ustream.tv/flash/viewer.swf\" type=\"application/x-shockwave-flash\" /></object><br /><a href=\"http://www.ustream.tv/\" style=\"padding: 2px 0px 4px; width: 400px; background: #ffffff; display: block; color: #000000; font-weight: normal; font-size: 10px; text-decoration: underline; text-align: center;\" target=\"_blank\">Free live streaming by Ustream</a></p> <iframe width=\"468\" scrolling=\"no\" height=\"586\" frameborder=\"0\" style=\"border: 0px none transparent;\" src=\"http://www.ustream.tv/socialstream/9399288\"></iframe>', '<script src=\"http://widgets.twimg.com/j/2/widget.js\"></script>\r\n<script>\r\nnew TWTR.Widget({\r\n  version: 2,\r\n  type: \'profile\',\r\n  rpp: 4,\r\n  interval: 6000,\r\n  width: \'auto\',\r\n  height: 300,\r\n  theme: {\r\n    shell: {\r\n      background: \'#333333\',\r\n      color: \'#faf8dc\'\r\n    },\r\n    tweets: {\r\n      background: \'#000000\',\r\n      color: \'#e6fae9\',\r\n      links: \'#4aed05\'\r\n    }\r\n  },\r\n  features: {\r\n    scrollbar: true,\r\n    loop: false,\r\n    live: true,\r\n    hashtags: true,\r\n    timestamp: true,\r\n    avatars: false,\r\n    behavior: \'all\'\r\n  }\r\n}).render().setUser(\'agrandio\').start();\r\n</script>', '<!-- ++Begin Video Bar Wizard Generated Code++ -->\r\n  <!--\r\n  // Created with a Google AJAX Search Wizard\r\n  // http://code.google.com/apis/ajaxsearch/wizards.html\r\n  -->\r\n\r\n  <!--\r\n  // The Following div element will end up holding the actual videobar.\r\n  // You can place this anywhere on your page.\r\n  -->\r\n  <div id=\"videoBar-bar\">\r\n    <span style=\"color:#676767;font-size:11px;margin:10px;padding:4px;\">Loading...</span>\r\n  </div>\r\n\r\n  <!-- Ajax Search Api and Stylesheet\r\n  // Note: If you are already using the AJAX Search API, then do not include it\r\n  //       or its stylesheet again\r\n  -->\r\n  <script src=\"http://www.google.com/uds/api?file=uds.js&v=1.0&source=uds-vbw\"\r\n    type=\"text/javascript\"></script>\r\n  <style type=\"text/css\">\r\n    @import url(\"http://www.google.com/uds/css/gsearch.css\");\r\n  </style>\r\n\r\n  <!-- Video Bar Code and Stylesheet -->\r\n  <script type=\"text/javascript\">\r\n    window._uds_vbw_donotrepair = true;\r\n  </script>\r\n  <script src=\"http://www.google.com/uds/solutions/videobar/gsvideobar.js?mode=new\"\r\n    type=\"text/javascript\"></script>\r\n  <style type=\"text/css\">\r\n    @import url(\"http://www.google.com/uds/solutions/videobar/gsvideobar.css\");\r\n  </style>\r\n\r\n  <style type=\"text/css\">\r\n    .playerInnerBox_gsvb .player_gsvb {\r\n      width : 320px;\r\n      height : 260px;\r\n    }\r\n  </style>\r\n  <script type=\"text/javascript\">\r\n    function LoadVideoBar() {\r\n\r\n    var videoBar;\r\n    var options = {\r\n        largeResultSet : !false,\r\n        horizontal : false,\r\n        autoExecuteList : {\r\n          cycleTime : GSvideoBar.CYCLE_TIME_MEDIUM,\r\n          cycleMode : GSvideoBar.CYCLE_MODE_LINEAR,\r\n          executeList : [\"ytchannel:agrandio3\"]\r\n        }\r\n      }\r\n\r\n    videoBar = new GSvideoBar(document.getElementById(\"videoBar-bar\"),\r\n                              GSvideoBar.PLAYER_ROOT_FLOATING,\r\n                              options);\r\n    }\r\n    // arrange for this function to be called during body.onload\r\n    // event processing\r\n    GSearch.setOnLoadCallback(LoadVideoBar);\r\n  </script>\r\n<!-- ++End Video Bar Wizard Generated Code++ -->', '<script type=\"text/javascript\" src=\"http://feedjit.com/serve/?vv=639&tft=3&dd=0&wid=6ce1919ea715581c&pid=0&proid=0&bc=FFFFFF&tc=000000&brd1=012B6B&lnk=135D9E&hc=FFFFFF&hfc=2853A8&btn=C99700&ww=200&went=10\"></script><noscript><a href=\"http://feedjit.com/\">Feedjit Live Blog Stats</a></noscript>', '', '', 0, '', '*9af24f4f7455b64f658c1ed9b9935672', '', '', '39.9777828*-0.0424934', '#b7b75e*#ffffcc*#212121*#212121*#727272*#ffffcc*#825b4c*#da5a24*#727272*#825b4c*#ffffff*#ae8171*#825b4c*#e0d8d5*#f1edec*#ffffff', '0000-00-00 00:00:00', 'smile', '', 'https://www.uji.es/departaments/emp/base/estructura/personal?p_departamento=101&p_profesor=59628', 'Director del Departamento', 'JC1010DD 8539', '', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuasi`
--

CREATE TABLE `usuasi` (
  `id` int(10) NOT NULL DEFAULT 0,
  `asigna` varchar(100) NOT NULL DEFAULT '0',
  `auto` int(1) NOT NULL DEFAULT 0,
  `numvinc` int(5) DEFAULT NULL,
  `numvotrec` int(5) NOT NULL DEFAULT 0,
  `nota` decimal(4,2) NOT NULL DEFAULT 0.00,
  `desvtip` decimal(4,2) NOT NULL DEFAULT 0.00,
  `rotos` int(10) NOT NULL DEFAULT 0,
  `anonota` int(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vconcepto`
--

CREATE TABLE `vconcepto` (
  `nconc` int(10) NOT NULL,
  `concepto` varchar(255) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vinchs2`
--

CREATE TABLE `vinchs2` (
  `id` int(10) NOT NULL DEFAULT 0,
  `usu_id` int(10) NOT NULL DEFAULT 0,
  `comentario` longtext NOT NULL,
  `fecha` datetime NOT NULL,
  `oculto` int(1) NOT NULL,
  `rowid` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vinctempo`
--

CREATE TABLE `vinctempo` (
  `usuid` int(10) NOT NULL,
  `vinc` int(10) NOT NULL,
  `asigna` varchar(15) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vinculos`
--

CREATE TABLE `vinculos` (
  `id` int(10) NOT NULL,
  `usu_id` int(10) NOT NULL DEFAULT 0,
  `area` varchar(50) NOT NULL DEFAULT '',
  `titulo` varchar(120) NOT NULL DEFAULT '',
  `url` varchar(255) NOT NULL DEFAULT '',
  `url_local` varchar(255) NOT NULL DEFAULT '',
  `claves` varchar(255) NOT NULL DEFAULT '',
  `fecha` varchar(14) DEFAULT NULL,
  `fechacrea` varchar(14) NOT NULL DEFAULT '',
  `resumen` varchar(255) NOT NULL DEFAULT '',
  `amplia` longtext DEFAULT NULL,
  `desvtip` decimal(5,2) DEFAULT 0.00,
  `nota` decimal(4,2) DEFAULT 0.00,
  `numvotos` int(5) DEFAULT 0,
  `clicks` int(5) NOT NULL DEFAULT 0,
  `roto` char(1) NOT NULL DEFAULT '',
  `idioma` char(1) NOT NULL DEFAULT '',
  `idcat` int(10) NOT NULL DEFAULT 0,
  `gc0` char(1) NOT NULL DEFAULT '',
  `gc1` char(1) NOT NULL DEFAULT '',
  `gc2` char(1) NOT NULL DEFAULT '',
  `gc3` char(1) NOT NULL DEFAULT '',
  `gc4` char(1) NOT NULL DEFAULT '',
  `curso` varchar(4) NOT NULL DEFAULT '',
  `grupo` varchar(1) NOT NULL DEFAULT '',
  `dirimagen` varchar(255) NOT NULL,
  `sologrupotrab` int(1) NOT NULL,
  `engrupotrab` int(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `votos`
--

CREATE TABLE `votos` (
  `vinculo_id` int(10) NOT NULL DEFAULT 0,
  `usu_id` int(10) NOT NULL DEFAULT 0,
  `votos` int(2) NOT NULL DEFAULT 0,
  `rigor` int(2) NOT NULL DEFAULT 0,
  `metodologia` int(2) NOT NULL DEFAULT 0,
  `contenido` int(2) NOT NULL DEFAULT 0,
  `originalidad` int(2) NOT NULL DEFAULT 0,
  `utilidad` int(2) NOT NULL DEFAULT 0,
  `global` int(2) NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `alumasiano`
--
ALTER TABLE `alumasiano`
  ADD PRIMARY KEY (`id`,`asigna`,`curso`),
  ADD KEY `id` (`id`),
  ADD KEY `cursoasignagrupo` (`curso`,`asigna`,`grupo`);

--
-- Indices de la tabla `asignatprof`
--
ALTER TABLE `asignatprof`
  ADD PRIMARY KEY (`curso`,`asigna`,`grupo`,`usuid`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `cursoareausuid` (`curso`,`area`,`usuid`),
  ADD KEY `cursoasignaarea` (`curso`,`asigna`,`area`),
  ADD KEY `cursoasignagrupo` (`curso`,`asigna`,`grupo`),
  ADD KEY `usuid` (`usuid`),
  ADD KEY `asigna` (`asigna`),
  ADD KEY `grupo` (`grupo`);

--
-- Indices de la tabla `asistencia`
--
ALTER TABLE `asistencia`
  ADD PRIMARY KEY (`usuid`,`asigna`,`curso`,`grupo`,`fecha`);

--
-- Indices de la tabla `bancot1`
--
ALTER TABLE `bancot1`
  ADD PRIMARY KEY (`bancoid`);

--
-- Indices de la tabla `bancot2`
--
ALTER TABLE `bancot2`
  ADD KEY `bancoid` (`bancoid`);

--
-- Indices de la tabla `boletin`
--
ALTER TABLE `boletin`
  ADD UNIQUE KEY `id_2` (`id`),
  ADD KEY `id` (`id`);

--
-- Indices de la tabla `b_autores`
--
ALTER TABLE `b_autores`
  ADD PRIMARY KEY (`cod`),
  ADD UNIQUE KEY `autttores_idx1` (`cod`);

--
-- Indices de la tabla `b_editoriales`
--
ALTER TABLE `b_editoriales`
  ADD PRIMARY KEY (`cod`),
  ADD UNIQUE KEY `cod` (`cod`);

--
-- Indices de la tabla `b_material`
--
ALTER TABLE `b_material`
  ADD PRIMARY KEY (`cod`);

--
-- Indices de la tabla `b_submaterial`
--
ALTER TABLE `b_submaterial`
  ADD PRIMARY KEY (`cod`);

--
-- Indices de la tabla `carpprofcoment`
--
ALTER TABLE `carpprofcoment`
  ADD UNIQUE KEY `id` (`id`);

--
-- Indices de la tabla `carpprofregactivi`
--
ALTER TABLE `carpprofregactivi`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `chat`
--
ALTER TABLE `chat`
  ADD PRIMARY KEY (`usuid`,`asigna`);

--
-- Indices de la tabla `chatlista`
--
ALTER TABLE `chatlista`
  ADD PRIMARY KEY (`n`);

--
-- Indices de la tabla `clasesgrab`
--
ALTER TABLE `clasesgrab`
  ADD PRIMARY KEY (`id`),
  ADD KEY `autor` (`autor`);

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD UNIQUE KEY `dni` (`dni`);

--
-- Indices de la tabla `control`
--
ALTER TABLE `control`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `convenios`
--
ALTER TABLE `convenios`
  ADD PRIMARY KEY (`n`),
  ADD KEY `entidad` (`entidad`);

--
-- Indices de la tabla `conventid`
--
ALTER TABLE `conventid`
  ADD PRIMARY KEY (`n`);

--
-- Indices de la tabla `convsolicitudes`
--
ALTER TABLE `convsolicitudes`
  ADD PRIMARY KEY (`convenio`,`alumno`),
  ADD KEY `alumno` (`alumno`);

--
-- Indices de la tabla `convtitul`
--
ALTER TABLE `convtitul`
  ADD PRIMARY KEY (`n`);

--
-- Indices de la tabla `cuentas`
--
ALTER TABLE `cuentas`
  ADD PRIMARY KEY (`row_id`),
  ADD UNIQUE KEY `cuenta` (`cuenta`);

--
-- Indices de la tabla `cuentas4`
--
ALTER TABLE `cuentas4`
  ADD PRIMARY KEY (`row_id`),
  ADD UNIQUE KEY `cuenta` (`cuenta`);

--
-- Indices de la tabla `cuentas5`
--
ALTER TABLE `cuentas5`
  ADD PRIMARY KEY (`row_id`),
  ADD UNIQUE KEY `cuenta` (`cuenta`);

--
-- Indices de la tabla `cursasigru`
--
ALTER TABLE `cursasigru`
  ADD PRIMARY KEY (`curso`,`asigna`,`grupo`),
  ADD KEY `asigna` (`asigna`),
  ADD KEY `curso` (`curso`),
  ADD KEY `grupo` (`grupo`);

--
-- Indices de la tabla `cursoareagrupoa`
--
ALTER TABLE `cursoareagrupoa`
  ADD PRIMARY KEY (`curso`,`area`,`grupoa`),
  ADD KEY `area` (`area`),
  ADD KEY `respons` (`respons`);

--
-- Indices de la tabla `enviospor`
--
ALTER TABLE `enviospor`
  ADD PRIMARY KEY (`n`),
  ADD UNIQUE KEY `n` (`n`);

--
-- Indices de la tabla `ex_aulas`
--
ALTER TABLE `ex_aulas`
  ADD PRIMARY KEY (`cod`);

--
-- Indices de la tabla `ex_examen`
--
ALTER TABLE `ex_examen`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `asigna` (`asigna`,`curso`,`grupo`,`conv`);

--
-- Indices de la tabla `ex_prof`
--
ALTER TABLE `ex_prof`
  ADD PRIMARY KEY (`codprof`,`examen`);

--
-- Indices de la tabla `ex_tot`
--
ALTER TABLE `ex_tot`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `factemi`
--
ALTER TABLE `factemi`
  ADD UNIQUE KEY `n_` (`n_`);

--
-- Indices de la tabla `factrec`
--
ALTER TABLE `factrec`
  ADD PRIMARY KEY (`row_id`);

--
-- Indices de la tabla `faq`
--
ALTER TABLE `faq`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `fichaactualiz`
--
ALTER TABLE `fichaactualiz`
  ADD PRIMARY KEY (`usuid`);

--
-- Indices de la tabla `fichaanotaci`
--
ALTER TABLE `fichaanotaci`
  ADD PRIMARY KEY (`n`);

--
-- Indices de la tabla `foro`
--
ALTER TABLE `foro`
  ADD PRIMARY KEY (`id`),
  ADD KEY `titulaci` (`titulaci`);

--
-- Indices de la tabla `forocategorias`
--
ALTER TABLE `forocategorias`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tit` (`tit`,`asigna`,`palabra`);

--
-- Indices de la tabla `forogrupos`
--
ALTER TABLE `forogrupos`
  ADD UNIQUE KEY `id_2` (`id`),
  ADD KEY `id` (`id`);

--
-- Indices de la tabla `gc1`
--
ALTER TABLE `gc1`
  ADD PRIMARY KEY (`n`);

--
-- Indices de la tabla `grabaciones`
--
ALTER TABLE `grabaciones`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`);

--
-- Indices de la tabla `grupos`
--
ALTER TABLE `grupos`
  ADD UNIQUE KEY `grupo` (`grupo`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indices de la tabla `gruposexpo`
--
ALTER TABLE `gruposexpo`
  ADD PRIMARY KEY (`row_id`);

--
-- Indices de la tabla `gruposexpotit`
--
ALTER TABLE `gruposexpotit`
  ADD PRIMARY KEY (`row_id`);

--
-- Indices de la tabla `gruposusu`
--
ALTER TABLE `gruposusu`
  ADD PRIMARY KEY (`grupo_id`,`usu_id`);

--
-- Indices de la tabla `idioma`
--
ALTER TABLE `idioma`
  ADD PRIMARY KEY (`m`);

--
-- Indices de la tabla `invent`
--
ALTER TABLE `invent`
  ADD PRIMARY KEY (`row_id`);

--
-- Indices de la tabla `iva`
--
ALTER TABLE `iva`
  ADD PRIMARY KEY (`n`),
  ADD UNIQUE KEY `iva` (`iva`);

--
-- Indices de la tabla `mailrec`
--
ALTER TABLE `mailrec`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `mandoadist`
--
ALTER TABLE `mandoadist`
  ADD PRIMARY KEY (`asigna`,`curso`,`grupo`,`usuid`),
  ADD KEY `click` (`click`);

--
-- Indices de la tabla `maquinas`
--
ALTER TABLE `maquinas`
  ADD KEY `id` (`id`);

--
-- Indices de la tabla `merlinhabla`
--
ALTER TABLE `merlinhabla`
  ADD UNIQUE KEY `frase` (`frase`,`usuid`);

--
-- Indices de la tabla `message_evai`
--
ALTER TABLE `message_evai`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`);

--
-- Indices de la tabla `message_evai_usus`
--
ALTER TABLE `message_evai_usus`
  ADD PRIMARY KEY (`usuid`,`parausuid`);

--
-- Indices de la tabla `message_humansite_usus`
--
ALTER TABLE `message_humansite_usus`
  ADD PRIMARY KEY (`usuid`,`parausuid`);

--
-- Indices de la tabla `noticias`
--
ALTER TABLE `noticias`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `podareagruposa`
--
ALTER TABLE `podareagruposa`
  ADD PRIMARY KEY (`area`,`cod`);

--
-- Indices de la tabla `podareas`
--
ALTER TABLE `podareas`
  ADD PRIMARY KEY (`codarea`);

--
-- Indices de la tabla `podasignaturas`
--
ALTER TABLE `podasignaturas`
  ADD PRIMARY KEY (`cod`);

--
-- Indices de la tabla `podcargos`
--
ALTER TABLE `podcargos`
  ADD PRIMARY KEY (`cod`);

--
-- Indices de la tabla `podcursoareagruposa`
--
ALTER TABLE `podcursoareagruposa`
  ADD PRIMARY KEY (`curso`,`area`,`cod`),
  ADD KEY `areacod` (`area`,`cod`),
  ADD KEY `cod` (`cod`);

--
-- Indices de la tabla `podcursoasigna`
--
ALTER TABLE `podcursoasigna`
  ADD PRIMARY KEY (`curso`,`asigna`),
  ADD KEY `asigna` (`asigna`);

--
-- Indices de la tabla `podcursoasignaarea`
--
ALTER TABLE `podcursoasignaarea`
  ADD PRIMARY KEY (`curso`,`asigna`,`area`),
  ADD KEY `area` (`area`),
  ADD KEY `asigna` (`asigna`);

--
-- Indices de la tabla `podcursoasignatit`
--
ALTER TABLE `podcursoasignatit`
  ADD PRIMARY KEY (`curso`,`asigna`,`tit`),
  ADD KEY `tit` (`tit`),
  ADD KEY `asigna` (`asigna`);

--
-- Indices de la tabla `podcursocargos`
--
ALTER TABLE `podcursocargos`
  ADD PRIMARY KEY (`curso`,`codcargo`),
  ADD KEY `codcargo` (`codcargo`);

--
-- Indices de la tabla `podcursofigura`
--
ALTER TABLE `podcursofigura`
  ADD PRIMARY KEY (`curso`,`codfigura`),
  ADD KEY `codfigura` (`codfigura`);

--
-- Indices de la tabla `podfiguras`
--
ALTER TABLE `podfiguras`
  ADD PRIMARY KEY (`cod`);

--
-- Indices de la tabla `podpaneles`
--
ALTER TABLE `podpaneles`
  ADD PRIMARY KEY (`n`);

--
-- Indices de la tabla `podtitulacion`
--
ALTER TABLE `podtitulacion`
  ADD PRIMARY KEY (`cod`);

--
-- Indices de la tabla `pracenti`
--
ALTER TABLE `pracenti`
  ADD PRIMARY KEY (`n`);

--
-- Indices de la tabla `profcurareafigura`
--
ALTER TABLE `profcurareafigura`
  ADD PRIMARY KEY (`curso`,`profeid`),
  ADD KEY `profeid` (`profeid`),
  ADD KEY `cursofigura` (`curso`,`figura`),
  ADD KEY `area` (`area`),
  ADD KEY `cursoareaprofid` (`curso`,`area`,`profeid`);

--
-- Indices de la tabla `profecargos`
--
ALTER TABLE `profecargos`
  ADD PRIMARY KEY (`curso`,`profeid`,`cargo`),
  ADD KEY `curso` (`curso`,`cargo`);

--
-- Indices de la tabla `recurgen`
--
ALTER TABLE `recurgen`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `social`
--
ALTER TABLE `social`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `usuid` (`usuid`,`tabla`,`relid`);

--
-- Indices de la tabla `socialmgnmg`
--
ALTER TABLE `socialmgnmg`
  ADD UNIQUE KEY `tabla` (`tabla`,`Id`,`usuid`);

--
-- Indices de la tabla `social_fotos`
--
ALTER TABLE `social_fotos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `social_textos`
--
ALTER TABLE `social_textos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tareas`
--
ALTER TABLE `tareas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tempoestadis`
--
ALTER TABLE `tempoestadis`
  ADD UNIQUE KEY `id` (`id`,`asigna`,`curso`,`grupo`);

--
-- Indices de la tabla `titcuradmi`
--
ALTER TABLE `titcuradmi`
  ADD PRIMARY KEY (`titulaci`,`curso`,`usuid`),
  ADD KEY `usuid` (`usuid`);

--
-- Indices de la tabla `usosistema`
--
ALTER TABLE `usosistema`
  ADD PRIMARY KEY (`rowid`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `mail` (`mail`),
  ADD UNIQUE KEY `usuario` (`usuario`);

--
-- Indices de la tabla `usuasi`
--
ALTER TABLE `usuasi`
  ADD PRIMARY KEY (`id`,`asigna`),
  ADD KEY `usuasi_ibfk_2` (`asigna`);

--
-- Indices de la tabla `vconcepto`
--
ALTER TABLE `vconcepto`
  ADD PRIMARY KEY (`nconc`);

--
-- Indices de la tabla `vinchs2`
--
ALTER TABLE `vinchs2`
  ADD PRIMARY KEY (`rowid`);
ALTER TABLE `vinchs2` ADD FULLTEXT KEY `comentario` (`comentario`);

--
-- Indices de la tabla `vinculos`
--
ALTER TABLE `vinculos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `url` (`url`);
ALTER TABLE `vinculos` ADD FULLTEXT KEY `area` (`area`,`titulo`,`url`,`claves`,`resumen`,`amplia`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `asignatprof`
--
ALTER TABLE `asignatprof`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `bancot1`
--
ALTER TABLE `bancot1`
  MODIFY `bancoid` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `boletin`
--
ALTER TABLE `boletin`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `b_autores`
--
ALTER TABLE `b_autores`
  MODIFY `cod` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `b_editoriales`
--
ALTER TABLE `b_editoriales`
  MODIFY `cod` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `b_material`
--
ALTER TABLE `b_material`
  MODIFY `cod` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `b_submaterial`
--
ALTER TABLE `b_submaterial`
  MODIFY `cod` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `carpprofcoment`
--
ALTER TABLE `carpprofcoment`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `carpprofregactivi`
--
ALTER TABLE `carpprofregactivi`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `chatlista`
--
ALTER TABLE `chatlista`
  MODIFY `n` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `clasesgrab`
--
ALTER TABLE `clasesgrab`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `control`
--
ALTER TABLE `control`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `convenios`
--
ALTER TABLE `convenios`
  MODIFY `n` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `conventid`
--
ALTER TABLE `conventid`
  MODIFY `n` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `convtitul`
--
ALTER TABLE `convtitul`
  MODIFY `n` int(3) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `cuentas`
--
ALTER TABLE `cuentas`
  MODIFY `row_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `cuentas4`
--
ALTER TABLE `cuentas4`
  MODIFY `row_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `cuentas5`
--
ALTER TABLE `cuentas5`
  MODIFY `row_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `enviospor`
--
ALTER TABLE `enviospor`
  MODIFY `n` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `ex_aulas`
--
ALTER TABLE `ex_aulas`
  MODIFY `cod` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `ex_examen`
--
ALTER TABLE `ex_examen`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT de la tabla `factrec`
--
ALTER TABLE `factrec`
  MODIFY `row_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `faq`
--
ALTER TABLE `faq`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `fichaanotaci`
--
ALTER TABLE `fichaanotaci`
  MODIFY `n` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `foro`
--
ALTER TABLE `foro`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `forocategorias`
--
ALTER TABLE `forocategorias`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `forogrupos`
--
ALTER TABLE `forogrupos`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `gc1`
--
ALTER TABLE `gc1`
  MODIFY `n` int(2) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `grabaciones`
--
ALTER TABLE `grabaciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `grupos`
--
ALTER TABLE `grupos`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `gruposexpo`
--
ALTER TABLE `gruposexpo`
  MODIFY `row_id` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT de la tabla `gruposexpotit`
--
ALTER TABLE `gruposexpotit`
  MODIFY `row_id` int(15) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `invent`
--
ALTER TABLE `invent`
  MODIFY `row_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `iva`
--
ALTER TABLE `iva`
  MODIFY `n` int(3) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `mailrec`
--
ALTER TABLE `mailrec`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `maquinas`
--
ALTER TABLE `maquinas`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT de la tabla `message_evai`
--
ALTER TABLE `message_evai`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `noticias`
--
ALTER TABLE `noticias`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `podpaneles`
--
ALTER TABLE `podpaneles`
  MODIFY `n` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `pracenti`
--
ALTER TABLE `pracenti`
  MODIFY `n` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT de la tabla `recurgen`
--
ALTER TABLE `recurgen`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `social`
--
ALTER TABLE `social`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `social_fotos`
--
ALTER TABLE `social_fotos`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `social_textos`
--
ALTER TABLE `social_textos`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `tareas`
--
ALTER TABLE `tareas`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usosistema`
--
ALTER TABLE `usosistema`
  MODIFY `rowid` int(15) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=239415;

--
-- AUTO_INCREMENT de la tabla `vconcepto`
--
ALTER TABLE `vconcepto`
  MODIFY `nconc` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `vinchs2`
--
ALTER TABLE `vinchs2`
  MODIFY `rowid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `vinculos`
--
ALTER TABLE `vinculos`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `asignatprof`
--
ALTER TABLE `asignatprof`
  ADD CONSTRAINT `asignatprof_ibfk_3` FOREIGN KEY (`usuid`) REFERENCES `usuarios` (`id`);

--
-- Filtros para la tabla `bancot2`
--
ALTER TABLE `bancot2`
  ADD CONSTRAINT `bancot2_ibfk_1` FOREIGN KEY (`bancoid`) REFERENCES `bancot1` (`bancoid`);

--
-- Filtros para la tabla `podcursoareagruposa`
--
ALTER TABLE `podcursoareagruposa`
  ADD CONSTRAINT `podcursoareagruposa_ibfk_1` FOREIGN KEY (`curso`) REFERENCES `podcursoasigna` (`curso`),
  ADD CONSTRAINT `podcursoareagruposa_ibfk_2` FOREIGN KEY (`area`) REFERENCES `podareas` (`codarea`),
  ADD CONSTRAINT `podcursoareagruposa_ibfk_3` FOREIGN KEY (`cod`) REFERENCES `podcursoasigna` (`asigna`);

--
-- Filtros para la tabla `podcursoasigna`
--
ALTER TABLE `podcursoasigna`
  ADD CONSTRAINT `podcursoasigna_ibfk_1` FOREIGN KEY (`asigna`) REFERENCES `podasignaturas` (`cod`);

--
-- Filtros para la tabla `podcursoasignaarea`
--
ALTER TABLE `podcursoasignaarea`
  ADD CONSTRAINT `podcursoasignaarea_ibfk_3` FOREIGN KEY (`area`) REFERENCES `podareas` (`codarea`);

--
-- Filtros para la tabla `podcursoasignatit`
--
ALTER TABLE `podcursoasignatit`
  ADD CONSTRAINT `podcursoasignatit_ibfk_3` FOREIGN KEY (`tit`) REFERENCES `podtitulacion` (`cod`);

--
-- Filtros para la tabla `podcursocargos`
--
ALTER TABLE `podcursocargos`
  ADD CONSTRAINT `podcursocargos_ibfk_1` FOREIGN KEY (`codcargo`) REFERENCES `podcargos` (`cod`);

--
-- Filtros para la tabla `podcursofigura`
--
ALTER TABLE `podcursofigura`
  ADD CONSTRAINT `podcursofigura_ibfk_1` FOREIGN KEY (`codfigura`) REFERENCES `podfiguras` (`cod`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
