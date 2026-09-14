/*
 Navicat Premium Data Transfer

 Source Server         : localhost
 Source Server Type    : MySQL
 Source Server Version : 80040 (8.0.40)
 Source Host           : localhost:8889
 Source Schema         : baseboda

 Target Server Type    : MySQL
 Target Server Version : 80040 (8.0.40)
 File Encoding         : 65001

 Date: 12/09/2026 20:02:05
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for comentarios
-- ----------------------------
DROP TABLE IF EXISTS `comentarios`;
CREATE TABLE `comentarios` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_foto` int NOT NULL,
  `nombre_comentador` varchar(255) NOT NULL,
  `comentario` text NOT NULL,
  `fecha_comentario` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_foto` (`id_foto`),
  CONSTRAINT `comentarios_ibfk_1` FOREIGN KEY (`id_foto`) REFERENCES `fotos_boda` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3;

-- ----------------------------
-- Table structure for fotos_boda
-- ----------------------------
DROP TABLE IF EXISTS `fotos_boda`;
CREATE TABLE `fotos_boda` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre_subida` varchar(255) NOT NULL,
  `nombre_archivo` varchar(255) NOT NULL,
  `fecha_subida` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb3;

-- ----------------------------
-- Table structure for modulos
-- ----------------------------
DROP TABLE IF EXISTS `modulos`;
CREATE TABLE `modulos` (
  `idmodulos` int NOT NULL AUTO_INCREMENT,
  `modulo` varchar(100) NOT NULL,
  `nivel` int NOT NULL DEFAULT '0',
  `estatus` int DEFAULT '1' COMMENT '0 - No activo\\n1 - Activo',
  `icono` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`idmodulos`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=utf8mb3;

-- ----------------------------
-- Table structure for modulos_menu
-- ----------------------------
DROP TABLE IF EXISTS `modulos_menu`;
CREATE TABLE `modulos_menu` (
  `idmodulos_menu` int NOT NULL AUTO_INCREMENT,
  `idmodulos` int NOT NULL,
  `menu` varchar(100) NOT NULL,
  `archivo` varchar(100) NOT NULL,
  `ubicacion_archivo` varchar(100) NOT NULL,
  `nivel` int NOT NULL DEFAULT '0',
  `estatus` int DEFAULT '1' COMMENT '0 - No activo\\n1 - Activo',
  `icono` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`idmodulos_menu`) USING BTREE,
  KEY `modulos_menu_ibfk_1_idx` (`idmodulos`) USING BTREE,
  CONSTRAINT `modulos_menu_ibfk_1` FOREIGN KEY (`idmodulos`) REFERENCES `modulos` (`idmodulos`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=154 DEFAULT CHARSET=utf8mb3;

-- ----------------------------
-- Table structure for monedero
-- ----------------------------
DROP TABLE IF EXISTS `monedero`;
CREATE TABLE `monedero` (
  `idmonedero` int NOT NULL AUTO_INCREMENT,
  `fecha` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `monto` float(10,2) DEFAULT NULL,
  `modalidad` int DEFAULT NULL COMMENT '0 - pago caja\n1 - por devolución\n2 - por deposito\n3 - Cancelacion\n4 - retiro de monedero',
  `tipo` varchar(45) DEFAULT NULL COMMENT '0 - ABONO\n1 - CARGO',
  `saldo_ant` float(10,5) DEFAULT NULL,
  `saldo_act` float(10,2) DEFAULT NULL,
  `concepto` varchar(255) DEFAULT NULL,
  `idusuarios` int NOT NULL,
  `idnota` int DEFAULT '0',
  `idcita` int DEFAULT NULL,
  `idnotadescripcion` int DEFAULT NULL,
  PRIMARY KEY (`idmonedero`),
  KEY `idusuarios_idx` (`idusuarios`),
  CONSTRAINT `monedero_ibfk_1` FOREIGN KEY (`idusuarios`) REFERENCES `usuarios` (`idusuarios`)
) ENGINE=InnoDB AUTO_INCREMENT=310 DEFAULT CHARSET=utf8mb3;

-- ----------------------------
-- Table structure for perfiles
-- ----------------------------
DROP TABLE IF EXISTS `perfiles`;
CREATE TABLE `perfiles` (
  `idperfiles` int NOT NULL AUTO_INCREMENT,
  `perfil` varchar(100) NOT NULL,
  `estatus` int DEFAULT '1' COMMENT '0 - No activo\\n1 - Activo',
  PRIMARY KEY (`idperfiles`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3;

-- ----------------------------
-- Table structure for perfiles_permisos
-- ----------------------------
DROP TABLE IF EXISTS `perfiles_permisos`;
CREATE TABLE `perfiles_permisos` (
  `idperfiles` int NOT NULL,
  `idmodulos_menu` int NOT NULL,
  `insertar` int DEFAULT '0',
  `borrar` int DEFAULT '0',
  `modificar` int DEFAULT '0',
  KEY `fk_perfiles_has_modulos_menu_modulos_menu1` (`idmodulos_menu`) USING BTREE,
  KEY `fk_perfiles_has_modulos_menu_perfiles1` (`idperfiles`) USING BTREE,
  CONSTRAINT `perfiles_permisos_ibfk_1` FOREIGN KEY (`idmodulos_menu`) REFERENCES `modulos_menu` (`idmodulos_menu`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `perfiles_permisos_ibfk_2` FOREIGN KEY (`idperfiles`) REFERENCES `perfiles` (`idperfiles`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- ----------------------------
-- Table structure for tipousuario
-- ----------------------------
DROP TABLE IF EXISTS `tipousuario`;
CREATE TABLE `tipousuario` (
  `idtipousuario` int NOT NULL AUTO_INCREMENT,
  `nombretipo` varchar(255) DEFAULT NULL,
  `mostrarenapp` int DEFAULT NULL,
  `estatus` int DEFAULT NULL COMMENT '0.-inactivo\n1.-activo',
  `sistema` int DEFAULT '0',
  PRIMARY KEY (`idtipousuario`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb3;

-- ----------------------------
-- Table structure for usuarios
-- ----------------------------
DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE `usuarios` (
  `idusuarios` int NOT NULL AUTO_INCREMENT COMMENT '0 - USUARIOS INTERNOS\\n1 - USUARIOS EXTERNOS',
  `idperfiles` int DEFAULT '0',
  `nombre` varchar(250) DEFAULT NULL,
  `paterno` varchar(250) DEFAULT NULL,
  `materno` varchar(250) DEFAULT NULL,
  `telefono` varchar(100) DEFAULT '----',
  `celular` varchar(100) DEFAULT '----',
  `email` varchar(100) DEFAULT NULL,
  `usuario` varchar(255) DEFAULT NULL,
  `clave` varchar(100) DEFAULT NULL,
  `tipo` int DEFAULT '1' COMMENT '0 - super usuario\\\\n \n1 -Empleado \\\\n\n2.- Administrador \\\\n\n3.-Alumno\n5.-Coach',
  `estatus` int DEFAULT '1' COMMENT '0.-inactivo\n1.-activo',
  `idempleados` int DEFAULT '0',
  `tokenfirebase` varchar(45) DEFAULT NULL COMMENT '	',
  `so` varchar(45) DEFAULT NULL,
  `fechanacimiento` varchar(100) DEFAULT NULL,
  `fechacreacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `token` varchar(45) DEFAULT NULL,
  `foto` text,
  `customerid_stripe` varchar(45) DEFAULT NULL,
  `lastcard_stripe` varchar(45) DEFAULT NULL,
  `versionactual` varchar(45) DEFAULT NULL,
  `validartelefono` int DEFAULT NULL,
  `bloquearediciondatos` int DEFAULT NULL,
  `sexo` varchar(1) DEFAULT NULL,
  `saldomonedero` float(14,2) DEFAULT NULL,
  `codigopostal` varchar(45) DEFAULT NULL,
  `pais` varchar(45) DEFAULT NULL,
  `estado` varchar(45) DEFAULT NULL,
  `municipio` varchar(45) DEFAULT NULL,
  `colonia` varchar(45) DEFAULT NULL,
  `tipoasentamiento` varchar(45) DEFAULT NULL,
  `calle` varchar(45) DEFAULT NULL,
  `no_int` varchar(45) DEFAULT NULL,
  `no_ext` varchar(45) DEFAULT NULL,
  `anunciovisto` int DEFAULT '0',
  `sistema` varchar(45) DEFAULT NULL,
  `alias` text,
  `monedero` float(10,2) DEFAULT '0.00',
  `celular2` varchar(45) DEFAULT NULL,
  `popupmembresia` int DEFAULT '0',
  `sincel` varchar(45) DEFAULT NULL,
  `celularrespaldo` varchar(45) DEFAULT NULL,
  `aceptopolitica` int DEFAULT '0',
  `orden` int DEFAULT '0',
  `lastcard_mercadopago` varchar(45) DEFAULT NULL,
  `color` varchar(45) DEFAULT NULL,
  `habilitartarjeta` int DEFAULT '0',
  `visibledashboard` int DEFAULT NULL,
  PRIMARY KEY (`idusuarios`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=3599 DEFAULT CHARSET=utf8mb3;

SET FOREIGN_KEY_CHECKS = 1;
