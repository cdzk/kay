<?php
/**
 * Created by PhpStorm.
 *
 * @Date: 2017-05-24
 * @Time: 15:27
 * @Author: cdkay
 * @Email: network@iyuanma.net
 *
 * @File： Auth.php
 */

namespace app\admin\controller;
use app\admin\model\Admin_auth;
use library\Tree;
use think\Request;

class Auth extends Base{
    private $auth;
    private $auth_tree;

    public function _initialize()
    {
        // 获取所有权限数据
        $this->auth = new Admin_auth();
        $auth_data = $this->auth->get_all_auth();

        // 生成无限级菜单数组数据
        $this->auth_tree = Tree::makeTreeForHtml($auth_data, array(
            'primary_key' => 'auth_id',
            'parent_key' => 'auth_parentid',
        ));
        $this->assign('auth_list', $this->auth_tree);

        parent::_initialize();
    }

    /**
     * index
     * 权限管理 列表
     *
     * @return \think\response\View
     */
    public function index()
    {
        return view('auth/index');
    }

    /**
     * add
     * 添加权限
     *
     * @param int $parent_id 权限父节点id 有值时表示添加权限子节点
     * @return \think\response\View
     */
    public function add($parent_id=null)
    {
        // 添加子权限节点时的父级节点id标识
        $this->assign('parent', $parent_id);

        return view('auth/add');
    }

    /**
     * edit
     * 修改权限
     *
     * @param int $auth_id 权限id
     * @return \think\response\View
     */
    public function edit($auth_id)
    {
        if (empty($auth_id)) exit;

        $result = $this->auth->get_single_auth($auth_id);
        $this->assign('auth', $result);

        return view('auth/edit');
    }

    /**
     * save
     * 保存权限数据 添加|修改
     *
     * @return mixed
     */
    public function save()
    {
        if (!Request::instance()->isPost()) exit;

        $result = $this->auth->save_auth();

        if (!is_array($result)) {
            if ($result) {
                return json(array('status'=>1, 'msg'=>'操作成功', 'result'=>array('jumpUrl'=>url('admin/Auth/index'))));
            } else {
                return json(array('status'=>0, 'msg'=>'操作失败', 'result'=>''));
            }
        } else {
            return json($result);
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
        if (!Request::instance()->isAjax()) exit;

        $result = $this->auth->delete_auth();

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
}