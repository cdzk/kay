<?php
/**
 * Created by PhpStorm.
 *
 * @Date: 2017-05-24
 * @Time: 23:08
 * @Author: cdkay
 * @Email: network@iyuanma.net
 *
 * @File： User.php
 */

namespace app\admin\controller;

use app\admin\model\Admin_user;
use think\Request;

class User extends Base
{
    private $user;
    public function _initialize()
    {
        // 实例化系统用户模型
        $this->user = new Admin_user();

        parent::_initialize();
    }

    /**
     * index
     * 系统用户 列表
     *
     * @return \think\response\View
     */
    public function index()
    {
        // 获取系统用户数据
        $data = $this->user->get_query_user();
        $this->assign('user_list', $data);

        return view('user/index');
    }

    /**
     * add
     * 添加用户
     *
     * @return \think\response\View
     * TODO 角色分组
     */
    public function add()
    {
        return view('user/add');
    }

    /**
     * edit
     * 修改用户
     *
     * @param int $user_id 用户id
     * @return \think\response\View
     * TODO 角色分组
     */
    public function edit($user_id)
    {
        if (empty($user_id)) exit;

        $result = $this->user->get_single_user($user_id);
        $this->assign('user', $result);

        return view('user/edit');
    }

    // TODO 修改当前登录用户资料

    /**
     * repeat
     * 用户(用户名)重复检测
     *
     * @return \think\response\Json
     */
    public function repeat()
    {
        if (!Request::instance()->isPost()) exit;

        $result = $this->user->repeat_user();

        if ($result) {
            return json(array('info'=>'用户名已经存在', 'status'=>'n'));
        } else {
            return json(array('info'=>'验证通过！', 'status'=>'y'));
        }
    }

    /**
     * save
     * 保存用户数据 添加|修改
     *
     * @return \think\response\Json
     */
    public function save()
    {
        if (!Request::instance()->isPost()) exit;

        $result = $this->user->save_user();

        if (!is_array($result)) {
            if ($result) {
                return json(array('status'=>1, 'msg'=>'操作成功', 'result'=>array('jumpUrl'=>url('admin/User/index'))));
            } else {
                return json(array('status'=>0, 'msg'=>'操作失败', 'result'=>''));
            }
        } else {
            return json($result);
        }
    }

    /**
     * del
     * 删除用户
     *
     * @return \think\response\Json
     */
    public function del()
    {
        if (!Request::instance()->isAjax()) exit;

        $result = $this->user->delete_user();

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

    // TODO 设置用户状态
}