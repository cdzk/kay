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

use think\Db;
use think\Log;
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
        $data = self::get(function ($query) use ($userId) {
            $query->alias('u')
                ->join('sys_role r', 'u.user_roleid=r.role_id', 'left')
                ->where('user_id', $userId)
                ->field('u.*, r.role_name');
        });

        return $data;
    }

    /**
     * getAllUser
     * 获取全部用户数据
     *
     * @return false|static[]
     */
    public static function getAllUser($roleId=0)
    {
        $data = self::all(function ($query) use ($roleId) {
            $query->alias('u')
                ->join('sys_role r', 'u.user_roleid=r.role_id', 'left')
                ->field('u.*,r.role_name');
            if ($roleId) $query->where('u.user_roleid', $roleId);
        });

        return $data;
    }

    /**
     * createUser
     * 新增用户数据
     *
     * @param array $inputData
     * @return bool
     */
    public static function createUser($inputData=[])
    {
        Db::startTrans();
        try {
            self::create($inputData);
            Db::commit();
            return true;
        } catch (\Exception $e) {
            Log::error('新增系统用户【error】：'.$e->getMessage());
            Db::rollback();
            return false;
        }
    }

    /**
     * updateUser
     * 更新用户数据
     *
     * @param $userId
     * @param array $inputData
     * @return bool
     */
    public static function updateUser($userId, $inputData=[])
    {
        Db::startTrans();
        try {
            self::where('user_id', $userId)->update($inputData);
            Db::commit();
            return true;
        } catch (\Exception $e) {
            Log::error('更新系统用户【error】：'.$e->getMessage());
            Db::rollback();
            return false;
        }
    }

    /**
     * updateUserStatus
     * 更新用户状态
     *
     * @param $userId
     * @param $status
     * @return bool
     */
    public static function updateUserStatus($userId, $status)
    {
        Db::startTrans();
        try {
            self::where('user_id', $userId)->update(['user_status'=>$status]);
            Db::commit();
            return true;
        } catch (\Exception $e) {
            Log::error('更新系统用户状态【error】：'.$e->getMessage());
            Db::rollback();
            return false;
        }
    }

    /**
     * deleteUser
     * 删除用户数据
     *
     * @param $roleId
     * @return bool
     */
    public static function deleteUser($userId)
    {
        Db::startTrans();
        try {
            self::destroy($userId);
            Db::commit();
            return true;
        } catch (\Exception $e) {
            Log::error('删除系统用户【error】：'.$e->getMessage());
            Db::rollback();
            return false;
        }
    }

    // todo 更新用户密码
    public static function updatePassword($userId, $password)
    {
        Db::startTrans();
        try {
            self::where('user_id', $userId)->update(['user_password'=>$password]);
            Db::commit();
            return true;
        } catch (\Exception $e) {
            Log::error('更新系统用户密码【error】：'.$e->getMessage());
            Db::rollback();
            return false;
        }
    }
}