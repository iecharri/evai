-- phpMyAdmin SQL Dump
-- version 5.2.1deb3
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 16-07-2025 a las 11:51:31
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
-- Base de datos: `evai_cuest`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cuestionario_`
--

CREATE TABLE `cuestionario_` (
  `n` int(3) NOT NULL DEFAULT 0,
  `n1` int(2) NOT NULL DEFAULT 0,
  `p` varchar(255) DEFAULT NULL,
  `tipo` char(1) DEFAULT NULL,
  `amin` int(3) DEFAULT NULL,
  `amax` int(3) DEFAULT NULL,
  `input` varchar(50) DEFAULT NULL,
  `m` decimal(4,2) DEFAULT NULL,
  `d` decimal(3,2) DEFAULT NULL,
  `r` longtext DEFAULT NULL,
  `respcorr` int(2) NOT NULL,
  `pordefec` int(1) NOT NULL,
  `tipofich` varchar(255) DEFAULT NULL,
  `imagen` longblob NOT NULL,
  `ancho` varchar(3) DEFAULT NULL,
  `anchoyoutube` varchar(3) DEFAULT NULL,
  `orden` int(6) DEFAULT 999999
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cuestionario_ppal1`
--

CREATE TABLE `cuestionario_ppal1` (
  `n` int(3) NOT NULL DEFAULT 0,
  `n1` int(2) NOT NULL DEFAULT 0,
  `p` longtext DEFAULT NULL,
  `tipo` char(1) DEFAULT NULL,
  `amin` int(3) DEFAULT NULL,
  `amax` int(3) DEFAULT NULL,
  `input` varchar(50) DEFAULT NULL,
  `defec` varchar(30) DEFAULT NULL,
  `m` decimal(4,2) DEFAULT NULL,
  `d` decimal(3,2) DEFAULT NULL,
  `r` longtext DEFAULT NULL,
  `respcorr` int(2) NOT NULL,
  `visible` int(1) DEFAULT NULL,
  `guardar` int(1) DEFAULT NULL,
  `mn` int(4) DEFAULT NULL,
  `visialuresp` int(1) NOT NULL,
  `formula` varchar(30) DEFAULT NULL,
  `ordenadas` int(1) DEFAULT NULL,
  `alfabet` int(1) DEFAULT NULL,
  `imagen` longblob NOT NULL,
  `tipofich` varchar(255) DEFAULT NULL,
  `ancho` varchar(3) DEFAULT NULL,
  `youtube` varchar(255) DEFAULT NULL,
  `anchoyoutube` varchar(3) DEFAULT NULL,
  `sinnum` int(1) DEFAULT NULL,
  `orden` int(6) DEFAULT 999999
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cuestionario_ppal2`
--

CREATE TABLE `cuestionario_ppal2` (
  `u` varchar(16) DEFAULT NULL,
  `cu` int(11) NOT NULL DEFAULT 0,
  `n` int(3) NOT NULL DEFAULT 0,
  `v1` int(10) DEFAULT NULL,
  `v2` varchar(255) NOT NULL DEFAULT '',
  `v3` longtext NOT NULL,
  `r` varchar(255) NOT NULL DEFAULT '',
  `usuid` int(10) NOT NULL DEFAULT 0,
  `obs` varchar(255) NOT NULL DEFAULT '',
  `feedback` longtext NOT NULL,
  `datetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `t_ini` datetime NOT NULL,
  `aciertoerror` int(1) NOT NULL,
  `nota` decimal(4,2) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `cuestionario_`
--
ALTER TABLE `cuestionario_`
  ADD PRIMARY KEY (`n`,`n1`);

--
-- Indices de la tabla `cuestionario_ppal1`
--
ALTER TABLE `cuestionario_ppal1`
  ADD PRIMARY KEY (`n`,`n1`);

--
-- Indices de la tabla `cuestionario_ppal2`
--
ALTER TABLE `cuestionario_ppal2`
  ADD PRIMARY KEY (`cu`,`n`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
