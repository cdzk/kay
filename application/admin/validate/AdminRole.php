<?php
/**
 * Created by PhpStorm.
 *
 * @Date: 2017-05-31
 * @Time: 12:17
 * @Author: cdkay
 * @Email: network@iyuanma.net
 *
 * @File： AdminRole.php
 */

namespace app\admin\validate;

use think\Validate;

class AdminRole extends Validate {
    protected $rule =   [
        ['role_name', 'require|token:__hash__', '角色名称不能为空'],
        ['role_remake', 'max:80', '角色描述最多允许80个字符']
    ];
}