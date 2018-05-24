/*
Navicat MySQL Data Transfer

Source Server         : yueche_web
Source Server Version : 50553
Source Host           : localhost:3306
Source Database       : yueche

Target Server Type    : MYSQL
Target Server Version : 50553
File Encoding         : 65001

Date: 2017-12-18 17:20:19
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for wp_action
-- ----------------------------
DROP TABLE IF EXISTS `wp_action`;
CREATE TABLE `wp_action` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `name` char(30) NOT NULL DEFAULT '' COMMENT '行为唯一标识',
  `title` char(80) NOT NULL DEFAULT '' COMMENT '行为说明',
  `remark` char(140) NOT NULL DEFAULT '' COMMENT '行为描述',
  `rule` text COMMENT '行为规则',
  `log` text COMMENT '日志规则',
  `type` tinyint(2) unsigned NOT NULL DEFAULT '1' COMMENT '类型',
  `status` tinyint(2) NOT NULL DEFAULT '0' COMMENT '状态',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '修改时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COMMENT='系统行为表';

-- ----------------------------
-- Table structure for wp_action_log
-- ----------------------------
DROP TABLE IF EXISTS `wp_action_log`;
CREATE TABLE `wp_action_log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `action_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '行为id',
  `user_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '执行用户id',
  `action_ip` bigint(20) NOT NULL COMMENT '执行行为者ip',
  `model` varchar(50) NOT NULL DEFAULT '' COMMENT '触发行为的表',
  `record_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '触发行为的数据id',
  `remark` varchar(255) NOT NULL DEFAULT '' COMMENT '日志备注',
  `status` tinyint(2) NOT NULL DEFAULT '1' COMMENT '状态',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '执行行为的时间',
  PRIMARY KEY (`id`),
  KEY `action_ip_ix` (`action_ip`),
  KEY `action_id_ix` (`action_id`),
  KEY `user_id_ix` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=163 DEFAULT CHARSET=utf8 COMMENT='行为日志表';

-- ----------------------------
-- Table structure for wp_addons
-- ----------------------------
DROP TABLE IF EXISTS `wp_addons`;
CREATE TABLE `wp_addons` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `name` varchar(40) NOT NULL COMMENT '插件名或标识',
  `title` varchar(20) NOT NULL DEFAULT '' COMMENT '中文名',
  `description` text COMMENT '插件描述',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态',
  `config` text COMMENT '配置',
  `author` varchar(40) DEFAULT '' COMMENT '作者',
  `version` varchar(20) DEFAULT '' COMMENT '版本号',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '安装时间',
  `has_adminlist` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否有后台列表',
  `type` tinyint(1) DEFAULT '0' COMMENT '插件类型 0 普通插件 1 微信插件 2 易信插件',
  `cate_id` int(11) DEFAULT NULL,
  `is_show` tinyint(2) DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `name` (`name`),
  KEY `sti` (`status`,`is_show`)
) ENGINE=MyISAM AUTO_INCREMENT=168 DEFAULT CHARSET=utf8 COMMENT='微信插件表';

-- ----------------------------
-- Table structure for wp_addon_category
-- ----------------------------
DROP TABLE IF EXISTS `wp_addon_category`;
CREATE TABLE `wp_addon_category` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `icon` int(10) unsigned DEFAULT NULL COMMENT '分类图标',
  `title` varchar(255) DEFAULT NULL COMMENT '分类名',
  `sort` int(10) DEFAULT '0' COMMENT '排序号',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COMMENT='插件分类表';

-- ----------------------------
-- Table structure for wp_analysis
-- ----------------------------
DROP TABLE IF EXISTS `wp_analysis`;
CREATE TABLE `wp_analysis` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `sports_id` int(10) DEFAULT NULL COMMENT 'sports_id',
  `type` varchar(30) DEFAULT NULL COMMENT 'type',
  `time` varchar(50) DEFAULT NULL COMMENT 'time',
  `total_count` int(10) DEFAULT '0' COMMENT 'total_count',
  `follow_count` int(10) DEFAULT '0' COMMENT 'follow_count',
  `aver_count` int(10) DEFAULT '0' COMMENT 'aver_count',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for wp_article_style
-- ----------------------------
DROP TABLE IF EXISTS `wp_article_style`;
CREATE TABLE `wp_article_style` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `group_id` int(10) DEFAULT '0' COMMENT '分组样式',
  `style` text COMMENT '样式内容',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for wp_article_style_group
-- ----------------------------
DROP TABLE IF EXISTS `wp_article_style_group`;
CREATE TABLE `wp_article_style_group` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `group_name` varchar(255) DEFAULT NULL COMMENT '分组名称',
  `desc` text COMMENT '说明',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for wp_ask
-- ----------------------------
DROP TABLE IF EXISTS `wp_ask`;
CREATE TABLE `wp_ask` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `keyword` varchar(100) NOT NULL COMMENT '关键词',
  `keyword_type` tinyint(2) NOT NULL DEFAULT '0' COMMENT '关键词类型',
  `title` varchar(255) NOT NULL COMMENT '标题',
  `intro` text COMMENT '封面简介',
  `mTime` int(10) DEFAULT NULL COMMENT '修改时间',
  `cover` int(10) unsigned DEFAULT NULL COMMENT '封面图片',
  `cTime` int(10) unsigned DEFAULT NULL COMMENT '发布时间',
  `token` varchar(255) DEFAULT NULL COMMENT 'Token',
  `finish_tip` text COMMENT '结束语',
  `content` text COMMENT '活动介绍',
  `shop_address` text COMMENT '商家地址',
  `appids` text COMMENT '提示关注的公众号',
  `finish_button` text COMMENT '成功抢答完后显示的按钮',
  `card_id` varchar(255) DEFAULT NULL COMMENT '卡券ID',
  `appsecre` varchar(255) DEFAULT NULL COMMENT '卡券对应的appsecre',
  `template` varchar(255) DEFAULT 'default' COMMENT '素材模板',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for wp_ask_answer
-- ----------------------------
DROP TABLE IF EXISTS `wp_ask_answer`;
CREATE TABLE `wp_ask_answer` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `answer` text COMMENT '回答内容',
  `openid` varchar(255) DEFAULT NULL COMMENT 'OpenId',
  `uid` int(10) DEFAULT NULL COMMENT '用户UID',
  `question_id` int(10) unsigned NOT NULL COMMENT 'question_id',
  `cTime` int(10) unsigned DEFAULT NULL COMMENT '发布时间',
  `token` varchar(255) DEFAULT NULL COMMENT 'Token',
  `ask_id` int(10) unsigned NOT NULL COMMENT 'ask_id',
  `is_correct` tinyint(2) DEFAULT '1' COMMENT '是否回答正确',
  `times` int(4) DEFAULT '0' COMMENT '次数',
  PRIMARY KEY (`id`),
  KEY `ask_id_uid` (`ask_id`,`uid`),
  KEY `question_uid` (`uid`,`question_id`,`times`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for wp_ask_question
-- ----------------------------
DROP TABLE IF EXISTS `wp_ask_question`;
CREATE TABLE `wp_ask_question` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `title` varchar(255) NOT NULL COMMENT '标题',
  `intro` text COMMENT '问题描述',
  `cTime` int(10) unsigned DEFAULT NULL COMMENT '发布时间',
  `token` varchar(255) DEFAULT NULL COMMENT 'Token',
  `is_must` tinyint(2) DEFAULT '1' COMMENT '是否必填',
  `extra` text NOT NULL COMMENT '参数',
  `type` char(50) NOT NULL DEFAULT 'radio' COMMENT '问题类型',
  `ask_id` int(10) unsigned NOT NULL COMMENT 'ask_id',
  `sort` int(10) unsigned DEFAULT '0' COMMENT '排序号',
  `answer` varchar(255) NOT NULL COMMENT '正确答案',
  `is_last` tinyint(2) DEFAULT '0' COMMENT '是否最后一题',
  `wait_time` int(10) DEFAULT '0' COMMENT '等待时间',
  `percent` int(10) DEFAULT '100' COMMENT '抢中概率',
  `answer_time` int(10) DEFAULT NULL COMMENT '答题时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for wp_attachment
-- ----------------------------
DROP TABLE IF EXISTS `wp_attachment`;
CREATE TABLE `wp_attachment` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(10) DEFAULT '0' COMMENT '用户ID',
  `title` char(30) NOT NULL DEFAULT '' COMMENT '附件显示名',
  `type` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '附件类型',
  `source` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '资源ID',
  `record_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '关联记录ID',
  `download` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '下载次数',
  `size` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '附件大小',
  `dir` int(12) unsigned NOT NULL DEFAULT '0' COMMENT '上级目录ID',
  `sort` int(8) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态',
  PRIMARY KEY (`id`),
  KEY `idx_record_status` (`record_id`,`status`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='附件表';

-- ----------------------------
-- Table structure for wp_attribute
-- ----------------------------
DROP TABLE IF EXISTS `wp_attribute`;
CREATE TABLE `wp_attribute` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL DEFAULT '' COMMENT '字段名',
  `title` varchar(100) NOT NULL DEFAULT '' COMMENT '字段注释',
  `field` varchar(100) NOT NULL DEFAULT '' COMMENT '字段定义',
  `type` varchar(20) NOT NULL DEFAULT '' COMMENT '数据类型',
  `value` varchar(100) NOT NULL DEFAULT '' COMMENT '字段默认值',
  `remark` varchar(100) NOT NULL DEFAULT '' COMMENT '备注',
  `is_show` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '是否显示',
  `extra` text NOT NULL COMMENT '参数',
  `model_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '模型id',
  `model_name` varchar(100) DEFAULT NULL,
  `is_must` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否必填',
  `status` tinyint(2) NOT NULL DEFAULT '0' COMMENT '状态',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `validate_rule` varchar(255) NOT NULL DEFAULT '',
  `validate_time` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `error_info` varchar(100) NOT NULL DEFAULT '',
  `validate_type` varchar(25) NOT NULL DEFAULT '',
  `auto_rule` varchar(100) NOT NULL DEFAULT '',
  `auto_time` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `auto_type` varchar(25) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `model_id` (`model_id`)
) ENGINE=MyISAM AUTO_INCREMENT=11377 DEFAULT CHARSET=utf8 COMMENT='模型属性表';

-- ----------------------------
-- Table structure for wp_auth_extend
-- ----------------------------
DROP TABLE IF EXISTS `wp_auth_extend`;
CREATE TABLE `wp_auth_extend` (
  `group_id` mediumint(10) unsigned NOT NULL COMMENT '用户id',
  `extend_id` mediumint(8) unsigned NOT NULL COMMENT '扩展表中数据的id',
  `type` tinyint(1) unsigned NOT NULL COMMENT '扩展类型标识 1:栏目分类权限;2:模型权限',
  UNIQUE KEY `group_extend_type` (`group_id`,`extend_id`,`type`),
  KEY `uid` (`group_id`),
  KEY `group_id` (`extend_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='用户组与分类的对应关系表';

-- ----------------------------
-- Table structure for wp_auth_group
-- ----------------------------
DROP TABLE IF EXISTS `wp_auth_group`;
CREATE TABLE `wp_auth_group` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `title` varchar(30) DEFAULT NULL COMMENT '分组名称',
  `icon` int(10) unsigned DEFAULT NULL COMMENT '图标',
  `description` text COMMENT '描述信息',
  `status` tinyint(2) DEFAULT '1' COMMENT '状态',
  `type` tinyint(2) DEFAULT '1' COMMENT '类型',
  `rules` text COMMENT '权限',
  `manager_id` int(10) DEFAULT '0' COMMENT '管理员ID',
  `token` varchar(100) DEFAULT NULL COMMENT 'Token',
  `is_default` tinyint(1) DEFAULT '0' COMMENT '是否默认自动加入',
  `qr_code` varchar(255) DEFAULT NULL COMMENT '微信二维码',
  `wechat_group_id` int(10) DEFAULT '-1' COMMENT '微信端的分组ID',
  `wechat_group_name` varchar(100) DEFAULT NULL COMMENT '微信端的分组名',
  `wechat_group_count` int(10) DEFAULT NULL COMMENT '微信端用户数',
  `is_del` tinyint(1) DEFAULT '0' COMMENT '是否已删除',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=171 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for wp_auth_group_access
-- ----------------------------
DROP TABLE IF EXISTS `wp_auth_group_access`;
CREATE TABLE `wp_auth_group_access` (
  `uid` int(10) DEFAULT NULL COMMENT '用户id',
  `group_id` mediumint(8) unsigned NOT NULL COMMENT '用户组id',
  UNIQUE KEY `uid_group_id` (`uid`,`group_id`),
  KEY `uid` (`uid`),
  KEY `group_id` (`group_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for wp_auth_rule
-- ----------------------------
DROP TABLE IF EXISTS `wp_auth_rule`;
CREATE TABLE `wp_auth_rule` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '规则id,自增主键',
  `name` char(80) NOT NULL DEFAULT '' COMMENT '规则唯一英文标识',
  `title` char(100) NOT NULL DEFAULT '' COMMENT '规则中文描述',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否有效(0:无效,1:有效)',
  `condition` varchar(300) NOT NULL DEFAULT '' COMMENT '规则附加条件',
  `group` char(30) DEFAULT '默认分组',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=280 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for wp_auto_reply
-- ----------------------------
DROP TABLE IF EXISTS `wp_auto_reply`;
CREATE TABLE `wp_auto_reply` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `keyword` varchar(255) DEFAULT NULL COMMENT '关键词',
  `msg_type` char(50) DEFAULT 'text' COMMENT '消息类型',
  `content` text COMMENT '文本内容',
  `group_id` int(10) DEFAULT NULL COMMENT '图文',
  `image_id` int(10) unsigned DEFAULT NULL COMMENT '上传图片',
  `manager_id` int(10) DEFAULT NULL COMMENT '管理员ID',
  `token` varchar(50) DEFAULT NULL COMMENT 'Token',
  `image_material` int(10) DEFAULT NULL COMMENT '素材图片id',
  `voice_id` int(10) DEFAULT NULL COMMENT '语音素材id',
  `video_id` int(10) DEFAULT NULL COMMENT '视频素材id',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for wp_business_card
-- ----------------------------
DROP TABLE IF EXISTS `wp_business_card`;
CREATE TABLE `wp_business_card` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `uid` int(10) DEFAULT NULL COMMENT '用户ID',
  `truename` varchar(50) DEFAULT NULL COMMENT '真实姓名',
  `position` varchar(50) DEFAULT NULL COMMENT '职位头衔',
  `mobile` varchar(30) DEFAULT NULL COMMENT '手机',
  `company` varchar(100) DEFAULT NULL COMMENT '公司名称',
  `department` varchar(50) DEFAULT NULL COMMENT '所属部门',
  `service` text COMMENT '产品服务',
  `company_url` varchar(255) DEFAULT NULL COMMENT '公司网址',
  `address` varchar(255) DEFAULT NULL COMMENT '地址',
  `telephone` varchar(30) DEFAULT NULL COMMENT '座机',
  `Email` varchar(100) DEFAULT NULL COMMENT '邮箱',
  `wechat` varchar(50) DEFAULT NULL COMMENT '微信号',
  `qq` varchar(30) DEFAULT NULL COMMENT 'QQ号',
  `weibo` varchar(255) DEFAULT NULL COMMENT '微博',
  `tag` varchar(255) DEFAULT NULL COMMENT '人物标签',
  `wishing` varchar(100) DEFAULT NULL COMMENT '希望结交',
  `interest` varchar(255) DEFAULT NULL COMMENT '兴趣',
  `personal_url` varchar(255) DEFAULT NULL COMMENT '个人主页',
  `intro` text COMMENT '个人介绍',
  `headface` int(10) unsigned DEFAULT NULL COMMENT '头像',
  `permission` char(50) DEFAULT '1' COMMENT '权限设置',
  `template` varchar(50) DEFAULT NULL COMMENT '选择的模板',
  `token` varchar(100) DEFAULT NULL COMMENT 'Token',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for wp_business_card_collect
-- ----------------------------
DROP TABLE IF EXISTS `wp_business_card_collect`;
CREATE TABLE `wp_business_card_collect` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `from_uid` int(10) DEFAULT NULL COMMENT '收藏人ID',
  `to_uid` int(10) DEFAULT NULL COMMENT '被收藏人的ID',
  `cTime` int(10) DEFAULT NULL COMMENT '收藏时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for wp_business_card_column
-- ----------------------------
DROP TABLE IF EXISTS `wp_business_card_column`;
CREATE TABLE `wp_business_card_column` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `type` char(10) DEFAULT '0' COMMENT '栏目类型',
  `cate_id` varchar(100) DEFAULT '0' COMMENT '分类',
  `title` varchar(255) DEFAULT NULL COMMENT '栏目名称',
  `url` varchar(255) DEFAULT NULL COMMENT '跳转url',
  `sort` int(10) DEFAULT '0' COMMENT '排序',
  `business_card_id` int(10) DEFAULT NULL COMMENT '名片id',
  `uid` int(10) DEFAULT NULL COMMENT '用户id',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for wp_buy_log
-- ----------------------------
DROP TABLE IF EXISTS `wp_buy_log`;
CREATE TABLE `wp_buy_log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `pay` float DEFAULT NULL COMMENT '消费金额',
  `sn_id` int(10) DEFAULT NULL COMMENT '优惠卷',
  `pay_type` char(10) DEFAULT NULL COMMENT '支付方式',
  `branch_id` int(10) DEFAULT '0' COMMENT '消费门店',
  `member_id` int(10) DEFAULT NULL COMMENT '会员卡id',
  `cTime` int(10) DEFAULT NULL COMMENT '创建时间',
  `token` varchar(255) DEFAULT NULL COMMENT 'token',
  `manager_id` int(10) DEFAULT NULL COMMENT '管理员ID',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for wp_car
-- ----------------------------
DROP TABLE IF EXISTS `wp_car`;
CREATE TABLE `wp_car` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `xid` int(11) DEFAULT NULL COMMENT '学员id',
  `jid` int(11) DEFAULT NULL COMMENT '教练id',
  `ch` int(11) DEFAULT NULL COMMENT '车号',
  `cph` varchar(10) DEFAULT NULL COMMENT '车牌号',
  `status` varchar(10) DEFAULT NULL COMMENT '车辆状态0:正常 1:故障',
  `mark` varchar(30) DEFAULT NULL COMMENT '备注',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='车辆信息表';

-- ----------------------------
-- Table structure for wp_card_coupons
-- ----------------------------
DROP TABLE IF EXISTS `wp_card_coupons`;
CREATE TABLE `wp_card_coupons` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `give_type` tinyint(2) NOT NULL DEFAULT '0' COMMENT '发放方式',
  `title` varchar(255) NOT NULL COMMENT '优惠券标题',
  `end_date` int(10) DEFAULT NULL COMMENT '结束时间',
  `start_date` int(10) NOT NULL COMMENT '开始时间',
  `content` text NOT NULL COMMENT '使用说明',
  `cTime` int(10) DEFAULT NULL COMMENT '发布时间',
  `token` varchar(100) NOT NULL COMMENT 'Token',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for wp_card_custom
-- ----------------------------
DROP TABLE IF EXISTS `wp_card_custom`;
CREATE TABLE `wp_card_custom` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `manager_id` int(10) DEFAULT NULL COMMENT '管理员ID',
  `token` varchar(50) DEFAULT NULL COMMENT 'Token',
  `cTime` int(10) DEFAULT NULL COMMENT '创建时间',
  `score` int(10) DEFAULT '0' COMMENT '积分数',
  `coupon_id` int(10) DEFAULT NULL COMMENT '商城优惠券',
  `is_show` tinyint(2) DEFAULT '0' COMMENT '是否在会员卡界面展示',
  `start_time` int(10) DEFAULT NULL COMMENT '节日时间',
  `end_time` int(10) DEFAULT NULL COMMENT '赠送时间',
  `title` varchar(100) DEFAULT NULL COMMENT '活动名称',
  `type` tinyint(2) DEFAULT '0' COMMENT '活动策略',
  `content` text COMMENT '活动说明',
  `member` int(10) DEFAULT NULL COMMENT '适用人群',
  `is_birthday` tinyint(2) DEFAULT '0' COMMENT '节日类型',
  `before_day` tinyint(2) DEFAULT '1' COMMENT '生日前',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for wp_card_level
-- ----------------------------
DROP TABLE IF EXISTS `wp_card_level`;
CREATE TABLE `wp_card_level` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `level` varchar(255) DEFAULT NULL COMMENT '会员等级',
  `score` int(10) DEFAULT NULL COMMENT '累计积分',
  `recharge` int(10) DEFAULT NULL COMMENT '累计充值',
  `discount` int(10) DEFAULT NULL COMMENT '折扣率',
  `token` varchar(255) DEFAULT NULL COMMENT 'token',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for wp_card_marketing
-- ----------------------------
DROP TABLE IF EXISTS `wp_card_marketing`;
CREATE TABLE `wp_card_marketing` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `title` varchar(255) DEFAULT NULL COMMENT '活动名称',
  `start_time` int(10) DEFAULT NULL COMMENT '开始时间',
  `end_time` int(10) DEFAULT NULL COMMENT '结束时间',
  `status` tinyint(2) DEFAULT '0' COMMENT '状态',
  `type` char(50) DEFAULT NULL COMMENT '活动类型',
  `give_type` char(10) DEFAULT NULL COMMENT '赠送类型',
  `give` int(10) DEFAULT NULL COMMENT '赠送数据',
  `condition` int(10) DEFAULT NULL COMMENT '赠送条件',
  `branch_id` int(10) DEFAULT NULL COMMENT '充值门店',
  `grade` int(10) DEFAULT NULL COMMENT '适用人群',
  `exchange_count` int(10) DEFAULT NULL COMMENT '兑换次数',
  `open_give_rule` tinyint(2) DEFAULT '0' COMMENT '启用赠送规则',
  `enjoy_power` tinyint(2) DEFAULT '0' COMMENT '消费享受权限',
  `token` varchar(255) DEFAULT NULL COMMENT 'token',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for wp_card_member
-- ----------------------------
DROP TABLE IF EXISTS `wp_card_member`;
CREATE TABLE `wp_card_member` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `number` varchar(50) DEFAULT NULL COMMENT '卡号',
  `cTime` int(10) DEFAULT NULL COMMENT '加入时间',
  `phone` varchar(30) DEFAULT NULL COMMENT '手机号',
  `username` varchar(100) DEFAULT NULL COMMENT '姓名',
  `uid` int(10) NOT NULL COMMENT '用户UID',
  `token` varchar(100) NOT NULL COMMENT 'Token',
  `recharge` int(10) DEFAULT '0' COMMENT '余额',
  `status` tinyint(2) DEFAULT '1' COMMENT '会员状态',
  `birthday` int(10) DEFAULT NULL COMMENT '生日',
  `address` varchar(255) DEFAULT NULL COMMENT '地址',
  `level` int(10) DEFAULT '0' COMMENT '会员卡等级',
  `sex` int(10) DEFAULT NULL COMMENT '性别',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for wp_card_notice
-- ----------------------------
DROP TABLE IF EXISTS `wp_card_notice`;
CREATE TABLE `wp_card_notice` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `cTime` int(10) DEFAULT NULL COMMENT '发布时间',
  `content` text NOT NULL COMMENT '通知内容',
  `title` varchar(255) NOT NULL COMMENT '标题',
  `token` varchar(100) NOT NULL COMMENT 'Token',
  `img` int(10) unsigned DEFAULT NULL COMMENT '通知图片',
  `grade` varchar(100) DEFAULT '0' COMMENT '适用人群',
  `to_uid` int(10) DEFAULT '0' COMMENT '指定用户',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for wp_card_privilege
-- ----------------------------
DROP TABLE IF EXISTS `wp_card_privilege`;
CREATE TABLE `wp_card_privilege` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `title` varchar(255) DEFAULT NULL COMMENT '特权标题',
  `grade` varchar(100) DEFAULT NULL COMMENT '适用人群',
  `start_time` int(10) DEFAULT NULL COMMENT '开始时间',
  `end_time` int(10) DEFAULT NULL COMMENT '结束时间',
  `intro` text COMMENT '使用说明',
  `token` varchar(255) DEFAULT NULL COMMENT 'token',
  `enable` tinyint(2) DEFAULT '1' COMMENT '是否启用',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for wp_card_recharge
-- ----------------------------
DROP TABLE IF EXISTS `wp_card_recharge`;
CREATE TABLE `wp_card_recharge` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `manager_id` int(10) DEFAULT NULL COMMENT '管理员ID',
  `token` varchar(50) DEFAULT NULL COMMENT 'Token',
  `cTime` int(10) DEFAULT NULL COMMENT '创建时间',
  `goods_ids` text COMMENT '指定商品ID串',
  `is_all_goods` tinyint(2) DEFAULT '0' COMMENT '适用的活动商品',
  `is_mult` tinyint(2) DEFAULT '0' COMMENT '多级优惠',
  `start_time` int(10) DEFAULT NULL COMMENT '开始时间',
  `end_time` int(10) DEFAULT NULL COMMENT '过期时间',
  `title` varchar(100) DEFAULT NULL COMMENT '活动名称',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for wp_card_recharge_condition
-- ----------------------------
DROP TABLE IF EXISTS `wp_card_recharge_condition`;
CREATE TABLE `wp_card_recharge_condition` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `money_param` decimal(11,2) DEFAULT NULL COMMENT '现金参数',
  `money` tinyint(2) DEFAULT NULL COMMENT '现在开关',
  `reward_id` int(10) DEFAULT NULL COMMENT '活动ID',
  `sort` int(10) DEFAULT '0' COMMENT '排序号',
  `condition` decimal(11,2) DEFAULT NULL COMMENT '条件',
  `score` tinyint(2) DEFAULT '0' COMMENT '积分开关',
  `score_param` int(10) DEFAULT NULL COMMENT '积分参数',
  `shop_coupon` tinyint(2) DEFAULT '0' COMMENT '优惠券开关',
  `shop_coupon_param` int(10) DEFAULT NULL COMMENT '优惠券ID',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for wp_card_reward
-- ----------------------------
DROP TABLE IF EXISTS `wp_card_reward`;
CREATE TABLE `wp_card_reward` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `manager_id` int(10) DEFAULT NULL COMMENT '管理员ID',
  `token` varchar(50) DEFAULT NULL COMMENT 'Token',
  `cTime` int(10) DEFAULT NULL COMMENT '创建时间',
  `start_time` int(10) DEFAULT NULL COMMENT '开始时间',
  `end_time` int(10) DEFAULT NULL COMMENT '过期时间',
  `title` varchar(100) DEFAULT NULL COMMENT '活动名称',
  `type` tinyint(2) DEFAULT '0' COMMENT '活动策略',
  `score` int(10) DEFAULT '0' COMMENT '积分数',
  `coupon_id` int(10) DEFAULT NULL COMMENT '商城优惠券',
  `is_show` tinyint(2) DEFAULT '0' COMMENT '是否在用户领卡界面展示',
  `content` text COMMENT '活动说明',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for wp_card_score
-- ----------------------------
DROP TABLE IF EXISTS `wp_card_score`;
CREATE TABLE `wp_card_score` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `manager_id` int(10) DEFAULT NULL COMMENT '管理员ID',
  `token` varchar(50) DEFAULT NULL COMMENT 'Token',
  `cTime` int(10) DEFAULT NULL COMMENT '创建时间',
  `num_limit` int(10) DEFAULT '0' COMMENT '兑换次数限制',
  `coupon_id` int(10) DEFAULT NULL COMMENT '商城优惠券',
  `score_limit` int(10) DEFAULT '0' COMMENT '所需积分',
  `start_time` int(10) DEFAULT NULL COMMENT '开始时间',
  `end_time` int(10) DEFAULT NULL COMMENT '过期时间',
  `title` varchar(100) DEFAULT NULL COMMENT '活动名称',
  `member` varchar(100) DEFAULT '0' COMMENT '适用人群',
  `coupon_type` int(10) DEFAULT '0' COMMENT '优惠券类型',
  `cover_id` int(10) unsigned DEFAULT NULL COMMENT '活动图片',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for wp_card_vouchers
-- ----------------------------
DROP TABLE IF EXISTS `wp_card_vouchers`;
CREATE TABLE `wp_card_vouchers` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `content` text COMMENT '活动介绍',
  `code` text COMMENT '卡券code码',
  `appsecre` varchar(255) DEFAULT NULL COMMENT '开通卡券的商家公众号密钥',
  `openid` text COMMENT 'OpenID',
  `card_id` varchar(100) NOT NULL COMMENT '卡券ID',
  `balance` varchar(30) DEFAULT NULL COMMENT '红包余额',
  `cover` int(10) unsigned DEFAULT NULL COMMENT '素材封面',
  `background` int(10) unsigned DEFAULT NULL COMMENT '背景图',
  `title` varchar(255) DEFAULT '卡券' COMMENT '卡券标题',
  `button_color` varchar(255) DEFAULT '#0dbd02' COMMENT '领取按钮颜色',
  `head_bg_color` varchar(255) DEFAULT '#35a2dd' COMMENT '头部背景颜色',
  `shop_logo` int(10) unsigned DEFAULT NULL COMMENT '商家LOGO',
  `shop_name` varchar(255) DEFAULT NULL COMMENT '商家名称',
  `more_button` text COMMENT '添加更多按钮',
  `template` varchar(255) DEFAULT 'default' COMMENT '素材模板',
  `uid` int(10) DEFAULT NULL COMMENT 'uid',
  `token` varchar(50) DEFAULT NULL COMMENT 'token',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for wp_channel
-- ----------------------------
DROP TABLE IF EXISTS `wp_channel`;
CREATE TABLE `wp_channel` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '频道ID',
  `pid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '上级频道ID',
  `title` char(30) NOT NULL COMMENT '频道标题',
  `url` char(100) NOT NULL COMMENT '频道连接',
  `sort` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '导航排序',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '状态',
  `target` tinyint(2) unsigned NOT NULL DEFAULT '0' COMMENT '新窗口打开',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for wp_check_record
-- ----------------------------
DROP TABLE IF EXISTS `wp_check_record`;
CREATE TABLE `wp_check_record` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '审核记录id',
  `wx_num` varchar(100) DEFAULT NULL COMMENT '审核人微信号',
  `wx_name` varchar(100) DEFAULT NULL COMMENT '审核人姓名',
  `wx_category` int(10) unsigned DEFAULT NULL COMMENT '审核类别',
  `wx_category_id` int(10) unsigned DEFAULT NULL COMMENT '审核素材文章id',
  `title` varchar(100) DEFAULT NULL COMMENT '审核标题',
  `wx_time` varchar(100) DEFAULT NULL COMMENT '审核时间',
  `content` varchar(100) DEFAULT NULL COMMENT '备注(不通过理由)',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=355 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for wp_city
-- ----------------------------
DROP TABLE IF EXISTS `wp_city`;
CREATE TABLE `wp_city` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `city` varchar(30) NOT NULL,
  `manager_uids` text,
  `cTime` int(11) DEFAULT NULL,
  `logo` int(11) DEFAULT NULL COMMENT '城市分站LOGO',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for wp_comment
-- ----------------------------
DROP TABLE IF EXISTS `wp_comment`;
CREATE TABLE `wp_comment` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `aim_table` varchar(30) DEFAULT NULL COMMENT '评论关联数据表',
  `aim_id` int(10) DEFAULT NULL COMMENT '评论关联ID',
  `cTime` varchar(30) DEFAULT NULL COMMENT '评论时间',
  `follow_id` int(10) DEFAULT NULL COMMENT 'follow_id',
  `content` text COMMENT '评论内容',
  `is_audit` tinyint(2) DEFAULT '0' COMMENT '是否审核',
  `uid` int(10) DEFAULT NULL COMMENT '文章id',
  `wx_num` varchar(30) DEFAULT NULL COMMENT '评论人微信号',
  `wx_name` varchar(30) DEFAULT NULL COMMENT '评论人姓名',
  `wx_tou` varchar(255) DEFAULT NULL COMMENT '评论人头像',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for wp_common_category
-- ----------------------------
DROP TABLE IF EXISTS `wp_common_category`;
CREATE TABLE `wp_common_category` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `name` varchar(255) DEFAULT NULL COMMENT '分类标识',
  `title` varchar(255) NOT NULL COMMENT '分类标题',
  `icon` int(10) unsigned DEFAULT NULL COMMENT '分类图标',
  `pid` int(10) unsigned DEFAULT '0' COMMENT '上一级分类',
  `path` varchar(255) DEFAULT NULL COMMENT '分类路径',
  `module` varchar(255) DEFAULT NULL COMMENT '分类所属功能',
  `sort` int(10) unsigned DEFAULT '0' COMMENT '排序号',
  `is_show` tinyint(2) DEFAULT '1' COMMENT '是否显示',
  `intro` varchar(255) DEFAULT NULL COMMENT '分类描述',
  `token` varchar(255) DEFAULT NULL COMMENT 'Token',
  `code` varchar(255) DEFAULT NULL COMMENT '分类扩展编号',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for wp_common_category_group
-- ----------------------------
DROP TABLE IF EXISTS `wp_common_category_group`;
CREATE TABLE `wp_common_category_group` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `name` varchar(100) NOT NULL COMMENT '分组标识',
  `title` varchar(255) NOT NULL COMMENT '分组标题',
  `cTime` int(10) unsigned DEFAULT NULL COMMENT '发布时间',
  `token` varchar(100) DEFAULT NULL COMMENT 'Token',
  `level` tinyint(1) unsigned DEFAULT '3' COMMENT '最多级数',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for wp_config
-- ----------------------------
DROP TABLE IF EXISTS `wp_config`;
CREATE TABLE `wp_config` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '配置ID',
  `name` varchar(30) NOT NULL DEFAULT '' COMMENT '配置名称',
  `type` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '配置类型',
  `title` varchar(50) NOT NULL DEFAULT '' COMMENT '配置说明',
  `group` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '配置分组',
  `extra` varchar(255) NOT NULL DEFAULT '' COMMENT '配置值',
  `remark` varchar(100) NOT NULL COMMENT '配置说明',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '状态',
  `value` text NOT NULL COMMENT '配置值',
  `sort` smallint(3) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_name` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=67 DEFAULT CHARSET=utf8 COMMENT='系统配置表';

-- ----------------------------
-- Table structure for wp_coupon
-- ----------------------------
DROP TABLE IF EXISTS `wp_coupon`;
CREATE TABLE `wp_coupon` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `background` int(10) unsigned DEFAULT NULL COMMENT '素材背景图',
  `keyword` varchar(100) DEFAULT NULL COMMENT '关键词',
  `use_tips` text COMMENT '使用说明',
  `title` varchar(255) NOT NULL COMMENT '标题',
  `intro` text COMMENT '封面简介',
  `end_time` int(10) DEFAULT NULL COMMENT '领取结束时间',
  `cover` int(10) unsigned DEFAULT NULL COMMENT '优惠券图片',
  `cTime` int(10) unsigned DEFAULT NULL COMMENT '发布时间',
  `token` varchar(255) DEFAULT NULL COMMENT 'Token',
  `start_time` int(10) DEFAULT NULL COMMENT '开始时间',
  `end_tips` text COMMENT '领取结束说明',
  `end_img` int(10) unsigned DEFAULT NULL COMMENT '领取结束提示图片',
  `num` int(10) unsigned DEFAULT '0' COMMENT '优惠券数量',
  `max_num` int(10) unsigned DEFAULT '1' COMMENT '每人最多允许获取次数',
  `follower_condtion` char(50) DEFAULT '1' COMMENT '粉丝状态',
  `credit_conditon` int(10) unsigned DEFAULT '0' COMMENT '积分限制',
  `credit_bug` int(10) unsigned DEFAULT '0' COMMENT '积分消费',
  `addon_condition` varchar(255) DEFAULT NULL COMMENT '插件场景限制',
  `collect_count` int(10) unsigned DEFAULT '0' COMMENT '已领取数',
  `view_count` int(10) unsigned DEFAULT '0' COMMENT '浏览人数',
  `addon` char(50) DEFAULT 'public' COMMENT '插件',
  `shop_uid` varchar(255) DEFAULT NULL COMMENT '商家管理员ID',
  `use_count` int(10) DEFAULT '0' COMMENT '已使用数',
  `pay_password` varchar(255) DEFAULT NULL COMMENT '核销密码',
  `empty_prize_tips` varchar(255) DEFAULT NULL COMMENT '奖品抽完后的提示',
  `start_tips` varchar(255) DEFAULT NULL COMMENT '活动还没开始时的提示语',
  `more_button` text COMMENT '其它按钮',
  `over_time` int(10) DEFAULT NULL COMMENT '使用的截止时间',
  `use_start_time` int(10) DEFAULT NULL COMMENT '使用开始时间',
  `shop_name` varchar(255) DEFAULT '优惠商家' COMMENT '商家名称',
  `shop_logo` int(10) unsigned DEFAULT NULL COMMENT '商家LOGO',
  `head_bg_color` varchar(255) DEFAULT '#35a2dd' COMMENT '头部背景颜色',
  `button_color` varchar(255) DEFAULT '#0dbd02' COMMENT '按钮颜色',
  `template` varchar(255) DEFAULT 'default' COMMENT '素材模板',
  `member` varchar(100) DEFAULT '0' COMMENT '选择人群',
  `is_del` int(10) DEFAULT '0' COMMENT '是否删除',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for wp_coupon_shop
-- ----------------------------
DROP TABLE IF EXISTS `wp_coupon_shop`;
CREATE TABLE `wp_coupon_shop` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `name` varchar(100) DEFAULT NULL COMMENT '店名',
  `address` varchar(255) DEFAULT NULL COMMENT '详细地址',
  `phone` varchar(30) DEFAULT NULL COMMENT '联系电话',
  `gps` varchar(50) DEFAULT NULL COMMENT 'GPS经纬度',
  `coupon_id` int(10) DEFAULT NULL COMMENT '所属优惠券编号',
  `token` varchar(255) DEFAULT NULL COMMENT 'token',
  `manager_id` int(10) DEFAULT NULL COMMENT '管理员id',
  `open_time` varchar(50) DEFAULT NULL COMMENT '营业时间',
  `img` int(10) unsigned DEFAULT NULL COMMENT '门店展示图',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for wp_coupon_shop_link
-- ----------------------------
DROP TABLE IF EXISTS `wp_coupon_shop_link`;
CREATE TABLE `wp_coupon_shop_link` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `coupon_id` int(10) DEFAULT NULL COMMENT 'coupon_id',
  `shop_id` int(10) DEFAULT NULL COMMENT 'shop_id',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for wp_credit_config
-- ----------------------------
DROP TABLE IF EXISTS `wp_credit_config`;
CREATE TABLE `wp_credit_config` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `title` varchar(255) NOT NULL COMMENT '积分描述',
  `name` varchar(50) DEFAULT NULL COMMENT '积分标识',
  `mTime` int(10) DEFAULT NULL COMMENT '修改时间',
  `experience` varchar(30) DEFAULT '0' COMMENT '经验值',
  `score` varchar(30) DEFAULT '0' COMMENT '金币值',
  `token` varchar(255) DEFAULT '0' COMMENT 'Token',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=45 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for wp_credit_data
-- ----------------------------
DROP TABLE IF EXISTS `wp_credit_data`;
CREATE TABLE `wp_credit_data` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `uid` int(10) DEFAULT '0' COMMENT '用户ID',
  `credit_name` varchar(50) DEFAULT NULL COMMENT '积分标识',
  `experience` int(10) DEFAULT '0' COMMENT '体力值',
  `score` int(10) DEFAULT '0' COMMENT '积分值',
  `cTime` int(10) DEFAULT NULL COMMENT '记录时间',
  `admin_uid` int(10) DEFAULT '0' COMMENT '操作者UID',
  `token` varchar(255) DEFAULT NULL COMMENT 'Token',
  `credit_title` varchar(50) DEFAULT NULL COMMENT '积分标题',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=37822 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for wp_customer
-- ----------------------------
DROP TABLE IF EXISTS `wp_customer`;
CREATE TABLE `wp_customer` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `userid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `name` varchar(50) DEFAULT '',
  `sex` varchar(4) DEFAULT '',
  `mobile` varchar(200) DEFAULT '',
  `tel` varchar(200) DEFAULT '',
  `email` varchar(200) DEFAULT '',
  `company` varchar(100) DEFAULT '',
  `job` varchar(20) DEFAULT '',
  `address` varchar(120) DEFAULT '',
  `website` varchar(200) DEFAULT '',
  `qq` varchar(16) DEFAULT '',
  `weixin` varchar(50) DEFAULT '',
  `yixin` varchar(50) DEFAULT '',
  `weibo` varchar(50) DEFAULT '',
  `laiwang` varchar(50) DEFAULT '',
  `remark` varchar(255) DEFAULT '',
  `origin` bigint(20) unsigned NOT NULL DEFAULT '0',
  `originName` varchar(50) NOT NULL DEFAULT '',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `createUser` varchar(32) NOT NULL DEFAULT '',
  `createTime` int(10) unsigned NOT NULL DEFAULT '0',
  `groupId` varchar(20) NOT NULL DEFAULT '',
  `groupName` varchar(200) DEFAULT '',
  `group` varchar(50) DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for wp_custom_menu
-- ----------------------------
DROP TABLE IF EXISTS `wp_custom_menu`;
CREATE TABLE `wp_custom_menu` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `url` varchar(255) DEFAULT NULL COMMENT '关联URL',
  `keyword` varchar(100) DEFAULT NULL COMMENT '关联关键词',
  `title` varchar(50) NOT NULL COMMENT '菜单名',
  `pid` int(10) DEFAULT '0' COMMENT '一级菜单',
  `sort` tinyint(4) DEFAULT '0' COMMENT '排序号',
  `token` varchar(255) DEFAULT NULL COMMENT 'Token',
  `type` varchar(30) DEFAULT 'click' COMMENT '类型',
  `from_type` char(50) DEFAULT '-1' COMMENT '配置动作',
  `addon` char(30) DEFAULT '0' COMMENT '选择插件',
  `target_id` int(10) DEFAULT NULL COMMENT '选择内容',
  `sucai_type` varchar(50) DEFAULT NULL COMMENT '素材类型',
  `jump_type` int(10) DEFAULT '0' COMMENT '推送类型',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=27 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for wp_custom_reply_mult
-- ----------------------------
DROP TABLE IF EXISTS `wp_custom_reply_mult`;
CREATE TABLE `wp_custom_reply_mult` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `keyword` varchar(255) DEFAULT NULL COMMENT '关键词',
  `keyword_type` tinyint(2) DEFAULT '0' COMMENT '关键词类型',
  `mult_ids` varchar(255) DEFAULT NULL COMMENT '多图文ID',
  `token` varchar(255) DEFAULT NULL COMMENT 'Token',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for wp_custom_reply_news
-- ----------------------------
DROP TABLE IF EXISTS `wp_custom_reply_news`;
CREATE TABLE `wp_custom_reply_news` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `keyword` varchar(100) NOT NULL COMMENT '关键词',
  `keyword_type` tinyint(2) DEFAULT NULL COMMENT '关键词类型',
  `title` varchar(255) NOT NULL COMMENT '标题',
  `intro` text COMMENT '简介',
  `cate_id` int(10) unsigned DEFAULT '0' COMMENT '所属类别',
  `cover` int(10) unsigned DEFAULT NULL COMMENT '封面图片',
  `content` text COMMENT '内容',
  `cTime` int(10) DEFAULT NULL COMMENT '发布时间',
  `sort` int(10) unsigned DEFAULT '0' COMMENT '排序号',
  `view_count` int(10) unsigned DEFAULT '0' COMMENT '浏览数',
  `token` varchar(255) DEFAULT NULL COMMENT 'Token',
  `jump_url` varchar(255) DEFAULT NULL COMMENT '外链',
  `author` varchar(50) DEFAULT NULL COMMENT '作者',
  `show_type` int(10) unsigned DEFAULT '0' COMMENT '显示方式',
  `is_show` char(10) DEFAULT '1' COMMENT '图片是否显示在内容页',
  `add_time` varchar(100) DEFAULT NULL COMMENT '添加时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=136 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for wp_custom_reply_text
-- ----------------------------
DROP TABLE IF EXISTS `wp_custom_reply_text`;
CREATE TABLE `wp_custom_reply_text` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `keyword` varchar(255) DEFAULT NULL COMMENT '关键词',
  `keyword_type` tinyint(2) DEFAULT '0' COMMENT '关键词类型',
  `content` text COMMENT '回复内容',
  `view_count` int(10) unsigned DEFAULT '0' COMMENT '浏览数',
  `sort` int(10) unsigned DEFAULT '0' COMMENT '排序号',
  `token` varchar(255) DEFAULT NULL COMMENT 'Token',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for wp_custom_sendall
-- ----------------------------
DROP TABLE IF EXISTS `wp_custom_sendall`;
CREATE TABLE `wp_custom_sendall` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `ToUserName` varchar(255) DEFAULT NULL COMMENT 'token',
  `FromUserName` varchar(255) DEFAULT NULL COMMENT 'openid',
  `cTime` int(10) DEFAULT NULL COMMENT '创建时间',
  `msgType` varchar(255) DEFAULT NULL COMMENT '消息类型',
  `manager_id` int(10) DEFAULT NULL COMMENT '管理员id',
  `content` text COMMENT '内容',
  `media_id` varchar(255) DEFAULT NULL COMMENT '多媒体文件id',
  `is_send` int(10) DEFAULT NULL COMMENT '是否已经发送',
  `uid` int(10) DEFAULT NULL COMMENT '粉丝uid',
  `news_group_id` varchar(10) DEFAULT NULL COMMENT '图文组id',
  `video_title` varchar(255) DEFAULT NULL COMMENT '视频标题',
  `video_description` text COMMENT '视频描述',
  `video_thumb` varchar(255) DEFAULT NULL COMMENT '视频缩略图',
  `voice_id` int(10) DEFAULT NULL COMMENT '语音id',
  `image_id` int(10) DEFAULT NULL COMMENT '图片id',
  `video_id` int(10) DEFAULT NULL COMMENT '视频id',
  `send_type` int(10) DEFAULT NULL COMMENT '发送方式',
  `send_opends` text COMMENT '指定用户',
  `group_id` int(10) DEFAULT NULL COMMENT '分组id',
  `diff` int(10) DEFAULT '0' COMMENT '区分消息标识',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for wp_dingdan
-- ----------------------------
DROP TABLE IF EXISTS `wp_dingdan`;
CREATE TABLE `wp_dingdan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT NULL,
  `xid` int(11) DEFAULT NULL COMMENT '学员id',
  `jxid` int(11) DEFAULT NULL COMMENT '驾校id',
  `jid` int(11) DEFAULT NULL COMMENT '教练id',
  `pch` varchar(50) DEFAULT NULL COMMENT '车号',
  `pdata` varchar(50) DEFAULT NULL COMMENT '日期',
  `ptime` text COMMENT '时间段',
  `pid` varchar(255) DEFAULT NULL COMMENT '时间段id',
  `tuan` varchar(255) DEFAULT NULL,
  `dbh` varchar(30) DEFAULT NULL COMMENT '订单编号',
  `km` varchar(15) DEFAULT NULL COMMENT '科目',
  `shouxu` varchar(255) DEFAULT NULL COMMENT '手续费',
  `koufei` varchar(255) DEFAULT NULL COMMENT '退款扣除手续费',
  `num` varchar(255) DEFAULT NULL,
  `money` varchar(15) DEFAULT NULL COMMENT '缴费金额',
  `fs` varchar(20) DEFAULT NULL COMMENT '1微信  2线下',
  `status` varchar(20) DEFAULT NULL COMMENT '订单状态0:交易成功1:已退款 2:已消费3:退款中',
  `mark` varchar(30) DEFAULT NULL COMMENT '备注',
  `mch_id` varchar(255) DEFAULT NULL COMMENT '商户号',
  `transaction_id` varchar(255) DEFAULT NULL COMMENT '微信支付订单号',
  `out_trade_no` varchar(255) DEFAULT NULL COMMENT '商户系统的订单号',
  `refund_fee` varchar(255) DEFAULT NULL COMMENT '退款金额',
  `time_end` varchar(50) DEFAULT NULL COMMENT '支付完成时间',
  `daddtime` varchar(50) DEFAULT NULL COMMENT '添加时间',
  `shuoming` text COMMENT '退款说明',
  `xian` varchar(10) DEFAULT NULL COMMENT '线上1 线下2',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11714 DEFAULT CHARSET=utf8 COMMENT='订单信息表';

-- ----------------------------
-- Table structure for wp_dingdan1
-- ----------------------------
DROP TABLE IF EXISTS `wp_dingdan1`;
CREATE TABLE `wp_dingdan1` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT NULL,
  `xid` int(11) DEFAULT NULL COMMENT '学员id',
  `jxid` int(11) DEFAULT NULL COMMENT '驾校id',
  `jid` int(11) DEFAULT NULL COMMENT '教练id',
  `pch` varchar(50) DEFAULT NULL COMMENT '车号',
  `pdata` varchar(50) DEFAULT NULL COMMENT '日期',
  `ptime` text COMMENT '时间段',
  `pid` varchar(255) DEFAULT NULL COMMENT '时间段id',
  `tuan` varchar(255) DEFAULT NULL,
  `dbh` varchar(30) DEFAULT NULL COMMENT '订单编号',
  `km` varchar(15) DEFAULT NULL COMMENT '科目',
  `shouxu` varchar(255) DEFAULT NULL COMMENT '手续费',
  `koufei` varchar(255) DEFAULT NULL COMMENT '退款扣除手续费',
  `num` varchar(255) DEFAULT NULL,
  `money` varchar(15) DEFAULT NULL COMMENT '缴费金额',
  `fs` varchar(20) DEFAULT NULL COMMENT '1微信  2线下',
  `status` varchar(20) DEFAULT NULL COMMENT '订单状态0:交易成功1:已退款 2:已消费3:退款中',
  `mark` varchar(30) DEFAULT NULL COMMENT '备注',
  `mch_id` varchar(255) DEFAULT NULL COMMENT '商户号',
  `transaction_id` varchar(255) DEFAULT NULL COMMENT '微信支付订单号',
  `out_trade_no` varchar(255) DEFAULT NULL COMMENT '商户系统的订单号',
  `refund_fee` varchar(255) DEFAULT NULL COMMENT '退款金额',
  `time_end` varchar(50) DEFAULT NULL COMMENT '支付完成时间',
  `daddtime` varchar(50) DEFAULT NULL COMMENT '添加时间',
  `shuoming` text COMMENT '退款说明',
  `xian` varchar(10) DEFAULT NULL COMMENT '线上1 线下2',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=242 DEFAULT CHARSET=utf8 COMMENT='订单信息表';

-- ----------------------------
-- Table structure for wp_dingdan_2017-12-08_1635
-- ----------------------------
DROP TABLE IF EXISTS `wp_dingdan_2017-12-08_1635`;
CREATE TABLE `wp_dingdan_2017-12-08_1635` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT NULL,
  `xid` int(11) DEFAULT NULL COMMENT '学员id',
  `jxid` int(11) DEFAULT NULL COMMENT '驾校id',
  `jid` int(11) DEFAULT NULL COMMENT '教练id',
  `pch` varchar(50) DEFAULT NULL COMMENT '车号',
  `pdata` varchar(50) DEFAULT NULL COMMENT '日期',
  `ptime` text COMMENT '时间段',
  `pid` varchar(255) DEFAULT NULL COMMENT '时间段id',
  `tuan` varchar(255) DEFAULT NULL,
  `dbh` varchar(30) DEFAULT NULL COMMENT '订单编号',
  `km` varchar(15) DEFAULT NULL COMMENT '科目',
  `shouxu` varchar(255) DEFAULT NULL COMMENT '手续费',
  `koufei` varchar(255) DEFAULT NULL COMMENT '退款扣除手续费',
  `num` varchar(255) DEFAULT NULL,
  `money` varchar(15) DEFAULT NULL COMMENT '缴费金额',
  `fs` varchar(20) DEFAULT NULL COMMENT '1微信  2线下',
  `status` varchar(20) DEFAULT NULL COMMENT '订单状态0:交易成功1:已退款 2:已消费3:退款中',
  `mark` varchar(30) DEFAULT NULL COMMENT '备注',
  `mch_id` varchar(255) DEFAULT NULL COMMENT '商户号',
  `transaction_id` varchar(255) DEFAULT NULL COMMENT '微信支付订单号',
  `out_trade_no` varchar(255) DEFAULT NULL COMMENT '商户系统的订单号',
  `refund_fee` varchar(255) DEFAULT NULL COMMENT '退款金额',
  `time_end` varchar(50) DEFAULT NULL COMMENT '支付完成时间',
  `daddtime` varchar(50) DEFAULT NULL COMMENT '添加时间',
  `shuoming` text COMMENT '退款说明',
  `xian` varchar(10) DEFAULT NULL COMMENT '线上1 线下2',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11122 DEFAULT CHARSET=utf8 COMMENT='订单信息表';

-- ----------------------------
-- Table structure for wp_draw_follow_log
-- ----------------------------
DROP TABLE IF EXISTS `wp_draw_follow_log`;
CREATE TABLE `wp_draw_follow_log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `follow_id` int(10) DEFAULT NULL COMMENT '粉丝id',
  `sports_id` int(10) DEFAULT NULL COMMENT '场次id',
  `count` int(10) DEFAULT '0' COMMENT '抽奖次数',
  `cTime` int(10) DEFAULT NULL COMMENT '支持时间',
  `uid` int(10) DEFAULT NULL COMMENT 'uid',
  `token` varchar(255) DEFAULT NULL COMMENT 'token',
  PRIMARY KEY (`id`),
  KEY `sports_id` (`sports_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for wp_exam
-- ----------------------------
DROP TABLE IF EXISTS `wp_exam`;
CREATE TABLE `wp_exam` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `keyword` varchar(100) NOT NULL COMMENT '关键词',
  `keyword_type` tinyint(2) NOT NULL DEFAULT '0' COMMENT '关键词匹配类型',
  `title` varchar(255) NOT NULL COMMENT '试卷标题',
  `intro` text NOT NULL COMMENT '封面简介',
  `mTime` int(10) NOT NULL COMMENT '修改时间',
  `cover` int(10) unsigned NOT NULL COMMENT '封面图片',
  `cTime` int(10) unsigned NOT NULL COMMENT '发布时间',
  `token` varchar(255) NOT NULL COMMENT 'Token',
  `finish_tip` text NOT NULL COMMENT '结束语',
  `start_time` int(10) DEFAULT NULL COMMENT '考试开始时间',
  `end_time` int(10) DEFAULT NULL COMMENT '考试结束时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for wp_exam_answer
-- ----------------------------
DROP TABLE IF EXISTS `wp_exam_answer`;
CREATE TABLE `wp_exam_answer` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `answer` text NOT NULL COMMENT '回答内容',
  `openid` varchar(255) NOT NULL COMMENT 'OpenId',
  `uid` int(10) NOT NULL COMMENT '用户UID',
  `question_id` int(10) unsigned NOT NULL COMMENT 'question_id',
  `cTime` int(10) unsigned NOT NULL COMMENT '发布时间',
  `token` varchar(255) NOT NULL COMMENT 'Token',
  `exam_id` int(10) unsigned NOT NULL COMMENT 'exam_id',
  `score` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '得分',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for wp_exam_question
-- ----------------------------
DROP TABLE IF EXISTS `wp_exam_question`;
CREATE TABLE `wp_exam_question` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `title` varchar(255) NOT NULL COMMENT '题目标题',
  `intro` text NOT NULL COMMENT '题目描述',
  `cTime` int(10) unsigned NOT NULL COMMENT '发布时间',
  `token` varchar(255) NOT NULL COMMENT 'Token',
  `is_must` tinyint(2) NOT NULL DEFAULT '1' COMMENT '是否必填',
  `extra` text NOT NULL COMMENT '参数',
  `type` char(50) NOT NULL DEFAULT 'radio' COMMENT '题目类型',
  `exam_id` int(10) unsigned NOT NULL COMMENT 'exam_id',
  `sort` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序号',
  `score` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '分值',
  `answer` varchar(255) NOT NULL COMMENT '标准答案',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for wp_file
-- ----------------------------
DROP TABLE IF EXISTS `wp_file`;
CREATE TABLE `wp_file` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '文件ID',
  `name` char(30) NOT NULL DEFAULT '' COMMENT '原始文件名',
  `savename` char(20) NOT NULL DEFAULT '' COMMENT '保存名称',
  `savepath` char(30) NOT NULL DEFAULT '' COMMENT '文件保存路径',
  `ext` char(5) NOT NULL DEFAULT '' COMMENT '文件后缀',
  `mime` char(40) NOT NULL DEFAULT '' COMMENT '文件mime类型',
  `size` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '文件大小',
  `md5` char(32) DEFAULT '' COMMENT '文件md5',
  `sha1` char(40) NOT NULL DEFAULT '' COMMENT '文件 sha1编码',
  `location` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '文件保存位置',
  `create_time` int(10) unsigned NOT NULL COMMENT '上传时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_md5` (`md5`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 COMMENT='文件表';

-- ----------------------------
-- Table structure for wp_forms
-- ----------------------------
DROP TABLE IF EXISTS `wp_forms`;
CREATE TABLE `wp_forms` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `finish_tip` text COMMENT '用户提交后提示内容',
  `cTime` int(10) unsigned DEFAULT NULL COMMENT '发布时间',
  `token` varchar(255) DEFAULT NULL COMMENT 'Token',
  `password` varchar(255) DEFAULT NULL COMMENT '表单密码',
  `keyword_type` tinyint(2) NOT NULL DEFAULT '0' COMMENT '关键词类型',
  `title` varchar(255) NOT NULL COMMENT '标题',
  `intro` text COMMENT '封面简介',
  `mTime` int(10) DEFAULT NULL COMMENT '修改时间',
  `cover` int(10) unsigned DEFAULT NULL COMMENT '封面图片',
  `keyword` varchar(100) NOT NULL COMMENT '关键词',
  `can_edit` tinyint(2) DEFAULT '0' COMMENT '是否允许编辑',
  `content` text COMMENT '详细介绍',
  `jump_url` varchar(255) DEFAULT NULL COMMENT '提交后跳转的地址',
  `template` varchar(255) DEFAULT 'default' COMMENT '模板',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for wp_forms_attribute
-- ----------------------------
DROP TABLE IF EXISTS `wp_forms_attribute`;
CREATE TABLE `wp_forms_attribute` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `type` char(50) NOT NULL DEFAULT 'string' COMMENT '字段类型',
  `title` varchar(255) NOT NULL COMMENT '字段标题',
  `mTime` int(10) DEFAULT NULL COMMENT '修改时间',
  `extra` text COMMENT '参数',
  `value` varchar(255) DEFAULT NULL COMMENT '默认值',
  `token` varchar(255) DEFAULT NULL COMMENT 'Token',
  `name` varchar(100) DEFAULT NULL COMMENT '字段名',
  `remark` varchar(255) DEFAULT NULL COMMENT '字段备注',
  `is_must` tinyint(2) DEFAULT NULL COMMENT '是否必填',
  `validate_rule` varchar(255) DEFAULT NULL COMMENT '正则验证',
  `sort` int(10) unsigned DEFAULT '0' COMMENT '排序号',
  `error_info` varchar(255) DEFAULT NULL COMMENT '出错提示',
  `forms_id` int(10) unsigned DEFAULT NULL COMMENT '表单ID',
  `is_show` tinyint(2) DEFAULT '1' COMMENT '是否显示',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=29 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for wp_forms_value
-- ----------------------------
DROP TABLE IF EXISTS `wp_forms_value`;
CREATE TABLE `wp_forms_value` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `uid` int(10) DEFAULT NULL COMMENT '用户ID',
  `openid` varchar(255) DEFAULT NULL COMMENT 'OpenId',
  `forms_id` int(10) unsigned DEFAULT NULL COMMENT '表单ID',
  `value` text COMMENT '表单值',
  `cTime` int(10) DEFAULT NULL COMMENT '增加时间',
  `token` varchar(255) DEFAULT NULL COMMENT 'Token',
  `addr` varchar(255) DEFAULT NULL COMMENT '举报地址',
  `zuobiao` varchar(255) DEFAULT NULL COMMENT '举报坐标',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=123 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for wp_forum
-- ----------------------------
DROP TABLE IF EXISTS `wp_forum`;
CREATE TABLE `wp_forum` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `title` varchar(255) NOT NULL COMMENT '标题',
  `uid` int(10) DEFAULT '0' COMMENT '用户ID',
  `content` text COMMENT '内容',
  `cTime` int(10) DEFAULT NULL COMMENT '发布时间',
  `attach` varchar(255) DEFAULT NULL COMMENT '附件',
  `is_top` int(10) DEFAULT '0' COMMENT '置顶',
  `cid` tinyint(4) DEFAULT NULL COMMENT '分类',
  `view_count` int(11) unsigned DEFAULT '0' COMMENT '浏览数',
  `reply_count` int(11) unsigned DEFAULT '0' COMMENT '回复数',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for wp_guess
-- ----------------------------
DROP TABLE IF EXISTS `wp_guess`;
CREATE TABLE `wp_guess` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `title` varchar(255) DEFAULT NULL COMMENT '竞猜标题',
  `desc` text COMMENT '活动说明',
  `start_time` int(10) DEFAULT NULL COMMENT '开始时间',
  `end_time` int(10) DEFAULT NULL COMMENT '结束时间',
  `create_time` int(10) DEFAULT NULL COMMENT '创建时间',
  `guess_count` int(10) unsigned DEFAULT '0',
  `token` varchar(255) DEFAULT NULL COMMENT 'Token',
  `template` varchar(255) DEFAULT 'default' COMMENT '素材模板',
  `cover` int(10) unsigned DEFAULT NULL COMMENT '主题图片',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for wp_guess_log
-- ----------------------------
DROP TABLE IF EXISTS `wp_guess_log`;
CREATE TABLE `wp_guess_log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `user_id` int(10) unsigned DEFAULT '0' COMMENT '用户ID',
  `guess_id` int(10) unsigned DEFAULT '0' COMMENT '竞猜Id',
  `token` varchar(255) DEFAULT NULL COMMENT '用户token',
  `optionIds` varchar(255) DEFAULT NULL COMMENT '用户猜的选项IDs',
  `cTime` int(10) DEFAULT NULL COMMENT '创时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for wp_guess_option
-- ----------------------------
DROP TABLE IF EXISTS `wp_guess_option`;
CREATE TABLE `wp_guess_option` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `guess_id` int(10) DEFAULT '0' COMMENT '竞猜活动的Id',
  `name` varchar(255) DEFAULT NULL COMMENT '选项名称',
  `image` int(10) unsigned DEFAULT NULL COMMENT '选项图片',
  `order` int(10) DEFAULT '0' COMMENT '选项顺序',
  `guess_count` int(10) unsigned DEFAULT '0' COMMENT '竞猜人数',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for wp_help_open
-- ----------------------------
DROP TABLE IF EXISTS `wp_help_open`;
CREATE TABLE `wp_help_open` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `title` varchar(100) DEFAULT NULL COMMENT '活动名称',
  `start_time` int(10) DEFAULT NULL COMMENT '开始时间',
  `end_time` int(10) DEFAULT NULL COMMENT '过期时间',
  `limit_num` int(10) DEFAULT '5' COMMENT '帮拆人数限制',
  `content` text COMMENT '活动规则',
  `token` varchar(50) DEFAULT NULL COMMENT 'token',
  `manager_id` int(10) DEFAULT NULL COMMENT 'manager_id',
  `prize_num` int(10) DEFAULT NULL COMMENT '大礼包数量',
  `status` tinyint(2) DEFAULT '1' COMMENT '是否开启',
  `collect_tips` text COMMENT '领取说明',
  `share_icon` int(10) unsigned DEFAULT NULL COMMENT '分享图标',
  `share_title` varchar(100) DEFAULT NULL COMMENT '分享标题',
  `share_intro` varchar(255) DEFAULT NULL COMMENT '分享简介',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for wp_help_open_prize
-- ----------------------------
DROP TABLE IF EXISTS `wp_help_open_prize`;
CREATE TABLE `wp_help_open_prize` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `help_id` int(10) DEFAULT NULL COMMENT '活动ID',
  `sort` int(10) DEFAULT NULL COMMENT '序号',
  `name` varchar(100) DEFAULT NULL COMMENT '奖项名称',
  `prize_type` tinyint(1) DEFAULT '0' COMMENT '奖项类型',
  `coupon_id` int(10) DEFAULT NULL COMMENT '优惠券ID',
  `shop_coupon_id` int(10) DEFAULT NULL COMMENT '代金券ID',
  `money` decimal(11,2) DEFAULT NULL COMMENT '返现金额',
  `is_del` int(10) DEFAULT '0' COMMENT '是否删除',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for wp_help_open_user
-- ----------------------------
DROP TABLE IF EXISTS `wp_help_open_user`;
CREATE TABLE `wp_help_open_user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `invite_uid` int(10) DEFAULT NULL COMMENT '邀请人ID',
  `friend_uid` int(10) DEFAULT NULL COMMENT '帮拆人ID',
  `help_id` int(10) DEFAULT NULL COMMENT '活动ID',
  `cTime` int(10) DEFAULT NULL COMMENT '创建时间',
  `sn_id` int(10) DEFAULT NULL COMMENT 'sn',
  `join_count` int(10) DEFAULT '0' COMMENT '领取数量',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for wp_hooks
-- ----------------------------
DROP TABLE IF EXISTS `wp_hooks`;
CREATE TABLE `wp_hooks` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `name` varchar(40) NOT NULL DEFAULT '' COMMENT '钩子名称',
  `description` text NOT NULL COMMENT '描述',
  `type` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '类型',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `addons` text COMMENT '钩子挂载的插件 ''，''分割',
  PRIMARY KEY (`id`),
  UNIQUE KEY `搜索索引` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=25 DEFAULT CHARSET=utf8 COMMENT='插件钩子表';

-- ----------------------------
-- Table structure for wp_import
-- ----------------------------
DROP TABLE IF EXISTS `wp_import`;
CREATE TABLE `wp_import` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `attach` int(10) unsigned NOT NULL COMMENT '上传文件',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for wp_invite
-- ----------------------------
DROP TABLE IF EXISTS `wp_invite`;
CREATE TABLE `wp_invite` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `keyword` varchar(100) NOT NULL COMMENT '关键词',
  `keyword_type` tinyint(2) NOT NULL DEFAULT '0' COMMENT '关键词类型',
  `title` varchar(255) NOT NULL COMMENT '标题',
  `intro` text COMMENT '封面简介',
  `mTime` int(10) DEFAULT NULL COMMENT '修改时间',
  `cover` int(10) unsigned NOT NULL COMMENT '封面图片',
  `cTime` int(10) unsigned DEFAULT NULL COMMENT '发布时间',
  `token` varchar(255) DEFAULT NULL COMMENT 'Token',
  `experience` int(10) DEFAULT '0' COMMENT '消耗体力值',
  `num` int(10) DEFAULT '0' COMMENT '邀请人数',
  `coupon_id` int(10) DEFAULT NULL COMMENT '优惠券编号',
  `coupon_num` int(10) DEFAULT '0' COMMENT '优惠券数',
  `receive_num` int(10) DEFAULT '0' COMMENT '已领取优惠券数',
  `content` text COMMENT '邀约介绍',
  `template` varchar(255) DEFAULT 'default' COMMENT '模板名称',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for wp_invite_code
-- ----------------------------
DROP TABLE IF EXISTS `wp_invite_code`;
CREATE TABLE `wp_invite_code` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `openid` varchar(100) DEFAULT NULL,
  `code` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for wp_invite_user
-- ----------------------------
DROP TABLE IF EXISTS `wp_invite_user`;
CREATE TABLE `wp_invite_user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `token` varchar(255) DEFAULT NULL COMMENT 'Token',
  `uid` int(10) DEFAULT NULL COMMENT '用户ID',
  `invite_id` int(10) DEFAULT NULL COMMENT '邀约ID',
  `invite_num` int(10) DEFAULT '0' COMMENT '已邀请人数',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for wp_jiaolian
-- ----------------------------
DROP TABLE IF EXISTS `wp_jiaolian`;
CREATE TABLE `wp_jiaolian` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `jxid` int(11) DEFAULT NULL COMMENT '属于哪个驾校',
  `jname` varchar(8) DEFAULT NULL COMMENT '姓名',
  `jsex` varchar(2) DEFAULT NULL COMMENT '1男2女',
  `jage` varchar(2) DEFAULT NULL COMMENT '年龄',
  `jphone` varchar(20) DEFAULT NULL COMMENT '电话',
  `tbh` varchar(20) DEFAULT NULL COMMENT '教练证号',
  `jcard` varchar(20) DEFAULT NULL COMMENT '身份证号',
  `jbh` varchar(20) DEFAULT NULL COMMENT '驾驶证编号',
  `jl` varchar(2) DEFAULT NULL COMMENT '驾龄',
  `jimage` varchar(300) DEFAULT NULL COMMENT '身份证照片',
  `jdaoqi` varchar(50) DEFAULT NULL,
  `jmark` varchar(30) DEFAULT NULL COMMENT '备注',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3346 DEFAULT CHARSET=utf8 COMMENT='教练信息表';

-- ----------------------------
-- Table structure for wp_jiaxiao
-- ----------------------------
DROP TABLE IF EXISTS `wp_jiaxiao`;
CREATE TABLE `wp_jiaxiao` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `jxname` varchar(255) DEFAULT NULL COMMENT '驾校名称',
  `jxfname` varchar(255) DEFAULT NULL COMMENT '负责人',
  `jxphone` varchar(255) DEFAULT NULL COMMENT '驾校电话',
  `jnum` varchar(255) DEFAULT NULL COMMENT '驾校教练人数',
  `jxwark` varchar(255) DEFAULT NULL COMMENT '备注',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=66 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for wp_join_count
-- ----------------------------
DROP TABLE IF EXISTS `wp_join_count`;
CREATE TABLE `wp_join_count` (
  `follow_id` int(10) DEFAULT NULL,
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `aim_id` int(10) DEFAULT NULL,
  `count` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fid_aim` (`follow_id`,`aim_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for wp_keyword
-- ----------------------------
DROP TABLE IF EXISTS `wp_keyword`;
CREATE TABLE `wp_keyword` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `keyword` varchar(100) NOT NULL COMMENT '关键词',
  `token` varchar(100) DEFAULT NULL COMMENT 'Token',
  `addon` varchar(255) NOT NULL COMMENT '关键词所属插件',
  `aim_id` int(10) unsigned NOT NULL COMMENT '插件表里的ID值',
  `cTime` int(10) DEFAULT NULL COMMENT '创建时间',
  `keyword_length` int(10) unsigned DEFAULT '0' COMMENT '关键词长度',
  `keyword_type` tinyint(2) DEFAULT '0' COMMENT '匹配类型',
  `extra_text` text COMMENT '文本扩展',
  `extra_int` int(10) DEFAULT NULL COMMENT '数字扩展',
  `request_count` int(10) DEFAULT '0' COMMENT '请求数',
  PRIMARY KEY (`id`),
  KEY `keyword_token` (`keyword`,`token`)
) ENGINE=MyISAM AUTO_INCREMENT=411 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for wp_lianxiren
-- ----------------------------
DROP TABLE IF EXISTS `wp_lianxiren`;
CREATE TABLE `wp_lianxiren` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT NULL COMMENT '微信id',
  `xid` int(11) DEFAULT NULL COMMENT '学员id',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=26537 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for wp_lottery_games
-- ----------------------------
DROP TABLE IF EXISTS `wp_lottery_games`;
CREATE TABLE `wp_lottery_games` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `title` varchar(255) DEFAULT NULL COMMENT '活动名称',
  `game_type` char(10) DEFAULT '1' COMMENT '游戏类型',
  `status` char(10) DEFAULT '1' COMMENT '状态',
  `start_time` int(10) DEFAULT NULL COMMENT '开始时间',
  `end_time` int(10) DEFAULT NULL COMMENT '结束时间',
  `day_attend_limit` int(10) DEFAULT '0' COMMENT '每人每天抽奖次数',
  `attend_limit` int(10) DEFAULT '0' COMMENT '每人总共抽奖次数',
  `day_win_limit` int(10) DEFAULT '0' COMMENT '每人每天中奖次数',
  `win_limit` int(10) DEFAULT '0' COMMENT '每人总共中奖次数',
  `day_winners_count` int(10) DEFAULT '0' COMMENT '每天最多中奖人数',
  `url` varchar(300) DEFAULT NULL COMMENT '关注链接',
  `remark` text COMMENT '活动说明',
  `keyword` varchar(255) DEFAULT NULL COMMENT '微信关键词',
  `attend_num` int(10) DEFAULT '0' COMMENT '参与总人数',
  `token` varchar(255) DEFAULT NULL COMMENT 'token',
  `manager_id` int(10) DEFAULT NULL COMMENT '管理员id',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for wp_lottery_games_award_link
-- ----------------------------
DROP TABLE IF EXISTS `wp_lottery_games_award_link`;
CREATE TABLE `wp_lottery_games_award_link` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `award_id` int(10) DEFAULT NULL COMMENT '奖品id',
  `games_id` int(10) DEFAULT NULL COMMENT '抽奖游戏id',
  `grade` varchar(255) DEFAULT NULL COMMENT '中奖等级',
  `num` int(10) DEFAULT NULL COMMENT '奖品数量',
  `max_count` int(10) DEFAULT NULL COMMENT '最多抽奖',
  `token` varchar(255) DEFAULT NULL COMMENT 'token',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for wp_lottery_prize_list
-- ----------------------------
DROP TABLE IF EXISTS `wp_lottery_prize_list`;
CREATE TABLE `wp_lottery_prize_list` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `sports_id` int(10) DEFAULT NULL COMMENT '活动编号',
  `award_id` varchar(255) DEFAULT NULL COMMENT '奖品编号',
  `award_num` int(10) DEFAULT NULL COMMENT '奖品数量',
  `uid` int(10) DEFAULT NULL COMMENT 'uid',
  PRIMARY KEY (`id`),
  KEY `sports_id` (`sports_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for wp_lucky_follow
-- ----------------------------
DROP TABLE IF EXISTS `wp_lucky_follow`;
CREATE TABLE `wp_lucky_follow` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `draw_id` int(10) DEFAULT NULL COMMENT '活动编号',
  `sport_id` int(10) DEFAULT NULL COMMENT '场次编号',
  `award_id` int(10) DEFAULT NULL COMMENT '奖品编号',
  `follow_id` int(10) DEFAULT NULL COMMENT '粉丝id',
  `address` varchar(255) DEFAULT NULL COMMENT '地址',
  `num` int(10) DEFAULT '0' COMMENT '获奖数',
  `state` tinyint(2) DEFAULT '0' COMMENT '兑奖状态',
  `zjtime` int(10) DEFAULT NULL COMMENT '中奖时间',
  `djtime` int(10) DEFAULT NULL COMMENT '兑奖时间',
  `uid` int(10) DEFAULT NULL COMMENT 'uid',
  `token` varchar(255) DEFAULT NULL COMMENT 'token',
  `aim_table` varchar(255) DEFAULT NULL COMMENT '活动标识',
  `remark` text COMMENT '备注',
  `scan_code` varchar(255) DEFAULT NULL COMMENT '核销码',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for wp_lzwg_activities
-- ----------------------------
DROP TABLE IF EXISTS `wp_lzwg_activities`;
CREATE TABLE `wp_lzwg_activities` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `title` varchar(255) DEFAULT NULL COMMENT '活动名称',
  `remark` text COMMENT '活动描述',
  `logo_img` int(10) unsigned DEFAULT NULL COMMENT '活动LOGO',
  `start_time` int(10) DEFAULT NULL COMMENT '开始时间',
  `end_time` int(10) DEFAULT NULL COMMENT '结束时间',
  `get_prize_tip` varchar(255) DEFAULT NULL COMMENT '中奖提示信息',
  `no_prize_tip` varchar(255) DEFAULT NULL COMMENT '未中奖提示信息',
  `ctime` int(10) DEFAULT NULL COMMENT '活动创建时间',
  `uid` int(10) DEFAULT NULL COMMENT 'uid',
  `lottery_number` int(10) DEFAULT '1' COMMENT '抽奖次数',
  `comment_status` char(10) DEFAULT '0' COMMENT '评论是否需要审核',
  `get_prize_count` int(10) DEFAULT '1' COMMENT '中奖次数',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for wp_lzwg_activities_vote
-- ----------------------------
DROP TABLE IF EXISTS `wp_lzwg_activities_vote`;
CREATE TABLE `wp_lzwg_activities_vote` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `lzwg_id` int(10) DEFAULT NULL COMMENT '活动编号',
  `lzwg_type` char(10) DEFAULT '0' COMMENT '活动类型',
  `vote_id` int(10) DEFAULT NULL COMMENT '题目编号',
  `vote_type` char(10) DEFAULT '1' COMMENT '问题类型',
  `vote_limit` int(10) DEFAULT NULL COMMENT '最多选择几项',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for wp_lzwg_coupon
-- ----------------------------
DROP TABLE IF EXISTS `wp_lzwg_coupon`;
CREATE TABLE `wp_lzwg_coupon` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `title` varchar(100) DEFAULT NULL COMMENT '名称',
  `money` decimal(10,2) DEFAULT NULL COMMENT '减免金额',
  `name` varchar(255) DEFAULT NULL COMMENT '代金券 标题',
  `condition` decimal(10,2) DEFAULT NULL COMMENT '抵押条件',
  `intro` varchar(255) DEFAULT NULL COMMENT '优惠券简述',
  `img` int(10) unsigned DEFAULT NULL COMMENT '优惠卷图标',
  `sn_str` text COMMENT '序列号',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for wp_lzwg_coupon_receive
-- ----------------------------
DROP TABLE IF EXISTS `wp_lzwg_coupon_receive`;
CREATE TABLE `wp_lzwg_coupon_receive` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `follow_id` int(10) DEFAULT NULL COMMENT '用户ID',
  `coupon_id` int(10) DEFAULT NULL COMMENT '优惠券ID',
  `sn_id` varchar(100) DEFAULT NULL COMMENT '序列号',
  `cTime` int(10) DEFAULT NULL COMMENT '领取时间',
  `aim_id` int(10) DEFAULT NULL COMMENT '活动编号',
  `aim_table` varchar(255) DEFAULT NULL COMMENT '活动表名',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for wp_lzwg_coupon_sn
-- ----------------------------
DROP TABLE IF EXISTS `wp_lzwg_coupon_sn`;
CREATE TABLE `wp_lzwg_coupon_sn` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `coupon_id` int(10) DEFAULT NULL COMMENT '优惠券Id',
  `sn` varchar(255) DEFAULT NULL COMMENT '优惠券sn',
  `is_use` int(10) DEFAULT '0' COMMENT '是否已领取',
  `is_get` int(10) DEFAULT '0' COMMENT '是否已经被领取',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for wp_lzwg_log
-- ----------------------------
DROP TABLE IF EXISTS `wp_lzwg_log`;
CREATE TABLE `wp_lzwg_log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `lzwg_id` int(10) DEFAULT NULL COMMENT '活动ID',
  `follow_id` int(10) DEFAULT NULL COMMENT '用户ID',
  `count` int(10) DEFAULT '0' COMMENT '参与次数',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for wp_lzwg_vote
-- ----------------------------
DROP TABLE IF EXISTS `wp_lzwg_vote`;
CREATE TABLE `wp_lzwg_vote` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `keyword` varchar(50) DEFAULT NULL COMMENT '关键词',
  `title` varchar(100) DEFAULT NULL COMMENT '投票标题',
  `description` text COMMENT '投票描述',
  `picurl` int(10) unsigned DEFAULT NULL COMMENT '封面图片',
  `type` char(10) DEFAULT '0' COMMENT '选择类型',
  `start_date` int(10) DEFAULT NULL COMMENT '开始日期',
  `end_date` int(10) DEFAULT NULL COMMENT '结束日期',
  `is_img` tinyint(2) DEFAULT '0' COMMENT '文字/图片投票',
  `vote_count` int(10) unsigned DEFAULT '0' COMMENT '投票数',
  `cTime` int(10) DEFAULT NULL COMMENT '投票创建时间',
  `mTime` int(10) DEFAULT NULL COMMENT '更新时间',
  `token` varchar(255) DEFAULT NULL COMMENT 'Token',
  `template` varchar(255) DEFAULT 'default' COMMENT '素材模板',
  `uid` int(10) DEFAULT NULL COMMENT 'uid',
  `vote_type` char(10) DEFAULT '0' COMMENT '题目类型',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for wp_lzwg_vote_log
-- ----------------------------
DROP TABLE IF EXISTS `wp_lzwg_vote_log`;
CREATE TABLE `wp_lzwg_vote_log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `vote_id` int(10) unsigned DEFAULT NULL COMMENT '投票ID',
  `user_id` int(10) DEFAULT NULL COMMENT '用户ID',
  `token` varchar(255) DEFAULT NULL COMMENT '用户TOKEN',
  `options` varchar(255) DEFAULT NULL COMMENT '选择选项',
  `cTime` int(10) DEFAULT NULL COMMENT '创建时间',
  `activity_id` int(10) DEFAULT NULL COMMENT '活动编号',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for wp_lzwg_vote_option
-- ----------------------------
DROP TABLE IF EXISTS `wp_lzwg_vote_option`;
CREATE TABLE `wp_lzwg_vote_option` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `vote_id` int(10) unsigned NOT NULL COMMENT '投票ID',
  `name` varchar(255) NOT NULL COMMENT '选项标题',
  `image` int(10) unsigned DEFAULT NULL COMMENT '图片选项',
  `opt_count` int(10) unsigned DEFAULT '0' COMMENT '当前选项投票数',
  `order` int(10) unsigned DEFAULT '0' COMMENT '选项排序',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for wp_manager
-- ----------------------------
DROP TABLE IF EXISTS `wp_manager`;
CREATE TABLE `wp_manager` (
  `uid` int(10) NOT NULL DEFAULT '0' COMMENT '用户ID',
  `has_public` tinyint(2) DEFAULT '0' COMMENT '是否配置公众号',
  `headface_url` int(10) unsigned DEFAULT NULL COMMENT '管理员头像',
  `GammaAppId` varchar(30) DEFAULT NULL COMMENT '摇电视的AppId',
  `GammaSecret` varchar(100) DEFAULT NULL COMMENT '摇电视的Secret',
  `copy_right` varchar(255) DEFAULT NULL COMMENT '授权信息',
  `tongji_code` text COMMENT '统计代码',
  `website_logo` int(10) unsigned DEFAULT NULL COMMENT '网站LOGO',
  PRIMARY KEY (`uid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for wp_manager_menu
-- ----------------------------
DROP TABLE IF EXISTS `wp_manager_menu`;
CREATE TABLE `wp_manager_menu` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `menu_type` tinyint(2) DEFAULT '0' COMMENT '菜单类型',
  `pid` varchar(50) DEFAULT '0' COMMENT '上级菜单',
  `title` varchar(50) DEFAULT NULL COMMENT '菜单名',
  `url_type` tinyint(2) DEFAULT '0' COMMENT '链接类型',
  `addon_name` varchar(30) DEFAULT NULL COMMENT '插件名',
  `url` varchar(255) DEFAULT NULL COMMENT '外链',
  `target` char(50) DEFAULT '_self' COMMENT '打开方式',
  `is_hide` tinyint(2) DEFAULT '0' COMMENT '是否隐藏',
  `sort` int(10) DEFAULT '0' COMMENT '排序号',
  `uid` int(10) DEFAULT NULL COMMENT '管理员ID',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=797710 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for wp_material_file
-- ----------------------------
DROP TABLE IF EXISTS `wp_material_file`;
CREATE TABLE `wp_material_file` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `file_id` int(10) DEFAULT NULL COMMENT '上传文件',
  `cover_url` varchar(255) DEFAULT NULL COMMENT '本地URL',
  `media_id` varchar(100) DEFAULT '0' COMMENT '微信端图文消息素材的media_id',
  `wechat_url` varchar(255) DEFAULT NULL COMMENT '微信端的文件地址',
  `cTime` int(10) DEFAULT NULL COMMENT '创建时间',
  `manager_id` int(10) DEFAULT NULL COMMENT '管理员ID',
  `token` varchar(100) DEFAULT NULL COMMENT 'Token',
  `title` varchar(100) DEFAULT NULL COMMENT '素材名称',
  `type` int(10) DEFAULT NULL COMMENT '类型',
  `introduction` text COMMENT '描述',
  `is_use` int(10) DEFAULT '1' COMMENT '可否使用',
  `aim_id` int(10) DEFAULT NULL COMMENT '添加来源标识id',
  `aim_table` varchar(255) DEFAULT NULL COMMENT '来源表名',
  `group_id` int(10) unsigned DEFAULT '0' COMMENT '素材分组',
  `is_show` int(10) DEFAULT '0' COMMENT '是否审核',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for wp_material_group
-- ----------------------------
DROP TABLE IF EXISTS `wp_material_group`;
CREATE TABLE `wp_material_group` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '素材分组id',
  `title` varchar(50) DEFAULT NULL COMMENT '分组名',
  `description` varchar(50) DEFAULT NULL COMMENT '描述',
  `token` varchar(100) DEFAULT NULL COMMENT 'Token',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=24 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for wp_material_image
-- ----------------------------
DROP TABLE IF EXISTS `wp_material_image`;
CREATE TABLE `wp_material_image` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `cover_id` int(10) DEFAULT NULL COMMENT '图片在本地的ID',
  `cover_url` varchar(255) DEFAULT NULL COMMENT '本地URL',
  `media_id` varchar(100) DEFAULT '0' COMMENT '微信端图文消息素材的media_id',
  `wechat_url` varchar(255) DEFAULT NULL COMMENT '微信端的图片地址',
  `cTime` int(10) DEFAULT NULL COMMENT '创建时间',
  `manager_id` int(10) DEFAULT NULL COMMENT '管理员ID',
  `token` varchar(100) DEFAULT NULL COMMENT 'Token',
  `is_use` int(10) DEFAULT '1' COMMENT '可否使用',
  `aim_id` int(10) DEFAULT NULL COMMENT '添加来源标识id',
  `aim_table` varchar(255) DEFAULT NULL COMMENT '来源表名',
  `group_id` int(10) unsigned DEFAULT '0' COMMENT '分组id',
  `is_show` int(10) unsigned DEFAULT '0' COMMENT '审核是否通过',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=126 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for wp_material_news
-- ----------------------------
DROP TABLE IF EXISTS `wp_material_news`;
CREATE TABLE `wp_material_news` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `title` varchar(100) DEFAULT NULL COMMENT '标题',
  `author` varchar(30) DEFAULT NULL COMMENT '作者',
  `cover_id` int(10) unsigned DEFAULT NULL COMMENT '封面',
  `intro` varchar(255) DEFAULT NULL COMMENT '摘要',
  `content` longtext COMMENT '内容',
  `link` varchar(255) DEFAULT NULL COMMENT '外链',
  `group_id` int(10) DEFAULT '0' COMMENT '多图文组的ID',
  `thumb_media_id` varchar(100) DEFAULT NULL COMMENT '图文消息的封面图片素材id（必须是永久mediaID）',
  `media_id` varchar(100) DEFAULT '0' COMMENT '微信端图文消息素材的media_id',
  `manager_id` int(10) DEFAULT NULL COMMENT '管理员ID',
  `token` varchar(100) DEFAULT NULL COMMENT 'Token',
  `cTime` int(10) DEFAULT NULL COMMENT '发布时间',
  `url` varchar(255) DEFAULT NULL COMMENT '图文页url',
  `is_use` int(10) DEFAULT '1' COMMENT '可否使用',
  `aim_id` int(10) DEFAULT NULL COMMENT '添加来源标识id',
  `aim_table` varchar(255) DEFAULT NULL COMMENT '来源表名',
  `update_time` int(10) DEFAULT '0' COMMENT 'update_time',
  `group_list` int(10) unsigned DEFAULT '0' COMMENT '分组id',
  `is_show` int(10) unsigned DEFAULT '0' COMMENT '审核通过',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=103 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for wp_material_text
-- ----------------------------
DROP TABLE IF EXISTS `wp_material_text`;
CREATE TABLE `wp_material_text` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `content` text COMMENT '文本内容',
  `token` varchar(50) DEFAULT NULL COMMENT 'Token',
  `uid` int(10) DEFAULT NULL COMMENT 'uid',
  `is_use` int(10) DEFAULT '1' COMMENT '可否使用',
  `aim_id` int(10) DEFAULT NULL COMMENT '添加来源标识id',
  `aim_table` varchar(255) DEFAULT NULL COMMENT '来源表名',
  `group_id` int(10) unsigned DEFAULT '0' COMMENT '素材分组',
  `is_show` int(10) unsigned DEFAULT '0' COMMENT '审核是否通过',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=26 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for wp_menu
-- ----------------------------
DROP TABLE IF EXISTS `wp_menu`;
CREATE TABLE `wp_menu` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '文档ID',
  `title` varchar(50) NOT NULL DEFAULT '' COMMENT '标题',
  `pid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '上级分类ID',
  `sort` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序（同级有效）',
  `url` char(255) NOT NULL DEFAULT '' COMMENT '链接地址',
  `hide` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否隐藏',
  `tip` varchar(255) NOT NULL DEFAULT '' COMMENT '提示',
  `group` varchar(50) DEFAULT '' COMMENT '分组',
  `is_dev` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否仅开发者模式可见',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=154 DEFAULT CHARSET=utf8 COMMENT='后台导航数据表';

-- ----------------------------
-- Table structure for wp_message
-- ----------------------------
DROP TABLE IF EXISTS `wp_message`;
CREATE TABLE `wp_message` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `bind_keyword` varchar(50) DEFAULT NULL COMMENT '关联关键词',
  `preview_openids` text COMMENT '预览人OPENID',
  `group_id` int(10) DEFAULT '0' COMMENT '群发对象',
  `type` tinyint(2) DEFAULT '0' COMMENT '素材来源',
  `media_id` varchar(100) DEFAULT NULL COMMENT '微信素材ID',
  `send_type` tinyint(1) DEFAULT '0' COMMENT '发送方式',
  `send_openids` text COMMENT '要发送的OpenID',
  `msg_id` varchar(255) DEFAULT NULL COMMENT 'msg_id',
  `content` text COMMENT '文本消息内容',
  `msgtype` varchar(255) DEFAULT NULL COMMENT '消息类型',
  `token` varchar(255) DEFAULT NULL COMMENT 'token',
  `appmsg_id` int(10) DEFAULT NULL COMMENT '图文id',
  `voice_id` int(10) DEFAULT NULL COMMENT '语音id',
  `video_id` int(10) DEFAULT NULL COMMENT '视频id',
  `cTime` int(10) DEFAULT NULL COMMENT '群发时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for wp_model
-- ----------------------------
DROP TABLE IF EXISTS `wp_model`;
CREATE TABLE `wp_model` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '模型ID',
  `name` char(30) NOT NULL DEFAULT '' COMMENT '模型标识',
  `title` char(30) NOT NULL DEFAULT '' COMMENT '模型名称',
  `extend` int(10) unsigned DEFAULT '0' COMMENT '继承的模型',
  `relation` varchar(30) DEFAULT '' COMMENT '继承与被继承模型的关联字段',
  `need_pk` tinyint(1) unsigned DEFAULT '1' COMMENT '新建表时是否需要主键字段',
  `field_sort` text COMMENT '表单字段排序',
  `field_group` varchar(255) DEFAULT '1:基础' COMMENT '字段分组',
  `attribute_list` text COMMENT '属性列表（表的字段）',
  `template_list` varchar(100) DEFAULT '' COMMENT '列表模板',
  `template_add` varchar(100) DEFAULT '' COMMENT '新增模板',
  `template_edit` varchar(100) DEFAULT '' COMMENT '编辑模板',
  `list_grid` text COMMENT '列表定义',
  `list_row` smallint(2) unsigned DEFAULT '10' COMMENT '列表数据长度',
  `search_key` varchar(50) DEFAULT '' COMMENT '默认搜索字段',
  `search_list` varchar(255) DEFAULT '' COMMENT '高级搜索的字段',
  `create_time` int(10) unsigned DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) unsigned DEFAULT '0' COMMENT '更新时间',
  `status` tinyint(3) unsigned DEFAULT '0' COMMENT '状态',
  `engine_type` varchar(25) DEFAULT 'MyISAM' COMMENT '数据库引擎',
  `addon` varchar(50) DEFAULT NULL COMMENT '所属插件',
  PRIMARY KEY (`id`),
  KEY `name` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=1156 DEFAULT CHARSET=utf8 COMMENT='系统模型表';

-- ----------------------------
-- Table structure for wp_online_count
-- ----------------------------
DROP TABLE IF EXISTS `wp_online_count`;
CREATE TABLE `wp_online_count` (
  `publicid` int(11) DEFAULT NULL,
  `addon` varchar(30) DEFAULT NULL,
  `aim_id` int(11) DEFAULT NULL,
  `time` bigint(12) DEFAULT NULL,
  `count` int(11) DEFAULT NULL,
  KEY `tc` (`time`,`count`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for wp_paiban
-- ----------------------------
DROP TABLE IF EXISTS `wp_paiban`;
CREATE TABLE `wp_paiban` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `data` varchar(20) DEFAULT NULL COMMENT '日期',
  `time` varchar(20) DEFAULT NULL COMMENT '时间段',
  `mark` varchar(30) DEFAULT NULL,
  `status` int(1) DEFAULT NULL COMMENT ' 状态(0:正常 1:锁住)',
  `ch` varchar(30) DEFAULT NULL,
  `type` int(1) DEFAULT '0' COMMENT '//排班发布类型（0学员预约，1驾校预约）',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=44289 DEFAULT CHARSET=utf8 COMMENT='排班表';

-- ----------------------------
-- Table structure for wp_paiban_copy
-- ----------------------------
DROP TABLE IF EXISTS `wp_paiban_copy`;
CREATE TABLE `wp_paiban_copy` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `data` varchar(20) DEFAULT NULL COMMENT '日期',
  `time` varchar(20) DEFAULT NULL COMMENT '时间段',
  `mark` varchar(30) DEFAULT NULL,
  `status` int(1) DEFAULT NULL COMMENT ' 状态(0:正常 1:锁住)',
  `ch` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=39624 DEFAULT CHARSET=utf8 COMMENT='排班表';

-- ----------------------------
-- Table structure for wp_paiban_copy_2017-12-18
-- ----------------------------
DROP TABLE IF EXISTS `wp_paiban_copy_2017-12-18`;
CREATE TABLE `wp_paiban_copy_2017-12-18` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `data` varchar(20) DEFAULT NULL COMMENT '日期',
  `time` varchar(20) DEFAULT NULL COMMENT '时间段',
  `mark` varchar(30) DEFAULT NULL,
  `status` int(1) DEFAULT NULL COMMENT ' 状态(0:正常 1:锁住)',
  `ch` varchar(30) DEFAULT NULL,
  `type` int(1) DEFAULT '0' COMMENT '//排班发布类型（0学员预约，1驾校预约）',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=44289 DEFAULT CHARSET=utf8 COMMENT='排班表';

-- ----------------------------
-- Table structure for wp_payment_order
-- ----------------------------
DROP TABLE IF EXISTS `wp_payment_order`;
CREATE TABLE `wp_payment_order` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `from` varchar(50) NOT NULL COMMENT '回调地址',
  `orderName` varchar(255) DEFAULT NULL COMMENT '订单名称',
  `single_orderid` varchar(100) NOT NULL COMMENT '订单号',
  `price` decimal(10,2) DEFAULT NULL COMMENT '价格',
  `token` varchar(100) NOT NULL COMMENT 'Token',
  `wecha_id` varchar(200) NOT NULL COMMENT 'OpenID',
  `paytype` varchar(30) NOT NULL COMMENT '支付方式',
  `showwxpaytitle` tinyint(2) NOT NULL DEFAULT '0' COMMENT '是否显示标题',
  `status` tinyint(2) NOT NULL DEFAULT '0' COMMENT '支付状态',
  `aim_id` int(10) DEFAULT NULL COMMENT 'aim_id',
  `uid` int(10) DEFAULT NULL COMMENT '用户uid',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for wp_payment_set
-- ----------------------------
DROP TABLE IF EXISTS `wp_payment_set`;
CREATE TABLE `wp_payment_set` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `token` varchar(255) DEFAULT NULL COMMENT 'token',
  `ctime` int(10) DEFAULT NULL COMMENT '创建时间',
  `wxappid` varchar(255) DEFAULT NULL COMMENT 'AppID',
  `wxpaysignkey` varchar(255) DEFAULT NULL COMMENT '支付密钥',
  `wxappsecret` varchar(255) DEFAULT NULL COMMENT 'AppSecret',
  `zfbname` varchar(255) DEFAULT NULL COMMENT '帐号',
  `pid` varchar(255) DEFAULT NULL COMMENT 'PID',
  `key` varchar(255) DEFAULT NULL COMMENT 'KEY',
  `partnerid` varchar(255) DEFAULT NULL COMMENT '财付通标识',
  `partnerkey` varchar(255) DEFAULT NULL COMMENT '财付通Key',
  `wappartnerid` varchar(255) DEFAULT NULL COMMENT '财付通标识WAP',
  `wappartnerkey` varchar(255) DEFAULT NULL COMMENT 'WAP财付通Key',
  `wxpartnerkey` varchar(255) DEFAULT NULL COMMENT '微信partnerkey',
  `wxpartnerid` varchar(255) DEFAULT NULL COMMENT '微信partnerid',
  `quick_security_key` varchar(255) DEFAULT NULL COMMENT '银联在线Key',
  `quick_merid` varchar(255) DEFAULT NULL COMMENT '银联在线merid',
  `quick_merabbr` varchar(255) DEFAULT NULL COMMENT '商户名称',
  `shop_id` int(10) DEFAULT '0' COMMENT '商店ID',
  `wxmchid` varchar(255) DEFAULT NULL COMMENT '微信支付商户号',
  `wx_cert_pem` int(10) unsigned DEFAULT NULL COMMENT '上传证书',
  `wx_key_pem` int(10) unsigned DEFAULT NULL COMMENT '上传密匙',
  `shop_pay_score` int(10) DEFAULT '0' COMMENT '支付返积分',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for wp_picture
-- ----------------------------
DROP TABLE IF EXISTS `wp_picture`;
CREATE TABLE `wp_picture` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键id自增',
  `path` varchar(255) NOT NULL DEFAULT '' COMMENT '路径',
  `url` varchar(255) NOT NULL DEFAULT '' COMMENT '图片链接',
  `category_id` int(255) DEFAULT '0',
  `md5` char(32) NOT NULL DEFAULT '' COMMENT '文件md5',
  `sha1` char(40) NOT NULL DEFAULT '' COMMENT '文件 sha1编码',
  `status` tinyint(2) NOT NULL DEFAULT '0' COMMENT '状态',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `token` varchar(255) DEFAULT NULL,
  `system` tinyint(10) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `status` (`id`,`status`)
) ENGINE=MyISAM AUTO_INCREMENT=1325 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for wp_picture_category
-- ----------------------------
DROP TABLE IF EXISTS `wp_picture_category`;
CREATE TABLE `wp_picture_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `ctime` int(11) DEFAULT NULL,
  `token` varchar(255) DEFAULT NULL,
  `system` tinyint(2) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for wp_plugin
-- ----------------------------
DROP TABLE IF EXISTS `wp_plugin`;
CREATE TABLE `wp_plugin` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `name` varchar(40) NOT NULL COMMENT '插件名或标识',
  `title` varchar(20) NOT NULL DEFAULT '' COMMENT '中文名',
  `description` text COMMENT '插件描述',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态',
  `config` text COMMENT '配置',
  `author` varchar(40) DEFAULT '' COMMENT '作者',
  `version` varchar(20) DEFAULT '' COMMENT '版本号',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '安装时间',
  `has_adminlist` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否有后台列表',
  `cate_id` int(11) DEFAULT NULL,
  `is_show` tinyint(2) DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `name` (`name`),
  KEY `sti` (`status`,`is_show`)
) ENGINE=MyISAM AUTO_INCREMENT=131 DEFAULT CHARSET=utf8 COMMENT='系统插件表';

-- ----------------------------
-- Table structure for wp_prize_address
-- ----------------------------
DROP TABLE IF EXISTS `wp_prize_address`;
CREATE TABLE `wp_prize_address` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `address` varchar(255) DEFAULT NULL COMMENT '奖品收货地址',
  `mobile` varchar(50) DEFAULT NULL COMMENT '手机',
  `turename` varchar(255) DEFAULT NULL COMMENT '收货人姓名',
  `uid` int(10) DEFAULT NULL COMMENT '用户id',
  `remark` varchar(255) DEFAULT NULL COMMENT '备注',
  `prizeid` int(10) DEFAULT NULL COMMENT '奖品编号',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for wp_public
-- ----------------------------
DROP TABLE IF EXISTS `wp_public`;
CREATE TABLE `wp_public` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `uid` int(10) DEFAULT NULL COMMENT '用户ID',
  `public_name` varchar(50) DEFAULT NULL COMMENT '公众号名称',
  `public_id` varchar(100) DEFAULT NULL COMMENT '公众号原始id',
  `wechat` varchar(100) DEFAULT NULL COMMENT '微信号',
  `interface_url` varchar(255) DEFAULT NULL COMMENT '接口地址',
  `headface_url` varchar(255) DEFAULT NULL COMMENT '公众号头像',
  `area` varchar(50) DEFAULT NULL COMMENT '地区',
  `addon_config` text COMMENT '插件配置',
  `addon_status` text COMMENT '插件状态',
  `token` varchar(100) DEFAULT NULL COMMENT 'Token',
  `is_use` tinyint(2) DEFAULT '0' COMMENT '是否为当前公众号',
  `type` char(10) DEFAULT '0' COMMENT '公众号类型',
  `appid` varchar(255) DEFAULT NULL COMMENT 'AppID',
  `secret` varchar(255) DEFAULT NULL COMMENT 'AppSecret',
  `group_id` int(10) unsigned DEFAULT '0' COMMENT '等级',
  `encodingaeskey` varchar(255) DEFAULT NULL COMMENT 'EncodingAESKey',
  `tips_url` varchar(255) DEFAULT NULL COMMENT '提示关注公众号的文章地址',
  `domain` varchar(30) DEFAULT NULL COMMENT '自定义域名',
  `is_bind` tinyint(2) DEFAULT '0' COMMENT '是否为微信开放平台绑定账号',
  `cTime` int(10) DEFAULT NULL COMMENT '增加时间',
  `authorizer_refresh_token` varchar(100) DEFAULT NULL COMMENT '一键绑定的refresh_token',
  PRIMARY KEY (`id`),
  KEY `token` (`token`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for wp_public_auth
-- ----------------------------
DROP TABLE IF EXISTS `wp_public_auth`;
CREATE TABLE `wp_public_auth` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` char(50) NOT NULL,
  `title` varchar(100) NOT NULL,
  `type_0` tinyint(1) DEFAULT '0' COMMENT '普通订阅号的开关',
  `type_1` tinyint(1) DEFAULT '0' COMMENT '微信认证订阅号的开关',
  `type_2` tinyint(1) DEFAULT '0' COMMENT '普通服务号的开关',
  `type_3` tinyint(1) DEFAULT '0' COMMENT '微信认证服务号的开关',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=36 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for wp_public_check
-- ----------------------------
DROP TABLE IF EXISTS `wp_public_check`;
CREATE TABLE `wp_public_check` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `token` varchar(50) NOT NULL,
  `na` varchar(50) NOT NULL,
  `msg` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=81 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for wp_public_follow
-- ----------------------------
DROP TABLE IF EXISTS `wp_public_follow`;
CREATE TABLE `wp_public_follow` (
  `openid` varchar(100) NOT NULL,
  `token` varchar(100) NOT NULL,
  `uid` int(11) DEFAULT NULL,
  `has_subscribe` tinyint(1) DEFAULT '0',
  `syc_status` tinyint(1) DEFAULT '2' COMMENT '0 开始同步中 1 更新用户信息中 2 完成同步',
  `remark` varchar(100) DEFAULT NULL,
  UNIQUE KEY `openid` (`openid`,`token`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for wp_public_group
-- ----------------------------
DROP TABLE IF EXISTS `wp_public_group`;
CREATE TABLE `wp_public_group` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `title` varchar(50) DEFAULT NULL COMMENT '等级名',
  `addon_status` text COMMENT '插件权限',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for wp_public_link
-- ----------------------------
DROP TABLE IF EXISTS `wp_public_link`;
CREATE TABLE `wp_public_link` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `uid` int(10) DEFAULT NULL COMMENT '管理员UID',
  `mp_id` int(10) unsigned NOT NULL COMMENT '公众号ID',
  `is_creator` tinyint(2) DEFAULT '0' COMMENT '是否为创建者',
  `addon_status` text COMMENT '插件权限',
  `is_use` tinyint(2) DEFAULT '0' COMMENT '是否为当前管理的公众号',
  PRIMARY KEY (`id`),
  UNIQUE KEY `um` (`uid`,`mp_id`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for wp_qr_admin
-- ----------------------------
DROP TABLE IF EXISTS `wp_qr_admin`;
CREATE TABLE `wp_qr_admin` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `action_name` varchar(30) NOT NULL DEFAULT 'QR_SCENE' COMMENT '类型',
  `group_id` int(10) DEFAULT '0' COMMENT '用户组',
  `tag_ids` varchar(255) DEFAULT NULL COMMENT '用户标签',
  `qr_code` varchar(255) DEFAULT NULL COMMENT '二维码',
  `material` varchar(50) DEFAULT NULL COMMENT '扫码后的回复内容',
  `mult_pic` varchar(255) DEFAULT NULL COMMENT '多图上传',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for wp_qr_code
-- ----------------------------
DROP TABLE IF EXISTS `wp_qr_code`;
CREATE TABLE `wp_qr_code` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `qr_code` varchar(255) NOT NULL COMMENT '二维码',
  `addon` varchar(255) NOT NULL COMMENT '二维码所属插件',
  `aim_id` int(10) unsigned NOT NULL COMMENT '插件表里的ID值',
  `cTime` int(10) DEFAULT NULL COMMENT '创建时间',
  `token` varchar(255) DEFAULT NULL COMMENT 'Token',
  `action_name` char(30) DEFAULT 'QR_SCENE' COMMENT '二维码类型',
  `extra_text` text COMMENT '文本扩展',
  `extra_int` int(10) DEFAULT NULL COMMENT '数字扩展',
  `request_count` int(10) DEFAULT '0' COMMENT '请求数',
  `scene_id` int(10) DEFAULT '0' COMMENT '场景ID',
  `expire_seconds` int(11) DEFAULT '2592000' COMMENT '有效期',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9123 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for wp_real_prize
-- ----------------------------
DROP TABLE IF EXISTS `wp_real_prize`;
CREATE TABLE `wp_real_prize` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `prize_name` varchar(255) DEFAULT NULL COMMENT '奖品名称',
  `prize_conditions` text COMMENT '活动说明',
  `prize_count` int(10) DEFAULT NULL COMMENT '奖品个数',
  `prize_image` varchar(255) DEFAULT '上传奖品图片' COMMENT '奖品图片',
  `token` varchar(255) DEFAULT NULL COMMENT 'token',
  `prize_type` tinyint(2) DEFAULT '1' COMMENT '奖品类型',
  `use_content` text COMMENT '使用说明',
  `prize_title` varchar(255) DEFAULT NULL COMMENT '活动标题',
  `fail_content` text COMMENT '领取失败提示',
  `template` varchar(255) DEFAULT 'default' COMMENT '素材模板',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for wp_recharge_log
-- ----------------------------
DROP TABLE IF EXISTS `wp_recharge_log`;
CREATE TABLE `wp_recharge_log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `recharge` float DEFAULT NULL COMMENT '充值金额',
  `branch_id` int(10) DEFAULT '0' COMMENT '充值门店',
  `operator` varchar(255) DEFAULT NULL COMMENT '操作员',
  `cTime` int(10) DEFAULT NULL COMMENT '创建时间',
  `token` varchar(255) DEFAULT NULL COMMENT 'token',
  `member_id` int(10) DEFAULT NULL COMMENT '会员id',
  `manager_id` int(10) DEFAULT NULL COMMENT '管理员id',
  `type` tinyint(2) DEFAULT '1' COMMENT '充值方式',
  `remark` text COMMENT '备注',
  `uid` int(10) DEFAULT NULL COMMENT '用户ID',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for wp_redbag
-- ----------------------------
DROP TABLE IF EXISTS `wp_redbag`;
CREATE TABLE `wp_redbag` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `mch_id` varchar(32) DEFAULT NULL COMMENT '商户号',
  `sub_mch_id` varchar(32) DEFAULT NULL COMMENT '子商户号',
  `wxappid` varchar(32) DEFAULT NULL COMMENT '公众账号appid',
  `nick_name` varchar(32) DEFAULT NULL COMMENT '提供方名称',
  `send_name` varchar(32) DEFAULT NULL COMMENT '商户名称',
  `total_amount` int(10) DEFAULT '1000' COMMENT '付款金额',
  `min_value` int(10) DEFAULT '1000' COMMENT '最小红包金额',
  `max_value` int(10) DEFAULT '1000' COMMENT '最大红包金额',
  `total_num` int(10) DEFAULT '1' COMMENT '红包发放总人数',
  `wishing` varchar(255) DEFAULT NULL COMMENT '红包祝福语',
  `act_name` varchar(255) DEFAULT NULL COMMENT '活动名称',
  `remark` varchar(255) DEFAULT NULL COMMENT '备注',
  `logo_imgurl` int(10) unsigned DEFAULT NULL COMMENT '商户logo的url',
  `share_content` varchar(255) DEFAULT NULL COMMENT '分享文案',
  `share_url` varchar(255) DEFAULT NULL COMMENT '分享链接',
  `share_imgurl` int(10) unsigned DEFAULT NULL COMMENT '分享的图片',
  `collect_count` int(10) DEFAULT '0' COMMENT '领取人数',
  `collect_amount` int(10) DEFAULT '0' COMMENT '已领取金额',
  `collect_limit` tinyint(2) DEFAULT '0' COMMENT '每人最多领取次数',
  `partner_key` varchar(50) DEFAULT NULL COMMENT '商户API密钥',
  `template` varchar(255) DEFAULT 'default' COMMENT '素材模板',
  `token` varchar(50) DEFAULT NULL COMMENT 'token',
  `uid` int(10) DEFAULT NULL COMMENT 'uid',
  `act_remark` varchar(255) DEFAULT NULL COMMENT '活动备注',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for wp_redbag_follow
-- ----------------------------
DROP TABLE IF EXISTS `wp_redbag_follow`;
CREATE TABLE `wp_redbag_follow` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `redbag_id` int(10) DEFAULT NULL COMMENT '红包ID',
  `follow_id` int(10) DEFAULT NULL COMMENT '粉丝ID',
  `amount` int(10) DEFAULT '0' COMMENT '领取金额',
  `cTime` int(10) DEFAULT NULL COMMENT '发放时间',
  `status` char(10) DEFAULT 'SENDING' COMMENT '发放状态',
  `reason` varchar(50) DEFAULT NULL COMMENT '失败原因 ',
  `Rcv_time` int(10) DEFAULT NULL COMMENT '领取红包的时间 ',
  `Send_time` int(10) DEFAULT NULL COMMENT '红包发送时间 ',
  `Refund_time` int(10) DEFAULT NULL COMMENT '红包退款时间',
  `extra` text COMMENT '微信返回的数据集',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for wp_reserve
-- ----------------------------
DROP TABLE IF EXISTS `wp_reserve`;
CREATE TABLE `wp_reserve` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `title` varchar(255) NOT NULL COMMENT '标题',
  `cTime` int(10) unsigned DEFAULT NULL COMMENT '发布时间',
  `token` varchar(255) DEFAULT NULL COMMENT 'Token',
  `password` varchar(255) DEFAULT NULL COMMENT '微预约密码',
  `jump_url` varchar(255) DEFAULT NULL COMMENT '提交后跳转的地址',
  `content` text COMMENT '详细介绍',
  `finish_tip` text COMMENT '用户提交后提示内容',
  `can_edit` tinyint(2) DEFAULT '0' COMMENT '是否允许编辑',
  `intro` text COMMENT '封面简介',
  `mTime` int(10) DEFAULT NULL COMMENT '修改时间',
  `cover` int(10) unsigned DEFAULT NULL COMMENT '封面图片',
  `template` varchar(255) DEFAULT 'default' COMMENT '模板',
  `status` tinyint(2) DEFAULT '0' COMMENT '状态',
  `start_time` int(10) DEFAULT NULL COMMENT '报名开始时间',
  `end_time` int(10) DEFAULT NULL COMMENT '报名结束时间',
  `pay_online` tinyint(2) DEFAULT '0' COMMENT '是否支持在线支付',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for wp_reserve_attribute
-- ----------------------------
DROP TABLE IF EXISTS `wp_reserve_attribute`;
CREATE TABLE `wp_reserve_attribute` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `is_show` tinyint(2) DEFAULT '1' COMMENT '是否显示',
  `reserve_id` int(10) unsigned DEFAULT NULL COMMENT '微预约ID',
  `error_info` varchar(255) DEFAULT NULL COMMENT '出错提示',
  `sort` int(10) unsigned DEFAULT '0' COMMENT '排序号',
  `validate_rule` varchar(255) DEFAULT NULL COMMENT '正则验证',
  `is_must` tinyint(2) DEFAULT NULL COMMENT '是否必填',
  `remark` varchar(255) DEFAULT NULL COMMENT '字段备注',
  `token` varchar(255) DEFAULT NULL COMMENT 'Token',
  `value` varchar(255) DEFAULT NULL COMMENT '默认值',
  `title` varchar(255) NOT NULL COMMENT '字段标题',
  `mTime` int(10) DEFAULT NULL COMMENT '修改时间',
  `extra` text COMMENT '参数',
  `type` char(50) NOT NULL DEFAULT 'string' COMMENT '字段类型',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for wp_reserve_option
-- ----------------------------
DROP TABLE IF EXISTS `wp_reserve_option`;
CREATE TABLE `wp_reserve_option` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `reserve_id` int(10) DEFAULT NULL COMMENT '预约活动ID',
  `name` varchar(100) DEFAULT NULL COMMENT '名称',
  `money` decimal(11,2) DEFAULT '0.00' COMMENT '报名费用',
  `max_limit` int(10) DEFAULT '0' COMMENT '最大预约数',
  `init_count` int(10) DEFAULT '0' COMMENT '初始化预约数',
  `join_count` int(10) DEFAULT '0' COMMENT '参加人数',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for wp_reserve_value
-- ----------------------------
DROP TABLE IF EXISTS `wp_reserve_value`;
CREATE TABLE `wp_reserve_value` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `reserve_id` int(10) unsigned DEFAULT NULL COMMENT '微预约ID',
  `value` text COMMENT '微预约值',
  `cTime` int(10) DEFAULT NULL COMMENT '增加时间',
  `openid` varchar(255) DEFAULT NULL COMMENT 'OpenId',
  `uid` int(10) DEFAULT NULL COMMENT '用户ID',
  `token` varchar(255) DEFAULT NULL COMMENT 'Token',
  `is_check` int(10) DEFAULT '0' COMMENT '验证是否成功',
  `is_pay` int(10) DEFAULT '0' COMMENT '是否支付',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for wp_school
-- ----------------------------
DROP TABLE IF EXISTS `wp_school`;
CREATE TABLE `wp_school` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `xid` int(10) DEFAULT NULL COMMENT '学员id',
  `sname` varchar(20) DEFAULT NULL COMMENT '驾校名称',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for wp_score_exchange_log
-- ----------------------------
DROP TABLE IF EXISTS `wp_score_exchange_log`;
CREATE TABLE `wp_score_exchange_log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `card_score_id` int(10) DEFAULT NULL COMMENT '兑换活动id',
  `token` varchar(255) DEFAULT NULL COMMENT 'token',
  `uid` int(10) DEFAULT NULL COMMENT 'uid',
  `ctime` int(10) DEFAULT NULL COMMENT 'ctime',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for wp_servicer
-- ----------------------------
DROP TABLE IF EXISTS `wp_servicer`;
CREATE TABLE `wp_servicer` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `uid` int(10) DEFAULT NULL COMMENT '用户选择',
  `truename` varchar(255) DEFAULT NULL COMMENT '真实姓名',
  `mobile` varchar(255) DEFAULT NULL COMMENT '手机号',
  `role` varchar(100) DEFAULT '0' COMMENT '授权列表',
  `enable` int(10) DEFAULT '1' COMMENT '是否启用',
  `token` varchar(255) DEFAULT NULL COMMENT 'token',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Table structure for wp_share_log
-- ----------------------------
DROP TABLE IF EXISTS `wp_share_log`;
CREATE TABLE `wp_share_log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `uid` int(10) DEFAULT NULL COMMENT '用户id',
  `sTime` int(10) DEFAULT NULL COMMENT '分享时间',
  `token` varchar(255) DEFAULT NULL COMMENT 'token',
  `score` int(10) DEFAULT NULL COMMENT '积分',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for wp_shop_address
-- ----------------------------
DROP TABLE IF EXISTS `wp_shop_address`;
CREATE TABLE `wp_shop_address` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `uid` int(10) DEFAULT NULL COMMENT '用户ID',
  `truename` varchar(100) DEFAULT NULL COMMENT '收货人姓名',
  `mobile` varchar(50) DEFAULT NULL COMMENT '手机号码',
  `city` varchar(255) DEFAULT NULL COMMENT '城市',
  `address` varchar(255) DEFAULT NULL COMMENT '具体地址',
  `is_use` tinyint(2) DEFAULT '0' COMMENT '是否设置为默认',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Table structure for wp_shop_coupon
-- ----------------------------
DROP TABLE IF EXISTS `wp_shop_coupon`;
CREATE TABLE `wp_shop_coupon` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `title` varchar(30) DEFAULT NULL COMMENT '优惠券名称',
  `num` int(10) DEFAULT '0' COMMENT '发放量',
  `money` decimal(11,2) DEFAULT NULL COMMENT '面值',
  `money_max` decimal(11,2) DEFAULT '0.00' COMMENT '最大面值',
  `is_money_rand` tinyint(2) DEFAULT '0' COMMENT '面值是否随机',
  `order_money` decimal(11,2) DEFAULT '0.00' COMMENT '订单金额',
  `limit_num` char(50) DEFAULT '0' COMMENT '每人限领',
  `start_time` int(10) DEFAULT NULL COMMENT '生效时间',
  `end_time` int(10) DEFAULT NULL COMMENT '过期时间',
  `limit_goods` tinyint(2) DEFAULT '0' COMMENT '可适用商品',
  `limit_goods_ids` varchar(100) DEFAULT NULL COMMENT '指定的商品',
  `is_market_price` tinyint(2) DEFAULT '0' COMMENT '仅原价购买商品时可用 ',
  `content` text COMMENT '使用说明',
  `status` tinyint(2) DEFAULT '1' COMMENT '状态',
  `collect_count` int(10) DEFAULT '0' COMMENT '领取数',
  `use_count` int(10) DEFAULT '0' COMMENT '已使用数',
  `manager_id` int(10) DEFAULT NULL COMMENT '管理员ID',
  `token` varchar(100) DEFAULT NULL COMMENT 'Token',
  `cTime` int(10) DEFAULT NULL COMMENT '创建时间',
  `member` varchar(100) DEFAULT '0' COMMENT '选择人群',
  `type` char(10) DEFAULT '0' COMMENT '优惠券类型',
  `is_del` int(10) DEFAULT '0' COMMENT '是否删除',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for wp_shop_vote
-- ----------------------------
DROP TABLE IF EXISTS `wp_shop_vote`;
CREATE TABLE `wp_shop_vote` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `title` varchar(255) DEFAULT NULL COMMENT '活动名称',
  `select_type` char(10) DEFAULT '1' COMMENT '投票类型',
  `multi_num` int(10) DEFAULT '0' COMMENT '多选限制',
  `start_time` int(10) DEFAULT NULL COMMENT '开始时间',
  `end_time` int(10) DEFAULT NULL COMMENT '结束时间',
  `remark` text COMMENT '活动说明',
  `token` varchar(255) DEFAULT NULL COMMENT 'token',
  `manager_id` int(10) DEFAULT NULL COMMENT '管理员id',
  `is_verify` tinyint(2) DEFAULT '0' COMMENT '投票是否需要填写验证码',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for wp_shop_vote_log
-- ----------------------------
DROP TABLE IF EXISTS `wp_shop_vote_log`;
CREATE TABLE `wp_shop_vote_log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `vote_id` int(10) DEFAULT NULL COMMENT '活动id',
  `option_id` int(10) DEFAULT NULL COMMENT '选项id',
  `uid` int(10) DEFAULT NULL COMMENT '投票者id',
  `token` varchar(255) DEFAULT NULL COMMENT 'token',
  `ctime` int(10) DEFAULT NULL COMMENT '投票时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for wp_shop_vote_option
-- ----------------------------
DROP TABLE IF EXISTS `wp_shop_vote_option`;
CREATE TABLE `wp_shop_vote_option` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `truename` varchar(255) DEFAULT NULL COMMENT '参赛者',
  `image` int(10) unsigned DEFAULT NULL COMMENT '参赛图片',
  `uid` int(10) DEFAULT NULL COMMENT '用户id',
  `manifesto` text COMMENT '参赛宣言',
  `introduce` text COMMENT '选手介绍',
  `ctime` int(10) DEFAULT NULL COMMENT '创建时间',
  `vote_id` int(10) DEFAULT NULL COMMENT '活动id',
  `opt_count` int(10) DEFAULT '0' COMMENT '投票数',
  `token` varchar(255) DEFAULT NULL COMMENT 'token',
  `number` int(10) DEFAULT '1' COMMENT '编号',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for wp_shouke
-- ----------------------------
DROP TABLE IF EXISTS `wp_shouke`;
CREATE TABLE `wp_shouke` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cid` int(11) DEFAULT NULL COMMENT '车辆id',
  `xtime` varchar(20) DEFAULT NULL COMMENT '学车时间',
  `xybh` varchar(20) DEFAULT NULL COMMENT '学员编号',
  `tbh` varchar(20) DEFAULT NULL COMMENT '教练编号',
  `num` varchar(20) DEFAULT NULL COMMENT '人数',
  `mark` varchar(30) DEFAULT NULL COMMENT '备注',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='教练授课‌信息表';

-- ----------------------------
-- Table structure for wp_signin_log
-- ----------------------------
DROP TABLE IF EXISTS `wp_signin_log`;
CREATE TABLE `wp_signin_log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `score` int(10) NOT NULL COMMENT '积分',
  `token` varchar(255) NOT NULL COMMENT 'Token',
  `sTime` int(10) unsigned NOT NULL COMMENT '签到时间',
  `uid` varchar(255) NOT NULL COMMENT '用户ID',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for wp_smalltools
-- ----------------------------
DROP TABLE IF EXISTS `wp_smalltools`;
CREATE TABLE `wp_smalltools` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `tooltype` tinyint(2) DEFAULT '0' COMMENT '工具类型',
  `keyword` varchar(255) DEFAULT NULL COMMENT ' 关键词 ',
  `cTime` int(10) DEFAULT NULL COMMENT '创建时间',
  `toolname` varchar(255) DEFAULT NULL COMMENT '工具名称',
  `tooldes` text COMMENT '工具描述',
  `toolnum` varchar(255) DEFAULT NULL COMMENT '工具唯一编号',
  `toolstate` tinyint(2) DEFAULT '0' COMMENT '工具状态',
  `token` varchar(255) DEFAULT NULL COMMENT 'Token',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for wp_sms
-- ----------------------------
DROP TABLE IF EXISTS `wp_sms`;
CREATE TABLE `wp_sms` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `from_type` varchar(255) DEFAULT NULL COMMENT '用途',
  `code` varchar(255) DEFAULT NULL COMMENT '验证码',
  `smsId` varchar(255) DEFAULT NULL COMMENT '短信唯一标识',
  `phone` varchar(255) DEFAULT NULL COMMENT '手机号',
  `cTime` int(10) DEFAULT NULL COMMENT '创建时间',
  `status` int(10) DEFAULT NULL COMMENT '使用状态',
  `plat_type` int(10) DEFAULT NULL COMMENT '平台标识',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for wp_sn_code
-- ----------------------------
DROP TABLE IF EXISTS `wp_sn_code`;
CREATE TABLE `wp_sn_code` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `sn` varchar(255) DEFAULT NULL COMMENT 'SN码',
  `uid` int(10) DEFAULT NULL COMMENT '粉丝UID',
  `cTime` int(10) DEFAULT NULL COMMENT '创建时间',
  `is_use` tinyint(2) DEFAULT '0' COMMENT '是否已使用',
  `use_time` int(10) DEFAULT NULL COMMENT '使用时间',
  `addon` varchar(255) DEFAULT 'Coupon' COMMENT '来自的插件',
  `target_id` int(10) unsigned DEFAULT NULL COMMENT '来源ID',
  `prize_id` int(10) unsigned DEFAULT NULL COMMENT '奖项ID',
  `status` tinyint(2) NOT NULL DEFAULT '1' COMMENT '是否可用',
  `prize_title` varchar(255) DEFAULT NULL COMMENT '奖项',
  `token` varchar(255) DEFAULT NULL COMMENT 'Token',
  `can_use` tinyint(2) DEFAULT '1' COMMENT '是否可用',
  `server_addr` varchar(50) DEFAULT NULL COMMENT '服务器IP',
  `admin_uid` int(10) DEFAULT NULL COMMENT '核销管理员ID',
  PRIMARY KEY (`id`),
  KEY `id` (`uid`,`target_id`,`addon`),
  KEY `addon` (`target_id`,`addon`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for wp_sports
-- ----------------------------
DROP TABLE IF EXISTS `wp_sports`;
CREATE TABLE `wp_sports` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `home_team` varchar(255) DEFAULT NULL COMMENT '主场球队',
  `visit_team` varchar(255) DEFAULT NULL COMMENT '客场球队',
  `start_time` int(10) DEFAULT NULL COMMENT '时间',
  `score` varchar(30) DEFAULT NULL COMMENT '比分',
  `content` text COMMENT '说明',
  `countdown` int(10) DEFAULT '60' COMMENT '擂鼓时长',
  `drum_count` int(10) DEFAULT '0' COMMENT '擂鼓次数',
  `drum_follow_count` int(10) DEFAULT '0' COMMENT '擂鼓人数',
  `home_team_support_count` int(10) DEFAULT '0' COMMENT '主场球队支持数',
  `visit_team_support_count` int(10) DEFAULT '0' COMMENT '客场球队支持人数',
  `home_team_drum_count` int(10) DEFAULT '0' COMMENT '主场球队擂鼓数',
  `visit_team_drum_count` int(10) DEFAULT '0' COMMENT '客场球队擂鼓数',
  `yaotv_count` int(10) DEFAULT '0' COMMENT '摇一摇总次',
  `draw_count` int(10) DEFAULT '0' COMMENT '抽奖总次数',
  `is_finish` tinyint(2) DEFAULT '0' COMMENT '是否已结束',
  `yaotv_follow_count` int(10) DEFAULT '0' COMMENT '摇电视总人数',
  `draw_follow_count` int(10) DEFAULT '0' COMMENT '抽奖总人数',
  `comment_status` tinyint(2) DEFAULT '0' COMMENT '评论是否需要审核',
  PRIMARY KEY (`id`),
  KEY `start_time` (`start_time`,`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for wp_sports_drum
-- ----------------------------
DROP TABLE IF EXISTS `wp_sports_drum`;
CREATE TABLE `wp_sports_drum` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `sports_id` int(10) DEFAULT NULL COMMENT '场次ID',
  `team_id` int(10) DEFAULT NULL COMMENT '球队ID',
  `follow_id` int(10) DEFAULT NULL COMMENT '用户ID',
  `drum_count` int(10) DEFAULT NULL COMMENT '擂鼓次数',
  `cTime` int(10) DEFAULT NULL COMMENT '时间',
  PRIMARY KEY (`id`),
  KEY `ctime` (`sports_id`,`cTime`),
  KEY `team_id` (`sports_id`,`team_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for wp_sports_join
-- ----------------------------
DROP TABLE IF EXISTS `wp_sports_join`;
CREATE TABLE `wp_sports_join` (
  `follow_id` int(11) DEFAULT NULL,
  `sports_id` int(11) DEFAULT NULL,
  `time` int(11) DEFAULT NULL,
  KEY `time` (`time`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for wp_sports_support
-- ----------------------------
DROP TABLE IF EXISTS `wp_sports_support`;
CREATE TABLE `wp_sports_support` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `sports_id` int(10) DEFAULT NULL COMMENT '场次ID',
  `team_id` int(10) DEFAULT NULL COMMENT '球队ID',
  `follow_id` int(10) DEFAULT NULL COMMENT '用户ID',
  `cTime` int(10) DEFAULT NULL COMMENT '支持时间',
  PRIMARY KEY (`id`),
  KEY `sf` (`sports_id`,`follow_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for wp_sports_team
-- ----------------------------
DROP TABLE IF EXISTS `wp_sports_team`;
CREATE TABLE `wp_sports_team` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `title` varchar(100) DEFAULT NULL COMMENT '球队名称',
  `logo` int(10) unsigned DEFAULT NULL COMMENT '球队图标',
  `intro` text COMMENT '球队说明',
  `pid` int(10) DEFAULT '0' COMMENT 'pid',
  `sort` int(10) DEFAULT '0' COMMENT '排序号',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for wp_sport_award
-- ----------------------------
DROP TABLE IF EXISTS `wp_sport_award`;
CREATE TABLE `wp_sport_award` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `name` varchar(255) NOT NULL COMMENT '奖项名称',
  `img` int(10) NOT NULL COMMENT '奖品图片',
  `price` float DEFAULT '0' COMMENT '商品价格',
  `explain` text COMMENT '奖品说明',
  `award_type` varchar(30) DEFAULT '1' COMMENT '奖品类型',
  `count` int(10) NOT NULL COMMENT '奖品数量',
  `sort` int(10) unsigned DEFAULT '0' COMMENT '排序号',
  `score` int(10) DEFAULT '0' COMMENT '积分数',
  `uid` int(10) DEFAULT NULL COMMENT 'uid',
  `token` varchar(255) DEFAULT NULL COMMENT 'token',
  `coupon_id` char(50) DEFAULT NULL COMMENT '选择赠送券',
  `money` float DEFAULT NULL COMMENT '返现金额',
  `aim_table` varchar(255) DEFAULT NULL COMMENT '活动标识',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for wp_store
-- ----------------------------
DROP TABLE IF EXISTS `wp_store`;
CREATE TABLE `wp_store` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `title` varchar(255) NOT NULL COMMENT '标题',
  `uid` int(10) DEFAULT '0' COMMENT '用户ID',
  `content` text COMMENT '内容',
  `cTime` int(10) DEFAULT NULL COMMENT '发布时间',
  `attach` varchar(255) DEFAULT NULL COMMENT '插件安装包',
  `is_top` int(10) DEFAULT '0' COMMENT '置顶',
  `cid` tinyint(4) DEFAULT NULL COMMENT '分类',
  `view_count` int(11) unsigned DEFAULT '0' COMMENT '浏览数',
  `img_1` int(10) unsigned DEFAULT NULL COMMENT '插件截图1',
  `img_2` int(10) unsigned DEFAULT NULL COMMENT '插件截图2',
  `img_3` int(10) unsigned DEFAULT NULL COMMENT '插件截图3',
  `img_4` int(10) unsigned DEFAULT NULL COMMENT '插件截图4',
  `download_count` int(10) unsigned DEFAULT '0' COMMENT '下载数',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for wp_sucai
-- ----------------------------
DROP TABLE IF EXISTS `wp_sucai`;
CREATE TABLE `wp_sucai` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `name` varchar(100) DEFAULT NULL COMMENT '素材名称',
  `status` char(10) DEFAULT 'UnSubmit' COMMENT '状态',
  `cTime` int(10) DEFAULT NULL COMMENT '提交时间',
  `url` varchar(255) DEFAULT NULL COMMENT '实际摇一摇所使用的页面URL',
  `type` varchar(255) DEFAULT NULL COMMENT '素材类型',
  `detail` text COMMENT '素材内容',
  `reason` text COMMENT '入库失败的原因',
  `create_time` int(10) DEFAULT NULL COMMENT '申请时间',
  `checked_time` int(10) DEFAULT NULL COMMENT '入库时间',
  `source` varchar(50) DEFAULT NULL COMMENT '来源',
  `source_id` int(10) DEFAULT NULL COMMENT '来源ID',
  `wechat_id` int(10) DEFAULT NULL COMMENT '微信端的素材ID',
  `uid` int(10) DEFAULT NULL COMMENT 'uid',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for wp_sucai_template
-- ----------------------------
DROP TABLE IF EXISTS `wp_sucai_template`;
CREATE TABLE `wp_sucai_template` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `uid` int(10) DEFAULT NULL COMMENT '管理员id',
  `token` varchar(255) DEFAULT NULL COMMENT '用户token',
  `addons` varchar(255) DEFAULT NULL COMMENT '插件名称',
  `template` varchar(255) DEFAULT NULL COMMENT '模版名称',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for wp_survey
-- ----------------------------
DROP TABLE IF EXISTS `wp_survey`;
CREATE TABLE `wp_survey` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `keyword` varchar(100) NOT NULL COMMENT '关键词',
  `keyword_type` tinyint(2) NOT NULL DEFAULT '0' COMMENT '关键词类型',
  `title` varchar(255) NOT NULL COMMENT '标题',
  `intro` text COMMENT '封面简介',
  `mTime` int(10) DEFAULT NULL COMMENT '修改时间',
  `cover` int(10) unsigned DEFAULT NULL COMMENT '封面图片',
  `cTime` int(10) unsigned DEFAULT NULL COMMENT '发布时间',
  `token` varchar(255) DEFAULT NULL COMMENT 'Token',
  `finish_tip` text COMMENT '结束语',
  `template` varchar(255) DEFAULT 'default' COMMENT '素材模板',
  `start_time` int(10) DEFAULT NULL COMMENT '开始时间',
  `end_time` int(10) DEFAULT NULL COMMENT '结束时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for wp_survey_answer
-- ----------------------------
DROP TABLE IF EXISTS `wp_survey_answer`;
CREATE TABLE `wp_survey_answer` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `cTime` int(10) unsigned DEFAULT NULL COMMENT '发布时间',
  `token` varchar(255) DEFAULT NULL COMMENT 'Token',
  `survey_id` int(10) unsigned NOT NULL COMMENT 'survey_id',
  `question_id` int(10) unsigned NOT NULL COMMENT 'question_id',
  `uid` int(10) DEFAULT NULL COMMENT '用户UID',
  `openid` varchar(255) DEFAULT NULL COMMENT 'OpenId',
  `answer` text COMMENT '回答内容',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for wp_survey_question
-- ----------------------------
DROP TABLE IF EXISTS `wp_survey_question`;
CREATE TABLE `wp_survey_question` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `title` varchar(255) NOT NULL COMMENT '标题',
  `intro` text COMMENT '问题描述',
  `cTime` int(10) unsigned DEFAULT NULL COMMENT '发布时间',
  `token` varchar(255) DEFAULT NULL COMMENT 'Token',
  `survey_id` int(10) unsigned NOT NULL COMMENT 'survey_id',
  `type` char(50) NOT NULL DEFAULT 'radio' COMMENT '问题类型',
  `extra` text COMMENT '参数',
  `is_must` tinyint(2) DEFAULT '0' COMMENT '是否必填',
  `sort` int(10) unsigned DEFAULT '0' COMMENT '排序号',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for wp_system_notice
-- ----------------------------
DROP TABLE IF EXISTS `wp_system_notice`;
CREATE TABLE `wp_system_notice` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `title` varchar(255) DEFAULT NULL COMMENT '公告标题',
  `content` text COMMENT '公告内容',
  `create_time` int(10) DEFAULT NULL COMMENT '发布时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for wp_test
-- ----------------------------
DROP TABLE IF EXISTS `wp_test`;
CREATE TABLE `wp_test` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `keyword` varchar(100) NOT NULL COMMENT '关键词',
  `keyword_type` tinyint(2) NOT NULL DEFAULT '0' COMMENT '关键词匹配类型',
  `title` varchar(255) NOT NULL COMMENT '问卷标题',
  `intro` text NOT NULL COMMENT '封面简介',
  `mTime` int(10) NOT NULL COMMENT '修改时间',
  `cover` int(10) unsigned NOT NULL COMMENT '封面图片',
  `token` varchar(255) NOT NULL COMMENT 'Token',
  `finish_tip` text NOT NULL COMMENT '评论语',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for wp_test_answer
-- ----------------------------
DROP TABLE IF EXISTS `wp_test_answer`;
CREATE TABLE `wp_test_answer` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `answer` text NOT NULL COMMENT '回答内容',
  `openid` varchar(255) NOT NULL COMMENT 'OpenId',
  `uid` int(10) NOT NULL COMMENT '用户UID',
  `question_id` int(10) unsigned NOT NULL COMMENT 'question_id',
  `cTime` int(10) unsigned NOT NULL COMMENT '发布时间',
  `token` varchar(255) NOT NULL COMMENT 'Token',
  `test_id` int(10) unsigned NOT NULL COMMENT 'test_id',
  `score` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '得分',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for wp_test_question
-- ----------------------------
DROP TABLE IF EXISTS `wp_test_question`;
CREATE TABLE `wp_test_question` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `title` varchar(255) NOT NULL COMMENT '题目标题',
  `intro` text NOT NULL COMMENT '题目描述',
  `cTime` int(10) unsigned NOT NULL COMMENT '发布时间',
  `token` varchar(255) NOT NULL COMMENT 'Token',
  `is_must` tinyint(2) NOT NULL DEFAULT '1' COMMENT '是否必填',
  `extra` text NOT NULL COMMENT '参数',
  `type` char(50) NOT NULL DEFAULT 'radio' COMMENT '题目类型',
  `test_id` int(10) unsigned NOT NULL COMMENT 'test_id',
  `sort` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序号',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for wp_tuikuan
-- ----------------------------
DROP TABLE IF EXISTS `wp_tuikuan`;
CREATE TABLE `wp_tuikuan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT NULL,
  `xid` int(11) DEFAULT NULL COMMENT '学员id',
  `jid` int(11) DEFAULT NULL COMMENT '教练id',
  `pch` varchar(50) DEFAULT NULL COMMENT '车号',
  `pdata` varchar(50) DEFAULT NULL COMMENT '日期',
  `ptime` text COMMENT '时间段',
  `pid` varchar(255) DEFAULT NULL COMMENT '时间段id',
  `dbh` varchar(30) DEFAULT NULL COMMENT '订单编号',
  `km` varchar(15) DEFAULT NULL COMMENT '科目',
  `fs` varchar(20) DEFAULT NULL COMMENT '支付方式（微信/支付宝）',
  `shouxu` varchar(255) DEFAULT NULL,
  `num` varchar(255) DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL COMMENT '订单状态0:已缴费1:已退款 2:已消费3:退款中',
  `mark` varchar(30) DEFAULT NULL COMMENT '备注',
  `mch_id` varchar(255) DEFAULT NULL COMMENT '商户号',
  `transaction_id` varchar(255) DEFAULT NULL COMMENT '微信支付订单号',
  `out_trade_no` varchar(255) DEFAULT NULL COMMENT '商户系统的订单号',
  `out_refund_no` varchar(255) DEFAULT NULL COMMENT '商户退款单号',
  `refund_id` varchar(255) DEFAULT NULL COMMENT '微信退款单号',
  `refund_fee` varchar(255) DEFAULT NULL COMMENT '退款金额',
  `time_end` varchar(50) DEFAULT NULL COMMENT '支付完成时间',
  `taddtime` varchar(50) DEFAULT NULL COMMENT '添加时间',
  `twark` text COMMENT '退款说明',
  `money` varchar(15) DEFAULT NULL COMMENT '缴费金额',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1046 DEFAULT CHARSET=utf8 COMMENT='订单信息表';

-- ----------------------------
-- Table structure for wp_update_score_log
-- ----------------------------
DROP TABLE IF EXISTS `wp_update_score_log`;
CREATE TABLE `wp_update_score_log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `score` int(10) DEFAULT NULL COMMENT '修改积分',
  `branch_id` int(10) DEFAULT NULL COMMENT '修改门店',
  `operator` varchar(255) DEFAULT NULL COMMENT '操作员',
  `cTime` int(10) DEFAULT NULL COMMENT '修改时间',
  `token` varchar(255) DEFAULT NULL COMMENT 'token',
  `member_id` int(10) DEFAULT NULL COMMENT '会员卡id',
  `manager_id` int(10) DEFAULT NULL COMMENT '管理员id',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for wp_update_version
-- ----------------------------
DROP TABLE IF EXISTS `wp_update_version`;
CREATE TABLE `wp_update_version` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `version` int(10) unsigned NOT NULL COMMENT '版本号',
  `title` varchar(50) NOT NULL COMMENT '升级包名',
  `description` text COMMENT '描述',
  `create_date` int(10) DEFAULT NULL COMMENT '创建时间',
  `download_count` int(10) unsigned DEFAULT '0' COMMENT '下载统计',
  `package` varchar(255) NOT NULL COMMENT '升级包地址',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for wp_user
-- ----------------------------
DROP TABLE IF EXISTS `wp_user`;
CREATE TABLE `wp_user` (
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `nickname` text COMMENT '用户名',
  `password` varchar(100) DEFAULT NULL COMMENT '登录密码',
  `truename` varchar(30) DEFAULT NULL COMMENT '真实姓名',
  `mobile` varchar(30) DEFAULT NULL COMMENT '联系电话',
  `email` varchar(100) DEFAULT NULL COMMENT '邮箱地址',
  `sex` tinyint(2) DEFAULT NULL COMMENT '性别',
  `headimgurl` varchar(255) DEFAULT NULL COMMENT '头像地址',
  `city` varchar(30) DEFAULT NULL COMMENT '城市',
  `province` varchar(30) DEFAULT NULL COMMENT '省份',
  `country` varchar(30) DEFAULT NULL COMMENT '国家',
  `language` varchar(20) DEFAULT 'zh-cn' COMMENT '语言',
  `score` int(10) DEFAULT '0' COMMENT '金币值',
  `experience` int(10) DEFAULT '0' COMMENT '经验值',
  `unionid` varchar(50) DEFAULT NULL COMMENT '微信第三方ID',
  `login_count` int(10) DEFAULT '0' COMMENT '登录次数',
  `reg_ip` varchar(30) DEFAULT NULL COMMENT '注册IP',
  `reg_time` int(10) DEFAULT NULL COMMENT '注册时间',
  `last_login_ip` varchar(30) DEFAULT NULL COMMENT '最近登录IP',
  `last_login_time` int(10) DEFAULT NULL COMMENT '最近登录时间',
  `status` tinyint(2) DEFAULT '1' COMMENT '状态',
  `is_init` tinyint(2) DEFAULT '0' COMMENT '初始化状态',
  `is_audit` tinyint(2) DEFAULT '0' COMMENT '审核状态',
  `subscribe_time` int(10) DEFAULT NULL COMMENT '用户关注公众号时间',
  `remark` varchar(100) DEFAULT NULL COMMENT '微信用户备注',
  `groupid` int(10) DEFAULT NULL COMMENT '微信端的分组ID',
  `come_from` tinyint(1) DEFAULT '0' COMMENT '来源',
  `login_name` varchar(100) DEFAULT NULL COMMENT 'login_name',
  `login_password` varchar(255) DEFAULT NULL COMMENT '登录密码',
  `manager_id` int(10) DEFAULT '0' COMMENT '公众号管理员ID',
  `level` tinyint(2) DEFAULT '0' COMMENT '管理等级',
  `membership` char(50) DEFAULT '0' COMMENT '会员等级',
  `jxid` int(10) DEFAULT NULL COMMENT '驾校id',
  PRIMARY KEY (`uid`)
) ENGINE=MyISAM AUTO_INCREMENT=34483 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for wp_user_follow
-- ----------------------------
DROP TABLE IF EXISTS `wp_user_follow`;
CREATE TABLE `wp_user_follow` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT NULL,
  `publicid` int(11) DEFAULT NULL,
  `follow_id` int(11) DEFAULT NULL,
  `url` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for wp_user_tag
-- ----------------------------
DROP TABLE IF EXISTS `wp_user_tag`;
CREATE TABLE `wp_user_tag` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `title` varchar(50) DEFAULT NULL COMMENT '标签名称',
  `token` varchar(100) DEFAULT NULL COMMENT 'token',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for wp_user_tag_link
-- ----------------------------
DROP TABLE IF EXISTS `wp_user_tag_link`;
CREATE TABLE `wp_user_tag_link` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `uid` int(10) DEFAULT NULL COMMENT 'uid',
  `tag_id` int(10) DEFAULT NULL COMMENT 'tag_id',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for wp_visit_log
-- ----------------------------
DROP TABLE IF EXISTS `wp_visit_log`;
CREATE TABLE `wp_visit_log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `publicid` int(10) DEFAULT '0' COMMENT 'publicid',
  `module_name` varchar(30) DEFAULT NULL COMMENT 'module_name',
  `controller_name` varchar(30) DEFAULT NULL COMMENT 'controller_name',
  `action_name` varchar(30) DEFAULT NULL COMMENT 'action_name',
  `uid` varchar(255) DEFAULT '0' COMMENT 'uid',
  `ip` varchar(30) DEFAULT NULL COMMENT 'ip',
  `brower` varchar(30) DEFAULT NULL COMMENT 'brower',
  `param` text COMMENT 'param',
  `referer` varchar(255) DEFAULT NULL COMMENT 'referer',
  `cTime` int(10) DEFAULT NULL COMMENT '时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=155955 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for wp_vote
-- ----------------------------
DROP TABLE IF EXISTS `wp_vote`;
CREATE TABLE `wp_vote` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `keyword` varchar(50) NOT NULL COMMENT '关键词',
  `title` varchar(100) NOT NULL COMMENT '投票标题',
  `description` text COMMENT '投票描述',
  `picurl` int(10) unsigned DEFAULT NULL COMMENT '封面图片',
  `type` char(10) NOT NULL DEFAULT '0' COMMENT '选择类型',
  `start_date` int(10) DEFAULT NULL COMMENT '开始日期',
  `end_date` int(10) DEFAULT NULL COMMENT '结束日期',
  `is_img` tinyint(2) DEFAULT '0' COMMENT '文字/图片投票',
  `vote_count` int(10) unsigned DEFAULT '0' COMMENT '投票数',
  `cTime` int(10) DEFAULT NULL COMMENT '投票创建时间',
  `mTime` int(10) DEFAULT NULL COMMENT '更新时间',
  `token` varchar(255) DEFAULT NULL COMMENT 'Token',
  `template` varchar(255) DEFAULT 'default' COMMENT '素材模板',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for wp_vote_log
-- ----------------------------
DROP TABLE IF EXISTS `wp_vote_log`;
CREATE TABLE `wp_vote_log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `vote_id` int(10) unsigned DEFAULT NULL COMMENT '投票ID',
  `user_id` int(10) DEFAULT NULL COMMENT '用户ID',
  `token` varchar(255) DEFAULT NULL COMMENT '用户TOKEN',
  `options` varchar(255) DEFAULT NULL COMMENT '选择选项',
  `cTime` int(10) DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for wp_vote_option
-- ----------------------------
DROP TABLE IF EXISTS `wp_vote_option`;
CREATE TABLE `wp_vote_option` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `vote_id` int(10) unsigned NOT NULL COMMENT '投票ID',
  `name` varchar(255) NOT NULL COMMENT '选项标题',
  `image` int(10) unsigned DEFAULT NULL COMMENT '图片选项',
  `opt_count` int(10) unsigned DEFAULT '0' COMMENT '当前选项投票数',
  `order` int(10) unsigned DEFAULT '0' COMMENT '选项排序',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for wp_weiba
-- ----------------------------
DROP TABLE IF EXISTS `wp_weiba`;
CREATE TABLE `wp_weiba` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `cid` varchar(100) DEFAULT NULL COMMENT '所属分类',
  `weiba_name` varchar(255) DEFAULT NULL COMMENT '版块名称',
  `uid` int(10) DEFAULT NULL COMMENT '创建者ID',
  `ctime` int(10) DEFAULT NULL COMMENT '创建时间',
  `logo` int(10) unsigned DEFAULT NULL COMMENT '版块图标',
  `intro` text COMMENT '版块说明',
  `who_can_post` tinyint(1) DEFAULT '0' COMMENT '发帖权限',
  `who_can_reply` tinyint(1) DEFAULT '0' COMMENT '回帖权限',
  `follower_count` int(10) DEFAULT '0' COMMENT '成员数',
  `thread_count` int(10) DEFAULT '0' COMMENT '帖子数',
  `admin_uid` varchar(255) DEFAULT NULL COMMENT '版主',
  `recommend` tinyint(1) DEFAULT '0' COMMENT '是否设置为推荐',
  `status` tinyint(1) DEFAULT '1' COMMENT '审核状态',
  `is_del` tinyint(1) DEFAULT '0' COMMENT '是否删除',
  `notify` text COMMENT '版块公告',
  `avatar_big` text COMMENT 'avatar_big',
  `avatar_middle` text COMMENT 'avatar_middle',
  `new_count` int(10) DEFAULT '0' COMMENT '最新帖子数',
  `new_day` date DEFAULT NULL COMMENT 'new_day',
  `info` varchar(255) DEFAULT NULL COMMENT '申请附件信息',
  `token` varchar(100) DEFAULT NULL COMMENT 'token',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for wp_weiba_apply
-- ----------------------------
DROP TABLE IF EXISTS `wp_weiba_apply`;
CREATE TABLE `wp_weiba_apply` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `follower_uid` int(11) NOT NULL COMMENT '申请者UID',
  `weiba_id` int(11) NOT NULL COMMENT '微吧id',
  `type` tinyint(2) NOT NULL COMMENT '申请类型 1-圈主 2-小主',
  `reason` varchar(255) DEFAULT NULL COMMENT '申请原因',
  `status` tinyint(2) NOT NULL COMMENT '状态 0-待审核 1-审核通过 -1-驳回',
  `manager_uid` int(11) NOT NULL COMMENT '操作者UID',
  `city` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for wp_weiba_blacklist
-- ----------------------------
DROP TABLE IF EXISTS `wp_weiba_blacklist`;
CREATE TABLE `wp_weiba_blacklist` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `weiba_id` int(11) NOT NULL COMMENT '微吧ID',
  `uid` int(11) NOT NULL COMMENT '成员ID',
  `cTime` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for wp_weiba_category
-- ----------------------------
DROP TABLE IF EXISTS `wp_weiba_category`;
CREATE TABLE `wp_weiba_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL COMMENT '分类名称',
  `token` varchar(100) DEFAULT NULL COMMENT 'token',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for wp_weiba_event
-- ----------------------------
DROP TABLE IF EXISTS `wp_weiba_event`;
CREATE TABLE `wp_weiba_event` (
  `event_id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT NULL COMMENT '创建者',
  `post_id` int(255) DEFAULT NULL COMMENT '对应的话题ID',
  `cover` int(11) DEFAULT NULL,
  `start_time` int(11) DEFAULT NULL COMMENT '开始时间',
  `end_time` int(11) DEFAULT NULL COMMENT '结束时间',
  `deadline` int(11) DEFAULT NULL COMMENT '报名截止',
  `area` varchar(255) DEFAULT NULL COMMENT '城市',
  `address` varchar(255) DEFAULT NULL COMMENT '具体地址',
  `max` int(11) DEFAULT NULL COMMENT '最大报名人数',
  `join_count` int(11) DEFAULT '0' COMMENT '报名数',
  `share_img` int(11) DEFAULT NULL COMMENT '分享图片',
  `share_title` varchar(255) DEFAULT NULL COMMENT '分享标题',
  `share_desc` varchar(255) DEFAULT NULL COMMENT '分享描述',
  `ctime` int(11) DEFAULT NULL,
  `is_del` tinyint(1) DEFAULT '0',
  `city` int(11) DEFAULT NULL,
  PRIMARY KEY (`event_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for wp_weiba_event_attr
-- ----------------------------
DROP TABLE IF EXISTS `wp_weiba_event_attr`;
CREATE TABLE `wp_weiba_event_attr` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `event_id` int(11) DEFAULT NULL,
  `type` char(50) DEFAULT NULL COMMENT '控件类型',
  `label` varchar(255) DEFAULT NULL,
  `extra` text COMMENT '参数',
  `default_value` varchar(255) DEFAULT NULL,
  `is_must` tinyint(1) DEFAULT '0' COMMENT '0可选 1必填',
  `sort` int(11) DEFAULT NULL COMMENT '排序',
  `name` varchar(255) DEFAULT NULL COMMENT '控件名',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for wp_weiba_event_user
-- ----------------------------
DROP TABLE IF EXISTS `wp_weiba_event_user`;
CREATE TABLE `wp_weiba_event_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT NULL,
  `event_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `value` text,
  `ctime` int(11) DEFAULT NULL,
  `is_refuse` tinyint(2) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for wp_weiba_favorite
-- ----------------------------
DROP TABLE IF EXISTS `wp_weiba_favorite`;
CREATE TABLE `wp_weiba_favorite` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL COMMENT '收藏者UID',
  `post_id` int(11) NOT NULL COMMENT '帖子ID',
  `weiba_id` int(11) NOT NULL COMMENT '微吧ID',
  `post_uid` int(11) NOT NULL COMMENT '发布者UID',
  `favorite_time` int(11) NOT NULL COMMENT '收藏时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for wp_weiba_follow
-- ----------------------------
DROP TABLE IF EXISTS `wp_weiba_follow`;
CREATE TABLE `wp_weiba_follow` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `weiba_id` int(11) NOT NULL COMMENT '微吧ID',
  `follower_uid` int(11) NOT NULL COMMENT '成员ID',
  `level` tinyint(1) NOT NULL DEFAULT '1' COMMENT '等级 1-粉丝 2-小主 3-圈主',
  PRIMARY KEY (`id`),
  KEY `uid` (`follower_uid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for wp_weiba_log
-- ----------------------------
DROP TABLE IF EXISTS `wp_weiba_log`;
CREATE TABLE `wp_weiba_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `weiba_id` int(11) NOT NULL COMMENT '微吧ID',
  `uid` int(11) NOT NULL COMMENT '操作者UID',
  `type` varchar(10) NOT NULL COMMENT '操作类型',
  `content` text NOT NULL COMMENT '管理内容',
  `ctime` int(11) NOT NULL COMMENT '操作时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for wp_weiba_post
-- ----------------------------
DROP TABLE IF EXISTS `wp_weiba_post`;
CREATE TABLE `wp_weiba_post` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `weiba_id` int(10) DEFAULT NULL COMMENT '所属版块',
  `post_uid` int(10) DEFAULT NULL COMMENT '发表者uid',
  `title` varchar(255) NOT NULL COMMENT '帖子标题',
  `content` text NOT NULL COMMENT '帖子内容',
  `post_time` int(10) DEFAULT NULL COMMENT '发表时间',
  `reply_count` int(10) DEFAULT '0' COMMENT '回复数',
  `read_count` int(10) DEFAULT '0' COMMENT '浏览数',
  `last_reply_uid` varchar(50) DEFAULT '0' COMMENT '最后回复人',
  `last_reply_time` int(10) DEFAULT '0' COMMENT '最后回复时间',
  `digest` tinyint(1) DEFAULT '0' COMMENT '全局精华',
  `top` tinyint(2) DEFAULT '0' COMMENT '置顶帖',
  `lock` tinyint(1) DEFAULT '0' COMMENT '锁帖',
  `recommend` tinyint(1) DEFAULT '0' COMMENT '是否设为推荐',
  `recommend_time` int(10) DEFAULT '0' COMMENT '设为推荐的时间',
  `is_del` tinyint(2) DEFAULT '0' COMMENT '是否已删除',
  `reply_all_count` int(11) DEFAULT '0' COMMENT '全部评论数目',
  `attach` varchar(255) DEFAULT NULL COMMENT 'attach',
  `praise` int(10) DEFAULT '0' COMMENT '喜欢',
  `from` tinyint(1) DEFAULT '1' COMMENT '客户端类型',
  `top_time` int(10) DEFAULT '0' COMMENT 'top_time',
  `is_index` tinyint(2) DEFAULT '0' COMMENT '是否推荐到首页',
  `index_img` int(10) unsigned DEFAULT NULL COMMENT 'index_img',
  `is_index_time` int(10) DEFAULT NULL COMMENT 'is_index_time',
  `img_ids` varchar(255) DEFAULT NULL COMMENT 'img_ids',
  `tag_id` int(10) DEFAULT '0' COMMENT '标签',
  `index_order` int(10) DEFAULT '0' COMMENT '首页帖子排序',
  `is_event` tinyint(2) DEFAULT '0' COMMENT '类型',
  `globle_recommend` tinyint(2) DEFAULT '0' COMMENT '推荐到全站',
  `token` varchar(100) DEFAULT NULL COMMENT 'token',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for wp_weiba_post_digg
-- ----------------------------
DROP TABLE IF EXISTS `wp_weiba_post_digg`;
CREATE TABLE `wp_weiba_post_digg` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `cTime` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for wp_weiba_post_share_logs
-- ----------------------------
DROP TABLE IF EXISTS `wp_weiba_post_share_logs`;
CREATE TABLE `wp_weiba_post_share_logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `post_id` int(11) DEFAULT NULL,
  `uid` int(11) DEFAULT '0' COMMENT '分享的用户id',
  `type` varchar(255) DEFAULT NULL COMMENT '分享方式',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for wp_weiba_reply
-- ----------------------------
DROP TABLE IF EXISTS `wp_weiba_reply`;
CREATE TABLE `wp_weiba_reply` (
  `reply_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '回复ID',
  `weiba_id` int(11) NOT NULL COMMENT '所属微吧',
  `post_id` int(11) NOT NULL COMMENT '所属帖子ID',
  `post_uid` int(11) NOT NULL COMMENT '帖子作者UID',
  `uid` int(11) NOT NULL COMMENT '回复者ID',
  `to_reply_id` int(11) NOT NULL DEFAULT '0' COMMENT '回复的评论id',
  `to_uid` int(11) NOT NULL DEFAULT '0' COMMENT '被回复的评论的作者的uid',
  `ctime` int(11) NOT NULL COMMENT '回复时间',
  `content` text NOT NULL COMMENT '回复内容',
  `is_del` tinyint(2) DEFAULT '0' COMMENT '是否已删除 0-否 1-是',
  `comment_id` int(11) NOT NULL COMMENT '对应的分享评论ID',
  `storey` int(11) NOT NULL DEFAULT '0' COMMENT '绝对楼层',
  `attach_id` int(11) NOT NULL,
  `digg_count` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`reply_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for wp_weiba_reply_digg
-- ----------------------------
DROP TABLE IF EXISTS `wp_weiba_reply_digg`;
CREATE TABLE `wp_weiba_reply_digg` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `row_id` int(11) NOT NULL,
  `cTime` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for wp_weiba_tag
-- ----------------------------
DROP TABLE IF EXISTS `wp_weiba_tag`;
CREATE TABLE `wp_weiba_tag` (
  `weiba_id` int(11) NOT NULL,
  `tag_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL COMMENT '名称',
  `city` int(11) DEFAULT NULL COMMENT '城市',
  PRIMARY KEY (`tag_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for wp_weisite_category
-- ----------------------------
DROP TABLE IF EXISTS `wp_weisite_category`;
CREATE TABLE `wp_weisite_category` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `title` varchar(100) NOT NULL COMMENT '分类标题',
  `icon` int(10) unsigned DEFAULT NULL COMMENT '分类图片',
  `url` varchar(255) DEFAULT NULL COMMENT '外链',
  `is_show` tinyint(2) DEFAULT '1' COMMENT '显示',
  `token` varchar(100) DEFAULT NULL COMMENT 'Token',
  `sort` int(10) DEFAULT '0' COMMENT '排序号',
  `pid` int(10) DEFAULT '0' COMMENT '一级目录',
  `template` varchar(255) DEFAULT NULL COMMENT '二级模板',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=28 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for wp_weisite_cms
-- ----------------------------
DROP TABLE IF EXISTS `wp_weisite_cms`;
CREATE TABLE `wp_weisite_cms` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `keyword` varchar(100) NOT NULL COMMENT '关键词',
  `keyword_type` tinyint(2) DEFAULT NULL COMMENT '关键词类型',
  `title` varchar(255) NOT NULL COMMENT '标题',
  `intro` text COMMENT '简介',
  `cate_id` int(10) unsigned DEFAULT '0' COMMENT '所属类别',
  `cover` int(10) unsigned DEFAULT NULL COMMENT '封面图片',
  `content` text COMMENT '内容',
  `cTime` int(10) DEFAULT NULL COMMENT '发布时间',
  `sort` int(10) unsigned DEFAULT '0' COMMENT '排序号',
  `view_count` int(10) unsigned DEFAULT '0' COMMENT '浏览数',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for wp_weisite_footer
-- ----------------------------
DROP TABLE IF EXISTS `wp_weisite_footer`;
CREATE TABLE `wp_weisite_footer` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `url` varchar(255) DEFAULT NULL COMMENT '关联URL',
  `title` varchar(50) NOT NULL COMMENT '菜单名',
  `pid` tinyint(2) DEFAULT '0' COMMENT '一级菜单',
  `sort` tinyint(4) DEFAULT '0' COMMENT '排序号',
  `token` varchar(255) DEFAULT NULL COMMENT 'Token',
  `icon` int(10) unsigned DEFAULT NULL COMMENT '图标',
  PRIMARY KEY (`id`),
  KEY `token` (`token`,`pid`,`sort`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for wp_weisite_slideshow
-- ----------------------------
DROP TABLE IF EXISTS `wp_weisite_slideshow`;
CREATE TABLE `wp_weisite_slideshow` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `title` varchar(255) DEFAULT NULL COMMENT '标题',
  `img` int(10) unsigned NOT NULL COMMENT '图片',
  `url` varchar(255) DEFAULT NULL COMMENT '链接地址',
  `is_show` tinyint(2) DEFAULT '1' COMMENT '是否显示',
  `sort` int(10) DEFAULT '0' COMMENT '排序',
  `token` varchar(100) DEFAULT NULL COMMENT 'Token',
  `cate_id` varchar(100) DEFAULT '0' COMMENT '所属目录',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for wp_weixin_log
-- ----------------------------
DROP TABLE IF EXISTS `wp_weixin_log`;
CREATE TABLE `wp_weixin_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cTime` int(11) DEFAULT NULL,
  `cTime_format` varchar(30) DEFAULT NULL,
  `data` text,
  `data_post` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1113204 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for wp_weixin_message
-- ----------------------------
DROP TABLE IF EXISTS `wp_weixin_message`;
CREATE TABLE `wp_weixin_message` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `ToUserName` varchar(100) DEFAULT NULL COMMENT 'Token',
  `FromUserName` varchar(100) DEFAULT NULL COMMENT 'OpenID',
  `CreateTime` int(10) DEFAULT NULL COMMENT '创建时间',
  `MsgType` varchar(30) DEFAULT NULL COMMENT '消息类型',
  `MsgId` varchar(100) DEFAULT NULL COMMENT '消息ID',
  `Content` text COMMENT '文本消息内容',
  `PicUrl` varchar(255) DEFAULT NULL COMMENT '图片链接',
  `MediaId` varchar(100) DEFAULT NULL COMMENT '多媒体文件ID',
  `Format` varchar(30) DEFAULT NULL COMMENT '语音格式',
  `ThumbMediaId` varchar(30) DEFAULT NULL COMMENT '缩略图的媒体id',
  `Title` varchar(100) DEFAULT NULL COMMENT '消息标题',
  `Description` text COMMENT '消息描述',
  `Url` varchar(255) DEFAULT NULL COMMENT 'Url',
  `collect` tinyint(1) DEFAULT '0' COMMENT '收藏状态',
  `deal` tinyint(1) DEFAULT '0' COMMENT '处理状态',
  `is_read` tinyint(1) DEFAULT '0' COMMENT '是否已读',
  `type` tinyint(1) DEFAULT '0' COMMENT '消息分类',
  `is_material` int(10) DEFAULT '0' COMMENT '设置为文本素材',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4330 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for wp_weizhifu
-- ----------------------------
DROP TABLE IF EXISTS `wp_weizhifu`;
CREATE TABLE `wp_weizhifu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `xid` int(11) DEFAULT NULL COMMENT '学员id',
  `jxid` int(11) DEFAULT NULL COMMENT '//驾校id',
  `uid` int(11) DEFAULT NULL,
  `jid` int(11) DEFAULT NULL COMMENT '教练id',
  `pid` varchar(50) DEFAULT NULL COMMENT '时间段id',
  `tuan` varchar(255) DEFAULT NULL COMMENT '组团人员',
  `dbh` varchar(30) DEFAULT NULL COMMENT '订单编号',
  `km` varchar(15) DEFAULT NULL COMMENT '科目',
  `shouxu` varchar(255) DEFAULT NULL COMMENT '手续费',
  `money` varchar(255) DEFAULT NULL COMMENT '缴费金额',
  `out_trade_no` varchar(255) DEFAULT NULL COMMENT '商户订单号',
  `num` varchar(255) DEFAULT NULL COMMENT '时长',
  `addtime` varchar(20) DEFAULT NULL COMMENT 'addtime',
  `fs` varchar(20) DEFAULT NULL COMMENT '支付方式（微信/支付宝）',
  `status` varchar(20) DEFAULT NULL COMMENT '1:已预约,未支付 2：已取消',
  `mark` varchar(30) DEFAULT NULL COMMENT '备注',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=16007 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for wp_weizhifu1
-- ----------------------------
DROP TABLE IF EXISTS `wp_weizhifu1`;
CREATE TABLE `wp_weizhifu1` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `xid` int(11) DEFAULT NULL COMMENT '学员id',
  `jid` int(11) DEFAULT NULL COMMENT '教练id',
  `pid` varchar(50) DEFAULT NULL COMMENT '时间段id',
  `tuan` varchar(255) DEFAULT NULL COMMENT '组团人员',
  `dbh` varchar(30) DEFAULT NULL COMMENT '订单编号',
  `km` varchar(15) DEFAULT NULL COMMENT '科目',
  `shouxu` varchar(255) DEFAULT NULL COMMENT '手续费',
  `money` varchar(255) DEFAULT NULL COMMENT '缴费金额',
  `num` varchar(255) DEFAULT NULL COMMENT '时长',
  `addtime` varchar(20) DEFAULT NULL COMMENT 'addtime',
  `fs` varchar(20) DEFAULT NULL COMMENT '支付方式（微信/支付宝）',
  `status` varchar(20) DEFAULT NULL COMMENT '1:已预约,未支付 2：已取消',
  `mark` varchar(30) DEFAULT NULL COMMENT '备注',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=835 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for wp_weizhifu_copy
-- ----------------------------
DROP TABLE IF EXISTS `wp_weizhifu_copy`;
CREATE TABLE `wp_weizhifu_copy` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `xid` int(11) DEFAULT NULL COMMENT '学员id',
  `uid` int(11) DEFAULT NULL,
  `jid` int(11) DEFAULT NULL COMMENT '教练id',
  `pid` varchar(50) DEFAULT NULL COMMENT '时间段id',
  `tuan` varchar(255) DEFAULT NULL COMMENT '组团人员',
  `dbh` varchar(30) DEFAULT NULL COMMENT '订单编号',
  `km` varchar(15) DEFAULT NULL COMMENT '科目',
  `shouxu` varchar(255) DEFAULT NULL COMMENT '手续费',
  `money` varchar(255) DEFAULT NULL COMMENT '缴费金额',
  `out_trade_no` varchar(255) DEFAULT NULL COMMENT '商户订单号',
  `num` varchar(255) DEFAULT NULL COMMENT '时长',
  `addtime` varchar(20) DEFAULT NULL COMMENT 'addtime',
  `fs` varchar(20) DEFAULT NULL COMMENT '支付方式（微信/支付宝）',
  `status` varchar(20) DEFAULT NULL COMMENT '1:已预约,未支付 2：已取消',
  `mark` varchar(30) DEFAULT NULL COMMENT '备注',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=14633 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for wp_wish_card
-- ----------------------------
DROP TABLE IF EXISTS `wp_wish_card`;
CREATE TABLE `wp_wish_card` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `send_name` varchar(255) DEFAULT NULL COMMENT '发送人',
  `receive_name` varchar(255) DEFAULT NULL COMMENT '接收人',
  `content` text COMMENT '祝福语',
  `create_time` int(10) DEFAULT NULL COMMENT ' 创建时间',
  `template` char(50) DEFAULT NULL COMMENT '模板',
  `template_cate` varchar(255) DEFAULT NULL COMMENT '模板分类',
  `read_count` int(10) DEFAULT '0' COMMENT '浏览次数',
  `mid` varchar(255) DEFAULT NULL COMMENT '用户Id',
  `token` varchar(255) DEFAULT NULL COMMENT 'Token',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for wp_wish_card_content
-- ----------------------------
DROP TABLE IF EXISTS `wp_wish_card_content`;
CREATE TABLE `wp_wish_card_content` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `content_cate_id` int(10) DEFAULT '0' COMMENT '祝福语类别Id',
  `content` text COMMENT '祝福语',
  `content_cate` varchar(255) DEFAULT NULL COMMENT '类别',
  `token` varchar(255) DEFAULT NULL COMMENT 'Token',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for wp_wish_card_content_cate
-- ----------------------------
DROP TABLE IF EXISTS `wp_wish_card_content_cate`;
CREATE TABLE `wp_wish_card_content_cate` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `content_cate_name` varchar(255) DEFAULT NULL COMMENT '祝福语类别',
  `token` varchar(255) DEFAULT NULL COMMENT 'Token',
  `content_cate_icon` int(10) unsigned DEFAULT NULL COMMENT '类别图标',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for wp_xdlog
-- ----------------------------
DROP TABLE IF EXISTS `wp_xdlog`;
CREATE TABLE `wp_xdlog` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `userid_int` int(11) NOT NULL,
  `biztitle` text,
  `biztype` int(11) NOT NULL DEFAULT '0',
  `opttime` bigint(20) DEFAULT NULL,
  `xd` bigint(20) DEFAULT NULL,
  `sceneid` bigint(20) DEFAULT '0',
  `remark` longtext,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for wp_xianxia
-- ----------------------------
DROP TABLE IF EXISTS `wp_xianxia`;
CREATE TABLE `wp_xianxia` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT NULL,
  `xid` int(11) DEFAULT NULL COMMENT '学员id',
  `jid` int(11) DEFAULT NULL COMMENT '教练id',
  `pch` varchar(50) DEFAULT NULL COMMENT '车号',
  `pdata` varchar(50) DEFAULT NULL COMMENT '日期',
  `ptime` text COMMENT '时间段',
  `pid` varchar(255) DEFAULT NULL COMMENT '时间段id',
  `tuan` varchar(255) DEFAULT NULL,
  `dbh` varchar(30) DEFAULT NULL COMMENT '订单编号',
  `km` varchar(15) DEFAULT NULL COMMENT '科目',
  `shouxu` varchar(255) DEFAULT NULL COMMENT '手续费',
  `koufei` varchar(255) DEFAULT NULL COMMENT '退款扣除手续费',
  `num` varchar(255) DEFAULT NULL,
  `money` varchar(15) DEFAULT NULL COMMENT '缴费金额',
  `fs` varchar(20) DEFAULT NULL COMMENT '支付方式（微信/支付宝）',
  `status` varchar(20) DEFAULT NULL COMMENT '订单状态0:交易成功1:已退款 2:已消费3:退款中',
  `mark` varchar(30) DEFAULT NULL COMMENT '备注',
  `mch_id` varchar(255) DEFAULT NULL COMMENT '商户号',
  `transaction_id` varchar(255) DEFAULT NULL COMMENT '微信支付订单号',
  `out_trade_no` varchar(255) DEFAULT NULL COMMENT '商户系统的订单号',
  `refund_fee` varchar(255) DEFAULT NULL COMMENT '退款金额',
  `time_end` varchar(50) DEFAULT NULL COMMENT '支付完成时间',
  `daddtime` varchar(50) DEFAULT NULL COMMENT '添加时间',
  `shuoming` text COMMENT '退款说明',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=132 DEFAULT CHARSET=utf8 COMMENT='订单信息表';

-- ----------------------------
-- Table structure for wp_xueyuan
-- ----------------------------
DROP TABLE IF EXISTS `wp_xueyuan`;
CREATE TABLE `wp_xueyuan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT NULL COMMENT '微信id',
  `jx` int(11) DEFAULT NULL COMMENT '驾校id',
  `jl_id` int(11) DEFAULT NULL COMMENT '教练id',
  `xsex` varchar(2) DEFAULT NULL COMMENT '1男2女',
  `xbirth` varchar(20) DEFAULT NULL COMMENT '年龄',
  `xaddr` varchar(30) DEFAULT NULL COMMENT '身份证地址',
  `xnow_addr` varchar(30) DEFAULT NULL COMMENT '现住址',
  `xphone` varchar(20) DEFAULT NULL COMMENT '电话',
  `xcard` varchar(20) DEFAULT NULL COMMENT '身份证号',
  `xbh` varchar(20) DEFAULT NULL COMMENT '学员编号',
  `ximage` varchar(255) DEFAULT NULL COMMENT '身份证照片',
  `xy` varchar(10) DEFAULT NULL COMMENT '协议 0：未同意 1：同意',
  `xname` varchar(8) DEFAULT NULL COMMENT '姓名',
  `xweixin` varchar(20) DEFAULT NULL COMMENT '微信号',
  `xmark` varchar(30) DEFAULT NULL COMMENT '备注',
  `xaddtime` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=28779 DEFAULT CHARSET=utf8 COMMENT='学员信息表';

-- ----------------------------
-- Table structure for wp_xueyuan2017-05-17
-- ----------------------------
DROP TABLE IF EXISTS `wp_xueyuan2017-05-17`;
CREATE TABLE `wp_xueyuan2017-05-17` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT NULL COMMENT '微信id',
  `jx` int(11) DEFAULT NULL COMMENT '驾校id',
  `jl_id` int(11) DEFAULT NULL COMMENT '教练id',
  `xsex` varchar(2) DEFAULT NULL COMMENT '1男2女',
  `xbirth` varchar(20) DEFAULT NULL COMMENT '年龄',
  `xaddr` varchar(30) DEFAULT NULL COMMENT '身份证地址',
  `xnow_addr` varchar(30) DEFAULT NULL COMMENT '现住址',
  `xphone` varchar(20) DEFAULT NULL COMMENT '电话',
  `xcard` varchar(20) DEFAULT NULL COMMENT '身份证号',
  `xbh` varchar(20) DEFAULT NULL COMMENT '学员编号',
  `ximage` varchar(255) DEFAULT NULL COMMENT '身份证照片',
  `xy` varchar(10) DEFAULT NULL COMMENT '协议 0：未同意 1：同意',
  `xname` varchar(8) DEFAULT NULL COMMENT '姓名',
  `xweixin` varchar(20) DEFAULT NULL COMMENT '微信号',
  `xmark` varchar(30) DEFAULT NULL COMMENT '备注',
  `xaddtime` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=675 DEFAULT CHARSET=utf8 COMMENT='学员信息表';

-- ----------------------------
-- Table structure for wp_yuyue
-- ----------------------------
DROP TABLE IF EXISTS `wp_yuyue`;
CREATE TABLE `wp_yuyue` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `xid` int(11) DEFAULT NULL COMMENT '学员id',
  `cid` int(11) DEFAULT NULL COMMENT '车辆id',
  `pid` int(11) DEFAULT NULL COMMENT '时间段id',
  `jid` int(11) DEFAULT NULL COMMENT '教练id',
  `data` varchar(20) DEFAULT NULL COMMENT '日期',
  `mark` varchar(30) DEFAULT NULL COMMENT '备注',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='预约时间表';
