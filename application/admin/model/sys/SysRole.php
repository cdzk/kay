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

use think\Db;
use think\Log;
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

    /**
     * getAllRole
     * 获取全部角色数据
     *
     * @return false|static[]
     */
    public static function getAllRole()
    {
        $data = self::all();

        return $data;
    }

    /**
     * getLimitRole
     * 获取限制的角色数据
     * 非超管用户不允许获取“超级管理员”角色数据
     *
     * @return false|static[]
     */
    public static function getLimitRole($userRole)
    {
        $data = self::all(function ($query) use ($userRole){
            if ($userRole!==1) $query->where('role_id', '<>', 1);
        });

        return $data;
    }

    /**
     * createRole
     * 新增角色数据
     *
     * @param array $inputData
     * @return bool
     */
    public static function createRole($inputData=[])
    {
        Db::startTrans();
        try {
            self::create($inputData);
            Db::commit();
            return true;
        } catch (\Exception $e) {
            Log::error('新增系统用户角色【error】：'.$e->getMessage());
            Db::rollback();
            return false;
        }
    }

    /**
     * updateRole
     * 更新菜单数据
     *
     * @param $roleId
     * @param array $inputData
     * @return bool
     */
    public static function updateRole($roleId, $inputData=[])
    {
        Db::startTrans();
        try {
            self::where('role_id', $roleId)->update($inputData);
            Db::commit();
            return true;
        } catch (\Exception $e) {
            Log::error('更新系统用户角色【error】：'.$e->getMessage());
            Db::rollback();
            return false;
        }
    }

    /**
     * updateRoleStatus
     * 更新角色状态
     *
     * @param $roleId
     * @param $status
     * @return bool
     */
    public static function updateRoleStatus($roleId, $status)
    {
        Db::startTrans();
        try {
            self::where('role_id', $roleId)->update(['role_status'=>$status]);
            Db::commit();
            return true;
        } catch (\Exception $e) {
            Log::error('更新系统用户角色状态【error】：'.$e->getMessage());
            Db::rollback();
            return false;
        }
    }

    /**
     * deleteRole
     * 删除角色数据
     *
     * @param $roleId
     * @return bool
     */
    public static function deleteRole($roleId)
    {
        Db::startTrans();
        try {
            self::destroy($roleId);
            Db::commit();
            return true;
        } catch (\Exception $e) {
            Log::error('删除系统用户角色【error】：'.$e->getMessage());
            Db::rollback();
            return false;
        }
    }

    /**
     * updateRoleAuth
     * 更新角色(菜单、系统)权限
     *
     * @param $roleId
     * @param array $auth 要更新的权限
     * @return bool
     */
    public static function updateRoleAuth($roleId, $auth=[])
    {
        Db::startTrans();
        try {
            self::where('role_id', $roleId)->update($auth);
            Db::commit();
            return true;
        } catch (\Exception $e) {
            Log::error('更新系统用户角色菜单权限【error】：'.$e->getMessage());
            Db::rollback();
            return false;
        }
    }
}