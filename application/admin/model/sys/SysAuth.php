<?php
/**
 * Created by PhpStorm.
 *
 * @Date: 2018-03-20
 * @Time: 22:24
 * @Author: cdkay
 * @Email: network@iyuanma.net
 *
 * @File： SysAuth.php
 */
namespace app\admin\model\sys;

use library\Tree;
use think\Db;
use think\Log;
use think\Model;

class SysAuth extends Model {
    protected $pk = 'auth_id';

    /**
     * getAllAuth
     * 获取全部权限数据
     *
     * @return false|static[]
     */
    public static function getAllAuth()
    {
        $data = self::all();

        return $data;
    }

    /**
     * getInAuth
     * 获取全部或指定范围的权限数据
     *
     * @param $menuId
     * @return false|static[]
     */
    public static function getInAuth($authId)
    {
        $data = self::all(function ($query) use ($authId) {
            if ($authId!=='super') {
                $query->where('auth_id', 'in', $authId);
            }
        });

        return $data;
    }

    /**
     * treeMenu
     * 生成树状权限数据
     *
     * @return array
     */
    public static function treeAuth()
    {
        $data = self::getAllAuth();

        $result = Tree::makeTreeForHtml($data, array(
            'primary_key' => 'auth_id',
            'parent_key' => 'auth_parentid',
        ));

        return $result;
    }

    /**
     * getSingleAuth
     * 获取单条权限数据
     *
     * @param $authId
     * @return null|static
     */
    public static function getSingleAuth($authId)
    {
        $data = self::get($authId);

        return $data;
    }

    /**
     * createAuth
     * 新增权限数据
     *
     * @param array $inputData
     * @return bool
     */
    public static function createAuth($inputData=[])
    {
        Db::startTrans();
        try {
            self::create($inputData);
            Db::commit();
            return true;
        } catch (\Exception $e) {
            Log::error('新增系统权限【error】：'.$e->getMessage());
            Db::rollback();
            return false;
        }
    }

    /**
     * updateAuth
     * 更新权限数据
     *
     * @param $authId
     * @param array $inputData
     * @return bool
     */
    public static function updateAuth($authId, $inputData=[])
    {
        Db::startTrans();
        try {
            self::where('auth_id', $authId)->update($inputData);
            Db::commit();
            return true;
        } catch (\Exception $e) {
            Log::error('更新系统权限【error】：'.$e->getMessage());
            Db::rollback();
            return false;
        }
    }

    /**
     * subAuthCount
     * 权限子节点统计
     *
     * @param $authId
     * @return int|string
     */
    public static function subAuthCount($authId)
    {
        $data = self::where('auth_parentid', $authId)->count();

        return $data;
    }

    /**
     * deleteAuth
     * 删除权限数据
     *
     * @param $authId
     * @return bool
     */
    public static function deleteAuth($authId)
    {
        Db::startTrans();
        try {
            self::destroy($authId);
            Db::commit();
            return true;
        } catch (\Exception $e) {
            Log::error('删除系统权限【error】：'.$e->getMessage());
            Db::rollback();
            return false;
        }
    }
}