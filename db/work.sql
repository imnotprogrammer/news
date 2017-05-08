/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : work

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2016-09-30 16:14:55
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `dep_info`
-- ----------------------------
DROP TABLE IF EXISTS `dep_info`;
CREATE TABLE `dep_info` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `di_name` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Records of dep_info
-- ----------------------------

-- ----------------------------
-- Table structure for `upordown_info`
-- ----------------------------
DROP TABLE IF EXISTS `upordown_info`;
CREATE TABLE `upordown_info` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `upuser` int(11) DEFAULT NULL,
  `downuser` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Records of upordown_info
-- ----------------------------

-- ----------------------------
-- Table structure for `user_info`
-- ----------------------------
DROP TABLE IF EXISTS `user_info`;
CREATE TABLE `user_info` (
  `ui_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `ui_name` varchar(60) COLLATE utf8_bin DEFAULT NULL,
  `ui_phone` varchar(60) COLLATE utf8_bin DEFAULT NULL,
  `ui_email` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `ui_dep` int(11) DEFAULT NULL,
  `ui_status` tinyint(4) unsigned zerofill DEFAULT NULL,
  `ui_regtime` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`ui_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Records of user_info
-- ----------------------------

-- ----------------------------
-- Table structure for `workcontent.info`
-- ----------------------------
DROP TABLE IF EXISTS `workcontent.info`;
CREATE TABLE `workcontent.info` (
  `wci_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `wci_content` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `wci_starttime` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `wci_endtime` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `wci_progrss` int(11) DEFAULT NULL,
  `wci_selfscore` int(11) DEFAULT NULL,
  `wci_bwid` int(11) DEFAULT NULL,
  PRIMARY KEY (`wci_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Records of workcontent.info
-- ----------------------------

-- ----------------------------
-- Table structure for `work_info`
-- ----------------------------
DROP TABLE IF EXISTS `work_info`;
CREATE TABLE `work_info` (
  `wi_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `wi_user` int(11) DEFAULT NULL,
  `wi_summary` text COLLATE utf8_bin,
  `wi_pointuser` int(11) DEFAULT NULL,
  `wi_createtime` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `wi_level` int(11) DEFAULT '0' COMMENT '0 一般 1 努力 2 优秀',
  PRIMARY KEY (`wi_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Records of work_info
-- ----------------------------
