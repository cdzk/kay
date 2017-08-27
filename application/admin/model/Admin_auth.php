<?php
/**
 * Created by PhpStorm.
 *
 * @Date: 2017-05-24
 * @Time: 15:39
 * @Author: cdkay
 * @Email: network@iyuanma.net
 *
 * @File： Auth.php
 */

namespace app\admin\model;

use library\Tree;
use think\Db;
use think\Loader;
use think\Model;
use think\Request;
use think\Session;

class Admin_auth extends Model {
    protected function initialize()
    {
        // 加载验证器
        $this->validate = Loader::validate('AdminAuth');

        parent::initialize();
    }

    /**
     * get_all_auth
     * 获取所有权限数据，并转换为数组
     *
     * @return array
     */
    public function get_all_auth()
    {
        $auth = $this->select();

        $data = array();
        foreach ($auth as $key=>$val)
        {
            $data[$key] = $val->toArray();
        }

        return $data;
    }

    /**
     * get_single_auth
     * 获取指定id的单条权限数据
     *
     * @param int $auth_id 权限id
     * @return array|false|\PDOStatement|string|Model
     */
    public function get_single_auth($auth_id)
    {
        return $this->where('auth_id', $auth_id)->find();
    }

    /**
     * save_auth
     * 保存权限数据到数据库 新增|更新
     *
     * @return $this|array|false|int|\think\response\Json
     */
    public function save_auth()
    {
        $form = input('post.');

        // 验证表单
        if(!$this->validate->check($form)) return array('status'=>-1, 'msg'=>$this->validate->getError(), 'result'=>'');

        $data = array(
            'auth_parentid' => $form['auth_parentid'],
            'auth_name' => $form['auth_name'],
            'auth_module' => $form['auth_module'],
            'auth_controller' => $form['auth_controller'],
            'auth_action' => $form['auth_action']
        );

        // 判断表单数据中是否有“主键ID”的元素存在，如果有则表示更新数据，没有则表示新增数据
        if (!array_key_exists('auth_id', $form)) {
            // 新增数据
            return $this->data($data)->save();
        } else {
            // 更新数据
            $auth_id = (int)$form['auth_id'];
            $isExist = $this->where('auth_id', $auth_id)->count();
            if ($isExist) {
                return $this->where('auth_id', $auth_id)->update($data);
            } else {
                return array('status'=>-1, 'msg'=>'数据错误，请重试', 'result'=>'');
            }
        }
    }

    /**
     * delete_auth
     * 删除权限
     *
     * @return int
     */
    public function delete_auth()
    {
        $auth_id = input('get.auth_id');

        $isExist = $this->where('auth_parentid', $auth_id)->count();

        if ($isExist) {
            return array('status'=>-1, 'msg'=>'抱歉，请先删除子权限', 'result'=>'');
        } else {
            return $this->destroy($auth_id);
        }
    }

    /**
     * check_auth
     * 对当前登录的管理用户进行管理权限验证
     *
     * @author zhengkai
     * @date 2017-08-27
     *
     * @return bool
     */
    public function check_auth()
    {
        // 从session获取当前登录的管理用户信息
        $getSessionUser = unserialize(Session::get('user', 'admin'));

        // 获取当前登录管理用户的角色的管理权限数据
        $user = Db::name('admin_user')
            ->alias('au')
            ->join('admin_role ar', 'au.user_roleid=ar.role_id', 'LEFT')
            ->where('au.user_id', $getSessionUser['user_id'])
            ->field('ar.role_auth')
            ->find();

        // 判断是否为超级管理员
        if ($user['role_auth'] === 'super') return true;

        /*** 获取权限数据 ***/
        $module = null; // 模块
        $this->where('auth_id', 'in', $user['role_auth']);
        $this->field('auth_id, auth_parentid, auth_module');
        $auth = $this->select();
        foreach ($auth as $m_key=>$m_val) {
            $module .= $m_val['auth_module'].',';
        }
        $module = array_unique(explode(',', rtrim($module, ',')));

        $controller = []; // 控制器
        foreach ($module as $c_key=>$c_val) {
            $am[$c_key] = $this->where('auth_id', 'in', $user['role_auth'])
                ->where('auth_module', $c_val)
                ->field('auth_id, auth_parentid, auth_controller')
                ->select();
            $ac[$c_key] = null;
            foreach ($am[$c_key] as $ac_key=>$ac_val){
                $ac[$c_key] .= $ac_val['auth_controller'].',';
            }
            $ac[$c_key] = array_unique(explode(',', rtrim($ac[$c_key], ',')));
            $controller[$c_val] = $ac[$c_key];
        }

        $action = []; // 方法
        foreach ($controller as $a_key=>$a_val) {
            foreach ($a_val as $a2_key=>$a2_val) {
                $ac[$a2_key] = $this->where('auth_id', 'in', $user['role_auth'])
                    ->where('auth_module', $a_key)
                    ->where('auth_controller', $a2_val)
                    ->field('auth_id, auth_parentid, auth_action')
                    ->select();

                $aa[$a2_key] = null;
                foreach ($ac[$a2_key] as $ac_key=>$ac_val){
                    $aa[$a2_key] .= $ac_val['auth_action'].',';
                }
                $aa[$a2_key] = rtrim($aa[$a2_key], ',');
                $action[$a_key][$a2_val] = $aa[$a2_key];
            }
        }

        // 最终拼接权限数据
        $arr = $action;
        /*** 获取权限数据 end ***/

        // 获取当前模块、控制器、方法名
        $request = Request::instance();
        $currModule = $request->module();
        $currController = $request->controller();
        $currAction = $request->action();

        // 对 admin 模块下的 Index 控制器不进行权限控制
        if ($currModule==='admin' && $currController==='Index') return true;

        if (array_key_exists($currModule, $arr)) { // 判断是否有模块访问权限
            if (array_key_exists($currController, $arr[$currModule])) { // 判断是否有控制器访问权限
                if (preg_match('#'.$currAction.'#', $arr[$currModule][$currController])) { // 判断是否有方法访问权限
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
}