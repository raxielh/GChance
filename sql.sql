/*
SQLyog Ultimate v11.33 (64 bit)
MySQL - 5.6.37 : Database - GChance
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`GChance` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `GChance`;

/*Table structure for table `acceso` */

DROP TABLE IF EXISTS `acceso`;

CREATE TABLE `acceso` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(90) CHARACTER SET latin1 NOT NULL,
  `usuario` varchar(90) CHARACTER SET latin1 NOT NULL,
  `pass` varchar(90) CHARACTER SET latin1 NOT NULL,
  `telefono` varchar(90) CHARACTER SET latin1 DEFAULT NULL,
  `rol` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `usuario` (`usuario`),
  KEY `Fk_rol` (`rol`),
  CONSTRAINT `Fk_rol` FOREIGN KEY (`rol`) REFERENCES `rol` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

/*Data for the table `acceso` */

LOCK TABLES `acceso` WRITE;

insert  into `acceso`(`id`,`nombre`,`usuario`,`pass`,`telefono`,`rol`) values (1,'administrador','admin','40bd001563085fc35165329ea1ff5c5ecbdbbeef','7898',2),(9,'Rodrigo','digitador','0e9ca2d77fe5c3556d9f94123d7e38812c4612f5','456',1);

UNLOCK TABLES;

/*Table structure for table `agencias` */

DROP TABLE IF EXISTS `agencias`;

CREATE TABLE `agencias` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `codigo` smallint(4) unsigned zerofill NOT NULL,
  `nombre` varchar(90) CHARACTER SET latin1 NOT NULL,
  `valor` varchar(90) CHARACTER SET latin1 NOT NULL,
  `municipio` varchar(90) CHARACTER SET latin1 NOT NULL,
  `usuario` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `codigo` (`codigo`),
  KEY `fk_usuario_agencias` (`usuario`),
  CONSTRAINT `fk_usuario_agencias` FOREIGN KEY (`usuario`) REFERENCES `acceso` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

/*Data for the table `agencias` */

LOCK TABLES `agencias` WRITE;

insert  into `agencias`(`id`,`codigo`,`nombre`,`valor`,`municipio`,`usuario`) values (10,0741,'Montelibano','450','Montelibano',1),(11,0745,'Monteria','400','Monteria',1);

UNLOCK TABLES;

/*Table structure for table `ganadores` */

DROP TABLE IF EXISTS `ganadores`;

CREATE TABLE `ganadores` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `loteria` int(11) NOT NULL,
  `numero` varchar(90) CHARACTER SET latin1 NOT NULL,
  `fecha` date NOT NULL,
  `usuario` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `union_fecha_loteria_numero` (`loteria`,`fecha`),
  KEY `fk_usur` (`usuario`),
  CONSTRAINT `fk_loteria` FOREIGN KEY (`loteria`) REFERENCES `loterias` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_usur` FOREIGN KEY (`usuario`) REFERENCES `acceso` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

/*Data for the table `ganadores` */

LOCK TABLES `ganadores` WRITE;

insert  into `ganadores`(`id`,`loteria`,`numero`,`fecha`,`usuario`) values (8,18,'5746','2018-02-04',1),(9,17,'5123','2018-02-04',1),(10,16,'4528','2018-02-04',1),(11,14,'7412','2018-02-04',1),(12,15,'8521','2018-02-04',1),(13,17,'7412','2018-02-06',1);

UNLOCK TABLES;

/*Table structure for table `loterias` */

DROP TABLE IF EXISTS `loterias`;

CREATE TABLE `loterias` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `codigo` varchar(90) CHARACTER SET latin1 NOT NULL,
  `nombre` varchar(90) CHARACTER SET latin1 NOT NULL,
  `usuario` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `codigo` (`codigo`),
  UNIQUE KEY `nombre` (`nombre`),
  KEY `fk_user` (`usuario`),
  CONSTRAINT `fk_user` FOREIGN KEY (`usuario`) REFERENCES `acceso` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;

/*Data for the table `loterias` */

LOCK TABLES `loterias` WRITE;

insert  into `loterias`(`id`,`codigo`,`nombre`,`usuario`) values (13,'001','Bogota',1),(14,'002','Boyaca',1),(15,'003','Cordoba',1),(16,'004','Medellin',1),(17,'005','Cundimarca',1),(18,'006','Risaralda',1);

UNLOCK TABLES;

/*Table structure for table `rol` */

DROP TABLE IF EXISTS `rol`;

CREATE TABLE `rol` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(90) CHARACTER SET latin1 NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nombre` (`nombre`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Data for the table `rol` */

LOCK TABLES `rol` WRITE;

insert  into `rol`(`id`,`nombre`) values (2,'Administrador'),(1,'Digitador');

UNLOCK TABLES;

/*Table structure for table `tiquetes` */

DROP TABLE IF EXISTS `tiquetes`;

CREATE TABLE `tiquetes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `agencia` int(11) NOT NULL,
  `numero` varchar(90) CHARACTER SET latin1 NOT NULL,
  `valor` varchar(90) CHARACTER SET latin1 NOT NULL,
  `fecha` date NOT NULL,
  `usuario` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_usu` (`usuario`),
  KEY `fk_agencia` (`agencia`),
  CONSTRAINT `fk_agencia` FOREIGN KEY (`agencia`) REFERENCES `agencias` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_usu` FOREIGN KEY (`usuario`) REFERENCES `acceso` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

/*Data for the table `tiquetes` */

LOCK TABLES `tiquetes` WRITE;

insert  into `tiquetes`(`id`,`agencia`,`numero`,`valor`,`fecha`,`usuario`) values (13,10,'5791','1000','2018-02-04',1),(14,11,'8546','2000','2018-02-04',1);

UNLOCK TABLES;

/*Table structure for table `tiquetes_as_loterias` */

DROP TABLE IF EXISTS `tiquetes_as_loterias`;

CREATE TABLE `tiquetes_as_loterias` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `loterias` int(11) DEFAULT NULL,
  `tiquetes` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `union` (`loterias`,`tiquetes`),
  KEY `fk_tiquetes` (`tiquetes`),
  CONSTRAINT `fk_loterias` FOREIGN KEY (`loterias`) REFERENCES `loterias` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_tiquetes` FOREIGN KEY (`tiquetes`) REFERENCES `tiquetes` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

/*Data for the table `tiquetes_as_loterias` */

LOCK TABLES `tiquetes_as_loterias` WRITE;

insert  into `tiquetes_as_loterias`(`id`,`loterias`,`tiquetes`) values (4,13,14),(3,15,14),(2,16,14),(1,18,13);

UNLOCK TABLES;

/*Table structure for table `tope` */

DROP TABLE IF EXISTS `tope`;

CREATE TABLE `tope` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fecha` date NOT NULL,
  `tope` varchar(90) NOT NULL,
  `usuario` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `fecha_tope` (`fecha`),
  KEY `fk_use` (`usuario`),
  CONSTRAINT `fk_use` FOREIGN KEY (`usuario`) REFERENCES `acceso` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Data for the table `tope` */

LOCK TABLES `tope` WRITE;

insert  into `tope`(`id`,`fecha`,`tope`,`usuario`) values (1,'2018-02-04','1000',1);

UNLOCK TABLES;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
