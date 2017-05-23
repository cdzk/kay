<?php
/**
 * Created by PhpStorm.
 *
 * @Date: 2017-05-19
 * @Time: 16:42
 * @Author: cdkay
 * @Email: network@iyuanma.net
 *
 * @File： Base.php
 */
namespace app\admin\controller;
use app\admin\model\AdminMenu;
use think\Controller;
use think\Request;


class Base extends Controller {
    public function _initialize()
    {
        // 实例化管理菜单模块
        $admin_menu = new AdminMenu();

        // 获取管理后台一级菜单
        $result = $admin_menu->get_menu(0, 1);
        $this->assign('menu', $result);
    }
}