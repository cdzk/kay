<?php
/**
 * Created by PhpStorm.
 *
 * @Date: 2018-03-17
 * @Time: 23:04
 * @Author: cdkay
 * @Email: network@iyuanma.net
 *
 * @File： Login.php
 */
namespace app\admin\controller;

use app\admin\model\sys\SysUser;
use app\common\controller\Resource;
use think\Collection;
use app\common\controller\Base;
use think\Session;

class Login extends Collection {
    /**
     * index
     * 用户登录
     *
     * @return \think\response\View
     */
    public function index()
    {
        return view('./login');
    }

    /**
     * action
     * 用户登录请求
     *
     * @return array
     */
    public function action()
    {
        if (!request()->isPost()) abort(Resource::ERR_REQUEST_INVALID, '请求错误');

        $form = Base::formCheck([
            ['user_name', 'require', '用户名不能为空'],
            ['user_password', 'require', '登录密码不能为空'],
            ['verify_code', 'require', '验证码不能为空'],
        ]);

        if (!Publics::verifyCodeCheck($form['verify_code'])) return Resource::getBack(Resource::ERR_DATA_INVALID, '验证码错误');

        $user = SysUser::getInfoForName($form['user_name']);
        if (!$user) return Resource::getBack(Resource::ERR_DATA_INVALID, '用户不存在');

        if (!Base::checkPassword($form['user_password'], $user->user_password)) return Resource::getBack(Resource::ERR_DATA_INVALID, '密码错误');

        if (!$user->user_status) return Resource::getBack(Resource::ERR_DATA_INVALID, '账号已被禁止登录');

        // 保存登录用户必要信息到session
        $data = [
            'user_id' => $user['user_id'],
            // 'user_roleid' => $user['user_roleid'], // 用户角色
        ];
        Session::set('user', serialize($data), 'admin');

        return Resource::getBack(Resource::SUCCESS, '登录成功', [
            'jumpUrl' => url('admin/Index/index')
        ]);
    }
}