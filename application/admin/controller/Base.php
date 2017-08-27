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
use app\admin\model\Admin_auth;
use app\admin\model\Admin_menu;
use think\Controller;
use think\Request;


class Base extends Controller {
    public function __construct()
    {
        parent::__construct();

        // 管理用户登录拦截
        $loginStatus = session('user', '', 'admin');
        if (!$loginStatus) $this->error('未登录或登录超时', 'admin/Entry/login');

        // 管理用户权限拦截
        $admin_auth = new Admin_auth();
        $checkAuth = $admin_auth->check_auth();
        if (!$checkAuth) {
            if (Request::instance()->isAjax()) {
                exit(json_encode(array('status'=>-1, 'msg'=>'您没有权限进行此操作', 'result'=>'')));
            } else {
                $this->error('您没有权限进行此操作');
            }
        }

        // 实例化管理菜单模块
        $admin_menu = new Admin_menu();

        // 获取管理后台一级菜单
        $result = $admin_menu->get_admin_menu(0, 1);
        $this->assign('menu', $result);
    }
}