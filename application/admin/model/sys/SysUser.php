<?php
/**
 * Created by PhpStorm.
 *
 * @Date: 2018-03-18
 * @Time: 14:02
 * @Author: cdkay
 * @Email: network@iyuanma.net
 *
 * @File： SysUser.php
 */
namespace app\admin\model\sys;

use think\Model;

class SysUser extends Model {
    protected $pk = 'user_id';

    /**
     * getInfoForName
     * 通过用户名查询获取用户信息
     *
     * @param string $uname 用户名
     * @return bool|null|static
     */
    public static function getInfoForName($uname)
    {
        $data = self::get(['user_name'=>$uname]);

        if ($data) {
            return $data;
        } else {
            return false;
        }
    }

    /**
     * getSingleUser
     * 获取单条用户数据
     *
     * @param int $userId 用户id
     * @return null|static
     */
    public static function getSingleUser($userId)
    {
        $data = self::get($userId);

        return $data;
    }
}