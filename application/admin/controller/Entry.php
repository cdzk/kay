<?php
/**
 * Created by PhpStorm.
 *
 * @Date: 2017-08-26
 * @Time: 01:38
 * @Author: cdkay
 * @Email: network@iyuanma.net
 *
 * @File： Entry.php
 */
namespace app\admin\controller;

use app\admin\model\Admin_user;
use app\common\controller\General;
use think\Controller;
use think\Session;

class Entry extends Controller {
    protected $user;

    public function __construct()
    {
        parent::__construct();

        $this->user = new Admin_user();
    }

    /**
     * verify_code
     * 图片验证码
     *
     * @author zhengkai
     * @date 2017-08-26
     */
    public function verify_code()
    {
        return General::verify_code(120, 34);
    }

    /**
     * login
     * 管理后台登录页
     *
     * @author zhengkai
     * @date 2017-08-26
     *
     * @return \think\response\View
     */
    public function login()
    {
        return view('entry/login');
    }

    /**
     * login_action
     * 管理用户登录请求处理
     *
     * @author zhengkai
     * @date 2017-08-27
     *
     * @return array
     */
    public function login_action()
    {
        return $this->user->login_user();
    }

    public function logout()
    {
        Session::delete('user', 'admin');

        $this->success('退出成功', 'admin/Entry/login');
    }
}