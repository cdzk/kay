<?php
/**
 * Created by PhpStorm.
 *
 * @Date: 2017-05-20
 * @Time: 22:39
 * @Author: cdkay
 * @Email: network@iyuanma.net
 *
 * @File： Menu.php
 */

namespace app\admin\controller;

use app\admin\model\AdminMenu;
use library\Tree;
use think\Request;

class Menu extends Base {
    private $menu;
    private $menu_tree;

    public function _initialize()
    {
        // 获取所有菜单数据
        $this->menu = new AdminMenu();
        $menu_data = $this->menu->get_menu();
        // 生成无限级菜单数组数据
        $this->menu_tree = Tree::makeTreeForHtml($menu_data, array(
            'primary_key' => 'menu_id',
            'parent_key' => 'menu_parentid',
        ));
        $this->assign('menu_list', $this->menu_tree);

        parent::_initialize();
    }

    /**
     * index
     * 菜单管理 列表页
     *
     * @return \think\response\View
     */
    public function index()
    {
        return view('menu/index');
    }

    /**
     * add
     * 添加菜单
     *
     * @return \think\response\View
     */
    public function add($parent_id=null)
    {
        // 添加子菜单时的父级菜单id标识
        $this->assign('parent', $parent_id);

        return view('menu/add');
    }

    /**
     * edit
     * 修改菜单
     *
     * @param int $menu_id 菜单id
     * @return \think\response\View
     */
    public function edit($menu_id)
    {
        if (empty($menu_id)) exit;

        $result = $this->menu->get_single_menu($menu_id);
        $this->assign('menu', $result);

        return view('menu/edit');
    }

    /**
     * save
     * 保存菜单数据 添加|修改
     *
     * @return mixed
     */
    public function save()
    {
        if (!Request::instance()->isPost()) exit;

        $result = $this->menu->save_menu();

        if (!is_array($result)) {
            if ($result) {
                return json(array('status'=>1, 'msg'=>'操作成功', 'result'=>array('backUrl'=>url('admin/Menu/index'))));
            } else {
                return json(array('status'=>0, 'msg'=>'操作失败', 'result'=>''));
            }
        } else {
            return json($result);
        }
    }

    /**
     * sort
     * 菜单排序
     *
     * @return \think\response\Json
     */
    public function sort()
    {
        if (!Request::instance()->isPost()) exit;

        $result = $this->menu->sort_menu();

        if ($result) {
            return json(array('status'=>1, 'msg'=>'操作成功', 'result'=>''));
        } else {
            return json(array('status'=>0, 'msg'=>'操作失败', 'result'=>''));
        }
    }

    /**
     * del
     * 删除菜单
     *
     * @return \think\response\Json
     */
    public function del()
    {
        if (!Request::instance()->isAjax()) exit;

        $result = $this->menu->delete_menu();
        if ($result) {
            return json(array('status'=>1, 'msg'=>'操作成功', 'result'=>''));
        } else {
            return json(array('status'=>0, 'msg'=>'操作失败', 'result'=>''));
        }
    }

    // TODO 菜单状态设置
}