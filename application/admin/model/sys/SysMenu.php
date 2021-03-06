<?php
/**
 * Created by PhpStorm.
 *
 * @Date: 2018-03-19
 * @Time: 21:44
 * @Author: cdkay
 * @Email: network@iyuanma.net
 *
 * @File： SysMenu.php
 */
namespace app\admin\model\sys;

use library\Tree;
use think\Db;
use think\Log;
use think\Model;

class SysMenu extends Model {
    protected $pk = 'menu_id';

    /**
     * getInMenu
     * 获取全部或指定范围的菜单数据
     *
     * @param $menuId
     * @return false|static[]
     */
    public static function getInMenu($menuId)
    {
        $data = self::all(function ($query) use ($menuId) {
            if ($menuId==='all') {
                $query->where('menu_status', 1)
                    ->order('menu_sort desc, menu_id asc');
            } else {
                $query->where('menu_id', 'in', $menuId)
                    ->where('menu_status', 1)
                    ->order('menu_sort asc');
            }
        });

        return $data;
    }

    /**
     * getAllMenu
     * 获取全部菜单数据
     *
     * @return false|static[]
     */
    public static function getAllMenu()
    {
        $data = self::all(function ($query) {
            $query->order('menu_sort desc, menu_id asc');
        });

        return $data;
    }

    /**
     * treeMenu
     * 生成树状菜单数据
     *
     * @return array
     */
    public static function treeMenu()
    {
        $data = self::getAllMenu();

        $result = Tree::makeTreeForHtml($data, array(
            'primary_key' => 'menu_id',
            'parent_key' => 'menu_parentid',
        ));

        return $result;
    }

    /**
     * getSingleMenu
     * 获取单条菜单数据
     *
     * @param $menuId
     * @return null|static
     */
    public static function getSingleMenu($menuId)
    {
        $data = self::get($menuId);

        return $data;
    }

    /**
     * createMenu
     * 新增菜单数据
     *
     * @param array $inputData
     * @return bool
     */
    public static function createMenu($inputData=[])
    {
        Db::startTrans();
        try {
            self::create($inputData);
            Db::commit();
            return true;
        } catch (\Exception $e) {
            Log::error('新增系统菜单【error】：'.$e->getMessage());
            Db::rollback();
            return false;
        }
    }

    /**
     * updateMenu
     * 更新菜单数据
     *
     * @param $menuId
     * @param array $inputData
     * @return bool
     */
    public static function updateMenu($menuId, $inputData=[])
    {
        Db::startTrans();
        try {
            self::where('menu_id', $menuId)->update($inputData);
            Db::commit();
            return true;
        } catch (\Exception $e) {
            Log::error('更新系统菜单【error】：'.$e->getMessage());
            Db::rollback();
            return false;
        }
    }

    /**
     * sortMenu
     * 批量更新菜单排序
     *
     * @param array $inputData
     * @return bool
     */
    public static function updateMenuSort($inputData=[])
    {
        Db::startTrans();
        try {
            foreach ($inputData as $key=>$val) {
                self::where('menu_id', $key)->update(['menu_sort'=>$val]);
            }
            Db::commit();
            return true;
        } catch (\Exception $e) {
            Log::error('更新系统菜单排序【error】：'.$e->getMessage());
            Db::rollback();
            return false;
        }
    }

    /**
     * updateMenuStatus
     * 更新菜单状态
     *
     * @param $menuId
     * @param $status
     * @return bool
     */
    public static function updateMenuStatus($menuId, $status)
    {
        Db::startTrans();
        try {
            self::where('menu_id', $menuId)->update(['menu_status'=>$status]);
            Db::commit();
            return true;
        } catch (\Exception $e) {
            Log::error('更新系统菜单状态【error】：'.$e->getMessage());
            Db::rollback();
            return false;
        }
    }

    /**
     * subMenuCount
     * 子菜单统计
     *
     * @param $menuId
     * @return int|string
     */
    public static function subMenuCount($menuId)
    {
        $data = self::where('menu_parentid', $menuId)->count();

        return $data;
    }

    /**
     * deleteMenu
     * 删除菜单数据
     *
     * @param $menuId
     * @return bool
     */
    public static function deleteMenu($menuId)
    {
        Db::startTrans();
        try {
            self::destroy($menuId);
            Db::commit();
            return true;
        } catch (\Exception $e) {
            Log::error('删除系统菜单【error】：'.$e->getMessage());
            Db::rollback();
            return false;
        }
    }
}