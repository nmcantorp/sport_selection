/*
Navicat MySQL Data Transfer

Source Server         : Local
Source Server Version : 50617
Source Host           : localhost:3306
Source Database       : bc_deportes

Target Server Type    : MYSQL
Target Server Version : 50617
File Encoding         : 65001

Date: 2015-11-17 16:42:10
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for decision
-- ----------------------------
DROP TABLE IF EXISTS `decision`;
CREATE TABLE `decision` (
  `id_dec` int(11) NOT NULL AUTO_INCREMENT,
  `id_resp` int(11) NOT NULL,
  `id_dep` int(11) NOT NULL,
  `pregunta_id_preg` int(3) NOT NULL,
  PRIMARY KEY (`id_dec`,`id_resp`,`id_dep`,`pregunta_id_preg`),
  KEY `fk_respuesta_has_deporte_deporte1_idx` (`id_dep`),
  KEY `fk_respuesta_has_deporte_respuesta1_idx` (`id_resp`),
  KEY `fk_decision_pregunta1_idx` (`pregunta_id_preg`),
  CONSTRAINT `fk_respuesta_has_deporte_deporte1` FOREIGN KEY (`id_dep`) REFERENCES `deporte` (`id_dep`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_respuesta_has_deporte_respuesta1` FOREIGN KEY (`id_resp`) REFERENCES `respuesta` (`id_resp`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_decision_pregunta1` FOREIGN KEY (`pregunta_id_preg`) REFERENCES `pregunta` (`id_preg`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of decision
-- ----------------------------
INSERT INTO `decision` VALUES ('1', '1', '1', '1');
INSERT INTO `decision` VALUES ('2', '1', '1', '2');
INSERT INTO `decision` VALUES ('3', '3', '1', '3');
INSERT INTO `decision` VALUES ('4', '1', '2', '1');
INSERT INTO `decision` VALUES ('5', '1', '2', '2');
INSERT INTO `decision` VALUES ('6', '4', '2', '3');
INSERT INTO `decision` VALUES ('7', '1', '3', '1');
INSERT INTO `decision` VALUES ('8', '1', '3', '2');
INSERT INTO `decision` VALUES ('9', '5', '3', '3');
INSERT INTO `decision` VALUES ('10', '1', '4', '1');
INSERT INTO `decision` VALUES ('11', '2', '4', '2');
INSERT INTO `decision` VALUES ('12', '6', '4', '4');
INSERT INTO `decision` VALUES ('13', '1', '5', '1');
INSERT INTO `decision` VALUES ('14', '2', '5', '2');
INSERT INTO `decision` VALUES ('15', '7', '5', '4');
INSERT INTO `decision` VALUES ('16', '2', '6', '1');
INSERT INTO `decision` VALUES ('17', '8', '6', '5');
INSERT INTO `decision` VALUES ('18', '1', '6', '6');
INSERT INTO `decision` VALUES ('19', '2', '7', '1');
INSERT INTO `decision` VALUES ('20', '9', '7', '5');
INSERT INTO `decision` VALUES ('21', '1', '7', '7');
INSERT INTO `decision` VALUES ('22', '2', '8', '1');
INSERT INTO `decision` VALUES ('23', '9', '8', '5');
INSERT INTO `decision` VALUES ('24', '2', '8', '7');

-- ----------------------------
-- Table structure for deporte
-- ----------------------------
DROP TABLE IF EXISTS `deporte`;
CREATE TABLE `deporte` (
  `id_dep` int(11) NOT NULL AUTO_INCREMENT,
  `nom_dep` varchar(255) NOT NULL,
  `imag_dep` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id_dep`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of deporte
-- ----------------------------
INSERT INTO `deporte` VALUES ('1', 'Baloncesto', null);
INSERT INTO `deporte` VALUES ('2', 'Futbol', null);
INSERT INTO `deporte` VALUES ('3', 'Rugby', null);
INSERT INTO `deporte` VALUES ('4', 'Criquet', null);
INSERT INTO `deporte` VALUES ('5', 'Tenis', null);
INSERT INTO `deporte` VALUES ('6', 'Natación', null);
INSERT INTO `deporte` VALUES ('7', 'Baile de Salón', null);
INSERT INTO `deporte` VALUES ('8', 'Tenis de mesa', null);

-- ----------------------------
-- Table structure for pregunta
-- ----------------------------
DROP TABLE IF EXISTS `pregunta`;
CREATE TABLE `pregunta` (
  `id_preg` int(3) NOT NULL AUTO_INCREMENT,
  `pregunta` mediumtext NOT NULL,
  `descripcion_preg` mediumtext,
  `imagen_preg` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_preg`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pregunta
-- ----------------------------
INSERT INTO `pregunta` VALUES ('1', 'Le gusta correr?', 'Le gusta correr?', null);
INSERT INTO `pregunta` VALUES ('2', 'Prefiere los deportes de contacto?', 'Prefiere los deportes de contacto?', null);
INSERT INTO `pregunta` VALUES ('3', 'Le gusta lanzar o patear balones o pelotas, o ambas?', 'Le gusta lanzar o patear balones o pelotas?', null);
INSERT INTO `pregunta` VALUES ('4', 'Le gusta jugar en un equipo o Individual?', 'Le gusta jugar en un equipo o Individual?', null);
INSERT INTO `pregunta` VALUES ('5', 'Le gusta hacer deporte solo o acompañado?', 'Le gusta hacer deporte solo o acompañado?', null);
INSERT INTO `pregunta` VALUES ('6', 'Le gusta el agua?', 'Le gusta el agua?', null);
INSERT INTO `pregunta` VALUES ('7', 'Le gusta escuchar música?', 'Le gusta escuchar música?', null);

-- ----------------------------
-- Table structure for respuesta
-- ----------------------------
DROP TABLE IF EXISTS `respuesta`;
CREATE TABLE `respuesta` (
  `id_resp` int(11) NOT NULL AUTO_INCREMENT,
  `respuesta` varchar(255) NOT NULL,
  PRIMARY KEY (`id_resp`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of respuesta
-- ----------------------------
INSERT INTO `respuesta` VALUES ('1', 'Si');
INSERT INTO `respuesta` VALUES ('2', 'No');
INSERT INTO `respuesta` VALUES ('3', 'Lanzar ');
INSERT INTO `respuesta` VALUES ('4', 'Patear ');
INSERT INTO `respuesta` VALUES ('5', 'Ambas');
INSERT INTO `respuesta` VALUES ('6', 'Equipo');
INSERT INTO `respuesta` VALUES ('7', 'Individual');
INSERT INTO `respuesta` VALUES ('8', 'Solo');
INSERT INTO `respuesta` VALUES ('9', 'Acompañado');

-- ----------------------------
-- Table structure for respuesta_pregunta
-- ----------------------------
DROP TABLE IF EXISTS `respuesta_pregunta`;
CREATE TABLE `respuesta_pregunta` (
  `pregunta_id_preg` int(3) NOT NULL,
  `respuesta_id_resp` int(11) NOT NULL,
  PRIMARY KEY (`pregunta_id_preg`,`respuesta_id_resp`),
  KEY `fk_respuesta_has_pregunta_pregunta1_idx` (`pregunta_id_preg`),
  KEY `fk_respuesta_has_pregunta_respuesta1_idx` (`respuesta_id_resp`),
  CONSTRAINT `fk_respuesta_has_pregunta_respuesta1` FOREIGN KEY (`respuesta_id_resp`) REFERENCES `respuesta` (`id_resp`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_respuesta_has_pregunta_pregunta1` FOREIGN KEY (`pregunta_id_preg`) REFERENCES `pregunta` (`id_preg`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of respuesta_pregunta
-- ----------------------------
INSERT INTO `respuesta_pregunta` VALUES ('1', '1');
INSERT INTO `respuesta_pregunta` VALUES ('1', '2');
INSERT INTO `respuesta_pregunta` VALUES ('2', '1');
INSERT INTO `respuesta_pregunta` VALUES ('2', '2');
INSERT INTO `respuesta_pregunta` VALUES ('3', '3');
INSERT INTO `respuesta_pregunta` VALUES ('3', '4');
INSERT INTO `respuesta_pregunta` VALUES ('3', '5');
INSERT INTO `respuesta_pregunta` VALUES ('4', '6');
INSERT INTO `respuesta_pregunta` VALUES ('4', '7');
INSERT INTO `respuesta_pregunta` VALUES ('5', '8');
INSERT INTO `respuesta_pregunta` VALUES ('5', '9');
INSERT INTO `respuesta_pregunta` VALUES ('6', '1');
INSERT INTO `respuesta_pregunta` VALUES ('6', '2');
INSERT INTO `respuesta_pregunta` VALUES ('7', '1');
INSERT INTO `respuesta_pregunta` VALUES ('7', '2');
