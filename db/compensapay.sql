-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 11-10-2023 a las 23:34:38
-- Versión del servidor: 10.4.27-MariaDB
-- Versión de PHP: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `compensapay`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `companies`
--

CREATE TABLE `companies` (
  `id` int(11) NOT NULL,
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
  `updated_at` int(11) NOT NULL DEFAULT unix_timestamp()
) ;

--
-- Disparadores `companies`
--
DELIMITER $$
CREATE TRIGGER `before_update_companies` BEFORE UPDATE ON `companies` FOR EACH ROW SET NEW.updated_at = UNIX_TIMESTAMP()
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `user` varchar(50) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `id_profile` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `telephone` varchar(10) NOT NULL,
  `id_question` int(11) NOT NULL,
  `answer` varchar(255) NOT NULL,
  `id_companie` int(11) NOT NULL,
  `manager` tinyint(4) NOT NULL,
  `created_at` int(11) NOT NULL DEFAULT unix_timestamp(),
  `updated_at` int(11) NOT NULL DEFAULT unix_timestamp()
) ;

--
-- Disparadores `users`
--
DELIMITER $$
CREATE TRIGGER `before_update_users` BEFORE UPDATE ON `users` FOR EACH ROW SET NEW.updated_at = UNIX_TIMESTAMP()
$$
DELIMITER ;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `companies`
--
ALTER TABLE `companies`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `rfc` (`rfc`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user` (`user`),
  ADD KEY `id_companie_values` (`id_companie`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `companies`
--
ALTER TABLE `companies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `id_companie_values` FOREIGN KEY (`id_companie`) REFERENCES `companies` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
