<?php
/**
 * Created by PhpStorm.
 *
 * @Date: 2017-05-17
 * @Time: 15:57
 * @Author: cdkay
 * @Email: network@iyuanma.net
 *
 * @File： Index.php
 */
namespace app\admin\controller;

use app\admin\model\Admin_menu;
use app\admin\model\Admin_user;
use library\PasswordHash;
use library\Tree;
use think\Request;
use think\Session;

class Index extends Base {
    protected $loginUser;
    protected $admin_user;
    public function __construct()
    {
        parent::__construct();

        $this->loginUser = unserialize(Session::get('user', 'admin'));

        // 实例化管理用户模型
        $this->admin_user = new Admin_user();

    }

    /**
     * index
     * 管理后台首页
     *
     */
    public function index()
    {
        $data = $this->admin_user->get_login_user($this->loginUser['user_id']);
        $this->assign('user', $data);

        return view('index/home');
    }

    /**
     * main
     * 管理后台iframe首页
     */
    public function main()
    {
        return view('index/main');
    }

    /**
     * sys_info
     * 获取服务器CPU使用率、内存使用情况、进程数等信息
     *
     * @return array
     */
    public function sys_info()
    {
        $result = get_used_status();
        $result['currentTimes'] = date('Y-m-d H:i:s', time());

        return json(['status'=>1,'msg'=>'success','data'=>$result]);
    }

    /**
     * admin_menu
     * 获取管理后台一级菜单以外的所有菜单
     *
     * @param int $menu_parentid 管理菜单父级id
     * @return string
     */
    public function admin_menu($menu_parentid)
    {
        if (!Request::instance()->isPost()) exit;

        // 获取所有允许显示的菜单数据
        $menu = new Admin_menu();
        $result = $menu->get_admin_menu(null, 1);

        // 生成无限级菜单数组数据
        $tree = Tree::makeTree($result, array(
            'primary_key' => 'menu_id',
            'parent_key' => 'menu_parentid',
        ));

        // 将菜单id转换为键名，生成新的数组
        $menu_data = array();
        foreach ($tree as $val) {
            $menu_data[$val['menu_id']] = $val;
        }

        // 无限遍历子菜单
        function sub_menu($data)
        {
            $html = '';
            if (isset($data) && is_array($data)) {
                foreach ($data as $subVal) {
                    if (isset($subVal['children']) && is_array($subVal['children'])) { // 判断是否有下级菜单
                        $html .= '<li>';
                        $html .= '    <a href="javascript:void(0);"><i class="fa fa-circle-o"></i> ' . $subVal['menu_name'];
                        $html .= '        <span class="pull-right-container">';
                        $html .= '            <i class="fa fa-angle-left pull-right"></i>';
                        $html .= '        </span>';
                        $html .= '    </a>';
                        $html .= '    <ul class="treeview-menu">';
                        $html .= sub_menu($subVal['children']);
                        $html .= '    </ul>';
                    } else if (empty($subVal['menu_action'])) {
                        $html .= '<li><a href="javascript:void(0);"><i class="fa fa-circle"></i> ' . $subVal['menu_name'] . '</a>';
                    } else {
                        $html .= '<li><a href="'.url($subVal['menu_module'].'/'.$subVal['menu_controller'].'/'.$subVal['menu_action']).'" target="main"><i class="fa fa-circle-o"></i> ' . $subVal['menu_name'] . '</a>';
                    }
                    $html .= '</li>';
                }
            }
            return $html;
        }

        // 根据指定的菜单id遍历，生成管理后台左侧菜单数据
        if (isset($menu_data[$menu_parentid]['children']) && is_array($menu_data[$menu_parentid]['children'])) {
            $menu_parent = $menu_data[$menu_parentid]['children'];
            $html = '';

            foreach ($menu_parent as $key1 => $items) {
                if (isset($items['children']) && is_array($items['children'])) {
                    $html .= '<li>';
                    $html .= '    <a href="javascript:void(0);">';
                    $html .= '        <i class="fa fa-circle"></i> <span>' . $items['menu_name'] . '</span>';
                    $html .= '        <span class="pull-right-container">';
                    $html .= '            <i class="fa fa-angle-left pull-right"></i>';
                    $html .= '        </span>';
                    $html .= '    </a>';
                    $html .= '    <ul class="treeview-menu">';
                    $html .= sub_menu($items['children']);
                    $html .= '    </ul>';
                    $html .= '</li>';
                } else if (empty($items['menu_action'])) {
                    $html .= '<li><a href="javascript:void(0);"><i class="fa fa-circle"></i> ' . $items['menu_name'] . '</a>';
                } else {
                    $html .= '<li><a href="'.url($items['menu_module'].'/'.$items['menu_controller'].'/'.$items['menu_action']).'" target="main"><i class="fa fa-circle"></i> ' . $items['menu_name'] . '</a>';
                }
            }
        }

        return $html;
    }


    /**
     * test
     * 测试专用
     *
     * access public
     */
    public function test()
    {
        /*$rule  = "/^([\x{4e00}-\x{9fa5}]+$|([a-z]+\s?)+)$/u";
        preg_match($rule,'a a d',$result);
        dump($result);*/
        /*$pass = new PasswordHash(8, false);

        $t1 = $pass->HashPassword('admin888');
        echo $t1;

        $t2 = $pass->CheckPassword('admin888', $t1);

        if ($t2) {
            echo '密码正确';
        } else {
            echo '密码错误';
        }*/
    }
}