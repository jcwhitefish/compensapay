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
INSERT INTO `acceso` VALUES (1,1,_binary '†Ωz*3>Y\nS3v\Œ\ıÑ','',0,NULL,1,NULL,NULL);
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
INSERT INTO `catbancos` VALUES (1,'002','BANAMEX',' Banco Nacional de M√©xico, S.A., Instituci√≥n de Banca M√∫ltiple, Grupo Financiero Banamex '),(2,'006','BANCOMEXT',' Banco Nacional de Comercio Exterior, Sociedad Nacional de Cr√©dito, Instituci√≥n de Banca de Desarrollo '),(3,'009','BANOBRAS',' Banco Nacional de Obras y Servicios P√∫blicos, Sociedad Nacional de Cr√©dito, Instituci√≥n de Banca de Desarrollo '),(4,'012','BBVA BANCOMER',' BBVA Bancomer, S.A., Instituci√≥n de Banca M√∫ltiple, Grupo Financiero BBVA Bancomer '),(5,'014','SANTANDER',' Banco Santander (M√©xico), S.A., Instituci√≥n de Banca M√∫ltiple, Grupo Financiero Santander '),(6,'019','BANJERCITO',' Banco Nacional del Ej√©rcito, Fuerza A√©rea y Armada, Sociedad Nacional de Cr√©dito, Instituci√≥n de Banca de Desarrollo '),(7,'021','HSBC',' HSBC M√©xico, S.A., instituci√≥n De Banca M√∫ltiple, Grupo Financiero HSBC '),(8,'030','BAJIO',' Banco del Baj√≠o, S.A., Instituci√≥n de Banca M√∫ltiple '),(9,'032','IXE',' IXE Banco, S.A., Instituci√≥n de Banca M√∫ltiple, IXE Grupo Financiero '),(10,'036','INBURSA','Banco Inbursa, S.A., Instituci√≥n de Banca M√∫ltiple, Grupo Financiero Inbursa '),(11,'037','INTERACCIONES',' Banco Interacciones, S.A., Instituci√≥n de Banca M√∫ltiple '),(12,'042','MIFEL',' Banca Mifel, S.A., Instituci√≥n de Banca M√∫ltiple, Grupo Financiero Mifel '),(13,'044','SCOTIABANK',' Scotiabank Inverlat, S.A. '),(14,'058','BANREGIO',' Banco Regional de Monterrey, S.A., Instituci√≥n de Banca M√∫ltiple, Banregio Grupo Financiero '),(15,'059','INVEX',' Banco Invex, S.A., Instituci√≥n de Banca M√∫ltiple, Invex Grupo Financiero '),(16,'060','BANSI',' Bansi, S.A., Instituci√≥n de Banca M√∫ltiple '),(17,'062','AFIRME',' Banca Afirme, S.A., Instituci√≥n de Banca M√∫ltiple '),(18,'072','BANORTE',' Banco Mercantil del Norte, S.A., Instituci√≥n de Banca M√∫ltiple, Grupo Financiero Banorte '),(19,'102','THE ROYAL BANK',' The Royal Bank of Scotland M√©xico, S.A., Instituci√≥n de Banca M√∫ltiple '),(20,'103','AMERICAN EXPRESS','American Express Bank (M√©xico), S.A., Instituci√≥n de Banca M√∫ltiple'),(21,'106','BAMSA',' Bank of America M√©xico, S.A., Instituci√≥n de Banca M√∫ltiple, Grupo Financiero Bank of America '),(22,'108','TOKYO','Bank of Tokyo-Mitsubishi UFJ '),(23,'110','JP MORGAN',' Banco J.P. Morgan, S.A., Instituci√≥n de Banca M√∫ltiple, J.P. Morgan Grupo Financiero '),(24,'112','BMONEX',' Banco Monex, S.A., Instituci√≥n de Banca M√∫ltiple '),(25,'113','VE POR MAS',' Banco Ve Por Mas, S.A. Instituci√≥n de Banca M√∫ltiple '),(26,'116','ING',' ING Bank (M√©xico), S.A., Instituci√≥n de Banca M√∫ltiple, ING Grupo Financiero'),(27,'124','DEUTSCHE',' Deutsche Bank M√©xico, S.A., Instituci√≥n de Banca M√∫ltiple '),(28,'126','CREDIT SUISSE','Banco Credit Suisse (M√©xico), S.A. Instituci√≥n de Banca M√∫ltiple, Grupo Financiero Credit Suisse (M√©xico) '),(29,'127','AZTECA',' Banco Azteca, S.A. Instituci√≥n de Banca M√∫ltiple. '),(30,'128','AUTOFIN',' Banco Autofin M√©xico, S.A. Instituci√≥n de Banca M√∫ltiple'),(31,'129','BARCLAYS','Barclays Bank M√©xico, S.A., Instituci√≥n de Banca M√∫ltiple, Grupo Financiero Barclays M√©xico.'),(32,'130','COMPARTAMOS',' Banco Compartamos, S.A., Instituci√≥n de Banca M√∫ltiple '),(33,'131','BANCO FAMSA',' Banco Ahorro Famsa, S.A., Instituci√≥n de Banca M√∫ltiple '),(34,'132','BMULTIVA','Banco Multiva, S.A., Instituci√≥n de Banca M√∫ltiple, Multivalores Grupo Financiero '),(35,'133','ACTINVER','Banco Actinver, S.A. Instituci√≥n de Banca M√∫ltiple, Grupo Financiero Actinver '),(36,'134','WAL-MART','Banco Wal-Mart de M√©xico Adelante, S.A., Instituci√≥n de Banca M√∫ltiple '),(37,'135','NAFIN','Nacional Financiera, Sociedad Nacional de Cr√©dito, Instituci√≥n de Banca de Desarrollo '),(38,'136','INTERBANCO','Inter Banco, S.A. Instituci√≥n de Banca M√∫ltiple '),(39,'137','BANCOPPEL','BanCoppel, S.A., Instituci√≥n de Banca M√∫ltiple '),(40,'138','ABC CAPITAL','ABC Capital, S.A., Instituci√≥n de Banca M√∫ltiple '),(41,'139','UBS BANK','UBS Bank M√©xico, S.A., Instituci√≥n de Banca M√∫ltiple, UBS Grupo Financiero '),(42,'140','CONSUBANCO','Consubanco, S.A. Instituci√≥n de Banca M√∫ltiple '),(43,'141','VOLKSWAGEN','Volkswagen Bank, S.A., Instituci√≥n de Banca M√∫ltiple '),(44,'143','CIBANCO','CIBanco, S.A. '),(45,'145','BBASE','Banco Base, S.A., Instituci√≥n de Banca M√∫ltiple '),(46,'166','BANSEFI','Banco del Ahorro Nacional y Servicios Financieros, Sociedad Nacional de Cr√©dito, Instituci√≥n de Banca de Desarrollo '),(47,'168','HIPOTECARIA FEDERAL','Sociedad Hipotecaria Federal, Sociedad Nacional de Cr√©dito, Instituci√≥n de Banca de Desarrollo '),(48,'600','MONEXCB','Monex Casa de Bolsa, S.A. de C.V. Monex Grupo Financiero '),(49,'601','GBM','GBM Grupo Burs√°til Mexicano, S.A. de C.V. Casa de Bolsa '),(50,'602','MASARI','Masari Casa de Bolsa, S.A. '),(51,'605','VALUE','Value, S.A. de C.V. Casa de Bolsa '),(52,'606','ESTRUCTURADORES','Estructuradores del Mercado de Valores Casa de Bolsa, S.A. de C.V. '),(53,'607','TIBER','Casa de Cambio Tiber, S.A. de C.V. '),(54,'608','VECTOR','Vector Casa de Bolsa, S.A. de C.V. '),(55,'610','B&B','B y B, Casa de Cambio, S.A. de C.V. '),(56,'614','ACCIVAL','Acciones y Valores Banamex, S.A. de C.V., '),(57,'615','MERRILL LYNCH','Merrill Lynch M√©xico, S.A. de C.V. Casa de Bolsa '),(58,'616','FINAMEX','Casa de Bolsa Finamex, S.A. de C.V. '),(59,'617','VALMEX','Valores Mexicanos Casa de Bolsa, S.A. de C.V. '),(60,'618','UNICA','Unica Casa de Cambio, S.A. de C.V. '),(61,'619','MAPFRE','MAPFRE Tepeyac, S.A. '),(62,'620','PROFUTURO','Profuturo G.N.P., S.A. de C.V., Afore '),(63,'621','CB ACTINVER','Actinver Casa de Bolsa, S.A. de C.V. '),(64,'622','OACTIN','OPERADORA ACTINVER, S.A. DE C.V. '),(65,'623','SKANDIA','Skandia Vida, S.A. de C.V. '),(66,'626','CBDEUTSCHE','Deutsche Securities, S.A. de C.V. CASA DE BOLSA '),(67,'627','ZURICH','Zurich Compa√±√≠a de Seguros, S.A. '),(68,'628','ZURICHVI','Zurich Vida, Compa√±√≠a de Seguros, S.A. '),(69,'629','SU CASITA','Hipotecaria Su Casita, S.A. de C.V. SOFOM ENR '),(70,'630','CB INTERCAM','Intercam Casa de Bolsa, S.A. de C.V. '),(71,'631','CI BOLSA','CI Casa de Bolsa, S.A. de C.V. '),(72,'632','BULLTICK CB','Bulltick Casa de Bolsa, S.A., de C.V. '),(73,'633','STERLING','Sterling Casa de Cambio, S.A. de C.V. '),(74,'634','FINCOMUN','Fincom√∫n, Servicios Financieros Comunitarios, S.A. de C.V. '),(75,'636','HDI SEGUROS','HDI Seguros, S.A. de C.V. '),(76,'637','ORDER','Order Express Casa de Cambio, S.A. de C.V '),(77,'638','AKALA','Akala, S.A. de C.V., Sociedad Financiera Popular '),(78,'640','CB  JPMORGAN','J.P. Morgan Casa de Bolsa, S.A. de C.V. J.P. Morgan Grupo Financiero '),(79,'642','REFORMA','Operadora de Recursos Reforma, S.A. de C.V., S.F.P. '),(80,'646','STP','Sistema de Transferencias y Pagos STP, S.A. de C.V.SOFOM ENR '),(81,'647','TELECOMM','Telecomunicaciones de M√©xico '),(82,'648','EVERCORE','Evercore Casa de Bolsa, S.A. de C.V. '),(83,'649','SKANDIA','Skandia Operadora de Fondos, S.A. de C.V. '),(84,'651','SEGMTY','Seguros Monterrey New York Life, S.A de C.V '),(85,'652','ASEA','Soluci√≥n Asea, S.A. de C.V., Sociedad Financiera Popular '),(86,'653','KUSPIT','Kuspit Casa de Bolsa, S.A. de C.V. '),(87,'655','SOFIEXPRESS','J.P. SOFIEXPRESS, S.A. de C.V., S.F.P. '),(88,'656','UNAGRA','UNAGRA, S.A. de C.V., S.F.P. '),(89,'659','OPCIONES EMPRESARIALES DEL NOROESTE','OPCIONES EMPRESARIALES DEL NORESTE, S.A. DE C.V., S.F.P. '),(90,'670','LIBERTAD','Cls Bank International '),(91,'901','CLS','SD. Indeval, S.A. de C.V. '),(92,'902','INDEVAL','Libertad Servicios Financieros, S.A. De C.V. '),(93,'999','N/A','');
/*!40000 ALTER TABLE `catbancos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `catbancos_original`
--

DROP TABLE IF EXISTS `catbancos_original`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `catbancos_original` (
  `cb_idCatBanco` int(3) NOT NULL AUTO_INCREMENT,
  `cb_Clave` int(3) DEFAULT NULL,
  `cb_Descripcion` varchar(50) NOT NULL,
  `cb_Activo` tinyint(1) NOT NULL,
  PRIMARY KEY (`cb_idCatBanco`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `catbancos_original`
--

LOCK TABLES `catbancos_original` WRITE;
/*!40000 ALTER TABLE `catbancos_original` DISABLE KEYS */;
INSERT INTO `catbancos_original` VALUES (1,NULL,'BBVA',1),(2,NULL,'Banorte',1),(3,NULL,'HSBV',1),(4,NULL,'STF',1),(5,NULL,'CitiBank',1);
/*!40000 ALTER TABLE `catbancos_original` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `catregimenfiscal`
--

DROP TABLE IF EXISTS `catregimenfiscal`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `catregimenfiscal` (
  `rf_idRegimenFiscal` int(3) NOT NULL AUTO_INCREMENT,
  `rf_Descripcion` varchar(255) NOT NULL,
  `rf_Activo` tinyint(1) NOT NULL,
  PRIMARY KEY (`rf_idRegimenFiscal`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `catregimenfiscal`
--

LOCK TABLES `catregimenfiscal` WRITE;
/*!40000 ALTER TABLE `catregimenfiscal` DISABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contacto`
--

LOCK TABLES `contacto` WRITE;
/*!40000 ALTER TABLE `contacto` DISABLE KEYS */;
INSERT INTO `contacto` VALUES (4,_binary 'ä\Í∫*V\ÿ\Ù\ÈU0pû~N{',_binary 'º•\“60o‘ùh1.\ı<{!',_binary '\€}\ŒCÅˇ\≈Y¢ˇ\ˆ&‚â¥ùë;\›˝üLÆ;R\ÔGpè',1),(5,_binary '\n\÷\’aXzÖ\˜O6Y\Ô',_binary 'º•\“60o‘ùh1.\ı<{!',_binary '\€}\ŒCÅˇ\≈Y¢ˇ\ˆ&‚â¥ùë;\›˝üLÆ;R\ÔGpè',1),(6,_binary '\n\÷\’aXzÖ\˜O6Y\Ô',_binary 'º•\“60o‘ùh1.\ı<{!',_binary '\€}\ŒCÅˇ\≈Y¢ˇ\ˆ&‚â¥ùë;\›˝üLÆ;R\ÔGpè',1),(7,_binary 'ºg\ny± ña€Øá\ÂU∑Z',_binary 'º•\“60o‘ùh1.\ı<{!',_binary 'Jcø´º\…\Ù\Òæ˝',1),(8,_binary 'ºg\ny± ña€Øá\ÂU∑Z',_binary 'º•\“60o‘ùh1.\ı<{!',_binary 'Jcø´º\…\Ù\Òæ˝',1);
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
  `b_id_CatBanco` int(3) NOT NULL,
  `b_CLABE` varchar(30) NOT NULL,
  `b_Activo` tinyint(1) NOT NULL,
  PRIMARY KEY (`b_idCtaBancaria`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cuentabacaria`
--

LOCK TABLES `cuentabacaria` WRITE;
/*!40000 ALTER TABLE `cuentabacaria` DISABLE KEYS */;
/*!40000 ALTER TABLE `cuentabacaria` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `demo_datos`
--

DROP TABLE IF EXISTS `demo_datos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `demo_datos` (
  `id_demo` int(11) NOT NULL,
  `Valor` varchar(100) DEFAULT NULL,
  `Encriptado` blob DEFAULT NULL,
  `Llave` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `demo_datos`
--

LOCK TABLES `demo_datos` WRITE;
/*!40000 ALTER TABLE `demo_datos` DISABLE KEYS */;
INSERT INTO `demo_datos` VALUES (1,'Cadena a encriptar',_binary 'ÆrΩ?ˇ≠±^\Á\nL\0¯\…]r¥≤,)\ÿ¸WK§xu±ø','Llave');
/*!40000 ALTER TABLE `demo_datos` ENABLE KEYS */;
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
INSERT INTO `estatuscp` VALUES (1,'Alta',1),(2,'Baja',1),(3,'En aprovacion',1);
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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `persona`
--

LOCK TABLES `persona` WRITE;
/*!40000 ALTER TABLE `persona` DISABLE KEYS */;
INSERT INTO `persona` VALUES (1,_binary 'õ}\ƒ\—\Ëí\‚•j˙qP8N',_binary 'â∏\ÁCû˛íHXΩ\Û\˜I\„Ãä\Í∫*V\ÿ\Ù\ÈU0pû~N{',_binary 'w$\ÚD\‰\ÁrÄßl\⁄¯π>˛',_binary '\¬}–∫f8´KK\r\œU\—\≈',_binary 'º•\“60o‘ùh1.\ı<{!',_binary 'º•\“60o‘ùh1.\ı<{!',_binary '˘yrö#F¥≥°óDØ˙ã•',_binary 'º•\“60o‘ùh1.\ı<{!',_binary 'º•\“60o‘ùh1.\ı<{!',_binary '<*\0:?\È\’\‰c5{Ä',1),(2,_binary '«èî>3E\r≠z∏p”§',_binary 'ä\Í∫*V\ÿ\Ù\ÈU0pû~N{',_binary ';9\ÀW<øµhLÇ˚,ì\ÿL¶Ç\ÿFàØ\’%9ôP;áˇ\ÃP∫',_binary '\ŸDüL•ˇçàV\Ô%\’}è',_binary 'ºg\ny± ña€Øá\ÂU∑Z',_binary 'º•\“60o‘ùh1.\ı<{!',_binary '˘yrö#F¥≥°óDØ˙ã•',_binary 'º•\“60o‘ùh1.\ı<{!',_binary 'º•\“60o‘ùh1.\ı<{!',_binary '<*\0:?\È\’\‰c5{Ä',1),(3,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1),(4,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1),(5,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1);
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
  `rl_Nombre` blob DEFAULT NULL,
  `rl_RFC` blob DEFAULT NULL,
  `rl_idPersona` blob DEFAULT NULL,
  `rl_Activo` tinyint(1) NOT NULL,
  PRIMARY KEY (`rl_idRepresentante`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `representantelegal`
--

LOCK TABLES `representantelegal` WRITE;
/*!40000 ALTER TABLE `representantelegal` DISABLE KEYS */;
INSERT INTO `representantelegal` VALUES (1,_binary '9c¿@X\–-ù\Ô\ \ƒL˝ì',_binary '\“nº?˙a\Á|¿∂ü\Ë',_binary 'º•\“60o‘ùh1.\ı<{!',1);
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
  `u_idPerfil` blob DEFAULT NULL,
  `u_imagenUsuario` blob DEFAULT NULL,
  `u_Activo` tinyint(1) NOT NULL,
  PRIMARY KEY (`u_idUsuario`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuario`
--

LOCK TABLES `usuario` WRITE;
/*!40000 ALTER TABLE `usuario` DISABLE KEYS */;
INSERT INTO `usuario` VALUES (1,_binary 'º•\“60o‘ùh1.\ı<{!',_binary '2\„<+\„[¢≥g•¶l ',_binary 'º•\“60o‘ùh1.\ı<{!',_binary 'ì\nHXpåPXèP$\Ú“õ°~\”?õ\€;Œêz~õ˙¥;\r',1),(4,_binary 'º•\“60o‘ùh1.\ı<{!',_binary '\Ùá\‰jP´ºL-Õü_¢çx?',_binary 'º•\“60o‘ùh1.\ı<{!',_binary 'ì\nHXpåPXèP$\Ú“õ°~\”?õ\€;Œêz~õ˙¥;\r',1);
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
DELIMITER ;;
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
END ;;
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
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` FUNCTION `AgregaPersona`(entrada blob,
llave varchar(100)) RETURNS blob
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
  select count(per_RFC) into resultado from compensapay.persona p where aes_decrypt(per_RFC,llave) = rfc and per_Activo = 1;								
  RETURN resultado;
END ;;
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
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` FUNCTION `AgregaRepresentante`(entrada blob,
llave varchar(100)) RETURNS blob
begin
  declare resultado blob;

declare nombre varchar(30);

set
nombre = JSON_UNQUOTE(json_extract(entrada,
'$.NombreRepresentante'));

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
end ;;
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
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` FUNCTION `AgregarOperacion`(entrada blob,
llave varchar(100)) RETURNS blob
begin
  declare resultado blob;

declare nombre varchar(30);

set
nombre = JSON_UNQUOTE(json_extract(entrada,
'$.NombreRepresentante'));

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
end ;;
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
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` FUNCTION `AgregaUsuario`(entrada blob,
llave varchar(100)) RETURNS blob
begin
  declare resultado blob;
  declare nomuser varchar(30);

set nomuser = JSON_UNQUOTE(json_extract(entrada,'$.NombreUsuario'));
 insert into compensapay.usuario (u_NombreUsuario,
 									u_idPersona,
 									u_idPerfil,
 									u_imagenUsuario,
 									u_Activo) values
 									(aes_encrypt(nomuser,llave),
 									aes_encrypt(JSON_UNQUOTE(json_extract(entrada,'$.idPersona')),llave),
 									aes_encrypt(JSON_UNQUOTE(json_extract (entrada,'$.idPerfil')),llave),
 									aes_encrypt(JSON_UNQUOTE(json_extract (entrada,'$.urlImagen')),llave),
 									1
 									);
  select count(u_NombreUsuario) into resultado from compensapay.usuario where aes_decrypt(u_NombreUsuario,llave) = nomuser and u_Activo = 1;								
  RETURN resultado;
END ;;
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
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` FUNCTION `ExisteRFC`(entrada VARCHAR(20),
llave varchar(100)) RETURNS blob
begin
  declare salida blob;

select
	JSON_OBJECT ('RFC',
	aes_decrypt(per_RFC,llave),
	'Nombre',
	aes_decrypt(per_Nombre,llave),
	'alias',
	aes_decrypt (per_Alias,llave))
into
	salida
from
	persona
where
	aes_decrypt (per_RFC,llave) = entrada;

return salida;
end ;;
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
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` FUNCTION `ExisteUsuario`(entrada VARCHAR(50),llave varchar(100)) RETURNS int(1)
BEGIN
  DECLARE salida int;
 	select count(u_NombreUsuario) into salida from usuario where aes_decrypt(u_NombreUsuario,llave) = entrada;
  RETURN salida;
END ;;
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
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` FUNCTION `VerBanco`(entrada VARCHAR(4)) RETURNS varchar(100) CHARSET utf8mb4 COLLATE utf8mb4_general_ci
begin
  declare salida varchar(100);

select
	JSON_OBJECT ('Clave',
	Clave,
	'Alias',
	Alias  
	)
into
	salida
from
	catbancos 
where
	compensapay.catbancos.Clave = entrada;

return salida;
end ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP FUNCTION IF EXISTS `VerFirma` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` FUNCTION `VerFirma`(entrada VARCHAR(20)) RETURNS int(11)
BEGIN
  DECLARE salida int;
  select count(u_NombreUsuario) into salida from usuario where usuario.u_NombreUsuario=entrada; 
  -- SET salida = 1;
  RETURN salida;
END ;;
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
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-09-14 15:06:42
