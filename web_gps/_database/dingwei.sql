/*
Navicat MySQL Data Transfer

Source Server         : 192.168.3.100
Source Server Version : 50524
Source Host           : 192.168.3.100:3306
Source Database       : che

Target Server Type    : MYSQL
Target Server Version : 50524
File Encoding         : 65001

Date: 2015-11-24 23:13:17
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `tb_coodr_dev`
-- ----------------------------
DROP TABLE IF EXISTS `tb_coodr_dev`;
CREATE TABLE `tb_coodr_dev` (
  `autoid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `remark` varchar(128) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `user_autoid` bigint(20) NOT NULL,
  `post_coodr_id` varchar(32) CHARACTER SET utf8 NOT NULL,
  `longitude` double NOT NULL DEFAULT '0' COMMENT '火星坐标',
  `latitude` double NOT NULL DEFAULT '0',
  `uptime` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updata_env` tinyint(4) NOT NULL DEFAULT '0' COMMENT '最后一次上传数据的环境,1=2G/3G/4G, 2=WIFI',
  PRIMARY KEY (`autoid`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tb_coodr_dev
-- ----------------------------
INSERT INTO `tb_coodr_dev` VALUES ('17', '于冬梅手机', '2', 'haha123', '113.569956', '22.263265', '0000-00-00 00:00:00', '0');
INSERT INTO `tb_coodr_dev` VALUES ('20', 'fesaer', '2', 'hha21111', '113.568956', '22.563265', '0000-00-00 00:00:00', '0');
INSERT INTO `tb_coodr_dev` VALUES ('22', '哈', '2', 'hha221', '0', '0', '0000-00-00 00:00:00', '0');
INSERT INTO `tb_coodr_dev` VALUES ('23', '', '9', 'hha221', '0', '0', '0000-00-00 00:00:00', '0');
INSERT INTO `tb_coodr_dev` VALUES ('27', 'haha', '10', 'hfdfd', '0', '0', '0000-00-00 00:00:00', '0');
INSERT INTO `tb_coodr_dev` VALUES ('29', 'unkownyes', '10', 'he11', '0', '0', '0000-00-00 00:00:00', '0');
INSERT INTO `tb_coodr_dev` VALUES ('30', 'unkownyes', '10', 'he211', '0', '0', '0000-00-00 00:00:00', '0');
INSERT INTO `tb_coodr_dev` VALUES ('31', 'unkownyes', '10', 'h211', '0', '0', '0000-00-00 00:00:00', '0');
INSERT INTO `tb_coodr_dev` VALUES ('32', 'unkownyes', '10', 'h2121', '0', '0', '0000-00-00 00:00:00', '0');
INSERT INTO `tb_coodr_dev` VALUES ('33', 'unkownyes', '10', 'h21d21', '0', '0', '0000-00-00 00:00:00', '0');

-- ----------------------------
-- Table structure for `tb_coodr_log`
-- ----------------------------
DROP TABLE IF EXISTS `tb_coodr_log`;
CREATE TABLE `tb_coodr_log` (
  `autoid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `post_coodr_id` varchar(20) NOT NULL,
  `longitude` double NOT NULL,
  `latitude` double NOT NULL,
  `uptime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`autoid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tb_coodr_log
-- ----------------------------

-- ----------------------------
-- Table structure for `tb_pay_record`
-- ----------------------------
DROP TABLE IF EXISTS `tb_pay_record`;
CREATE TABLE `tb_pay_record` (
  `autoid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` varchar(128) NOT NULL,
  `money` int(11) NOT NULL DEFAULT '0' COMMENT '单位_分',
  `pay_state` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0-未付款,1-已付款,2-记录已失效',
  PRIMARY KEY (`autoid`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tb_pay_record
-- ----------------------------

-- ----------------------------
-- Table structure for `tb_userlist`
-- ----------------------------
DROP TABLE IF EXISTS `tb_userlist`;
CREATE TABLE `tb_userlist` (
  `autoid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `account` varchar(128) NOT NULL,
  `passwd` varchar(64) NOT NULL,
  `vip_deadline` date NOT NULL COMMENT 'vip最后限期',
  `max_dev` int(11) unsigned zerofill NOT NULL DEFAULT '00000000000',
  `lastlogin` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `loginip` varchar(44) NOT NULL,
  `safe_question` varchar(256) NOT NULL,
  `safe_answer` varchar(256) NOT NULL,
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`autoid`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tb_userlist
-- ----------------------------
INSERT INTO `tb_userlist` VALUES ('2', '11', 'd9b1d7db4cd6e70935368a1efb10e377', '2015-09-04', '00000000005', '2015-11-24 23:11:56', '192.168.2.200', '123', '123', '0000-00-00 00:00:00');
INSERT INTO `tb_userlist` VALUES ('9', 'nnn123', 'd9b1d7db4cd6e70935368a1efb10e377', '0000-00-00', '00000000001', '2015-09-01 23:16:31', '192.168.2.200', '123', '123', '2015-09-01 23:16:10');
INSERT INTO `tb_userlist` VALUES ('10', 'h123', 'd9b1d7db4cd6e70935368a1efb10e377', '0000-00-00', '00000000030', '2015-10-11 22:15:31', '127.0.0.1', '123', '123', '2015-09-01 23:17:59');

-- ----------------------------
-- Procedure structure for `sp_add_newdev`
-- ----------------------------
DROP PROCEDURE IF EXISTS `sp_add_newdev`;
DELIMITER ;;
CREATE DEFINER=`root`@`%` PROCEDURE `sp_add_newdev`(in _post_coodr_id varchar(32),in _remark varchar(128),in _account varchar(128),in _pwd varchar(64))
BEGIN

DECLARE result_ int;
DECLARE max_count int;
DECLARE dingwei_count int;
DECLARE autoid_ bigint;

#判断账号密码
if exists( select *  from tb_userlist where account=_account and passwd=_pwd) then

  #获取是否可以定位数量
  select autoid into autoid_ from tb_userlist where account=_account;
	select max_dev into max_count from tb_userlist where autoid=autoid_;
	select count(*) into dingwei_count from tb_coodr_dev where user_autoid=autoid_;

	IF EXISTS(SELECT *from tb_coodr_dev WHERE user_autoid=autoid_ and post_coodr_id=_post_coodr_id) THEN
		#重复ID			
		set result_=2;
	ELSE
		IF dingwei_count<max_count THEN
			INSERT INTO tb_coodr_dev(user_autoid,post_coodr_id,remark) VALUES(autoid_ ,_post_coodr_id,_remark);
			set result_=1;
		ELSE
      #定位数量不足
			set result_=3;
		END IF;
	END IF;

ELSE
    set result_=4;
end if;

SELECT result_,autoid_;

END
;;
DELIMITER ;

-- ----------------------------
-- Procedure structure for `sp_getdev_info`
-- ----------------------------
DROP PROCEDURE IF EXISTS `sp_getdev_info`;
DELIMITER ;;
CREATE DEFINER=`root`@`%` PROCEDURE `sp_getdev_info`(in _autoid varchar(128))
BEGIN

select account , vip_deadline , max_dev ,
(select count(*) from tb_coodr_dev where user_autoid=ulst.autoid) dev_count
 from tb_userlist ulst where autoid=_autoid;

END
;;
DELIMITER ;

-- ----------------------------
-- Procedure structure for `sp_reg`
-- ----------------------------
DROP PROCEDURE IF EXISTS `sp_reg`;
DELIMITER ;;
CREATE DEFINER=`root`@`%` PROCEDURE `sp_reg`(in _account varchar(128),in _pwd varchar(64),in _question varchar(256),in _answer varchar(256),in _max_dev int)
BEGIN

DECLARE result_ int;

IF EXISTS(SELECT *from tb_userlist WHERE account=_account) THEN
    set result_=2;
ELSE
 
		INSERT INTO tb_userlist(account,passwd,safe_question,safe_answer,max_dev)
             VALUES(_account ,_pwd ,_question ,_answer,_max_dev);
		set result_=1;

END IF;

SELECT result_;

END
;;
DELIMITER ;

-- ----------------------------
-- Procedure structure for `sp_signin`
-- ----------------------------
DROP PROCEDURE IF EXISTS `sp_signin`;
DELIMITER ;;
CREATE DEFINER=`root`@`%` PROCEDURE `sp_signin`(in _account varchar(128), in _pwd varchar(64),in _ip varchar(50))
begin

declare result_ tinyint;
declare autoid_ bigint;
declare vip_deadline_ TIMESTAMP;
declare max_dev_ bigint;

if exists( select *  from tb_userlist where account=_account and passwd=_pwd) then
      #更新最后登录消息
			update tb_userlist set lastlogin=now(),loginip=_ip where account=_account;
			set result_ =1;

select vip_deadline , autoid,result_,max_dev,
(select count(*) from tb_coodr_dev where user_autoid=ulst.autoid) dev_count
 from tb_userlist ulst where account=_account;

else
			set result_ =2;
select result_;

end if;


end
;;
DELIMITER ;

-- ----------------------------
-- Procedure structure for `sp_update_coodr`
-- ----------------------------
DROP PROCEDURE IF EXISTS `sp_update_coodr`;
DELIMITER ;;
CREATE DEFINER=`root`@`%` PROCEDURE `sp_update_coodr`(in _uid bigint, in _post_coodr_id varchar(20),in _longitude double,in _latitude double, in _updata_env tinyint)
BEGIN

declare result_ int;

IF EXISTS(select * from tb_coodr_dev where user_autoid=_uid and post_coodr_id=_post_coodr_id) then
	update tb_coodr_dev set longitude=_longitude,latitude=_latitude,uptime=NOW(),updata_env=_updata_env where user_autoid=_uid and post_coodr_id=_post_coodr_id;
	set result_= 1;
else
	set result_= 2;
END IF;

select result_;

END
;;
DELIMITER ;

-- ----------------------------
-- Procedure structure for `sp_update_passwd`
-- ----------------------------
DROP PROCEDURE IF EXISTS `sp_update_passwd`;
DELIMITER ;;
CREATE DEFINER=`root`@`%` PROCEDURE `sp_update_passwd`(in _aid bigint, in _oldpwd varchar(127) , in _newpwd varchar(127))
begin

declare result_ tinyint;

if exists(select autoid from tb_userlist where autoid=_aid and passwd=_oldpwd ) then
	update tb_userlist set passwd=_newpwd where autoid=_aid ;
	set result_ =1;
else
	set result_ =2;
end if;

select result_;

end
;;
DELIMITER ;
