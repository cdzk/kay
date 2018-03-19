<?php
/**
 * Created by PhpStorm.
 *
 * @Date: 2018-03-19
 * @Time: 22:33
 * @Author: cdkay
 * @Email: network@iyuanma.net
 *
 * @File： SysRole.php
 */
namespace app\admin\model\sys;

use think\Model;

class SysRole extends Model {
    protected $pk = 'role_id';

    /**
     * getSingleRole
     * 获取单条角色数据
     *
     * @param int $roleId 角色id
     * @return null|static
     */
    public static function getSingleRole($roleId)
    {
        $data = self::get(function ($query) use ($roleId) {
            $query->where('role_id', $roleId);
        });

        return $data;
    }
}