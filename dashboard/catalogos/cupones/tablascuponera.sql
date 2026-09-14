-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 07-08-2021 a las 00:37:35
-- Versión del servidor: 10.4.20-MariaDB
-- Versión de PHP: 7.3.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `market-prueba`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cuponclientes`
--

CREATE TABLE `cuponclientes` (
  `idcuponcliente` int(11) NOT NULL,
  `idcupon` int(11) NOT NULL,
  `idcliente` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cupones`
--

CREATE TABLE `cupones` (
  `idcupon` int(11) NOT NULL,
  `codigocupon` varchar(5) NOT NULL,
  `fechainicial` varchar(45) DEFAULT NULL,
  `fechafinal` varchar(45) DEFAULT NULL,
  `horainicial` varchar(45) DEFAULT NULL,
  `horafinal` varchar(45) DEFAULT NULL,
  `tipodescuento` tinyint(1) NOT NULL,
  `descuento` int(11) NOT NULL,
  `lusocliente` int(11) DEFAULT NULL,
  `lusodia` int(11) DEFAULT NULL,
  `lusosucursal` int(11) DEFAULT NULL,
  `lusototal` int(11) DEFAULT NULL,
  `tsucursales` tinyint(1) NOT NULL DEFAULT 0,
  `tpaquetes` tinyint(1) NOT NULL DEFAULT 0,
  `tclientes` tinyint(1) NOT NULL DEFAULT 0,
  `aplicarsobrepromo` tinyint(4) NOT NULL DEFAULT 0,
  `montocompra` int(11) NOT NULL DEFAULT 0,
  `cantidadcompra` int(11) NOT NULL DEFAULT 0,
  `estatus` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cuponpaquetes`
--

CREATE TABLE `cuponpaquetes` (
  `idcuponpaquete` int(11) NOT NULL,
  `idcupon` int(11) NOT NULL,
  `idpaquete` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cuponsucursales`
--

CREATE TABLE `cuponsucursales` (
  `idcuponsucursal` int(11) NOT NULL,
  `idcupon` int(11) DEFAULT NULL,
  `idsucursal` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `cuponclientes`
--
ALTER TABLE `cuponclientes`
  ADD PRIMARY KEY (`idcuponcliente`);

--
-- Indices de la tabla `cupones`
--
ALTER TABLE `cupones`
  ADD PRIMARY KEY (`idcupon`);

--
-- Indices de la tabla `cuponpaquetes`
--
ALTER TABLE `cuponpaquetes`
  ADD PRIMARY KEY (`idcuponpaquete`);

--
-- Indices de la tabla `cuponsucursales`
--
ALTER TABLE `cuponsucursales`
  ADD PRIMARY KEY (`idcuponsucursal`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `cuponclientes`
--
ALTER TABLE `cuponclientes`
  MODIFY `idcuponcliente` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `cupones`
--
ALTER TABLE `cupones`
  MODIFY `idcupon` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `cuponpaquetes`
--
ALTER TABLE `cuponpaquetes`
  MODIFY `idcuponpaquete` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `cuponsucursales`
--
ALTER TABLE `cuponsucursales`
  MODIFY `idcuponsucursal` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
