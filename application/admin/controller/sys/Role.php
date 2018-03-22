<?php
/**
 * Created by PhpStorm.
 *
 * @Date: 2018-03-21
 * @Time: 23:33
 * @Author: cdkay
 * @Email: network@iyuanma.net
 *
 * @File： Role.php
 */
namespace app\admin\controller\sys;

use app\admin\controller\Init;
use app\admin\model\sys\SysAuth;
use app\admin\model\sys\SysMenu;
use app\admin\model\sys\SysRole;
use app\common\controller\Base;
use app\common\controller\Resource;

class Role extends Init {
    /**
     * index
     * 系统用户角色 列表
     *
     * @return \think\response\View
     */
    public function index()
    {
        $role = SysRole::getAllRole();
        $this->assign('role_list', $role);

        return $this->fetch('./sys/role/list');
    }

    /**
     * add
     * 添加角色
     *
     * @return \think\response\View
     */
    public function add()
    {
        if (!request()->isPost()) {
            return $this->fetch('./sys/role/add');
        } else {
            $form = Base::formCheck([
                ['role_name', 'require|token:__hash__', '角色名称不能为空'],
            ]);

            $data = [
                'role_name' => $form['role_name'],
                'role_remake' => $form['role_remake'],
            ];

            $result = SysRole::createRole($data);

            if ($result) {
                return Resource::getBack(Resource::SUCCESS, '角色添加成功', [
                    'jumpUrl' => url('admin/sys.Role/index')
                ]);
            } else {
                return Resource::getBack(Resource::ERROR, '角色添加失败');
            }
        }
    }

    /**
     * edit
     * 修改角色
     *
     * @param int $roleId 角色id
     * @return \think\response\View
     */
    public function edit($roleId)
    {
        if (empty($roleId)) abort(Resource::ERR_REQUEST_INVALID, '请求错误');

        if (!request()->isPost()) {
            $role = SysRole::getSingleRole($roleId);
            if (!$role) abort(Resource::ERR_REQUEST_INVALID, '请求错误');
            $this->assign('role', $role);

            return $this->fetch('./sys/role/edit');
        } else {
            $form = Base::formCheck([
                ['role_name', 'require|token:__hash__', '角色名称不能为空'],
            ]);

            $data = [
                'role_name' => $form['role_name'],
                'role_remake' => $form['role_remake'],
            ];

            $result = SysRole::updateRole($roleId, $data);

            if ($result) {
                return Resource::getBack(Resource::SUCCESS, '角色更新成功', [
                    'jumpUrl' => url('admin/sys.Role/index')
                ]);
            } else {
                return Resource::getBack(Resource::ERROR, '角色更新失败');
            }
        }
    }

    /**
     * status
     * 设置角色状态
     *
     * @return \think\response\Json
     */
    public function status()
    {
        if (!request()->isPost()) abort(Resource::ERR_REQUEST_INVALID, '请求错误');

        $form = Base::formCheck([
            ['role_id', 'require|integer', '角色id不能为空|参数类型错误'],
            ['role_status', 'require|integer', '参数不能为空|参数类型错误'],
        ]);

        $result = SysRole::updateRoleStatus($form['role_id'], $form['role_status']);

        if ($result) {
            return Resource::getBack(Resource::SUCCESS, '操作成功');
        } else {
            return Resource::getBack(Resource::ERROR, '操作失败');
        }
    }

    /**
     * menu_auth
     * 设置角色菜单权限
     *
     * @param string $type 请求类型，默认加载数据，save=保存数据
     * @return \think\response\Json
     */
    public function menu_auth($type='')
    {
        if (!request()->isAjax()) abort(Resource::ERR_REQUEST_INVALID, '请求错误');

        switch ($type) {
            case 'save':
                if (!request()->isPost()) abort(Resource::ERR_REQUEST_INVALID, '请求错误');

                $form = Base::formCheck([
                    ['role_id', 'require|integer', '角色id不能为空|参数类型错误'],
                    ['checkedAuth', 'require', '权限参数|参数类型错误'],
                ]);

                $result = SysRole::updateRoleAuth($form['role_id'], ['role_menu'=>$form['checkedAuth']]);

                if ($result) {
                    return Resource::getBack(Resource::SUCCESS, '菜单权限更新成功');
                } else {
                    return Resource::getBack(Resource::ERROR, '菜单权限更新失败');
                }
                break;
            default:
                $form = Base::formCheck([
                    ['role_id', 'require|integer', '角色id不能为空|参数类型错误'],
                ]);
                $menu = SysMenu::treeMenu();
                $role = SysRole::getSingleRole($form['role_id']);

                $result = array(
                    'tree' => $menu,
                    'role_tree' => $role->role_menu
                );

                return json($result);
                break;
        }
    }

    /**
     * system_auth
     * 设置角色系统权限
     *
     * @param string $type 请求类型，默认加载数据，save=保存数据
     * @return \think\response\Json
     */
    public function system_auth($type='')
    {
        if (!request()->isAjax()) abort(Resource::ERR_REQUEST_INVALID, '请求错误');

        switch ($type) {
            case 'save':
                if (!request()->isPost()) abort(Resource::ERR_REQUEST_INVALID, '请求错误');

                $form = Base::formCheck([
                    ['role_id', 'require|integer', '角色id不能为空|参数类型错误'],
                ]);

                $result = SysRole::updateRoleAuth($form['role_id'], ['role_auth'=>$form['checkedAuth']]);

                if ($result) {
                    return Resource::getBack(Resource::SUCCESS, '系统权限更新成功');
                } else {
                    return Resource::getBack(Resource::ERROR, '系统权限更新失败');
                }
                break;
            default:
                $form = Base::formCheck([
                    ['role_id', 'require|integer', '角色id不能为空|参数类型错误'],
                ]);
                $auth = SysAuth::treeAuth();
                $role = SysRole::getSingleRole($form['role_id']);

                $result = array(
                    'tree' => $auth,
                    'role_tree' => $role->role_auth
                );

                return json($result);
                break;
        }
    }

    /**
     * del
     * 删除角色
     *
     * @return \think\response\Json
     */
    public function del()
    {
        if (!request()->isAjax()) abort(Resource::ERR_REQUEST_INVALID, '请求错误');

        $form = Base::formCheck([
            ['role_id', 'require|integer', '角色id不能为空|参数类型错误'],
        ]);

        // if (SysMenu::subMenuCount($form['menu_id'])) return Resource::getBack(Resource::ERR_DATA_INVALID, '存在子菜单不允许删除');

        $result = SysRole::deleteRole($form['role_id']);

        if ($result) {
            return Resource::getBack(Resource::SUCCESS, '操作成功');
        } else {
            return Resource::getBack(Resource::ERROR, '操作失败');
        }
    }
}