/*
Navicat MySQL Data Transfer

Source Server         : 192.168.3.100
Source Server Version : 50524
Source Host           : 192.168.3.100:3306
Source Database       : account_db

Target Server Type    : MYSQL
Target Server Version : 50524
File Encoding         : 65001

Date: 2016-04-21 20:48:56
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `tb_account_log`
-- ----------------------------
DROP TABLE IF EXISTS `tb_account_log`;
CREATE TABLE `tb_account_log` (
  `autoid` bigint(64) NOT NULL AUTO_INCREMENT,
  `userlist_userid` bigint(64) NOT NULL COMMENT '操作数据表的管理员ID',
  `event_name` varchar(64) NOT NULL COMMENT '事件名称',
  `content` varchar(512) NOT NULL COMMENT 'json格式的数据内容',
  `uptime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '插入时间',
  PRIMARY KEY (`autoid`)
) ENGINE=InnoDB AUTO_INCREMENT=166 DEFAULT CHARSET=utf8 COMMENT='操作记录日志';

-- ----------------------------
-- Records of tb_account_log
-- ----------------------------

-- ----------------------------
-- Table structure for `tb_credit_history`
-- ----------------------------
DROP TABLE IF EXISTS `tb_credit_history`;
CREATE TABLE `tb_credit_history` (
  `autoid` bigint(64) unsigned NOT NULL AUTO_INCREMENT,
  `credit_info_autoid` bigint(64) NOT NULL COMMENT '对应积分记录表的自动编号',
  `operat_score` int(32) NOT NULL COMMENT '操作的数值',
  `remark` varchar(512) NOT NULL COMMENT '备注信息',
  `uptime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`autoid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='tb_credit_info的操作记录表';

-- ----------------------------
-- Records of tb_credit_history
-- ----------------------------

-- ----------------------------
-- Table structure for `tb_credit_info`
-- ----------------------------
DROP TABLE IF EXISTS `tb_credit_info`;
CREATE TABLE `tb_credit_info` (
  `autoid` bigint(64) unsigned NOT NULL AUTO_INCREMENT,
  `userlist_userid` bigint(64) NOT NULL,
  `score` int(32) NOT NULL DEFAULT '0' COMMENT '积分',
  `product_list_guid` varchar(64) NOT NULL COMMENT '产品唯一编号',
  PRIMARY KEY (`autoid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='这表功能是用来针对使用所有产品的一些活动积分记录';

-- ----------------------------
-- Records of tb_credit_info
-- ----------------------------

-- ----------------------------
-- Table structure for `tb_product_list`
-- ----------------------------
DROP TABLE IF EXISTS `tb_product_list`;
CREATE TABLE `tb_product_list` (
  `guid` varchar(64) NOT NULL COMMENT '产品唯一编号',
  `product_name` varchar(128) NOT NULL,
  `product_remark` varchar(2048) NOT NULL,
  PRIMARY KEY (`guid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='公共产品列表的信息';

-- ----------------------------
-- Records of tb_product_list
-- ----------------------------

-- ----------------------------
-- Table structure for `tb_user_forgot_password`
-- ----------------------------
DROP TABLE IF EXISTS `tb_user_forgot_password`;
CREATE TABLE `tb_user_forgot_password` (
  `userlist_userid` bigint(64) unsigned NOT NULL AUTO_INCREMENT,
  `rand_id` int(11) NOT NULL COMMENT '随机ID,用来匹配修改密码的钥匙',
  `uptime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '提交或更新此记录的操作时间',
  PRIMARY KEY (`userlist_userid`)
) ENGINE=InnoDB AUTO_INCREMENT=12889 DEFAULT CHARSET=utf8 COMMENT='本表用于重置密码使用';

-- ----------------------------
-- Records of tb_user_forgot_password
-- ----------------------------
INSERT INTO `tb_user_forgot_password` VALUES ('12888', '848168', '2014-10-23 00:07:59');

-- ----------------------------
-- Table structure for `tb_user_list`
-- ----------------------------
DROP TABLE IF EXISTS `tb_user_list`;
CREATE TABLE `tb_user_list` (
  `userid` bigint(64) unsigned NOT NULL AUTO_INCREMENT,
  `createtime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '账户创建日期',
  `passwd` varchar(127) NOT NULL COMMENT '密码',
  `nickname` varchar(255) NOT NULL COMMENT '站内交流用的呢称',
  `safe_email` varchar(255) NOT NULL COMMENT '安全邮箱',
  `safe_phone` varchar(64) DEFAULT NULL COMMENT '手机电话号码',
  `is_verify_email` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否验证过邮箱,bool值',
  `is_verify_phone` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否验证过手机号码,bool值',
  `all_disable` tinyint(4) NOT NULL DEFAULT '0' COMMENT ' 禁用全局账号',
  `lastlogin` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `loginip` varchar(64) NOT NULL COMMENT '最后一次登录的IP',
  PRIMARY KEY (`userid`)
) ENGINE=InnoDB AUTO_INCREMENT=18890 DEFAULT CHARSET=utf8 COMMENT='用户账号信息表';

-- ----------------------------
-- Records of tb_user_list
-- ----------------------------
INSERT INTO `tb_user_list` VALUES ('10000', '0000-00-00 00:00:00', 'd9b1d7db4cd6e70935368a1efb10e377', '超级管理员', 'master@cloudkon.com', '10000', '0', '0', '0', '2014-10-23 21:51:54', '');
INSERT INTO `tb_user_list` VALUES ('10025', '0000-00-00 00:00:00', 'd9b1d7db4cd6e70935368a1efb10e377', 'hhaa', '120611961@qq.com', null, '0', '0', '0', '2014-10-28 22:13:42', '200.200.3.2');
INSERT INTO `tb_user_list` VALUES ('12888', '0000-00-00 00:00:00', 'd9b1d7db4cd6e70935368a1efb10e377', '小熊熊', 'sohn@163.com', '10086', '0', '0', '0', '2015-06-03 14:37:39', '127.0.0.1');
INSERT INTO `tb_user_list` VALUES ('18889', '0000-00-00 00:00:00', 'd9b1d7db4cd6e70935368a1efb10e377', '小梅干', 'yudongmei412@163.com', '10086', '0', '0', '0', '2014-10-23 21:51:54', '');

-- ----------------------------
-- Procedure structure for `sp_forgot_get_rand`
-- ----------------------------
DROP PROCEDURE IF EXISTS `sp_forgot_get_rand`;
DELIMITER ;;
CREATE DEFINER=`root`@`%` PROCEDURE `sp_forgot_get_rand`(in _userid bigint)
    COMMENT '忘记密码执行后,申请的随机钥匙\r\n\r\nrandid_\r\n6位随机钥匙'
begin

declare randid_ int;
#产生6位随机数
set randid_=(rand()*1000000)%900000+100000;
if exists(select * from tb_user_forgot_password where userlist_userid=_userid ) then
	#更新密码重置请求
	update tb_user_forgot_password set rand_id=randid_ , uptime=now() where userlist_userid=_userid;
else
	#插入新的重置请求
	insert into tb_user_forgot_password(userlist_userid,rand_id ) values(_userid,randid_ );
end if;

select randid_;

end
;;
DELIMITER ;

-- ----------------------------
-- Procedure structure for `sp_forgot_set_passwd`
-- ----------------------------
DROP PROCEDURE IF EXISTS `sp_forgot_set_passwd`;
DELIMITER ;;
CREATE DEFINER=`root`@`%` PROCEDURE `sp_forgot_set_passwd`(in _uid bigint,in _rid int,in _new_pwd varchar(127),out result_ tinyint)
    COMMENT '忘记密码接口使用的功能\r\n\r\nresult\r\n1成功修改新密码\r\n2随机密码验证失败\r\n3无效账户\r\n'
begin
	if exists(select userid from tb_user_list where userid=_uid ) then
		/*验证随机密码*/
		if exists(select userlist_userid from tb_user_forgot_password where userlist_userid=_uid and rand_id=_rid  ) then
			update tb_user_list set passwd=_new_pwd where userid=_uid;
			set result_ =1;
		else
			/*验证失败*/
			set result_ =2;
		end if;
               /*删除记录*/
	       delete from tb_user_forgot_password where userlist_userid=_uid;
	else
		/*未注册账号*/
		set result_ =3;
	end if;

end
;;
DELIMITER ;

-- ----------------------------
-- Procedure structure for `sp_register`
-- ----------------------------
DROP PROCEDURE IF EXISTS `sp_register`;
DELIMITER ;;
CREATE DEFINER=`root`@`%` PROCEDURE `sp_register`(in _uid bigint,in _pwd varchar(127),in _nick varchar(255),in _email varchar(255), in _ip varchar(60),out ret_ tinyint)
    COMMENT '注册用户使用的储存功能\r\n\r\nret\r\n1=成功注册\r\n2=操作失败\r\n3=用户已经存在\r\n4=邮箱已被使用'
begin

/* 默认操作失败 */
set ret_=2;

if exists( select userid from tb_user_list where userid=_uid ) then
	/* 用户ID重复 */
	set ret_=3;
else

	if exists( select userid from tb_user_list where safe_email=_email ) then
		/*  邮箱重复 */
		set ret_=4;
	else
		insert into tb_user_list( userid,passwd,nickname,safe_email,lastlogin,loginip ) values(_uid,_pwd,_nick,_email,now(),_ip );
		set ret_=1;
		if exists( select free_userid from tb_free_userid where free_userid=_uid ) then
			delete from tb_free_userid where free_userid=_uid;
		end if;
	end if;

end if;

end
;;
DELIMITER ;

-- ----------------------------
-- Procedure structure for `sp_signin_by_email`
-- ----------------------------
DROP PROCEDURE IF EXISTS `sp_signin_by_email`;
DELIMITER ;;
CREATE DEFINER=`root`@`%` PROCEDURE `sp_signin_by_email`(in _email varchar(255), in _pwd varchar(127),in _ip varchar(50),in _client_flag varchar(50))
    COMMENT '用EMAIL登录账户\r\n\r\nresult_\r\n1=登录成功\r\n2=密码错误\r\n3=账号被禁用\r\n4=不存在账号'
begin

declare logmsg varchar(128 );
declare disable tinyint;
declare result_ tinyint;
declare userid_ bigint;

if exists( select *  from tb_user_list where safe_email=_email ) then
    select userid into userid_  from tb_user_list where safe_email=_email and passwd=_pwd;

    if userid_ then
        select all_disable into disable from tb_user_list where userid=userid_;
        if 0=disable then
	   #更新最后登录消息
	    update tb_user_list set lastlogin=now(),loginip=_ip where userid=userid_;
            /* 添加到操作日志*/
            set logmsg=concat( '{"ip":"',_ip,'","cflag":"',_client_flag,'"}' );
            insert into tb_account_log(userlist_userid,event_name,content ) values(userid_,'login',logmsg );
            set result_ =1;
        else
            set result_ =3;
        end if;
    else
            set result_ =2;
    end if;

else
	set result_ =4;
end if;
select result_ , userid_;

end
;;
DELIMITER ;

-- ----------------------------
-- Procedure structure for `sp_update_passwd`
-- ----------------------------
DROP PROCEDURE IF EXISTS `sp_update_passwd`;
DELIMITER ;;
CREATE DEFINER=`root`@`%` PROCEDURE `sp_update_passwd`(in _uid bigint , in _oldpwd varchar(127) , in _newpwd varchar(127) , in _ip varchar(60),in _client_flag varchar(50))
    COMMENT '修改密码\r\n\r\nresult\r\n1=成功\r\n2=修改密码失败'
begin

declare logmsg varchar(128 );
declare result_ tinyint;

if exists(select userid from tb_user_list where userid=_uid and passwd=_oldpwd ) then
	update tb_user_list set passwd=_newpwd where userid=_uid;
	set result_ =1;

	 /* 添加到操作日志*/
        set logmsg=concat( '{"ip":"',_ip,'","cflag":"',_client_flag,'"}' );
	insert into tb_account_log(userlist_userid,event_name,content ) values(_uid,'modifyPwd',logmsg );
else
	set result_ =2;
end if;

select result_;

end
;;
DELIMITER ;

-- ----------------------------
-- Procedure structure for `sp_verify_userid`
-- ----------------------------
DROP PROCEDURE IF EXISTS `sp_verify_userid`;
DELIMITER ;;
CREATE DEFINER=`root`@`%` PROCEDURE `sp_verify_userid`(in _uid bigint,out result_ tinyint)
    COMMENT '验证用户ID是否可以注册,用于自定义用户ID的时候使用\r\n\r\nresult\r\n1可注册\r\n2已经被注册'
begin

if exists(select userid from  tb_user_list where  userid=_uid ) then
	set result_=2;
else
		set result_=1;
end if;

end
;;
DELIMITER ;
