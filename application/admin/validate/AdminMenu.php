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

class AdminMenu extends Validate {
    protected $rule =   [
        ['menu_parentid', 'require|token:__hash__', '上级菜单不能为空'],
        ['menu_name', 'require', '菜单名称不能为空'],
        ['menu_module', '[a-z]+$', '模块名只允许小写英文字母'],
        ['menu_controller', '^[A-Z][A-Za-z]+$', '控制器名只允许为英文字母，且首字母必须为大写'],
        ['menu_action', '[a-zA-Z_]+$', '方法名只允许为英文字母与下划线'],
    ];
}