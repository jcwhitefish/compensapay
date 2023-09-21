-- MySQL dump 10.13  Distrib 5.5.62, for Win64 (AMD64)
--
-- Host: localhost    Database: compensapay
-- ------------------------------------------------------
-- Server version	5.7.40


-- Crea base de datos

DROP database IF EXISTS `compensapay`;
CREATE database `compensapay`;
use `compensapay`;

--
-- Table structure for table `acceso`
--

DROP TABLE IF EXISTS `acceso`;
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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `acceso`
--

LOCK TABLES `acceso` WRITE;
UNLOCK TABLES;

--
-- Table structure for table `catbancos`
--

DROP TABLE IF EXISTS `catbancos`;
CREATE TABLE `catbancos` (
  `id` int(4) NOT NULL,
  `Clave` varchar(3) DEFAULT NULL,
  `Alias` varchar(50) DEFAULT NULL,
  `Nombre` varchar(256) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `catbancos`
--

LOCK TABLES `catbancos` WRITE;
INSERT INTO `catbancos` VALUES (1,'002','BANAMEX',' Banco Nacional de México, S.A., Institución de Banca Múltiple, Grupo Financiero Banamex '),(2,'006','BANCOMEXT',' Banco Nacional de Comercio Exterior, Sociedad Nacional de Crédito, Institución de Banca de Desarrollo '),(3,'009','BANOBRAS',' Banco Nacional de Obras y Servicios Públicos, Sociedad Nacional de Crédito, Institución de Banca de Desarrollo '),(4,'012','BBVA BANCOMER',' BBVA Bancomer, S.A., Institución de Banca Múltiple, Grupo Financiero BBVA Bancomer '),(5,'014','SANTANDER',' Banco Santander (México), S.A., Institución de Banca Múltiple, Grupo Financiero Santander '),(6,'019','BANJERCITO',' Banco Nacional del Ejército, Fuerza Aérea y Armada, Sociedad Nacional de Crédito, Institución de Banca de Desarrollo '),(7,'021','HSBC',' HSBC México, S.A., institución De Banca Múltiple, Grupo Financiero HSBC '),(8,'030','BAJIO',' Banco del Bajío, S.A., Institución de Banca Múltiple '),(9,'032','IXE',' IXE Banco, S.A., Institución de Banca Múltiple, IXE Grupo Financiero '),(10,'036','INBURSA','Banco Inbursa, S.A., Institución de Banca Múltiple, Grupo Financiero Inbursa '),(11,'037','INTERACCIONES',' Banco Interacciones, S.A., Institución de Banca Múltiple '),(12,'042','MIFEL',' Banca Mifel, S.A., Institución de Banca Múltiple, Grupo Financiero Mifel '),(13,'044','SCOTIABANK',' Scotiabank Inverlat, S.A. '),(14,'058','BANREGIO',' Banco Regional de Monterrey, S.A., Institución de Banca Múltiple, Banregio Grupo Financiero '),(15,'059','INVEX',' Banco Invex, S.A., Institución de Banca Múltiple, Invex Grupo Financiero '),(16,'060','BANSI',' Bansi, S.A., Institución de Banca Múltiple '),(17,'062','AFIRME',' Banca Afirme, S.A., Institución de Banca Múltiple '),(18,'072','BANORTE',' Banco Mercantil del Norte, S.A., Institución de Banca Múltiple, Grupo Financiero Banorte '),(19,'102','THE ROYAL BANK',' The Royal Bank of Scotland México, S.A., Institución de Banca Múltiple '),(20,'103','AMERICAN EXPRESS','American Express Bank (México), S.A., Institución de Banca Múltiple'),(21,'106','BAMSA',' Bank of America México, S.A., Institución de Banca Múltiple, Grupo Financiero Bank of America '),(22,'108','TOKYO','Bank of Tokyo-Mitsubishi UFJ '),(23,'110','JP MORGAN',' Banco J.P. Morgan, S.A., Institución de Banca Múltiple, J.P. Morgan Grupo Financiero '),(24,'112','BMONEX',' Banco Monex, S.A., Institución de Banca Múltiple '),(25,'113','VE POR MAS',' Banco Ve Por Mas, S.A. Institución de Banca Múltiple '),(26,'116','ING',' ING Bank (México), S.A., Institución de Banca Múltiple, ING Grupo Financiero'),(27,'124','DEUTSCHE',' Deutsche Bank México, S.A., Institución de Banca Múltiple '),(28,'126','CREDIT SUISSE','Banco Credit Suisse (México), S.A. Institución de Banca Múltiple, Grupo Financiero Credit Suisse (México) '),(29,'127','AZTECA',' Banco Azteca, S.A. Institución de Banca Múltiple. '),(30,'128','AUTOFIN',' Banco Autofin México, S.A. Institución de Banca Múltiple'),(31,'129','BARCLAYS','Barclays Bank México, S.A., Institución de Banca Múltiple, Grupo Financiero Barclays México.'),(32,'130','COMPARTAMOS',' Banco Compartamos, S.A., Institución de Banca Múltiple '),(33,'131','BANCO FAMSA',' Banco Ahorro Famsa, S.A., Institución de Banca Múltiple '),(34,'132','BMULTIVA','Banco Multiva, S.A., Institución de Banca Múltiple, Multivalores Grupo Financiero '),(35,'133','ACTINVER','Banco Actinver, S.A. Institución de Banca Múltiple, Grupo Financiero Actinver '),(36,'134','WAL-MART','Banco Wal-Mart de México Adelante, S.A., Institución de Banca Múltiple '),(37,'135','NAFIN','Nacional Financiera, Sociedad Nacional de Crédito, Institución de Banca de Desarrollo '),(38,'136','INTERBANCO','Inter Banco, S.A. Institución de Banca Múltiple '),(39,'137','BANCOPPEL','BanCoppel, S.A., Institución de Banca Múltiple '),(40,'138','ABC CAPITAL','ABC Capital, S.A., Institución de Banca Múltiple '),(41,'139','UBS BANK','UBS Bank México, S.A., Institución de Banca Múltiple, UBS Grupo Financiero '),(42,'140','CONSUBANCO','Consubanco, S.A. Institución de Banca Múltiple '),(43,'141','VOLKSWAGEN','Volkswagen Bank, S.A., Institución de Banca Múltiple '),(44,'143','CIBANCO','CIBanco, S.A. '),(45,'145','BBASE','Banco Base, S.A., Institución de Banca Múltiple '),(46,'166','BANSEFI','Banco del Ahorro Nacional y Servicios Financieros, Sociedad Nacional de Crédito, Institución de Banca de Desarrollo '),(47,'168','HIPOTECARIA FEDERAL','Sociedad Hipotecaria Federal, Sociedad Nacional de Crédito, Institución de Banca de Desarrollo '),(48,'600','MONEXCB','Monex Casa de Bolsa, S.A. de C.V. Monex Grupo Financiero '),(49,'601','GBM','GBM Grupo Bursátil Mexicano, S.A. de C.V. Casa de Bolsa '),(50,'602','MASARI','Masari Casa de Bolsa, S.A. '),(51,'605','VALUE','Value, S.A. de C.V. Casa de Bolsa '),(52,'606','ESTRUCTURADORES','Estructuradores del Mercado de Valores Casa de Bolsa, S.A. de C.V. '),(53,'607','TIBER','Casa de Cambio Tiber, S.A. de C.V. '),(54,'608','VECTOR','Vector Casa de Bolsa, S.A. de C.V. '),(55,'610','B&B','B y B, Casa de Cambio, S.A. de C.V. '),(56,'614','ACCIVAL','Acciones y Valores Banamex, S.A. de C.V., '),(57,'615','MERRILL LYNCH','Merrill Lynch México, S.A. de C.V. Casa de Bolsa '),(58,'616','FINAMEX','Casa de Bolsa Finamex, S.A. de C.V. '),(59,'617','VALMEX','Valores Mexicanos Casa de Bolsa, S.A. de C.V. '),(60,'618','UNICA','Unica Casa de Cambio, S.A. de C.V. '),(61,'619','MAPFRE','MAPFRE Tepeyac, S.A. '),(62,'620','PROFUTURO','Profuturo G.N.P., S.A. de C.V., Afore '),(63,'621','CB ACTINVER','Actinver Casa de Bolsa, S.A. de C.V. '),(64,'622','OACTIN','OPERADORA ACTINVER, S.A. DE C.V. '),(65,'623','SKANDIA','Skandia Vida, S.A. de C.V. '),(66,'626','CBDEUTSCHE','Deutsche Securities, S.A. de C.V. CASA DE BOLSA '),(67,'627','ZURICH','Zurich Compañía de Seguros, S.A. '),(68,'628','ZURICHVI','Zurich Vida, Compañía de Seguros, S.A. '),(69,'629','SU CASITA','Hipotecaria Su Casita, S.A. de C.V. SOFOM ENR '),(70,'630','CB INTERCAM','Intercam Casa de Bolsa, S.A. de C.V. '),(71,'631','CI BOLSA','CI Casa de Bolsa, S.A. de C.V. '),(72,'632','BULLTICK CB','Bulltick Casa de Bolsa, S.A., de C.V. '),(73,'633','STERLING','Sterling Casa de Cambio, S.A. de C.V. '),(74,'634','FINCOMUN','Fincomún, Servicios Financieros Comunitarios, S.A. de C.V. '),(75,'636','HDI SEGUROS','HDI Seguros, S.A. de C.V. '),(76,'637','ORDER','Order Express Casa de Cambio, S.A. de C.V '),(77,'638','AKALA','Akala, S.A. de C.V., Sociedad Financiera Popular '),(78,'640','CB  JPMORGAN','J.P. Morgan Casa de Bolsa, S.A. de C.V. J.P. Morgan Grupo Financiero '),(79,'642','REFORMA','Operadora de Recursos Reforma, S.A. de C.V., S.F.P. '),(80,'646','STP','Sistema de Transferencias y Pagos STP, S.A. de C.V.SOFOM ENR '),(81,'647','TELECOMM','Telecomunicaciones de México '),(82,'648','EVERCORE','Evercore Casa de Bolsa, S.A. de C.V. '),(83,'649','SKANDIA','Skandia Operadora de Fondos, S.A. de C.V. '),(84,'651','SEGMTY','Seguros Monterrey New York Life, S.A de C.V '),(85,'652','ASEA','Solución Asea, S.A. de C.V., Sociedad Financiera Popular '),(86,'653','KUSPIT','Kuspit Casa de Bolsa, S.A. de C.V. '),(87,'655','SOFIEXPRESS','J.P. SOFIEXPRESS, S.A. de C.V., S.F.P. '),(88,'656','UNAGRA','UNAGRA, S.A. de C.V., S.F.P. '),(89,'659','OPCIONES EMPRESARIALES DEL NOROESTE','OPCIONES EMPRESARIALES DEL NORESTE, S.A. DE C.V., S.F.P. '),(90,'670','LIBERTAD','Cls Bank International '),(91,'901','CLS','SD. Indeval, S.A. de C.V. '),(92,'902','INDEVAL','Libertad Servicios Financieros, S.A. De C.V. '),(93,'999','N/A','');
UNLOCK TABLES;

--
-- Table structure for table `catpreguntas`
--

DROP TABLE IF EXISTS `catpreguntas`;
CREATE TABLE `catpreguntas` (
  `pg_idpregunta` int(3) NOT NULL AUTO_INCREMENT,
  `pg_pregunta` varchar(255) NOT NULL,
  `pg_activo` int(1) NOT NULL,
  PRIMARY KEY (`pg_idpregunta`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `catpreguntas`
--

LOCK TABLES `catpreguntas` WRITE;
INSERT INTO `catpreguntas` VALUES (1,'¿Cuál es tu película favorita?',1),(2,'¿Nombre de tu primera mascota?',1),(3,'¿Segundo apellido de tu mamá?',1);
UNLOCK TABLES;

--
-- Table structure for table `catregimenfiscal`
--

DROP TABLE IF EXISTS `catregimenfiscal`;
CREATE TABLE `catregimenfiscal` (
  `rg_id_regimen` int(11) DEFAULT NULL,
  `rg_Clave` int(11) DEFAULT NULL,
  `rg_Regimen` varchar(128) DEFAULT NULL,
  `rg_P_Fisica` int(11) DEFAULT NULL,
  `rg_P_Moral` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
--
-- Dumping data for table `catregimenfiscal`
--

LOCK TABLES `catregimenfiscal` WRITE;
INSERT INTO `catregimenfiscal` VALUES (1,601,'General de Ley Personas Morales',0,1),(2,603,'Personas Morales con Fines no Lucrativos',0,1),(3,605,'Sueldos y Salarios e Ingresos Asimilados a Salarios',1,0),(4,606,'Arrendamiento',1,0),(5,607,'Régimen de Enajenación o Adquisición de Bienes',1,0),(6,608,'Demás ingresos',1,0),(7,610,'Residentes en el Extranjero sin Establecimiento Permanente en México',1,1),(8,611,'Ingresos por Dividendos (socios y accionistas)',1,0),(9,612,'Personas Físicas con Actividades Empresariales y Profesionales',1,0),(10,614,'Ingresos por intereses',1,0),(11,615,'Régimen de los ingresos por obtención de premios',1,0),(12,616,'Sin obligaciones fiscales',1,0),(13,620,'Sociedades Cooperativas de Producción que optan por diferir sus ingresos',0,1),(14,621,'Incorporación Fiscal',1,0),(15,622,'Actividades Agrícolas, Ganaderas, Silvícolas y Pesqueras',0,1),(16,623,'Opcional para Grupos de Sociedades',0,1),(17,624,'Coordinados',0,1),(18,625,'Régimen de las Actividades Empresariales con ingresos a través de Plataformas Tecnológicas',1,0),(19,626,'Régimen Simplificado de Confianza',1,1);
UNLOCK TABLES;

--
-- Table structure for table `cattipovalor`
--

DROP TABLE IF EXISTS `cattipovalor`;
CREATE TABLE `cattipovalor` (
  `cv_idTipoValor` int(3) NOT NULL AUTO_INCREMENT,
  `cv_Descripcion` varchar(255) NOT NULL,
  `cv_Activo` tinyint(1) NOT NULL,
  PRIMARY KEY (`cv_idTipoValor`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `cattipovalor`
--

LOCK TABLES `cattipovalor` WRITE;
INSERT INTO `cattipovalor` VALUES (1,'Cadena',1),(2,'Numerico',1),(3,'Logico',1);
UNLOCK TABLES;

--
-- Table structure for table `clienteproveedor`
--

DROP TABLE IF EXISTS `clienteproveedor`;
CREATE TABLE `clienteproveedor` (
  `cp_idClienteProveedor` int(4) NOT NULL AUTO_INCREMENT,
  `cp_idPersonaCliente` int(3) NOT NULL,
  `cp_idPersonaProveedor` varchar(100) NOT NULL,
  `cp_Nota` varchar(50) NOT NULL,
  `cp_idEstatusCP` int(2) DEFAULT NULL,
  `cp_Activo` tinyint(1) NOT NULL,
  PRIMARY KEY (`cp_idClienteProveedor`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `clienteproveedor`
--

LOCK TABLES `clienteproveedor` WRITE;
UNLOCK TABLES;

--
-- Table structure for table `compensacion`
--

DROP TABLE IF EXISTS `compensacion`;
CREATE TABLE `compensacion` (
  `cm_idCompensacion` int(4) NOT NULL AUTO_INCREMENT,
  `cm_idPersonaCliente` int(3) NOT NULL,
  `cm_idPersonaProveedor` varchar(100) NOT NULL,
  `cm_idEstatusCM` varchar(50) NOT NULL,
  `cm_idOperacion` int(2) DEFAULT NULL,
  `cm_Activo` tinyint(1) NOT NULL,
  PRIMARY KEY (`cm_idCompensacion`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `compensacion`
--

LOCK TABLES `compensacion` WRITE;
UNLOCK TABLES;

--
-- Table structure for table `configuracion`
--

DROP TABLE IF EXISTS `configuracion`;
CREATE TABLE `configuracion` (
  `cnf_idConfiguracion` int(3) NOT NULL AUTO_INCREMENT,
  `cnf_idPersona` int(3) NOT NULL,
  `cnf_idElementoConfigurable` int(3) NOT NULL,
  `cnf_Valor` varchar(100) NOT NULL,
  `cnf_Activo` int(1) NOT NULL,
  PRIMARY KEY (`cnf_idConfiguracion`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `configuracion`
--

LOCK TABLES `configuracion` WRITE;
INSERT INTO `configuracion` VALUES (1,1,1,'/nombre_archivo.png',1);
UNLOCK TABLES;

--
-- Table structure for table `contacto`
--

DROP TABLE IF EXISTS `contacto`;
CREATE TABLE `contacto` (
  `c_idContacto` int(4) NOT NULL AUTO_INCREMENT,
  `c_idTipoContacto` blob NOT NULL,
  `c_idPersona` blob NOT NULL,
  `c_Descripcion` blob NOT NULL,
  `c_Activo` tinyint(1) NOT NULL,
  PRIMARY KEY (`c_idContacto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `contacto`
--

LOCK TABLES `contacto` WRITE;
UNLOCK TABLES;

--
-- Table structure for table `cuentabancaria`
--

DROP TABLE IF EXISTS `cuentabancaria`;
CREATE TABLE `cuentabancaria` (
  `b_idCtaBancaria` int(3) NOT NULL AUTO_INCREMENT,
  `b_idCatBanco` int(3) NOT NULL,
  `b_CLABE` blob NOT NULL,
  `b_Activo` tinyint(1) NOT NULL,
  PRIMARY KEY (`b_idCtaBancaria`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;

LOCK TABLES `cuentabancaria` WRITE;
UNLOCK TABLES;


--
-- Table structure for table `direccion`
--

DROP TABLE IF EXISTS `direccion`;
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `direccion`
--

LOCK TABLES `direccion` WRITE;
UNLOCK TABLES;

--
-- Table structure for table `elementoconfigurable`
--

DROP TABLE IF EXISTS `elementoconfigurable`;
CREATE TABLE `elementoconfigurable` (
  `ec_idElementoConfigurable` int(3) NOT NULL AUTO_INCREMENT,
  `ec_Descripcion` varchar(255) NOT NULL,
  `ec_idTipoValor` int(3) NOT NULL,
  `ec_Activo` tinyint(1) NOT NULL,
  PRIMARY KEY (`ec_idElementoConfigurable`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `elementoconfigurable`
--

LOCK TABLES `elementoconfigurable` WRITE;
INSERT INTO `elementoconfigurable` VALUES (1,'ImagenPerfil',1,1);
UNLOCK TABLES;

--
-- Table structure for table `estados`
--

DROP TABLE IF EXISTS `estados`;
CREATE TABLE `estados` (
  `e_IdEstado` int(11) DEFAULT NULL,
  `e_Descripcion` varchar(50) DEFAULT NULL,
  `e_alias` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `estados`
--

LOCK TABLES `estados` WRITE;
INSERT INTO `estados` VALUES (1,'Aguascalientes','Ags.'),(2,'Baja California','BC'),(3,'Baja California Sur','BCS'),(4,'Campeche','Camp.'),(5,'Coahuila de Zaragoza','Coah.'),(6,'Colima','Col.'),(7,'Chiapas','Chis.'),(8,'Chihuahua','Chih.'),(9,'Ciudad de México','CDMX'),(10,'Durango','Dgo.'),(11,'Guanajuato','Gto.'),(12,'Guerrero','Gro.'),(13,'Hidalgo','Hgo.'),(14,'Jalisco','Jal.'),(15,'México','Mex.'),(16,'Michoacán de Ocampo','Mich.'),(17,'Morelos','Mor.'),(18,'Nayarit','Nay.'),(19,'Nuevo León','NL'),(20,'Oaxaca','Oax.'),(21,'Puebla','Pue.'),(22,'Querátaro','Qro.'),(23,'Quintana Roo','Q. Roo'),(24,'San Luis Potosí','SLP'),(25,'Sinaloa','Sin.'),(26,'Sonora','Son.'),(27,'Tabasco','Tab.'),(28,'Tamaulipas','Tamps.'),(29,'Tlaxcala','Tlax.'),(30,'Veracruz de Ignacio de la Llave','Ver.'),(31,'Yucatán','Yuc.'),(32,'Zacatecas','Zac.');
UNLOCK TABLES;

--
-- Table structure for table `estatuscm`
--

DROP TABLE IF EXISTS `estatuscm`;
CREATE TABLE `estatuscm` (
  `ec_idEstatusCM` int(4) NOT NULL AUTO_INCREMENT,
  `ec_Descripcion` varchar(16) NOT NULL,
  `ec_Activo` tinyint(1) NOT NULL,
  PRIMARY KEY (`ec_idEstatusCM`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `estatuscm`
--

LOCK TABLES `estatuscm` WRITE;
INSERT INTO `estatuscm` VALUES (1,'Alta',1),(2,'Conciliada',1),(3,'Pagada',1);
UNLOCK TABLES;

--
-- Table structure for table `estatuscp`
--

DROP TABLE IF EXISTS `estatuscp`;
CREATE TABLE `estatuscp` (
  `ecp_idEstatusCP` int(4) NOT NULL AUTO_INCREMENT,
  `ecp_Descripcion` varchar(16) NOT NULL,
  `ecp_Activo` tinyint(1) NOT NULL,
  PRIMARY KEY (`ecp_idEstatusCP`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `estatuscp`
--

LOCK TABLES `estatuscp` WRITE;
INSERT INTO `estatuscp` VALUES (1,'Alta',1),(2,'Baja',1),(3,'En aprobación',1);
UNLOCK TABLES;

--
-- Table structure for table `estatuso`
--

DROP TABLE IF EXISTS `estatuso`;
CREATE TABLE `estatuso` (
  `eo_idEstatusO` int(4) NOT NULL AUTO_INCREMENT,
  `eo_Descripcion` varchar(16) NOT NULL,
  `eo_Activo` tinyint(1) NOT NULL,
  PRIMARY KEY (`eo_idEstatusO`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `estatuso`
--

LOCK TABLES `estatuso` WRITE;
INSERT INTO `estatuso` VALUES (1,'Cargada',1),(2,'Por autroizar',1),(3,'Autorizada',1),(4,'Proceso pago',1),(5,'Pagada',1);
UNLOCK TABLES;

--
-- Table structure for table `moduloperfil`
--

DROP TABLE IF EXISTS `moduloperfil`;
CREATE TABLE `moduloperfil` (
  `mp_idModuloPerfil` int(3) NOT NULL AUTO_INCREMENT,
  `mp_idModulo` tinyint(3) DEFAULT NULL,
  `mp_idPerfil` tinyint(3) DEFAULT NULL,
  `mp_Activo` tinyint(1) NOT NULL,
  PRIMARY KEY (`mp_idModuloPerfil`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `moduloperfil`
--

LOCK TABLES `moduloperfil` WRITE;
UNLOCK TABLES;

--
-- Table structure for table `modulos`
--

DROP TABLE IF EXISTS `modulos`;
CREATE TABLE `modulos` (
  `m_idModulo` tinyint(3) NOT NULL AUTO_INCREMENT,
  `m_Descripcion` varchar(30) NOT NULL,
  `m_Activo` tinyint(1) NOT NULL,
  PRIMARY KEY (`m_idModulo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `modulos`
--

LOCK TABLES `modulos` WRITE;
UNLOCK TABLES;

--
-- Table structure for table `operacion`
--

DROP TABLE IF EXISTS `operacion`;
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `operacion`
--

LOCK TABLES `operacion` WRITE;
UNLOCK TABLES;

--
-- Table structure for table `perfil`
--

DROP TABLE IF EXISTS `perfil`;
CREATE TABLE `perfil` (
  `p_idPerfil` tinyint(3) NOT NULL AUTO_INCREMENT,
  `p_Descripcion` varchar(50) NOT NULL,
  `p_Activo` tinyint(1) NOT NULL,
  PRIMARY KEY (`p_idPerfil`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `perfil`
--

LOCK TABLES `perfil` WRITE;
INSERT INTO `perfil` VALUES (1,'Administrador',1),(2,'Administrador Ex',1),(3,'Colaborador Editor',1),(4,'Colaborador Consulta',1);
UNLOCK TABLES;

--
-- Table structure for table `persona`
--

DROP TABLE IF EXISTS `persona`;
CREATE TABLE `persona` (
  `per_idPersona` int(5) NOT NULL AUTO_INCREMENT,
  `per_Nombre` blob,
  `per_Apellido` blob,
  `per_Alias` blob,
  `per_RFC` blob,
  `per_idTipoPrersona` blob,
  `per_idRol` blob,
  `per_ActivoFintec` blob,
  `per_RegimenFiscal` blob,
  `per_idCtaBanco` blob,
  `per_logo` blob,
  `per_Activo` int(1) DEFAULT NULL,
  PRIMARY KEY (`per_idPersona`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `persona`
--

LOCK TABLES `persona` WRITE;
UNLOCK TABLES;

--
-- Table structure for table `preguntapersona`
--

DROP TABLE IF EXISTS `preguntapersona`;
CREATE TABLE `preguntapersona` (
  `pp_idpreguntapersona` int(3) NOT NULL AUTO_INCREMENT,
  `pp_idpersona` int(11) DEFAULT NULL,
  `pp_idpregunta` int(3) NOT NULL,
  `pp_respuestapregunta` blob NOT NULL,
  `pp_Activo` int(1) DEFAULT NULL,
  PRIMARY KEY (`pp_idpreguntapersona`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `preguntapersona`
--

LOCK TABLES `preguntapersona` WRITE;
UNLOCK TABLES;

--
-- Table structure for table `representantelegal`
--

DROP TABLE IF EXISTS `representantelegal`;
CREATE TABLE `representantelegal` (
  `rl_idRepresentante` int(3) NOT NULL AUTO_INCREMENT,
  `rl_Nombre` blob,
  `rl_RFC` blob,
  `rl_idPersona` blob,
  `rl_Activo` tinyint(1) NOT NULL,
  PRIMARY KEY (`rl_idRepresentante`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `representantelegal`
--

LOCK TABLES `representantelegal` WRITE;
UNLOCK TABLES;

--
-- Table structure for table `rol`
--

DROP TABLE IF EXISTS `rol`;
CREATE TABLE `rol` (
  `r_idRol` tinyint(3) NOT NULL AUTO_INCREMENT,
  `r_Descripcion` varchar(50) DEFAULT NULL,
  `r_Activo` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`r_idRol`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `rol`
--

LOCK TABLES `rol` WRITE;
INSERT INTO `rol` VALUES (1,'Cliente',1),(2,'Proveedor',1);
UNLOCK TABLES;

--
-- Table structure for table `seguimiento`
--

DROP TABLE IF EXISTS `seguimiento`;
CREATE TABLE `seguimiento` (
  `s_idSeguimiento` int(4) NOT NULL AUTO_INCREMENT,
  `s_idOperacion` varchar(10) NOT NULL,
  `s_FechaSeguimiento` datetime NOT NULL,
  `s_DescripcionOperacion` varchar(255) NOT NULL,
  `s_idEstatusO` float DEFAULT NULL,
  `s_UsuarioActualizo` int(3) NOT NULL,
  `s_Activo` tinyint(1) NOT NULL,
  PRIMARY KEY (`s_idSeguimiento`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `seguimiento`
--

LOCK TABLES `seguimiento` WRITE;
UNLOCK TABLES;

--
-- Table structure for table `tipocontacto`
--

DROP TABLE IF EXISTS `tipocontacto`;
CREATE TABLE `tipocontacto` (
  `tc_idTipoContacto` int(4) NOT NULL AUTO_INCREMENT,
  `tc_Descripcion` varchar(30) NOT NULL,
  `tc_Activo` tinyint(1) NOT NULL,
  PRIMARY KEY (`tc_idTipoContacto`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tipocontacto`
--

LOCK TABLES `tipocontacto` WRITE;
INSERT INTO `tipocontacto` VALUES (1,'Fijo',1),(2,'Movil',1),(3,'eMail',1);
UNLOCK TABLES;

--
-- Table structure for table `tipodocumento`
--

DROP TABLE IF EXISTS `tipodocumento`;
CREATE TABLE `tipodocumento` (
  `td_idTipoDocumento` int(4) NOT NULL AUTO_INCREMENT,
  `td_Descripcion` varchar(16) NOT NULL,
  `td_Activo` tinyint(1) NOT NULL,
  PRIMARY KEY (`td_idTipoDocumento`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tipodocumento`
--

LOCK TABLES `tipodocumento` WRITE;
INSERT INTO `tipodocumento` VALUES (1,'Factura',1),(2,'Comp Egreso',1);
UNLOCK TABLES;

--
-- Table structure for table `tipopersona`
--

DROP TABLE IF EXISTS `tipopersona`;
CREATE TABLE `tipopersona` (
  `tp_idTipoPersona` tinyint(3) NOT NULL AUTO_INCREMENT,
  `tp_Descripcion` varchar(50) DEFAULT NULL,
  `tp_Activo` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`tp_idTipoPersona`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tipopersona`
--

LOCK TABLES `tipopersona` WRITE;
INSERT INTO `tipopersona` VALUES (1,'Fisica',1),(2,'Moral',1);
UNLOCK TABLES;

--
-- Table structure for table `usuario`
--

DROP TABLE IF EXISTS `usuario`;
CREATE TABLE `usuario` (
  `u_idUsuario` int(4) NOT NULL AUTO_INCREMENT,
  `u_idPersona` blob,
  `u_NombreUsuario` blob,
  `u_Nombre` blob,
  `u_Apellidos` blob,
  `u_Llaveacceso` blob,
  `u_idPerfil` blob,
  `u_imagenUsuario` blob,
  `u_Activo` tinyint(1) NOT NULL,
  PRIMARY KEY (`u_idUsuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `usuario`
--

LOCK TABLES `usuario` WRITE;
UNLOCK TABLES;

--
-- Temporary table structure for view `vistapersonausuario`
--

DROP TABLE IF EXISTS `vistapersonausuario`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping events for database 'compensapay'
--

--
-- Dumping routines for database 'compensapay'
--

-- AgregaContacto

DELIMITER ;;
CREATE DEFINER=`root`@`localhost` FUNCTION `AgregaContacto`(entrada text,

llave varchar(100)) RETURNS text CHARSET latin1
begin

  	declare resultado text;

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

-- AgregaCtaBancaria

DELIMITER ;;
CREATE DEFINER=`root`@`localhost` FUNCTION `AgregaCtaBancaria`(entrada text,llave varchar(100)) RETURNS text CHARSET latin1
begin

  	declare resultado text;

  	declare idPersona int(3);

  	declare idBanco int(3);

  	declare contenido varchar(50);

  	declare idcuenta int(3);

    declare existe int (3);

	set idPersona = JSON_UNQUOTE(json_extract(entrada,'$.idPersona'));

	set idBanco = JSON_UNQUOTE(json_extract(entrada,'$.idBanco'));

	set contenido = JSON_UNQUOTE(json_extract(entrada,'$.CLABE'));

select c.b_idCtaBancaria into existe

from compensapay.cuentabancaria c 

where aes_decrypt (b_CLABE,llave)=contenido;

if existe then

	set resultado = 0;

else 

	insert into compensapay.cuentabancaria (

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

from compensapay.cuentabancaria c 

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



END ;;
DELIMITER ;

-- AgregaDireccion
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` FUNCTION `AgregaDireccion`(entrada text) RETURNS text CHARSET latin1
begin

  	declare resultado text;

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



END ;;
DELIMITER ;

-- AgregaPersona
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` FUNCTION `AgregaPersona`(entrada text, llave varchar(100)) RETURNS text CHARSET latin1
begin

  	declare resultado text;

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



END ;;
DELIMITER ;

-- AgregaPregunta
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` FUNCTION `AgregaPregunta`(entrada text, llave varchar(100)) RETURNS text CHARSET latin1
begin

  	declare resultado text;

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

END ;;
DELIMITER ;

-- AgregaRepresentante
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` FUNCTION `AgregaRepresentante`(entrada text, llave varchar(100)) RETURNS text CHARSET latin1
begin

  	declare resultado text;

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



end ;;
DELIMITER ;

-- AgregarOperacion
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` FUNCTION `AgregarOperacion`(entrada text, llave varchar(100)) RETURNS text CHARSET latin1
begin

	declare resultado text;

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



end ;;
DELIMITER ;

-- AgregaUsuario
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` FUNCTION `AgregaUsuario`(entrada text,llave varchar(100)) RETURNS text CHARSET latin1
begin

  declare resultado text;

  declare nomuser varchar(30);

set nomuser = JSON_UNQUOTE(json_extract(entrada,'$.NombreUsuario'));

 insert into compensapay.usuario (u_NombreUsuario,
 									u_Nombre ,
 									u_Apellidos ,

 								--	u_Llaveacceso,

 									u_idPersona,

 									u_idPerfil,

 									u_imagenUsuario,

 									u_Activo) values

 									(aes_encrypt(nomuser,llave),
 									aes_encrypt (MD5(JSON_UNQUOTE(json_extract(entrada,'$.Nombre'))),llave),
 									aes_encrypt (MD5(JSON_UNQUOTE(json_extract(entrada,'$.Apellido'))),llave),

 							--		aes_encrypt (MD5(JSON_UNQUOTE(json_extract(entrada,'$.LlaveAcceso'))),llave),

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

END ;;
DELIMITER ;

-- ConsultaEmpresa
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` FUNCTION `ConsultaEmpresa`(entrada text, llave varchar(100)) RETURNS text CHARSET latin1
begin

	declare resultado text;

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

inner join cuentabancaria c on

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



END ;;
DELIMITER ;

-- ConsultaPersona
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` FUNCTION `ConsultaPersona`(entrada int,llave varchar(100)) RETURNS text CHARSET latin1
begin



	declare salida text;

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

			'nombre_usuario', aes_decrypt(u.u_NombreUsuario, llave),

			'nombre_representante', aes_decrypt(r.rl_Nombre,llave),
			'nombre_usuario',aes_decrypt(u.u_Nombre ,llave),
			'apellido_usuario',aes_decrypt(u.u_Apellidos,llave),

			'id_usuario', u.u_idUsuario) 

	  SEPARATOR ',')

    ,']')

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

inner join cuentabancaria c on

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



END ;;
DELIMITER ;


-- ConsultarEstadosMX
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` FUNCTION `ConsutlarEstadosMX`() RETURNS text CHARSET latin1
begin

  declare salida text;

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

end ;;
DELIMITER ;

-- ExisteRFC
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` FUNCTION `ExisteRFC`(entrada VARCHAR(20),llave varchar(100)) RETURNS text CHARSET latin1
begin



  declare salida text;

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



end ;;
DELIMITER ;

-- ExisteUsuario
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` FUNCTION `ExisteUsuario`(entrada VARCHAR(50),llave varchar(100)) RETURNS int(1)
BEGIN

  DECLARE salida int;

 	select count(u_NombreUsuario) 

	into salida 

	from usuario 

	where aes_decrypt(u_NombreUsuario,llave) = entrada;

  RETURN salida;

END ;;
DELIMITER ;

-- UpdateLlaveUsuario
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` FUNCTION `UpdateLlaveUsuario`(entrada text, llave varchar(100)) RETURNS text CHARSET latin1
begin

	declare resultado text;

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



END ;;
DELIMITER ;

-- ValidarLlave
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` FUNCTION `ValidarLlave`(entrada text,llave varchar(100)) RETURNS text CHARSET latin1
begin

  declare resultado text;

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



end ;;
DELIMITER ;

/*!50003 DROP FUNCTION IF EXISTS `VerBanco` */;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` FUNCTION `VerBanco`(entrada VARCHAR(4)) RETURNS varchar(100) CHARSET utf8mb4
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



end ;;
DELIMITER ;
/*!50003 DROP FUNCTION IF EXISTS `VerCatPreguntas` */;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` FUNCTION `VerCatPreguntas`() RETURNS text CHARSET latin1
begin

	declare salida text;

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



END ;;
DELIMITER ;
/*!50003 DROP FUNCTION IF EXISTS `VerRegimenFiscal` */;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` FUNCTION `VerRegimenFiscal`(tipopersona int) RETURNS text CHARSET latin1
begin

	declare salida text;

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



end ;;
DELIMITER ;
--
-- Final view structure for view `vistapersonausuario`
--
-- Dump completed on 2023-09-21  9:07:23
