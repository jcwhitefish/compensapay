-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 15-11-2023 a las 19:06:36
-- Versión del servidor: 8.0.31
-- Versión de PHP: 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `compensatest_base`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `companies`
--

DROP TABLE IF EXISTS `companies`;
CREATE TABLE IF NOT EXISTS `companies` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `legal_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `short_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `id_type` int UNSIGNED NOT NULL,
  `rfc` varchar(13) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `id_fiscal` int UNSIGNED NOT NULL,
  `id_postal_code` int UNSIGNED NOT NULL,
  `id_country` int UNSIGNED NOT NULL,
  `address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `telephone` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `account_clabe` varchar(18) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `id_broadcast_bank` int UNSIGNED NOT NULL,
  `dias_pago` int NOT NULL DEFAULT '45',
  `arteria_id` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `unique_key` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `created_at` varchar(11) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci DEFAULT (unix_timestamp(now())),
  `updated_at` varchar(12) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `rfc` (`rfc`) USING BTREE,
  KEY `ent_gro_FK` (`id_type`),
  KEY `ent_fiscal_FK` (`id_fiscal`),
  KEY `ent_zp_FK` (`id_postal_code`),
  KEY `ent_county` (`id_country`),
  KEY `ent_bank_FK` (`id_broadcast_bank`)
) ;

--
-- Volcado de datos para la tabla `companies`
--

INSERT INTO `companies` (`id`, `legal_name`, `short_name`, `id_type`, `rfc`, `id_fiscal`, `id_postal_code`, `id_country`, `address`, `telephone`, `account_clabe`, `id_broadcast_bank`, `dias_pago`, `arteria_id`, `unique_key`, `created_at`, `updated_at`) VALUES
(1, 'WHITEFISH SOLVE TECH', 'WHITEFISH', 2, 'WST230202CQ2', 1, 471, 9, 'Bosque de Radiatas 26', '1284576458', '012180015926668199', 1, 45, NULL, '652fedab76eab-16', '1697640960', '1699647419'),
(2, 'SLV CAPERE', 'SOLVE', 2, 'SCA230301DQ3', 16, 471, 9, 'Bosque de Radiatas 26', '1284576458', '002180700606505680', 4, 45, NULL, '653a7a9d889dc-16', '1698332585', '1699629228'),
(3, 'Comando Espacial de las Naciones Unidas', 'UNSC', 2, 'UNSC345627U56', 16, 471, 9, 'Bosque de Radiatas 26', '1234567880', '002564565465464565', 1, 45, NULL, '654wdwdsffdsf-16', '1698333516', '1698333972');

--
-- Disparadores `companies`
--
DROP TRIGGER IF EXISTS `before_update_companies`;
DELIMITER $$
CREATE TRIGGER `before_update_companies` BEFORE UPDATE ON `companies` FOR EACH ROW SET NEW.updated_at = UNIX_TIMESTAMP()
$$
DELIMITER ;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `companies`
--
ALTER TABLE `companies`
  ADD CONSTRAINT `ent_bank_FK` FOREIGN KEY (`id_broadcast_bank`) REFERENCES `cat_bancos` (`bnk_id`),
  ADD CONSTRAINT `ent_county` FOREIGN KEY (`id_country`) REFERENCES `cat_county` (`cnty_id`),
  ADD CONSTRAINT `ent_fiscal_FK` FOREIGN KEY (`id_fiscal`) REFERENCES `cat_regimenfiscal` (`rg_id`),
  ADD CONSTRAINT `ent_gro_FK` FOREIGN KEY (`id_type`) REFERENCES `cat_giro` (`gro_id`),
  ADD CONSTRAINT `ent_zp_FK` FOREIGN KEY (`id_postal_code`) REFERENCES `cat_zipcode` (`zip_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
