<?php
/**
 * Created by PhpStorm.
 *
 * @Date: 2017-05-24
 * @Time: 16:32
 * @Author: cdkay
 * @Email: network@iyuanma.net
 *
 * @File： Auth.php
 */

namespace app\admin\validate;

use think\Validate;

class AdminAuth extends Validate {
    protected $rule =   [
        ['auth_parentid', 'require|token:__hash__', '所属节点不能为空'],
        ['auth_name', 'require', '权限名称不能为空'],
        ['auth_module', 'require|[a-z]+$', '模块名不能为空|模块名只允许小写英文字母'],
        ['auth_controller', 'require|^[A-Z][A-Za-z]+$', '控制器名不能为空|控制器名只允许为英文字母，且首字母必须为大写'],
        ['auth_action', 'require|[a-zA-Z_]+$', '方法名不能为空|方法名只允许为英文字母与下划线'],
    ];
}