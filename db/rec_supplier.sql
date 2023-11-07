-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versión del servidor:         8.0.34 - MySQL Community Server - GPL
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

-- Volcando estructura para tabla compensapay.rec_supplier
DROP TABLE IF EXISTS `rec_supplier`;
CREATE TABLE IF NOT EXISTS `rec_supplier` (
  `rec_id` int NOT NULL AUTO_INCREMENT,
  `id_com` int unsigned NOT NULL,
  `nationality` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL DEFAULT '0',
  `date_const` varchar(50) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `num_rpc` varchar(50) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `e_firma` varchar(50) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `e_mail` varchar(100) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `website` varchar(100) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `obj_social` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `desc_operation` varchar(255) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `transact_month` varchar(50) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `ammount` varchar(50) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `person_incharge` varchar(50) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `person_name` varchar(100) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `person_curp` varchar(50) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `person_rfc` varchar(50) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `person_id` varchar(100) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `person_adress` varchar(100) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `person_email` varchar(100) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `person_phone` varchar(100) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `natural_person_benef` tinyint DEFAULT NULL,
  `benef_legal_entity` tinyint DEFAULT NULL,
  `license_services` tinyint DEFAULT NULL,
  `supervisor_name` varchar(100) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `license_type` varchar(50) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `license_date` varchar(50) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `been_audited` tinyint DEFAULT NULL,
  `anticorruption` tinyint DEFAULT NULL,
  `data_protection` tinyint DEFAULT NULL,
  `vul_activity` tinyint DEFAULT NULL,
  `regist_sat` varchar(255) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `up_to_date` varchar(255) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  KEY `Índice 1` (`rec_id`),
  KEY `FK_rec_supplier_companies` (`id_com`),
  CONSTRAINT `FK_rec_supplier_companies` FOREIGN KEY (`id_com`) REFERENCES `companies` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- La exportación de datos fue deseleccionada.

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
