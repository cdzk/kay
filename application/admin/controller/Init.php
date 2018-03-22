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

use app\admin\model\sys\SysAuth;
use app\admin\model\sys\SysMenu;
use app\admin\model\sys\SysRole;
use app\admin\model\sys\SysUser;
use app\common\controller\Resource;
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
        $userSession = unserialize($loginUser);
        self::$user = SysUser::getSingleUser($userSession['user_id'])->toArray();
        $this->assign('curr_user', self::$user);

        // 用户头像
        $avatar = randomAvatar();
        $this->assign('avatar', $avatar);

        // 用户角色
        $userRole = SysUser::getSingleUser(self::$user['user_id'])->user_roleid;

        // 系统菜单
        $roleMenu = SysRole::getSingleRole($userRole)->role_menu;
        $menu = $this->menu($roleMenu);
        $this->assign('sys_menu', $menu);

        // 系统权限验证
        $roleAuth = SysRole::getSingleRole($userRole)->role_auth;
        $auth = self::auth_verify($roleAuth);
        if (!$auth) {
            if (request()->isAjax()) {
                exit(json_encode(Resource::getBack(Resource::ERR_AUTH_INVALID, '没有权限进行操作'), JSON_UNESCAPED_UNICODE));
            } else {
                $this->error('没有权限进行操作');
            }
        }
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
                        // 判断当前的模块是否与菜单的相同并展开当前菜单
                        if (strcasecmp(request()->module(),$childVal['menu_module'])===0) {
                            $html .= "<li class=\"active\">";
                        } else {
                            $html .= "<li>";
                        }

                        $html .= "    <a href=\"javascript:void(0);\"><i class=\"fa fa-circle\"></i> {$childVal['menu_name']}";
                        $html .= "        <span class=\"pull-right-container\">";
                        $html .= "            <i class=\"fa fa-angle-left pull-right\"></i>";
                        $html .= "        </span>";
                        $html .= "    </a>";

                        // 判断当前的模块是否与菜单的相同并高亮当前菜单
                        if (strcasecmp(request()->module(),$childVal['menu_module'])===0) {
                            $html .= "    <ul class=\"treeview-menu menu-open\" style=\"display: block;\">";
                        } else {
                            $html .= "    <ul class=\"treeview-menu\">";
                        }

                        $html .= $this->sub_menu($childVal['children']);
                        $html .= "    </ul>";
                    } else if (empty($childVal['menu_action'])) { // 判断菜单是否包含链接
                        $html .= "<li><a href=\"javascript:void(0);\"><i class=\"fa fa-circle\"></i> {$childVal['menu_name']}</a>";
                    } else {
                        $url = url($childVal['menu_module'].'/'.$childVal['menu_controller'].'/'.$childVal['menu_action']);

                        // 判断当前的控制器是否与菜单的相同并高亮当前菜单
                        if (strcasecmp(request()->controller(),$childVal['menu_controller'])===0) {
                            $html .= "<li class=\"active\"><a href=\"{$url}\"><i class=\"fa fa-circle\"></i> {$childVal['menu_name']}</a>";
                        } else {
                            $html .= "<li><a href=\"{$url}\"><i class=\"fa fa-circle\"></i> {$childVal['menu_name']}</a>";
                        }
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
                    // 判断当前的模块是否与菜单的相同并展开当前菜单
                    if (strcasecmp(request()->module(),$val['menu_module'])===0) {
                        $html .= "<li class=\"active\">";
                    } else {
                        $html .= "<li>";
                    }

                    $html .= "    <a href=\"javascript:void(0);\"><i class=\"fa fa-circle-o\"></i> {$val['menu_name']}";
                    $html .= "        <span class=\"pull-right-container\">";
                    $html .= "            <i class=\"fa fa-angle-left pull-right\"></i>";
                    $html .= "        </span>";
                    $html .= "    </a>";

                    // 判断当前的模块是否与菜单的相同并高亮当前菜单
                    if (strcasecmp(request()->module(),$val['menu_module'])===0) {
                        $html .= "    <ul class=\"treeview-menu menu-open\" style=\"display: block;\">";
                    } else {
                        $html .= "    <ul class=\"treeview-menu\">";
                    }

                    $html .= $this->sub_menu($val['children']);
                    $html .= "    </ul>";
                } else if (empty($val['menu_action'])) { // 判断菜单是否包含链接
                    $html .= "<li><a href=\"javascript:void(0);\"><i class=\"fa fa-circle-o\"></i> {$val['menu_name']}</a>";
                } else {
                    $url = url($val['menu_module'].'/'.$val['menu_controller'].'/'.$val['menu_action']);

                    // 判断当前的控制器是否与菜单的相同并高亮当前菜单
                    if (strcasecmp(request()->controller(),$val['menu_controller'])===0) {
                        $html .= "<li class=\"active\"><a href=\"{$url}\"><i class=\"fa fa-circle-o\"></i> {$val['menu_name']}</a>";
                    } else {
                        $html .= "<li><a href=\"{$url}\"><i class=\"fa fa-circle-o\"></i> {$val['menu_name']}</a>";
                    }
                }
                $html .= '</li>';
            }
        }

        return $html;
    }

    /**
     * check_auth
     * 系统用户权限验证
     *
     * @author zhengkai
     * @date 2017-08-27
     *
     * @return bool
     */
    public static function auth_verify($roleAuth)
    {
        // 判断是否为超级管理员
        if ($roleAuth === 'super') return true;

        /*** 获取权限数据 ***/
        // 模块
        $m =  SysAuth::all(function ($query) use ($roleAuth) {
            $query->where('auth_id', 'in', $roleAuth)
                ->field('auth_id, auth_parentid, auth_module');
        });
        $module = '';
        foreach ($m as $m_key=>$m_val) {
            $module .= $m_val['auth_module'].',';
        }
        $module = array_unique(explode(',', rtrim($module, ',')));

        $controller = []; // 控制器
        foreach ($module as $c_key=>$c_val) {
            // 使用模块名作为条件查询出对应的控制器
            $am[$c_key] = SysAuth::all(function ($query) use ($roleAuth, $c_val) {
                $query->where('auth_id', 'in', $roleAuth)
                    ->where('auth_module', $c_val)
                    ->field('auth_id, auth_parentid, auth_controller');
            });

            $ac[$c_key] = '';
            foreach ($am[$c_key] as $ac_key=>$ac_val){
                $ac[$c_key] .= $ac_val['auth_controller'].',';
            }
            $ac[$c_key] = array_unique(explode(',', rtrim($ac[$c_key], ',')));
            $controller[$c_val] = $ac[$c_key];
        }

        $action = []; // 方法
        foreach ($controller as $a_key=>$a_val) {
            foreach ($a_val as $a2_key=>$a2_val) {
                // 使用模块名、控制器名同时作为条件查询出对应的方法
                $ac[$a2_key] = SysAuth::all(function ($query) use ($roleAuth, $a_key, $a2_val) {
                    $query->where('auth_id', 'in', $roleAuth)
                        ->where('auth_module', $a_key)
                        ->where('auth_controller', $a2_val)
                        ->field('auth_id, auth_parentid, auth_action');
                });

                $aa[$a2_key] = '';
                foreach ($ac[$a2_key] as $ac_key=>$ac_val){
                    $aa[$a2_key] .= $ac_val['auth_action'].',';
                }
                $aa[$a2_key] = rtrim($aa[$a2_key], ',');
                $action[$a_key][$a2_val] = $aa[$a2_key];
            }
        }

        // 最终拼接权限数据
        $authData = $action;

        /*** 获取权限数据 end ***/

        // 获取当前模块、控制器、方法名
        $currModule = request()->module();
        $currController = request()->controller();
        $currAction = request()->action();

        // 对 admin 模块下的 Index 控制器不进行权限控制
        if ($currModule==='admin' && $currController=='Index') return true;

        if (array_key_exists($currModule, $authData)) { // 判断是否有模块访问权限
            if (array_key_exists(lcfirst($currController), $authData[$currModule])) { // 判断是否有控制器访问权限
                if (preg_match('#'.$currAction.'#', $authData[$currModule][lcfirst($currController)])) { // 判断是否有方法访问权限
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
}