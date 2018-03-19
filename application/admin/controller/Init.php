<?php
/**
 * Created by PhpStorm.
 *
 * @Date: 2018-03-19
 * @Time: 21:58
 * @Author: cdkay
 * @Email: network@iyuanma.net
 *
 * @File： Init.php
 */
namespace app\admin\controller;

use app\admin\model\sys\SysMenu;
use app\admin\model\sys\SysRole;
use app\admin\model\sys\SysUser;
use library\Tree;
use think\Controller;

class Init extends Controller {
    public static $user;

    public function __construct()
    {
        parent::__construct();

        // 登录检测
        $loginUser = session('user', '', 'admin');
        if (!$loginUser) {
            if (
                request()->module()==='admin' &&
                request()->controller()==='Index' &&
                request()->action()==='index'
            ) {
                $this->redirect('admin/Login/index');
            } else {
                $this->error('未登录或登录超时', 'admin/Login/index');
            }
        }
        self::$user = unserialize($loginUser);

        // 系统菜单
        $userRole = SysUser::getSingleUser(self::$user['user_id'])->user_roleid;
        $RoleMenu = SysRole::getSingleRole($userRole)->role_menu;
        $menu = $this->menu($RoleMenu);
        $this->assign('sys_menu', $menu);

        // 用户头像
        $avatar = randomAvatar();
        $this->assign('avatar', $avatar);
    }

    /**
     * menu
     * 生成系统菜单
     *
     * @return string
     */
    protected function menu($menuId)
    {
        // 从数据库读取菜单数据
        $data = SysMenu::getInMenu($menuId);

        // 生成无限级菜单数组数据
        $menuTree = Tree::makeTree($data, array(
            'primary_key' => 'menu_id',
            'parent_key' => 'menu_parentid',
        ));

        // 拼装菜单
        $html = '';
        foreach ($menuTree as $parentKey=>$parentVal) {
            $html .= "<li class=\"header\"><i class=\"fa fa-cubes\"></i> {$parentVal['menu_name']}</li>";

            if (isset($parentVal['children']) && is_array($parentVal['children'])) {
                foreach ($parentVal['children'] as $childKey=>$childVal) {
                    if (isset($childVal['children']) && is_array($childVal['children'])) { // 判断是否有下级菜单
                        $html .= "<li>";
                        $html .= "    <a href=\"javascript:void(0);\"><i class=\"fa fa-circle\"></i> {$childVal['menu_name']}";
                        $html .= "        <span class=\"pull-right-container\">";
                        $html .= "            <i class=\"fa fa-angle-left pull-right\"></i>";
                        $html .= "        </span>";
                        $html .= "    </a>";
                        $html .= "    <ul class=\"treeview-menu\">";
                        $html .= $this->sub_menu($childVal['children']);
                        $html .= "    </ul>";
                    } else if (empty($childVal['menu_action'])) { // 判断菜单是否包含链接
                        $html .= "<li><a href=\"javascript:void(0);\"><i class=\"fa fa-circle\"></i> {$childVal['menu_name']}</a>";
                    } else {
                        $url = url($childVal['menu_module'].'/'.$childVal['menu_controller'].'/'.$childVal['menu_action']);

                        $html .= "<li><a href=\"{$url}\"><i class=\"fa fa-circle\"></i> {$childVal['menu_name']}</a>";
                    }
                    $html .= '</li>';
                }
            }

        }

        return $html;
    }

    /**
     * sub_menu
     * 系统菜单子菜单递归处理
     *
     * @param array $subMenu 子菜单数据
     * @return string
     */
    protected function sub_menu($subMenu)
    {
        $html = '';
        if ($subMenu && is_array($subMenu)) {
            foreach ($subMenu as $key=>$val) {
                if (isset($val['children']) && is_array($val['children'])) { // 判断是否有下级菜单
                    $html .= "<li>";
                    $html .= "    <a href=\"javascript:void(0);\"><i class=\"fa fa-circle-o\"></i> {$val['menu_name']}";
                    $html .= "        <span class=\"pull-right-container\">";
                    $html .= "            <i class=\"fa fa-angle-left pull-right\"></i>";
                    $html .= "        </span>";
                    $html .= "    </a>";
                    $html .= "    <ul class=\"treeview-menu\">";
                    $html .= $this->sub_menu($val['children']);
                    $html .= "    </ul>";
                } else if (empty($val['menu_action'])) { // 判断菜单是否包含链接
                    $html .= "<li><a href=\"javascript:void(0);\"><i class=\"fa fa-circle-o\"></i> {$val['menu_name']}</a>";
                } else {
                    $url = url($val['menu_module'].'/'.$val['menu_controller'].'/'.$val['menu_action']);

                    $html .= "<li><a href=\"{$url}\"><i class=\"fa fa-circle-o\"></i> {$val['menu_name']}</a>";
                }
                $html .= '</li>';
            }
        }

        return $html;
    }
}