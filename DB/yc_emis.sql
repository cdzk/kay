/*
Navicat MySQL Data Transfer

Source Server         : 办公室
Source Server Version : 50505
Source Host           : 192.168.1.200:3306
Source Database       : yc_emis

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2017-05-25 19:02:13
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for yc_admin_auth
-- ----------------------------
DROP TABLE IF EXISTS `yc_admin_auth`;
CREATE TABLE `yc_admin_auth` (
  `auth_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '权限节点id',
  `auth_parentid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '权限父节点id',
  `auth_name` varchar(255) NOT NULL COMMENT '权限名称',
  `auth_module` varchar(255) NOT NULL,
  `auth_controller` varchar(255) NOT NULL COMMENT '控制器',
  `auth_action` varchar(255) NOT NULL COMMENT '方法',
  PRIMARY KEY (`auth_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COMMENT='权限节点';

-- ----------------------------
-- Records of yc_admin_auth
-- ----------------------------
INSERT INTO `yc_admin_auth` VALUES ('1', '0', '菜单管理', 'admin', 'Menu', 'index');
INSERT INTO `yc_admin_auth` VALUES ('2', '1', '添加菜单', 'admin', 'Menu', 'add');
INSERT INTO `yc_admin_auth` VALUES ('3', '1', '修改菜单', 'admin', 'Menu', 'edit');
INSERT INTO `yc_admin_auth` VALUES ('4', '1', '删除菜单', 'admin', 'Menu', 'del');
INSERT INTO `yc_admin_auth` VALUES ('5', '1', '菜单排序', 'admin', 'Menu', 'sort');
INSERT INTO `yc_admin_auth` VALUES ('6', '1', '状态设置', 'admin', 'Menu', 'status');
INSERT INTO `yc_admin_auth` VALUES ('7', '0', '权限管理', 'admin', 'Auth', 'index');
INSERT INTO `yc_admin_auth` VALUES ('8', '7', '添加权限', 'admin', 'Auth', 'add');
INSERT INTO `yc_admin_auth` VALUES ('9', '7', '修改权限', 'admin', 'Auth', 'edit');
INSERT INTO `yc_admin_auth` VALUES ('10', '7', '删除权限', 'admin', 'Auth', 'del');
INSERT INTO `yc_admin_auth` VALUES ('11', '0', '用户管理', 'admin', 'User', 'index');

-- ----------------------------
-- Table structure for yc_admin_menu
-- ----------------------------
DROP TABLE IF EXISTS `yc_admin_menu`;
CREATE TABLE `yc_admin_menu` (
  `menu_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '菜单id',
  `menu_parentid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '菜单父id，默认为0 表示为一级菜单',
  `menu_name` varchar(255) NOT NULL COMMENT '菜单名称',
  `menu_module` varchar(255) DEFAULT NULL COMMENT '模块名称',
  `menu_controller` varchar(255) DEFAULT NULL COMMENT '控制器名称',
  `menu_action` varchar(255) DEFAULT NULL COMMENT '方法名称',
  `menu_param` varchar(255) DEFAULT NULL COMMENT '请求参数',
  `menu_sort` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '菜单排序：默认为0，从大到小排列',
  `menu_status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '菜单状态：1=显示，0=不显示',
  PRIMARY KEY (`menu_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COMMENT='管理后台菜单';

-- ----------------------------
-- Records of yc_admin_menu
-- ----------------------------
INSERT INTO `yc_admin_menu` VALUES ('1', '0', '系统', 'admin', null, null, null, '0', '1');
INSERT INTO `yc_admin_menu` VALUES ('2', '1', '菜单管理', 'admin', 'Menu', 'index', null, '0', '1');
INSERT INTO `yc_admin_menu` VALUES ('3', '1', '权限管理', 'admin', 'Auth', 'index', null, '0', '1');
INSERT INTO `yc_admin_menu` VALUES ('4', '1', '系统用户', 'admin', '', '', null, '0', '1');
INSERT INTO `yc_admin_menu` VALUES ('5', '4', '用户管理', 'admin', 'User', 'index', null, '0', '1');
INSERT INTO `yc_admin_menu` VALUES ('6', '4', '角色管理', 'admin', 'Role', 'index', null, '0', '1');

-- ----------------------------
-- Table structure for yc_admin_user
-- ----------------------------
DROP TABLE IF EXISTS `yc_admin_user`;
CREATE TABLE `yc_admin_user` (
  `user_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '用户id',
  `user_roleid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '用户角色id',
  `user_name` varchar(255) NOT NULL COMMENT '用户名',
  `user_password` varchar(255) NOT NULL COMMENT '登录密码',
  `user_realname` varchar(255) DEFAULT NULL COMMENT '用户真实姓名',
  `user_email` varchar(255) DEFAULT NULL COMMENT '用户邮箱',
  `user_mobile` varchar(11) DEFAULT NULL COMMENT '用户手机号',
  `user_status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '用户状态：1=正常、0=锁定',
  `user_addtime` int(10) NOT NULL COMMENT '用户添加时间',
  `user_login_last_ip` varchar(255) DEFAULT NULL COMMENT '用户最后一次登录ip',
  `user_login_last_area` varchar(255) DEFAULT NULL COMMENT '用户最后一次登录地区',
  `user_login_last_time` int(10) DEFAULT NULL COMMENT '用户最后一次登录时间',
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='系统用户';

-- ----------------------------
-- Records of yc_admin_user
-- ----------------------------
INSERT INTO `yc_admin_user` VALUES ('1', '0', 'admin', '$2a$08$WoDoUJUDsBqPlQn3fytNBOCP5JVW1AgBrvu2G9uyNGWvMoQToe.Qy', '猿创科技', 'service@i-yc.com', '13800138000', '1', '1495705635', null, null, null);
