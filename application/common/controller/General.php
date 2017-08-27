<?php
/**
 * Created by PhpStorm.
 *
 * @Date: 2017-08-26
 * @Time: 03:31
 * @Author: cdkay
 * @Email: network@iyuanma.net
 *
 * @File： General.php
 */
namespace app\common\controller;

use Minho\Captcha\CaptchaBuilder;
use think\Controller;
use think\Session;

class General extends Controller {
    /**
     * verify_code
     * 图形验证码
     *
     * @param int $width 验证码宽度
     * @param int $height 验证码高度
     */
    public static function verify_code($width=150, $height=44)
    {
        $captch = new CaptchaBuilder();

        $captch->initialize([
            'width' => $width,      // 宽度
            'height' => $height,    // 高度
            'line' => false,        // 直线
            'curve' => true,        // 曲线
            'noise' => 1,           // 噪点背景
            'fonts' => []           // 字体
        ]);
        $captch->create();

        $captch->output(1);

        Session::set('verify_code', $captch->getText(), 'common');
    }
}