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

namespace app\admin\controller\sys;

use app\admin\controller\Init;
use app\admin\model\sys\SysMenu;
use app\common\controller\Base;
use app\common\controller\Resource;

class Menu extends Init {
    /**
     * index
     * 菜单列表
     *
     * @return \think\response\View
     */
    public function index()
    {
        $menu = SysMenu::treeMenu();
        $this->assign('menu_list', $menu);

        return $this->fetch('./sys/menu/list');
    }

    /**
     * add
     * 添加菜单
     *
     * @param int $parentId 父级菜单id，默认0
     * @return \think\response\View
     */
    public function add($parentId=0)
    {
        if (!request()->isPost()) {
            // 获取父级菜单数据
            $parentMenu = SysMenu::getSingleMenu($parentId);
            $this->assign('parent_menu', $parentMenu);

            $menuAll = SysMenu::treeMenu();
            $this->assign('menu_list', $menuAll);

            return $this->fetch('./sys/menu/add');
        } else {
            $form = Base::formCheck([
                ['menu_parentid', 'require|integer|token:__hash__', '上级菜单不能为空|参数类型错误'],
                ['menu_name', 'require', '菜单名称不能为空'],
            ]);

            $data = [
                'menu_parentid' => $form['menu_parentid'],
                'menu_name' => $form['menu_name'],
                'menu_module' => $form['menu_module'],
                'menu_controller' => $form['menu_controller'],
                'menu_action' => $form['menu_action'],
                'menu_status' => $form['menu_status'],
            ];

            $result = SysMenu::createMenu($data);

            if ($result) {
                return Resource::getBack(Resource::SUCCESS, '菜单添加成功', [
                    'jumpUrl' => url('admin/sys.Menu/index')
                ]);
            } else {
                return Resource::getBack(Resource::ERROR, '菜单添加失败');
            }
        }
    }

    /**
     * edit
     * 修改菜单
     *
     * @param int $menu_id 菜单id
     * @return \think\response\View
     */
    public function edit($menuId)
    {
        if (empty($menuId)) abort(Resource::ERR_REQUEST_INVALID, '请求错误');

        if (!request()->isPost()) {
            $menu = SysMenu::getSingleMenu($menuId);
            if (!$menu) abort(Resource::ERR_REQUEST_INVALID, '请求错误');
            $this->assign('menu', $menu);

            $menuAll = SysMenu::treeMenu();
            $this->assign('menu_list', $menuAll);

            return $this->fetch('./sys/menu/edit');
        } else {
            $form = Base::formCheck([
                ['menu_parentid', 'require|integer|token:__hash__', '上级菜单不能为空|参数类型错误'],
                ['menu_name', 'require', '菜单名称不能为空'],
            ]);

            $data = [
                'menu_parentid' => $form['menu_parentid'],
                'menu_name' => $form['menu_name'],
                'menu_module' => $form['menu_module'],
                'menu_controller' => $form['menu_controller'],
                'menu_action' => $form['menu_action'],
                'menu_status' => $form['menu_status'],
            ];

            $result = SysMenu::updateMenu($menuId, $data);

            if ($result) {
                return Resource::getBack(Resource::SUCCESS, '菜单更新成功', [
                    'jumpUrl' => url('admin/sys.Menu/index')
                ]);
            } else {
                return Resource::getBack(Resource::ERROR, '菜单更新失败');
            }
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
        if (!request()->isPost()) abort(Resource::ERR_REQUEST_INVALID, '请求错误');

        $form = Base::formCheck([
            ['menu_sort', 'require', '参数不能为空'],
        ]);

        $result = SysMenu::updateMenuSort($form['menu_sort']);

        if ($result) {
            return Resource::getBack(Resource::SUCCESS, '操作成功', [
                'jumpUrl' => $_SERVER['HTTP_REFERER']
            ]);
        } else {
            return Resource::getBack(Resource::ERROR, '操作失败');
        }
    }

    /**
     * 设置菜单状态
     *
     * @return \think\response\Json
     */
    public function status()
    {
        if (!request()->isPost()) abort(Resource::ERR_REQUEST_INVALID, '请求错误');

        $form = Base::formCheck([
            ['menu_id', 'require|integer', '菜单id不能为空|参数类型错误'],
            ['menu_status', 'require|integer', '参数不能为空|参数类型错误'],
        ]);

        $result = SysMenu::updateMenuStatus($form['menu_id'], $form['menu_status']);

        if ($result) {
            return Resource::getBack(Resource::SUCCESS, '操作成功');
        } else {
            return Resource::getBack(Resource::ERROR, '操作失败');
        }
    }

    /**
     * 删除菜单
     *
     * @return \think\response\Json
     */
    public function del()
    {
        if (!request()->isAjax()) abort(Resource::ERR_REQUEST_INVALID, '请求错误');

        $form = Base::formCheck([
            ['menu_id', 'require|integer', '菜单id不能为空|参数类型错误'],
        ]);

        if (SysMenu::subMenuCount($form['menu_id'])) return Resource::getBack(Resource::ERR_DATA_INVALID, '存在子菜单不允许删除');

        $result = SysMenu::deleteMenu($form['menu_id']);

        if ($result) {
            return Resource::getBack(Resource::SUCCESS, '操作成功');
        } else {
            return Resource::getBack(Resource::ERROR, '操作失败');
        }
    }
}