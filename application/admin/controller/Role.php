<?php
/**
 * Created by PhpStorm.
 *
 * @Date: 2017-05-31
 * @Time: 11:18
 * @Author: cdkay
 * @Email: network@iyuanma.net
 *
 * @File： Role.php
 */

namespace app\admin\controller;

use app\admin\model\Admin_role;
use think\Request;

class Role extends Base
{
    private $role;
    public function _initialize()
    {
        // 实例化系统用户角色模型
        $this->role = new Admin_role();

        parent::_initialize();
    }

    /**
     * index
     * 系统用户角色 列表
     *
     * @return \think\response\View
     */
    public function index()
    {
        // 获取系统用户角色数据
        $data = $this->role->get_query_user();
        $this->assign('role_list', $data);

        return view('role/index');
    }

    /**
     * add
     * 添加角色
     *
     * @return \think\response\View
     */
    public function add()
    {
        return view('role/add');
    }

    /**
     * edit
     * 修改角色
     *
     * @param int $role_id 角色id
     * @return \think\response\View
     */
    public function edit($role_id)
    {
        if (empty($role_id)) exit;

        $result = $this->role->get_single_role($role_id);
        $this->assign('role', $result);

        return view('role/edit');
    }

    /**
     * save
     * 保存角色数据 添加|修改
     *
     * @return \think\response\Json
     */
    public function save()
    {
        if (!Request::instance()->isPost()) exit;

        $result = $this->role->save_role();

        if (!is_array($result)) {
            if ($result) {
                return json(array('status'=>1, 'msg'=>'操作成功', 'result'=>array('jumpUrl'=>url('admin/Role/index'))));
            } else {
                return json(array('status'=>0, 'msg'=>'操作失败', 'result'=>''));
            }
        } else {
            return json($result);
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
        if (!Request::instance()->isAjax()) exit;

        $result = $this->role->delete_role();

        if (!is_array($result)) {
            if ($result) {
                return json(array('status'=>1, 'msg'=>'操作成功', 'result'=>''));
            } else {
                return json(array('status'=>0, 'msg'=>'操作失败', 'result'=>''));
            }
        } else {
            return json($result);
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
        if (!Request::instance()->isAjax()) exit;

        $result = $this->role->status_role();

        if ($result) {
            return json(array('status'=>1, 'msg'=>'操作成功', 'result'=>''));
        } else {
            return json(array('status'=>0, 'msg'=>'操作失败', 'result'=>''));
        }
    }

    /**
     * auth_menu
     * 设置角色菜单权限
     *
     * @param string $type 请求类型
     * @return \think\response\Json
     */
    public function auth_menu($type=null)
    {
        if (!Request::instance()->isAjax()) exit;

        switch ($type) {
            case 'save': // 保存权限数据
                $result = $this->role->save_role_menu();

                if ($result) {
                    return json(array('status'=>1, 'msg'=>'操作成功', 'result'=>''));
                } else {
                    return json(array('status'=>0, 'msg'=>'操作失败', 'result'=>''));
                }
                break;
            default:
                // 获取菜单数据
                $tree = $this->role->get_menu();

                // 根据角色id获取角色id的菜单权限数据
                $role_tree = $this->role->get_single_role(input('post.id'));

                $result = array(
                    'tree' => $tree,
                    'role_tree' => $role_tree['role_menu']
                );
                return json($result);
                break;
        }
    }

    /**
     * auth
     * 设置角色管理权限
     *
     * @param string $type 请求类型
     * @return \think\response\Json
     */
    public function auth($type=null)
    {
        if (!Request::instance()->isAjax()) exit;

        switch ($type) {
            case 'save': // 保存权限数据
                $result = $this->role->save_role_auth();

                if ($result) {
                    return json(array('status'=>1, 'msg'=>'操作成功', 'result'=>''));
                } else {
                    return json(array('status'=>0, 'msg'=>'操作失败', 'result'=>''));
                }
                break;
            default:
                // 获取菜单数据
                $tree = $this->role->get_auth();

                // 根据角色id获取角色id的管理权限数据
                $role_tree = $this->role->get_single_role(input('post.id'));

                $result = array(
                    'tree' => $tree,
                    'role_tree' => $role_tree['role_auth']
                );
                return json($result);
                break;
        }
    }
}