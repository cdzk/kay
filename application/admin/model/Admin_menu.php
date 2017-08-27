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
use think\Db;
use think\Model;
use think\Session;
use think\Validate;

class Admin_menu extends Model {

    protected $validate;

    protected function initialize()
    {
        // 加载验证器
        $rule =   [
            ['menu_parentid', 'require|token:__hash__', '上级菜单不能为空'],
            ['menu_name', 'require', '菜单名称不能为空'],
            ['menu_module', '[a-z]+$', '模块名只允许小写英文字母'],
            ['menu_controller', '^[A-Z][A-Za-z]+$', '控制器名只允许为英文字母，且首字母必须为大写'],
            ['menu_action', '[a-zA-Z_]+$', '方法名只允许为英文字母与下划线'],
        ];

        $this->validate = new Validate($rule);

        parent::initialize();
    }

    /**
     * get_menu
     * 获取全部管理菜单数据
     *
     * @return array
     */
    public function get_menu()
    {
        $this->order('menu_sort desc, menu_id asc');
        $menu = $this->select();

        $data = array();
        foreach ($menu as $key=>$val)
        {
            $data[$key] = $val->toArray(); // toArray() 对象转为数组
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
        if(!$this->validate->check($form)) return array('status'=>-1, 'msg'=>$this->validate->getError(), 'result'=>'');

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

    /**
     * get_admin_menu
     * [根据父级id]获取管理菜单数据
     * 并根据当前登录的管理用户角色查询菜单数据
     *
     * @param int $parent_id 管理菜单父级id
     * @return array
     */
    public function get_admin_menu($parent_id=null)
    {
        // 从session获取当前登录的管理用户信息
        $getSessionUser = unserialize(Session::get('user', 'admin'));

        // 获取当前登录管理用户的角色的菜单权限数据
        $user = Db::name('admin_user')
            ->alias('au')
            ->join('admin_role ar', 'au.user_roleid=ar.role_id', 'LEFT')
            ->where('au.user_id', $getSessionUser['user_id'])
            ->field('ar.role_menu')
            ->find();

        // 查询获取管理菜单灵气
        if ($user['role_menu'] !== 'all') $this->where('menu_id', 'in', $user['role_menu']);
        if (isset($parent_id)) $this->where('menu_parentid', $parent_id);
        $this->where('menu_status', 1);
        $this->order('menu_sort desc, menu_id asc');
        $menu = $this->select();

        $data = array();
        foreach ($menu as $key=>$val)
        {
            $data[$key] = $val->toArray(); // toArray() 对象转为数组
        }

        return $data;
    }
}