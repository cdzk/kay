<?php
/**
 * Created by PhpStorm.
 *
 * @Date: 2017-05-19
 * @Time: 16:17
 * @Author: cdkay
 * @Email: network@iyuanma.net
 *
 * @File： Menu.php
 */

namespace app\admin\model;
use think\Config;
use think\Loader;
use think\Model;

class AdminMenu extends Model {

    protected function initialize()
    {
        // 指定表名
        $this->table = Config::get('database.prefix').'admin_menu';

        // 加载验证器
        $this->validate = Loader::validate('Admin_menu');

        parent::initialize();
    }

    /**
     * get_menu
     * [根据父级id]获取管理菜单数据
     *
     * @param int $parent_id 管理菜单父级id
     * @param int $status 菜单状态 默认为全部，1=显示，0=不显示
     * @return array
     */
    public function get_menu($parent_id=null, $status=null)
    {
        if (isset($parent_id)) $this->where('menu_parentid', $parent_id);
        if (isset($status)) $this->where('menu_status', $status);
        $this->order('menu_sort desc, menu_id asc');
        $menu = $this->select();
        $data = array();
        foreach ($menu as $key=>$val)
        {
            $data[$key] = $val->toArray();
        }

        return $data;
    }

    /**
     * get_single_menu
     * 获取指定id的单条菜单数据
     *
     * @param int $menu_id 菜单id
     * @return array|false|\PDOStatement|string|Model
     */
    public function get_single_menu($menu_id)
    {
        return $this->where('menu_id', $menu_id)->find();
    }

    /**
     * save_menu
     * 保存菜单数据到数据库 新增|更新
     *
     * @return $this|array|false|int|\think\response\Json
     */
    public function save_menu()
    {
        $form = input('post.');

        // 验证表单
        if(!$this->validate->check($form)) return array('status'=>-1, 'msg'=>'数据错误，请重试', 'result'=>''); // $this->validate->getError();

        $data = array(
            'menu_parentid' => $form['menu_parentid'],
            'menu_name' => $form['menu_name'],
            'menu_module' => $form['menu_module'],
            'menu_controller' => $form['menu_controller'],
            'menu_action' => $form['menu_action'],
            'menu_status' => $form['menu_status']
        );

        // 判断表单数据中是否有“主键ID”的元素存在，如果有则表示更新数据，没有则表示新增数据
        if (!array_key_exists('menu_id', $form)) {
            // 新增数据
            return $this->data($data)->save();
        } else {
            // 更新数据
            $menu_id = (int)$form['menu_id'];
            $isExist = $this->where('menu_id', $menu_id)->count();
            if ($isExist) {
                return $this->where('menu_id', $menu_id)->update($data);
            } else {
                return array('status'=>-1, 'msg'=>'数据错误，请重试', 'result'=>'');
            }
        }
    }


    /**
     * sort_menu
     * 更新菜单排序
     *
     * @return bool
     */
    public function sort_menu()
    {
        $form = input('post.');

        // $data = array();
        foreach ($form['menu_sort'] as $key=>$val) {
            // $data[] = array('menu_id'=>$key, 'menu_sort'=>$val);
            $this->where('menu_id', $key)->update(array('menu_sort'=>$val));
        }

        /*foreach($data as $val){
            $this->data($val,true)->isUpdate(true)->save();
        }*/

        return true;
    }

    /**
     * delete_menu
     * 删除菜单
     *
     * @return int
     */
    public function delete_menu()
    {
        $menu_id = input('get.menu_id');

        $isExist = $this->where('menu_parentid', $menu_id)->count();

        if ($isExist) {
            return array('status'=>-1, 'msg'=>'抱歉，请先删除子菜单', 'result'=>'');
        } else {
            return $this->destroy($menu_id);
        }
    }

    /**
     * status_menu
     * 更新菜单状态
     *
     * @return $this
     */
    public function status_menu()
    {
        $menu_id = input('post.menu_id');
        $menu_status = input('post.menu_status');

        return $this->where('menu_id', $menu_id)->update(array('menu_status'=>$menu_status));
    }
}