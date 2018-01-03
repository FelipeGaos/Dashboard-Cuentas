-- --------------------------------------------------------
-- Host:                         localhost
-- Versión del servidor:         10.1.13-MariaDB - mariadb.org binary distribution
-- SO del servidor:              Win32
-- HeidiSQL Versión:             9.3.0.4984
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Volcando estructura de base de datos para dashboard_ovas
CREATE DATABASE IF NOT EXISTS `dashboard_ovas` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `dashboard_ovas`;


-- Volcando estructura para tabla dashboard_ovas.herramienta
CREATE TABLE IF NOT EXISTS `herramienta` (
  `id_herramienta` int(11) NOT NULL,
  `nombre` varchar(250) DEFAULT NULL,
  `url` varchar(20000) DEFAULT NULL,
  `nivel_acceso` varchar(50) NOT NULL DEFAULT 'publico' COMMENT 'Acceso = publico || privado',
  `comentario` varchar(250) DEFAULT NULL,
  `item_padre` int(11) DEFAULT NULL,
  `orden` int(11) DEFAULT NULL,
  `target` varchar(50) DEFAULT NULL,
  `opciones` varchar(250) DEFAULT NULL,
  `fk_id_proyecto` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_herramienta`),
  KEY `fk_id_proyecto` (`fk_id_proyecto`),
  CONSTRAINT `fk_id_proyecto` FOREIGN KEY (`fk_id_proyecto`) REFERENCES `proyecto` (`id_proyecto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- La exportación de datos fue deseleccionada.


-- Volcando estructura para tabla dashboard_ovas.perfil
CREATE TABLE IF NOT EXISTS `perfil` (
  `id` int(11) NOT NULL,
  `nombre_perfil` varchar(50) NOT NULL,
  `descripcion` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- La exportación de datos fue deseleccionada.


-- Volcando estructura para tabla dashboard_ovas.permiso
CREATE TABLE IF NOT EXISTS `permiso` (
  `username` varchar(50) NOT NULL,
  `id_menu` int(11) NOT NULL,
  `estado_permiso` int(11) NOT NULL DEFAULT '0' COMMENT '0 = Inactivo; 1 = Activo',
  `fecha_asignacion` varchar(50) DEFAULT NULL,
  `usuario_asigna` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`username`,`id_menu`),
  KEY `fk_id_herramienta` (`id_menu`),
  CONSTRAINT `fk_id_herramienta` FOREIGN KEY (`id_menu`) REFERENCES `herramienta` (`id_herramienta`),
  CONSTRAINT `fk_username` FOREIGN KEY (`username`) REFERENCES `usuario` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- La exportación de datos fue deseleccionada.


-- Volcando estructura para tabla dashboard_ovas.proyecto
CREATE TABLE IF NOT EXISTS `proyecto` (
  `id_proyecto` int(11) NOT NULL,
  `nombre` varchar(50) DEFAULT NULL,
  `area` varchar(50) DEFAULT NULL,
  `url` varchar(20000) DEFAULT NULL,
  `icono` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`id_proyecto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- La exportación de datos fue deseleccionada.


-- Volcando estructura para tabla dashboard_ovas.usuario
CREATE TABLE IF NOT EXISTS `usuario` (
  `username` varchar(50) NOT NULL,
  `clave` varchar(50) NOT NULL,
  `nombres` varchar(50) NOT NULL,
  `ape_paterno` varchar(50) NOT NULL,
  `ape_materno` varchar(50) DEFAULT NULL,
  `email` varchar(50) NOT NULL,
  `movil` varchar(50) NOT NULL,
  `fecha_ultimo_acceso` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `estado` varchar(50) NOT NULL DEFAULT 'A',
  `fecha_ultima_modificacion` timestamp NULL DEFAULT NULL,
  `area` varchar(50) NOT NULL,
  `area2` varchar(50) DEFAULT NULL,
  `tipo_usuario` int(11) NOT NULL,
  PRIMARY KEY (`username`,`tipo_usuario`),
  KEY `fk_tipo_usuario` (`tipo_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- La exportación de datos fue deseleccionada.
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
