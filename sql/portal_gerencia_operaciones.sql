-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versión del servidor:         5.6.16-log - MySQL Community Server (GPL)
-- SO del servidor:              Win64
-- HeidiSQL Versión:             9.3.0.4984
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Volcando estructura de base de datos para sg_operaciones
CREATE DATABASE IF NOT EXISTS `sg_operaciones` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `sg_operaciones`;


-- Volcando estructura para tabla sg_operaciones.herramienta
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

-- Volcando datos para la tabla sg_operaciones.herramienta: ~86 rows (aproximadamente)
/*!40000 ALTER TABLE `herramienta` DISABLE KEYS */;
INSERT INTO `herramienta` (`id_herramienta`, `nombre`, `url`, `nivel_acceso`, `comentario`, `item_padre`, `orden`, `target`, `opciones`, `fk_id_proyecto`) VALUES
	(1, 'MIGRACIONES', '#', 'privado', NULL, 0, NULL, NULL, NULL, 1),
	(2, 'Automigranol', '#', 'privado', NULL, 1, NULL, NULL, NULL, 1),
	(3, 'Migranol 2G', '#', 'privado', NULL, 1, NULL, NULL, NULL, 1),
	(4, 'Migranol 3G', '#', 'privado', NULL, 1, NULL, NULL, NULL, 1),
	(5, 'REGULACIÓN TAC-LAC', '#', 'privado', NULL, 0, NULL, NULL, NULL, 1),
	(6, 'RNC', '#', 'publico', NULL, 0, NULL, NULL, NULL, 2),
	(7, 'KPIs de RNCs', '#', 'publico', NULL, 6, NULL, NULL, NULL, 2),
	(8, 'Reporte de RNC', '#', 'publico', NULL, 6, NULL, NULL, NULL, 2),
	(9, 'MGW', '#', 'publico', NULL, 0, NULL, NULL, NULL, 2),
	(10, 'Ejecutar Comandos', '#', 'publico', NULL, 9, NULL, NULL, NULL, 2),
	(11, 'Reporte MGW', '#', 'publico', NULL, 9, NULL, NULL, NULL, 2),
	(12, 'Logs de MGW', '#', 'publico', NULL, 9, NULL, NULL, NULL, 2),
	(13, 'DATOS', '#', 'publico', NULL, 0, NULL, NULL, NULL, 3),
	(14, 'GA/LAC/TAC E nodeB los MME', '#', 'publico', NULL, 13, NULL, NULL, NULL, 3),
	(15, 'GA/TAC - GA/LAC en SGSNs', '#', 'publico', NULL, 13, NULL, NULL, NULL, 3),
	(16, 'LAC/RAC en SGSNs', '#', 'publico', NULL, 13, NULL, NULL, NULL, 3),
	(17, 'WO GA/LAC/TAC', '#', 'publico', NULL, 13, NULL, NULL, NULL, 3),
	(18, 'BÚSQUEDA MÓVIL', '#', 'publico', NULL, 0, NULL, NULL, NULL, 3),
	(19, 'DUMP HSS', '#', 'publico', NULL, 0, NULL, NULL, NULL, 3),
	(20, 'INCONSISTENCIA HLR', '#', 'publico', NULL, 0, NULL, NULL, NULL, 3),
	(21, 'LAC TAC', '#', 'publico', NULL, 0, NULL, NULL, NULL, 3),
	(22, 'KPIs CORE-VOZ', '#', 'publico', NULL, 0, NULL, NULL, NULL, 3),
	(23, 'RNC', '#', 'publico', NULL, 22, NULL, NULL, NULL, 3),
	(24, 'Carga CPU', '#', 'publico', NULL, 22, NULL, NULL, NULL, 3),
	(25, 'Uso HSS', '#', 'publico', NULL, 22, NULL, NULL, NULL, 3),
	(26, 'CUENTAS OSS', '#', 'publico', NULL, 0, NULL, NULL, NULL, 4),
	(27, 'Crear Cuentas', '#', 'publico', NULL, 26, NULL, NULL, NULL, 4),
	(28, 'Reset Cuentas', '#', 'publico', NULL, 26, NULL, NULL, NULL, 4),
	(29, 'Consultar Logs', '#', 'publico', NULL, 26, NULL, NULL, NULL, 4),
	(30, 'Bloquear Cuentas', '#', 'publico', NULL, 26, NULL, NULL, NULL, 4),
	(31, 'Desbloquear Cuentas', '#', 'publico', NULL, 26, NULL, NULL, NULL, 4),
	(32, 'OPERACIONES', '#', 'publico', NULL, 0, NULL, NULL, NULL, 4),
	(33, 'Recargas', '#', 'publico', NULL, 32, NULL, NULL, NULL, 4),
	(34, 'Tabla Resúmen Diario', '#', 'publico', NULL, 32, NULL, NULL, NULL, 4),
	(35, 'Asignados por Usuario Prepago', '#', 'publico', NULL, 32, NULL, NULL, NULL, 4),
	(36, 'TPs asignados por Usuario VASME', '#', 'publico', NULL, 32, NULL, NULL, NULL, 4),
	(37, 'Monitoreo OSS', '#', 'publico', NULL, 32, NULL, NULL, NULL, 4),
	(38, 'COCKPIT', '#', 'publico', NULL, 0, NULL, NULL, NULL, 4),
	(39, 'TPs asignados por usuario OVAS-PLAT', '#', 'publico', NULL, 38, NULL, NULL, NULL, 4),
	(40, 'Horas extra y normales VAS', '#', 'publico', NULL, 38, NULL, NULL, NULL, 4),
	(41, 'Horas extra y normales PLAT', '#', 'publico', NULL, 38, NULL, NULL, NULL, 4),
	(42, 'Horas extra y normales SUBG', '#', 'publico', NULL, 38, NULL, NULL, NULL, 4),
	(43, 'Administración Plataformas', '#', 'publico', NULL, 38, NULL, NULL, NULL, 4),
	(44, 'Horas extra y normales Mediación', '#', 'publico', NULL, 38, NULL, NULL, NULL, 4),
	(45, 'Actualizar Capacidad-Disponibilidad', '#', 'publico', NULL, 38, NULL, NULL, NULL, 4),
	(46, 'Capacidad-Disponibilidad', '#', 'publico', NULL, 38, NULL, NULL, NULL, 4),
	(47, 'TP-Cumplimiento', '#', 'publico', NULL, 38, NULL, NULL, NULL, 4),
	(48, 'Administración HHEE', '#', 'publico', NULL, 38, NULL, NULL, NULL, 4),
	(49, 'Carga HHEE CSV', '#', 'publico', NULL, 38, NULL, NULL, NULL, 4),
	(50, 'GESTOR TAREAS', '#', 'publico', NULL, 0, NULL, NULL, NULL, 4),
	(51, 'Tareas', '#', 'publico', NULL, 50, NULL, NULL, NULL, 4),
	(52, 'MEDIADOR OSS', '#', 'publico', NULL, 0, NULL, NULL, NULL, 4),
	(53, 'Administrar Comandos', '#', 'publico', NULL, 52, NULL, NULL, NULL, 4),
	(54, 'Administrar Usuarios', '#', 'publico', NULL, 52, NULL, NULL, NULL, 4),
	(55, 'Enviar Comandos', '#', 'publico', NULL, 52, NULL, NULL, NULL, 4),
	(56, 'SISTEMAS', '#', 'publico', NULL, 0, NULL, NULL, NULL, 5),
	(57, 'Consulta de Estado Móvil', '#', 'publico', NULL, 56, NULL, NULL, NULL, 5),
	(58, 'SAPC - Cuenta Controlada', '#', 'publico', NULL, 56, NULL, NULL, NULL, 5),
	(59, 'Panel Control TPs', '#', 'publico', NULL, 56, NULL, NULL, NULL, 5),
	(60, 'Archivos Conf. Versionados', '#', 'publico', NULL, 56, NULL, NULL, NULL, 5),
	(61, 'Cambio SCHAR', '#', 'publico', NULL, 56, NULL, NULL, NULL, 5),
	(62, 'APN', '#', 'publico', NULL, 0, NULL, NULL, NULL, 5),
	(63, 'IPs disponibles por APN', '#', 'publico', NULL, 62, NULL, NULL, NULL, 5),
	(64, 'RI-DNS-Radius APN', '#', 'publico', NULL, 62, NULL, NULL, NULL, 5),
	(65, 'Gestor APN', '#', 'publico', NULL, 62, NULL, NULL, NULL, 5),
	(66, 'APN CORE', '#', 'publico', NULL, 0, NULL, NULL, NULL, 5),
	(67, 'Monitor APNs Core', '#', 'publico', NULL, 66, NULL, NULL, NULL, 5),
	(68, 'Admin APNs Core', '#', 'publico', NULL, 66, NULL, NULL, NULL, 5),
	(69, 'PORTALCORE PANADOL', '#', 'publico', NULL, 0, NULL, NULL, NULL, 6),
	(70, 'Ayacencias', '#', 'publico', NULL, 69, NULL, NULL, NULL, 6),
	(71, 'Software BSC', '#', 'publico', NULL, 69, NULL, NULL, NULL, 6),
	(72, 'Busca UMFI\'s', '#', 'publico', NULL, 69, NULL, NULL, NULL, 6),
	(73, 'LAC Celdas MSCs', '#', 'publico', NULL, 69, NULL, NULL, NULL, 6),
	(74, 'Adyacencias 3G', '#', 'publico', NULL, 69, NULL, NULL, NULL, 6),
	(75, 'EJECUCIÓN TPs', '#', 'publico', NULL, 0, NULL, NULL, NULL, 6),
	(76, 'TRX LAB', '#', 'publico', NULL, 0, NULL, NULL, NULL, 6),
	(77, 'LOC NO', '#', 'publico', NULL, 0, NULL, NULL, NULL, 6),
	(78, 'Revisión LOC No por Comunas', '#', 'publico', NULL, 77, NULL, NULL, NULL, 6),
	(79, 'Centros Primarios', '#', 'publico', NULL, 77, NULL, NULL, NULL, 6),
	(80, 'Revisión LOC No en Nodo', '#', 'publico', NULL, 77, NULL, NULL, NULL, 6),
	(81, 'CENTRO DE EMERGENCIAS', '#', 'publico', NULL, 0, NULL, NULL, NULL, 6),
	(82, 'Actualizar Centro', '#', 'publico', NULL, 81, NULL, NULL, NULL, 6),
	(83, 'Verificación Centro', '#', 'publico', NULL, 81, NULL, NULL, NULL, 6),
	(84, 'Verificación Centro Celdas por Comuna', '#', 'publico', NULL, 81, NULL, NULL, NULL, 6),
	(85, 'Verificación Nodo por todas las Comunas', '#', 'publico', NULL, 81, NULL, NULL, NULL, 6),
	(86, 'Verificación Centro Punta Arenas', '#', 'publico', NULL, 81, NULL, NULL, NULL, 6),
	(87, 'Verificación Números de Emergencia', '#', 'publico', NULL, 81, NULL, NULL, NULL, 6),
	(88, 'REVISIÓN MSC vs RNC vs BSC', '#', 'publico', NULL, 0, NULL, NULL, NULL, 6),
	(89, 'IR21', '#', 'publico', NULL, 0, NULL, NULL, NULL, 7),
	(90, 'Plataforma IR21', '#', 'publico', NULL, 89, NULL, NULL, NULL, 7),
	(91, 'ACUERDOS COMERCIALES', '#', 'publico', NULL, 0, NULL, NULL, NULL, 7),
	(92, 'Listar Acuerdos', '#', 'publico', NULL, 91, NULL, NULL, NULL, 7);
/*!40000 ALTER TABLE `herramienta` ENABLE KEYS */;


-- Volcando estructura para tabla sg_operaciones.perfil
CREATE TABLE IF NOT EXISTS `perfil` (
  `id` int(11) NOT NULL,
  `nombre_perfil` varchar(50) NOT NULL,
  `descripcion` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla sg_operaciones.perfil: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `perfil` DISABLE KEYS */;
/*!40000 ALTER TABLE `perfil` ENABLE KEYS */;


-- Volcando estructura para tabla sg_operaciones.permiso
CREATE TABLE IF NOT EXISTS `permiso` (
  `username` varchar(50) NOT NULL,
  `id_herramienta` int(11) NOT NULL,
  `estado_permiso` int(11) NOT NULL DEFAULT '0' COMMENT '0 = Inactivo; 1 = Activo',
  `fecha_asignacion` varchar(50) NOT NULL,
  `usuario_asigna` varchar(50) NOT NULL,
  PRIMARY KEY (`username`,`id_herramienta`),
  KEY `fk_id_herramienta` (`id_herramienta`),
  CONSTRAINT `fk_id_herramienta` FOREIGN KEY (`id_herramienta`) REFERENCES `herramienta` (`id_herramienta`),
  CONSTRAINT `fk_username` FOREIGN KEY (`username`) REFERENCES `usuario` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla sg_operaciones.permiso: ~3 rows (aproximadamente)
/*!40000 ALTER TABLE `permiso` DISABLE KEYS */;
INSERT INTO `permiso` (`username`, `id_herramienta`, `estado_permiso`, `fecha_asignacion`, `usuario_asigna`) VALUES
	('jopino', 1, 1, '2015-07-30 17:12:10', 't2b'),
	('jopino', 2, 1, '2015-07-30 17:12:10', 't2b'),
	('jopino', 3, 1, '2015-07-30 17:12:10', 't2b'),
	('jopino', 4, 1, '2015-07-30 17:12:10', 't2b');
/*!40000 ALTER TABLE `permiso` ENABLE KEYS */;


-- Volcando estructura para tabla sg_operaciones.proyecto
CREATE TABLE IF NOT EXISTS `proyecto` (
  `id_proyecto` int(11) NOT NULL,
  `nombre` varchar(50) DEFAULT NULL,
  `area` varchar(50) DEFAULT NULL,
  `url` varchar(20000) DEFAULT NULL,
  `icono` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`id_proyecto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla sg_operaciones.proyecto: ~6 rows (aproximadamente)
/*!40000 ALTER TABLE `proyecto` DISABLE KEYS */;
INSERT INTO `proyecto` (`id_proyecto`, `nombre`, `area`, `url`, `icono`) VALUES
	(1, 'Configuraciones Core', 'Configuraciones Core', '#', 'fa fa-gear'),
	(2, 'Core Voz', 'Core Voz', '#', 'fa fa-volume-up'),
	(3, 'LTE', 'Configuraciones Core', '#', 'fa fa-signal'),
	(4, 'OVAS', 'OVAS', '#', 'fa fa-code-fork'),
	(5, 'Packet Core', 'Packet Core', '#', 'fa fa-database'),
	(6, 'Cell ID', 'Configuraciones Core', '#', 'fa fa-map-marker'),
	(7, 'Core Internacional', 'Core Internacional', '#', 'fa fa-globe');
/*!40000 ALTER TABLE `proyecto` ENABLE KEYS */;


-- Volcando estructura para tabla sg_operaciones.tipo_usuario
CREATE TABLE IF NOT EXISTS `tipo_usuario` (
  `id_tipo` int(11) NOT NULL,
  `tipo_usuario` varchar(50) NOT NULL,
  `descripcion` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_tipo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla sg_operaciones.tipo_usuario: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `tipo_usuario` DISABLE KEYS */;
INSERT INTO `tipo_usuario` (`id_tipo`, `tipo_usuario`, `descripcion`) VALUES
	(1, 'Administrador', 'Posee todos los permisos');
/*!40000 ALTER TABLE `tipo_usuario` ENABLE KEYS */;


-- Volcando estructura para tabla sg_operaciones.usuario
CREATE TABLE IF NOT EXISTS `usuario` (
  `username` varchar(50) NOT NULL,
  `clave` varchar(50) NOT NULL,
  `nombres` varchar(50) NOT NULL,
  `ape_paterno` varchar(50) NOT NULL,
  `ape_materno` varchar(50) DEFAULT NULL,
  `e-mail` varchar(50) NOT NULL,
  `movil` varchar(50) NOT NULL,
  `estado` int(11) NOT NULL DEFAULT '0' COMMENT '0 = Inactivo; 1 = Activo',
  `fecha_ultimo_acceso` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fecha_ultima_modificacion` timestamp NULL DEFAULT NULL,
  `area` varchar(50) NOT NULL,
  `area2` varchar(50) DEFAULT NULL,
  `tipo_usuario` int(11) NOT NULL,
  PRIMARY KEY (`username`),
  KEY `fk_tipo_usuario` (`tipo_usuario`),
  CONSTRAINT `fk_tipo_usuario` FOREIGN KEY (`tipo_usuario`) REFERENCES `tipo_usuario` (`id_tipo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla sg_operaciones.usuario: ~1 rows (aproximadamente)
/*!40000 ALTER TABLE `usuario` DISABLE KEYS */;
INSERT INTO `usuario` (`username`, `clave`, `nombres`, `ape_paterno`, `ape_materno`, `e-mail`, `movil`, `estado`, `fecha_ultimo_acceso`, `fecha_ultima_modificacion`, `area`, `area2`, `tipo_usuario`) VALUES
	('jopino', 'e10adc3949ba59abbe56e057f20f883e', 'Jonathan Alexander', 'Pino', 'Caba', 'diego.gonzalez@t2b.cl', '92449766', 1, '2015-08-14 14:39:57', NULL, 'Configuraciones', NULL, 1),
	('t2b', 'd36f14f419eb3ba0c591f400c176b30f', 'Technology To Business', 'T2B', NULL, 'diego.gonzalez@t2b.cl', '92449766', 1, '2015-08-12 16:29:35', NULL, 'Desarrollo', NULL, 1);
/*!40000 ALTER TABLE `usuario` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
