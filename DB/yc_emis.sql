/*
Navicat MySQL Data Transfer

Source Server         : 本机
Source Server Version : 50528
Source Host           : 127.0.0.1:3306
Source Database       : yc_emis

Target Server Type    : MYSQL
Target Server Version : 50528
File Encoding         : 65001

Date: 2017-05-23 00:36:19
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for yc_admin_menu
-- ----------------------------
DROP TABLE IF EXISTS `yc_admin_menu`;
CREATE TABLE `yc_admin_menu` (
  `menu_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '菜单id',
  `menu_parentid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '菜单父id，默认为0 表示为一级菜单',
  `menu_name` varchar(255) DEFAULT NULL COMMENT '菜单名称',
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
INSERT INTO `yc_admin_menu` VALUES ('3', '1', '系统用户', 'User', '', '', null, '0', '1');
INSERT INTO `yc_admin_menu` VALUES ('4', '3', '用户管理', 'admin', 'User', 'index', null, '0', '1');
INSERT INTO `yc_admin_menu` VALUES ('5', '3', '角色管理', 'admin', 'User', 'role', null, '0', '1');
INSERT INTO `yc_admin_menu` VALUES ('6', '3', '权限管理', 'admin', 'Auth', 'index', null, '0', '1');
