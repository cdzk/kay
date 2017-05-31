<?php
/**
 * Created by PhpStorm.
 *
 * @Date: 2017-05-22
 * @Time: 01:30
 * @Author: cdkay
 * @Email: network@iyuanma.net
 *
 * @File： Admin_menu.php
 */

namespace app\admin\validate;

use think\Validate;

class AdminUser extends Validate {
    // 验证规则
    protected $rule =   [
        ['user_roleid', 'require|token:__hash__', '角色分组不能为空'],
        ['user_name', 'require', '系统用户名不能为空'],
        ['user_password', 'require|^(?=.*\d.*)(?=.*[a-zA-Z].*).{6,20}$', '登录密码不能为空|登录密码必须包含英文字母与数字，长度在6-20之间'],
        // ['user_realname', '/^([\x{4e00}-\x{9fa5}]+|([a-z]+\s?)+)$/u', '真实姓名，中文字符之间不允许有空格；英文字符之间只能有一个空格'],
        ['user_email', '^[\w\+\-]+(\.[\w\+\-]+)*@[a-z\d\-]+(\.[a-z\d\-]+)*\.([a-z]{2,4})$', '邮箱格式不正确'],
        ['user_mobile', '^1[3-9]\d{9}$', '手机号码格式不正确'],
    ];

    // 验证场景
    protected $scene = [
        'add' => ['user_name', 'user_password', 'user_email', 'user_mobile'],
        'edit' => ['user_email', 'user_mobile']
    ];
}