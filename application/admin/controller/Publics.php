<?php
/**
 * Created by PhpStorm.
 *
 * @Date: 2018-03-17
 * @Time: 23:41
 * @Author: cdkay
 * @Email: network@iyuanma.net
 *
 * @File： Publics.php
 */
namespace app\admin\controller;

use think\Controller;
use think\Cookie;
use think\Session;

class Publics extends Controller {
    /**
     * verify_code
     * 图形验证码
     *
     * @param $width
     * @param $height
     */
    public function verify_code($width, $height)
    {
        return verifyCode($width, $height);
    }

    /**
     * verifyCodeCheck
     * 图形验证码验证
     *
     * @param $code
     * @return bool
     */
    public static function verifyCodeCheck($code)
    {
        // 从session中读取验证码
        $getVerifyCode = Session::get('verifyCode', 'common');

        if ($code !== $getVerifyCode) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * logout
     * 用户退出登录
     */
    public function logout()
    {
        Session::delete('user', 'admin');
        Cookie::delete('admin_menu');

        $this->success('退出成功', 'admin/Login/index');
    }

    public function logoutNotTip()
    {
        Session::delete('user', 'admin');
        Cookie::delete('admin_menu');
        $this->redirect('admin/Login/index');
    }
}