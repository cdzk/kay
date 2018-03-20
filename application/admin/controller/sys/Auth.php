<?php
/**
 * Created by PhpStorm.
 *
 * @Date: 2018-03-20
 * @Time: 22:20
 * @Author: cdkay
 * @Email: network@iyuanma.net
 *
 * @File： Auth.php
 */
namespace app\admin\controller\sys;

use app\admin\controller\Init;
use app\admin\model\sys\SysAuth;
use app\common\controller\Base;
use app\common\controller\Resource;

class Auth extends Init {
    /**
     * index
     * 权限列表
     *
     * @return \think\response\View
     */
    public function index()
    {
        $menu = SysAuth::treeAuth();
        $this->assign('auth_list', $menu);

        return $this->fetch('./sys/auth/list');
    }

    /**
     * add
     * 添加权限
     *
     * @param int $parentId 父级权限id，默认0
     * @return \think\response\View
     */
    public function add($parentId=0)
    {
        if (!request()->isPost()) {
            // 获取父级权限数据
            $parentAuth = SysAuth::getSingleAuth($parentId);
            $this->assign('parent_auth', $parentAuth);

            $authAll = SysAuth::treeAuth();
            $this->assign('auth_list', $authAll);

            return $this->fetch('./sys/auth/add');
        } else {
            $form = Base::formCheck([
                ['auth_parentid', 'require|integer|token:__hash__', '所属节点不能为空|参数类型错误'],
                ['auth_name', 'require', '权限名称不能为空'],
                ['auth_module', 'require', '模块名不能为空'],
                ['auth_controller', 'require', '控制器名不能为空'],
                ['auth_action', 'require', '方法名不能为空'],
            ]);

            $data = [
                'auth_parentid' => $form['auth_parentid'],
                'auth_name' => $form['auth_name'],
                'auth_module' => $form['auth_module'],
                'auth_controller' => $form['auth_controller'],
                'auth_action' => $form['auth_action'],
            ];

            $result = SysAuth::createAuth($data);

            if ($result) {
                return Resource::getBack(Resource::SUCCESS, '权限添加成功', [
                    'jumpUrl' => url('admin/sys.Auth/index')
                ]);
            } else {
                return Resource::getBack(Resource::ERROR, '权限添加失败');
            }
        }
    }

    /**
     * edit
     * 修改权限
     *
     * @param int $authId 权限id
     * @return \think\response\View
     */
    public function edit($authId)
    {
        if (empty($authId)) abort(Resource::ERR_REQUEST_INVALID, '请求错误');

        if (!request()->isPost()) {
            $auth = SysAuth::getSingleAuth($authId);
            if (!$auth) abort(Resource::ERR_REQUEST_INVALID, '请求错误');
            $this->assign('auth', $auth);

            $authAll = SysAuth::treeAuth();
            $this->assign('auth_list', $authAll);

            return $this->fetch('./sys/auth/edit');
        } else {
            $form = Base::formCheck([
                ['auth_parentid', 'require|integer|token:__hash__', '所属节点不能为空|参数类型错误'],
                ['auth_name', 'require', '权限名称不能为空'],
                ['auth_module', 'require', '模块名不能为空'],
                ['auth_controller', 'require', '控制器名不能为空'],
                ['auth_action', 'require', '方法名不能为空'],
            ]);

            $data = [
                'auth_parentid' => $form['auth_parentid'],
                'auth_name' => $form['auth_name'],
                'auth_module' => $form['auth_module'],
                'auth_controller' => $form['auth_controller'],
                'auth_action' => $form['auth_action'],
            ];

            $result = SysAuth::updateAuth($authId, $data);

            if ($result) {
                return Resource::getBack(Resource::SUCCESS, '权限节点更新成功', [
                    'jumpUrl' => url('admin/sys.Auth/index')
                ]);
            } else {
                return Resource::getBack(Resource::ERROR, '权限节点更新失败');
            }
        }
    }

    /**
     * del
     * 删除权限
     *
     * @return \think\response\Json
     */
    public function del()
    {
        if (!request()->isAjax()) abort(Resource::ERR_REQUEST_INVALID, '请求错误');

        $form = Base::formCheck([
            ['auth_id', 'require|integer', '权限id不能为空|参数类型错误'],
        ]);

        if (SysAuth::subAuthCount($form['auth_id'])) return Resource::getBack(Resource::ERR_DATA_INVALID, '存在子节点不允许删除');

        $result = SysAuth::deleteAuth($form['auth_id']);

        if ($result) {
            return Resource::getBack(Resource::SUCCESS, '操作成功');
        } else {
            return Resource::getBack(Resource::ERROR, '操作失败');
        }
    }
}