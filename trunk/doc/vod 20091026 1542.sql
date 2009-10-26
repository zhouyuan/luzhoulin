-- MySQL Administrator dump 1.4
--
-- ------------------------------------------------------
-- Server version	5.1.33-community


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


--
-- Create schema vod
--

CREATE DATABASE IF NOT EXISTS vod;
USE vod;

--
-- Definition of table `pv_advert`
--

DROP TABLE IF EXISTS `pv_advert`;
CREATE TABLE `pv_advert` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `subject` varchar(255) NOT NULL DEFAULT '',
  `startdate` varchar(15) NOT NULL DEFAULT '',
  `enddate` varchar(15) NOT NULL DEFAULT '',
  `filename` varchar(100) NOT NULL DEFAULT '',
  `content` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

--
-- Dumping data for table `pv_advert`
--

/*!40000 ALTER TABLE `pv_advert` DISABLE KEYS */;
/*!40000 ALTER TABLE `pv_advert` ENABLE KEYS */;


--
-- Definition of table `pv_announce`
--

DROP TABLE IF EXISTS `pv_announce`;
CREATE TABLE `pv_announce` (
  `aid` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `vieworder` smallint(6) NOT NULL DEFAULT '0',
  `author` varchar(15) NOT NULL DEFAULT '',
  `startdate` varchar(15) NOT NULL DEFAULT '',
  `enddate` varchar(15) NOT NULL DEFAULT '',
  `subject` varchar(100) NOT NULL DEFAULT '',
  `content` mediumtext NOT NULL,
  PRIMARY KEY (`aid`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=gbk;

--
-- Dumping data for table `pv_announce`
--

/*!40000 ALTER TABLE `pv_announce` DISABLE KEYS */;
INSERT INTO `pv_announce` (`aid`,`vieworder`,`author`,`startdate`,`enddate`,`subject`,`content`) VALUES 
 (1,0,'lippman','1255605725','','公告1','asdasdasd');
/*!40000 ALTER TABLE `pv_announce` ENABLE KEYS */;


--
-- Definition of table `pv_attachs`
--

DROP TABLE IF EXISTS `pv_attachs`;
CREATE TABLE `pv_attachs` (
  `aid` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `uid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `author` varchar(15) NOT NULL DEFAULT '',
  `name` char(80) NOT NULL DEFAULT '',
  `size` int(10) unsigned NOT NULL DEFAULT '0',
  `uploadtime` int(10) NOT NULL DEFAULT '0',
  `type` varchar(5) NOT NULL DEFAULT '',
  PRIMARY KEY (`aid`),
  KEY `uid` (`uid`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

--
-- Dumping data for table `pv_attachs`
--

/*!40000 ALTER TABLE `pv_attachs` DISABLE KEYS */;
/*!40000 ALTER TABLE `pv_attachs` ENABLE KEYS */;


--
-- Definition of table `pv_cknum`
--

DROP TABLE IF EXISTS `pv_cknum`;
CREATE TABLE `pv_cknum` (
  `sid` varchar(8) NOT NULL,
  `nmsg` char(4) NOT NULL DEFAULT '',
  `time` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`sid`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

--
-- Dumping data for table `pv_cknum`
--

/*!40000 ALTER TABLE `pv_cknum` DISABLE KEYS */;
/*!40000 ALTER TABLE `pv_cknum` ENABLE KEYS */;


--
-- Definition of table `pv_class`
--

DROP TABLE IF EXISTS `pv_class`;
CREATE TABLE `pv_class` (
  `cid` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `cup` smallint(6) unsigned NOT NULL DEFAULT '0',
  `lv` tinyint(2) NOT NULL DEFAULT '0',
  `fathers` varchar(255) NOT NULL DEFAULT '',
  `caption` varchar(80) NOT NULL DEFAULT '',
  `vieworder` tinyint(3) NOT NULL DEFAULT '0',
  `type` enum('hidden','members','free') NOT NULL DEFAULT 'free',
  `orderway` enum('replies','hits','postdate') NOT NULL DEFAULT 'postdate',
  `orderasc` tinyint(1) NOT NULL DEFAULT '1',
  `atccheck` tinyint(1) NOT NULL DEFAULT '0',
  `rvrcneed` int(11) NOT NULL DEFAULT '0',
  `moneyneed` int(11) NOT NULL DEFAULT '0',
  `postneed` int(11) NOT NULL DEFAULT '0',
  `password` char(32) NOT NULL DEFAULT '',
  `allowvisit` varchar(255) NOT NULL DEFAULT '',
  `allowplay` varchar(255) NOT NULL DEFAULT '',
  `allowpost` varchar(255) NOT NULL DEFAULT '',
  `allowrp` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`cid`),
  KEY `hup` (`cup`)
) ENGINE=MyISAM AUTO_INCREMENT=33 DEFAULT CHARSET=gbk;

--
-- Dumping data for table `pv_class`
--

/*!40000 ALTER TABLE `pv_class` DISABLE KEYS */;
INSERT INTO `pv_class` (`cid`,`cup`,`lv`,`fathers`,`caption`,`vieworder`,`type`,`orderway`,`orderasc`,`atccheck`,`rvrcneed`,`moneyneed`,`postneed`,`password`,`allowvisit`,`allowplay`,`allowpost`,`allowrp`) VALUES 
 (1,0,0,'','小学',0,'free','postdate',1,0,0,0,0,'','','','',''),
 (2,0,0,'','初中',0,'free','postdate',1,0,0,0,0,'','','','',''),
 (30,3,1,'3','第一高中',0,'free','postdate',1,0,0,0,0,'','','','',''),
 (5,1,1,'1','第一小学',0,'free','postdate',1,0,0,0,0,'','','','',''),
 (6,1,1,'1','第二小学',0,'free','postdate',1,0,0,0,0,'','','','',''),
 (7,1,1,'1','第三小学',0,'free','postdate',1,0,0,0,0,'','','','',''),
 (8,1,1,'1','第四小学',0,'free','postdate',1,0,0,0,0,'','','','',''),
 (9,1,1,'1','第五小学',0,'free','postdate',1,0,0,0,0,'','','','',''),
 (10,1,1,'1','第六小学',0,'free','postdate',1,0,0,0,0,'','','','',''),
 (14,2,1,'2','第一初中',0,'free','postdate',1,0,0,0,0,'','','','',''),
 (15,2,1,'2','第二初中',0,'free','postdate',1,0,0,0,0,'','','','',''),
 (31,2,1,'2','第三初中',0,'free','postdate',1,0,0,0,0,'','','','',''),
 (3,0,0,'','高中',0,'free','postdate',1,0,0,0,0,'','','','','');
/*!40000 ALTER TABLE `pv_class` ENABLE KEYS */;


--
-- Definition of table `pv_config`
--

DROP TABLE IF EXISTS `pv_config`;
CREATE TABLE `pv_config` (
  `db_name` varchar(30) NOT NULL DEFAULT '',
  `db_value` text NOT NULL,
  `decrip` text NOT NULL,
  PRIMARY KEY (`db_name`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

--
-- Dumping data for table `pv_config`
--

/*!40000 ALTER TABLE `pv_config` DISABLE KEYS */;
INSERT INTO `pv_config` (`db_name`,`db_value`,`decrip`) VALUES 
 ('db_creditset','a:4:{s:5:\"money\";a:4:{s:4:\"Post\";i:3;s:5:\"Reply\";i:1;s:6:\"Delete\";i:3;s:8:\"Deleterp\";i:1;}s:4:\"rvrc\";a:4:{s:4:\"Post\";i:1;s:5:\"Reply\";i:0;s:6:\"Delete\";i:1;s:8:\"Deleterp\";i:0;}i:1;a:4:{s:4:\"Post\";i:0;s:5:\"Reply\";i:0;s:6:\"Delete\";i:0;s:8:\"Deleterp\";i:0;}i:2;a:4:{s:4:\"Post\";i:0;s:5:\"Reply\";i:0;s:6:\"Delete\";i:0;s:8:\"Deleterp\";i:0;}}',''),
 ('db_forcecharset','0',''),
 ('db_timedf','8',''),
 ('db_datefm','Y-n-j H:i',''),
 ('db_defaultstyle','phpvod',''),
 ('db_indexlink','1',''),
 ('db_indexmqlink','0',''),
 ('db_adminperpage','20',''),
 ('db_perpage','10',''),
 ('db_readperpage','10',''),
 ('db_postmin','3',''),
 ('db_postmax','500',''),
 ('db_reply','1',''),
 ('db_autochange','0',''),
 ('db_hour','8',''),
 ('db_http','N',''),
 ('db_uploadvodpic','1',''),
 ('db_picfiletype','jpg,jpeg,gif,png,bmp',''),
 ('db_picmaxsize','2048000',''),
 ('db_uploadattach','1',''),
 ('db_attfiletype','zip,rar',''),
 ('db_gdcheck','0	0	0	0	0	0',''),
 ('rg_regdetail','1',''),
 ('rg_ifcheck','0',''),
 ('rg_regrvrc','0',''),
 ('rg_regmoney','0',''),
 ('db_siteifopen','1',''),
 ('db_whyclose','网站升级中... 请等候 15分钟.',''),
 ('db_wwwname','上海中小学视频点播网',''),
 ('db_wwwurl','http://localhost/vod',''),
 ('db_bfn','index.php',''),
 ('db_ceoconnect','http://localhost/vod',''),
 ('db_ceoemail','phpvod@qq.com',''),
 ('db_keywords','中小学，视频，课件',''),
 ('db_description','',''),
 ('db_copyright','<font color=#999999>Copyright 2007-2009 版权所有 <a href=http://www.phpvod.com/ target=_blank><b>PHPvod</b><b style=color:#FF9900>.com</b></a></font>',''),
 ('db_obstart','0',''),
 ('db_debug','0',''),
 ('db_ifjump','1',''),
 ('db_cc','1',''),
 ('db_charset','gbk',''),
 ('rg_allowregister','1',''),
 ('rg_regminname','3',''),
 ('rg_regmaxname','12',''),
 ('rg_regmaxhonor','30',''),
 ('rg_regmaxsign','100',''),
 ('rg_banname','admin,管理员,站长',''),
 ('db_upgrade','a:6:{s:7:\"postnum\";s:1:\"0\";s:4:\"rvrc\";s:1:\"3\";s:5:\"money\";s:1:\"1\";i:5;s:1:\"1\";i:6;s:1:\"2\";i:7;s:1:\"3\";}',''),
 ('db_tplrefresh','1',''),
 ('db_htmifopen','0',''),
 ('db_dir','.php?',''),
 ('db_ext','.html',''),
 ('db_iconupload','1',''),
 ('db_iconsize','2000','');
/*!40000 ALTER TABLE `pv_config` ENABLE KEYS */;


--
-- Definition of table `pv_credits`
--

DROP TABLE IF EXISTS `pv_credits`;
CREATE TABLE `pv_credits` (
  `cid` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `name` char(30) NOT NULL DEFAULT '',
  `description` char(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`cid`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=gbk;

--
-- Dumping data for table `pv_credits`
--

/*!40000 ALTER TABLE `pv_credits` DISABLE KEYS */;
INSERT INTO `pv_credits` (`cid`,`name`,`description`) VALUES 
 (1,'贡献度','自定义积分1'),
 (2,'交易币','自定义积分3');
/*!40000 ALTER TABLE `pv_credits` ENABLE KEYS */;


--
-- Definition of table `pv_grades`
--

DROP TABLE IF EXISTS `pv_grades`;
CREATE TABLE `pv_grades` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `subject` char(20) NOT NULL,
  `cid` smallint(6) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=gbk ROW_FORMAT=FIXED;

--
-- Dumping data for table `pv_grades`
--

/*!40000 ALTER TABLE `pv_grades` DISABLE KEYS */;
INSERT INTO `pv_grades` (`id`,`subject`,`cid`) VALUES 
 (1,'小学一年级',5),
 (2,'小学二年级',5),
 (3,'小学三年级',5);
/*!40000 ALTER TABLE `pv_grades` ENABLE KEYS */;


--
-- Definition of table `pv_hack`
--

DROP TABLE IF EXISTS `pv_hack`;
CREATE TABLE `pv_hack` (
  `hid` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL DEFAULT '',
  `directory` varchar(100) NOT NULL DEFAULT '',
  `hidden` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`hid`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=gbk;

--
-- Dumping data for table `pv_hack`
--

/*!40000 ALTER TABLE `pv_hack` DISABLE KEYS */;
INSERT INTO `pv_hack` (`hid`,`name`,`directory`,`hidden`) VALUES 
 (1,'勋章中心','medal',0);
/*!40000 ALTER TABLE `pv_hack` ENABLE KEYS */;


--
-- Definition of table `pv_hackvar`
--

DROP TABLE IF EXISTS `pv_hackvar`;
CREATE TABLE `pv_hackvar` (
  `hk_name` varchar(30) NOT NULL DEFAULT '',
  `hk_value` text NOT NULL,
  `decrip` text NOT NULL,
  PRIMARY KEY (`hk_name`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

--
-- Dumping data for table `pv_hackvar`
--

/*!40000 ALTER TABLE `pv_hackvar` DISABLE KEYS */;
INSERT INTO `pv_hackvar` (`hk_name`,`hk_value`,`decrip`) VALUES 
 ('md_ifopen','1',''),
 ('md_ifmsg','0',''),
 ('md_groups',',3,','');
/*!40000 ALTER TABLE `pv_hackvar` ENABLE KEYS */;


--
-- Definition of table `pv_help`
--

DROP TABLE IF EXISTS `pv_help`;
CREATE TABLE `pv_help` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(80) NOT NULL DEFAULT '',
  `content` mediumtext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

--
-- Dumping data for table `pv_help`
--

/*!40000 ALTER TABLE `pv_help` DISABLE KEYS */;
/*!40000 ALTER TABLE `pv_help` ENABLE KEYS */;


--
-- Definition of table `pv_medalinfo`
--

DROP TABLE IF EXISTS `pv_medalinfo`;
CREATE TABLE `pv_medalinfo` (
  `id` tinyint(4) NOT NULL AUTO_INCREMENT,
  `name` varchar(40) NOT NULL DEFAULT '',
  `intro` varchar(255) NOT NULL DEFAULT '',
  `picurl` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=gbk;

--
-- Dumping data for table `pv_medalinfo`
--

/*!40000 ALTER TABLE `pv_medalinfo` DISABLE KEYS */;
INSERT INTO `pv_medalinfo` (`id`,`name`,`intro`,`picurl`) VALUES 
 (1,'终身成就奖','谢谢您为网站发展做出的不可磨灭的贡献!!','1.gif'),
 (2,'宣传大使奖','谢谢您为网站积极宣传,特颁发此奖!','2.gif'),
 (3,'特殊贡献奖','您为网站做出了特殊贡献,谢谢您!','3.gif'),
 (4,'金点子奖','为网站提出建设性的建议被采纳,特颁发此奖!','4.gif'),
 (5,'视频发布奖','谢谢您积极发表影视作品,特颁发此奖!','5.gif'),
 (6,'新人进步奖','新人有很大的进步可以得到这个奖章!','6.gif'),
 (7,'幽默大师奖','您总是能给别人带来欢乐,谢谢您!','7.gif');
/*!40000 ALTER TABLE `pv_medalinfo` ENABLE KEYS */;


--
-- Definition of table `pv_medalslogs`
--

DROP TABLE IF EXISTS `pv_medalslogs`;
CREATE TABLE `pv_medalslogs` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `awardee` varchar(40) NOT NULL DEFAULT '',
  `awarder` varchar(40) NOT NULL DEFAULT '',
  `awardtime` int(10) NOT NULL DEFAULT '0',
  `timelimit` tinyint(2) NOT NULL DEFAULT '0',
  `state` tinyint(1) NOT NULL DEFAULT '0',
  `level` tinyint(4) NOT NULL DEFAULT '0',
  `action` tinyint(1) NOT NULL DEFAULT '0',
  `why` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

--
-- Dumping data for table `pv_medalslogs`
--

/*!40000 ALTER TABLE `pv_medalslogs` DISABLE KEYS */;
/*!40000 ALTER TABLE `pv_medalslogs` ENABLE KEYS */;


--
-- Definition of table `pv_membercredit`
--

DROP TABLE IF EXISTS `pv_membercredit`;
CREATE TABLE `pv_membercredit` (
  `uid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `cid` tinyint(3) NOT NULL DEFAULT '0',
  `value` mediumint(8) NOT NULL DEFAULT '0',
  KEY `uid` (`uid`),
  KEY `cid` (`cid`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

--
-- Dumping data for table `pv_membercredit`
--

/*!40000 ALTER TABLE `pv_membercredit` DISABLE KEYS */;
/*!40000 ALTER TABLE `pv_membercredit` ENABLE KEYS */;


--
-- Definition of table `pv_memberdata`
--

DROP TABLE IF EXISTS `pv_memberdata`;
CREATE TABLE `pv_memberdata` (
  `uid` mediumint(8) unsigned NOT NULL DEFAULT '1',
  `postnum` int(10) unsigned NOT NULL DEFAULT '0',
  `rvrc` int(10) NOT NULL DEFAULT '0',
  `money` int(10) NOT NULL DEFAULT '0',
  `buyvid` text NOT NULL,
  `onlineip` char(30) NOT NULL DEFAULT '',
  PRIMARY KEY (`uid`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

--
-- Dumping data for table `pv_memberdata`
--

/*!40000 ALTER TABLE `pv_memberdata` DISABLE KEYS */;
INSERT INTO `pv_memberdata` (`uid`,`postnum`,`rvrc`,`money`,`buyvid`,`onlineip`) VALUES 
 (1,2,2,6,'','127.0.0.1|1256531050|6'),
 (2,4,4,13,'','127.0.0.1|1256112906|6'),
 (3,0,0,0,'','127.0.0.1'),
 (4,0,0,0,'','127.0.0.1'),
 (5,0,0,0,'','127.0.0.1'),
 (6,0,0,0,'','127.0.0.1|1255856270|6'),
 (7,0,0,0,'','127.0.0.1'),
 (8,0,0,0,'','127.0.0.1'),
 (9,0,0,0,'','127.0.0.1'),
 (10,0,0,0,'','127.0.0.1'),
 (11,0,0,0,'','127.0.0.1'),
 (12,0,0,0,'','127.0.0.1');
/*!40000 ALTER TABLE `pv_memberdata` ENABLE KEYS */;


--
-- Definition of table `pv_members`
--

DROP TABLE IF EXISTS `pv_members`;
CREATE TABLE `pv_members` (
  `uid` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL DEFAULT '',
  `password` varchar(40) NOT NULL DEFAULT '',
  `email` varchar(60) NOT NULL DEFAULT '',
  `publicmail` tinyint(1) NOT NULL DEFAULT '1',
  `groupid` tinyint(3) NOT NULL DEFAULT '-1',
  `memberid` tinyint(3) NOT NULL DEFAULT '0',
  `icon` varchar(100) NOT NULL DEFAULT '',
  `gender` tinyint(1) NOT NULL DEFAULT '0',
  `regdate` int(10) unsigned NOT NULL DEFAULT '0',
  `signature` mediumtext NOT NULL,
  `region` varchar(12) NOT NULL,
  `school` varchar(35) NOT NULL,
  `site` varchar(75) NOT NULL DEFAULT '',
  `honor` varchar(30) NOT NULL DEFAULT '',
  `bday` date NOT NULL DEFAULT '0000-00-00',
  `receivemail` tinyint(1) NOT NULL DEFAULT '1',
  `yz` int(10) NOT NULL DEFAULT '1',
  `newpm` tinyint(1) NOT NULL DEFAULT '0',
  `medals` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`uid`),
  KEY `username` (`username`),
  KEY `groupid` (`groupid`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=gbk;

--
-- Dumping data for table `pv_members`
--

/*!40000 ALTER TABLE `pv_members` DISABLE KEYS */;
INSERT INTO `pv_members` (`uid`,`username`,`password`,`email`,`publicmail`,`groupid`,`memberid`,`icon`,`gender`,`regdate`,`signature`,`region`,`school`,`site`,`honor`,`bday`,`receivemail`,`yz`,`newpm`,`medals`) VALUES 
 (1,'lippman','b772c188ea0301c443d0f558ba0d126e','luyang9889@sina.com',1,5,7,'none.gif',0,1255596402,'','闵行区','第一小学','','','0000-00-00',1,1,0,''),
 (2,'test','e10adc3949ba59abbe56e057f20f883e','as@as.com',1,3,7,'none.gif',1,1255605487,'','闵行区','第二小学','','','1984-02-27',2,1,0,''),
 (3,'test2','e10adc3949ba59abbe56e057f20f883e','123@123.com',1,4,5,'none.gif',1,1255842475,'','闵行区','第二小学','','','0000-00-00',1,1,0,''),
 (4,'asd','e10adc3949ba59abbe56e057f20f883e','asd@asd.com',1,-1,5,'4.gif',0,1255850261,'','闵行区','第二小学','','','0000-00-00',1,1,0,''),
 (5,'asdddd','e10adc3949ba59abbe56e057f20f883e','123@123.com',1,-1,7,'2.gif',0,1255853443,'','闵行区','第二小学','','','0000-00-00',1,1,0,''),
 (6,'asdaaa','e10adc3949ba59abbe56e057f20f883e','123@123.com',1,-1,7,'none.gif',0,1255855038,'','闵行区','第二小学','','','0000-00-00',1,1,0,''),
 (7,'wwww','e10adc3949ba59abbe56e057f20f883e','123@123.com',1,-1,7,'none.gif',0,1255857995,'','闵行区','第二小学','','老大','0000-00-00',1,1,0,''),
 (8,'阿斯达的','e10adc3949ba59abbe56e057f20f883e','123@123.com',1,-1,7,'none.gif',0,1255858912,'','闵行区','第四小学','','','0000-00-00',1,1,0,''),
 (9,'ddd','e10adc3949ba59abbe56e057f20f883e','123@123.com',1,6,7,'',0,1256042657,'','','','','','0000-00-00',1,1,0,''),
 (10,'test4','e10adc3949ba59abbe56e057f20f883e','123@123.com',1,-1,7,'none.gif',0,1256053893,'','闵行区','第六小学','','','0000-00-00',1,1,0,''),
 (11,'adssd','a8f5f167f44f4964e6c998dee827110c','123@123.com',1,-1,7,'none.gif',0,1256099467,'','闵行区','第一小学','','','0000-00-00',1,1,0,''),
 (12,'123','202cb962ac59075b964b07152d234b70','123@123.com',1,-1,7,'',0,1256113635,'','','','','','0000-00-00',1,1,0,'');
/*!40000 ALTER TABLE `pv_members` ENABLE KEYS */;


--
-- Definition of table `pv_msg`
--

DROP TABLE IF EXISTS `pv_msg`;
CREATE TABLE `pv_msg` (
  `mid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type` enum('rebox','sebox','public') NOT NULL DEFAULT 'rebox',
  `touid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `fromuid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `username` varchar(15) NOT NULL DEFAULT '',
  `ifnew` tinyint(1) NOT NULL DEFAULT '0',
  `title` varchar(130) NOT NULL DEFAULT '',
  `content` mediumtext NOT NULL,
  `mdate` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`mid`),
  KEY `touid` (`touid`),
  KEY `fromuid` (`fromuid`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

--
-- Dumping data for table `pv_msg`
--

/*!40000 ALTER TABLE `pv_msg` DISABLE KEYS */;
/*!40000 ALTER TABLE `pv_msg` ENABLE KEYS */;


--
-- Definition of table `pv_nations`
--

DROP TABLE IF EXISTS `pv_nations`;
CREATE TABLE `pv_nations` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `subject` char(20) NOT NULL DEFAULT '',
  `vieworder` smallint(6) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `subject` (`subject`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=gbk;

--
-- Dumping data for table `pv_nations`
--

/*!40000 ALTER TABLE `pv_nations` DISABLE KEYS */;
INSERT INTO `pv_nations` (`id`,`subject`,`vieworder`) VALUES 
 (1,'语文',1),
 (2,'数学',2),
 (3,'英语',3),
 (4,'历史',4),
 (5,'其他',5),
 (6,'政治',0),
 (7,'asd',0);
/*!40000 ALTER TABLE `pv_nations` ENABLE KEYS */;


--
-- Definition of table `pv_player`
--

DROP TABLE IF EXISTS `pv_player`;
CREATE TABLE `pv_player` (
  `pid` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `name` char(50) NOT NULL DEFAULT '',
  `subject` char(100) NOT NULL DEFAULT '',
  `playpath` char(100) NOT NULL DEFAULT '',
  `hidden` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`pid`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=gbk;

--
-- Dumping data for table `pv_player`
--

/*!40000 ALTER TABLE `pv_player` DISABLE KEYS */;
INSERT INTO `pv_player` (`pid`,`name`,`subject`,`playpath`,`hidden`) VALUES 
 (1,'RealPlayer','支持 Rm, Rmvb, Mpg, Mp4 等常用格式','real.htm',1),
 (2,'Window Media Player','支持 Wmv, Asf, Avi 等常用格式','media.htm',1),
 (3,'QVOD','快播','qvod.htm',1),
 (4,'GVOD','迅播','gvod.htm',1),
 (5,'皮皮播放器','皮皮播放器','pipi.htm',1),
 (6,'酷6','酷6','ku6.htm',1),
 (7,'56','56','56.htm',1),
 (8,'土豆','土豆','tudou.htm',1),
 (9,'下载','下载影片','down.htm',1),
 (10,'IActivePlayer','IActive','iac.htm',1);
/*!40000 ALTER TABLE `pv_player` ENABLE KEYS */;


--
-- Definition of table `pv_replier`
--

DROP TABLE IF EXISTS `pv_replier`;
CREATE TABLE `pv_replier` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `vid` smallint(8) unsigned NOT NULL DEFAULT '0',
  `author` varchar(50) NOT NULL DEFAULT '',
  `authorid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `postdate` int(10) unsigned NOT NULL DEFAULT '0',
  `content` mediumtext NOT NULL,
  `yz` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `vid` (`vid`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=gbk;

--
-- Dumping data for table `pv_replier`
--

/*!40000 ALTER TABLE `pv_replier` DISABLE KEYS */;
INSERT INTO `pv_replier` (`id`,`vid`,`author`,`authorid`,`postdate`,`content`,`yz`) VALUES 
 (1,1,'test',2,1255615679,'阿飞的',1);
/*!40000 ALTER TABLE `pv_replier` ENABLE KEYS */;


--
-- Definition of table `pv_report`
--

DROP TABLE IF EXISTS `pv_report`;
CREATE TABLE `pv_report` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `vid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `uid` mediumint(9) NOT NULL DEFAULT '0',
  `type` char(255) NOT NULL DEFAULT '0',
  `reason` char(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `type` (`type`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=gbk;

--
-- Dumping data for table `pv_report`
--

/*!40000 ALTER TABLE `pv_report` DISABLE KEYS */;
INSERT INTO `pv_report` (`id`,`vid`,`uid`,`type`,`reason`) VALUES 
 (1,1,1,'违禁视频','asdasdsad');
/*!40000 ALTER TABLE `pv_report` ENABLE KEYS */;


--
-- Definition of table `pv_sharelinks`
--

DROP TABLE IF EXISTS `pv_sharelinks`;
CREATE TABLE `pv_sharelinks` (
  `sid` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `threadorder` tinyint(3) NOT NULL DEFAULT '0',
  `name` char(100) NOT NULL DEFAULT '',
  `url` char(100) NOT NULL DEFAULT '',
  `descrip` char(200) NOT NULL DEFAULT '0',
  `logo` char(100) NOT NULL DEFAULT '',
  PRIMARY KEY (`sid`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=gbk;

--
-- Dumping data for table `pv_sharelinks`
--

/*!40000 ALTER TABLE `pv_sharelinks` DISABLE KEYS */;
INSERT INTO `pv_sharelinks` (`sid`,`threadorder`,`name`,`url`,`descrip`,`logo`) VALUES 
 (1,0,'Sina','http://www.sina.com.cn','Sina最大的中文门户网站','');
/*!40000 ALTER TABLE `pv_sharelinks` ENABLE KEYS */;


--
-- Definition of table `pv_siteinfo`
--

DROP TABLE IF EXISTS `pv_siteinfo`;
CREATE TABLE `pv_siteinfo` (
  `id` smallint(3) unsigned NOT NULL AUTO_INCREMENT,
  `newmember` varchar(15) NOT NULL DEFAULT '',
  `totalmember` mediumint(8) unsigned NOT NULL DEFAULT '0',
  KEY `id` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=gbk;

--
-- Dumping data for table `pv_siteinfo`
--

/*!40000 ALTER TABLE `pv_siteinfo` DISABLE KEYS */;
INSERT INTO `pv_siteinfo` (`id`,`newmember`,`totalmember`) VALUES 
 (1,'123',12);
/*!40000 ALTER TABLE `pv_siteinfo` ENABLE KEYS */;


--
-- Definition of table `pv_styles`
--

DROP TABLE IF EXISTS `pv_styles`;
CREATE TABLE `pv_styles` (
  `sid` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `name` char(50) NOT NULL DEFAULT '',
  `stylepath` char(50) NOT NULL DEFAULT '',
  `tplpath` char(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`sid`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=gbk;

--
-- Dumping data for table `pv_styles`
--

/*!40000 ALTER TABLE `pv_styles` DISABLE KEYS */;
INSERT INTO `pv_styles` (`sid`,`name`,`stylepath`,`tplpath`) VALUES 
 (1,'phpvod','phpvod','phpvod');
/*!40000 ALTER TABLE `pv_styles` ENABLE KEYS */;


--
-- Definition of table `pv_tags`
--

DROP TABLE IF EXISTS `pv_tags`;
CREATE TABLE `pv_tags` (
  `ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `subject` char(20) NOT NULL,
  `gradeID` smallint(6) unsigned NOT NULL,
  `nationID` smallint(6) unsigned NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=gbk;

--
-- Dumping data for table `pv_tags`
--

/*!40000 ALTER TABLE `pv_tags` DISABLE KEYS */;
INSERT INTO `pv_tags` (`ID`,`subject`,`gradeID`,`nationID`) VALUES 
 (1,'新中国成立',3,1),
 (2,'回忆',3,1),
 (3,'雍正王朝',2,4);
/*!40000 ALTER TABLE `pv_tags` ENABLE KEYS */;


--
-- Definition of table `pv_urls`
--

DROP TABLE IF EXISTS `pv_urls`;
CREATE TABLE `pv_urls` (
  `uid` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `vid` smallint(8) unsigned NOT NULL DEFAULT '0',
  `pid` tinyint(3) NOT NULL DEFAULT '1',
  `url` char(255) NOT NULL DEFAULT '',
  `series` int(10) NOT NULL,
  `server` int(10) NOT NULL DEFAULT '1',
  `caption` char(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`uid`),
  KEY `vid` (`vid`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=gbk;

--
-- Dumping data for table `pv_urls`
--

/*!40000 ALTER TABLE `pv_urls` DISABLE KEYS */;
INSERT INTO `pv_urls` (`uid`,`vid`,`pid`,`url`,`series`,`server`,`caption`) VALUES 
 (1,1,1,'http://www.tudou.com/playlist/playindex.do?lid=7161893&iid=37952498&cid=22',1,1,''),
 (2,3,10,'upload/php127D.tmpxu.iac',0,0,''),
 (3,4,10,'upload/php2EE2.tmpxu.iac',0,0,''),
 (4,5,10,'upload/php5CAB.tmpxu.iac',0,0,''),
 (7,8,10,'upload/php1B9E.tmpxu.iac',0,0,'');
/*!40000 ALTER TABLE `pv_urls` ENABLE KEYS */;


--
-- Definition of table `pv_usergroups`
--

DROP TABLE IF EXISTS `pv_usergroups`;
CREATE TABLE `pv_usergroups` (
  `gid` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `gptype` enum('default','member','system') NOT NULL DEFAULT 'member',
  `grouptitle` varchar(60) NOT NULL DEFAULT '',
  `groupimg` varchar(15) NOT NULL DEFAULT '',
  `grouppost` int(10) NOT NULL DEFAULT '0',
  `maxmsg` int(10) NOT NULL DEFAULT '10',
  `allowread` tinyint(1) NOT NULL DEFAULT '0',
  `allowrp` tinyint(1) NOT NULL DEFAULT '0',
  `allowhonor` tinyint(1) NOT NULL DEFAULT '0',
  `alloweditatc` tinyint(1) NOT NULL DEFAULT '0',
  `allowdelatc` tinyint(1) NOT NULL DEFAULT '0',
  `allowpost` tinyint(1) NOT NULL DEFAULT '0',
  `allowmessage` tinyint(1) NOT NULL DEFAULT '0',
  `allowplay` tinyint(1) NOT NULL DEFAULT '0',
  `atccheck` tinyint(1) NOT NULL DEFAULT '0',
  `rpcheck` tinyint(1) NOT NULL DEFAULT '0',
  `allowprofile` tinyint(1) NOT NULL DEFAULT '0',
  `allowseticon` tinyint(1) NOT NULL DEFAULT '0',
  `allowupicon` tinyint(1) NOT NULL DEFAULT '0',
  `allowsell` tinyint(1) NOT NULL DEFAULT '0',
  `allowencode` tinyint(1) NOT NULL DEFAULT '0',
  `ifdefault` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `allowadmincp` tinyint(1) NOT NULL DEFAULT '0',
  `allowadminedit` tinyint(1) NOT NULL DEFAULT '0',
  `allowadmindel` tinyint(1) NOT NULL DEFAULT '0',
  `allowadminshow` tinyint(1) NOT NULL DEFAULT '0',
  `allowadminviewhide` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`gid`),
  KEY `gptype` (`gptype`),
  KEY `grouppost` (`grouppost`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=gbk;

--
-- Dumping data for table `pv_usergroups`
--

/*!40000 ALTER TABLE `pv_usergroups` DISABLE KEYS */;
INSERT INTO `pv_usergroups` (`gid`,`gptype`,`grouptitle`,`groupimg`,`grouppost`,`maxmsg`,`allowread`,`allowrp`,`allowhonor`,`alloweditatc`,`allowdelatc`,`allowpost`,`allowmessage`,`allowplay`,`atccheck`,`rpcheck`,`allowprofile`,`allowseticon`,`allowupicon`,`allowsell`,`allowencode`,`ifdefault`,`allowadmincp`,`allowadminedit`,`allowadmindel`,`allowadminshow`,`allowadminviewhide`) VALUES 
 (1,'default','default','6',0,10,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,0,0,0,0,0),
 (2,'default','游客','7',0,0,1,1,0,0,0,0,0,1,1,1,0,0,0,0,0,0,0,0,0,0,0),
 (5,'system','系统管理员','3',0,500,1,1,1,1,1,1,1,1,0,0,1,1,1,1,1,0,1,1,1,1,1),
 (6,'system','未验证会员','8',0,10,1,1,0,1,1,0,1,1,1,1,1,0,0,0,0,0,0,0,0,0,0),
 (7,'member','学前班','9',0,10,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,0,0,0,0,0,0),
 (8,'member','小学生','10',100,30,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,0,0,0,0,0,0),
 (9,'member','初中生','11',200,50,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,0,0,0,0,0,0),
 (10,'member','高中生','12',500,100,1,1,1,1,1,1,1,1,0,0,1,1,1,1,1,0,0,0,0,0,0),
 (11,'member','大学生','13',1000,120,1,1,1,1,1,1,1,1,0,0,1,1,1,1,1,0,0,0,0,0,0),
 (12,'member','硕士研究生','14',2000,150,1,1,1,1,1,1,1,1,0,0,1,1,1,1,1,0,0,0,0,0,0),
 (13,'member','博士研究生','15',5000,200,1,1,1,1,1,1,1,1,0,0,1,1,1,1,1,0,0,0,0,0,0),
 (14,'member','博士后研究生','16',10000,300,1,1,1,1,1,1,1,1,0,0,1,1,1,1,1,0,0,0,0,0,0),
 (3,'system','校级管理员','3',0,500,1,1,1,1,1,1,1,1,0,0,1,1,1,1,1,0,1,1,1,1,1),
 (4,'system','区级管理员','3',0,500,1,1,1,1,1,1,1,1,0,0,1,1,1,1,1,0,1,1,1,1,1);
/*!40000 ALTER TABLE `pv_usergroups` ENABLE KEYS */;


--
-- Definition of table `pv_video`
--

DROP TABLE IF EXISTS `pv_video`;
CREATE TABLE `pv_video` (
  `vid` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `cid` smallint(8) unsigned NOT NULL DEFAULT '0',
  `nid` smallint(8) unsigned NOT NULL DEFAULT '0',
  `author` char(15) NOT NULL DEFAULT '',
  `authorid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `postdate` int(10) unsigned NOT NULL DEFAULT '0',
  `lostdate` int(10) unsigned NOT NULL DEFAULT '0',
  `subject` char(100) NOT NULL DEFAULT '',
  `pic` char(100) NOT NULL DEFAULT '',
  `playactor` char(30) NOT NULL DEFAULT '',
  `director` char(30) NOT NULL DEFAULT '',
  `tag` char(100) NOT NULL DEFAULT '',
  `content` mediumtext NOT NULL,
  `best` tinyint(1) NOT NULL DEFAULT '0',
  `yz` tinyint(1) NOT NULL DEFAULT '1',
  `grade` char(45) NOT NULL,
  `region` varchar(45) DEFAULT NULL,
  `school` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`vid`),
  KEY `bid` (`cid`),
  KEY `nid` (`nid`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=gbk;

--
-- Dumping data for table `pv_video`
--

/*!40000 ALTER TABLE `pv_video` DISABLE KEYS */;
INSERT INTO `pv_video` (`vid`,`cid`,`nid`,`author`,`authorid`,`postdate`,`lostdate`,`subject`,`pic`,`playactor`,`director`,`tag`,`content`,`best`,`yz`,`grade`,`region`,`school`) VALUES 
 (1,6,1,'test',2,1255610735,1255610735,'ADS','','SAD','ASD','S		','ASD',2,1,'','闵行区','第二小学'),
 (2,7,6,'lippman',1,1256028401,1256028401,'asdasdasd','','','aaaa','aa		','aaaa',0,1,'小学二年级','闵行区','第一小学'),
 (3,5,6,'test',2,1256114049,1256114049,'ASD','','','asd','		','AS',0,1,'小学二年级','闵行区','第二小学'),
 (4,5,6,'test',2,1256115328,1256115328,'sad','','','sdf','q		','sad',0,1,'小学一年级','闵行区','第二小学'),
 (5,5,6,'test',2,1256117061,1256537614,'test1','','','','回忆','asd',1,1,'1','闵行区','第一小学'),
 (8,5,6,'lippman',1,1256537640,1256540267,'gggg','','','ggg','新中国成立','ggg',0,1,'小学一年级','闵行区','第一小学');
/*!40000 ALTER TABLE `pv_video` ENABLE KEYS */;


--
-- Definition of table `pv_videodata`
--

DROP TABLE IF EXISTS `pv_videodata`;
CREATE TABLE `pv_videodata` (
  `vid` mediumint(8) unsigned NOT NULL,
  `hits` int(10) unsigned NOT NULL DEFAULT '0',
  `replier` int(10) unsigned NOT NULL DEFAULT '0',
  `sale` char(255) NOT NULL DEFAULT '',
  `need` char(255) NOT NULL DEFAULT '',
  `usernth` int(10) unsigned NOT NULL DEFAULT '0',
  `fraction` int(10) unsigned NOT NULL DEFAULT '0',
  `star` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`vid`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

--
-- Dumping data for table `pv_videodata`
--

/*!40000 ALTER TABLE `pv_videodata` DISABLE KEYS */;
INSERT INTO `pv_videodata` (`vid`,`hits`,`replier`,`sale`,`need`,`usernth`,`fraction`,`star`) VALUES 
 (1,22,1,'','',0,0,0),
 (2,2,0,'','',0,0,0),
 (3,7,0,'','',0,0,0),
 (4,18,0,'','',0,0,0),
 (5,29,0,'','',0,0,0),
 (8,4,0,'','',0,0,0);
/*!40000 ALTER TABLE `pv_videodata` ENABLE KEYS */;




/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
