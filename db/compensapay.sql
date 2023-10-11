-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versión del servidor:         10.4.28-MariaDB - mariadb.org binary distribution
-- SO del servidor:              Win64
-- HeidiSQL Versión:             12.5.0.6677
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Volcando estructura para tabla test.cat_bancos
DROP TABLE IF EXISTS `cat_bancos`;
CREATE TABLE IF NOT EXISTS `cat_bancos` (
											`bnk_id` int(11) unsigned NOT NULL,
											`bnk_clave` varchar(3) DEFAULT NULL,
											`bnk_alias` varchar(50) DEFAULT NULL,
											`bnk_nombre` varchar(256) DEFAULT NULL,
											PRIMARY KEY (`bnk_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla test.cat_county
DROP TABLE IF EXISTS `cat_county`;
CREATE TABLE IF NOT EXISTS `cat_county` (
											`cnty_id` int(10) unsigned NOT NULL DEFAULT 0,
											`stt_id` int(11) unsigned NOT NULL DEFAULT 0,
											`cnty_code` smallint(3) unsigned zerofill NOT NULL,
											`cnty_name` varchar(250) NOT NULL,
											`cnty_active` tinyint(1) unsigned DEFAULT 1,
											PRIMARY KEY (`cnty_id`),
											UNIQUE KEY `cnty_code_UNIQUE` (`stt_id`,`cnty_code`),
											KEY `cnty_active_INDEX` (`cnty_active`),
											CONSTRAINT `county_stt_id_FK` FOREIGN KEY (`stt_id`) REFERENCES `cat_state` (`stt_id`) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla test.cat_giro
DROP TABLE IF EXISTS `cat_giro`;
CREATE TABLE IF NOT EXISTS `cat_giro` (
										  `gro_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
										  `gro_giro` varchar(255) NOT NULL,
										  `gro_activo` int(11) NOT NULL,
										  PRIMARY KEY (`gro_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla test.cat_preguntas
DROP TABLE IF EXISTS `cat_preguntas`;
CREATE TABLE IF NOT EXISTS `cat_preguntas` (
											   `pg_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
											   `pg_pregunta` varchar(255) NOT NULL,
											   `pg_activo` int(11) NOT NULL,
											   PRIMARY KEY (`pg_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla test.cat_regimenfiscal
DROP TABLE IF EXISTS `cat_regimenfiscal`;
CREATE TABLE IF NOT EXISTS `cat_regimenfiscal` (
												   `rg_id` int(11) unsigned NOT NULL,
												   `rg_clave` int(11) DEFAULT NULL,
												   `rg_regimen` varchar(128) DEFAULT NULL,
												   `rg_pFisica` int(11) DEFAULT NULL,
												   `rg_pMoral` int(11) DEFAULT NULL,
												   PRIMARY KEY (`rg_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla test.cat_state
DROP TABLE IF EXISTS `cat_state`;
CREATE TABLE IF NOT EXISTS `cat_state` (
										   `stt_id` int(11) unsigned NOT NULL DEFAULT 0,
										   `stt_name` varchar(50) NOT NULL,
										   `stt_abbr` varchar(6) NOT NULL,
										   `stt_active` tinyint(1) unsigned NOT NULL DEFAULT 1,
										   PRIMARY KEY (`stt_id`),
										   UNIQUE KEY `stt_name_UNIQUE` (`stt_name`),
										   UNIQUE KEY `stt_abbr_UNIQUE` (`stt_abbr`),
										   KEY `stt_active_INDEX` (`stt_active`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla test.cat_tipovalor
DROP TABLE IF EXISTS `cat_tipovalor`;
CREATE TABLE IF NOT EXISTS `cat_tipovalor` (
											   `val_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
											   `val_descripcion` varchar(255) NOT NULL,
											   `val_activo` tinyint(1) NOT NULL,
											   PRIMARY KEY (`val_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla test.cat_zipcode
DROP TABLE IF EXISTS `cat_zipcode`;
CREATE TABLE IF NOT EXISTS `cat_zipcode` (
											 `zip_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
											 `zip_code` mediumint(5) unsigned zerofill NOT NULL,
											 `zip_town` varchar(100) NOT NULL,
											 `zip_cat` varchar(30) DEFAULT NULL,
											 `zip_county` int(11) unsigned NOT NULL DEFAULT 0,
											 `zip_state` int(10) unsigned NOT NULL DEFAULT 0,
											 PRIMARY KEY (`zip_id`),
											 KEY `stt_id_INDEX` (`zip_state`),
											 KEY `cnty_id_INDEX` (`zip_county`),
											 KEY `zip_code_INDEX` (`zip_code`),
											 KEY `zip_cat_INDEX` (`zip_cat`),
											 CONSTRAINT `zipcode_cnty_id_FK` FOREIGN KEY (`zip_county`) REFERENCES `cat_county` (`cnty_id`) ON DELETE NO ACTION ON UPDATE CASCADE,
											 CONSTRAINT `zipcode_stt_id_FK` FOREIGN KEY (`zip_state`) REFERENCES `cat_state` (`stt_id`) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=143657 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla test.companies
DROP TABLE IF EXISTS `companies`;
CREATE TABLE IF NOT EXISTS `companies` (
										   `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
										   `legal_name` varchar(100) NOT NULL,
										   `short_name` varchar(100) NOT NULL,
										   `id_type` int(11) NOT NULL,
										   `rfc` varchar(13) NOT NULL,
										   `id_fiscal` int(11) NOT NULL,
										   `id_postal_code` int(11) NOT NULL,
										   `id_country` int(11) NOT NULL,
										   `address` varchar(255) NOT NULL,
										   `telephone` varchar(10) NOT NULL,
										   `account_clabe` varchar(18) NOT NULL,
										   `id_broadcast_bank` int(11) NOT NULL,
										   `unique_key` varchar(100) NOT NULL,
										   `created_at` int(11) NOT NULL DEFAULT unix_timestamp(),
										   `updated_at` int(11) NOT NULL DEFAULT unix_timestamp(),
										   PRIMARY KEY (`id`),
										   UNIQUE KEY `rfc` (`rfc`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla test.rol
DROP TABLE IF EXISTS `rol`;
CREATE TABLE IF NOT EXISTS `rol` (
									 `r_idRol` tinyint(4) unsigned NOT NULL AUTO_INCREMENT,
									 `r_descripcion` varchar(50) DEFAULT NULL,
									 `r_activo` tinyint(1) DEFAULT NULL,
									 PRIMARY KEY (`r_idRol`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla test.sts_estatuscm
DROP TABLE IF EXISTS `sts_estatuscm`;
CREATE TABLE IF NOT EXISTS `sts_estatuscm` (
											   `ecm_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
											   `ecm_descripcion` varchar(16) NOT NULL,
											   `ecm_activo` tinyint(1) NOT NULL,
											   PRIMARY KEY (`ecm_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla test.sts_estatuscp
DROP TABLE IF EXISTS `sts_estatuscp`;
CREATE TABLE IF NOT EXISTS `sts_estatuscp` (
											   `ecp_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
											   `ecp_descripcion` varchar(16) NOT NULL,
											   `ecp_activo` tinyint(1) NOT NULL,
											   PRIMARY KEY (`ecp_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla test.sts_estatuso
DROP TABLE IF EXISTS `sts_estatuso`;
CREATE TABLE IF NOT EXISTS `sts_estatuso` (
											  `eso_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
											  `eso_descripcion` varchar(16) NOT NULL,
											  `eso_activo` tinyint(1) NOT NULL,
											  PRIMARY KEY (`eso_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla test.subscription
DROP TABLE IF EXISTS `subscription`;
CREATE TABLE IF NOT EXISTS `subscription` (
											  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
											  `companies_id` int(11) unsigned NOT NULL,
											  `prevPay` varchar(50) NOT NULL,
											  `nextPay` varchar(50) NOT NULL,
											  `dealings` smallint(3) NOT NULL DEFAULT 0,
											  `extraDealing` smallint(3) NOT NULL DEFAULT 0,
											  `created_at` varchar(50) NOT NULL DEFAULT unix_timestamp(current_timestamp()),
											  `statusSupplier` tinyint(1) NOT NULL DEFAULT 0,
											  `active` tinyint(1) NOT NULL DEFAULT 0,
											  `updated_at` varchar(50) DEFAULT NULL,
											  PRIMARY KEY (`id`) USING BTREE,
											  KEY `sbs_fechaCorte` (`nextPay`) USING BTREE,
											  KEY `sbs_fechaPagoPrev` (`prevPay`) USING BTREE,
											  KEY `sbs_cmp_FK` (`companies_id`),
											  CONSTRAINT `sbs_cmp_FK` FOREIGN KEY (`companies_id`) REFERENCES `companies` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci COMMENT='Esta tabla almacenara los datos de las subcripciones, cuando fue el ultimo pago, cuando el siguiente, el contador de transacciones  y el estado como proveedor 0/1/2 (cliente, proveedor activo y proveedor detenido) ';

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla test.tipo_contacto
DROP TABLE IF EXISTS `tipo_contacto`;
CREATE TABLE IF NOT EXISTS `tipo_contacto` (
											   `tpc_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
											   `tpc_descripcion` varchar(30) NOT NULL,
											   `tpc_activo` tinyint(1) NOT NULL,
											   PRIMARY KEY (`tpc_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla test.tipo_documento
DROP TABLE IF EXISTS `tipo_documento`;
CREATE TABLE IF NOT EXISTS `tipo_documento` (
												`tpd_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
												`tpd_descripcion` varchar(16) NOT NULL,
												`tpd_activo` tinyint(1) NOT NULL,
												PRIMARY KEY (`tpd_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla test.tipo_persona
DROP TABLE IF EXISTS `tipo_persona`;
CREATE TABLE IF NOT EXISTS `tipo_persona` (
											  `tp_id` tinyint(4) unsigned NOT NULL AUTO_INCREMENT,
											  `tp_descripcion` varchar(50) DEFAULT NULL,
											  `tp_activo` tinyint(1) DEFAULT NULL,
											  PRIMARY KEY (`tp_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla test.users
DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
									   `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
									   `user` varchar(50) NOT NULL,
									   `password` varchar(255) DEFAULT NULL,
									   `id_profile` int(11) NOT NULL,
									   `name` varchar(100) NOT NULL,
									   `last_name` varchar(100) NOT NULL,
									   `email` varchar(255) NOT NULL,
									   `telephone` varchar(10) NOT NULL,
									   `id_question` int(11) NOT NULL,
									   `answer` varchar(255) NOT NULL,
									   `id_companie` int(11) unsigned NOT NULL,
									   `manager` tinyint(4) NOT NULL,
									   `unique_key` varchar(100) NOT NULL,
									   `created_at` int(11) NOT NULL DEFAULT unix_timestamp(),
									   `updated_at` int(11) NOT NULL DEFAULT unix_timestamp(),
									   PRIMARY KEY (`id`),
									   UNIQUE KEY `user` (`user`),
									   KEY `id_companie_values` (`id_companie`),
									   CONSTRAINT `id_companie_values` FOREIGN KEY (`id_companie`) REFERENCES `companies` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para disparador test.before_update_companies
DROP TRIGGER IF EXISTS `before_update_companies`;
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO';
DELIMITER //
CREATE TRIGGER `before_update_companies` BEFORE UPDATE ON `companies` FOR EACH ROW SET NEW.updated_at = UNIX_TIMESTAMP()//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

-- Volcando estructura para disparador test.before_update_users
DROP TRIGGER IF EXISTS `before_update_users`;
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO';
DELIMITER //
CREATE TRIGGER `before_update_users` BEFORE UPDATE ON `users` FOR EACH ROW SET NEW.updated_at = UNIX_TIMESTAMP()//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
