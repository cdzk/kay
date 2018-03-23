<?php
/**
 * Created by PhpStorm.
 *
 * @Date: 2018-03-22
 * @Time: 23:45
 * @Author: cdkay
 * @Email: network@iyuanma.net
 *
 * @File： User.php
 */
namespace app\admin\controller\sys;

use app\admin\controller\Init;
use app\admin\model\sys\SysRole;
use app\admin\model\sys\SysUser;
use app\common\controller\Base;
use app\common\controller\Resource;

class User extends Init {
    /**
     * index
     * 用户列表
     *
     * @return \think\response\View
     */
    public function index($roleId=null)
    {
        $user = SysUser::getAllUser($roleId);
        $this->assign('user_list', $user);

        return $this->fetch('./sys/user/list');
    }

    /**
     * add
     * 添加用户
     *
     * @return \think\response\View
     */
    public function add()
    {
        if (!request()->isPost()) {
            $role = SysRole::getLimitRole(Init::$user['user_roleid']);
            $this->assign('role_list', $role);

            return $this->fetch('./sys/user/add');
        } else {
            $form = Base::formCheck([
                ['user_name', 'require|token:__hash__', '用户名不能为空'],
                ['user_roleid', 'require|integer', '用户角色不能为空|参数类型错误'],
                ['user_password', 'require|^(?=.*\d.*)(?=.*[a-zA-Z].*).{6,20}$', '登录密码不能为空|密码必须同时包含英文字母与数字，长度在6-20之间'],
                ['user_email', '^[\w\+\-]+(\.[\w\+\-]+)*@[a-z\d\-]+(\.[a-z\d\-]+)*\.([a-z]{2,4})$', '邮箱格式不正确'],
                ['user_mobile', '^1[3-9]\d{9}$', '手机号码格式不正确'],
            ]);

            $data = [
                'user_name' => $form['user_name'],
                'user_roleid' => $form['user_roleid'],
                'user_password' => Base::encryptPassword($form['user_password']),
                'user_realname' => $form['user_realname'],
                'user_mobile' => $form['user_mobile'],
                'user_email' => $form['user_email'],
                'user_addtime' => time(),
            ];

            $result = SysUser::createUser($data);

            if ($result) {
                return Resource::getBack(Resource::SUCCESS, '用户添加成功', [
                    'jumpUrl' => url('admin/sys.User/index')
                ]);
            } else {
                return Resource::getBack(Resource::ERROR, '用户添加失败');
            }
        }
    }

    /**
     * repeat
     * 用户(用户名)重复检测
     *
     * @return \think\response\Json
     */
    public function repeat()
    {
        if (!request()->isPost()) abort(Resource::ERR_REQUEST_INVALID, '请求错误');

        $form = Base::formCheck([
            ['param', 'require', '参数错误'],
        ]);

        $result = SysUser::getInfoForName($form['param']);

        if ($result) {
            return json(array('info'=>'用户名已经存在', 'status'=>'n'));
        } else {
            return json(array('info'=>'验证通过！', 'status'=>'y'));
        }
    }

    /**
     * edit
     * 修改用户
     *
     * @param int $userId 用户id
     * @return \think\response\View
     */
    public function edit($userId)
    {
        if (empty($userId)) abort(Resource::ERR_REQUEST_INVALID, '请求错误');

        if (!request()->isPost()) {
            $role = SysRole::getLimitRole(Init::$user['user_roleid']);
            $this->assign('role_list', $role);

            $user = SysUser::getSingleUser($userId);
            if (!$user) abort(Resource::ERR_REQUEST_INVALID, '请求错误');
            $this->assign('user', $user);

            return $this->fetch('./sys/user/edit');
        } else {
            $form = Base::formCheck([
                ['user_roleid', 'require|integer', '用户角色不能为空|参数类型错误'],
                ['user_password', '^(?=.*\d.*)(?=.*[a-zA-Z].*).{6,20}$', '登录密码不能为空|密码必须同时包含英文字母与数字，长度在6-20之间'],
                ['user_email', '^[\w\+\-]+(\.[\w\+\-]+)*@[a-z\d\-]+(\.[a-z\d\-]+)*\.([a-z]{2,4})$', '邮箱格式不正确'],
                ['user_mobile', '^1[3-9]\d{9}$', '手机号码格式不正确'],
            ]);

            $data = [
                'user_roleid' => $form['user_roleid'],
                'user_realname' => $form['user_realname'],
                'user_mobile' => $form['user_mobile'],
                'user_email' => $form['user_email'],
                'user_addtime' => time(),
            ];
            // 只有在设置了密码时才对密码进行更新
            if (isset($form['user_password']) && !empty($form['user_password'])) $data['user_password'] = Base::encryptPassword($form['user_password']);

            $result = SysUser::updateUser($userId, $data);

            if ($result) {
                return Resource::getBack(Resource::SUCCESS, '用户更新成功', [
                    'jumpUrl' => url('admin/sys.User/index')
                ]);
            } else {
                return Resource::getBack(Resource::ERROR, '用户更新失败');
            }
        }
    }

    /**
     * status
     * 设置用户状态
     *
     * @return \think\response\Json
     */
    public function status()
    {
        if (!request()->isPost()) abort(Resource::ERR_REQUEST_INVALID, '请求错误');

        $form = Base::formCheck([
            ['user_id', 'require|integer', '用户id不能为空|参数类型错误'],
            ['user_status', 'require|integer', '参数不能为空|参数类型错误'],
        ]);

        $result = SysUser::updateUserStatus($form['user_id'], $form['user_status']);

        if ($result) {
            return Resource::getBack(Resource::SUCCESS, '操作成功');
        } else {
            return Resource::getBack(Resource::ERROR, '操作失败');
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
        if (!request()->isAjax()) abort(Resource::ERR_REQUEST_INVALID, '请求错误');

        $form = Base::formCheck([
            ['user_id', 'require|integer', '角色id不能为空|参数类型错误'],
        ]);

        $result = SysUser::deleteUser($form['user_id']);

        if ($result) {
            return Resource::getBack(Resource::SUCCESS, '操作成功');
        } else {
            return Resource::getBack(Resource::ERROR, '操作失败');
        }
    }

    // todo 密码修改
    public function safe()
    {
        if (!request()->isPost()) abort(Resource::ERR_REQUEST_INVALID, '请求错误');

        $form = Base::formCheck([
            ['user_id', 'require|integer|token:__hash__', '用户id不能为空|参数类型错误'],
            ['user_password', 'require', '参数不能为空|参数类型错误'],
        ]);

        $result = SysUser::updatePassword($form['user_id'], Base::encryptPassword($form['user_password']));

        if ($result) {
            return Resource::getBack(Resource::SUCCESS, '密码修改成功，请重新登录', [
                'jumpUrl' => url('admin/Publics/logoutNotTip')
            ]);
        } else {
            return Resource::getBack(Resource::ERROR, '操作失败');
        }
    }
}