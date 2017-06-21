-- MySQL dump 10.13  Distrib 5.7.17, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: sj_erp
-- ------------------------------------------------------
-- Server version	5.5.5-10.1.21-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `sj_auth_group`
--

DROP TABLE IF EXISTS `sj_auth_group`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sj_auth_group` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `title` char(100) NOT NULL DEFAULT '',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `rules` varchar(1000) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sj_auth_group`
--

LOCK TABLES `sj_auth_group` WRITE;
/*!40000 ALTER TABLE `sj_auth_group` DISABLE KEYS */;
/*!40000 ALTER TABLE `sj_auth_group` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sj_auth_group_access`
--

DROP TABLE IF EXISTS `sj_auth_group_access`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sj_auth_group_access` (
  `uid` mediumint(8) unsigned NOT NULL,
  `group_id` mediumint(8) unsigned NOT NULL,
  UNIQUE KEY `uid_group_id` (`uid`,`group_id`),
  KEY `uid` (`uid`),
  KEY `group_id` (`group_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sj_auth_group_access`
--

LOCK TABLES `sj_auth_group_access` WRITE;
/*!40000 ALTER TABLE `sj_auth_group_access` DISABLE KEYS */;
/*!40000 ALTER TABLE `sj_auth_group_access` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sj_auth_rule`
--

DROP TABLE IF EXISTS `sj_auth_rule`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sj_auth_rule` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `pid` int(11) DEFAULT NULL,
  `name` char(80) NOT NULL DEFAULT '',
  `title` char(20) NOT NULL DEFAULT '',
  `type` tinyint(1) NOT NULL DEFAULT '1',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `condition` char(100) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=61 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sj_auth_rule`
--

LOCK TABLES `sj_auth_rule` WRITE;
/*!40000 ALTER TABLE `sj_auth_rule` DISABLE KEYS */;
INSERT INTO `sj_auth_rule` VALUES (47,0,'Home/Common/Index/index','主页',1,1,''),(48,0,'Home/SaleScene/Customer/index','客户管理',1,1,''),(49,0,'Home/SaleScene/HouseResource/index','房源管理',1,1,''),(50,0,'Home/Rbac/Auth/index','权限管理',1,1,''),(51,0,'Home/Rbac/Auth/group','用户组管理',1,1,''),(52,0,'Home/Rbac/Auth/admin_user_list','管理员列表',1,1,''),(53,50,'Home/Rbac/Auth/add','添加权限',1,1,''),(54,50,'Home/Rbac/Auth/edit','修改权限',1,1,''),(55,50,'Home/Rbac/Auth/delete','删除权限',1,1,''),(56,51,'Home/Rbac/Auth/add_group','添加用户组',1,1,''),(57,51,'Home/Rbac/Auth/edit_group','修改用户组',1,1,''),(58,51,'Home/Rbac/Auth/delete_group','删除用户组',1,1,''),(59,51,'Home/Rbac/Auth/rule_group','分配权限',1,1,''),(60,52,'Home/Rbac/Auth/edit_admin','修改管理员',1,1,'');
/*!40000 ALTER TABLE `sj_auth_rule` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sj_customer`
--

DROP TABLE IF EXISTS `sj_customer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sj_customer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `project` varchar(45) DEFAULT NULL,
  `name` varchar(45) DEFAULT NULL,
  `sex` varchar(45) DEFAULT NULL,
  `telephone` varchar(45) DEFAULT NULL,
  `phone` varchar(45) DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  `pathway` varchar(45) DEFAULT NULL,
  `carttype` varchar(45) DEFAULT NULL,
  `cartnumber` varchar(45) DEFAULT NULL,
  `age` varchar(45) DEFAULT NULL,
  `business` varchar(45) DEFAULT NULL,
  `job` varchar(45) DEFAULT NULL,
  `lastfollow` varchar(45) DEFAULT NULL,
  `visitdate` date DEFAULT NULL,
  `type` varchar(45) DEFAULT NULL,
  `teltovisited` varchar(45) DEFAULT NULL,
  `salesman` varchar(45) DEFAULT NULL,
  `address` varchar(45) DEFAULT NULL,
  `addressdetail` varchar(45) DEFAULT NULL,
  `investmentdemand` varchar(45) DEFAULT NULL,
  `investmentintention` varchar(200) DEFAULT NULL,
  `investmentbudget` varchar(45) DEFAULT NULL,
  `otherintentestate` varchar(45) DEFAULT NULL,
  `intentestate` varchar(45) DEFAULT NULL,
  `qualifications` varchar(45) DEFAULT NULL,
  `financialdemand` varchar(45) DEFAULT NULL,
  `homepurpose` varchar(45) DEFAULT NULL,
  `intenthome` varchar(45) DEFAULT NULL,
  `acceptprice` varchar(45) DEFAULT NULL,
  `intentlevel` varchar(45) DEFAULT NULL,
  `resistance` varchar(45) DEFAULT NULL,
  `approvalpoint` varchar(45) DEFAULT NULL,
  `institutional` varchar(45) DEFAULT NULL,
  `leasing` varchar(45) DEFAULT NULL,
  `pastloan` varchar(45) DEFAULT NULL,
  `experience` varchar(100) DEFAULT NULL,
  `holding` varchar(45) DEFAULT NULL,
  `driving` varchar(45) DEFAULT NULL,
  `review` varchar(45) DEFAULT NULL,
  `family` varchar(45) DEFAULT NULL,
  `carprice` varchar(45) DEFAULT NULL,
  `ownership` varchar(45) DEFAULT NULL,
  `financialstrength` varchar(45) DEFAULT NULL,
  `WeChat` varchar(45) DEFAULT NULL,
  `companyname` varchar(45) DEFAULT NULL,
  `coding` varchar(45) DEFAULT NULL,
  `ownershipform` varchar(45) DEFAULT NULL,
  `registeredprice` varchar(45) DEFAULT NULL,
  `employeesnumber` varchar(45) DEFAULT NULL,
  `usestatus` varchar(45) DEFAULT NULL,
  `concernfactor` varchar(200) DEFAULT NULL,
  `officespace` varchar(45) DEFAULT NULL,
  `establishmenttime` varchar(45) DEFAULT NULL,
  `islist` varchar(45) DEFAULT NULL,
  `drivingfactors` varchar(200) DEFAULT NULL,
  `demandarea` varchar(45) DEFAULT NULL,
  `demandunitprice` varchar(45) DEFAULT NULL,
  `remark` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='客源';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sj_customer`
--

LOCK TABLES `sj_customer` WRITE;
/*!40000 ALTER TABLE `sj_customer` DISABLE KEYS */;
/*!40000 ALTER TABLE `sj_customer` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sj_house`
--

DROP TABLE IF EXISTS `sj_house`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sj_house` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `housecode` varchar(45) DEFAULT NULL COMMENT '房源编码',
  `title` varchar(200) DEFAULT NULL,
  `location` varchar(45) DEFAULT NULL,
  `building` varchar(45) DEFAULT NULL,
  `layout` varchar(45) DEFAULT NULL,
  `decoration` varchar(45) DEFAULT NULL,
  `floor` varchar(45) DEFAULT NULL,
  `direction` varchar(45) DEFAULT NULL,
  `area` varchar(45) DEFAULT NULL,
  `roomnumber` varchar(45) DEFAULT NULL,
  `haskey` varchar(45) DEFAULT NULL,
  `twoyears` varchar(45) DEFAULT NULL,
  `price` varchar(45) DEFAULT NULL,
  `contact` varchar(45) DEFAULT NULL,
  `sex` varchar(45) DEFAULT NULL,
  `phone` varchar(45) DEFAULT NULL,
  `description` varchar(200) DEFAULT NULL,
  `status` int(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sj_house`
--

LOCK TABLES `sj_house` WRITE;
/*!40000 ALTER TABLE `sj_house` DISABLE KEYS */;
/*!40000 ALTER TABLE `sj_house` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sj_houseimg`
--

DROP TABLE IF EXISTS `sj_houseimg`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sj_houseimg` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `houseid` int(11) NOT NULL,
  `url` varchar(200) NOT NULL,
  `title` varchar(200) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sj_houseimg`
--

LOCK TABLES `sj_houseimg` WRITE;
/*!40000 ALTER TABLE `sj_houseimg` DISABLE KEYS */;
/*!40000 ALTER TABLE `sj_houseimg` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sj_system_record`
--

DROP TABLE IF EXISTS `sj_system_record`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sj_system_record` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(45) NOT NULL COMMENT '邮箱',
  `name` varchar(45) NOT NULL COMMENT '用户名',
  `op_date` date NOT NULL COMMENT '操作日期',
  `op_time` time NOT NULL COMMENT '操作时间',
  `operation` text NOT NULL COMMENT '操作',
  `controller` varchar(200) DEFAULT '""' COMMENT '控制器',
  `visit` tinyint(1) DEFAULT '1' COMMENT '访问标识（0：系统访问；1：页面访问；2：功能访问）',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='系统操作记录';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sj_system_record`
--

LOCK TABLES `sj_system_record` WRITE;
/*!40000 ALTER TABLE `sj_system_record` DISABLE KEYS */;
/*!40000 ALTER TABLE `sj_system_record` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sj_user`
--

DROP TABLE IF EXISTS `sj_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sj_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(45) NOT NULL,
  `password` varchar(100) NOT NULL,
  `name` varchar(45) NOT NULL,
  `head_img` varchar(200) DEFAULT NULL,
  `status` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  UNIQUE KEY `email_UNIQUE` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sj_user`
--

LOCK TABLES `sj_user` WRITE;
/*!40000 ALTER TABLE `sj_user` DISABLE KEYS */;
INSERT INTO `sj_user` VALUES (1,'admin',md5(concat('admin','admin')),'ADMIN','',1);
/*!40000 ALTER TABLE `sj_user` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-06-21 17:58:31
