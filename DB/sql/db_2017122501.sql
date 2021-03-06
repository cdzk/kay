-- MySQL Script generated by MySQL Workbench
-- Mon Dec 25 23:02:43 2017
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema sy_kay
-- -----------------------------------------------------
-- 基于ThinkPHP5的敏捷开发框架
DROP SCHEMA IF EXISTS `sy_kay` ;

-- -----------------------------------------------------
-- Schema sy_kay
--
-- 基于ThinkPHP5的敏捷开发框架
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `sy_kay` DEFAULT CHARACTER SET utf8 ;
USE `sy_kay` ;

-- -----------------------------------------------------
-- Table `sy_kay`.`kay_sys_menu`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `sy_kay`.`kay_sys_menu` ;

CREATE TABLE IF NOT EXISTS `sy_kay`.`kay_sys_menu` (
  `menu_id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '菜单id',
  `menu_parentid` INT(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '菜单父id，默认为0 表示为一级菜单',
  `menu_name` VARCHAR(255) NOT NULL COMMENT '菜单名称',
  `menu_module` VARCHAR(255) NULL COMMENT '模块名称',
  `menu_controller` VARCHAR(255) NULL COMMENT '控制器名称',
  `menu_action` VARCHAR(255) NULL COMMENT '方法名称',
  `menu_param` VARCHAR(255) NULL COMMENT '请求参数',
  `menu_sort` INT(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '菜单排序：默认为0，从大到小排列',
  `menu_status` TINYINT(1) UNSIGNED NOT NULL DEFAULT 1 COMMENT '菜单状态：1=显示，0=不显示',
  PRIMARY KEY (`menu_id`))
ENGINE = InnoDB
COMMENT = '管理后台菜单';


-- -----------------------------------------------------
-- Table `sy_kay`.`kay_user_auth`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `sy_kay`.`kay_user_auth` ;

CREATE TABLE IF NOT EXISTS `sy_kay`.`kay_user_auth` (
  `auth_id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '权限节点id',
  `auth_parentid` INT(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '权限父节点id',
  `auth_name` VARCHAR(255) NOT NULL COMMENT '权限名称',
  `auth_module` VARCHAR(255) NOT NULL,
  `auth_controller` VARCHAR(255) NOT NULL COMMENT '控制器',
  `auth_action` VARCHAR(255) NOT NULL COMMENT '方法',
  PRIMARY KEY (`auth_id`),
  UNIQUE INDEX `auth_id_UNIQUE` (`auth_id` ASC))
ENGINE = InnoDB
COMMENT = '权限节点';


-- -----------------------------------------------------
-- Table `sy_kay`.`kay_user`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `sy_kay`.`kay_user` ;

CREATE TABLE IF NOT EXISTS `sy_kay`.`kay_user` (
  `user_id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '用户id',
  `user_roleid` INT(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '用户角色id',
  `user_name` VARCHAR(255) NOT NULL COMMENT '用户名',
  `user_password` VARCHAR(255) NOT NULL COMMENT '登录密码',
  `user_realname` VARCHAR(255) NULL COMMENT '用户真实姓名',
  `user_mobile` VARCHAR(11) NULL COMMENT '用户手机号',
  `user_email` VARCHAR(255) NULL COMMENT '用户邮箱',
  `user_status` TINYINT(1) UNSIGNED NOT NULL DEFAULT 1 COMMENT '用户状态：1=正常、0=锁定',
  `user_addtime` INT(10) NOT NULL COMMENT '用户添加时间',
  PRIMARY KEY (`user_id`),
  UNIQUE INDEX `user_id_UNIQUE` (`user_id` ASC))
ENGINE = InnoDB
COMMENT = '系统用户';


-- -----------------------------------------------------
-- Table `sy_kay`.`kay_user_role`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `sy_kay`.`kay_user_role` ;

CREATE TABLE IF NOT EXISTS `sy_kay`.`kay_user_role` (
  `role_id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '角色id',
  `role_name` VARCHAR(255) NOT NULL COMMENT '角色名称',
  `role_remake` TEXT(0) NULL COMMENT '角色描述',
  `role_auth` MEDIUMTEXT NULL COMMENT '角色权限',
  `role_menu` MEDIUMTEXT NULL COMMENT '菜单权限',
  `role_status` TINYINT(0) UNSIGNED NOT NULL DEFAULT 1 COMMENT '角色状态：1=启用，0=禁用',
  PRIMARY KEY (`role_id`),
  UNIQUE INDEX `role_id_UNIQUE` (`role_id` ASC),
  CONSTRAINT `fk_kay_user_role_kay_user`
    FOREIGN KEY (`role_id`)
    REFERENCES `sy_kay`.`kay_user` (`user_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
COMMENT = '系统用户角色';


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
