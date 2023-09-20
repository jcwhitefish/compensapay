-- MySQL dump 10.13  Distrib 8.0.19, for Win64 (x86_64)
--
-- Host: localhost    Database: compensapay
-- ------------------------------------------------------
-- Server version	5.5.5-10.4.27-MariaDB

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

DROP database IF EXISTS `compensapay`;
CREATE database 'compensapay';
use 'compensapay';


--
-- Table structure for table `acceso`
--

DROP TABLE IF EXISTS `acceso`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `acceso` (
  `a_idAcceso` int(3) NOT NULL AUTO_INCREMENT,
  `a_idUsuario` int(3) NOT NULL,
  `a_Llave` blob NOT NULL,
  `a_Sesion` varchar(127) NOT NULL,
  `a_CambiarLlave` tinyint(1) DEFAULT NULL,
  `a_UlimoAcceso` datetime DEFAULT NULL,
  `a_Activo` tinyint(1) NOT NULL,
  `PreguntaSeguridad` varchar(255) DEFAULT NULL,
  `RespuestaSeguridad` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`a_idAcceso`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `acceso`
--

LOCK TABLES `acceso` WRITE;
/*!40000 ALTER TABLE `acceso` DISABLE KEYS */;
/*!40000 ALTER TABLE `acceso` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `catbancos`
--

DROP TABLE IF EXISTS `catbancos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `catbancos` (
  `id` int(4) NOT NULL,
  `Clave` varchar(3) DEFAULT NULL,
  `Alias` varchar(50) DEFAULT NULL,
  `Nombre` varchar(256) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `catbancos`
--

LOCK TABLES `catbancos` WRITE;
/*!40000 ALTER TABLE `catbancos` DISABLE KEYS */;
INSERT INTO `catbancos` VALUES (1,'002','BANAMEX',' Banco Nacional de México, S.A., Institución de Banca Múltiple, Grupo Financiero Banamex '),(2,'006','BANCOMEXT',' Banco Nacional de Comercio Exterior, Sociedad Nacional de Crédito, Institución de Banca de Desarrollo '),(3,'009','BANOBRAS',' Banco Nacional de Obras y Servicios Públicos, Sociedad Nacional de Crédito, Institución de Banca de Desarrollo '),(4,'012','BBVA BANCOMER',' BBVA Bancomer, S.A., Institución de Banca Múltiple, Grupo Financiero BBVA Bancomer '),(5,'014','SANTANDER',' Banco Santander (México), S.A., Institución de Banca Múltiple, Grupo Financiero Santander '),(6,'019','BANJERCITO',' Banco Nacional del Ejército, Fuerza Aérea y Armada, Sociedad Nacional de Crédito, Institución de Banca de Desarrollo '),(7,'021','HSBC',' HSBC México, S.A., institución De Banca Múltiple, Grupo Financiero HSBC '),(8,'030','BAJIO',' Banco del Bajío, S.A., Institución de Banca Múltiple '),(9,'032','IXE',' IXE Banco, S.A., Institución de Banca Múltiple, IXE Grupo Financiero '),(10,'036','INBURSA','Banco Inbursa, S.A., Institución de Banca Múltiple, Grupo Financiero Inbursa '),(11,'037','INTERACCIONES',' Banco Interacciones, S.A., Institución de Banca Múltiple '),(12,'042','MIFEL',' Banca Mifel, S.A., Institución de Banca Múltiple, Grupo Financiero Mifel '),(13,'044','SCOTIABANK',' Scotiabank Inverlat, S.A. '),(14,'058','BANREGIO',' Banco Regional de Monterrey, S.A., Institución de Banca Múltiple, Banregio Grupo Financiero '),(15,'059','INVEX',' Banco Invex, S.A., Institución de Banca Múltiple, Invex Grupo Financiero '),(16,'060','BANSI',' Bansi, S.A., Institución de Banca Múltiple '),(17,'062','AFIRME',' Banca Afirme, S.A., Institución de Banca Múltiple '),(18,'072','BANORTE',' Banco Mercantil del Norte, S.A., Institución de Banca Múltiple, Grupo Financiero Banorte '),(19,'102','THE ROYAL BANK',' The Royal Bank of Scotland México, S.A., Institución de Banca Múltiple '),(20,'103','AMERICAN EXPRESS','American Express Bank (México), S.A., Institución de Banca Múltiple'),(21,'106','BAMSA',' Bank of America México, S.A., Institución de Banca Múltiple, Grupo Financiero Bank of America '),(22,'108','TOKYO','Bank of Tokyo-Mitsubishi UFJ '),(23,'110','JP MORGAN',' Banco J.P. Morgan, S.A., Institución de Banca Múltiple, J.P. Morgan Grupo Financiero '),(24,'112','BMONEX',' Banco Monex, S.A., Institución de Banca Múltiple '),(25,'113','VE POR MAS',' Banco Ve Por Mas, S.A. Institución de Banca Múltiple '),(26,'116','ING',' ING Bank (México), S.A., Institución de Banca Múltiple, ING Grupo Financiero'),(27,'124','DEUTSCHE',' Deutsche Bank México, S.A., Institución de Banca Múltiple '),(28,'126','CREDIT SUISSE','Banco Credit Suisse (México), S.A. Institución de Banca Múltiple, Grupo Financiero Credit Suisse (México) '),(29,'127','AZTECA',' Banco Azteca, S.A. Institución de Banca Múltiple. '),(30,'128','AUTOFIN',' Banco Autofin México, S.A. Institución de Banca Múltiple'),(31,'129','BARCLAYS','Barclays Bank México, S.A., Institución de Banca Múltiple, Grupo Financiero Barclays México.'),(32,'130','COMPARTAMOS',' Banco Compartamos, S.A., Institución de Banca Múltiple '),(33,'131','BANCO FAMSA',' Banco Ahorro Famsa, S.A., Institución de Banca Múltiple '),(34,'132','BMULTIVA','Banco Multiva, S.A., Institución de Banca Múltiple, Multivalores Grupo Financiero '),(35,'133','ACTINVER','Banco Actinver, S.A. Institución de Banca Múltiple, Grupo Financiero Actinver '),(36,'134','WAL-MART','Banco Wal-Mart de México Adelante, S.A., Institución de Banca Múltiple '),(37,'135','NAFIN','Nacional Financiera, Sociedad Nacional de Crédito, Institución de Banca de Desarrollo '),(38,'136','INTERBANCO','Inter Banco, S.A. Institución de Banca Múltiple '),(39,'137','BANCOPPEL','BanCoppel, S.A., Institución de Banca Múltiple '),(40,'138','ABC CAPITAL','ABC Capital, S.A., Institución de Banca Múltiple '),(41,'139','UBS BANK','UBS Bank México, S.A., Institución de Banca Múltiple, UBS Grupo Financiero '),(42,'140','CONSUBANCO','Consubanco, S.A. Institución de Banca Múltiple '),(43,'141','VOLKSWAGEN','Volkswagen Bank, S.A., Institución de Banca Múltiple '),(44,'143','CIBANCO','CIBanco, S.A. '),(45,'145','BBASE','Banco Base, S.A., Institución de Banca Múltiple '),(46,'166','BANSEFI','Banco del Ahorro Nacional y Servicios Financieros, Sociedad Nacional de Crédito, Institución de Banca de Desarrollo '),(47,'168','HIPOTECARIA FEDERAL','Sociedad Hipotecaria Federal, Sociedad Nacional de Crédito, Institución de Banca de Desarrollo '),(48,'600','MONEXCB','Monex Casa de Bolsa, S.A. de C.V. Monex Grupo Financiero '),(49,'601','GBM','GBM Grupo Bursátil Mexicano, S.A. de C.V. Casa de Bolsa '),(50,'602','MASARI','Masari Casa de Bolsa, S.A. '),(51,'605','VALUE','Value, S.A. de C.V. Casa de Bolsa '),(52,'606','ESTRUCTURADORES','Estructuradores del Mercado de Valores Casa de Bolsa, S.A. de C.V. '),(53,'607','TIBER','Casa de Cambio Tiber, S.A. de C.V. '),(54,'608','VECTOR','Vector Casa de Bolsa, S.A. de C.V. '),(55,'610','B&B','B y B, Casa de Cambio, S.A. de C.V. '),(56,'614','ACCIVAL','Acciones y Valores Banamex, S.A. de C.V., '),(57,'615','MERRILL LYNCH','Merrill Lynch México, S.A. de C.V. Casa de Bolsa '),(58,'616','FINAMEX','Casa de Bolsa Finamex, S.A. de C.V. '),(59,'617','VALMEX','Valores Mexicanos Casa de Bolsa, S.A. de C.V. '),(60,'618','UNICA','Unica Casa de Cambio, S.A. de C.V. '),(61,'619','MAPFRE','MAPFRE Tepeyac, S.A. '),(62,'620','PROFUTURO','Profuturo G.N.P., S.A. de C.V., Afore '),(63,'621','CB ACTINVER','Actinver Casa de Bolsa, S.A. de C.V. '),(64,'622','OACTIN','OPERADORA ACTINVER, S.A. DE C.V. '),(65,'623','SKANDIA','Skandia Vida, S.A. de C.V. '),(66,'626','CBDEUTSCHE','Deutsche Securities, S.A. de C.V. CASA DE BOLSA '),(67,'627','ZURICH','Zurich Compañía de Seguros, S.A. '),(68,'628','ZURICHVI','Zurich Vida, Compañía de Seguros, S.A. '),(69,'629','SU CASITA','Hipotecaria Su Casita, S.A. de C.V. SOFOM ENR '),(70,'630','CB INTERCAM','Intercam Casa de Bolsa, S.A. de C.V. '),(71,'631','CI BOLSA','CI Casa de Bolsa, S.A. de C.V. '),(72,'632','BULLTICK CB','Bulltick Casa de Bolsa, S.A., de C.V. '),(73,'633','STERLING','Sterling Casa de Cambio, S.A. de C.V. '),(74,'634','FINCOMUN','Fincomún, Servicios Financieros Comunitarios, S.A. de C.V. '),(75,'636','HDI SEGUROS','HDI Seguros, S.A. de C.V. '),(76,'637','ORDER','Order Express Casa de Cambio, S.A. de C.V '),(77,'638','AKALA','Akala, S.A. de C.V., Sociedad Financiera Popular '),(78,'640','CB  JPMORGAN','J.P. Morgan Casa de Bolsa, S.A. de C.V. J.P. Morgan Grupo Financiero '),(79,'642','REFORMA','Operadora de Recursos Reforma, S.A. de C.V., S.F.P. '),(80,'646','STP','Sistema de Transferencias y Pagos STP, S.A. de C.V.SOFOM ENR '),(81,'647','TELECOMM','Telecomunicaciones de México '),(82,'648','EVERCORE','Evercore Casa de Bolsa, S.A. de C.V. '),(83,'649','SKANDIA','Skandia Operadora de Fondos, S.A. de C.V. '),(84,'651','SEGMTY','Seguros Monterrey New York Life, S.A de C.V '),(85,'652','ASEA','Solución Asea, S.A. de C.V., Sociedad Financiera Popular '),(86,'653','KUSPIT','Kuspit Casa de Bolsa, S.A. de C.V. '),(87,'655','SOFIEXPRESS','J.P. SOFIEXPRESS, S.A. de C.V., S.F.P. '),(88,'656','UNAGRA','UNAGRA, S.A. de C.V., S.F.P. '),(89,'659','OPCIONES EMPRESARIALES DEL NOROESTE','OPCIONES EMPRESARIALES DEL NORESTE, S.A. DE C.V., S.F.P. '),(90,'670','LIBERTAD','Cls Bank International '),(91,'901','CLS','SD. Indeval, S.A. de C.V. '),(92,'902','INDEVAL','Libertad Servicios Financieros, S.A. De C.V. '),(93,'999','N/A','');
/*!40000 ALTER TABLE `catbancos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `catpreguntas`
--

DROP TABLE IF EXISTS `catpreguntas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `catpreguntas` (
  `pg_idpregunta` int(3) NOT NULL AUTO_INCREMENT,
  `pg_pregunta` varchar(255) NOT NULL,
  `pg_activo` int(1) NOT NULL,
  PRIMARY KEY (`pg_idpregunta`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `catpreguntas`
--

LOCK TABLES `catpreguntas` WRITE;
/*!40000 ALTER TABLE `catpreguntas` DISABLE KEYS */;
INSERT INTO `catpreguntas` VALUES (1,'¿Cuál es tu película favorita?',1),(2,'¿Nombre de tu primera mascota?',1),(3,'¿Segundo apellido de tu mamá?',1);
/*!40000 ALTER TABLE `catpreguntas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `catregimenfiscal`
--

DROP TABLE IF EXISTS `catregimenfiscal`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `catregimenfiscal` (
  `rg_id_regimen` int(11) DEFAULT NULL,
  `rg_Clave` int(11) DEFAULT NULL,
  `rg_Regimen` varchar(128) DEFAULT NULL,
  `rg_P_Fisica` int(11) DEFAULT NULL,
  `rg_P_Moral` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `catregimenfiscal`
--

LOCK TABLES `catregimenfiscal` WRITE;
/*!40000 ALTER TABLE `catregimenfiscal` DISABLE KEYS */;
INSERT INTO `catregimenfiscal` VALUES (1,601,'General de Ley Personas Morales',0,1),(2,603,'Personas Morales con Fines no Lucrativos',0,1),(3,605,'Sueldos y Salarios e Ingresos Asimilados a Salarios',1,0),(4,606,'Arrendamiento',1,0),(5,607,'Régimen de Enajenación o Adquisición de Bienes',1,0),(6,608,'Demás ingresos',1,0),(7,610,'Residentes en el Extranjero sin Establecimiento Permanente en México',1,1),(8,611,'Ingresos por Dividendos (socios y accionistas)',1,0),(9,612,'Personas Físicas con Actividades Empresariales y Profesionales',1,0),(10,614,'Ingresos por intereses',1,0),(11,615,'Régimen de los ingresos por obtención de premios',1,0),(12,616,'Sin obligaciones fiscales',1,0),(13,620,'Sociedades Cooperativas de Producción que optan por diferir sus ingresos',0,1),(14,621,'Incorporación Fiscal',1,0),(15,622,'Actividades Agrícolas, Ganaderas, Silvícolas y Pesqueras',0,1),(16,623,'Opcional para Grupos de Sociedades',0,1),(17,624,'Coordinados',0,1),(18,625,'Régimen de las Actividades Empresariales con ingresos a través de Plataformas Tecnológicas',1,0),(19,626,'Régimen Simplificado de Confianza',1,1);
/*!40000 ALTER TABLE `catregimenfiscal` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cattipovalor`
--

DROP TABLE IF EXISTS `cattipovalor`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cattipovalor` (
  `cv_idTipoValor` int(3) NOT NULL AUTO_INCREMENT,
  `cv_Descripcion` varchar(255) NOT NULL,
  `cv_Activo` tinyint(1) NOT NULL,
  PRIMARY KEY (`cv_idTipoValor`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cattipovalor`
--

LOCK TABLES `cattipovalor` WRITE;
/*!40000 ALTER TABLE `cattipovalor` DISABLE KEYS */;
INSERT INTO `cattipovalor` VALUES (1,'Cadena',1),(2,'Numerico',1),(3,'Logico',1);
/*!40000 ALTER TABLE `cattipovalor` ENABLE KEYS */;
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
-- Table structure for table `configuracion`
--

DROP TABLE IF EXISTS `configuracion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `configuracion` (
  `cnf_idConfiguracion` int(3) NOT NULL AUTO_INCREMENT,
  `cnf_idPersona` int(3) NOT NULL,
  `cnf_idElementoConfigurable` int(3) NOT NULL,
  `cnf_Valor` varchar(100) NOT NULL,
  `cnf_Activo` int(1) NOT NULL,
  PRIMARY KEY (`cnf_idConfiguracion`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `configuracion`
--

LOCK TABLES `configuracion` WRITE;
/*!40000 ALTER TABLE `configuracion` DISABLE KEYS */;
INSERT INTO `configuracion` VALUES (1,1,1,'/nombre_archivo.png',1);
/*!40000 ALTER TABLE `configuracion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contacto`
--

DROP TABLE IF EXISTS `contacto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `contacto` (
  `c_idContacto` int(4) NOT NULL AUTO_INCREMENT,
  `c_idTipoContacto` blob NOT NULL,
  `c_idPersona` blob NOT NULL,
  `c_Descripcion` blob NOT NULL,
  `c_Activo` tinyint(1) NOT NULL,
  PRIMARY KEY (`c_idContacto`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contacto`
--

LOCK TABLES `contacto` WRITE;
/*!40000 ALTER TABLE `contacto` DISABLE KEYS */;
INSERT INTO `contacto` VALUES (3,_binary '\n\�\�aXz�\�O6Y\�',_binary '\n\�\�aXz�\�O6Y\�',_binary '\�}\�C��\�Y��\�&≴��;\���L�;R\�Gp�',1);
/*!40000 ALTER TABLE `contacto` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cuentabacaria`
--

DROP TABLE IF EXISTS `cuentabacaria`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cuentabacaria` (
  `b_idCtaBancaria` int(3) NOT NULL AUTO_INCREMENT,
  `b_idCatBanco` int(3) NOT NULL,
  `b_CLABE` blob NOT NULL,
  `b_Activo` tinyint(1) NOT NULL,
  PRIMARY KEY (`b_idCtaBancaria`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cuentabacaria`
--

LOCK TABLES `cuentabacaria` WRITE;
/*!40000 ALTER TABLE `cuentabacaria` DISABLE KEYS */;
INSERT INTO `cuentabacaria` VALUES (3,1,_binary '\�dq`.�m\�H!�\�ԛ��P�\�c x�_\�',1);
/*!40000 ALTER TABLE `cuentabacaria` ENABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `direccion`
--

LOCK TABLES `direccion` WRITE;
/*!40000 ALTER TABLE `direccion` DISABLE KEYS */;
INSERT INTO `direccion` VALUES (1,1,'En la calle con el numero X','No conocida','','CDMX',6000,1),(2,3,'En la calle con el numero X','No conocida','','CDMX',6000,1);
/*!40000 ALTER TABLE `direccion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `elementoconfigurable`
--

DROP TABLE IF EXISTS `elementoconfigurable`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `elementoconfigurable` (
  `ec_idElementoConfigurable` int(3) NOT NULL AUTO_INCREMENT,
  `ec_Descripcion` varchar(255) NOT NULL,
  `ec_idTipoValor` int(3) NOT NULL,
  `ec_Activo` tinyint(1) NOT NULL,
  PRIMARY KEY (`ec_idElementoConfigurable`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `elementoconfigurable`
--

LOCK TABLES `elementoconfigurable` WRITE;
/*!40000 ALTER TABLE `elementoconfigurable` DISABLE KEYS */;
INSERT INTO `elementoconfigurable` VALUES (1,'ImagenPerfil',1,1);
/*!40000 ALTER TABLE `elementoconfigurable` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `estados`
--

DROP TABLE IF EXISTS `estados`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `estados` (
  `e_IdEstado` int(11) DEFAULT NULL,
  `e_Descripcion` varchar(50) DEFAULT NULL,
  `e_alias` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `estados`
--

LOCK TABLES `estados` WRITE;
/*!40000 ALTER TABLE `estados` DISABLE KEYS */;
INSERT INTO `estados` VALUES (1,'Aguascalientes','Ags.'),(2,'Baja California','BC'),(3,'Baja California Sur','BCS'),(4,'Campeche','Camp.'),(5,'Coahuila de Zaragoza','Coah.'),(6,'Colima','Col.'),(7,'Chiapas','Chis.'),(8,'Chihuahua','Chih.'),(9,'Ciudad de México','CDMX'),(10,'Durango','Dgo.'),(11,'Guanajuato','Gto.'),(12,'Guerrero','Gro.'),(13,'Hidalgo','Hgo.'),(14,'Jalisco','Jal.'),(15,'México','Mex.'),(16,'Michoacán de Ocampo','Mich.'),(17,'Morelos','Mor.'),(18,'Nayarit','Nay.'),(19,'Nuevo León','NL'),(20,'Oaxaca','Oax.'),(21,'Puebla','Pue.'),(22,'Querátaro','Qro.'),(23,'Quintana Roo','Q. Roo'),(24,'San Luis Potosí','SLP'),(25,'Sinaloa','Sin.'),(26,'Sonora','Son.'),(27,'Tabasco','Tab.'),(28,'Tamaulipas','Tamps.'),(29,'Tlaxcala','Tlax.'),(30,'Veracruz de Ignacio de la Llave','Ver.'),(31,'Yucatán','Yuc.'),(32,'Zacatecas','Zac.');
/*!40000 ALTER TABLE `estados` ENABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `estatuscm`
--

LOCK TABLES `estatuscm` WRITE;
/*!40000 ALTER TABLE `estatuscm` DISABLE KEYS */;
INSERT INTO `estatuscm` VALUES (1,'Alta',1),(2,'Conciliada',1),(3,'Pagada',1);
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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `estatuscp`
--

LOCK TABLES `estatuscp` WRITE;
/*!40000 ALTER TABLE `estatuscp` DISABLE KEYS */;
INSERT INTO `estatuscp` VALUES (1,'Alta',1),(2,'Baja',1),(3,'En aprobación',1);
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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `estatuso`
--

LOCK TABLES `estatuso` WRITE;
/*!40000 ALTER TABLE `estatuso` DISABLE KEYS */;
INSERT INTO `estatuso` VALUES (1,'Cargada',1),(2,'Por autroizar',1),(3,'Autorizada',1),(4,'Proceso pago',1),(5,'Pagada',1);
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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `perfil`
--

LOCK TABLES `perfil` WRITE;
/*!40000 ALTER TABLE `perfil` DISABLE KEYS */;
INSERT INTO `perfil` VALUES (1,'Administrador',1),(2,'Administrador Ex',1),(3,'Colaborador Editor',1),(4,'Colaborador Consulta',1);
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
  `per_Nombre` blob DEFAULT NULL,
  `per_Apellido` blob DEFAULT NULL,
  `per_Alias` blob DEFAULT NULL,
  `per_RFC` blob DEFAULT NULL,
  `per_idTipoPrersona` blob DEFAULT NULL,
  `per_idRol` blob DEFAULT NULL,
  `per_ActivoFintec` blob DEFAULT 0,
  `per_RegimenFiscal` blob DEFAULT NULL,
  `per_idCtaBanco` blob DEFAULT NULL,
  `per_logo` blob DEFAULT NULL,
  `per_Activo` int(1) DEFAULT NULL,
  PRIMARY KEY (`per_idPersona`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `persona`
--

LOCK TABLES `persona` WRITE;
/*!40000 ALTER TABLE `persona` DISABLE KEYS */;
INSERT INTO `persona` VALUES (3,_binary 'G�\���p�.\�2��\�',_binary '��\�C���HX�\�\�I\�̼g\ny�ʖaۯ�\�U�Z',_binary '\�W\�f��P\�N�\�:m',_binary '\�6�ڒ\r\�Ę4X}.�\�4',_binary '��\�60oԝh1.\�<{!',_binary '��\�60oԝh1.\�<{!',_binary '�yr�#F����D����',_binary '��\�60oԝh1.\�<{!',_binary '��\�60oԝh1.\�<{!',_binary '<*\0:?\�\�\�c5{�',1);
/*!40000 ALTER TABLE `persona` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `preguntapersona`
--

DROP TABLE IF EXISTS `preguntapersona`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `preguntapersona` (
  `pp_idpreguntapersona` int(3) NOT NULL AUTO_INCREMENT,
  `pp_idpersona` int(11) DEFAULT NULL,
  `pp_idpregunta` int(3) NOT NULL,
  `pp_respuestapregunta` blob NOT NULL,
  `pp_Activo` int(1) DEFAULT NULL,
  PRIMARY KEY (`pp_idpreguntapersona`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `preguntapersona`
--

LOCK TABLES `preguntapersona` WRITE;
/*!40000 ALTER TABLE `preguntapersona` DISABLE KEYS */;
INSERT INTO `preguntapersona` VALUES (2,1,1,_binary '\�\\1\\��G\�E��u!}�',1);
/*!40000 ALTER TABLE `preguntapersona` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `representantelegal`
--

DROP TABLE IF EXISTS `representantelegal`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `representantelegal` (
  `rl_idRepresentante` int(3) NOT NULL AUTO_INCREMENT,
  `rl_Nombre` blob DEFAULT NULL,
  `rl_RFC` blob DEFAULT NULL,
  `rl_idPersona` blob DEFAULT NULL,
  `rl_Activo` tinyint(1) NOT NULL,
  PRIMARY KEY (`rl_idRepresentante`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `representantelegal`
--

LOCK TABLES `representantelegal` WRITE;
/*!40000 ALTER TABLE `representantelegal` DISABLE KEYS */;
INSERT INTO `representantelegal` VALUES (2,_binary '9c�@X\�-�\�\�\�L��',_binary '\�n�?�a\�|���\�',_binary '\n\�\�aXz�\�O6Y\�',1);
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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rol`
--

LOCK TABLES `rol` WRITE;
/*!40000 ALTER TABLE `rol` DISABLE KEYS */;
INSERT INTO `rol` VALUES (1,'Cliente',1),(2,'Proveedor',1);
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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipocontacto`
--

LOCK TABLES `tipocontacto` WRITE;
/*!40000 ALTER TABLE `tipocontacto` DISABLE KEYS */;
INSERT INTO `tipocontacto` VALUES (1,'Fijo',1),(2,'Movil',1),(3,'eMail',1);
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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipodocumento`
--

LOCK TABLES `tipodocumento` WRITE;
/*!40000 ALTER TABLE `tipodocumento` DISABLE KEYS */;
INSERT INTO `tipodocumento` VALUES (1,'Factura',1),(2,'Comp Egreso',1);
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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipopersona`
--

LOCK TABLES `tipopersona` WRITE;
/*!40000 ALTER TABLE `tipopersona` DISABLE KEYS */;
INSERT INTO `tipopersona` VALUES (1,'Fisica',1),(2,'Moral',1);
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
  `u_idPersona` blob DEFAULT NULL,
  `u_NombreUsuario` blob DEFAULT NULL,
  `u_Llaveacceso` blob DEFAULT NULL,
  `u_idPerfil` blob DEFAULT NULL,
  `u_imagenUsuario` blob DEFAULT NULL,
  `u_Activo` tinyint(1) NOT NULL,
  PRIMARY KEY (`u_idUsuario`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuario`
--

LOCK TABLES `usuario` WRITE;
/*!40000 ALTER TABLE `usuario` DISABLE KEYS */;
INSERT INTO `usuario` VALUES (3,_binary '\n\�\�aXz�\�O6Y\�',_binary '2\�<+\�[��g��l ',_binary '3 \�C�^1\�A�!d��ѕ9O/\�\���|�\�me\�R�\�*V\�\�\�U0p�~N{',_binary '��\�60oԝh1.\�<{!',_binary '�\nHXp�PX�P$\�қ�~\�?�\�;ΐz~���;\r',1);
/*!40000 ALTER TABLE `usuario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary view structure for view `vistapersonausuario`
--

DROP TABLE IF EXISTS `vistapersonausuario`;
/*!50001 DROP VIEW IF EXISTS `vistapersonausuario`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `vistapersonausuario` AS SELECT 
 1 AS `per_idPersona`,
 1 AS `per_Nombre`,
 1 AS `per_Alias`,
 1 AS `per_RFC`,
 1 AS `per_idTipoPrersona`,
 1 AS `per_idRol`,
 1 AS `per_ActivoFintec`,
 1 AS `per_Activo`,
 1 AS `rl_idRepresentante`,
 1 AS `rl_Nombre`,
 1 AS `rl_RFC`,
 1 AS `rl_idPersona`,
 1 AS `rl_Activo`,
 1 AS `u_idUsuario`,
 1 AS `u_idPersona`,
 1 AS `u_NombreUsuario`,
 1 AS `u_idPerfil`,
 1 AS `u_Activo`*/;
SET character_set_client = @saved_cs_client;

--
-- Dumping events for database 'compensapay'
--

--
-- Dumping routines for database 'compensapay'
--
/*!50003 DROP FUNCTION IF EXISTS `AgregaContacto` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER $$
$$
CREATE DEFINER=`root`@`localhost` FUNCTION `AgregaContacto`(entrada blob,

llave varchar(100)) RETURNS blob
begin
  	declare resultado blob;
	declare contenido varchar(50);
	declare idPersona int(3);
	declare idTipoContacto int(3);
	set contenido = JSON_UNQUOTE(json_extract(entrada,'$.Contenido'));
	set idPersona = JSON_UNQUOTE(json_extract(entrada,'$.idPersona'));
	set idTipoContacto = JSON_UNQUOTE(json_extract(entrada,'$.idTipoContacto'));
	insert into compensapay.contacto (c_idTipoContacto,
 									c_idPersona,
 									c_Descripcion,
 									c_Activo) values
 									(aes_encrypt(idTipoContacto,llave),
 									aes_encrypt(idPersona,llave),
 									aes_encrypt(contenido,llave),
 									1
 									);
  select
	count(c_Descripcion)
into
	resultado
from
	compensapay.contacto c 
where
	aes_decrypt(c_idTipoContacto,llave) = idTipoContacto and 
	aes_decrypt(c_idPersona,llave) = idPersona and 
	aes_decrypt(c_Descripcion,llave) = Contenido
	and c_Activo = 1;
  RETURN resultado;
END ;$$
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP FUNCTION IF EXISTS `AgregaCtaBancaria` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER $$
$$
CREATE DEFINER=`root`@`localhost` FUNCTION `AgregaCtaBancaria`(entrada blob,llave varchar(100)) RETURNS blob
begin
  	declare resultado blob;
  	declare idPersona int(3);
  	declare idBanco int(3);
  	declare contenido varchar(50);
  	declare idcuenta int(3);
    declare existe int (3);
	set idPersona = JSON_UNQUOTE(json_extract(entrada,'$.idPersona'));
	set idBanco = JSON_UNQUOTE(json_extract(entrada,'$.idBanco'));
	set contenido = JSON_UNQUOTE(json_extract(entrada,'$.CLABE'));
select c.b_idCtaBancaria into existe
from compensapay.cuentabacaria c 
where aes_decrypt (b_CLABE,llave)=contenido;
if existe then
	set resultado = 0;
else 
	insert into compensapay.cuentabacaria (
								b_idCatBanco,
								b_CLABE,
								b_Activo 
								)
							values
								(
								idBanco,
								aes_encrypt(contenido,llave),
								1
								);
select c.b_idCtaBancaria into idcuenta 
from compensapay.cuentabacaria c 
where aes_decrypt(b_CLABE,llave)=contenido and b_Activo = 1 ;

update compensapay.persona p 
set p.per_idCtaBanco = aes_encrypt(idcuenta,llave) 
where aes_decrypt (p.per_idPersona,llave)=idPersona
and p.per_Activo = 1;

select
	count(aes_decrypt (p.per_idCtaBanco,llave))
into
	resultado
from
	compensapay.persona p 
where
	p.per_idPersona =  idPersona and 
	p.per_Activo = 1;
end if;

RETURN resultado;

END ;$$
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP FUNCTION IF EXISTS `AgregaDireccion` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER $$
$$
CREATE DEFINER=`root`@`localhost` FUNCTION `AgregaDireccion`(entrada blob) RETURNS blob
begin
  	declare resultado blob;
  	declare idPersona int(3);
	set idPersona = JSON_UNQUOTE(json_extract(entrada,'$.idPersona'));
insert into compensapay.direccion (	d_idPersona,
 									d_CalleYNumero,
 									d_Colonia,
 									d_Ciudad,
 									d_Estado,
 									d_CodPost,
 									d_Activo) values
 									(
 									idPersona,
 									JSON_UNQUOTE(json_extract(entrada,'$.CalleyNumero')),
 									JSON_UNQUOTE(json_extract(entrada,'$.Colonia')),
 									JSON_UNQUOTE(json_extract(entrada,'$.Ciudad')),
 									JSON_UNQUOTE(json_extract(entrada,'$.Estado')),
 									JSON_UNQUOTE(json_extract(entrada,'$.CodPostal')),
 									1
 									);
select
	count(d_CalleyNumero)
into
	resultado
from
	compensapay.direccion d  
where
	d.d_idPersona  = idPersona  
and d.d_Activo  = 1 ;
  RETURN resultado;

END ;$$
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP FUNCTION IF EXISTS `AgregaPersona` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER $$
$$
CREATE DEFINER=`root`@`localhost` FUNCTION `AgregaPersona`(entrada blob, llave varchar(100)) RETURNS blob
begin
  	declare resultado blob;
	declare rfc varchar(16);
set
rfc = JSON_UNQUOTE(json_extract(entrada,'$.RFC'));
 insert into compensapay.persona (per_Nombre,
 									per_Apellido,
 									per_Alias,
 									per_RFC,
 									per_idTipoPrersona,
 									per_idRol,
 									per_ActivoFintec,
 									per_RegimenFiscal,
 									per_idCtaBanco,
 									per_logo,
 									per_Activo) values
 									(
 									aes_encrypt(JSON_UNQUOTE(json_extract(entrada,'$.Nombre')),llave),
 									aes_encrypt(JSON_UNQUOTE(json_extract(entrada,'$.Apellido')),llave),
 									aes_encrypt(JSON_UNQUOTE(json_extract (entrada,'$.Alias')),llave),
 									aes_encrypt(rfc,llave),
 									aes_encrypt(JSON_UNQUOTE(json_extract(entrada,'$.TipoPersona')),llave),
 									aes_encrypt(JSON_UNQUOTE(json_extract(entrada,'$.Rol')),llave),
 									aes_encrypt(JSON_UNQUOTE(json_extract(entrada,'$.ActivoFintec')),llave),
 									aes_encrypt(JSON_UNQUOTE(json_extract(entrada,'$.RegimenFical')),llave),
 									aes_encrypt(JSON_UNQUOTE(json_extract(entrada,'$.idCtaBanco')),llave),
 									aes_encrypt(JSON_UNQUOTE(json_extract(entrada,'$.Logo')),llave),
 									1
 									);

  select per_idPersona  into resultado from compensapay.persona p where aes_decrypt(per_RFC,llave) = rfc and per_Activo = 1;								

  RETURN resultado;

END ;$$
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP FUNCTION IF EXISTS `AgregaPregunta` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER $$
$$
CREATE DEFINER=`root`@`localhost` FUNCTION `AgregaPregunta`(entrada blob, llave varchar(100)) RETURNS blob
begin
  	declare resultado blob;
  	declare contenido varchar(50);
	declare idPersona int(3);
	declare idPregunta int(3);
set idPersona = JSON_UNQUOTE(json_extract(entrada,'$.idPersona'));
set idPregunta = JSON_UNQUOTE(json_extract(entrada,'$.idPregunta'));
set contenido = JSON_UNQUOTE(json_extract(entrada,'$.Respuesta'));

insert into compensapay.preguntapersona (
										pp_idpersona,
										pp_idpregunta,
										pp_respuestapregunta,
										pp_Activo
 									) values
 									(idPersona,
 									idPregunta,
 									aes_encrypt(upper(trim(contenido)),llave),
 									1
 									);

  select
	count(pp_idpregunta)
into
	resultado
from
	compensapay.preguntapersona p 
where
	pp_idpersona = idPersona and 
	pp_idpregunta = idPregunta 
	and pp_Activo = 1;
  RETURN resultado;
END ;$$
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP FUNCTION IF EXISTS `AgregaRepresentante` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER $$
$$
CREATE DEFINER=`root`@`localhost` FUNCTION `AgregaRepresentante`(entrada blob, llave varchar(100)) RETURNS blob
begin
  	declare resultado blob;
	declare nombre varchar(30);
set nombre = JSON_UNQUOTE(json_extract(entrada,'$.NombreRepresentante'));
insert
	into
	compensapay.representantelegal (rl_Nombre,
	rl_RFC,
	rl_idPersona,
	rl_Activo)
values
 									(aes_encrypt (nombre,llave),
 									aes_encrypt(JSON_UNQUOTE(json_extract(entrada,'$.RFC')),llave),
 									aes_encrypt(JSON_UNQUOTE(json_extract (entrada,'$.idPersona')),llave),
 									1);

select
	count(rl_Nombre)
into
	resultado
from
	compensapay.representantelegal
where
	aes_decrypt(rl_Nombre,
	llave) = nombre
	and rl_Activo = 1;

return resultado;

end ;$$
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP FUNCTION IF EXISTS `AgregarOperacion` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER $$
$$
CREATE DEFINER=`root`@`localhost` FUNCTION `AgregarOperacion`(entrada blob, llave varchar(100)) RETURNS blob
begin
	declare resultado blob;
	declare nombre varchar(30);
set nombre = JSON_UNQUOTE(json_extract(entrada,'$.NombreRepresentante'));

insert
	into
	compensapay.representantelegal (rl_Nombre,
	rl_RFC,
	rl_idPersona,
	rl_Activo)
values
 									(aes_encrypt (nombre,llave),
 									aes_encrypt(JSON_UNQUOTE(json_extract(entrada,'$.RFC')),llave),
 									aes_encrypt(JSON_UNQUOTE(json_extract (entrada,'$.idPersona')),llave),
 									1);

select
	count(rl_Nombre)
into
	resultado
from
	compensapay.representantelegal
where
	aes_decrypt(rl_Nombre,
	llave) = nombre
	and rl_Activo = 1;
return resultado;

end ;$$
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP FUNCTION IF EXISTS `AgregaUsuario` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER $$
$$
CREATE DEFINER=`root`@`localhost` FUNCTION `AgregaUsuario`(entrada blob,llave varchar(100)) RETURNS blob
begin

  declare resultado blob;
  declare nomuser varchar(30);
set nomuser = JSON_UNQUOTE(json_extract(entrada,'$.NombreUsuario'));
 insert into compensapay.usuario (u_NombreUsuario,
 									u_Llaveacceso,
 									u_idPersona,
 									u_idPerfil,
 									u_imagenUsuario,
 									u_Activo) values
 									(aes_encrypt(nomuser,llave),
 									aes_encrypt (MD5(JSON_UNQUOTE(json_extract(entrada,'$.LlaveAcceso'))),llave),
 									aes_encrypt(JSON_UNQUOTE(json_extract(entrada,'$.idPersona')),llave),
 									aes_encrypt(JSON_UNQUOTE(json_extract (entrada,'$.idPerfil')),llave),
 									aes_encrypt(JSON_UNQUOTE(json_extract (entrada,'$.urlImagen')),llave),
 									1
 									);
  select count(u_NombreUsuario) into resultado 
  from compensapay.usuario 
  where aes_decrypt(u_NombreUsuario,llave) = nomuser 
  and u_Activo = 1;								

  RETURN resultado;
END ;$$
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP FUNCTION IF EXISTS `ConsultaEmpresa` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER $$
$$
CREATE DEFINER=`root`@`localhost` FUNCTION `ConsultaEmpresa`(entrada blob,llave varchar(100)) RETURNS blob
begin

	declare resultado blob;
	declare idPersona int;

	set idPersona = JSON_UNQUOTE(json_extract(entrada,'$.idPersona'));

select
concat('[',
        GROUP_CONCAT(
	JSON_OBJECT (
	'Nombre', aes_decrypt (per_Nombre,llave),
	'Alias', aes_decrypt (per_Alias,llave),
	'RFC', aes_decrypt (per_RFC,llave),
	'idTipoPersona', aes_decrypt (per_idTipoPrersona, llave),
	'idRol', aes_decrypt (per_idRol, llave),
	'ActivoFintec', aes_decrypt (per_ActivoFintec, llave),
	'idRegimenFiscal', aes_decrypt (per_RegimenFiscal, llave),
	'idCuentaBanco', aes_decrypt (per_idCtaBanco, llave),
	'Banco', c2.Alias,
	'imagenPersona', aes_decrypt (per_logo ,llave),
	'imagenUsuario', aes_decrypt (u.u_imagenUsuario, llave),
	'idUsuario', u.u_idUsuario)
	  SEPARATOR ',')
    ,']')

	into resultado
from
	persona p
inner join representantelegal r  
on
	p.per_idPersona = aes_decrypt(r.rl_idPersona, llave)
inner join usuario u 
on
	aes_decrypt(r.rl_idPersona,	llave) = aes_decrypt(u.u_idPersona,	llave)
inner join tipopersona t 
on
	t.tp_idTipoPersona = aes_decrypt(p.per_idTipoPrersona,	llave)
inner join cuentabacaria c on
	c.b_idCatBanco = aes_decrypt (per_idCtaBanco,llave)
inner join catbancos c2 on
	c.b_idCatBanco = c2.id 
where
	per_Activo = 1
	and u_Activo = 1
	and rl_Activo = 1
	and t.tp_Activo = 1
	and per_idPersona = idPersona;

return resultado;

END ;$$
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP FUNCTION IF EXISTS `ConsultaPersona` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER $$
$$
CREATE DEFINER=`root`@`localhost` FUNCTION `ConsultaPersona`(entrada int,llave varchar(100)) RETURNS blob
begin

	declare salida blob;
	select
	concat('[',
        GROUP_CONCAT(
			JSON_OBJECT (
			'nombre', aes_decrypt (per_Nombre,llave),
			'alias', aes_decrypt (per_Alias,llave),
			'rfc', aes_decrypt (per_RFC,llave),
			'idtipopersona', aes_decrypt (per_idTipoPrersona, llave),
			'idrol', aes_decrypt (per_idRol, llave),
			'activofintec',	aes_decrypt (per_ActivoFintec, llave),
			'idregimenfiscal', aes_decrypt (per_RegimenFiscal, llave),
			'idcuentabanco', aes_decrypt (per_idCtaBanco, llave),
			'banco', c2.Alias,
			'clabe', aes_decrypt (c.b_CLABE,llave),
			'logo_persona',	aes_decrypt (per_logo ,llave),
			'logo_usuario',	aes_decrypt (u.u_imagenUsuario, llave),
			'id_usuario', u.u_idUsuario) 	) 
	separator ',')
    , ']')
    into salida
from
	persona p
inner join representantelegal r  
on
	p.per_idPersona = aes_decrypt(r.rl_idPersona,llave)
inner join usuario u 
on
	aes_decrypt(r.rl_idPersona,llave) = aes_decrypt(u.u_idPersona,llave)
inner join tipopersona t 
on
	t.tp_idTipoPersona = aes_decrypt(p.per_idTipoPrersona,llave)
inner join cuentabacaria c on
	c.b_idCatBanco = aes_decrypt (per_idCtaBanco,llave)
inner join catbancos c2 on
	c.b_idCatBanco = c2.id 
inner join compensapay.rol on
	rol.r_idRol= aes_decrypt(p.per_idRol,llave)
inner join compensapay.perfil on
	perfil.p_idPerfil = aes_decrypt (u.u_idPerfil,llave) 
where
	per_Activo = 1
	and u_Activo = 1
	and rl_Activo = 1
	and t.tp_Activo = 1
	and per_idPersona = entrada;

return salida;

END ;$$
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP FUNCTION IF EXISTS `ConsutlarEstadosMX` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER $$
CREATE DEFINER=`root`@`localhost` FUNCTION `ConsutlarEstadosMX`() RETURNS blob
begin
  declare salida blob;
select
	concat('[',
        GROUP_CONCAT(
            JSON_OBJECT (
				'id_estado', e.e_IdEstado,
				'Nombre', e.e_Descripcion,
				'alias', e.e_alias)
            SEPARATOR ',')
    ,']')

into
	salida
from
	estados e;

return salida;
end ;$$
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP FUNCTION IF EXISTS `ExisteRFC` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER $$
CREATE DEFINER=`root`@`localhost` FUNCTION `ExisteRFC`(entrada VARCHAR(20),llave varchar(100)) RETURNS blob
begin

  declare salida blob;
select
	JSON_OBJECT (
		'RFC',aes_decrypt(per_RFC,llave),
		'Nombre',aes_decrypt(per_Nombre,llave),
		'alias',aes_decrypt (per_Alias,llave))
into
	salida
from
	persona
where
	aes_decrypt (per_RFC,llave) = entrada;

return salida;

end ;$$
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP FUNCTION IF EXISTS `ExisteUsuario` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER $$
$$
CREATE DEFINER=`root`@`localhost` FUNCTION `ExisteUsuario`(entrada VARCHAR(50),llave varchar(100)) RETURNS int(1)
BEGIN
  DECLARE salida int;
 	select count(u_NombreUsuario) 
	into salida 
	from usuario 
	where aes_decrypt(u_NombreUsuario,llave) = entrada;
  RETURN salida;
END ;$$
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP FUNCTION IF EXISTS `UpdateLlaveUsuario` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER $$
CREATE DEFINER=`root`@`localhost` FUNCTION `UpdateLlaveUsuario`(entrada blob, llave varchar(100)) RETURNS blob
begin
	declare resultado blob;
  	declare iduser varchar(100);
  	declare llave_interna varchar(100);
  	declare nueva_llave blob;
  	set iduser = JSON_UNQUOTE(json_extract(entrada,'$.idUsuario'));
  	set llave_interna = JSON_UNQUOTE(json_extract(entrada,'$.Llave'));
    set nueva_llave = aes_encrypt(md5(llave_interna),llave);

 update
	usuario u
 set
	u.u_Llaveacceso = nueva_llave
 where
	u.u_idUsuario = iduser;
 select
 JSON_OBJECT (
	'Perfil',p.p_idPerfil,
	'Persona',aes_decrypt(u.u_idPersona,llave),
	'Usuario',aes_decrypt (u.u_NombreUsuario,llave)) 
 into
	resultado
 from
	compensapay.usuario u
 inner join compensapay.perfil p on aes_decrypt(u.u_idPerfil,llave) = p.p_idPerfil 
	where
	u.u_idUsuario = iduser
	and aes_decrypt(u.u_Llaveacceso,llave) = md5(llave_interna);
return resultado;

END ;$$
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP FUNCTION IF EXISTS `ValidarLlave` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER $$
$$
CREATE DEFINER=`root`@`localhost` FUNCTION `ValidarLlave`(entrada blob,llave varchar(100)) RETURNS blob
begin
  declare resultado blob;
  declare usuario varchar(100);
  declare llave_interna varchar(100);
  set usuario = JSON_UNQUOTE(json_extract(entrada,'$.Usuario'));
  set llave_interna = JSON_UNQUOTE(json_extract(entrada,'$.Llave'));
 select
 JSON_OBJECT (
	'Perfil',p.p_idPerfil,
	'Persona',aes_decrypt(u.u_idPersona, llave),
	'Usuario',aes_decrypt(u.u_NombreUsuario,llave)) 
into
	resultado
from
	compensapay.usuario u
inner join compensapay.perfil p on aes_decrypt(u.u_idPerfil,llave) = p.p_idPerfil 
	where
	aes_decrypt(u_NombreUsuario,llave) = usuario
	and aes_decrypt(u_Llaveacceso,llave) = md5(llave_interna);
RETURN resultado;

end ;$$
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP FUNCTION IF EXISTS `VerBanco` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER $$
$$
CREATE DEFINER=`root`@`localhost` FUNCTION `VerBanco`(entrada VARCHAR(4)) RETURNS varchar(100) CHARSET utf8mb4 COLLATE utf8mb4_general_ci
begin

  declare salida varchar(100);
select
	JSON_OBJECT (
		'Clave',Clave,
		'Alias',Alias  
	)
into
	salida
from
	catbancos 
where
	compensapay.catbancos.Clave = entrada;

return salida;

end ;$$
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP FUNCTION IF EXISTS `VerCatPreguntas` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER $$
$$
CREATE DEFINER=`root`@`localhost` FUNCTION `VerCatPreguntas`() RETURNS blob
begin
	declare salida blob;
	select	
		concat('[',
        GROUP_CONCAT(
			JSON_OBJECT (
				'idpregunta',pg_idpregunta,
				'pregunta',pg_pregunta
			 ) 
	separator ',')
    , ']')
into
	salida
from
	catpreguntas 
where
	pg_activo  = 1;
return salida;

END ;$$
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP FUNCTION IF EXISTS `VerRegimenFiscal` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER $$
CREATE DEFINER=`root`@`localhost` FUNCTION `VerRegimenFiscal`(tipopersona int) RETURNS blob
begin
	declare salida blob;
	declare fisica int;
	declare moral int;

if tipopersona = 1
	then
		select	
		concat('[',
        GROUP_CONCAT(
			JSON_OBJECT (
				'id_regimen',rg_id_regimen,
				'Clave',rg_Clave,
				'Regimen',rg_Regimen ) 
	separator ',')
    , ']')
into
	salida
from
	catregimenfiscal
where
	rg_P_Fisica = 1;

elseif tipopersona = 2 then
		select
		concat('[',
        GROUP_CONCAT(
			JSON_OBJECT (
				'id_regimen',rg_id_regimen,
				'Clave',rg_Clave,
				'Regimen',rg_Regimen  
	) separator ',')
    , ']')
into
	salida
from
	catregimenfiscal
where
	rg_P_Moral = 1;
end if;
return salida;

end ;$$
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Final view structure for view `vistapersonausuario`
--

/*!50001 DROP VIEW IF EXISTS `vistapersonausuario`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `vistapersonausuario` AS select `persona`.`per_idPersona` AS `per_idPersona`,`persona`.`per_Nombre` AS `per_Nombre`,`persona`.`per_Alias` AS `per_Alias`,`persona`.`per_RFC` AS `per_RFC`,`persona`.`per_idTipoPrersona` AS `per_idTipoPrersona`,`persona`.`per_idRol` AS `per_idRol`,`persona`.`per_ActivoFintec` AS `per_ActivoFintec`,`persona`.`per_Activo` AS `per_Activo`,`representantelegal`.`rl_idRepresentante` AS `rl_idRepresentante`,`representantelegal`.`rl_Nombre` AS `rl_Nombre`,`representantelegal`.`rl_RFC` AS `rl_RFC`,`representantelegal`.`rl_idPersona` AS `rl_idPersona`,`representantelegal`.`rl_Activo` AS `rl_Activo`,`usuario`.`u_idUsuario` AS `u_idUsuario`,`usuario`.`u_idPersona` AS `u_idPersona`,`usuario`.`u_NombreUsuario` AS `u_NombreUsuario`,`usuario`.`u_idPerfil` AS `u_idPerfil`,`usuario`.`u_Activo` AS `u_Activo` from ((`persona` join `representantelegal` on(`persona`.`per_idPersona` = `representantelegal`.`rl_idPersona`)) join `usuario` on(`representantelegal`.`rl_idPersona` = `usuario`.`u_idPersona`)) where `persona`.`per_Activo` = 1 and `usuario`.`u_Activo` = 1 and `representantelegal`.`rl_Activo` = 1 */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;
-- Dump completed on 2023-09-20  9:03:00
