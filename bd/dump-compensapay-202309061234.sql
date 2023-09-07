-- MySQL dump 10.13  Distrib 8.0.19, for Win64 (x86_64)
--
-- Host: localhost    Database: compensapay
-- ------------------------------------------------------
-- Server version	5.5.5-10.4.27-MariaDB

--
 CREATE DATABASE if not exists `compensapay` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;
 USE  compensapay ;
-- --------------------------------------------------------


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `acceso`
--

DROP TABLE IF EXISTS `acceso`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `acceso` (
  `a_idAcceso` int(3) NOT NULL AUTO_INCREMENT,
  `a_idUsuario` int(3) NOT NULL,
  `a_Llave` varchar(255) NOT NULL,
  `a_Sesion` varchar(127) NOT NULL,
  `a_CambiarLlave` tinyint(1) DEFAULT NULL,
  `a_UlimoAcceso` datetime DEFAULT NULL,
  `a_Activo` tinyint(1) NOT NULL,
  PRIMARY KEY (`a_idAcceso`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `acceso`
--

LOCK TABLES `acceso` WRITE;
/*!40000 ALTER TABLE `acceso` DISABLE KEYS */;
/*!40000 ALTER TABLE `acceso` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `clienteproveedor`
--

DROP TABLE IF EXISTS `clienteproveedor`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `clienteproveedor` (
  `cp_idClienteProveedor` int(4) NOT NULL AUTO_INCREMENT,
  `cp_idPersonaCliente` int(3) NOT NULL,
  `cp_idPersonaProveedor` varchar(100) NOT NULL,
  `cp_Nota` varchar(50) NOT NULL,
  `cp_idEstatusCP` int(2) DEFAULT NULL,
  `cp_Activo` tinyint(1) NOT NULL,
  PRIMARY KEY (`cp_idClienteProveedor`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `clienteproveedor`
--

LOCK TABLES `clienteproveedor` WRITE;
/*!40000 ALTER TABLE `clienteproveedor` DISABLE KEYS */;
/*!40000 ALTER TABLE `clienteproveedor` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `compensacion`
--

DROP TABLE IF EXISTS `compensacion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `compensacion` (
  `cm_idCompensacion` int(4) NOT NULL AUTO_INCREMENT,
  `cm_idPersonaCliente` int(3) NOT NULL,
  `cm_idPersonaProveedor` varchar(100) NOT NULL,
  `cm_idEstatusCM` varchar(50) NOT NULL,
  `cm_idOperacion` int(2) DEFAULT NULL,
  `cm_Activo` tinyint(1) NOT NULL,
  PRIMARY KEY (`cm_idCompensacion`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `compensacion`
--

LOCK TABLES `compensacion` WRITE;
/*!40000 ALTER TABLE `compensacion` DISABLE KEYS */;
/*!40000 ALTER TABLE `compensacion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contacto`
--

DROP TABLE IF EXISTS `contacto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `contacto` (
  `c_idContacto` int(4) NOT NULL AUTO_INCREMENT,
  `c_idTipoContacto` int(3) NOT NULL,
  `c_idPersona` int(3) NOT NULL,
  `c_Descripcion` varchar(50) NOT NULL,
  `c_Activo` tinyint(1) NOT NULL,
  PRIMARY KEY (`c_idContacto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contacto`
--

LOCK TABLES `contacto` WRITE;
/*!40000 ALTER TABLE `contacto` DISABLE KEYS */;
/*!40000 ALTER TABLE `contacto` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `direccion`
--

DROP TABLE IF EXISTS `direccion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `direccion` (
  `d_idDireccion` int(4) NOT NULL AUTO_INCREMENT,
  `d_idPersona` int(3) NOT NULL,
  `d_CalleYNumero` varchar(100) NOT NULL,
  `d_Colonia` varchar(50) NOT NULL,
  `d_Ciudad` varchar(50) DEFAULT NULL,
  `d_Estado` varchar(50) DEFAULT NULL,
  `d_CodPost` int(6) DEFAULT NULL,
  `d_Activo` tinyint(1) NOT NULL,
  PRIMARY KEY (`d_idDireccion`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `direccion`
--

LOCK TABLES `direccion` WRITE;
/*!40000 ALTER TABLE `direccion` DISABLE KEYS */;
/*!40000 ALTER TABLE `direccion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `estatuscm`
--

DROP TABLE IF EXISTS `estatuscm`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `estatuscm` (
  `ec_idEstatusCM` int(4) NOT NULL AUTO_INCREMENT,
  `ec_Descripcion` varchar(16) NOT NULL,
  `ec_Activo` tinyint(1) NOT NULL,
  PRIMARY KEY (`ec_idEstatusCM`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `estatuscm`
--

LOCK TABLES `estatuscm` WRITE;
/*!40000 ALTER TABLE `estatuscm` DISABLE KEYS */;
/*!40000 ALTER TABLE `estatuscm` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `estatuscp`
--

DROP TABLE IF EXISTS `estatuscp`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `estatuscp` (
  `ecp_idEstatusCP` int(4) NOT NULL AUTO_INCREMENT,
  `ecp_Descripcion` varchar(16) NOT NULL,
  `ecp_Activo` tinyint(1) NOT NULL,
  PRIMARY KEY (`ecp_idEstatusCP`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `estatuscp`
--

LOCK TABLES `estatuscp` WRITE;
/*!40000 ALTER TABLE `estatuscp` DISABLE KEYS */;
/*!40000 ALTER TABLE `estatuscp` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `estatuso`
--

DROP TABLE IF EXISTS `estatuso`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `estatuso` (
  `eo_idEstatusO` int(4) NOT NULL AUTO_INCREMENT,
  `eo_Descripcion` varchar(16) NOT NULL,
  `eo_Activo` tinyint(1) NOT NULL,
  PRIMARY KEY (`eo_idEstatusO`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `estatuso`
--

LOCK TABLES `estatuso` WRITE;
/*!40000 ALTER TABLE `estatuso` DISABLE KEYS */;
/*!40000 ALTER TABLE `estatuso` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `moduloperfil`
--

DROP TABLE IF EXISTS `moduloperfil`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `moduloperfil` (
  `mp_idModuloPerfil` int(3) NOT NULL AUTO_INCREMENT,
  `mp_idModulo` tinyint(3) DEFAULT NULL,
  `mp_idPerfil` tinyint(3) DEFAULT NULL,
  `mp_Activo` tinyint(1) NOT NULL,
  PRIMARY KEY (`mp_idModuloPerfil`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `moduloperfil`
--

LOCK TABLES `moduloperfil` WRITE;
/*!40000 ALTER TABLE `moduloperfil` DISABLE KEYS */;
/*!40000 ALTER TABLE `moduloperfil` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `modulos`
--

DROP TABLE IF EXISTS `modulos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `modulos` (
  `m_idModulo` tinyint(3) NOT NULL AUTO_INCREMENT,
  `m_Descripcion` varchar(30) NOT NULL,
  `m_Activo` tinyint(1) NOT NULL,
  PRIMARY KEY (`m_idModulo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `modulos`
--

LOCK TABLES `modulos` WRITE;
/*!40000 ALTER TABLE `modulos` DISABLE KEYS */;
/*!40000 ALTER TABLE `modulos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `operacion`
--

DROP TABLE IF EXISTS `operacion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `operacion` (
  `o_idOperacion` int(4) NOT NULL AUTO_INCREMENT,
  `o_NumOperacion` varchar(10) NOT NULL,
  `o_idPersona` int(4) NOT NULL,
  `o_FechaEmision` datetime NOT NULL,
  `o_Total` float DEFAULT NULL,
  `o_ArchivoXML` blob NOT NULL,
  `o_ArchivoPDF` blob NOT NULL,
  `o_UUID` varchar(20) NOT NULL,
  `o_idTipoDocumento` int(3) NOT NULL,
  `o_SubTotal` float DEFAULT NULL,
  `o_Impuesto` float NOT NULL,
  `o_FechaUpload` datetime NOT NULL,
  `o_Activo` tinyint(1) NOT NULL,
  PRIMARY KEY (`o_idOperacion`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `operacion`
--

LOCK TABLES `operacion` WRITE;
/*!40000 ALTER TABLE `operacion` DISABLE KEYS */;
/*!40000 ALTER TABLE `operacion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `perfil`
--

DROP TABLE IF EXISTS `perfil`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `perfil` (
  `p_idPerfil` tinyint(3) NOT NULL AUTO_INCREMENT,
  `p_Descripcion` varchar(50) NOT NULL,
  `p_Activo` tinyint(1) NOT NULL,
  PRIMARY KEY (`p_idPerfil`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `perfil`
--

LOCK TABLES `perfil` WRITE;
/*!40000 ALTER TABLE `perfil` DISABLE KEYS */;
/*!40000 ALTER TABLE `perfil` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `persona`
--

DROP TABLE IF EXISTS `persona`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `persona` (
  `per_idPersona` int(5) NOT NULL AUTO_INCREMENT,
  `per_Nombre` varchar(50) DEFAULT NULL,
  `per_Alias` varchar(10) DEFAULT NULL,
  `per_RFC` varchar(16) DEFAULT NULL,
  `per_idTipoPrersona` int(2) DEFAULT NULL,
  `per_idRol` int(2) DEFAULT NULL,
  `per_ActivoFintec` tinyint(1) DEFAULT NULL,
  `per_Activo` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`per_idPersona`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `persona`
--

LOCK TABLES `persona` WRITE;
/*!40000 ALTER TABLE `persona` DISABLE KEYS */;
/*!40000 ALTER TABLE `persona` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `representantelegal`
--

DROP TABLE IF EXISTS `representantelegal`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `representantelegal` (
  `rl_idRepresentante` int(3) NOT NULL AUTO_INCREMENT,
  `rl_Nombre` varchar(30) DEFAULT NULL,
  `rl_RFC` varchar(10) DEFAULT NULL,
  `rl_idPersona` int(3) DEFAULT NULL,
  `rl_Activo` tinyint(1) NOT NULL,
  PRIMARY KEY (`rl_idRepresentante`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `representantelegal`
--

LOCK TABLES `representantelegal` WRITE;
/*!40000 ALTER TABLE `representantelegal` DISABLE KEYS */;
/*!40000 ALTER TABLE `representantelegal` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rol`
--

DROP TABLE IF EXISTS `rol`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `rol` (
  `r_idRol` tinyint(3) NOT NULL AUTO_INCREMENT,
  `r_Descripcion` varchar(50) DEFAULT NULL,
  `r_Activo` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`r_idRol`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rol`
--

LOCK TABLES `rol` WRITE;
/*!40000 ALTER TABLE `rol` DISABLE KEYS */;
/*!40000 ALTER TABLE `rol` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `seguimiento`
--

DROP TABLE IF EXISTS `seguimiento`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `seguimiento` (
  `s_idSeguimiento` int(4) NOT NULL AUTO_INCREMENT,
  `s_idOperacion` varchar(10) NOT NULL,
  `s_FechaSeguimiento` datetime NOT NULL,
  `s_DescripcionOperacion` varchar(255) NOT NULL,
  `s_idEstatusO` float DEFAULT NULL,
  `s_UsuarioActualizo` int(3) NOT NULL,
  `s_Activo` tinyint(1) NOT NULL,
  PRIMARY KEY (`s_idSeguimiento`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `seguimiento`
--

LOCK TABLES `seguimiento` WRITE;
/*!40000 ALTER TABLE `seguimiento` DISABLE KEYS */;
/*!40000 ALTER TABLE `seguimiento` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tipocontacto`
--

DROP TABLE IF EXISTS `tipocontacto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tipocontacto` (
  `tc_idTipoContacto` int(4) NOT NULL AUTO_INCREMENT,
  `tc_Descripcion` varchar(30) NOT NULL,
  `tc_Activo` tinyint(1) NOT NULL,
  PRIMARY KEY (`tc_idTipoContacto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipocontacto`
--

LOCK TABLES `tipocontacto` WRITE;
/*!40000 ALTER TABLE `tipocontacto` DISABLE KEYS */;
/*!40000 ALTER TABLE `tipocontacto` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tipodocumento`
--

DROP TABLE IF EXISTS `tipodocumento`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tipodocumento` (
  `td_idTipoDocumento` int(4) NOT NULL AUTO_INCREMENT,
  `td_Descripcion` varchar(16) NOT NULL,
  `td_Activo` tinyint(1) NOT NULL,
  PRIMARY KEY (`td_idTipoDocumento`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipodocumento`
--

LOCK TABLES `tipodocumento` WRITE;
/*!40000 ALTER TABLE `tipodocumento` DISABLE KEYS */;
/*!40000 ALTER TABLE `tipodocumento` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tipopersona`
--

DROP TABLE IF EXISTS `tipopersona`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tipopersona` (
  `tp_idTipoPersona` tinyint(3) NOT NULL AUTO_INCREMENT,
  `tp_Descripcion` varchar(50) DEFAULT NULL,
  `tp_Activo` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`tp_idTipoPersona`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipopersona`
--

LOCK TABLES `tipopersona` WRITE;
/*!40000 ALTER TABLE `tipopersona` DISABLE KEYS */;
/*!40000 ALTER TABLE `tipopersona` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuario`
--

DROP TABLE IF EXISTS `usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `usuario` (
  `u_idUsuario` int(4) NOT NULL AUTO_INCREMENT,
  `u_idPersona` int(3) DEFAULT NULL,
  `u_NombreUsuario` varchar(15) DEFAULT NULL,
  `u_idPerfil` int(3) DEFAULT NULL,
  `u_Activo` tinyint(1) NOT NULL,
  PRIMARY KEY (`u_idUsuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuario`
--

LOCK TABLES `usuario` WRITE;
/*!40000 ALTER TABLE `usuario` DISABLE KEYS */;
/*!40000 ALTER TABLE `usuario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'compensapay'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-09-06 12:34:27
