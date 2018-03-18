<?php
/**
 * Created by PhpStorm.
 *
 * @Date: 2018-03-18
 * @Time: 23:43
 * @Author: cdkay
 * @Email: network@iyuanma.net
 *
 * @File： Base.php
 */
namespace app\common\controller;

use library\PasswordHash;
use think\Controller;
use think\Validate;

class Base extends Controller {
    /**
     * formCheck
     * 表单验证
     *
     * @param array $rules 验证规则
     * @return array|mixed
     */
    public static function formCheck($rules)
    {
        $form = input('');

        $validate = new Validate($rules);

        if (!$validate->check($form)) {
            return Resource::getBack(Resource::ERR_FORM_INVALID, $validate->getError());
        } else {
            return $form;
        }
    }

    /**
     * encryptPassword
     * 把需要加密的密码通过Phpass进行加密处理
     *
     * @param string|int $password 需要加密的密码
     * @return bool|string
     */
    public static function encryptPassword($password)
    {
        $lib = new PasswordHash(8, false);

        $result = $lib->HashPassword($password);

        return $result;
    }

    /**
     * checkPassword
     * 密码验证
     *
     * @param string|int $inputPass 需要比较的密码
     * @param string $comparePass 比较密码样本
     * @return bool
     */
    public static function checkPassword($inputPass, $comparePass)
    {
        $lib = new PasswordHash(8, false);

        $result = $lib->CheckPassword($inputPass, $comparePass);

        return $result;
    }
}